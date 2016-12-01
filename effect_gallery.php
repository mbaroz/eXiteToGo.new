<?
reset($GAL);
include_once("inc/imageResizer.php");
$GAL=GetCatGallery($urlKey,3,$productUrlKey);
//Photogallery.php : Ver:1.0 /  Last Update: 10/01/2010
//TODO: 
$galleryWidth=$dynamicWidthPadding-263;
$tumbsMargin=45;
$sideTextWidth=223;
$PhotoDivWidth="";

if ($P_DETAILS[PageStyle]==1) {
	$galleryWidth=$dynamicWidthPadding;
	$tumbsMargin=50;
	$sideTextWidth=280;
}

if ($P_DETAILS[PageStyle]==1) $galleryWidth=$dynamicWidthPadding;
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
$GalID=$GAL[GID];
$cursorStyle="pointer";
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
$isWidthModeChecked="";
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
$GAL_OPTIONS[photo_text_bg_color]=GetGalleryAttribute('photos_text_bg_color',$GalID);
$GAL_OPTIONS[photo_text_color]=GetGalleryAttribute('photos_text_color',$GalID);
$GAL_OPTIONS[tumbs_border_color]=GetGalleryAttribute('tumbs_border_color',$GalID);
$GAL_OPTIONS[gallery_border_color]=GetGalleryAttribute('gallery_border_color',$GalID);
$GAL_OPTIONS[gallery_bg_color]=GetGalleryAttribute('gallery_bg_color',$GalID);
$GAL_OPTIONS[gallery_width_mode]=GetGalleryAttribute('gallery_width_mode',$GalID);
if ($GAL_OPTIONS[gallery_width_mode]==1) $isWidthModeChecked="checked";
function SetPageEffectGallery($urlKey) {
	global $SITE;
	global $gallery_dir;
	global $ADMIN_TRANS;
	global $galleryWidth;
	global $PhotoDivWidth;
	global $sideTextWidth;
	global $P_DETAILS;
	global $productUrlKey;
	global $SITE_LANG;
	global $gal_height;
	global $GAL_OPTIONS;
	global $embed_code_height;
	global $dynamicWidth;
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

	$GAL_OPT=GetGalleryOptions($urlKey,3,$productUrlKey);
	$GAL=GetCatGallery($urlKey,3,$productUrlKey);
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
		$css_align='align="center"';
		$effect_image = new SimpleImage();
		$globalCDN=$SITE[url];
	}
	if ($GAL[ProductGallery]==1) $PhotoDivWidth=$dynamicWidth-505;
	if ($P_DETAILS[PageStyle]==1) $PhotoDivWidth=$dynamicWidth-300;
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
	$textTopMargin=7;
	$Text_border_margin=15;
	$SideTextHeight=$gal_height;
	if ($GAL_OPT[GalleryTheme]==1) {
		$textTopMargin=10;
		$SideTextHeight=$SideTextHeight+4;
		$Text_border_margin=10;
	}
	$showArrowNav="";
	if (count($GAL[PhotoID])<2) $showArrowNav="none";
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
	$embed_code_height=$gal_height;
	if ($GAL_OPT[GalleryEffect]<4) {
		?>
		 .galleria-container.galleria-theme-fullscreen{z-index:1000 !important;}
		 .galleria-exit{position:absolute;top:12px;right:12px;z-index:10;cursor:pointer}
        .galleria-stage {background-color:#<?=$gallery_bg_color;?>;
		padding:7px;
		border:1px solid #<?=$gallery_border;?>;
		}
		.galleria-thumbnails .galleria-image {
	                border:2px solid #<?=$tumbs_border_color;?>;
          	}
          	.galleria-thumbnails {
          		min-height:65px;
				margin:0 auto;
          	}
          	
              .galleria-thumb-nav-left {
          		height:64px;width:16px !important;
          		left:5px !important;
          		top:8px ;
          		background-color:#<?=$SITE[contenttextcolor];?>;
          		background-repeat:no-repeat;
          		background-position: -500px 5px !important;
          	}	
          	.galleria-thumb-nav-right {
          		height:64px;width:16px !important;
          		right:6px !important;
          		top:8px;
          		background-color:#<?=$SITE[contenttextcolor];?>;
          		background-repeat:no-repeat;
          	}
          	.galleria-info-title {color:#<?=$gallery_text_color;?>;}
          	.galleria-info-text {background-color:#<?=$gallery_text_bg_color;?>;direction:<?=$SITE_LANG[direction];?>}
          	.galleria-theme-classic {background-color:transparent !important}
          	.galleria-thumbnails .galleria-image img {
          		width:80px;
          		height:60px;
          	}
          	<?
		
        	if ($GAL_OPT[GalleryTheme]==0) {// DOTS GALLERY
        		$embed_code_height=$embed_code_height+30;
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
        		.galleria-info {width:<?=($PhotoDivWidth-17);?>px;}
        		.galleria-thumbnails-container{background-color:#<?=$gallery_bg_color;?>;padding-top:8px;border:1px solid #<?=$gallery_border;?>;}
        		.galleria-thumb-nav-left, .galleria-thumb-nav-right {margin-top:8px;}

        		<?
        	}
        	if (count($GAL[PhotoID])<8) {
        		?>.galleria-thumbnails .galleria-image {margin-left:7px;}
        		<?
        	}
        
	}
	if ($GAL_OPT[GalleryEffect]>3) {
		$vertical_padding=0;
		if ($gallery_bg_color OR $gallery_border) $vertical_padding=14;
		?>
		.pix_diapo_page {
			border:1px solid #<?=$gallery_border;?>;
			background-color:#<?=$gallery_bg_color;?>;
			height:<?=$GAL_OPT[GalleryHeight]+$vertical_padding;?>px;
		}
		.pix_diapo_img {
			max-width: <?=$galleryWidth-14;?>px;
			max-height: <?=$GAL_OPT[GalleryHeight];?>px;
			width: expression(this.width > <?=$galleryWidth;?> ? "<?=$galleryWidth;?>px" : true);			
			height: expression(this.height > <?=$gal_height;?> ? "<?=$gal_height;?>px" : true);
		}
		.pix_relativize {
			<?
			if (ieversion()>8 OR ieversion()<0) print 'display:table-cell;';
			?>
		}
		.caption {color:#<?=$gallery_text_color;?>;background-color:#<?=$gallery_text_bg_color;?>;bottom:0}
		#galleriapage{height:<?=$GAL_OPT[GalleryHeight];?>px;
		
		}
		#galleriapage #pix_next, #galleriapage #pix_prev {display:<?=$showArrowNav;?>;}
		
		<?
		
	}
		$sideTextMargin=0;
        	if ($SITE[gallerysidetextbg]) {
        		$sideTextMargin=10;
        		?>.galleria-container {margin:0px 0px 0px 0px;}
        		
        		<?
        	}
        	?>
        	#SideGalVR {
		border-<?=$SITE[align];?>:1px solid #<?=$SITE[gallerylinecolor];?>;
		padding-<?=$SITE[align];?>:15px;
	}
        	</style>
	<script src="<?=$globalCDN;?>/js/gallery/slider/<?=$galJS;?>"></script>
	<?
	if ($GAL_OPT[ProductGallery]==1) {
		?>
		<div style="margin:<?=$textTopMargin;?>px 0px 0px <?=$sideTextMargin;?>px;float:<?=$SITE[opalign];?>;width:<?=$sideTextWidth;?>px;background:#<?=$SITE[gallerysidetextbg];?>;" class="mainContentText">
		<?if (isset($_SESSION['LOGGED_ADMIN'])) {
			?>&nbsp;&nbsp;&nbsp;
			<div id="newSaveIcon" onclick="EditGallerySideText('galSideText');"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit'];?></div>
			<?
		}
		$padding_top_text=5;
		if (!$SITE[gallerysidetextbg]) {
			$padding_top_text=0;
			?>
			<div id="SideGalVR">
			<?
		}
		
		?>
		<div id="galSideText" style="padding-top:<?=$padding_top_text;?>px;min-height:<?=$gal_height-20;?>px;"><?=$GAL[GallerySideText];?></div>
		<?
		if (!$SITE[gallerysidetextbg]) print '</div>';
		?>
		</div>
		<?
	}
	?>
	
	<style>
		#galleriapage .galleria-image-nav{display:<?=$showArrowNav;?>}
	</style>
	<div style="text-align:left;width:<?=$PhotoDivWidth;?>px">
	<div id="galleriapage" <?=$css_align;?> class="swiper-container swiper-content">
	<?
	if ($GAL_OPT[GalleryEffect]>3) print '<div class="pix_diapo_page" align="center">';
	for ($a=0;$a<count($GAL[PhotoID]);$a++){ 
		$GalPagePic=$GAL[FileName][$a];
		$GalPicText=$GAL[PhotoText][$a];
		$galPhotoTarget="_self";
		$link_str=$img_link="";
		if ($GAL[PhotoUrl][$a]) {
			$img_link=urldecode($GAL[PhotoUrl][$a]);
			$link_str='longdesc="'.$img_link.'"';
		}
		if (strpos($img_link,$SITE[url])===false AND strpos($img_link,"/category/")===false AND !strpos($img_link,"/")==0) $galPhotoTarget="_blank";
		switch(1) {
			case $GAL_OPT[GalleryEffect]<4:
				?><a href="<?=SITE_MEDIA."/".$gallery_dir."/".$GalPagePic;?>?<?=time();?>">
				<?
				print '<img src="'.SITE_MEDIA.'/'.$gallery_dir.'/tumbs/'.$GalPagePic.'" border="0" title="'.$GalPicText.'" '.$link_str.' /></a>';	
			break;
			case $GAL_OPT[GalleryEffect]>3:
				$margin_top=0;
				if (ieversion()>0 AND ieversion()<9) {
					$effect_image->load($gallery_dir.'/'.$GalPagePic);
					$pic_real_height=$pic_calculated_height=$effect_image->getHeight();
					if ($effect_image->getWidth()>$galleryWidth) $pic_calculated_height=$pic_real_height/($effect_image->getWidth()/$galleryWidth);
					if ($pic_calculated_height<$GAL_OPT[GalleryHeight]) $margin_top=($GAL_OPT[GalleryHeight]-$pic_calculated_height)/2;
				}
				print '<div data-thumb="'.SITE_MEDIA.'/'.$gallery_dir.'/tumbs/'.$GalPagePic.'" align="center">';
				if ($img_link) print '<a target="'.$galPhotoTarget.'" href="'.$img_link.'" style="cursor:'.$cursor.'">';
					print '<img src="'.SITE_MEDIA.'/'.$gallery_dir.'/'.$GalPagePic.'?'.time().'" border="0" class="pix_diapo_img" style="margin-top:'.$margin_top.'px">';
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
	if ($GAL_OPT[GalleryEffect]>3) print '<div class="clear" style="min-height:25px"></div>';
	if ($GAL[ProductGallery]==1) {
		?>
		<!--Here comes the gallery content middle-->
		<?if (isset($_SESSION['LOGGED_ADMIN'])) {
			?>
			<div style="text-align:<?=$SITE[align];?>;margin:12px">
				<div id="newSaveIcon" onclick="EditGalleryContent('galMiddleText');"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit content under photos'];?></div>
				<?if ($PhotoDivWidth<260) print '<div style="height:10px;"></div>';?>
			</div>
			<?
		}
		?>
		<div id="galMiddleText" align="<?=$SITE[align];?>" class="galleryMiddleText" style="width:<?=($PhotoDivWidth-15);?>px"><?=$GAL[GalleryBottomPicsText];?></div>
		<?
	}
	?>
	
	</div>
	
	<?
	$increment=10;
	if (!$PhotoDivWidth=="") {
		if (!$P_DETAILS[PageStyle]==1) $increment=35; 
		?>
		<script language="javascript">
		gal_editor_width=<?=($PhotoDivWidth-$increment);?>;
		var org_editor_width=gal_editor_width;
		var sideTextWidth=<?=$sideTextWidth;?>;
		</script>
		<?
	}
	switch (1) {
		case $GAL_OPT[GalleryEffect]<4:
			?>
			<script>
			if (typeof(isSliderFullScreen)=="undefined")
				Galleria.loadTheme('<?=$globalCDN;?>/js/gallery/slider/galleria/themes/classic/galleria.classic.min.js?t=677');
			else {
				if (isSliderFullScreen==1) Galleria.loadTheme('<?=$globalCDN;?>/js/gallery/slider/galleria/themes/fullscreen/galleria.fullscreen.min.js?t=677');
			}
			Galleria.run('#galleriapage',{
				transition: '<?=$gal_effect;?>',
				autoplay:<?=$gal_autoplay;?>,
				imageCrop:'<?=$GAL_OPTIONS[gallery_width_mode]==1 ? 'width' : 'false';?>',
				_hideDock: false,
				image_margin:0,
				height:<?=$gal_height;?>,
				transitionSpeed:<?=$gal_slide_speed;?>,
				show_counter: false,
				lightbox: false,
				thumbnails:<?=$GAL_OPTIONS[GalleryTheme]==0 ? 'true' : 'false';?>,
				extend: function(options) {PageGallerySlider = this;}
			});
			jQuery('.galleria-thumb-nav-right').html("0");
			Galleria.ready(function() {
			    var gallery = this;
			    this.addElement('exit').appendChild('container','exit');
			    var btn = this.jQuery('exit').hide().text('close').click(function(e) {
			        gallery.exitFullscreen();
			    });
			    this.bind('fullscreen_enter', function() {
			        btn.show();
			    });
			    this.bind('fullscreen_exit', function() {
			        btn.hide();
			    });
			});
			</script>
			<?
		break;
		case $GAL_OPT[GalleryEffect]>3:
			include_once("inc/Mobile_Detect.php");
			$detect = new Mobile_Detect();
			if ($detect->isMobile() OR $detect->isTablet() AND !$_SESSION['LOGGED_ADMIN']) {
				?>
				<script type='text/javascript' src='<?=$SITE[url];?>/js/gallery/slider/jquery.mobile-1.0rc2.customized.min.js'></script> 
				<?
			}
			?>
		<script type='text/javascript' src='<?=$SITE[url];?>/js/gallery/slider/jquery.hoverIntent.minified.js'></script>
		<script language="javascript">
		jQuery(function(){
				jQuery('.pix_diapo_page').diapo({
					fx:'<?=$GAL_PIX_DIAPO_EFFECTS[$GAL_OPT[GalleryEffect]-4];?>',
					loader: 'none',
					commands:'false',
					mobileCommands:'false',
					time:<?=$GAL_OPT[SlideDelay];?>,
					transPeriod:<?=$gal_slide_speed;?>,
					pagination:'false',
					mobilePagination:'fase',
					mobileNavigation:'false',
					mobileNavHover:'false'
				});
		});
		
		</script>
		<?
		break;
		default:
		break;
	} //end switch
	 
} //end of function
if (isset($_SESSION['LOGGED_ADMIN'])) {
	//$boxHeight=$boxHeight+10;
	$cursorStyle="move";
}
if ($vertical==1) {
	$boxWidth=$boxWidth*$NumPerLine;
	$textAlign="right";
	$textLinesEdit=4;
}
?>

<style type="text/css">
	#gallery {
	}
	#boxes  {
		font-family: <?=$SITE[cssfont];?>;
		list-style-type: none;
		margin: 0px;
		padding-<?=$SITE[align];?>: 25px;
		padding-<?=$SITE[opalign];?>: 0px;
		width: <?=$galleryWidth+30;?>px;
	}
	#boxes li {
		float: <?=$SITE[align];?>;
		margin-top:5px;
		margin-bottom:10px;
		margin-<?=$SITE[opalign];?>:<?=$tumbsMargin;?>px;
		margin-<?=$SITE[align];?>:0px;
		width: <?=$boxWidth+10;?>px;
		height: <?=$boxHeight+35;?>px;
		border: 0px solid silver;
		text-align: <?=$textAlign;?>;
	}
	.photoName a, .photoName{
		cursor: pointer;
		text-decoration:none;
		color:#<?=$SITE[contenttextcolor];?>;
		padding-top:4px;
		padding-<?=$SITE[align];?>:2px;
		text-align:<?=$SITE[align];?>;
		width:<?=$boxWidth;?>;
		font-weight:bold;
		height:32px;
		overflow:hidden;
	}
	.photoHolder {
		cursor: <?=$cursorStyle;?>;
	}
