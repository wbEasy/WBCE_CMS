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
 * Send a test mail to the stored server address — fetch endpoint, answers
 * JSON {ok, message}. Uses the STORED mail settings; settings.js saves
 * pending changes first.
 *
 * @since 1.7.0
 */

require '../../config.php';

$admin = new Admin('Settings', 'settings_basic', false);

$ok = false;
if ($_SERVER['REQUEST_METHOD'] !== 'POST'
    || $admin->checkIDKEY('settings_token', '', 'POST', true, 'settings') !== 'settings') {
    // a POST with an unknown key: the page outlived its token
    if ($_SERVER['REQUEST_METHOD'] === 'POST') BackendAjax::denyIfAjax(BackendAjax::TOKEN_EXPIRED);
    $message = L_('MESSAGE:GENERIC_SECURITY_ACCESS');
} else {
    $ok = (new Accounts())->sendEmail(SERVER_EMAIL, [
        'LOGIN_WEBSITE_TITLE'         => WEBSITE_TITLE,
        'WBMAILER_DEFAULT_SENDERNAME' => WBMAILER_DEFAULT_SENDERNAME,
        'SERVER_EMAIL'                => SERVER_EMAIL,
        'WB_URL'                      => WB_URL,
        'DATE'                        => date('d-m-Y', time() + DEFAULT_TIMEZONE),
        'TIME'                        => date('H:i:s', time() + DEFAULT_TIMEZONE),
    ], 'testmail') == true;
    $message = sprintf(L_($ok ? 'MESSAGE:TESTMAIL_SUCCESS' : 'MESSAGE:TESTMAIL_FAILURE'), SERVER_EMAIL);
}

http_response_code($ok ? 200 : 422);
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok' => $ok, 'message' => $message]);
