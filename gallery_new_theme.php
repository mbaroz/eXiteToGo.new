<?
reset($GAL);
$GAL=GetCatGallery($urlKey,0);
//Photogallery.php : Ver:1.0 /  Last Update: 10/01/2010
//TODO:
$galleryWidth=$dynamicWidth-240;
$tumbsMargin=45;
$ADMIN_TRANS['show all']="Show All";
$ADMIN_TRANS['show none']="Show Untagged";
if ($SITE_LANG[selected]=="he") {
	$ADMIN_TRANS['show all']="הצג הכל";
	$ADMIN_TRANS['show none']="הצג תמונות ללא תגיות";
}
$labels['left']=array("Please wait...");
$labels['right']=array("העמוד בטעינה...");
if (intval($isLeftColumn)>0 AND $customLeftColWidth==220) $tumbsMargin=35;
$tumbsMarginHeight=35;
$defaultMarginHeight=10;
$display_bgupload="none";
$containerPaddingRight=25;
$EASINGS=array('none','linear','swing','easeInQuad','easeOutQuad','easeInOutQuad','easeInCubic','easeOutCubic','easeInOutCubic','easeInQuart','easeOutQuart','easeInOutQuart','easeInQuint','easeOutQuint','easeInOutQuint','easeInSine','easeOutSine','easeInOutSine','easeInExpo','easeOutExpo','easeInOutExpo','easeInCirc','easeOutCirc','easeInOutCirc','easeInElastic','easeOutElastic','easeInOutElastic','easeInBack','easeOutBack','easeInOutBack','easeInBounce','easeOutBounce','easeInOutBounce');
$HOVERTEXTSTYLES=array("Show Always","Slide Up text on Mouse Over ","Slide Up Text&Photo on Mouse Over");
$ADMIN_TRANS['crop tumbs images']="Crop Tumbs images";
if ($SITE_LANG[selected]=="he") $ADMIN_TRANS['crop tumbs images']="חתוך את התמונות הקטנות במקום להקטין אותן";
// $media_prefix = ($AWS_S3_ENABLED) ? $SITE_MEDIA : $SITE[url];


if ($P_DETAILS[PageStyle]==1) $galleryWidth=$dynamicWidth;
if (intval($isLeftColumn)>0) {
	$customLeftColSub=200;
	if ($customLeftColWidth) $customLeftColSub=$customLeftColWidth;
	$galleryWidth=$galleryWidth-$customLeftColSub;
	$galleryWidth=$rightColWidth-20;
}

$tumbsWidth=$SITE[galleryphotowidth];
$tumbsHeight=$SITE[galleryphotoheight];
if ($GAL[TumbsWidth]>0) $tumbsWidth=$GAL[TumbsWidth];
if ($GAL[TumbsHeight]>0) $tumbsHeight=$GAL[TumbsHeight];
if ($GAL[hmargin]) {
	$tumbsMarginHeight=$GAL[hmargin]; 
	$defaultMarginHeight=0;
}
if ($GAL[wmargin]) {
	$tumbsMargin=$GAL[wmargin];
	if ($tumbsMargin<-27) $tumbsMargin=-27;
}
$textAlign="center";
$vertical=0;
$textLinesEdit=1;
$GalID=$GAL[GID];
$cursorStyle="pointer";

$TAGS_FONT_STYLES=array("normal","bold","italic");
$isSideTextChecked=$isOrderBottom=$isTextCentered=$isPhotosBG_DISABLED=$isRoundedCorners=$corners_css=$isGalFixedChecked=$isCollageGallery=$is_default_options_checked=$isHoverPhotoDimmed=$isImagesCropMode="";
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
$TextCentered=GetGalleryAttribute("centerPhotoText",$GalID);
$GAL_OPTIONS[photo_text_bg_color]=GetGalleryAttribute('photos_text_bg_color',$GalID);
$GAL_OPTIONS[photo_text_color]=GetGalleryAttribute('photos_text_color',$GalID);
$GAL_OPTIONS[photo_text_color]=GetGalleryAttribute('photos_text_color',$GalID);
$GAL_OPTIONS[photo_text_border_color]=GetGalleryAttribute('photo_text_border_color',$GalID);
$GAL_OPTIONS[photo_bg_disabled]=GetGalleryAttribute('disable_photos_bg',$GalID);
$GAL_OPTIONS[rounded_corners_bg]=GetGalleryAttribute('rounded_corners_bg',$GalID);
$GAL_OPTIONS[collage_gallery]=GetGalleryAttribute('collage_gallery',$GalID);
$GAL_OPTIONS[CollageEasing]=GetGalleryAttribute('CollageEasing',$GalID);
$GAL_OPTIONS[CollageEasingSpeed]=GetGalleryAttribute('CollageEasingSpeed',$GalID);
$GAL_OPTIONS[ZoomEffect]=GetGalleryAttribute('ZoomEffect',$GalID);
$GAL_OPTIONS[photo_bg_color]=GetGalleryAttribute('photos_bg_color',$GalID);
$GAL_OPTIONS[GalFixed]=GetGalleryAttribute('GalFixed',$GalID);

$GAL_OPTIONS[gallery_tags_text_color]=GetGalleryAttribute('gallery_tags_text_color',$GalID);
$GAL_OPTIONS[gallery_tags_bg_color]=GetGalleryAttribute('gallery_tags_bg_color',$GalID);
$GAL_OPTIONS[gallery_tags_margin]=GetGalleryAttribute('gallery_tags_margin',$GalID);
$GAL_OPTIONS[all_tags_bg_color]=GetGalleryAttribute('all_tags_bg_color',$GalID);
$GAL_OPTIONS[selected_tags_color]=GetGalleryAttribute('selected_tags_color',$GalID);
$GAL_OPTIONS[selected_tag_bg_color]=GetGalleryAttribute('selected_tag_bg_color',$GalID);
$GAL_OPTIONS[tags_font_size]=GetGalleryAttribute('tags_font_size',$GalID);
$GAL_OPTIONS[tags_font_style]=GetGalleryAttribute('tags_font_style',$GalID);
$GAL_OPTIONS[hover_text_style]=GetGalleryAttribute('hover_text_style',$GalID);
$GAL_OPTIONS[infinite_scroll]=GetGalleryAttribute('infinite_scroll',$GalID);
$GAL_OPTIONS[mobile_columns]=GetGalleryAttribute('mobile_columns',$GalID);
$GAL_OPTIONS[mobile_images_reduce]=GetGalleryAttribute('mobile_images_reduce',$GalID);
$GAL_OPTIONS[images_crop_mode]=GetGalleryAttribute('images_crop_mode',$GalID);
if ($GAL_OPTIONS[images_crop_mode]==1) $isImagesCropMode="checked";
if ($GAL_OPTIONS[mobile_images_reduce]<1 OR $GAL_OPTIONS[mobile_images_reduce]=="") $GAL_OPTIONS[mobile_images_reduce]=100;
if ($GAL_OPTIONS[mobile_columns]<1 OR !$GAL_OPTIONS[mobile_columns]) $GAL_OPTIONS[mobile_columns]=2;
if ($GAL_OPTIONS[hover_text_style]=="") $GAL_OPTIONS[hover_text_style]=0;
if (!$GAL_OPTIONS[photo_bg_color] AND $SITE[photowrapperbg]!="transparent") $GAL_OPTIONS[photo_bg_color]=str_replace("#", "",$SITE[photowrapperbg]);
$GAL_OPTIONS[photo_dimmed]=GetGalleryAttribute('photo_dimmed',$GalID);
if ($GAL_OPTIONS[photo_dimmed]==1) $isHoverPhotoDimmed="checked";
$TAGS_FONT_STYLE_SELECTED[$GAL_OPTIONS[tags_font_style]]="selected";
$HOVER_STYLE_SELECTED[$GAL_OPTIONS[hover_text_style]]="selected";

if ($GAL_OPTIONS[gallery_tags_margin]=="") $GAL_OPTIONS[gallery_tags_margin]=10;

if ($GAL_OPTIONS[GalFixed]=="") $GAL_OPTIONS[GalFixed]=1;
if (!$GAL_OPTIONS[CollageEasingSpeed]) $GAL_OPTIONS[CollageEasingSpeed]=800;
if ($GAL_OPTIONS[photo_bg_color] AND !$GAL_OPTIONS[photo_text_bg_color] AND $GAL_OPTIONS[rounded_corners_bg]) $GAL_OPTIONS[photo_text_bg_color]=$GAL_OPTIONS[photo_bg_color];
if ($GAL_OPTIONS[GalFixed]==1) {
	$isGalFixedChecked="checked";
	$galleryWidth=$galleryWidth+$tumbsMargin-7; //Added 11/6/12
	$containerPaddingRight=9;
	if (!$GAL[wmargin]) $tumbsMargin=60;
}
//disable default image:
$show_avaliable_filters=0;
$G_FILTERS_ARRAY_DISPLAY=GetGalleryAvaliableFilters($GalID,$GAL[Filters]);
$G_FILTERS_ARRAY=explode("|",$GAL[Filters]);
if (count($G_FILTERS_ARRAY_DISPLAY)>0 AND !$GAL[Filters]=="") $show_avaliable_filters=1;
$GALLERY_FILTERS=htmlspecialchars_decode($GAL[Filters]);
$GALLERY_FILTERS=str_ireplace("|","\n",$GALLERY_FILTERS);
$GALLERY_FILTERS_STR=trim($GALLERY_FILTERS);
$selected_easing[$GAL_OPTIONS[CollageEasing]]="selected";
$selected_Zoom[$GAL_OPTIONS[ZoomEffect]]="selected";
$cssItems='height: '.($boxHeight+$tumbsMarginHeight).'px;';
if ($GAL_OPTIONS[collage_gallery]) {
	$isCollageGallery="checked";
	$cssItems="min-height:5px;margin-bottom:".$tumbsMarginHeight."px;";
}
if ($GAL_OPTIONS[rounded_corners_bg]) $isRoundedCorners="checked";
if ($GAL_OPTIONS[hover_text_style]>0) $GAL_OPTIONS[rounded_corners_bg]=0;
if ($GAL_OPTIONS[rounded_corners_bg]) {
	$corners_css="border-bottom-left-radius:5px;border-bottom-right-radius:5px;";
	$isRoundedCorners="checked";
}
if ($GAL_OPTIONS[photo_bg_disabled]==1) {
	$isPhotosBG_DISABLED="checked";
	$GAL[TumbsBGPic]=$SITE[gallerybgpic]='';
}
if ($GAL[isDefaultOptions]==1) $is_default_options_checked="checked";
$photo_text_color=$SITE[contenttextcolor];
if ($GAL_OPTIONS[photo_text_color]) $photo_text_color=$GAL_OPTIONS[photo_text_color];


