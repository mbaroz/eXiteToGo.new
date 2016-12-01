<?
$ExpireTime=360000;
header('Cache-Control: max-age=' . $ExpireTime); // must-revalidate
header('Expires: '.gmdate('D, d M Y H:i:s', time()+$ExpireTime).' GMT');
header("Content-Type:text/html; charset=utf-8");
include_once("../config.inc.php");
$db=new database();
$db->query("SELECT * from photos WHERE PhotoID='$photoID'");
$db->nextRecord();
$GalID=$db->getField("GalleryID");
$PhotoFilters=$db->getField("PhotoFilters");
$P_FILTERS_ARRAY=explode("|",$PhotoFilters);
$db->query("SELECT Filters from galleries WHERE GalleryID='$GalID'");
$db->nextRecord();
$allfilters_str=$db->getField("Filters");
$ALL_FILTERS=explode("|",$allfilters_str);
for ($a=0;$a<count($ALL_FILTERS);$a++) {
    $filterName=$ALL_FILTERS[$a];
    $filterNameEncoded=htmlspecialchars($filterName);
   	$filterNameDisplay=htmlspecialchars_decode($filterName);
    $is_checked="";
    if (in_array($filterNameDisplay,$P_FILTERS_ARRAY)) $is_checked="checked";
    ?>
    <input id="P_FILTERS" <?=$is_checked;?> name='P_FILTERS' style="margin:5px" type="checkbox" value='<?=str_replace('"','"',$filterName);?>' /><?=$filterNameDisplay;?>
    <br />
    <?
}