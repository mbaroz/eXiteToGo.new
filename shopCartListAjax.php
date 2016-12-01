<?
include_once("config.inc.php");
require_once('inc/ProductsShop.inc.php');
?>
<style type="text/css">
#orderList {
	color:#<?=$SITE[contenttextcolor];?>;
	padding:5px 10px 10px 10px;
	<? if($SITE['shopOrderListSide'] != 1){ ?>margin:0 0 20px 0;<? } else { ?>margin:0;<? } ?>
}

#orderList table tr td a {
	color:#<?=($SITE[cartListProductNameColor] != '') ? $SITE[cartListProductNameColor] : $SITE[linkscolor];?>;
	text-decoration:underline;
}

#orderList table tr td a.plusMinus {
	font-weight:bold;
	color:#<?=$SITE[titlescolor];?>;
	text-decoration: none;
}
</style>
<script>
	function UpdateCartListQty(cart_key) {
                
               var ship_price_calculated=parseInt(jQuery('#shipping_price').html());
                jQuery('#orderList').load('<?=$SITE[url];?>/shopCartListAjax.php?ship_price='+ship_price_calculated+'<?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>',function() {
			document.location.reload();
		});
              	
	}
</script>
<?
$SHOP_TRANS['choose_next']="Choose next";
if ($SITE_LANG[selected]=="he") $SHOP_TRANS['choose_next']="בחר בהמשך";
$cart = (isset($_SESSION['ShoppingCart']) && $_SESSION['ShoppingCart']) ? $_SESSION['ShoppingCart'] : array();
if($SITE[shopCartQtyArrows] == '')
	$SITE[shopCartQtyArrows] = $SITE[url].'/images/qty_arrows.png';
else
	$SITE[shopCartQtyArrows] = SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$SITE[shopCartQtyArrows];
if(@$_POST['coupon_code'] != '')
{
	if(!getCoupon($_POST['coupon_code']))
	{
		?><script type="text/javascript">alert('<?=$SHOP_TRANS['wrong_coupon'];?>!')</script><?
	}
	else
	{
		$_POST['coupon_code'] = '';
	}
}

$unpackedCart = getCartContents();
if(!isset($countries))
	$countries = getCountries();
if(!isset($shippings))
	$shippings = getShippings();

        

?>
<b style="font-size:16px;font-weight:bold;padding-<?=$SITE['align'];?>:5px;"><?=$SHOP_TRANS['my_shopping_cart'];?> (<?=count($unpackedCart);?>)</b><br/><br/>
<table width="100%" cellspacing="0" cellpadding="3" border="0">
<?php
echo '<tr>
		<td';
	if($SITE[cartListViewPics] == '1')
		echo ' colspan="2"';
echo ' style="border-bottom:1px dotted #'.$SITE[contenttextcolor].';"><b>'.$SHOP_TRANS['item_name'].'</b></td>
		<td style="border-bottom:1px dotted #'.$SITE[contenttextcolor].'"><b>'.$SHOP_TRANS['quantity'].'</b></td>
		<td style="border-bottom:1px dotted #'.$SITE[contenttextcolor].';text-align:center"><b>'.$SHOP_TRANS['price'].'</b></td>
	</tr>';

