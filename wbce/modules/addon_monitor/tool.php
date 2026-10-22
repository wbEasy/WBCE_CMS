<?php
/**
 * @file       tool.php
 * @category   admintool
 * @package    addon_monitor
 * @author     Christian M. Stefan (https://www.wbeasy.de)
 * @license    http://www.gnu.org/licenses/gpl.html
 * @platform   WBCE CMS 1.7.0
 */

defined('WB_PATH') or die(header('Location: ../index.php'));

// no access to this tool if use has no access to addons
if (!$admin->get_permission('addons')) {
    die(header('Location: ../../index.php'));
}

// Load Language
Lang::loadLanguage();
// set ur of this Tool
$toolUrl  = ADMIN_URL . '/admintools/tool.php?tool=' . basename(__DIR__);
    
// what tabs does this tool have? Each belongs to the system permission of
// the same name; the filtered list is both the whitelist for ?addons= and
// the source of the navigation, so a tab hidden from the menu can't be
// opened by URL either.
$tabs = array_values(array_filter(
    ['modules', 'templates', 'languages'],
    fn($tab) => $admin->get_permission($tab)
));
if (!$tabs) {
    echo $MESSAGE['ADMIN_INSUFFICIENT_PRIVELLIGES'];
    return;
}

// what tab do we have to show? (anything not allowed falls back to the first allowed one)
$showTab = isset($_GET['addons']) ? (string) $_GET['addons'] : $tabs[0];
if (!in_array($showTab, $tabs, true)) {
    $showTab = $tabs[0];
}

// load functions
require_once(__DIR__ . '/functions.php');
switch ($showTab) {
    case 'templates': $aOuptut = getTemplatesArray(); break;
    case 'languages': $aOuptut = getLanguagesArray(); break;
    default:          $aOuptut = getModulesArray();   break;
}
?>
<div class="am-header">
    <nav class="am-tabs" role="tablist">
        <?php foreach ($tabs as $tab): ?>
        <a class="am-tab<?= ($showTab === $tab) ? ' am-tab--active' : '' ?>"
           href="<?= $toolUrl ?>&addons=<?= $tab ?>"
           role="tab"
           aria-selected="<?= ($showTab === $tab) ? 'true' : 'false' ?>">
            <?= $MENU[strtoupper($tab)] ?>
        </a>
        <?php endforeach ?>
    </nav>
    <span class="am-version">Addon Monitor <?= $module_version ?></span>
</div>
<div class="am-panel">
    <?php 
    // load the template of the current tab
    $oTwig = getTwig(__DIR__ . '/twig/');
    $oTemplate = $oTwig->load('monitor_' . $showTab . '.twig');
    $oTemplate->display($aOuptut); 
    ?>
</div>
<noscript><p style="padding:8px;color:#900;">Please enable JavaScript for full functionality.</p></noscript>