.CatEditor {
	color:black;
	}
.photoWrapper img {
		max-width:<?=$boxWidth-20;?>px;
		max-height: <?=$boxHeight-20;?>px;
	}

</style>

<?

if (isset($_SESSION['LOGGED_ADMIN'])) {
	$showAdvancedEditButton="none";
	if (ieversion()<0 OR ieversion()>9 ) $showAdvancedEditButton="";
	?>
	 <script type="text/javascript">
		jQuery(function() {
		jQuery("#boxes").sortable({
   		update: function(event, ui) {
   			saveOrder(jQuery("#boxes").sortable('serialize'));
   		}
	});
		//jQuery("#boxes").disableSelection();
	});
 </script>
<style>
	#photoPreviewDisplay {
		width:160px;
		height:150px;
		padding:2px;
		border:1px solid #cfcfcf;
		background-repeat:no-repeat;
		background-position:center;
		background-size: contain;
		background-color:#fff;
	}
	#avpw_temp_loading_image {display: none !important}
</style>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link href="<?=$SITE[url];?>/css/uploader/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.queue.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/fileprogress.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/handlers.js"></script>
<?
if ($showAdvancedEditButton=="") {
	?>
	<script type="text/javascript" src="http://feather.aviary.com/js/feather.js"></script>
	<script language="javascript">
	var featherEditor = new Aviary.Feather({
	       apiKey: 'd378530d86bbf078',
	       apiVersion: 3,
	       theme: 'light', // Check out our new 'light' and 'dark' themes!
	       tools: 'all',
	       appendTo: '',
	       maxSize:1024,
	       onSave: function(imageID, newURL) {
		   var img = document.getElementById(imageID);
		   jQuery("#photoPreviewDisplay").css("background-image",'url('+newURL+')');
		   img.src = newURL;	   
		   featherEditor.close();
	       },
	       postUrl: '<?=$SITE[url];?>/Admin/saveAdvancedPhotoEdit.php',
	       onError: function(errorObj) {
		   alert(errorObj.message);
	       }
	   });
	</script>
	<?
}
?>
<script>
function launchAdvancedPhotoEditor(id, src,photoID) {
       featherEditor.launch({
           image: id,
           url: src,
	   postData:photoID
       });
      return false;
}
var currentGALID="<?=$GalID;?>";
var editor_ins;
//var editor_browsePath="<?//=$SITE[base_dir];?>/ckfinder";
var gal_editor_width="98%";
var uploaded_filename;
var buttonID= "photo_spanButtonPlaceHolder";
var cancelButtonID= "photo_btnCancel";
var progressTargetID="photo_fsUploadProgress";
var allowed_photo_types="*.jpg;*.gif;*.png;*.ico";
function ismaxlength(obj){
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>mlength)
	obj.value=obj.value.substring(0,mlength);
}
function AddNewPic() {
	upload_global_type="photogallery";
	edit_video_id=0;
	edit_photo_id=0;
	jQuery('#PhotoPreview').hide();
	jQuery('#PicUploader').css("width","500px");
	jQuery('#GeneralUploader').css("width","480px");
	if (document.getElementById("PicUploader").style.display=="none") {
		ShowLayer("PicUploader",1,1,1);
		showuploader(allowed_photo_types,200,buttonID,cancelButtonID,progressTargetID,0);
		jQuery("#PicUploader").draggable({
			handle:'#make_dragable',
			cursor:'move'
			});
	}
	else ShowLayer("PicUploader",0,1,1);
	
}

