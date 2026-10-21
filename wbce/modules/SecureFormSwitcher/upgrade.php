<?php
/**
 * @category        modules
 * @package         More Security Settings (SecureFormSwitcher)
 * @author          WBCE Project
 * @copyright       Norbert Heimsath
 * @license         WTFPL
 */

//no direct file access
if (count(get_included_files())==1) {
    header("Location: ../index.php", true, 301);
}

$msg = '';

// Del old switch as now there is only one.
Settings::delete("secure_form_module");

// 1.4.0: fingerprinting and the secret rotation time are gone from SecureForm
Settings::delete("wb_secform_usefp");
Settings::delete("fingerprint_with_ip_octets");
Settings::delete("wb_secform_secrettime");

// 1.4.0: the form moved to twig/tool.twig and the cp_chrome layout
$obsoleteFilesAndDirs = [
    '/templates',    // sfs.tpl.php (old table layout)
    '/backend.css',  // tooltip styles of the old layout
];
foreach ($obsoleteFilesAndDirs as $rec) {
    $signal = removePath(__DIR__ . $rec);
    // L_(), not $SIGNAL: upgrade.php runs in function scope (see droplets/upgrade.php)
    echo L_("SIGNAL['$signal']", $rec) . '<br>';
}

$setError = Settings::set("wb_session_timeout", WB_SECFORM_TIMEOUT);
