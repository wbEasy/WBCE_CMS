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
 * @version      1.1.9
 * @authors      Martin Hecht (mrbaseman)
 * @link         https://forum.wbce.org/viewtopic.php?id=176
 * @license      GNU GPL2 (or any later version)
 * @platform     WBCE 1.x
 * @requirements OutputFilter Dashboard 1.5.x and PHP 5.4 or higher
 *
 * Admin-Tool entry point: saves the settings (post-redirect-get with toasts)
 * and renders templates/tool.twig.
 **/

defined('WB_PATH') or exit('No direct access allowed');

/**
 * Sanitise an @/. replacement before it is stored.
 *
 * Keeps a handful of inert inline tags so a replacement like
 * "<span>&commat;</span>" is possible, then removes every attribute from
 * them — an allowlist alone would still let "<span onclick=...>" through,
 * and this string ends up in the markup of every page the filter touches.
 *
 * @param  mixed  $value Raw POST value.
 * @return string
 */
function opf_email_clean_replacement($value)
{
    $value = trim(strip_tags((string) $value, '<span><b><i><em><strong><small>'));
    return preg_replace('#<(/?)(span|b|i|em|strong|small)(?:\s[^>]*)?>#i', '<$1$2>', $value);
}

// check whether outputfilter-module is installed
if (file_exists(WB_PATH.'/modules/outputfilter_dashboard/functions.php')) {
    // functions.php require()s the dashboard's info.php into THIS scope, which is
    // the runner's: it overwrites $module_name (and friends) with the dashboard's,
    // and the runner reads $module_name for the breadcrumb only after this file
    // has finished. Put our own values back afterwards.
    $opfSaved = [];
    foreach (['module_name', 'module_description', 'module_function', 'module_directory', 'module_version', 'module_platform', 'module_author', 'module_license', 'module_icon'] as $opfVar) {
        if (isset($$opfVar)) {
            $opfSaved[$opfVar] = $$opfVar;
        }
    }
    require_once(WB_PATH.'/modules/outputfilter_dashboard/functions.php');
    foreach ($opfSaved as $opfVar => $opfValue) {
        $$opfVar = $opfValue;
    }
    unset($opfSaved, $opfVar, $opfValue);
}

// ── Save ──────────────────────────────────────────────────────────────────────
if (isset($_POST['save_settings'])) {
    if (!$admin->checkFTAN()) {
        (new Alerts())->sessionToast($MESSAGE['GENERIC_SECURITY_ACCESS'], 'error');
        header('Location: ' . $returnUrl);
        exit;
    }

    $flag = function ($name) {
        return (int) (intval($_POST[$name] ?? 0) != 0);
    };
    $data = array();
    $data['email_filter']  = $flag('email_filter');
    $data['mailto_filter'] = $flag('mailto_filter');
    $data['js_mailto']     = $flag('js_mailto');
    $data['js_text']       = $flag('js_text');
    // Entities (&commat;, &period;, &#64;) are plain text here and pass untouched;
    // see opf_email_clean_replacement() for what is let through.
    $data['at_replacement']  = opf_email_clean_replacement($_POST['at_replacement'] ?? '');
    $data['dot_replacement'] = opf_email_clean_replacement($_POST['dot_replacement'] ?? '');

    // A mode without its parent filter never runs, and a switch that silently
    // does nothing is worse than no switch.
    if (!$data['mailto_filter']) {
        $data['js_mailto'] = 0;
    }
    if (!$data['email_filter']) {
        $data['js_text'] = 0;
    }

    $errmsg = '';
    $errmsg .= (string) Settings::Set('opf_email_filter',    $data['email_filter']);
    $errmsg .= (string) Settings::Set('opf_mailto_filter',   $data['mailto_filter']);
    $errmsg .= (string) Settings::Set('opf_js_mailto',       $data['js_mailto']);
    $errmsg .= (string) Settings::Set('opf_js_text',         $data['js_text']);
    $errmsg .= (string) Settings::Set('opf_at_replacement',  $data['at_replacement']);
    $errmsg .= (string) Settings::Set('opf_dot_replacement', $data['dot_replacement']);

    if (function_exists('opf_set_active')) {
        // if any option is active switch on the filter, otherwise switch it off
        opf_set_active('E-Mail', ($data['email_filter'] || $data['mailto_filter'] || $data['js_mailto'] || $data['js_text']) ? 1 : 0);
    }

    if ($errmsg === '') {
        (new Alerts())->sessionToast('MESSAGE:CHANGES_SAVE_SUCCESS', 'success');
    } else {
        (new Alerts())->sessionToast($MESSAGE['RECORD_MODIFIED_FAILED'] . '<br>' . $errmsg, 'error');
    }
    header('Location: ' . $returnUrl);
    exit;
}

// ── Display ───────────────────────────────────────────────────────────────────
getTwig(__DIR__ . '/templates/')->load('tool.twig')->display([
    'returnUrl'       => $returnUrl,
    'RETURN_TO_TOOLS' => $returnToTools,
    'cfg'             => [
        'email_filter'    => (int) (Settings::Get('opf_email_filter')  == 1),
        'mailto_filter'   => (int) (Settings::Get('opf_mailto_filter') == 1),
        'js_mailto'       => (int) (Settings::Get('opf_js_mailto')     == 1),
        'js_text'         => (int) (Settings::Get('opf_js_text')       == 1),
        'at_replacement'  => (string) Settings::Get('opf_at_replacement'),
        'dot_replacement' => (string) Settings::Get('opf_dot_replacement'),
    ],
]);
