<script language="javascript" type="text/javascript">
function setCapcha() {
	if ($('fullname').value!="" && $('phone').value!="" && $('email').value!=""  && $('contact_details').value!="") Effect.Appear("cpcha");
	else Effect.Fade("cpcha");
}
function sendContact(rs) {
	if (rs=="<?=session_id();?>") {
		Effect.SlideUp("contact_layer",{duration:0.4});
		$('msgContact').innerHTML="הפרטים נשלחו בהצלחה , אחד מנציגנו ייצור עימך קשר בהקדם האפשרי .";

	}
	else $('msgContact').innerHTML=rs;
}
function processContact() {
//	$('msgContact').innerHTML="";
}
function failedSendContact() {
	$('msgContact').innerHTML="Failed sending";
}
function sendContact_frm() {
	var url = '<?=$SITE[url];?>/sendContact.php';
	var em=$('email').value;
	var phne=$('phone').value;
	var fname=$('fullname').value;
	var c_details=$('contact_details').value;
//	var sec_image=$('security_code').value;
	var pars = 'eml='+em+'&fullname='+fname+'&phne='+phne+'&c_details='+c_details;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {
		sendContact(transport.responseText);
		}, onFailure:failedSendContact,onLoading:processContact});
	return false;
}

</script>
<style type="text/css">
#contact_layer {
	color:#<?=$SITE[contenttextcolor];?>;
	font-size:13px;
	text-align:right;
	
}
.contact_frm {
	width:200px;
	padding:1px;
	border:0px solid silver;
	background-color:#<?=$SITE[formbgcolor];?>;
	font-family:inherit;
	font-size:inherit;
	color:#<?=$SITE[formtextcolor];?>;
}
.contact_frm_txt {
	width:198px;
	padding:2px;
	border:0px solid silver;
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	scrollbar-base-color: #<?=$SITE[formbgcolor];?>;
}
.frm_button {
	padding:3px 5px 3px 5px;
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	font-weight:bold;
	border:0px solid silver;
	width:60px;
	font-size:12px;
	cursor:pointer;
}
</style>
<br />
<div id="contact_layer" style="width:300px" align="<?=$SITE[align];?>">
<form id="contact_form" name="contact_form" method="post" action="<?=$PHP_SELF;?>" onsubmit="return false">

	<div align="<?=$SITE[opalign];?>">שם מלא : <input name="fullname" id="fullname" type="text" class="contact_frm"></div>
	<div style="height:5px"></div>
	<div align="<?=$SITE[opalign];?>">טלפון  : <input name="phone" id="phone" type="text" class="contact_frm" dir="ltr"></div>
	<div style="height:5px"></div>
	<div align="<?=$SITE[opalign];?>">אימייל : <input name="email"  id="email" type="text" class="contact_frm" dir="ltr"></div>
	<div style="height:5px"></div>
	<div align="<?=$SITE[opalign];?>" style="padding-<?=$SITE[align];?>:25px;"><textarea class="contact_frm_txt"  rows="5" name="contact_details" id="contact_details" onfocus="this.value='';">רשום את פנייתך כאן</textarea></div>
	<div style="height:2px"></div>
	

	
</form>
	<table style="border:0px;" width="306" cellpadding="0" cellspacing="5">
	<tr>
	<td width="152" align="<?=$SITE[opalign];?>" style="height:30px;"><input type="button" value="נקה טופס" onclick="contact_form.reset()"  class="frm_button"></td>
	<td width="138" align="<?=$SITE[opalign];?>" style="height:30px;"><input type="button" value="שלח" class="frm_button" onclick="sendContact_frm()"></td>
	</tr>
	</table>
</div>

<table style="border:0px;" width="322" cellpadding="0" cellspacing="5">
<tr>
	<td colspan="3">
	<div id="msgContact" style="height:46px;font-weight:normal;" align="left"></div>
	</td>
	</tr>
</table>



