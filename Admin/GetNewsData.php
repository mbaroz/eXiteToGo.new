<?header("Content-Type:text/html; charset=utf-8");?>
<?include_once("../config.inc.php");?>
<?include_once("../".$SITE_LANG[dir]."database.php");?>
<?include_once("../inc/GetNewsData.inc.php");?>
<?
$N=GetNewsContent($newsID);
print $N[NewsBody];
?>
