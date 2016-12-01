<?
//General Config Form
include_once("checkAuth.php");
$SITE['cdn_url']="//d3jy1qiodf2240.cloudfront.net";
$db = new Database();
?>
<script type="text/javascript" src="http://feather.aviary.com/js/feather.js"></script>
<div align="center" class="general" style="width:900px">
<br />

<script type="text/javascript">
	var pressed_addnew = false;
	var gal_editor_width="99%";
	var OrigTopContent;
	var OrigBottomContent;
	var SiteDirection="<?=($SITE['align'] == 'right') ? 'rtl' : 'ltr';?>";
	var editor_ins_new;
	var editor_browsePath="<?=$SITE['url'];?>/ckfinder";

	var siteURL="<?=$SITE[url];?>";
</script>

<div style="position:relative;text-align:<?=$SITE[align];?>">
<? if(@$_GET['ProductID'] > 0){ ?>
<div style="margin-right:10px;">
<?=$SHOP_TRANS['edit_email_for_product'];?>:&nbsp;
<select id="newProductEmailID">
	<option value="0"><?=$SHOP_TRANS['clali'];?></option>
	<? $db->query("SELECT `ProductID`,`ProductTitle` FROM `products` WHERE `ProductTitle` != '' ORDER BY `ProductTitle` ASC");
		while($db->nextRecord()){ ?><option value="<?=$db->getField('ProductID');?>"<?=($db->getField('ProductID') == @$_GET['ProductID']) ? ' SELECTED' : '';?>><?=$db->getField('ProductTitle');?></option><? } ?>
	</select>&nbsp;
	<input type="button" class="greenSave" id="newSaveIcon" onclick="document.location.href='#emailsAdmin?ProductID='+jQuery('#newProductEmailID').val();" value="<?=$SHOP_TRANS['choose'];?>" /><br/><br/>
</div>
<div style="padding:20px;" id="addNewEmail">
	<form id="newEmail" method="POST" action="saveEmails.php" target="ifrmData">
	<input type="hidden" name="ProductID" id="newEmailProductID" value="<?=$_GET['ProductID'];?>" />
	<?
	$found = true;
$db->query("SELECT * FROM `email_texts` WHERE `emailID`='ProductEmail_{$_GET['ProductID']}'");
if(!$db->nextRecord())
{
	$found = false;
	$db->query("SELECT * FROM `email_texts` WHERE `emailID`='costumerNewOrder'");
	$db->nextRecord();
}

if(true)
{ 
 ?>
	<textarea style="width:448px;" cols="60" rows="10" class="ConfigAdminInputTxt" name="emailText" id="newProductMailText"><?=($found) ? $db->getField('emailText') : '';?></textarea><br />
	<input type="hidden" name="emailDetails" value="<?=$db->getField('emailDetails');?>" />
	<input type="hidden" name="newEmail" value="1" />
	<input type="submit" class="button" value="<?=$ADMIN_TRANS['save changes'];?>">
	<? if($found){ ?>
	&nbsp;&nbsp;&nbsp;<input type="button" class="button" style="color:RED;" value="<?=$SHOP_TRANS['del'];?>" onclick="if(confirm('<?=$SHOP_TRANS['you_sure'];?>?'))document.location.href='/Admin/saveEmails.php?delEmail=ProductEmail_<?=$_GET['ProductID'];?>';">
	<? }
} ?>
</form>
</div>
<script>
jQuery(document).ready(function() { 

   	var contentDIV = document.getElementById("newProductMailText");
	editor_ins_new=CKEDITOR.replace(contentDIV, {
		filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
		filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
		filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
		filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
		filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
		customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_galleries.js'
	});
}); 
</script>

<? } else { ?>
<form id="config" method="POST" action="saveEmails.php" target="ifrmData">
<table class="ConfigAdmin" style="margin: 0 auto;">
<tr>
<td align="center"<? if ($MEMBER[UserType]==0) { ?> colspan="2"<? } ?>><h3><?=$SHOP_TRANS['emails'];?></h3></td>
</tr>
<?
$db = new Database();
$db->query("SELECT * FROM `email_texts`");
while($db->nextRecord())
if(substr($db->getField('emailID'),0,13) != 'ProductEmail_'){ 

if ($MEMBER[UserType]==0 || $db->getField('emailID') == 'footer') {?>
<tr><td colspan="2" align="<?=$SITE['align'];?>">
<?=$db->getField('emailTitle');?>:<? if(substr($db->getField('emailID'),0,13) == 'ProductEmail_'){ ?>
	&nbsp;&nbsp;&nbsp;<a href="/Admin/saveEmails.php?delEmail=<?=$db->getField('emailID');?>" style="color:RED;font-size:11px;" onclick="if(!confirm('<?=$SHOP_TRANS['you_sure'];?>'))return false;"><?=$SHOP_TRANS['del'];?></a>
<? } ?><br/>
<? if ($MEMBER[UserType]==0 && $db->getField('emailID') != 'footer') { ?>
<small>
<? $vars = explode("\n",$db->getField('emailDetails')); 
$k_vars = array();
$v_vars = array();
foreach($vars as $var)
{
	$ex = explode(' - ',$var);
	$key = trim($ex[0]);
	$key = '[['.substr($key,2,-2).']]';
	$k_vars[] = $key;
	$v_vars[] = trim($ex[1]);
}
?>
<select id="var_<?=$db->getField('emailID');?>">
	<? foreach($v_vars as $i => $title){ ?><option value="<?=$k_vars[$i];?>"><?=$title;?></option><? } ?>
</select>
<input type="button" value="<?=$SHOP_TRANS['insert'];?>" onclick="insertAtCursor('<?=$db->getField('emailID');?>',jQuery('#var_<?=$db->getField('emailID');?>').val());" />
</small>
<? }
elseif ($db->getField('emailID') == 'footer')
{
$ndb = new Database();
?>
<div style="">
<?=$SHOP_TRANS['edit_email_for_product'];?>:&nbsp;
<select id="newProductEmailID">
	<option value="0"><?=$SHOP_TRANS['clali'];?></option>
	<? $ndb->query("SELECT `ProductID`,`ProductTitle` FROM `products` WHERE `ProductTitle` != '' ORDER BY `ProductTitle` ASC");
		while($ndb->nextRecord()){ ?><option value="<?=$ndb->getField('ProductID');?>"<?=($ndb->getField('ProductID') == @$_GET['ProductID']) ? ' SELECTED' : '';?>><?=$ndb->getField('ProductTitle');?></option><? } ?>
	</select>&nbsp;
	<input type="button" onclick="document.location.href='#emailsAdmin?ProductID='+jQuery('#newProductEmailID').val();" value="<?=$SHOP_TRANS['choose'];?>" /><br/>
</div>
<?
}
$mailtext = $db->getField('emailText');
$ex = explode('%%',$mailtext);
$open = false;
$newtext = array_shift($ex);
foreach($ex as $e)
{
	$newtext .= ($open) ? ']]' : '[[';
	$newtext .= $e;
	if($open)
		$open = false;
	else
		$open = true;
}
if ($db->getField("emailID")=="footer") $class_name="ConfigAdminInputTxt_mailFooter";
else $class_name="ConfigAdminInputTxt";
?>
</td></tr>
<tr>
<td colspan="2" <? if($db->getField('emailID') == 'footer' && $MEMBER[UserType]==0){?> colspan="2" <? } ?>align="<?=$SITE[align];?>">
<textarea style="width:820px;" rows="10" class="<?=$class_name;?>" name="<?=$db->getField('emailID');?>" id="mail_<?=$db->getField('emailID');?>"><?=$newtext;?></textarea>
</td>
</tr>
<? 
} } ?>
<tr>
<td align="center"><br />

<input type="submit" class="greenSave" id="newSaveIcon" value="<?=$ADMIN_TRANS['save changes'];?>">
<br>

</td>
</td>
</tr>
</table>
</br>
<? } ?>

