<?
//General Config Form
include_once("checkAuth.php");
include("colorpicker.php");
$CONF=GetConfigVars();
for ($a=0;$a<count($CONF[ConfigID]);$a++) {
	$V[$CONF[VarName][$a]]=$CONF[VarValue][$a];
}
$SHOP_TRANS['shop_admin_email']='Notify Store manager on Email';
if ($SITE_LANG[selected]=="he") {
	$SHOP_TRANS['shop_admin_email']='שלח הודעה על הזמנות חדשות לכתובת';
}
if ($SITE['shop_email']=="") $V['SITE[shop_email]']=$SITE['FromEmail'];
?>
<style type="text/css">
table tr td {text-align: <?=$SITE[opalign];?>;vertical-align: middle;}
table tr td.checkb {text-align: <?=$SITE[align];?>}
</style>
<script type="text/javascript">
jQuery(document).ready(function() { 
    var options = { 
        target:        '.msgGeneralAdminNotification', 
        success:       function(){showNotification(1);}  // target element(s) to be updated with server response 
        

    }; 
   	jQuery('#config').ajaxForm(options); 
}); 
</script>
<div align="center" class="general" style="width:900px">
<h3><?=$SHOP_TRANS['shopOptions'];?></h3>
<form id="config" method="POST" action="saveConfig.php" target="ifrmData">
<br />

<table class="ConfigAdmin" cellpadding="3" cellspacing="5">
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['shop_admin_email'];?>: </td><td align="<?=$SITE[opalign];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[shop_email]" value="<?=$V['SITE[shop_email]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['paypal_acc'];?>: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[paypal]" value="<?=$V['SITE[paypal]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['AproductPicWidth'];?>: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[productPicWidth]" value="<?=$V['SITE[productPicWidth]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['AproductPicHeight'];?>: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[productPicHeight]" value="<?=$V['SITE[productPicHeight]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['AshopProdsPerPage'];?>: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[shopProdsPerPage]" value="<?=$V['SITE[shopProdsPerPage]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['tax'];?>: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[tax]" value="<?=$V['SITE[tax]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top">Tranzila merchant: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[tranzila_merchant]" value="<?=$V['SITE[tranzila_merchant]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top">Tranzila secret: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[tranzila_secret]" value="<?=$V['SITE[tranzila_secret]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['max_payments_num'];?>: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[max_payments_num]" value="<?=$V['SITE[max_payments_num]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$ADMIN_TRANS['default stock quantity for new products'];?></td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[shop_default_quantity]" value="<?=$V['SITE[shop_default_quantity]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['payments_type'];?>: </td><td align="<?=$SITE[align];?>">
<select name="SITE[payments_type]" class="ConfigAdminSelect">
<option value="8">Regular</option>
<option value="6"<? if($V['SITE[payments_type]'] == 6){ ?> SELECTED<? } ?>>Credit</option>
</select>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['currency'];?>: </td><td align="<?=$SITE[align];?>">
<select name="SITE[nis]" class="ConfigAdminSelect">
<option value="USD">USD</option>
<option value="NIS"<? if($V['SITE[nis]'] == 'NIS'){ ?> SELECTED<? } ?>>NIS</option>
<option value="EUR"<? if($V['SITE[nis]'] == 'EUR'){ ?> SELECTED<? } ?>>EUR</option>
</select>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['currency_sign'];?>: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[ItemsCurrency]" value="<?=$V['SITE[ItemsCurrency]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"> </td><td class="checkb" align="<?=$SITE[align];?>"><input type="checkbox" id="SITE[showWithTax]" name="SITE[showWithTax]" value="1" <?=($SITE['showWithTax'] == 1) ? 'CHECKED' : '';?>/>&nbsp;<label for="SITE[showWithTax]"><?=$SHOP_TRANS['showWithTax'];?></label>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" class="checkb"> </td><td class="checkb" align="<?=$SITE[align];?>"><input type="checkbox" id="SITE[paypal_only]" name="SITE[paypal_only]" value="1" <?=($SITE['paypal_only'] == 1) ? 'CHECKED' : '';?>/>&nbsp;<label="SITE[paypal_only]"><?=$SHOP_TRANS['PaypalOnly'];?></label>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" class="checkb"> </td><td class="checkb" align="<?=$SITE[align];?>"><input type="checkbox" id="SITE[enabledVat]" name="SITE[enabledVat]" value="1" <?=($SITE['enabledVat'] == 1) ? 'CHECKED' : '';?>/>&nbsp;<label for="SITE[enabledVat]"><?=$SHOP_TRANS['VatEnabled'];?></label>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" class="checkb"> </td><td class="checkb" align="<?=$SITE[align];?>"><input type="checkbox" id="SITE[greetingEnabled]" name="SITE[greetingEnabled]" value="1" <?=($SITE['greetingEnabled'] == 1) ? 'CHECKED' : '';?>/>&nbsp;<label for="SITE[greetingEnabled]"><?=$SHOP_TRANS['greetingEnabled'];?></label>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" class="checkb"> </td><td class="checkb" align="<?=$SITE[align];?>"><input type="checkbox" id="SITE[shippingEnabled]" name="SITE[shippingEnabled]" value="1" <?=($SITE['shippingEnabled'] == 1) ? 'CHECKED' : '';?>/>&nbsp;<label for="SITE[shippingEnabled]"><?=$SHOP_TRANS['shippingEnabled'];?></label>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" class="checkb"> </td><td class="checkb" align="<?=$SITE[align];?>"><input type="checkbox" id="SITE[memberEnabled]" name="SITE[memberEnabled]" value="1" <?=($SITE['memberEnabled'] == 1) ? 'CHECKED' : '';?>/>&nbsp;<label for="SITE[memberEnabled]"><?=$SHOP_TRANS['memberEnabled'];?></label>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" class="checkb"> </td><td class="checkb" align="<?=$SITE[align];?>"><input type="checkbox" id="SITE[couponsEnabled]" name="SITE[couponsEnabled]" value="1" <?=($SITE['couponsEnabled'] == 1) ? 'CHECKED' : '';?>/>&nbsp;<label for="SITE[couponsEnabled]"><?=$SHOP_TRANS['couponsEnabled'];?></label>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['VatLabel'];?>: </td><td  align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[VatLabel]" value="<?=$V['SITE[VatLabel]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top"><?=$SHOP_TRANS['defaultPayment'];?>: </td><td>
<select name="SITE[shopDefaultPayment]" class="ConfigAdminSelect">
<option value="phone"><?=$SHOP_TRANS['phonePayment'];?></option>
<option value="cc"<? if($V['SITE[shopDefaultPayment]'] == 'cc'){ ?> SELECTED<? } ?>><?=$SHOP_TRANS['pay_type_cc'];?></option>
<option value="paypal"<? if($V['SITE[shopDefaultPayment]'] == 'paypal'){ ?> SELECTED<? } ?>>Paypal</option>
</select>
</td>
</tr>
<tr>
<td></td>
<td align="center"><br />

<input type="submit" class="greenSave" value="<?=$ADMIN_TRANS['save changes'];?>" id="newSaveIcon">

</td>
</tr>
</table>
</br>
<input type="hidden" name="shop_config_win" value=1 />
</form>
</div>
<?include_once("footer.inc.php");?>