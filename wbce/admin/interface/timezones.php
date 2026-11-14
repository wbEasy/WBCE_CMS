<?php
/**
 * WBCE CMS
 * Way Better Content Editing.
 * Visit https://wbce.org to learn more and to join the community.
 *
 * Time zone choices: $TIMEZONES = [zone name => "Europe/Berlin (UTC+01:00)"].
 *
 * Since 1.7.0 the values are IANA zone names, not hours: settings and users
 * store the name; TIMEZONE / DEFAULT_TIMEZONE stay seconds (initialize.php).
 * With $user_time set (a user's own choice), the list starts with '' = the
 * system default.
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
if (!defined('TIMEZONES_LOADED')) {
    define('TIMEZONES_LOADED', true);
}

// The current values stay selectable even when they are Etc zones (the
// upgrade writes those; PHP's zone list leaves them out).
$TIMEZONES = DateTimeFormat::timezoneChoices([
    DEFAULT_TIMEZONE_NAME,
    defined('TIMEZONE_NAME') ? TIMEZONE_NAME : '',
]);

// "System default" at the top (a user's own choice only)
if (isset($user_time) && $user_time == true) {
    global $TEXT;
    $TIMEZONES = ['' => $TIMEZONES[DEFAULT_TIMEZONE_NAME] . ' (' . ($TEXT['SYSTEM_DEFAULT'] ?? 'System default') . ')']
               + $TIMEZONES;
}

if (!function_exists('getTimeZonesArray')) {

    /**
     * @brief  The choices as rows for a select: [['VALUE', 'NAME', 'SELECTED',
     *         'KEYWORDS', 'GROUP_START'?, 'GROUP_END'?], …] — in groups
     *         (suggestions, continents; DateTimeFormat::timezoneGroups()).
     *         GROUP_START (the heading) opens an <optgroup>, GROUP_END closes
     *         it; KEYWORDS (the country) belongs in data-keywords for the
     *         search. Templates that ignore the three get a flat list.
     *
     * @param array            $TIMEZONES only its '' entry (system default) is used
     * @param string|bool|null $selected  the zone to mark; anything but a
     *                                    string = the current user's own
     *                                    ('' when they use the system default
     *                                    and the list offers it). A zone that
     *                                    is not in the list is added to the
     *                                    suggestions.
     * @return array
     */
    function getTimeZonesArray($TIMEZONES, $selected = null)
    {
        if (!is_string($selected)) {
            $selected = (isset($TIMEZONES['']) && !empty($_SESSION['USE_DEFAULT_TIMEZONE']))
                ? ''
                : (defined('TIMEZONE_NAME') ? TIMEZONE_NAME : '');
        }
        $groups = DateTimeFormat::timezoneGroups([$selected, DEFAULT_TIMEZONE_NAME]);
        if (isset($TIMEZONES[''])) {
            array_unshift($groups, ['label' => '', 'zones' => ['' => ['label' => $TIMEZONES[''], 'keywords' => '']]]);
        }

        $aTimeZones = [];
        foreach (DateTimeFormat::timezoneRows($groups, $selected) as $row) {
            $rec = [
                'VALUE'    => $row['value'],
                'NAME'     => $row['label'],
                'SELECTED' => $row['selected'],
                'KEYWORDS' => $row['keywords'],
            ];
            if (isset($row['group_start'])) $rec['GROUP_START'] = $row['group_start'];
            if (isset($row['group_end']))   $rec['GROUP_END']   = true;
            $aTimeZones[] = $rec;
        }
        return $aTimeZones;
    }
}
