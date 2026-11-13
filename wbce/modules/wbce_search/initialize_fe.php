<?php
/**
 * wbce_search - initialize_fe.php
 * Loaded by the core on frontend requests only, right after initialize.php
 * (framework/initialize.php: initialize.php, then initialize_fe.php /
 * initialize_be.php by context).
 *
 * Adds the live-search script to frontend pages — but only while WBCE
 * Search actually serves /search/, because the JSON endpoint
 * (search/index.php?ws_ajax=1) only exists then.
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
defined('WB_PATH') or die(header('Location: ../index.php'));

// The same check as initialize.php — while it fails, the classes are not
// registered either. SHOW_SEARCH (core) covers the "Search" setting for this
// visitor: a guest gets neither live search nor the jump when only
// logged-in users may search.
if (!SHOW_SEARCH) return;

// Arriving from a search hit (?searchresult=1&sstring=…): the core already
// wraps the terms in <span class="highlight"> — fe_search_jump.js scrolls to
// the first one. Independent of the live-search setting below.
if (isset($_GET['searchresult']) && !empty($_GET['sstring']) && !isset($_GET['nohighlight'])) {
    I::insertJsFile(WB_URL . '/modules/wbce_search/assets/fe_search_jump.js', 'body_late', 'search_jump');
}

// The search page queues the same script itself (WbceSearchPage).
if (str_ends_with((string) ($_SERVER['SCRIPT_NAME'] ?? ''), '/search/index.php')) return;

// Module settings live in {TP}settings, loaded by the core — no query here.
if (!WbceSearchSettings::get('ajax_suggest')) return;

I::insertJsCode(
    'window.WS_SEARCH_CFG=' . json_encode([
        'ajax_url'  => WB_URL . '/search/index.php?ws_ajax=1',
        'min_chars' => max(2, (int) WbceSearchSettings::get('min_length')),
        'delay'     => 300,
    ]) . ';',
    'body_late',
    'search_cfg'
);
I::insertJsFile(WB_URL . '/modules/wbce_search/assets/fe_search.js', 'body_late', 'search_js');
I::insertCssFile(WB_URL . '/modules/wbce_search/assets/fe_search_suggest.css', 'head_late', 'search_suggest_css');
