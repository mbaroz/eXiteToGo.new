<?
if ($iframe_effectGal) $GAL=GetGalleryPhotos($gID);
else $GAL=GetCatGallery($urlKey,3,$productUrlKey);
$GAL_OPT=GetGalleryOptions($urlKey,3,$productUrlKey);
$GAL_STYLE_OPTIONS[gallery_bg_color]=GetGalleryAttribute('gallery_bg_color',$GAL[GID]);
if (!$GAL_STYLE_OPTIONS[gallery_bg_color]) $GAL_STYLE_OPTIONS[gallery_bg_color]="#".$SITE[effectgallerybg];
if (!$GAL_STYLE_OPTIONS[gallery_bg_color]) $GAL_STYLE_OPTIONS[gallery_bg_color]="transparent";
if ($_GET['nobg']) $GAL_STYLE_OPTIONS[gallery_bg_color]="transparent";
$gal_autoplay="true";
if ($GAL_OPT[AutoPlay]==1) $gal_autoplay="false";
$gal_height=$gal_outer_height=480;

if ($GAL_OPT[GalleryTheme]==1) {
        $gal_outer_height=$gal_height+100;
}
?>
<script class="rs-file" src="/js/royalslider/jquery.royalslider.min.js"></script>
<link class="rs-file" href="/js/royalslider/royalslider.css" rel="stylesheet">
<link class="rs-file" href="/js/royalslider/rs-minimal-white.css" rel="stylesheet">
    
<style>
            .ui-content {padding:0}
                /* Swipe 2 required styles */
    #full-width-slider {
            width: 100%;
            color: #000;
            text-align: center;
           
}
.rsMinW, .rsMinW .rsOverflow, .rsMinW .rsSlide, .rsMinW .rsVideoFrameHolder, .rsMinW .rsThumbs {background: <?=$GAL_STYLE_OPTIONS[gallery_bg_color];?>}
.visibleNearby {
  width: 100%;
  background: <?=$GAL_STYLE_OPTIONS[gallery_bg_color];?>;
  color: #FFF;
  padding-top: 10px;padding-bottom:10px;
}
.visibleNearby .rsGCaption {
  font-size: 16px;
  line-height: 18px;
  padding: 16px 0 16px;
  background: <?=$GAL_STYLE_OPTIONS[gallery_bg_color];?>;
  width: 100%;
  position: static;
  float: left;
  left: auto;
  bottom: auto;
  text-align: center;
}
.visibleNearby .rsGCaption span {
  display: block;
  clear: both;
  color: #bbb;
  font-size: 14px;
  line-height: 22px;
}


/* Scaling transforms */
.visibleNearby .rsSlide img {
  opacity: 0.45;
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;

  -webkit-transform: scale(0.9);  
  -moz-transform: scale(0.9); 
  -ms-transform: scale(0.9);
  -o-transform: scale(0.9);
  transform: scale(0.9);
}
.visibleNearby .rsActiveSlide img {
  opacity: 1;
  -webkit-transform: scale(1);  
  -moz-transform: scale(1); 
  -ms-transform: scale(1);
  -o-transform: scale(1);
  transform: scale(1);
}
.coloredBlock {
  padding: 12px;
  background: <?=$GAL_STYLE_OPTIONS[gallery_bg_color];?>;
  color: #FFF;
   width: 200px;
   left: 20%;
   top: 5%;
}
.infoBlock {
  position: absolute;
  top: 30px;
  right: 30px;
  left: auto;
  max-width: 25%;
  padding-bottom: 0;
  
  background: transparent;
  overflow: hidden;
  padding: 20px;
}
.infoBlockLeftBlack {
  color: #FFF;
  background: <?=$GAL_STYLE_OPTIONS[gallery_bg_color];?>;
  left: 30px;
  right: auto;
}
.infoBlock h4 {
  font-size: 20px;
  line-height: 1.2;
  margin: 0;
  padding-bottom: 3px;
}
.infoBlock p {
  font-size: 14px;
  margin: 4px 0 0;
}
.infoBlock a {
  color: #FFF;
  text-decoration: underline;
}
.photosBy {
  position: absolute;
  line-height: 24px;
  font-size: 12px;
  background: transparent;
  color: #000;
  padding: 0px 10px;
  position: absolute;
  left: 12px;
  bottom: 12px;
  top: auto;
  border-radius: 2px;
  z-index: 25; 
} 
.photosBy a {
  color: #000;
}
.fullWidth {
  max-width: 1400px;
  margin: 0 auto 24px;
}