function EditPhotoDetails(photo_url,photo_title,photo_id) {
	$('photo_url').value=photo_url;
	$('photo_text').value=photo_title;
	upload_global_type="photogallery";
	edit_photo_id=photo_id;
	jQuery('#PicUploader').css("width","700px");
	jQuery('#PhotoPreview').show();
	var photo_src_location=jQuery("#photo_cell-"+photo_id+" img.desaturate").attr("src");
	var big_photo_src_location=photo_src_location.replace("tumbs/","");
	var image_id_edit=jQuery("#photo_cell-"+photo_id+" img.desaturate").attr("id");
	jQuery("#photoPreviewDisplay").css("background-image",'url('+photo_src_location+')');
	<?
	if ($showAdvancedEditButton=="") {
		?>
		if (photo_src_location.indexOf("youtube")==-1) {
			jQuery(".advancedEditorButton").show();
			jQuery(".advancedEditorButton").click(function() {
				return launchAdvancedPhotoEditor(image_id_edit, big_photo_src_location,photo_id);
			});
		}
		else jQuery(".advancedEditorButton").hide();
	<?
	}
	?>
	if (document.getElementById("PicUploader").style.display=="none") {
		ShowLayer("PicUploader",1,1,1);
		showuploader(allowed_photo_types,200,buttonID,cancelButtonID,progressTargetID,0);
		jQuery(function() {
		jQuery("#PicUploader").draggable({
			handle:'#make_dragable',
			cursor:'move'
			});
		});
	}
	else ShowLayer("PicUploader",0,1,1);
}
function check_if_gallery_pics_finished() {
		my_stat = swfu.getStats();
		if(my_stat.in_progress == 1 || my_stat.files_queued > 0)
			setTimeout('check_if_gallery_pics_finished()',500);
		else{
			ShowLayer('PicUploader',0,1,1);
			window.setTimeout('ReloadPage()',500);
		}
}
function SaveNewUrl() {
	swfu.startUpload();
	var newPhotoUrl=document.getElementById("photo_url").value;
	var newPhotoText=document.getElementById("photo_text").value;
	newPhotoText=encodeURIComponent(newPhotoText);
	var photo_id=edit_photo_id;
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=rename_url';
	var pars = 'NewPicUrl='+newPhotoUrl+'&photo_id='+photo_id+'&newPhotoText='+newPhotoText;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	setTimeout('check_if_gallery_pics_finished()',500);
}
function DelPhoto(photo_id) {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		deleted_photo_id=photo_id;
		var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=delPhoto';
		var pars = 'photo_id='+photo_id;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
	}
}
function SaveUploadedPhoto(photo_name) {
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php';
	var v_txt=$('photo_text').value;
	var v_url=$('photo_url').value;
	v_txt=encodeURIComponent(v_txt);
	var galID="<?=$GAL[GID];?>";
	var photo_id=edit_photo_id;
	var pars = 'photo_name='+photo_name+'&photo_text='+v_txt+'&photo_url='+v_url+'&galleryID='+galID+'&photo_id='+photo_id+'&p_style=<?=$P_DETAILS[PageStyle];?>';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit,onLoading:savingChanges});
}
function saveOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php';
		var pars = 'galleryID=<?=$GalID;?>'+'&'+newPosition+'&action=saveLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
}
function EditGallerySideText(textDivID) {
	var buttons_str;
	var sideTextContent=$(textDivID).innerHTML;
	var lightTextDiv='<div id="lightSideTextEditor"></div>';
	buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveGalleryContentSide();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
	buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancelLightEdit();"><?=$ADMIN_TRANS['cancel'];?></div>';
	var div=$('lightSideGalTextContainer');
	div.innerHTML=lightTextDiv+buttons_str+"&nbsp;";
	editor_ins=CKEDITOR.appendTo('lightSideTextEditor', {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_news.js'
		});
		editor_ins.setData(sideTextContent);
		//ShowLayer("lightSideGalTextContainer",1,1,1);
		editor_ins.on("loaded",function() {
			slideOutEditor("lightSideGalTextContainer",1);
		});
		
			
}
function EditGalleryContent(textDivID) {
	var editorconfig;
	var buttons_str;
	gal_editor_width="99%";
	editorconfig="config_full.js";
	switch (textDivID) {
		case "galleryContent":
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveGalleryContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		break;
		case "galleryContentBottom":
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveGalleryContentBottom();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		break;
		case "galMiddleText":
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveGalleryContentMiddle();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		break;
		default :
		editorconfig="config_full.js";
		break;
	}
	var contentDIV = document.getElementById(textDivID);
	var gal_Content=contentDIV.innerHTML;
	buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancel();"><?=$ADMIN_TRANS['cancel'];?></div>';
	var div=$('lightEditorContainer');
	div.innerHTML=editorContainerLignboxDiv+buttons_str+"&nbsp;";
	
	editor_ins=CKEDITOR.appendTo('lightContainerEditor', {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/' + editorconfig
		});
	editor_ins.setData(gal_Content);
			//ShowLayer("lightEditorContainer",1,1,0);
		editor_ins.on("loaded",function() {
			slideOutEditor("lightEditorContainer",1);
		});
		
			
}
function saveGalleryContent() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	$('galleryContent').innerHTML=decodeURIComponent(cVal);
	//ShowLayer("lightEditorContainer",0,1,0);
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
}
function saveGalleryContentBottom() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent&divplace=bottom';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
	$('galleryContentBottom').innerHTML=decodeURIComponent(cVal);
	//ShowLayer("lightEditorContainer",0,1,0);
	
}
function saveGalleryContentSide() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent&divplace=side';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	
	//ShowLayer("lightSideGalTextContainer",0,1,0);
	slideOutEditor("lightSideGalTextContainer",0);
	$('galSideText').innerHTML=decodeURIComponent(cVal);
	editor_ins.destroy();
}
function saveGalleryContentMiddle() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent&divplace=middle';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	$('galMiddleText').innerHTML=decodeURIComponent(cVal);
	//ShowLayer("lightEditorContainer",0,1,0);
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
}
function cancel() {
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
	//ShowLayer("lightEditorContainer",0,1,0);
}
function cancelLightEdit() {
	//ShowLayer("lightSideGalTextContainer",0,1,0);
	slideOutEditor("lightSideGalTextContainer",0);
	editor_ins.destroy();
}
function EditGalleryOptions(galID) {
	    if ($('GalPageOptions').style.display=="none") {
		//ShowLayer('GalPageOptions',1,1,1);
		slideOutSettings("GalPageOptions",1);
		jQuery("#GalPageOptions").draggable({
			handle:'#make_dragable',
			cursor:'move'
			});
	    }
	    else slideOutSettings("GalPageOptions",0);
}
function setGalAttributeProperty(gID,v,p) {
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var pars = 'uploadtype=setGalleryAttributeProperty&galID='+gID+'&property_type='+p+'&val='+v;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
}
function SaveGalPageOptions(gallery_id) {
	    var selected_GalEffect=$('gal_effect_page').options[$('gal_effect_page').selectedIndex].value;
	    var selected_GalTheme=$('gal_theme_page').options[$('gal_theme_page').selectedIndex].value;
	    var selected_GalAutoPlay=1;
	    var selected_product_gallery=0;
	    var selected_orderBottom="top";
	    var selected_width_mode=0;
	    if ($('gal_autoplay_page').checked==true) selected_GalAutoPlay=0;
	    if ($('is_product_gallery').checked==true) selected_product_gallery=1;
	    if ($('is_order_bottom').checked==true) selected_orderBottom="bottom";
	     if ($('gallery_width_mode').checked==true) selected_width_mode=1;
	    var slides_speed=$('slide_speed_page').value;
	    var slides_delay=$('slide_delay_page').value;
	    var gallery_height=$('gal_height_page').value;
	    var gallery_num_slices=$('num_slices_page').value;
	    var gal_id=gallery_id;
	    var photos_text_bg_color=$('GAL_OPTIONS[photo_text_bg_color]').value;
	    var photos_text_color=$('GAL_OPTIONS[photo_text_color]').value;
	    var gal_border_color=$('GAL_OPTIONS[gallery_border_color]').value;
	    var gal_bg_color=$('GAL_OPTIONS[gallery_bg_color]').value;
	    var tumbs_border_color=$('GAL_OPTIONS[tumbs_border_color]').value;
	    
	    var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	    var pars = 'uploadtype=saveGalPageOptions&gal_effect='+selected_GalEffect+'&gal_theme='+selected_GalTheme+'&autoplay='+selected_GalAutoPlay+
	    '&slides_speed='+slides_speed+'&gal_height='+gallery_height+'&galleryID='+gal_id+'&urlKey='+urlKey+'&slides_delay='+slides_delay+'&num_slices='+gallery_num_slices+'&selected_product_gallery='+selected_product_gallery
	    +'&selected_orderBottom='+selected_orderBottom;
	    var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	    setGalAttributeProperty(gal_id,photos_text_bg_color,"photos_text_bg_color");
	    setGalAttributeProperty(gal_id,photos_text_color,"photos_text_color");
	    setGalAttributeProperty(gal_id,gal_border_color,"gallery_border_color");
	    setGalAttributeProperty(gal_id,gal_bg_color,"gallery_bg_color");
	    setGalAttributeProperty(gal_id,tumbs_border_color,"tumbs_border_color");
	    setGalAttributeProperty(gal_id,selected_width_mode,"gallery_width_mode");
	    window.setTimeout('ReloadPage()',700);
}
function ShowGalleryTumbs() {
	if ($('boxes').style.display=="none") {
		Effect.SlideDown("boxes");
		Effect.SlideUp("EffectGalleryBigPhotos");
		Effect.ScrollTo('EffectGalleryBigPhotos');
	}
	else {
		Effect.SlideUp("boxes");
		Effect.SlideDown("EffectGalleryBigPhotos");
	}
}
var embed_code_backup;
var newCodeVal;
function ShowEmbedCode() {
	jQuery("#embedGalleryCode").toggle();
	embed_code_backup=jQuery("#embedCode").val();
		var clip = null;
		ZeroClipboard.setMoviePath('/js/zeroclipboard/ZeroClipboard10.swf');	
		jQuery(function() {
			clip = new ZeroClipboard.Client();
			clip.setHandCursor( true );
			clip.addEventListener('mouseOver', function (client) {
				clip.setText(jQuery("#embedCode").val());
			});
			clip.addEventListener('complete', function (client, text) {
				jQuery('#bef_copy').hide();
				jQuery('#af_copy').show();
				setTimeout(function(){
					jQuery('#af_copy').hide();
					jQuery('#bef_copy').show();
				}, 3000);
			});
			clip.glue( 'd_clip_button', 'd_clip_container' );
		});
}

