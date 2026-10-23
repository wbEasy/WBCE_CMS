<?php
/**
 *
 * @category        modules
 * @package         news_img
 * @author          WBCE Community
 * @copyright       2004-2009, Ryan Djurovich
 * @copyright       2009-2010, Website Baker Org. e.V.
 * @copyright       2019-, WBCE Community
 * @link            https://www.wbce.org/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WBCE
 *
 */

require_once __DIR__.'/functions.inc.php';

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');
$group_id = $admin->checkIDKEY('group_id', 0, 'GET');
if (!$group_id){
    $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS']
	 .' (IDKEY) '.__FILE__.':'.__LINE__,
         ADMIN_URL.'/pages/index.php');
    $admin->print_footer();
    exit();
}
// The object must belong to the section modules/admin.php has checked
if (!mod_nwi_group_in_section($group_id, $section_id)) {
    mod_nwi_refuse($page_id);
}

$database->query("UPDATE `".TABLE_PREFIX."mod_news_img_posts` SET `group_id` = '0' where `group_id`='$group_id'");
// Update row
$database->query("DELETE FROM `".TABLE_PREFIX."mod_news_img_groups` WHERE `group_id` = '$group_id'");
// Check if there is a db error, otherwise say successful
if($database->is_error()) {
	$admin->print_error($database->get_error(), ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&tab=g');
} else {
	$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&tab=g');
}

// Print admin footer
$admin->print_footer();
