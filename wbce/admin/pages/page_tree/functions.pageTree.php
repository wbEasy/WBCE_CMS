<?php

/*
 * @category        Pages Backend-Tool
 * @package         backend_pages
 * @author          Christian M. Stefan  <stefek@designthings.de>
 * @copyright       GPL v2 or any later (see LICENSE.md for details)
 */

/**
 * nestedPagesArray
 * 
 * @global object $database
 * @global object $admin
 * @param  int    $iParent
 * @return boolean|array 
 */
function nestedPagesArray($iParent = 0) {
    global $database, $admin;
    $iParent = intval($iParent);
    $sWhereClause = (PAGE_TRASH != 'inline') ? " WHERE `visibility` <> 'deleted'" : '';
    $sPageCode = isPageCodeUsed() ? "p.`page_code`, " : '';
    if (defined('WB_SHORTURL_ONELEVEL') && WB_SHORTURL_ONELEVEL == true) {
        $sPageCode .= 'p.`dlink,` ';
    }
    $sUseTrash = '';
    // prepare SQL Query, build the query string first	
    $sQuery = 'SELECT  s.`module`, MAX(s.`publ_start` + s.`publ_end`) published, p.`link`,'
            . '(SELECT MAX(`position`) FROM `{TP}pages` WHERE `parent` = p.`parent`) siblings, '
            . 'p.`position`, p.`page_id`, p.`parent`, p.`level`, p.`menu`, p.`language`, p.`admin_groups`, '
            . 'p.`admin_users`, p.`viewing_groups`, p.`viewing_users`, p.`visibility`, '
            . 'p.`menu_title`, p.`page_title`, p.`page_trail`, p.`description`, p.`keywords`, ' . $sPageCode
           
            // create json type of string of all the sections
            . 'GROUP_CONCAT(
                    CAST(
                      CONCAT(
                        \'"\', s.section_id, \'" : {\',
                        \'"module":"\', s.module, \'",\',  
                        \'"publ_start":"\', s.publ_start, \'",\', 
                        \'"publ_end":"\', s.publ_end, \'"}\'  
                      )
                    AS CHAR)
                  ) as `sections` '
            #            \'"block":"\', s.block, \'",\',
            #            \'"namesection":"\', s.namesection, \'"}\'  
            
            . 'FROM `{TP}pages` p '
            . 'INNER JOIN `{TP}sections` s '
            . 'ON p.`page_id`=s.`page_id` '
            . $sWhereClause . ' '
            . 'GROUP BY p.`page_id` '
            . 'ORDER BY p.`position` ASC';

    $oPages = $database->query($sQuery);
    $aPages = array();
    if (!$oPages)
        return $aPages; // no pages in DB yet; return empty array
    $refs = array();
    $aQueryKeys = array(
        'page_id', 'siblings', 'position', 'parent', 'menu_title', 'page_title', 'level', 'menu',
        'admin_groups', 'admin_users', 'position', 'module', 'visibility', 'language'
    );
    if (isPageCodeUsed()) {
        $aQueryKeys[] = 'page_code';
    }
    if (defined('WB_SHORTURL_ONELEVEL') && WB_SHORTURL_ONELEVEL == true) {
        $aQueryKeys[] = 'dlink';
    }
    while ($p = $oPages->fetchRow(MYSQLI_ASSOC)) {
        $thisref = &$refs[$p['page_id']];
        foreach ($aQueryKeys as $key) {
            $thisref[$key] = $p[$key];
        }
        $thisref['root_parent']   = isset($p['root_parent']) ? $p['root_parent'] : 0;
        $thisref['pageIDKEY']     = $admin->getIDKEY($p['page_id']);
        $thisref['frontend_link'] = PAGES_DIRECTORY . $p['link'] . PAGE_EXTENSION;
        $thisref['sections']      = '{'.preg_replace('/\s+/', '', $p['sections']).'}';

        // Admin Groups (get user permissions)
        $aAdminGroups = explode(',', str_replace('_', '', $p['admin_groups']));
        $admin_users  = explode(',', str_replace('_', '', $p['admin_users']));
        $bInGroup = false;
        foreach ($admin->get_groups_id() as $cur_gid) {
            if (in_array($cur_gid, $aAdminGroups))
                $bInGroup = true;
        }
        // check modify permissions
        $thisref['can_modify'] = false;
        if (($bInGroup) || is_numeric(array_search($admin->get_user_id(), $admin_users))) {
            if ($p['visibility'] == 'deleted') {
                $thisref['can_modify'] = (PAGE_TRASH == 'inline');
            } elseif ($p['visibility'] != 'deleted') {
                $thisref['can_modify'] = true;
            }
        } else {
            if ($p['visibility'] == 'private') {
                continue;
            } else {
                $thisref['can_modify'] = false;
            }
        }
        $thisref['canManageSections']  = ((MANAGE_SECTIONS == 'enabled' || MANAGE_SECTIONS == 1) && $admin->get_permission('pages_modify') == true && $thisref['can_modify'] == true);
        $thisref['pageIsMovable']      = ($admin->get_permission('pages_settings') == true && $thisref['can_modify'] == true);
        $thisref['pageIsMovable']      = ($thisref['pageIsMovable'] && $thisref['siblings'] != 1);
        $thisref['canDeleteAndModify'] = ($admin->get_permission('pages_delete') == true && $thisref['can_modify'] == true);
        $thisref['canAddChild']        = ($admin->get_permission('pages_add')) == (true && $thisref['can_modify'] == true) && ($thisref['visibility'] != 'deleted');
        $thisref['canModifyPage']      = ($admin->get_permission('pages_modify') == true && $thisref['can_modify'] == true);
        $thisref['canModifySettings']  = ($admin->get_permission('pages_settings') == true && $thisref['can_modify'] == true);
        $thisref['canMoveUP']          = (isset($thisref['pageIsMovable']) && $thisref['position'] != 1);
        $thisref['canMoveDOWN']        = (isset($thisref['pageIsMovable']) && $thisref['position'] != $thisref['siblings']);

        /**
         * sectionCase: we can have several conditions for the section ICON 
         * (clock, noclock, clock_red and menu_link)
         */
        $thisref['sectionCase'] = "noclock";
        if ($p['published'] != 0) {
            $thisref['sectionCase'] = ($admin->page_is_active($thisref)) ? "clock" : "clock_red";
        }
        if ($p['module'] == 'menu_link') {
            $thisref['sectionCase'] = "menu_link"; // menu_link doesn't display sections (it's a special case)
            $thisref['menu_link'] = true;
        }

        // reiterate the tree
        if ($p['parent'] == $iParent) {
            $aPages[$p['page_id']] = &$thisref;
        } else {
            $refs[$p['parent']]['children'][$p['page_id']] = &$thisref;
        }
        unset($p);
    }
    return $aPages;
}


