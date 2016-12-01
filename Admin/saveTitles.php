<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("../inc/GetServerData.inc.php");
include_once("AmazonUtil.php");
include_once("../inc/imageResizer.php");
if (!isset($_SESSION['LOGGED_ADMIN'])) die();

function GenerateUrlKey($MenuTitle,$counter=0,$CurrentMenuTitle=0) {
	if ($CurrentMenuTitle==0)  $CurrentMenuTitle=$MenuTitle;
	$counter++;
	$MenuTitle=strip_tags($MenuTitle);
	$MenuTitle=str_ireplace("?","",$MenuTitle);
	$MenuTitle=trim($MenuTitle);
	$MenuTitle=str_ireplace("  "," ",$MenuTitle);
	$MenuTitle=str_ireplace("   "," ",$MenuTitle);
	
	$MenuTitle=str_ireplace(".","",$MenuTitle);
	$MenuTitle=str_ireplace("/","",$MenuTitle);
	$MenuTitle=stripslashes($MenuTitle);
	$MenuTitle=stripcslashes($MenuTitle);
	
	$MenuTitle=str_ireplace(" - ","-",$MenuTitle);
	$MenuTitle=str_ireplace("- ","-",$MenuTitle);
	$MenuTitle=str_ireplace(" -","-",$MenuTitle);
	$SuggestedUrlKey=strtolower(str_ireplace(" ","-",$MenuTitle));
	
	$db=new Database();
	$db2=new Database();
	//$db->query("SELECT UrlKey from content WHERE UrlKey='$SuggestedUrlKey'");
	$db2->query("SELECT UrlKey from categories WHERE UrlKey='$SuggestedUrlKey' AND MenuTitle!='$CurrentMenuTitle'");
	
	if ($db2->nextRecord()) {
		$NewUrlKey=$SuggestedUrlKey."-".$counter;
		GenerateUrlKey($NewUrlKey,$counter,$CurrentMenuTitle);
	}
	else {
		$NewUrlKey=$SuggestedUrlKey;
		return strtolower($NewUrlKey);
	}
	
}
$content=$_POST['content'];
$value=$_POST['value'];
$newTitle=strip_tags($value);
$newTitle=addslashes($_POST['newTitle']);
$ELID=explode("-",$_POST['editorId']);
$objectID=intval($_POST['objectID']);

$CatID=$ELID[1];
$pathToUserFiles="http://".$bucket."/exitetogo/" . $SITE['S3_FOLDER'];
if ($AWS_S3_ENABLED) {
//	print $pathToUserFiles;
	$content=str_ireplace('src="'.$pathToUserFiles,'src="',$content);
}

$content=str_ireplace('href="'.$SITE[url],'href="',$content); //Converting local urls's to relative
$content=str_ireplace('src="'.$SITE[url],'src="',$content); //Converting local urls's to relative

switch ($_POST['type']) {
	case "cat":
		$db=new Database();
		if ($newTitle=="") $newTitle=" ";
		$sql="update categories SET CatTitle='$newTitle' WHERE CatID='$CatID'";
		$db->query($sql);
		print $newTitle;
		break;
	case "contentpics":
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$CatID' AND ObjectType='$type'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Title='$newTitle' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Title='$newTitle',ObjectID='$CatID', ObjectType='$type'";
		$db->query($sql);
		print stripslashes($newTitle);
		break;
	case "TopForm_Title":
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$CatID' AND ObjectType='$type'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Title='$newTitle' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Title='$newTitle',ObjectID='$CatID', ObjectType='$type'";
		$db->query($sql);
		print $newTitle;
		break;
	case "contentpics_text":
		
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$objectID' AND ObjectType='contentpics'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='contentpics'";
		$db->query($sql);
		break;
	case "contentpics_text_bottom":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$objectID' AND ObjectType='contentpics_bottom'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='contentpics_bottom'";
		$db->query($sql);
		break;
	case "sidecats_text":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$objectID' AND ObjectType='sidecats_text'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	case "sidecats_top_text":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$objectID' AND ObjectType='sidecats_top_text'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	case "sidecontact_text":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectType='sidecontact_text'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectType='$type'";
		$db->query($sql);
		break;
	case "mainpic_side_text":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$objectID' AND ObjectType='mainpic_side_text'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	case "left_column_text":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectType='left_column_text' AND ObjectID='$objectID'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectType='$type',ObjectID='$objectID'";
		$db->query($sql);
		break;
	case "TopForm_Content":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$objectID' AND ObjectType='TopForm_Content'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET  Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	case "BottomForm_Content":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectID='$objectID' AND ObjectType='BottomForm_Content'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	case "master_footer_text":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectType='master_footer_text' AND ObjectID='$objectID'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	case "master_header_text":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectType='master_header_text' AND ObjectID='$objectID'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	case "slideout_content_text":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectType='slideout_content_text' AND ObjectID='$objectID'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	case "master_header_text_bottommenu":
		$SC[Content]=str_ireplace("'","&lsquo;",$content);
		$db=new Database();
		$db->query("SELECT Title,TitleID from titles WHERE ObjectType='master_header_text_bottommenu' AND ObjectID='$objectID'");
		if ($db->nextRecord()) {
			$titleID=$db->getField("TitleID");
			$sql="UPDATE titles SET Content='$SC[Content]' WHERE TitleID='$titleID'";
		}
		else $sql="INSERT INTO titles SET Content='$SC[Content]' ,ObjectID='$objectID', ObjectType='$type'";
		$db->query($sql);
		break;
	default:
		break;
}
