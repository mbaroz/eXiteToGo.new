<?
$SITE_LANG[selected]=($SITELANG[selected] != '') ? $SITELANG[selected] : $SITE_LANG[selected];
if ($SITE_LANG[direction]=="") $SITE_LANG[direction]=$SITELANG[direction];
//ini_set("session.gc_maxlifetime",3000);
include_once("config.inc.php");

if ($_GET['admin_preview_mode']==sha1($SITE[url]) AND !isset($_SESSION['admin_preview_mode'])) $_SESSION['admin_preview_mode']=sha1($SITE[url]);

if (isset($_SESSION['admin_preview_mode'])) $SITE[mobileEnabled]=1; //just for us to check
if ($_GET[mobile] AND isset($_SESSION['LOGGED_ADMIN'])) $SITE[mobile_preview]=1;
if ($_GET['m_p_o']==1) $SITE[mobile_preview]=0;
if ($SITE[mobileEnabled] AND isset($_SESSION['LOGGED_ADMIN']) AND $SITE[mobile_preview]==1) {
	//session_register("mini_admin_mode");
	unset($_SESSION['LOGGED_ADMIN']);
	
}
if ($SITE_LANG[selected]=="") $SITE_LANG[selected]=$SITELANG[selected]=$default_lang;
if (stristr($_SERVER['REQUEST_URI'], '/en/')) {
	$SITE[url]=str_ireplace("www.", 'en.', $SITE[url]);
	$_SERVER['REQUEST_URI']=str_ireplace("/en/", '/', $_SERVER['REQUEST_URI']);
}
$href_url=$SITE[url].$_SERVER['REQUEST_URI'];
$site_url_check=str_ireplace("http://","",$SITE[url]);
if (stristr($SITE[url],"https://")) $site_url_check=str_ireplace("https://","",$SITE[url]);
if ($_SERVER['HTTP_HOST']!=$site_url_check) {
	Header("HTTP/1.1 301 Moved Permanently");
	header("Location:".$href_url);
}
if(file_exists('sites/'.$SITE['S3_FOLDER'].'/configAddOn.php'))	require_once('sites/'.$SITE['S3_FOLDER'].'/configAddOn.php');

$_SESSION['retu']=$href_url;
if (isset($_SESSION['MEMBER'])) $MEMBER=$_SESSION['MEMBER'];

$content_lang=$SITE_LANG[selected];
if ($content_lang=="") $content_lang=$default_lang;
include_once("auth.php");
include_once("inc/topmenu.inc.php");
include_once("round_corners.inc.php");
include_once("inc/headerpics.inc.php");
include_once("inc/Mobile_Detect.php");
//$SITE['cdn_url']="http://cdn.exiteme.com";
$SITE['cdn_url']="//cdn.exiteme.com";
// Added to support ckeditor in amazon bucket.
// if ($AWS_S3_ENABLED) $SITE['cdn_url']="http://cdn.exiteme.com";
$mobileDetect=new Mobile_Detect();
$inc_mobile_menu=0;
if ($mobileDetect->isTablet()) {
	$SITE[mobileEnabled]=0;
	$SITE[sitewidth]=0;
}
if ($SITE[mobileEnabled] AND $mobileDetect->isMobile() OR isset($_SESSION['admin_preview_mode'])) $inc_mobile_menu=1;
if ($SITE[mobileEnabled] AND $SITE[mobilelogo] AND $mobileDetect->isMobile()) $SITE[logo]=$SITE[mobilelogo];

if (ieversion()<8 AND ieversion()>0) $b_ver=ieversion();
if ($b_ver==7) $topHeaderHeight="auto";
	else $topHeaderHeight="80px";
if($CHECK_PAGE['ProductID'] > 0)
	$P_DETAILS=GetMetaData($CHECK_PAGE['ProductID'],2);
else
{
	$P_DETAILS=GetMetaData($CHECK_CATPAGE[parentID],1);
	if ($CHECK_PAGE) $P_DETAILS=GetMetaData($CHECK_PAGE[parentID]);
}
if ($SITE['MobileHomePage'] AND $SITE[mobileEnabled] AND $urlKey=="home" AND !isset($_SESSION['LOGGED_ADMIN']) AND $mobileDetect->isMobile()) {
	Header("HTTP/1.1 301 Moved Permanently");
	header("Location:".$SITE[url]."/category/".$SITE['MobileHomePage']);
}

