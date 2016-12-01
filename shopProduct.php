<?php
require_once 'inc/ProductsShop.inc.php';
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
global $SHOP_TRANS;

function AttrsTable() {
	global $SITE,$SHOP_TRANS,$ProductData,$CHECK_PAGE,$butClass,$gallery_dir;
	$cart_img_url = ($SITE[shopAttrsTableCartPic] == '') ? '/images/AddToBasket.gif' : SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$SITE[shopAttrsTableCartPic];
	?>
	<div class="mainContentText">
		<table cellspacing="0" cellpadding="5" border="0" width="100%" class="AttributeTableCart">
			<tr id="attrLinesTitles">
				<td width="65" style="white-space:nowrap;border-bottom:1px solid #<?=$SITE[contenttextcolor];?>"><?=$SHOP_TRANS['add_to_shopping_cart'];?></td>
				<?
				$lines = 0;
				foreach($ProductData['attributes'] as $AttributeID => $Attribute)
					if(count($Attribute['values']) > 0) { ?>
						<td style="border-bottom:1px solid #<?=$SITE[contenttextcolor];?>"><b><?=$Attribute['name'];?></b></td>
						<? 
						if($lines < count($Attribute['values']))
							$lines = count($Attribute['values']);
					} ?> 
				<td style="border-bottom:1px solid #<?=$SITE[contenttextcolor];?>"><b><?=$SHOP_TRANS['price'];?></b></td>
			</tr>
			<? for($l = 0;$l < $lines;$l++){
				$price = (floatval($ProductData['discountPrice']) > 0) ? floatval($ProductData['discountPrice']) : floatval($ProductData['ProductPrice']); ?>
			<tr id="attrLine_<?=$l;?>">
				<td>
					<a href="#" onclick="addRowProduct(<?=$CHECK_PAGE['ProductID'];?>,<?=$l;?>);return false;"><img src="<?=$cart_img_url;?>" border="0" style="vertical-align:middle;" /></a>
					<input type="text" id="quantity_<?=$l;?>" value="0" style="width:32px;height:13px;vertical-align:middle;padding:2px;background-color: #<?=$SITE[shopSelectBg];?>;color:#<?=$SITE[shopSelectTextColor];?>;border:1px solid;" />
				</td>
				<? foreach($ProductData['attributes'] as $AttributeID => $Attribute)
				if(count($Attribute['values']) > 0){
					$keys = array_keys($Attribute['values']);
					echo '<td>';
					if(isset($keys[$l]))
					{
						echo $Attribute['values'][$keys[$l]]['name'];
						$price += floatval($Attribute['values'][$keys[$l]]['price_effect']);
						echo '<input type="hidden" class="attrsHidden_'.$l.'" value="'.$AttributeID.':'.$keys[$l].'" />';
					}
					
					echo '</td>';
				} ?>
				<td><?=show_price_side($price,false);?></td>
			</tr>
			<? } ?>
		</table>
		<br/>
		<div class="<?=$butClass;?>" style="float:<?=$SITE[align];?>" onclick="addAllRowProducts(<?=$CHECK_PAGE['ProductID'];?>);"><?=$SHOP_TRANS['add_to_shopping_cart'];?></div>
		<br/><br/>
	</div>
	<?
}

function AttrsAndButs() {
	global $PAGE_ID,$ADMIN_TRANS,$SITE,$SHOP_TRANS,$ProductData,$butClass,$obutClass,$CHECK_PAGE,$shopCartImage;
	if (isset($_SESSION['LOGGED_ADMIN']) || $ProductData['specialAttrsTable'] != '1') { ?>
	<div style="padding:5px 5px <?=($SITE[roundcorners]==1 && $PAGE_ID['shopOptions']['roundedCorners'] == 1) ? '0px' : '10px';?>;background:#<?=$SITE[shopAttrsBgColor];?>;<? if ($ProductData['galleryEffect'] == 1 && $ProductData['galleryAside'] == 1 && $SITE[roundcorners]!=1) {
		$bcolor = ($SITE[productPicsBlockBorder] != '' ) ? $SITE[productPicsBlockBorder] : $SITE[effectgallerybordercolor];
	 ?>border:1px solid #<?=$bcolor;?>;<?
	  } ?>">
		<? if (isset($_SESSION['LOGGED_ADMIN'])) { ?>
			<div id="newSaveIcon" class="edit_att_but" onclick="EditAttributes();"><?=$SHOP_TRANS['EditItemsAttrs'];?></div>&nbsp;
			<div id="newSaveIcon" class="edit_att_but" onclick="EditRelated();"><?=$SHOP_TRANS['EditRelated'];?></div>&nbsp;
			<? if($ProductData['galleryEffect'] != 0) { ?><br/><br/><div id="newSaveIcon" class="edit_att_but" onclick="jQuery('#more_pics').slideToggle();"><?=$ADMIN_TRANS['edit photos'];?></div>&nbsp;<? } ?>
			<br/><br/>
			<div id="newSaveIcon" class="pics_add_but" onclick="AddPics(this);"><img style="vertical-align:-20%;" src="<?=$SITE[url];?>/Admin/images/slides.png" />&nbsp;<?=$ADMIN_TRANS['add photo'];?></div><br/><br/>
		<? }
		if($ProductData['specialAttrsTable'] != '1' || isset($_SESSION['LOGGED_ADMIN'])) { ?>
		<div style="width:100%;overflow:hidden;">
		<table cellspacing="3" cellpadding="0" border="0" width="100%">
			<? if(floatval($ProductData['ProductPrice']) > 0 || isset($_SESSION['LOGGED_ADMIN'])){ ?>
			<tr id="ProductPrice">
				<td style="white-space:nowrap"><span class="shortContentTitle" style="padding-<?=$SITE[align];?>:0px;"><?=$SHOP_TRANS['price'];?>:</span></td>
				<td style="white-space:nowrap" width="100%"><span id="thePriceSpan" class="shortContentTitle" style="padding-<?=$SITE[align];?>:0px;<? if(floatval($ProductData['discountPrice']) > 0){ ?>text-decoration: line-through;<? } ?>" itemprop="offers" itemscope itemtype="http://schema.org/Offer"><? if($SITE[shopMarkOutOfStock] == 1 && $ProductData['quantity'] < 1){ ?><link itemprop="availability" href="http://schema.org/OutOfStock" /><? }else{ ?><link itemprop="availability" href="http://schema.org/InStock" /><? } ?><?=show_price_side($ProductData['ProductPrice'],true,'',true);?></span></td>
			</tr>
			<? } ?>
			<? if(floatval($ProductData['discountPrice']) > 0 || isset($_SESSION['LOGGED_ADMIN'])){ ?>
			<tr id="discountPrice">
				<td style="white-space:nowrap"><span class="shortContentTitle" style="padding-<?=$SITE[align];?>:0px;"><?=$SHOP_TRANS['discount_price'];?>:</span></td>
				<td style="white-space:nowrap" width="100%"><span id="thediscountSpan" class="shortContentTitle" style="padding-<?=$SITE[align];?>:0px;color:#<?=$SITE[shopProductsPageDiscountPriceColor];?>;"><?=show_price_side($ProductData['discountPrice'],true,'',false,'discountPrice');?></span></td>
			</tr>
			<? } ?>
			<? if($ProductData['specialAttrsTable'] != '1') { ?>
			<? if($SITE[shopMarkOutOfStock] == 1 && $ProductData['quantity'] < 1){ ?>
			<tr><td colspan="2"><span style="font-weight:bold;color:#<?=$SITE[shopOutOfStockColor];?>"><?=$SHOP_TRANS['outOfStock'];?></span></td></tr>
			<? } else { 
				$maxQuantity=100;
				if ($ProductData['quantity']<$maxQuantity) $maxQuantity=$ProductData['quantity'];
				?>
			<tr id="ProductQ">
				<td style="white-space:nowrap"><span class="shortContentTitle" style="padding-<?=$SITE[align];?>:0px;"><?=$SHOP_TRANS['quantity'];?>:</span></td>
				<td style="white-space:nowrap" width="100%"><select class="ProductSelectQuantity" style="width:40px;vertical-align:center;text-align: center" id="quantity_cart" name="quantity_cart">
					<?for($qqq=1;$qqq<=$maxQuantity;$qqq++){print '<option value='.$qqq.'>'.$qqq.'</option>';}?>
				</select>
				</td>
			</tr>
			<? }
		
			foreach($ProductData['attributes'] as $AttributeID => $Attribute)
				if(count($Attribute['values']) > 0) { ?>
				<tr>
					<td style="white-space:nowrap"><span class="shortContentTitle attrTitle" style="padding-<?=$SITE[align];?>:0px;"><?=$Attribute['name'];?>:</span></td>
					<td width="100%" class="attr_one_val_cell"><div>
					
					<? 
					if(count($Attribute['values']) == 1)
					{	
						$vname = array_pop($Attribute['values']);
						$attr_key=array_keys($ProductData['attributes'][$AttributeID]['values']);
						$attr_val=$attr_key[0];
						echo '<span style="font-weight:normal;" class="attr_one_val" data-attr-id="'.$AttributeID.'" data-attr-val="'.$attr_val.'">'.$vname['name'].'</span>';
					}
					else
					{ 
						?><select onchange="showThePrice();" class="ProductAttributeSelect" style="width:100%;" name="attribute_<?=$AttributeID;?>">
						<option value="0"><?=$SHOP_TRANS['choose'];?> <?=$Attribute['name'];?></option>
						<?
						foreach($Attribute['values'] as $vid => $vname)
							echo '<option value="'.$vid.'">'.$vname['name'].'</option>';
						?></select><?
					}
					 ?>
					</div></td>
				</tr>
			<? } } ?>
		
		</table>
		</div>
		<? if($ProductData['specialAttrsTable'] != '1') { ?>
		<br/>
		<div class="<?=$butClass;?>" style="float:<?=$SITE[align];?>" onclick="AddToCart(<?=$CHECK_PAGE['ProductID'];?>);"><?=$SHOP_TRANS['add_to_shopping_cart'];?></div>
		<div class="<?=$obutClass;?>" style="float:<?=$SITE[opalign];?>" onclick="AddAndCheckout(<?=$CHECK_PAGE['ProductID'];?>);"><?=$SHOP_TRANS['add_to_cart_and_pay'];?></div>
		<div style="clear:both;"></div>
		<? } } ?>
		<script type="text/javascript">
			var additionalPrices = {
				<? foreach($ProductData['attributes'] as $AttributeID => $Attribute)
					if(count($Attribute['values']) > 0) {
						echo "'{$AttributeID}' : {";
						foreach($Attribute['values'] as $vid => $vname)
							echo "'{$vid}' : ".floatval($vname['price_effect']).",";
						echo "'0' : 0 },";
					}
				?>
				'0' : 0,
			};
			
			var originalDPrice = <?=floatval($ProductData['discountPrice']);?>;
			
			var originalBPrice = <?=floatval($ProductData['ProductPrice']);?>;
			var priceCalculateBySquare=0;
			
			jQuery(function(){
				if (priceCalculateBySquare==1) showThePriceSquareFeet();
				else showThePrice();
			});
			
			function showThePrice()
			{
				if (priceCalculateBySquare==1) {showThePriceSquareFeet();return true;}
				var addiPrice = 0;
				jQuery('select.ProductAttributeSelect').each(function(){
					var aid = jQuery(this).attr('name').replace('attribute_','');
					addiPrice += additionalPrices[aid][jQuery(this).val()];
				});
				jQuery('.attr_one_val').each(function(){
					var aid = jQuery(this).attr('data-attr-id');
					addiPrice += additionalPrices[aid][jQuery(this).attr('data-attr-val')];
				});
				var finalDPrice = originalDPrice+addiPrice;
				var finalBPrice = originalBPrice+addiPrice;
				jQuery('#thePriceSpan .price').html(finalBPrice);
				jQuery('#thediscountSpan .price').html(finalDPrice);
			}
			function showThePriceSquareFeet()
			{
				var addiPrice = 1;
				jQuery('select.ProductAttributeSelect').each(function(){
					var aid = jQuery(this).attr('name').replace('attribute_','');

					addiPrice*= additionalPrices[aid][jQuery(this).val()];
				});
				var finalDPrice = originalDPrice*addiPrice;
				var finalBPrice = originalBPrice*addiPrice;
				jQuery('#thePriceSpan .price').html(finalBPrice);
				jQuery('#thediscountSpan .price').html(finalDPrice);
			}
		</script>
		<?
	}
}

