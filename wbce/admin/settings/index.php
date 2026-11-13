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

/**
 * Settings page — renders the form from the registry (see SettingsForm).
 * Saving and the test mail are fetch requests (save.php, send_testmail.php);
 * the page is never reloaded for either.
 *
 * @since 1.7.0
 */

require '../../config.php';
require_once __DIR__ . '/SettingsForm.php';

$admin  = new Admin('Settings', 'settings_basic');
$alerts = new Alerts();
$form   = new SettingsForm(require __DIR__ . '/settings_registry.php', $admin);

Alerts::ensureToastAssets();
I::loadPlugin('include/wbeSelect');
I::insertJsFile(ADMIN_URL . '/settings/settings.js', 'BODY BTM-');

// include/PHPMailer/config_mail.php overrides the mail settings — say so,
// or changing them seems to do nothing
$mailOverride = false;
$overrideFile = WB_PATH . '/include/PHPMailer/config_mail.php';
if (is_readable($overrideFile)) {
    $overrideCfg  = include $overrideFile;
    $mailOverride = is_array($overrideCfg) && $overrideCfg !== [];
}

$searchTool = $form->guard('search_tool');
$sections   = $form->view();

// HTML fields (website header/footer) as code fields with HTML highlighting
// — no toolbar, so no line numbers either (CodeMirror_Config). Without the
// module they stay plain textareas.
if (class_exists('CodeEditor')) {
    foreach ($sections as $section) {
        foreach ($section['fields'] as $name => $field) {
            if ($field['type'] === 'html') {
                CodeEditor::init('set_' . $name, 'html', [
                    'height'    => 'auto',
                    'toolbar'   => false,
                    'line_wrap' => true,
                ]);
            }
        }
    }
}

$admin->getThemeFile('settings.twig', [
    'MESSAGE_BOX'      => $alerts->render(),
    'SECTIONS'         => $sections,
    'IS_ADVANCED'      => $form->userLevel() >= SettingsForm::LEVEL_ADVANCED,
    // peeked, never consumed: the page saves any number of times
    'TOKEN'            => $admin->getIDKEY('settings', 'settings'),
    'SAVE_URL'         => ADMIN_URL . '/settings/save.php',
    'TESTMAIL_URL'     => ADMIN_URL . '/settings/send_testmail.php',
    'SEARCH_TOOL_URL'  => $searchTool ? ADMIN_URL . '/admintools/tool.php?tool=wbce_search' : '',
    'SEARCH_TOOL_NAME' => $searchTool ? $admin->get_module_name('wbce_search', false, '', 'tool') : '',
    'MAIL_OVERRIDE'    => $mailOverride,
]);

$admin->print_footer();
