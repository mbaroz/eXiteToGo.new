<?php
error_reporting(0);
@file_put_contents('tmp/tmp_'.$_SERVER['SERVER_NAME'].'_'.time(),print_r($_POST,true));
if($_POST['payment_status'] == 'Pending')
	die;
$postdata=""; 
foreach ($_POST as $key=>$value)
	$postdata.=$key."=".urlencode(stripslashes($value))."&";  
$postdata.="cmd=_notify-validate"; 
$curl = curl_init("https://www.paypal.com/cgi-bin/webscr"); 
curl_setopt ($curl, CURLOPT_HEADER, 0); 
curl_setopt ($curl, CURLOPT_POST, 1); 
curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata); 
curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 1); 
$response = curl_exec ($curl); 
curl_close ($curl);  
if ($response != "VERIFIED")
{
	file_put_contents('tmp/err'.time(),$response);
	//die; 
}

if(array_key_exists('charset', $_POST) && ($charset = $_POST['charset']))
{
    // Ignore if same as our default
    if($charset == 'utf-8')
        return;

    // Otherwise convert all the values
    foreach($_POST as $key => &$value)
    {
        $value = mb_convert_encoding($value, 'utf-8', $charset);
    }
}

$sel_lang = 'he';
$item_number = $_POST['item_number'];
$ex = explode('-',$item_number);
if(count($ex) == 2)
{
	$sel_lang = $ex[0];
	$item_number = $ex[1];
}
else
	$item_number = $ex[0];

$SITE_LANG[selected] = $sel_lang;

require_once '../config.inc.php';
require_once '../inc/ProductsShop.inc.php';

$FROM_EMAIL=explode(",",$SITE[FromEmail]);
$send_mail_from=ltrim($FROM_EMAIL[0]);
$admin_notify_mail=$SITE[shop_email];
if (trim($admin_notify_mail)=="") $admin_notify_mail=$SITE[FromEmail];
$payment_status = $_POST['payment_status'];
$payment_amount = round($_POST['mc_gross'],2);
$shipping = round($_POST['shipping'],2);
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];

$item_name = $_POST['item_name'];

