<? function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
 
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

if(intval($SITE[cartBgOpacity]) == 0)
	$SITE[cartBgOpacity] = 100;
?>

<style type="text/css">
#cart_wrapper {
	direction:<?=($SITE['align'] == 'left') ? 'rtl' : 'ltr'; ?>;
	
	
}


<?
$rgb = hex2rgb($SITE[shopMiniCartBg]);
?>

#mini_cart {
	<?=(($SITE[shopCartHide] == 1 && $C_STYLING[ShowShopCart]!=1) OR ($SITE[shopCartHide] != 1 && $C_STYLING[HideShopCart]==1)) ? 'display:none;' : '';?>
	direction:<?=($SITE['align'] == 'right') ? 'rtl' : 'ltr'; ?>;
	position:fixed;
	<?=($SITE[shopCartBottom] > 0) ? 'bottom:0;' : '';?>
	color:#<?=$SITE[shopCartTextColor];?>;
	z-index:1000;
	<? if($SITE['shopCartTopMinWidth'] > 0 && $SITE[shopCartBottom] != 2) { ?>width:<?=$SITE['shopCartTopMinWidth'];?>px;<? } 
	else { ?>width:<?=($SITE[shopCartBottom] > 0) ? '100%' : '350px';?>;<? }
	if ($SITE[shopCartBottom] > 0) {
		print $SITE[align].':0;';
	}
	else {
		?>
		margin-left:<?=($SITE['align'] == 'left') ? '600px' : '0px';?>
		<? 
	}
	if ($SITE[shopCartBottom] == 1) { 
		if($SITE[cartBottomImage] != '') { ?>padding-top:20px;background:url('/<?=$gallery_dir.'/sitepics/'.$SITE[cartBottomImage];?>') no-repeat top center;background-color:#<?=$SITE[shopMiniCartBg];?>;<? }
		else { ?>
		background: rgb(<?=$rgb[0];?>, <?=$rgb[1];?>, <?=$rgb[2];?>); /* The Fallback */
		background: rgba(<?=$rgb[0];?>, <?=$rgb[1];?>, <?=$rgb[2];?>, <?=round($SITE[cartBgOpacity]/100,2);?>);
		<? }
	} ?>

}

#sub_mini_cart {
	<? if($SITE['shopCartTopMinWidth'] > 0 && $SITE[shopCartBottom] != 2) { ?>width:<?=$SITE['shopCartTopMinWidth'];?>px;<? } 
	elseif($SITE[shopCartBottom] != 2) { ?>width:<?=($SITE[shopCartBottom] > 0) ? '950px' : '350px';?>;<? } ?>
	<?=($SITE[shopCartBottom] == 1) ? 'margin:0 auto;' : '';?>;
	text-align:<?=$SITE[align];?>;
}



#a_mini_cart {
	<? if ($SITE[shopCartBottom] == 1) {
		print 'padding:5px 0;';
	} else { ?>
	background: rgb(<?=$rgb[0];?>, <?=$rgb[1];?>, <?=$rgb[2];?>); /* The Fallback */
	background: rgba(<?=$rgb[0];?>, <?=$rgb[1];?>, <?=$rgb[2];?>, <?=round($SITE[cartBgOpacity]/100,2);?>);
	<? }
	if($SITE[cartBottomImage] != '' && $SITE[shopCartBottom] < 1) { ?>background:url('/<?=$gallery_dir.'/sitepics/'.$SITE[cartBottomImage];?>') no-repeat bottom center;background-color: #<?=$SITE[shopMiniCartBg];?>;<? } ?>
	<? if($SITE[shopCartBottom] == 2) { ?><? }
	elseif($SITE['shopCartTopMinWidth'] > 0) { ?>width:<?=$SITE['shopCartTopMinWidth'];?>px;<? }
	else { ?>width:<?=($SITE[shopCartBottom] == 1) ? '50%' : '350px';?>;<? } ?>
	<? if($SITE['shopCartTopMinHeight'] > 0 && $SITE[shopCartBottom] != 2) { ?>min-height:<?=$SITE['shopCartTopMinHeight'];?>px;<? } ?>
	position:relative;
}