if ($GAL[PhotosOrder]=="bottom") $isOrderBottom="checked";
$align_photo_text=$SITE[align];
$photo_text_width_fix=-1;
if ($GAL_OPTIONS[photo_text_bg_color]) {
	$photo_text_padding=5;
	$photo_text_width_fix=-9;
}
if ($TextCentered) {
	$isTextCentered="checked";
	$align_photo_text="center";
	$photo_text_padding=5;
	$photo_text_width_fix=-7;
	if ($GAL_OPTIONS[photo_text_bg_color]) $photo_text_width_fix=-9;
}



$collage_direction=$collage_op_direction="inherit";
if ($GAL_OPTIONS[collage_gallery]) {
	$collage_direction="ltr";
	$collage_op_direction="rtl";
	$isRTL="false";
	if ($SITE[align]=="right"){
		$collage_direction="rtl";
		$collage_op_direction="ltr";
		$isRTL="true";
	}

}

$collageAnimated="true";
if (isset($_SESSION['LOGGED_ADMIN']) OR $GAL_OPTIONS[CollageEasing]=="none") $collageAnimated="false";
$lightBoxClass="photo_gallery";
if ($GAL_OPTIONS[ZoomEffect]=="fancybox" OR $GAL_OPTIONS[ZoomEffect]=="fancyboxfullscreen") $lightBoxClass="fancybox";
if ($GAL_OPTIONS[ZoomEffect]=="fancyboxtumbs") {
	$lightBoxClass="fancybox-thumbs";
	?>
	<link rel="stylesheet" href="<?=$SITE[url];?>/js/gallery/fancybox/helpers/jquery.fancybox-thumbs.css?v=2.0.5" type="text/css" media="screen" />
	<script type="text/javascript" src="<?=$SITE[url];?>/js/gallery/fancybox/helpers/jquery.fancybox-thumbs.js?v=2.0.5"></script>
	<script>
	jQuery(document).ready(function() {
		jQuery(".fancybox-thumbs").fancybox({
			openEffect :'elastic',padding:'7',
			helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}}
	})});
	</script>
	<?

}
if ($GAL_OPTIONS[ZoomEffect]=="fancyboxfullscreen") {
	?>
	<script>
	fancyBoxFullScreen=1;
	</script>
	<style>.fancybox-close {top: 10px !important;right: 10px !important;}</style>
	<?
}
//if ($show_avaliable_filters==1) {
	?>
	<script>
	var mobileColumnsCount="<?=$GAL_OPTIONS[mobile_columns];?>";
	var mobileReduceImageSize="<?=$GAL_OPTIONS[mobile_images_reduce];?>";
	var this_is_collage_gal=0;
	<?
	if ($GAL_OPTIONS[collage_gallery]) {
		?>
		this_is_collage_gal=1;
		<?
	}
	?>
	function refreshLazy(){
		if (this_is_collage_gal==0) jQuery(".boxes li .photoWrapper img.desaturate").data("plugin_lazy").update();

	}
	function setButtonFiltered(but) {
		
		jQuery(".photoGalley_filter div").removeClass("selected");
		jQuery(but).addClass("selected");
		window.setTimeout('refreshLazy()',500);
	}
	function filterPhotos(data_flitered,but){
		var $filtered_data = $listContainer.find('li[datavalue*='+data_flitered+']');
		if (data_flitered=="") $filtered_data = $listContainer.find('li');
		$listContainer.isotope({
			filter:$filtered_data,
			transformsEnabled: true,
				masonry: {
					columnWidth:1
				},
			itemSelector: '.portlet',
			animationEngine: 'jquery',
			animationOptions:{queue:false,duration:<?=$GAL_OPTIONS[CollageEasingSpeed];?><?if ($GAL_OPTIONS[CollageEasing]!='none') {?>,easing:'<?=$GAL_OPTIONS[CollageEasing];?>'<?}?>}
		});
		
	}
	jQuery(window).bind( 'hashchange', function( event ){
		var hashData = decodeURIComponent(location.hash.replace( /^#/, '' ));		
		if (hashData=='/') filterPhotos('',null);

		else {
			if (hashData.indexOf("PhotoSwipe")==-1 && hashData!="" && hashData.indexOf("filter")>0) {
				hashDataA=hashData.split("/");
				hashData=hashDataA[1];
				butID=hashData.replace("filter","filterID");
				var href=jQuery("#"+butID).attr("button-filter");
				filterPhotos(href,null);
				setButtonFiltered(jQuery("#"+butID));

			}
		}
		
	});
	</script>
	<?
$width_num=1350;

if ($P_DETAILS[PageStyle]==2 or $P_DETAILS[PageStyle]==0) 	
	{
		if ($isLeftColumn!=1) $customLeftColWidth=0; 
		$width_six=$width_num-250-$customLeftColWidth; 		
		if($width_six<1350 and $width_six>880)
		    {$width_ten=12.5; $width_nine=12.5; $width_eight=12.5; $width_seven=14.28;
		    	$width_six=16.66; $width_five=20; $width_four=25; $width_three=33; $width_two=50; 
		     $respon_a=25; $respon_b=33; $respon_c=50; $respon_d=16.6;//1100-950-850
		     
		    } 
		else if($width_six<890) 
			{
				$width_ten=16.66; $width_nine=16.66; $width_eight=16.66; $width_seven=16.66;
				$width_six=25; $width_five=20; $width_four=25; $width_three=33; $width_two=50; //1350
				$respon_a=33; $respon_b=50; $respon_c=100; $respon_d=33;//1100-950-850
			}
		
    }
if($P_DETAILS[PageStyle]==1) 
	{
		$width_ten=10; $width_nine=11.10; $width_eight=12.5; $width_seven=14.28;
		$width_six=16.66; $width_five=20; $width_four=25; $width_three=33; $width_two=50; 
		$respon_a=20; $respon_b=25; $respon_d=16.6; $respon_c=50;//1100-950-850
	}	

$numrows=5;
if ($numrows==10) $allPrecent=$width_ten; 
if ($numrows==9) $allPrecent=$width_nine;
if ($numrows==8) $allPrecent=$width_eight;
if ($numrows==7) $allPrecent=$width_seven;
if ($numrows==6) $allPrecent=$width_six;
if ($numrows==5) $allPrecent=$width_five;
if ($numrows==4) $allPrecent=$width_four;
if ($numrows==3) $allPrecent=$width_three;
if ($numrows==2) $allPrecent=$width_two;


?>
<style type="text/css">

ul{margin: 0px; padding: 0px;}
.boxes{ width:100%;  clear:both; font-family:<?=$SITE[cssfont];?>; list-style-type: none; margin: 0px; padding: 0px}
.div_all{ width:<?=$allPrecent;?>%;  float:<?=$SITE[align];?>;padding:<?=($tumbsMarginHeight);?>px <?=($tumbsMargin);?>px; margin:0px; padding-<?=$SITE[align];?>:0px;      box-sizing:border-box;  font-family: <?=$SITE[cssfont];?>;}
.inside_div{width: 100%;  padding:0px;  box-sizing:border-box; float:<?=$SITE[align];?>; }
.bg{ width:100%; height:<?=($tumbsHeight);?>px;  box-sizing:border-box; margin: 0px; background-size: cover; background-position: center; background-repeat: no-repeat;}
.tumbs {width:100%;  padding:5px; background-color:#D1022F /*<?=$GAL_OPTIONS[photo_bg_color];?>*/;  border: 1px solid #000 /*<?=$GAL_OPTIONS[photos_border_color];?>*/; box-sizing:border-box;}
figure {
    display: block;
    -webkit-margin-before:0em;
    -webkit-margin-after: 0em;
    -webkit-margin-start: 0px;
    -webkit-margin-end: 0px;
    margin:0px;
    padding:0px;
} 

.button{padding:3px; background-color: #fff; border:solid 1px #B9BFD1;border-radius: 9px;  }

.photoWrapper{}

.boxes:after {
		content: ""; display: block; height: 0; overflow: hidden; clear: both; 
			 }
.photoName a, .photoName{
		text-decoration:none;
		color:#<?=$photo_text_color;?>;
		text-align:<?=$align_photo_text;?>;
		font-weight:bold;
		overflow:hidden;
		background-color:#90C3D4 /*<?=$GAL_OPTIONS[photo_text_bg_color];?>*/;
		font-size: <?=$SITE[contenttextsize];?>px;
		line-height: 25px;
        margin-top: 1px;
       
	}
	.photoName{ border:solid 1px #000 /*<?=$GAL_OPTIONS[photo_text_border_color];?>*/;}
	.boxes li.ui-sortable-placeholder 
		{	background-color:transparent;border: 1px dotted silver;
			visibility: visible !important;min-height: 50px;width:<?=$boxWidth;?>px
		}
	#lock_prop {cursor:pointer}
	div.flash { width:95%;	}
	.progressWrapper  {
		width:100px;
		float:left;
	}
	.progressContainer {
		padding:3px;
		width:auto;
		height:75px;
	}
	.progressName {
		width:75px;
		font-size:10px;
		font-weight:normal;
	}
	.progressBarInProgress,.progressBarComplete, .progressBarError {
		width:0%;
		border-radius:6px;
		height:6px;
	}
	.progressBarInProgress {background-color:white; width:100%;}
	.progressBarStatus {
		width:85px;
	}
	.progressContainer img {max-width:90px;max-height:90px;}
	.photoGalley_filter div,.photoGalley_filter div a {
		background-color: #<?=$GAL_OPTIONS['gallery_tags_bg_color'];?>;
		color: #<?=$GAL_OPTIONS['gallery_tags_text_color'];?>;
		<?if($GAL_OPTIONS[tags_font_style]!=2) {?> font-weight:<?=$TAGS_FONT_STYLES[$GAL_OPTIONS[tags_font_style]];}?>;
		<?if($GAL_OPTIONS[tags_font_style]==2) {?> font-style:<?=$TAGS_FONT_STYLES[$GAL_OPTIONS[tags_font_style]];}?>;
		<?if($GAL_OPTIONS[tags_font_size]) {?> font-size:<?=$GAL_OPTIONS[tags_font_size];?>px;<?}?>
	}
	.photoGalley_filter div.selected, .photoGalley_filter div.selected a{
		<?if($GAL_OPTIONS[selected_tag_bg_color])?> background-color: #<?=$GAL_OPTIONS['selected_tag_bg_color'];?>;
		<?if($GAL_OPTIONS[selected_tags_color])?> color: #<?=$GAL_OPTIONS['selected_tags_color'];?>;
		
	}
	.photoGalley_filter {margin-<?=$SITE[opalign];?>:<?=$GAL_OPTIONS['gallery_tags_margin'];?>px;margin-bottom:<?=abs($GAL_OPTIONS['gallery_tags_margin']);?>px;margin-top:2px;}
	<?if ($GAL_OPTIONS[all_tags_bg_color]=="") {?> .photoGalley_filter:first-child {margin-<?=$SITE[align];?>:0px;}<?}?>
	.photoGalleryFiltersWrapper {
		background-color:#<?=$GAL_OPTIONS[all_tags_bg_color];?>;
	}
	<?if ($GAL_OPTIONS[rounded_corners_bg]) {
		?>
		.photoGalley_filter div, .photoGalleryFiltersWrapper {
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			border-radius: 4px;
			}
	<?
	}
	?>
	.video_button {
		width:<?=$tumbsWidth;?>px;
		height:46px;
		<?if ($GAL_OPTIONS[collage_gallery]) {?>height:100%;margin-top:-5px;<?}?>
		<?if (!$GAL_OPTIONS[collage_gallery]) {?>top:<?=(($tumbsHeight/2)-23)+5;?>px;<?}?>
		background:transparent url('/images/video-bot-circle.png') no-repeat;
		position:absolute;
		background-position: center;
		cursor: pointer;
		opacity: 0.65;
		display: none;
	}
	.video_button:hover {opacity: 0.90}
	.loading_infinite {bottom:0px;position: fixed}

@media screen and (max-width: 1350px) {
.main_box{width:100%; } 
.inside_div img{ width: 100%; height: 100% }
}
@media screen and (max-width: 1200px) {
  .div_all{
  	<?if ($numrows==10 || $numrows==9 || $numrows==8 || $numrows==7) { ?>width:<?=$respon_d;?>%; <?}?>}
}

@media screen and (max-width: 1100px) {
 .div_all{
 		<?if ($numrows==10 || $numrows==9 || $numrows==8 || $numrows==7 || $numrows==6 || $numrows==5) 
 		{ ?>width:<?=$respon_d;?>%; <?}?> 
 	}
}
@media screen and (max-width: 950px) {
 .div_all{
 	<?if ($numrows==10 || $numrows==9 || $numrows==8 || $numrows==7) { ?>width:<?=$respon_a;?>%; <?}?>}
 .div_all{
 	<?if ($numrows==6 || $numrows==5 || $numrows==4) { ?> width:<?=$respon_b;?>%; <?}?>}
}
@media screen and (max-width: 850px) { 
 .div_all{
 	<?if ($numrows==9 || $numrows==8 || $numrows==7) { ?>width:<?=$respon_b;?>%;  	<?}?>}
 .div_all{
 	<?if ($numrows==6 || $numrows==5 || $numrows==4 || $numrows==3) { ?>width:<?=$respon_c;?>%; <?}?>}
@media screen and (max-width: 680px) {
.div_all{width:50%; }
}
@media screen and (max-width: 600px) {
.div_all{width:100%; }
.bg{   background-size:100%;}
}
</style>
<!--------------------------------end style-------------------------------------------->

<script>
	var mobileEnabled="<?=$SITE[mobileEnabled];?>";
	var w_gallerySize=jQuery(window).width();
</script>

	<script language="javascript" src="<?=$SITE[url];?>/js/jquery.isotope.min.js"></script>
	<?if($SITE[align]=="right") {
		?>
		<script language="javascript">
			jQuery.Isotope.prototype._positionAbs = function( x, y ) {
		       return { right: x+7, top: y };
			};
		</script>
		<?
	}
	

if (isset($_SESSION['LOGGED_ADMIN'])) {
	$showAdvancedEditButton="none";
	if (ieversion()<0 OR ieversion()>9 ) $showAdvancedEditButton="";
	if ($GAL_OPTIONS[collage_gallery]) {
			?>
			<script language="javascript" src="<?=$SITE[url];?>/js/jquery.masonry.min.js"></script>
			<?
	}
?>
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

<?
if ($showAdvancedEditButton=="") {
	?>
	<script language="javascript">
	var currentEditedPhotoID;
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
			   jQuery.get("<?=$SITE[url];?>/Admin/saveAdvancedPhotoEdit.php",{url:newURL,photo_id:currentEditedPhotoID});
			   featherEditor.close();
	       },
	       //postUrl: '<?=$SITE[url];?>/Admin/saveAdvancedPhotoEdit.php',
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
           url: src
       });
       currentEditedPhotoID=photoID;
      return false;
}
var currentGALID="<?=$GalID;?>";
var editor_ins;
//var editor_browsePath="<?//=$SITE[base_dir];?>/ckfinder";
var gal_editor_width="99%";
var uploaded_filename;
var buttonID= "photo_spanButtonPlaceHolder";
var cancelButtonID= "photo_btnCancel";
var progressTargetID="photo_fsUploadProgress";
var allowed_photo_types="*.jpg;*.gif;*.png;*.ico";
var pre_prodUrlStr;
var display_bg_upload="<?=$display_bgupload;?>";
var show_filters=0;

	jQuery(function() {
		jQuery(".boxes").sortable({
		
   		update: function(event, ui) {
   			saveOrder(jQuery(".boxes").sortable('serialize'));
   		},
		connectWith: '.portlet',
		scroll:true,
		opacity: 0.6,tolerance: 'pointer',dropOnEmpty: false,
		forcePlaceholderSize :true
		
		<?if ($GAL_OPTIONS[collage_gallery]) {
			?>
			,
				 start:  function(event, ui) {  
					//$listContainer.isotope('destroy');
					jQuery(".ui-sortable-placeholder").css("height",ui.item.height()-5+"px");
					ui.item.parent().masonry('reload');
				 },
				change: function(event, ui) {
					ui.item.parent().masonry('reload',{isRTL:false});
				},
				stop:   function(event, ui) {
					 ui.item.parent().masonry('reload',{isRTL:false,isAnimated:false});
				}
			<?
		}
		?>
	});
		jQuery( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" );
		
	});
function ismaxlength(obj){
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>mlength)
	obj.value=obj.value.substring(0,mlength);
}

function AddNewPic() {
	upload_global_type="photogallery";
	edit_video_id=0;
	edit_photo_id=0;
	show_filters=0;
	jQuery('#PhotoFiltersDiv').hide();
	jQuery('#PhotoPreview').hide();
	jQuery('#PicUploader').css("width","530px");
	jQuery('#GeneralUploader').css("width","515px");
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




function EditPhotoDetails(photo_url,photo_title,photo_id,photo_prod_urlKey,isProdPageChecked,photo_alt) {
	$('photo_url').value=photo_url;
	$('productPageUrlKey').value=photo_prod_urlKey;
	$('photo_alt_text').value=photo_alt;
	show_filters=1;
	jQuery('#PhotoFiltersDiv').show();
	jQuery('#PhotoPreview').show();
	jQuery('#PicUploader').css("width","890px");
	jQuery('#GeneralUploader').css("width","430px");
	EditPhotoFilters(photo_id);
	if (isProdPageChecked==1) {
		$('isProductLinked').checked=true;
		$('prodUrlKeyLabel').style.display="";
		$('photo_url').disabled=true;
	}
	else {
		$('isProductLinked').checked=false;
		$('prodUrlKeyLabel').style.display="none";
		$('photo_url').disabled=false;
	}
	

	var photo_src_location=jQuery("figure#img-"+photo_id).attr("data-tumb");
	var currentImgTagForEditor=jQuery('<img id="aviary_edited_img_'+photo_id+'">');
	    currentImgTagForEditor.attr('src',photo_src_location);
		currentImgTagForEditor.css("display","none");
		currentImgTagForEditor.appendTo("body");

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
	updateProdUrlKeyExample($('productPageUrlKey'));
	photo_title=photo_title.replace('&rsquo;',"'");
	photo_title=photo_title.replace(/<br \/>/g,"\n");
	$('photo_text').value=photo_title;
	upload_global_type="photogallery";
	edit_photo_id=photo_id;
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
	else {
		ShowLayer("PicUploader",0,1,1);
	}
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
var picCounter=0;
var isFilesInQue=0;
function SaveNewUrl() {
	jQuery(".progressBarInProgress").css({"background-color":"#0C7DD3", "width": "0%"});
	swfu.startUpload();
	f_stat = swfu.getStats();
	if (f_stat.files_queued>0) isFilesInQue=1;
	var newPhotoUrl=document.getElementById("photo_url").value;
	newPhotoUrl=encodeURIComponent(newPhotoUrl);
	var newPhotoText=document.getElementById("photo_text").value;
	var newPhotoAltText=document.getElementById("photo_alt_text").value;
	var newPhotoProdUrlKey=$('productPageUrlKey').value;
	newPhotoText=encodeURIComponent(newPhotoText);
	var photo_id=edit_photo_id;
	var isProdLinked=0;
	var galID="<?=$GAL[GID];?>";
	if ($('isProductLinked').checked) isProdLinked=1;
	if ($('isProductLinked').checked && $('productPageUrlKey').value=="") {
		alert("יש להזין שם לעמוד המוצר");
		return false;
		
	}
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=rename_url';
	var pars = 'galID='+galID+'&NewPicUrl='+newPhotoUrl+'&photo_id='+photo_id+'&newPhotoText='+newPhotoText+'&isProdUrl='+isProdLinked+'&prodUrlKey='+newPhotoProdUrlKey+'&photo_alt='+newPhotoAltText+'&haveFiles='+isFilesInQue;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	if (show_filters==1) SavePhotoFilters(photo_id,0);
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
function successEditUploadedPhoto(p) {
	successEdit();
	//jQuery("#SWFUpload_0_"+picCounter+" .progressContainer").html("<div style='display:table-cell;vertical-align:middle;height:90px;text-align:center'><img src='<?=SITE_MEDIA;?>/gallery/tumbs/"+p+"' /></div>");
	//picCounter++;
}
function SaveUploadedPhoto(photo_name) {
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php';
	var v_txt=$('photo_text').value;
	var v_url=$('photo_url').value;
	var photo_alt=$('photo_alt_text').value;
	
	v_txt=encodeURIComponent(v_txt);
	var galID="<?=$GAL[GID];?>";
	var isCollageEnabled='<?=$GAL_OPTIONS[collage_gallery];?>';
	var photo_id=edit_photo_id;
	var pars = 'photo_name='+photo_name+'&photo_text='+v_txt+'&photo_url='+v_url+'&galleryID='+galID+'&photo_id='+photo_id+'&is_collage='+isCollageEnabled+'&photo_alt='+photo_alt;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEditUploadedPhoto(photo_name);}, onFailure:failedEdit,onLoading:savingChanges});
	
}
function SaveGalleryTumbsBG(photo_name) {
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=uploadTumbsBG';
	var galID="<?=$GAL[GID];?>";
	var pars = 'photo_name='+photo_name+'&galleryID='+galID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit,onLoading:savingChanges});
}
function delTumbsBG() {
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=delTumbsBG';
	var galID="<?=$GAL[GID];?>";
	var pars = 'galleryID='+galID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout('ReloadPage()',300);
}
function saveOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php';
		var pars = 'galleryID=<?=$GalID;?>'+'&'+newPosition+'&action=saveLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
}

function EditGalleryContent(textDivID) {
	var editorconfig;
	var buttons_str;
	editorconfig="config_full.js";
	switch (textDivID) {
		case "galleryContent":
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveGalleryContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		break;
		case "galleryContentBottom":
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveGalleryContentBottom();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		break;
		case "galSideText":
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveGalleryContentSide();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
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
			jQuery(function() {
				jQuery("#lightEditorContainer").draggable();
	});
	
}
function saveGalleryContent() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	editor_ins.destroy();
	$('galleryContent').innerHTML=decodeURIComponent(cVal);
	//ShowLayer("lightEditorContainer",0,1,0);
	slideOutEditor("lightEditorContainer",0);
}
function saveGalleryContentBottom() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent&divplace=bottom';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	editor_ins.destroy();
	$('galleryContentBottom').innerHTML=decodeURIComponent(cVal);
	//ShowLayer("lightEditorContainer",0,1,0);
	slideOutEditor("lightEditorContainer",0);
}
function saveGalleryContentSide() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent&divplace=side';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
	$('galSideText').innerHTML=decodeURIComponent(cVal);
	//ShowLayer("lightEditorContainer",0,1,0);
	
}
function saveGalleryContentMiddle() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent&divplace=middle';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
	$('galMiddleText').innerHTML=decodeURIComponent(cVal);
	//ShowLayer("lightEditorContainer",0,1,0);
	
}
function cancel() {
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
	//ShowLayer("lightEditorContainer",0,1,0);
	
}
function EditGalleryOptions(galID) {
	    if ($('GalPageOptions').style.display=="none") {
		//ShowLayer('GalPageOptions',1,1,1);
		slideOutSettings("GalPageOptions",1);
		upload_global_type="gallerytumbsBG";
		showuploader(allowed_photo_types,1,'photoBG_spanButtonPlaceHolder','photoBG_btnCancel','photoBG_fsUploadProgress',0);
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
	var galID=gallery_id;
	var orderPhotosBottom="top";
	var textPhotoCentered=0;
	var isGalFixed=0;
	var options_default=0;
	var is_photo_dimmed=0;
	if ($('sideTextGal').checked) currentProdGal=1;
		else currentProdGal=0;
	if ($('orderPhotos').checked) orderPhotosBottom="bottom";
	if ($('centerTextUnderPhotos').checked) textPhotoCentered=1;
	if ($('gal_is_fixed').checked) isGalFixed=1;
	if ($('is_default_options').checked) options_default=1;
	if ($('is_photo_dimmed').checked) is_photo_dimmed=1;
	var imagesCropMode=0;
	if (jQuery("input#crop_mode").is(":checked")) imagesCropMode=1;
	var hMargin=$('hmargin').value;	
	var wMargin=$('wmargin').value;
	var tumbsWidth=$('tumbswidth').value;
	var tumbsHeight=$('tumbsheight').value;
	var galleryFilters=jQuery('#filters_name').val();
	galleryFilters=galleryFilters.replace(/\n/g,'|');
	var photos_bg_color=$('GAL_OPTIONS[photo_bg_color]').value;
	var photos_text_bg_color=$('GAL_OPTIONS[photo_text_bg_color]').value;
	var photos_text_color=$('GAL_OPTIONS[photo_text_color]').value;
	var photo_text_border_color=$('GAL_OPTIONS[photo_text_border_color]').value;
	var photos_border_color=$('GAL_OPTIONS[photos_border_color]').value;
	var easing_speed=$('easing_speed').value;
	var selected_easing=$('easingEffect').options[$('easingEffect').selectedIndex].value;
	var selected_zoomEffect=$('zoomEffect').options[$('zoomEffect').selectedIndex].value;
	var selected_tags_font_style=$('tags_font_style').options[$('tags_font_style').selectedIndex].value;
	var selected_hover_style=$('hover_text_style').options[$('hover_text_style').selectedIndex].value;
	
	var gal_tags_text_color=$('GAL_OPTIONS[gallery_tags_text_color]').value;
	var gal_tags_bg_color=$('GAL_OPTIONS[gallery_tags_bg_color]').value;
	var gal_tags_margin=$('GAL_OPTIONS[gallery_tags_margin]').value;
	var all_tags_bg_color=$('GAL_OPTIONS[all_tags_bg_color]').value;
	var selected_tags_color=$('GAL_OPTIONS[selected_tags_color]').value;
	var selected_tag_bg_color=$('GAL_OPTIONS[selected_tag_bg_color]').value;
	var tags_font_size=$('GAL_OPTIONS[tags_font_size]').value;
	var mobileColumnCount=$('mobileColumnsCount').value;
	var mobileImagesReduce=$('mobileImagesReduce').value;

	
	<?if ($display_bgupload=="") {
		?>swfu.startUpload();
		<? }	?>
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var pars = 'uploadtype=setProductGallery&isProdGal='+currentProdGal+'&galID='+galID+'&hmargin='+hMargin+'&wmargin='+wMargin+'&tumbsHeight='+tumbsHeight+'&tumbsWidth='+tumbsWidth+'&orderBottom='+orderPhotosBottom+'&galleryFilters='+galleryFilters+'&isDefaultOptions='+options_default;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	setGalAttributeProperty(galID,textPhotoCentered,"centerPhotoText");
	setGalAttributeProperty(galID,photos_text_bg_color,"photos_text_bg_color");
	setGalAttributeProperty(galID,photos_text_color,"photos_text_color");
	setGalAttributeProperty(galID,photos_bg_color,"photos_bg_color");
	setGalAttributeProperty(galID,photos_border_color,"photos_border_color");
	
	setGalAttributeProperty(galID,selected_easing,"CollageEasing");
	setGalAttributeProperty(galID,easing_speed,"CollageEasingSpeed");
	setGalAttributeProperty(galID,selected_zoomEffect,"ZoomEffect");
	setGalAttributeProperty(galID,isGalFixed,"GalFixed");
	
	setGalAttributeProperty(galID,gal_tags_text_color,"gallery_tags_text_color");
	setGalAttributeProperty(galID,gal_tags_bg_color,"gallery_tags_bg_color");
	setGalAttributeProperty(galID,gal_tags_margin,"gallery_tags_margin");
	setGalAttributeProperty(galID,all_tags_bg_color,"all_tags_bg_color");
	setGalAttributeProperty(galID,selected_tags_color,"selected_tags_color");
	setGalAttributeProperty(galID,selected_tag_bg_color,"selected_tag_bg_color");
	setGalAttributeProperty(galID,tags_font_size,"tags_font_size");
	setGalAttributeProperty(galID,selected_tags_font_style,"tags_font_style");
	
	setGalAttributeProperty(galID,is_photo_dimmed,"photo_dimmed");
	setGalAttributeProperty(galID,selected_hover_style,"hover_text_style");
	setGalAttributeProperty(galID,mobileColumnCount,"mobile_columns");
	setGalAttributeProperty(galID,mobileImagesReduce,"mobile_images_reduce");
	setGalAttributeProperty(galID,imagesCropMode,"images_crop_mode");
		
	if (display_bg_upload=="") window.setTimeout('check_if_gallery_pics_finished()',2500);
	else window.setTimeout('ReloadPage()',2500);
}
function showProdUrlKey() {
	var pre_prodUrlARR=$('photo_text').value.split(" ",3);
	if (pre_prodUrlARR[0]) pre_prodUrlStr=pre_prodUrlARR[0];
	if (pre_prodUrlARR[1]) pre_prodUrlStr+=' '+pre_prodUrlARR[1];
	if (pre_prodUrlARR[2]) pre_prodUrlStr+=' '+pre_prodUrlARR[2];
	
	
	if ($('prodUrlKeyLabel').style.display=="") {
		$('prodUrlKeyLabel').style.display="none";
		$('photo_url').disabled=false;
		$('isProductLinked').checked=false;
	}
	else {
		$('prodUrlKeyLabel').style.display="";
		$('photo_url').disabled=true;
		$('isProductLinked').checked=true;
		if (!$('photo_text').value=="" && $('productPageUrlKey').value=="") $('productPageUrlKey').value=pre_prodUrlStr;
	}
}
function updateProdUrlKeyExample(in_text) {
	var boxUrlText=in_text.value;
	boxUrlText=boxUrlText.replace(/ /gi,"-");
	boxUrlText=boxUrlText.replace(/&/gi,"and");
	boxUrlText=boxUrlText.replace(/'/gi,'');
	boxUrlText=boxUrlText.replace(/"/gi,'');
	boxUrlText=boxUrlText.replace(/%/gi,'');
	$('prodUrlKeyExample').innerHTML=boxUrlText;
	
}
function updateGalAttribute(p,v) {
	var gID="<?=$GalID;?>";
	setGalAttributeProperty(gID,v,p);
}
function setDisablePhotosBG() {
	var photos_bg_disabled=0;
	if ($('disablePhotosBG').checked) photos_bg_disabled=1;
	updateGalAttribute("disable_photos_bg",photos_bg_disabled);
}
function setRoundedCornersBG() {
	var rounded_corners_bg=0;
	if ($('rounded_corners_bg').checked) rounded_corners_bg=1;
	updateGalAttribute("rounded_corners_bg",rounded_corners_bg);
}
function setCollageGallery() {
	var is_collage_gallery=0;
	if ($('collage_gallery').checked) is_collage_gallery=1;
	updateGalAttribute("collage_gallery",is_collage_gallery);
}
var currentLock=1;
var tumbsProportion=<?=$tumbsWidth/$tumbsHeight;?>;
function lockPropotionals() {
	if (currentLock==1) {
		document.getElementById("prop_lock_image").src="<?=$SITE[url];?>/Admin/images/unlock_prop_icon.png";
		currentLock=0;
	}
	else {
		document.getElementById("prop_lock_image").src="<?=$SITE[url];?>/Admin/images/lock_prop_icon.png";
		currentLock=1;
	}
}
/*function updateWidthHeight(wh) {
	var h=jQuery("#tumbsheight").val();
	var w=jQuery("#tumbswidth").val();
	if (currentLock==1) {
		if (wh=="width") jQuery("#tumbsheight").val(Math.round(w/tumbsProportion));
		if (wh=="height") jQuery("#tumbswidth").val(Math.round(h*tumbsProportion));
	}
	//updateRealTumbs(jQuery("#tumbswidth").val(),jQuery("#tumbsheight").val());
}*/
function resetWidthHeight() {
	jQuery("#tumbsheight").val(<?=$tumbsHeight;?>);
	jQuery("#tumbswidth").val(<?=$tumbsWidth;?>);
}
function updateRealTumbs(w,h) {
	var newW=parseInt(w)+10;
	jQuery(".boxes li").css("width",newW+"px");
	jQuery(".photoHolder").css("height",h+"px");
	jQuery(".photoHolder").css("width",w+"px");
	jQuery(".photoHolder img").css("max-height",h+"px");
	jQuery(".photoHolder img").css("max-width",w+"px");
}
function EditPhotoFilters(photo_id) {
		var url="<?=$SITE[url];?>/Admin/GetPhotoFilters.php?photoID="+photo_id;
		jQuery("#PhotoFiltersContainer").load(url);
}
function SavePhotoFilters(photo_id,hide_after) {
	var filters_selected;
	var inputStr = '';
	jQuery('#P_FILTERS:checked').each(function(){
		inputStr += '&'+encodeURIComponent(jQuery(this).attr('name'))+'[]='+encodeURIComponent(jQuery(this).val());
	});
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=saveFilters';
	var pars = 'photo_id='+photo_id+inputStr;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	if (hide_after==1) ShowLayer("PicUploader",0,1,1);
}
</script>

<?
include_once("Admin/uploader/uploader_settings.php");
if ($GAL[GalleryName]=="") $GAL[GalleryName]=$ADMIN_TRANS['untitled'];
}
if (!isset($_SESSION['LOGGED_ADMIN']) AND $GAL[GalleryName]==$ADMIN_TRANS['untitled']) $GAL[GalleryName]="";
$h_tag="h1";
if ($pageHasHOne) $h_tag="h2";
?>
		<div class="titleContent_top">
		<?if ($SITE[titlesicon] AND $GAL[GalleryName]) {
			?><div class="titlesIcon"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
			<?
		}
		if ($GAL[GalleryName]) {
			?>
			<<?=$h_tag;?> id="galleryTitle-<?=$GAL[GID];?>"><?=$GAL[GalleryName];?></<?=$h_tag;?>>
		<?
		}
		?>
		</div>
		<div style="clear:both"></div>
<?

if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<br />&nbsp;&nbsp;
	<div id="newSaveIcon" class="add_button"  onclick="AddNewPic();"><i class="fa fa-picture-o"></i> <?=$ADMIN_TRANS['add photos'];?></div>
	
	<span id="delGalButton"><div id="newSaveIcon"  onclick="DelGallery(<?=$GAL[GID];?>)">&nbsp;<i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete gallery'];?></div></span>
	<div id="newSaveIcon"  onclick="EditGalleryOptions(<?=$GAL[GID];?>)">&nbsp;<i class="fa fa-sliders"></i> <?=$ADMIN_TRANS['gallery options'];?></div>
	&nbsp;&nbsp;<span id="editGalButton"><div id="newSaveIcon"  onclick="EditGalleryContent('galleryContent');"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit top content'];?></div></span>
	<div style="height:5px"></div>
	<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('galleryTitle-<?=$GAL[GID];?>', '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=renameGallery', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'galleryTitle-<?=$GAL[GID];?>',formClassName:'titleContent_top'});
	</script>
	<?
}

