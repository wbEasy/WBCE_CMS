<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

require('../../config.php');

// Determine what is being moved (page or section)
if (isset($_GET['page_id']) and is_numeric($_GET['page_id'])) {
    if (isset($_GET['section_id']) and is_numeric($_GET['section_id'])) {
        $page_id      = $_GET['page_id'];
        $id           = $_GET['section_id'];
        $id_field     = 'section_id';
        $common_field = 'page_id';
        $table        = TABLE_PREFIX . 'sections';
    } else {
        $id           = $_GET['page_id'];
        $id_field     = 'page_id';
        $common_field = 'parent';
        $table        = TABLE_PREFIX . 'pages';
    }
} else {
    header("Location: index.php");
    exit(0);
}

$admin  = new Admin('Pages', 'pages_settings', false);
$alerts = new Alerts();

// CSRF: the arrows carry Wbce::pagesMoveKey(); a link without it (e.g. from
// a foreign site, which the browser sends with the admin's session) is refused
if ($admin->checkIDKEY('movekey', false, 'GET', true, 'pages_move') !== 'pages_move') {
    $admin->print_header();
    $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS'], ADMIN_URL . '/pages/index.php');
}

// pages_settings is only the general right. The user must also be allowed
// to administrate this very page, and a section must belong to it —
// otherwise page_id=A&section_id=<section of B> reorders page B's sections.
$iCheckPageId = (int) ($id_field == 'page_id' ? $id : $page_id);
$bAllowed     = $admin->isAdmin() || $admin->get_page_permission($iCheckPageId, 'admin');
if ($bAllowed && $id_field == 'section_id') {
    $bAllowed = (int) $database->fetchValue(
        "SELECT `page_id` FROM `{TP}sections` WHERE `section_id` = ?", [(int) $id]
    ) === $iCheckPageId;
}
if (!$bAllowed) {
    $admin->print_header();
    $admin->print_error($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS'], ADMIN_URL . '/pages/index.php');
}
$order  = new Order($table, 'position', $id_field, $common_field);

if ($id_field == 'page_id') {
    $backUrl = ADMIN_URL . '/pages/index.php';
    if ($order->move_down($id)) {
        $alerts->sessionToast($MESSAGE['PAGES_REORDERED'], 'success');
        header('Location: ' . $backUrl);
        exit;
    } else {
        $admin->print_header();
        $admin->print_error($MESSAGE['PAGES_CANNOT_REORDER'], $backUrl);
    }
} else {
    $backUrl = ADMIN_URL . '/pages/sections.php?page_id=' . $page_id;
    if ($order->move_down($id)) {
        $alerts->sessionToast($TEXT['SUCCESS'], 'success');
        header('Location: ' . $backUrl);
        exit;
    } else {
        $admin->print_header();
        $admin->print_error($TEXT['ERROR'], $backUrl);
    }
}