if (!$P_DETAILS[TagTitle] AND $CHECK_CATPAGE AND !$SITE[title]) $P_DETAILS[TagTitle]=$P_DETAILS[MenuTitle];
if (!$P_DETAILS[PageDescribtion] AND $CHECK_PAGE)  $P_DETAILS[PageDescribtion]=$P_DETAILS[PageTitle];

if (!$P_DETAILS[PageDescribtion]) $P_DETAILS[PageDescribtion]=$SITE[description];
if (!$P_DETAILS[PageKeywords]) $P_DETAILS[PageKeywords]=$SITE[keywords];
if (!$P_DETAILS[TagTitle] AND !$CHECK_PAGE) $P_DETAILS[TagTitle]=$P_DETAILS[MenuTitle]." - ".$SITE[title];
if ($CHECK_PAGE AND !$P_DETAILS[TagTitle]) $P_DETAILS[TagTitle]=$P_DETAILS[PageTitle]." - ".$SITE[title];

if ($CHECK_CATPAGE AND $_GET['page']>1 AND $shopActivated) {
	if ($SITE_LANG[selected]=="he") $page_translated="עמוד";
	else $page_translated="Page";
	$P_DETAILS[TagTitle].=" | ".$page_translated."-".$page;
	$P_DETAILS[PageDescribtion].=". ".$page_translated."-".$page;
}

$productPageGalID=$CHECK_PAGE[galleryID];
if ($productPageGalID AND $CHECK_PAGE[productUrlKey]) {
	$db->query("SELECT FileName from photos WHERE GalleryID='$productPageGalID' LIMIT 1");
	$db->nextRecord();$photoOGTAG=$SITE[media]."/gallery/".$db->getField("FileName");
	
}

$SITE_URL=$SITE[url];
$ROOT_URLKEY=GetRootUrlKey($urlKey);
if ($ROOT_URLKEY[ParentMenuTitle]=="") $ROOT_URLKEY[ParentMenuTitle]=$CHECK_CATPAGE[title];
if (!$P_DETAILS[CatTitle]=="") $ROOT_URLKEY[ParentMenuTitle]=$P_DETAILS[CatTitle];
if ($ROOT_URLKEY[ParentMenuTitle]==" " AND isset($_SESSION['LOGGED_ADMIN'])) $ROOT_URLKEY[ParentMenuTitle]=$ADMIN_TRANS['untitled'];
$SITE[pageverlaypic]=$P_DETAILS[OverlayPhotoName]; //just cause $SITE is session registered
$SITE[pageoverlayheight]=$P_DETAILS[OverlayPhotoHeight]; //just cause $SITE is session registered
$SITE[pageheaderbg]=$P_DETAILS[HeaderBGPhotoName]; //just cause $SITE is session registered
$C_STYLING=json_decode($P_DETAILS[CatStylingOptions],true);
$SITE[CurrentPageContentBGColor]=$C_STYLING[CatContentBGColor];
$SITE[CatSiteBGColor]=$C_STYLING[CatSiteBGColor];
$SITE[CatSiteTextColor]=$C_STYLING[CatSiteTextColor];
$SITE[CatSiteTitlesColor]=$C_STYLING[CatSiteTitlesColor];
$SITE[CatContentTextSize]=$C_STYLING[CatContentTextSize];
$SITE[CatTitlesTextSize]=$C_STYLING[CatTitlesTextSize];
$SITE[CatFontFace]=$C_STYLING[CatFontFace];
$SITE[ThisPageContentBGPic]=$C_STYLING[ThisPageContentBGPic];
$SITE[CurrentPageStyle]=$P_DETAILS[PageStyle];
if ($P_DETAILS[MainPicSideText]==0) $P_DETAILS[MainPicSideText]=isParentMainPicSideTextDisabled($urlKey);

if ($P_DETAILS[PageStyle]=="") $P_DETAILS[PageStyle]=0;
include_once($inc_dir."defaults.php");

