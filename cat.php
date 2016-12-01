<?
session_start();
$urlKey=$_GET['urlKey'];
$P_ARRAY=explode("/",$PHP_SELF);
$url_req=$_SERVER['REQUEST_URI'];
$sub_url_pos=strrpos($url_req,"/category/".urlencode($urlKey));
$pre_url=substr($url_req,0,($sub_url_pos));
$lang_code_request= trim(str_ireplace($P_ARRAY[1],"",$pre_url),"/");
if($lang_code_request == '' && isset($_GET['lang']))
	$lang_code_request= urlencode(substr($_GET['lang'],0,2));

include_once("config.inc.php");
if ($SITE_LANG['selected']=="") $SITE_LANG['selected']=$_SESSION['def_lang'];
if ($urlKey=="" OR $url_req=="/category/home") header("Location:".$SITE[url]);
include_once("inc/GetServerData.inc.php");
$CHECK_CATPAGE=GetIDFromUrlKey($urlKey);
if($urlKey == 'order-complete')
	$_SESSION['ShoppingCart'] = array();
if ($CHECK_CATPAGE[Status]==404) {
	$sUrl=$SITE[url].$url_req;
	if (GetRedirects($sUrl)) {
		$destination=GetRedirects($sUrl);
		Header("HTTP/1.1 301 Moved Permanently");
		header("Location:".$destination);
	}
	else {
		header("HTTP/1.0 404 Not Found");
		$urlKey="404";
	}
}
include_once("header.php");?>

<?include_once("footer.inc.php");?>
