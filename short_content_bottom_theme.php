<?

$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
$axis="x,y";

$is_rounded_checked=$is_default_options_checked=$is_titles_above_checked="";
$is_rounded=0;
// global $SITE_MEDIA;
$ADMIN_TRANS['crop tumbs images']="Crop Tumbs images";
$ADMIN_TRANS['search html code']="Search box embed code";
if ($SITE_LANG[selected]=="he") {
	$ADMIN_TRANS['crop tumbs images']="חתוך את התמונות הקטנות במקום להקטין אותן";
	$ADMIN_TRANS['search html code']="קוד הטמעת תיבת חיפוש לפי תגיות";
}
if ($SITE_LANG[selected]=="he") $ADMIN_TRANS['crop tumbs images']="חתוך את התמונות הקטנות במקום להקטין אותן";
$CONTENT_OPTIONS=json_decode($P_DETAILS[Options]);
$P_DETAILS[ContentPhotoBGColor]=$CONTENT_OPTIONS->ContentPicBGColor;
$P_DETAILS[ContentTextBGColor]=$CONTENT_OPTIONS->ContentTextBGColor;
$P_DETAILS[ContentTextColor]=$CONTENT_OPTIONS->ContentTextColor;
$P_DETAILS[TitlesColor]=$CONTENT_OPTIONS->TitlesColor;
$P_DETAILS[NumBriefsShow]=$CONTENT_OPTIONS->NumBriefsShow;
$P_DETAILS[FullLineBriefWidth]=$CONTENT_OPTIONS->FullLineBriefWidth;
$P_DETAILS[ContentBorderColor]=$CONTENT_OPTIONS->ContentBorderColor;
$P_DETAILS[ContentMinHeight]=$CONTENT_OPTIONS->ContentMinHeight;
$P_DETAILS[isContentRoundCorners]=$CONTENT_OPTIONS->ContentRoundCorners;
$P_DETAILS[PhotosBorderColor]=$CONTENT_OPTIONS->PhotosBorderColor;
$P_DETAILS[isTitlesAbove]=$CONTENT_OPTIONS->isTitlesAbove;
$P_DETAILS[show_pinterest_button]=$CONTENT_OPTIONS->ShowPinterestButton;
if ($CONTENT_OPTIONS->images_crop_mode==1) $cropModeChecked="checked";
if ($P_DETAILS[isContentRoundCorners]==1 OR ($P_DETAILS[isContentRoundCorners]==0 AND $SITE[roundcorners]==1)) {
	$is_rounded_checked="checked";
	$is_rounded=1;
}
if ($P_DETAILS[isDefaultOptions]==1) $is_default_options_checked="checked";
if ($P_DETAILS[isTitlesAbove]==1) $is_titles_above_checked="checked";
if ($P_DETAILS[show_pinterest_button]==1) $showPinterestButton_check="checked";
$boxWidth=$SITE[galleryphotowidth];
$boxHeight=$SITE[galleryphotoheight];
$ContentMinHeight=5;
if ($P_DETAILS[ContentPhotoWidth]>0) $boxWidth=$P_DETAILS[ContentPhotoWidth];
if ($P_DETAILS[ContentPhotoHeight]>0) $boxHeight=$P_DETAILS[ContentPhotoHeight];
if ($P_DETAILS[ContentMarginW]=="") {
	$P_DETAILS[ContentMarginW]=6;
}
$tumbsWidth=$boxWidth;//for fields value
$tumbsHeight=$boxHeight;
if ($P_DETAILS[ContentMarginH]=="") $P_DETAILS[ContentMarginH]=10;
if($P_DETAILS[ContentBGColor]) $SITE[shortcontentbgcolor]=$P_DETAILS[ContentBGColor];



$topRoundedCornersColor=$bottomRoundedCornersColor=$SITE[shortcontentbgcolor];
if ($P_DETAILS[ContentPhotoBGColor]) $topRoundedCornersColor=$P_DETAILS[ContentPhotoBGColor];
if ($P_DETAILS[ContentTextBGColor]) $bottomRoundedCornersColor=$P_DETAILS[ContentTextBGColor];


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
		else if($width_six<892) 
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

$numrows=$CONTENT_OPTIONS->number_columns;
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

