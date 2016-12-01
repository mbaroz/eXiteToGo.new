<?php
include_once("../Admin/AmazonUtil.php");

function saveFormData($formID,$data,$isMobile=0)
{
	global $db;
	if(!is_object($db))
		$db = new database();
	$db->query("INSERT INTO `custom_forms_history`(`date`,`formID`,`data`,`fromMobile`) VALUES(NOW(),'{$formID}','".addslashes(serialize($data))."', '{$isMobile}')");
}
function updateFormHistory($histID,$data)
{
	global $db;
	if(!is_object($db))
		$db = new database();
	$db->query("update `custom_forms_history` SET  data='".addslashes(serialize($data))."' WHERE id={$histID}");
}
function getFormByUrlKey($urlKey)
{
	global $db;
	if(!is_object($db))
		$db = new database();
	$db->query("
		SELECT
			`custom_forms`.*
		FROM
			`custom_forms`
		LEFT JOIN
			`categories` USING(`CatID`)
		WHERE
			`categories`.`UrlKey`='{$urlKey}'
	");
	if($db->nextRecord())
	{
		return $db->record;
	}
	return false;
}


function getFormByID($formID)
{
	global $db;
	if(!is_object($db))
		$db = new database();
	$db->query("
		SELECT
			*
		FROM
			`custom_forms`
		WHERE
			`formID`='{$formID}'
	");
	if($db->nextRecord())
	{
		return $db->record;
	}
	return false;
}

function createBlankForm($urlKey,$CatID = 0)
{
	global $SITE_LANG, $db, $AWS_S3_ENABLED;
	if(!is_object($db))
		$db = new database();
		
	if($CatID == 0)
	{
		$db->query("SELECT `CatID` FROM `categories` WHERE `UrlKey`='{$urlKey}'");
		if(!$db->nextRecord())
			return false;
		$CatID = $db->getField('CatID');
	}
	$db->query("SELECT `successMsg`,`recievers`,`bgColor`,`borderColor`,`textColor`,`textSize`,`inputBgColor`,`inputTextColor`,`inputBorderColor`,`mandatoryTextColor`,`roundCorners`,`successUrl`,`inputWidth`,`inputHeight`,`clearText`,`sendText`,`submitWidth`,`submitHeight`,`buttonFontSize`,`buttonsRoundCorners`,`buttonsBgColor`,`buttonsTextColor`,`subject`,`buttonFile`,`placeholders`,`buttonsBorderColor`,`inputRoundedCorners`,`inputALine`,`inputBottomMargin`,`saveFormData`,`antiSpam` FROM `custom_forms` WHERE `defaultSettings` = '1'");
	if($db->nextRecord())
	{
		$default = $db->record;
		$buttonFile = '';
		if($default['buttonFile'] != '')
		{
			$fl_data = unserialize($default['buttonFile']);
			$ex = explode('.',$fl_data['file']);
			$ext = array_pop($ex);
			$buttonFile = uniqid().'.'.$ext;
			if(CheckForFile("",'gallery/sitepics/'.$fl_data['file']))
			{
				if($AWS_S3_ENABLED){
					UploadToAmazon('gallery/sitepics/'.$fl_data['file'],'gallery/sitepics/'.$buttonFile);
				}
				else{
					copy('gallery/sitepics/'.$fl_data['file'],'gallery/sitepics/'.$buttonFile);
				}
				$fl_data['file'] = $buttonFile;
				$buttonFile = serialize($fl_data);
			}
		}


		$db->query("INSERT INTO `custom_forms` SET
		`catID`='{$CatID}',
		`successMsg`='".addslashes($default['successMsg'])."',
		`recievers`='{$default['recievers']}',
		`bgColor`='{$default['bgColor']}',
		`borderColor`='{$default['borderColor']}',
		`textColor`='{$default['textColor']}',
		`textSize`='{$default['textSize']}',
		`inputBgColor`='{$default['inputBgColor']}',
		`inputTextColor`='{$default['inputTextColor']}',
		`inputBorderColor`='{$default['inputBorderColor']}',
		`roundCorners`='{$default['roundCorners']}',
		`successUrl`='{$default['successUrl']}',
		`inputWidth`='{$default['inputWidth']}',
		`inputHeight`='{$default['inputHeight']}',
		`clearText`='".addslashes($default['clearText'])."',
		`sendText`='".addslashes($default['sendText'])."',
		`submitWidth`='{$default['submitWidth']}',
		`submitHeight`='{$default['submitHeight']}',
		`buttonFontSize`='{$default['buttonFontSize']}',
		`buttonsRoundCorners`='{$default['buttonsRoundCorners']}',
		`buttonsBgColor`='{$default['buttonsBgColor']}',
		`buttonsTextColor`='{$default['buttonsTextColor']}',
		`subject`='".addslashes($default['subject'])."',
		`buttonFile`='{$buttonFile}',
		`placeholders`='{$default['placeholders']}',
		`buttonsBorderColor`='{$default['buttonsBorderColor']}',
		`mandatoryTextColor`='{$default['mandatoryTextColor']}',
		`inputRoundedCorners`='{$default['inputRoundedCorners']}',
		`inputALine`='{$default['inputALine']}',
		`inputBottomMargin`='{$default['inputBottomMargin']}',
		`saveFormData`='{$default['saveFormData']}',
		`antiSpam`='{$default['antiSpam']}'
		");
	}
	else
		$db->query("INSERT INTO `custom_forms`(`catID`,`saveFormData`) VALUES({$CatID},'1')");
	$ret = array('formID' => mysql_insert_id(),'CatID'=>$CatID);
	if(!empty($default))
		$ret = array_merge($ret,$default);
	return $ret;
}

function getFormInputs($formID,$antiSpam = false)
{
	global $db,$translations,$SITE_LANG,$antiSpamSys;
	if(!is_object($db))
		$db = new database();
	$ret = array();
	$db->query("SELECT * FROM `custom_form_inputs` WHERE `formID` = '{$formID}' ORDER BY `order` ASC");
	while($db->nextRecord())
		$ret[] = $db->record;
	if($antiSpam && $antiSpamSys)
	{
		$q_index = getRandomQuestion();
		$ret[] = array(
			'inputID' => 'question_'.$q_index,
			'inputType' => 'text',
			'inputName' => $translations[$SITE_LANG['selected']]['questions'][$q_index],
			'mandatory' => 1,
		);
	}
	return $ret;
}

function getRandomQuestion()
{
	global $translations,$SITE_LANG;
	$index = rand(0,count($translations[$SITE_LANG['selected']]['questions'])-1);
	return $index;
}

function checkAnswer($index,$answer)
{
	global $translations,$SITE_LANG;
	return in_array(strtolower($answer),$translations[$SITE_LANG['selected']]['answers'][$index]);
}

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}

$translations = array(
	'he' => array(
		'go_to_form' => 'עבור לעמוד הטופס',
		'email_is_invalid' => 'יש להזין כתובת אימייל תקינה: ',
		'download_attachment' => 'להורדת הקובץ המצורף',
		'send' => 'שלח',	 
		'please_wait' => 'אנא המתן...',
		'please_fill' => 'יש למלא',
		'sent_from_here' => 'נשלח מעמוד זה',
		'wrong_file_format' => 'העלת קובץ מסוג אסור בשדה: ',
		'wrong_answer' => 'תשובה שגויה לשאלת הבדיקה. נסו שוב.',
		'anti_spam' => 'על מנת למנוע ספאם עליכם לרשום את התשובה לשאלה זו',
		'sent_from_mobile' => 'נשלח מאתר המובייל',
		'questions' => array(
			'כמה זה אחד פלוס אחד?',
			'כמה זה שלוש כפול שתיים?',
			'כמה זה חמש מינוס ארבע?',
			'כמה זה עשר חלקי שתיים?',
			'כמה זה ארבע פלוס שלוש?',
		),
		'answers' => array(
			array('2','שתיים','שניים'),
			array('6','שש','שישה','ששה','שיש'),
			array('1','אחת','אחד'),
			array('5','חמשה','חמש','חמישה'),
			array('7','שבעה','שבע'),
		),
	),
	'en' => array(
		'go_to_form' => 'Go to the form',
		'email_is_invalid' => 'Please fill a valid email address:',
		'download_attachment' => 'Download attachment',
		'send' => 'Send',
		'please_wait' => 'Please wait...',
		'please_fill' => 'You have to fill',
		'sent_from_here' => 'Sent from this page',
		'wrong_file_format' => 'You have uploaded a forbidden file type at field: ',
		'wrong_answer' => 'Wrong answer on anti-spam question',
		'anti_spam' => 'You have to answer this question for anti-spam purposes',
		'sent_from_mobile' => 'Sent from Mobile Device',
		'questions' => array(
			'How much is one plus one?',
			'How much is two minus one?',
			'How much is three times two?',
			'How much is four times one?',
			'How much is five plus two?',
		),
		'answers' => array(
			array('2','two'),
			array('1','one'),
			array('6','six'),
			array('4','four'),
			array('7','seven'),
		),
	)
);

$antiSpamSys = false;

?>