#sub_mini_cart .roundBox {
	width:100%;
	opacity:<?=round($SITE[cartBgOpacity]/100,2);?>;
	/* IE 8 */
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?=$SITE[cartBgOpacity];?>)";
	
	/* IE 5-7 */
	filter: alpha(opacity=<?=$SITE[cartBgOpacity];?>);
	z-index:1;
}

#sub_mini_cart .roundBox .round_bottom , #sub_mini_cart .roundBox .round_top{
	display:none;
	
}

#in_mini_cart {
	<? if($SITE[shopCartBottom] != 2){ ?>
	padding:0 10px 0 10px;
	<? } else { ?>
	width:950px;
	margin:0 auto;
	<? } ?>
	<? if($SITE['shopCartTopMinHeight'] > 0 && $SITE[cartBottomImage] == '' && $SITE[shopCartBottom] != 2) { ?>min-height:<?=($SITE['shopCartTopMinHeight']-8);?>px;<? } ?>
}

#in_cart_content table tr td{
	padding:10px;
	border-bottom:1px solid #<?=$SITE[shopCartTextColor];?>;
}

.shopButton {
	border-style:none;
	color:#<?=$SITE[shopButtonTextColor];?>;
	background:#<?=$SITE[shopButtonBgColor];?>;
	border:1px solid #<?=$SITE[shopButtonBorderColor];?>;
	float:<?=$SITE[align];?>;
	padding:5px;
	cursor: pointer;
	font-size: <?=$SITE['shopProductPriceSize'];?>px;
}

#cart_button {
	cursor: hand;
	cursor: pointer;
	float:<?=$SITE[align];?>;
	font-weight: bold;
	font-size:16px;
	<?=($SITE[shopCartBottom] == 0) ? 'padding-top:5px;' : '';?>
}

#cart_button img{
	vertical-align:middle;
}

#cart_order_button {
	display: block;
	float:<?=$SITE[opalign];?>;
	margin-<?=$SITE[align];?>:20px;
	font-family: inherit;
	font-size:<?=$SITE[shopProductPriceSize];?>px;
}
#cart_content {
	display:none;
}
#in_cart_content {
	<? if($SITE[shopCartBottom] != 2){ ?>padding:10px;<? }
	else { ?>min-height:50px;<? } ?>
	direction:<?=($SITE['align'] == 'right') ? 'rtl' : 'ltr'; ?>;
	<? if($SITE['shopCartTopMinWidth'] > 0 && $SITE[shopCartBottom] != 2) { ?>width:<?=($SITE['shopCartTopMinWidth']-30);?>px;<? }
	elseif($SITE[shopCartBottom] != 2 && $SITE[shopCartBottom] > 0) { ?>width:550px;<? } ?>
	text-align:<?=$SITE[align];?>;
	font-size:<?=$SITE[contenttextsize];?>px;
}

#in_cart_content a {
	color:#<?=($SITE[shopProductInCartColor] != '') ? $SITE[shopProductInCartColor] : $SITE[linkscolor];?>;
	text-decoration:underline;
}

#in_cart_content a.plusMinus {
	font-weight:bolder;
	font-size:16px;
	color:#<?=($SITE[shopPlusMinusColor]) ? $SITE[shopPlusMinusColor] : $SITE[titlescolor];?>;
	text-decoration: none;
}

