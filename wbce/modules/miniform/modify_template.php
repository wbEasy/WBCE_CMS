<?php
/**
 *
 * @category        modules
 * @package         miniform
 * @author          Ruud Eisinga / Dev4me
 * @link			http://www.dev4me.nl/modules-snippets/opensource/miniform/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.x
 * @requirements    PHP 5.6 and higher
 * @version         0.15.0
 * @lastmodified    April 30, 2019
 *
 */


require_once __DIR__.'/../../config.php';

$sLangPath = WB_PATH.'/modules/miniform/languages';
require_once($sLangPath.'/EN.php');
if(LANGUAGE != 'EN'){
	if(file_exists($sLangPath.'/'.LANGUAGE.'.php')) {
		require_once($sLangPath.'/'.LANGUAGE.'.php');
	}
}

// Include WB admin wrapper script
require WB_PATH.'/modules/admin.php';
// modules/admin.php has checked the page right and that $section_id belongs
// to the page; the key (issued by modify.php for this section) must match it.
// It used to travel in section_id itself, where modules/admin.php's intval()
// turned a key starting with digits into an unrelated section number.
$section_key = $admin->checkIDKEY('section_key', 0, 'GET', false, 'section');
$settings = $section_key
    ? $database->fetchRow("SELECT * FROM {TP}mod_miniform WHERE section_id = ?", [$section_id])
    : null;
if ((int) $section_key !== (int) $section_id || $settings === null) {
    $admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS']
	 .' (IDKEY) '.__FILE__.':'.__LINE__,
         ADMIN_URL.'/pages/index.php');
    $admin->print_footer();
    exit();
}
$remote = $settings['remote_id'];



require_once WB_PATH.'/framework/module.functions.php';

$backlink = ADMIN_URL.'/pages/modify.php?page_id='.(int)$page_id;
// section_id is the plain number modules/admin.php checks (page right, section on
// that page); the one-time key travels separately and must match it
$manage_url = WB_URL.'/modules/miniform/modify_template.php?page_id='.$page_id.'&section_id='.(int)$section_id
    .'&section_key='.$admin->getIDKEY($section_id, 'section').'&mt=1&name=';


require_once __DIR__ . '/functions.php';
$mform = new mForm();
$nwdata = '';
if(isset($_POST['remote'])) {
	$tmpremote = $_POST['remote'];
	if(stripos($tmpremote,'load=') !== false) {
		$tmpremote = substr($tmpremote,stripos($tmpremote,'load=')+5,32);
	}
	if(strlen($tmpremote) == 32) {
		$remote = $tmpremote;
		echo "<div class='mf-loading'>".$MF['LOADING'].": $remote</div>";
		$remotelink = 'https://miniform.dev4me.com/form-creator/?load='.$remote.'&clean';
		$nwdata = base64_decode($mform->remote_data($remotelink));
	}
	if(!$nwdata) {
		echo "<div class='mf-error'>".$MF['LOADERROR']."</div>";
	} else {
		$database->query("UPDATE `{TP}mod_miniform` SET `remote_id` = ? WHERE `section_id` = ?", [$remote, $section_id]);
		echo "<div class='mf-success'>".$MF['LOADSUCCESS']."</div>";
	}	
}