function SetPageEffectGallery($GAL_OPT,$pics,$picDesc = '') {
	global $gallery_dir;
	global $SITE,$ProductData;
	global $SITE_LANG,$SHOP_TRANS,$PAGE_ID;
	$GAL = array();
	$gal_theme="galleria.pagedots.js";
	$css_align="";
	if ($GAL_OPT[GalleryEffect]==0) $gal_effect="slide";
	if ($GAL_OPT[GalleryEffect]==1) $gal_effect="fade";
	if ($GAL_OPT[GalleryEffect]==2) $gal_effect="flash";
	if ($GAL_OPT[GalleryEffect]==3) {$gal_effect="fadeslide";$css_align='align="center"';}
	if ($GAL_OPT[GalleryEffect]==4) $gal_effect="sliceUp";
	if ($GAL_OPT[GalleryEffect]==5) $gal_effect="sliceDown";
	if ($GAL_OPT[GalleryEffect]==6) $gal_effect="sliceUpDown";
	if ($GAL_OPT[GalleryEffect]==7) $gal_effect="fade";
	if ($GAL_OPT[GalleryEffect]==8) $gal_effect="fold";
	if ($GAL_OPT[GalleryEffect]==9) $gal_effect="random";
	
	if ($GAL_OPT[GalleryTheme]==0) {
		$gal_theme="galleria.pagedots.js";
		$gal_css="galleria.pagedots.css";
	}
	if ($GAL_OPT[GalleryTheme]==1) {
		$gal_theme="galleria.pageclassic.js";
		$gal_css="galleria.pageclassic.css";
		
	}
	$PhotoDivWidth= ($PAGE_ID['shopOptions']['GalleryWidth'] > 0 && $ProductData['galleryAside'] == 1) ? $PAGE_ID['shopOptions']['GalleryWidth'] : ((isset($GAL_OPT[GalleryWidth]) && $GAL_OPT[GalleryWidth] > 0) ? $GAL_OPT[GalleryWidth] : 400);
	if ($ProductData['galleryAside']==1 AND !$GAL_OPT['GalleryWidth']) $PhotoDivWidth=$PhotoDivWidth+26;
	if ($ProductData['galleryAside']==1) $PhotoDivWidth=$PhotoDivWidth+26;
	$sideTextWidth=($galleryWidth-$PhotoDivWidth);
	//$PhotoDivWidth=($SITE[productgallerywidth] > 0) ? $SITE[productgallerywidth] : $PhotoDivWidth;
	
	//$PhotoDivWidth="";
	
	if ($GAL_OPT[AutoPlay]==1) $gal_autoplay="false";
	else $gal_autoplay=(intval($SITE[shopGalleryDuration]) > 0) ? intval($SITE[shopGalleryDuration])*1000 : "true";
	$gal_slide_speed= "400";
	$gal_height=($PAGE_ID['shopOptions']['GalleryHeight'] > 0) ? $PAGE_ID['shopOptions']['GalleryHeight'] : 350;
	$gal_height+=16;
	//$gal_height=$gal_height+100;
	$textTopMargin=7;
	$Text_border_margin=15;
	$SideTextHeight=$gal_height;
	if ($GAL_OPT[GalleryTheme]==1) {
		$textTopMargin=10;
		$SideTextHeight=$SideTextHeight+4;
		$Text_border_margin=10;
	}

	?>
	 <style> 
	 	#onto_gallery {
	 		 margin:<?=($SITE['opalign'] == 'right') ? '7px 10px 15px 0px' : '7px 0px 15px 10px'; ?>;
	 	}
	 	
	 	#onto_gallery .roundBox{
	 		width:auto;
	 	}
	            #galleriapage{
		  
		   direction:ltr;
	                z-index:0;
	                }
	            
        </style> 
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/gallery/slider/<?=$gal_css;?>">
	<style>
    .galleria-stage {background-color:#<?=$SITE[shopProductPageImagesBg];?>;
	padding:8px 5px 8px 5px;
	top:0;
	bottom:0;
	left:0;
	right:0;
	<? /* if(@$PAGE_ID['shopOptions']['roundedCorners'] != 1) { */
		$bcolor = ($SITE[productPicsBlockBorder] != '' ) ? $SITE[productPicsBlockBorder] : $SITE[effectgallerybordercolor];
	 ?>border:1px solid #<?=$bcolor;?>;<?
	 
	 // } ?>

	 <? if ($SITE[roundcorners]==1 && $PAGE_ID['shopOptions']['roundedCorners'] == 1) { ?>border-radius:5px;<? } ?>
          	}
          	.galleria-thumbnails .galleria-image {
	                border:2px solid #<?=$SITE[thumbsbordercolor];?>;
          	}
          	.galleria-thumbnails {
          		min-height:65px;
          		max-height: 67px;
          	}
          	.galleria-thumb-nav-left {
          		
          	}
              .galleria-thumb-nav-left {
          		height:64px;width:16px;
          		left:5px;
          		top:8px;
          		background-color:#<?=$SITE[contenttextcolor];?>;
          		background-repeat:no-repeat;
          	}	
          	.galleria-thumb-nav-right {
          		height:64px;width:16px;
          		right:6px;
          		top:8px;
          		background-color:#<?=$SITE[contenttextcolor];?>;
          		background-repeat:no-repeat;
          		display: none;
          	}
		.galleria-info {display:none;}
          	.galleria-info-title {color:#<?=$SITE[shopProductPageImagesBg];?>;}
          	.galleria-info-text {background-color:#<?=$SITE[shopProductPageImagesBg];?>;direction:<?=$SITE_LANG[direction];?>}
          	.galleria-thumbnails .galleria-image img {
          		
          	}
          	<?
        	if ($GAL_OPT[GalleryTheme]==0) {// DOTS GALLERY
        		?>
        		.galleria-stage {padding:7px;}
        		.galleria-thumbnails .galleria-image {border:0px;}
        		 .galleria-thumb-nav-left {display:none;}
        		 .galleria-info-title {color:#<?=$SITE[contenttextcolor];?>;}
        		 .galleria-info-text {background-color:transparent}
        		<?
        	}
        	else {
        		?>
        		 .galleria-info {width:<?=($PhotoDivWidth-17);?>px;}
        		.galleria-thumbnails-container{background-color:#<?=$SITE[shopProductPageImagesBg];?>;padding-top:8px;padding-bottom:4px;border:1px solid #<?=$SITE[effectgallerybordercolor];?>;bottom:-8px;left:0;right:0;<? if ($SITE[roundcorners]==1 && $PAGE_ID['shopOptions']['roundedCorners'] == 1) { ?>border-radius:5px;<? } ?>}
        		<?
        	} ?>
        	.galleria-info {background-color:#<?=$SITE[shopProductPageImagesBg];?>;}
        	.galleria-theme-classic {background:transparent !important}
        	<? if (count($pics)<8) {
        		?>.galleria-thumbnails .galleria-image {margin-left:7px;}
        		<?
        	}
        	$sideTextMargin=0;
        	if ($SITE[gallerysidetextbg]) {
        		$sideTextMargin=10;
        	}
        	?>
        	.galleria-container {margin:0px 0px 0px 0px;overflow:visible;}
        	#SideGalVR {
		border-<?=$SITE[opalign];?>:1px solid #<?=$SITE[gallerylinecolor];?>;
		padding-<?=$SITE[opalign];?>:15px;
	}
	<? if($GAL_OPT['GalleryTheme'] == 1){ ?>
	.galleria-stage {
		bottom:80px;
	}
	
	.galleria-container {
		background-color:#<?=$SITE[shopProductPageImagesBg];?>;
	}
	<? } ?>
        	</style>
	<script src="<?=$SITE[cdn_url];?>/js/gallery/slider/galleria/galleria-1.4.2.min.js"></script>

	<?
		$padding_top_text=5;	
	?>
	<div style="text-align:left;<?='width:'.($PhotoDivWidth).'px;margin:0 auto;';?>">
	<div id="onto_gallery">
	<? if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1 && count($pics) > 0 && $SITE[shopProductPageImagesBg] != '') SetRoundedCorners(1,1,$SITE[shopProductPageImagesBg]); ?>
	<div id="galleriapage" <?=$css_align;?> class="swiper-container swiper-content">
	<?
	for ($a=0;$a<count($pics);$a++){ 
		$GalPagePic=$pics[$a];
		$GalPicText=$picDesc;
		?><a href="<?=SITE_MEDIA."/".$gallery_dir."/products/".$GalPagePic;?>">
		<?
		print '<img src="'.SITE_MEDIA.'/'.$gallery_dir.'/products/'.$GalPagePic.'" border="0" title="'.$GalPicText.'" /></a>';
	}
	?>
	
	</div>
	<? if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1 && count($pics) > 0 && $SITE[shopProductPageImagesBg] != '') SetRoundedCorners(0,1,$SITE[shopProductPageImagesBg]); ?>
	</div>
	</div>
	<script language="javascript"> 
	<?
	
	$increment=10;
	if ($PhotoDivWidth > 0) {
		$increment=35; 
		?>
		
		gal_editor_width=<?=($PhotoDivWidth-$increment);?>;
		var org_editor_width=gal_editor_width;
		var sideTextWidth=<?=$sideTextWidth;?>;
		<?
	}
	?>

		Galleria.loadTheme('<?=$SITE['cdn_url'];?>/js/gallery/slider/galleria/themes/classic/galleria.classic.min.js?t=677');
	 	Galleria.run('#galleriapage',{
				transition: '<?=$gal_effect;?>',
				autoplay:<?=$gal_autoplay;?>,
				imageCrop:'true',
				_hideDock: false,
				image_margin:0,
				height:<?=$gal_height;?>,
				transitionSpeed:<?=$gal_slide_speed;?>,
				show_counter: false,
				lightbox: true,
				thumbnails:<?=$GAL_OPT[GalleryTheme]==1 ? 'true' : 'false';?>,
				extend: function(options) {PageGallerySlider = this;}
			});
	    	jQuery('.galleria-thumb-nav-right').html("0");
	  	   </script> 
	   <?
}
$fullWidth=$dynamicWidth-270;

?>

<style type="text/css">

<? 

$buttonsWidth = 30;
if($SITE[shopButtonImage] != '') { $butClass	= 'addToCart';$size = getimagesize('http:'.SITE_MEDIA.'/gallery/sitepics/'.$SITE[shopButtonImage]);$buttonsWidth+=$size[0]; ?>.addToCart {cursor:hand;cursor:pointer;background:url('<?=SITE_MEDIA;?>/<?=$gallery_dir;?>/sitepics/<?=$SITE[shopButtonImage];?>') no-repeat;width:<?=$size[0];?>px;height:<?=$size[1];?>px;color:transparent;font-size:0px;text-decoration:none;border:0;float:<?=$SITE[align];?>;}<? } else $butClass = 'shopButton'; ?>
<? if($SITE[shopProdButtonOrderImage] != '') {$obutClass	= 'addToCartOrder';$size = getimagesize('http:'.SITE_MEDIA.'/gallery/sitepics/'.$SITE[shopProdButtonOrderImage]);$buttonsWidth+=$size[0]; ?>.addToCartOrder {cursor:hand;cursor:pointer;background:url('<?=SITE_MEDIA;?>/<?=$gallery_dir;?>/sitepics/<?=$SITE[shopProdButtonOrderImage];?>') no-repeat;width:<?=$size[0];?>px;height:<?=$size[1];?>px;color:transparent;font-size:0px;text-decoration:none;border:0;float:<?=$SITE[opalign];?>;}<? } else $obutClass = 'shopButton'; 

$ProductData = GetTheProduct($CHECK_PAGE['ProductID']);
$more_pics = unserialize($ProductData['more_pics']);
if(!$more_pics)
	$more_pics = array();
if($ProductData['ProductPhotoName'] != '' && (isset($_SESSION['LOGGED_ADMIN']) || $ProductData['mainPicNotShown'] == 0))
	array_unshift($more_pics,$ProductData['ProductPhotoName']);
	//$more_pics[] = $ProductData['ProductPhotoName'];
		
$PAGE_ID = GetIDFromUrlKey($ProductData['ParentID'],true);

$thumbWidth = ($PAGE_ID['shopOptions']['ContentPagePhotoWidth'] > 0) ? $PAGE_ID['shopOptions']['ContentPagePhotoWidth'] : (($PAGE_ID['shopOptions']['ContentPhotoWidth'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoWidth'] : $SITE[productPicWidth]);
$thumbHeight = ($PAGE_ID['shopOptions']['ContentPagePhotoHeight'] > 0) ? $PAGE_ID['shopOptions']['ContentPagePhotoHeight'] : (($PAGE_ID['shopOptions']['ContentPhotoHeight'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoHeight'] : $SITE[productPicHeight]);

if($thumbWidth < $buttonsWidth)
	$thumbWidth = $buttonsWidth;

/* if($thumbWidth > 290)
	$thumbWidth = 290;
	
if($thumbWidth < 220)
	$thumbWidth = 220; */


$lpartWidth = $thumbWidth + 30;
$rpartWidth = $fullWidth-$lpartWidth-15;

$img_url=($ProductData['ProductPhotoName'] != '') ? SITE_MEDIA.'/'.$gallery_dir.'/products/'.$ProductData['ProductPhotoName'] : '';
$full_img_url=($ProductData['ProductPhotoName'] != '') ? SITE_MEDIA.'/'.$gallery_dir.'/products/'.$ProductData['ProductPhotoName'] : '';
?>

<? if(count($more_pics) < 2){ ?>
.galleria-image-nav {
	display:none;
}
<? } ?>

.ProductAttributeSelect {
	background-color: #<?=($SITE[shopAttrBgColor] != '') ? $SITE[shopAttrBgColor] : $SITE[shopSelectBg];?>;
	color:#<?=$SITE[shopSelectTextColor];?>;
	border:1px solid #<?=$SITE[shopSelectTextColor];?>;
	padding:3px;
	min-height: 14px;
}
 .ProductSelectQuantity {width:22px;}
.oneProduct {
	padding:5px;
	width:<?=$fullWidth;?>px;
	box-sizing:border-box;
}

#tratata .roundBox{
	height:12px;
}

.oneProduct .roundBox{
	width:100%;
}

.oneProduct .left_part {
	float:<?=$SITE[align];?>;
	width:<?=$lpartWidth;?>px;
}

.oneProduct .right_part {
	float:<?=$SITE[opalign];?>;
	width:<?=$rpartWidth;?>px;
}

.editable_textarea form textarea {
	width:40%;
	height:200px;
}

#more_pics {
	width:<?=($thumbWidth+20);?>px;
	padding:10px 0 1px 0;
	background:#<?=$SITE[shopProductPageImagesBg];?>;
}

#more_pics .pic {
	width:<?=($thumbWidth-2);?>px;
	border:1px solid #<?=$SITE[shopPicsBorderColor];?>;
	padding:10px;
	margin: 0 auto 10px auto;
	text-align: center;
	<? if($SITE[roundcorners] == 1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1){ ?>border-radius:5px;<? } ?>
}

#more_pics .pic .inpic a img {
	max-width:<?=($thumbWidth-2);?>px;
	max-height:<?=($thumbHeight-2);?>px;
}

#mainProductPic {
	position:relative;
	width:<?=$thumbWidth;?>px;
}

#mainProductPic a.photo_gallery img {
	width:<?=$thumbWidth;?>px;
}

.inpic {
	position:relative;
}

.adminDel {
	position:absolute;
	bottom:-8px;
	<?=$SITE[align];?>:10px;
}

.adminEdit {
	position:absolute;
	bottom:-8px;
	<?=$SITE[opalign];?>:10px;
}

#ProductPrice {
	padding-<?=$SITE[opalign];?>:5px;
	padding-<?=$SITE[align];?>:0;
}

