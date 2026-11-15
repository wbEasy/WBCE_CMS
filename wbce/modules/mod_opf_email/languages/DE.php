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

// Modulbeschreibung
$module_name = 'E-Mail-Ausgabefilter';
$module_description = 'Dieses Modul erlaubt die Filterung von Inhalten vor der Anzeige im Frontend.';

// Ueberschriften und Textausgaben
$OPF['HEADING'] = 'Optionen: Ausgabefilterung';
$OPF['HOWTO'] = '&Uuml;ber nachfolgende Optionen kann die Ausgabefilterung konfiguriert werden.';
$OPF['WARNING'] = '';

// Text von Form Elementen
$OPF['BASIC_CONF'] = 'Grundeinstellungen';
$OPF['SYS_REL'] = 'Frontendausgabe mit relativen URLs';
$OPF['EMAIL_FILTER'] = 'Filtere E-Mail Adressen im Text';
$OPF['MAILTO_FILTER'] = 'Filtere E-Mail Adressen in mailto-Links';
$OPF['ENABLED'] = 'Aktiviert';
$OPF['DISABLED'] = 'Deaktiviert';

$OPF['REPLACEMENT_CONF'] = 'E-Mail-Ersetzungen';
$OPF['AT_REPLACEMENT'] = 'Ersetze "@" durch';
$OPF['DOT_REPLACEMENT'] = 'Ersetze "." durch';

$OPF['ALL_ON_OFF'] = 'Alle Filter aktivieren/deaktivieren';
$OPF['DROPLETS'] = 'Droplets-Filter';
$OPF['WBLINK'] = 'wblink-Filter';
$OPF['INSERT'] = 'CSS-, JS-, Meta-Insert-Filter';
$OPF['JS_MAILTO'] = 'Javascript f&uuml;r Mailto-Filter';
$OPF['JS_TEXT'] = 'Javascript f&uuml;r sichtbare Adressen';
$OPF['JS_TEXT_HINT'] = 'Die Adresse steht dann gar nicht mehr im Quelltext, sondern wird erst im Browser eingesetzt. <strong>Ohne JavaScript ist sie nicht sichtbar</strong> &ndash; es gibt bewusst keinen Ersatztext.';
$OPF['REPLACEMENT_HINT'] = '<strong>Wenn beide Felder leer gelassen werden wird die empfohlene Variante aktiviert:</strong> Die Adresse wird zeichenweise als HTML-Entity kodiert, <code>@</code> und <code>.</code> zus&auml;tzlich in <code>&lt;span&gt;</code> gekapselt. Besucher lesen <code>max@example.com</code>, im Quelltext steht keine Adresse.';
$OPF['SHORT_URL'] = 'Short Url Filter(kein /pages/, kein .php)';
$OPF['CSS_TO_HEAD'] = 'CSS in den Head transferieren';
