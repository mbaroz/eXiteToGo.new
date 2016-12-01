<?
$inc_dir="../../";
session_start();
include_once("../../config.inc.php");
include_once("../../inc/GetServerData.inc.php");
include_once("../lang.admin.he.inc.php");
include_once("../lang.admin.php");
$mainRef="http://".$_SERVER['HTTP_HOST'];
$MAIN['locked_account']="You are currently locked out. Please wait at least 10 minutes";
if ($SITE_LANG['selected']=="he") $MAIN['locked_account']="חשבונך ננעל זמנית עקב נסיונות כולשים רבים להיכנס לאתר. נסה שוב בעוד 10 דקות";

if ($_POST['mainRef'] OR $_GET['mainRef']) die();
$mainRef="http://".$_SERVER['HTTP_HOST'];
if (stristr($SITE[url],"https://")) $mainRef="https://".$_SERVER['HTTP_HOST'];
if($mainRef!=$SITE[url]) die();
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
	require_once '../../inc/PHPMailerAutoload.php';
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
	
	$mail->addAddress($to);
	$mail->Subject = $subject;
	$msgHTML=$body;
	$mail->msgHTML($msgHTML);
     if (!$results=$mail->send()) print $mail->ErrorInfo;
    else return $results;
}
function SendResetedPass($e,$newPass) {
	global $SITE_LANG;
	global $SITE;
	$recipient=$e;
	$fromaddr="noreply@exite.co.il";
	$subject="Password reset";
	$curdate=date('d/m/Y');
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
	בקשתך לשחזור סיסמה התקבלה במערכת וסיסמתך החדשה היא:
	".$newPass."<br>...........................................................................<br>
	לכניסה לממשק ניהול האתר לחץ  על הקישור הבא או העתק והדבק אותו בשורת הכתובת בדפדפן<br>".$SITE[url]."/Admin"
	."<br>"
	."לאחר כניסתכם עם סיסמה זו תוכלו לשנות את סיסמתכם בהגדרות כלליות ובחירת שינוי סיסמה בתפריט העליון";
	$generalBodyFoot="<br><hr size=1 width=100% color=#efefef></div>";
	$generalBodyFoot.="</html>";
	$fullmessageBODY=$generalBodyHead.$fullmessage.$generalBodyFoot;
	sendHTMLemail($recipient,$subject,$fromaddr,$fullmessageBODY);
	
}
function get_real_ip()
{
	if (isset($_SERVER["HTTP_CLIENT_IP"]))
		return $_SERVER["HTTP_CLIENT_IP"];
	elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
		return $_SERVER["HTTP_X_FORWARDED"];
	elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
		return $_SERVER["HTTP_FORWARDED_FOR"];
	elseif (isset($_SERVER["HTTP_FORWARDED"]))
		return $_SERVER["HTTP_FORWARDED"];
	else
		return $_SERVER["REMOTE_ADDR"];
}

function getIP()
{
	$ip = get_real_ip();
	$ex = explode(',',$ip);
	return $ex[0];
}

function LoggedIn($uID,$e) {
	global $RET_URL;
	global $SITE;
	global $MEMBER;
	global $LOGGED_ADMIN;
	$LOGGED_ADMIN=$LOGGED=uniqid("A#a",25).session_id();
	if(!isset($_SESSION['LOGGED_ADMIN'])) $_SESSION['LOGGED_ADMIN']=$LOGGED_ADMIN;
	$MEMBER=GetAdminDetails($uID);
	if(!isset($_SESSION['MEMBER'])) $_SESSION['MEMBER']=$MEMBER;
	print session_id().$e;
}
function CheckCredentials($e,$p) {
	global $MAIN;
	$bad_login_limit = 3;
	$lockout_time = 600;
	unset($_SESSION['authKey']);
	$db=new Database();
	$db->query("SELECT * from admins where Email='$e'");
	if ($db->nextRecord()) {
		$FAIL_DATA=json_decode($db->getField("FAILS"),true);
		$failed_login_count=$FAIL_DATA['failed_login_count'];
		$first_failed_login=$FAIL_DATA["first_failed_login"];
		if(
		    ($failed_login_count >= $bad_login_limit)
		    &&
		    (time() - $first_failed_login < $lockout_time)
		) {
		  print $MAIN['locked_account'];
		  die();
		}
	}
	$db->query("SELECT * from admins where Email='$e' AND Passwd='$p'");
	$c_ip=getIP();
	if ($db->nextRecord()) {
		
		$uid=$db->getField("UID");
		$db->query("update admins SET LoginCount=LoginCount+1, IP='{$c_ip}' WHERE UID=$uid");
		$curMsg="";
		LoggedIn($uid,$e);
	}
	else {
		$db->query("SELECT * from admins where Email='$e'");
		if ($db->nextRecord()) {
			$uid=$db->getField("UID");

			$FAIL_DATA=json_decode($db->getField("FAILS"),true);
			$failsCount=$FAIL_DATA["count"]+1;
			$failDate=date("Y-M-d H:i:s");
			$first_failed_login=$FAIL_DATA["first_failed_login"];
			$failed_login_count=$FAIL_DATA["failed_login_count"];
			 if( time() - $first_failed_login > $lockout_time ) {
				$first_failed_login = time(); // commit to DB
			    $failed_login_count = 1; // commit to db
			  } 
			  else $failed_login_count++; // commit to db.
			  
			 
			$failDate=date("Y-M-d H:i:s");
			$failed_data=array(
				"count"=>$failsCount,
				"lastTry"=>$failDate,
				"first_failed_login"=>$first_failed_login,
				"failed_login_count"=>$failed_login_count
				);
			$db_failed_data=json_encode($failed_data);
			$db->query("update admins SET FAILS='{$db_failed_data}',IP='{$c_ip}' WHERE UID=$uid");
		}
		print $MAIN[login][3];
	}
	
} //End Check Cred

if ($_POST['isReset']==1) {
	$newPlainPass=createRandomPassword();
	$newSecurePass=sha1($newPlainPass);
	$db=new Database();
	$db->query("SELECT Email from admins WHERE Email='$e'");
	if ($db->nextRecord()) {
		$db->query("UPDATE admins SET Passwd='$newSecurePass' WHERE Email='$e'");
		SendResetedPass($e,$newPlainPass);
		print "resetOK";
	}
	die();
}

if ($_POST['e']) {
	$_SESSION['se']=$se=$_POST['e'];
	
}
$sp=sha1($_POST['p']);
if (isset($_POST['auth']) AND isset($_SESSION['se']) AND $_POST['p']) CheckCredentials($se,$sp);
?>