<?
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
//$cID=36;
//$URL_KEY=GetUrlKeyFromID($cID);
//$urlKey=$URL_KEY[UrlKey];
$urlKey=$_GET['cat_url'];
$CHECK_CATPAGE=GetIDFromUrlKey($urlKey);
include_once("round_corners.inc.php");
$P_DETAILS=GetMetaData($CHECK_CATPAGE[parentID],1);
if ($CHECK_PAGE) $P_DETAILS=GetMetaData($CHECK_PAGE[parentID]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<base target="_top" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php?urlKey=<?=$urlKey;?>">
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/lightbox/css/jquery.lightbox-0.5.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/shadowbox/shadowbox.css">
	<link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/css/he_fonts.css">

	<style>
	body {background:none;background-image:none;background-color:transparent;margin:0;padding:0;direction:<?=$SITE_LANG[direction];?>}
	</style>
	<?if ($SITE[mobileEnabled]){?>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0">
	<?}?>
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
<?
$ShortContentStyle=0;
$boxHeight=115;
$boxWidth=115;
$display_bgupload="none";
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
$axis="x,y";
$box_float="none";
$overflow="none";
$divider=2;
$minHeight="inherit";
$shortDivCSS="";
$is_rounded_checked="";
$is_rounded=0;

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
if ($P_DETAILS[ContentMarginW]==0) {
	$P_DETAILS[ContentMarginW]=6;
}
$tumbsWidth=$boxWidth;//for fields value
$tumbsHeight=$boxHeight;
if ($P_DETAILS[ContentMarginH]==0) $P_DETAILS[ContentMarginH]=10;
if($P_DETAILS[ContentBGColor]) $SITE[shortcontentbgcolor]=$P_DETAILS[ContentBGColor];
if ($P_DETAILS[ContentBorderColor] AND !$is_rounded) $border_css="border:1px solid #".$P_DETAILS[ContentBorderColor];
if ($P_DETAILS[ContentMinHeight]!="") $ContentMinHeight=$P_DETAILS[ContentMinHeight];

$topRoundedCornersColor=$bottomRoundedCornersColor=$SITE[shortcontentbgcolor];
if ($P_DETAILS[ContentPhotoBGColor]) $topRoundedCornersColor=$P_DETAILS[ContentPhotoBGColor];
if ($P_DETAILS[ContentTextBGColor]) $bottomRoundedCornersColor=$P_DETAILS[ContentTextBGColor];

$containerWidth=$dynamicWidth-270;
if (intval($isLeftColumn)>0) $containerWidth=$containerWidth-$customLeftColWidth;
$num_short_content_in_line=$containerWidth/($boxWidth+$P_DETAILS[ContentMarginW]+6);
//print $boxWidth+$P_DETAILS[ContentMarginW];die();
$short_text_width=($containerWidth-$boxWidth-6);
if ($P_DETAILS[ContentBorderColor])  $short_text_width=$short_text_width-2;


$orig_short_text_width=$short_text_width;
$num_short_content_in_line=intval($num_short_content_in_line);

$orgDivider=$divider;
$padding_left=1;

$all_container_width=$containerWidth+$P_DETAILS[ContentMarginW];
if ($P_DETAILS[PageStyle]==1) $all_container_width=$all_container_width+3;
?>
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
if ($P_DETAILS[ContentPicBG]) {
	?>
	.photoHolder {background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$P_DETAILS[ContentPicBG];?>');}
	.photoWrapper {background-color:transparent}
	<?
}
else {
	?>
	.photoHolder {background-image:none;}
	<?
}
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
if ($SITE[shortcontentbgcolor] OR $P_DETAILS[ContentPhotoBGColor] OR $P_DETAILS[ContentBorderColor] OR $P_DETAILS[ContentPicBG] OR $P_DETAILS[PhotosBorderColor]) {
	$boxWidth=$boxWidth+6;
	//$P_DETAILS[ContentMarginW]=($P_DETAILS[ContentMarginW]-1);
	if ($P_DETAILS[PhotosBorderColor]) $boxWidth=$boxWidth+2;
}
$boxesBGColor=$SITE[shortcontentbgcolor];
if ($is_rounded) $boxesBGColor="";

if ($P_DETAILS[show_pinterest_button]==1) {
?>
 <script type="text/javascript" async  data-pin-shape="round" data-pin-height="32" data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>
<?
}
?>
<style type="text/css">
#boxes  {
		font-family: <?=$SITE[cssfont];?>;
		list-style-type: none;
		margin:0;
		padding:0;
		width: 103%;
		margin-top:0px;
		margin-bottom:0px;
		box-sizing:border-box;
}

#boxes li {
		background-color:#<?=$boxesBGColor;?>;
		margin-top:0px;
		margin-bottom:<?=$P_DETAILS[ContentMarginH];?>px;
		margin-<?=$SITE[align];?>:0px;
		margin-<?=$SITE[opalign];?>:<?=($P_DETAILS[ContentMarginW]);?>px;
		padding-top:1px;padding-bottom:2px;
		padding-<?=$SITE[align];?>:1px;
		padding-<?=$SITE[opalign];?>:6px;
		float: <?=$SITE[align];?>;
		min-height:<?=$ContentMinHeight;?>px;
		width:<?=$boxWidth;?>px;
		<?=$border_css;?>;

	}
