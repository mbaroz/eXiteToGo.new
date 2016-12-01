<?php

function getAllProducts()
{
	$db=new database;
	$db->query("
		SELECT
			`products`.*,
			`categories`.`UrlKey` AS `catUrlKey`
		FROM
			`products`
		LEFT JOIN
			`categories` ON (`products`.`ParentID`=`categories`.`CatID`)
		ORDER BY
			`ProductTitle` ASC
	");
	$ret = array();
	while($db->nextRecord())
		$ret[] = $db->record;
	return $ret;
}

function getRelatedProducts($ProductID)
{
	global $SITE;
	$db=new database;
	$db->query("
		SELECT
			`products`.*,
			`categories`.`UrlKey` AS `catUrlKey`
		FROM
			`products_related`
		LEFT JOIN
			`products` ON (`products`.`ProductID`=`products_related`.`RelatedProductID`)
		LEFT JOIN
			`categories` ON (`products`.`ParentID`=`categories`.`CatID`)
		WHERE
			`products_related`.`ProductID` = '{$ProductID}'
	");
	$ret = array();
	while($db->nextRecord())
		$ret[] = $db->record;
	return $ret;
}

function getFeaturedProducts()
{
	global $SITE;
	$db=new database;
	$db->query("
		SELECT
			`products`.*,
			`categories`.`UrlKey` AS `catUrlKey`
		FROM
			`products`
		LEFT JOIN
			`categories` ON (`products`.`ParentID`=`categories`.`CatID`)
		WHERE
			`products`.`featured` = '1'
	");
	$ret = array();
	while($db->nextRecord())
		$ret[] = $db->record;
	return $ret;
}

function GetDefaultProduct()
{
	global $SITE;
	$db=new database;
	$db->query("
		SELECT
			`products`.*,
			`categories`.`UrlKey` AS `catUrlKey`
		FROM
			`products`
		LEFT JOIN
			`categories` ON (`products`.`ParentID`=`categories`.`CatID`)
		WHERE
			`products`.`defaultProduct` = '1'
	");
	if(!$db->nextRecord())
		return false;
		
	return $db->record;
}

function GetTheProduct($ItemID)
{
	global $SITE;
	$db=new database;
	$db->query("
		SELECT
			`products`.*,
			`categories`.`UrlKey` AS `catUrlKey`
		FROM
			`products`
		LEFT JOIN
			`categories` ON (`products`.`ParentID`=`categories`.`CatID`)
		WHERE
			`products`.`ProductID` = '{$ItemID}'
	");
	$db->nextRecord();
	$item = $db->record;
	$db->query("
		SELECT
			`categories_attributes`.`AttributeID`,
			`categories_attributes`.`AttributeName`,
			`categories_attributes_values`.`ValueID`,
			`categories_attributes_values`.`ValueName`,
			`categories_attributes_values`.`price_effect`
		FROM
			`categories_attributes`
		LEFT JOIN
			`categories_attributes_values` ON (`categories_attributes_values`.`AttributeID` = `categories_attributes`.`AttributeID`)
		LEFT JOIN
			`items_attributes` ON (`items_attributes`.`AttributeID` = `categories_attributes`.`AttributeID` AND `items_attributes`.`ValueID` = `categories_attributes_values`.`ValueID`)
		WHERE
			`items_attributes`.`ProductID` = '{$ItemID}'
		ORDER BY
			`categories_attributes`.`AttributeID`,
			`categories_attributes_values`.`ValueID`
	");
	$item['attributes'] = array();
	while($db->nextRecord())
	{
		$attr = $db->record;
		if(!isset($item['attributes'][$attr['AttributeID']]))
			$item['attributes'][$attr['AttributeID']] = array(
				'name' => $attr['AttributeName'],
				'values' => array(),
			);
		$item['attributes'][$attr['AttributeID']]['values'][$attr['ValueID']] = array('name' => $attr['ValueName'],'price_effect' => $attr['price_effect']);
	}
	if($SITE['showWithTax'] == 1)
		$item['ProductPrice'] = $item['ProductPrice']*((100+$SITE['tax'])/100);
	$item['ProductPrice'] = round($item['ProductPrice'],2);
	return $item;
}

function getTotalProdsByCategory($urlKey,$attrs_search = false)
{
	$PAGE_ID=GetIDFromUrlKey($urlKey);
	$categoryID=$PAGE_ID['parentID'];
	$w_and = (isset($_SESSION['LOGGED_ADMIN'])) ? '' : "AND `products`.`ViewStatus` = '1'";
	$db=new database;
	
	$p_in = '';
	if(is_array($attrs_search) && count($attrs_search) > 0)
	{
		$wr_s = '';
		$wr_j = '';
		$prods = array();
		foreach($attrs_search as $aid => $vid)
		{
			$wr_j .= "LEFT JOIN `items_attributes` AS `attr{$aid}` ON (`attr{$aid}`.`ProductID`=`products`.`ProductID`) ";
			$wr_s .= "`attr{$aid}`.`AttributeID`='{$aid}' AND `attr{$aid}`.`ValueID`='{$vid}' AND ";
		}
		$wr_s = substr($wr_s,0,-5);
		$db->query("SELECT `products`.`ProductID` FROM `products` {$wr_j} WHERE {$wr_s}");
		$p_in = 'AND `ProductID` IN(';
		while($db->nextRecord())
			$p_in .= "'".$db->getField('ProductID')."',";
		if($p_in == 'AND `ProductID` IN(')
			return 0;
		else
			$p_in = substr($p_in,0,-1).')';
	}
	
	$db->query("
		SELECT
			COUNT(`products`.`ProductID`) AS `cnt`
		FROM
			`products`
		WHERE
			`products`.`ParentID` = '{$categoryID}'
		{$w_and}
		{$p_in}
	");
	
	if($db->nextRecord())
		return $db->getField('cnt');

	return 0;
}

function getTotalPagesByCategory($urlKey,$attrs_search = false)
{
	global $SITE;
	$totalProds = getTotalProdsByCategory($urlKey,$attrs_search);
	return ceil($totalProds/$SITE[shopProdsPerPage]);
}

function GetProductsByCategory($urlKey,$page = 1,$attrs_search = false)
{
	global $SITE;
	$PAGE_ID=GetIDFromUrlKey($urlKey);
	$categoryID=$PAGE_ID['parentID'];
	$limit = $SITE[shopProdsPerPage];
	if($page < 1)
		$page = 1;
	$offset = ($page-1)*$limit;
	$w_and = (isset($_SESSION['LOGGED_ADMIN'])) ? '' : "AND `products`.`ViewStatus` = '1'";
	$db=new database;
	$p_in = '';
	if(is_array($attrs_search) && count($attrs_search) > 0)
	{
		$wr_s = '';
		$wr_j = '';
		$prods = array();
		foreach($attrs_search as $aid => $vid)
		{
			$wr_j .= "LEFT JOIN `items_attributes` AS `attr{$aid}` ON (`attr{$aid}`.`ProductID`=`products`.`ProductID`) ";
			$wr_s .= "`attr{$aid}`.`AttributeID`='{$aid}' AND `attr{$aid}`.`ValueID`='{$vid}' AND ";
		}
		$wr_s = substr($wr_s,0,-5);
		$db->query("SELECT `products`.`ProductID` FROM `products` {$wr_j} WHERE {$wr_s}");
		$p_in = 'AND `ProductID` IN(';
		while($db->nextRecord())
			$p_in .= "'".$db->getField('ProductID')."',";
		if($p_in == 'AND `ProductID` IN(')
			return array();
		else
			$p_in = substr($p_in,0,-1).')';
	}
	
	$db->query("
		SELECT
			`products`.`ViewStatus`,
			`products`.`ProductID`,
			`products`.`ProductTitle`,
			`products`.`ProductShortDesc`,
			`products`.`ProductDescription`,
			`products`.`ProductPrice`,
			`products`.`discountPrice`,
			`products`.`ProductPhotoName`,
			`products`.`ProductUrl`,
			`products`.`UrlKey`,
			`products`.`quantity`,
			`products`.`featured`,
			`products`.`richText`,
			`products`.`onSale`
		FROM
			`products`
		WHERE
			`products`.`ParentID` = '{$categoryID}'
		{$w_and}
		{$p_in}
		ORDER BY
			`products`.`ProductOrder` ASC,`products`.`ProductID` DESC
		LIMIT
			{$offset},{$limit}
	");
	$items = array();
	while($db->nextRecord())
	{
		$item = $db->record;
		if($SITE['showWithTax'] == 1)
			$item['ProductPrice'] = $item['ProductPrice']*((100+$SITE['tax'])/100);
		$item['ProductPrice'] = round($item['ProductPrice'],2);
		$items[] = $item;
	}

	return $items;
}

function GetCategoryAttributes($urlKey,$byid = false)
{
	if($byid)
		$categoryID = $urlKey;
	else
	{
		$PAGE_ID=GetIDFromUrlKey($urlKey);
		$categoryID=$PAGE_ID['parentID'];
	}
	$db=new database;
	$db->query("
		SELECT
			`categories_attributes`.`AttributeID`,
			`categories_attributes`.`AttributeName`,
			`categories_attributes_values`.`ValueID`,
			`categories_attributes_values`.`ValueName`,
			`categories_attributes_values`.`price_effect`
		FROM
			`categories_attributes`
		LEFT JOIN
			`categories_attributes_values` USING(`AttributeID`)
		WHERE
			`categories_attributes`.`CatID` = '{$categoryID}'
		ORDER BY
			`categories_attributes`.`AttributeID`,
			`categories_attributes_values`.`ValueID`
	");
	$attributes = array();
	while($db->nextRecord())
	{
		if(!isset($attributes[$db->getField('AttributeID')]))
			$attributes[$db->getField('AttributeID')] = array('name' => $db->getField('AttributeName'),'values' => array(),'valuesPrices' => array());
		if($db->getField('ValueID') > 0)
		{
			$attributes[$db->getField('AttributeID')]['values'][$db->getField('ValueID')] = $db->getField('ValueName');
			$attributes[$db->getField('AttributeID')]['valuesPrices'][$db->getField('ValueID')] = $db->getField('price_effect');
		}
	}
	return $attributes;
}

function GetShopOrderByHash($hash)
{
	$db=new database;
	$db->query("
		SELECT
			`shoporders`.*,
			`shop_countries`.`countryName`,
			`shop_shippings`.`shippingName`
		FROM
			`shoporders`
		LEFT JOIN
			`shop_countries` ON (`shoporders`.`countryID` = `shop_countries`.`countryID`)
		LEFT JOIN
			`shop_shippings` ON (`shoporders`.`shippingID` = `shop_shippings`.`shippingID`)
		WHERE
			`shoporders`.`hash` = '{$hash}'
	");
	if($db->nextRecord())
	{
		return $db->record;
	}
	return false;
}

function getCartContents()
{
	global $total_price,$cart,$SITE;
	$db=new Database();
	$return = '';
	$sql_attrs = '';
	$sql_prods = '';
	foreach($cart as $item) {
		$attrs = unserialize($item['attrs']);
		foreach($attrs as $AttributeID => $ValueID)
			$sql_attrs .= "(`categories_attributes`.`AttributeID` = '{$AttributeID}' AND `categories_attributes_values`.`ValueID` = '{$ValueID}') OR ";
		$sql_prods .= "{$item['ProductID']},";
	}
	$print_attrs = array();
	$prods_names = array();
	$prods_prices = array();
	$prods_urls = array();
	$prods_pics = array();
	$price_effects = array();
	$prods_descs = array();
	if($sql_prods != '')
	{
		$sql_attrs = substr($sql_attrs,0,-4);
		$sql_prods = substr($sql_prods,0,-1);
		if($sql_attrs)
		{
			$db->query("
				SELECT
					`categories_attributes`.`AttributeName`,
					`categories_attributes`.`AttributeID`,
					`categories_attributes_values`.`ValueID`,
					`categories_attributes_values`.`ValueName`,
					`categories_attributes_values`.`price_effect`
				FROM
					`categories_attributes`
				LEFT JOIN
					`categories_attributes_values` USING(`AttributeID`)
				WHERE
					{$sql_attrs}
			");
			while ($db->nextRecord())
			{
				$print_attrs[$db->getField('AttributeID').':'.$db->getField('ValueID')] = '<b>'.$db->getField('AttributeName').':</b> '.$db->getField('ValueName');
				$price_effects[$db->getField('AttributeID').':'.$db->getField('ValueID')] = floatval($db->getField('price_effect'));
			}
		}
		$db->query("
			SELECT
				`products`.`ProductID`,
				`products`.`ProductTitle`,
				`products`.`ProductPrice`,
				`products`.`discountPrice`,
				`products`.`ProductPhotoName`,
				`products`.`ProductShortDesc`,
				`products`.`UrlKey`,
				`categories`.`UrlKey` as `CatUrlKey`
			FROM
				`products`
			LEFT JOIN
				`categories` ON (`products`.`ParentID` = `categories`.`CatID`)
			WHERE
				`products`.`ProductID` IN({$sql_prods})
		");
		while ($db->nextRecord())
		{
			$prods_names[$db->getField('ProductID')] = $db->getField('ProductTitle');
			$prods_descs[$db->getField('ProductID')] = $db->getField('ProductShortDesc');
			$prods_prices[$db->getField('ProductID')] = (floatval($db->getField('discountPrice')) > 0) ? floatval($db->getField('discountPrice')) : floatval($db->getField('ProductPrice'));
			$prods_urls[$db->getField('ProductID')] = $db->getField('CatUrlKey').'/'.$db->getField('UrlKey');
			$prods_pics[$db->getField('ProductID')] = $db->getField('ProductPhotoName');
		}
	}
	
	$return = array();
	foreach($cart as $key => $item) {
		$attrs = unserialize($item['attrs']);
		$p_a = '';
		$p_c = 0;
		foreach($attrs as $AttributeID => $ValueID)
		{
			$item['text_attrs'][$AttributeID] = $print_attrs[$AttributeID.':'.$ValueID];
			$p_c += $price_effects[$AttributeID.':'.$ValueID];
		}
		
		$total_price += (($prods_prices[$item['ProductID']]+$p_c) * $item['count']);
		$item['prod_url'] = $prods_urls[$item['ProductID']];
		$item['prod_name'] = $prods_names[$item['ProductID']];
		$item['prod_price'] = ($prods_prices[$item['ProductID']]+$p_c);
		if($SITE['showWithTax'] == 1)
			$item['prod_price'] = $item['prod_price']*((100+$SITE['tax'])/100);
		$item['prod_price'] = round($item['prod_price'],2);
		$item['ProductPhotoName'] = $prods_pics[$item['ProductID']];
		$item['ProductShortDesc'] = $prods_descs[$item['ProductID']];
		$return[$key] = $item;
	}
	
	return $return;
}

function getCountries()
{
	global $db,$total_price;
	if (!$db) $db=new Database();
	if(floatval($total_price) == 0)
		getCartContents();
	
	$countries = array();
	$db->query("SELECT * FROM `shop_countries` ORDER BY `countryName`");
	
	while($db->nextRecord())
	{

		if(!$discounts = unserialize($db->getField('discounts')))
			$discounts = array();
		$price = $db->getField('countryCost');

		$discount = makeDiscount($total_price,$discounts);
		$price -= $discount;
		if($price < 0)
			$price = 0;
		$countries[$db->getField('countryID')]=array('id' => $db->getField('countryID'),'name' => $db->getField('countryName'),'price' => $price,'default' => $db->getField('default'),'vatEffects' => $db->getField('vatEffects'));
	}

	return $countries;
}

function getShippings()
{
	global $db,$total_price;
	if (!$db) $db=new Database();
	if(floatval($total_price) == 0)
		getCartContents();
	$shippings = array();
	$db->query("SELECT * FROM `shop_shippings`");
	while($db->nextRecord())
	{
		if(!$discounts = unserialize($db->getField('discounts')))
			$discounts = array();
		$price = $db->getField('shippingCost');
		$priceForCalc=$total_price;
		if ($_SESSION['coupon_discount']>0) $priceForCalc -= ($_SESSION['coupon_type'] == 'sum') ? floatval($_SESSION['coupon_discount']) : $priceForCalc*(floatval($_SESSION['coupon_discount'])/100);
		$discount = makeDiscount($priceForCalc,$discounts);
		$price -= $discount;
		if($price < 0)
			$price = 0;
		$shippings[$db->getField('shippingID')]=array('id' => $db->getField('shippingID'),'name' => $db->getField('shippingName'),'price' => $price,'default' => $db->getField('default'));
	}
	return $shippings;
}

function makeDiscount($total_price,$discounts){
	$discount = 0;
	$max_min_price = 0;
	foreach($discounts as $min_price => $dis)
	{
		if($min_price <= $total_price)
		{
			if($min_price > $max_min_price)
			{
				$max_min_price = $min_price;
				$discount = $dis;
			}
		}
	}
	return $discount;
}

function getDefaultSel($array)
{
	foreach($array as $in_arr)
		if($in_arr['default'] == 1)
			return $in_arr;
	return array_pop($array);
}

function sendHTMLemail($to, $subject, $from, $body,$pre_inc="../") {
	require_once $pre_inc.'inc/PHPMailerAutoload.php';
	global $SITE;
	$recips=explode(",", $to);
	$body = stripslashes($body);
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = 'email-smtp.eu-west-1.amazonaws.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "AKIAI524PJFHZLBK4FQQ";
	//Password to use for SMTP authentication
	$mail->Password = "Akza4RlpzI6A35ti4kZl2IETBDDyP+k6zl6E35O8tpOv";
	$mail->setFrom('no-reply@exitetogo.com', $SITE[name]);
	$mail->addReplyTo($from);
	//Set who the message is to be sent to
	if (is_array($recips)) {
		foreach ($recips as $recip) {
			$mail->addAddress($recip);
		}
	}
	else $mail->addAddress($to);
	$mail->Subject = $subject;
	$msgHTML=$body;
	$mail->msgHTML($msgHTML);
     if (!$results=$mail->send()) print $mail->ErrorInfo;
    else return $results;
}

function show_price_side($price,$editable = false,$sid = '',$schema = false,$name='ProductPrice'){
	global $SITE;
	$ret = '';
	$s_code = ($schema) ? ' itemprop="price"' : '';
	if($SITE['shopCurrencySide'] == 'l')
	{
		if($editable)
			$ret .= '<span>';
		$ret .= $SITE[ItemsCurrency];
		if($editable)
			$ret .= '</span>';
	}
	if($editable)
	{
		$ret .= '<span class="editable price" style="white-space:nowrap" id="'.$name;
		if($sid != '')
			$ret .= '-'.$sid;
		$ret .= '"'.$s_code.'>'.$price.'</span>';
	}
	elseif($sid != '')
		$ret .= '<span id="'.$sid.'"'.$s_code.'>'.$price.'</span>';
	else
		$ret .= '<span'.$s_code.'>'.$price.'</span>';
	if($SITE['shopCurrencySide'] == 'r')
	{
		if($editable)
			$ret .= '<span>';
		$ret .= $SITE[ItemsCurrency];
		if($editable)
			$ret .= '</span>';
	}
	return $ret;
}

function GetProductEmailText($ProductID) {
	if($ProductID > 0)
	{
		$db=new Database();
		$db->query("SELECT `emailText` FROM `email_texts` WHERE `emailID`='ProductEmail_{$ProductID}'");
		if($db->nextRecord())
			return $db->getField('emailText');
	}
	return GetEmailText('costumerNewOrder');
}

function GetProductFooterText($ProductID) {
	if($ProductID > 0)
	{
		$db=new Database();
		$db->query("SELECT `emailText` FROM `email_texts` WHERE `emailID`='ProductEmail_{$ProductID}'");
		if($db->nextRecord())
			return $db->getField('emailText');
	}
	return GetEmailText('footer');
}

function getCoupon($code){
	if(isset($_SESSION['coupon']))
		return true;
	$db=new Database();
	$code = addslashes($code);
	$db->query("SELECT * FROM `shop_coupons` WHERE `code`='{$code}'");
	if($db->nextRecord())
	{
		$coupon = $db->record;
		if($coupon['uses'] > $coupon['used'])
		{
			//$db->query("UPDATE `shop_coupons` SET `used`=`used`+1 WHERE `code`='{$code}'");
			$_SESSION['coupon']=$coupon['code'];
			$_SESSION['coupon_type']=$coupon['type'];
			$_SESSION['coupon_discount']=$coupon['discount'];
			return true;
		}
	}
	return false;
}

?>