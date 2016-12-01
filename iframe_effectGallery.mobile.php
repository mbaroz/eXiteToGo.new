<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
$iframe_effectGal=1;
$gID=$_GET['gID'];

$db=new Database();
$db->query("SELECT UrlKey from categories LEFT JOIN galleries ON categories.CatID=galleries.CatID WHERE galleries.GalleryID='$gID'");
$db->nextRecord();
$urlKey=$db->getField("UrlKey");
?>
<!DOCTYPE html>
<html>
<head>
	<base target="_top" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
	<script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
	<script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.9.2.custom.min.js"></script>
	<script>
	jQuery.noConflict();
        </script>
	<style>

	html, body {background:none;background-image:none;background-color:transparent;margin:0;padding:0;direction:<?=$SITE_LANG[direction];?>}
	</style>

</head>
<body> 

<div id="effectGalContainer">
	<?include_once("effect_gallery.mobile.php");?>
	
</div>
<?

?>
<script>
	jQuery(document).ready(function() {
		 var iframe_effect_gal_height=jQuery("#effectGalContainer").height();
		jQuery(".embed_effect_gallery_<?=$gID;?>",parent.document.body).height(iframe_effect_gal_height+"px");
		jQuery("#iframe_gallery",parent.document.body).height(iframe_effect_gal_height+"px");
		
	})
</script>
</body>
</html>