?>
<div id="galleryContent" style="padding-<?=$SITE[align];?>:7px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=str_ireplace("&lsquo;","'",$GAL[GalleryText]);?></div>
<?
$enable_side_text="none";

if ($show_avaliable_filters==1) {
	if ($GAL_OPTIONS[all_tags_bg_color]) $wrapper_padding="padding-".$SITE[align].":10px";
	?>
	
	<div class="photoGalleryFiltersWrapper" style="<?=$wrapper_padding;?>">
	<?
	for ($f=0;$f<count($G_FILTERS_ARRAY_DISPLAY);$f++) {
		$filterName=$G_FILTERS_ARRAY_DISPLAY[$f];
		$filterNameCoded=str_ireplace("&quot;","",$filterName);
		$filterNameCoded=str_ireplace(" ","-",$filterNameCoded);
		$filterNameCoded=str_ireplace(",","-",$filterNameCoded);
		$filterNameCoded=str_ireplace(".","-",$filterNameCoded);
		
		?>
		<div class="photoGalley_filter mainContentText">
			<div onclick="setButtonFiltered(this);" id="filterID-<?=$f;?>" button-filter="<?=$filterNameCoded;?>"><a href="#!<?=$filterNameCoded;?>/filter-<?=$f;?>"><?=$filterName;?></a></div>
		</div>
		<?
	}
	?>
	<div class="photoGalley_filter mainContentText">
		<div onclick="setButtonFiltered(this)"><a href="#/"><?=$ADMIN_TRANS['show all'];?></a></div>
	</div>
	<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<div class="photoGalley_filter mainContentText" style="opacity: 0.7">
			<div onclick="filterPhotos('NO-DATA-VAL',this);setButtonFiltered(this)"><?=$ADMIN_TRANS['show none'];?></div>
		</div>
		<?
	}
	?>
	
	<div class="clear"></div>
	</div>
	<?
}
?>
	
