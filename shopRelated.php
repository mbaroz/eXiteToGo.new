<?

require_once 'inc/ProductsShop.inc.php';
$related = getRelatedProducts($CHECK_PAGE['ProductID']);
if(count($related) > 0)
{
	$p_w = ($SITE[shopRelatedPosition] == 'bottom') ? '100' : '87';
	$p_m = ($SITE[shopRelatedPosition] == 'bottom') ? '14' : '13';
	$p_t_m = ($SITE[shopRelatedPosition] == 'bottom') ? '20' : '5';
	
?>
<style type="text/css">
.underRound .roundBox {
	width:auto;
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
</style>
<div style="font-size:20px;text-align:<?=$SITE['align'];?>;padding-bottom:<?=$p_t_m;?>px;margin:20px 10px 0;" class="pay_block_title"><span><?=($SITE[shopRelatedProductsTitle] == '') ? $SHOP_TRANS['related_products'] : $SITE[shopRelatedProductsTitle];?></span><div style="clear:both;"></div></div>
<? if ($SITE[roundcorners]==1 && $SITE[shopFeaturedBgColor] != '') { ?><div class="underRound" style="margin:0 10px;width:auto;"><? SetRoundedCorners(1,1,$SITE[shopFeaturedBgColor]); ?></div><? } ?>
<div style="width:auto;margin:0 10px;<? if ($SITE[roundcorners]!=1 || $SITE[shopFeaturedBgColor] == ''){ ?>margin-bottom:20px;<? } ?>padding:7px 0px;<?=($SITE[shopFeaturedBgColor] != '') ? 'background:#'.$SITE[shopFeaturedBgColor].';' : '';?>" id="featuredContainer">
	<div id="oneInFeatured" style="margin:0px;position:relative;">
		<div id="underRuler">
			<? foreach($related as $f_product){
				$img_url=($f_product['ProductPhotoName'] != '') ? SITE_MEDIA.'/'.$gallery_dir.'/products/thumb_'.$f_product['ProductPhotoName'] : '';
				$page_url=$SITE['media'].'/shop_product/'.$f_product['catUrlKey'].'/'.$f_product['UrlKey'];
				if ($f_product['ProductUrl']!='')
					$page_url=urldecode($f_product['ProductUrl']);
				?>
				<div style="width:<?=$p_w;?>px;float:<?=$SITE[align];?>;margin:0 <?=$p_m;?>px <?=$p_m;?>px;" class="relatedProd">
					<div class="underpic" style="margin-bottom:5px;width:<?=($p_w-2);?>px;height:<?=($p_w-2);?>px;text-align:center;overflow:hidden;<?=($SITE[cartProductPicBorderColor] != '') ? 'border:1px solid #'.$SITE[cartProductPicBorderColor].';' : '';?><?=($SITE[cartProductPicBgColor] != '') ? 'background:#'.$SITE[cartProductPicBgColor].';' : '';?>;display: table; #position: relative; overflow: hidden;">
					<div style="#position: absolute; #top: 50%;display: table-cell; vertical-align: middle;">
						<? if($img_url != ''){ ?>
						<a href="<?=$page_url;?>"><img src="<?=$img_url;?>" style="max-width:<?=($p_w-2);?>px;max-height:<?=($p_w-2);?>px;#position: relative; #top: -50%" border="0" /></a>
						<? } ?>
					</div>
					</div>
					<a style="color:#<?=($SITE[cartListProductNameColor] != '') ? $SITE[cartListProductNameColor] : $SITE[linkscolor];?>;text-decoration:underline;word-wrap:break-word;" href="<?=$page_url;?>"><?=$f_product['ProductTitle'];?></a>
				</div>
			<? } ?>
			<div style="clear:both"></div>
		</div>
	</div>
</div>
<? if ($SITE[roundcorners]==1 && $SITE[shopFeaturedBgColor] != '') { ?><div class="underRound" style="margin:0 10px 20px;width:auto;"><? SetRoundedCorners(0,1,$SITE[shopFeaturedBgColor]); ?></div><? } ?>
<script type="text/javascript">
var max_height = 0;
var very_max_height = 0;
var very_max_i = 0;
var max_line = 0;
var i_now = 0;
var i_prev = 0;
var marg = 0;
jQuery(function(){
	max_line = Math.floor(jQuery('#underRuler').width() / jQuery('.relatedProd').first().outerWidth(true));
	marg = parseInt(jQuery('.relatedProd').first().css('margin-<?=$SITE[align];?>')) + Math.round((jQuery('#underRuler').width() - (jQuery('.relatedProd').first().outerWidth(true)*max_line))/2);
	jQuery('.relatedProd').each(function(){
		if(i_now == max_line)
		{
			if(very_max_i < 2)
			{
				very_max_height += max_height;
				very_max_i++;
			}
			jQuery('.relatedProd').eq(i_prev).css('margin-<?=$SITE[align];?>',marg+'px');
			jQuery('.relatedProd').eq(i_prev+i_now-1).css('margin-<?=$SITE[opalign];?>','0px');
			for(var j = i_prev;j < i_prev+i_now;j++)
			{
				jQuery('.relatedProd').eq(j).height(max_height);
			}
			max_height = 0;
			i_prev += i_now;
			i_now = 0;
		}
		i_now++;
		if(jQuery(this).height() > max_height)
			max_height = jQuery(this).height();
		
	});
	if(very_max_i < 2)
	{
		very_max_height += max_height;
		very_max_i++;
	}
	jQuery('.relatedProd').eq(i_prev).css('margin-<?=$SITE[align];?>',marg+'px');
	jQuery('.relatedProd').eq(i_prev+i_now-1).css('margin-<?=$SITE[opalign];?>','0px');
	for(var j = i_prev;j < i_prev+i_now;j++)
	{
		jQuery('.relatedProd').eq(j).height(max_height);
	}
	
	<? /* if($SITE[shopRelatedPosition] == 'side') { ?>
		jQuery('#underRuler').height(very_max_height+<?=$p_m;?>);
		jQuery('#underRuler').css('overflow','auto');
	<? } */ ?>
});
</script>
<? } ?>