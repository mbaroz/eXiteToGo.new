<?php

header ("Content-Type:text/xml"); 

if(isset($_GET['lang']))
	$SITE_LANG[selected] = substr(urlencode($_GET['lang']),0,2);

include_once("../config.inc.php");

$db = new Database();
$db->query("SELECT * FROM `categories` WHERE `CatID`='{$_GET['catID']}'");
if($db->nextRecord())
	$category = $db->record;
$db->query("SELECT * FROM `shop_shippings` WHERE `default`='1'");
if($db->nextRecord())
	$shipment = $db->record;
echo '<?xml version="1.0" encoding="utf-8" ?>';
?>
<store url="<?=$SITE['url'];?>/" date="<?=date('d/m/Y',time());?>" time="<?=date('H:i:s',time());?>" name="Main Website/Default Store View" status="ONLINE" ID="">
	<PRODUCTS>
		<?
		$i=0;
		$db->query("SELECT * FROM `products` WHERE `ParentID`='{$category['CatID']}'");
		while($db->nextRecord())
		{
			$i++;
			$product = $db->record;
			?>
		    <PRODUCT NUM="<?=$i;?>">
		        <PRODUCT_URL><![CDATA[<?=$SITE['url'];?>/<?=$category['UrlKey'];?>/<?=$product['UrlKey'];?>]]></PRODUCT_URL>
		        <PRODUCT_NAME><![CDATA[<?=$product['ProductTitle'];?>]]></PRODUCT_NAME>
		        <MODEL></MODEL>
		        <DETAILS><![CDATA[<?=mb_substr(strip_tags($product['ProductDescription']),0,200,'UTF-8');?>]]></DETAILS>
		        <CATALOG_NUMBER></CATALOG_NUMBER>
		        <PRICE><?=$product['ProductPrice'];?></PRICE>
		        <CURRENCY>ILS</CURRENCY>
		        <SHIPMENT_COST><?=$shipment['shippingCost'];?></SHIPMENT_COST>
		        <DELIVERY_TIME><![CDATA[<?=$shipment['shippingTime'];?>]]></DELIVERY_TIME>
		        <MANUFACTURER></MANUFACTURER>
		        <WARRANTY></WARRANTY>
		        <IMAGE><?=$SITE['url'];?>/<?=$gallery_dir;?>/products/<?=$product['ProductPhotoName'];?></IMAGE>
		        <TAX>0%</TAX>
		    </PRODUCT>
		    <?
		} ?>
	</PRODUCTS>
</store>