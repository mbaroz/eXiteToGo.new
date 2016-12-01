<?
$fields_border_css=$buttons_css="border:0px;";
$font_size=12;
if ($SITE[fontface]!="Arial") $font_size=11;
if ($SITE[formfieldsborder]) $fields_border_css="border:1px solid #".$SITE[formfieldsborder].";";
if ($SITE[formbuttonsborder]) $buttons_css="border:1px solid #".$SITE[formbuttonsborder].";";

?>
<script language="javascript" type="text/javascript">
function setCapcha() {
	if ($('fullname').value!="" && $('phone').value!="" && $('email').value!=""  && $('contact_details').value!="") Effect.Appear("cpcha");
	else Effect.Fade("cpcha");
}
function sendContact(rs) {
	if (rs=="<?=session_id();?>") {
		//Effect.SlideUp("contact_layer",{duration:0.4});
		jQuery('#contact_layer').fadeTo("slow",0,function() {jQuery('#contact_layer').css("display","none")});
		jQuery('#msgContact').html("הודעתך נשלחה בהצלחה !");

	}
	else jQuery('#msgContact').html(rs);
}
function processContact() {
	$('msgContact').innerHTML="Sending Contact information...";
}
function failedSendContact() {
	$('msgContact').innerHTML="Failed sending";
}
function sendContact_frm() {
	var url = '<?=$SITE[url];?>/sendContact.php';
	var em=jQuery('#email').val();
	var phne=jQuery('#phone').val();
	var fname=jQuery('#fullname').val();
	var c_details=jQuery('#contact_details').val();
//	var sec_image=$('security_code').value;
	var pars = 'eml='+em+'&fullname='+fname+'&phne='+phne+'&c_details='+c_details;
	jQuery.ajax({
		  url: url,type:'POST',
		  data:pars,
		  success: function(data) {
		  	sendContact(data);
		  }
	});
//	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {
//		sendContact(transport.responseText);
//		}, onFailure:failedSendContact,onLoading:processContact});
	return false;
}
var isTACleared=0;
function clearTextArea(o) {
	if (isTACleared==0) {
		o.value='';
		isTACleared=1;
	}
}
</script>
<style type="text/css">
#contact_layer {
	color:#<?=$SITE[contenttextcolor];?>;
	font-size:13px;
	text-align:right;
	margin-left:5px;
	padding:0 10px 0px 10px;
	border:0px;
}
.contact_frm {
	width:200px;
	padding:1px;
	
	background-color:#<?=$SITE[formbgcolor];?>;
	font-family:inherit;
	font-size:inherit;
	color:#<?=$SITE[formtextcolor];?>;
	<?=$fields_border_css;?>
}
.contact_frm_txt {
	width:198px;
	padding:2px;
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	scrollbar-base-color: #<?=$SITE[formbgcolor];?>;
	overflow-y:auto;
	<?=$fields_border_css;?>
}
.frm_button {
	padding:3px 5px 3px 5px;
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	font-weight:bold;
	width:60px;
	font-size:<?=$font_size;?>px;
	cursor:pointer;
	margin:0;
	
	<?=$buttons_css;?>
}
#contact_form {
	margin:0;
}
</style>
<br />
<div id="contact_layer" style="width:auto" align="<?=$SITE[align];?>">
<form id="contact_form" name="contact_form" method="post" action="<?=$PHP_SELF;?>" onsubmit="return false">

	<div align="<?=$SITE[opalign];?>">שם מלא : <input name="fullname" id="fullname" type="text" class="contact_frm"></div>
	<div style="height:5px"></div>
	<div align="<?=$SITE[opalign];?>">טלפון  : <input name="phone" id="phone" type="text" class="contact_frm" dir="ltr"></div>
	<div style="height:5px"></div>
	<div align="<?=$SITE[opalign];?>">אימייל : <input name="email"  id="email" type="text" class="contact_frm" dir="ltr"></div>
	<div style="height:5px"></div>
	<div align="<?=$SITE[opalign];?>" style="padding-<?=$SITE[align];?>:25px;"><textarea class="contact_frm_txt"  rows="5" name="contact_details" id="contact_details" onfocus="clearTextArea(this)">רשום את פנייתך כאן</textarea></div>
	<div style="height:2px"></div>
	

</form>
	<table style="border:0px;"  cellpadding="0" cellspacing="0" align="center">
	<tr>
	<td width="155" align="<?=$SITE[opalign];?>" style="height:30px;"><input type="button" value="נקה טופס" onclick="contact_form.reset()"  class="frm_button"></td>
	<td width="156" align="<?=$SITE[opalign];?>" style="height:30px;"><input type="button" value="שלח" class="frm_button" onclick="sendContact_frm()"></td>
	</tr>
	</table>
</div>

<table style="border:0px;" width="322" cellpadding="0" cellspacing="5">
<tr>
	<td colspan="3">
	<div id="msgContact" style="padding-<?=$SITE[align];?>:20px;height:46px;font-weight:normal;color:#<?=$SITE[contenttextcolor];?>" align="center"></div>
	</td>
	</tr>
</table>