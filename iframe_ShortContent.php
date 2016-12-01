<?
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
$urlKey=$_GET['cat_url'];
$CHECK_CATPAGE=GetIDFromUrlKey($urlKey);
include_once("round_corners.inc.php");
$P_DETAILS=GetMetaData($CHECK_CATPAGE[parentID],1);
if ($CHECK_PAGE) $P_DETAILS=GetMetaData($CHECK_PAGE[parentID]);
$ShortContentStyle=0;
if ($CHECK_CATPAGE[CatType]==11) $ShortContentStyle=2;
$boxHeight=115;
$boxWidth=115;
$contentMarginH=20;
$display_bgupload="none";
$is_default_options_checked="";
$customWidth=$SITE[galleryphotowidth];
$customHeight=$SITE[galleryphotoheight];
$CONTENT_OPTIONS=json_decode($P_DETAILS[Options]);
$P_DETAILS[ContentPhotoBGColor]=$CONTENT_OPTIONS->ContentPicBGColor;
if($P_DETAILS[ContentBGColor]) $SITE[shortcontentbgcolor]=$P_DETAILS[ContentBGColor];
$P_DETAILS[ContentTextColor]=$CONTENT_OPTIONS->ContentTextColor;
$P_DETAILS[TitlesColor]=$CONTENT_OPTIONS->TitlesColor;
$P_DETAILS[FullLineBriefWidth]=$CONTENT_OPTIONS->FullLineBriefWidth;
if (!$P_DETAILS[FullLineBriefWidth]) {
	if ($isLeftColumn>0 AND $ShortContentStyle==2) {
		$left_ColSubStruct=210;
		if ($customLeftColWidth) $left_ColSubStruct=$customLeftColWidth+10;
		if ($P_DETAILS[PageStyle]==0) $P_DETAILS[FullLineBriefWidth]=677-$left_ColSubStruct;
		else  $P_DETAILS[FullLineBriefWidth]=930-$left_ColSubStruct;
	}
}


if ($P_DETAILS[ContentPhotoWidth]>0) $customWidth=$P_DETAILS[ContentPhotoWidth];
if ($P_DETAILS[ContentPhotoHeight]>0) $customHeight=$P_DETAILS[ContentPhotoHeight];
if ($P_DETAILS[ContentMarginH]>0) $contentMarginH=$P_DETAILS[ContentMarginH];
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
$short_text_width=(668-$customWidth-10);
if ($P_DETAILS[PageStyle]==1) $short_text_width=(930-$customWidth-10);
$li_container_margin_left=8;
if ($ShortContentStyle!=2 AND $SITE[shortcontentbgcolor]) {
	$short_text_width=$short_text_width-5;
	//$li_container_margin_left=8;
}

