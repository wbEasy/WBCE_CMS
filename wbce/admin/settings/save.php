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
 * Save the settings — fetch endpoint, answers JSON only:
 *   {ok: bool, message: string, errors: {field: message}, reload: bool}
 *
 * What may be saved, and how, is decided by SettingsForm alone: a field the
 * user is not shown is a field the user cannot save.
 *
 * reload: the change affects the open page itself — a new session cookie
 * name (app_name) ends the current session, a new backend theme only shows
 * after a reload — so settings.js reloads instead of staying on a page that
 * no longer fits.
 *
 * @since 1.7.0
 */

/** Settings whose change makes the open page stale. */
const SETTINGS_RELOAD_ON_CHANGE = ['app_name', 'default_theme'];

require '../../config.php';
require_once __DIR__ . '/SettingsForm.php';

$admin = new Admin('Settings', 'settings_basic', false);

/** @param array<string, string> $errors */
function settingsResponse(bool $ok, string $message, array $errors = [], bool $reload = false): never
{
    http_response_code($ok ? 200 : 422);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => $ok, 'message' => $message, 'errors' => (object) $errors, 'reload' => $reload]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || $admin->checkIDKEY('settings_token', '', 'POST', true, 'settings') !== 'settings') {
    // a POST with an unknown key: the page outlived its token
    if ($_SERVER['REQUEST_METHOD'] === 'POST') BackendAjax::denyIfAjax(BackendAjax::TOKEN_EXPIRED);
    settingsResponse(false, L_('MESSAGE:GENERIC_SECURITY_ACCESS'));
}

$form   = new SettingsForm(require __DIR__ . '/settings_registry.php', $admin);
$result = $form->validate($_POST);

if ($result['errors'] !== []) {
    settingsResponse(false, L_('MESSAGE:SETTINGS_INVALID_VALUE'), $result['errors']);
}

// compared before saving — afterwards the stored value is the new one
$reload = false;
foreach (SETTINGS_RELOAD_ON_CHANGE as $name) {
    if (isset($result['values'][$name]) && $result['values'][$name] !== (string) Settings::get($name, '')) {
        $reload = true;
    }
}

$error = $form->save($result['values']);
if ($error !== null) {
    settingsResponse(false, $error);
}

settingsResponse(true, L_('MESSAGE:SETTINGS_SAVED'), [], $reload);
