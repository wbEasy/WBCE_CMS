<?php
/**
 * wbce_search - info.php
 * @module    wbce_search
 * @author    Peter Kitzinger (Slugger)
 * @author    Christian M. Stefan (https://www.wbEasy.de)
 * @copyright WBCE Project (2026-)
 * @license   GNU General Public License
 * @platform  WBCE 1.7.0+
 *
 * Developed with AI assistance (Claude).
 */

$core               = true;
$module_directory   = 'wbce_search';
$module_name        = 'WBCE Search';
$module_function    = 'tool, initialize';
$module_version     = '0.6.1';
$module_platform    = '1.7.0';
$module_author      = 'Peter Kitzinger (Slugger), Christian M. Stefan';
$module_license     = 'GNU General Public License';
$module_description = 'Advanced Search Settings. Index, modules, layouts and statistics of the WBCE CMS search: full-text search with operators, live suggestions, hit highlighting on the target page and a tag cloud.';

$module_icon        = 'fa fa-search';


// Don't load backend header and footer on HTMX requests
if (!empty($_SERVER['HTTP_HX_REQUEST'])) {
    $module_nopage = true;
}