.div100p{ width:100%;  clear:both; float:<?=$SITE[align];?>; !background:#ccc;}
.div_all{width:<?=$allPrecent;?>%;  float:<?=$SITE[align];?>;  padding:<?=($P_DETAILS[ContentMarginW]);?>px;  box-sizing:border-box;  font-family: <?=$SITE[cssfont];?>;}
.inside_div{width: 100%;  background-color:#<?=$SITE[shortcontentbgcolor];?>; padding:0px;  box-sizing:border-box; float:<?=$SITE[align];?>; <?=$P_DETAILS[ContentBorderColor] ? 'border: 1px solid;border-color:#'.$P_DETAILS[ContentBorderColor] : 'border:0px;';?>}
.inside_div img{ width: 100%;  }
.top_tit{padding:5px; }
.bg{ width:100%; height:120px; padding:0px 5px; box-sizing:border-box; margin: 0px; background-size: cover; background-position: center; background-repeat: no-repeat;}
.inside_div h2{margin: 0px; padding: 0px; font-size: 17px; color:#<?=$P_DETAILS[TitlesColor];?>;}
.inside_div h2 a {
	<?if ($P_DETAILS[TitlesColor]) {
		?>
		color:#<?=$P_DETAILS[TitlesColor];?>;
	<?}?>
}

.customContentStyle {}
.content{padding: 5px;  text-align:<?=$SITE[align];?>;}
.content p{margin: 0px; padding: 0px 0px 5px 0px; font-size: 15px; line-height: 20px;
	<?if ($P_DETAILS[ContentTextColor]) {
		?>
		color:#<?=$P_DETAILS[ContentTextColor];?>;
		
	<?}?>
	
}
.content p img {max-width: 100%;height:auto !important;}
.tumbs {width:100%;  padding:5px; background-color:#<?=$P_DETAILS[ContentPhotoBGColor];?>; box-sizing:border-box;}
.wide100{ width:100%; padding:5px; box-sizing:border-box; margin: 0px; }
.wideclass100{ width:100%; padding:5px; box-sizing:border-box; margin: 0px; }
.wideclass100 .tumbs{visibility: hidden;}

.wideclass100Foto{ width:100%; padding:5px; box-sizing:border-box; margin: 0px; }
.wideclass100Foto .tumbs{width:15%; float:<?=$SITE[align];?>;}
.wideclass100Foto .content{float:<?=$SITE[align];?>; width:85%; box-sizing:border-box; text-align:<?=$SITE[align];?>;}


@media screen and (max-width: 1350px) {
.main_box{width:100%; } 
.

}
@media screen and (max-width: 1200px) {
  .div_all{
  	<?if ($numrows==10 || $numrows==9 || $numrows==8 || $numrows==7) { ?>width:<?=$respon_d;?>%; <?}?>}
  .wideclass100Foto .tumbs{width:100%; }
.wideclass100Foto .content{ width:100%; }	
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
<style type="text/css">
.custom {
	width:<?=($boxWidth);?>px;
	height:<?=$boxHeight;?>px;
	
}
.custom img {
	max-width:<?=($boxWidth);?>px;
	max-height:<?=$boxHeight;?>px;
}
.customTitleStyle, .customTitleStyle a {
	<?if ($P_DETAILS[TitlesColor]) {
		?>
		color:#<?=$P_DETAILS[TitlesColor];?>;
	<?}?>
	
}
.customTitleStyle {
	padding-<?=$SITE[opalign];?>:3px;
}
.customContentStyle {
	<?if ($P_DETAILS[ContentTextColor]) {
		?>
		color:#<?=$P_DETAILS[ContentTextColor];?>;
		
	<?}?>
}
<?
if ($P_DETAILS[ContentPhotoBGColor]) {
	?>
	.photoWrapper, .photoHolder {background-color:#<?=$P_DETAILS[ContentPhotoBGColor];?>;}
	.photoHolder {background-image:none;}
	<?
}
if ($P_DETAILS[PhotosBorderColor]) {
	?>
	.photoHolder {border:1px solid #<?=$P_DETAILS[PhotosBorderColor];?>;}
	<?
	if ($P_DETAILS[isContentRoundCorners]==1 AND !$P_DETAILS[PhotosBorderColor]) {
		?>
		.photoHolder {border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;-moz-border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;}
		<?
	}
	
}
if (ieversion()<=8 AND ieversion()>0) {
	?>
	.photoWrapper {display:inline;line-height:<?=$boxHeight;?>px;}
	.photoWrapper img {vertical-align:middle;}
	<?
}
?>
</style>

<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
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
	</style>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/uploader.js"></script>
	
		<script type="text/javascript">
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
		   jQuery.get("<?=$SITE[url];?>/Admin/saveAdvancedPhotoEdit.php",{url:newURL,photo_id:currentEditedPhotoID,type:'short_content',catID:<?=$CHECK_CATPAGE[parentID];?>}); 
		   featherEditor.close();
			},
			//postUrl: '<?=$SITE[url];?>/Admin/saveAdvancedPhotoEdit.php?type=short_content&catID=<?=$CHECK_CATPAGE[parentID];?>',
			onError: function(errorObj) {
			    alert(errorObj.message);
			}
		    });

		function AddNewArticlePic(item_id,alt_text,edit_photo) {
		upload_global_type="articlepic";
		currentPhotoID=item_id;
		var alt_text_decoded=decodeURIComponent(alt_text);
		jQuery("#PhotoPreview").hide();
		if (edit_photo==1) {
			var photo_src_location=jQuery("figure#photo_img_"+item_id).attr("data-tumb-url");
			var currentImgTagForEditor=jQuery('<img id="aviary_edited_img_'+item_id+'">');
			currentImgTagForEditor.attr('src',photo_src_location);
			currentImgTagForEditor.css("display","none");
			currentImgTagForEditor.appendTo("body");
			jQuery("#PhotoPreview").show();
			
			
			var big_photo_src_location=photo_src_location.replace("articles/","");
			jQuery("#photoPreviewDisplay").css("background-image",'url('+photo_src_location+')');
			jQuery(".advancedEditorButton").click(function() {
				return launchAdvancedPhotoEditor("aviary_edited_img_"+item_id, big_photo_src_location,currentPhotoID);

			});
		}
		jQuery("#photo_alt_text").val(alt_text_decoded);
		if (document.getElementById("PicUploader").style.display=="none") {
			ShowLayer("PicUploader",1,1,0);
			showuploader(allowed_photo_types,1,buttonID,cancelButtonID,progressTargetID,0);
			$('itemID').value=item_id;
			
		}
		else {
			if (NewPicAdding==1) {
				ShowLayer("PicUploader",0,1,0);
				jQuery("#lightEditorContainer").css("z-index","1100");
				if (itemID==-1) NewPicAdding=0;
			}
			else ShowLayer("PicUploader",0,1,0);
		}
		
	}
		</script>
<?}?>		
	
	
<?
$P_TITLE=GetPageTitle($CHECK_CATPAGE[parentID],"contentpics");
$P_TITLE_BOTTOM=GetPageTitle($CHECK_CATPAGE[parentID],"contentpics_bottom");

if ($P_TITLE[Title]=="" AND isset($_SESSION['LOGGED_ADMIN'])) $P_TITLE[Title]="Enter Your title here";
if (!isset($_SESSION['LOGGED_ADMIN']) AND $P_TITLE[Title]=="Enter Your title here") $P_TITLE[Title]="";
?>
<div class="titleContent_top">
<?if ($SITE[titlesicon] AND !$P_TITLE[Title]=="") {
		?><div class="titlesIcon" style="margin-<?=$SITE[align];?>:10px;"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
		<?
		
	}
	if (!$P_TITLE[Title]=="") {
		?>
		<h1 id="shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>"><?=$P_TITLE[Title];?></h1>
		<?
	}
	?>
</div>
<?
$CONTENT=GetMultiContent($urlKey);
$briefs_limit=count($CONTENT[PageID]);
if (isset($_SESSION['LOGGED_ADMIN'])) {
		$showTopEditLabel=$showBottomEditLabel="";
		if (count($CONTENT[PageID])<1 AND $P_TITLE[Content]=="") $showTopEditLabel="none";
		if (count($CONTENT[PageID])<1 AND $P_TITLE_BOTTOM[Content]=="") $showBottomEditLabel="none";
		?>
		<br />&nbsp;
		<div id="newSaveIcon" class="add_button" onclick="AddNewContentType();"><i class="fa fa-file-text-o"></i> <?=$ADMIN_TRANS['add brief'];?></div>
		<div id="newSaveIcon"  onclick="EditContentOptions(event);"><i class="fa fa-sliders"></i> <?=$ADMIN_TRANS['options'];?></div>
		&nbsp;&nbsp;<div id="newSaveIcon" style="display: <?=$showTopEditLabel;?>" onclick="EditTopBottomContent('topShortContent');"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit top content'];?></div>
		<div style="height:5px"></div>
		<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>', '<?=$SITE[url];?>/Admin/saveTitles.php?type=contentpics', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>',formClassName:'titleContent_top'});
		</script>
		<?
}
?>
<div id="topShortContent" style="padding-<?=$SITE[align];?>:6px;margin-<?=$SITE[opalign];?>:7px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=$P_TITLE[Content];?></div>

	
<div class="div100p">
<?
	for ($a=0;$a<$briefs_limit;$a++) {
		$FullWidthClassName="";
		if($CONTENT[isFullWidth][$a] AND $CONTENT[ContentPhotoName][$a]=="") $FullWidthClassName="wideclass100";
		if($CONTENT[isFullWidth][$a] AND !$CONTENT[ContentPhotoName][$a]=="") $FullWidthClassName="wideclass100Foto";
		if ($CONTENT[ContentPhotoName][$a]=="" AND $CONTENT[PageTitle][$a]=="" AND $CONTENT[ShortContent][$a]=="" AND $CONTENT[PageContent][$a]=="") continue;
		?>
<!------------------------start------------------------------>
<?
if ($CONTENT[ContentPhotoName][$a]=="" AND $CONTENT[PageTitle][$a]=="" AND $CONTENT[ShortContent][$a]=="" AND $CONTENT[PageContent][$a]=="") continue;
		$photo_alt=str_replace("'","&lsquo;",$CONTENT[ContentPhotoAlt][$a]);
		$photo_alt=str_replace('"',"&quot;",$photo_alt);
		$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
		$photo_alt=str_ireplace("’","&rsquo;",$photo_alt);
		$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
		if ($photo_alt=="") $photo_alt=$CONTENT[PageTitle][$a];
		$num_inline++;
		$p_url=$SITE[url]."/".$CONTENT[UrlKey][$a];
		$page_url=$CONTENT[PageUrl][$a];
		$target_location="_self";
		$rel_code="";
		if (!stripos(urldecode($page_url),"/")==0 AND $page_url!="") $target_location="_blank";
		//$prefix_url="";
		//if (stripos(urldecode($page_url),"/category")===0) $prefix_url="/".$SITE_LANG[selected];
		//if ($SITE_LANG[selected]!=$default_lang) $CONTENT[PageUrl][$a]=$prefix_url.$page_url;
		
		if ($CONTENT[IsTitleLink][$a]) $page_url=$p_url;
		$cFloating=$pFloating="none";
		$float_code="";
		$isfull=1;
		$short_text_padding=6;
		$short_content_padding=6;
		$class="portlet";
		$roundedCornersWidth=$boxWidth+6;
		$inner_div_rightPadding=0;
		$innerDivWidth=$boxWidth+6;
		$inner_min_height=$ContentMinHeight;
		$SwitchLineViewLabel=$ADMIN_TRANS['full horizental view'];
		$SwitchLineEditClass="fa-align-justify";
		$photoHolderExtraCSS="";
		$controls_margin=0;
		if ($is_rounded AND !$P_DETAILS[ContentPhotoBGColor] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[PhotosBorderColor] AND $P_DETAILS[ContentTextBGColor]) $roundedCornersWidth=$boxWidth;
		
		$short_content_extra_css="width:".$roundedCornersWidth."px;background-color:#".$P_DETAILS[ContentTextBGColor];
		if ($P_DETAILS[ContentTextBGColor] AND !$P_DETAILS[ContentPhotoBGColor] AND !$P_DETAILS[ContentPicBG] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[ContentBorderColor] AND !$P_DETAILS[PhotosBorderColor] AND !$is_rounded) $short_content_extra_css="width:".$boxWidth."px;margin-".$SITE[align].":6px;background-color:#".$P_DETAILS[ContentTextBGColor];
		if ($P_DETAILS[ContentPhotoBGColor] AND !$is_rounded) $short_content_extra_css.=";margin-top:5px;";
		if ($P_DETAILS[PhotosBorderColor]) $short_content_extra_css.=";width:".($boxWidth+6)."px;";
		if ($P_DETAILS[ContentMinHeight] AND $P_DETAILS[ContentTextBGColor]) $short_content_extra_css.=";min-height:".($inner_min_height-$boxHeight)."px;";
		if ($P_DETAILS[ContentPhotoBGColor] AND !$P_DETAILS[isTitlesAbove]) $topRoundedCornersColor=$P_DETAILS[ContentPhotoBGColor];
		if ($P_DETAILS[ContentTextBGColor]) $bottomRoundedCornersColor=$P_DETAILS[ContentTextBGColor];
		if ($is_rounded AND !$P_DETAILS[ContentPhotoBGColor] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[ContentPicBG] AND !$P_DETAILS[PhotosBorderColor] AND $P_DETAILS[ContentTextBGColor]) $photoHolderExtraCSS=";margin-".$SITE[align].":-6px"; //Added 2/9/2012
		if ($CONTENT[isFullWidth][$a]==1) {
			$pFloating=$cFloating=$SITE[align];
			$containerWidth=$short_text_width+$boxWidth-($P_DETAILS[ContentMarginW]/2)-8;
			$labelContainerWidth=$containerWidth;
			if ($P_DETAILS[FullLineBriefWidth]>0) $containerWidth=$P_DETAILS[FullLineBriefWidth];
			//$padding_right=6;
			if ($SITE[shortcontentbgcolor] OR $P_DETAILS[ContentBorderColor] OR $P_DETAILS[ContentPicBG] OR $P_DETAILS[ContentPhotoBGColor] OR $P_DETAILS[PhotosBorderColor]) $padding_right=6;
			if ($is_rounded) {
				$padding_right=0;
				$containerWidth=$containerWidth+8;
				$labelContainerWidth=$labelContainerWidth+8;
			}
			
			$extra_float_css="";
			if (!$is_rounded AND $P_DETAILS[ContentTextBGColor]) $extra_float_css.="background-color:#".$P_DETAILS[ContentTextBGColor].";";
			//if ($SITE[shortcontentbgcolor]) $containerWidth=$containerWidth-25;
			$float_code='style="width:'.$containerWidth.'px;margin-'.$SITE[align].':1px;padding-right:'.$padding_right.'px;min-height:5px;'.$extra_float_css.'"';
			if ($P_DETAILS[ContentPhotoBGColor] OR $P_DETAILS[ContentPicBG] OR $P_DETAILS[PhotosBorderColor]) $float_code='style="width:'.$containerWidth.'px;margin-'.$SITE[align].':0px;padding-right:0px;min-height:5px;padding-top:0px;padding-bottom:0px;'.$extra_float_css.'"';
			$inner_min_height=5;
			$inner_div_rightPadding=6;
			$innerDivWidth=$containerWidth-1;
			$isfull=0;
			$SwitchLineViewLabel=$ADMIN_TRANS['half horizental view'];
			$SwitchLineEditClass="fa-th-large";
			$short_text_padding=0;
			$num_inline=0;
			$class="portlet wide";
			$roundedCornersWidth=$containerWidth+5;
			$topRoundedCornersColor=$bottomRoundedCornersColor=$SITE[shortcontentbgcolor];
			$photoHolderExtraCSS="margin-".$SITE[opalign].":5px";
			if (!$P_DETAILS[PhotosBorderColor] AND !$P_DETAILS[ContentPicBG] AND !$P_DETAILS[ContentPhotoBGColor] AND !$P_DETAILS[ContentTextBGColor]) $photoHolderExtraCSS.=";padding-right:0px;padding-left:0px";
			$short_content_extra_css="background-color:#".$P_DETAILS[ContentTextBGColor];
			
		}
		if (!$is_rounded AND !$P_DETAILS[ContentTextBGColor] AND !$P_DETAILS[ContentBorderColor] AND !$SITE[shortcontentbgcolor]) $roundedCornersWidth=$roundedCornersWidth+15;
		$titleShow="";
		if ($CONTENT[PageTitle][$a]=="") $titleShow="none";
		if (!$CONTENT[PageUrl][$a]=="") {
			$page_url=urldecode($CONTENT[PageUrl][$a]);
			$cursor="pointer";
			if (stristr($page_url,"youtu.be/") OR stristr($page_url,"youtube.com")) {
				$page_url=str_ireplace("youtu.be/","youtube.com/embed/",$page_url);
				if (stristr($page_url,"youtube.com")) {
					$page_url=str_ireplace("watch?v=","embed/",$page_url);
					$page_url=str_ireplace("&feature=","?feature=",$page_url);
					
				}
				if (!stristr($page_url,"?rel=")) $page_url=$page_url."?rel=0";
				$rel_code='rel="shadowbox;width=720;height=450"';
			}
			if (stristr($page_url,"vimeo.com/")) {
				$page_url=str_ireplace("vimeo.com/","player.vimeo.com/video/",$page_url);
				$rel_code='rel="shadowbox;width=720;height=450"';
			}
		}
		$ItemID=$CONTENT[PageID][$a];
		$m_height="";
		if (isset($_SESSION['LOGGED_ADMIN'])) $eventMouseOverPic="showphotoedittools";
			else $eventMouseOverPic="showNULL";
		?>
<!--------------------------end-------------------------------------->		
		<div class="outerBox div_all <?=$FullWidthClassName;?>" id="short_cell-<?=$CONTENT[PageID][$a];?>">
			<div class="inside_div">

<!--------------------------start------------------------>
<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {
				$enlarge_checked="";
				
				if ($CONTENT[ContentPhotoName][$a]=="") $controls_margin=16;
				if ($CONTENT[EnableEnlarge][$a]==1) $enlarge_checked="checked";
				if (!$P_DETAILS[ContentPhotoBGColor] AND $CONTENT[ContentPhotoName][$a]=="") $controls_margin=8;
				?>
				<div class="briefs_edit" id="photo_edit_tools_<?=$a;?>" style="margin-top:<?=$controls_margin;?>px">
					<div id="newSaveIcon" onclick="jQuery('#pDropDownMenu_<?=$a;?>').toggle()"><i class="fa fa-angle-down"></i> | <?=$ADMIN_TRANS['edit brief/photo'];?></div>
					<div id="pDropDownMenu_<?=$a;?>" class="newSaveIcon popMenu" style="display:block;height: auto;display:none" onblur="jQuery(this).toggle();">
						
						<div class="photoEditDropDown" onclick="EditHere(<?=$CONTENT[PageID][$a];?>,'',1);"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit content'];?></div>

						<?
						if ($CONTENT[ContentPhotoName][$a]=="") {
							?>
							<div class="photoEditDropDown" onclick="AddNewArticlePic(<?=$ItemID;?>,'',0)"><i class="fa fa-picture-o"></i> <?=$ADMIN_TRANS['add photo'];?></div>
							<?
						}
						else {
							?>
							<div class="photoEditDropDown" onclick="AddNewArticlePic(<?=$ItemID;?>,'<?=$photo_alt;?>',1)"><i class="fa fa-picture-o"></i> <?=$ADMIN_TRANS['edit photo'];?></div>
							<div class="photoEditDropDown" onclick="setEnlarge(<?=$CONTENT[PageID][$a];?>);"><input style="width:12px;height:12px"  type="checkbox" id="enlarge_<?=$CONTENT[PageID][$a];?>" value="1" <?=$enlarge_checked;?>><span onclick="setEnlargeCheck(<?=$CONTENT[PageID][$a];?>);"><?=$ADMIN_TRANS['enlarge'];?></span></div>
							<div style="color:red" class="photoEditDropDown" onclick="delArticlePic(<?=$CONTENT[PageID][$a];?>,<?=$CONTENT[isFullWidth][$a];?>)"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete photo'];?></div>
						
							<?
						}
						?>
						<div style="color:red" class="photoEditDropDown" onclick="deleteContent(<?=$CONTENT[PageID][$a];?>)"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete this content'];?></div>
						
						<div class="photoEditDropDown" onclick="enlarge_line(<?=$CONTENT[PageID][$a]; ?>,<?=$isfull;?>)"><i class="fa <?=$SwitchLineEditClass;?>"></i> <?=$SwitchLineViewLabel;?> </div>
						<?if (!$SITE[enableContentAttributes]==1) {
							?>
							<div class="photoEditDropDown" onclick="selectContentAttr(<?=$CONTENT[PageID][$a];?>);"><i class="fa fa-tags"></i> <?=$ADMIN_TRANS['assign tags'];?></div>
							<?}?>
					</div>
				</div>
				<script language="javascript" type="text/javascript">
				pageUrlKey[<?=$CONTENT[PageID][$a];?>]="<?=$CONTENT[UrlKey][$a];?>";
				pageTextUrlKey[<?=$CONTENT[PageID][$a];?>]="<?=$CONTENT[UrlKey][$a];?>";
				pageIsTitleLink[<?=$CONTENT[PageID][$a];?>]="<?=$CONTENT[IsTitleLink][$a];?>";
				</script>
				<?
		}
?>

<!---------------------------end---------------------------------------->


				<?
				if (!$CONTENT[PageTitle][$a]=="" AND $P_DETAILS[isTitlesAbove]==1) 
				{
					?>
				   <div class="top_tit" id="titleContent_<?=$CONTENT[PageID][$a]; ?>"  >
						<?
							if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
						?>
							<h2><?=$CONTENT[PageTitle][$a];?></h2></a>
				    </div><!--top_tit-->
				
				<? 
			    }
				
				if (!$CONTENT[ContentPhotoName][$a]=="") 
				{
				?>
				<div class="tumbs">
		            <?
		            if (!$page_url=="" AND !$CONTENT[EnableEnlarge][$a]==1) 
		            {
						?>
						<a href="<?=$page_url;?>" target="<?=$target_location;?>" <?=$rel_code;?>>
						<?
					}
					?>
					<img src="<?=SITE_MEDIA;?>/gallery/articles/<?=$CONTENT[ContentPhotoName][$a];?>"   alt='<?=$photo_alt;?>' data-tumb-url="<?=SITE_MEDIA;?>/gallery/articles/<?=$CONTENT[ContentPhotoName][$a];?>" />
					<!--<figure id="photo_img_<?=$CONTENT[PageID][$a];?>" style="background-image:url(<?=SITE_MEDIA;?>/gallery/articles/<?=$CONTENT[ContentPhotoName][$a];?>) ; " class="bg"  alt='<?=$photo_alt;?>' data-tumb-url="<?=SITE_MEDIA;?>/gallery/articles/<?=$CONTENT[ContentPhotoName][$a];?>" title='<?=$photo_alt;?>'></figure><?if (!$page_url=="" OR $CONTENT[EnableEnlarge][$a]==1) print '</a>';?>-->
					
					</div><!--tumbs-->
				
				<?
				}
				?>
				
				<div class="content">
					<?
				if (isset($_SESSION['LOGGED_ADMIN'])) 
				{?>
				<span style="display:none" id="p_url_<?=$CONTENT[PageID][$a];?>"><?=urldecode($CONTENT[PageUrl][$a]);?></span>
				<?}

				if(($P_DETAILS[isTitlesAbove]==0 OR $CONTENT[isFullWidth][$a]==1) AND !$CONTENT[PageTitle][$a]=="" )
				{
					if (isset($_SESSION['LOGGED_ADMIN']) OR $titleShow=="")
					{
						?>
						<div  id="titleContent_<?=$CONTENT[PageID][$a]; ?>">
						<?
						if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
						?>
						<h2><?=$CONTENT[PageTitle][$a];?></h2></a></div>
						<?
					}
				}
					?>

					
					<div id="divContent_<?=$CONTENT[PageID][$a]; ?>">
						<?
						if ($CONTENT[ShortContent][$a]=="") $CONTENT[ShortContent][$a]=$CONTENT[PageContent][$a];
						?><p><?print str_ireplace("&lsquo;","'",$CONTENT[ShortContent][$a]);?></p><?
						?>
					</div>
				</div><!--content-->
			</div><!--inside_div-->
		</div><!--div4_in_row-->
		<?
	}
	?>
</div><!--div100p-->
<div class="clear"></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	&nbsp;&nbsp;
	<div id="newSaveIcon" style="display: <?=$showBottomEditLabel;?>"  onclick="EditTopBottomContent('bottomShortContent');"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit bottom content'];?></div>
	<div style="height:5px"></div>
	<?
	}