<div class="clear"></div>
<?
if ($GAL_OPTIONS[collage_gallery] AND !isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<div class="spinner images_loading_waiting"><div class="bo1"></div><div class="bo2"></div><div class="bo3"></div></div>
	<?
}
?>
<ul class="boxes">
<?
$limitPhotosPerPage=count($GAL[PhotoID]);
if ($SITE[mobileEnabled] AND !$GAL_OPTIONS[collage_gallery] AND $mobileDetect->isMobile()) {
	$GAL_OPTIONS[infinite_scroll]=1;
	if ($limitPhotosPerPage>9) $NumPerPage=9;
	else $NumPerPage=$limitPhotosPerPage;
}
$GAL_OPTIONS[infinite_scroll]=0;
if ($GAL_OPTIONS[infinite_scroll] AND $NumPerPage>0 AND !isset($_SESSION['LOGGED_ADMIN']))  $limitPhotosPerPage=$NumPerPage; 
$num_inline=0;

for ($a=0;$a<$limitPhotosPerPage;$a++){
		$num_inline++;
		$last_photo_css="";
		$rel_code="";
		
		if ($num_inline==$numPhotosPerLine AND !isset($_SESSION['LOGGED_ADMIN'])) {
			//$last_photo_css='style="margin-'.$SITE[opalign].':8px"';
			$num_inline=0;
		}
		$photo_alt_text=$GAL[PhotoText][$a];
		if ($GAL[PhotoAlt][$a]) $photo_alt_text=$GAL[PhotoAlt][$a];
		$photo_filter_name=htmlspecialchars($GAL[PhotoFilters][$a]);
		$photo_filter_name=str_ireplace("&quot;","",$photo_filter_name);
		$photo_filter_name=str_ireplace(" ","-",$photo_filter_name);
		$photo_filter_name=str_ireplace(",","-",$photo_filter_name);
		$photo_filter_name=str_ireplace(".","-",$photo_filter_name);
		
		if ($photo_filter_name=="") $photo_filter_name="NO-DATA-VAL";
			$GAL[PhotoUrl][$a]=urldecode($GAL[PhotoUrl][$a]);
		$padding_top_bottom=4;
		$PhotoExternalUrl=$GAL[PhotoUrl][$a];
		$yt_img_url="";
		// if (!is_file($gallery_dir."/tumbs/".$GAL[FileName][$a])) $GAL[FileName][$a]="movies-icon.png";
		// Check if the file exists. if not, display the default image.
		if($GAL[FileName][$a]=="")
			$GAL[FileName][$a]="movies-icon.png";
		
		if (stristr($PhotoExternalUrl,"youtu.be/") OR stristr($PhotoExternalUrl,"youtube.com")) {
			
			$rel_code='rel="shadowbox;width=853;height=480"';
			$GAL[PhotoUrl][$a]=str_ireplace("youtu.be/","youtube.com/embed/",$PhotoExternalUrl);
			$YT_IMG=explode("youtube.com/embed/",$GAL[PhotoUrl][$a]);
			
			if (stristr($PhotoExternalUrl,"youtube.com")) {
				$GAL[PhotoUrl][$a]=str_ireplace("watch?v=","embed/",$PhotoExternalUrl);
				$GAL[PhotoUrl][$a]=str_ireplace("&feature=","?feature=",$GAL[PhotoUrl][$a]);
				$YT_IMG=explode("embed/",$GAL[PhotoUrl][$a]);
			}
			$yt_feature_pos=stripos($YT_IMG[1],"?feature");
			$yt_video_id=$YT_IMG[1];
			if ($yt_feature_pos>0) $yt_video_id=substr($YT_IMG[1],0,$yt_feature_pos);
			$yt_img_url="http://img.youtube.com/vi/".$yt_video_id."/mqdefault.jpg";
			if (!stristr($GAL[PhotoUrl][$a],"?rel=")) $GAL[PhotoUrl][$a]=$GAL[PhotoUrl][$a]."?rel=0";
		}
		if (stristr($PhotoExternalUrl,"vimeo.com/")) {
				$GAL[PhotoUrl][$a]=str_ireplace("vimeo.com/","player.vimeo.com/video/",$PhotoExternalUrl);
				$rel_code='rel="shadowbox;width=720;height=450"';
				$VM_IMG=explode("/video/",$GAL[PhotoUrl][$a]);
				$imgid = $VM_IMG[1];
				if ($GAL[FileName][$a]=="movies-icon.png") {
					$vm_hash = unserialize(file_get_contents("https://vimeo.com/api/v2/video/$imgid.php"));
					$yt_img_url=$vm_hash[0]['thumbnail_large'];
				}
		}
		if (stristr($PhotoExternalUrl,"www.ted.com")) {
			$GAL[PhotoUrl][$a]=str_ireplace("www.ted.com","embed.ted.com",$PhotoExternalUrl);
			$rel_code='rel="shadowbox;width=853;height=480"';
		}
		// If the AWS is enabled load the media from amazon.
		if($AWS_S3_ENABLED){
			$img_src=SITE_MEDIA."/".$gallery_dir."/tumbs/".$GAL[FileName][$a];
			$img_big_src=SITE_MEDIA."/".$gallery_dir."/".$GAL[FileName][$a];
		}
		else{
			$img_src=$SITE[url]."/".$gallery_dir."/tumbs/".$GAL[FileName][$a];
			$img_big_src=$SITE[url]."/".$gallery_dir."/".$GAL[FileName][$a];
		}
		
		if ($yt_img_url AND $GAL[FileName][$a]=="movies-icon.png") $img_src=$img_big_src=$yt_img_url;
		if ($SITE[mobileEnabled] AND !$GAL_OPTIONS[collage_gallery] AND $mobileDetect->isMobile()) $img_src="/images/pixel.png";
		//if ($SITE[mobileEnabled] AND !$GAL_OPTIONS[collage_gallery] AND $mobileDetect->isMobile()) $gridBG='style="background-image:url('.$img_src.');"';
		
		?>

		<li <?=$gridBG;?> data-id="id-<?=$a;?>" id="photo_cell-<?=$GAL[PhotoID][$a];?>" class="portlet div_all" <?=$last_photo_css;?> datavalue='<?=$photo_filter_name;?>' data-src='<?=$img_big_src;?>'>
		<?
		$bottom_rounded_bg_color=$GAL_OPTIONS[photo_bg_color];
		if ($GAL_OPTIONS[photo_text_bg_color] AND $GAL[PhotoText][$a]) $bottom_rounded_bg_color=$GAL_OPTIONS[photo_text_bg_color];
		//if ($GAL_OPTIONS[rounded_corners_bg] AND $GAL_OPTIONS[photo_bg_color]) SetShortContentRoundedCorners(1,0,$GAL_OPTIONS[photo_bg_color],$boxWidth+1);
		
		?>
		
		<?
	
		$GAL[PhotoText][$a]=str_ireplace("\n"," ",$GAL[PhotoText][$a]);
		$GAL[PhotoText][$a]=str_ireplace("\r"," ",$GAL[PhotoText][$a]);
		$text_link=$GAL[PhotoUrl][$a];
		$target="_self";
		if ($text_link AND (strpos($text_link,$SITE[url])===false AND strpos($text_link,"/category/")===false) AND !strpos($text_link,"/")==0) $target="_blank";
		if (!$GAL[PhotoUrl][$a]) $text_link='#';
		
		if ($GAL[isProductLink][$a]==1 AND $GAL[ProductUrlKey][$a]) $GAL[PhotoUrl][$a]=$SITE[url]."/".$GAL[ProductUrlKey][$a];
		if ($GAL[PhotoText][$a] AND $GAL_OPTIONS[photo_text_bg_color]) $padding_top_bottom=3;
		if (!$GAL[PhotoText][$a] AND $GAL_OPTIONS[photo_text_bg_color]) $padding_top_bottom=0;
		
		
		?>
		<div class="inside_div">
		<div !class="photoWrapper custom" align="center" id="wrapper-<?=$a;?>">
			
			<?
			if (!isset($_SESSION['LOGGED_ADMIN'])) {
				if (!$GAL[PhotoUrl][$a]) {
					
					$picCursorStyle="pointer";
				?>
				<a title="<?=strip_tags($photo_alt_text);?>" class="<?=$lightBoxClass;?>"  href="<?=SITE_MEDIA."/".$gallery_dir."/".$GAL[FileName][$a];?>?<?=time();?>" data-fancybox-group="thumb">
				<!--<span class="gallery_zoom_hover"></span>-->
			
			<?
				}
				else {
					$picCursorStyle="default";
					if ($GAL[PhotoUrl][$a]!="#") {
						
						$picCursorStyle="pointer";
						?><a title="<?=$photo_alt_text;?>"  href="<?=$GAL[PhotoUrl][$a];?>" target="<?=$target;?>" <?=$rel_code;?>>
							
						<?
						if ($rel_code!="") print '<div class="video_button" id="vid_but-'.$a.'"></div>';
					}
				}
			}
			$attr_photo="src";
			if (!$GAL_OPTIONS[collage_gallery]) {
				$attr_photo="data-src"; 
				$src_loading='src="'.$SITE[cdn_url].'/images/pic_loading.png"';
			}
			?>
			<div class="tumbs">
				<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {
			$edit_controlsSpace=$tumbsWidth+9;
			if ($tumbsMargin<40) $edit_controlsSpace=$tumbsWidth;
			$PHOTOPRODURL=explode('product/',$GAL[ProductUrlKey][$a]);
			$photoProdUrlKey=$PHOTOPRODURL[1];
			$isProdPageChecked=$GAL[isProductLink][$a];
			?>
			


			<div  align="center" >
				<span style="float:right; padding-top:50px" class="EditPhotoIcon">
					<i class="button fa fa-pencil-square-o" onclick="EditPhotoDetails('<?=$PhotoExternalUrl;?>','<?=htmlspecialchars(html_entity_decode($GAL[PhotoText][$a]));?>',<?=$GAL[PhotoID][$a];?>,'<?=$photoProdUrlKey;?>',<?=$isProdPageChecked;?>,'<?=htmlspecialchars(html_entity_decode($GAL[PhotoAlt][$a]));?>')"  src="<?=$SITE[url];?>/Admin/images/editIcon_new.png" border="0"   title="<?=$ADMIN_TRANS['edit photo'];?>"></i>
				</span>
				<span style="float:left; padding-top:50px">
					<i class="button fa fa-trash-o" onclick="DelPhoto(<?=$GAL[PhotoID][$a];?>)" src="<?=$SITE[url];?>/Admin/images/delIcon_new.png" border="0" align="absmiddle"  title="<?=$ADMIN_TRANS['delete'];?>"></i>
				</span>
			</div>

			<?
		}
?>
				<figure id="img-<?=$GAL[PhotoID][$a];?>" style="background-image:url(<?=$img_src;?>);" class="bg" data-tumb="<?=$img_src;?>"></figure>
			</div>
			<?
			if ($GAL[PhotoUrl][$a]!="#") print '</a>';?>
		</div>
		
	
		
		
</div>
		<div style="height:0px; box-sizing:border-box;">
		<? $GAL[PhotoText][$a]=trim($GAL[PhotoText][$a]);
		if ($GAL[PhotoText][$a]) {
		?>
			<div class="photoName">
			<?
			if ($GAL[PhotoUrl][$a] AND $GAL[PhotoUrl][$a]!="#") print '<a href="'.$GAL[PhotoUrl][$a].'" target="'.$target.'" '.$rel_code.'>';
			print $GAL[PhotoText][$a];
			if ($GAL[PhotoUrl][$a] AND $GAL[PhotoUrl][$a]!="#") print '</a>';
			?>
			</div>
		</div>
		<?
		}
		//if ($GAL_OPTIONS[rounded_corners_bg] AND $GAL_OPTIONS[photo_bg_color]) SetShortContentRoundedCorners(0,0,$bottom_rounded_bg_color,$boxWidth+1);
		
		
		?>
		</li>
		<?
	}
	?>
