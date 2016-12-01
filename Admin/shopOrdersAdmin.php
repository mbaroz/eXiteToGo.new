<?
//General Config Form
include_once("checkAuth.php");
//include_once("header.inc.php");
include("colorpicker.php");
$status_names = array(
	'awaiting' => $SHOP_TRANS['awaiting_payment'],
	'payed' => $SHOP_TRANS['payed'],
	'delivered' => $SHOP_TRANS['sent'],
	'cancelled' => $SHOP_TRANS['cancelled'],
	'error' => 'error',
);

$pay_types = array(
	'paypal' => 'PayPal',
	'phone' => $SHOP_TRANS['pay_type_phone'],
	'tranzila' => 'Tranzila',
);

?>
<link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/js/datatables/jquery.dataTables.min.css"></link>
<link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/js/datatables/buttons.dataTables.min.css"></link>

<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/jszip.min.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/pdfmake.min.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/buttons.html5.min.js"></script>
<style type="text/css">
	.tr_awaiting {background:#ffffff;}
	.tr_payed {background:yellow;}
	.tr_delivered {background:green;}
	.tr_error,.tr_cancelled {background:red;}
	.itemsDetails {position:absolute;width:100%;margin:0 auto;right:0;}
	.dataTables_filter input[type="search"] {width:200px;padding:10px;min-height: 30px;border:0px;border-bottom: 1px solid silver;outline: none}
	.icon_close {transition:all 0.5s;color:white;transform:rotate(45deg);-ms-transform:rotate(45deg);-webkit-transform:rotate(45deg);font-size:55px;position:absolute;<?=$SITE[opalign];?>:1px;cursor:pointer;top:-43px;color:#333;}
</style>
<br/><br/><br/>
<div style="width:100%;margin-right:10px;">
<div class="selectBoxWrap">
<select id="MassStatus">
	<? foreach($status_names as $status => $name) { ?><option value="<?=$status;?>"><?=$name;?></option><? } ?>
</select>
</div>
<div style="float:left;margin-bottom:10px" class="greenSave" id="newSaveIcon" onclick="mass_change_status()"><?=$ADMIN_TRANS['save changes'];?></div>
<div style="clear:both"></div>
<br/><br>
<table id="orders_List" class="ConfigAdmin listTable" border="0" style="width100%;border-collapse:;" cellpadding="3" cellspacing="2">
<thead>
	<tr style="background-color:#efefef;font-weight:bold;">
	<th align="<?=$SITE[align];?>"><input id="main_checkbox" onclick="check_all()" type="checkbox" /></th>
	<th align="<?=$SITE[align];?>">#</th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['date'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['customer_name'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['customer_email'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['customer_phone'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['customer_adress'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['customer_notes'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['shipping_label'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['items'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['total'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['status'];?></th>
	<th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['pay_type'];?></th>
	<? if($SITE['enabledVat'] == 1) { ?><th align="<?=$SITE[align];?>">VAT</th><? } ?>
	<? if($SITE['greetingEnabled'] == 1) { ?><th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['greeting_text'];?></th><? } ?>
	<? if($SITE['shippingEnabled'] == 1) { ?><th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['shipping_name'];?></th><th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['shipping_adres'];?></th><? } ?>
	<? if($SITE['memberEnabled'] == 1) { ?><th align="<?=$SITE[align];?>"><?=$SHOP_TRANS['member_number'];?></th><? } ?>
	<th align="<?=$SITE[align];?>"></th>
	</tr>
</thead>

<tbody>
<?
$db = new Database();
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
		`pay_type`!='hand'
	ORDER BY
		`date` DESC
");
while($db->nextRecord())
{
	$order = $db->record;
	$p_t = $db->getField('pay_type');
	$total_price = $db->getField('total');
	$subtotal = $db->getField('subtotal');
	if($p_t == 'paypal' && $order['shippingPrice'] > 0 && $order['status'] != 'payed')
		$subtotal+= $order['shippingPrice'];
	?>
	<tr class="tr_<?=$db->getField('status');?>" id="order_<?=$db->getField('OrderID');?>">
	<td><input type="checkbox" class="order_check" name="order_<?=$db->getField('OrderID');?>" /></td>
	<td><?=$db->getField('OrderID');?>.</td>
	<td><?=date('d.m.Y H:i',$db->getField('date'));?></td>
	<td align="<?=$SITE[align];?>"><?=$db->getField('fullname');?></td>
	<td><?=$db->getField('email');?></td>
	<td><?=$db->getField('phone');?></td>
	<td align="<?=$SITE[align];?>"><?=nl2br($db->getField('adres'));?></td>
	<td align="<?=$SITE[align];?>"><?=nl2br($db->getField('additional'));?></td>
	<td align="<?=$SITE[align];?>" style="white-space:nowrap;"><? if($order['countryID'] > 0){ ?><?=$SHOP_TRANS['shipping_to'];?><?=$order['countryName'];?><br/><? } if($order['shippingID'] > 0){ ?><?=$SHOP_TRANS['shipped_by'];?> <?=$order['shippingName'];?><br/><? } if($order['shippingPrice'] > 0) { ?><?=$order['shippingPrice'];?> <?=$SITE[ItemsCurrency];?><? } ?></td>
	<td align="<?=$SITE[align];?>" style="white-space:nowrap">
	<a href="#" onclick="jQuery('#items_<?=$db->getField('OrderID');?>').toggle();return false;"><?=$SHOP_TRANS['items'];?></a><? if($db->getField('status') != 'awaiting' && $db->getField('processing_details') != ''){ ?><br/><a href="#" onclick="jQuery('#details_<?=$db->getField('OrderID');?>').toggle();return false;"><?=$SHOP_TRANS['order_details'];?></a><? } ?>
	<div id="details_<?=$db->getField('OrderID');?>" style="display:none;direction:ltr;text-align:left;">
		<?=nl2br($db->getField('processing_details'));?>
	</div>
	<div id="items_<?=$db->getField('OrderID');?>" style="display:none" class="itemsDetails">
		<div class="icon_close" onclick="jQuery('#items_<?=$db->getField('OrderID');?>').hide();return false;">+</div>
		<table cellpadding="3" cellspacing="0" border="1" style="border-collapse:collapse" width="100%">
		<tr>
			<td><b><?=$SHOP_TRANS['item_name'];?></b></td>
			<td><b><?=$SHOP_TRANS['quantity'];?></b></td>
			<td><b><?=$SHOP_TRANS['price'];?></b></td>
		</tr>
		<?=$db->getField('items');?>
		</table>
	</div>
	</td>
	<td style="direction:ltr;white-space:nowrap;"><b><?=$subtotal;?> <?=$SITE[ItemsCurrency];?></b><br/>(<?=$total_price;?><? if($order['shippingPrice'] > 0) { ?> + <?=$order['shippingPrice'];?><? } ?> + <?=(round(floatval($subtotal),2) - round((round(floatval($total_price),2) + round(floatval($order['shippingPrice']),2)),2));?> <?=$SHOP_TRANS['tax'];?>)</td>
	<td align="<?=$SITE[align];?>" id="status_<?=$db->getField('OrderID');?>" style="white-space:nowrap"><?=$status_names[$db->getField('status')];?><? if($db->getField('status') == 'error'){ ?><br/><?=$db->getField('error_details');?><? } ?></td>
	<td align="<?=$SITE[align];?>" style="white-space:nowrap"><?=$pay_types[$p_t];?><? if($p_t == 'tranzila'){ ?><br/><?=$SHOP_TRANS['payments_num'];?>: <?=$db->getField('payments');?><? } ?></td>
	<? if($SITE['enabledVat'] == 1) { ?><td align="<?=$SITE[align];?>"><?=$order['VatNumber'];?></td><? } ?>
	<? if($SITE['greetingEnabled'] == 1) { ?><td align="<?=$SITE[align];?>"><?=$order['greetingText'];?></td><? } ?>
	<? if($SITE['shippingEnabled'] == 1) { ?><td align="<?=$SITE[align];?>"><?=$order['shipping_name'];?></td><td align="<?=$SITE[align];?>"><?=$order['shipping_adres'];?></td><? } ?>
	<? if($SITE['memberEnabled'] == 1) { ?><td align="<?=$SITE[align];?>"><?=$order['memberNumber'];?></td><? } ?>
	<td id="status_links_<?=$db->getField('OrderID');?>">
	<? if($db->getField('status') == 'awaiting' || $db->getField('status') == 'error') { ?><a href="#" onclick="ChangeOrderStatus(<?=$db->getField('OrderID');?>,'payed');return false;"><?=$SHOP_TRANS['payed'];?></a>&nbsp;|&nbsp;<a href="#" onclick="ChangeOrderStatus(<?=$db->getField('OrderID');?>,'cancelled');return false;"><?=$SHOP_TRANS['cancelled'];?></a><? } ?>
	<? if($db->getField('status') == 'payed') { ?><a href="#" onclick="ChangeOrderStatus(<?=$db->getField('OrderID');?>,'awaiting');return false;"><?=$SHOP_TRANS['awaiting_payment'];?></a>&nbsp;|&nbsp;<a href="#" onclick="ChangeOrderStatus(<?=$db->getField('OrderID');?>,'delivered');return false;"><?=$SHOP_TRANS['sent'];?></a>&nbsp;|&nbsp;<a href="#" onclick="ChangeOrderStatus(<?=$db->getField('OrderID');?>,'cancelled');return false;"><?=$SHOP_TRANS['cancelled'];?></a><? } ?>
	<? if($db->getField('status') == 'delivered') { ?><a href="#" onclick="ChangeOrderStatus(<?=$db->getField('OrderID');?>,'payed');return false;"><?=$SHOP_TRANS['payed'];?></a>&nbsp;|&nbsp;<a href="#" onclick="ChangeOrderStatus(<?=$db->getField('OrderID');?>,'cancelled');return false;"><?=$SHOP_TRANS['cancelled'];?></a><? } ?>
	</td>
	</tr>
	
<? } ?>
</tbody>
</table>
<br/>
</div>
<script type="text/javascript">
	var status_names = {'awaiting' : '<?=$SHOP_TRANS['awaiting_payment'];?>','payed' : '<?=$SHOP_TRANS['payed'];?>','delivered' : '<?=$SHOP_TRANS['sent'];?>','cancelled' : '<?=$SHOP_TRANS['cancelled'];?>'};
	function ChangeOrderStatus(orderid,status) {
		if(!confirm('<?=$SHOP_TRANS['you_sure'];?>?'))
			return;
		jQuery.ajax({
			url : '<?=$SITE[url];?>/Admin/saveOrderStatus.php',
			type:'post',
			data:'action=StatusUpdate&OrderID='+orderid+'&status='+status,
			success:function (transport) {
				//document.location.reload();
				document.getElementById('order_'+orderid).className = 'tr_'+status;
				document.getElementById('status_links_'+orderid).innerHTML = transport;
				document.getElementById('status_'+orderid).innerHTML = status_names[status];
			}
		});
	}
	
	function mass_change_status() {
		if(!confirm('<?=$SHOP_TRANS['you_sure'];?>?'))
			return;
		status = jQuery('#MassStatus option:selected').attr('value');
		
		pars = 'action=MassStatusUpdate&status='+status;
		jQuery('.order_check:checked').each(function(){
			pars += '&orderid[]='+jQuery(this).attr('name').replace('order_','');
		});
		jQuery.ajax({
			url : '<?=$SITE[url];?>/Admin/saveOrderStatus.php',
			type:'post',
			data:pars,
			success:function (transport) {
				document.location.reload();
			}
		}); 
	}
	
	function check_all() {
		if(jQuery('#main_checkbox:checked').length > 0)
			jQuery('input[type=checkbox]').attr('checked','checked');
		else
			jQuery('input[type=checkbox]').attr('checked','');
	}
</script>
<script>
function initEXiteAdminTables() {
	jQuery('#orders_List').DataTable( {
        dom: 'Bfrtip',
        buttons: [{
        	 extend: 'excelHtml5',
        	 title: 'OrdersExport'
        },
       
        {
        	extend:'csvHtml5',
        	title:'OrdersExport'
        },
        {
        	extend:'pdfHtml5',
        	title:'OrdersExport'
        },
        {extend:'copyHtml5'}
        ],
        "language": {
		    "paginate": {
		      "next": "לעמוד הבא","previous": "לעמוד הקודם"
		    },
		    "search": "חפש מוצר/ים",
		    "info": "מציג עמוד _PAGE_ מתוך _PAGES_"
	  }
    } );
}
</script>

<script>
	//jQuery(document).ready(function() {initEXiteAdminTables()});
 	window.setTimeout("initEXiteAdminTables();",60);

</script>
<? include_once("footer.inc.php"); ?>