$_SESSION['retu']=$_SERVER['REQUEST_URI'];
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
<title><?=$P_DETAILS[TagTitle];?></title>

<meta http-equiv="Content-Language" content="<?=$content_lang;?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="<?=$P_DETAILS[TagTitle];?>" />
<?
if ($CHECK_PAGE['ProductID']>0) {
	?>
	<meta property="og:type" content="product" />
	<meta property="og:price:amount" content="<?=$P_DETAILS['ProductPrice'];?>" />
	<meta property="og:price:currency" content="<?=$SITE[nis];?>" />
	<?
}
?>
<meta name="Description" content="<?=$P_DETAILS[PageDescribtion];?>" />
<meta name="Keywords" content="<?=$P_DETAILS[PageKeywords];?>" />
<?if ($urlKey=="404" OR $P_DETAILS[SEBlock]==1) print '<meta name="robots" content="noindex, nofollow">';?>
<?if($photoOGTAG) print '<meta property="og:image" content="'.$photoOGTAG.'"/>';?>
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php?urlKey=<?=$urlKey;?>&cID=<?=$CHECK_CATPAGE[parentID];?>">
<link rel='stylesheet' type="text/css" media="only screen and (max-device-width: 680px) ,(max-width:680px)" href='<?=$SITE[url];?>/css/iphone.css.php' />
<link href="<?=$SITE[cdn_url];?>/css/animate.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/css/he_fonts.css">
<?if ($SITE[mobileEnabled] AND !isset($_SESSION['LOGGED_ADMIN'])) {?>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0">
	<link rel='stylesheet' type="text/css" media="only screen and (max-device-width: 680px) ,(max-width:680px)" href='<?=$SITE[url];?>/css/rwd.css.php?mobileheaderbgpic=<?=$SITE[mobileheaderbgpic];?>&show_top_bg=<?=$SITE[show_topbg_mobile];?>&mobile_bg_color=<?=$SITE[mobilesitebgcolor];?>&hide_all_bgs=<?=$SITE[hide_all_bgs];?>&show_main_gallery_mobile=<?=$C_STYLING[showMainGalleryMobile];?>' />
	<?}?>
	

<?if ($gfont_exists) print "<link href='http://fonts.googleapis.com/css?family=".$g_fonts."' rel='stylesheet' type='text/css'>";?>
 <!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/ie7.css.php?urlKey=<?=$urlKey;?>" />
<![endif]-->
 
<link rel="shortcut icon" href="<?=SITE_MEDIA;?>/gallery/favicon.ico" type="image/x-icon" /> 
<?
if (isset($_SESSION['LOGGED_ADMIN']) OR isset($_SESSION['mini_admin_mode'])) {
	?>
	<script language="javascript"  type="text/javascript" src="<?=$SITE[url];?>/js/prototype.js"></script>
	<script language="javascript"  type="text/javascript" src="<?=$SITE[url];?>/js/scriptaculous.js"></script>
	<?
}
?>
<script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
<script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/js/gallery/fancybox/jquery.fancybox.pack.js?v=2.0.5"></script>
<script language="javascript" type="text/javascript">

jQuery.noConflict();
var GlobalWinWidth=jQuery(window).width();
var fancyBoxFullScreen=0;
</script>
<?
if ($SITE[showtoupicon]==1) {
	?>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/jquery.ui.totop.js"></script>
	<script language="javascript" type="text/javascript">
	jQuery(document).ready(function() {
		
		jQuery().UItoTop({ easingType: 'easeOutQuart' });
		});
	</script>
	<?
}
include_once("metaTagsAddons.php");
if (!isset($_SESSION['LOGGED_ADMIN']))  print html_entity_decode(stripcslashes($SITE[googleanalytics]));
?>
</head>
<body>