foreach($unpackedCart as $key => $item) {
	$p_a = '';
	if(is_array($item['text_attrs']))
	{
		/* foreach(@$item['text_attrs'] as $AttributeID => $ValueText)
			$p_a .= $ValueText.', '; */
		$p_a = implode(', ',$item['text_attrs']);
	}
	//$p_a = substr($p_a,0,-2);
	if($p_a != '')
		$p_a = '<br/><small>'.$p_a.'</small>';
	$p_d = ($item['ProductShortDesc'] != '' && $SITE['shopOrderListSide'] != 1) ? '<br/><small>'.$item['ProductShortDesc'].'</small>' : '';
	$c_form = '&nbsp;%d&nbsp;';
	$cart_qty_arrows = '<a href="#" class="plusMinus" onclick="IncrementItemInCart(\''.$key.'\');UpdateCartListQty(\''.$key.'\');return false;">+</a>&nbsp;<span id="count_'.$key.'">'.$item['count'].'</span>&nbsp;<a href="#" class="plusMinus" onclick="DecrementItemInCart(\''.$key.'\');return false;">-</a>';
	if($SITE[shopCartQtyArrows] != '') $cart_qty_arrows = '<div style="float:right;margin-left:10px;" id="count_'.$key.'">'.$item['count'].'</div><div style="float:right;background:url('.$SITE[shopCartQtyArrows].') no-repeat;width:35px;height:15px;"><a href="#" onclick="IncrementItemInCart(\''.$key.'\');UpdateCartListQty(\''.$key.'\');return false;" style="float:left;display:block;width:50%;height:100%"></a><a href="#" onclick="DecrementItemInCart(\''.$key.'\');UpdateCartListQty(\''.$key.'\');return false;" style="float:left;display:block;width:50%;height:100%"></a></div><div style="clear:both"></div>';

	$c_name = '<a href="'.$SITE[url].'/shop_product/'.$item['prod_url'].'">%s</a>';
	$img_url= ($item['ProductPhotoName'] != '') ? SITE_MEDIA.'/'.$gallery_dir.'/products/thumb_'.$item['ProductPhotoName'] : '';
	$img_code = '';
	if($img_url != ''){
		$img_code .= '<div style="';
		if($SITE[cartProductPicBgColor] != '')
			$img_code .= 'background:#'.$SITE[cartProductPicBgColor].';';
		$img_code .= 'float:'.$SITE[align].';margin:5px 0;"><a href="'.$SITE[media].'/shop_product/'.$item['prod_url'].'"><img src="'.$img_url.'" style="max-width:50px;';
		if($SITE[cartProductPicBorderColor] != '')
			$img_code .= 'border:1px solid #'.$SITE[cartProductPicBorderColor].';';
		$img_code .= '" /></a></div>';
	}
	$return .= '<tr>';
	if($SITE[cartListViewPics] == '1')
		$return .= '<td style="border-bottom:1px dotted #'.$SITE[contenttextcolor].'" width="60">'.$img_code.'</td>';
	$return .= '<td style="border-bottom:1px dotted #'.$SITE[contenttextcolor].'"';
	if($SITE['shopOrderListSide'] == 1 && $SITE[cartListViewPics] == '1')
		$return .= ' width="60"';
	$return .= '>';
	if($SITE['shopOrderListSide'] == 1 && $SITE[cartListViewPics] == '1')
		$return .= '<div style="width:60px;word-wrap:break-word;">';
	$return .= sprintf($c_name,$item['prod_name']).$p_a.$p_d;
	if($SITE['shopOrderListSide'] == 1 && $SITE[cartListViewPics] == '1')
		$return .= '</div>';
	$return .= '</td>
		<td style="border-bottom:1px dotted #'.$SITE[contenttextcolor].'">'.$cart_qty_arrows.'</td>
		<td style="border-bottom:1px dotted #'.$SITE[contenttextcolor].';text-align:center"><span id="prod_price_qty">'.show_price_side($item['prod_price'] * $item['count']).'</span></td>
	</tr>';
}

echo $return;
if($SITE[couponsEnabled] == 1){
	if(isset($_SESSION['coupon_discount'])) {
		$CouponDiscountCalc=$total_price*(floatval($_SESSION['coupon_discount'])/100);
		$total_price -= ($_SESSION['coupon_type'] == 'sum') ? floatval($_SESSION['coupon_discount']) : $total_price*(floatval($_SESSION['coupon_discount'])/100);
		if($total_price < 0)
			$total_price = 0;
	}
}
$show_price = $total_price+round($total_price*($SITE[tax]/100),2);
//if($total_price < 0){
?>
<script type="text/javascript">
var beforeTaxPrice = <?=floatval($total_price);?>;
var afterTaxPrice = <?=$show_price;?>;
var totalPrice = <?=$show_price;?>;
</script>
<?
//}
$colspan = 2;
if($SITE[cartListViewPics] == '1')
	$colspan = 3;