$payer_email = $_POST['payer_email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address_zip  =$_POST['address_zip'];
$address_street = htmlspecialchars($_POST['address_street'],ENT_QUOTES);
$address_city = $_POST['address_city'];
$address_state = $_POST['address_state'];
$address_country = $_POST['address_country'];

$receiver_email = $_POST['receiver_email'];
$business_email=$_POST['business'];

if(!isset($db))
	$db = new Database();


$pay_types = array(
	'paypal' => 'PayPal',
	'phone' => $SHOP_TRANS['pay_type_phone'],
	'tranzila' => 'Tranzila',
	'hand' => $SHOP_TRANS['pay_type_hand'],
);

$db->query("SELECT `total`,`subtotal`,`items`,`hash`,`shippingPrice`,`additional`,`phone`,`partner_id`,`partner_email`,`onlyProductID`,`shipping_name`,`shipping_adres`,`pay_type`,`greetingText`,`memberNumber`,`coupon`,`coupon_discount` FROM `shoporders` WHERE `OrderID`='{$item_number}'");

if($db->nextRecord())
{
	$additional = $db->getField('additional');
	$OrderTotal = round($db->getField('total'),2);
	$subtotal = round($db->getField('subtotal'),2);
	$shipping_price = round($db->getField('shippingPrice'),2);
	$items = $db->getField('items');
	$order_hash = $db->getField('hash');
	$test_sum = round(($payment_amount - $shipping),2);
	$test_out = $subtotal - $test_sum;
	$phone = $db->getField('phone');
	$partner_id = $db->getField('partner_id');
	$partner_email = $db->getField('partner_email');
	$onlyProductID = $db->getField('onlyProductID');
	$shipping_adres = $db->getField('shipping_adres');
	$shipping_name = $db->getField('shipping_name');
	$pay_type = $db->getField('pay_type');
	$greetingText = $db->getField('greetingText');
	$memberNumber = $db->getField('memberNumber');
	$coupon = $db->getField('coupon');
	$coupon_discount = $db->getField('coupon_discount');
	
	$currency = $currencies[$SITE[nis]]['paypal'];
	if($currency == '')
		$currency = 'ILS';

	if (($OrderTotal > 0) && ($payment_status == 'Completed') && ($receiver_email == $SITE[paypal] OR $business_email==$SITE[paypal]) && ($payment_currency == $currency))
	{
		
		$fullname = $first_name.' '.$last_name;
		$contact_adres = $address_country.', '.$address_city.', '.$address_street.' ('.$address_zip.')';
		$shipping_add = ($shipping > 0) ? ",`subtotal`=`subtotal`+{$shipping}" : '';
		$db->query("UPDATE  `shoporders` SET `date`='".time()."',`fullname`='{$fullname}',`email`='{$payer_email}',`adres`='{$contact_adres}'{$shipping_add},`status`='payed' WHERE `OrderID`='{$item_number}'");
		$db->query("UPDATE `shop_coupons` SET `used`=`used`+1 WHERE `code`='{$coupon}'");
		$order_list = '<table cellpadding="0" cellspacing="10" border="0">'.$items.'</table>';
		$replace = array(
			'http://'.$_SERVER['HTTP_HOST'].'/Admin/shopOrdersAdmin.php#order_'.$item_number,
			$fullname,
			$phone,
			$payer_email,
			$contact_adres,
			$additional,
			$payment_amount,
			$order_list,
			$SITE['tax'],
			$OrderTotal,
			$shipping_price,
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
		$admin_email .= ($sel_lang == 'he') ? 'rtl' : 'ltr';
		$admin_email .= ';">'.nl2br(str_replace($search,$replace,GetEmailText('adminNewOrder'))).'</body></html>';
		$replace = array(
			$fullname,
			$phone,
			$payer_email,
			$contact_adres,
			$additional,
			$payment_amount,
			$order_list,
			$SITE[name],
			'http://'.$_SERVER['HTTP_HOST'].'/orderDetails.php?hash='.$order_hash.'&lang='.$SITE_LANG[selected],
			$SITE['tax'],
			$OrderTotal,
			$shipping_price,
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
		$costumer_email .= ($sel_lang == 'he') ? 'rtl' : 'ltr';
		$costumer_email .= ';">'.nl2br(str_replace($search,$replace,GetEmailText('costumerNewOrder'))).'<br/>'.GetProductFooterText($onlyProductID).'</body></html>';
		//$subject = 'הזמנה חדשה באתר '.$SITE[name];
		$subject = sprintf($SHOP_TRANS['new_order_at'],$item_number).$SITE['name'];
		sendHTMLemail($admin_notify_mail, $subject, $SITE[name].' <'.$send_mail_from.'>', $admin_email);
		sendHTMLemail($payer_email, $subject, $SITE[name].' <'.$send_mail_from.'>', $costumer_email);
		if(file_exists('../sites/'.$_SERVER['SERVER_NAME'].'/additional_processing_pp.php'))
		{
			require_once('../sites/'.$_SERVER['SERVER_NAME'].'/additional_processing_pp.php');
		}
		
	}
	else
	{
		//file_put_contents('last_err','('.$OrderTotal.' > 0) && ("'.$payment_status.'" == "Completed") && ("'.$receiver_email.'" == "'.$SITE[paypal].'") && ('.$test_out.' == 0) && ("'.$payment_currency.'" == "ILS")');
	}
	if($payment_status != 'Completed')
	{
		$error_details = $payment_status;
		if($payment_status == 'Pending')
			$error_details .= ' : '.$_POST['pending_reason'];
		$db->query("UPDATE  `shoporders` SET `fullname`='{$fullname}',`email`='{$payer_email}',`adres`='{$contact_adres}',`status`='error',`error_details`='{$error_details}' WHERE `OrderID`='{$item_number}'");
	}
}
?>