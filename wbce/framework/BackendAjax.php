<?php
declare(strict_types=1);
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

// Prevent  this  file  from  being  accessed  directly
defined('WB_PATH') or die('No direct access');

/**
 * Backend answers for script requests (fetch, XMLHttpRequest, htmx) that
 * cannot go ahead: session gone, rights missing, page token expired.
 *
 * A login redirect or an HTML error page is useless to a script. fetch()
 * follows the redirect without a word, response.json() fails on the login
 * page, and the page shows a generic error while the user believes the change
 * was saved. Requests that identify as script requests therefore get a status
 * code and JSON instead; the global handler in
 * include/SessionTimeout/SessionTimeout.js turns that into a sticky notice
 * with a reload button. Normal page calls keep the redirect / HTML message.
 *
 * In an endpoint, after a failed token check:
 *
 *   if (!$admin->checkFTAN()) {
 *       BackendAjax::denyIfAjax(BackendAjax::TOKEN_EXPIRED);
 *       // … the endpoint's existing non-AJAX handling
 *   }
 */
final class BackendAjax
{
    public const SESSION_EXPIRED = 'session_expired';
    public const TOKEN_EXPIRED   = 'token_expired';
    public const FORBIDDEN       = 'forbidden';

    /** htmx event fired via HX-Trigger; SessionTimeout.js listens for it. */
    public const HTMX_EVENT = 'wbceAjaxDenied';

    /** reason => [HTTP status, language key] */
    private const REASONS = [
        self::SESSION_EXPIRED => [401, 'MESSAGE:SESSION_EXPIRED_REQUEST'],
        self::TOKEN_EXPIRED   => [403, 'MESSAGE:SESSION_TOKEN_EXPIRED'],
        self::FORBIDDEN       => [403, 'MESSAGE:ADMIN_INSUFFICIENT_PRIVELLIGES'],
    ];

    /**
     * Does the request come from a script rather than a page navigation?
     *
     * Accepts what the backend's scripts send: htmx (HX-Request), jQuery and
     * other XHR wrappers (X-Requested-With: XMLHttpRequest), WBCE's own fetch
     * calls (X-Requested-With: fetch) and anything that asks for JSON. A
     * browser navigation never sends application/json in Accept.
     *
     * @param array<string, mixed>|null $server  $_SERVER (default) or a test double
     */
    public static function isAjax(?array $server = null): bool
    {
        $server ??= $_SERVER;

        if (self::isHtmx($server)) {
            return true;
        }

        $with = strtolower((string) ($server['HTTP_X_REQUESTED_WITH'] ?? ''));
        if ($with === 'xmlhttprequest' || $with === 'fetch') {
            return true;
        }

        return str_contains(strtolower((string) ($server['HTTP_ACCEPT'] ?? '')), 'application/json');
    }

    /**
     * Is it an htmx request? Same test as Alerts::isHtmx(), but on any array.
     *
     * @param array<string, mixed>|null $server
     */
    public static function isHtmx(?array $server = null): bool
    {
        $server ??= $_SERVER;
        return !empty($server['HTTP_HX_REQUEST']);
    }

    /**
     * Build the refusal for $reason without sending anything.
     *
     * htmx gets an HX-Trigger on top of the JSON body: on a 4xx htmx skips the
     * swap but still fires the event, so the page can show the notice. Not
     * HX-Redirect — that would navigate to the login page and throw away
     * whatever the user had typed into the form.
     *
     * @param  array<string, mixed>|null $server
     * @return array{status: int, headers: array<string, string>, body: array<string, mixed>}
     */
    public static function response(string $reason, ?array $server = null): array
    {
        if (!isset(self::REASONS[$reason])) {
            throw new InvalidArgumentException("BackendAjax: unknown reason '{$reason}'");
        }
        [$status, $langKey] = self::REASONS[$reason];

        $body = [
            'ok'        => false,
            'reason'    => $reason,
            'message'   => L_($langKey),
            'login_url' => ADMIN_URL . '/login/',
        ];

        $headers = [
            'Content-Type'  => 'application/json; charset=utf-8',
            'Cache-Control' => 'no-store',
        ];

        if (self::isHtmx($server)) {
            // json_encode's default \u escaping keeps the header ASCII-only
            $headers['HX-Trigger'] = (string) json_encode([self::HTMX_EVENT => $body]);
        }

        return ['status' => $status, 'headers' => $headers, 'body' => $body];
    }

    /**
     * Send the refusal for $reason and end the request.
     */
    public static function deny(string $reason): never
    {
        $response = self::response($reason);

        // whatever was buffered so far (a BOM, a notice) would break the JSON
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        if (!headers_sent()) {
            http_response_code($response['status']);
            foreach ($response['headers'] as $name => $value) {
                header($name . ': ' . $value);
            }
        }

        echo json_encode($response['body'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Refuse with JSON when the current request is a script request;
     * otherwise return and let the caller do its usual redirect / message.
     */
    public static function denyIfAjax(string $reason): void
    {
        if (self::isAjax()) {
            self::deny($reason);
        }
    }
}