#ProductPrice span {
	color:#<?=$SITE[shopProductPriceColor];?>;
	font-size: <?=$SITE[shopProductPriceSize];?>px;
	font-weight: <?=($SITE[shopProductPriceBold] == 1) ? 'bold' : 'normal';?>;
}
.attr_one_val {font-size: <?=$SITE[shopProductPriceSize];?>px;}
#ProductQ span {
	color:#<?=$SITE[shopProductPriceColor];?>;
}

#discountPrice span {
	color:#<?=$SITE[shopProductPriceColor];?>;
}

#discountPrice #thediscountSpan span {
	color:#<?=$SITE[shopProductsPageDiscountPriceColor];?>;
}

#tratata .round_bottom {
	height:1px;
}

<? if(false&& $SITE[shopPicsBorderColor] != '' && $SITE[shopProductPageImagesBg] == '' && $ProductData['galleryEffect'] != 0){ ?>
	#ProductDescription {padding-top:6px;}
<? } ?>

span.attrTitle {
	color:#<?=$SITE[shopProductPriceColor];?>;
}
<? if(isset($_SESSION['LOGGED_ADMIN'])) { ?>
#ProductPrice form {display:inline;margin:0;padding:0;}
.editable:hover{background:#FFF1A8;}
#fsUploadProgress_morepics, #fsUploadProgress_morepicsmass {
	margin-<?=$SITE[opalign];?>:20px;
	width:auto;
}

#fsUploadProgress_morepics .progressWrapper, #fsUploadProgress_morepicsmass .progressWrapper {
	width:auto;
}