if($SITE[tax] > 0 && $SITE['showWithTax'] == 0) { ?>
<tr id="tax_row">
	<td colspan="<?=$colspan;?>" align="<?=$SITE[align];?>" style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>"><div class="longDescCartDiv" style="text-align:<?=$SITE[align];?>"><b><?=$SHOP_TRANS['tax'];?>:</b></div></td>
	<td style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>;text-align: center"><b><?=show_price_side(round($total_price*($SITE[tax]/100),2));?></b></td>
</tr>

<? } ?>
<? if(count($countries) > 0 || count($shippings) > 0) {
	$shipping_price = 0;
        
	if(count($countries) > 0 && !isset($country))
		$country = getDefaultSel($countries);
	if(count($shippings) > 0 && !isset($shipping)) {
		$shipping = getDefaultSel($shippings);
		$hasDefaultShipping=0;
		foreach($shippings as $whatDefault)
				if($whatDefault['default'] == 1) $hasDefaultShipping=1;
			if (!$hasDefaultShipping) $shipping=array('price'=>0,'name'=>$SHOP_TRANS['choose']);
	}
	if(isset($country))
		$shipping_price += $country['price'];
	if(isset($shipping))
		$shipping_price += $shipping['price'];
        if ($_GET['ship_price']!='') $shipping['price']=$shipping_price=$_GET['ship_price'];
	$show_price += $shipping_price;
        


	?>
<? if($SITE[couponsEnabled] == 1){
if(isset($_SESSION['coupon'])) { ?>
	<tr><td style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>;" align="<?=$SITE[align];?>"><b><?=$SHOP_TRANS['coupon'];?>:</b></td><td style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>;" colspan="<?=$colspan-1;?>" align="<?=$SITE[align];?>"><?=$_SESSION['coupon'];?><?=($_SESSION['coupon_type'] != 'sum') ? ' ('.$SHOP_TRANS['discount'].':  '.floatval($_SESSION['coupon_discount']).'%)' : '';?></td><td style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>;text-align: center"><b><?=($_SESSION['coupon_type'] == 'sum') ? show_price_side(floatval($_SESSION['coupon_discount'])) : show_price_side(floatval($CouponDiscountCalc));?> -</b></td></tr>
<? 
}} ?>
<?

?>
<tr>
	<td colspan="<?=$colspan;?>" align="<?=$SITE[align];?>" style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>"><div class="longDescCartDiv" style="text-align:<?=$SITE[align];?>"><b><?=$SHOP_TRANS['shipping_label'];?> <? if(count($countries) > 0){ ?>(<span id="country_name"><?=$country['name'];?></span><? } if(count($shippings) > 0){ if(count($countries) > 0){ ?>/<? }else{ ?>(<? } ?><span id="shipping_name"><?=$shipping['name'];?></span>)<? }else{ ?>)<? } ?>:</b></div></td>
	<td style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>;text-align: center"><b><?=show_price_side($shipping_price,false,'shipping_price');?></b></td>
</tr>
<? } ?>

<tr>
	<td colspan="<?=$colspan;?>" align="<?=$SITE[align];?>" style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>"><div class="longDescCartDiv" style="text-align:<?=$SITE[align];?>"><b><?=$SHOP_TRANS['total'];?>:</b></div></td>
	<td style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>;text-align: center"><b><?=show_price_side($show_price,false,'total_price');?></b></td>
</tr>

</table>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if (selectedShipping_ID==0) setShipping("0:0:<?=$SHOP_TRANS[choose_next];?>");
	});
</script>