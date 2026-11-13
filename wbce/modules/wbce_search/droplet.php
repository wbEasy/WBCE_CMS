<?php
/**
 * wbce_search - droplet.php
 * Droplet [[wbce_search_tagcloud]] — embeddable tag cloud
 * Parameters: max=20 min_count=1 desc="Frequently searched:" active=true
 *   active=false (or off/no) switches this droplet off (independent of the search page
 *   setting "Show tag cloud") — handy to keep it in place but hidden.
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

// Run in frontend context only
if (!defined('WB_PATH') || !defined('FRONTEND_CONTEXT')) return '';

// Nothing while the search is off for this visitor (the core's "Search"
// setting, SHOW_SEARCH) — the tags would link to a disabled search page,
// and the module's classes are not even loaded then.
if (defined('SHOW_SEARCH') && !SHOW_SEARCH) return '';

global $database;

// Module texts through the core's Lang registry (EN as fallback, loaded once
// per request) — no include: droplet code may not include files (CodeVet).
Lang::loadLanguage(WB_PATH . '/modules/wbce_search');

// Droplets passes parameters directly as variables
// [[wbce_search_tagcloud?max=20&min_count=1&desc=Oft gesucht&active=true]]
// active: default on; only an explicit false / off / no switches it off
// (an empty or unknown value keeps the default). active=0 never arrives
// here: the Droplets engine drops values that are empty() — "0" is one.
if (isset($active) && trim((string) $active) !== ''
    && filter_var($active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === false) {
    return '';
}
$tags = (new WbceSearchStats($database))->getTagCloud(
    isset($max)       ? (int) $max       : null,
    isset($min_count) ? (int) $min_count : null
);
if ($tags === []) return '';

// Layout and stylesheet: as picked in the tool's Layout tab
// (WbceSearchLayouts — own copy, the search template's search/tagcloud.htt,
// or layouts/tagcloud_default.htt).
// desc: omitted = language text, empty = no label, text = own label.
WbceSearchLayouts::queueStylesheet();
return WbceSearchLayouts::renderTagCloud($tags, isset($desc) ? (string) $desc : null);
