<?
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("AmazonUtil.php");
if (!isset($_SESSION['LOGGED_ADMIN']))
	die;

require_once('lang.admin.php');

$db=new Database();

$action = (isset($_POST['action'])) ? $_POST['action'] : $_GET['action'];
switch($action)
{
	case 'saveFreeText':
		$freeText = urldecode($_POST['freeText']);
		$db->query("
			UPDATE
				`custom_form_inputs`
			SET
				`inputValues`='".addslashes($freeText)."'
			WHERE
				`inputID` = '{$_POST['inputID']}'
		");
		break;
	case 'saveReceivers':
		$receivers = array();
		foreach(@$_POST['options'] as $i => $option)
		{
			$receivers[] = array('option' => urldecode($option),'receivers' => urldecode(@$_POST['receivers'][$i]));
		}
		$receivers = serialize($receivers);
		$db->query("
			UPDATE
				`custom_form_inputs`
			SET
				`receivers`='".addslashes($receivers)."'
			WHERE
				`inputID` = '{$_POST['inputID']}'
		");
		break;
	case 'saveForm':
		$recievers = '';
		if($_POST['recievers'] != '')
		{
			$recs = array();
			$ex = explode("\n",$_POST['recievers']);
			foreach($ex as $rec)
				if(trim($rec) != '')
					$recs[] = trim($rec);
			$recievers = serialize($recs);
		}
		$_POST['successUrl'] = str_replace($SITE['media'].'/','',$_POST['successUrl']);
		$_POST['successUrl'] = str_replace($SITE['media'],'',$_POST['successUrl']);
		$_POST['successUrl'] = str_replace($SITE['url'].'/','',$_POST['successUrl']);
		$_POST['successUrl'] = str_replace($SITE['url'],'',$_POST['successUrl']);
		
		if($_POST['successMsg'] == '')
			$_POST['successMsg'] = $ADMIN_TRANS['your request was successfully sent, thank you.'];
			
		if(!isset($_POST['roundCorners']))
			$_POST['roundCorners'] = 0;
		if(!isset($_POST['inputALine']))
			$_POST['inputALine'] = 0;
		if(!isset($_POST['buttonsRoundCorners']))
			$_POST['buttonsRoundCorners'] = 0;
		
		$buttonFile = '';
		
		if($_POST['buttonFile'] != '')
		{
			rename('uploader/uploads/'.$_POST['buttonFile'],'../gallery/sitepics/'.$_POST['buttonFile']);
			$size = getimagesize('../gallery/sitepics/'.$_POST['buttonFile']);
			$filedata = array('file' => $_POST['buttonFile'],'width' => $size[0],'height' => $size[1]);
			$btfldata = serialize($filedata);
			$buttonFile = ",`buttonFile`='{$btfldata}'";
		}
		$defaultSettings = '';
		if(isset($_POST['defaultSettings']))
		{
			$defaultSettings = ",`defaultSettings`='{$_POST['defaultSettings']}'";
			if($_POST['defaultSettings'] == 1)
				$db->query("UPDATE `custom_forms` SET `defaultSettings`='0'");
		}
		
		$db->query("
			UPDATE
				`custom_forms`
			SET
				`formName`='{$_POST['formName']}',
				`successMsg`='{$_POST['successMsg']}',
				`successUrl`='{$_POST['successUrl']}',
				`sendText`='{$_POST['sendText']}',
				`clearText`='{$_POST['clearText']}',
				`inputWidth`='{$_POST['inputWidth']}',
				`inputHeight`='{$_POST['inputHeight']}',
				`submitWidth`='{$_POST['submitWidth']}',
				`submitHeight`='{$_POST['submitHeight']}',
				`buttonFontSize`='{$_POST['buttonFontSize']}',
				`textSize`='{$_POST['textSize']}',
				`titleSize`='{$_POST['titleSize']}',
				`buttonsRoundCorners`='{$_POST['buttonsRoundCorners']}',
				`inputRoundedCorners`='{$_POST['inputRoundedCorners']}',
				`bgColor`='{$_POST['bgColor']}',
				`borderColor`='{$_POST['borderColor']}',
				`textColor`='{$_POST['textColor']}',
				`mandatoryTextColor`='{$_POST['mandatoryTextColor']}',
				`inputBgColor`='{$_POST['inputBgColor']}',
				`inputTextColor`='{$_POST['inputTextColor']}',
				`inputBorderColor`='{$_POST['inputBorderColor']}',
				`buttonsBgColor`='{$_POST['buttonsBgColor']}',
				`buttonsTextColor`='{$_POST['buttonsTextColor']}',
				`roundCorners`='{$_POST['roundCorners']}',
				`inputALine`='{$_POST['inputALine']}',
				`inputBottomMargin`='{$_POST['inputBottomMargin']}',
				`subject`='{$_POST['subject']}',
				`placeholders`='{$_POST['placeholders']}',
				`buttonsBorderColor`='{$_POST['buttonsBorderColor']}',
				`saveFormData`='{$_POST['saveFormData']}',
				`antiSpam`='{$_POST['antiSpam']}',
				`recievers`='{$recievers}'{$buttonFile}{$defaultSettings}
			WHERE
				`formID`='{$_POST['formID']}'
		");
		
		if(@$_GET['iframe'] == 1)
		{
		?>
		<script type="text/javascript">
			window.top.document.location.reload();
		</script>
		<?
		}
		break;
	case 'delButtonFile':
		global $AWS_S3_ENABLED;
		if(isset($_POST['del_buttonFile']))
		{
			$db->query("
				UPDATE
					`custom_forms`
				SET
					`buttonFile` = ''
				WHERE
					`formID`='{$_POST['formID']}'
			");
			if($AWS_S3_ENABLED){
				DeleteImageFromAmazon("/".$gallery_dir."/sitepics/".$_POST['del_buttonFile']);
			}
			else{
				unlink('../gallery/sitepics/'.$_POST['del_buttonFile']);
			}
		}
		break;
	case 'saveInput':
		$values = '';
		if($_POST['inputValues'] != '')
		{
			$vals = array();
			$ex = explode("\n",$_POST['inputValues']);
			foreach($ex as $val)
				if(trim($val) != '')
					$vals[] = str_replace(array('&','"','\'','<','>',"\t",),array('&amp;','&quot;','&#039;','&lt;','&gt;','&nbsp;&nbsp;'),trim($val));
			$values = serialize($vals);
			$values = str_replace('\\','\\\\',$values);
		}
		if($_POST['isSubject'] == 1)
			$db->query("UPDATE `custom_form_inputs` SET `isSubject`='0' WHERE `formID`='{$_POST['formID']}'");
		if($_POST['isSenderMail'] == 1)
			$db->query("UPDATE `custom_form_inputs` SET `isSenderMail`='0' WHERE `formID`='{$_POST['formID']}'");
		if($_POST['inputID'] > 0)
		{
			$inputValues = "`inputValues`='{$values}',";
			if($_POST['inputType'] == 'title')
				$inputValues = '';
			$db->query("
				UPDATE
					`custom_form_inputs`
				SET
					`inputName`='{$_POST['inputName']}',
					`inputType`='{$_POST['inputType']}',
					`inputDefValue`='{$_POST['inputDefValue']}',
					{$inputValues}
					`mandatoryError`='{$_POST['mandatoryError']}',
					`mandatory`='{$_POST['mandatory']}',
					`isSenderMail`='{$_POST['isSenderMail']}',
					`boldLabel`='{$_POST['boldLabel']}',
					`maxLength`='{$_POST['maxLength']}',
					`minTableWidth`='{$_POST['minTableWidth']}',
					`maxTableWidth`='{$_POST['maxTableWidth']}'
				WHERE
					`inputID` = '{$_POST['inputID']}'
			");
		}
		else
		{
			$q_order = $db->query("SELECT MAX(`order`)+1 AS `order` FROM `custom_form_inputs` WHERE `formID`='{$_POST['formID']}'");
			if($db->nextRecord())
				$neworder = $db->getField('order');
			else
				$neworder = 1;
			$db->query("
				INSERT INTO
					`custom_form_inputs`
				SET
					`formID`='{$_POST['formID']}',
					`inputName`='{$_POST['inputName']}',
					`inputType`='{$_POST['inputType']}',
					`inputDefValue`='{$_POST['inputDefValue']}',
					`inputValues`='{$values}',
					`mandatoryError`='{$_POST['mandatoryError']}',
					`mandatory`='{$_POST['mandatory']}',
					`isSenderMail`='{$_POST['isSenderMail']}',
					`boldLabel`='{$_POST['boldLabel']}',
					`order` = '{$neworder}',
					`maxLength`='{$_POST['maxLength']}'
			");
		}
		break;
	case 'saveOrder':
		foreach($_POST['short_cell'] as $i => $inputID)
			$db->query("UPDATE `custom_form_inputs` SET `order`='{$i}' WHERE `inputID`='{$inputID}'");
		break;
	case 'delInput':
		$db->query("DELETE FROM `custom_form_inputs` WHERE `inputID`='{$_POST['inputID']}'");
		break;
}

?>