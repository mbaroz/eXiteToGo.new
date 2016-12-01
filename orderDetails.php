<?
session_start();
if (isset($_SESSION['SITE_LANG'])) unset($_SESSION['SITE_LANG']);
$P_ARRAY=explode("/",$PHP_SELF);
$urlKey = 'orderDetails';
$url_req=$_SERVER['REQUEST_URI'];
$sub_url_pos=strrpos($url_req,"/category/".urlencode($urlKey));
$pre_url=substr($url_req,0,($sub_url_pos));
$lang_code_request= trim(str_ireplace($P_ARRAY[1],"",$pre_url),"/");
$SITE_LANG[selected]=$lang_code_request;
if(isset($_GET['lang']))
	$SITE_LANG[selected] = substr(urlencode($_GET['lang']),0,2);
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
$CHECK_CATPAGE=GetIDFromUrlKey($urlKey);
if ($CHECK_CATPAGE[Status]==404) {
	$db=new Database();
	$db->query("INSERT INTO `categories` SET `MenuTitle`='Order Details',`CategoryType`=16,`CatTitle`='פרטי ההזמנה',`UrlKey`='orderDetails',`ParentID`=7558855,ViewStatus='0'");
	$CHECK_CATPAGE=GetIDFromUrlKey($urlKey);
}
include_once("header.php");
include_once("footer.inc.php");
?>
