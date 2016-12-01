<?
require_once 'inc/ProductsShop.inc.php';
if($CHECK_PAGE['parentID'] > 0)
{
	$ukey = GetUrlKeyFromID($CHECK_PAGE['parentID']);
	$cat_ukey = $ukey['UrlKey'];
	$attributes = GetCategoryAttributes($CHECK_PAGE['parentID'],true);
}
else
{
	$attributes = GetCategoryAttributes($urlKey);
	$cat_ukey = $urlKey;
}

$ok = false;
foreach($attributes as $id => $data)
	if(count($data['values']) > 1){
		$ok = true;
		break;
	}
if($ok)
{
?>
<style type="text/css">
	.ShopSearchBox {margin:<?=($SITE['align'] == 'right') ? '0 0 0 5px' : '0 5px 0 0px'; ?>;padding:10px 15px 10px 10px;}
	.ShopSearchBox .roundBox {width:100%;}
	<? if($SITE[shopAttrsSearchButton] != ''){
		$size = getimagesize($gallery_dir.'/sitepics/'.$SITE[shopAttrsSearchButton]); ?>
	.shopSearchButton {
		width:<?=$size[0];?>px;
		height:<?=$size[1];?>px;
		cursor:pointer;
		border:0;
		background:url(<?=$SITE[url];?>/<?=$gallery_dir;?>/sitepics/<?=$SITE[shopAttrsSearchButton];?>) no-repeat;
	}
	<? } ?>
	.onePx {
		width:1px;
	}
</style>
<div class="ShopSearchBox">
<? if ($SITE[roundcorners]==1) SetRoundedCorners(1,1,$SITE[formbgcolor]); ?>
<div style="background:#<?=$SITE[formbgcolor];?>;color:#<?=($SITE[shopSearchByAttrsTextColor] != '') ? $SITE[shopSearchByAttrsTextColor] : $SITE[formtextcolor];?>;padding-top:4px;">

<b style="font-size:16px;font-weight:bold;padding-<?=$SITE['align'];?>:5px;"><?=$SHOP_TRANS['search_by_attrs'];?></b><br/><br/>
<form action="<?=$SITE[url];?>/cat.php" method="GET" style="padding:0;margin:0;">
	<input type="hidden" name="urlKey" value="<?=$cat_ukey;?>" />
	<?=($SITE_LANG[selected] != 'he') ? '<input type="hidden" name="lang" value="'.$SITE_LANG[selected].'" />' : '';?>
	<table cellpadding="2" cellspacing="2" border="0" width="100%">
	<?
	foreach($attributes as $id => $data)
		if(count($data['values']) > 1){ ?>
		<tr>
			<td style="white-space:nowrap;" class="onePx"><b><?=$data['name'];?></b></td>
			<td><div style="padding-<?=$SITE['opalign'];?>:5px;"><select name="attr_<?=$id;?>" style="width:100%;border:1px;background-color: #<?=$SITE[shopSelectBg];?>;color:#<?=$SITE[shopSelectTextColor];?>;">
				<option value="0"><?=$SHOP_TRANS['all'];?></option>
		<? foreach($data['values'] as $vid => $value) { ?>
			<option value="<?=$vid;?>"<?=($_GET['attr_'.$id] == $vid) ? ' SELECTED' : '';?>><?=$value;?></option>
		<? } ?>
			</select></div></td>
		</tr>
	<? } ?>
	<tr>
		<td colspan="2" align="<?=$SITE[opalign];?>"><input type="submit" class="shopSearchButton" value="<?=($SITE[shopAttrsSearchButton] == '') ? $SHOP_TRANS['search'] : '';?>" /></td>
	</tr>
	</table>
</form>

</div>
<? if ($SITE[roundcorners]==1) SetRoundedCorners(0,1,$SITE[formbgcolor]); ?>
</div>
<? } ?>