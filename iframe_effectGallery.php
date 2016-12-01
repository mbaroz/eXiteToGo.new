<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
$gID=$_GET['gID'];

//Photogallery.php : Ver:1.0 /  Last Update: 10/01/2010
//TODO: 
$galleryWidth=667;
$PhotoDivWidth="";

if (intval($isLeftColumn)>0) {
	$customLeftColSub=200;
	if ($customLeftColWidth) $customLeftColSub=$customLeftColWidth;
	$galleryWidth=$galleryWidth-$customLeftColSub;
	
}

$NumPerLine=4;
$boxHeight=$SITE[galleryphotoheight]+13;
$boxWidth=$SITE[galleryphotowidth]+11;
$textAlign="center";
$vertical=0;
$textLinesEdit=1;
$GalID=$gID;
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
if ($_GET['nobg']==1) $SITE[effectgallerybg]="";
if ($_GET['noborder']==1) $SITE[effectgallerybordercolor]="";
$noArrows=$_GET['noarrows'];
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
$GAL_OPTIONS[photo_text_bg_color]=GetGalleryAttribute('photos_text_bg_color',$GalID);
$GAL_OPTIONS[photo_text_color]=GetGalleryAttribute('photos_text_color',$GalID);
$GAL_OPTIONS[tumbs_border_color]=GetGalleryAttribute('tumbs_border_color',$GalID);
$GAL_OPTIONS[gallery_border_color]=GetGalleryAttribute('gallery_border_color',$GalID);
$GAL_OPTIONS[gallery_bg_color]=GetGalleryAttribute('gallery_bg_color',$GalID);
$GAL_OPTIONS[gallery_width_mode]=GetGalleryAttribute('gallery_width_mode',$GalID);
function SetPageEffectGallery($gID) {
	global $SITE;
	global $gallery_dir;
	global $ADMIN_TRANS;
	global $galleryWidth;
	global $PhotoDivWidth;
	global $P_DETAILS;
	global $SITE_LANG;
        global $GAL_OPT;
	global $noArrows;
	global $GAL_OPTIONS;
	$gallery_text_color=$SITE[effectgallerytextcolor];
	$gallery_text_bg_color=$SITE[effectgallerybgcolor];
	$gallery_bg_color=$SITE[effectgallerybg];
	$gallery_border=$SITE[effectgallerybordercolor];
	$tumbs_border_color=$SITE[thumbsbordercolor];
	if ($GAL_OPTIONS[photo_text_color]) $gallery_text_color=$GAL_OPTIONS[photo_text_color];
	if ($GAL_OPTIONS[photo_text_bg_color]) $gallery_text_bg_color=$GAL_OPTIONS[photo_text_bg_color];
	if ($GAL_OPTIONS[gallery_border_color]) $gallery_border=$GAL_OPTIONS[gallery_border_color];
	if ($GAL_OPTIONS[gallery_bg_color]) $gallery_bg_color=$GAL_OPTIONS[gallery_bg_color];
	if ($GAL_OPTIONS[tumbs_border_color]) $tumbs_border_color=$GAL_OPTIONS[tumbs_border_color];
	if ($_GET['nobg']==1) $gallery_bg_color="";
	if ($_GET['noborder']==1) $gallery_border="";
	$width_increment=14;
	$height_indcrement=12;
	if ($gallery_bg_color=="" AND $gallery_border=="") $width_increment=$height_indcrement=0;
        $db=new Database();
        $db->query("SELECT * from galleries WHERE GalleryID='$gID'");
	$db->nextRecord();
	$numFields=$db->numFields();
            for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$GAL_OPT[$fName]=$db->getField($fNum);
		}
	$GAL=GetGalleryPhotos($gID);
	$GAL_PIX_DIAPO_EFFECTS=array('random','scrollHorz','scrollTop','scrollBottom','scrollLeft','scrollRight','simpleFade', 'curtainTopLeft', 'curtainTopRight', 'curtainBottomLeft', 'curtainBottomRight', 'curtainSliceLeft', 'curtainSliceRight', 'blindCurtainTopLeft', 'blindCurtainTopRight', 'blindCurtainBottomLeft', 'blindCurtainBottomRight', 'blindCurtainSliceBottom', 'blindCurtainSliceTop', 'stampede', 'mosaic', 'mosaicReverse', 'mosaicRandom', 'mosaicSpiral', 'mosaicSpiralReverse', 'topLeftBottomRight', 'bottomRightTopLeft', 'bottomLeftTopRight', 'bottomLeftTopRight');
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
	$galJS="galleria/galleria-1.4.2.min.js";
	$gal_container_css='';
	$globalCDN=$SITE['cdn_url'];
	if ($GAL_OPT[GalleryTheme]==0) {
		$gal_theme="galleria.pagedots.js";
		$gal_css="galleria.pagedots.css";
	}
	if ($GAL_OPT[GalleryTheme]==1) {
		$gal_theme="galleria.pageclassic.js";
		$gal_css="galleria.pageclassic.css";
		
	}
	if ($GAL_OPT[GalleryEffect]>3) {
		$galJS="diapo.js";
		$gal_css="diapo.page.css";
		$globalCDN=$SITE[url];
	}
	if ($GAL[ProductGallery]==1) $PhotoDivWidth=445;
	if ($P_DETAILS[PageStyle]==1) $PhotoDivWidth=650;
	if ($SITE[productgallerywidth]) {
		$sideTextWidth=($galleryWidth-$SITE[productgallerywidth]);
		$PhotoDivWidth=($SITE[productgallerywidth]);
	}
	if (!$GAL[ProductGallery]==1) $PhotoDivWidth="";
	if ($GAL_OPT[AutoPlay]==1) $gal_autoplay="false";
	else $gal_autoplay="true";
	$gal_slide_speed=$GAL_OPT[SlideSpeed];
	if ($GAL_OPT[SlideSpeed]<20) $gal_slide_speed="400";
	$gal_height=$GAL_OPT[GalleryHeight];
	if ($gal_height==0) $gal_height=350;
	if ($GAL_OPT[SlideDelay]>1) $gal_autoplay=$GAL_OPT[SlideDelay];
	if ($GAL_OPT[AutoPlay]==1) $gal_autoplay="false";
	if ($GAL_OPT[GalleryTheme]==1) $gal_height=$gal_height+113;
	else $gal_height=$gal_height+30;
	
	$showArrowNav="";
	if (count($GAL[PhotoID])<2 OR $noArrows==1) $showArrowNav="none";
	?>
	 <style> 
	            #galleriapage{
		   margin:0px auto 2px 0px;
		   direction:ltr;
	            z-index:0;
	           }
        </style> 
       <?if ($GAL_OPT[GalleryEffect]>3) {
		?>
		<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/gallery/slider/<?=$gal_css;?>">
		<?
		}
		?>
	<style>
	<?
	if ($GAL_OPT[GalleryEffect]<4) {
		?>
        	.galleria-stage {background-color:#<?=$gallery_bg_color;?>;
		padding:7px;
		border:1px solid #<?=$gallery_border?>;
		left:0;
		right:0;
		}
		.galleria-thumbnails .galleria-image {
	                border:2px solid #<?=$tumbs_border_color;?>;
          	}
          	.galleria-thumbnails {
          		min-height:65px;
			margin:0 auto;
          	}
          	
              .galleria-thumb-nav-left {
          		height:60px;width:16px !important;
          		left:2px;
          		top:8px;
          		background-color:#<?=$SITE[contenttextcolor];?>;
          		background-repeat:no-repeat;
				background-position: -500px 5px !important;
          	}	
          	.galleria-thumb-nav-right {
          		height:60px;width:16px !important;
          		right:2px;
          		top:8px;
          		background-color:#<?=$SITE[contenttextcolor];?>;
          		background-repeat:no-repeat;
			background-position-y:-2px;
          	}
          	.galleria-info-title {color:#<?=$gallery_text_color;?>;}
          	.galleria-info-text {background-color:#<?=$gallery_text_bg_color;?>;direction:<?=$SITE_LANG[direction];?>}
          	.galleria-theme-classic {background-color:transparent !important}
          	.galleria-thumbnails .galleria-image img {
          		width:80px;
          		height:60px;
          	}

          	<?
		$clientHeightIncrement=$decrementHeight=0;
        	if ($GAL_OPT[GalleryTheme]==0) {// DOTS GALLERY
			for ($a=0;$a<count($GAL[PhotoID]);$a++) {
				$isTextInPhotos=0;
				if ($GAL[PhotoText][$a]!="") {
					$isTextInPhotos=1;
					break;
				}
			}
			if ($isTextInPhotos==1) $decrementHeight=30; //for text to show up under photos
        		?>
        		.galleria-stage {padding:7px 7px 7px 7px;}
        		.galleria-thumbnails .galleria-image {border:0px;display:<?=$showArrowNav;?>;}
        		 .galleria-thumb-nav-left, .galleria-thumbnails-container {display:none;}
        		 .galleria-info-title {color:#<?=$SITE[contenttextcolor];?>;}
        		 .galleria-info-text {background-color:transparent}
        		<?
        	}
        	else {
        		?>
	       		 .galleria-info {width:99.8%;left:1px !important;}
	       		.galleria-thumbnails-container{background-color:#<?=$gallery_bg_color;?>;margin-bottom:2px;padding-top:7px;padding-bottom:6px;border:1px solid #<?=$gallery_border;?>;}
			.galleria-thumbnails-container {height:auto;left:0;right:0}
			.galleria-thumb-nav-left, .galleria-thumb-nav-right {margin-top:8px;}
        		<?
        	}
        	if (count($GAL[PhotoID])<8) {
        		?>.galleria-thumbnails .galleria-image {margin-left:7px;}
        		<?
        	}
        
	}
	if ($GAL_OPT[GalleryEffect]>3) {
		$framepadding=7;
		if (!$gallery_bg_color AND !$gallery_border) $framepadding=0;
		//if ($gallery_border) $clientHeightIncrement=2;
		
		?>
		#galleriapage {
			border:1px solid #<?=$gallery_border;?>;
			background-color:#<?=$gallery_bg_color;?>;
			
		}
		.pix_diapo_page {
			margin:0px;
		}
		
		.pix_diapo_img {
			max-width: <?=$galleryWidth;?>px;
			max-height: <?=$GAL_OPT[GalleryHeight];?>px;
			width: expression(this.width > <?=$galleryWidth;?> ? "<?=$galleryWidth;?>px" : true);
			height: expression(this.height > <?=$gal_height;?> ? "<?=$gal_height;?>px" : true);
		}
                .pix_relativize {
                    display: table-cell;
		}
		#galleriapage #pix_next,#galleriapage #pix_prev {display:<?=$showArrowNav;?>;}
		.caption {color:#<?=$gallery_text_color;?>;background-color:#<?=$gallery_text_bg_color;?>;bottom:0}
		<?
	}
        ?>
        .galleria-container {margin:0px 0px 0px 0px;}
        </style>
	<script src="<?=$globalCDN;?>/js/gallery/slider/<?=$galJS;?>"></script>
       
	
	<style>
		#galleriapage .galleria-image-nav{display:<?=$showArrowNav;?>}
	</style>
	
	<div id="galleriapage" <?=$css_align;?>>
	<?
	if ($GAL_OPT[GalleryEffect]>3) print '<div class="pix_diapo_page">';
	for ($a=0;$a<count($GAL[PhotoID]);$a++){ 
		$GalPagePic=$GAL[FileName][$a];
		$GalPicText=$GAL[PhotoText][$a];
		$galPhotoTarget="_top";
		$link_str=$img_link="";
		if ($GAL[PhotoUrl][$a]) {
			$img_link=urldecode($GAL[PhotoUrl][$a]);
			$link_str='longdesc="'.$img_link.'"';
		}
		if (strpos($img_link,$SITE[url])===false AND strpos($img_link,"/category/")===false AND !strpos($img_link,"/")==0) $galPhotoTarget="_blank";
		switch(1) {
			case $GAL_OPT[GalleryEffect]<4:
				?><a href="<?=SITE_MEDIA."/".$gallery_dir."/".$GalPagePic;?>">
				<?
				print '<img src="'.SITE_MEDIA.'/'.$gallery_dir.'/tumbs/'.$GalPagePic.'" border="0" title="'.$GalPicText.'" '.$link_str.' /></a>';	
			break;
			case $GAL_OPT[GalleryEffect]>3:
				print '<div data-thumb="'.SITE_MEDIA.'/'.$gallery_dir.'/tumbs/'.$GalPagePic.'">';
				if ($img_link) print '<a target="'.$galPhotoTarget.'" href="'.$img_link.'" style="cursor:'.$cursor.'">';
					print '<img src="'.SITE_MEDIA.'/'.$gallery_dir.'/'.$GalPagePic.'" border="0" class="pix_diapo_img">';
				if ($img_link) print '</a>';
				if ($GalPicText) print '<div class="caption elemHover fromLeft">'.$GalPicText.'</div>';
				print '</div>';
			break;
			default:
			break;
		} //end switch
		
	}
	if ($GAL_OPT[GalleryEffect]>3) print '</div>';
	?>
	</div>
	<?
	
	//if (isset($_SESSION['LOGGED_ADMIN'])) $clientHeightIncrement=7;
	switch (1) {
		case $GAL_OPT[GalleryEffect]<4:
			?>
			<script>
			Galleria.loadTheme('<?=$globalCDN;?>/js/gallery/slider/galleria/themes/classic/galleria.classic.min.js?t=677');
			Galleria.run('#galleriapage',{
				transition: '<?=$gal_effect;?>',
				autoplay:<?=$gal_autoplay;?>,
				imageCrop:'<?=$GAL_OPTIONS[gallery_width_mode]==1 ? 'width' : 'false';?>',
				image_margin:0,
				height:<?=$gal_height;?>,
				transitionSpeed:<?=$gal_slide_speed;?>,
				show_counter: false,
				lightbox: true,
				thumbnails:<?=$GAL_OPTIONS[GalleryTheme]==0 ? 'true' : 'false';?>,
				extend: function(options) {PageGallerySlider = this;}
			});
			jQuery('.galleria-thumb-nav-right').html("0");
			</script>
			<?
		break;
		case $GAL_OPT[GalleryEffect]>3:
		?>
		<!--[if !IE]><!--><script type='text/javascript' src='<?=$SITE[url];?>/js/gallery/slider/jquery.mobile-1.0rc2.customized.min.js'></script><!--<![endif]-->
		<script type='text/javascript' src='<?=$SITE[url];?>/js/gallery/slider/jquery.hoverIntent.minified.js'></script> 
		<script language="javascript">
		var clientHeight=jQuery(window).height();
		jQuery("#galleriapage").css("height",(clientHeight-<?=($framepadding*2);?>)+"px");
		jQuery(".pix_diapo_page").css("height",(clientHeight-<?=($framepadding*2);?>)+"px");
		jQuery(function(){
				jQuery('.pix_diapo_page').diapo({
					fx:'<?=$GAL_PIX_DIAPO_EFFECTS[$GAL_OPT[GalleryEffect]-4];?>',
					loader: 'none',
					commands:'false',
					mobileCommands:'false',
					time:<?=$GAL_OPT[SlideDelay];?>,
					transPeriod:<?=$gal_slide_speed;?>,
					pagination:'false',
					mobilePagination:'false'
				});
		});
		
                var gal_dynamic_w=jQuery("#galleriapage").width()-<?=$width_increment;?>;
                var gal_dynamic_h=jQuery("#galleriapage").height()-<?=$height_indcrement;?>;
                jQuery(".pix_diapo_img").css("max-width",gal_dynamic_w+"px");
                jQuery(".pix_diapo_img").css("max-height",gal_dynamic_h+"px");
		jQuery("#galleriapage").css("height",(clientHeight-<?=($framepadding*2)+$clientHeightIncrement;?>)+"px");
		</script>
		<?
		break;
		default:
		break;
	} //end switch
	 
} //end of function

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<base target="_top" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php?urlKey=<?=$urlKey;?>">
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/lightbox/css/jquery.lightbox-0.5.css" media="screen" />
    <script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
	<script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.9.2.custom.min.js"></script>
     <script language="javascript" type="text/javascript">
	jQuery.noConflict();
        </script>
	<style>
	body {background:none;background-image:none;background-color:transparent;margin:0;padding:0;direction:<?=$SITE_LANG[direction];?>}
	</style>

</head>
<body> 

<div id="effectGalContainer"><?SetPageEffectGallery($gID);?></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
    $UKEY=GetUrlKeyFromID($GAL_OPT[CatID]);
    $gal_url_key=$UKEY[UrlKey];
    
    ?>
    <div id="editMode" class="mainContentText" style="display:none;font-size:12px;position:absolute;top:0px;z-index:1000;background-color:#<?=$SITE[contentbgcolor];?>"><a href="<?=$SITE[media];?>/category/<?=$gal_url_key;?>"><?=$ADMIN_TRANS['go to gallery settings page'];?></a></div>

	<script>
	jQuery("#effectGalContainer").mouseover(function() {
		jQuery("#editMode").show();
	});
	jQuery("#effectGalContainer").mouseout(function() {
		jQuery("#editMode").hide();
	});
	jQuery("#editMode").mouseover(function() {
		jQuery("#editMode").show();
	});
	
    </script>
<?
}
?>
</body>
</html>