$shortTextLeft=15;
$axis="y";
$box_float="none";
$overflow="none";
$divider=2;
$minHeight="inherit";
$shortDivCSS="";
$orig_short_text_width=$short_text_width;
if ($ShortContentStyle==2) {
	$short_text_width=(314-$customWidth);
	if ($P_DETAILS[PageStyle]==1) {
		$short_text_width=$short_text_width-22;
		$divider=3;
	}	
	$shortTextLeft=10;
	$axis="x,y";
	$box_float=$SITE[align];
	//$overflow="hidden"; remarked on 08/02/2011
	$minHeight="10px";
}
if ($isLeftColumn>0 AND $ShortContentStyle!=2) {
	$left_ColSubStruct=210;
	if ($customLeftColWidth) $left_ColSubStruct=$customLeftColWidth+10;
	$short_text_width=$short_text_width-$left_ColSubStruct;
	
	if ($P_DETAILS[PageStyle]==1) $short_text_width=$short_text_width-60;
	if ($customLeftColWidth AND $P_DETAILS[PageStyle]==1) $short_text_width=$short_text_width+55;
}
if ($isLeftColumn>0 AND $ShortContentStyle==2 AND $P_DETAILS[PageStyle]==1) $short_text_width=$short_text_width+20;
$boxWidth=$short_text_width+$customWidth;
if ($ShortContentStyle==2 AND $b_ver==7) $shortDivCSS="width:".($boxWidth+15)."px";
$modified_short_text_width=$short_text_width;
$orgDivider=$divider;
$padding_left=1;
$top_text_padding=0;
if ($SITE[shortcontentbgcolor]) {
	$padding_left=1;
	$top_text_padding=3;
}
$place_photo_top=0;
include_once("defaults.php");
$G_FONTS=explode("|",$SITE[googlewebfonts]);
$gfont_exists=0;
if (in_array($SITE[titlesfont],$G_FONTS) OR in_array($SITE[menusfont],$G_FONTS) OR in_array($SITE[fontface],$G_FONTS)) {
	$gfont_exists=1;
	$gfont_str=array();
	if (in_array($SITE[menusfont],$G_FONTS)) $gfont_str[]=$SITE[menusfont];
	if (in_array($SITE[titlesfont],$G_FONTS)) $gfont_str[]=$SITE[titlesfont];
	if (in_array($SITE[fontface],$G_FONTS)) $gfont_str[]=$SITE[fontface];
	
	$g_fonts=implode("|",$gfont_str);
	$g_fonts=str_ireplace(" ","+",$g_fonts);
	if ($g_fonts=="") $gfont_exists=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<base target="_top" />
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php?urlKey=<?=$urlKey;?>">
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/lightbox/css/jquery.lightbox-0.5.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/shadowbox/shadowbox.css">
	<link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/css/he_fonts.css">
	<?if ($SITE[mobileEnabled] AND !isset($_SESSION['LOGGED_ADMIN'])) {?>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0">
		<?}
		?>
	<style>
	body {background:none;background-image:none;background-color:transparent;margin:0;padding:0;direction:<?=$SITE_LANG[direction];?>}
	</style>
	<script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
	<script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/lightbox/jquery.lightbox.iframe-0.5.js"></script>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/shadowbox/shadowbox.js"></script>
	<script language="javascript" type="text/javascript">
	jQuery.noConflict();
	jQuery(function() {
				jQuery('a.photo_gallery').lightBox({
				imageLoading:'<?=$SITE[url];?>/images/lightbox/loading.gif',
				imageBtnPrev:'<?=$SITE[url];?>/images/lightbox/prev.gif',	
				imageBtnNext:'<?=$SITE[url];?>/images/lightbox/next.gif',	
				imageBtnClose:'<?=$SITE[url];?>/images/lightbox/close.gif',
				imageBlank:'<?=$SITE[url];?>/images/blank.gif',
				overlayOpacity:0.5,
				txtImage:'<?=$SITE[photosnavlabel];?>',
				txtOf:'/'
				})
	});
	
	Shadowbox.init({
		    language:   "en",
		     viewportPadding:1,
		    autoplayMovies:true
	});
	</script>
</head>
<body>
<style type="text/css">
.custom {
	width:<?=($customWidth);?>px;
	height:<?=$customHeight;?>px;
	<?
	if ($customWidth!=$SITE[galleryphotowidth] OR $customHeight!=$SITE[galleryphotoheight])
		{
			$place_photo_top=1;
			?>
			background-image:none;
			<?
		}
	?>
}
.custom img {
	max-width:<?=($customWidth);?>px;
	max-height:<?=$customHeight;?>px;
}
.customTitleStyle, .customTitleStyle a {
	<?if ($P_DETAILS[TitlesColor]) {
		?>
		color:#<?=$P_DETAILS[TitlesColor];?>;
	<?}?>
	
}
.customContentStyle {
	<?if ($P_DETAILS[ContentTextColor]) {
		?>
		color:#<?=$P_DETAILS[ContentTextColor];?>;
	<?}?>
}
<?
if ($P_DETAILS[ContentPicBG]) {
	?>
	.photoHolder {background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$P_DETAILS[ContentPicBG];?>');}
	<?
}
?>
#boxes  {
		font-family: <?=$SITE[cssfont];?>;
		list-style-type: none;
		margin:0px;
		width: 100%;
		margin-top:0px;
		padding:0;
}
#boxes li {
		background-color:#<?=$SITE[shortcontentbgcolor];?>;
		margin-top:5px;
		margin-bottom:<?=$contentMarginH;?>px;
		margin-<?=$SITE[align];?>:0px;
		margin-<?=$SITE[opalign];?>:0px;
		padding-top:2px;
		padding-bottom:3px;
		padding-<?=$SITE[opalign];?>:0px;
		padding-<?=$SITE[align];?>:0px;
		float:<?=$box_float;?>;
		min-height:<?=$minHeight;?>;
		overflow-y:<?=$overflow;?>;
		<?=$shortDivCSS;?>
	}

