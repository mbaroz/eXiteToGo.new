<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("../inc/GetServerData.inc.php");
$SQL="UPDATE config SET ";
$db=new Database();

foreach ($_POST as $value=>$key) {
	if (!is_array($key)) continue;
	foreach ($key as $v=>$k) {
		$varName=$value."[".$v."]";
		$updateQuery="VarValue='".$k."'";
		$updateQuery=$SQL." ".$updateQuery." WHERE VarName='".$varName."'";
		$db->query($updateQuery);

	}
}
delCacheKey('siteCONFIG',$m);
?>