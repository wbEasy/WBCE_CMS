<?php
/**
 * errorlogger — tool.php
 *
 * AdminTool controller: permission check, state changes (save / delete /
 * view-mode cookie), then it hands a plain data array to twig/tool.twig.
 * No markup lives here — see ErrorlogParser.php for the log logic and
 * twig/tool.twig for the layout.
 *
 * Included by admin/admintools/tool.php, which already enforced the
 * 'admintools' permission, loaded the language files and opened the page shell.
 *
 * @author  Ruud Eisinga · www.dev4me.com   (original module)
 * @author  Christian M. Stefan · www.wbEasy.de   (WBCE 1.7.0 rework)
 * @license GNU GPL2
 */

defined('WB_PATH') or die('Cannot access this file directly');
$admin->get_permission('admintools') or die(header('Location: ../../index.php'));

require_once __DIR__ . '/ErrorlogParser.php';

$base            = ADMIN_URL . '/admintools/tool.php?tool=errorlogger';
$tab             = (($_GET['tab'] ?? '') === 'settings') ? 'settings' : 'log';
$debugConstants  = ['WBCE_DEBUG', 'SQL_DEBUG', 'PDO_CANONICAL_DEBUG'];
// WBCE_DEBUG can't be toggled here while WB_DEBUG is still hardcoded in
// config.php — initialize.php then defines DEPRECATED_WB_DEBUG.
$wbceDebugLocked = defined('DEPRECATED_WB_DEBUG');

// ── Save (FTAN-protected POST, Post/Redirect/Get) ───────────────────────────
if (!empty($_POST['el_save'])) {
    while (ob_get_level() > 0) { ob_end_clean(); }

    if (!$admin->checkFTAN()) {
        (new Alerts())->sessionToast($MESSAGE['GENERIC_SECURITY_ACCESS'], 'error');
        header('Location: ' . $base . '&tab=settings');
        exit;
    }

    foreach ($debugConstants as $c) {
        if ($c === 'WBCE_DEBUG' && $wbceDebugLocked) {
            continue;
        }
        if (!empty($_POST['dbg'][$c])) {
            Settings::setFileBasedSetting($c, true);
        } else {
            Settings::deleteFileBasedSetting($c);
        }
    }

    if (in_array($_POST['er_level'] ?? '', ['E0', 'E1', 'E2', 'E3'], true)) {
        Settings::set('er_level', $_POST['er_level']);
    }

    (new Alerts())->sessionToast('MESSAGE:CHANGES_SAVE_SUCCESS', 'success');
    header('Location: ' . $base . '&tab=settings');
    exit;
}

// ── View mode — persisted in a cookie ──────────────────────────────────────
$cookie = 'errorlog_colors';
if (isset($_GET['color'])) {
    if ($_GET['color'] === '1' || $_GET['color'] === '2') {
        setcookie($cookie, $_GET['color'], time() + (86400 * 365));
        $_COOKIE[$cookie] = $_GET['color'];
    } else {
        setcookie($cookie, '0', 1);
        unset($_COOKIE[$cookie]);
    }
}
$view = isset($_COOKIE[$cookie]) ? (int) $_COOKIE[$cookie] : 0;

// ── Log file ───────────────────────────────────────────────────────────────
$logfile  = ini_get('error_log') ?: WB_PATH . '/var/logs/php_error.log.php';
$warnings = [];

// Delete = archive the current file under a timestamped name.
if (isset($_GET['delete']) && file_exists($logfile)) {
    $archived = dirname($logfile) . '/' . date('Ymd_Hi') . '_php_error.log.php';
    rename($logfile, $archived);
    $warnings[] = [
        'type' => 'info',
        'text' => sprintf($TXT['LOGFILE_RENAMED'], str_replace(WB_PATH, '', $archived)),
    ];
}

$since = isset($_SESSION['lastview']) ? (int) strtotime($_SESSION['lastview']) : time();

$lines = [];
if (file_exists($logfile)) {
    $lines = file($logfile);
    unset($lines[0]);                          // "<?php die()" guard line
    $lines = array_slice($lines, -250);
}