#boxes li .mainContentText li {
	margin:0;
	padding:0px;
	float:none;
	min-height:0;
}
#boxes li .mainContentText ul {list-style-type: disc}
#boxes li .mainContentText ul {list-style-type: disc}
#boxes li.ui-sortable-placeholder {background-color:transparent;border: 1px dotted silver;visibility: visible !important;}
<?
if ($P_DETAILS[ContentPhotoBGColor]) {
	?>
	.photoWrapper, .photoHolder {background-color:#<?=$P_DETAILS[ContentPhotoBGColor];?>;}
	.photoHolder {background-image:none;}
	#boxes li {padding-top:0px;padding-bottom:0px;}
	<?
}
if ($P_DETAILS[ContentPicBG] OR $SITE[gallerybgpic]) {
	?>
	#boxes li {padding-top:0px;padding-bottom:0px;}
	<?
}
?>
.photoHolder {
	float:<?=$SITE[align];?>;
	margin-<?=$SITE[align];?>:0px;
}
#lock_prop {cursor:pointer}
<?
if ($SITE[shortcontentbgcolor]=="" AND $P_DETAILS[ContentPhotoBGColor]=="" AND $P_DETAILS[ContentBGColor]=="") {
	?>
	.photoWrapper {display:block}
	<?
}
?>
@media only screen and (max-width : 680px)  {
    .rwd#boxes li {
	    width:100%;
	    margin-right:0px;
	    margin-left:0px;
	    padding:0 0 0 0;
	    min-height:0px;
	}
    ul.rwd#boxes{width:100%;}
	.rwd#boxes li.wide, #boxes li.wide div {width:100%;padding:0}
	.rwd#boxes li .innerDiv {width:100% !important;padding:0 !important;min-height:0 !important;}
	.rwd div.brief_photo {
	    padding: 0px;
	    border:0px solid silver;
	    text-align: center;
	    background: transparent;
	    margin-top:5px;
	    margin-bottom:5px;
	    overflow: hidden;
	    display: block;
	    width:100% !important;
	 }
	.rwd .brief_photo img {
	    max-width:100%;max-height: 100%;
	    padding: 0;
	    vertical-align: middle;
	    top: 0;
	    left: 0;
	    width:100%;
	}
    .rwd#boxes li .photoWrapper {
        width:100% !important;
        height:100%;
        border:0px;
        background-color:transparent;
        padding:0px !important;
        margin-top:0px !important;
        
    }
    .rwd#boxes li .photoHolder {
        width:100% !important;
        height:100%;
        padding:0px !important;
        border:0px;
        background-color:transparent;
        background-image:none;
        margin-right:0px !important;
        margin-left:0px !important;
        float:none !important;
    }
    ul.rwd#boxes {padding:0}
    .rwd#boxes li.wide #printArea{width:auto;padding-<?=$SITE[opalign];?>:6px;}
    .rwd#boxes li #printArea div.mainContentText{padding-<?=$SITE[opalign];?>:6px;padding-<?=$SITE[align];?>:0px !important;overflow:inherit}
    .rwd#boxes li div div.shortContentTitle {padding-<?=$SITE[align];?>:0px !important;}
    .rwd#boxes li div div.topShortContentTitle {padding-<?=$SITE[align];?>:6px !important;}
    .rwd#boxes li .short_content_container{float:none !important;width:100% !important;padding:6px !important;box-sizing:border-box;}
    .rwd#boxes li #printArea div.mainContentText img {max-width: 100%;width:auto !important;height:auto !important;}
}

</style>
<!--[if IE 9]>
<style>
	<?
	if ($SITE[contenttextsize]!=13) {
	?>
	.customContentStyle {letter-spacing: -0.5px;}
	<?
	}
	?>
