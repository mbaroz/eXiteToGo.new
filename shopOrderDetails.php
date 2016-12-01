<style type="text/css"> 
	.order {
		padding:20px;
		color:#<?=$SITE[contenttextcolor];?>;
		font-family: Arial;
		font-size:14px;
	}
	
		.order .title {
			font-size:22px;
			text-decoration: underline;
		}
		
		.order .value {
			color:#<?=$SITE[formtextcolor];?>;
			font-weight: bold;
		}
		
		.order .value.payed {
			
		}
		
		.order .value.awaiting {
			color:#fff;
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
</style> 
<? if(isset($_SESSION['LOGGED_ADMIN'])) { ?>
<script type="text/javascript">
	function saveOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars =newPosition+'&action=saveContentLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});	
	}

	jQuery(function() {
		jQuery("#boxes").sortable({
	   		update: function(event, ui) {
	   			saveOrder(jQuery("#boxes").sortable('serialize'));
	   		},
	   		scroll:false,
		});
	});
</script>
<? } ?>
<ul id="boxes">
<?
$CONTENT=GetMultiContent($urlKey);
//var_dump($CONTENT);
//die;
for ($a=0;$a<count($CONTENT[PageID]);$a++) {
	$titleShow="block";
	$p_url=SITE_MEDIA."/".$CONTENT[UrlKey][$a];
	$page_url=SITE_MEDIA."/".$CONTENT[UrlKey][$a];
	if ($CONTENT[PageTitle][$a]=="") $titleShow="none";
	if (!$CONTENT[PageUrl][$a]=="") $page_url=urldecode($CONTENT[PageUrl][$a]);
	?>
	<li id="short_cell-<?=$CONTENT[PageID][$a];?>" class="ui-state-default">
	<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<span style="display:none" id="p_url_<?=$CONTENT[PageID][$a];?>"><?=urldecode($CONTENT[PageUrl][$a]);?></span>
		<div class="cHolder" id="cHolder-item_<?=$CONTENT[PageID][$a];?>">
		<div>
		<span id="AdminErea_<?=$CONTENT[PageID][$a];?>" style="display:">
		<?include './Admin/EditAreaClient.php'; ?>
		</span></div>
		<?
	}
	$h_tag="h1";
	if ($pageHasHOne) $h_tag="h2";
	if ($a>0) {
			$h_tag="h2";
			if ($pageHasHOne) $h_tag="h3";		
	}
	?>
	<div class="titleContent">
	<<?=$h_tag;?>  id="titleContent_<?=$CONTENT[PageID][$a]; ?>" style="display:<?=$titleShow;?>">
	<?
	if (count($CONTENT[PageID])>1) {
		?><a id="c_url_<?=$CONTENT[PageID][$a];?>" href="<?=$page_url;?>"><? }
	else {
		?><a id="c_url_<?=$CONTENT[PageID][$a];?>"><? }
		?><?=$CONTENT[PageTitle][$a];?></a>
		</<?=$h_tag;?>></div>
		<?

	?>

	<div id="printArea"><div id="divContent_<?=$CONTENT[PageID][$a]; ?>" align="<?=$SITE[align];?>" class="mainContentText">
	<?
	print $CONTENT[PageContent][$a];
	?></div></div>
<?

if (isset($_SESSION['LOGGED_ADMIN'])) print "</div><br>";
print "</li>";
}
?>
</ul>
<?
require_once 'inc/ProductsShop.inc.php';
$hash = mysql_real_escape_string($_GET['hash']);
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
	<table cellpadding="3" cellspacing="3" border="0">
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
		<tr>
			<td><?=$SHOP_TRANS['notes'];?>:</td>
			<td class="value"><?=$order['additional'];?></td>
		</tr>
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