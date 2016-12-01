<?
session_unset();
unset($GLOBALS['SITE']);
unset($GLOBALS['SITE_LANG']);
unset($GLOBALS['def_lang']);
unset($ADMIN_TRANS);
unset($MEMBER);
unset($AdminMode);
unset($LOGGED_ADMIN);
unset($LOGGED);
include_once("../config.inc.php");

define('ADMIN_MODE',false);
session_destroy();
header("Location:".$SITE[url]);
?>