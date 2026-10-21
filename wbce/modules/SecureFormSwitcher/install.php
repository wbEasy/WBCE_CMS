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

$setError = Settings::set("wb_secform_secret", bin2hex(random_bytes(12)));
$setError = Settings::set("wb_secform_timeout", '7200');
$setError = Settings::set("wb_session_timeout", '7200');
$setError = Settings::set("wb_secform_ftan_maxage", '28800');
$setError = Settings::set("wb_secform_tokenname", 'formtoken');
$msg = '';