// Error reporting not at maximum → some errors may be missing.
if (error_reporting(-1) !== E_ALL) {
    $warnings[] = ['type' => 'warning', 'text' => $TXT['NOT_MAX_LEVEL']];
}

// ── Build the view model ───────────────────────────────────────────────────
$toTwig = [
    'MODULE_NAME'  => $module_name,
    'BASE'         => $base,
    'TAB'          => $tab,
    'WARNINGS'     => $warnings,
];

if ($tab === 'settings') {
    $erLevel = defined('ER_LEVEL') ? (string) ER_LEVEL : 'E0';

    loadPlugin('include/wbeSelect'); // ER_LEVEL <select> is a wbeSelect widget

    // README link — rendered as a MarkdownWbce popup when that (core) module is
    // present, otherwise omitted. Own href + onclick slots (see MdReaderLink).
    $readmeUrl = $readmeOnclick = '';
    if (class_exists('MdReaderLink') && is_readable(__DIR__ . '/README.md')) {
        $md = MdReaderLink::file('/modules/errorlogger/README.md')->title($module_name);
        $readmeUrl     = $md->url();
        $readmeOnclick = $md->popupOnclick();
    }

    $toTwig += [
        'FTAN'              => $admin->getFTAN(),
        'README_URL'        => $readmeUrl,
        'README_ONCLICK'    => $readmeOnclick,
        'WBCE_DEBUG_LOCKED' => $wbceDebugLocked,
        'WB_DEBUG_MSG'      => $wbceDebugLocked ? $MSG['WB_DEBUG_DEPRECATED'] : '',
        'ER_LEVEL'          => $erLevel,
        'ER_LEVELS'         => [
            'E0' => $TEXT['ERR_USE_SYSTEM_DEFAULT'],
            'E1' => $TEXT['ERR_HIDE_ERRORS_NOTICES'],
            'E2' => $TEXT['ERR_SHOW_ERRORS_NOTICES'],
            'E3' => $TEXT['ERR_SHOW_ERRORS_HIDE_NOTICES'],
        ],
        'DEBUG_SWITCHES'    => [
            [
                'const'     => 'WBCE_DEBUG',
                'label_key' => 'TXT:WBCE_DEBUG_LABEL',
                'desc_key'  => 'TXT:WBCE_DEBUG_DESC',
                'on'        => defined('WBCE_DEBUG') && WBCE_DEBUG,
                'locked'    => $wbceDebugLocked,
                'badge'     => null,
            ],
            [
                'const'     => 'SQL_DEBUG',
                'label_key' => 'TXT:SQL_DEBUG_LABEL',
                'desc_key'  => 'TXT:SQL_DEBUG_DESC',
                'on'        => defined('SQL_DEBUG') && SQL_DEBUG,
                'locked'    => false,
                'badge'     => ['SQL', 'sql'],
            ],
            [
                'const'     => 'PDO_CANONICAL_DEBUG',
                'label_key' => 'TXT:PDO_DEBUG_LABEL',
                'desc_key'  => 'TXT:PDO_DEBUG_DESC',
                'on'        => defined('PDO_CANONICAL_DEBUG') && PDO_CANONICAL_DEBUG,
                'locked'    => false,
                'badge'     => ['PDO', 'pdo'],
            ],
        ],
    ];
} else {
    $toTwig += [
        'VIEW'       => $view,
        'COLOR_MODE' => $view === 1,
        'LOCALE'     => strtolower(defined('LANGUAGE') ? LANGUAGE : 'en'),
        'HAS_LOG'    => count($lines) > 0,
        'PLAIN_ROWS' => $view === 2 ? [] : ErrorlogParser::plainRows($lines, $since),
        'TABLE_ROWS' => $view === 2 ? ErrorlogParser::tableRows($lines, $since) : [],
    ];
}

$_SESSION['lastview'] = date('c');

getTwig(__DIR__ . '/twig/')->load('tool.twig')->display($toTwig);
