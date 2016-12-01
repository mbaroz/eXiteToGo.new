<?
//General Config Form
include_once("checkAuth.php");
include("colorpicker.php");

$db=new Database();

if(@$_GET['del'] > 0)
{
	$db->query("DELETE FROM `shop_shippings` WHERE `shippingID`='{$_GET['del']}'");
	print "Done!";
}

if(@$_GET['edit'] > 0)
{
	if(trim(@$_POST['shippingName']) != '')
	{
		if(!isset($_POST['default']))
			$_POST['default'] = 0;
		$discounts = array();
		if(is_array(@$_POST['discounts']))
			foreach($_POST['discounts'] as $i => $discount)
			{
				$min_price = floatval($_POST['discounts_mins'][$i]);
				if($min_price > 0 && $discount > 0)
				{
					$discounts[$min_price] = floatval($discount);
				}
			}
		$discounts = serialize($discounts);
		$db->query("UPDATE `shop_shippings` SET `shippingName`='{$_POST['shippingName']}',`shippingCost`='{$_POST['shippingCost']}',`shippingTime`='{$_POST['shippingTime']}',`default`='{$_POST['default']}',`discounts`='{$discounts}' WHERE `shippingID`='{$_GET['edit']}'");
		if($_POST['default'] == 1)
			$db->query("UPDATE `shop_shippings` SET `default`='0' WHERE `shippingID`!='{$_GET['edit']}'");
	}
	print "Done!";
	die();
}

if(@$_GET['add'] == 1)
{
	if(trim(@$_POST['shippingName']) != '')
	{
		if(!isset($_POST['default']))
			$_POST['default'] = 0;
		if($_POST['default'] == 1)
			$db->query("UPDATE `shop_shippings` SET `default`='0'");
		$discounts = array();
		if(is_array(@$_POST['discounts']))
			foreach($_POST['discounts'] as $i => $discount)
			{
				$min_price = floatval($_POST['discounts_mins'][$i]);
				if($min_price > 0 && $discount > 0)
				{
					$discounts[$min_price] = floatval($discount);
				}
			}
		$discounts = serialize($discounts);
		$db->query("INSERT INTO `shop_shippings` SET `shippingName`='{$_POST['shippingName']}',`shippingCost`='{$_POST['shippingCost']}',`default`='{$_POST['default']}',`shippingTime`='{$_POST['shippingTime']}',`discounts`='{$discounts}'");
	}
	print "Done!";
	die();
}

?>
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
<br/><br/>
<div style="margin-right:10px;">
<table class="ConfigAdmin listTable" border="0" style="border-collapse:;" cellpadding="3" cellspacing="3">
<tr style="background-color:#efefef;font-weight:bold;">
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['shipping_label'];?></td>
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['shipping_price'];?></td>
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['shipping_time'];?></td>
<td align="<?=$SITE[align];?>"></td>
</tr>
<?
$db = new Database();
$db->query("
	SELECT
		*
	FROM
		`shop_shippings`
	ORDER BY
		`shippingCost` ASC
");
while($db->nextRecord())
{
	$shipping = $db->record;
	?>
	<tr<?=($shipping['default'] == 1) ? ' style="font-weight:bold;"' : '';?>>
	<td><?=$shipping['shippingName'];?></td>
	<td><?=$shipping['shippingCost'];?></td>
	<td><?=$shipping['shippingTime'];?></td>
	<td><a href="#" onclick="jQuery('#edit_<?=$shipping['shippingID'];?>').slideToggle();jQuery('#configEdit_<?=$shipping['shippingID'];?>').ajaxForm(options);return false;"><?=$SHOP_TRANS['edit'];?></a>&nbsp;&nbsp;<a href="#shopShippingsAdmin?del=<?=$shipping['shippingID'];?>" onclick="if(!confirm('<?=$SHOP_TRANS['you_sure'];?>?'))return false;"><?=$SHOP_TRANS['del'];?></a></td>
	</tr>
	<tr id="edit_<?=$shipping['shippingID'];?>" style="display:none;">
	<td colspan="5">
	<form id="configEdit_<?=$shipping['shippingID'];?>" method="POST" action="<?=$PHP_SELF;?>?edit=<?=$shipping['shippingID'];?>">
	<table class="ConfigAdmin">
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shipping_label'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="shippingName" value="<?=$shipping['shippingName'];?>" />
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shipping_price'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="shippingCost" value="<?=$shipping['shippingCost'];?>" />
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shipping_time'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="shippingTime" value="<?=$shipping['shippingTime'];?>" />
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['default'];?>: </td><td align="<?=$SITE[align];?>"><input type="checkbox" name="default" value="1" <?=($shipping['default'] == 1) ? 'CHECKED' : '';?>/>
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['discounts'];?>: </td><td align="<?=$SITE[align];?>">
	<? $discounts = unserialize($shipping['discounts']);
	if(!is_array($discounts))
		$discounts = array();
	foreach($discounts as $min_price => $discount){ ?>
	<div style="margin-bottom:5px;"><?=$SHOP_TRANS['min_price'];?>: <input class="ConfigAdminInput" type="text" name="discounts_mins[]" value="<?=$min_price;?>" style="width:110px" />&nbsp;<?=$SHOP_TRANS['discount'];?>: <input class="ConfigAdminInput" type="text" name="discounts[]" value="<?=$discount;?>" style="width:110px" /></div>
	<? } ?>
	<div style="margin-bottom:5px;"><?=$SHOP_TRANS['min_price'];?>: <input class="ConfigAdminInput" type="text" name="discounts_mins[]" value="0" style="width:110px" />&nbsp;<?=$SHOP_TRANS['discount'];?>: <input class="ConfigAdminInput" type="text" name="discounts[]" value="0" style="width:110px" /></div>
	<a href="#" onclick="jQuery(this).before('<div style=\'margin-bottom:5px;\'>'+jQuery(this).prev().html()+'</div>');return false;"><?=$SHOP_TRANS['more_discounts'];?></a>
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
<td colspan="5"><a id="newSaveIcon" class="add_button" href="#" onclick="jQuery('#add_shipping').slideToggle();return false;"><i class="fa fa-truck"></i>&nbsp;<?=$SHOP_TRANS['add_new'];?></td>
</tr>
<tr id="add_shipping" style="display:none;">
<td colspan="5">
<form id="config" method="POST" action="<?=$PHP_SELF;?>?add=1">
<table class="ConfigAdmin">
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shipping_label'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="shippingName" />
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shipping_price'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="shippingCost" value="0" />
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shipping_time'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="shippingTime" />
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['default'];?>: </td><td align="<?=$SITE[align];?>"><input type="checkbox" name="default" value="1" />
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['discounts'];?>: </td><td align="<?=$SITE[align];?>">
<div style="margin-bottom:5px;"><?=$SHOP_TRANS['min_price'];?>: <input class="ConfigAdminInput" type="text" name="discounts_mins[]" value="0" style="width:110px" />&nbsp;<?=$SHOP_TRANS['discount'];?>: <input class="ConfigAdminInput" type="text" name="discounts[]" value="0" style="width:110px" /></div>
<a href="#" onclick="jQuery(this).before('<div style=\'margin-bottom:5px;\'>'+jQuery(this).prev().html()+'</div>');return false;"><?=$SHOP_TRANS['more_discounts'];?></a>
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

</table>
</div>

<? include_once("footer.inc.php"); ?>