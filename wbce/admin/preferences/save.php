<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

/**
 * Save "My data" — fetch endpoint, answers JSON only:
 *   {ok: bool, message: string, errors: {field: message}, reload: bool}
 *
 * reload: the language changed — the backend has to be drawn anew in it.
 *
 * @since 1.7.0
 */

require '../../config.php';
require_once __DIR__ . '/PreferencesForm.php';

$admin = new Admin('Preferences', 'start', false);

/** @param array<string, string> $errors */
function preferencesResponse(bool $ok, string $message, array $errors = [], bool $reload = false): never
{
    http_response_code($ok ? 200 : 422);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => $ok, 'message' => $message, 'errors' => (object) $errors, 'reload' => $reload]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || $admin->checkIDKEY('preferences_token', '', 'POST', true, 'preferences') !== 'preferences') {
    // a POST with an unknown key: the page outlived its token
    if ($_SERVER['REQUEST_METHOD'] === 'POST') BackendAjax::denyIfAjax(BackendAjax::TOKEN_EXPIRED);
    preferencesResponse(false, L_('MESSAGE:GENERIC_SECURITY_ACCESS'));
}

// accounts without the right "Preferences → Modify" are managed by the administrator
if (!$admin->mayEditOwnData()) {
    preferencesResponse(false, L_('MESSAGE:PREFERENCES_LOCKED'));
}

$form   = new PreferencesForm($admin);
$before = $form->values();
$result = $form->validate($_POST);

if ($result['errors'] !== []) {
    preferencesResponse(false, L_('MESSAGE:SETTINGS_INVALID_VALUE'), $result['errors']);
}

$error = $form->save($result['values']);
if ($error !== null) {
    preferencesResponse(false, $error);
}

$reload = isset($result['values']['language']) && $result['values']['language'] !== $before['language'];
preferencesResponse(
    true,
    L_($result['password_changed'] ? 'MESSAGE:PREFERENCES_PASSWORD_CHANGED' : 'MESSAGE:PREFERENCES_DETAILS_SAVED'),
    [],
    $reload
);
