<?php
/**
 * WBCE CMS — htmx endpoint: Group form fragment
 *
 * GET:  ?action=add / ?group_id={IDKEY} → load form
 * POST: save → return updated form + HX-Trigger for table row update
 *
 * @since 1.7.0
 */

require '../../config.php';
require ADMIN_PATH . '/access/functions.php';
Lang::loadLanguage(__DIR__);

// Non-htmx fallback
if (!MessageBox::isHtmx()) {
    $redirect = ADMIN_URL . '/groups/';
    if (isset($_GET['group_id'])) {
        $redirect .= 'index.php?group_id=' . urlencode($_GET['group_id']) . '&modify=1';
    }
    header('Location: ' . $redirect);
    exit;
}

$groups   = new GroupManager();
$perms    = new PermissionManager();
$alerts  = new Alerts(useSession: false);
$wasAdded = false;
$groupId  = 0;
$isNew    = false;
$hasError = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // =================================================================
    //  POST: Save
    // =================================================================
    $groupId = intval($_POST['group_id'] ?? 0);
    $isNew   = ($groupId === 0);

    $admin = new Admin('Access', $isNew ? 'groups_add' : 'groups_modify', false);

    if (!$admin->checkFTAN()) {
        $alerts->error($MESSAGE['GENERIC_SECURITY_ACCESS']);
        echo $alerts->renderFragment();
        exit;
    }

    if (!$isNew && ($groupId < 2 || !$groups->mayManageGroup($admin, $groupId))) {
        $alerts->error($MESSAGE['GENERIC_SECURITY_ACCESS']);
        echo $alerts->renderFragment();
        exit;
    }

    // Validate name
    $name = trim(strip_tags($admin->get_post('group_name') ?? ''));
    if ($name === '') {
        $alerts->error($MESSAGE['GROUPS_GROUP_NAME_BLANK']);
        $hasError = true;
    } elseif ($groups->isNameTaken($name, $groupId)) {
        $alerts->error($MESSAGE['GROUPS_GROUP_NAME_EXISTS']);
        $hasError = true;
    }

    if (!$hasError) {
        $data = [
            'name'           => $name,
            'description'    => strip_tags($admin->get_post('description') ?? ''),
            'default_module' => trim($admin->get_post('default_module') ?? ''),
            ...$perms->parseFromPost($admin),
        ];

        // A non-admin grants only what he has himself; the form greys out
        // the rest, the request must not add it either.
        if (!$groups->mayStoreRights($admin, $data)) {
            http_response_code(422);
            $alerts->error($MESSAGE['GENERIC_SECURITY_ACCESS']);
            echo $alerts->renderFragment();
            exit;
        }

        if ($isNew) {
            $groupId = $groups->createGroup($data);
            if ($groupId > 0) {
                $wasAdded = true;
            }
        } else {
            $groups->updateGroup($groupId, $data);
        }

        if ($database->hasError()) {
            $alerts->error($database->getError());
            $hasError = true;
        }
    }

    // HX-Trigger for table row update FIRST, then toast merges
    if ($groupId > 0 && !$hasError) {
        $newIDKEY = $admin->getIDKEY($groupId, 'group');
        if ($wasAdded) {
            header('HX-Trigger: {"groupAdded": {"idkey": "' . $newIDKEY . '", "groupId": ' . $groupId . '}}');
        } else {
            header('HX-Trigger: {"groupSaved": {"idkey": "' . $newIDKEY . '", "groupId": ' . $groupId . '}}');
        }

        $label = $wasAdded ? '{MESSAGE:GROUPS_ADDED}' : '{MESSAGE:GROUPS_SAVED}';
        $alerts->toast($label, 'success');
    }

    // After add: switch to edit mode
    if ($wasAdded) {
        $isNew = false;
    }

} else {
    // =================================================================
    //  GET: Load form
    // =================================================================
    $isNew = (($_GET['action'] ?? '') === 'add');

    if ($isNew) {
        $admin = new Admin('Access', 'groups_add', false);
    } else {
        $admin   = new Admin('Access', 'groups_modify', false);
        $groupId = intval($admin->checkIDKEY('group_id', 0, 'GET', true, 'group'));

        if ($groupId < 2 || !$groups->mayManageGroup($admin, $groupId)) {
            $alerts->error($MESSAGE['GENERIC_SECURITY_ACCESS']);
            echo $alerts->renderFragment();
            exit;
        }
    }
}


// =====================================================================
//  Render form
// =====================================================================
// rights outside the editor's own are shown greyed out (rights ceiling)
$ceiling = $perms->ceilingOf($admin);

$toTwig = [
    'MESSAGE_BOX'  => $alerts->renderFragment(),
    'group_id'     => $groupId,
    'GROUP_NAME'     => ($groupId > 0) ? $groups->getGroupName($groupId)                             : '',
    'GROUP_DESC'     => ($groupId > 0) ? $groups->getGroupDescription($groupId)                      : '',
    'default_module' => ($groupId > 0) ? ($groups->getGroup($groupId)['default_module'] ?? '')       : '',
    'access_perms' => $perms->getStructure($groupId, $ceiling),
    'addon_list'   => [
        'page'     => $perms->getAddonList('page',     $groupId, $ceiling),
        'tool'     => $perms->getAddonList('tool',     $groupId, $ceiling),
        'setting'  => $perms->getAddonList('setting',  $groupId, $ceiling),
        'template' => $perms->getAddonList('template', $groupId, $ceiling),
        'theme'    => $perms->getAddonList('theme',    $groupId, $ceiling),
    ],
];

$admin->getThemeFile('access_groups_form.twig', $toTwig);