/**
 * @global object $admin
 * @global object $database
 * @global type?? $field_set
 * @param  array  $nestedPagesArray
 * @param  int    $iCurrPageID
 * @param  bool   $bAllLevels
 * @return array
 */
function parentPageList($nestedPagesArray, $iCurrPageID = 0, $bAllLevels = false) {
    global $admin, $database, $field_set;
    $iParentId = $database->get_one("SELECT `parent` FROM `{TP}pages` WHERE `page_id` = " . $iCurrPageID);
    $sPageTrash = $database->get_one("SELECT `value`  FROM `{TP}settings` WHERE `name` = 'page_trash'");

    $aPages = array();
    foreach ($nestedPagesArray as $p) {
        // skip some pages where the user shouldn't have access		

        if ($iCurrPageID != 0 && $p['parent'] == $iCurrPageID)
            continue;
        if ($p['visibility'] == 'deleted' && $sPageTrash != 'inline')
            continue;
        if ($p['visibility'] == 'deleted')
            continue;
        #if ($p['visibility'] == 'none') continue;
        // get childs smaller than PAGE_LEVEL_LIMIT only!
        if ($p['level'] + 1 < PAGE_LEVEL_LIMIT || $bAllLevels == true) {

            // space_trail
            if (defined('DB_CHARSET') && DB_CHARSET == 'utf8') {
                $sSpacer = str_repeat(($p['level'] == 1 ? "&nbsp;" : "&nbsp;&nbsp;"), (($p['level']))) . (($p['level'] > 0) ? ($p['canMoveDOWN'] ? ' ├─ ' : ' └─ ') : ""
                        );
                $sSpacer = str_repeat("" . (($p['canMoveDOWN'] || $p['canMoveUP']) && $p['level'] != 0 ? '&nbsp;·&nbsp;' : '&nbsp;'), (($p['level']))) . (($p['level'] > 0) ? ($p['canMoveDOWN'] ? ' ├─ ' : ' └─ ') : " "
                        //  the characters should actually look like in the above line, however it didn't work well
                        //  wenn saved from NetBeans IDE.
                        //  Also the variants chr(195).chr(238).' ' : ' '.chr(192).chr(238)
                        //  and sprintf(" %c%c ", 195, 238) sprintf(" %c%c ", 192, 238) didn't work well
                        );
            } else {
                // fallback if charset is not UTF-8
                $sSpacer = str_repeat("&nbsp;", (($p['level']) * 2 * 2)) . (($p['level'] > 0) ? ($p['canMoveDOWN'] ? ' |-- ' : " '-- ") : ""
                        );
            }

            $aPages[$p['page_id']] = $p;
            $aPages[$p['page_id']]['space_trail'] = $sSpacer;
            $aPages[$p['page_id']]['icon'] = ($p['parent'] == 0 && $field_set ) ? $p['language'] : 'none';
            $aPages[$p['page_id']]['selected'] = ($p['page_id'] == $iParentId) ? ' selected="selected" ' : '';
            $aPages[$p['page_id']]['disabled'] = ($p['page_id'] == $iCurrPageID || $p['can_modify'] == false) ? ' disabled="disabled" ' : '';
            if (isset($p['children'])) {
                $aPages = array_merge($aPages, parentPageList($p['children'], $iCurrPageID, $bAllLevels));
            }
            unset($p);
        }
    }
    return($aPages);
}

