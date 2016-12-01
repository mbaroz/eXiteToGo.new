<?
include_once("dir_size.php");
include_once("header.inc.php");
	if (!isset($_SESSION['authKey'])) $_SESSION['authKey']=uniqid("A#a",1).session_id();
	
	if ($default_lang=="he") $urlKeyContent="home";
	else $urlKeyContent="english";

$alert_div_css_color="orange";

$alert_display="none";

$landingAferLogin=$SITE[url];
//if (!$_SESSION['retu']=="") $landingAferLogin=$SITE[url].$_SESSION['retu'];;
?>
<style>
.adminBody {background-color: #fff}
.LoginInput {
	height:23px;
	width:255px;
	border:1px solid silver;
	font-family:inherit;
	font-size:18px;
	font-weight:normal;
	padding:5px;
	direction:ltr;
	color:#333333;
	outline: none;
}
.LoginButton {
	min-width:370px;
	height:45px;
	font-size:19px;
	font-weight:bold;
	padding:5px;
	background-color:#91b017;
	color:white;
	border:0px;
	cursor: pointer;

}
.admin-signinBG {
	box-sizing:border-box;
	padding:15px;
	width:90%;
	text-align:center;
	display: block;
	min-height: 300px;
	background-color: #ffffff;
	!box-shadow: 0px 0px 8px 1px silver;
	margin:0 auto;
	
}
.LoginSide {box-sizing:border-box;background-color:#fff;width:50%;height: 400px;float:<?=$SITE[align];?>;}
.LoginSide.logoPlace{border-<?=$SITE[align];?>:1px solid silver;}
.LoginSide.logoPlace img {margin:25% auto;max-width:80%;}
.admin-signinBG.animated {display: block}
.alerts_bg {
	background-color:<?=$alert_div_css_color;?>;
	width:100%;
	min-height:45px;
	color:white;
	font-size:12px;
	display:<?=$alert_display;?>;
	
}
.message {
	width:800px;
	font-family:arial;
	text-align:<?=$SITELANG[direction];?>;
	font-weight:bold;
	padding:5px;
}
.forgotPassLabel {
	cursor:pointer;
	font-size:14px;
	color:#333;
	font-weight:normal;
	font-family:arial;
	text-align: <?=$SITE[align];?>;
	display: block;
	width: 400px;
	margin:0 auto;

}
#ForgotPassMessage {
	font-size:14px;
	font-weight:normal;
	text-align: <?=$SITE[align];?>;
	font-family:arial;
	margin:0 auto;
	width: 400px;
	
}
#msgs {width: 400px;margin:0 auto;}
h3 {text-align: center;}
.submitLoader {display: inline-block;margin:0px -10px 10px;}
.group 			  { 
  position:relative; 
  
  margin:40px auto;
}
input 				{
  font-size:25px;
  padding:10px 10px 10px 5px;
  display:block;
  width:400px;
  border:none;
  border-bottom:1px solid #757575;
  margin:0 auto;
  box-sizing:border-box;
}
input:focus { outline:none; }

/* LABEL ======================================= */
label 				 {
  color:#999; 
  font-size:18px;
  font-weight:normal;
  position:absolute;
  pointer-events:none;
  right:0px;left:0px;
  top:10px;
  transition:0.2s ease all; 
  -moz-transition:0.2s ease all; 
  -webkit-transition:0.2s ease all;
  width:45%;
}

/* active state */
input:focus ~ label, input:valid ~ label 		{
  top:-20px;
  font-size:14px;
  color:#5264AE;
}

/* BOTTOM BARS ================================= */
.bar 	{ position:relative; display:block; width:400px;margin:0 auto; }
.bar:before, .bar:after 	{
  content:'';
  height:2px; 
  width:0;
  bottom:1px; 
  position:absolute;
  background:#5264AE; 
  transition:0.2s ease all; 
  -moz-transition:0.2s ease all; 
  -webkit-transition:0.2s ease all;
}
.bar:before {
  right:50%;
}
.bar:after {
  left:50%; 
}

/* active state */
input:focus ~ .bar:before, input:focus ~ .bar:after {
  width:50%;
}
 input:-webkit-autofill,
 input:-webkit-autofill:hover,
 input:-webkit-autofill:focus,
 input:-webkit-autofill:active {
 -webkit-box-shadow: 0 0 0px 1000px white inset !important;
  }

/* active state */
input:focus ~ .highlight {
  -webkit-animation:inputHighlighter 0.3s ease;
  -moz-animation:inputHighlighter 0.3s ease;
  animation:inputHighlighter 0.3s ease;
}

/* ANIMATIONS ================ */
@-webkit-keyframes inputHighlighter {
	from { background:#5264AE; }
  to 	{ width:0; background:transparent; }
}
@-moz-keyframes inputHighlighter {
	from { background:#5264AE; }
  to 	{ width:0; background:transparent; }
}
@keyframes inputHighlighter {
	from { background:#5264AE; }
  to 	{ width:0; background:transparent; }
}
</style>
<script language="javascript">
jQuery.noConflict();
var step=0;
var isPassReset=0;
function validAuth() {
	if (!document.login.elements[0].value && !document.login.elements[1].value) {
		alert("<?=$ADMIN_TRANS['wrong email/password'];?>");
		return false;
	}
	return true;
}
function initLogin(rs) {
	jQuery('#msgs').html(rs);
	jQuery('#e').val("");
	jQuery('#p').val("");
	
}
function SignInType() {
	//jQuery(".admin-signinBG").removeClass("zoomIn").removeClass("bounce");
	var email=jQuery("#e").val();
	var p=jQuery("#p").val();
	var url = '<?=$SITE[url];?>/Admin/login/auth.php';
	var pars;
	pars = 'e='+email+'&p='+p+'&auth=<?=$authKey;?>&isReset='+isPassReset;
	jQuery.ajax({
		  url: url,type:'POST',
		  data:pars,
		  success: function(data) {
		  	successSignIn(data,step);
		  }
	});
	
	return false;
}
function successSignIn(rs,step) {
	if (rs=="<?=session_id();?>"+document.getElementById("e").value) LoginOk();
		else {
			if (isPassReset) {
				if (rs=="resetOK")	{
					jQuery("#ForgotPassMessage").html("<b><font color='green'><?=$ADMIN_TRANS['a new password has been sent to your email'];?></font></b>");
					jQuery(".LoginButton").attr("disabled",true);
				}
				
				else {
					jQuery("#ForgotPassMessage").html("<font color='red'><?=$ADMIN_TRANS['no account found with this email'];?></font>");
					
				}
			}
			else initLogin(rs);
			
		}

}
function failedEdit() {
	msgDivText="<span class='failedEdit'><?=$ADMIN_TRANS['an error occurred during server communication , please try again.'];?></span>";
}
function SignInProcess() {
	if (step==2) $('#msgs').html("<font color=black>Loging in please wait...</font>");
}
function LoginOk() {
	//document.location="<?=$SITE[url];?>";
	document.location="<?=$landingAferLogin;?>";
}
function stopForgetPass() {
	jQuery("#LoginTitlePass").slideDown();
	jQuery('#returnToLoginLabel').hide();
	jQuery('#ForgotPassMessage').hide();
	jQuery(".LoginButton").val('Sign In');
	jQuery("#msgs").html('');
	jQuery(".LoginButton").attr("disabled",false);
	isPassReset=0;
}
function startForgetPass() {
	jQuery("#LoginTitlePass").slideUp();
	jQuery("#returnToLoginLabel").fadeIn();
	jQuery('#ForgotPassMessage').fadeIn();
	jQuery('#ForgotPassMessage').html(' ');
	jQuery(".LoginButton").val('<?=$ADMIN_TRANS['reset password'];?>');
	isPassReset=1;
	jQuery("#p").val('');
}

</script>
<!--<div style="float:right;width:260px;height:350px;margin-right:20px;margin-top:60px;">
<!--<iframe src="http://www.facebook.com/plugins/likebox.php?id=123000624397833&amp;width=262&amp;connections=0&amp;stream=true&amp;header=true&amp;height=345" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:262px; height:350px;" allowTransparency="true"></iframe>-->
<!--</div>-->
<div class="alerts_bg" align="center"><div class="message"><?=$message;?></div></div>
<div align="center" style="margin-top:30px;"></div>
<?
$CHK_LOGO=explode(".",$SITE[logo]);

?>


<form id="login_frm" name="login_frm" action="" method="post" onsubmit="return SignInType()">
<div class="admin-signinBG">
	<h3><?=$ADMIN_TRANS['management of'];?> - <a href="<?=$SITE[url];?>"><?=$SITE[name];?></a></h3>
	<div class="LoginSide">
		<div class="group email">      
		    <input type="text" name="e" id="e" required/>
		    <span class="bar"></span>
		    <label><?=$ADMIN_TRANS['email'];?></label>
	  </div>
	  <div class="group" id="LoginTitlePass">      
		    <input type="password" name="p" id="p" />
		    <span class="bar"></span>
		    <label><?=$ADMIN_TRANS['password'];?></label>
		    <span id="forgotPassLabel" class="forgotPassLabel"  onclick="startForgetPass();"><?=$ADMIN_TRANS['forgot your password?'];?></span>
	  </div>
	  <div align="<?=$SITE[align];?>" style="margin-<?=$SITE[align];?>:2px;padding-top:10px;direction:<?=$SITE_LANG[direction];?>">
			<input type="submit" class="LoginButton" value="Sign In">
			<span id="returnToLoginLabel" style="display: none" class="forgotPassLabel"  onclick="stopForgetPass();"><?=$ADMIN_TRANS['back to login'];?></span>
			<div id="msgs" align="right" style="height:22px;color:red;font-size:15px;font-family:arial"></div>

	  </div>
			<div style="padding-top:3px;"></div>
			<div id="ForgotPassMessage"></div>

	</div>

	<div class="LoginSide logoPlace">
		<?
		if ($CHK_LOGO[1]=="png" OR $CHK_LOGO[1]=="jpg")
		{
		?>
		<a href="<?=$SITE[url];?>"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[logo];?>" /></a>
		<?
		}
		else {
			print '<a href="'.$SITE[url].'"><div class="text_logo_insite">'.$SITE[logo].'</div></a>';
		}
		?>

	</div>
	<div style="clear:both"></div>
</div>
</form>


<div class="general" id="footerContentAdmin" style="width:780px;direction:<?=$SITE_LANG[direction];?>" align="<?=$SITE[align];?>"></div>

