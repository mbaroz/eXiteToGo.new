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
	function initShopCartList() {
		jQuery('#orderList').load('<?=$SITE[url];?>/shopCartListAjax.php<?=($SITE_LANG[selected] != 'he') ? '?lang='.$SITE_LANG[selected] : '';?>');
	}
	jQuery(document).ready(function() {
		initShopCartList();
	})
</script>
<?
$cart = (isset($_SESSION['ShoppingCart']) && $_SESSION['ShoppingCart']) ? $_SESSION['ShoppingCart'] : array();
?>
<div id="orderList"></div>
