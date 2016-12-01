<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("../inc/GetServerData.inc.php");
$CID=GetIDFromUrlKey($urlKey);
$catID=$CID[parentID];
$newsContent=str_ireplace('href=\"'.$SITE[url],'href=\"',$newsContent); //Converting local urls's to relative
$newsContent=str_ireplace('src=\"'.$SITE[url],'src=\"',$newsContent); //Converting local urls's to relative
switch ($action) {
	case "changeScroll" :
		$db=new Database();
		$sql="UPDATE news SET ScrollType='$scroll_type' WHERE CatID='$catID'";
		if ($newsGalID>0) $sql="UPDATE news SET ScrollType='$scroll_type' WHERE GalleryID='$newsGalID'";
//		print $newsID;
		$db->query($sql);
	break;
	case "AddNewsBlock":
		$db=new Database();
		$sql="SELECT CatID from news WHERE CatID='$catID'";
		$db->query($sql);
		if (!$db->nextRecord()) $db->query("INSERT INTO news SET CatID='$catID' , NewsTitle='Good News'");
				
	break;
	case "delNews":
		$db=new Database();
		if (!$newsID==0) $sql="DELETE from news WHERE NewsID='$newsID'";
//		print $newsID;
		$db->query($sql);
	break;
	case "change_newsgal":
		//print $prodgalleryID;
		$db=new Database();
		$SetNewsCATID="888888".$prodgalleryID;
		$SetNewsGALID="999999".$prodgalleryID;
		$db->query("SELECT NewsID from news WHERE GalleryID='$SetNewsGALID'");
		if (!$db->nextRecord()) $sql="INSERT into news SET GalleryID='$prodgalleryID'";
		else $sql="update news SET GalleryID='$prodgalleryID'  WHERE GalleryID='$SetNewsGALID'";
		if ($set_type==2) $sql="update news SET GalleryID='$SetNewsGALID'  WHERE GalleryID='$prodgalleryID'";
//		print $newsID;
		$db->query($sql);
	break;
	case "change_newscat":
		$db=new Database();
		$SetNewsCATID="999999".$catID;
		$db->query("SELECT NewsID from news WHERE CatID='$SetNewsCATID'");
		if (!$db->nextRecord()) $sql="INSERT into news SET CatID='$catID'";
		else $sql="update news SET CatID='$catID'  WHERE CatID='$SetNewsCATID'";
		if ($set_type==2) $sql="update news SET CatID='$SetNewsCATID'  WHERE CatID='$catID'";
//		print $newsID;
		$db->query($sql);
	break;
	default:
		$db=new Database();
		if ($newsGalID>0) $catID="888888".$newsGalID;
		if ($newsID==0) $sql="INSERT INTO news SET NewsTitle='$newsTitle',NewsBody='$newsContent',CatID='$catID',GalleryID='$newsGalID',ScrollType='$scroll_type'";
		else $sql="UPDATE  news SET newsTitle='$newsTitle',NewsBody='$newsContent' WHERE NewsID='$newsID'";
		$db->query($sql);
//		if (!mysql_insert_id()) $db->query("UPDATE  news SET ScrollType='$scrolltype' WHERE CatID='$catID'");
	break;
	
	
}

?>