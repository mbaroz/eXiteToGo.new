<?
session_start();
include_once("defaults.php");
if ($_GET['langID']) {
	include_once("database.php");
	$db=new Database();
	$selected_lang=$_GET['langID'];
	$db->query("SELECT * from langs WHERE LangID='$selected_lang'");
	$db->nextRecord();
	if (!isset($_SESSION['SITE_LANG'])) session_register('SITE_LANG');
	if (!session_is_registered('SITELANG')) session_register('SITELANG');
	$SITE_LANG[selected]=$db->getField("LangCode");
	$SITE_LANG[direction]=$db->getField("LangDirection");
	$SITELANG[selected]=$SITE_LANG[selected];
	$SITELANG[direction]=$SITE_LANG[direction];
	session_unregister('set_vars');
	session_unregister('ADMIN_TRANS');
	$trail_url="";
	if (!$SITE_LANG[selected]=="") $trail_url="/".$SITE_LANG[selected]."/category/home";
	header("Location:".$SITE[url].$trail_url);
}
?>