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

if (!defined('WB_URL')) {
    header('Location: ../../../index.php');
    exit(0);
}

// Define that this file is loaded
if (!defined('DATE_FORMATS_LOADED')) {
    define('DATE_FORMATS_LOADED', true);
}

// Create array
$DATE_FORMATS = array();

// Now, in the user's zone if required, else the system default's; the
// examples show names in the page language ("Samstag, 1. August, 2026").
$actual_time = new DateTimeImmutable('now', new DateTimeZone(
    (isset($user_time) && $user_time == true) ? TIMEZONE_NAME : DEFAULT_TIMEZONE_NAME
));

// Add values to list — keys: the format with '|' for spaces (array keys);
// formats without names get the order as a hint: "01.08.2026 (D.M.Y)"
foreach (DateTimeFormat::DATE_FORMATS as $sFormat) {
    $sExample = DateTimeFormat::format($actual_time, $sFormat);
    $DATE_FORMATS[str_replace(' ', '|', $sFormat)] = preg_match('/[DlFMS]/', $sFormat)
        ? $sExample
        : $sExample . ' (' . strtr($sFormat, ['d' => 'D', 'm' => 'M']) . ')';
}

// Add "System Default" to list (if we need to)
if (isset($user_time) && $user_time == true) {
    global $TEXT;
    $DATE_FORMATS['system_default'] = DateTimeFormat::format($actual_time, DEFAULT_DATE_FORMAT) . ' (' . $TEXT['SYSTEM_DEFAULT'] . ')';
}

// Reverse array so "System Default" is at the top
$DATE_FORMATS = array_reverse($DATE_FORMATS, true);

if (!function_exists('getDateFormatsArray')) {

    /**
     * @brief  Returns an array of date formats set up by the system
     *         This function will return an array that can be used
     *         to display all the date formats or in order to create
     *         a select box to choose from.
     *
     * @param array $DATE_FORMATS
     * @return array
     */
    function getDateFormatsArray($DATE_FORMATS)
    {
        $aDateFormats = array();
        $i = 0;
        foreach ($DATE_FORMATS as $sFormat => $sTitle) {
            $sFormat = str_replace('|', ' ', $sFormat); // Adds white-spaces (not able to be stored in array key)

            $aDateFormats[$i]['VALUE'] = ($sFormat != 'system_default') ? $sFormat : '';
            $aDateFormats[$i]['NAME'] = $sTitle;

            $aDateFormats[$i]['SELECTED'] = false;
            if (DATE_FORMAT == $sFormat && !isset($_SESSION['USE_DEFAULT_DATE_FORMAT'])) {
                $aDateFormats[$i]['SELECTED'] = true;
            } elseif ($sFormat == 'system_default' && isset($_SESSION['USE_DEFAULT_DATE_FORMAT'])) {
                $aDateFormats[$i]['SELECTED'] = true;
            }
            $i++;
        }
        return $aDateFormats;
    }
}
