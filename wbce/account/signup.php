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

require_once dirname(__DIR__) . '/config.php';

if (!FRONTEND_LOGIN) {
    header('Location: ' . WB_URL . ((INTRO_PAGE) ? PAGES_DIRECTORY : '') . '/index.php');
    exit;
}

$oAccounts = new Accounts();

$oAccounts->loadLanguages();

// Check if FRONTEND_SIGNUP group constant is defined or USER_ID is in Session
$iSignupGroupID = defined('FRONTEND_SIGNUP') ? (int)FRONTEND_SIGNUP : 0;
// Never into the administrators group or a group that no longer exists:
// a wrong value in the settings (old install, import) must not open the
// signup to admin accounts.
if ($iSignupGroupID !== 0 && !(new GroupManager())->isValidSignupGroup((string) $iSignupGroupID)) {
    $iSignupGroupID = 0;
}
$iUserID = isset($_SESSION['USER_ID']) ? (int)$_SESSION['USER_ID'] : 0;

// Work out redirect_url (either root index.php or intro page in pages/index.php)
$sRedirect = WB_URL . ((INTRO_PAGE) ? PAGES_DIRECTORY : '') . '/index.php';

// Do not show signup form if no FRONTEND_SIGNUP was defined or user already logged-in
if ($iSignupGroupID === 0 || $iUserID != 0) {
    header('Location: ' . $sRedirect);
    exit;
}

// The ASP honeypot is checked in form_signup.php (Captcha::verify(), or
// Captcha::verifyHoneypotField() when only ASP is on).

// Required page details
$page_id = (isset($_SESSION['PAGE_ID']) && is_numeric($_SESSION['PAGE_ID']) ? $_SESSION['PAGE_ID'] : 0);
define('TEMPLATE', $oAccounts->cfg['signup_template']);
define('PAGE_ID', $page_id);
define('ROOT_PARENT', 0);
define('PARENT', 0);
define('LEVEL', 0);
define('PAGE_TITLE', $TEXT['SIGNUP']);
define('MENU_TITLE', $TEXT['SIGNUP']);
define('VISIBILITY', 'public');
define('PAGE_CONTENT', ACCOUNT_TOOL_PATH . '/account/form_signup.php');

// Setup wb object, skip header and skip permission checks
#$wb = new wb('Start', 'start', false, false);

// disable auto authentication
$auto_auth = false;

// Include index wrapper file
require WB_PATH . '/index.php';