<?if (isset($_SESSION['LOGGED_ADMIN']) AND !$SITE[mobile_preview]) include_once("Admin/AdminTop.inc.php");?>	
<?if (isset($_SESSION['mini_admin_mode']) AND !$SITE[mobile_preview]) include_once("Admin/AdminTopView.inc.php");?>	
<?if (isset($_SESSION['LOGGED_ADMIN']) AND !$SITE[mobile_preview]) include_once("Admin/headerPicUpload.php");?>
<?
if ($SITE[showmasterheaderfooter]==1 OR $SITE[showmasterheaderfooter]==3) include_once("master_header.php");
?>
<div class="mainPage" align="center" id="TopHead" name="TopHead">
<div class="shadow_layer">
<?if ($SITE[mobileEnabled] AND $inc_mobile_menu) include_once("rwdMenu.php");?>
	<?
	 if ($shopActivated) {
		print "<div style='width:".$dynamicWidth."px' class='shopMainCartWrapper'>";
		require_once 'mini_cart.php';
		print "</div>";
	}
	if ($SITE[topheaderbg]!="-" OR $inc_mobile_menu==1) {
		?>
		<?if ($SITE[topheaderfullwidth]) print '<div class="topHeaderFull">';?>
		<div class="topHeader">
			<?if ($SITE[topmenubottom]!=4) {
				?>
				<div class="topHeaderLogo" id="topHeaderLogo">				
				<?=SetLogo($P_DETAILS[HideTopMenu],$C_STYLING[showLogoOnLandingPage]);?>
				</div>
			<? //if($shopActivated) require_once 'mini_cart.php'; ?>
			<?
			}
			if ($SITE[searchformtop]==1) {
				print '<div class="searchFormTop">';
				include_once("searchForm.inc.php");
				print "</div>";
			}
			if ($SITE[topmenubottom]==2 AND $P_DETAILS[HideTopMenu]==0) {
				?>
				
				<div class="topHeaderTopMenu">
				<?if ($inc_mobile_menu==0) SetTopMenuNew();?>
				</div>
				<?
			}
			else {
					if ($SITE[topmenubottom]==0 OR $SITE[topmenubottom]==1 OR $SITE[topmenubottom]==3) {
						?>
						<div class="topHeaderSlogen" id="topHeaderSlogen">
						<span id="topSlogen"><?if ($P_DETAILS[HideTopMenu]==0) print $SITE[slogen];?></span>
						</div>
						<?
						if (isset($_SESSION['LOGGED_ADMIN']) AND $P_DETAILS[HideTopMenu]==0) include_once("Admin/sloganAdmin.php");
					}
			}
			if ($SITE[searchformtop]>1 OR $SITE[searchformtop]==0 OR $SITE[searchformtop]=="") {
				//print '<div class="topLangSelector">';
				//include_once("langselector.inc.php");
				//print "</div>";
			}
			?>
			
		<div class="clear"></div>
		</div> <!-- End of topHeader -->
		<?if ($SITE[topheaderfullwidth]) print '</div>';?><!-- End of topHeaderFull-->
		
		<?
		}
		?>
	<div class="clear"></div>
	<div class="h_margin" style="height:<?=$mainpictopmargin_defaultdiv;?>"></div>
	<?if ($SITE[roundcorners]==1) print '<div  class="h_margin"></div>';?>
	<?
	$hHeightMainPic="";if (!$SITE[mainpictopmargin]=="") $hHeightMainPic="height:0px;";
	//print '<div id="topmainpic_margin_height" class="h_margin" style="margin-top:'.$SITE[mainpictopmargin].'px;'.$hHeightMainPic.';"></div>';
	?>
	
	<!--END OF: Rounded Corners -->
	<!--Here was <div class="shadow_layer">-->
	<?
	if ($SITE[mobileEnabled]) {
		if (!$SITE[mobilemainpichomepage] AND $P_DETAILS[PhotoName]) $SITE[mobilemainpichomepage]=$P_DETAILS[PhotoName];
		if (!$SITE[mobilemainpichomepage] AND $SITE[homepic]) $SITE[mobilemainpichomepage]=$SITE[homepic];
		if ($urlKey!="home") $SITE[mobilemainpichomepage]=$P_DETAILS[PhotoName];
		if ($C_STYLING['showMainGalleryMobile']=="" OR $C_STYLING['showMainGalleryMobile']=="false") print '<div class="mobile_mainpic_homepage"></div>';
		
	}
	?>
	<?if ($SITE[topheadermainfullwidth]) print '<div class="topHeaderMainFull" style="margin-top:'.$SITE[mainpictopmargin].'px">';?>
	<div class="topHeaderMain" style="<?=$SITE[topheadermainfullwidth] ? '' : 'margin-top:'.$SITE[mainpictopmargin].'px';?>">
		
	
		<?if ($SITE[siteoverlaypic] OR $SITE[pageoverlaypic]) print '<div id="site_overbg" class="site_overbg" style="display:none"></div>';?>
		
		<?if (!$SITE[topmenubottom]==1 AND $SITE[topmenubgcolor]!="-" AND $P_DETAILS[HideTopMenu]==0)  {
			print '<div style="height:8px"></div>';
			if ($inc_mobile_menu==0) SetTopMenuNew();
			}
			if (!$SITE[topmenubottom]==1) print '<div style="height:'.$SITE[topmenumargin].'px"></div>';
			?>
		
		<div class="topMainPic" align="center" id="topMainPic">
			<?
			//print "PARENT_SIDETEXT:".isParentMainPicSideTextDisabled($urlKey);
			
			//die();
			if ($SITE[globalsidetextmainpic]==0 AND ($P_DETAILS[MainPicSideText]==-1 OR $P_DETAILS[MainPicSideText]==0) OR $SITE[globalsidetextmainpic]==1 AND $P_DETAILS[MainPicSideText]==-1) $SITE[mainpiccustomwidth]="";
			if ($SITE[mainpiccustomwidth]) print '<div class="topMainPicCustom">';
			if (isSlideGallery($urlKey) AND ($inc_mobile_menu==0 OR $C_STYLING[showMainGalleryMobile]=="true")) SetGalleryPagePics($urlKey);
			else print SetPagePic($urlKey);
			if ($SITE[mainpiccustomwidth]) {
				print '</div>';
				include_once("MainPicSideText.php");
			}
			?>
			<?//if ($SITE[roundcorners]==0) print '<div  class=h_margin" style="height:4px;"></div>';?>
		</div>
		<?if ($SITE[topmenubottom]==1 AND !$SITE[topmenumargin]=="") print '<div style="height:'.$SITE[topmenumargin].'px"></div>';?>
		<?if ($SITE[topmenubottom]==1 AND $SITE[topmenubgcolor]!="-" AND $P_DETAILS[HideTopMenu]==0) {
			if ($inc_mobile_menu==0) SetTopMenuNew();
			print '<div style="height:8px;clear:both"></div>';
		}
			?>	
		<?if(file_exists('sites/'.$SITE['S3_FOLDER'].'/headerAddOns.php'))	require_once('sites/'.$SITE['S3_FOLDER'].'/headerAddOns.php');?>

	</div>
	<?if ($SITE[topheadermainfullwidth]) print '</div>';?><!-- End Top HeaderMainFull-->
	
	<?
	$middleCONTENT=GetMiddleContent($urlKey);

	$SITE[isFullResponsive]=0;
	if ($SITE[middlecontenthome]==1) $middleCONTENT=GetMiddleContent("home");
	if (!$middleCONTENT[PageContent][0]=="" OR isset($_SESSION['LOGGED_ADMIN']) OR ($SITE[searchformtop]==2 AND $urlKey=="search_results")) include_once("middlecontent.php");
	else $top_content_margin=$SITE[contenttopmargin];

	print '<a name="mainContentAnchor" id="mainContentAnchor"></a>';
	if ($SITE[maincontentfullwidth]) print '<div class="mainContentFull" style="margin-top:'.$top_content_margin.'px;">';
		else print '<div style="margin-top:'.$top_content_margin.'px;">';
		switch ($P_DETAILS[PageStyle]) {
			case 1:
				include_once("WidePageStyle.php");
				break;
			case 2:
				include_once("SeperatedPageStyle.php");
				break;
			case 4:
				include_once("WidePageStyle.php");
				break;
			default:
				include_once("SideMenuPageStyle.php");
			break;
		}
		print "</div>";
		?>

	
	</div><!--END OF: Sahdow Layer -->
