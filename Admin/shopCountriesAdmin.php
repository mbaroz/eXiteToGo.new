<?
//General Config Form
include_once("checkAuth.php");
include("colorpicker.php");

$db=new Database();

if(@$_GET['del'] > 0)
{
	$db->query("DELETE FROM `shop_countries` WHERE `countryID`='{$_GET['del']}'");
	print "Done!";
	//die;
}

if(@$_GET['edit'] > 0)
{
	if(trim(@$_POST['countryName']) != '')
	{
		if(!isset($_POST['default']))
			$_POST['default'] = 0;
		if(!isset($_POST['vatEffects']))
			$_POST['vatEffects'] = 0;
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
		$db->query("UPDATE `shop_countries` SET `countryName`='{$_POST['countryName']}',`countryCost`='{$_POST['countryCost']}',`default`='{$_POST['default']}',`vatEffects`='{$_POST['vatEffects']}',`discounts`='{$discounts}' WHERE `countryID`='{$_GET['edit']}'");
		if($_POST['default'] == 1)
			$db->query("UPDATE `shop_countries` SET `default`='0' WHERE `countryID`!='{$_GET['edit']}'");
	}
	print "Done !";
	die;
}

if(@$_GET['add'] == 1)
{
	if(trim(@$_POST['countryName']) != '')
	{
		if(!isset($_POST['default']))
			$_POST['default'] = 0;
		if(!isset($_POST['vatEffects']))
			$_POST['vatEffects'] = 0;
		if($_POST['default'] == 1)
			$db->query("UPDATE `shop_countries` SET `default`='0'");
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
		$db->query("INSERT INTO `shop_countries` SET `countryName`='{$_POST['countryName']}',`countryCost`='{$_POST['countryCost']}',`default`='{$_POST['default']}',`vatEffects`='{$_POST['vatEffects']}',`discounts`='{$discounts}'");
	}
	print "Done !";
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
<br/><br/>
<style type="text/css">
table {width:800px;}
</style>
<div style="margin-right:5px;">
<table class="ConfigAdmin listTable" border="0" style="border-collapse:;" cellpadding="3" cellspacing="4">
<tr style="background-color:#efefef;font-weight:bold;">
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['country_name'];?></td>
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['shipping_price'];?></td>
<td align="<?=$SITE[align];?>"><?=$SHOP_TRANS['vat_effects'];?></td>
<td align="<?=$SITE[align];?>"></td>
</tr>
<?
$db = new Database();
$db->query("
	SELECT
		*
	FROM
		`shop_countries`
	ORDER BY
		`countryName` ASC
");
while($db->nextRecord())
{
	$country = $db->record;
	?>
	<tr<?=($country['default'] == 1) ? ' style="font-weight:bold;"' : '';?>>
	<td><?=$country['countryName'];?></td>
	<td><?=$country['countryCost'];?></td>
	<td><?=$country['vatEffects'];?></td>
	<td><a href="#" onclick="jQuery('#edit_<?=$country['countryID'];?>').slideToggle();jQuery('#configEdit_<?=$country['countryID'];?>').ajaxForm(options);return false;"><?=$SHOP_TRANS['edit'];?></a>&nbsp;&nbsp;<a href="#shopCountriesAdmin?del=<?=$country['countryID'];?>" onclick="if(!confirm('<?=$SHOP_TRANS['you_sure'];?>?'))return false;"><?=$SHOP_TRANS['del'];?></a></td>
	</tr>
	<tr id="edit_<?=$country['countryID'];?>" style="display:none;">
	<td colspan="3">
	<form id="configEdit_<?=$country['countryID'];?>" method="POST" action="<?=$PHP_SELF;?>?edit=<?=$country['countryID'];?>">
	<table class="ConfigAdmin">
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['country_name'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="countryName" value="<?=$country['countryName'];?>" />
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shipping_price'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="countryCost" value="<?=$country['countryCost'];?>" />
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['vat_effects'];?>: </td><td align="<?=$SITE[align];?>"><input type="checkbox" name="vatEffects" value="1" <?=($country['vatEffects'] == 1) ? 'CHECKED' : '';?>/>
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['default'];?>: </td><td align="<?=$SITE[align];?>"><input type="checkbox" name="default" value="1" <?=($country['default'] == 1) ? 'CHECKED' : '';?>/>
	</td>
	</tr>
	<tr>
	<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['discounts'];?>: </td><td align="<?=$SITE[align];?>">
	<? $discounts = unserialize($country['discounts']);
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
<td colspan="5"><a id="newSaveIcon" class="add_button" href="#" onclick="jQuery('#add_country').slideToggle();return false;"><i class="fa fa-truck"></i>&nbsp;<?=$SHOP_TRANS['add_new'];?></td>
</tr>
<tr id="add_country" style="display:none;">
<td colspan="4">
<form id="config" method="POST" action="<?=$PHP_SELF;?>?add=1">
<table class="ConfigAdmin">
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['country_name'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="countryName" />
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shipping_price'];?>: </td><td align="<?=$SITE[align];?>"><input class="ConfigAdminInput" type="text" name="countryCost" value="0" />
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['vat_effects'];?>: </td><td align="<?=$SITE[align];?>"><input type="checkbox" name="vatEffects" value="1" />
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