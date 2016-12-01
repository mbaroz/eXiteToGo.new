<?
session_unregister("LOGGED_ADMIN");
include_once("config.inc.php");
if (ieversion()<8 AND ieversion()>0) $b_ver=ieversion();
$urlKey="facebook_page";
if ($_GET['fb_page']) $urlKey=$_GET['fb_page'];
$CHECK_CATPAGE=GetIDFromUrlKey($urlKey);
$gal_type=0;
if (isEffectGalleryPage($urlKey)) $gal_type=3;
if ($CHECK_CATPAGE[CatType]==3) $gal_type=1;
$GAL=GetCatGallery($urlKey,$gal_type);
$P_DETAILS[PageStyle]=0;
include_once("defaults.php");
if (!$SITE[shortcontentbgcolor]) $SITE[shortcontentbgcolor]="ffffff";
if (!$SITE[contentbgcolor]) $SITE[contentbgcolor]="ffffff";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php?urlKey=<?=$urlKey;?>">
<style type="text/css">
body {
	background-image:none;
	background-color:#<?=$SITE[contentbgcolor];?>;
	
}
</style>
<div style="direction:<?=$SITE_LANG[direction];?>;text-align:<?=$SITE[align];?>">
<?


switch ($CHECK_CATPAGE[CatType]) {
	case 1:
		 include_once("short_content.php");
		 break;
	case 11:
		 include_once("short_content.php");
		 break;
	case 2: 
		if ($GAL[Type]==0 AND $GAL[Type]!="") include_once("gallery.php");
		if ($GAL[Type]==3 AND $GAL[Type]!="") include_once("effect_gallery.php");
		break;
	case 3:
		if ($GAL[Type]==1) include_once("videogallery.php");
		break;
	default:
		include_once("long_content.php");
		if ($custompage) include_once($custompage);
		break;
	
	}
	?>
</div>