<script type="text/javascript">
	function insertAtCursor(myField, myValue) {
		if(myField == 'newProductMailText')
		{
			editor_ins_new.insertHtml(myValue);
		}
		else
		{
			//IE support
			myField = document.getElementById('mail_'+myField);
			if (document.selection) {
				myField.focus();
				sel = document.selection.createRange();
				sel.text = myValue;
			}
			//MOZILLA/NETSCAPE support
			else if (myField.selectionStart || myField.selectionStart == '0') {
				var startPos = myField.selectionStart;
				var endPos = myField.selectionEnd;
				myField.value = myField.value.substring(0, startPos)
				+ myValue
				+ myField.value.substring(endPos, myField.value.length);
			} else {
				myField.value += myValue;
			}
			myField.focus();
		}
	}

function initAjaxForm(){
	var options = { 
	        target:        '.msgGeneralAdminNotification', 
	        success:       function(){showNotification(1);}  // target element(s) to be updated with server response 
	        

	    };
	jQuery('#config').ajaxForm(options);  
}
jQuery(document).ready(function(){
			CKEDITOR.replace("mail_footer", {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_galleries.js'
		});
		window.setTimeout('initAjaxForm()',1000);
	});
	
</script>

</form>
</div>
</div>
<? include_once("footer.inc.php"); ?>