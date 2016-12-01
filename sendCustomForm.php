<?
//var_dump($_POST);die;
//var_dump($_FILES);die;
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
if(!isset($_POST['formID']) || intval($_POST['formID']) <= 0)
	die;
	
$formID = intval($_POST['formID']);

if(isset($_GET['lang']))
	$SITE_LANG[selected] = substr(urlencode($_GET['lang']),0,2);

include_once("config.inc.php");
include_once("inc/CustomForm.inc.php");
include_once("inc/Mobile_Detect.php");
$mobileDetect=new Mobile_Detect();
$db = new database();

if(!$form = getFormByID($formID))
	die;
	
$antiSpamSys = ($form['antiSpam'] == '1');

$recievers = unserialize($form['recievers']);
if(!is_array($recievers) || count($recievers) == 0)
	$recievers = array($SITE['FromEmail']);
if ($recievers[0]=="" OR $recievers[0]=="info@mysite.co.il") $recievers=array("websites@exite.co.il");
	
$inputs = getFormInputs($formID);

$errs = array();
$FROM_REC=array();
$FROM_REC=explode(",",$SITE['FromEmail']);

$from_mail = $SITE['name']." <".$FROM_REC[0].">";

$has_files = false;
$found_captcha = false;

foreach($_POST as $key => $v)
{
	if(substr_count($key, '_question_') == 1)
		$found_captcha = true;
}

if(!$found_captcha && $antiSpamSys)
	die;

if(is_array($inputs) && count($errs) == 0)
{
	foreach($inputs as $input)
	{
		switch($input['inputType'])
		{
			default:
				if($input['mandatory']==1 && ($_POST['input_'.$input['inputID']] == '' || $_POST['input_'.$input['inputID']] == 'novalue'))
				{
					$errmsg = ($input['mandatoryError'] != '') ? $input['mandatoryError'] : $translations[$SITE_LANG['selected']]['please_fill'].' '.$input['inputName'];
					$errs[] = $errmsg;
					$err_input_name[]='input_'.$input['inputID'];
				}
				else
				{
					if($input['inputType'] == 'radio' || $input['inputType'] == 'select')
					{
						//$recievers
						$inputReceivers = unserialize($input['receivers']);
						if(is_array($inputReceivers) && !empty($inputReceivers))
						{
							foreach($inputReceivers as $receiver)
								if(md5($receiver['option']) == md5($_POST['input_'.$input['inputID']]))
								{
									$recs = explode("\n",$receiver['receivers']);
									foreach($recs as $rec)
									{
										$rec = trim($rec);
										$recievers[] = $rec;
									}
								}
						}
					}
				}
				break;
			case 'file':
				$has_files = true;
				if($input['mandatory']==1 && ($_POST['input_'.$input['inputID']] == '' || substr($_POST['input_'.$input['inputID']],0,5) == 'error'))
				{
					$errmsg = ($input['mandatoryError'] != '') ? $input['mandatoryError'] : $translations[$SITE_LANG['selected']]['please_fill'].' '.$input['inputName'];
					$errs[] = $errmsg;
				}
				else
				{
					if($_POST['input_'.$input['inputID']] == '' || substr($_POST['input_'.$input['inputID']],0,5) == 'error')
						$_POST['input_'.$input['inputID']] = '';
					else
						$_POST['input_'.$input['inputID']] = $SITE[url].'/gallery/form_files/'.$_POST['input_'.$input['inputID']];
				}	
				break;
			case 'checkbox':
				if($input['mandatory']==1 && (!is_array($_POST['input_'.$input['inputID']]) || count($_POST['input_'.$input['inputID']]) == 0))
				{
					$errmsg = ($input['mandatoryError'] != '') ? $input['mandatoryError'] : $translations[$SITE_LANG['selected']]['please_fill'].' '.$input['inputName'];
					$errs[] = $errmsg;
				}
				break;
		}
		if($input['isSenderMail'] == 1 && $_POST['input_'.$input['inputID']] != '')
		{
			$from_mail = $_POST['input_'.$input['inputID']];
			if(is_array($from_mail))
				$from_mail = $from_mail[0];
			if($from_mail != '')
			{
				if(!validEmail($from_mail))
				{
					$errmsg = $translations[$SITE_LANG['selected']]['email_is_invalid'].' '.$input['inputName'];
					$errs[] = $errmsg;
				}
			}
		}
		
	}
}

