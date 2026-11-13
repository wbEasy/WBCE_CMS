<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright Ryan Djurovich (2004-2009)
 * @copyright WebsiteBaker Org. e.V. (2009-2015)
 * @copyright WBCE Project (since 2015)
 * @license GNU GPL2 (or any later version)
 */

// Prevent this file from being accessed directly
defined('WB_PATH') or die("Cannot access this file directly"); 
        
$sUsernameField = 'username';
$sPasswordField = 'password';

if(defined('SMART_LOGIN') AND SMART_LOGIN == 'enabled') {
    // Generate username field name
    $sUsernameField = 'username_';
    $sPasswordField = 'password_';

    $temp = array_merge(range('a','z'), range(0,9));
    shuffle($temp);
    for($i=0; $i<=7; $i++) {
            $sUsernameField .= $temp[$i];
            $sPasswordField .= $temp[$i];
    }
}

$oAccounts = new Accounts();
// Messages and captcha come from the Login object that handled this
// request (account/login.php): a fresh Alerts here never held them, so a
// wrong password said nothing, and once the captcha was required the form
// offered none — the login was impossible until the lockout window passed.
$aToTwig = array(
    'USERNAME_FIELD' => $sUsernameField,
    'PASSWORD_FIELD' => $sPasswordField,
    'REDIRECT_URL'   => h($oLogin->getRedirectUrl()),
    'MESSAGE_BOX'    => $oLogin->renderMessages(),
    'CAPTCHA'        => $oLogin->getCaptchaHtml(),
);
$oAccounts->useTwigTemplate('form_login.twig', $aToTwig);