?>
<div id="bottomShortContent" style="padding-<?=$SITE[align];?>:6px;margin-<?=$SITE[opalign];?>:7px;" align="<?=$SITE[align];?>" class="mainContentText"><?=$P_TITLE_BOTTOM[Content];?></div>

<script type="text/javascript" src="<?=$SITE['cdn_url'];?>/js/jquery.matchHeight-min.js"></script>
<script>
jQuery(window).load(function() {
	if (jQuery(window).width()>680) {
		
		jQuery('.div100p .inside_div').not(".wide100").matchHeight();

	}	
	
});
</script>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<div style="width:550px;display:none;z-index:1100;position:fixed;top:150px;" id="PicUploader" class="CatEditor CenterBoxWrapper" align="center" dir="<?=$SITE[direction];?>">
	<div id="make_dragable" align="<?=$SITE[opalign];?>"><div class="icon_close" onclick="AddNewArticlePic(-1)">+</div>
		<div class="title"><strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong></div>
	</div>
		<div class="CenterBoxContent">
		<div style="float:<?=$SITE[align];?>;width:190px;" id="PhotoPreview"><strong><?=$ADMIN_TRANS['edit photo'];?></strong>
			<div id="photoPreviewDisplay"></div>
			<div style="margin-top:10px;"></div>
			<div id="newSaveIcon" style="display: <?=$showAdvancedEditButton;?>" class="advancedEditorButton"><i class="fa fa-magic"></i> <?=$ADMIN_TRANS['advanced photo editor'];?></div>
		</div>
		<form id="ArticlePicUpload" method="post" onsubmit="return false;">
		 <div><?=$ADMIN_TRANS['browse to upload photo'];?></div>
		 <span id="photo_spanButtonPlaceHolder" style="cursor:pointer"></span>
		<div class="fieldset flash" id="photo_fsUploadProgress">		
		</div>
		<div id="divStatus" dir="ltr"></div>
		
		<br />
		<div align="center" style="clear: both">
		<br />
		<?=$ADMIN_TRANS['photo alt text'];?>(ALT)
		<br>
		<textarea id="photo_alt_text" name="photo_alt_text" style="width:98%;font-family:arial" maxlength="150" /></textarea>
		<br />
		<input id="photo_btnCancel" type="button" value="Cancel All" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 22px;" />
		<div id="newSaveIcon" class="greenSave" onclick="SavePhotoArticle()"><i class="fa fa-cloud-upload"></i> <?=$ADMIN_TRANS['upload and save'];?></div>
		
		</div>
		<input type="hidden" name="itemID" id="itemID">
		</form>
		</div>	
	</div>
	<script>
	function EditTopBottomContent(textDivID) {
		var contentDIV = document.getElementById(textDivID);
		OrigTopContent=contentDIV.innerHTML;
		var top_bottom_content_text=contentDIV.innerHTML;
		var buttons_str;
		buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveTopContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		if (textDivID=="bottomShortContent") buttons_str='<br><div id="newSaveIcon" onclick="saveBottomContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
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
				 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
			});
		editor_ins.setData(top_bottom_content_text);
				//ShowLayer("lightEditorContainer",1,1,0);
				editor_ins.on("loaded",function() {
					slideOutEditor("lightEditorContainer",1);
				});
				jQuery(function() {
					jQuery("#lightEditorContainer").draggable();
		});
	}
	function saveTopContent() {
		var cVal=editor_ins.getData();
		cVal=encodeURIComponent(cVal);
		var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
		var cpicstype="contentpics_text";
		//if (textDivID=="bottomShortContent") cpicstype="contentpics_text_bottom";
		var pars = 'type='+cpicstype+'&content='+cVal+'&objectID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
		jQuery('#topShortContent').html(decodeURIComponent(cVal));
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
	}
	function saveBottomContent() {
		var cVal=editor_ins.getData();
		cVal=encodeURIComponent(cVal);
		var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
		var cpicstype="contentpics_text_bottom";
		var pars = 'type='+cpicstype+'&content='+cVal+'&objectID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
		jQuery('#bottomShortContent').html(decodeURIComponent(cVal));
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
		
	}
	function cancel() {
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
	}
	function setEnlargeCheck(cID) {
		var isCheked=$('enlarge_'+cID).checked;
		if (isCheked) $('enlarge_'+cID).checked=false;
		else $('enlarge_'+cID).checked=true;
		setEnlarge(cID)
	}
	function setEnlarge(cID) {
		var setENLARGE=0;
		if ($('enlarge_'+cID).checked) setENLARGE=1;
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=setContentPhotoEnlarge';
		var pars = 'pageID='+cID+'&enableEnlarge='+setENLARGE;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});

	}
	function enlarge_line(pID,full) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=enlargeFullLine';
		var pars = 'pageID='+pID+'&full='+full;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',400);
	}
	</script>

	<script>
	function launchAdvancedPhotoEditor(id, src,photoID) {
	       featherEditor.launch({
		   image: id,
		   url: src
	       });
	       currentEditedPhotoID=photoID;
	      return false;
	}
	var gal_editor_width="99%";
	var OrigTopContent;
	var OrigBottomContent;
	var photo_alt_text;
	var display_bg_upload="<?=$display_bgupload;?>";
	 function saveOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars =newPosition+'&action=saveContentLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
			
	}
		jQuery(function() {
			
			jQuery(".div100p").sortable({
			update: function(event, ui) {
				saveOrder(jQuery(".div100p").sortable('serialize'));
			}
			,handle: '.briefs_edit>#newSaveIcon,img',
			scroll:true,
			axis:'<?=$axis;?>',
			connectWith: ".div_all",
			opacity: 0.6,tolerance: 'pointer',dropOnEmpty: false
			
			
		});
		jQuery( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" );
		
	});

	cType=1;
	var uploaded_filename;
	var buttonID= "photo_spanButtonPlaceHolder";
	var cancelButtonID= "photo_btnCancel";
	var progressTargetID="photo_fsUploadProgress";
	var allowed_photo_types="*.jpg;*.gif;*.png";
	var currentPhotoID;
	function SavePhotoArticle() {
		swfu.startUpload();
		photo_alt_text=jQuery("#photo_alt_text").val();
		var photo_alt_text_encoded=encodeURIComponent(photo_alt_text);
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=updateBriefPhotoAlt';
		jQuery.ajax({data:'alt_text='+photo_alt_text_encoded+'&itemID='+currentPhotoID,url:url,success:successEdit});
		window.setTimeout('check_if_gallery_pics_finished()',500);
	}
	function check_if_gallery_pics_finished() {
		my_stat = swfu.getStats();
		if(my_stat.in_progress == 1)
			setTimeout('check_if_gallery_pics_finished()',500);
		else{
			if (NewPicAdding==1) {
				ShowLayer('PicUploader',0,0,0);
				jQuery("#lightEditorContainer").css("z-index","1100");
				jQuery(".editor_addPhoto").hide();
				NewPicAdding=0;
			}
			else  {
				ShowLayer('PicUploader',0,1,0);
				window.setTimeout('ReloadPage()',700);
			}
			
		}
	}
	
	function SaveUploadedArticlePhoto(photo_name) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=uploadPhoto';
		var pars = 'photo_name='+photo_name+'&itemID='+currentPhotoID+'&catID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	}
	
	function delArticlePic(photo_id,isFullLine) {
		var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
		if (q) {
			deleted_photo_id=photo_id;
			var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delPhoto';
			var pars = 'photo_id='+photo_id;
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
			$("photo_img_holder_"+photo_id).hide();
			$('add_photo_label_'+photo_id).show();
			if (isFullLine) $('short_content_container_'+photo_id).style.width="<?=$short_text_width+$gallery_photo_w+$shortTextLeft;?>px";
			//$('short_content_container').style.width=<?//=$short_text_width+$gallery_photo_w+30;?>;
			
		}
	}


	function EditTopBottomContent(textDivID) {
		var contentDIV = document.getElementById(textDivID);
		OrigTopContent=contentDIV.innerHTML;
		var top_bottom_content_text=contentDIV.innerHTML;
		var buttons_str;
		buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveTopContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		if (textDivID=="bottomShortContent") buttons_str='<br><div id="newSaveIcon" onclick="saveBottomContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
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
				 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
			});
		editor_ins.setData(top_bottom_content_text);
				//ShowLayer("lightEditorContainer",1,1,0);
				editor_ins.on("loaded",function() {
					slideOutEditor("lightEditorContainer",1);
				});
				jQuery(function() {
					jQuery("#lightEditorContainer").draggable();
		});
	}
	function saveTopContent() {
		var cVal=editor_ins.getData();
		cVal=encodeURIComponent(cVal);
		var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
		var cpicstype="contentpics_text";
		//if (textDivID=="bottomShortContent") cpicstype="contentpics_text_bottom";
		var pars = 'type='+cpicstype+'&content='+cVal+'&objectID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
		jQuery('#topShortContent').html(decodeURIComponent(cVal));
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
	}
	function saveBottomContent() {
		var cVal=editor_ins.getData();
		cVal=encodeURIComponent(cVal);
		var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
		var cpicstype="contentpics_text_bottom";
		var pars = 'type='+cpicstype+'&content='+cVal+'&objectID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
		jQuery('#bottomShortContent').html(decodeURIComponent(cVal));
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
		
	}
	function cancel() {
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
	}
	function setEnlargeCheck(cID) {
		var isCheked=$('enlarge_'+cID).checked;
		if (isCheked) $('enlarge_'+cID).checked=false;
		else $('enlarge_'+cID).checked=true;
		setEnlarge(cID)
	}
	function setEnlarge(cID) {
		var setENLARGE=0;
		if ($('enlarge_'+cID).checked) setENLARGE=1;
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=setContentPhotoEnlarge';
		var pars = 'pageID='+cID+'&enableEnlarge='+setENLARGE;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});

	}
	function enlarge_line(pID,full) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=enlargeFullLine';
		var pars = 'pageID='+pID+'&full='+full;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',400);
	}
	function EditContentOptions(o) {
		if ($('ContentOptions').style.display=="none") {
			upload_global_type="contentPicBG";
			slideOutSettings("ContentOptions",1);
			//ShowLayer("ContentOptions",1,1,1);
			showuploader(allowed_photo_types,1,'photoBG_spanButtonPlaceHolder','photoBG_btnCancel','photoBG_fsUploadProgress',0);
				
		}
			else slideOutSettings("ContentOptions",0);
		
	}
	function SaveContentOptions() {
		var catID="<?=$CHECK_CATPAGE[parentID];?>";
		var pWidth=$('contentphotowidth').value;
		var pHeight=$('contentphotoheight').value;
		var marginW=$('contentmarginwidth').value;
		var marginH=$('contentmarginheight').value;
		var num_briefs_show=$('num_briefs_display').value;
		var content_bg_color=$('P_DETAILS[ContentBGColor]').value;
		var content_border_color=$('P_DETAILS[ContentBorderColor]').value;
		var photos_border_color=$('P_DETAILS[PhotosBorderColor]').value;
		var content_min_height=$('content_min_height').value;
		var content_photo_bg_color=$('P_DETAILS[ContentPhotoBGColor]').value;
		var content_text_bg_color=$('P_DETAILS[ContentTextBGColor]').value;
		var content_text_color=$('P_DETAILS[ContentTextColor]').value;
		var titles_color=$('P_DETAILS[TitlesColor]').value;
		var full_line_width=$('full_brief_width').value;
		var is_rounded=-1;
		var options_default=-1;
		var is_titles_above=0;
		var show_pinterest_button=0;
		var imagesCropMode=0;
		if (jQuery("input#crop_mode").is(":checked")) imagesCropMode=1;
		<?if ($display_bgupload=="") {
		?>swfu.startUpload();
		<? }	?>
		if ($('is_rounded_corners').checked) is_rounded=1;
		if ($('titles_above').checked) is_titles_above=1;
		if ($('is_default_options').checked) options_default=1;
		if ($('show_pinterest_button').checked) show_pinterest_button=1;
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars = 'action=saveContentOptions&catID='+catID+'&pWidth='+pWidth+'&pHeight='+pHeight+'&wMargin='+marginW+'&hMargin='+marginH+'&content_bg_color='+content_bg_color+'&borderColor='+content_border_color+'&content_min_height='+content_min_height+'&content_rounded_corners='+is_rounded+'&content_photo_bg_color='+content_photo_bg_color+'&content_text_bg_color='+content_text_bg_color+'&titles_color='+titles_color+'&content_text_color='+content_text_color+'&num_briefs_show='+num_briefs_show+'&full_line_width='+full_line_width+'&isDefaultOptions='+options_default+'&photos_border_color='+photos_border_color+'&is_titles_above='+is_titles_above+'&show_pinterest_button='+show_pinterest_button+'&images_crop_mode='+imagesCropMode;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
		if (display_bg_upload=="") window.setTimeout('check_if_gallery_pics_finished()',900);
		else window.setTimeout('ReloadPage()',900);
		
	}
	function SaveContentTumbsBG(photo_name) {
		var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=uploadContentTumbsBG';
		var pars = 'photo_name='+photo_name+'&catID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit,onLoading:savingChanges});
	}
	function delContentPicBG() {
		var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=delContentTumbsBG';
		var pars = 'catID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',300);
	}
	function resetDefaultOptions() {
		var catID="<?=$CHECK_CATPAGE[parentID];?>";
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars = 'action=resetDefaultOptions&update_catID='+catID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',300);
	}
	var currentLock=1;
			
	function showphotoedittools(w) {
		jQuery("#"+w).toggle();
		
	}
	var embed_code_backup;
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
	</script>
	<?
}
?>