// Parent page list
// $database = new database();
function oldstyle_parent_list($parent = 0, $iCurrPageID = 0, $bThreaded = false) {
    global $admin, $database, $field_set;
    $aPages = array();
    $query = "SELECT * FROM {TP}pages WHERE parent = '$parent' AND visibility!='deleted' ORDER BY position ASC";
    $get_pages = $database->query($query);

    $iParent = ($iCurrPageID != 0) ? $database->get_one("SELECT `parent` FROM `{TP}pages` WHERE `page_id` = " . $iCurrPageID) : NULL;

    while ($p = $get_pages->fetchRow()) {
        if ($admin->page_is_visible($p) == false)
            continue;
        #if (isset($iParent) && $p['parent'] == $iCurrPageID)  continue;
        // Stop users from adding pages with a level of more than the set p level limit
        if ($p['level'] + 1 < PAGE_LEVEL_LIMIT) {            
            // Title -'s prefix
            $sSpacer = '';
            for ($i = 1; $i <= $p['level']; $i++) {
                $sSpacer .= ' - ';
            }
            $aPages[] = array(
                'page_id' => $p['page_id'],
                'space_trail' => $sSpacer,
                'menu_title' => ($p['menu_title']),
                'page_title' => ($p['page_title']),
                'disabled' => '',
                'disabled' => ($p['page_id'] == $iCurrPageID || $p['parent'] == $iCurrPageID || userCanModifyPage($iCurrPageID) != true) ? ' disabled class="disabled"' : '',
                'selected' => (isset($iParent) && $p['page_id'] == $iParent) ? ' selected ' : '',
                'root_icon' => ($p['parent'] == 0 && $field_set) ? NULL : $p['language'],
                'childs' => oldstyle_parent_list($p['page_id'], $iCurrPageID)
            );
        }
    }

    if ($bThreaded != true) {
        // make the array a flat one
        $aFinal = array();
        foreach ($aPages as $p) {
            $aFinal[$p['page_id']] = $p;
            if ($p['childs']) {
                unset($aFinal[$p['page_id']]['childs']);
                foreach ($p['childs'] as $p) {
                    $aFinal[$p['page_id']] = $p;
                }
            }
        }
        $aPages = $aFinal;
    }
    return $aPages;
}


