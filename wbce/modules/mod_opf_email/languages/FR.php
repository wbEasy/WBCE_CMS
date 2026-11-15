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

// Module Description
$module_name = 'Filtre de sortie e-mail';
$module_description = 'Ce module g&egrave;re le filtrage des donn&eacute;es avant affichage &agrave; l&apos;utilisateur. Permets de filtrer les liens mailto et les adresses emails.';

// Headings and text outputs
$OPF['HEADING'] = 'Options: Output Filter';
$OPF['HOWTO'] = 'Vous pouvez configurer le filtrage des donn&eacute;es avant affichage gr&acirc;ce aux options ci-dessous.'; 
$OPF['WARNING'] = '';

// Text and captions of form elements
$OPF['BASIC_CONF'] = 'Configuration de base des Emails';
$OPF['SYS_REL'] = 'Frontendoutput with  relative Urls';
$OPF['EMAIL_FILTER'] = 'Filtrer le texte des Emails';
$OPF['MAILTO_FILTER'] = 'Filtrer les liens mailto des Emails';
$OPF['ENABLED'] = 'Activ&eacute;';
$OPF['DISABLED'] = 'D&eacute;sactiv&eacute;';

$OPF['REPLACEMENT_CONF']= 'Remplacements';
$OPF['AT_REPLACEMENT']  = 'Remplacer "@" par';
$OPF['DOT_REPLACEMENT'] = 'Remplacer "." par';

$OPF['ALL_ON_OFF'] = 'Enable/Disable all old Outputfilter';
$OPF['DROPLETS'] = 'Droplets filter';
$OPF['WBLINK'] = 'WB-Link Filter';
$OPF['INSERT'] = 'CSS, JS, Meta Insert Filter';
$OPF['JS_MAILTO'] = 'Use Javascript on Mailtofilter';
$OPF['JS_TEXT'] = 'Javascript pour les adresses visibles';
$OPF['JS_TEXT_HINT'] = 'L\'adresse ne figure alors plus dans le code source&nbsp;; elle est ins&eacute;r&eacute;e par le navigateur. <strong>Sans JavaScript, elle n\'est pas visible</strong> &ndash; il n\'y a volontairement aucun texte de remplacement.';
$OPF['REPLACEMENT_HINT'] = '<strong>Leave both fields empty</strong> to use the recommended variant: the address is encoded character by character as HTML entities, with <code>@</code> and <code>.</code> additionally wrapped in <code>&lt;span&gt;</code>. Visitors read <code>max@example.com</code>, the source contains no address.';
$OPF['SHORT_URL'] = 'Use short url filter';
$OPF['CSS_TO_HEAD'] = 'Use CSS to head';
