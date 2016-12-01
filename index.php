<?include_once("config.inc.php");?>
<?
$url_req=$_SERVER['REQUEST_URI'];
if (stristr($url_req,"index.php")) {
	$sUrl=$SITE[url].$url_req;
	if (GetRedirects($sUrl)) {
		$destination=GetRedirects($sUrl);
		Header("HTTP/1.1 301 Moved Permanently");
		header("Location:".$destination);
	}
}
	
?>
<?include_once("inc/topmenu.inc.php");?>
<?include_once("home.php");?>
<?include_once("header.php");?>
<?include_once("footer.inc.php");?>