function userCanModifyPage($iPageID){
    global $database;
    $oCMS = isset($GLOBALS['wb']) ? $GLOBALS['wb'] : $GLOBALS['admin'];
    $bRetVal  = false;
    $bInGroup = false;
    
    $resGroups = $database->get_one('SELECT `admin_groups` FROM `{TP}pages` WHERE `page_id` = '.$iPageID);
    $resUsers  = $database->get_one('SELECT `admin_groups` FROM `{TP}pages` WHERE `page_id` = '.$iPageID);
    // Get user perms
    $aAdmGroups = explode(',', str_replace('_', '', $resGroups));
    $aAdmUsers  = explode(',', str_replace('_', '', $resUsers));
            
    foreach ($oCMS->get_groups_id() as $iCurrGroupID) {
        if (in_array($iCurrGroupID, $aAdmGroups)) {
            $bInGroup = true;
        }
    }
    if (($bInGroup) or is_numeric(array_search($oCMS->get_user_id(), $aAdmUsers))) {
        $bRetVal = true;
    }
    return $bRetVal;
}

/**
 * @param  array  $nestedPagesArray
 * @return array
 */
if (!function_exists('pageTreeCombobox')) {

    function pageTreeCombobox($nestedPagesArray, $iCurrPageID) {
        global $database;
        $aPages = array();
        $iParent = ($iCurrPageID != 0) ? $database->get_one("SELECT `parent` FROM `{TP}pages` WHERE `page_id` = " . $iCurrPageID) : NULL;
        foreach ($nestedPagesArray as $p) {
            $aPages[] = array(
                'page_id' => $p['page_id'],
                'menu_title' => drawSpacer($p) . $p['menu_title'],
                'menu' => $p['menu'],
                'page_title' => $p['page_title'],
                'level' => $p['level'],                
                'root_icon' => ($p['parent'] == 0 && (isset($field_set) && $field_set == true)) ? NULL : $p['language'],
                'language' => $p['language'],
                'visibility' => $p['visibility'],
                'disabled' => ($p['page_id'] == $iCurrPageID || $p['parent'] == $iCurrPageID || userCanModifyPage($iCurrPageID) != true) ? ' disabled="disabled" class="disabled"' : '',
                'selected' => (isset($iParent) && $p['page_id'] == $iParent) ? ' selected ' : '',
            );
            if (isset($p['children'])) {
                $aPages = array_merge($aPages, pageTreeCombobox($p['children'], $iCurrPageID));
            }
            unset($p);
        }
        return($aPages);
    }

}

if (!function_exists('drawSpacer')) {

    function drawSpacer($aPage) {
        $sSpacer = '';
        $iLevel = $aPage['level'];
        $aPage['canMoveDOWN'] = isset($aPage['canMoveDOWN']) ? $aPage['canMoveDOWN'] : false;
        // space_trail
        if (defined('DB_CHARSET') && DB_CHARSET == 'utf8') {

            $sSpacer = str_repeat(
                ($iLevel == 1 ? "&nbsp;" : "&nbsp;&nbsp;"), 
                (($iLevel))) . (($iLevel > 0) ? ($aPage['canMoveDOWN'] ? ' ├─ ' : ' └─ ') : ""
            );
        } else {

            // fallback if charset is not UTF-8
            $sSpacer = str_repeat(
                "&nbsp;", 
                (($iLevel) * 2 * 2)) . (($iLevel > 0) ? ($aPage['canMoveDOWN'] ? ' |-- ' : " '-- ") : ""
            );
        }
        return $sSpacer;
    }

}

/**
 * check whether or not we have the mod_multilingal installed
 * ==========================================================
 * 
 * @return bool
 */
if (!function_exists('isPageCodeUsed')) {

    function isPageCodeUsed() {
        $bUsePageCodes = false;
        if (is_file(WB_PATH . '/modules/mod_multilingual/update_keys.php')) {
            $bUsePageCodes = $GLOBALS['database']->field_exists('{TP}pages', 'page_code');
        }
        return $bUsePageCodes;
    }

}

/**
 * check whether or not we have the mod_multilingal installed
 * ==========================================================
 * 
 * @return bool
 */
if (!function_exists('isWysiwygHistoryUsed')) {

    function isWysiwygHistoryUsed() {
        $bUseHistory = false;
        if (is_file(WB_PATH . '/modules/mod_multilingual/update_keys.php')) {
            $bUseHistory = $GLOBALS['database']->field_exists('{TP}pages', 'page_code');
        }
        return $bUseHistory;
    }
    
}
