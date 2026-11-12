<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (2015-)
 * @license GNU GPL2 (or any later version)
 */

defined('FRONTEND_CONTEXT') or define('FRONTEND_CONTEXT', true);
// Include the config file
require '../config.php';

// Required page details
$page_id = 0;
$page_description = '';
$page_keywords = '';
define('PAGE_ID', 0);
define('ROOT_PARENT', 0);
define('PARENT', 0);
define('LEVEL', 0);
define('PAGE_TITLE', $TEXT['SEARCH']);
define('MENU_TITLE', $TEXT['SEARCH']);
define('MODULE', '');
define('VISIBILITY', 'public');

// The search page is WBCE Search (core module, always shipped). It also
// handles a search that is switched off or not open to this visitor
// (SHOW_SEARCH) and sets the page's TEMPLATE from its own setting.
$searchToolPath = WB_PATH . '/modules/wbce_search';
if (!is_file($searchToolPath . '/search_page.php')) {
    http_response_code(404);
    exit('Search is not available.');
}
define('PAGE_CONTENT', $searchToolPath . '/search_output.php');
include $searchToolPath . '/search_page.php';

// Get the referrer page ID if it exists
$referrer = 0;
if (isset($_REQUEST['referrer']) && is_numeric($_REQUEST['referrer']) && intval($_REQUEST['referrer']) > 0) {
    $referrer = intval($_REQUEST['referrer']);
} 
define('REFERRER_ID', $referrer);

// Include index (wrapper) file
require WB_PATH . '/index.php';