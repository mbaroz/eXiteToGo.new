<?
include_once("../config.inc.php");
function Redir($retURL) {
	global $SITE;
	header("Location:".$retURL);
}
if (!isset($_SESSION['LOGGED_ADMIN'])) {
	header("Location:SignIn.php");
}
?>