#fsUploadProgress_morepics .progressWrapper .progressContainer, #fsUploadProgress_morepicsmass .progressWrapper .progressContainer {
	width:auto;
}

#fsUploadProgress_morepics .progressWrapper .progressContainer .progressName, #fsUploadProgress_morepicsmass .progressWrapper .progressContainer .progressName {
	overflow:hidden;
}

#fsUploadProgress_morepics .progressWrapper .progressContainer .progressBarStatus, #fsUploadProgress_morepicsmass .progressWrapper .progressContainer .progressBarStatus {
	width:auto;
}


<? } ?>
#ProductTitle {margin-bottom:10px;}

</style>

<div class="oneProduct" itemscope itemtype="http://schema.org/Product">
	<div class="titleContent">
		<h1 class="editable_title" id="ProductTitle" itemprop="name"><?=$ProductData['ProductTitle'];?></h1>
	</div>
	<? if($ProductData['galleryEffect'] == 1) { ?>
		<div style="width:100%;overflow:hidden;margin-<?=$SITE[opalign];?>:-10px;padding-bottom:10px;">
		<?
		$galW = $fullWidth;
		if($ProductData['galleryAside'] == 1)
		{
			//$galW = () ? 400 : $SITE[productgallerywidth];
			$galW= ($PAGE_ID['shopOptions']['GalleryWidth'] > 0 && $ProductData['galleryAside'] == 1) ? $PAGE_ID['shopOptions']['GalleryWidth'] : ((intval($SITE[productgallerywidth]) <= 0) ? 400 : intval($SITE[productgallerywidth]));
			
			$galW+=25;
			
			$descW = $fullWidth-$galW-15;
			?>
			<div style="float:<?=$SITE[opalign];?>;width:<?=$descW;?>px;padding:5px;box-sizing:border-box">
				<? if($ProductData['specialAttrsTable'] == '1') {
					AttrsTable();
				} ?>
				<div class="mainContentText editable_textarea" id="ProductDescription" itemprop="description">
					<?=$ProductData['ProductDescription'];?>
					
				</div>
				<? if (isset($_SESSION['LOGGED_ADMIN'])) { ?><br/><br/><div onclick="EditDescription();" id="newSaveIcon"><img src="<?=$SITE['url'];?>/Admin/images/editIcon.png" border="0" align="absmiddle"><?=$SHOP_TRANS['edit_content'];?></div>
				<? if($default = GetDefaultProduct()) {
						if($default['ProductID'] != $ProductData['ProductID'] && $default['ProductDescription'] == $ProductData['ProductDescription'])
						{
							$page_url=$SITE['media'].'/'.'shop_product/'.$default['catUrlKey'].'/'.$default['UrlKey'];
							?><a href="<?=$page_url;?>" style="color:#<?=$SITE[linkscolor];?>"><?=$SHOP_TRANS['toDefaultProduct'];?></a><?
						}
					}
				} ?>
			</div>
			<div style="float:<?=$SITE[opalign];?>;width:<?=$galW;?>px;">
			<?
		}
		$GAL_OPT = array('GalleryEffect' => $ProductData['effectID'],'GalleryTheme' => $ProductData['galleryTheme'],'GalleryWidth' => $galW);
		
		
		
		SetPageEffectGallery($GAL_OPT,$more_pics,''); ?>
		<? if($ProductData['galleryAside'] == 1 && (isset($_SESSION['LOGGED_ADMIN']) || $ProductData['specialAttrsTable'] != '1')) {
		?>
		<div style="margin-<?=$SITE[opalign];?>:10px;">
		<? if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1) SetRoundedCorners(1,1,$SITE[shopAttrsBgColor]); ?>
		<?
		AttrsAndButs(); ?>
		
		</div>
		<? if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1) SetRoundedCorners(0,1,$SITE[shopAttrsBgColor]); ?>
		</div>
	<? } ?>
	</div>
	<? } ?>
	<?
	$more_pics = unserialize($ProductData['more_pics']);
	$left_exists = false;

	if(
		isset($_SESSION['LOGGED_ADMIN']) ||
		$ProductData['specialAttrsTable'] != '1' ||
		(
			(
				count($more_pics) > 0 ||
				($img_url != '' && (isset($_SESSION['LOGGED_ADMIN']) || $ProductData['mainPicNotShown'] == 0))
			) &&
			(
				isset($_SESSION['LOGGED_ADMIN']) ||
				$ProductData['galleryEffect'] == 0 ||
				($ProductData['galleryEffect'] == 1 && $ProductData['galleryAside'] == 0 && isset($_SESSION['LOGGED_ADMIN']))
			)
		)
	)
		$left_exists = true;
	//var_dump((isset($_SESSION['LOGGED_ADMIN']) || $ProductData['specialAttrsTable'] != '1'));
	?>
	<? if($ProductData['galleryEffect'] == 0 || ($ProductData['galleryEffect'] == 1 && $ProductData['galleryAside'] == 0)) { ?>
	<div class="right_part"<?=(!$left_exists) ? ' style="width:100%;"' : '';?>>
		<? if($ProductData['specialAttrsTable'] == '1') {
			AttrsTable();
		} ?>
		<div class="mainContentText editable_textarea" id="ProductDescription" itemprop="description">
			<?=$ProductData['ProductDescription'];?>
		</div>
		<? if (isset($_SESSION['LOGGED_ADMIN'])) { ?>
		<br/><br/><div onclick="EditDescription();" id="newSaveIcon"><img src="<?=$SITE['url'];?>/Admin/images/editIcon.png" border="0" align="absmiddle"><?=$SHOP_TRANS['edit_content'];?></div>
			<? if($default = GetDefaultProduct()) {
				if($default['ProductID'] != $ProductData['ProductID'] && $default['ProductDescription'] == $ProductData['ProductDescription'])
				{
					$page_url=$SITE['media'].'/'.'shop_product/'.$default['catUrlKey'].'/'.$default['UrlKey'];
					?><a href="<?=$page_url;?>" style="color:#<?=$SITE[linkscolor];?>"><?=$SHOP_TRANS['toDefaultProduct'];?></a><?
				}
			}
		} ?>
		
	</div>
	<? }
	if($left_exists){
	?>
	<div class="left_part">
		<? 
		if(($ProductData['galleryEffect'] == 0 || isset($_SESSION['LOGGED_ADMIN'])) && ($img_url != '' || (is_array($more_pics) && count($more_pics) > 0))) { ?>
		<? if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1 && $ProductData['galleryEffect'] == 0 && $SITE[shopProductPageImagesBg] != '') {?><div style="margin-<?=$SITE[opalign];?>:10px;"><? SetRoundedCorners(1,1,$SITE[shopProductPageImagesBg]); ?></div><? } ?>
		<div id="more_pics"<? if($ProductData['galleryEffect'] != 0) { ?> style="margin-top:10px;display:none;"<? } elseif($SITE[productPicsBlockBorder] != '' && $SITE[roundcorners]!=1){ ?> style="border-top:1px solid #<?=$SITE[productPicsBlockBorder];?>;border-left:1px solid #<?=$SITE[productPicsBlockBorder];?>;border-right:1px solid #<?=$SITE[productPicsBlockBorder];?>;"<? } ?>>
			<?
			$was_main_pic = false;
			if($img_url != '' && (isset($_SESSION['LOGGED_ADMIN']) || $ProductData['mainPicNotShown'] == 0)) { 
				$was_main_pic = true;
			?>
			<div class="pic" id="<?=base64_encode($ProductData['ProductPhotoName']);?>">
				<div class="inpic">
					<a <? if($ProductData['noBigPics'] != 1){ ?>href="<?=$full_img_url;?>" class="photo_gallery"<? } ?>><img src="<?=$img_url;?>" alt="<?=$ProductData['ProductTitle'];?>" itemprop="image" border="0" /></a>
					<? if (isset($_SESSION['LOGGED_ADMIN'])) { ?>
					<div class="adminEdit"><a href="#" onclick="AddPics(this,'<?=$ProductData['ProductPhotoName'];?>');return false;"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" /></a></div>
					<div class="adminDel"><a href="#" onclick="delMainPic('<?=$ProductData['ProductPhotoName'];?>',<?=$CHECK_PAGE['ProductID'];?>);return false;"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" border="0" /></a></div>
					<? } ?>
				</div>
			</div>
			<? } ?>
			<? 
			if(is_array($more_pics) && count($more_pics) > 0)
				foreach($more_pics as $pic) {
					$was_main_pic = true;
					$img_url=SITE_MEDIA.'/'.$gallery_dir.'/products/'.$pic;
					$full_img_url=SITE_MEDIA.'/'.$gallery_dir.'/products/'.$pic;
					?>
					<div class="pic" id="<?=base64_encode($pic);?>">
						<div class="inpic">
							<a <? if($ProductData['noBigPics'] != 1){ ?>href="<?=$full_img_url;?>" class="photo_gallery"<? } ?>><img src="<?=$img_url;?>" data-zoom-image="<?=$full_img_url;?>" alt="<?=$ProductData['ProductTitle'];?>"  border="0"<?=($was_main_pic) ? '' : ' itemprop="image"';?> /></a>
							<? if (isset($_SESSION['LOGGED_ADMIN'])) { ?>
							<div class="adminEdit"><a href="#" onclick="AddPics(this,'<?=$pic;?>');return false;"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" /></a></div>
							<div class="adminDel"><a href="#" onclick="delMorePic('<?=$pic;?>',<?=$CHECK_PAGE['ProductID'];?>);return false;"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" border="0" /></a></div>
							<? } ?>
						</div>
					</div>
					<?
				} ?>
			<div style="clear:both;"></div>
		</div>

		<? }
		elseif($ProductData['galleryAside'] != 1)
			if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1){ ?><div style="margin-<?=$SITE[opalign];?>:10px;"><? SetRoundedCorners(1,1,$SITE[shopAttrsBgColor]); ?></div><? }
		if($ProductData['galleryEffect'] == 0 || ($ProductData['galleryEffect'] == 1 && $ProductData['galleryAside'] == 0))
		{
			?>
			<div style="margin-<?=$SITE[opalign];?>:10px;<? if($SITE[productPicsBlockBorder] != '' && $SITE[roundcorners]!=1 && $ProductData['galleryEffect'] == 0){ ?>width:<?=($thumbWidth+20);?>px;border-bottom:1px solid #<?=$SITE[productPicsBlockBorder];?>;border-left:1px solid #<?=$SITE[productPicsBlockBorder];?>;border-right:1px solid #<?=$SITE[productPicsBlockBorder];?>;<? if($img_url == '' && (!is_array($more_pics) || count($more_pics) == 0)) { ?>border-top:1px solid #<?=$SITE[productPicsBlockBorder];?>;<? } } ?>">
			<? if (isset($_SESSION['LOGGED_ADMIN']) || $ProductData['specialAttrsTable'] != '1') { 
			AttrsAndButs(); ?>
			</div>
			<? } ?>
			<div id="tratata">
			<? if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1) SetRoundedCorners(0,1,$SITE[shopAttrsBgColor]); ?>
			</div>
		<? } ?>
		
		</div>
		<? if($ProductData['picsZoom'] == 1){ 
		?>
		<style type="text/css">
		.magnifyarea{ /* CSS to add shadow to magnified image. Optional */
			background: white;
			
		}
		</style>

		<!--<script type="text/javascript" src="/js/featuredimagezoomer.js"></script>-->
		<script type="text/javascript" src="/js/jquery.elevateZoom-3.0.8.min.js"></script>
		<script type="text/javascript">
			jQuery(window).load(function(){
				jQuery('.pic > .inpic > .photo_gallery > img').each(function(){
					var _this = this;
					jQuery(this).elevateZoom({
						zoomType:'lens',
						 easing:true,
						 lenszoom:true,
						 lensFadeIn:500,
						 lensFadeOut:100,
						lensSize:100,
						constrainSize:100,
						borderSize:1,
						containLensZoom:true,
						borderColour:'#<?=$SITE['shopPicsBorderColor'];?>'
						});
					//jQuery(this).addimagezoom({
					//	'largeimage':jQuery(this).parent().attr('href'),
					//	'magnifierpos' : '<?=$SITE['opalign'];?>',
					//	'magnifiersize':[jQuery(_this).parent().parent().parent().outerWidth()/1.2,jQuery(_this).parent().parent().parent().outerHeight()],
					//	'cursorshade': true,
					//	'topoffset': Math.round((jQuery(_this).parent().parent().parent().outerHeight() - jQuery(_this).height())/2),
					//	'leftoffset': Math.round((jQuery(_this).parent().parent().parent().outerWidth() - jQuery(_this).width())/2+8),
					//	'borderRadius':<?=($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1) ? '5' : '0';?>
					//});
				});
			});
		</script>
		<?
		}
		
		?>
	</div>
	<? } ?>
	<div style="clear:both;"></div>
