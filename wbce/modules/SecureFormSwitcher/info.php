<?php
/**
 * @category        modules
 * @package         More Security Settings (SecureFormSwitcher)
 * @author          WBCE Project
 * @copyright       Norbert Heimsath
 * @license         WTFPL
 */

$core = true;
$module_directory   = 'SecureFormSwitcher';
$module_name        = 'More Security Settings';
$module_function    = 'tool';
$module_version     = '1.4.0';
$module_platform    = '1.1.0';
$module_author      = 'Norbert Heimsath (heimsath.org), Christian M. Stefan';
$module_license     = 'GPLv2 or any later';
$module_description = 'This tool provides some additional security settings';
$module_icon        = 'fa fa-lock';

/**
 * Version history
 * 1.4.0 - remove the fingerprinting switch and the IP-blocks setting: the
 *         switch never took effect, and a browser/IP fingerprint cannot
 *         protect a CSRF token in principle (see framework/SecureForm.php)
 *       - remove "Secrettime": the secret no longer rotates, form token
 *         lifetime is now the new setting "Form token max. age"
 *         (wb_secform_ftan_maxage, default 28800 s)
 *       - session timeout is validated to 60-86400 (SecureForm ignored
 *         larger values silently) and labelled as what it is
 *       - upgrade.php removes the obsolete settings rows
 *       - uninstall.php used the non-existent Settings::del()
 *       - a missing or invalid FTAN only printed an error, the settings were
 *         saved anyway (print_error(..., false) does not exit)
 *       - new layout: twig/tool.twig on the cp_chrome settings layout (as
 *         CodeMirror_Config), save/reset via post-redirect-get with toasts,
 *         hints below the fields instead of hover tooltips; templates/ and
 *         backend.css removed (upgrade.php deletes them)
 *
 * 1.3.5 - set $core var, remove deprecated $module_level var
 * 
 * 1.3.4 - use Settings::set("wb_secform_secret", bin2hex(random_bytes(12)));
 *             to avoid having a known secret token in use on live installations
 *         adopt new PSR-4 method names of class Settings
 * 
 * 1.3.3 - cs fixed files
 *
 * 1.3.2 - Add module_level core status
 *
 * 1.3.1 - Add Add Admintool Icon
 *
 **/
