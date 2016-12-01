<?
include_once("../../config.inc.php");
include_once("../../database.php");
$db=new database();
function validateRegForm($data,$db) {
	$e=$data['etg_email'];
	$db->query("SELECT Email from global_users WHERE Email='{$e}'");
	if ($data['etg_email'] AND $data['etg_pass'] and $data['etg_FullName']) return false;
	if (!$db->nextRecord()) return true;

	return false;
}
function register($data,$db) {
	$e=$data['etg_email'];
	$securePass=sha1($data['etg_pass']);
	$name=$data['etg_FullName'];
	$db->query("INSERT INTO global_users SET FullName='{$name}', Passwd='{$securePass}', Email='{$e}'");
}
if (validateRegForm($_GET,$db)) {
	register($_GET,$db);
	print "OK";
}
else print "ff";
?>