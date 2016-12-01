<?php
$partner_id='shalom';
$partner_email='emai';

setcookie("partner_details", $partner_id, time() + (86400 * 30)); // 86400 = 1 day
setcookie("partner_email_details", $partner_email, time() + (86400 * 30)); // 86400 = 1 day

 echo  $_COOKIE["partner_details"];
 echo  $_COOKIE["partner_email_details"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>


</body>
</html>