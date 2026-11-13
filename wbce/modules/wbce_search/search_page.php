<?php
/**
 * wbce_search - search_page.php
 * Dispatcher: takes over the WBCE search page (/search/) — included from
 * search/index.php before WB_PATH/index.php. The page itself is
 * WbceSearchPage; its HTML goes to $GLOBALS['ws_output'], which
 * search_output.php (PAGE_CONTENT) prints.
 *
 * @module    wbce_search
 * @author    Peter Kitzinger (Slugger)
 * @author    Christian M. Stefan (https://www.wbEasy.de)
 * @copyright WBCE Project (2026-)
 * @license   GNU General Public License
 * @platform  WBCE 1.7.0+
 *
 * Developed with AI assistance (Claude).
 */
defined('WB_PATH') or die('No direct access');

// The wording (namespace SEARCH): EN, the site language on top.
Lang::loadLanguage(WB_PATH . '/modules/wbce_search');

// The core's "Search" setting decides first (none / logged-in users only):
// SHOW_SEARCH, set in framework/initialize.php. (Was defined as a fixed
// true here: the search, the live search and the template's search box
// ignored the setting on this page.)

global $database, $TEXT;

// ── Live search (?ws_ajax=1): JSON, then stop ──────────────────────────────
if (($_GET['ws_ajax'] ?? '') === '1') {
    while (ob_get_level()) ob_end_clean();
    // A machine response: a displayed notice would break the JSON for the
    // browser. Errors still reach the log (log_errors); the HTML page below
    // follows the site's own error setting.
    ini_set('display_errors', '0');
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    echo SHOW_SEARCH
        ? (new WbceSearchPage($database, new WbceSearch($database)))
            ->suggestJson(is_string($_GET['q'] ?? null) ? $_GET['q'] : '')
        : '[]';
    exit;
}

// Frontend template of this page (Settings → Result display), '' = the
// website's default. Set before search/index.php would define TEMPLATE from
// the core's search setting. The classes are only registered while the
// search is on (initialize.php) — hence class_exists().
if (SHOW_SEARCH && class_exists('WbceSearchSettings') && !defined('TEMPLATE')) {
    $_ws_tpl = (string) WbceSearchSettings::get('page_template');
    if ($_ws_tpl !== '' && is_file(WB_PATH . '/templates/' . $_ws_tpl . '/index.php')) {
        define('TEMPLATE', $_ws_tpl);
    }
    unset($_ws_tpl);
}

$GLOBALS['ws_output'] = SHOW_SEARCH
    ? (new WbceSearchPage($database, new WbceSearch($database)))
        ->render($_GET, $_REQUEST, (string) ($_SERVER['REQUEST_URI'] ?? ''))
    // Search off / not open to this visitor: the wording the old core search page used.
    : '<p class="ws-disabled">' . htmlspecialchars(($TEXT['SEARCH'] ?? 'Search') . ' ' . ($TEXT['DISABLED'] ?? 'disabled'), ENT_QUOTES, 'UTF-8') . '</p>';
