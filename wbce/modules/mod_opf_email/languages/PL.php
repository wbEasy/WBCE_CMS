<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * @copyright    Ryan Djurovich (2004-2009)
 * @copyright    WebsiteBaker Org. e.V. (2009-2015)
 * @copyright    WBCE Project (2015-)
 * @category     tool
 * @package      OPF E-Mail
 * @version      1.1.7
 * @authors      Martin Hecht (mrbaseman)
 * @link         https://forum.wbce.org/viewtopic.php?id=176
 * @license      GNU GPL2 (or any later version)
 * @platform     WBCE 1.x
 * @requirements OutputFilter Dashboard 1.5.x and PHP 5.4 or higher
 *
 **/

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if (!defined('WB_PATH')) {
    // Stop this file being access directly
    if (!headers_sent()) {
        header("Location: ../index.php", true, 301);
    }
    die('<head><title>Access denied</title></head><body><h2 style="color:red;margin:3em auto;text-align:center;">Cannot access this file directly</h2></body></html>');
}
/* -------------------------------------------------------- */

// Module description

// Module description
$module_name = 'Filtr wyj&#347;cia e-mail';
$module_description = 'Narz&#281;dzie do konfiguracji podstawowego filtra wyj&#347;cia WB(CE)';

// Headings and text outputs
$OPF['HEADING'] = 'Opcje: filtrowanie wyj&#347;cia';
$OPF['HOWTO'] = 'Poni&#380;sze opcje pozwalaj&#261; skonfigurowa&#263; filtrowanie wyj&#347;cia.';
$OPF['WARNING'] = '';

// Text and captions of form elements
$OPF['BASIC_CONF'] = 'Podstawowa konfiguracja e-mail';
$OPF['SYS_REL'] = 'Wyj&#347;cie frontendu ze wzgl&#281;dnymi adresami URL';
$OPF['EMAIL_FILTER'] = 'Filtruj adresy e-mail w tek&#347;cie';
$OPF['MAILTO_FILTER'] = 'Filtruj adresy e-mail w linkach mailto';
$OPF['ENABLED'] = 'W&#322;&#261;czone';
$OPF['DISABLED'] = 'Wy&#322;&#261;czone';

$OPF['REPLACEMENT_CONF']= 'Zamienniki w adresach e-mail';
$OPF['AT_REPLACEMENT']  = 'Zast&#261;p "@" przez';
$OPF['DOT_REPLACEMENT'] = 'Zast&#261;p "." przez';

$OPF['ALL_ON_OFF'] = 'W&#322;&#261;cz/wy&#322;&#261;cz wszystkie stare filtry wyj&#347;cia';
$OPF['DROPLETS'] = 'Filtr Droplets';
$OPF['WBLINK'] = 'Filtr WB-Link';
$OPF['INSERT'] = 'Filtr wstawiania CSS, JS i Meta';
$OPF['JS_MAILTO'] = 'U&#380;yj JavaScriptu w filtrze mailto';
$OPF['JS_TEXT'] = 'JavaScript dla widocznych adres&#243;w';
$OPF['JS_TEXT_HINT'] = 'Adres w og&#243;le nie wyst&#281;puje wtedy w kodzie &#378;r&#243;d&#322;owym, lecz jest wstawiany dopiero w przegl&#261;darce. <strong>Bez JavaScriptu nie jest widoczny</strong> &ndash; celowo nie ma tekstu zast&#281;pczego.';
$OPF['REPLACEMENT_HINT'] = '<strong>Pozostaw oba pola puste</strong>, aby u&#380;y&#263; zalecanego wariantu: adres jest kodowany znak po znaku jako encje HTML, a <code>@</code> i <code>.</code> s&#261; dodatkowo uj&#281;te w <code>&lt;span&gt;</code>. Odwiedzaj&#261;cy widz&#261; <code>max@example.com</code>, w kodzie &#378;r&#243;d&#322;owym nie ma adresu.';
$OPF['SHORT_URL'] = 'U&#380;yj filtra kr&#243;tkich adres&#243;w URL';
$OPF['CSS_TO_HEAD'] = 'U&#380;yj CSS w nag&#322;&#243;wku';
