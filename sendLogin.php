<?
$inc_dir="";
session_start();
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
$LOGIN_LABEL=array("Members Sign In","User name","Password","Login","User or password is incorrect","You dont have permission to this page","We sent you a mail to reset your password, please check your mail and your junk mail folder.","Email/User does not exists in the system","Your confirmed password does not match","Password changed succesfully, please Login with your new password.","Your password is too short, make sure it contain at least 5 charactes");
if ($SITE_LANG[selected]=="he") {
	$LOGIN_LABEL=array("כניסה למשתמשים רשומים","שם משתמש","סיסמה","כניסה","שם משתמש או סיסמה שגויים","אין לך הרשאות לעמוד זה","נשלחה אליך הודעת מייל להמשך איפוס הסיסמה. אנא בדוק את תיבת הדואר נכנס או תיקיית דואר זבל.","כתובת אימייל אינה קיימת במערכת","אימות הסיסמה אינו תואם את הסיסמה שקבעת, אנא תקן/י","סיסמתך שונתה בהצלחה, <a href=''>לחצו כאן</a> לחזרה למסך הכניסה","הסיסמה קצרב מדיי,אנא וודאו שהיא כוללת לפחות 5 תווים");
}
function createRandomPassword() { 
	$chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
	srand((double)microtime()*1000000); 
	$i = 0; 
	$pass = '' ; 
	while ($i <= 7) { 
	    $num = rand() % 33; 
	    $tmp = substr($chars, $num, 1); 
	    $pass = $pass . $tmp; 
	    $i++; 
	} 
	return $pass; 
}
function sendHTMLemail($to, $subject, $from, $body) { 

	if (preg_match("(.*)< (.*)>", $from, $regs)) {
	   $from = '=?UTF-8?B?'.base64_encode($regs[1]).'?= < '.$regs[2].'>';
	} else {
	   $from = $from;
	}

	    $headers = "From: $from\r\n";
	    $headers .= "MIME-Version: 1.0\r\n";
	    $boundary = uniqid("HTMLEMAIL");
	    $headers .= "Content-Type: multipart/alternative;".
	                "boundary = $boundary\r\n\r\n";
	    $headers .= "This is a MIME encoded message.\r\n\r\n";
	    $headers .= "--$boundary\r\n".
	                "Content-Type: text/plain; UTF-8\r\n".
	                "Content-Transfer-Encoding: base64\r\n\r\n";
	    $headers .= chunk_split(base64_encode(strip_tags($body)));
	    $headers .= "--$boundary\r\n".
	                "Content-Type: text/html; charset=UTF-8\r\n".
	                "Content-Transfer-Encoding: base64\r\n\r\n";
	    $headers .= chunk_split(base64_encode($body)); 
	
	    $result = mail($to,'=?UTF-8?B?'.base64_encode($subject).'?=',"",$headers);
	    return $result;
}
function SendResetedPass($e,$hashCode) {
	global $SITE_LANG;
	global $SITE;
	$recipient=$e;
	$fromaddr="noreply@exite.co.il";
	$subject="Password reset";
	$curdate=date('d/m/Y');
	$generatedLink=$SITE[url]."/pages/login&p_r=".$hashCode;
	if ($SITE_LANG[selected]=="en") $curdate=date('m/d/Y');
	$headers ="From: ".$SITE[name]."<".$fromaddr.">\n";
	$headers.="Reply-To:".$fromaddr."\n";
	$headers.="Return-Path: ".$SITE[FromEmail]."\n";
	$headers.="Date: ".date('d M Y H:i:s')."\n";
	$headers.="MIME-Version: 1.0\n"; 
	$plainHeader=$headers."Content-type: text/plain;charset=utf-8"."\n";
	$headers.="Content-type: text/html; charset=utf-8."."\n";
	$generalBodyHead="<html>";
	$generalBodyHead.="<head></head>";
	$fullmessage = "<div dir='".$SITE_LANG[direction]."' style='font-family:arial;background-color:#efefef;dir:rtl;align:right;text-align:".$SITE[align]."'>".$curdate."\n<br>"
	."שלום. <br>
	בקשתך לאיפוס סיסמה התקבלה במערכת <br><br>על מנת לאפס את סיסמתך עליך להקליק על הקישור הבא ולקבוע סיסמה חדשה:
	<br>

	".$generatedLink."<br>...........................................................................<br>	
	לאחר שינוי הסיסמה תוכלו לחזור ולהיכנס למערכת עם הסיסמה שקבעתם";
	$generalBodyFoot="<br><hr size=1 width=100% color=#efefef></div>";
	$generalBodyFoot.="</html>";
	$fullmessageBODY=$generalBodyHead.$fullmessage.$generalBodyFoot;
	sendHTMLemail($recipient,$subject,$fromaddr,$fullmessageBODY);
	
}
function authenticate($u,$p,$secureCID) {
	global $LOGIN_LABEL;
	unset($_SESSION['USER_LOGGEDIN']);
	$db=new Database();
	$db->query("SELECT * from users where Email='$u' AND Passwd='$p'");
	if ($db->nextRecord()) {
		$uid=$db->getField("UID");
		$email=$db->getField("Email");
		$isCategoryPemmitted=$db->getField("CategoryPerms");
		if ($isCategoryPemmitted==1 AND !GetResolvedPerms($uid,$secureCID)) die($LOGIN_LABEL[5]);
		$db->query("update users SET LoginCount=LoginCount+1 WHERE UID=$uid");
		print session_id();
		//if (GetResolvedPerms($uid,$secureCID)) session_register('USER_LOGGEDIN_'.sha1($uid));
		global $USER_LOGGEDIN;
		global $USER_LOGGED;
		$USER_LOGGEDIN=sha1($uid);
		$USER_LOGGED[uid]=$uid;
		$USER_LOGGED[email]=$email;
		$_SESSION['USER_LOGGEDIN']=$USER_LOGGEDIN;
		$_SESSION['USER_LOGGED']=$USER_LOGGED;
	}
	else print $LOGIN_LABEL[4];
}
$usr=$_POST['usr'];
$actionType="";
if ($_POST['actionType']) $actionType=$_POST['actionType'];
if ($actionType=="resetPass") {
	$db=new Database();
	$db->query("SELECT Email from users WHERE Email='$usr'");
	if ($db->nextRecord()) {
		$newHashPassChange=sha1($db->getField("Email"));
		$db->query("UPDATE users SET PasswdChange='$newHashPassChange' WHERE Email='$usr'");
		SendResetedPass($usr,$newHashPassChange);
		print $LOGIN_LABEL[6];
	}
	else print $LOGIN_LABEL[7];
	die();
}
if ($actionType=="changePassNow" AND $_POST['passwd']) {
	if ($_POST['passwd']!=$_POST['passwd_confirm']) die($LOGIN_LABEL[8]);
	if (strlen($_POST['passwd'])<5) die($LOGIN_LABEL[10]);
	$db=new Database();
	$hash=sha1($usr);
	$db->query("SELECT Email from users WHERE Email='$usr' AND PasswdChange='{$hash}'");
	if ($db->nextRecord()) {
		$newSecuredPass=sha1($_POST['passwd']);
		$db->query("UPDATE users SET Passwd='{$newSecuredPass}', PasswdChange='' WHERE Email='{$usr}' AND PasswdChange='{$hash}'");
		print $LOGIN_LABEL[9];
		die();
	}
}
$passwd=sha1($_POST[passwd]);
authenticate($usr,$passwd,$scid);
?>