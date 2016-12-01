<?

//TODO: Check if page is homepage with no urkLey and put the relevant pID to expose the ParentCATID 
$gal_type=0;
if (isEffectGalleryPage($urlKey)) $gal_type=3;
if ($CHECK_CATPAGE[CatType]==3) $gal_type=1;
$GAL=GetCatGallery($urlKey,$gal_type);
$ITEM=GetCatItem($urlKey,1);
$isLeftColumn=GetCatStyle("ShowLeftColumn",$CHECK_CATPAGE[parentID]);
$isLeftColumnInherit=GetCatStyle("LeftColInherit",$CHECK_CATPAGE[parentID]);
$customLeftColWidth=GetCatStyle("LeftColWidth",$CHECK_CATPAGE[parentID]);
$LeftColSide=GetCatStyle("leftColSide",$CHECK_CATPAGE[parentID]);
$leftColSeperatorColor=GetCatStyle("leftColSepColor",$CHECK_CATPAGE[parentID]);
$CHECK_INHERIT_LEFT=CheckLeftColumnParent($CHECK_CATPAGE[parentID]);
$CHECK_LEFT_INHERIT_TMP=CheckLeftColumnParent(1);
$leftCol_Parent_Cat=$CHECK_INHERIT_LEFT[parent_cat_id];
if ($CHECK_INHERIT_LEFT[custom_width] AND !$customLeftColWidth) $customLeftColWidth=$CHECK_INHERIT_LEFT[custom_width];
if ($LeftColSide=="") $LeftColSide=$CHECK_INHERIT_LEFT[leftColSide];
if ($LeftColSide=="") $LeftColSide=$CHECK_LEFT_INHERIT_TMP[leftColSide];
if ($LeftColSide=="") $LeftColSide=$SITE[opalign];
if ($customLeftColWidth=="") $customLeftColWidth=220;
if ($isLeftColumn=="") {
	$check_left_col_inherit=$CHECK_INHERIT_LEFT[left_inherit];
	if ($check_left_col_inherit==1) $isLeftColumn=1;
}
if ($customLeftColWidth) {
	$rightColWidth=($dynamicWidth-268)-($customLeftColWidth);
	if ($P_DETAILS[PageStyle]==1) $rightColWidth=($dynamicWidth-12)-($customLeftColWidth);
	$leftCol_widthStyle='width:'.$customLeftColWidth.'px;';
	$rightColWidthStyle='width:'.$rightColWidth.'px;';
}
if (!$leftColSeperatorColor) $leftColSeperatorColor=$SITE[leftcolseperatorcolor];
if ($leftColSeperatorColor) $leftColSeperatorStyle="border-".$SITE[align].":1px solid #".$leftColSeperatorColor;
if ($LeftColSide==$SITE[align]) $leftColSeperatorStyle="border-".$SITE[opalign].":1px solid #".$leftColSeperatorColor;

if ($leftColSeperatorColor=="-") $leftColSeperatorStyle="border-".$SITE[align].":0px solid transparent";
if (isset($_SESSION['LOGGED_ADMIN'])) {
	if (!$CHECK_PAGE) include_once("Admin/EditArea.inc.php");
	?>
	<div style="height:3px"></div>
	<?
	
}

?>
<style type="text/css">
.leftColCustom {
	<?=$leftCol_widthStyle;?>;
	<?=$leftColSeperatorStyle;?>;
	<?if ($LeftColSide==$SITE[align]) {
		print "float:".$SITE[align].";";
		print "padding-".$SITE[opalign].":6px;";
		print "padding-".$SITE[align].":0px;";
	}
	?>
}
.rightColCustom {
	<?=$rightColWidthStyle;?>;
	<?if ($CHECK_CATPAGE[CatType]==0) print 'margin-top:-5px;';?>
	<?if ($LeftColSide==$SITE[align]) print "float:".$SITE[opalign];?>;
}
</style>

<?
if($urlKey == 'order')
	{
		include_once("shopOrder.php");
	}
