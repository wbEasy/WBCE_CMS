<?php
/**
 * Flatpickr — WBCE integration setup
 *
 * Include this file instead of include/jscalendar/wb-setup.php.
 * It sets the following variables used by the template (pages_sections.htt)
 * and by sections.php when formatting stored timestamps for display:
 *
 *   $fp_locale_key  — locale key for flatpickr.l10ns lookup (e.g. 'de', 'default')
 *   $fp_dateFormat  — Flatpickr date format token string (PHP-style, e.g. 'd.m.Y')
 *   $fp_php_format  — PHP date() format string (identical to $fp_dateFormat)
 *   $fp_use_time    — bool; set to true BEFORE including this file to enable timepicker
 *
 * @copyright WBCE Project (2015-)
 * @license   GNU GPL2 (or any later version)
 */

if (!defined('WB_URL')) {
    header('Location: ../../index.php');
    exit(0);
}

// ── Locale key ────────────────────────────────────────────────────────────────
// WBCE LANGUAGE code → key in flatpickr.l10ns, from DateTimeFormat (one table
// for the whole core; it also has HR, which this file's own copy missed).
// New code: DateTimeFormat::pickerConfig() — ISO in the field, the user's
// format with localized names on screen. The variables below stay as they
// were for existing callers.
$fp_locale_key = DateTimeFormat::pickerLocale();

// ── Date / time format ────────────────────────────────────────────────────────
// Flatpickr uses PHP-style tokens (d, m, Y, H, i) — same tokens work for both
// the picker display and PHP date() formatting, so $fp_php_format = $fp_dateFormat.
switch (DATE_FORMAT) {
    case 'd.m.Y':
    case 'd M Y':
    case 'l, jS F, Y':
    case 'jS F, Y':
    case 'D M d, Y':
    case 'd-m-Y':
    case 'd/m/Y':
        $fp_dateFormat = 'd.m.Y';
        $fp_php_format = 'd.m.Y';
        break;

    case 'm/d/Y':
    case 'm-d-Y':
    case 'M d Y':
    case 'm.d.Y':
        $fp_dateFormat = 'm/d/Y';
        $fp_php_format = 'm/d/Y';
        break;

    default:
        $fp_dateFormat = 'Y-m-d';
        $fp_php_format = 'Y-m-d';
        break;
}

$fp_use_time = isset($fp_use_time) && $fp_use_time === true;
if ($fp_use_time) {
    $fp_dateFormat .= ' H:i';
    $fp_php_format .= ' H:i';
}

// ── Enqueue assets (loaded once via WBCE asset pipeline) ─────────────────────
$_fp_base = WB_URL . '/include/date_time_picker/';
I::insertCssFile($_fp_base . 'flatpickr.wbeRange.min.css', 'HEAD TOP+');
I::insertJsFile([
    $_fp_base . 'flatpickr.min.js',
    $_fp_base . 'flatpickr.locales.js',
    $_fp_base . 'flatpickr.wbeRange.js',
], 'BODY TOP+');
unset($_fp_base);


if(!function_exists('jscalendar_to_timestamp')){
/**
 * Converts a date string (supporting multiple input formats) into a Unix timestamp.
 *
 * This function was originally created for jscalendar / Flatpickr integration
 * and maintains the exact original behavior for backward compatibility.
 *
 * Supported input formats:
 * - dd.mm.yyyy or dd.mm.yy     (e.g. 31.12.2025 or 31.12.25)
 * - mm/dd/yyyy or mm/dd/yy     (e.g. 12/31/2025 or 12/31/25)
 * - Any format supported by PHP's strtotime() (including yyyy-mm-dd, relative dates, etc.)
 *
 * @param string $str       The date string to parse.
 * @param string $offset    Optional base timestamp (used for relative dates like "+1 day", "-3 weeks", etc.).
 *                          If set to '0', it will be treated as empty.
 * @param string $timeshift If this parameter is not empty, the global TIMEZONE constant
 *                          will be subtracted from the resulting timestamp (legacy behavior).
 *
 * @return string|int       Returns the Unix timestamp as integer.
 *                          Returns string '0' if the input is empty or exactly '0'.
 */
    function jscalendar_to_timestamp(string $str, string $offset = '', string $timeshift = ''): string|int
    {
        $str = trim($str);

        if ($str === '' || $str === '0') {
            return '0';
        }

        if ($offset === '0') {
            $offset = '';
        }

        // Convert dd.mm.yyyy → yyyy-mm-dd
        if (preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{2}(?:\d{2})?)$/', $str, $m)) {
            $str = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
        }
        // Convert mm/dd/yyyy → yyyy-mm-dd
        elseif (preg_match('#^(\d{1,2})/(\d{1,2})/(\d{2}(?:\d{2})?)$#', $str, $m)) {
            $str = sprintf('%04d-%02d-%02d', $m[3], $m[1], $m[2]);
        }

        // Use strtotime() with optional base timestamp
        $timestamp = $offset !== ''
            ? strtotime($str, (int)$offset)
            : strtotime($str);

        // Legacy timezone handling
        if ($timeshift !== '') {
            $timestamp -= TIMEZONE;
        }

        return $timestamp;
    }
}