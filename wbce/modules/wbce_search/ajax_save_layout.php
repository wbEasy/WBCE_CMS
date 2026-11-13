<?php
/**
 * wbce_search — AJAX save endpoint for the layout editor
 *
 * Receives the HTT template content from the CodeEditorToolbar AJAX save
 * (Ctrl+S or the Save button while "AjaxSave" is ticked) and writes it to
 * the layout's own copy (POST layout = search | tagcloud → <x>_custom.htt),
 * activating it. The writing itself is WbceSearchLayouts::writeCustom() —
 * the same code the plain form POST (AjaxSave off) runs.
 *
 * Security: IDKEY (session-backed, non-consuming for repeated saves).
 */

require '../../config.php';

$admin = new Admin('admintools', 'admintools', false);

header('Content-Type: application/json; charset=utf-8');

// Module wording (SEARCH:…) — the AdminTools runner, which normally loads it, is not involved here.
Lang::loadLanguage(__DIR__);

// ── Permission check ─────────────────────────────────────────────────────────
if (!$admin->hasToolPermission('wbce_search')) {
    http_response_code(403);
    (new Alerts(false))->toast('MESSAGE:GENERIC_SECURITY_ACCESS', 'error');
    exit(json_encode(['ok' => false, 'error' => 'Permission denied']));
}

// ── IDKEY validation ($ajax = true → key survives repeated saves) ─────────────
$key = $admin->checkIDKEY('idKey', false, 'POST', true);
if ($key === false) {
    http_response_code(403);
    (new Alerts(false))->toast('MESSAGE:GENERIC_SECURITY_ACCESS', 'error');
    exit(json_encode(['ok' => false, 'error' => 'Invalid or expired key']));
}

// ── Write + activate ─────────────────────────────────────────────────────────
$layout = (string) ($_POST['layout'] ?? '');
try {
    if (!WbceSearchLayouts::isTarget($layout)) {
        throw new RuntimeException(L_('SEARCH:MSG_SECURITY_ERROR'));
    }
    WbceSearchLayouts::writeCustom($layout, (string) ($_POST['code_area_text'] ?? ''));
} catch (RuntimeException $e) {
    http_response_code(500);
    (new Alerts(false))->toast($e->getMessage(), 'error');
    exit(json_encode(['ok' => false, 'error' => $e->getMessage()]));
}

(new Alerts(false))->toast('MESSAGE:CHANGES_SAVE_SUCCESS', 'success');
exit(json_encode(['ok' => true, 'file' => WbceSearchLayouts::customName($layout)]));
