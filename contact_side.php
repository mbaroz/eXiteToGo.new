<?
if ($SITE_LANG[selected]=="en" OR $default_lang=="en") $CONTACT_LABELS=array("Full Name", "Phone Number", "Email","Your message here","Your message was sent, one of our staff will contact you . . .","Send","Clear form");
else $CONTACT_LABELS=array("שם מלא", "טלפון", "אימייל","רשום את פנייתך כאן","הפרטים נשלחו בהצלחה , אחד מנציגנו ייצור עימך קשר בהקדם האפשרי .","שלח","נקה טופס");
$width_inc_side=0;
$css_code="margin-".$SITE[align].":15px;";
$margin_bottom=3;
if(ieversion()>0) $margin_bottom=6;
if (ieversion()>0 AND ieversion()<9) $margin_bottom=3;
if (ieversion()>0 AND ieversion()<8) $margin_bottom=1;
if ($P_DETAILS[HideTopMenu]==1) $SITE[sideformbgpic]="";
$fields_css_code="border:1px solid #".$SITE[formfieldsborder].";";
if ($SITE[formfieldsborder]=="") $fields_css_code="border:0px;";
$buttons_css="border:0px;";
if ($SITE[formbuttonsborder]) $buttons_css="border:1px solid #".$SITE[formbuttonsborder].";";
if ($SITE[sideformbgpic]) {
	$width_inc_side=8;
	$css_code="padding:5px 12px 5px 8px;margin-".$SITE[align].":8px;width:210px;height:280px";
	$fields_css_code="border:0px;";
	$buttons_css="border:0px;";
}
if ($SITE[formbuttontextcolor]=="" AND !$SITE[sideformbgpic]) $SITE[formbuttontextcolor]=$SITE[formtextcolor];
$button_text_color="#".$SITE[formbuttontextcolor];
if ($SITE[formbuttontextcolor]=="" AND !$SITE[sideformbgpic]=="") {
	$sideformbgbolor="transparent";
	$button_text_color="transparent";
	//$buttons_css.="line-height:0;";
	$CONTACT_LABELS[5]=$CONTACT_LABELS[6]="";
}
else $sideformbgbolor="#".$SITE[formbgcolor];
?>
<script language="javascript" type="text/javascript">
function sendSideContact(rs) {
	if (rs=="<?=session_id();?>") {
		//Effect.SlideUp("contact_layer_side",{duration:0.4});
		jQuery('#msgSideContact').html("<?=$CONTACT_LABELS[4];?>");
		document.getElementById('side_contact_form').reset();
		
	}
	else jQuery('#msgSideContact').html(rs);
}
function processSideContact() {
//	$('msgContact').innerHTML="";
}
function failedSendSideContact() {
	$('msgSideContact').innerHTML="Failed sending";
}
function sendSideContact_frm() {
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
		  	sendSideContact(data);
		   	}
		});
//	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {
//		sendSideContact(transport.responseText);
//		}, onFailure:failedSendSideContact,onLoading:processSideContact});
	return false;
}

</script>
<style type="text/css">
#contact_layer_side {
	color:#<?=$SITE[contenttextcolor];?>;
	font-size:13px;
	text-align:left;
	background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[sideformbgpic];?>');
	background-position: top;
	background-repeat:no-repeat;
	width:210px;
	<?=$css_code;?>
}
.contact_frm_side {
	width:<?=(210-$width_inc_side);?>px;
	padding:1px;
	background-color:<?=$sideformbgbolor;?>;
	font-family:inherit;
	font-size:inherit;
	color:#<?=$SITE[formtextcolor];?>;
	outline: none;
	<?=$fields_css_code;?>;
	margin-bottom:<?=$margin_bottom;?>px;
	margin-top:1px;
}
.contact_frm_txt_side {
	width:<?=(208-$width_inc_side);?>px;
	padding:2px;
	background-color:<?=$sideformbgbolor;?>;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	scrollbar-base-color: #<?=$SITE[formbgcolor];?>;
	outline: none;
	margin-bottom:2px;
	margin-top:1px;
	<?=$fields_css_code;?>
}
.frm_button_side {
	padding:3px 2px 3px 2px;
	background-color:<?=$sideformbgbolor;?>;
	color:<?=$button_text_color;?>;
	font-family:inherit;
	font-size:inherit;
	font-weight:bold;
	width:65px;
	font-size:12px;
	cursor:pointer;
	text-align:center;
	<?=$buttons_css;?>
}
</style>
<br />
<div id="contact_layer_side">
<form id="side_contact_form" name="side_contact_form" method="post" action="<?=$PHP_SELF;?>" onsubmit="return false">

	<div align="<?=$SITE[align];?>"><?=$CONTACT_LABELS[0];?> :<br /><input name="fullname" id="fullname" type="text" class="contact_frm_side"></div>
	<div style="height:5px"></div>
	<div align="<?=$SITE[align];?>"><?=$CONTACT_LABELS[1];?>  : <br /><input name="phone" id="phone" type="text" class="contact_frm_side" dir="ltr"></div>
	<div style="height:5px"></div>
	<div align="<?=$SITE[align];?>"><?=$CONTACT_LABELS[2];?> : <br /><input name="email"  id="email" type="text" class="contact_frm_side" dir="ltr"></div>
	<div style="height:15px"></div>
	<div align="<?=$SITE[align];?>" style="padding-<?=$SITE[opalign];?>:25px;"><textarea class="contact_frm_txt_side"  rows="5" name="contact_details" id="contact_details" onfocus="this.value='';"><?=$CONTACT_LABELS[3];?></textarea></div>
	<div style="height:2px"></div>
	
</form>
<div style="height:10px"></div>
	<table style="border:0px;" width="<?=(212-$width_inc_side);?>" cellpadding="0" cellspacing="0">
	<tr>
	<td width="108" align="<?=$SITE[align];?>" style="height:30px;"><input type="button" value="<?=$CONTACT_LABELS[6];?>" onclick="side_contact_form.reset()"  class="frm_button_side"></td>
	<td width="105" align="<?=$SITE[opalign];?>" style="height:30px;"><input type="button" value="<?=$CONTACT_LABELS[5];?>" class="frm_button_side" onclick="sendSideContact_frm()"></td>
	</tr>
	</table>
</div>

<table style="border:0px;" width="210" cellpadding="0" cellspacing="1">
<tr>
	<td colspan="3">
	<div id="msgSideContact" style="margin-<?=$SITE[align];?>:5px;height:46px;font-weight:normal;color:#<?=$SITE[contenttextcolor];?>" align="center"></div>
	</td>
	</tr>
</table>