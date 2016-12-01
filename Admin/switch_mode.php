<?
include_once("../config.inc.php");


$_SESSION['ref_page']=$ref_page=$_SERVER['HTTP_REFERER'];

if (isset($_SESSION['LOGGED_ADMIN'])) {
	if (!isset($_SESSION['mini_admin_mode'])) $_SESSION['mini_admin_mode']=1;
	unset($GLOBALS['LOGGED_ADMIN']);
	unset($_SESSION['LOGGED_ADMIN']);
}
elseif (isset($_SESSION['mini_admin_mode'])) {
	$_SESSION['LOGGED_ADMIN']=$LOGGED_ADMIN=$LOGGED=uniqid("A#a",25).session_id();
	unset($_SESSION['mini_admin_mode']);
	unset($GLOBALS['mini_admin_mode']);
	if ($ref_page==$SITE[url]."/pages/login" AND $ret_url) $ref_page=$SITE[url].$ret_url;
}
header("Location:".$ref_page);
?>