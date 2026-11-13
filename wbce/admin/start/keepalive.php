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
 * Extend the backend session — fetch endpoint for the "Extend session" button
 * of the expiry warning in include/SessionTimeout/SessionTimeout.js.
 *
 * Nothing to do here beyond being a logged-in backend request: the session
 * lifetime slides with every request (WbceSession sets discard_after anew).
 * When the session is already gone, Admin answers 401 JSON (BackendAjax) and
 * the script shows the "expired" notice instead.
 *
 * @since 1.7.0
 */

require '../../config.php';

// 'start' is granted to every logged-in user
$admin = new Admin('Start', 'start', false);

http_response_code($_SERVER['REQUEST_METHOD'] === 'POST' ? 200 : 405);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
echo json_encode([
    'ok'      => $_SERVER['REQUEST_METHOD'] === 'POST',
    'timeout' => (int) $admin->get_session_timeout(),
]);
