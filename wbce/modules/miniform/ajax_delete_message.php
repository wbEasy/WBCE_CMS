<?php

// initialize json_respond array  (will be sent back)
$aJsonRespond = array();
$aJsonRespond['message'] = 'Nothing to do!';
$aJsonRespond['success'] = false;

// require config for initialisation.
require '../../config.php';

require_once(WB_PATH.'/framework/class.admin.php');
require_once __DIR__ . '/functions.php';
$admin = new admin('Pages', 'pages_modify', false, false);

if (!$admin->is_authenticated()) {
	$aJsonRespond['message'] = 'insufficient rights';
	die(json_encode($aJsonRespond));
}
// the token travels in the POST body (see messages_loop.php)
if (!$admin->checkFTAN()) {
	$aJsonRespond['message'] = 'Security offense! Access denied!';
	die(json_encode($aJsonRespond));
}

// check for the iRecordID parameter. Preventing warnings in the errorlogs
if(!isset($_POST['iRecordID']) || is_array($_POST['iRecordID'])) die(json_encode($aJsonRespond));

$iRecordID = intval($_POST['iRecordID']);

// only submissions of a form the user may manage (any message_id was
// deletable by any user with modules_view before)
$iSectionID = (int) $database->fetchValue(
	"SELECT `section_id` FROM `{TP}mod_miniform_data` WHERE `message_id` = ?", [$iRecordID]
);
if ($iRecordID > 0 && !miniform_may_manage_section($admin, $iSectionID)) {
	$aJsonRespond['message'] = 'insufficient rights';
	die(json_encode($aJsonRespond));
}

if($iRecordID > 0) {
	// excecute query
	$database->deleteRow('{TP}mod_miniform_data', 'message_id', $iRecordID);
	// test for errors
	if($database->hasError()) {
		$aJsonRespond['message'] = 'Deleting record failed!';
	} else {
		$aJsonRespond['message'] = 'Record deleted successfully!';
		$aJsonRespond['success'] = true;
	}
}
// return json data
die(json_encode($aJsonRespond));

