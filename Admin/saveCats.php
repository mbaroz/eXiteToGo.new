<?header("Content-Type:text/html; charset=utf-8");?>
<?include_once("../config.inc.php");?>
<?include_once("../inc/GetServerData.inc.php");?>
<?
$db=new Database();
if (count($CAT_SELECTED)>0) $db->query("DELETE from content_cats WHERE PageID='$pageID'");
for ($a=0;$a<count($CAT_SELECTED);$a++) {
	$c_id= $CAT_SELECTED[$a];
	$sql="INSERT INTO  content_cats SET CatID='$c_id' , PageID='$pageID'";
	$db->query($sql);
}