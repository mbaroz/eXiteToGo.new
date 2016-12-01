<?
session_start();
$urlKey=$_GET['urlKey'];
if (isset($_SESSION['SITE_LANG'])) unset($_SESSION['SITE_LANG']);
$P_ARRAY=explode("/",$PHP_SELF);
$url_req=$_SERVER['REQUEST_URI'];
$urlKeyforPos=urlencode($urlKey);
$substr_urlKey=stristr($url_req,"shop_product/");
if(!$substr_urlKey)
	$substr_urlKey=stristr($url_req,"product/");
if ($substr_urlKey) $urlKeyforPos=$substr_urlKey;
$sub_url_pos=strrpos($url_req,"/".$urlKeyforPos);
$pre_url=substr($url_req,0,($sub_url_pos));
$lang_code_request= trim(str_ireplace($P_ARRAY[1],"",$pre_url),"/");
$SITE_LANG[selected]=$lang_code_request;
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
$CHECK_PAGE=GetPageIDFromUrlKey($urlKey);
//print_r($CHECK_PAGE);die();
if ($CHECK_PAGE[Status]==404) {
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
include_once("header.php");
include_once("footer.inc.php");?>