#boxes li .innerDiv {
	background-color:#<?=$SITE[shortcontentbgcolor];?>;
	margin:0;
	min-height:<?=$ContentMinHeight;?>px;
}
#boxes li.li_spacer {
	background-color:transparent;
	width:100%;
	height:0px;
	min-height:1px;
	border:0;
	clear:both;
	padding:0;
	margin:0px;
	box-sizing:border-box;
}

#boxes li .mainContentText li {
	margin:0;
	padding:0px;
	border:0px;
	float:none;
	width:auto;
	min-height:0;
	background-color:transparent;
	
}
#boxes li .mainContentText ul {list-style-type: disc}
#boxes li.ui-sortable-placeholder {background-color:transparent;border: 1px dotted silver;visibility: visible !important;min-height:50px;}
#boxes li.wide{width:100%;box-sizing:border-box;}
#lock_prop {cursor:pointer}
<?
if ($P_DETAILS[ContentPhotoBGColor] OR $P_DETAILS[ContentBorderColor]) {
	?>
	.photoWrapper, .photoHolder {background-color:#<?=$P_DETAILS[ContentPhotoBGColor];?>;}
	.photoHolder {background-image:none;}
	#boxes li {padding-top:0px;padding-bottom:0px;padding-<?=$SITE[align];?>:0px;}
	<?
}
if ($boxesBGColor) {
	?>
	#boxes li {padding-top:0px;padding-bottom:0px;padding-<?=$SITE[align];?>:0px;}
	<?
}
if  (!$P_DETAILS[ContentPhotoBGColor] AND !$P_DETAILS[ContentPicBG] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[ContentBorderColor] AND !$P_DETAILS[PhotosBorderColor] AND !$P_DETAILS[ContentTextBGColor]) {
	?>
	.photoHolder {padding-right:0px;padding-left:0px}
	<?
}
$Proporsion=1;
if ($P_DETAILS[ContentPhotoHeight]>0 AND $P_DETAILS[ContentPhotoWidth]>0) $Proporsion=$P_DETAILS[ContentPhotoWidth]/$P_DETAILS[ContentPhotoHeight];
?>

@media all and (max-width : 680px)  {
	.rwd#boxes * {box-sizing:border-box;}
    .rwd#boxes li {
	    width:100%;
	    margin-right:0px;
	    margin-left:0px;
	    padding:7px;
	    min-height:0px;
	    box-sizing:border-box;
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
    .rwd#boxes li #printArea div.mainContentText{width: 98% !important;padding-<?=$SITE[opalign];?>:6px;padding-<?=$SITE[align];?>:0px !important;overflow:inherit}
    .rwd#boxes li div div.shortContentTitle {padding-<?=$SITE[align];?>:0px !important;}
    .rwd#boxes li div div.topShortContentTitle {padding-<?=$SITE[align];?>:6px !important;}
    .rwd#boxes li .short_content_container{float:none !important;width:100% !important;padding:6px !important;box-sizing:border-box;}
    .rwd#boxes li #printArea div.mainContentText img {max-width: 100%;width:auto !important;height:auto !important;}
}

</style>
<?
	if (isset($_SESSION['LOGGED_ADMIN'])) print '<a href="'.$SITE[media].'/category/'.$urlKey.'">To All briefs page</a>';
	$CONTENT=GetMultiContent($urlKey);
	print '<ul id="boxes">';
	print '<li class="li_spacer" style="min-height:3px;"></li>';
	$num_inline=0;
	$max_briefs=count($CONTENT[PageID]);
	$start_brief=0;
	if ($_GET['from']>0) $start_brief=$_GET['from']-1;
	if ($_GET['limit']) $max_briefs=$limit+1;

	for ($a=0;$a<$max_briefs;$a++) {
		//$photo_alt=htmlspecialchars($CONTENT[ContentPhotoAlt][$a],ENT_QUOTES);
		if ($CONTENT[ContentPhotoName][$a]=="" AND $CONTENT[PageTitle][$a]=="" AND $CONTENT[ShortContent][$a]=="" AND $CONTENT[PageContent][$a]=="") continue;
		$photo_alt=str_replace("'","&lsquo;",$CONTENT[ContentPhotoAlt][$a]);
		$photo_alt=str_replace('"',"&quot;",$photo_alt);
		$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
		$photo_alt=str_ireplace("’","&rsquo;",$photo_alt);
		$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
		$num_inline++;
		$p_url=$SITE[url]."/".$CONTENT[UrlKey][$a];
		$page_url=$CONTENT[PageUrl][$a];
		$target_location="_top";
		$rel_code="";
		if (!stripos(urldecode($page_url),"/")==0 AND $page_url!="") $target_location="_blank";
		
		
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
		
		?>
		<li id="short_cell-<?=$CONTENT[PageID][$a];?>" class="<?=$class;?>">
		<?
		if (!$P_DETAILS[ContentPhotoBGColor]) $topRoundedCornersColor=$SITE[shortcontentbgcolor];
		if ($is_rounded) {
			if ($P_DETAILS[isTitlesAbove]==1) $topRoundedCornersColor=$SITE[shortcontentbgcolor];
			// Check if the image is in the database.
			if ($CONTENT[ContentPhotoName][$a]=="") {
				if (!$CONTENT[isFullWidth][$a]==1) $topRoundedCornersColor=$SITE[shortcontentbgcolor];
				if (!$CONTENT[isFullWidth][$a]==1 AND $P_DETAILS[ContentTextBGColor])  $topRoundedCornersColor=$P_DETAILS[ContentTextBGColor];
			}
			
			SetShortContentRoundedCorners(1,0,$topRoundedCornersColor,$roundedCornersWidth);
			?>
			<div <?=$inner_float_code;?> class="innerDiv" style="min-height:<?=$inner_min_height;?>px;width:<?=$innerDivWidth-6;?>px;padding-<?=$SITE[align];?>:<?=$inner_div_rightPadding;?>px;padding-<?=$SITE[opalign];?>:6px;padding-bottom:0px;">
			<?
		}
		$have_pic=0;
		$add_photo_show="";
		if ($CONTENT[ContentPhotoName][$a]=="") {
			$CONTENT[ContentPhotoName][$a]="content_nopic.png";
			//if (!$SITE[shortcontentbgcolor]) $short_content_padding=0;
			$short_text_width_complete=$short_text_width+$SITE[galleryphotowidth]+($shortTextLeft-6);
			if ($CONTENT[isFullWidth][$a]==1) $short_content_padding=0;
			$short_content_extra_css="width:".($roundedCornersWidth-12)."px;background-color:#".$P_DETAILS[ContentTextBGColor];
			if (!$CONTENT[isFullWidth][$a]==1) $short_content_extra_css="width:".($roundedCornersWidth)."px;background-color:#".$P_DETAILS[ContentTextBGColor];
			if ($CONTENT[isFullWidth][$a]==1 AND !$is_rounded) $short_content_extra_css.=";padding-".$SITE[align].":6px;width:".($roundedCornersWidth-16)."px";
			if ($CONTENT[isFullWidth][$a]==1 AND $is_rounded) $short_content_extra_css.=";padding-".$SITE[align].":5px;width:".($roundedCornersWidth-16)."px";
			if ($CONTENT[isFullWidth][$a]==1 AND ($P_DETAILS[ContentTextBGColor] OR $SITE[shortcontentbgcolor] OR $P_DETAILS[ContentBorderColor])) $short_content_extra_css.=";padding-top:6px;padding-bottom:6px;";
			if ($P_DETAILS[ContentMinHeight] AND !$CONTENT[isFullWidth][$a]==1 AND $P_DETAILS[ContentTextBGColor]) $short_content_extra_css.=";min-height:".($inner_min_height)."px;";
			
			if (!$P_DETAILS[ContentBorderColor] AND !$P_DETAILS[ContentPicBG] AND !$P_DETAILS[ContentPhotoBGColor] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[ContentTextBGColor]) {
				$short_content_extra_css.=";padding-".$SITE[align].":0px;margin-".$SITE[align].":0px";
				if (!$CONTENT[isFullWidth][$a]==1) $short_content_extra_css.=";margin-".$SITE[align].":-5px";
			}
			
		}
		else {
			
			if ($CONTENT[isFullWidth][$a]==1 AND !$is_rounded) $short_content_extra_css.=";padding-".$SITE[align].":0px;width:".($roundedCornersWidth)."px"; //25/7/12
			$add_photo_show="none";
			$have_pic=1;
			//Added 6/12/12:
			if ($P_DETAILS[isTitlesAbove]==1 AND !$CONTENT[isFullWidth][$a]==1) {
				if ($titleShow=="")
					{
					?>
					<strong><div class="shortContentTitle customTitleStyle topShortContentTitle" id="titleContent_<?=$CONTENT[PageID][$a]; ?>"  style="display:<?=$titleShow;?>;padding-<?=$SITE[align];?>:<?=$short_content_padding;?>px;padding-top:3px;padding-bottom:5px;">
					<?
					if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
					?>
					<?=$CONTENT[PageTitle][$a];?></a></div></strong>
					<?
				}
			}
			?>
			<div class="photoHolder custom" id="photo_img_holder_<?=$CONTENT[PageID][$a];?>" style="float:<?=$pFloating;?>;<?=$photoHolderExtraCSS;?>">
			<div class="photoWrapper custom">
			<?
			$id_text="";
			if ($CONTENT[EnableEnlarge][$a]==1) {
				?>
				<a href="<?=SITE_MEDIA."/".$gallery_dir."/".$CONTENT[ContentPhotoName][$a];?>" class="photo_gallery"  title="<?=$CONTENT[PageTitle][$a];?>">
				<?
			}
			if (!$page_url=="" AND !$CONTENT[EnableEnlarge][$a]==1) {
				?>
				<a href="<?=$page_url;?>" target="<?=$target_location;?>" <?=$rel_code;?>>
				<?
			}
			?>
			<img border="0" id="photo_img_<?=$CONTENT[PageID][$a];?>"  src="<?=SITE_MEDIA;?>/gallery/articles/<?=$CONTENT[ContentPhotoName][$a];?>" alt='<?=$photo_alt;?>' title='<?=$photo_alt;?>' /><?if (!$page_url=="" OR $CONTENT[EnableEnlarge][$a]==1) print '</a>';?>
			</div>
		
		</div>
		
		<?
		} 	//End Check if Photo NOT Exist so we put only text content
		
		if ($CONTENT[isFullWidth][$a]==0) $short_content_extra_css.=";padding-bottom:5px";
		//if ($CONTENT[isFullWidth][$a]==1 AND ) $short_content_extra_css.=";padding-bottom:5px";
		if ($CONTENT[isFullWidth][$a]==0) print '<div class="clear"></div>';
		//TO BE Added 4/9
		?>
		<div class="short_content_container" id="short_content_container_<?=$CONTENT[PageID][$a];?>" style="padding-<?=$SITE[align];?>:0px;margin-<?=$SITE[align];?>:0px;align:<?=$SITE[align];?>;padding-top:0px;<?=$short_content_extra_css;?>">
		<?
		
		if (!$P_DETAILS[isTitlesAbove] OR $CONTENT[isFullWidth][$a]==1 OR $have_pic==0) {
			if ($titleShow=="")
				{
				?>
				<strong><div class="shortContentTitle customTitleStyle" id="titleContent_<?=$CONTENT[PageID][$a]; ?>"  style="display:<?=$titleShow;?>;padding-<?=$SITE[align];?>:<?=$short_content_padding;?>px;padding-top:3px;">
				<?
				if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
				?>
				<?=$CONTENT[PageTitle][$a];?></a></div></strong>
				<?
				}
		}
			?>
		<div id="printArea"><div id="divContent_<?=$CONTENT[PageID][$a]; ?>" align="<?=$SITE[align];?>" class="mainContentText customContentStyle" style="margin-<?=$SITE[opalign];?>:6px;padding-<?=$SITE[align];?>:<?=$short_text_padding;?>px">
		<?
		if ($CONTENT[ShortContent][$a]=="") $CONTENT[ShortContent][$a]=$CONTENT[PageContent][$a];
		print str_ireplace("&lsquo;","'",$CONTENT[ShortContent][$a]);
		?></div></div>
		<div style="clear:both;"></div>
	<?
	
		if (!$is_rounded) print "</div>";
		print "<div class='clear'></div>";
		if ($is_rounded) {
			if (!$CONTENT[isFullWidth][$a]==1 AND $CONTENT[ShortContent][$a]=="" AND $CONTENT[PageTitle][$a]=="") $bottomRoundedCornersColor=$topRoundedCornersColor;
			print "</div></div>";
			SetShortContentRoundedCorners(0,0,$bottomRoundedCornersColor,$roundedCornersWidth);
			
		}
		print "</li>";
		if ($num_inline==$num_short_content_in_line) {
			print '<li class="li_spacer"></li>'; //13/6/12
			$num_inline=0;
		}
	}
	print '<li class="li_spacer"></li>';
	print '</ul>';
?>
<div class="clear"></div>
<script type="text/javascript" src="<?=$SITE['cdn_url'];?>/js/jquery.matchHeight-min.js"></script>

<script>
var max_height;
function setBriefsMinHeight() {
		max_height = 0;
		jQuery('ul#boxes li').not(".wide, .li_spacer").each(function(){
			if(jQuery(this).height() > max_height)
				max_height = jQuery(this).height();
		});
		if(max_height > 0) jQuery('ul#boxes li').not(".wide, .li_spacer").matchHeight();
			//jQuery('ul#boxes li').not(".wide, .li_spacer").css("min-height",max_height+"px");
			
}
function setIframeHeight() {
	var h=jQuery("body").height()+8;
	
	jQuery("#iframe_shortContentBottom_<?=$urlKey;?>",parent.document.body).height(h+"px");
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
	if (jQuery(parent.window).width()>680) {
		window.setTimeout('setBriefsMinHeight()',50);
	}


});
jQuery(document).ready(function() {
	
	if (jQuery(parent.window).width()<680) rwdShortContentIframe();
	var container_width=jQuery("ul#boxes").width();
	window.setTimeout('setIframeHeight()',300);
	

});

</script>
</body>
</html>