<?if (isset($_SESSION['LOGGED_ADMIN']) AND $SITE[topheaderbg]!="-" AND $SITE[topmenubottom]!=2) {
	}
	else {
		?>
		<script language="javascript" type="text/javascript">
		var site_logo_width=jQuery(".topHeaderLogo").width();
		var TopMenuHeadWidth=<?=$dynamicWidth;?>-site_logo_width;
		//if (TopMenuHeadWidth<950) jQuery(".topHeaderTopMenu").width(TopMenuHeadWidth);
		</script>
	<?
		
	}
?>
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/shadowbox/shadowbox.css">
<script type="text/javascript" src="<?=$SITE[url];?>/js/shadowbox/shadowbox.js"></script>
<script language="javascript"  type="text/javascript" src="<?=$SITE[url];?>/js/swfobject/swfobject.js" async="async"></script>
<link rel="stylesheet" href="<?=$SITE[url];?>/js/gallery/fancybox/jquery.fancybox.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/jquery.smooth-scroll.min.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/jquery.ba-bbq.js"></script>
<script>

jQuery(document).ready(function() {
		if (fancyBoxFullScreen==1) {
			jQuery(".fancybox, a.photo_gallery").fancybox({openEffect :'elastic',padding:'0',margin:0,
			 afterLoad  : function () {
	            jQuery.extend(this, {
	                aspectRatio : false,
	                openMethod:'zoomIn',
	                type    : 'html',
	                width   : '100%',
	                height  : '100%',
	                autoSize:false,
	                content : '<div class="fancybox-image" style="background-image:url(' + this.href + '); background-size: contain; background-position:50% 50%;background-repeat:no-repeat;height:100%;width:100%;" /></div>'
	            });
	        }
		});
		}
		else jQuery(".fancybox, a.photo_gallery").fancybox({openEffect :'elastic',padding:'7'});
		//jQuery.scrollTo({top:'+=500px'},300);
		jQuery(".fancybox_video").fancybox({openEffect :'elastic',padding:'4',type:'iframe'});
		<?if ($SITE['isFullResponsive']==1) {
			?>
			
			var leftSideWidth=rwdSize-255;
			if (rwdSize>1350) leftSideWidth=1350-255;
	        if(rwdSize<680) leftSideWidth=rwdSize;
	        var centertSideWidth=leftSideWidth-<?=$customLeftColWidth; ?>-15;
			jQuery(".leftSide, .mainContentSeperated").width(leftSideWidth+"px"); 
			jQuery(".rightColCustom").width(centertSideWidth+"px");	
		<? 
		}
		?>
    	
   
});
 jQuery('a[href*="#"]').not('a[href*="#boxes_products"], .photoGalley_filter div a, .AdminTopMenu *, ul.boxes li a, ul#boxes li a, a[href*="Admin"], #sideCatContentTop a[class="external"], a[target="_blank"]').on('click', function() {
      if ( this.hash ) {
        jQuery.bbq.pushState( '#/' + this.hash.slice(1) );
        return false;
      }
    }).ready(function() {
      jQuery(window).bind('hashchange', function(event) {
        var tgt = location.hash.replace(/^#\/?/,'');
        if ( document.getElementById(tgt) ) {
          jQuery.smoothScroll({scrollTarget: '#' + tgt,exclude: ['a[href*="#boxes_products"','.photoGalley_filter div a']});
        }


      });
       jQuery(window).trigger('hashchange');
 });
<?
if ($SITE['isFullResponsive']==1) {
	?>
	
	jQuery(window).resize(function() {
		var leftSideWidth=rwdSize-255;
		if (rwdSize>1350) leftSideWidth=1350-255;
		if(rwdSize<680) leftSideWidth=rwdSize;
		var centertSideWidth=leftSideWidth-<?=$customLeftColWidth; ?>-15;
		jQuery(".leftSide, .mainContentSeperated").width(leftSideWidth+"px");
		jQuery(".rightColCustom").width(centertSideWidth+"px");
	});

	
	<?
}
?>
			
Shadowbox.init({
		    language:   "en",
		    viewportPadding:1,
		    autoplayMovies:true
});
var contentFontName="<?=$SITE[fontface];?>";
</script>
