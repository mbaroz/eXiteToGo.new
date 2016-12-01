<?include_once("config.inc.php");?>
<?
$CHECK_CATPAGE=GetIDFromUrlKey($urlKey);
$custompage="sites/".$_SERVER['SERVER_NAME']."/".$urlKey.".php";
if ($urlKey=="sitemap") $custompage=$urlKey.".php";
if ($urlKey=="login") $custompage="login.php";
?>
<?include_once("inc/topmenu.inc.php");?>
<?include_once("header.php");?>
<?include_once("footer.inc.php");?>