.xcloseLink {
	display:block;
	position:absolute;
	bottom:<? if($SITE[cartCloseButton] == '' && $SITE[shopCartBottom] != 1 && $SITE[roundcorners]==1) echo '-5px';elseif($SITE[shopCartBottom] == 1 && $SITE[cartCloseButton] == '') echo '5px'; else echo '0';?>;
	right:initial;
	padding-<?=$SITE[opalign];?>:5px;
	float:<?=$SITE[align];?>;
	color:#<?=$SITE[shopCartTextColor];?>;
	text-decoration:none;
	font-size:14px;
	z-index:2;
	<? if($SITE[shopCartBottom] == 2){ ?>
	top:10px;
	<?=$SITE[align];?>:10px;
	<? } ?>
}
<? $shopCartImage = ($SITE[shopCartImage] == '') ? '' : $gallery_dir.'/sitepics/'.$SITE[shopCartImage]; 
$orderButClass = 'shopButton';
if($SITE[shopButtonOrderImage] != '')
{
	$orderButClass = 'orderButton';
	$size = getimagesize($gallery_dir.'/sitepics/'.$SITE[shopButtonOrderImage]);
	?>
	.orderButton {
		cursor:hand;
		cursor:pointer;
		background:url('<?=$SITE[url];?>/<?=$gallery_dir;?>/sitepics/<?=$SITE[shopButtonOrderImage];?>') no-repeat;
		width:<?=$size[0];?>px;
		height:<?=$size[1];?>px;
		color:transparent;
		font-size:0;
		border:0;
	}
	<?
} ?>
</style>
<!--[if lt IE 9]>

   <style type="text/css">
   #mini_cart {
   	<? if ($SITE[shopCartBottom] == 1 && $SITE[cartBottomImage] == '') { 
		if($SITE[cartBgOpacity] < 100){
			$hexop = dechex(round(255*($SITE[cartBgOpacity]/100)));
			if(strlen($hexop) == 1)
				$hexop = '0'.$hexop; 
			$hexop = strtoupper($hexop); ?>
	       background:transparent;
	       filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#<?=$hexop.$SITE[shopMiniCartBg];?>,endColorstr=#<?=$hexop.$SITE[shopMiniCartBg];?>);
	       zoom: 1;
	       <? } else { ?>
	       background:#<?=$SITE[shopMiniCartBg];?>;
	       <? }
	} ?>
   }
   
	#a_mini_cart {
	<? 
	if (($SITE[shopCartBottom] == 0 || $SITE[shopCartBottom] > 1) && $SITE[cartBottomImage] == '')
	{
		if($SITE[cartBgOpacity] < 100){
			$hexop = dechex(round(255*($SITE[cartBgOpacity]/100)));
			if(strlen($hexop) == 1)
				$hexop = '0'.$hexop; 
			$hexop = strtoupper($hexop); ?>
	       background:transparent;
	       filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#<?=$hexop.$SITE[shopMiniCartBg];?>,endColorstr=#<?=$hexop.$SITE[shopMiniCartBg];?>);
	       zoom: 1;
	       <? } else { ?>
	       background:#<?=$SITE[shopMiniCartBg];?>;
	       <? }
    } ?>
    } 
    
    #label_for_ie {
	    <? if ($SITE[shopCartBottom] == 2 && $SITE[cartBottomImage] == '')
		{
			if($SITE[cartBgOpacity] < 100 && false){
				$hexop = dechex(round(255*($SITE[cartBgOpacity]/100)));
				if(strlen($hexop) == 1)
					$hexop = '0'.$hexop; 
				$hexop = strtoupper($hexop); ?>
		       background:transparent;
		       filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#<?=$hexop.$SITE[shopCartBottomLabelBg];?>,endColorstr=#<?=$hexop.$SITE[shopCartBottomLabelBg];?>);
		       zoom: 1;
		       <?
		     } else { ?>
		       background:#<?=$SITE[shopCartBottomLabelBg];?>;
		     <? }
	    } ?>
    }

    </style>

