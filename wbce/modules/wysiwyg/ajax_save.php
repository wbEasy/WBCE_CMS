<?php
/**
 * wysiwyg — AJAX save endpoint
 *
 * Receives the section content from the AjaxSave form submission in modify.php
 * and writes it to {TP}mod_wysiwyg without a page reload.
 *
 * Security: IDKEY (session-backed, non-consuming so repeated saves work),
 * redeemed with a purpose, then full authorization of the target section.
 *   - 'section' key (modify.php: getIDKEY($section_id, 'section')): the
 *     section comes from the key's value alone.
 *   - 'page' key (a page-scoped key, value = page ID): the section comes from
 *     the POST and must live on that page.
 * The purpose keeps the two apart: a page key is never read as a section ID,
 * and a key issued for anything else is refused. section_id/page_id in the
 * POST body are never trusted on their own; the page always comes from the
 * section row.
 */

require '../../config.php';

$admin = new Admin('pages', 'pages_modify', false);

header('Content-Type: application/json; charset=utf-8');

// ── IDKEY validation ──────────────────────────────────────────────────────────
$keyPageId  = 0;
$section_id = (int) $admin->checkIDKEY('idKey', 0, 'POST', true, 'section');
if ($section_id <= 0) {
    $keyPageId  = (int) $admin->checkIDKEY('idKey', 0, 'POST', true, 'page');
    $section_id = $keyPageId > 0 ? (int) ($_POST['section_id'] ?? 0) : 0;
}
if ($section_id <= 0) {
    http_response_code(403);
    exit(json_encode(['ok' => false, 'error' => 'Invalid or expired key']));
}
// The form posts its section_id and content{section_id} as well; if either
// disagrees with the key's section, refuse instead of writing an empty
// content{section_id} over that section.
$postedSectionId = (int) ($_POST['section_id'] ?? $section_id);
if ($postedSectionId !== $section_id || !isset($_POST['content' . $section_id])) {
    http_response_code(400);
    exit(json_encode(['ok' => false, 'error' => 'Section mismatch or missing content']));
}

// ── Authorization ─────────────────────────────────────────────────────────────
$section = $database->fetchRow(
    'SELECT `page_id`, `module` FROM `{TP}sections` WHERE `section_id` = ?',
    [$section_id]
);
if (!$section
    || $section['module'] !== 'wysiwyg'
    || ($keyPageId > 0 && (int) $section['page_id'] !== $keyPageId)
    || !$admin->get_permission('wysiwyg', 'module')
    || !$admin->get_page_permission((int) $section['page_id'], 'admin')) {
    http_response_code(403);
    exit(json_encode(['ok' => false, 'error' => 'Insufficient permissions']));
}
$page_id = (int) $section['page_id'];

// ── Content processing (identical to save.php) ────────────────────────────────
$sMediaUrl = WB_URL . MEDIA_DIRECTORY;
$content   = (string) $_POST['content' . $section_id];

// Replace absolute media URLs with portable placeholder
$content = preg_replace(
    '@(<[^>]*=\s*")(' . preg_quote($sMediaUrl, '@') . ')([^">]*".*>)@siU',
    '$1{SYSVAR:MEDIA_REL}$3',
    $content
);

$database->upsertRow('{TP}mod_wysiwyg', 'section_id', [
    'section_id' => $section_id,
    'page_id'    => $page_id,
    'content'    => $content,
    'text'       => strip_tags($content),
]);

if ($database->hasError()) {
    http_response_code(500);
    (new Alerts(false))->toast($database->getError(), 'error');
    exit(json_encode(['ok' => false, 'error' => $database->getError()]));
}

// Version history (tinymce_wbce): record a version on this REAL save.
// Decoupled — no-op if the tinymce_wbce module is not installed.
if (file_exists(WB_PATH . '/modules/tinymce_wbce/history.php')) {
    require_once WB_PATH . '/modules/tinymce_wbce/history.php';
    tinymce_wbce_history_snapshot_section($section_id, $content, $admin, 'wysiwyg');
}

// ── Touch timestamps ──────────────────────────────────────────────────────────
$admin->touchSection($section_id);
// ── Toast via HX-Trigger header (read by ajax_save.js, works without HTMX) ───
(new Alerts(false))->toast('MESSAGE:CHANGES_SAVE_SUCCESS', 'success');

exit(json_encode(['ok' => true]));
