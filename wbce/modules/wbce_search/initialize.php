<?php
/**
 * wbce_search - initialize.php
 * Loaded by the core on every request, frontend and backend, for addons
 * whose $module_function contains "initialize" (info.php: 'tool, initialize').
 *
 * Makes the module's classes (classes/WbceSearch*.php) known to the core
 * autoloader — no file of the module requires a class itself. The frontend
 * part (live search, jump to the first hit) is in initialize_fe.php.
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

// The module's tables: {TP_SEARCH}index, {TP_SEARCH}words, {TP_SEARCH}stats
// (= {TP}mod_search_*). Registered before the early return below — it costs
// nothing and keeps the tables addressable on every request.
$database->addPrefix('{TP_SEARCH}', TABLE_PREFIX . 'mod_search_');

// Frontend pages: nothing of the module is needed while this visitor may not
// search (SHOW_SEARCH — the core's "Search" setting, set in
// framework/initialize.php). (The backend always registers the classes: the
// admin tool is where the search is set up. /search/ is a frontend page too;
// its dispatcher only uses the classes when SHOW_SEARCH is true.)
if (defined('FRONTEND_CONTEXT') && !SHOW_SEARCH) {
    return;
}

WbAuto::AddDir(__DIR__ . '/classes/', true);
