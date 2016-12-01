<?

require_once 'inc/ProductsShop.inc.php';
$featured = array();
if($SITE[shopFeaturedShown] != 0)
	$featured = getFeaturedProducts();
if(count($featured) > 0)
{
	$rarr = '&laquo;';
	$larr = '&raquo;';
	$arr_w = 20;
	$arr_h = 30;
	if($SITE[shopFeaturedArrows] != '')
	{
		$size = getimagesize($gallery_dir.'/sitepics/'.$SITE[shopFeaturedArrows]);
		//$arr_w = round($size[0]/2);
		$arr_h = $size[1];
		$larr = '<span style="display:block;width:'.$arr_w.'px;height:'.$size[1].'px;background:url('.$SITE[url].'/'.$gallery_dir.'/sitepics/'.$SITE[shopFeaturedArrows].') no-repeat;"></span>';
		$rarr = '<span style="display:block;width:'.$arr_w.'px;height:'.$size[1].'px;background:url('.$SITE[url].'/'.$gallery_dir.'/sitepics/'.$SITE[shopFeaturedArrows].') no-repeat -'.$arr_w.'px top;"></span>';
	}
	
	if(count($featured) < 6)
	{
		$rarr = '';
		$larr = '';
	}
	//$arr_w = 20;
	$c_w = 649-(2*$arr_w);
	
?>
<style type="text/css">
.underRound .roundBox {
	width:auto;
}
</style>
<div style="font-size:20px;text-align:<?=$SITE['align'];?>;padding-bottom:20px;margin:20px 10px 0;" class="pay_block_title"><span><?=$SHOP_TRANS['featured_products'];?></span><div style="clear:both;"></div></div>
<? if ($SITE[roundcorners]==1 && $SITE[shopFeaturedBgColor] != '') { ?><div class="underRound" style="margin:0 10px;width:auto;"><? SetRoundedCorners(1,1,$SITE[shopFeaturedBgColor]); ?></div><? } ?>
<div style="width:auto;height:200px;margin:0 10px;<? if ($SITE[roundcorners]!=1 || $SITE[shopFeaturedBgColor] == ''){ ?>margin-bottom:20px;<? } ?>padding:7px 0px;<?=($SITE[shopFeaturedBgColor] != '') ? 'background:#'.$SITE[shopFeaturedBgColor].';' : '';?>" id="featuredContainer">
	<div style="float:<?=$SITE[align];?>;width:<?=$arr_w;?>px;padding-<?=$SITE[align];?>:5px;" id="rarr"><a href="#" onclick="fMoveRight();return false;" style="font-size:30px;color:#<?=$SITE[linkscolor];?>;"><?=$rarr;?></a></div>
	<div id="oneInFeatured" style="float:<?=$SITE[align];?>;width:<?=$c_w;?>px;margin:0 5px;height:100%;overflow:hidden;position:relative;">
		<div style="position:absolute;top:0;<?=$SITE[align];?>:0;" id="underRuler">
			<? foreach($featured as $f_product){
				$img_url=($f_product['ProductPhotoName'] != '') ? $SITE['url'].'/'.$gallery_dir.'/products/thumb_'.$f_product['ProductPhotoName'] : '';
				$page_url=$SITE['media'].'/shop_product/'.$f_product['catUrlKey'].'/'.$f_product['UrlKey'];
				if ($f_product['ProductUrl']!='')
					$page_url=urldecode($f_product['ProductUrl']);
				?>
				<div style="width:100px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:27px;">
					<div class="underpic" style="margin-bottom:5px;width:98px;height:98px;text-align:center;overflow:hidden;<?=($SITE[cartProductPicBorderColor] != '') ? 'border:1px solid #'.$SITE[cartProductPicBorderColor].';' : '';?><?=($SITE[cartProductPicBgColor] != '') ? 'background:#'.$SITE[cartProductPicBgColor].';' : '';?>">
						<? if($img_url != ''){ ?>
						<a href="<?=$page_url;?>"><img src="<?=$img_url;?>" style="max-width:98px;max-height:98px;" border="0" /></a>
						<? } ?>
					</div>
					<a style="color:#<?=($SITE[cartListProductNameColor] != '') ? $SITE[cartListProductNameColor] : $SITE[linkscolor];?>;text-decoration:underline;word-wrap:break-word;" href="<?=$page_url;?>"><?=$f_product['ProductTitle'];?></a>
				</div>
			<? } ?>
		</div>
	</div>
	<div style="float:<?=$SITE[align];?>;width:<?=$arr_w;?>px;padding-<?=$SITE[opalign];?>:5px;" id="larr"><a href="#" onclick="fMoveLeft();return false;" style="font-size:30px;color:#<?=$SITE[linkscolor];?>;"><?=$larr;?></a></div>
</div>
<? if ($SITE[roundcorners]==1 && $SITE[shopFeaturedBgColor] != '') { ?><div class="underRound" style="margin:0 10px 20px;width:auto;"><? SetRoundedCorners(0,1,$SITE[shopFeaturedBgColor]); ?></div><? } ?>
<script type="text/javascript">
	
	var f_total_products = <?=count($featured);?>;
	var max_prods = 5;
	var f_current_pointer = max_prods;
	if(f_current_pointer > f_total_products)
		f_current_pointer = f_total_products;
	
	function fMoveLeft(){
		f_current_pointer++;
		if(f_current_pointer > f_total_products)
		{
			f_current_pointer--;
			return;
			//jQuery('#underRuler').animate({'<?=$SITE[align];?>' : 0},1000);
		}
		else
		{
			var move_total = (f_current_pointer - max_prods) * 127;
			jQuery('#underRuler').animate({'<?=$SITE[align];?>' : '-'+move_total+'px'},600);
		}
	}
	
	function fMoveRight(){
		f_current_pointer--;
		if(f_current_pointer < max_prods)
		{
			f_current_pointer++;
			return;
			//jQuery('#underRuler').animate({'<?=$SITE[align];?>' : 0},1000);
		}
		else
		{
			var move_total = (f_current_pointer - max_prods) * 127;
			jQuery('#underRuler').animate({'<?=$SITE[align];?>' : '-'+move_total+'px'},600);
		}
	}
	
	//jQuery(window).load(function(){
		jQuery('#oneInFeatured').width(jQuery('#featuredContainer').width()-(2*<?=$arr_w;?>)-20);
		max_prods = Math.ceil(jQuery('#oneInFeatured').width()/127);
		var line_height = 30;
		var max_height = 0;
		var total_width = 0;
		jQuery(window).load(function(){
			jQuery('.underpic a img').each(function(){
				if(jQuery(this).height() < jQuery(this).parent().parent().height())
					jQuery(this).css('margin-top',Math.round((jQuery(this).parent().parent().height()-jQuery(this).height())/2)+'px');
			}); 
		});
		jQuery('.underpic').each(function(){
			if(jQuery(this).height() > max_height)
				max_height = jQuery(this).height();
			total_width += 127;
		});
		jQuery('.underpic').height(max_height);
		jQuery('.underpic').each(function(){
			if(jQuery(this).parent().height() > line_height)
				line_height = jQuery(this).parent().height();
		});
		jQuery('#larr,#rarr').css({'padding-top':Math.round((98/2)-(<?=$arr_h;?>/2))+'px'});
		jQuery('#featuredContainer').height(line_height);
		jQuery('#underRuler').width(total_width);
	//});
</script>
<? } ?>