foreach($_POST as $key => $v)
{
	if(substr_count($key, '_question_') == 1)
	{
		$ex = explode('_question_',$key);
		$q_index = intval($ex[1]);
		if(!checkAnswer($q_index,$v))
			$errs[] = $translations[$SITE_LANG['selected']]['wrong_answer'];
	}
}
if(file_exists('sites/'.$SITE['S3_FOLDER'].'/sendCustomFormBeforeCheck.php'))
{
	require_once('sites/'.$SITE['S3_FOLDER'].'/sendCustomFormBeforeCheck.php');
}
if(count($errs) == 0)
{
	if(file_exists('sites/'.$SITE['S3_FOLDER'].'/sendCustomFormPreportion.php'))
	{
		require_once('sites/'.$SITE['S3_FOLDER'].'/sendCustomFormPreportion.php');
	}
	$recievers = array_unique($recievers);
	$emailsubj = $form['formName'];
	if($form['subject'] != '')
		$emailsubj = $form['subject'];
	if ($emailsubj=="") $emailsubj=$SITE[name];
	$curdate=date('d/m/Y');
	if ($SITE_LANG[selected]=="en") $curdate=date('m/d/Y');
	$headers ="From: ".$SITE['name']." <".$SITE['FromEmail'].">\n";
	$headers.="Reply-To: ".$SITE['FromEmail']."\n";
	$headers.="Return-Path: ".$SITE['FromEmail']."\n";
	$headers.="Date: ".date('d M Y H:i:s')."\n";
	$headers.="MIME-Version: 1.0\n"; 
	$plainHeader=$headers."Content-type: text/plain;charset=utf-8"."\n";
	$headers.="Content-type: text/html; charset=utf-8."."\n";
	$generalBodyHead="<html>";
	$generalBodyHead.="<head></head>";
	$fullmessage = "<div dir='".$SITE_LANG['direction']."' style='font-family:arial;background-color:#efefef;dir:rtl;align:right;text-align:".$SITE['align']."'>".$curdate."\n<br>";
	$fullmessagePlain = $curdate."\n";
	if(is_array($inputs))
	{
		foreach($inputs as $input)
		{
			switch($input['inputType'])
			{
				default:
					$fullmessage .= $input['inputName'].": ".$_POST['input_'.$input['inputID']]."\n<br/>";
					$fullmessagePlain .= $input['inputName'].": ".$_POST['input_'.$input['inputID']]."\n";
					break;
				case 'file':
					$fullmessage .= $input['inputName'].": ";
					if($_POST['input_'.$input['inputID']] != '')
						$fullmessage .= "<a href=\"".$_POST['input_'.$input['inputID']]."\">".$translations[$SITE_LANG['selected']]['download_attachment']."</a>";
					$fullmessage .= "\n<br/>";
					$fullmessagePlain .= $input['inputName'].": ".$_POST['input_'.$input['inputID']]."\n";
					break;
				/* case 'file':
					if(@$_FILES['input_'.$input['inputID']]['tmp_name'] != '')
					{
						$flname = time().'_'.$_FILES['input_'.$input['inputID']]['name'];
						move_uploaded_file($_FILES['input_'.$input['inputID']]['tmp_name'], 'gallery/form_files/'.$flname);
						$fullmessage .= $input['inputName'].": ".$SITE[url].'/gallery/form_files/'.$flname."\n<br/>";
						$fullmessagePlain .= $input['inputName'].": ".$SITE[url].'/gallery/form_files/'.$flname."\n";
					}
					$fullmessage .= $input['inputName'].": ".$SITE[url].'/gallery/form_files/'.$_POST['input_'.$input['inputID']]."\n<br/>";
					$fullmessagePlain .= $input['inputName'].": ".$SITE[url].'/gallery/form_files/'.$_POST['input_'.$input['inputID']]."\n";
					break; */
				case 'title':
					break;
				case 'hidden':
					$fullmessage .= $input['inputName']."\n<br/>";
					$fullmessagePlain .= $input['inputName']."\n";
					break;
				case 'checkbox':
					$fullmessage .= $input['inputName'].": ";
					$fullmessagePlain .= $input['inputName'].": ";
					if(is_array(@$_POST['input_'.$input['inputID']]))
					{
						foreach($_POST['input_'.$input['inputID']] as $val)
						{
							$fullmessage .= $val.'; ';
							$fullmessagePlain .= $val.'; ';
						}
					}
					$fullmessage .= "\n<br/>";
					$fullmessagePlain .= "\n";
					break;
			}
		}
	}	
	
	if(isset($_POST['from_uri']) && $_POST['from_uri'] != '')
	{
		$fullmessage .= '<br/><br/>'.$translations[$SITE_LANG['selected']]['sent_from_here'].':<br/>'.urldecode($_POST['from_uri']);
		if ($mobileDetect->isMobile()) {
			$fullmessage.='<br/>'.$translations[$SITE_LANG['selected']]['sent_from_mobile'];
			$mobileData=1;
		}
	}	
	$generalBodyFoot.="<br><hr size=1 width=100% color=#efefef></div>";
	$generalBodyFoot.="</html>";
	$fullmessagePlain.="…………………………………………………………………………………………………………." ;
	$emailbody=$fullmessagePlain;
	if(is_array($recievers)) {
		if (!$sendRecieversTogether==1) {
			foreach($recievers as $recipient) {
				$res=sendHTMLemail($recipient,$emailsubj,$from_mail,$fullmessage);
				}
			}
			else {

				$one_recievers=implode(",", $recievers);
				$res=sendHTMLemail($one_recievers,$emailsubj,$from_mail,$fullmessage);
			}
	}
	
	if($form['saveFormData'] == '1')
		saveFormData($form['formID'],$_POST,$mobileData);
	$pre = '';
	$after = '';
	if(file_exists('sites/'.$SITE['S3_FOLDER'].'/sendCustomFormAddition.php'))
	{
		$pre = "setTimeout('";
		$after = "',2500);";
		require_once('sites/'.$SITE['S3_FOLDER'].'/sendCustomFormAddition.php');
	}
	echo '<script type="text/javascript">';
	//if($has_files)
	//	echo 'window.parent.Placeholder.init({normal:"#'.$form['inputTextColor'].'"});window.parent.';
	echo $pre.'submitSuccess();'.$after.'</script>';
}
else
{
	
	echo '<script type="text/javascript">';
	//foreach($errs as $err)
	//	echo "alert('{$err}!');";
	echo "alert('".htmlspecialchars(array_shift($errs))."!');";
	echo "jQuery('#".$err_input_name[0]."').focus();";
	echo '</script>';
}

function sendHTMLemail($to, $subject, $from, $body) {
	require_once 'inc/PHPMailerAutoload.php';
	global $SITE;
	$recips=explode(",", $to);
	$body = stripslashes($body);
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = 'email-smtp.eu-west-1.amazonaws.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->SMTPAuth = true;
	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "AKIAI524PJFHZLBK4FQQ";
	//Password to use for SMTP authentication
	$mail->Password = "Akza4RlpzI6A35ti4kZl2IETBDDyP+k6zl6E35O8tpOv";
	$mail->setFrom('no-reply@exitetogo.com', $SITE[name]);
	$mail->addReplyTo($from);
	//Set who the message is to be sent to
	if (is_array($recips)) {
		foreach ($recips as $recip) {
			$mail->addAddress($recip);
		}
	}
	else $mail->addAddress($to);
	$mail->Subject = $subject;
	$msgHTML=$body;
	$mail->msgHTML($msgHTML);
     if (!$results=$mail->send()) print $mail->ErrorInfo;
    else return $results;
}

?>