function update_embed_code(op) {
	var the_val;
	var op_the_val;
	var what=op.id;
	if (op.checked) {
		the_val=1;
		op_the_val=0;
	}
		else {
			the_val=0;
			op_the_val=1;
		}
	switch (what)
	{
		case "update_border":
			newCodeVal=embed_code_backup.replace('noborder='+op_the_val,'noborder='+the_val);
			break;
		case "update_bg":
			newCodeVal=embed_code_backup.replace('nobg='+op_the_val,'nobg='+the_val);
			break;
		case "update_arrow":
			newCodeVal=embed_code_backup.replace('noarrows='+op_the_val,'noarrows='+the_val);
			break;
		default:
			break;
	}
	jQuery("#embedCode").val(newCodeVal);
	embed_code_backup=jQuery("#embedCode").val();
}
</script>


<?
include_once("Admin/uploader/uploader_settings.php");
if ($GAL[GalleryName]=="") $GAL[GalleryName]=$ADMIN_TRANS['untitled'];
}
if (!isset($_SESSION['LOGGED_ADMIN']) AND $GAL[GalleryName]==$ADMIN_TRANS['untitled']) $GAL[GalleryName]="";

?>
		<div class="titleContent_top">
		<?if ($SITE[titlesicon]  AND $GAL[GalleryName]) {
			?><div class="titlesIcon"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
			<?
		}
		if ($GAL[GalleryName]!="") {
			?><h1 style="padding-<?=$SITE[align];?>:10px;" id="galleryTitle-<?=$GAL[GID];?>"><?=$GAL[GalleryName];?></h1><?
		}
		?>
			
		</div>
		<div style="clear:both"></div>