</style>
<![endif]-->
<?
$Proporsion=1;
if ($P_DETAILS[ContentPhotoHeight]>0) $Proporsion=$P_DETAILS[ContentPhotoWidth]/$P_DETAILS[ContentPhotoHeight];
$CONTENT=GetMultiContent($urlKey);
$max_briefs=count($CONTENT[PageID]);
if ($_GET['limit']) $max_briefs=$limit;
print '<ul id="boxes">';
	for ($a=0;$a<$max_briefs;$a++) {
		$photo_alt=htmlspecialchars($CONTENT[ContentPhotoAlt][$a],ENT_QUOTES);
		$photo_alt=str_replace("'","&lsquo;",$CONTENT[ContentPhotoAlt][$a]);
		$photo_alt=str_replace('"',"&quot;",$CONTENT[ContentPhotoAlt][$a]);
		$p_url=SITE_MEDIA."/".$CONTENT[UrlKey][$a];
		$rel_code="";
		$page_url=$CONTENT[PageUrl][$a];
		$target_location="_top";
		if (!stripos(urldecode($page_url),"/")==0 AND $page_url!="") $target_location="_blank";
		if ($CONTENT[IsTitleLink][$a]) $page_url=$p_url;
		$titleShow="";
		$short_text_width=$modified_short_text_width;
		
		if ($ShortContentStyle==2 AND $CONTENT[isFullWidth][$a]==1) $short_text_width=$orig_short_text_width;
		
		$short_text_width_complete=$short_text_width+$customWidth+$shortTextLeft;
		if ($short_text_width_complete>677) $short_text_width_complete=677;
		if ($short_text_width_complete>670 AND !$ShortContentStyle==2) $short_text_width_complete=654;
		
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
				$rel_code='rel="shadowbox;width=720;height=450"';
			}
			if (stristr($page_url,"vimeo.com/")) {
				$page_url=str_ireplace("vimeo.com/","player.vimeo.com/video/",$page_url);
				$rel_code='rel="shadowbox;width=720;height=450"';
			}
			
			
		}
		$ItemID=$CONTENT[PageID][$a];
		$SwitchLineViewLabel=$ADMIN_TRANS['full horizental view'];
		$isfull=1;
		$float_code="";
		$m_height="";
		$classNameBlocks="portlet";
		if ($CONTENT[isFullWidth][$a]==1) {
			$SwitchLineViewLabel=$ADMIN_TRANS['half horizental view'];
			$isfull=0;
			if ($CONTENT[ContentPhotoName][$a]=="") $m_height="min-height:10px;margin-bottom:5px";
			$float_code='style="float:none;clear:both;'.$m_height;
			if ($ShortContentStyle==2 AND $P_DETAILS[FullLineBriefWidth]>0) {
				$short_text_width_complete=$P_DETAILS[FullLineBriefWidth];
				$float_code.=';width:'.$short_text_width_complete.'px';
				
			}
			$float_code.='"';
			$labelContainerWidth=$short_text_width_complete;
			$classNameBlocks="portlet wide";
		}
		
		?>
		<li id="short_cell-<?=$CONTENT[PageID][$a];?>" <?=$float_code;?> class="<?=$classNameBlocks;?>">
		<?
		$have_pic=0;
		$add_photo_show="";
		$short_content_padding=9;
		$short_content_padding_left=0;
		if ($CONTENT[ContentPhotoName][$a]=="") {
			$CONTENT[ContentPhotoName][$a]="content_nopic.png";
			if ($ShortContentStyle==2 AND isset($_SESSION['LOGGED_ADMIN'])) {
				$ADMIN_TRANS['edit']=$ADMIN_TRANS['edit_temp'];
				$ADMIN_TRANS['change order']=$ADMIN_TRANS['move_temp'];
			}
			if ($ShortContentStyle==2 AND $SITE[shortcontentbgcolor]) $short_content_padding_left=7;
			if (!$SITE[shortcontentbgcolor]) $short_content_padding=0;
			$short_text_width_complete=$short_text_width+$customWidth+($shortTextLeft-9);
			if ($P_DETAILS[FullLineBriefWidth]>0 AND $ShortContentStyle==2 AND $CONTENT[isFullWidth][$a]==1) $short_text_width_complete=$P_DETAILS[FullLineBriefWidth];
		}
		else {
			$have_pic=1;
			$short_text_width_complete=$short_text_width-4; // we strech the text to fill the space+photo
			
			if ($P_DETAILS[FullLineBriefWidth]>0 AND $ShortContentStyle==2 AND $CONTENT[isFullWidth][$a]==1) $short_text_width_complete=$P_DETAILS[FullLineBriefWidth]-$customWidth-12;
			
			
		?>
			<div class="photoHolder custom" id="photo_img_holder_<?=$CONTENT[PageID][$a];?>">
			<div class="photoWrapper custom">
			<?
			$id_text="";
			if ($CONTENT[EnableEnlarge][$a]==1) {
				?>
				<a href="<?=SITE_MEDIA."/".$gallery_dir."/".$CONTENT[ContentPhotoName][$a];?>" class="photo_gallery"  title="<?=$CONTENT[PageTitle][$a];?>">
				<?
			}
			if (!$CONTENT[PageUrl][$a]=="") {
				?>
				<a href="<?=$page_url;?>" target="<?=$target_location;?>" <?=$rel_code;?>>
				<?
			}
			?>
			<img border="0" id="photo_img_<?=$CONTENT[PageID][$a];?>"  src="<?=SITE_MEDIA;?>/gallery/articles/<?=$CONTENT[ContentPhotoName][$a];?>" alt='<?=$CONTENT[ContentPhotoAlt][$a];?>' title='<?=$CONTENT[ContentPhotoAlt][$a];?>' /><?if ($CONTENT[PageUrl][$a] OR $CONTENT[EnableEnlarge][$a]==1) print '</a>';?>
			</div>
			</div>
		
		<?
		} 	//End Check if Photo NOT Exist so we put only text content
		
		?>
		<div class="short_content_container" id="short_content_container_<?=$CONTENT[PageID][$a];?>" style="padding-<?=$SITE[align];?>:0px;margin-<?=$SITE[align];?>:0px;width:<?=$short_text_width_complete;?>px;float:<?=$SITE[align];?>;align:<?=$SITE[align];?>;padding-top:<?=$top_text_padding;?>px;padding-bottom:<?=$top_text_padding;?>px;padding-<?=$SITE[opalign];?>:<?=$short_content_padding_left;?>px">
		<?
		if ($titleShow=="") {
			?>
			<strong><div class="shortContentTitle customTitleStyle" id="titleContent_<?=$CONTENT[PageID][$a]; ?>"  style="display:<?=$titleShow;?>;padding-<?=$SITE[align];?>:<?=$short_content_padding;?>px;">
			<?
			if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
			?>
			<?=$CONTENT[PageTitle][$a];?></a></div></strong>
			<?
		}
		?>
		<div id="printArea"><div id="divContent_<?=$CONTENT[PageID][$a]; ?>" align="<?=$SITE[align];?>" class="mainContentText customContentStyle" style="padding-left:0px;padding-<?=$SITE[align];?>:<?=$short_content_padding;?>px">
		<?
		print str_ireplace("&lsquo;","'",$CONTENT[ShortContent][$a]);
		?></div></div>
	<?
	
	print "</div>";
	print "<div class='clear'></div>";
	print "</li>";
	if (!$counter_new) $counter_new=1;
	if ($CONTENT[isFullWidth][$a]==1 AND $ShortContentStyle==2) {
		print "<li class='clear' style='float:none;min-height:2px;margin:0px;padding:0px;background-color:transparent'></li>";
		$counter_new=0;
		//$divider=$divider+1;
		//if ($orgDivider==3) $divider=$orgDivider+1;
		
	}
	if ($counter_new==$orgDivider AND $ShortContentStyle==2) {
		print "<li class='clear' style='float:none;min-height:0px;margin:0px;padding:0px;background-color:transparent'></li>";
		$counter_new=0;
	}
	$counter_new++;

	}
	print '</ul>';
