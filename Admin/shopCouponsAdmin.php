<?
//General Config Form
include_once("checkAuth.php");
include("colorpicker.php");

$db=new Database();

if(@$_GET['del'] > 0)
{
	$db->query("DELETE FROM `shop_coupons` WHERE `id`='{$_GET['del']}'");
	print "Done!";
	
}

if(@$_GET['edit'] > 0)
{
	$db->query("UPDATE `shop_coupons` SET `uses`='{$_POST['uses']}',`type`='{$_POST['type']}',`discount`='{$_POST['discount']}' WHERE `id`='{$_GET['edit']}'");
	print "Done!";
	die();
	
}

if(@$_GET['add'] == 1)
{
	if(trim(@$_POST['code']) != '')
	{
		$db->query("INSERT INTO `shop_coupons` SET `code`='{$_POST['code']}',`uses`='{$_POST['uses']}',`type`='{$_POST['type']}',`discount`='{$_POST['discount']}'");
	}
	print "Done!";
	die();
}

?>
<br/><br/>
<script type="text/javascript">
var options = { 
        target:        '.msgGeneralAdminNotification', 
        success:       function(){showNotification(1);}  // target element(s) to be updated with server response 
        

  }; 
jQuery(document).ready(function() { 
   	jQuery('#config').ajaxForm(options);

}); 
</script>
<style type="text/css">
table {width: 800px;}
</style>
<div style="margin-right:10px;">
<table class="ConfigAdmin listTable" border="0" style="border-collapse:;" cellpadding="3" cellspacing="3">
<tr style="background-color:#efefef;font-weight:bold;">
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['coupon_code'];?></td>
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['coupon_uses'];?></td>
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['coupon_used'];?></td>
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['coupon_type'];?></td>
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['coupon_discount'];?></td>
<td align="<?=$SITE[align];?>"></td>
</tr>
<?
$db = new Database();
$db->query("
	SELECT
		*
	FROM
		`shop_coupons`
	ORDER BY
		`code` ASC
");
while($db->nextRecord())
{
	$coupon = $db->record;
	?>
	<tr>
	<td><?=$coupon['code'];?></td>
	<td><?=$coupon['uses'];?></td>
	<td><?=$coupon['used'];?></td>
	<td><?=$SHOP_TRANS['coupon_type_'.$coupon['type']];?></td>
	<td><?=$coupon['discount'];?></td>
	<td><a href="#" onclick="jQuery('#edit_<?=$coupon['id'];?>').slideToggle();jQuery('#configEdit_<?=$coupon['id'];?>').ajaxForm(options);return false;"><?=$SHOP_TRANS['edit'];?></a>&nbsp;&nbsp;<a href="#shopCouponsAdmin?del=<?=$coupon['id'];?>" onclick="if(!confirm('<?=$SHOP_TRANS['you_sure'];?>?'))return false;"><?=$SHOP_TRANS['del'];?></a></td>
	</tr>
	<tr id="edit_<?=$coupon['id'];?>" style="display:none;">
	<td colspan="5">
	<form id="configEdit_<?=$coupon['id'];?>" method="POST" action="<?=$PHP_SELF;?>?edit=<?=$coupon['id'];?>">
	<table class="ConfigAdmin">
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['coupon_uses'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="uses" value="<?=$coupon['uses'];?>" />
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['coupon_type'];?>: </td><td align="<?=$SITE[align];?>">
		<select name="type">
			<option value="sum"><?=$SHOP_TRANS['coupon_type_sum'];?></option>
			<option value="percent"<?=($coupon['type'] == 'percent') ? ' SELECTED' : '';?>><?=$SHOP_TRANS['coupon_type_percent'];?></option>
		</select>
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['coupon_discount'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="discount" value="<?=$coupon['discount'];?>" />
	</td>
	</tr>
	<tr>
	<td></td>
	<td align="center"><br />
	
	<input type="submit" class="greenSave" id="newSaveIcon" value="<?=$ADMIN_TRANS['save changes'];?>">
	
	</td>
	</tr>
	</table>
	
	</form>
	</td>
	</tr>
<? } ?>

<tr>
<td colspan="11"><a id="newSaveIcon" class="add_button" href="#" onclick="jQuery('#add_coupon').slideToggle();return false;"><?=$SHOP_TRANS['add_new'];?></td>
</tr>
<tr id="add_coupon" style="display:none;">
<td colspan="11">
<form id="config" method="POST" action="<?=$PHP_SELF;?>?add=1">
<table class="ConfigAdmin">
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['coupon_code'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="code" />
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['coupon_uses'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="uses" />
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['coupon_type'];?>: </td><td align="<?=$SITE[align];?>">
	<select name="type">
		<option value="sum"><?=$SHOP_TRANS['coupon_type_sum'];?></option>
		<option value="percent"><?=$SHOP_TRANS['coupon_type_percent'];?></option>
	</select>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['coupon_discount'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="discount" />
</td>
</tr>
<tr>
<td></td>
<td align="center"><br />

<input type="submit" id="newSaveIcon" class="greenSave" value="<?=$ADMIN_TRANS['save changes'];?>">

</td>
</tr>
</table>

</form>
</td>
</tr>

</table>
</div>


<? include_once("footer.inc.php"); ?>