</div>

<?
	if ($ProductData['galleryAside']!=1 AND $ProductData['galleryEffect']==0 AND $ProductData['picsZoom']==1 AND !$ProductData['specialAttrsTable']==1) {
		?>
		<script>
			function marginizeBottom() {
				jQuery(".right_part").css("margin-top",jQuery("#more_pics").height()+15+"px");
			}
			jQuery(document).ready(function() {
				window.setTimeout("marginizeBottom()",200);
			});
		</script>
		<?
	}


if($SITE['shopRelatedPosition'] == 'bottom')
	require_once('shopRelated.php');
if (isset($_SESSION['LOGGED_ADMIN'])) {
	$effects = array('slide','fade','flash','fadeslide','sliceUp','sliceDown','sliceUpDown','fade','fold','random');
	?>
	<div dir="<?=$SITE_LANG[direction];?>" id="DescriptionEditor" style="display:none;z-index:1000;" class="editorWrapper">
		<span><?=$ADMIN_TRANS['product description'];?></span> : <br />
		<textarea id="ProductDesc" name="ProductDesc"><?=$ProductData['ProductDescription'];?></textarea>
		<div style="clear:both;"><br></div>
		
		<div id="newSaveIcon" class="greenSave" onclick="SaveDescription();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" />&nbsp;<?=$ADMIN_TRANS['save changes'];?></div>
		&nbsp; &nbsp;
		<div class="newSaveIcon" onclick="EditDescription();"><?=$ADMIN_TRANS['cancel'];?></div>
		<div style="clear:both;"></div>
	</div>
	
	<div dir="<?=$SITE_LANG[direction];?>" id="PicsEditor" style="display:none;z-index:1000;position:absolute;top:100px;width:550px;" class="CenterBoxWrapper">
		<div id="make_dragable" align="<?=$SITE[opalign];?>"><div class="icon_close" onclick="AddPics()">+</div>
			<div class="title"><?=$ADMIN_TRANS['upload/edit photo'];?></div>
		</div>
		<div class="CenterBoxContent">
		<div style="float:<?=$SITE[align];?>"><span id="spanButtonPlaceHolder_morepics" style="cursor:pointer;float:<?=$SITE[align];?>"></span></div>
		
		<div style="clear:both;"></div>
		<div class="fieldset flash" id="fsUploadProgress_morepics"></div>
		<div style="clear:both;border-bottom:1px solid #000;padding-top:20px;margin-bottom:20px;"></div>
		<div style="float:<?=$SITE[align];?>">
			<div id="newSaveIcon" class="greenSave" onclick="beforeSavePics();"><i class="fa fa-cloud-upload"></i><?=$ADMIN_TRANS['upload and save'];?></div>
			&nbsp; &nbsp;
			<div class="newSaveIcon" onclick="AddPics();"><?=$ADMIN_TRANS['cancel'];?></div>
		</div>
		<div style="clear:both;"></div>
		</div>
	</div>
	
	<div dir="<?=$SITE_LANG[direction];?>" id="ProductAttributes" style="display:none;z-index:1000;padding:10px;position:absolute;top:100px;<?=$SITE[align];?>:295px;background-color:#E0ECFF;border:2px solid #C3D9FF;width:600px;">
		<h1 style="font-size:16px;"><?=$SHOP_TRANS['product_attrs'];?></h1>
		<!-- <a href="#" style="color:#000000;text-decoration:underline;" onclick="jQuery('#ProductAttrs').hide();jQuery('#ProductsPars').show();return false;"><?=$SHOP_TRANS['product_settings'];?></a>&nbsp;|&nbsp;<a href="#" style="color:#000000;text-decoration:underline;" onclick="jQuery('#ProductAttrs').show();jQuery('#ProductsPars').hide();return false;"><?=$SHOP_TRANS['product_attrs'];?></a>
		<div style="height:20px;"></div> -->
		<!-- <div id="ProductAttrs"> -->
			<?
			$attributes = GetCategoryAttributes($CHECK_PAGE['parentID'],true);
			if(count($attributes) > 0)
				foreach($attributes as $id => $data) { ?>
					<h2 style="font-size:14px;"><?=$data['name'];?></h2>
					<? foreach($data['values'] as $vid => $value) { ?>
					<input type="checkbox" value="1" name="value_<?=$id;?>:<?=$vid;?>" class="ProductValues AdminCheckbox"<?=(@array_key_exists($vid,@$ProductData['attributes'][$id]['values'])) ? ' CHECKED' : '';?> />&nbsp;<?=$value;?>&nbsp;&nbsp;&nbsp;
					<? } ?>
				<? } ?>
		<!-- </div>
		<div id="ProductsPars" style="display:none;"> -->
		<hr />
			<div style="float:<?=$SITE[align];?>;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="ViewStatus" id="ViewStatus" value="1" <?=($ProductData['ViewStatus'] == 1) ? 'CHECKED' : '';?> />&nbsp;<?=$ADMIN_TRANS['show this product'];?>&nbsp;&nbsp;&nbsp;
			</div>
			<div style="float:<?=$SITE[align];?>;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="featured" id="featured" value="1" <?=($ProductData['featured'] == 1) ? 'CHECKED' : '';?> />&nbsp;<?=$SHOP_TRANS['featured_product'];?>&nbsp;&nbsp;&nbsp;
			</div>
			
			<div style="float:<?=$SITE[align];?>;<?=($ProductData['galleryEffect'] == 0) ? '' : 'display:;';?>" id="picsZoomBox">
				<br/>
				<input type="checkbox" name="picsZoom" class="AdminCheckbox" id="picsZoom" value="1" <?=($ProductData['picsZoom'] == 1) ? 'CHECKED' : '';?> />&nbsp;<?=$SHOP_TRANS['picsZoom'];?>&nbsp;&nbsp;&nbsp;<br/><br/>
			</div>
			<div style="float:<?=$SITE[align];?>;">
				<br/>
				<input align="absmiddle" type="checkbox" name="noBigPics" class="AdminCheckbox" id="noBigPics" value="1" <?=($ProductData['noBigPics'] == 1) ? 'CHECKED' : '';?> />&nbsp;<?=$SHOP_TRANS['AnoBigPics'];?><br/><br/>
			</div>
			<div style="margin-<?=$SITE[align];?>:20px;float:<?=$SITE[align];?>;">
				<br/>
				<input align="absmiddle" type="checkbox" name="mainPicNotShown" class="AdminCheckbox" id="mainPicNotShown" value="1" <?=($ProductData['mainPicNotShown'] == 1) ? 'CHECKED' : '';?> />&nbsp;<?=$SHOP_TRANS['mainPicNotShown'];?><br/><br/>
			</div>
			<div class="clear"></div>

			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br>
				<input type="checkbox" name="galleryEffect" class="AdminCheckbox" id="galleryEffect" value="1" <?=($ProductData['galleryEffect'] == 1) ? 'CHECKED' : '';?> />&nbsp;<?=$SHOP_TRANS['effects_gallery'];?>&nbsp;&nbsp;
			</div>
			<div style="float:<?=$SITE[align];?>;<?=($ProductData['galleryEffect'] == 1) ? '' : 'display:;';?>" id="effectIDSelect">
				<span><?=$SHOP_TRANS['effect'];?></span> : <br />
				<select name="effectID" id="effectID" style="width:120px">
					<? foreach($effects as $effectID => $effectName) { ?><option value="<?=$effectID;?>" <?=($ProductData['effectID'] == $effectID) ? 'SELECTED' : '';?>><?=$effectName;?></option><? } ?>
				</select>&nbsp;&nbsp;
			</div>
			
			<div style="float:<?=$SITE[align];?>;<?=($ProductData['galleryEffect'] == 1) ? '' : 'display:;';?>" id="galleryThemeSelect">
				<span><?=$SHOP_TRANS['gallery_type'];?></span> : <br />
				<select name="galleryTheme" id="galleryTheme" style="width:150px">
					<option value="0"><?=$SHOP_TRANS['without_preview'];?></option>
					<option value="1" <?=($ProductData['galleryTheme'] == 1) ? 'SELECTED' : '';?>><?=$SHOP_TRANS['with_preview'];?></option>
				</select><br /><br />
			</div>
			
			
			<!-- <div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;<?=($ProductData['galleryEffect'] == 1) ? '' : 'display:;';?>" id="galleryAsideSelect">
				<br />
				&nbsp;<input type="checkbox" name="galleryAside" class="AdminCheckbox" id="galleryAside" value="1" <?=($ProductData['galleryAside'] == 1) ? 'CHECKED' : '';?> /><?=$SHOP_TRANS['desc_right_to_gallery'];?>
			</div> -->
			<div style="clear: both"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				
				<span><?=$SHOP_TRANS['text_is_shown_at'];?></span> :
				
				<select name="galleryAside" id="galleryAside" style="width:120px;">
					<option value="1"><?=$SHOP_TRANS['text_to_the_left'];?></option>
					<option value="0"<?=($ProductData['galleryAside'] == 1) ? '' : ' SELECTED';?>><?=$SHOP_TRANS['text_under'];?></option>
				</select>
			</div>
			<div style="float:<?=$SITE[align];?>;">
				<span><?=$SHOP_TRANS['quantity_has'];?></span> :
				<input type="text" style="width:40px" id="quantity" name="quantity" value="<?=$ProductData['quantity'];?>" />
			</div>
			
			<div style="clear:both"></div>
			<div style="width:100%">
				<span><?=$SHOP_TRANS['Aurlkey'];?></span> : <br />
				<input type="text" style="width:100%" id="prod_urlkey" name="prod_urlkey" value="<?=$ProductData['UrlKey'];?>" />
			</div>
			<div style="clear:both"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br/>
				<input align="absmiddle" type="checkbox" name="specialAttrsTable" class="AdminCheckbox" id="specialAttrsTable" value="1" <?=($ProductData['specialAttrsTable'] == '1') ? 'CHECKED' : '';?> />&nbsp;<?=$SHOP_TRANS['specialAttrsTable'];?><br/><br/>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br/>
				<input align="absmiddle" type="checkbox" name="defaultProduct" class="AdminCheckbox" id="defaultProduct" value="1" <?=($ProductData['defaultProduct'] == '1') ? 'CHECKED' : '';?> />&nbsp;<b><?=$SHOP_TRANS['defaultProduct'];?></b><br/>
				<small><?=$SHOP_TRANS['defaultProductDesc'];?></small><br/>
			</div>
			<div style="clear:both"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br/>
				<input align="absmiddle" type="checkbox" name="onSale" class="AdminCheckbox" id="onSale" value="1" <?=($ProductData['onSale'] == '1') ? 'CHECKED' : '';?> />&nbsp;<?=$SHOP_TRANS['onSale'];?><br/><br/>
			</div>
		<!-- </div> -->
		<div style="clear:both;height:20px;"></div>
		<input id="saveContentButton" type="button" class="greenSave" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="saveAttributes();">
		&nbsp; &nbsp;
		<input id="cancelContentButton" type="button"  value="<?=$ADMIN_TRANS['cancel'];?>" onclick="EditAttributes();">
		<div style="clear:both;"></div>
	</div>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/placeholder.js"></script>
	<div dir="<?=$SITE_LANG[direction];?>" id="ProductRelated" style="display:none;z-index:1000;padding:10px;position:fixed;top:100px;margin:0 auto;background-color:#E0ECFF;border:2px solid #C3D9FF;width:720px;max-height:600px;">
		<h1 style="font-size:16px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:120px;margin-top:0;"><?=($SITE[shopRelatedProductsTitle] == '') ? $SHOP_TRANS['choose_related_products'] : $SITE[shopRelatedProductsTitle];?></h1>
		<div style="float:<?=$SITE[align];?>;">
			<input type="search" onkeyup="filterAdminRelated(this.value);" style="width:130px" placeholder="<?=$SHOP_TRANS['search_product'];?>..." />
		</div>
		<div style="clear:both"></div>
		<div class="adminRelatedLine" style="max-height:540px;overflow:auto;">
		<?
		$related = getRelatedProducts($CHECK_PAGE['ProductID']);
		$rids = array();
		foreach($related as $pr)
			$rids[] = $pr['ProductID'];
		$all_products = getAllProducts();
		function cmp($a, $b)
		{
			global $rids;
		    if (in_array($a['ProductID'], $rids) && in_array($b['ProductID'], $rids)) {
		        return 0;
		    }
		    if(in_array($a['ProductID'], $rids))
		    	return -1;
		    return 1;
		    
		}
		usort($all_products, "cmp");
		
		foreach($all_products as $apr)
		{
			$img_url=($apr['ProductPhotoName'] != '') ? SITE_MEDIA.'/'.$gallery_dir.'/products/thumb_'.$apr['ProductPhotoName'] : '';
			$page_url=$SITE['media'].'/shop_product/'.$apr['catUrlKey'].'/'.$apr['UrlKey'];
			if ($apr['ProductUrl']!='')
				$page_url=urldecode($apr['ProductUrl']);
			?>
			<div class="adminRelated" style="float:<?=$SITE[align];?>;margin:10px;border:1px solid #efefef;background:#fff;padding:5px;width:200px;word-wrap:break-word">
				<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
					<div style="width:98px;margin-bottom:5px;<?=($img_url != '') ? 'border:1px solid #efefef' : '';?>">
						<div style="text-align:center;">
							<? if($img_url != ''){ ?>
							<a target="_blank" href="<?=$page_url;?>"><img src="<?=$img_url;?>" style="max-width:98px;max-height:98px;" border="0" /></a>
							<? } ?>
						</div>
					</div>
				</div>
				<div style="float:<?=$SITE[align];?>;width:20px;"><input type="checkbox" class="relatedCh" id="relatedCh<?=$apr['ProductID'];?>" value="<?=$apr['ProductID'];?>" <?=(in_array($apr['ProductID'], $rids)) ? ' CHECKED' : '';?> /></div>
				<div style="float:<?=$SITE[align];?>;width:60px;">
					<label for="relatedCh<?=$apr['ProductID'];?>"><span class="relatedTitle"><?=$apr['ProductTitle'];?></span></label>
				</div>
				<div style="clear:both"></div>
			</div>
			<?
		}
		?>
		<div style="clear:both"></div>
		</div>
		<div style="clear:both;height:20px;"></div>
		<div id="newSaveIcon" class="greenSave" onclick="saveRelated();"><?=$ADMIN_TRANS['save changes'];?></div>
		&nbsp; &nbsp;
		<div id="newSaveIcon" class="cancel" onclick="EditRelated();"><?=$ADMIN_TRANS['cancel'];?></div>
		<div style="clear:both;"></div>
	</div>
	
	<script type="text/javascript">
		var but_width = 0;
		jQuery(function(){
			Placeholder.init({normal:"#cccccc"});
		});
	</script>
	<script type="text/javascript" src="<?=$SITE['cdn_url'];?>/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/jquery.jeditable.mini.js"></script>
	<script type="text/javascript">
		var editor_browsePath="<?=$SITE[url];?>/ckfinder";
		var buttonID= "photo_spanButtonPlaceHolder";
		var allowed_photo_types="*.jpg;*.gif;*.png";
		var uploaded_filename = '';
		var my_uploaded_file = '';
		var upload_global_type = 'shop_product';
		var swfu,swfu_2;
		var editor_ins = false;
		var changed_attrs = false;
		var more_pics = [];
		var more_pics_cnt = 0;
		var in_more_pics = false;
		var delpicAfterUpload = '';
		
		jQuery(function() {
			jQuery("#more_pics").sortable({
		   		update: function(event, ui) {
		   			savePicsOrder(jQuery("#more_pics").sortable('serialize'));
		   		},
		   		scroll:false,
			});
		});
		
		function filterAdminRelated(text){
			jQuery('.adminRelated').each(function(){
				if(jQuery('.relatedTitle',this).html().indexOf(text) == -1)
					jQuery(this).hide();
				else
					jQuery(this).show();
				
			});
			reorderAdminRelated();
		}
		
		function savePicsOrder(data) {
			var pars = 'action=sortPics&ProductID=<?=$CHECK_PAGE['ProductID'];?>&'+data;
		   
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit, onLoading:savingChanges});
		}
		
		function beforeSavePics() {
			savingChanges(); 
			swfu_2.startUpload();
			setTimeout('checkProductMorePicsUploaded()',500);
		}
		
		function checkProductMorePicsUploaded() {
			my_stat = swfu_2.getStats();
			if(my_stat.files_queued > 0)
				setTimeout('checkProductMorePicsUploaded()',500);
			else
				setTimeout('savePics()',500);
		}
		
		function savePics() {
		
			var pars = 'action=addPics&ProductID=<?=$CHECK_PAGE['ProductID'];?>&catID=<?=$ProductData['ParentID'];?>';

			jQuery.each(more_pics, function(index,data) {
		      pars += '&more_pics[]='+data;
		   });
		   
		   if(delpicAfterUpload != '')
		   	pars += '&delPic='+delpicAfterUpload;
		   
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
		}
	    
	    function ShopUploadedPic(flname) {
			more_pics[more_pics_cnt] = flname;
			more_pics_cnt++;
		}
		
		function AddPics(obj,curr_pic) {
			if (document.getElementById("PicsEditor").style.display=="none") {
				ShowLayer("PicsEditor",1,1,0);
				if(!obj)
					obj = jQuery('.pics_add_but');
				new_top = jQuery(obj).offset().top - jQuery('#PicsEditor').height() - 70;
				jQuery('#PicsEditor').css('top',new_top+'px');
				delpicAfterUpload = curr_pic;
				showuploader(allowed_photo_types,10,'spanButtonPlaceHolder_morepics',0,'fsUploadProgress_morepics',2);
			}
			else ShowLayer("PicsEditor",0,1,0);
		}
		
		function EditDescription() {
			if (document.getElementById("DescriptionEditor").style.display=="none") {
				//ShowLayer("DescriptionEditor",1,1,1);
				slideOutEditor("DescriptionEditor",1);
				editor_ins=CKEDITOR.replace('ProductDesc', {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
				});
			}
			else slideOutEditor("DescriptionEditor",0);
		}
		
		function delMorePic(PicName,ProductID) {
			if(confirm('<?=$SHOP_TRANS['you_sure'];?>?')) {
				var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:'action=delMorePic&ProductID='+ProductID+'&picName='+PicName, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
			}
		}
		
		function delMainPic(PicName,ProductID) {
			if(confirm('<?=$SHOP_TRANS['you_sure'];?>?')) {
				var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:'action=delMainPic&ProductID='+ProductID+'&picName='+PicName, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
			}
		}
		
		function EditAttributes() {
			if (document.getElementById("ProductAttributes").style.display=="none")
			{
				new_top = jQuery('.edit_att_but').offset().top - jQuery('#ProductAttributes').height()-30;
				jQuery('#ProductAttributes').css('top',new_top+'px');
				ShowLayer("ProductAttributes",1,1,0);
				jQuery('#ProductAttributes').draggable();
			}
			else
				ShowLayer("ProductAttributes",0,1,0);
		}
		
		function reorderAdminRelated() {
			var max_line = 3;
			var i_now = 0;
			var i_prev = 0;
			var max_height = 0;
			jQuery('.adminRelated:visible').each(function(){
				if(i_now == max_line)
				{
					for(var j = i_prev;j < i_prev+i_now;j++)
					{
						jQuery('.adminRelated:visible').eq(j).height(max_height);
					}
					max_height = 0;
					i_prev += i_now;
					i_now = 0;
				}
				i_now++;
				if(jQuery(this).height() > max_height)
					max_height = jQuery(this).height();
				
			});
			
			for(var j = i_prev;j < i_prev+i_now;j++)
			{
				jQuery('.adminRelated:visible').eq(j).height(max_height);
			}
		}
		
		function EditRelated() {
			if (document.getElementById("ProductRelated").style.display=="none")
			{
				ShowLayer("ProductRelated",1,1,0);
				
				reorderAdminRelated();
			}
			else
				ShowLayer("ProductRelated",0,1,0);
		}

		
		function successEdit() {
			document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$SHOP_TRANS['changes_saved'];?></span>";
		}

		function saveAttributes() {
			var ViewStatus = 0;
			if(jQuery('#ViewStatus:checked').length > 0)
				ViewStatus = 1;
			var featured = 0;
			if(jQuery('#featured:checked').length > 0)
				featured = 1;
			var noBigPics = 0;
			if(jQuery('#noBigPics:checked').length > 0)
				noBigPics = 1;
			var mainPicNotShown = 0;
			if(jQuery('#mainPicNotShown:checked').length > 0)
				mainPicNotShown = 1;
			var defaultProduct = 0;
			if(jQuery('#defaultProduct:checked').length > 0)
				defaultProduct = 1;
			var picsZoom = 0;
			var galleryEffect = 0;
			var effectID = 0;
			var galleryTheme = 0;
			var galleryAside = 0;
			var specialAttrsTable = 0;
			var onSale = 0;
			galleryAside = jQuery('#galleryAside option:selected').val();
			if(jQuery('#galleryEffect:checked').length > 0)
			{
				galleryEffect = 1;
				effectID = jQuery('#effectID option:selected').val();
				galleryTheme = jQuery('#galleryTheme option:selected').val();
				//if(jQuery('#galleryAside:checked').length > 0)
				//	galleryAside = 1;
				
			}
			else if(jQuery('#picsZoom:checked').length > 0)
				picsZoom = 1;
			if(jQuery('#specialAttrsTable:checked').length > 0)
				specialAttrsTable = 1;
			if(jQuery('#onSale:checked').length > 0)
				onSale = 1;
			var pars = 'action=saveAttributes&ProductID=<?=$CHECK_PAGE['ProductID'];?>&noBigPics='+noBigPics+'&mainPicNotShown='+mainPicNotShown+'&urlkey='+jQuery('#prod_urlkey').val()+'&quantity='+jQuery('#quantity').val()+'&ViewStatus='+ViewStatus+'&featured='+featured+'&galleryEffect='+galleryEffect+'&effectID='+effectID+'&galleryTheme='+galleryTheme+'&galleryAside='+galleryAside+'&picsZoom='+picsZoom+'&specialAttrsTable='+specialAttrsTable+'&onSale='+onSale+'&defaultProduct='+defaultProduct;
			jQuery('.ProductValues:checked').each(function(){
				pars+='&values[]='+jQuery(this).attr('name').replace('value_','');
			});
			
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout("document.location.href='<?=$SITE['media'];?>/shop_product/<?=$ProductData['catUrlKey'];?>/"+transport.responseText+"'",900);}, onFailure:failedEdit, onLoading:savingChanges});
		}
		
		function saveRelated()
		{
			var pars = 'action=saveRelated&ProductID=<?=$CHECK_PAGE['ProductID'];?>';
			jQuery('.relatedCh:checked').each(function(){
				pars+='&related[]='+jQuery(this).attr('value');
			});
			
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout("document.location.reload()",500);}, onFailure:failedEdit, onLoading:savingChanges});
		}
		
		(function($) {
			$.generateId = function() {
				return arguments.callee.prefix + arguments.callee.count++;
			};
			$.generateId.prefix = 'jq$';
			$.generateId.count = 0;
		
			$.fn.generateId = function() {
				return this.each(function() {
					this.id = $.generateId();
				});
			};
		})(jQuery);
		
		function SaveDescription() {
			slideOutEditor("DescriptionEditor",0);
			var pars = 'action=editParameter&ProductID=<?=$CHECK_PAGE['ProductID'];?>&id=ProductDescription&value='+encodeURIComponent(editor_ins.getData());
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
		}
		
		function ReloadPage() {
			document.location.reload();
		}
		
		jQuery('document').ready(function() {
			jQuery('.editable').mouseout(function () {
			      jQuery(this).effect("highlight", {}, 1000);
			});
			jQuery('.editable').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=editParameter&ProductID=<?=$CHECK_PAGE['ProductID'];?>',{onblur:'submit'});
			
			jQuery('.editable_title').mouseout(function () {
			      jQuery(this).effect("highlight", {}, 1000);
			});
			jQuery('.editable_title').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=editParameter&ProductID=<?=$CHECK_PAGE['ProductID'];?>',{width:'400px'});
			
			/* (function($) {
				$.editable.addInputType('ckeditor', {
				    element : function(settings, original) {
				    	$('.left_part').hide();
				    	$('.editable_textarea').css('width','669px');

				        var textarea = $('<textarea>').css("opacity", "0").generateId();
				        if (settings.rows) {
				            textarea.attr('rows', settings.rows);
				        } else {
				            textarea.height(settings.height);
				        }
				        if (settings.cols) {
				            textarea.attr('cols', settings.cols);
				        } else {
				            textarea.width(settings.width);
				        }
				        $(this).append(textarea);
				        return(textarea);
				    },
				    content : function(string, settings, original) { 
				        $('textarea', this).text(string);
				    },
				    plugin : function(settings, original) {
				        var self = this;
				        if (settings.ckeditor) {
				            setTimeout(function() { CKEDITOR.replace($('textarea', self).attr('id'), settings.ckeditor); }, 0);
				        } else {
				            setTimeout(function() { CKEDITOR.replace($('textarea', self).attr('id')); }, 0);
				        }
				    },
				    submit : function(settings, original) {
				    	$('.editable_textarea').css('width','320px');
				    	$('.left_part').show();
				        $('textarea', this).val(CKEDITOR.instances[$('textarea', this).attr('id')].getData());
					CKEDITOR.instances[$('textarea', this).attr('id')].destroy();
				    }
				});
			})(jQuery);

			jQuery('.editable_textarea').editable(
				'<?=$SITE[url];?>/Admin/saveProduct.php?action=editParameter&ProductID=<?=$CHECK_PAGE['ProductID'];?>',
				{
					type : 'ckeditor',
					submit : 'OK',
					cancel: 'Cancel',
					height:'300px',
					ckeditor: {
						filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
						filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
						filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
						filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
						filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
						filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					},
					onblur    : 'ignore',
					onreset: function() {
						jQuery('.left_part').show();
					}
				}
			); */
		});
	</script>
	<?
} ?>