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
 * "My data" — the logged-in user's own account. Saved by fetch
 * (save.php), the page is not reloaded unless the language changes.
 *
 * @since 1.7.0
 */

require '../../config.php';
require_once __DIR__ . '/PreferencesForm.php';

$admin = new Admin('Preferences');
// accounts without the right "Preferences → Modify" are managed by the administrator
if (!$admin->mayEditOwnData()) {
    $admin->print_error($MESSAGE['PREFERENCES_LOCKED'], ADMIN_URL . '/start/index.php');
}

$form = new PreferencesForm($admin);

Alerts::ensureToastAssets();
I::loadPlugin('include/wbeSelect');
I::insertJsFile(ADMIN_URL . '/preferences/preferences.js', 'BODY BTM-');

// options as wbeSelect renders them; the language gets code badge and flag
$choices = [];
// the time zone in groups ('' = system default first, then suggestions and
// continents) with the country as search keyword
$values           = $form->values();
$defaultZone      = ['label' => '', 'zones' => ['' => ['label' => $form->options('timezone')[''], 'keywords' => '']]];
$choices['timezone'] = DateTimeFormat::timezoneRows(
    array_merge([$defaultZone], DateTimeFormat::timezoneGroups([$values['timezone']])),
    $values['timezone']
);
foreach (['language', 'date_format', 'time_format'] as $field) {
    foreach ($form->options($field) as $value => $label) {
        $choice = ['value' => (string) $value, 'label' => $label];
        if ($field === 'language') {
            $choice['right'] = (string) $value;
            $choice['left']  = WB_URL . '/languages/' . rawurlencode((string) $value) . '.svg';
        }
        $choices[$field][] = $choice;
    }
}

$admin->getThemeFile('preferences.twig', [
    'VALUES'         => $values,
    'CHOICES'        => $choices,
    'TOKEN'          => $admin->getIDKEY('preferences', 'preferences'),
    'SAVE_URL'       => ADMIN_URL . '/preferences/save.php',
    'PASSWORD_FIELD' => $admin->passwordField('new_password_1', 'new_password_2'),
]);

$admin->print_footer();
