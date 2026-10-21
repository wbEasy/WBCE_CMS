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

 $setError = Settings::delete("wb_secform_secret");
 $setError = Settings::delete("wb_secform_timeout");
 $setError = Settings::delete("wb_secform_ftan_maxage");
 $setError = Settings::delete("wb_secform_tokenname");

$msg = 'Secureform switcher setting deleted, now you need to use config.php again ';