<![endif]-->
<? 
if ($SITE[shopCartBottom] != 1) print '<div id="cart_wrapper">';
if ($SITE[roundcorners]==1 && $SITE[cartBottomImage] == '') $border_radius = 'border-top-left-radius:5px;border-top-right-radius:5px;';
?>
<div id="mini_cart">
	<div id="sub_mini_cart">
		<div id="a_mini_cart">
			<div id="in_mini_cart">
				<div id="label_for_ie" style="<? if($SITE['shopCartTopMinWidth'] > 0 && $SITE[shopCartBottom] != 2) { ?>width:<?=($SITE['shopCartTopMinWidth']-20);?>px;<? } elseif($SITE[shopCartBottom] != 2) { if($SITE[shopCartBottom] > 0){ ?>width:560px;<? } }else{ ?>width:227px;<? if($SITE[cartBottomImage] == ''){ 
		$rgb = hex2rgb($SITE[shopCartBottomLabelBg]);
		if($SITE[cartBgOpacity] == 100) {
			?>background: rgb(<?=$rgb[0];?>, <?=$rgb[1];?>, <?=$rgb[2];?>);<?
		}
		elseif(!preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])) {
			?>background: rgba(<?=$rgb[0];?>, <?=$rgb[1];?>, <?=$rgb[2];?>, <?=round($SITE[cartBgOpacity]/100,2);?>);<?
		}
	}
} ?><?=($SITE[shopCartBottom] == 2) ? 'min-height:'.(($SITE[shopCartLabelHeight] > 0) ? ($SITE[shopCartLabelHeight]-20) : '68').'px;'.(($SITE[cartBottomImage] != '') ? 'background:url(\'/'.$gallery_dir.'/sitepics/'.$SITE[cartBottomImage].'\') no-repeat;' : '').'position:absolute;top:-'.(($SITE[shopCartLabelHeight] > 0) ? ($SITE[shopCartLabelHeight]-20) : '68').'px;padding:10px;'.$border_radius : '';?>"><div onclick="toggleCart();" id="cart_button"><? if($shopCartImage != '') { ?><img src="<?=SITE_MEDIA;?>/<?=$shopCartImage;?>" border="0" align="middle" /> <? } ?><?=$SHOP_TRANS['my_shopping_cart'];?><span id="shop_quant_placer"<?=(count($_SESSION['ShoppingCart']) == 0) ? ' style="display:none;"' : '';?>> (<span id="shop_cart_items_num"><?=count($_SESSION['ShoppingCart']);?></span>)</span></div>
				<? if($SITE[shopCartBottom] != 2) { ?><input type="button" id="cart_order_button" style="display:<?=($SITE[shopCartBottom]==1) ? 'none' : '';?>" onclick="submitOrder();" value="<?=($SITE[shopButtonOrderImage] != '') ? '' : $SHOP_TRANS['to_pay'];?>" class="<?=$orderButClass;?>" /><? } ?>
				<div style="clear:both;"></div>
				</div>
				<div id="cart_content">
					<div id="in_cart_content"></div>
					<? if($SITE[cartCloseButton] == '') { ?> 
					<a href="#" onclick="toggleCart();return false;" class="xcloseLink"><b>X</b>&nbsp;<?=$SHOP_TRANS['close'];?></a>
					<? } else { ?>
					<a href="#" onclick="toggleCart();return false;" class="xcloseLink"><img src="<?=$SITE[url];?>/<?=$gallery_dir;?>/sitepics/<?=$SITE[cartCloseButton];?>" border="0" align="middle" /></a>
					<? } ?>
					<div style="clear:both"></div>
				</div>
				
			</div>
			
		</div>
		<? if ($SITE[roundcorners]==1 && $SITE[shopCartBottom] == 0) SetRoundedCorners(0,1,$SITE[shopMiniCartBg]); ?>
		<div style="clear:both;"></div>
	</div>
