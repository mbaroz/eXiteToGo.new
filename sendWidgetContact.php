<?
session_start();
//include_once("inc/class.phpmailer.php");
if ($SITE_LANG[selected]=="en") {
	$CONTACT_LABELS=array("Full Name", "Phone Number", "Email","Message","Date","Newsletter subscriber");
	$CONTACT_ERR=array("Please enter a valid email address", "Phone number is not valid", "Please enter a valid full name");
	
}
else {
	$CONTACT_LABELS=array("שם מלא", "טלפון", "אימייל","הודעה","תאריך","הרשמה לניוזלטר");
	$CONTACT_ERR=array("יש לרשום כתובת אימייל חוקית", "מספר טלפון לא תקין", "שם מלא לא תקין");

}


if (strlen($_POST['fullname'])>50 OR strlen($_POST['fullname'])<3) die("<font color='red'>".$CONTACT_ERR[2]."</font>");
if (strlen($_POST['phne'])>12 OR strlen($_POST['phne'])<8) die("<font color='red'>".$CONTACT_ERR[1]."</font>");
if (strlen($_POST['eml'])>50 OR strlen($_POST['eml'])<6) die("<font color='red'>".$CONTACT_ERR[0]."</font>");
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


function sendContactFrm($sid) {
	global $SITE;
	global $SITE_LANG;
	global $CONTACT_LABELS;
	$recipient=$SITE[FromEmail];
	 $fullname  = $_POST['fullname'];
	$phone     = $_POST['phne'];
	$emailaddr = $_POST['eml'];
	$remarks   = $_POST['c_details'];
	$newsletter   = $_POST['newsletter'];
	if ($newsletter==1) $remarks.="<br>".$CONTACT_LABELS[5];
	$emailsubj = $SITE[name]." - Contact";
		// extra info to add to message
	$curdate=date('d/m/Y');
	if ($SITE_LANG[selected]=="en") $curdate=date('m/d/Y');
	$headers ="From: ".$SITE[name]."<".$emailaddr.">\n";
	$headers.="Reply-To:".$emailaddr."\n";
//	$headers.="To: ".$recipient."\n";
	$headers.="Return-Path: ".$SITE[FromEmail]."\n";
	$headers.="Date: ".date('d M Y H:i:s')."\n";
	$headers.="MIME-Version: 1.0\n"; 
		$plainHeader=$headers."Content-type: text/plain;charset=utf-8"."\n";
	$headers.="Content-type: text/html; charset=utf-8."."\n";
	$generalBodyHead="<html>";
	$generalBodyHead.="<head></head>";
	$fullmessage = "<div dir='".$SITE_LANG[direction]."' style='font-family:arial;background-color:#efefef;dir:rtl;align:right;text-align:".$SITE[align]."'>".$CONTACT_LABELS[4].": ".$curdate."\n<br>"
	.$CONTACT_LABELS[2].": <br>".$emailaddr."\n<br>"
	.$CONTACT_LABELS[0]." : <br>".$fullname."\n<br>"
	.$CONTACT_LABELS[1]." : <br>".$phone."\n<br>"
	.$CONTACT_LABELS[3]." : <br>".$remarks."\n<br>";
	
	$generalBodyFoot.="<br><hr size=1 width=100% color=#efefef></div>";
	$generalBodyFoot.="</html>";
	$fullmessagePlain=$CONTACT_LABELS[4].": ".$curdate."\n"
	.$CONTACT_LABELS[2].": ".$emailaddr."\n"
	.$CONTACT_LABELS[0].": ".$fullname."\n"
	.$CONTACT_LABELS[1].": ".$phone."\n"
	.$CONTACT_LABELS[3].": ".$remarks."\n"
	."........................................................................................................................." ;
	$emailbody=$fullmessagePlain;
	print $sid;
	$res=sendHTMLemail($recipient,$emailsubj,$emailaddr,$fullmessage);

}
sendContactFrm(session_id());
?>