?>
<div class="clear"></div>
<script>
function setIframeHeight() {
	var h=jQuery("ul#boxes").height()+50;
	jQuery("#iframe_shortContent",parent.document.body).height(h+"px");
}
function rwdShortContentIframe() {
	jQuery("#boxes").addClass("rwd");
	jQuery("#boxes li .photoWrapper img").each(function(){
                var articleImgSrc=jQuery(this).attr('src');
                var newArticleImgSrc=articleImgSrc.replace("articles/","");
                
                jQuery(this).attr("src",newArticleImgSrc);
                
        });
        jQuery("#boxes li div.photoWrapper").addClass("brief_photo");
        jQuery("#boxes li").css("width","");
        jQuery("#boxes li .photoHolder, #boxes li .photoWrapper").removeClass("custom");
         if (jQuery("a.photo_gallery").length>0) {
            jQuery("a.photo_gallery").addClass("enlarge");
            jQuery("a.photo_gallery").unbind("click");
            jQuery("a.photo_gallery").removeClass("photo_gallery");
            //var myPhotoSwipe = jQuery(".brief_photo a.enlarge").photoSwipe({ enableMouseWheel: true , enableKeyboard: true });
         }
}
	jQuery(document).ready(function() {
		if (jQuery(parent.window).width()<680) rwdShortContentIframe();
		var container_width=jQuery("ul#boxes").width();
		<?
		if ($ShortContentStyle!=2) {
			?>
			jQuery("ul#boxes li.portlet").each(function()  {
				var photo_width=jQuery(this).find(".photoHolder").width();
				
				if (photo_width) {
					var new_width=container_width-photo_width-25+"px";
					jQuery(this).find("div.short_content_container").width(new_width);
					
				}
				else {
					jQuery(this).find("div.short_content_container").width(container_width-20+"px");
				}
			});
			
			
			<?
		}
		?>
		window.setTimeout("setIframeHeight();",1000);

	});
</script>
</body>
</html>