</div>
<?if ($SITE[shopCartBottom] != 1) print '</div>';?>
<script type="text/javascript">
	var cartOpened = false;
	var cart_width = 0;
	
	jQuery(function(){
		//var main_pos = jQuery('.topMenuNew:first').position();
		//jQuery('#mini_cart').css('<?=$SITE[opalign];?>',(main_pos.left-8)+'px');
	});
	
	function toggleCart() {
		if(!cartOpened)
			openCart();
		else
			closeCart();
	}
	
	function closeCart(){
		cartOpened = false;
		jQuery('#cart_content').slideUp();
		<?=($SITE[shopCartBottom]==1) ? "jQuery('#cart_order_button').hide();" : "";?>
	}
	
	function openCart(){
		cartOpened = true;
		jQuery('#in_cart_content').load('<?=$SITE[url];?>/ajax_cart.php?showit=1<?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>',function(){jQuery('#cart_content').show();loadedCart();jQuery('#cart_content').hide();jQuery('#cart_content').slideDown();jQuery('#cart_order_button').show();});
	}
	
	function loadedCart(no_reopening) {
		jQuery('#shop_cart_items_num, .fixed_footer .inner div.icon#shopping_cart .cart_count').text(jQuery('#in_cart_content .cItem').length);
		if(jQuery('#in_cart_content .cItem').length > 0)
			jQuery('#shop_quant_placer').show();
		
		//setTimeout(function(){
			var max_height = 0;
			jQuery('.theName').each(function(){
				if(jQuery(this).height() > max_height)
					max_height = jQuery(this).height();
			});
			jQuery('.theName').height(max_height);
			max_height = 0;
			jQuery('.theItem').each(function(){
				if(jQuery(this).outerHeight(true) > max_height)
					max_height = jQuery(this).outerHeight(true);
			});
			jQuery('#theCartItems').height(max_height);
		//},10);
	}
	
	function loadCartTo(obj_id){
		jQuery('#'+obj_id).load('<?=$SITE[url];?>/ajax_cart.php?showit=1&orderPage=1<?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>');
	}
	var global_AttributesNeeded=1;
	function AddToCart(ProductID) {
		var pars = 'action=addToCart&ProductID='+ProductID;
		AttributesSelected=1;
		jQuery('select.ProductAttributeSelect').each(function(){
			AttributeID = jQuery(this).attr('name').replace('attribute_','');
			ValueID = jQuery('option:selected',this).val();
			AttributeName= jQuery('option:selected',this).text();
			pars += '&attrs[]='+AttributeID+':'+ValueID;
			if (ValueID==0 && global_AttributesNeeded==1) {
			   AttributesSelected=0;
			   alert(AttributeName);
			}
		});
		jQuery('.attr_one_val').each(function(){
			AttributeID = jQuery(this).attr('data-attr-id');
			ValueID = jQuery(this).attr('data-attr-val');
			pars += '&attrs[]='+AttributeID+':'+ValueID;
		});
		if(AttributesSelected==1) {
			jQuery.ajax({
				url: '<?=$SITE[url];?>/ajax_cart.php?quantity='+jQuery('#quantity_cart').val()+'<?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>',
				type:'post',
				data:pars,
				success:function (transport) {
					if(transport == 'NOT_ENOUGH')
						alert('<?=$SHOP_TRANS['not_enought'];?>!');
					else
					{
						updateShoppingCart();
						if(!cartOpened)
							openCart();
							jQuery(".fixed_footer .inner div.icon#shopping_cart").show();
							jQuery(".fixed_footer .inner div.icon#shopping_cart .cart_count").removeClass("animated bounceIn").addClass("animated bounceIn");
					}
				}
			});
		}
	}
	
	function AddAndCheckout(ProductID) {
		var pars = 'action=addToCart&ProductID='+ProductID;
		AttributesSelected=1;
		jQuery('select.ProductAttributeSelect').each(function(){
			AttributeID = jQuery(this).attr('name').replace('attribute_','');
			ValueID = jQuery('option:selected',this).val();
			AttributeName= jQuery('option:selected',this).text();
			pars += '&attrs[]='+AttributeID+':'+ValueID;
			if (ValueID==0 && global_AttributesNeeded==1) {
			   AttributesSelected=0;
			   alert(AttributeName);
			}
		});
		jQuery('.attr_one_val').each(function(){
			AttributeID = jQuery(this).attr('data-attr-id');
			ValueID = jQuery(this).attr('data-attr-val');
			pars += '&attrs[]='+AttributeID+':'+ValueID;
		});
		 if(AttributesSelected==1) {
			jQuery.ajax({
				url: '<?=$SITE[url];?>/ajax_cart.php?quantity='+jQuery('#quantity_cart').val()+'<?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>',
				type:'post',
				data:pars,
				success:function (transport) {
					if(transport == 'NOT_ENOUGH')
						alert('<?=$SHOP_TRANS['not_enough'];?>!');
					else
					{
						submitOrder();
					}
				}
			});
		}
	}
	
	function addRowProduct(ProductID,lineNumber) {
		var pars = 'action=addToCart&ProductID='+ProductID;
		jQuery('input.attrsHidden_'+lineNumber).each(function(){
			pars += '&attrs[]='+jQuery(this).val();
		});
		jQuery.ajax({
			url: '<?=$SITE[url];?>/ajax_cart.php?quantity='+jQuery('#quantity_'+lineNumber).val()+'<?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>',
			type:'post',
			data:pars,
			success:function (transport) {
				if(transport == 'NOT_ENOUGH')
					alert('<?=$SHOP_TRANS['not_enought'];?>!');
				else
				{
					updateShoppingCart();
					if(!cartOpened)
						openCart();
				}
			}
		});
	}
	
	function addAllRowProducts(ProductID) {
		var pars = 'action=massAddToCart&ProductID='+ProductID;
		jQuery('.AttributeTableCart tr').each(function(){
			if(jQuery(this).attr('id').substr(0,9) == 'attrLine_')
			{
				var lineNumber = parseInt(jQuery(this).attr('id').replace('attrLine_',''));
				var quantity = parseInt(jQuery('#quantity_'+lineNumber).val());
				if(quantity > 0)
				{
					jQuery('input.attrsHidden_'+lineNumber).each(function(){
						pars += '&attrs_'+lineNumber+'[]='+jQuery(this).val();
					});
					pars += '&lineNumbers[]='+lineNumber+'&quantity_'+lineNumber+'='+quantity;
				}
			}
		});
		jQuery.ajax({
			url: '<?=$SITE[url];?>/ajax_cart.php?<?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>',
			type:'post',
			data:pars,
			success:function (transport) {
				if(transport == 'NOT_ENOUGH')
					alert('<?=$SHOP_TRANS['not_enought'];?>!');
				else
				{
					updateShoppingCart();
					if(!cartOpened)
						openCart();
				}
			}
		});
	}
	
	function IncrementItemInCart(cart_key) {
		jQuery.ajax({
			url: '<?=$SITE[url];?>/ajax_cart.php<?=($SITE_LANG[selected] != 'he') ? '?lang='.$SITE_LANG[selected] : '';?>',
			type:'post',
			data:'action=incrementInCart&cartKey='+cart_key,
			success:function (transport) {
				if(transport == 'NOT_ENOUGH')
					alert('<?=$SHOP_TRANS['not_enough'];?>!');
				else
					updateShoppingCart();
			}
		});
	}
	
	function DecrementItemInCart(cart_key) {
		var quant = parseInt(jQuery('#count_'+cart_key).html());
		if(quant == 1 && !confirm('<?=$SHOP_TRANS['you_sure_remove'];?>?'))
			return;
		jQuery.ajax({url: '<?=$SITE[url];?>/ajax_cart.php<?=($SITE_LANG[selected] != 'he') ? '?lang='.$SITE_LANG[selected] : '';?>', type:'post', data:'action=decrementInCart&cartKey='+cart_key, success:function (transport) { updateShoppingCart(); }});
	}
	
	function RemoveItemInCart(cart_key) {
		if(!confirm('<?=$SHOP_TRANS['you_sure_remove'];?>?'))
			return;
		jQuery.ajax({
			url: '<?=$SITE[url];?>/ajax_cart.php<?=($SITE_LANG[selected] != 'he') ? '?lang='.$SITE_LANG[selected] : '';?>',
			type:'post',
			data:'action=removeInCart&cartKey='+cart_key,
			success:function (transport) {
					updateShoppingCart();
			}
		});
	}
	
	function updateShoppingCart() {
		if(cartOpened)
		{
			jQuery('#in_cart_content').load('<?=$SITE[url];?>/ajax_cart.php?showit=1<?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>',function(){loadedCart(true);});
			
		}
	}
	
	function sendShopOrder(form_elem) {
		var ok = false;
		if(jQuery(form_elem).attr('id') == 'paypal_form') {
			if(jQuery('#withVatPayPal:checked').length > 0 && jQuery('#vat_number_paypal').val() == '')
				alert('<?=$SHOP_TRANS['star_fields_cant_be_empty'];?>!');
			else {
				<? if($SITE[shopOrderPaypalAdditionalFields] == '1') { ?>
				if(jQuery('.fullname',form_elem).val() == '' || jQuery('.phone',form_elem).val() == '' || jQuery('.email',form_elem).val() == '')
					alert('<?=$SHOP_TRANS['star_fields_cant_be_empty'];?>!');
				else
				{
					if(isValidEmail(jQuery('.email',form_elem).val()))
					{
						if(IsNumeric(jQuery('.phone',form_elem).val()))
						{
							
						<? } ?>
							var pars = 'action=sendOrder&paypal=1&contact_additional='+encodeURIComponent(jQuery('#contact_additional_paypal').val());
							<? if($SITE[shopOrderPaypalAdditionalFields] == '1') { ?>
							pars += '&fullname='+encodeURIComponent(jQuery('.fullname',form_elem).val())+'&phone='+encodeURIComponent(jQuery('.phone',form_elem).val())+'&email='+encodeURIComponent(jQuery('.email',form_elem).val());
							<? } ?>
							ok = true;
							if(jQuery('#withVatPayPal:checked').length > 0)
								pars += '&VatNumber='+encodeURIComponent(jQuery('#vat_number_paypal').val());
						<? if($SITE[shopOrderPaypalAdditionalFields] == '1') { ?>
						}
						else
							alert('<?=$SHOP_TRANS['invalid_phone'];?>!');
					}
					else
						alert('<?=$SHOP_TRANS['invalid_email'];?>!');
				}
				<? } ?>
			}
		}
		else{
			if(jQuery('.withVat:checked',form_elem).length < 1 || jQuery('.vat_number',form_elem).val() == '' || jQuery('.fullname',form_elem).val() == '' || jQuery('.phone',form_elem).val() == '' || jQuery('.email',form_elem).val() == '' || jQuery('.contact_adres',form_elem).val() == '')
				alert('<?=$SHOP_TRANS['star_fields_cant_be_empty'];?>!');
			else {
				if(isValidEmail(jQuery('.email',form_elem).val()))
				{
					if(IsNumeric(jQuery('.phone',form_elem).val()))
					{
						var pars = 'action=sendOrder&fullname='+encodeURIComponent(jQuery('.fullname',form_elem).val())+'&phone='+encodeURIComponent(jQuery('.phone',form_elem).val())+'&email='+encodeURIComponent(jQuery('.email',form_elem).val())+'&contact_adres='+encodeURIComponent(jQuery('.contact_adres',form_elem).val())+'&contact_additional='+encodeURIComponent(jQuery('.contact_additional',form_elem).val())+'&pay_type='+jQuery('input[name=pay_type]',form_elem).val();
						if(jQuery('#payments_num_select').length > 0 && jQuery('input[name=pay_type]',form_elem).val() == 'cc')
							pars += '&payments_num='+jQuery('#payments_num_select').val();
						if(jQuery('.withVat:checked',form_elem).length > 0)
							pars += '&VatNumber='+encodeURIComponent(jQuery('.vat_number',form_elem).val());
						ok = true;
					}
					else
						alert('<?=$SHOP_TRANS['invalid_phone'];?>!');
				}
				else
					alert('<?=$SHOP_TRANS['invalid_email'];?>!');
			}
		}
		if(ok){
			
			if(jQuery('input[name=shipping_name]',form_elem).length > 0)
			{
				if(jQuery('textarea[name=shipping_adres]',form_elem).val() == '' || jQuery('input[name=shipping_name]',form_elem).val() == '')
				{
					ok = false;
					alert('<?=$SHOP_TRANS['star_fields_cant_be_empty'];?>!');
				}
			}
			if(jQuery('.add_greeting:checked',form_elem).length > 0 && jQuery('textarea[name=greeting_text]',form_elem).val() == '')
			   {
			         ok = false;
				 alert('<?=$SHOP_TRANS['star_fields_cant_be_empty'];?>!');
			   }
			if(jQuery('textarea[name=contact_additional]',form_elem).val() == '' && is_shop_remarks_must==1)
			   {
			         ok = false;
				 alert('<?=$SHOP_TRANS['star_fields_cant_be_empty'];?>!');
			   }
		}
		if(ok){
			if(countryID > 0)
				pars += '&countryID='+countryID;
			if(shippingID > 0)
				pars += '&shippingID='+shippingID;
			if(jQuery('.add_greeting:checked',form_elem).length > 0)
			{
				pars+= '&greetingText='+encodeURIComponent(jQuery('textarea[name=greeting_text]',form_elem).val());
			}
			if(jQuery('input[name=shipping_name]',form_elem).length > 0)
			{
				pars+= '&shipping_adres='+encodeURIComponent(jQuery('textarea[name=shipping_adres]',form_elem).val())+'&shipping_name='+encodeURIComponent(jQuery('input[name=shipping_name]',form_elem).val());
			}
			if(jQuery('.member_number',form_elem).length > 0)
			{
				pars+= '&memberNumber='+encodeURIComponent(jQuery('.member_number',form_elem).val());
			}
			jQuery.ajax({
				url: '<?=$SITE[url];?>/ajax_cart.php<?=($SITE_LANG[selected] != 'he') ? '?lang='.$SITE_LANG[selected] : '';?>',
				type:'post',
				data:pars,
				success:function (transport) {
					//closeCart();
					if(transport.substr(0,6) == 'error:')
						alert(transport.substr(6));
					else
					{
						if(jQuery(form_elem).attr('id') == 'paypal_form' || jQuery('input[name=pay_type]',form_elem).val() == 'cc') {
							jQuery('#under_paypal_form').html(transport);
							jQuery('#paypal_payment_form').submit();
						}
						else
						{
							//alert('הזמנתך נשלחה בהצלחה!');
							document.location.href='<?=$SITE['url'];?>/category/order-complete-phone';
						}
					}
				}
			});
		}
	}
	
	function submitOrder() {
		document.location.href='<?=$SITE[url];?>/order.php<?=($SITE_LANG[selected] != 'he') ? '?lang='.$SITE_LANG[selected] : '';?>';
	}
	
	function isValidEmail(str) {
		return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
	}
	
	function IsNumeric(strString)
	{
		var strValidChars = "0123456789-()";
		var strChar;
		var blnResult = true;
		
		if (strString.length == 0)
			return false;
			
		for (i = 0; i < strString.length && blnResult == true; i++)
		{
			strChar = strString.charAt(i);
			if (strValidChars.indexOf(strChar) == -1)
				blnResult = false;
		}
		
		return blnResult;
	}
	
	function setPayVis()
	{
		if(jQuery('#pay_type').val() == 'cc' && jQuery('#payments_num').length > 0)
			jQuery('#payments_num').show();
		else
			jQuery('#payments_num').hide();
	}
</script>