$_action = (isset($_POST['action']) ? $_POST['action'] : '');
$_action = ($_action != 'save' ? 'edit' : 'save');
if ($_action == 'save') {
	$template = $_POST['name'] ?? '';
	// the name becomes part of a file path (templates/form_<name>.htt)
	if (!miniform_valid_template_name($template)) {
		$admin->print_error($MF['INVALID_TEMPLATE_NAME'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
		$admin->print_footer();
		exit;
	}
	$data = $_POST['template_data'];
	$filename = dirname(__FILE__).'/templates/form_'.$template.'.htt';
	if (false !== file_put_contents($filename,$data)) {
		$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	} else { 
		$admin->print_error($TEXT['ERROR'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	}
} else {
	
	$template = $_GET['name'] ?? '';
	if (!miniform_valid_template_name($template)) {
		$template = '';
	}
	$filename = dirname(__FILE__).'/templates/form_'.$template.'.htt';
	$data = '';
	if ($template !== '' && file_exists($filename)) $data = file_get_contents($filename) ;
	if($nwdata) $data = $nwdata;
	echo registerEditArea ('code_area','html',true,'both',true,true,600,450,$toolbar = 'default');
	?>
	<form name="edit_module_file" action="<?=$manage_url.rawurlencode($template);?>" method="post" style="margin: 0;">
			<input type="hidden" name="page_id" value="<?=$page_id; ?>" />
			<input type="hidden" name="section_id" value="<?=$section_id; ?>" />
			<input type="hidden" name="action" value="save" />
			<span class="sleft"><?=$MF['SAVEAS']; ?>: </span><input required type="text" class="mf-input" name="name" value="<?=htmlspecialchars($template); ?>" pattern="[A-Za-z0-9 _()\-]{1,64}" title="<?=htmlspecialchars($MF['INVALID_TEMPLATE_NAME']); ?>" />
			<span style="float:right"><a class="mf-button" href="http://miniform.dev4me.nl/template-help/basic-structure/" target="_blank"><?=$MF['HELP']; ?></a></span>
			<span style="float:right"><a class="mf-button" href="http://miniform.dev4me.nl/form-creator/<?=$remote ? '?load='.$remote:''; ?>" target="_blank"><?=$MF['TPL_GEN']; ?></a></span>
			<span style="float:right"><a class="doremote mf-button" href="#" ><?=$MF['DOREMOTE']; ?></a></span>
			<div class="mf_editor">
			<br><br>
			<textarea id="code_area" name="template_data" cols="100" rows="25" wrap="VIRTUAL" style="margin:2px;width:100%;"><?=htmlspecialchars($data); ?></textarea>
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td class="left">
					<input name="save" type="submit" value="<?=$TEXT['SAVE'];?>" style="width: 100px; margin-top: 5px;" />
					</td>
					<td class="right">
					<input type="button" value="<?=$TEXT['CANCEL']; ?>"
							onclick="javascript: window.location = '<?=ADMIN_URL;?>/pages/modify.php?page_id=<?=$page_id; ?>';"
							style="width: 100px; margin-top: 5px;" />
					</td>
				</tr>
			</table>
			</div>
	</form>
	<div class="mf_remote" style="display:none;">
		<br><br>
		<form name="load_remote" action="<?=$manage_url.rawurlencode($template);?>" method="post" > 
			<input type="hidden" name="page_id" value="<?=$page_id; ?>" />
			<input type="hidden" name="section_id" value="<?=$section_id; ?>" />
			<span class="sleft"><?=$MF['REMOTE']; ?>: </span><input type="text" class="mf-input" name="remote" value="<?=$remote; ?>" />
			<input class="mf-button" name="load" type="submit" value="<?=$MF['LOAD'];?>" style="width: 100px; margin-top: 5px;" />
			<input class="mf-button" type="button" value="<?=$TEXT['CANCEL']; ?>"
								onclick="javascript: window.location = '<?=ADMIN_URL;?>/pages/modify.php?page_id=<?=$page_id; ?>';"
								style="width: 100px; margin-top: 5px;" />

			
		</form>
		<?php if($remote) { ?>
		<br>
		<span class="sleft">&nbsp;</span><a class="mf-button" href="http://miniform.dev4me.nl/form-creator/?load=<?=$remote ?>" target="_blank"><?=$MF['EDITREMOTE'];?></a><br>
		<?php } ?>

	</div>
	<?php 
}
?>
<script>
$(function() {
	
	$(".doremote").click(function(){
		$(".mf_editor").toggle();
		$(".mf_remote").toggle();
	});

});
</script>
<?php
$admin->print_footer();

