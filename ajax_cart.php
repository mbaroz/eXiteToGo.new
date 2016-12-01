<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");

if(isset($_GET['lang']))
{
	session_start();
	if (!isset($_SESSION['SITE_LANG'])) session_register('SITE_LANG');
	$_SERVER['REQUEST_URI'] = '/'.substr(urlencode($_GET['lang']),0,2).'/ajax_cart.php';
	$SITE_LANG[selected] = substr(urlencode($_GET['lang']),0,2);
}

include_once("config.inc.php");
require_once('inc/ProductsShop.inc.php');

if(isset($_GET['lang']))
{
	if($_GET['lang'] == 'he')
	{
		$SITE['align'] = 'right';
		$SITE['opalign'] = 'left';
	}
	else
	{
		$SITE['align'] = 'left';
		$SITE['opalign'] = 'right';
	}
}


$pay_types = array(
	'paypal' => 'PayPal',
	'phone' => $SHOP_TRANS['pay_type_phone'],
	'tranzila' => 'Tranzila',
	'hand' => $SHOP_TRANS['pay_type_hand'],
);

$cart = (isset($_SESSION['ShoppingCart']) && $_SESSION['ShoppingCart']) ? $_SESSION['ShoppingCart'] : array();

$allowed_pay_types = array('paypal','phone','tranzila');

