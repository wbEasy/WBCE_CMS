<?php
/*      Drag'N'Drop Position
**/

$aJsonRespond = array();
$aJsonRespond['success'] = false;
$aJsonRespond['message'] = '';
$aJsonRespond['icon'] = '';


if (!isset($_POST['action']) || !isset($_POST['post_id']) && !isset($_POST['group_id']) && !isset($_POST['img_id'])) {
    $aJsonRespond['message'] = 'one of the parameters does not exist';
    exit(json_encode($aJsonRespond));
} else {
    require_once('../../../config.php');
    // check if user has permissions to access the news_img module
    require_once(WB_PATH.'/framework/class.admin.php');
    $admin = new admin('Pages', 'pages_modify', false, false);
    if (!($admin->is_authenticated() && $admin->get_permission('news_img', 'module'))) {
        $aJsonRespond['message'] = 'insuficcient rights';
        exit(json_encode($aJsonRespond));
    }

    // Sanitize variables
    $action = $admin->add_slashes($_POST['action']);
    if ($action == "updatePosition") {
        require_once dirname(__DIR__) . '/functions.inc.php';

        // Each list is redeemed with the purpose of its rows, and every row
        // must belong to one news_img section on a page the user may
        // administrate (images: to one post). All of it is checked before
        // anything is written, so a bad entry leaves the order untouched.
        $aLists = array(
            //  POST field   purpose   table                  id column   descending
            'post_id'  => array('post',  'mod_news_img_posts',  'post_id',  true),
            'group_id' => array('group', 'mod_news_img_groups', 'group_id', false),
            'img_id'   => array('image', 'mod_news_img_img',    'id',       false),
        );
        $aUpdates = array();
        foreach ($aLists as $sField => $aList) {
            list($sPurpose, $sTable, $sIdCol, $bDescending) = $aList;
            if (!isset($_POST[$sField])) {
                continue;
            }
            $aIds = array();
            foreach ((array) $_POST[$sField] as $recID) {
                $id = defined('CAT_PATH')
                    ? intval($recID)
                    : intval($admin->checkIDKEY((string) $recID, 0, 'key', true, $sPurpose));
                if ($id <= 0) {
                    $aJsonRespond['message'] = 'invalid value';
                    exit(json_encode($aJsonRespond));
                }
                $aIds[] = $id;
            }
            $aSections = array();
            $aPosts    = array();
            foreach ($aIds as $id) {
                $aSections[mod_nwi_owner_section($sPurpose, $id)] = true;
                if ($sPurpose === 'image') {
                    $aPosts[(int) $database->fetchValue(
                        "SELECT `post_id` FROM `{TP}mod_news_img_img` WHERE `id` = ?", array($id)
                    )] = true;
                }
            }
            $iSection = (int) key($aSections);
            if (count($aSections) !== 1 || $iSection === 0 || !mod_nwi_may_manage_section($iSection)
                || ($sPurpose === 'image' && count($aPosts) !== 1)) {
                $aJsonRespond['message'] = 'insuficcient rights';
                exit(json_encode($aJsonRespond));
            }
            $aUpdates[] = array($sTable, $sIdCol, $aIds, $bDescending);
        }

        foreach ($aUpdates as $aUpdate) {
            list($sTable, $sIdCol, $aIds, $bDescending) = $aUpdate;
            $i = $bDescending ? count($aIds) : 1;
            foreach ($aIds as $id) {
                $database->query(
                    "UPDATE `{TP}" . $sTable . "` SET `position` = ? WHERE `" . $sIdCol . "` = ?",
                    array($i, $id)
                );
                $i += $bDescending ? -1 : 1;
            }
        }
        if ($database->hasError()) {
            $aJsonRespond['success'] = false;
            $aJsonRespond['message'] = 'db query failed: '.$database->getError();
            $aJsonRespond['icon'] = 'cancel.gif';
            exit(json_encode($aJsonRespond));
        }
    } else {
        $aJsonRespond['message'] = 'wrong arguments "$action"';
        exit(json_encode($aJsonRespond));
    }

    $aJsonRespond['icon'] = 'ajax-loader.gif';
    $aJsonRespond['message'] = 'seems everything is fine';
    $aJsonRespond['success'] = true;
    exit(json_encode($aJsonRespond));
}
