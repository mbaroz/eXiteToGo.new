<?
$inc_dir="../../";
session_start();
include_once("../../config.inc.php");
include_once("../../inc/GetServerData.inc.php");
$mainRef="http://".$_SERVER['HTTP_HOST'];
?>
<link rel="stylesheet" type="text/css" href="../../<?=$SITE[css];?>">
<?
if ($_POST['mainRef'] OR $_GET['mainRef']) die();
$mainRef="http://".$_SERVER['HTTP_HOST']."/demo";
if($mainRef!=$SITE[url]) die();
function LoggedIn($uID) {
	global $RET_URL;
	global $SITE;
	
	if(!isset($_SESSION['LOGGED_ADMIN'])) $_SESSION['LOGGED_ADMIN']=uniqid("A#a",25).session_id();
	if(!isset($_SESSION['LOGGED'])) $_SESSION['LOGGED']=$_SESSION['LOGGED_ADMIN'];
	if(!session_is_registered('ADMIN_MODE')) session_register('ADMIN_MODE');
	global $MEMBER;
	global $LOGGED_ADMIN;
	$LOGGED_ADMIN=$LOGGED=uniqid("A#a",25).session_id();
	

	if(!isset($_SESSION['MEMBER'])) $_SESSION['MEMBER']=$MEMBER=GetAdminDetails($uID);
	?>
	<script language="javascript">
	window.top.location="<?=$SITE[url];?>";
	</script>
	<?
}
function CheckCredentials($e,$p) {
	global $MSGS;
	unset($_SESSION['authKey']);
	$db=new Database();
	$db->query("SELECT * from admins where Email='$e' AND Passwd='$p'");
	if ($db->nextRecord()) {
		$uid=$db->getField("UID");
		$db->query("update admins SET LoginCount=LoginCount+1 WHERE UID=$uid");
		$curMsg="";
		LoggedIn($uid);
	}
	else $curMsg=$MSGS[BadPass];
	?>
	<form id="loginMSG" name="loginMSG" target="_self" method="POST" action="../SignIn.php">
	<input type="hidden" name="curMsg" value="<?=$curMsg;?>">
	</form>
	<script language="javascript">
	setTimeout("document.loginMSG.submit()",400);
	</script>
	<?
} //End Check Cred

function sidGen() {
	global $authKey;
	if (!isset($_SESSION['authKey'])) $_SESSION['authKey']=$authKey=uniqid("A#a",1).session_id();
	?>
	<div class="loading">Logging In...</div>
	<form id="secureLogin" name="secureLogin" action="<?=$_SERVER['PHP_SELF'];?>" method="POST" target="_self">
	<input type="hidden" name="auth" value="<?=$authKey;?>">
	<input type="hidden" name="se" value="<?=$_POST['email'];?>">
	<input type="hidden" name="sp" value="<?=sha1($_POST['passwd']);?>">
	<input type="submit" style="display:none" value="">
	</form>
	<script language="javascript">
	document.all.secureLogin.submit();
	</script>
	<?
}

if ($_POST['email'] OR $_POST['passwd']) sidGen();


if ($auth AND $auth==$authKey AND ($_POST['se'] OR $_POST['sp'])) CheckCredentials($se,$sp);
//if ($authKey AND $_POST['email'] AND $_POST['passwd']) CheckCredentials($_POST['email'],$_POST['passwd']);

?>
</body>
</html>
