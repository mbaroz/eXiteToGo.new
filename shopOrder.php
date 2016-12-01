<? if($SITE[orderPageInputWidth] < 1)
	$SITE[orderPageInputWidth] = 200; ?>
<style type="text/css"> 
.pay_block_type {
	color:#<?=($SITE[orderPageLabelTextColor] != '') ? $SITE[orderPageLabelTextColor] : $SITE[contenttextcolor];?>;
	font-size:<?=($SITE[orderPageLabelTextSize] != '') ? $SITE[orderPageLabelTextSize] : '13';?>px;
	text-align:<?=$SITE['align'];?>;
}
.coupon_field {
	background:#<?=$SITE[orderPageInputBgColor];?>;
	color:#<?=$SITE[orderPageInputTextColor];?>;
}
.coupon_field_button {
	
	vertical-align: middle
}
.contact_frm {
	width:200px;
	padding:1px;
	border:0px solid silver;
	background-color: #<?=$SITE[shopSelectBg];?>;
	font-family:inherit;
	font-size:inherit;
	color:#<?=$SITE[shopSelectTextColor];?>;
}
.contact_frm {
	<? if($SITE[orderPageInputWidth] > 0){ ?>width:<?=$SITE[orderPageInputWidth];?>px;<? } ?>
	<? if($SITE[orderPageInputHeight] > 0){ ?>height:<?=$SITE[orderPageInputHeight];?>px;<? } ?>
	<? if($SITE[orderPageInputBgColor] != ''){ ?>background:#<?=$SITE[orderPageInputBgColor];?>;<? } ?>
	<? if($SITE[orderPageInputTextColor] != ''){ ?>color:#<?=$SITE[orderPageInputTextColor];?>;<? } ?>
	<? if($SITE[orderPageInputBorder] != ''){ ?>border:1px solid #<?=$SITE[orderPageInputBorder];?>;<? } ?>
}
select.contact_frm {
	<? if($SITE[orderPageInputWidth] > 0){ ?>width:<?=($SITE[orderPageInputWidth]+2);?>px;<? }
	else { ?>width:202px;<? } ?>
}
.contact_frm_txt {
	width:198px;
	padding:2px;
	border:0px solid silver;
	background-color: #<?=$SITE[shopSelectBg];?>;
	color:#<?=$SITE[shopSelectTextColor];?>;
	font-family:inherit;
	font-size:inherit;
	scrollbar-base-color: #<?=$SITE[formbgcolor];?>;
	vertical-align:top;
}
textarea.contact_frm_txt {
	<? if($SITE[orderPageInputWidth] > 0){ ?>width:<?=($SITE[orderPageInputWidth]-2);?>px;<? } ?>
	<? if($SITE[orderPageInputBgColor] != ''){ ?>background:#<?=$SITE[orderPageInputBgColor];?>;<? } ?>
	<? if($SITE[orderPageInputTextColor] != ''){ ?>color:#<?=$SITE[orderPageInputTextColor];?>;<? } ?>
	<? if($SITE[orderPageInputBorder] != ''){ ?>border:1px solid #<?=$SITE[orderPageInputBorder];?>;<? } ?>
}

.frm_button {
	padding:3px 5px 3px 5px;
	background-color:#<?=($SITE['orderPageSubmitBg'] != '') ? $SITE['orderPageSubmitBg'] : $SITE['formbgcolor'];?>;
	color:#<?=($SITE[orderPageSubmitFontColor] != '') ? $SITE[orderPageSubmitFontColor] : $SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	font-weight:bold;
	border:<?=($SITE[orderPageSubmitBorder] != '') ? '1px solid #'.$SITE[orderPageSubmitBorder] : '0px solid silver';?>;
	width:<?=($SITE['orderPageSubmitWidth']) ? $SITE['orderPageSubmitWidth'] : '60';?>px;
	<? if($SITE['orderPageSubmitHeight'] != ''){ ?>height:<?=$SITE['orderPageSubmitHeight'];?>px;<? } ?>
	font-size:<?=($SITE[orderPageSubmitFontSize]) ? $SITE[orderPageSubmitFontSize] : '12';?>px;
	cursor:pointer;
}

#boxes {
	list-style-type: none;
	padding-<?=$SITE[align];?>:13px;
}

.pay_block_title span {
	color:#<?=($SITE[payBlockTitleTextColor] != '') ? $SITE[payBlockTitleTextColor] : $SITE[contenttextcolor];?>;
	text-decoration: none;
	display: block;
    padding: 10px;
    margin:0 auto;
    background: #<?=($SITE[payBlockTitleBgColor] != '') ? $SITE[payBlockTitleBgColor] : $SITE[formbgcolor];?>;
    <? if($SITE[roundcorners]==1){ ?>border-radius: 5px;<? } ?>
}

<? if($SITE[orderSubmitButton] != '') {
	$size = getimagesize('http:'.SITE_MEDIA.'/gallery/sitepics/'.$SITE[orderSubmitButton]); ?>
	.sendButton {
		color:transparent;
		font-size:0px;
		line-height:0px;
		display:block;
		width:<?=$size[0];?>px;
		height:<?=$size[1];?>px;
		background:url('<?=SITE_MEDIA."/".$gallery_dir.'/sitepics/'.$SITE[orderSubmitButton];?>');
		background-color: none;
		padding:0;
	}
	
	.clearButton {
		display:none;
	}
<? }
$addPix = ($SITE[orderPageInputBorder] != '') ? 4 : 2;
?>

.form_row {
	width:<?=($SITE[orderPageInputWidth]+$addPix);?>px;
	margin-<?=$SITE[align];?>:20px;
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
	$p_url=$SITE[media]."/".$CONTENT[UrlKey][$a];
	$page_url=$SITE[media]."/".$CONTENT[UrlKey][$a];
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
print '</ul>';

	
if($SITE['shopOrderListSide'] != 1)
{
	require_once 'shopCartList.php';
}

if($SITE[couponsEnabled] == 1){

if(@$_POST['coupon_code'] != '')
{
	if(!getCoupon($_POST['coupon_code']))
	{
		?><script type="text/javascript">alert('<?=$SHOP_TRANS['wrong_coupon'];?>!')</script><?
	}
}

if(!isset($_SESSION['coupon'])) { ?>
<div style="padding:5px 10px 10px 10px"><table width="100%" cellspacing="0" cellpadding="3" border="0" style="color:#<?=$SITE[contenttextcolor];?>;"><tr><td style="border-bottom:1px dotted #<?=$SITE[contenttextcolor];?>;white-space:nowrap;" align="<?=$SITE[align];?>"><b><?=$SHOP_TRANS['add_coupon_code'];?>:</b>&nbsp;&nbsp;<form action="?addCoupon" method="post" style="margin:0;padding:0;display:inline;"><input class="coupon_field" style="border: 0;width: 100px;height: 20px;vertical-align: middle;" type="text" name="coupon_code" value="<?=@$_POST['coupon_code'];?>" />&nbsp;<input class="coupon_field_button" type="submit" value="<?=$SHOP_TRANS['add'];?>" /></form></td></tr></table></div>
<? } } 

if($SITE[shopFeaturedTop] == 1)
	require_once 'shopFeatured.php';

require_once 'inc/ProductsShop.inc.php';

if(!isset($countries))
	$countries = getCountries();

if(!isset($shippings))
	$shippings = getShippings();

$country = getDefaultSel($countries);
$shipping = getDefaultSel($shippings);
$hasDefaultShipping=0;
if (count($shippings)>0) {
	foreach($shippings as $whatDefault)
		if($whatDefault['default'] == 1) $hasDefaultShipping=1;
}

?>

<script type="text/javascript">
var countryID = 0;
var country_price = 0;
var shippingID = 0;
var shipping_price = 0;
var vatEffects = 0;
var is_shop_remarks_must=0;
<? if($country['id'] > 0){ ?>
countryID = <?=$country['id'];?>;
country_price = <?=$country['price'];?>;
vatEffects = <?=($country['vatEffects'] == 1) ? '1' : '0';?>;
<? } ?>
<? if($shipping['id'] > 0){ ?>
shippingID = <?=$shipping['id'];?>;
shipping_price = <?=$shipping['price'];?>;
<? } ?>

if(vatEffects == 1 && (jQuery('#withVatPayPal:checked').length > 0 || jQuery('.withVat:checked').length > 0))
	totalPrice = beforeTaxPrice;
function setCountry(val)
{
	dets = val.split(':');
	countryID = dets[0];
	country_price = dets[1];
	jQuery('#country_name').html(dets[2]);
	vatEffects = parseInt(dets[3]);
	if(vatEffects == 1)
	{
		if(jQuery('#withVatPayPal:checked').length > 0 || jQuery('.withVat:checked').length > 0)
		{
			jQuery('#tax_row').hide();
			totalPrice = beforeTaxPrice;
		}
		else
		{
			jQuery('#tax_row').show();
			totalPrice = afterTaxPrice;
		}
	}
	else
	{
		jQuery('#tax_row').show();
		totalPrice = afterTaxPrice;
	}
	jQuery('#shipping_price').html(Math.round((parseFloat(dets[1])+parseFloat(shipping_price))*100)/100);
	jQuery('#total_price').html(Math.round((parseFloat(totalPrice)+parseFloat(dets[1])+parseFloat(shipping_price))*100)/100);
	jQuery('#paypal_country option[value='+val+']').attr('selected','selected');
	jQuery('.phone_country option[value='+val+']').attr('selected','selected');
}
var selectedShipping_ID=0;
<?
if ($hasDefaultShipping) {
	?>
	selectedShipping_ID=shippingID;
	<?
}
?>
function setShipping(val)
{
	dets = val.split(':');
	shippingID = dets[0];
	selectedShipping_ID=shippingID;
	shipping_price = dets[1];
	jQuery('#shipping_name').html(dets[2]);
	jQuery('#shipping_price').html(Math.round((parseFloat(dets[1])+parseFloat(country_price))*100)/100);
	jQuery('#total_price').html(Math.round((parseFloat(totalPrice)+parseFloat(dets[1])+parseFloat(country_price))*100)/100);
	jQuery('#paypal_shipping option[value='+val+']').attr('selected','selected');
	jQuery('.phone_shipping option[value='+val+']').attr('selected','selected');
}

function togglePayBlock(type)
{
	jQuery('#paypal_form,#contact_form').slideUp();
	jQuery('#'+type+'_form').slideDown();
	jQuery('.pay_block_title a').removeClass('unactive');
	jQuery('#'+type+'_layer .pay_block_title a').addClass('unactive');
}

function toggleVat(from)
{
	if(jQuery('#'+from+':checked').length > 0)
	{
		jQuery('#vatNumberBlockPayPal').show();
		jQuery('#vatNumberBlock').show();
		jQuery('#withVat').attr('checked','checked');
		jQuery('#withVatPayPal').attr('checked','checked');
		if(vatEffects == 1)
		{
			totalPrice = beforeTaxPrice;
			jQuery('#total_price').html(Math.round((parseFloat(totalPrice)+parseFloat(shipping_price)+parseFloat(country_price))*100)/100);
			jQuery('#tax_row').hide();
		}
		else
		{
			totalPrice = afterTaxPrice;
			jQuery('#total_price').html(Math.round((parseFloat(totalPrice)+parseFloat(shipping_price)+parseFloat(country_price))*100)/100);
			jQuery('#tax_row').show();
		}
	}
	else
	{
		jQuery('#vatNumberBlockPayPal').hide();
		jQuery('#vatNumberBlock').hide();
		jQuery('#withVat').removeAttr('checked');
		jQuery('#withVatPayPal').removeAttr('checked');
		totalPrice = afterTaxPrice;
		jQuery('#total_price').html(Math.round((parseFloat(totalPrice)+parseFloat(shipping_price)+parseFloat(country_price))*100)/100);
		jQuery('#tax_row').show();
	}
}

function copyVat(elem)
{
	from = jQuery(elem).val();
	jQuery('#vat_number_paypal').val(from);
	jQuery('.vat_number').val(from);
}
</script>
<?


?>
<? if(($SITE[paypal] != '' && $SITE['paypal_only'] != 1) || $SITE[tranzila_merchant] != ''){ ?><div style="font-size:20px;text-align:<?=$SITE['align'];?>;padding-bottom:20px;margin:0 10px;" class="pay_block_title"><span><?=$SHOP_TRANS['choose_payment_method'];?></span><div style="clear:both;"></div></div><? } ?>
<div style="float:<?=$SITE['align'];?>;width:300px;margin-<?=$SITE['align'];?>:17px;">
<?
if($SITE[tranzila_merchant] != '' && $SITE['paypal_only'] != 1) { ?>
<div id="cc_radio_type" style="margin-bottom:5px;font-size:12px;color:#<?=$SITE[contenttextcolor];?>;font-weight:bold"><input style="vertical-align:middle" type="radio" name="pay_type" value="cc" onclick="jQuery('.pay_block_type').hide();jQuery('#credit_layer').show();" id="pay_type_cc"<? if($SITE['shopDefaultPayment'] == 'cc'){ ?> CHECKED<? } ?> />&nbsp;&nbsp;<label for="pay_type_cc"><?=$SHOP_TRANS['pay_type_cc'];?></label></div>
<? }
if($SITE[paypal] != ''){ 

$palign= ($SITE['paypal_only'] == 1) ? $SITE['align'] : $SITE['opalign']; ?>
<div id="paypal_radio_type"  style="margin-bottom:5px;font-size:12px;color:#<?=$SITE[contenttextcolor];?>;font-weight:bold"><input style="vertical-align:middle" type="radio" name="pay_type" value="paypal" onclick="jQuery('.pay_block_type').hide();jQuery('#paypal_layer').show();" id="pay_type_paypal"<? if($SITE['shopDefaultPayment'] == 'paypal'){ ?> CHECKED<? } ?> />&nbsp;&nbsp;<label for="pay_type_paypal"><? if($SITE['orderPaypalOrderButton'] != ''){ ?><img src="<?=SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$SITE[orderPaypalOrderButton];?>" style="vertical-align:middle" /><? } else { ?><?=$SHOP_TRANS['pay_with_paypal'];?><? } ?></label></div>
<? 
}
if($SITE['paypal_only'] != 1){ ?>
<div id="phone_radio_type"  style="margin-bottom:5px;font-size:12px;color:#<?=$SITE[contenttextcolor];?>;font-weight:bold"><input style="vertical-align:middle" type="radio" name="pay_type" value="phone" onclick="jQuery('.pay_block_type').hide();jQuery('#contact_layer').show();" id="pay_type_phone"<? if($SITE['shopDefaultPayment'] == 'phone'){ ?> CHECKED<? } ?> />&nbsp;&nbsp;<label for="pay_type_phone"><?=$SHOP_TRANS['fill_for_phone_order'];?></label></div>
<? 
 } ?>
</div>
<div style="<? /* if(($SITE[paypal] != '' && $SITE['paypal_only'] != 1) || $SITE[tranzila_merchant] != ''){ ?>float:<?=$SITE['align'];?>;<? } */ ?>float:<?=$SITE['align'];?>;margin-<?=$SITE['opalign'];?>:10px;">
<?
if($SITE[paypal] != ''){ 

$palign= ($SITE['paypal_only'] == 1) ? $SITE['align'] : $SITE['opalign']; ?>
<div id="paypal_layer" class="pay_block_type" align="<?=$SITE['align'];?>"<? if($SITE['shopDefaultPayment'] != 'paypal'){ ?> style="display:none"<? } ?>> 
<form id="paypal_form" name="contact_form" method="post" action="?" onsubmit="sendShopOrder(this);return false">
	<? if($SITE[shopOrderPaypalAdditionalFields] == '1') { ?>
	<div class="form_row">* <?=$SHOP_TRANS['full_name'];?> : <input name="fullname" type="text" class="contact_frm fullname"></div> 
	<div style="height:10px"></div>
	<div class="form_row"><span class="phone_label">* <?=$SHOP_TRANS['phone'];?> :</span> <input name="phone" type="text" class="contact_frm phone" dir="ltr"></div> 
	<div style="height:10px"></div>
	<div class="form_row">* <?=$SHOP_TRANS['email'];?> : <input name="email" type="text" class="contact_frm email" dir="ltr"></div> 
	<div style="height:10px"></div>
	<? } ?>
	
	<? if(count($countries) > 1) { ?>
	<div class="form_row">* <?=$SHOP_TRANS['country'];?> : <select id="paypal_country" onchange="setCountry(jQuery(this).val());"  class="contact_frm">
	<? foreach($countries as $countryID => $icountry){ ?>
	<option value="<?=$countryID;?>:<?=$icountry['price'];?>:<?=$icountry['name'];?>:<?=($icountry['vatEffects'] == 1) ? '1' : '0';?>"<?=($country['id'] == $icountry['id']) ? ' SELECTED' : '';?>><?=$icountry['name'];?></option>
	<? } ?>
	</select></div> 
	<div style="height:10px"></div>
	<? } /* elseif(count($countries) == 1) { ?>
	<div align="<?=$SITE['align'];?>">* <?=$SHOP_TRANS['country'];?> : <?=$country['name'];?></div> 
	<div style="height:10px"></div>
	<? } */ ?>
	<? if(count($shippings) > 1) {
		?>
	<div class="form_row">* <?=$SHOP_TRANS['shipping_label'];?> : <select id="paypal_shipping" onchange="setShipping(jQuery(this).val());" class="contact_frm">
	<?if (!$hasDefaultShipping) print '<option value="0:0:'.$SHOP_TRANS[choose].'" selected>'.$SHOP_TRANS[choose].'</option>';?>
	<? foreach($shippings as $shippingID => $ishipping){ ?>
	<option value="<?=$shippingID;?>:<?=$ishipping['price'];?>:<?=$ishipping['name'];?>"<?=($shippingID == $shipping['id'] AND $hasDefaultShipping) ? ' SELECTED' : '';?>><?=$ishipping['name'];?></option>
	<? } ?>
	</select></div> 
	<div style="height:10px"></div>
	<? } /* elseif(count($shippings) == 1) { ?>
	<div align="<?=$SITE['align'];?>">* <?=$SHOP_TRANS['shipping_label'];?> : <?=$shipping['name'];?></div> 
	<div style="height:10px"></div>
	<? } */ ?>
	<? 
	if($SITE[shippingEnabled] == 1)
	{
		?>
			<div style="font-size:20px;text-align:<?=$SITE['align'];?>;margin:10px 20px 0 0px;"><span><?=$SHOP_TRANS['add_shipping'];?></span><div style="clear:both;"></div></div>
			<div class="shipping_form">	
				<div style="height:10px"></div>
				<div class="form_row">* <?=$SHOP_TRANS['shipping_name'];?> : <input name="shipping_name" type="text" class="contact_frm shipping_name"></div> 
				<div style="height:10px"></div>
				<div class="form_row">* <?=$SHOP_TRANS['shipping_adres'];?> : <textarea class="contact_frm_txt contact_adres"  rows="5" name="shipping_adres"></textarea></div>
			</div>
			<div style="height:10px"></div>
		<?
	} ?>
	
	<div class="form_row"><?=$SHOP_TRANS['notes'];?> : <textarea class="contact_frm_txt"  rows="5" name="contact_additional_paypal" id="contact_additional_paypal"></textarea></div>
	<div style="height:10px"></div>
	<? if($SITE['enabledVat'] == 1){ ?>
	<div class="form_row"><div style="margin:0;display:inline-block;text-align:<?=$SITE['align'];?>"><input type="checkbox" id="withVatPayPal" onclick="toggleVat('withVatPayPal');" /> <label for="withVatPayPal"><?=$SITE['VatLabel'];?></label></div></div> 
	<div style="height:10px"></div>
	<div class="form_row" id="vatNumberBlockPayPal" style="display:none;">* <?=$SHOP_TRANS['vat_number'];?> : <input name="vat_number_paypal"  id="vat_number_paypal" type="text" class="contact_frm" dir="ltr" onchange="copyVat(this)"></div> 
	<div style="height:10px"></div>
	<? } 
	if($SITE[greetingEnabled] == 1)
	{
		?>
			<div class="form_row"><label><input class="add_greeting" type="checkbox" onchange="jQuery('.greeting_form',jQuery(this).parent().parent().parent()).toggle();" />&nbsp;<?=$SHOP_TRANS['add_greeting'];?></label></div>
			<div class="greeting_form" style="display:none">	
				<div style="height:10px"></div>
				<div class="form_row">*&nbsp;<?=$SHOP_TRANS['greeting_text'];?> : <textarea class="contact_frm_txt contact_adres"  rows="5" name="greeting_text"></textarea></div>
			</div>
			<div style="height:10px"></div>
		<?
	} ?>
	
	<? 
	if($SITE[memberEnabled] == 1)
	{
		?>
			<div class="form_row"><?=$SHOP_TRANS['member_number'];?> : <input name="member_number" type="text" class="contact_frm member_number" dir="ltr"></div> 
			<div style="height:10px"></div>
		<?
	} ?>
	<div class="form_row">
	<? /* if($SITE[orderSubmitButton] != '') { ?><input type="submit" value="<?=$SHOP_TRANS['send'];?>" class="frm_button sendButton"><? } else { */ ?><input type="image" src=<? if($SITE[orderPaypalButton] != ''){ ?>"<?=SITE_MEDIA.'/'.$gallery_dir;?>/sitepics/<?=$SITE[orderPaypalButton];?>"<? } else { ?>"<?=$SITE[url];?>/images/paypal_button.png" style="margin-<?=$SITE['align'];?>:-12px;"<? } ?> border="0" /><? /* } */ ?></div>
</form>
</div>
<? 
}
if($SITE['paypal_only'] != 1){ ?>
<div id="contact_layer" class="pay_block_type"<? if($SITE['shopDefaultPayment'] != 'phone'){ ?> style="display:none"<? } ?> align="<?=$SITE['align'];?>"> 
<form id="contact_form" name="contact_form" method="post" action="?" onsubmit="sendShopOrder(this);return false"> 
 
	<div class="form_row">* <?=$SHOP_TRANS['full_name'];?> : <input name="fullname" type="text" class="fullname contact_frm"></div> 
	<div style="height:10px"></div>
	<div class="form_row"><span class="phone_label">* <?=$SHOP_TRANS['phone'];?> :</span> <input name="phone" type="text" class="contact_frm phone" dir="ltr"></div> 
	<div style="height:10px"></div>
	<div class="form_row">* <?=$SHOP_TRANS['email'];?> : <input name="email" type="text" class="contact_frm email" dir="ltr"></div> 
	<div style="height:10px"></div>
	<? if(count($countries) > 1) { ?>
	<div class="form_row">* <?=$SHOP_TRANS['country'];?> : <select onchange="setCountry(jQuery(this).val());"  class="contact_frm phone_country">
	<? foreach($countries as $countryID => $icountry){ ?>
	<option value="<?=$countryID;?>:<?=$icountry['price'];?>:<?=$icountry['name'];?>:<?=($icountry['vatEffects'] == 1) ? '1' : '0';?>"<?=($country['id'] == $icountry['id']) ? ' SELECTED' : '';?>><?=$icountry['name'];?></option>
	<? } ?>
	</select></div> 
	<div style="height:10px"></div>
	<? } /* elseif(count($countries) == 1) { ?>
	<div align="<?=$SITE['align'];?>">* <?=$SHOP_TRANS['country'];?> : <?=$country['name'];?></div> 
	<div style="height:10px"></div>
	<? } */ ?>
	<? if(count($shippings) > 1) {
		
		?>
	<div class="form_row">* <?=$SHOP_TRANS['shipping_label'];?> : <select onchange="setShipping(jQuery(this).val());" class="contact_frm phone_shipping">
	<?if (!$hasDefaultShipping) print '<option value="0:0:'.$SHOP_TRANS[choose].'" selected>'.$SHOP_TRANS[choose].'</option>';?>
	<? foreach($shippings as $shippingID => $ishipping){ ?>
	<option value="<?=$shippingID;?>:<?=$ishipping['price'];?>:<?=$ishipping['name'];?>"<?=($shippingID == $shipping['id'] AND $hasDefaultShipping) ? ' SELECTED' : '';?>><?=$ishipping['name'];?></option>
	<? } ?>
	</select></div> 
	<div style="height:10px"></div>
	<? } /* elseif(count($shippings) == 1) { ?>
	<div align="<?=$SITE['align'];?>">* <?=$SHOP_TRANS['shipping_label'];?> : <?=$shipping['name'];?></div> 
	<div style="height:10px"></div>
	<? } */ ?>
	<div class="form_row" id="contact_address">* <?=$SHOP_TRANS['adress'];?> : <textarea class="contact_frm_txt contact_adres"  rows="5" name="contact_adres"></textarea></div> 
	<? 
	if($SITE[shippingEnabled] == 1)
	{
		?>
			<div style="font-size:20px;text-align:<?=$SITE['align'];?>;margin:10px 20px 0 0px;"><span><?=$SHOP_TRANS['add_shipping'];?></span><div style="clear:both;"></div></div>
			<div class="shipping_form">	
				<div style="height:10px"></div>
				<div class="form_row">* <?=$SHOP_TRANS['shipping_name'];?> : <input name="shipping_name" type="text" class="contact_frm shipping_name"></div> 
				<div style="height:10px"></div>
				<div class="form_row">* <?=$SHOP_TRANS['shipping_adres'];?> : <textarea class="contact_frm_txt contact_adres"  rows="5" name="shipping_adres"></textarea></div>
			</div>
			<div style="height:10px"></div>
		<?
	} ?>
	<div style="height:10px"></div>
	<div class="form_row phone_remarks"><?=$SHOP_TRANS['notes'];?> : <textarea class="contact_frm_txt contact_additional"  rows="5" name="contact_additional"></textarea></div>
	<div style="height:10px"></div>
	<input type="hidden" name="pay_type" value="phone" />
	
	<? if($SITE['enabledVat'] == 1){ ?>
	<div class="form_row"><div style="display:inline-block;text-align:<?=$SITE['align'];?>"><input type="checkbox" class="withVat" onclick="toggleVat('withVat');" /> <label for="withVat"><?=$SITE['VatLabel'];?></label></div></div> 
	<div style="height:10px"></div>
	<div class="form_row" id="vatNumberBlock" style="display:none;">* <?=$SHOP_TRANS['vat_number'];?> : <input name="vat_number" type="text" class="contact_frm vat_number" dir="ltr" onchange="copyVat(this)"></div> 
	<div style="height:10px"></div>
	<? }
	if($SITE[greetingEnabled] == 1)
	{
		?>
			<div class="form_row"><label><input class="add_greeting" type="checkbox" onchange="jQuery('.greeting_form',jQuery(this).parent().parent().parent()).toggle();" />&nbsp;<?=$SHOP_TRANS['add_greeting'];?></label></div>
			<div class="greeting_form" style="display:none">	
				<div style="height:10px"></div>
				<div class="form_row">*&nbsp;<?=$SHOP_TRANS['greeting_text'];?> : <textarea class="contact_frm_txt contact_adres"  rows="5" name="greeting_text"></textarea></div>
			</div>
			<div style="height:10px"></div>
		<?
	} ?>
	
	<? 
	if($SITE[memberEnabled] == 1)
	{
		?>
			<div class="form_row"><?=$SHOP_TRANS['member_number'];?> : <input name="member_number" type="text" class="contact_frm member_number" dir="ltr"></div> 
			<div style="height:10px"></div>
		<?
	} ?>
	<table style="border:0px;" class="form_row" cellpadding="0" cellspacing="0"> 
	<tr> 
	<td align="<?=$SITE['align'];?>" style="height:30px;"><input type="submit" value="<?=($SITE[orderPageSubmitSendText] != '') ? $SITE[orderPageSubmitSendText] : $SHOP_TRANS['send'];?>" class="frm_button sendButton"></td> 
	<? if($SITE[orderPageSubmitSendText] == '') { ?>
	<td align="<?=$SITE['opalign'];?>" style="height:30px;"><input type="reset" value="<?=$SHOP_TRANS['clear'];?>"  class="frm_button clearButton"></td> 
	<? } ?>
	</tr> 
	</table>
	</form>  
</div>
<? 
if($SITE[tranzila_merchant] != '') { ?>
<div id="credit_layer" class="pay_block_type"<? if($SITE['shopDefaultPayment'] != 'cc'){ ?> style="display:none"<? } ?> align="<?=$SITE['align'];?>"> 
<form id="credit_form" name="contact_form" method="post" action="?" onsubmit="sendShopOrder(this);return false"> 
 
	<div class="form_row">* <?=$SHOP_TRANS['full_name'];?> : <input name="fullname" type="text" class="contact_frm fullname"></div> 
	<div style="height:10px"></div>
	<div class="form_row"><span class="phone_label">* <?=$SHOP_TRANS['phone'];?>: </span><input name="phone" type="text" class="contact_frm phone" dir="ltr"></div> 
	<div style="height:10px"></div>
	<div class="form_row">* <?=$SHOP_TRANS['email'];?> : <input name="email" type="text" class="contact_frm email" dir="ltr"></div> 
	<div style="height:10px"></div>
	<? if(count($countries) > 1) { ?>
	<div class="form_row">* <?=$SHOP_TRANS['country'];?> : <select onchange="setCountry(jQuery(this).val());"  class="contact_frm phone_country">
	<? foreach($countries as $countryID => $icountry){ ?>
	<option value="<?=$countryID;?>:<?=$icountry['price'];?>:<?=$icountry['name'];?>:<?=($icountry['vatEffects'] == 1) ? '1' : '0';?>"<?=($country['id'] == $icountry['id']) ? ' SELECTED' : '';?>><?=$icountry['name'];?></option>
	<? } ?>
	</select></div> 
	<div style="height:10px"></div>
	<? } /* elseif(count($countries) == 1) { ?>
	<div align="<?=$SITE['align'];?>">* <?=$SHOP_TRANS['country'];?> : <?=$country['name'];?></div> 
	<div style="height:10px"></div>
	<? } */ ?>
	<? if(count($shippings) > 1) { ?>
	<div class="form_row">* <?=$SHOP_TRANS['shipping_label'];?> : <select onchange="setShipping(jQuery(this).val());" class="contact_frm phone_shipping">
	<?if (!$hasDefaultShipping) print '<option value="0:0:'.$SHOP_TRANS[choose].'" selected>'.$SHOP_TRANS[choose].'</option>';?>
	<? foreach($shippings as $shippingID => $ishipping){ ?>
	<option value="<?=$shippingID;?>:<?=$ishipping['price'];?>:<?=$ishipping['name'];?>"<?=($shippingID == $shipping['id'] AND $hasDefaultShipping) ? ' SELECTED' : '';?>><?=$ishipping['name'];?></option>
	<? } ?>
	</select></div> 
	<div style="height:10px"></div>
	<? } /* elseif(count($shippings) == 1) { ?>
	<div align="<?=$SITE['align'];?>">* <?=$SHOP_TRANS['shipping_label'];?> : <?=$shipping['name'];?></div> 
	<div style="height:10px"></div>
	<? } */ ?>
	<div class="form_row" id="contact_address">* <?=$SHOP_TRANS['adress'];?> : <textarea class="contact_frm_txt contact_adres"  rows="5" name="contact_adres"></textarea></div> 
	<div style="height:10px"></div>
	<? 
	if($SITE[shippingEnabled] == 1)
	{
		?>
			<div style="font-size:20px;text-align:<?=$SITE['align'];?>;margin:10px 20px 0 0px;"><span><?=$SHOP_TRANS['add_shipping'];?></span><div style="clear:both;"></div></div>
			<div class="shipping_form">
				<div style="height:10px"></div>
				<div class="form_row">* <?=$SHOP_TRANS['shipping_name'];?> : <input name="shipping_name" type="text" class="contact_frm shipping_name"></div> 	
				<div style="height:10px"></div>
				<div class="form_row">* <?=$SHOP_TRANS['shipping_adres'];?> : <textarea class="contact_frm_txt contact_adres"  rows="5" name="shipping_adres"></textarea></div>
			</div>
			<div style="height:10px"></div>
		<?
	} ?>
	<div class="form_row cc_remarks"><?=$SHOP_TRANS['notes'];?> : <textarea class="contact_frm_txt contact_additional"  rows="5" name="contact_additional"></textarea></div>
	<div style="height:10px"></div>
	
	<input type="hidden" name="pay_type" value="cc" />
	<? if($SITE[max_payments_num] > 1) { ?>
	<div id="payments_num">
		<div class="form_row"><?=$SHOP_TRANS['payments_num'];?> : <select name="payments_num" id="payments_num_select" ><? for($p = 1;$p <= $SITE[max_payments_num];$p++){ ?><option><?=$p;?></option><? } ?></select></div> 
	<div style="height:10px"></div>
	</div>
	<? } 
	if($SITE['enabledVat'] == 1){ ?>
	<div class="form_row"><div style="display:inline-block;text-align:<?=$SITE['align'];?>"><input type="checkbox" class="withVat" onclick="toggleVat('withVat');" /> <label for="withVat"><?=$SITE['VatLabel'];?></label></div></div> 
	<div style="height:10px"></div>
	<div class="form_row" id="vatNumberBlock" style="display:none;">* <?=$SHOP_TRANS['vat_number'];?> : <input name="vat_number" type="text" class="contact_frm vat_number" dir="ltr" onchange="copyVat(this)"></div> 
	<div style="height:10px"></div>
	<? }
	if($SITE[greetingEnabled] == 1)
	{
		?>
			<div class="form_row"><label id="greeting_label"><input class="add_greeting" type="checkbox" onchange="jQuery('.greeting_form',jQuery(this).parent().parent().parent()).toggle();" />&nbsp;<?=$SHOP_TRANS['add_greeting'];?></label></div>
			<div class="greeting_form" style="display:none">	
				<div style="height:10px"></div>
				<div class="form_row">*&nbsp;<?=$SHOP_TRANS['greeting_text'];?> : <textarea class="contact_frm_txt contact_adres"  rows="5" name="greeting_text"></textarea></div>
			</div>
			<div style="height:10px"></div>
		<?
	} ?>
	<? 
	if($SITE[memberEnabled] == 1)
	{
		?>
			<div class="form_row"><?=$SHOP_TRANS['member_number'];?> : <input name="member_number" type="text" class="contact_frm member_number" dir="ltr"></div> 
			<div style="height:10px"></div>
		<?
	} ?>
	<table style="border:0px;" class="form_row" cellpadding="0" cellspacing="0"> 
	<tr> 
	<td align="<?=$SITE['align'];?>" style="height:30px;"><input type="submit" value="<?=($SITE[orderPageSubmitSendText] != '') ? $SITE[orderPageSubmitSendText] : $SHOP_TRANS['send'];?>" class="frm_button sendButton"></td> 
	<? if($SITE[orderPageSubmitSendText] == '') { ?>
	<td align="<?=$SITE['opalign'];?>" style="height:30px;"><input type="reset" value="<?=$SHOP_TRANS['clear'];?>"  class="frm_button clearButton"></td> 
	<? } ?>
	</tr> 
	</table>
	</form>  
</div>
<? } }
?>

</div>
<div style="clear:both;"></div>
<div style="position:absolute;z-index:1;visibility:hidden;" id="under_paypal_form"></div>
<?
if($SITE[shopFeaturedTop] == 0)
	require_once 'shopFeatured.php';
	
?>