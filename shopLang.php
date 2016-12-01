<?php
 $currencies = array(
	'NIS' => array(
		'paypal' => 'ILS',
		'tranzila' => '1',
	),
	'USD' => array(
		'paypal' => 'USD',
		'tranzila' => '2',
	),
	'EUR' => array(
		'paypal' => 'EUR',
		'tranzila' => '7',
	),
);
if(!isset($SITE_LANG['selected']))
	$SITE_LANG['selected'] = 'he';
	if (!$SHP_LANG=getCacheResult('shop_lang',$m)) {
	        $SHOP_TRANS = array();
	        $db=new Database();
	        $db->query("SELECT * FROM `shop_lang` WHERE `lang`='{$SITE_LANG['selected']}'");
	        while($db->nextRecord())
	            $SHOP_TRANS[$db->getField('label')]=$db->getField('text');

	        if ($SITE_LANG['selected']=="en") {
				$SHOP_TRANS['shop']="Store";
				$SHOP_TRANS['shopOptions']="Store Options";
				$SHOP_TRANS['adminEmails']="Orders Emails ";
				$SHOP_TRANS['countries_admin']="Countries Shipping";
				$SHOP_TRANS['shippings_admin']="Shipping Types";
				$SHOP_TRANS['coupons_admin']="Discounts & Coupons";
				$SHOP_TRANS['shopOrders']="Orders";

			}
	        $_SESSION['SHOP_TRANS']=$SHOP_TRANS=setCacheVal('shop_lang',$SHOP_TRANS,$m);
	}
	else $_SESSION['SHOP_TRANS']=$SHOP_TRANS=$SHP_LANG;
		
		
		
//}
?>