@media screen and (min-width:960px) and (min-height:660px) {
  .heroSlider .rsOverflow,
  .royalSlider.heroSlider {
      height: 520px !important;
  }
}

@media screen and (min-width:960px) and (min-height:1000px) {
    .heroSlider .rsOverflow,
    .royalSlider.heroSlider {
        height: 660px !important;
    }
}
@media screen and (min-width: 0px) and (max-width: 800px) {
  .royalSlider.heroSlider,
  .royalSlider.heroSlider .rsOverflow {
    height: 300px !important;
  }
  .infoBlock {
    padding: 10px;
    height: auto;
    max-height: 100%;
    min-width: 40%;
    left: 5px;
    top: 5px;
    right: auto;
    font-size: 12px;
  }
  .infoBlock h3 {
     font-size: 14px;
     line-height: 17px;
  }
}
#full-width-slider {display: none};
</style>
<?
if (!$iframe_effectGal) {
        if ($GAL[GalleryName]!="") {
                    ?>
                    <span class="titleContent"><h1 style="margin-top:0px;margin-bottom:0px;padding-<?=$SITE[align];?>:10px;" id="galleryTitle-<?=$GAL[GID];?>"><?=$GAL[GalleryName];?></span></h1><?
                        }
        ?>
        <div id="galleryContent" style="padding-<?=$SITE[align];?>:10px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=str_ireplace("&lsquo;","'",$GAL[GalleryText]);?></div>
       <br>
        <?
}
?>
<div id="full-width-slider" class="royalSlider rsMinW visibleNearby">
 <?
 $controlNav="bullets";
 if (count($GAL[PhotoID])>15) $controlNav='none';
    for ($a=0;$a<count($GAL[PhotoID]);$a++) {
        $GalPagePic=$GAL[FileName][$a];
    		$GalPicText=$GAL[PhotoText][$a];
    		$galPhotoTarget="_self";
    		$link_str=$img_link="";
    		if ($GAL[PhotoUrl][$a]) $img_link=urldecode($GAL[PhotoUrl][$a]);
    		?>
                <div class="rsContent">
                    <?
                    if ($img_link) {
                        ?>
                        <a href="<?=$img_link;?>">
                        <?
                    }
                    ?>
                        <img class="rsImg" src="<?=SITE_MEDIA.'/gallery/'.$GalPagePic;?>" />
                    <?if ($img_link) print '</a>';?>
                    <figure class="rsCaption"><?=$GalPicText;?></figure>
                </div>
                <?
                
            }
            ?>
    </div>
<?
if (!$iframe_effectGal) {
        ?>
        <div id="galleryContentBottom" style="padding-<?=$SITE[align];?>:10px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=str_ireplace("&lsquo;","'",$GAL[GallerySideText]);?></div>
        <div id="galleryContentBottom" style="padding-<?=$SITE[align];?>:10px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=str_ireplace("&lsquo;","'",$GAL[GalleryBottomText]);?></div>
        <?
}
?>

<script>
    function setSlider() {
          jQuery('#full-width-slider').royalSlider({
            arrowsNav: true,
            loop: false,
            addActiveClass: true,
            fadeinLoadedSlide: false,
            keyboardNavEnabled: true,
            controlsInside: false,
            imageScaleMode: 'fit-if-smaller',
            arrowsNavAutoHide: false,
            autoScaleSlider: true,     controlNavigation: 'bullets',
            thumbsFitInViewport: false,
            navigateByClick: true,
            startSlideId: 0,
            autoPlay: {enabled:<?=$gal_autoplay;?>},
            transitionType:'move',
            globalCaption: false,
            autoScaleSliderHeight :500,
            controlNavigation:'<?=$controlNav;?>',
            deeplinking: {
              enabled: false,
              change: false,
            },
            visibleNearby: {
              enabled: true,
              centerArea: 1,
              center: true,
              breakpoint: 650,
              breakpointCenterArea: 1,
              navigateByCenterClick: true
            }
          });
    }
jQuery(document).ready(function($) {
    setSlider();
        jQuery("#full-width-slider").show();
});
</script>
<style>
        #full-width-slider {
              
                opacity: 1;
        }
</style>