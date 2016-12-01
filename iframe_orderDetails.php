<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <base target="_top">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-1.7.2.min.js"></script>
<style>
body {background:none;background-image:none;background-color:transparent;margin:0;padding:0;direction:<?=$SITE_LANG[direction];?>}
	.order {
		padding:20px;
		color:#<?=$SITE[contenttextcolor];?>;
		font-family: Arial;
		font-size:14px;
	}
	
		.order .title {
			font-size:20px;
			text-decoration: underline;
                        
		}
		
		.order .value {
			color:#<?=$SITE[formtextcolor];?>;
			font-weight: bold;
		}
		
		.order .value.payed {
			
		}
		
		.order .value.awaiting {
			color:#777777;
		}
		
		.order .value.delivered {
			color:#91B017;
		}
		
		.order .value.cancelled {
			color:red;
		}
		
		.order a {
			color:#<?=$SITE[formtextcolor];?>;
			text-decoration: underline;
		}
   
                table tr.cItem td {vertical-align: top}
                .order table {border-collapse:collapse}
                .order table tr {border-bottom: 1px solid silver}
</style>
</head>
<body>
<?
require_once 'inc/ProductsShop.inc.php';
$order_id_from_s=$_SESSION['orderID'];
//$order_id_from_s=84;
$db=new database();
$db->query("SELECT hash from shoporders WHERE OrderID='$order_id_from_s'");
$db->nextRecord();
$hash = mysql_real_escape_string($db->getField('hash'));
if(!$order = GetShopOrderByHash($hash))
{
	?><div class="order"><center><b><?=$SHOP_TRANS['order_not_found'];?></b></center></div><?
}
else
{
	$status_names = array(
		'awaiting' => $SHOP_TRANS['awaiting_payment'],
		'payed' => $SHOP_TRANS['payed'],
		'delivered' => $SHOP_TRANS['sent'],
		'cancelled' => $SHOP_TRANS['cancelled']
	);
?>
<div class="order">
	<div class="title"><?=$SHOP_TRANS['order'];?> <?=$order['OrderID'];?>#</div>
        <br>
	<table cellpadding="3" cellspacing="3">
		<tr>
			<td><?=$SHOP_TRANS['status'];?>:</td>
			<td class="value <?=$order['status'];?>"><?=$status_names[$order['status']];?></td>
		</tr>
		<tr>
			<td><?=$SHOP_TRANS['full_name'];?>:</td>
			<td class="value"><?=$order['fullname'];?></td>
		</tr>
		<tr>
			<td><?=$SHOP_TRANS['email'];?>:</td>
			<td class="value"><?=$order['email'];?></td>
		</tr>
		<tr>
			<td><?=$SHOP_TRANS['phone'];?>:</td>
			<td class="value"><?=$order['phone'];?></td>
		</tr>
		<tr>
			<td><?=$SHOP_TRANS['adress'];?>:</td>
			<td class="value"><?=$order['adres'];?></td>
		</tr>
                 <? if($order['shipping_adres']) { ?>
		<tr>
			<td><?=$SHOP_TRANS['shipping_name'];?>:</td>
			<td class="value"><?=$order['shipping_name'];?><br><small><?=$order['shipping_adres'];?></small></td>
		</tr>
		<? } ?>
		
                <? if($order['coupon']) { ?>
		<tr>
			<td><?=$SHOP_TRANS['coupon'];?>:</td>
			<td class="value"><?=$order['coupon_discount'];?>-</td>
		</tr>
		<? } ?>
		<? if($SITE[tax] > 0 && $SITE['showWithTax'] == 0){ ?>
		<tr>
			<td><?=$SHOP_TRANS['tax'];?>:</td>
			<td class="value"><?=show_price_side($order['subtotal']-$order['total']);?></td>
		</tr>
		<? } ?>
		<? if($order['shippingPrice'] > 0){ ?>
		<tr>
			<td><?=$SHOP_TRANS['shipping_label'];?><? if($order['countryID'] > 0){ ?>(<?=$order['countryName'];?><? } if($order['shippingID'] > 0){ if($order['countryID'] < 1){  ?>(<? }else{ ?>/<? } ?><?=$order['shippingName'];?>)<? }else{ ?>)<? } ?></td>
			<td class="value"><?=show_price_side($order['shippingPrice']);?></td>
		</tr>
		<? } ?>
		<tr>
			<td><?=$SHOP_TRANS['total'];?>:</td>
			<td class="value"><?=show_price_side($order['subtotal']);?></td>
		</tr>
                <tr>
			<td><?=$SHOP_TRANS['notes'];?>:</td>
			<td class="value"><?=$order['additional'];?></td>
		</tr>
                 <? if($order['greetingText']) { ?>
		<tr>
			<td><?=$SHOP_TRANS['greeting_text'];?>:</td>
			<td class="value"><?=$order['greetingText'];?></td>
		</tr>
		<? } ?>
		<tr>
			<td valign="top"><?=$SHOP_TRANS['items'];?>:</td>
			<td style="font-size:12px;">
				<table cellspacing="2" cellpadding="2" border="0"><?=$order['items'];?></table>
			</td>
		</tr>
	</table>
</div>
<?
}
?>
<script>
     var order_iframe_height=jQuery(".order").height()+50;
	jQuery("#oDetails",parent.document.body).height(order_iframe_height+"px");
</script>
</body>
</html>