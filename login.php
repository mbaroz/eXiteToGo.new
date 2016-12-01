<?
unset($GLOBALS['USER_LOGGEDIN']);
unset($_SESSION['USER_LOGGEDIN']);
$LOGIN_LABEL=array("Members Sign In","User name","Password","Login","User or password is incorrect","Forget password?","Reset Password","New Password","Confirm New Password","Change Password");
if ($SITE_LANG[selected]=="he") {
	$LOGIN_LABEL=array("כניסה למשתמשים רשומים","שם משתמש","סיסמה","כניסה","שם משתמש או סיסמה שגויים","שכחתי סיסמה","אפס סיסמה","סיסמה חדשה","אימות סיסמה חדשה","שנה סיסמה");
}
//if (!session_is_registered('ret_url')) session_register('ret_url');
//$ret_url=$_GET['r_url'];
if ($SITE['login_label']) $LOGIN_LABEL[1]=$SITE['login_label'];
$fields_border_css=$buttons_css="border:0px;";
if ($SITE[formfieldsborder]) $fields_border_css="border:1px solid #".$SITE[formfieldsborder].";";
if ($SITE[formbuttonsborder]) $buttons_css="border:1px solid #".$SITE[formbuttonsborder].";";
if ($_GET['p_r']) {
	$changePassEmail="";
	$changePassHash=$_GET['p_r'];
	$db=new Database();
	$db->query("SELECT * from users WHERE PasswdChange='{$changePassHash}' LIMIT 1");
	if (!$db->nextRecord()) $changePassHash="";
	else {
		$changePassEmail=$db->getField("Email");
		}
		
	}
?>
<style type="text/css">
.login_text {
	width:180px;
	padding:4px;
	<?=$fields_border_css;?>;
	background-color:#<?=$SITE[formbgcolor];?>;
	font-family:inherit;
	font-size:inherit;
	color:#<?=$SITE[formtextcolor];?>;
	direction:ltr;
	transition:all 0.4s;
	-webkit-transition:all 0.5;
}
.login_button {
	padding:3px 5px 3px 5px;
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	font-weight:bold;
	<?=$buttons_css;?>;
	min-width:60px;
	font-size:15px;
	cursor:pointer;
}
.fPass {cursor: pointer;}
</style>
<script language="javascript">
var actionType="login";
function sendLogin(rs) {
	if (rs=="<?=session_id();?>") {
		//Effect.SlideUp("contact_layer",{duration:0.4});
		document.location.href="<?=$SITE[url].$ret_url;?>";

	}
	else jQuery('#msgLogin').html(rs);
}
function doLogin() {
	var url = '<?=$SITE[url];?>/sendLogin.php';
	var u=jQuery('#u').val();
	var p=jQuery('#p').val();
	var cID="<?=$scid;?>";
	var pars = 'usr='+u+'&passwd='+p+'&actionType='+actionType;
	jQuery.ajax({
		  url: url,type:'POST',
		  data:pars,
		  success: function(data) {
		  	sendLogin(data);
		  }
	});
	return false;
}
function doChangePass() {
	var url = '<?=$SITE[url];?>/sendLogin.php';
	var new_p=jQuery('#newP').val();
	var new_p2=jQuery('#newP_2').val();
	var cID="<?=$scid;?>";
	var pars = 'usr=<?=$changePassEmail;?>&passwd='+new_p+'&passwd_confirm='+new_p2+'&actionType=changePassNow'
	jQuery.ajax({
		  url: url,type:'POST',
		  data:pars,
		  success: function(data) {
		  	sendLogin(data);
		  }
	});
	return false;
}
var curLoginbuLabel;
function startForgotPass() {
	if (curLoginbuLabel=="") curLoginbuLabel=jQuery(".login_button").val();
	jQuery(".passArea").toggle(function() {
		if (actionType=="resetPass") {
		jQuery(".login_button").val("<?=$LOGIN_LABEL[3];?>");
		jQuery(".fPass").text("<?=$LOGIN_LABEL[5];?>");
		curLoginbuLabel="";
		actionType="login";
	}
	else {
		jQuery(".login_button").val("<?=$LOGIN_LABEL[6];?>");
		jQuery(".fPass").text("<?=$LOGIN_LABEL[0];?>");
		actionType="resetPass";
		}
	});
	
}
</script>
<?
if ($changePassHash AND $changePassEmail) {
	?>
	<form onsubmit="doChangePass();return false;">
		<div class="mainContentText" style="margin-<?=$SITE[align];?>:5px;">
			<br>
			<strong><?=$LOGIN_LABEL[7];?></strong>
			<br>
			<input type="text" class="login_text" name="newP" id="newP" />
			<br><br>
			<strong><?=$LOGIN_LABEL[8];?></strong>
			<br>
			<input type="text" class="login_text" name="newP_2" id="newP_2" />
			<div style="height:10px"></div>
			<input type="submit" value="<?=$LOGIN_LABEL[8];?>" class="login_button" />
			<div style="height:10px"></div>
			<div id="msgLogin" style="padding-<?=$SITE[align];?>:2px;font-weight:normal;color:red" ></div>
		</div>
	</form>

	<?
	
}
else {
	?>
	<form onsubmit="doLogin();return false;">
	<div class="mainContentText" style="margin-<?=$SITE[align];?>:5px;">
		<br>
		<strong><?=$LOGIN_LABEL[1];?></strong>
		<br>
		<input type="text" class="login_text" name="u" id="u" />
		<div style="height:10px"></div>
		<div class="passArea">
		<strong><?=$LOGIN_LABEL[2];?></strong>
		<br>
		
			<input type="password" class="login_text" name="p" id="p" />
		</div>
		<div style="height:10px"></div>
		<input type="submit" value="<?=$LOGIN_LABEL[3];?>" class="login_button" />
		&nbsp;<span class="fPass"><?=$LOGIN_LABEL[5];?></span>
		<div style="height:10px"></div>
		<div id="msgLogin" style="padding-<?=$SITE[align];?>:2px;font-weight:normal;color:red" ></div>
	</div>
	</form>
	<script language="javascript">
	document.onload=document.getElementById('u').focus();
	jQuery(document).ready(function() {
		jQuery(".fPass").click(function() {startForgotPass()});
	});
	</script>
<?

}
?>