elseif ($CHECK_PAGE) {
	if ($CHECK_PAGE[galleryID]) include_once("ProductPage.php");
	elseif ($CHECK_PAGE[ProductID]) include_once("shopProduct.php");
	else {
		$CONTENT=GetContent($urlKey);
		if ($CONTENT[FullContent]=="") $CONTENT[FullContent]=$CONTENT[PageContent];
		?>
		<!--	Added 25/12/2009-->
		<link rel="stylesheet" href="<?=$SITE[url];?>/lightbox/css/lightbox.css" type="text/css" media="screen" />
		<!--	Added 25/12/2009-->	
		<span  id="titleContent" class="titleContent" style="display:;padding-<?=$SITE[align];?>:5px;"><h1><?=$CONTENT[PageTitle];?></h1></span>
		<?
		if (isset($_SESSION['LOGGED_ADMIN']))  {
			?>
				<?include_once('./Admin/EditPageClient.php');?>
				<div class="cHolder" id="cHolder">
				
			<?
			if ($CONTENT[FullContent]=="") $CONTENT[FullContent]=$CONTENT[PageContent];
			
		}
		?>
		<div id="printArea"><div id="divContent" align="<?=$SITE[align];?>" style="margin-<?=$SITE[align];?>:5px;padding-<?=$SITE[opalign];?>:15px;" class="mainContentText">
		<?
		print $CONTENT[FullContent];
		?></div></div>
		<?
		if (isset($_SESSION['LOGGED_ADMIN'])) print "</div>";
		if ($CHECK_PAGE[G_WIDGET]) $P_DETAILS[G_WIDGET]=$CHECK_PAGE[G_WIDGET];
		if ($P_DETAILS[FB_WIDGET]>0 OR $SITE[fb_integration]) include_once("facebook_widgets.php");
		if ($P_DETAILS[G_WIDGET] OR $SITE[g_integration]) include_once("google_widgets.php");
	}
}
else {
	if ($isLeftColumn==1) {
		?>
			<div class="leftColumn_right rightColCustom">
		<?
	}
	
	switch ($CHECK_CATPAGE[CatType]) {
	case 1:
		 include_once("short_content.php");
		 break;
	case 11:
		 include_once("short_content.php");
		 break;
	case 12:
		 if ($SITE[isFullResponsive]==1) include_once("short_content_bottom_theme.php");
		 else include_once("short_content_bottom.php");
		 break;
	case 14:
		 include_once("shopProducts.php");
		 break;
	case 21:
		include_once("short_content_collage.php");
		 break;
	case 15:

		 include_once("shopOrder.php");
		 break;
	case 16:
		 include_once("shopOrderDetails.php");
		 break;
	case 17:
		 include_once("customFormPage.php");
		 break;
	case 2:
		
		if ($GAL[Type]==0 AND $GAL[Type]!="") {
			if ($SITE['isFullResponsive']==1) include_once("gallery_new_theme.php");
			else include_once("gallery.php");

		}
		if ($GAL[Type]==3 AND $GAL[Type]!="") {
		//$debug=true;
		include_once("effect_gallery.php");
		
		}
		break;
	case 3:
		if ($GAL[Type]==1) include_once("videogallery.php");
		break;
	case 40:
		include_once("hybridpage.php");
	break;

	default:
		include_once("long_content.php");
		if ($custompage) include_once($custompage);
		break;
	
	}
		
	if ($CHECK_PAGE[G_WIDGET]) $P_DETAILS[G_WIDGET]=$CHECK_PAGE[G_WIDGET];
	if ($P_DETAILS[FB_WIDGET]>0 OR $SITE[fb_integration]) include_once("facebook_widgets.php");
	if ($P_DETAILS[G_WIDGET] OR $SITE[g_integration]) include_once("google_widgets.php");
	if ($SITE['custom_comments'])
	{
		$custom_comments_content = @file_get_contents('http:'.SITE_MEDIA.'/httpfiles/custom_comments.html');
		print $custom_comments_content;

	}
	if ($isLeftColumn==1) {
		?>
		</div>
		<div class="leftColumn leftColCustom"><? include_once("leftColumn.php");?></div>
		
		<?
				
	}
}
if ($SITE[mobileEnabled]) {?>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/rwd.js.php?catType=<?=$CHECK_CATPAGE[CatType];?>&galType=<?=$GAL[Type];?>&mobilelogo=<?=$SITE[mobilelogo];?>&mobilemainpichomepage=<?=$SITE[mobilemainpichomepage];?>&site_media=<?=SITE_MEDIA;?>&aws_s3_enabled=<?=$AWS_S3_ENABLED;?>"></script>
	<link href="<?=$SITE[url];?>/css/photoswipe.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?=$SITE[url];?>/js/klass.min.js"></script>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/code.photoswipe-3.0.5.min.js"></script>
	
	<?

	
}


?>
<script language="javascript">
	var rightsideheight=jQuery('.rightSide').height();
	function measureRightSideHeight() {
		rightsideheight=jQuery('.rightSide').height();
		if (rightsideheight>jQuery('.contentOuter').height()) jQuery('.contentOuter').css('min-height',(rightsideheight)+"px");
	}
	function setLeftColMinHeight() {
		var leftCol_rightHeight=jQuery('.leftColumn_right').height();
		jQuery('.leftColumn').css('min-height',(leftCol_rightHeight)+"px");
	}
	<?
	if ($NEWS[ScrollType][0]==1) {
		?>
		//rightsideheight=150+jQuery('#sideCatContent').height()+jQuery('#sideCatContentTop').height()+jQuery('#sideContactText').height()+jQuery('#contact_layer_side').height()-20;
		if (GlobalWinWidth>680) window.setTimeout('measureRightSideHeight()',390);
		<?
	}
	else {
		?>
		if (rightsideheight>jQuery('.contentOuter').height() && GlobalWinWidth>680) jQuery('.contentOuter').css('min-height',(rightsideheight)+"px");
		<?
	}
	
	if ($isLeftColumn) {
		
		if ($CHECK_CATPAGE[CatType]!=21) {
		 	?>
			if (GlobalWinWidth>680) window.setTimeout("setLeftColMinHeight()",200);
			<?
		}
	}
	
	if($P_DETAILS[PageStyle]==2) {
		?>
			jQuery(document).ready(function() {
				if (GlobalWinWidth>680) window.setTimeout('SetSeperatedEqualHeight()',295);
			});
		<?
	}
	?>
	
	
</script>