</ul>
<div style="clear:<?=$SITE[align];?>"></div>

<script type="text/javascript" src="<?=$SITE['cdn_url'];?>/js/jquery.matchHeight-min.js"></script>
		<script>
		jQuery(window).load(function() {
			if (jQuery(window).width()>680) {
		
		jQuery('.boxes .inside_div').matchHeight();

	}	
	
});
</script>

<!--Here comes Gallery Bottom Text-->
<div class="clear"></div>

<? 
$bottomTextMargin=5;
if ($tumbsMarginHeight<0) $bottomTextMargin=-($tumbsMarginHeight)+5;

?>
<div class="clear" style="margin-top:<?=$bottomTextMargin;?>px"></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<br />&nbsp;&nbsp;
	<div id="newSaveIcon"  onclick="EditGalleryContent('galleryContentBottom');"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit content under photos'];?></div>
	<div style="height:5px"></div>
	
	<?
}
?>

<div id="galleryContentBottom" style="padding-<?=$SITE[align];?>:7px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=str_ireplace("&lsquo;","'",$GAL[GalleryBottomText]);?></div>
<!--end Here comes Gallery Bottom Text-->
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	include_once("Admin/colorpicker.php");
	?>
	<div style="width:620px;display:none;" id="GalPageOptions" class="CatEditor settings_slider"  dir="<?=$SITE[direction];?>">
		<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="EditGalleryOptions(<?=$GAL[GID];?>)">+</div>
			<div class="title"><strong><?=$ADMIN_TRANS['gallery options'];?></strong></div>
		</div>
		<div class="CenterBoxContent">
		<div style="float: <?=$SITE[align];?>;width:355px">
		<div>
			<span style="display:<?=$enable_side_text;?>">
				<input id="sideTextGal" type="checkbox" <?=$isSideTextChecked;?> />&nbsp;<?=$ADMIN_TRANS['show text right to images'];?>&nbsp;&nbsp;&nbsp;
			</span>
			<input id="orderPhotos" type="checkbox" <?=$isOrderBottom;?> /><?=$ADMIN_TRANS['order by first'];?>&nbsp; &nbsp;
			<input id="centerTextUnderPhotos" type="checkbox" <?=$isTextCentered;?> /><?=$ADMIN_TRANS['center text under photos'];?><br />
			<input id="disablePhotosBG" type="checkbox" <?=$isPhotosBG_DISABLED;?> onclick="setDisablePhotosBG()" /><?=$ADMIN_TRANS['disable photos bg'];?>
			<span style="margin-<?=$SITE[align];?>:26px"><input id="rounded_corners_bg" type="checkbox" <?=$isRoundedCorners;?> onclick="setRoundedCornersBG()" /><?=$ADMIN_TRANS['rounded corners'];?></span>
			
			
			
		</div>
			 
		<table border="0" cellspacing="2">
			<tr><td colspan="10"></td></tr>
			<tr>
			<td><?=$ADMIN_TRANS['tumbnail size'];?></td>
			<td>W<input type="text" maxlength="3" value="<?=$tumbsWidth;?>" name="tumbswidth" id="tumbswidth" style="width:30px;direction:ltr;text-align: center" onkeyup="updateWidthHeight('width');"/>x<input  type="text" maxlength="3" value="<?=$tumbsHeight;?>" name="tumbsheight" id="tumbsheight" style="width:30px;direction:ltr;text-align: center" onkeyup="updateWidthHeight('height');" />H
			&nbsp; <span style="cursor:pointer" onclick="resetWidthHeight();" title="reset"><img src="<?=$SITE[url];?>/Admin/images/reset_prop_icon.png" border="0"></span>
			<br>
			<span id="lock_prop" onclick="lockPropotionals()" style="margin-<?=$SITE[align];?>:28px"><img id="prop_lock_image" src="<?=$SITE[url];?>/Admin/images/lock_prop_icon.png" border="0"></span>
			</td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['margin between photos'];?>(W)</td>
			<td><input type="text" maxlength="3" value="<?=$tumbsMargin;?>" name="wmargin" id="wmargin" style="width:30px;direction:ltr"/>&nbsp;<small>(<?=$ADMIN_TRANS['width in pixels'];?>)</small></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['margin between photos'];?>(H)</td>
			<td><input  type="text" maxlength="3" value="<?=$tumbsMarginHeight;?>" name="hmargin" id="hmargin" style="width:30px;direction:ltr" />&nbsp;<small>(<?=$ADMIN_TRANS['height in pixels'];?>)</small></td>
			</tr>
			<tr style="display:<?=$SITE[mobileEnabled] ? '' : 'none';?>">
			<td><?=$ADMIN_TRANS['columns count in mobileview'];?></td>
			<td><input  type="text" maxlength="3" value="<?=$GAL_OPTIONS[mobile_columns];?>" name="mobileColumnsCount" id="mobileColumnsCount" style="width:30px;direction:ltr" /></td>
			</tr>
			<tr style="display:<?=$SITE[mobileEnabled] ? '' : 'none';?>">
			<td><?=$ADMIN_TRANS['reduce image size in mobile to:'];?></td>
			<td><input  type="text" maxlength="3" value="<?=$GAL_OPTIONS[mobile_images_reduce];?>" name="mobileImagesReduce" id="mobileImagesReduce" style="width:30px;direction:ltr" maxlength=3 />%</td>
			</tr>
			
			<tr>
			
				<td colspan="2"></td>
			</tr>
				
			<tr style="display:<?=$display_bgupload;?>">
				<td colspan="2"><?=$ADMIN_TRANS['gallery background image'];?>: 				
					<span id="photoBG_spanButtonPlaceHolder" style="cursor:pointer"></span>
					<input id="photoBG_btnCancel" type="button" value="Cancel All" onclick="swfu.cancelQueue();" disabled="disabled" />
					<?
					
					if ($GAL[TumbsBGPic]) {
							?><span class="button" onclick="delTumbsBG()" style="color:red"><?=$ADMIN_TRANS['delete photo'];?></span><?
					}
					?>
					<div class="fieldset flash" id="photoBG_fsUploadProgress"></div>
					<div id="divStatus" dir="ltr"></div>
				</td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['photos bg color'];?>: </td><td><?PickColor("GAL_OPTIONS[photo_bg_color]",$GAL_OPTIONS[photo_bg_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['photos text bg color'];?>: </td><td><?PickColor("GAL_OPTIONS[photo_text_bg_color]",$GAL_OPTIONS[photo_text_bg_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['photos border color'];?>: </td><td><?PickColor("GAL_OPTIONS[photos_border_color]",$GAL_OPTIONS[photos_border_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['photos text border color'];?>: </td><td><?PickColor("GAL_OPTIONS[photo_text_border_color]",$GAL_OPTIONS[photo_text_border_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['photos text color'];?>: </td><td><?PickColor("GAL_OPTIONS[photo_text_color]",$GAL_OPTIONS[photo_text_color]);?></td>
			</tr>
			<tr><td colspan="10" style="height:8px"></td></tr>
			<tr>
			<td colspan="2"><input id="collage_gallery" type="checkbox" <?=$isCollageGallery;?> onclick="setCollageGallery()" />&nbsp;<?=$ADMIN_TRANS['collage gallery'];?></td>
			</tr>
			<tr>
			<td style="width:160px;"><?=$ADMIN_TRANS['collage effect'];?>: </td>
                            <td>
                                <select name="easingEffect" id="easingEffect" value="<?=$GAL_OPTIONS[CollageEasing];?>" style="width:75px">
                                    <?
                                    for ($e=0;$e<count($EASINGS);$e++) {
					print '<option value='.$EASINGS[$e].' '.$selected_easing[$EASINGS[$e]].'>'.$EASINGS[$e].'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
			</tr>
                        <tr>
			<td style="width:160px;"><?=$ADMIN_TRANS['slides speed'];?>: </td><td><input class="StyleEditFrm" name="easing_speed" id="easing_speed" value="<?=$GAL_OPTIONS[CollageEasingSpeed];?>" type="text" style="width:75px"></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['large photo enlarge style'];?>:</td>
				<td>
				 <select name="zoomEffect" id="zoomEffect" value="<?=$GAL_OPTIONS[ZoomEffect];?>" style="width:75px">
                                    <option value="lightbox" <?=$selected_Zoom[lightbox];?>>LightBox</option>
                                    <option value="fancybox" <?=$selected_Zoom[fancybox];?>>FancyBox</option>
                                    <option value="fancyboxtumbs" <?=$selected_Zoom[fancyboxtumbs];?>>FancyBox With Tumbs</option>
                                    <option value="fancyboxfullscreen" <?=$selected_Zoom[fancyboxfullscreen];?>>FancyBox Full Screen Zoom</option>
                                </select>
				</td>
			</tr>
			<tr style="display:<?=$display_bgupload;?>">
			<td colspan="3">
				<input type="checkbox" name="gal_is_fixed" id="gal_is_fixed" <?=$isGalFixedChecked;?>> Fix Gallery Container
			</td>
			</tr>
			<tr>
				
				<td colspan="3"><input type="checkbox" id="is_photo_dimmed" name="is_photo_dimmed" <?=$isHoverPhotoDimmed;?>>
				<?=$ADMIN_TRANS['colorize photos on hover'];?>
				</td>
				
			</tr>
			<tr>
				
				<td colspan="3"><input type="checkbox" id="crop_mode" name="crop_mode" <?=$isImagesCropMode;?>>
				<i class="fa fa-crop"></i> <?=$ADMIN_TRANS['crop tumbs images'];?>
				</td>
				
			</tr>
			<tr>
				<td><?=$ADMIN_TRANS['photos text appearance'];?>:</td>
				<td>
					<select name="hover_text_style" id="hover_text_style">
						<?
						for ($a=0;$a<count($HOVERTEXTSTYLES);$a++) {
							?>
							<option value="<?=$a;?>" <?=$HOVER_STYLE_SELECTED[$a];?>><?=$HOVERTEXTSTYLES[$a];?></option>
							<?
						}
						?>
					</select>
				</td>
			</tr>
		</table>
		</div>
		<div style="float: <?=$SITE[opalign];?>;width:228px;"><!--filtering options-->
		<strong><?=$ADMIN_TRANS['gallery filter tags'];?></strong><br><small><?=$ADMIN_TRANS['enter each tag in new line'];?></small>
		<textarea name="filters_name" id="filters_name" style="padding:3px;width:210px;height:160px;border: 1px solid silver;font-family:arial"><?=$GALLERY_FILTERS_STR;?></textarea>
		<br />
		<table>
			<tr>
			<td><?=$ADMIN_TRANS['all tags background color'];?>: </td><td><?PickColor("GAL_OPTIONS[all_tags_bg_color]",$GAL_OPTIONS[all_tags_bg_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['tags text color'];?>: </td><td><?PickColor("GAL_OPTIONS[gallery_tags_text_color]",$GAL_OPTIONS[gallery_tags_text_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['tags background color'];?>: </td><td><?PickColor("GAL_OPTIONS[gallery_tags_bg_color]",$GAL_OPTIONS[gallery_tags_bg_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['selected tags color'];?>: </td><td><?PickColor("GAL_OPTIONS[selected_tags_color]",$GAL_OPTIONS[selected_tags_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['selected tag bg color'];?>: </td><td><?PickColor("GAL_OPTIONS[selected_tag_bg_color]",$GAL_OPTIONS[selected_tag_bg_color]);?></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['tags font size'];?>: </td><td><input type="text" maxlength="3" value="<?=$GAL_OPTIONS[tags_font_size];?>" name="GAL_OPTIONS[tags_font_size]" id="GAL_OPTIONS[tags_font_size]" style="width:51px;direction:ltr;border:1px solid silver"/></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['font style'];?>: </td>
				<td>
				<select id="tags_font_style" name="tags_font_style">
					<?
					for ($a=0;$a<count($TAGS_FONT_STYLES);$a++) {
						?>
						<option value=<?=$a;?> <?=$TAGS_FONT_STYLE_SELECTED[$a];?>/><?=$TAGS_FONT_STYLES[$a];?></option>
						<?
					}
					?>
				</select>
				</td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['margin between tags'];?>(px): </td><td><input type="text" maxlength="3" value="<?=$GAL_OPTIONS[gallery_tags_margin];?>" name="GAL_OPTIONS[gallery_tags_margin]" id="GAL_OPTIONS[gallery_tags_margin]" style="width:71px;direction:ltr;border:1px solid silver"/></td>
			</tr>
		</table>
		
		</div>
		<div style="clear:both"></div>
		<div style="margin:5px;"><?=$ADMIN_TRANS['set as default options'];?>: </td><td><input type="checkbox" name="is_default_options" id="is_default_options" value=1 <?=$is_default_options_checked;?> /></div>
		
		

	</div>
	<div class="saveButtonsNew">
			<div id="newSaveIcon" class="greenSave" onclick="SaveGalPageOptions(<?=$GAL[GID];?>)"><img align="absmiddle" src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" /><?=$ADMIN_TRANS['save changes'];?></div>
			<div id="newSaveIcon" class="cancel" onclick="EditGalleryOptions(<?=$GAL[GID];?>)"><?=$ADMIN_TRANS['cancel'];?></div>
	</div>
	</div>
	<div style="width:886px;display:none;z-index:1100;position:absolute;top:150px;" id="PicUploader" class="CatEditor Center CenterBoxWrapper" align="center" dir="<?=$SITE[direction];?>">
	<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="AddNewPic()">+</div>
		<div class="title"><strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong></div>
	</div>
<div class="CenterBoxContent">
<div style="float:<?=$SITE[align];?>;width:178px;margin-<?=$SITE[opalign];?>:24px;" id="PhotoPreview"><strong><?=$ADMIN_TRANS['edit photo'];?></strong>
	<div id="photoPreviewDisplay" style="margin-top:8px"></div>
	<div style="margin-top:10px;"></div>
	<div id="newSaveIcon" class="advancedEditorButton" style="display: <?=$showAdvancedEditButton;?>"><i class="fa fa-magic"></i> <?=$ADMIN_TRANS['advanced photo editor'];?></div>
</div>
<div style="margin-top: 5px"></div>
<div style="float:<?=$SITE[align];?>;width:440px;" id="GeneralUploader">
	<form id="GalleryPicUpload" method="post" onsubmit="return false;">
	 <div style="float:<?=$SITE[align];?>"><?=$ADMIN_TRANS['browse to upload photo'];?></div>
	 <div style="clear:both"></div>
	 <span id="photo_spanButtonPlaceHolder" style="cursor:pointer;float:<?=$SITE[align];?>"></span>
	 <div id="newSaveIcon" class="greenSave" onclick="SaveNewUrl()" style="float:<?=$SITE[opalign];?>;margin-<?=$SITE[opalign];?>:10px;"><i class="fa fa-cloud-upload"></i> <?=$ADMIN_TRANS['upload and save'];?></div>
	<div class="fieldset flash" id="photo_fsUploadProgress">
	</div>
	<div id="divStatus" dir="ltr" style="clear:both"></div> <!--Added 8.10.12-->
	
	<div style="margin-top:5px"></div>
       	<div align="<?=$SITE[align];?>" class="galleryInputText"><label><?=$ADMIN_TRANS['text under photo'];?>:</label><br><textarea id="photo_text" rows="4" name="photo_text" style="width:97%;font-family:arial" maxlength="250" onkeyup="return ismaxlength(this)"/></textarea></div>
       	<div style="margin-top:5px"></div>
	<div align="<?=$SITE[align];?>" class="galleryInputText" id="alt_photo_label"><label><?=$ADMIN_TRANS['photo alt text'];?>(ALT):</label><br><textarea id="photo_alt_text" name="photo_alt_text" style="width:97%;font-family:arial" maxlength="150"/></textarea></div>
	<div style="margin-top:5px"></div>
       	<div align="<?=$SITE[align];?>" class="galleryInputText"><label><?=$ADMIN_TRANS['external link'];?>:</label><br><input style="direction:ltr;width:97%;height:18px;" type="text" id="photo_url" name="photo_url"/>
       	<div style="color:silver">למשל : http://www.mywebsite.com/?v=3gsj5</div>
	
       	</div>
     	<div style="text-align:<?=$SITE[align];?>" class="galleryInputText">
     		<a onclick="showProdUrlKey()"><input type="checkbox" name="isProductLinked" id="isProductLinked"> <?=$ADMIN_TRANS['link to product page'];?></a>
     		<div style="display:none" id="prodUrlKeyLabel"><input type="text" style="width:98%" name="productPageUrlKey" id="productPageUrlKey" onkeyup="updateProdUrlKeyExample(this)">
     			<div style="color:gray;font-size:11px;text-align:left;direction:ltr"><?=$SITE[url];?>/product/<span id="prodUrlKeyExample"></span></div>
     		</div>
     		<br>
     	</div>
		<div id="newSaveIcon" class="greenSave" onclick="SaveNewUrl()" style="float: <?=$SITE[opalign];?>;margin-<?=$SITE[opalign];?>:10px"><i class="fa fa-cloud-upload"></i> <?=$ADMIN_TRANS['upload and save'];?></div>
		<div id="newSaveIcon" class="cancel" onclick="AddNewPic()" style="max-width:165px;"><?=$ADMIN_TRANS['cancel'];?></div>
	
	<input type="hidden" name="galleryID" value="<?=$GAL[GID];?>">
	</form>
	
</div>
<div id="PhotoFiltersDiv" style="float:<?=$SITE[opalign];?>;width:230px">
	<strong><?=$ADMIN_TRANS['photo tags'];?></strong><br>
	<div id="PhotoFiltersContainer"></div>
	<input class="saveContentButton" type="button" value="<?=$ADMIN_TRANS['save photo tags'];?>" onclick="SavePhotoFilters(edit_photo_id,1)"; />
</div>
<div style="clear: both"></div>
	<div id="uploading" dir="ltr" align="center"></div>
</div>
</div>
	<div dir="<?=$SITE_LANG[direction];?>" id="lightEditorContainer" style="display:none;z-index:1100;padding:10px;background-color:#E0ECFF;border:3px solid #C3D9FF;position:fixed;top:100px;width:auto;"></div>
	<?
}

//if ($show_avaliable_filters==1 OR $GAL_OPTIONS[collage_gallery]) {
	?>
	<script>
	function animateMason() {
		jQuery(".boxes").css("display","block");
		$listContainer.isotope('reLayout');
	}
	jQuery(document).ready(function(){
		if (this_is_collage_gal==0) jQuery(".boxes li .photoWrapper img.desaturate").lazy({enableThrottle: true,throttle: 100,effect:'fadeIn',effectTime:400,threshold:30});

	});
	$listContainer=jQuery('.boxes');
	<?if(!isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		jQuery(document).ready(function() {
			if (location.hash) jQuery(window).trigger('hashchange');
				else	{
					filterPhotos('',null);
					window.setTimeout('animateMason()',440);
				}
			jQuery(".video_button").show();
		})
		
		
		<?}?>
	</script>
	<?
//}
if ($GAL_OPTIONS[collage_gallery] AND !isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script>
	//hideMe();
	//jQuery(document).ready(function() {
		var short_cont_container=jQuery('.boxes');
		short_cont_container.imagesLoaded(function() {
			jQuery(".boxes").css("display","block");
			jQuery(".images_loading_waiting.spinner").remove();
			
			if (collage_animated=="true") {
				window.setTimeout('goMason()',150);
				window.setTimeout('animateMason()',440);
			}
			else goMasonNoEffect();
		});
    //   });	
	</script>
	
	<?
}
if ($GAL_OPTIONS[collage_gallery] AND isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script>
	var short_cont_container=jQuery('.boxes');
	short_cont_container.imagesLoaded(function() {
		goMasonAdminMode();
	});

	</script>
	<?
}
?>

<?
	if ($GAL_OPTIONS[hover_text_style]>0) {
		?>
		<style>
		ul.boxes li .photoName{padding-top: 10px;padding-bottom: 10px;position: relative;opacity: 0.8;}
		</style>
		
		<?if (!isset($_SESSION['LOGGED_ADMIN'])) {
			?>
			<style>ul.boxes li .photoName {display: none}</style>
			<script>
			jQuery(".boxes li").hover(function() {
			jQuery(this).find(".photoName").css("margin-top","-"+(jQuery(this).find(".photoName").height()+17)+"px");
			jQuery(this).find(".photoName").slideDown({duration:300});
			<?if ($GAL_OPTIONS[hover_text_style]==2) {
				?>
				jQuery(this).find(".photoHolder").animate({marginTop:'-10px'});
				<?
			}
			?>
			
			
			},function() {
				jQuery(this).find(".photoName").slideUp({duration:300});
				
				<?if ($GAL_OPTIONS[hover_text_style]==2) {
					?>
					jQuery(this).find(".photoHolder").animate({marginTop:'10px'});
					<?
				}
			?>
				
			});
			</script>
		<?
		}
	}
	
	if ($GAL_OPTIONS[photo_dimmed]) {
		?>
		<style>
		ul.boxes li .photoWrapper img {
			opacity: 0.7;filter:gray;
			-webkit-filter:grayscale(100%);
			-moz-filter:grayscale(100%);
			transition:all 0.5s;
		}
		ul.boxes li:hover .photoWrapper img {
			opacity: 1;
			filter:none;
			-webkit-filter:grayscale(0%);
			-moz-filter:grayscale(0%);
		}
		</style>
		<?
	}
	
	?>
</script>

<script src="<?=$SITE[cdn_url];?>/js/jquery.lazy.min.js"></script>
