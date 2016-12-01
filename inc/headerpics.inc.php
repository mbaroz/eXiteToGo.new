<?
//include_once("./language.inc.php");
function SetPagePic($urlKey) {
	global $LOGGED;
	global $LABEL;
	global $SITE;
	global $SITE_LANG;
	global $gallery_dir;
	global $video_gallery_dir;
	global $ADMIN_TRANS;
	global $MEMBER;
	global $CHECK_PAGE;
	$urlKey=str_ireplace("/","",$urlKey);
	if ($CHECK_PAGE) {
		$PageCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
		if ($CHECK_PAGE[ProductID]) $PageCatUrlKey=GetCatUrlKeyFromCatID($CHECK_PAGE[parentID]);
			elseif ($CHECK_PAGE[productUrlKey]) $PageCatUrlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
		$urlKey=$PageCatUrlKey;
	}

	$db=new Database();
	if ($CHECK_PAGE[ProductID]) {
		$db->query("SELECT HeaderPhotoName FROM products WHERE ProductID='{$CHECK_PAGE[ProductID]}' AND HeaderPhotoName!=''");
		if ($db->nextRecord()) $ProductPagePic=$db->getField("HeaderPhotoName");
	}
	$HomePagePic=$SITE[homepic];
	if ($HomePagePic=="") $HomePagePic="pixel.png"; //Set to default homepagepic
	$tempUrlKey=$urlKey;
	$sql="SELECT * from categories WHERE UrlKey='$urlKey'";
	$db->query($sql);
	$db->nextRecord();

	$PagePic=$db->getField("PhotoName");
	if ($ProductPagePic!="") $PagePic=$ProductPagePic;
	//if ($PagePic=="") $PagePic=$SITE[homepic];
	$PicSize=strtolower($db->getField("PhotoSize"));
	$TmpMainPicHeight=strtolower($db->getField("MainPicHeight"));
	$TMP_CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
	if ($ProductPagePic=="") {
		$tmp_picPositsion=explode(":", $TMP_CAT_STYLE["mainPicPosition"]);
		$tmp_picMaxHeight=$TMP_CAT_STYLE["mainPicMaxHeight"];
	}

	$parentID=1;
	$PicText=$db->getField("PhotoAltText");
	while ($PagePic=="" AND $parentID!=0) {
		$parURL_KEY=GetParentUrlKey($tempUrlKey);
		$parent_url_key=$parURL_KEY[ParentUrlKey];
		$sql="SELECT * from categories WHERE UrlKey='$parent_url_key'";
		$db->query($sql);
		$db->nextRecord();
		$parentID=$parURL_KEY[ParentID];
		$tempUrlKey=$parent_url_key;
		$PagePic=$db->getField("PhotoName");
		//$PicText=$db->getField("PhotoAltText");
		$MainPicHeight=strtolower($db->getField("MainPicHeight"));
		$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
		if ($CAT_STYLE["mainPicPosition"]!="" AND $tmp_picPositsion[0]=="") $picPositsion=explode(":", $CAT_STYLE["mainPicPosition"]);

		if ($CAT_STYLE["mainPicMaxHeight"]!="" AND $tmp_picMaxHeight=="") $mainPicMaxHeight=$CAT_STYLE["mainPicMaxHeight"]; 
	}
	
	if ($picPositsion[0]=="") $picPositsion=$tmp_picPositsion;
	if ($mainPicMaxHeight=="") $mainPicMaxHeight=$tmp_picMaxHeight;
	$mainPicPositionX=$picPositsion[0];
	$mainPicPositionY=$picPositsion[1];
	
	if ($MainPicHeight==0) $MainPicHeight=$TmpMainPicHeight;

	if ($PagePic=="" && $SITE[innerpagesheaderpic]=="") {
		$PagePic=$HomePagePic;
		$db->query("SELECT MainPicHeight,CatStylingOptions from categories WHERE UrlKey='home'");
		$db->nextRecord();
		$MainPicHeight=$db->getField("MainPicHeight");
		if ($mainPicMaxHeight=="") {
			$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
			$mainPicMaxHeight=$CAT_STYLE["mainPicMaxHeight"];
		}
	}
	else {
		if ($PagePic=="") {
			$PagePic= $SITE[innerpagesheaderpic];
			$MainPicHeight=$SITE[innerpagesmainpicheight];
		}
		
	}
	if ($urlKey=="home" AND $HomePagePic) {
		$PagePic=$HomePagePic;
		$MainPicHeight=$TmpMainPicHeight;
	}
	
	if ($PicText=="") $PicText=$urlKey;
	$P_CHECK=explode(".",$PagePic);
	$PagePic_ext=$P_CHECK[1];
	$event_handler="";
	$className="staticHeadPic";
	$PicText=htmlspecialchars(html_entity_decode($PicText));
	
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		$ADMIN_TRANS_LABEL['moveimage']['en']=$ADMIN_TRANS_LABEL['moveimage']['de']="Align Image";
		$ADMIN_TRANS_LABEL['moveimage']['he']="הזז מיקום תמונה";
		$ADMIN_TRANS_LABEL['changeareaheight']['en']=$ADMIN_TRANS_LABEL['changeareaheight']['de']="Resize height area";
		$ADMIN_TRANS_LABEL['changeareaheight']['he']="שנה גובה אזור התמונה";
//		do some work for admin
		$wideSliderClass="";
		if ($SITE[mainpicwidth]==2000) $wideSliderClass="widerSlider";
		$admin_upload_button_height_css="";
		//if ($MainPicHeight<30 AND !$MainPicHeight=="") $admin_upload_button_height_css='bottom:0;top:0;margin-bottom:30px';
		$event_handler='<div style="'.$admin_upload_button_height_css.'" class="mainPicStaticAdminControl '.$wideSliderClass.'">
		<div id="newSaveIcon" class="mainPicEditDD" style="position:absolute;">
			<i class="fa fa-angle-down"></i> | '.$ADMIN_TRANS['edit photo'].'
		</div>
		<div id="newSaveIcon" class="greenSave" style="position:absolute;">
			<i class="fa fa-check"></i> | '.$ADMIN_TRANS['save'].'
		</div>
		<div class="newSaveIcon" style="display:none;height:auto;margin-top:34px" id="editMainPhoto">
				<div class="photoEditDropDown" onclick=showUploadTools("pagepic",event)><i class="fa fa-edit"></i> '.$ADMIN_TRANS['edit photo'].'</div>
				<div class="photoEditDropDown" onclick=showMainPicGalleryUploadTools("mainpicgallery",event)><i class="fa fa-picture-o"></i> '.$ADMIN_TRANS['switch to slides'].'</div>
				';
				if ($SITE[mainpicwidth]!=2000) $event_handler.='
				<div class="photoEditDropDown moveLocation"><i class="fa fa-arrows"></i> '.$ADMIN_TRANS_LABEL[moveimage][$SITE_LANG[selected]].'</div>
				<div class="photoEditDropDown ResizeHeight"> &nbsp;<i class="fa fa-arrows-v"></i>&nbsp; '.$ADMIN_TRANS_LABEL[changeareaheight][$SITE_LANG[selected]].'</div>
				';
		$event_handler.='<div class="photoEditDropDown" style="color:red" onclick="QuickDelPagePic()"><i class="fa fa-trash-o"></i> '.$ADMIN_TRANS['delete photo'].'</div>';
		$event_handler.='</div>
		
		</div>';
		//$event_handler.='<style>.topMainPic {position:relative}</style>';

		$className="pagePic";
	}
	$pagePicSource=SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$PagePic;
	if ($PagePic=="pixel.png") $pagePicSource=$SITE[cdn_url]."/images/".$PagePic;
	$PagePicCode=$event_handler.'<div class="resizeWrapper"><img class="'.$className.'" src="'.$pagePicSource.'" border="0" title="'.$PicText.'" id="staticHeadPic" /></div>';
	$file_extension=end(explode(".", $pagePicSource));
	if ($file_extension=="mp4") $PagePicCode=$event_handler.'<div class="resizeWrapper"><video autoplay loop class="fillWidth" style="max-width:100%"><source src="'.$pagePicSource.'" type="video/mp4" /></video></div>';
	if (strtolower($PagePic_ext)=="swf") {
		if ($PicSize=="") {
			$db->query("SELECT * from categories WHERE UrlKey='home'");
			$db->nextRecord();
			$PicSize=strtolower($db->getField("PhotoSize"));
		}
		$flashW=$SITE[mainpicwidth];
		$flashH=350;
		
		$PicSize=str_ireplace(" ","",$PicSize);
		$PIC_SIZE=explode("x",$PicSize);
		if ($PIC_SIZE[0]>0 AND $PIC_SIZE[0]<$flashW) $flashW=$PIC_SIZE[0];
		if ($PIC_SIZE[1]>0) $flashH=$PIC_SIZE[1];
		
//		swfobjectcodehere
		$PagePicCode='
		<script language="javascript">
		var swfparams={
			  menu: "false",
			  wmode: "transparent"
			};
		swfobject.embedSWF("'.SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$PagePic.'", "flashMainPic", "'.$flashW.'", "'.$flashH.'","9.0.0","expressInstall.swf", "",swfparams);
		</script>
		<div style="display:inline;padding:0" id="flashMainPic">'.$PicText.'</div>
		'.$event_handler;
	}
	
	if ($SITE[mainpicwidth]==2000) {
		?>
		<style>
			img.staticHeadPic, img.pagePic {max-width:100%;}
			.topMainPic video {width:100%;}
		</style>
		<script>
			
			var stageWidth=jQuery(window).width();
			var leftOffset=-(2000-stageWidth)/2;
			var staticImgSrc="<?=SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$PagePic;?>";
			myImge = jQuery("<img />").attr("src",staticImgSrc+ "?" + new Date().getTime());
			
			jQuery(document).ready(function() {
				//jQuery("#staticHeadPic").css("position","relative");
				//jQuery("#staticHeadPic").css("<?=$SITE[align];?>",leftOffset);
				
			});
			
		</script>
		<?
	}
	else {
		
		if ($mainPicPositionX!=0) {
			?>
			<style type="text/css">img#staticHeadPic{left:<?=$mainPicPositionX;?>px;position: relative;}</style>
			<?
		}
		if ($mainPicMaxHeight!="") {
			?>
			<style type="text/css">.topMainPic .resizeWrapper{height:<?=$mainPicMaxHeight;?>px;}</style>
			<?
		}
	}
	if (($SITE[maingallerybehind]==1 AND $urlKey=="home") OR ($SITE[maingallerybehind]==2)) {
		$marginizer_height=$MainPicHeight-95;
		if (($SITE[topmenubottom]==3 OR $SITE[topmenubottom]==4) AND $SITE[topmenumargin]) $marginizer_height=$MainPicHeight-92-$SITE[topmenumargin]+15;
		
		?>
		<div id="marginizer" style="margin-top: 0px;"></div>
		<script>
		//	var staticImgSrc="<?=SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$PagePic;?>";
		//	myImge = jQuery("<img />")
		//		.attr("src",staticImgSrc+ "?" + new Date().getTime());
			
			jQuery(".topMainPic").css({"position":"absolute","top":"0"});
			//jQuery("#marginizer").css('margin-top',jQuery('img#staticHeadPic').height()-75+"px");
			
		//	jQuery(myImge).load(function() {
		//			var topHeight="<?=$MainPicHeight;?>-100";
		//			jQuery('#marginizer').css("margin-top",topHeight+"px");
		jQuery(document).ready(function() {
			<?
			if (isset($_SESSION['LOGGED_ADMIN'])) {
				?>
				var topOffset=jQuery(".AdminTopNew").height();

				jQuery(".topMainPic, .mainPicStaticAdminControl").css("top",topOffset+"px");
				<?
			}
			
			if ($SITE[topmenubottom]==1) {
				?>
				jQuery(".topMenuNew").prepend(jQuery('#marginizer'));
				<?
			}
			else {
			?>
					if (jQuery(".middleContent").length) {
						//jQuery("#marginizer").css("margin-top","<?=$marginizer_height;?>px");
						jQuery(".middleContent").prepend(jQuery('#marginizer'));
					}
						else jQuery(".mainContentContainer").prepend(jQuery('#marginizer'));
			<?
				}
			?>
			
			});
			var mainPicHeight=<?=$MainPicHeight;?>;
			topMarginMainPic=(mainPicHeight/2000*jQuery(window).width());
			jQuery("#marginizer").css('margin-top',(topMarginMainPic-75)+"px");
			
			jQuery(window).resize(function() {jQuery("#marginizer").css('margin-top',jQuery('img#staticHeadPic').height()-75+"px");});
		 </script>
		<style>.topMenuNew, .topHeader, .topHeaderFull{position:relative;z-index: 101;}.topMainPic{padding-top:0px}</style>
		
		<?
	}
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<link rel="stylesheet" href="<?=$SITE[cdn_url];?>/css/jquery-ui.1.11.2.css">
		<script>
		var xMainPicStatic=0,yMainPicStatic=0;
		jQuery(".site_overbg").hover(function(){jQuery(".mainPicStaticAdminControl").show();});
		function QuickDelPagePic() {
			uploadType="pagepic";
			DelSitePhoto();
		}
		function syncBox(c) {
			jQuery('.topMainPic').height(c.h+'px');
		}
		function saveMainPhotoCustomHeight() {
			var savedHeight=jQuery(".resizeWrapper").height();
			console.log(savedHeight);
			if (catParentID>0)  setCatStyleProperty(catParentID,savedHeight,"mainPicMaxHeight");
		}
		function saveMainPhotoPosition() {
			jQuery(".mainPicStaticAdminControl #editMainPhoto").toggle();
			jQuery(".mainPicStaticAdminControl #newSaveIcon").toggleClass("show");

			if (catParentID>0)  setCatStyleProperty(catParentID,xMainPicStatic+":"+yMainPicStatic,"mainPicPosition");
		}
		function startResizeChange() {
			jQuery(".mainPicStaticAdminControl #editMainPhoto").toggle();
			//jQuery("img#staticHeadPic").wrap("<div class='resizeWrapper'>");
			jQuery(".topMainPic").append('<div class="dragger"></div>');
			jQuery(".topMainPic .resizeWrapper").addClass("adminMode");

			jQuery(".resizeWrapper").resizable({
		      
		      maxWidth: 930,
		     handles: "s",
		     maxHeight:<?=$MainPicHeight ? $MainPicHeight : '800';?>,
		     stop:function() {saveMainPhotoCustomHeight();}
		      
		    });

		}
		function startHeightChange(s,w) {
			if (s==1) {
				var mainPHeight=<?=$MainPicHeight ? $MainPicHeight : '800';?>;
				jQuery(".mainPicStaticAdminControl #newSaveIcon").toggleClass("show");
				jQuery(".mainPicStaticAdminControl #editMainPhoto").toggle();
				//console.log(w);
				//jQuery("img#staticHeadPic").css("left","50%");
				jQuery("img#staticHeadPic").css("cursor","move");
				jQuery("img#staticHeadPic").draggable({
					cursor:'move',
					drag: function( event, ui ) {
						//if (jQuery("#staticHeadPic").css('left')<=<?=$SITE[mainpicwidth];?>-)
                		//console.log("x:"+jQuery("#staticHeadPic").css('left')+"y:"+jQuery("#staticHeadPic").css('top'));
                		
                		if (ui.position.left>=(w-<?=$SITE[mainpicwidth];?>)) ui.position.left=(w-<?=$SITE[mainpicwidth];?>);
                		if (ui.position.left<=0) ui.position.left=0;
                		if (ui.position.top>=(mainPHeight-jQuery(".topMainPic").height())) ui.position.top=(mainPHeight-jQuery(".topMainPic").height());
                		if (ui.position.top<=0) ui.position.top=0;
                		xMainPicStatic=ui.position.left;
                		yMainPicStatic=ui.position.top;
            		}
				});

			}
			else {
				//jCropAPI.disable();
			}

			
		}
		jQuery(document).ready(function() {
			jQuery(".mainPicStaticAdminControl #newSaveIcon.mainPicEditDD").click(function() {jQuery(".mainPicStaticAdminControl #editMainPhoto").toggle();});
			jQuery(".mainPicStaticAdminControl #newSaveIcon.greenSave").click(function() {saveMainPhotoPosition();});
			jQuery(".mainPicStaticAdminControl .moveLocation").click(function(){startHeightChange(1,jQuery("#staticHeadPic").width());});
			jQuery(".mainPicStaticAdminControl .ResizeHeight").click(function(){startResizeChange();});
			
		});
		
		</script>
		
		<?

	}
	return $PagePicCode;
	
}
function GetImgDimentions($img) {
	list($width, $height, $type, $attr) = getimagesize($img);
	$I[w]=$width;
	$I[h]=$height;
	return $I;
}
function SetLogo($isTopMenuHidden=0,$showLogoOnLanding=0) {
	global $LOGGED;
	global $LABEL;
	global $SITE;
	global $gallery_dir;
	global $ADMIN_TRANS;
	global $MEMBER;
	$db=new Database();
	$LogoFile=$SITE[logo];
	if ($LogoFile=="") $LogoFile="default_logo.jpg"; //Set to default homepagepic
	
	
	$event_handler="";
	$className="";
	if (isset($_SESSION['LOGGED_ADMIN'])) {
//		do some work for admin
		$event_handler='<div class="elEditorButton"><div id="newSaveIcon" onclick=showUploadTools("logo",event)><img src="'.$SITE[url].'/Admin/images/editIcon.png" align="absmiddle" border="0">'.$ADMIN_TRANS['edit logo'].'</div></div>';
		$className="logoPic";
	}
	$LogoPicCode=$defLogoPicCode='<a href="'.$SITE[url].'"><img class="'.$className.'" src="'.SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$LogoFile.'" border="0" title="'.$SITE[logotext].'" alt="'.$SITE[logotext].'" /></a>'.$event_handler;
	$CHK_LOGO=explode(".",$SITE[logo]);
	if (!strtolower($CHK_LOGO[1])=="jpg" AND !strtolower($CHK_LOGO[1])=="png") {
			$LogoPicCode=$defLogoPicCode='<a href="'.$SITE[url].'"><div class="text_logo_insite">'.$SITE['logo'].'</div></a><style>.topHeaderSlogen{width:auto}</style>'.$event_handler;

		}

	if ($isTopMenuHidden==1 AND ($showLogoOnLanding=="true") AND (strtolower($CHK_LOGO[1])=="jpg" OR strtolower($CHK_LOGO[1])=="png")) {
		//$i=GetImgDimentions($gallery_dir."/sitepics/".$LogoFile);
		$LogoPicCode=$defLogoPicCode;
	}
	if ($isTopMenuHidden==1 AND ($showLogoOnLanding=="false" OR $showLogoOnLanding=="")) $LogoPicCode="";
	return $LogoPicCode;
	
}
function SetGalleryPagePics($urlKey) {
	global $SITE;
	global $gallery_dir;
	global $ADMIN_TRANS;
	global $MEMBER;
	global $SITE_LANG;
	$GAL_OPT=GetGalleryOptions($urlKey,4);
	$GAL=GetCatGallery($urlKey,4);
	
	$gal_theme="galleria.dots.js";
	$GalleryWidth=$SITE[mainpicwidth];
	
	$slides_def_effect="slide";
	if ($GAL_OPT[GalleryEffect]<16) $slides_def_effect="fade"; 
	$GAL_SLIDES_EASE=array(16=>"easeOutBounce",17=>"easeInBounce",18=>"easeInOutBounce",19=>"easeOutBack",20=>"easeInBack",21=>"easeOutElastic",22=>"easeInElastic",23=>"easeOutExpo");
	$GAL_PIX_DIAPO_EFFECTS=array('random','scrollHorz','scrollTop','scrollBottom','scrollLeft','scrollRight','simpleFade', 'curtainTopLeft', 'curtainTopRight', 'curtainBottomLeft', 'curtainBottomRight', 'curtainSliceLeft', 'curtainSliceRight', 'blindCurtainTopLeft', 'blindCurtainTopRight', 'blindCurtainBottomLeft', 'blindCurtainBottomRight', 'blindCurtainSliceBottom', 'blindCurtainSliceTop', 'stampede', 'mosaic', 'mosaicReverse', 'mosaicRandom', 'mosaicSpiral', 'mosaicSpiralReverse', 'topLeftBottomRight', 'bottomRightTopLeft', 'bottomLeftTopRight', 'bottomLeftTopRight');
	
	$gal_container_css="";
	$cropMode="width";
	if ($GalleryWidth==2000) {
		$gal_container_css='style="width:100%;"';
		$cropMode="height";
		
	}
	if ($SITE[mainpiccustomwidth]) $GalleryWidth=$SITE[mainpiccustomwidth];
	if ($GAL_OPT[GalleryEffect]==0) $gal_effect="slide";
	if ($GAL_OPT[GalleryEffect]==1) $gal_effect="fade";
	if ($GAL_OPT[GalleryEffect]==2) $gal_effect="flash";
	if ($GAL_OPT[GalleryEffect]==3) $gal_effect="fadeslide";
	if ($GAL_OPT[GalleryEffect]==4) $gal_effect="sliceUp";
	if ($GAL_OPT[GalleryEffect]==5) $gal_effect="sliceDown";
	if ($GAL_OPT[GalleryEffect]==6) $gal_effect="sliceUpDown";
	if ($GAL_OPT[GalleryEffect]==7) $gal_effect="fade";
	if ($GAL_OPT[GalleryEffect]==8) $gal_effect="fold";
	if ($GAL_OPT[GalleryEffect]==9) $gal_effect="random";
	if ($GAL_OPT[GalleryEffect]==10) $gal_effect="boxRain";
	if ($GAL_OPT[GalleryEffect]==11) $gal_effect="boxRainGrow";
	if ($GAL_OPT[GalleryEffect]==12) $gal_effect="boxRandom";
	if ($GAL_OPT[GalleryEffect]==13) $gal_effect="blast";
	if ($GAL_OPT[GalleryEffect]==14) $gal_effect="kenburns";
	if ($GAL_OPT[GalleryEffect]=="") $GAL_OPT[GalleryEffect]=53;
	if ($GAL_OPT[GalleryTheme]==0) {
		$gal_theme="galleria.dots.js";
		$gal_css="galleria.dots.css";
	}
	if ($GAL_OPT[GalleryTheme]==1) {
		$gal_theme="galleria.classic.js";
		$gal_css="galleria.classic.css";
		?>
		<style>
		.galleria-thumbnails .galleria-image {border:2px solid #<?=$SITE[thumbsbordercolor];?>;}
		.galleria-thumb-nav-left, .galleria-thumb-nav-right {background-color:#<?=$SITE[thumbsbordercolor];?>;}
		.galleria-thumbnails-container {display: none;}
		</style>
		<?
	}
	$showArrowNav="";
	if ($SITE[mainpicwidth]==2000 OR ($GAL_OPT[GalleryEffect]>14 AND ieversion()==7)) $showArrowNav="none";
		
	if ($GAL_OPT[AutoPlay]==1) $gal_autoplay="false";
	else $gal_autoplay="true";
	$gal_slide_speed=$GAL_OPT[SlideSpeed];
	if ($GAL_OPT[SlideSpeed]<20) $gal_slide_speed="400";
	$gal_height=$GAL_OPT[GalleryHeight];
	if ($gal_height==0) $gal_height=240;
	if ($GAL_OPT[SlideDelay]>1 AND  $gal_autoplay=="true") $gal_autoplay=$GAL_OPT[SlideDelay];
	
	?>
	 <style>
                    .nivo-html-caption {
                        position:absolute;
                        top:0;
                        direction:rtl;
                        
                    }
		    
                    
	            #galleria{
		   margin:0px auto 3px auto;
		   direction:ltr;
	                text-align:center;
	                width:<?=$GalleryWidth;?>px;
			
	                z-index:0;
	               }
	           #galleria .galleria-info {direction:<?=$SITE_LANG[direction];?>;<?=$SITE[align];?>:0}
		  .pix_diapo {width:<?=$GalleryWidth;?>px;}
		  
	  
	            
        </style> 
	 <?
	 $event_handler_extra_css="position:relative;margin-bottom:-25px;";
	 $globalCDN=$SITE[url];
	if ($GAL_OPT[GalleryEffect]>3) {
		
		$effectCSS="nivo-slider.css";
		$effectJS="jquery.nivo.slider.pack.js";
		if ($GAL_OPT[GalleryEffect]>12) {
			$effectCSS="wowslider.css";
			$effectJS="wowslider.js";
			?>
			<style>
			.topMainPic, .topMainPicCustom {height:<?=$gal_height;?>px;}
			.slides_container a {width:<?=$GalleryWidth;?>px;}
			</style>
			<?
			if ($GAL_OPT[GalleryEffect]>14) {
				$effectCSS="slides.global.css";
				$effectJS="slides.min.jquery.js";
				$event_handler_extra_css="";
			}
			if ($GAL_OPT[GalleryEffect]>23) {
				$effectCSS="diapo.css";
				$effectJS="diapo.js";
				$gal_container_css.='class="pix_diapo" align="center"';
				$selected_easing=GetGalleryAttribute("easingEffect",$GAL_OPT[GalleryID]);
				if ($selected_easing=="") $selected_easing='easeInOutExpo';
				$event_handler_extra_css="position:relative;";
			}
			if ($GAL_OPT[GalleryEffect]>52 AND $GAL_OPT[GalleryEffect]<55) {
				$effectCSS="ls/layerslider.css";
				$effectJS="ls/layerslider.kreaturamedia.jquery.js";
				$hideTumbs=GetGalleryAttribute("HideTumbs",$GAL_OPT[GalleryID]);
				$EXISTS_EFFECTS_STR=explode("-",GetGalleryAttribute("ExtraEffects",$GAL_OPT[GalleryID]));
				$EXIST_EFFECTS_2D=explode("2d:", $EXISTS_EFFECTS_STR[0]);
				$EXIST_2D_EFFECTS_STR=$EXIST_EFFECTS_2D[1];
				$EXIST_2D_EFFECTS_STR=str_ireplace("|", ",", $EXIST_2D_EFFECTS_STR);
				$EXIST_EFFECTS_3D=explode("3d:", $EXISTS_EFFECTS_STR[1]);
				$EXIST_3D_EFFECTS_STR=str_ireplace("|", ",", $EXIST_EFFECTS_3D[1]);
				$globalCDN="//secure.exite.co.il";
				$globalCDN="http://cdn.exiteme.com";
				?>
				<script src="<?=$globalCDN;?>/js/gallery/slider/ls/greensock.js" type="text/javascript"></script>
				<script src="<?=$globalCDN;?>/js/gallery/slider/ls/layerslider.transitions.js" type="text/javascript"></script>
				<style>.topMainPic, .topMainPicCustom {height:<?=($gal_height+2);?>px;}</style>
				<?
			}
			if ($GAL_OPT[GalleryEffect]>54) {
				$effectCSS="background/supersized.css";
				$effectJS="background/supersized.3.2.7.min.js";
				$globalCDN="//secure.exite.co.il";
				$gal_height=1;
				if (isset($_SESSION['LOGGED_ADMIN'])) $gal_height=20;
				?>
				<link rel="stylesheet" href="<?=$globalCDN;?>/js/gallery/slider/background/theme/supersized.shutter.css" type="text/css" media="screen" />
				<style>.topMainPic {height:inherit}</style>
				<?
			}
		}
		
		?>
		
		<link rel="stylesheet" href="<?=$globalCDN;?>/js/gallery/slider/<?=$effectCSS;?>" type="text/css" media="screen" />
		
		<script src="<?=$SITE[url];?>/js/gallery/slider/jquery.easing.1.3.js"></script>
		<script src="<?=$globalCDN;?>/js/gallery/slider/<?=$effectJS;?>"></script>
		<?
		if ($GAL_OPT[GalleryEffect]>54) {
			?><script src="<?=$globalCDN;?>/js/gallery/slider/background/theme/supersized.shutter.min.js" type="text/javascript"></script>
			<?
		}
		?>
		
		<style>
			#galleria, .slides_container a {height:<?=$gal_height;?>px;}
			#galleria .ws_images{ width:<?=$GalleryWidth;?>px;height:<?=$gal_height;?>px}
			#galleria a.ws_next, #galleria a.ws_prev{background-image: url(<?=$SITE[url];?>/js/gallery/slider/wowslider_images/arrows.png);}
			<?
			if (ieversion()==7 AND $GAL_OPT[GalleryEffect]>14) {
				?>
				#galleria {position:relative}
				<?
			}
			?>
		</style>
		<?
		if ($GAL_OPT[GalleryEffect]<12 AND $GAL_OPT[GalleryEffect]>3 AND $GAL_OPT[GalleryHeight]==0) {
			?>
			<style>#galleria.nivoSlider{height: auto}	</style>
			<?
		}
		if ($GAL_OPT[GalleryEffect]>52 AND $SITE['3deffectbgcolor']) {
			?><style>#galleria .ls-3d-box div{background: #<?=$SITE['3deffectbgcolor'];?>;}</style><?
		}
		if ($GAL_OPT[GalleryEffect]>52 AND $GAL_OPT[GalleryEffect]<55 AND $GalleryWidth==2000) {
			?>
			<style>.topMainPic {height: inherit;}</style>
			<?
			$gal_container_css='style="width:100%;height:'.$gal_height.'px"';
		}
		if ($GAL_OPT[GalleryEffect]>52 AND $GAL_OPT[GalleryEffect]<55 AND $SITE[topmenubottom]==1) {
			?><style>.topMainPic {margin-bottom:3px;}</style><?
		}
		
	}
	else {
		?>
		<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/gallery/slider/<?=$gal_css;?>">
		<script src="<?=$SITE[url];?>/js/gallery/slider/galleria.js"></script>
		<?
	}
	?>
	<style>
		 #galleria .galleria-image-nav, #galleria .prev, #galleria .next{display:<?=$showArrowNav;?>}
		 #galleria .video_overlay_exite {position:absolute;height:100%;width:100%;background:rgba(0,0,0,0.5);}
		 #galleria .ls-l.ls-video-layer {width:100% !important;left:0px !important;}
		 #galleria .ls-l > * {direction: <?=$SITE_LANG[direction];?>;}
		 #galleria .ls-l {width:100% !important;box-sizing:border-box;padding:10px;}
		 #galleria .ls-l {white-space: normal!important}
	</style>
	<?
	$event_handler="";
	if (isset($_SESSION['LOGGED_ADMIN'])) {
//		do some work for admin
		$wideSliderClass="";
		if ($GalleryWidth==2000) $wideSliderClass="widerSlider";
		$event_handler='<div class="mainPicStaticAdminControl slider '.$wideSliderClass.'">
		<div id="newSaveIcon" class="mainPicEditDD" style="position:absolute;">
			<i class="fa fa-angle-down"></i> | '.$ADMIN_TRANS['gallery options'].'
		</div>
		<div class="newSaveIcon" style="display:none;height:auto;margin-top:34px" id="editMainPhoto">
				<div class="photoEditDropDown" onclick=showMainPicGalleryUploadTools("mainpicgallery",event)><i class="fa fa-edit"></i> '.$ADMIN_TRANS['edit photos'].'</div>
				<div class="photoEditDropDown" onclick=SwitchToSingle()><i class="fa fa-picture-o"></i> '.$ADMIN_TRANS['switch to single image'].'</div>
		</div>
		
		</div>';
		?>
		<script>jQuery(".site_overbg").hover(function(){jQuery(".mainPicStaticAdminControl").show();});</script>
		<?
	}
	print $event_handler;
	?>
	<div id="galleria" <?=$gal_container_css;?>>
	<?
	if ($GAL_OPT[GalleryEffect]>12 AND $GAL_OPT[GalleryEffect]<15) print '<div class="ws_images">';
	if ($GAL_OPT[GalleryEffect]>14 AND $GAL_OPT[GalleryEffect]<24) print '<div class="slides_container">';
	
	for ($a=0;$a<count($GAL[PhotoID]);$a++){ 
		$GalPagePic=$GAL[FileName][$a];
		$GalPicText=$GAL[PhotoText][$a];
		$GalPicUrl=urldecode($GAL[PhotoUrl][$a]);
		$galPhotoTarget="_self";
		$GalPicRichText=htmlspecialchars($GAL[PhotoContent][$a]);
		$cursor="default";
		$link_str="";
		if ($GalPicUrl) {
			$img_link=$GalPicUrl;
			$cursor="pointer";
			$link_str='longdesc="'.$img_link.'"';
		}
		else $img_link="#";
		 if (strpos($img_link,$SITE[url])===false AND strpos($img_link,"/category/")===false AND !strpos($img_link,"/")==0) $galPhotoTarget="_blank";
		$img_path="/sitepics/";
		
		if ($GAL_OPT[GalleryEffect]<4) {
			$img_path="/tumbs/";
			$img_link=SITE_MEDIA."/".$gallery_dir."/sitepics/".$GalPagePic;
		}
		
		switch(1) {
			case $GAL_OPT[GalleryEffect]>23 AND $GAL_OPT[GalleryEffect]<53:
			$EXTRA_EFFECTS=explode(",",$GAL[PhotoExtraEffect][$a]);
			$data_effect_str="";
			$data_effect_text_fx="";
			foreach($EXTRA_EFFECTS as $e_val) {
				$EFFECT_ARRAY=explode(":",$e_val);
				$data_effect_str.=$EFFECT_ARRAY[0].'="'.$EFFECT_ARRAY[1].'" ';
				if ($EFFECT_ARRAY[0]=="data-class") $data_effect_text_fx=$EFFECT_ARRAY[1];
				if ($EFFECT_ARRAY[0]=="" OR $EFFECT_ARRAY[1]=="") $data_effect_str="";
				
				
			}
			$data_effect_str=rtrim($data_effect_str);
			print '<div data-thumb="'.SITE_MEDIA.'/'.$gallery_dir.'/tumbs/'.$GalPagePic.'">';
			if ($GalPicUrl) print '<a target="'.$galPhotoTarget.'" href="'.$img_link.'" style="cursor:'.$cursor.'">';
				print '<img src="'.SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$GalPagePic.'" border="0">';
			if ($GalPicUrl) print '</a>';
			if ($GalPicRichText) print '<div id="galContent" class="elemHover captionRich '.$data_effect_text_fx.'">'.$GAL[PhotoContent][$a].'</div>';
			
			if ($GalPicText) print '<div class="caption elemHover fromLeft">'.$GalPicText.'</div>';
			
			print '</div>';
			break;

			case $GAL_OPT[GalleryEffect]>14 AND $GAL_OPT[GalleryEffect]<24:
				if ($GalPicRichText) print "<a><div id='galContent'>".$GAL[PhotoContent][$a]."</div></a>";
				else print '<a target="'.$galPhotoTarget.'" href="'.$img_link.'" style="cursor:'.$cursor.'"><img src="'.SITE_MEDIA.'/'.$gallery_dir.$img_path.$GalPagePic.'" border="0" title="'.$GalPicText.'"  id="'.$a.'" /></a>';
			break;
			case $GAL_OPT[GalleryEffect]<15:
				if ($GalPicRichText) print '<a target="'.$galPhotoTarget.'" href="'.$img_link.'" style="cursor:'.$cursor.'"><img src="'.SITE_MEDIA.'/'.$gallery_dir.$img_path.$GalPagePic.'" border="0" alt="'.$GalPicRichText.'" title=""  id="wow'.$a.'" /></a>';
				else print '<a target="'.$galPhotoTarget.'" href="'.$img_link.'" style="cursor:'.$cursor.'"><img src="'.SITE_MEDIA.'/'.$gallery_dir.$img_path.$GalPagePic.'" border="0" alt="'.$GalPicText.'"  id="'.$a.'" '.$link_str.' /></a>';
			break;
			case $GAL_OPT[GalleryEffect]>52 AND $GAL_OPT[GalleryEffect]<55 :
				$class_ls="ls-bg";
				$file_extension=end(explode(".", $GalPagePic));
				
				print '<div class="ls-slide" data-ls="slidedelay:'.$GAL_OPT[SlideDelay].';transition2d: '.$EXIST_2D_EFFECTS_STR.'; transition3d:'.$EXIST_3D_EFFECTS_STR.'">';
				if ($file_extension=="mp4") print '<div class="ls-l"><div class="video_overlay_exite"></div><video autoplay loop class="fillWidth"><source src="'.SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$GalPagePic.'" type="video/mp4" /></video></div>';
					else print '<img src="'.SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$GalPagePic.'" border="0" class="'.$class_ls.'" alt="Image background" nopin="nopin" data-ls="easingin:easeInOutCubic;durationin:'.$GAL_OPT[SlideSpeed].';durationout:'.$GAL_OPT[SlideSpeed].';">';
				if ($GalPicUrl) print '<a href="'.$img_link.'" class="ls-link"></a>';
				if ($GalPicRichText) {
					print '<div class="ls-l" data-ls="offsetxin:0;scalexout:0.2;scaleyout:0.2" style="white-space:nowrap;width:100%">'.$GAL[PhotoContent][$a].'</div>';
						
					}
				print "</div>";

			break;
			case $GAL_OPT[GalleryEffect]>54:
				//$BG_IMAGES=array();
				$BG_IMAGES[]=SITE_MEDIA.'/'.$gallery_dir.'/sitepics/'.$GalPagePic;
								
			break;
			default :
			break;
				
		} //end Switch
		
		//if ($GalPicRichText) {
		//	if ($GAL_OPT[GalleryEffect]>14) print "<a><div id='galContent'>".$GAL[PhotoContent][$a]."</div></a>";
		//	else print '<a target="'.$galPhotoTarget.'" href="'.$img_link.'" style="cursor:'.$cursor.'"><img src="'.SITE_MEDIA.'/'.$gallery_dir.$img_path.$GalPagePic.'" border="0" alt="'.$GalPicRichText.'" title=""  id="wow'.$a.'" /></a>';
		//}
		//else print '<a target="'.$galPhotoTarget.'" href="'.$img_link.'" style="cursor:'.$cursor.'"><img src="'.SITE_MEDIA.'/'.$gallery_dir.$img_path.$GalPagePic.'" border="0" title="'.$GalPicText.'"  id="'.$a.'" /></a>';
		
		//print '<img src="'.SITE_MEDIA.'/'.$gallery_dir.$img_path.$GalPagePic.'" border="0" title="#htmlcaption_'.$a.'" id="wow"'.$a.'" /></a>';
                
	} //end loop
	
	if ($GAL_OPT[GalleryEffect]>12 AND $GAL_OPT[GalleryEffect]<24) print '</div>'; //in case Script is jslides or wowSlider
	if ($GAL_OPT[GalleryEffect]>14 AND $GAL_OPT[GalleryEffect]<24) {
			?>
			<a href="#" class="prev"></a>
			<a href="#" class="next"></a>
			<?
			//print $event_handler;
	}
	
	
	?>
	</div>
	<script>
	var stageWidth=jQuery(window).width();
	var galleryGlobalHeight="<?=$gal_height;?>";
	jQuery(".mainPicStaticAdminControl #newSaveIcon.mainPicEditDD").click(function() {jQuery(".mainPicStaticAdminControl #editMainPhoto").toggle();});
	</script>
        <?
	//if ($GAL_OPT[GalleryEffect]<15 OR $GAL_OPT[GalleryEffect]>23) print $event_handler;

	switch(1) {
		case $GAL_OPT[GalleryEffect]>=0 AND $GAL_OPT[GalleryEffect]<4:
			
			?>
			<script language="javascript">
			TopHeaderGalType="galleria";
			var MainGallerySlider;
			Galleria.loadTheme('<?=$SITE[url];?>/js/gallery/slider/<?=$gal_theme;?>');
			jQuery('#galleria').galleria({
				transition: '<?=$gal_effect;?>',
				autoplay:<?=$gal_autoplay;?>,
				image_crop:'<?=$cropMode;?>',
				image_margin:0,
				height:<?=$gal_height;?>,
				transition_speed:<?=$gal_slide_speed;?>,
				show_imagenav:false,
				carousel_follow:false,
				preload:1,
				extend: function(options) {MainGallerySlider = this;}
				});
			
			</script>
			
		<?
		break;
		case $GAL_OPT[GalleryEffect]>3 AND $GAL_OPT[GalleryEffect]<13:
			?>
			<script language="javascript">
			TopHeaderGalType="nivo";
			  //NNivo Slider
				jQuery('#galleria').nivoSlider({
				effect:'<?=$gal_effect;?>',
				controlNav:false,
				directionNav:false,
				slices:<?=$GAL_OPT[NumSlices];?>,
				boxCols:<?=$GAL_OPT[NumSlices];?>,
				boxRows:<?=$GAL_OPT[NumSlices];?>,
				animSpeed:<?=$gal_slide_speed;?>,
				pauseTime:<?=$GAL_OPT[SlideDelay];?>,
                                captionOpacity:0.8
				}
				);
			 // End Nivo Slider
			 </script>
		<?
		break;
		case $GAL_OPT[GalleryEffect]>12 AND $GAL_OPT[GalleryEffect]<15:
			?>
			<script language="javascript">
			jQuery("#galleria").wowSlider({effect:"<?=$gal_effect;?>",prev:"",next:"",duration:<?=$gal_slide_speed;?>,delay:<?=$GAL_OPT[SlideDelay];?>,outWidth:<?=$GalleryWidth;?>,outHeight:<?=$gal_height;?>,width:<?=$GalleryWidth;?>,height:<?=$gal_height;?>,caption:true,controls:false,autoPlay:true,stopOnHover:false});
			  <?
			 if ($GalleryWidth==2000) {
				?>
				jQuery(document).ready(function() {
					var stageWidth=jQuery(window).width();
					var leftOffset=-(2000-stageWidth)/2;
					//jQuery(".ws_images img").css("position","absolute");
					jQuery(".ws_images").css("left",leftOffset);
					jQuery(window).resize(function() {
							stageWidth=jQuery(window).width();
							leftOffset=-(2000-stageWidth)/2;
							jQuery(".ws_images").css("left",leftOffset);
						});
				    });
				<?
			}
			?>
			</script>
			<?
		break;
		case $GAL_OPT[GalleryEffect]>14 AND $GAL_OPT[GalleryEffect]<24:
		?>
			
			<script language="javascript">
			jQuery(function(){
				jQuery('#galleria').slides({
					preload: false,
					preloadImage: 'loading.gif',
					play:<?=$gal_autoplay;?>,
					pause:200,
					hoverPause: true,
					effect:'<?=$slides_def_effect;?>',
					paginationEffect:'<?=$slides_def_effect;?>',
					crossfade: false,
					slideEasing: '<?=$GAL_SLIDES_EASE[$GAL_OPT[GalleryEffect]];?>',
					fadeEasing: '<?=$GAL_SLIDES_EASE[$GAL_OPT[GalleryEffect]];?>',
					slideSpeed:<?=$gal_slide_speed;?>,
					fadeSpeed:<?=$gal_slide_speed;?>
					
				});
			});
			 // End jsSlider
			 <?
			 if ($GalleryWidth==2000) {
				?>
				jQuery(document).ready(function() {
					var leftOffset=-(2000-stageWidth)/2;
					
					jQuery(".slides_control img").css("position","absolute");
					jQuery(".slides_control img").css("left",leftOffset);
					jQuery(window).resize(function() {
							stageWidth=jQuery(window).width();
							leftOffset=-(2000-stageWidth)/2;
							jQuery(".slides_control img").css("left",leftOffset);
						});
				    });
				<?
			}
			?>
			 </script>
		<?
		break;
		case $GAL_OPT[GalleryEffect]>23 AND $GAL_OPT[GalleryEffect]<53:
			include_once("Mobile_Detect.php");
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
				jQuery('.pix_diapo').diapo({
					fx:'<?=$GAL_PIX_DIAPO_EFFECTS[$GAL_OPT[GalleryEffect]-24];?>',
					loader: 'none',
					commands:'false',
					mobileCommands:'false',
					time:<?=$GAL_OPT[SlideDelay];?>,
					slicedCols:<?=$GAL_OPT[NumSlices];?>,
					slicedRows:<?=$GAL_OPT[NumSlices];?>,
					transPeriod:<?=$gal_slide_speed;?>,
					pagination:'false',
					mobilePagination:'fase',
					easing: '<?=$selected_easing;?>'
					
				});
			});
			<?
			if ($GalleryWidth==2000) {
				?>
				jQuery(document).ready(function() {
					
					var leftOffset=-(2000-stageWidth)/2;
					
					jQuery(".pix_relativize img").css("position","absolute");
					jQuery(".pix_relativize img").css("left",leftOffset);
					jQuery(".galleria-thumbnails-container").attr("align","center");
					jQuery(window).resize(function() {
							stageWidth=jQuery(window).width();
							leftOffset=-(2000-stageWidth)/2;
							jQuery(".pix_relativize img").css("left",leftOffset+"px");
							jQuery(".pix_relativize").css("width",stageWidth+"px");
						});
				    });
				<?
			}
			?>
			</script>
			<?
			break;
		case $GAL_OPT[GalleryEffect]>52 AND $GAL_OPT[GalleryEffect]<55:
			?>
			<script language="javascript">
				jQuery(document).ready(function(){
					jQuery('#galleria').layerSlider({
						skinsPath: '<?=$globalCDN;?>/js/gallery/slider/ls/skins/',
						autoStart : <?=$gal_autoplay;?>,
						pauseOnHover:false,
						<?
						if ($SITE[siteoverlaypic] OR $SITE[pageoverlaypic] OR $hideTumbs==1) {
							?>
							navButtons:false,
							navStartStop:false,
							<?
						}
						?>
						responsive: false,
						responsiveUnder: <?=($GalleryWidth==2000) ? 2000 : 800;?>,
						layersContainer: <?=($GalleryWidth==2000) ? 2000 : 800;?>,
						autoPlayVideos : true
						
					});
				 });
			</script>
			<?
		break;
		case $GAL_OPT[GalleryEffect]>54 :
		include_once("Mobile_Detect.php");
		$detect = new Mobile_Detect();

			?>
			<script language="javascript">
				jQuery(function($) {
					$.supersized({
						slideshow :1,			// Slideshow on/off
						autoplay:1,			// Slideshow starts playing automatically
						start_slide:1,			// Start slide (0 is random)
						stop_loop	:0,			// Pauses slideshow on last slide
						random: 	0,			// Randomize slide order (Ignores start slide)
						slide_interval:  <?=$GAL_OPT[SlideDelay];?>,		// Length between transitions
						transition: <?=($GAL_OPT[GalleryEffect]-54);?>, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
						transition_speed:<?=$gal_slide_speed;?>,		// Speed of transition
						new_window:0,			// Image links open in new window/tab
						pause_hover:   0,			// Pause slideshow on hover
						keyboard_nav:   1,			// Keyboard navigation on/off
						performance:	0,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
						image_protect:1,			// Disables image dragging and right click with Javascript
						min_width:0,			// Min width allowed (in pixels)
						min_height: 0,			// Min height allowed (in pixels)
						vertical_center:   0,			// Vertically center background
						horizontal_center:1,			// Horizontally center background
						fit_always:0,			// Image will never exceed browser width or height (Ignores min. dimensions)
						fit_portrait :  1,			// Portrait images will not exceed browser height
						fit_landscape:   0,			// Landscape images will not exceed browser width
						slide_links:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
						thumb_links:	1,			// Individual thumb links for each slide
						thumbnail_navigation: 0,			// Thumbnail navigation
						slides:[
								<?
								$ccc=0;
								foreach($BG_IMAGES as $bg_img_url) {
									$ccc++;
									?>
									{image : '<?=$bg_img_url;?>'}<?if ($ccc<count($BG_IMAGES)) print ',';
								}
								?>
							],
						progress_bar:0,			// Timer for each slide							
						mouse_scrub:0
					});	
				});
			</script>
			<?
			if (!$detect->isMobile()) print '<a id="prevslide" class="load-item"></a><a id="nextslide" class="load-item"></a>';
			
		break;
		default:
		break;
		
		
	} //End Switch
	
	if ($gal_theme=="galleria.classic.js") { //aligning the tumbs to center
		?>
	
	<script>
		
		jQuery(document).ready(function() {
			
			setTimeout(function() {
				jQuery(".galleria-thumbnails-container").show();
				jQuery(".galleria-thumbnails-container").attr("align","center");
				
		},200)
		
		});
	</script>
	<?
	}
	if (($SITE[maingallerybehind]==1 AND $urlKey=="home") OR ($SITE[maingallerybehind]==2) AND $GAL_OPT[GalleryEffect]<55) {
		
		
		?>
		<div id="marginizer"></div>
		<script>
		function setTpGalMargin() {
			var topHeight=jQuery('#galleria').height()-85;
			<?
			if (($SITE[topmenubottom]==3 OR $SITE[topmenubottom]==4) AND $SITE[topmenumargin]) {
				?>
				topHeight=topHeight-(<?=$SITE[topmenumargin];?>)-8;
				
				<?
			}
			?>
			jQuery('#marginizer').css("margin-top",topHeight+"px");
			<?
			if ($SITE[topmenubottom]==1) { //in case top menu is under main photo we want to leave it there
				?>
				jQuery(".topMenuNew").prepend(jQuery("#marginizer"));
				<?
			}
			else {
				?>
				if (jQuery(".middleContent").length) jQuery(".middleContent").prepend(jQuery('#marginizer'));
					else jQuery(".mainContentContainer").prepend(jQuery('#marginizer'));
				<?
			}
			?>
			//jQuery(".topMainPic").css({"position":"absolute","top":"0"});
		}
		jQuery(document).ready(function() {
			window.setTimeout('setTpGalMargin()',750);
			});
			jQuery(window).resize(function() {jQuery("#marginizer").css('margin-top',jQuery('#galleria').height()-85+"px");});
		 </script>
		<style>.topMenuNew, .topHeader, .topHeaderFull{position:relative;z-index: 101;} .topMainPic{position: absolute;top:0;padding-top:0px;}</style>
		
		<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {?><style>.topMainPic{top:65px;}</style><?}
	}
}
?>
