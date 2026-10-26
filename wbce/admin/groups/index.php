<?php
/**
 * WBCE CMS — Groups management (overview, modify, delete, duplicate)
 *
 * Slim bootstrap: renders access_groups.twig.
 * CRUD operations handled by form.php (add/edit) and action.php (delete/getrow).
 *
 * @copyright WBCE Project (2015-)
 * @license   GNU GPL2 (or any later version)
 */

require '../../config.php';
require ADMIN_PATH . '/access/functions.php';
Lang::loadLanguage(__DIR__);

I::loadPlugin('include/wbeSelect');

$alerts = new Alerts();
$groups = new GroupManager();
$perms  = new PermissionManager();
$sPos   = 'groups';

// --- Determine action ---
$action  = 'overview';
$groupId = 0;

if (isset($_GET['delete']))    $action = 'delete';
elseif (isset($_GET['duplicate'])) $action = 'duplicate';

switch ($action) {

    case 'delete':
        $admin   = new Admin('Access', 'groups_delete', false);
        $groupId = intval($admin->checkIDKEY('group_id', 0, $_SERVER['REQUEST_METHOD'], false, 'group'));

        if ($groupId > 1 && $groups->mayManageGroup($admin, $groupId)) {
            if ($groups->hasMembers($groupId)) {
                $alerts->error($MESSAGE['GROUP_HAS_MEMBERS'] ?? 'Group has members');
            } elseif ($groups->deleteGroup($groupId)) {
                $alerts->sessionToast('{MESSAGE:GROUPS_DELETED}', 'success');
                header('Location: ' . ADMIN_URL . '/groups/');
                exit;
            } else {
                $alerts->error($database->getError());
            }
        }
        break;

    case 'duplicate':
        $admin   = new Admin('Access', 'groups_add', false);
        $groupId = intval($admin->checkIDKEY('group_id', 0, $_SERVER['REQUEST_METHOD'], true, 'group'));
        // A copy carries all permissions of its source: a non-admin may only
        // copy groups within his own rights — never the administrators group
        // (it used to accept any key whose value was 1), nor e.g. a webmaster
        // group that may install modules.
        $newId   = ($groupId > 0 && $groups->mayManageGroup($admin, $groupId))
            ? $groups->duplicateGroup($groupId)
            : 0;

        if ($newId > 0) {
            $alerts->sessionToast('{TEXT:DUPLICATED}', 'success');
            header('Location: ' . ADMIN_URL . '/groups/?duplicated=' . $newId);
        } else {
            $alerts->error($database->getError());
            header('Location: ' . ADMIN_URL . '/groups/');
        }
        exit;

    default:
        $admin = new Admin('Access', $sPos);
}

// --- Build group list ---
// the administrators group only for administrators: non-admins get no key for it
$allGroups = $groups->getAllGroups(true, $admin->isAdmin());
// actions only where the rights ceiling allows them (the endpoints check again)
foreach ($allGroups as &$rec) {
    $rec['manageable'] = $groups->mayManageGroup($admin, (int) $rec['group_id']);
}
unset($rec);

// --- Render ---
$toTwig = [
    'MESSAGE_BOX'      => $alerts->render(),
    'TABS'             => renderAddonsTabs($sPos),
    'groups'           => $allGroups,
    'GROUP_ID'         => (isset($_GET['group_id']) && isset($_GET['modify'])) ? intval($admin->checkIDKEY('group_id', 0, 'GET', true, 'group')) : 0,
];

if (isset($_GET['duplicated'])) {
    $toTwig['duplicated'] = (int) $_GET['duplicated'];
}

$admin->getThemeFile('access_groups.twig', $toTwig);
$admin->print_footer();
