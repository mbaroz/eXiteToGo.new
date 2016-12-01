<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
switch ($action) {
    case "saveRichText":
        $content=str_ireplace('href=\"'.$SITE[url],'href=\"',$content); //Converting local urls's to relative
        $content=str_ireplace("'","&lsquo;",$content);
        $db=new Database();
        $db->query("UPDATE photos SET PhotoContent='$content' WHERE PhotoID='$photoID'");
        break;
     default:
        $db=new Database();
        $db->query("SELECT PhotoContent from photos WHERE PhotoID='$photoID'");
        $db->nextRecord();
        $photoRichText=$db->getField("PhotoContent");
        print $photoRichText;
        break;
}

?>