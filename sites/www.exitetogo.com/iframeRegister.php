<?
include_once("../../config.inc.php");
?>
<html>
<head>
	<title></title>
	<script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
<script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="register.js"></script>
<style type="text/css">
body {margin:0;padding: 0;font-family: arial}
.registerForm {
	width:100%;
}
.registerForm form {padding:0;margin:0;}
.registerForm input {width:250px;height: 35px;outline: none;padding:3px;font-size: 16px;border:1px solid #dedede;}
.registerForm input[type="submit"] {color:white;background-color: #333333;font-size: 18px;cursor: pointer;border:0px;}
.registerForm form div {margin:10px 0;}
.registerForm .etg_message {height: 30px;width:250px;color:red;}
</style>
</head>
<body>
<div class="registerForm">
	<form action="" method="POST" onsubmit="return doRegisterNewCustomer()">
		<div><input type="text" name="etg_FullName" id="etg_FullName" placeholder="Full Name" autocomplete="off" /></div>
		<div><input type="text" name="etg_email" id="etg_email" placeholder="Email" autocomplete="off" /></div>
		<div><input type="password" name="etg_pass" id="etg_pass" placeholder="Password" autocomplete="off" /></div>
		<div><input type="submit" value="Sign up free" /></div>
	</form>
	<div class="etg_message"></div>
</div> 

</body>
</html>