<?

if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<br />&nbsp;&nbsp;
	<div id="newSaveIcon" class="add_button" onclick="AddNewPic();"><i class="fa fa-picture-o"></i> <?=$ADMIN_TRANS['add more photos'];?></div>
	<div id="newSaveIcon"  onclick="ShowGalleryTumbs();"><i class="fa fa-clone"></i> <?=$ADMIN_TRANS['edit photos'];?></div>
	<span id="delGalButton"><div id="newSaveIcon"  onclick="DelGallery(<?=$GAL[GID];?>)"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete gallery'];?></div></span>
	<div id="newSaveIcon"  onclick="EditGalleryOptions(<?=$GAL[GID];?>)"><i class="fa fa-sliders"></i> <?=$ADMIN_TRANS['options'];?></div>
	&nbsp;&nbsp;<span id="editGalButton"><div id="newSaveIcon"  onclick="EditGalleryContent('galleryContent');"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit top content'];?></div></span>
	<div style="height:5px"></div>
	<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('galleryTitle-<?=$GAL[GID];?>', '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=renameGallery', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'galleryTitle-<?=$GAL[GID];?>',formClassName:'titleContent_top'});
	</script>
	<?
}

?>
<div id="galleryContent" style="padding-<?=$SITE[align];?>:10px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=str_ireplace("&lsquo;","'",$GAL[GalleryText]);?></div>
<span id="EffectGalleryBigPhotos"><?SetPageEffectGallery($urlKey);?></span>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<div class="clear"></div>
	<ul id="boxes" style="display:none">
	<?
	for ($a=0;$a<count($GAL[PhotoID]);$a++){
			?>
			<li id="photo_cell-<?=$GAL[PhotoID][$a];?>">
			<div class="photoHolder" align="center">
			<?
			$GAL[PhotoUrl][$a]=urldecode($GAL[PhotoUrl][$a]);
			$PhotoExternalUrl=$GAL[PhotoUrl][$a];
			$GAL[PhotoText][$a]=str_ireplace("\n"," ",$GAL[PhotoText][$a]);
			$GAL[PhotoText][$a]=str_ireplace("\r"," ",$GAL[PhotoText][$a]);
			  $text_link=$GAL[PhotoUrl][$a];
			  $target="_self";
			  if ($text_link AND (strpos($text_link,$SITE[url])===false AND strpos($text_link,"/category/")===false)) $target="_blank"; 
			if (!$GAL[PhotoUrl][$a]) $text_link='#';
			
			if ($GAL[FileName][$a]=="") $GAL[FileName][$a]="movies-icon.png";
			?>
				<div class="photoWrapper" align="center">
					<img src="<?=SITE_MEDIA;?>/<?=$gallery_dir;?>/tumbs/<?=$GAL[FileName][$a];?>"  title="<?=$GAL[PhotoText][$a];?>" border="0" align="absmiddle" class="desaturate" id="img-<?=$GAL[PhotoID][$a];?>" />
				</div>
			</div>
			<div style="position:absolute;width:<?=$boxWidth;?>px;margin-top:-17px;margin-left:13px;" align="center">
				<span style="float:right" class="EditPhotoIcon">
				<img onclick="EditPhotoDetails('<?=$PhotoExternalUrl;?>','<?=htmlspecialchars(html_entity_decode($GAL[PhotoText][$a]));?>',<?=$GAL[PhotoID][$a];?>)"  src="<?=$SITE[url];?>/Admin/images/editIcon_new.png" border="0"  class="button" title="<?=$ADMIN_TRANS['edit photo'];?>">
				</span>
				<span style="float:left">
				<img onclick="DelPhoto(<?=$GAL[PhotoID][$a];?>)" src="<?=$SITE[url];?>/Admin/images/delIcon_new.png" border="0" align="absmiddle" class="button" title="<?=$ADMIN_TRANS['delete'];?>">
				</span>
			</div>
	
			<?
			$GAL[PhotoText][$a]=trim($GAL[PhotoText][$a]);
			?>
			<div class="photoName"><a href="<?=$text_link;?>" target="<?=$target;?>"><?=$GAL[PhotoText][$a];?></a></div>
			</li>
			<?
		}
		?>
		</ul>
		<?
	}