switch($_POST['action'])
{
	case 'massAddToCart':
		$ProductID = intval($_POST['ProductID']);
		if($ProductID > 0)
		{
			foreach($_POST['lineNumbers'] as $lineNumber)
			{
				$quantity = intval($_POST['quantity_'.$lineNumber]);
				if(CheckCartQuantity($ProductID,$quantity))
				{
					$p_attrs = array();
					foreach($_POST['attrs_'.$lineNumber] as $attr)
					{
						$attr = explode(':',$attr);
						$p_attrs[$attr[0]] = $attr[1];
					}
					$s_attrs = serialize($p_attrs);
					$key = md5($ProductID.'_'.$s_attrs);
					if(!isset($cart[$key]))
						$cart[$key] = array('ProductID' => $ProductID,'count' => $quantity,'attrs' => $s_attrs);
					else
						$cart[$key]['count']+=$quantity;
					$_SESSION['ShoppingCart'] = $cart;
					echo 'OK';
				}
			}
		}
		break;
	case 'addToCart':
		$ProductID = intval($_POST['ProductID']);
		$quantity = intval($_GET['quantity']);
		if($quantity < 1)
			$quantity = 1;
		if($ProductID > 0)
		{
			if(CheckCartQuantity($ProductID,$quantity))
			{
				$p_attrs = array();
				foreach($_POST['attrs'] as $attr)
				{
					$attr = explode(':',$attr);
					$p_attrs[$attr[0]] = $attr[1];
				}
				$s_attrs = serialize($p_attrs);
				$key = md5($ProductID.'_'.$s_attrs);
				if(!isset($cart[$key]))
					$cart[$key] = array('ProductID' => $ProductID,'count' => $quantity,'attrs' => $s_attrs);
				else
					$cart[$key]['count']+=$quantity;
				$_SESSION['ShoppingCart'] = $cart;
				echo 'OK';
			}
			else
				echo 'NOT_ENOUGH';
		}
		break;
	case 'incrementInCart':
		$cartKey = $_POST['cartKey'];
		if(isset($cart[$cartKey]))
		{
			$ProductID = $cart[$cartKey]['ProductID'];
			if(CheckCartQuantity($ProductID))
			{
				$cart[$cartKey]['count']++;
				$_SESSION['ShoppingCart'] = $cart;
				echo 'OK';
			}
			else
				echo 'NOT_ENOUGH';
		}
		break;
		
		
	case 'decrementInCart':
		$cartKey = $_POST['cartKey'];
		if(isset($cart[$cartKey]))
			$cart[$cartKey]['count']--;
		if($cart[$cartKey]['count'] == 0)
			unset($cart[$cartKey]);
		$_SESSION['ShoppingCart'] = $cart;
		break;
		
		
	case 'removeInCart':
		$cartKey = $_POST['cartKey'];
		unset($cart[$cartKey]);
		$_SESSION['ShoppingCart'] = $cart;
		break;
		
		
	case 'sendOrder':
		if(count($cart) > 0)
		{
			$db=new Database();
			$fullname = mysql_real_escape_string(@$_POST['fullname']);
			$phone = mysql_real_escape_string(@$_POST['phone']);
			$email = mysql_real_escape_string(@$_POST['email']);
			$contact_adres = mysql_real_escape_string(@$_POST['contact_adres']);
			$shipping_adres = mysql_real_escape_string(@$_POST['shipping_adres']);
			$shipping_name = mysql_real_escape_string(@$_POST['shipping_name']);
			$contact_additional = mysql_real_escape_string(@$_POST['contact_additional']);
			$countryID = intval(mysql_real_escape_string(@$_POST['countryID']));
			$shippingID = intval(mysql_real_escape_string(@$_POST['shippingID']));
			$VatNumber = mysql_real_escape_string(@$_POST['VatNumber']);
			$greetingText = mysql_real_escape_string(@$_POST['greetingText']);
			$memberNumber = mysql_real_escape_string(@$_POST['memberNumber']);
			
			$coupon = @$_SESSION['coupon'];
			$coupon_discount = floatval(@$_SESSION['coupon_discount']);
			
			if($countryID > 0)
			{
				$db->query("SELECT * FROM `shop_countries` WHERE `countryID`='{$countryID}'");
				if($db->nextRecord())
					$country = $db->record;
				else
					$countryID = 0;
			}
			
			if($VatNumber != '' && @$country['vatEffects'] == 1)
				$SITE['tax'] = 0;
			
			if($shippingID > 0)
			{
				$db->query("SELECT * FROM `shop_shippings` WHERE `shippingID`='{$shippingID}'");
				if($db->nextRecord())
					$shipping = $db->record;
				else
					$shippingID = 0;
			}
			
			$total_price = 0;
			$onlyProductID = 0;
			$items = addslashes(MakeOrderList());
			$ip = getIP();
			$order_hash = md5(microtime());
			
			if(@$_SESSION['coupon_type'] == 'percent')
				$coupon_discount = $total_price*(floatval(@$_SESSION['coupon_discount'])/100);
			$total_price_before_coupon=$total_price;	
			$total_price -= $coupon_discount;
			if($total_price < 0)
				$total_price = 0;
			
			$subtotal = $total_price + round($total_price*($SITE[tax]/100),2);
			$subtotal_before_coupon=$total_price_before_coupon + round($total_price*($SITE[tax]/100),2);
		
			$subtotal_sql = $subtotal;
			
			
			$pay_type = ($_POST['paypal'] == 1 && $SITE[paypal] != '') ? 'paypal' : $_POST['pay_type'];
			
			$shipping_cost = 0;
			
			if(@$country['countryCost'] > 0)
			{
				if(!$discounts = unserialize($country['discounts']))
					$discounts = array();
				$discount = makeDiscount($total_price,$discounts);
				$country['countryCost'] -= $discount;
				if($country['countryCost'] < 0)
					$country['countryCost'] = 0;
				$shipping_cost += $country['countryCost'];
			}
			if(@$shipping['shippingCost'] > 0)
			{
				if(!$discounts = unserialize($shipping['discounts']))
					$discounts = array();
				$discount = makeDiscount($total_price_before_coupon,$discounts);
				$shipping['shippingCost'] -= $discount;
				if($shipping['shippingCost'] < 0)
					$shipping['shippingCost'] = 0;
				$shipping_cost += $shipping['shippingCost'];
			}
			
			if($pay_type != 'paypal')
				$subtotal += $shipping_cost;
			
			if($pay_type == 'cc')
				$pay_type = 'tranzila';
			if(!in_array($pay_type,$allowed_pay_types))
				$pay_type = 'phone';
			$payments_num = isset($_POST['payments_num']) ? intval($_POST['payments_num']) : 1;
			if($payments_num < 1 || $payments_num > $SITE[max_payments_num])
				$payments_num = 1;
			if ($_COOKIE['partner_id'] AND $_COOKIE['partner_email']) 
				$db->query("INSERT INTO `shoporders` SET `date`='".time()."',`fullname`='{$fullname}',`phone`='{$phone}',`email`='{$email}',`adres`='{$contact_adres}',`additional`='{$contact_additional}',`items`='{$items}',`ip`='{$ip}',`total`='{$total_price}',`tax`='{$SITE['tax']}',`subtotal`='{$subtotal}',`status`='awaiting',`hash`='{$order_hash}',`pay_type`='{$pay_type}',`payments`='{$payments_num}',`shippingID`='{$shippingID}',`countryID`='{$countryID}',`shippingPrice`='{$shipping_cost}',`VatNumber`='{$VatNumber}',`onlyProductID`='{$onlyProductID}',`greetingText`='{$greetingText}',`shipping_name`='{$shipping_name}',`shipping_adres`='{$shipping_adres}',`memberNumber`='{$memberNumber}',`coupon`='{$coupon}',`coupon_discount`='{$coupon_discount}',`partner_id`='{$partner_id}',`partner_email`='{$partner_email}'");
			else $db->query("INSERT INTO `shoporders` SET `date`='".time()."',`fullname`='{$fullname}',`phone`='{$phone}',`email`='{$email}',`adres`='{$contact_adres}',`additional`='{$contact_additional}',`items`='{$items}',`ip`='{$ip}',`total`='{$total_price}',`tax`='{$SITE['tax']}',`subtotal`='{$subtotal}',`status`='awaiting',`hash`='{$order_hash}',`pay_type`='{$pay_type}',`payments`='{$payments_num}',`shippingID`='{$shippingID}',`countryID`='{$countryID}',`shippingPrice`='{$shipping_cost}',`VatNumber`='{$VatNumber}',`onlyProductID`='{$onlyProductID}',`greetingText`='{$greetingText}',`shipping_name`='{$shipping_name}',`shipping_adres`='{$shipping_adres}',`memberNumber`='{$memberNumber}',`coupon`='{$coupon}',`coupon_discount`='{$coupon_discount}'");
			$orderID = mysql_insert_id();
			$_SESSION['orderID'] = $orderID;
			$_SESSION['orderLink'] = 'http://'.$_SERVER['HTTP_HOST'].'/orderDetails.php?hash='.$order_hash.'&lang='.$SITE_LANG[selected];
			ReQuantityCart();
			switch($pay_type){
				case 'paypal':
					$item_name = $SITE[name].' ORDER';
					if(count($cart) == 1)
					{
						$product = array_pop(array_slice($cart,0,1));
						$db->query("
							SELECT
								`products`.`ProductTitle`
							FROM
								`products`
							WHERE
								`products`.`ProductID`='{$product['ProductID']}'
						");
						if($db->nextRecord())
							$item_name = $db->getField('ProductTitle');
					}
					
					$quant = 0;
					foreach($cart as $key => $item) {
						$quant += $item['count'];
					}
					if($quant > 0)
						$sub_q = round(($subtotal_before_coupon/$quant),2);
					else
						$sub_q = $subtotal;
						
					$currency = $currencies[$SITE[nis]]['paypal'];
					//if(!in_array($currency,array('USD','ILS',)))
					if($currency == '')
						$currency = 'ILS';
					$pp_locale="en_US";
					if ($SITE_LANG[selected]=="he") $pp_locale="he_IL";
					?>
					<form method="post" id="paypal_payment_form" action= "https://www.paypal.com/cgi-bin/webscr"> 
					<input type="hidden" name="cmd" value="_xclick"> 
					<input type="hidden" name="business" value="<?=$SITE[paypal];?>" /> 
					<input type="hidden" name="item_name" value="<?=$item_name;?>" /> 
					<input type="hidden" name="item_number" value="<?=$SITE_LANG['selected'];?>-<?=$orderID;?>" /> 
					<input type="hidden" name="amount" value="<?=$sub_q;?>" /> 
					<input type="hidden" name="no_shipping" value="0" /> 
					<input type="hidden" name="notify_url" value="<?=$SITE[url];?>/paypal/payment_verify.php" /> 
					<input type="hidden" name="return" value="<?=$SITE[url];?>/category/order-complete" />
					<input type="hidden" name="rm" value="2" /> 
					<input type="hidden" name="cancel_return" value="<?=$SITE[url];?>" /> 
					<input type="hidden" name="currency_code" value="<?=$currency;?>" />
					<input type="hidden" name="locale.x" value="<?=$pp_locale;?>" />
					<? if($coupon_discount > 0){ ?> 
					<input type="hidden" name="discount_amount" value="<?=$coupon_discount;?>" /> 
					<? } ?>
					
					<? if($shipping_cost > 0){ ?> 
					<input type="hidden" name="shipping" value="<?=$shipping_cost;?>" /> 
					<? } ?>
					<input type="hidden" name="rm" value="2" /> 
					<INPUT TYPE="hidden" name="charset" value="utf-8" />
					<? if($quant > 0){ ?><INPUT TYPE="hidden" name="quantity" value="<?=$quant;?>"><? } ?>
					<input type="submit" value="Checkout">  
					</form>
					<?
					break;
				case 'tranzila':
					$item_name = $SITE[name].' ORDER';
					if(count($cart) == 1)
					{
						$product = array_pop(array_slice($cart,0,1));
						$db->query("
							SELECT
								`products`.`ProductTitle`
							FROM
								`products`
							WHERE
								`products`.`ProductID`='{$product['ProductID']}'
						");
						$db->nextRecord();
						$item_name = $db->getField('ProductTitle');
					}
					
					$quant = 0;
					foreach($cart as $key => $item) {
						$quant += $item['count'];
					}
					
					$currency = $currencies[$SITE[nis]]['tranzila'];
					if($currency == '')
						$currency = '1';
					
					?>
					<form id="paypal_payment_form" action="https://direct.tranzila.com/<?=$SITE['tranzila_merchant'];?>/" method="post">
					<input type="hidden" name="sum" value="<?=$subtotal;?>" />
					<input type="hidden" name="pdesc" value="<?=$item_name;?>" />
					<input type="hidden" name="contact" value="<?=$fullname;?>" /> 
					<input type="hidden" name="email" value="<?=$email;?>" /> 
					<input type="hidden" name="phone" value="<?=$phone;?>" />
					<input type="hidden" name="address" value="<?=$contact_adres;?>" />
					<input type="hidden" name="remarks" value="<?=$contact_additional;?>" />
					<input type="hidden" name="TranzilaToken" value="<?=$SITE_LANG['selected'];?>-<?=$orderID;?>" />
					<input type="hidden" name="tranzilasecret" value="<?=$SITE['tranzila_secret'];?>" />
					<input type="hidden" name="currency" value="<?=$currency;?>" />
					<? if($payments_num ==1){ ?>
					<input type="hidden" name="cred_type" value="1" />
					<? } else { 
						if($SITE[payments_type] == 6) {?>
						<input type="hidden" name="cred_type" value="6" />
						<input type="hidden" name="npay" value="<?=$payments_num;?>" />
						<? } elseif($SITE[payments_type] == 8) { ?>
						<input type="hidden" name="cred_type" value="8" />
						<input type="hidden" name="npay" value="<?=($payments_num-1);?>" />
						<input type="hidden" name="fpay" value="<?=ceil($subtotal/$payments_num);?>" />
						<input type="hidden" name="spay" value="<?=ceil($subtotal/$payments_num);?>" />
						<? }
					} ?>
					</form>
					<?
					break;
				case 'phone':
				default:
					$admin_notify_mail=$SITE[shop_email];
					if (trim($admin_notify_mail)=="") $admin_notify_mail=$SITE[FromEmail];
					$order_list = '<table cellpadding="0" cellspacing="10" border="0">'.$items.'</table>';
	
					$replace = array(
						'http://'.$_SERVER['HTTP_HOST'].'/Admin/shopOrdersAdmin.php#order_'.$orderID,
						$fullname,
						$phone,
						$email,
						$contact_adres,
						$contact_additional,
						$subtotal,
						$order_list,
						$SITE['tax'],
						$total_price,
						$shipping_cost,
						$shipping_name,
						$shipping_adres,
						$pay_types[$pay_type],
						$greetingText,
						$memberNumber,
						$coupon,
						$coupon_discount,
						'http://'.$_SERVER['HTTP_HOST'].'/orderDetails.php?hash='.$order_hash.'&lang='.$SITE_LANG[selected]
					);
					$search = array(
						'%%admin_link%%',
						'%%fullname%%',
						'%%phone%%',
						'%%email%%',
						'%%adres%%',
						'%%additional%%',
						'%%total%%',
						'%%order_list%%',
						'%%tax%%',
						'%%before_tax%%',
						'%%shipping_price%%',
						'%%shipping_name%%',
						'%%shipping_adres%%',
						'%%payment_type%%',
						'%%greeting_text%%',
						'%%member_number%%',
						'%%coupon_code%%',
						'%%coupon_discount%%',
						'%%order_link%%'
					);
					$admin_email = '<html><body style="direction:';
					$admin_email .= ($SITE['align'] == 'right') ? 'rtl' : 'ltr';
					$admin_email .= ';">'.nl2br(str_replace($search,$replace,GetEmailText('adminNewOrder'))).'</body></html>';
					$replace = array(
						$fullname,
						$phone,
						$email,
						$contact_adres,
						$contact_additional,
						$subtotal,
						$order_list,
						$SITE[name],
						'http://'.$_SERVER['HTTP_HOST'].'/orderDetails.php?hash='.$order_hash.'&lang='.$SITE_LANG[selected],
						$SITE['tax'],
						$total_price,
						$shipping_cost,
						$shipping_name,
						$shipping_adres,
						$pay_types[$pay_type],
						$greetingText,
						$memberNumber,
						$coupon,
						$coupon_discount
					);
					$search = array(
						'%%fullname%%',
						'%%phone%%',
						'%%email%%',
						'%%adres%%',
						'%%additional%%',
						'%%total%%',
						'%%order_list%%',
						'%%site_name%%',
						'%%order_link%%',
						'%%tax%%',
						'%%before_tax%%',
						'%%shipping_price%%',
						'%%shipping_name%%',
						'%%shipping_adres%%',
						'%%payment_type%%',
						'%%greeting_text%%',
						'%%member_number%%',
						'%%coupon_code%%',
						'%%coupon_discount%%'
					);
					$costumer_email = '<html><body style="direction:';
					$costumer_email .= ($SITE['align'] == 'right') ? 'rtl' : 'ltr';
					$costumer_email .= ';">'.nl2br(str_replace($search,$replace,GetEmailText('costumerNewOrder'))).'<br/>'.GetProductFooterText($onlyProductID).'</body></html>';
					//$subject = 'הזמנה חדשה באתר '.$SITE[name];
					$subject = sprintf($SHOP_TRANS['new_order_at'],$orderID).$SITE['name'];
					sendHTMLemail($admin_notify_mail, $subject, $SITE[name].' <'.$SITE[FromEmail].'>', $admin_email,"");
					sendHTMLemail($email, $subject, $SITE[name].' <'.$SITE[FromEmail].'>', $costumer_email,"");
					$_SESSION['ShoppingCart'] = array();
					break;
			}
		}
		else
			echo 'error:'.$SHOP_TRANS['your_cart_is_empty'];
		break;
}

if($_GET['showit'] == 1)
{
	if($SITE[shopCartQtyArrows] == '')
		$SITE[shopCartQtyArrows] = $SITE[url].'/images/qty_arrows.png';
	else
		$SITE[shopCartQtyArrows] = SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$SITE[shopCartQtyArrows];
	if(count($cart) == 0)
	{
		?>
			<br/>
			<center><?=$SHOP_TRANS['your_cart_is_empty'];?></center>
		<?
	}
	else
	{
		$total_price = 0;
		if($SITE[shopCartBottom] != 2) {
		?>
		<table <?=(isset($_GET['orderPage'])) ? 'cellpadding="10" cellspacing="0" border="1" bordercolor="#'.$SITE[contenttextcolor].'"' : 'cellpadding="0" cellspacing="0" border="0"';?> width="100%">
			<?=MakeOrderList(!isset($_GET['orderPage']));?>
			<? $show_price = ($SITE[tax] > 0) ? $total_price+round($total_price*($SITE[tax]/100),2) : $total_price;
			$colspan = ($SITE[shopCartBottomPics] == 1) ? 3 : 2; ?>
			<? if(isset($_GET['orderPage']) && $SITE[tax] > 0 && $SITE['showWithTax'] == 0) { ?>
			<tr>
				<td colspan="<?=$colspan;?>" align="<?=$SITE[opalign];?>"><b><?=$SHOP_TRANS['tax'];?>:</b></td>
				<td align="<?=$SITE[opalign];?>"><b><?=show_price_side(round($total_price*($SITE[tax]/100),2));?></b></td>
			</tr>
			<? } ?>
			<tr>
				<td colspan="<?=$colspan;?>" align="<?=$SITE[opalign];?>" style="border:none"><b><?=$SHOP_TRANS['total'];?>:</b></td>
				<td align="<?=$SITE[opalign];?>" style="border:none"><b><?=show_price_side($show_price);?></b></td>
			</tr>
		</table>
		
		<?
		} else {
			$unpackedCart = getCartContents();
			echo '<div style="overflow:auto;width:680px;float:'.$SITE[opalign].';padding:10px 0 30px;margin-'.$SITE[opalign].':15px;" id="theCartItems">';
			$i = 0;
			$all = 0;
			foreach($unpackedCart as $key => $item) {
				$i++;
				$all++;
				$p_a = '';
				if(is_array(@$item['text_attrs']))
					$p_a = implode(', ',$item['text_attrs']);
					/* foreach($item['text_attrs'] as $AttributeID => $ValueText)
						$p_a .= $ValueText.', '; */
				//$p_a = substr($p_a,0,-2);
				$c_form = '<a href="#" class="plusMinus" onclick="IncrementItemInCart(\''.$key.'\');return false;">+</a>&nbsp;<span id="count_'.$key.'">'.$item['count'].'</span>&nbsp;<a href="#" class="plusMinus" onclick="DecrementItemInCart(\''.$key.'\');return false;">-</a>';
				if($SITE[shopCartQtyArrows] != '')
				{
					$c_form = '<div style="float:left;margin-right:10px;" id="count_'.$key.'">'.$item['count'].'</div><div style="float:left;background:url('.$SITE[shopCartQtyArrows].') no-repeat;width:35px;height:15px;"><a href="#" onclick="IncrementItemInCart(\''.$key.'\');return false;" style="float:left;display:block;width:50%;height:100%"></a><a href="#" onclick="DecrementItemInCart(\''.$key.'\');return false;" style="float:left;display:block;width:50%;height:100%"></a></div><div style="clear:both"></div>';
				}
				// changed to SITE_MEDIA to support amazon
				$c_name = '<a href="'.$SITE[url].'/shop_product/'.$item['prod_url'].'" style="color:#'.$SITE[shopCartTextColor].'">%s</a>';
				$img_url= ($item['ProductPhotoName'] != '') ? SITE_MEDIA.'/'.$gallery_dir.'/products/thumb_'.$item['ProductPhotoName'] : '';
				echo '<div class="cItem theItem" style="float:'.$SITE[align].';width:100px;margin-'.$SITE[opalign].':10px;margin-bottom:20px;color:#'.$SITE[shopCartTextColor].';position:relative;">';
				if($SITE['cartRemoveButton'] != '')
					echo '<a style="display:block;position:absolute;top:10px;right:10px;" href="#" onclick="RemoveItemInCart(\''.$key.'\');return false;"><img src="'.SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$SITE['cartRemoveButton'].'" border="0" /></a>';
				echo '<div style="';
				if($SITE[cartProductPicBorderColor] != '')
					echo 'border:3px solid #'.$SITE[cartProductPicBorderColor].';';
				echo 'height:94px;overflow:hidden;text-align:center;margin-bottom:5px;background:#'.$SITE[cartProductPicBgColor].';">
						<a href="'.$SITE[url].'/shop_product/'.$item['prod_url'].'"><img src="'.$img_url.'" style="max-height:94px;max-width:94px" border="0" /></a>
					</div>
					<div class="theName" style="text-align:center;word-wrap:break-word"><b>'.sprintf($c_name,$item['prod_name']).'</b><br/><small>'.$p_a.'</small></div>
					<div style="text-align:center;padding:5px 0;color:#'.$SITE[shopCartTextColor].';width:60px;margin:0 auto;">'.$c_form.'</div>
					<center>'.show_price_side($item['prod_price'] * $item['count']).'</center>
				</div>';
				if($i == 6)
				{
					$i = 0;
					if($all < count($unpackedCart))
						echo '<div style="clear:both;height:1px;background:#'.$SITE[shopCartTextColor].';margin-bottom:20px;"></div>';
				}
			}
			echo '<div style="clear:both;"></div></div>
			<div style="float:'.$SITE[align].';width:227px;padding:10px;background:#'.$SITE[shopCartBottomLabelBg].';';
			if ($SITE[roundcorners]==1)
				echo 'border-bottom-left-radius:5px;border-bottom-right-radius:5px;';
			echo '">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">';
			$show_price = ($SITE[tax] > 0) ? $total_price+round($total_price*($SITE[tax]/100),2) : $total_price;
					if($SITE[tax] > 0 && $SITE['showWithTax'] == 0) {
					echo '<tr>
						<td align="'.$SITE[opalign].'"><b>'.$SHOP_TRANS['tax'].':</b></td>
						<td align="'.$SITE[opalign].'"><b>'.show_price_side(round($total_price*($SITE[tax]/100),2)).'</b></td>
					</tr>';
					}
					echo '<tr>
						<td align="'.$SITE[opalign].'" style="border:none"><b>'.$SHOP_TRANS['total'].':</b></td>
						<td align="'.$SITE[opalign].'" style="border:none"><b>'.show_price_side($show_price).'</b></td>
					</tr>
					<tr>
						<td colspan="2" align="center" style="border:none"><input type="button" id="cart_order_button" onclick="submitOrder();" value="';
						if($SITE[shopButtonOrderImage] == '')
							echo $SHOP_TRANS['to_pay'];
						$orderButClass = 'shopButton';
						if($SITE[shopButtonOrderImage] != '')
							$orderButClass = 'orderButton';
						echo '" class="'.$orderButClass.'" style="float:none;margin:0;display:inline;" /></td> 
					</tr>
				</table>
			</div>
			<div style="clear:both;"></div>
			</div>';
		}
		
	}
}

function MakeOrderList($for_cart = false) {
	global $total_price,$cart,$SITE,$gallery_dir,$onlyProductID,$SHOP_TRANS;
	
	$unpackedCart = getCartContents();
	
	$onlyFound = true;
	
	foreach($unpackedCart as $key => $item) {
		if($onlyProductID == 0)
			$onlyProductID = $item['ProductID'];
		if($onlyProductID != $item['ProductID'])
			$onlyFound = false;
		$p_a = '';
		if(is_array(@$item['text_attrs']))
			$p_a = implode(', ',$item['text_attrs']);
			/* foreach($item['text_attrs'] as $AttributeID => $ValueText)
				$p_a .= $ValueText.', '; */
		//$p_a = substr($p_a,0,-2);
		if($p_a != '')
			$p_a = '<br/><small>'.$p_a.'</small>';
		$p_d = ($item['ProductShortDesc'] != '') ? '<br/><small>'.$item['ProductShortDesc'].'</small>' : '';
		$c_form = '<a href="#" class="plusMinus" onclick="IncrementItemInCart(\''.$key.'\');return false;">+</a>&nbsp;<span id="count_'.$key.'">'.$item['count'].'</span>&nbsp;<a href="#" class="plusMinus" onclick="DecrementItemInCart(\''.$key.'\');return false;" style="vertical-align:10%;">-</a>';
		if($SITE[shopCartQtyArrows] != '')
		{
			$c_form = '<div style="float:left;margin-right:10px;" id="count_'.$key.'">'.$item['count'].'</div><div style="float:left;background:url('.$SITE[shopCartQtyArrows].') no-repeat;width:35px;height:15px;"><a href="#" onclick="IncrementItemInCart(\''.$key.'\');return false;" style="float:left;display:block;width:50%;height:100%"></a><a href="#" onclick="DecrementItemInCart(\''.$key.'\');return false;" style="float:left;display:block;width:50%;height:100%"></a></div><div style="clear:both"></div>';
		}
		$item_price_label='';
		if(!$for_cart) {
			$c_form = '&nbsp;'.$SHOP_TRANS['quantity'].': '.$item['count'].'&nbsp;';
			$item_price_label=$SHOP_TRANS['price'].': '; 
		}
		// changed to SITE_MEDIA to support amazon
		$c_name = '<a href="'.$SITE[url].'/shop_product/'.$item['prod_url'].'">%s</a>';
		
		$return .= '<tr class="cItem">';
		if($for_cart && $SITE[shopCartBottomPics] == 1)
		{
			$img_url= ($item['ProductPhotoName'] != '') ? sprintf($c_name,'<img src="'.SITE_MEDIA.'/'.$gallery_dir.'/products/thumb_'.$item['ProductPhotoName'].'" border="0" style="max-width:60px;max-height:45px;#position: relative; #top: -50%" />') : '';
			$return .= '<td width="60"><div style="display: table;#position: relative;margin:5px;width:60px;height:45px;overflow:hidden;';
			$style = '';
			if($SITE[cartProductPicBorderColor] != '')
				$style .= 'border:3px solid #'.$SITE[cartProductPicBorderColor].';';
			if($SITE[cartProductPicBgColor] != '')
				$style .= 'background:#'.$SITE[cartProductPicBgColor].';';
			if($style != '')
				$return .= $style;
			$return .= '"><div style=" #position: absolute; #top: 50%;display: table-cell; vertical-align: middle;text-align:center;">'.$img_url.'</div></div></td>';
		}
			$return  .= '<td>'.sprintf($c_name,$item['prod_name']).$p_d.$p_a.'</td>
			<td width="70">'.$c_form.'</td>
			<td align="'.$SITE[opalign].'">'.$item_price_label.show_price_side($item['prod_price'] * $item['count']).'</td>';
		if($SITE['cartRemoveButton'] != '' && $for_cart)
			$return .= '<td valign="middle"><a href="#" onclick="RemoveItemInCart(\''.$key.'\');return false;"><img src="'.SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$SITE['cartRemoveButton'].'" border="0" /></a></td>';
		$return .= '</tr>';
	}
	if(!$onlyFound)
		$onlyProductID = 0;
	return $return;
}

function CheckSelectedAttributes($ProductID,$Attributes) {
	//$db=new Database();
	 //$db->query("SELECT `AttributeName` FROM `categories_attributes` LEFT JOIN `items_attributes` ON WHERE `ProductID`='{$ProductID}' AND `AttributeID` >= {$quantity}");
	//if($db->nextRecord())
	//return true;

}

function CheckCartQuantity($ProductID,$n_quantity = 1)
{
	global $cart;
	$quantity = 0;
	foreach($cart as $key => $item)
		if($item['ProductID'] == $ProductID)
			$quantity += $item['count'];
	$quantity+=$n_quantity;
	$db=new Database();
	$db->query("SELECT `ProductID` FROM `products` WHERE `ProductID`='{$ProductID}' AND `quantity` >= {$quantity}");
	if($db->nextRecord())
		return true;
	return false;
}

function ReQuantityCart()
{
	global $cart;
	$quants = array();
	foreach($cart as $key => $item)
	{
		if(!isset($quants[$item['ProductID']]))
			$quants[$item['ProductID']] = 0;
		$quants[$item['ProductID']] += $item['count'];
	}
	$update_sql = '';
	$update_ids = '';
	foreach($quants as $ProductID => $count)
	{
		$update_sql .= "WHEN {$ProductID} THEN {$count} ";
		$update_ids .= "'{$ProductID}',";
	}
	$update_ids = substr($update_ids,0,-1);
	$db=new Database();
	$db->query("UPDATE `products` SET `quantity`=`quantity`-(CASE `ProductID` {$update_sql} END) WHERE `ProductID` IN({$update_ids})");
}

function get_real_ip()
{
	if (isset($_SERVER["HTTP_CLIENT_IP"]))
		return $_SERVER["HTTP_CLIENT_IP"];
	elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
		return $_SERVER["HTTP_X_FORWARDED"];
	elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
		return $_SERVER["HTTP_FORWARDED_FOR"];
	elseif (isset($_SERVER["HTTP_FORWARDED"]))
		return $_SERVER["HTTP_FORWARDED"];
	else
		return $_SERVER["REMOTE_ADDR"];
}

function getIP()
{
	$ip = get_real_ip();
	$ex = explode(',',$ip);
	return $ex[0];
}
?>