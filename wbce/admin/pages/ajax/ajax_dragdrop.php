<?php
/**
 * WBCE CMS — Pages: AJAX Drag & Drop order update
 *
 * Receives the new page order from jQuery UI sortable
 * and writes positions back to the database via PDO.
 *
 * The request must carry the IDKEY jsadmin issues for this purpose (read in
 * peek mode, so one key serves every drop on the page), every page in the
 * list must be one the user may administrate, and all of them must be
 * siblings — the list is one level of the page tree, nothing else.
 */

require '../../../config.php';
if (!defined('WB_PATH')) exit();

if (!isset($_POST['action'])) {
    header('Location: ../../../index.php');
    exit();
}

$response = ['success' => false, 'message' => '', 'icon' => ''];

$admin = new Admin('Pages', 'pages', false, false);

if (!$admin->is_authenticated()
    || !$admin->get_permission('admintools')
    || !$admin->get_permission('pages')) {
    $response['message'] = 'Insufficient privileges';
    $response['icon']    = 'failure.gif';
    header('Content-Type: application/json');
    exit(json_encode($response));
}

if ($_POST['action'] === 'updateArray') {
    $pageIDs = array_map('intval', isset($_POST['pageID']) ? (array)$_POST['pageID'] : []);

    $refuse = function (string $message) use (&$response): never {
        $response['message'] = $message;
        $response['icon']    = 'failure.gif';
        header('Content-Type: application/json');
        exit(json_encode($response));
    };

    if ($admin->checkIDKEY('idkey', false, 'POST', true) !== 'jsadmin_dragdrop') {
        $refuse($MESSAGE['GENERIC_SECURITY_ACCESS'] ?? 'Security offense');
    }
    if ($pageIDs === [] || min($pageIDs) < 1 || count(array_unique($pageIDs)) !== count($pageIDs)) {
        $refuse('Invalid parameters');
    }

    $placeholders = implode(',', array_fill(0, count($pageIDs), '?'));
    $rows = $database->fetchAll(
        "SELECT `page_id`, `parent`, `admin_groups`, `admin_users`
           FROM `{TP}pages` WHERE `page_id` IN ($placeholders)",
        $pageIDs
    );
    if (count($rows) !== count($pageIDs) || count(array_unique(array_column($rows, 'parent'))) !== 1) {
        $refuse('Invalid parameters');
    }
    foreach ($rows as $row) {
        if (!$admin->isAdmin() && !$admin->get_page_permission($row, 'admin')) {
            $refuse('Insufficient privileges');
        }
    }

    $position = 1;
    foreach ($pageIDs as $pageID) {
        $database->query(
            'UPDATE `{TP}pages` SET `position` = ? WHERE `page_id` = ?',
            [$position, $pageID]
        );

        if ($database->hasError()) {
            $response['message'] = 'DB error: ' . $database->getError();
            $response['icon']    = 'failure.gif';
            header('Content-Type: application/json');
            exit(json_encode($response));
        }

        $position++;
    }

    $response['success'] = true;
    $response['message'] = $MESSAGE['RECORD_MODIFIED_SAVED'] ?? 'Saved';
    $response['icon']    = 'success.gif';
}

header('Content-Type: application/json');
exit(json_encode($response));