?>

<div class="clear"></div>
<? 
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script type="text/javascript" src="/js/zeroclipboard/ZeroClipboard.js"></script>
	<br />&nbsp;&nbsp;
	<div id="newSaveIcon"  onclick="EditGalleryContent('galleryContentBottom');"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit content under photos'];?></div>
	<div style="height:5px"></div>
	
	<?
}
?>
<div class="clear"></div>
<div id="galleryContentBottom" style="padding-<?=$SITE[align];?>:10px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=str_ireplace("&lsquo;","'",$GAL[GalleryBottomText]);?></div>
<!--end Here comes Gallery Bottom Text-->
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	$ADMIN_TRANS['use width to resize images']='Use photos width to fill gallery area';
	if ($SITE_LANG['selected']=="he") {
		$ADMIN_TRANS['use width to resize images']='השתמש ברוחב תמונות כדי למלא את שטח הגלריה';
	}
	include_once("Admin/colorpicker.php");
	?>
	<div style="display:none;" id="GalPageOptions" class="CatEditor settings_slider"  dir="<?=$SITE[direction];?>">
		<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="EditGalleryOptions(<?=$GAL[GID];?>)">+</div>
			<div class="title"><strong><?=$ADMIN_TRANS['gallery options'];?></strong></div>
		</div>
		<div class="CenterBoxContent">
			<?=GetGalleryPageStyling($urlKey,3,$productUrlKey);?>
			<table cellspacing="3">
				<tr>
					<td><input type="checkbox" id="gallery_width_mode" <?=$isWidthModeChecked;?> ><?=$ADMIN_TRANS['use width to resize images'];?> </td>
				</tr>
				<tr>
					<td><?=$ADMIN_TRANS['photos text bg color'];?>: </td><td><?PickColor("GAL_OPTIONS[photo_text_bg_color]",$GAL_OPTIONS[photo_text_bg_color]);?></td>
				</tr>
				<tr>
					<td>&nbsp;<?=$ADMIN_TRANS['effect gallery bg color'];?>: </td><td><?PickColor("GAL_OPTIONS[gallery_bg_color]",$GAL_OPTIONS[gallery_bg_color]);?></td>
				</tr>
				<tr>
					<td><?=$ADMIN_TRANS['photos text color'];?>: </td><td><?PickColor("GAL_OPTIONS[photo_text_color]",$GAL_OPTIONS[photo_text_color]);?></td>
				</tr>
				<tr>
					<td>&nbsp;<?=$ADMIN_TRANS['effect gallery border'];?>: </td><td><?PickColor("GAL_OPTIONS[gallery_border_color]",$GAL_OPTIONS[gallery_border_color]);?></td>
				</tr>
				<tr>
				<td><?=$ADMIN_TRANS['gallery thumbnails border color'];?>: </td><td><?PickColor("GAL_OPTIONS[tumbs_border_color]",$GAL_OPTIONS[tumbs_border_color]);?></td>
				</tr>
				<tr>
				
				<td colspan=3><br><div class="button" onclick="ShowEmbedCode(this)"><?=$ADMIN_TRANS['embed gallery code'];?></div></td>
				</tr>
			</table>
			<div id="embedGalleryCode">
				
				<?=$ADMIN_TRANS['set embed gallery'];?>:<br>
				<input type="checkbox" onclick="update_embed_code(this)" name="update_border" id="update_border" /><?=$ADMIN_TRANS['with no border'];?> 
				<input type="checkbox" onclick="update_embed_code(this)" name="update_bg" id="update_bg" /><?=$ADMIN_TRANS['with no background'];?> 
				<input type="checkbox" onclick="update_embed_code(this)" name="update_arrow" id="update_arrow" /><?=$ADMIN_TRANS['with no navigation arrows'];?> 
				<br>
				<div id="d_clip_container" style="position:relative;margin-top:5px">
					<div id="d_clip_button" class="my_clip_button"><b id="bef_copy"><?=$ADMIN_TRANS['copy code to clipboard'];?></b><b id="af_copy" style="display:none"><?=$ADMIN_TRANS['copied! now you can paste and embed it in rich text content editor'];?></b></div>
				</div>
				<br/>
				<br>
				<div><?=$ADMIN_TRANS['source html code'];?></div>
					<textarea readonly="readonly" id="embedCode"><?=htmlspecialchars('<iframe allowtransparency="true" border="0" frameborder="0" class="embed_effect_gallery_'.$GalID.'" height="'.$embed_code_height.'" id="iframe_gallery" scrolling="no" src="'.$SITE[url].'/iframe_effectGallery.php?gID='.$GalID.'&noborder=0&nobg=0&noarrows=0" width="100%"></iframe>');?></textarea>
				
			</div>
			</p>
			
	</div>
	<div class="saveButtonsNew">
		<div class="greenSave" id="newSaveIcon"  onclick="SaveGalPageOptions(<?=$GAL[GID];?>)"><img align="absmiddle" src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" /><?=$ADMIN_TRANS['save changes'];?></div>
		<div id="newSaveIcon" class="cancel" onclick="EditGalleryOptions(<?=$GAL[GID];?>)"><?=$ADMIN_TRANS['cancel'];?></div>
	</div>
	</div>
	<div style="width:860px;display:none;z-index:1100;position:absolute;top:150px;" id="PicUploader" class="CatEditor Center CenterBoxWrapper" align="center" dir="<?=$SITE[direction];?>">
		<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="AddNewPic()">+</div>
			<div class="title"><strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong></div>
		</div>
		<div class="CenterBoxContent">
			<div style="float:<?=$SITE[align];?>;width:178px;margin-<?=$SITE[opalign];?>:24px;" id="PhotoPreview"><strong><?=$ADMIN_TRANS['edit photo'];?></strong>
				<div id="photoPreviewDisplay" style="margin-top:8px"></div>
				<div style="margin-top:10px;"></div>
				<div id="newSaveIcon" class="advancedEditorButton" style="display: <?=$showAdvancedEditButton;?>"><i class="fa fa-magic"></i> <?=$ADMIN_TRANS['advanced photo editor'];?></div>
			</div>
			<div style="float:<?=$SITE[align];?>;width:470px;" id="GeneralUploader">
				<form id="GalleryPicUpload" method="post" onsubmit="return false;">
				<div style="float:<?=$SITE[align];?>"><?=$ADMIN_TRANS['browse to upload photo'];?></div>
				<div style="clear:both"></div>
				 <span id="photo_spanButtonPlaceHolder" style="cursor:pointer"></span>&nbsp;&nbsp;
				 <div id="newSaveIcon" class="greenSave" onclick="SaveNewUrl()" style="float:<?=$SITE[opalign];?>;margin-<?=$SITE[opalign];?>:10px;"><i class="fa fa-cloud-upload"></i> <?=$ADMIN_TRANS['upload and save'];?></div>
				<div class="fieldset flash" id="photo_fsUploadProgress"></div>
				<div id="divStatus" dir="ltr"></div>
					
				<div align="<?=$SITE[align];?>"><label><?=$ADMIN_TRANS['photo alt text'];?>:</label><br><textarea id="photo_text" name="photo_text" style="width:98%;font-family:arial" rows="5"/></textarea></div>
			
				<div align="<?=$SITE[align];?>"><label><?=$ADMIN_TRANS['external link'];?>:</label><br><input style="direction:ltr;width:98%;height:20px;border:1px solid silver;" type="text" id="photo_url" name="photo_url"/>
				<div style="color:silver">למשל : http://www.mywebsite.com/?v=3gsj5</div>
				</div>
				<br />
				<div id="newSaveIcon" class="greenSave" onclick="SaveNewUrl()" style="float:<?=$SITE[opalign];?>;margin-<?=$SITE[opalign];?>:10px;"><i class="fa fa-cloud-upload"></i> <?=$ADMIN_TRANS['upload and save'];?></div>
				<div id="newSaveIcon" class="cancel" onclick="AddNewPic()"><?=$ADMIN_TRANS['cancel'];?></div>
				<br>
				<input type="hidden" name="galleryID" value="<?=$GAL[GID];?>">
				</form>
				
				<div id="uploading" dir="ltr" align="center"></div>
				
			</div>
		<div style="clear: both"></div>
		</div>
	</div>
	<div dir="<?=$SITE_LANG[direction];?>" id="lightSideGalTextContainer" style="display:none;z-index:1100;<?=$SITE[opalign];?>:15%;margin-left:auto;width:320px;" class="editorWrapper"></div>
	<div dir="<?=$SITE_LANG[direction];?>" id="lightEditorContainer" style="display:none;z-index:1100;" class="editorWrapper"></div>
	
	
	
	<?
}
if ($C_STYLING['ContentEntranceEffect']!="" AND !isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script src="//d3jy1qiodf2240.cloudfront.net/js/wow.min.js"></script>
	<script>
	new WOW().init();
	jQuery(document).ready(function(){
	jQuery("#galleriapage").addClass("wow <?=$C_STYLING['ContentEntranceEffect'];?>");

	});
	</script>

	<?
}
?>