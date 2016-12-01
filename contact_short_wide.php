<?
include_once("config.inc.php");
include_once("defaults.php");
$fields_border_css=$buttons_css="border:0px;";
if ($SITE[formfieldsborder]) $fields_border_css="border:1px solid #".$SITE[formfieldsborder].";";
if ($SITE[formbuttonsborder]) $buttons_css="border:1px solid #".$SITE[formbuttonsborder].";";
if ($SITE_LANG[selected]=="en" OR $default_lang=="en") $CONTACT_LABELS=array("Name", "Phone Number", "Email","Your message here","Your message was sent, one of our staff will contact you . . .","Send","Clear form");
else $CONTACT_LABELS=array("שם", "טלפון", "דוא''ל","רשום את פנייתך כאן","הפרטים נשלחו בהצלחה" ,"שלח","נקה טופס");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php">
<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-1.4.4.min.js"></script>
<script language="javascript" src="<?=$SITE[url];?>/js/jquery.form.js"></script>
<style type="text/css">
body {
    margin:12px 0px 0px 0px;
    padding:0px;
    background:none transparent;
    background-color:transparent;
    
}
#contact_form {margin:0;padding:0;}
#contact_layer {
	color:#<?=$SITE[contenttextcolor];?>;
	font-size:13px;
	padding:0 10px 0px 10px;
	direction:<?=$SITE_LANG[direction];?>;
}
#contact_layer td{vertical-align:top;margin-<?=$SITE[opalign];?>:13px;}
.contact_frm {
	width:93%;
	padding:2px;
	background-color:#<?=$SITE[formbgcolor];?>;
	font-family:inherit;
	font-size:inherit;
	color:#<?=$SITE[formtextcolor];?>;
	<?=$fields_border_css;?>;
        margin:0px;
        
}

.frm_button {
	padding:2px 8px 2px 8px;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	font-weight:bold;
	font-size:<?=$font_size;?>px;
	cursor:pointer;
	background-color:#<?=$SITE[formbgcolor];?>;
        <?=$buttons_css;?>;
	margin:0px;
}
#contact_form {
	margin:0;
}
.comment {
	color:#ccc;
	font-style:italic;
	width:260px;
}
.comment_on {
	color:#<?=$SITE[formtextcolor];?>;
	font-style:normal;
}
.contact_title {
    font-size:14px;
    font-weight:bold;
}
</style>
</head>
<body background="transparent" bgcolor="transparent">
<script language="javascript" type="text/javascript">
function sendContact(rs, statusText, xhr, $form) {
	if (rs=="<?=session_id();?>") {
		//Effect.SlideUp("contact_layer",{duration:0.4});
		//$('#contact_layer').fadeTo("slow",0,function() {$('#contact_layer').css("display","none")});
		$('#msgContact').html("<?=$CONTACT_LABELS[4];?>");
                document.getElementById('contact_form').reset();
	}
	else {
            $('#msgContact').html(rs);
        }
}
function processContact(formData, jqForm, options) {
	$('#msgContact').html="Sending Contact information...";
}
function failedSendContact() {
	$('msgContact').innerHTML="Failed sending";
}

$(document).ready(function() { 
    var options = { 
        target:        '#msgContact',   // target element(s) to be updated with server response 
        beforeSubmit:  processContact,  // pre-submit callback 
        success:       sendContact  // post-submit callback 

    }; 
    $('#contact_form').ajaxForm(options); 
}); 
function enter_here() {
	$("#comment").addClass("comment_on");
	$("#comment").val('');
}
</script>

<div id="contact_layer" style="width:auto" align="<?=$SITE[align];?>">
<form id="contact_form" name="contact_form" method="post" action="sendWidgetContact.php">
<table cellspacing="5" border="0" cellpadding="0">
    <tr>
        <td><?=$CONTACT_LABELS[0];?>: </td><td><input name="fullname" id="fullname" type="text" class="contact_frm" autocomplete="off"></td>
   
        <td><?=$CONTACT_LABELS[1];?>: </td><td><input name="phne" id="phne" type="text" class="contact_frm" dir="ltr" autocomplete="off"></td>
  
        <td><?=$CONTACT_LABELS[2];?>: </td><td><input name="eml" id="eml" type="text" class="contact_frm" dir="ltr" autocomplete="off"></td>
        <td align="left" style="width:50px"><input type="submit" value="<?=$CONTACT_LABELS[5];?>" class="frm_button"></td>
    </tr>
</table>
<input type="hidden" id="newsletter" name="newsletter" value="<?=$_GET['newsletter'];?>">
</form>
<div id="msgContact" style="font-weight:normal;height:15px;font-size:11px" align="center"></div>
</div>
</body>
</html>