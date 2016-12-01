<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("../inc/GetServerData.inc.php");
include_once("../inc/imageResizer.php");
include_once("AmazonUtil.php");
$MESSAGE['templateSwitch']['he']="התבנית הנוכחית בעמוד שונה מהתבנית המועתקת,האם לשנות את התבנית תוכן בעמוד הנוכחי לתבנית מהעמוד המועתק ?";
$MESSAGE['templateSwitch']['en']="The Current Page template is different trom the template on the copied page. Do you want to switch the current template to the copied template?";

$MESSAGE['templateSwitchOption']['he']="החלף את התבנית בעמוד הנוכחי לתבנית מהעמוד המועתק";
$MESSAGE['templateSwitchOption']['en']="Switch the current template to the same template of the copied page";

$MESSAGE['stylePasting']['he']="העתק הגדרות עיצוב מהתבנית המועתקת";
$MESSAGE['stylePasting']['en']="Copy Styling options from the copied template";
$MESSAGE['pasteGeneral']['he']="בחר את האפשרות הרצויה:";
$MESSAGE['pasteGeneral']['en']="Please choose how would you like to paste:";
$MESSAGE['pasteConfirm']['en']="Paste";
$MESSAGE['pasteConfirm']['he']="הדבק";


if (!isset($_SESSION['LOGGED_ADMIN'])) die();

function genRandomTitle() {
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}
function CopyContentStyle($sourceCatID,$destCatID) {
      $db=new database;
      $db->query("UPDATE `categories` AS `t1`,`categories` AS `t2` SET `t1`.`Options`=`t2`.`Options`,`t1`.`ContentPhotoWidth`=`t2`.`ContentPhotoWidth`,`t1`.`ContentPhotoHeight`=`t2`.`ContentPhotoHeight`,`t1`.`ContentMarginH`=`t2`.`ContentMarginH` ,`t1`.`ContentMarginW`=`t2`.`ContentMarginW`,`t1`.`ContentBGColor`=`t2`.`ContentBGColor`,`t1`.`ContentPicBG`=`t2`.`ContentPicBG`  WHERE `t2`.`CatID`='$sourceCatID' AND `t1`.`CatID`='$destCatID'");
}
function CopyContentPhoto($pageID,$sourceArticlePhotoName) {
    global $gallery_dir;
    global $SITE_LANG;
    $gallery_dir=$SITE_LANG[dir].$gallery_dir;
    $sourceArticlePhotoEX=explode(".",$sourceArticlePhotoName);
    $destArticlePhotoName=NewGuid().".".$sourceArticlePhotoEX[1];
    // copy("../$gallery_dir/$sourceArticlePhotoName","../$gallery_dir/$destArticlePhotoName");
    // copy("../$gallery_dir/articles/$sourceArticlePhotoName","../$gallery_dir/articles/$destArticlePhotoName");
    DuplicatePhotoInStorage("../","$gallery_dir/$sourceArticlePhotoName","../","$gallery_dir/$destArticlePhotoName");
    DuplicatePhotoInStorage("../","$gallery_dir/articles/$sourceArticlePhotoName","../","$gallery_dir/articles/$destArticlePhotoName");

    $db=new database();
    $db->query("UPDATE content SET ContentPhotoName='$destArticlePhotoName' WHERE PageID='$pageID'");
}
function CopyGalleryPhotos($source_gID,$dest_gID) {
    global $gallery_dir;
    global $SITE_LANG;
    $gallery_dir=$SITE_LANG[dir].$gallery_dir;
    $db=new database();
    $db2=new database();
    $db->query("SELECT * from photos WHERE GalleryID='$source_gID'");
    while($db->nextRecord()) {
	$sourcePhotoName=$db->getField("FileName");
	$sourcePhotoID=$db->getField("PhotoID");
	$sourcePhotoEX=explode(".",$sourcePhotoName);
	$destPhotoName=NewGuid().".".$sourcePhotoEX[1];
	// if (is_file("../".$gallery_dir."/".$sourcePhotoName)) copy("../$gallery_dir/$sourcePhotoName","../$gallery_dir/$destPhotoName");
	// if (is_file("../".$gallery_dir."/tumbs/".$sourcePhotoName)) copy("../$gallery_dir/tumbs/$sourcePhotoName","../$gallery_dir/tumbs/$destPhotoName");

	if (CheckForFile("../",$gallery_dir."/".$sourcePhotoName)){
		DuplicatePhotoInStorage("../","$gallery_dir/$sourcePhotoName","../","$gallery_dir/$destPhotoName");
	}
	if (CheckForFile("../",$gallery_dir."/tumbs/".$sourcePhotoName)){
		DuplicatePhotoInStorage("../","$gallery_dir/tumbs/$sourcePhotoName","../","$gallery_dir/tumbs/$destPhotoName");
	}


	$db2->query("INSERT INTO photos (GalleryID,FileName,PhotoText,PhotoAlt,PhotoUrl,PhotoDescribtion,PhotoContent,PhotoOrder,ProductUrlKey,isProductLink,PhotoFilters)
		    SELECT '$dest_gID','$destPhotoName',PhotoText,PhotoAlt,PhotoUrl,PhotoDescribtion,PhotoContent,PhotoOrder,ProductUrlKey,isProductLink,PhotoFilters FROM photos WHERE PhotoID='$sourcePhotoID'");
    }
    
}
function CopyContent($sourceCatID,$destCatID,$cType=0,$copyStyle=0) {
    $db=new database;
    $sql="select content.* from content_cats LEFT JOIN content  ON  content_cats.PageID=content.PageID WHERE content_cats.CatID='$sourceCatID' AND content.PageTitle NOT LIKE '%footer_%' AND content.PageTitle NOT LIKE '%middle_%'  ORDER BY content.PageOrder,content.PageID DESC";
    $db->query($sql);
    $b=0;
    $P[cType]=$cType;
    while ($db->nextRecord()) {
	$P[contentTitle]=$db->getField("PageTitle");
	$P[pageContent]=$db->getField("PageContent");
	$P[shortContent]=$db->getField("ShortContent");
	$P[pageURL]=$db->getField("PageUrl");
	$P[Show]=$db->getField("ViewStatus");
	$P[parentPage]=$destCatID;
	$P[isTitleLink]=$db->getField("IsTitleLink");
	$P[isFullWidth]=$db->getField("isFullWidth");
	$P[contentOrder]=$db->getField("PageOrder");
	$P[NewPageUrlKey]=GeneratePageUrlKey("cp-".$P[contentTitle]);
	$P[copyContentAction]=1;
	$addedPageID=AddContent($P);
	if (!$db->getField("ContentPhotoName")=="" AND !$cType==0) CopyContentPhoto($addedPageID,$db->getField("ContentPhotoName")); 
	$b++;
    }
    if ($copyStyle=="true") CopyContentStyle($sourceCatID,$destCatID);
    if (!$cType==0) {
	$db->query("SELECT * from titles WHERE ObjectID='$destCatID' AND ObjectType='contentpics'");
	if ($db->nextRecord()) {
	    $db->query("UPDATE `titles` AS `t1`,`titles` AS `t2` SET `t1`.`Title`=`t2`.`Title` WHERE t2.ObjectID='$sourceCatID' AND t1.ObjectID='$destCatID' AND t1.Title='' AND t2.ObjectType='contentpics'");
	    $db->query("UPDATE `titles` AS `t1`,`titles` AS `t2` SET `t1`.`Content`=`t2`.`Content` WHERE t2.ObjectID='$sourceCatID' AND t1.ObjectID='$destCatID' AND t1.Content='' AND t2.ObjectType='contentpics' AND t1.ObjectType='contentpics'");
	}
	    else $db->query("INSERT INTO titles (Title,Content,ObjectID,ObjectType) SELECT Title,Content, '$destCatID' AS ObjectID,ObjectType from titles WHERE ObjectID='$sourceCatID' AND ObjectType='contentpics'");
	$db->query("SELECT * from titles WHERE ObjectID='$destCatID' AND ObjectType='contentpics_bottom'");
	if ($db->nextRecord()) $db->query("UPDATE `titles` AS `t1`,`titles` AS `t2` SET `t1`.`Content`=`t2`.`Content` WHERE t2.ObjectID='$sourceCatID' AND t1.ObjectID='$destCatID' AND t1.Content='' AND t2.ObjectType='contentpics_bottom' AND t1.ObjectType='contentpics_bottom'");
	    else $db->query("INSERT INTO titles (Title,Content,ObjectID,ObjectType) SELECT Title,Content, '$destCatID' AS ObjectID,ObjectType from titles WHERE ObjectID='$sourceCatID' AND ObjectType='contentpics_bottom'");
    }
    
    
}

function CopyGallery($sourceCatID,$destCatID,$cType=0,$copyStyle=0) {
    $db=new database;
    $db->query("SELECT * from galleries WHERE CatID='$sourceCatID' AND (GalleryType=3 OR GalleryType=0)");
    $db->nextRecord();
    $source_gID=$db->getField("GalleryID");
    $db->query("SELECT * from galleries WHERE CatID='$destCatID' AND (GalleryType=3 OR GalleryType=0)");
    if (!$db->nextRecord()) {
	$sql="INSERT INTO galleries (CatID,GalleryName,GalleryText,GalleryBottomText,GalleryType,GalleryEffect,GalleryTheme,SlideSpeed,SlideDelay,GalleryHeight,AutoPlay,NumSlices,ProductGallery,hmargin,wmargin,TumbsBGPic,TumbsWidth,TumbsHeight,PhotosOrder,GalleryOptions,Filters,FB_WIDGET,G_WIDGET)
		SELECT '$destCatID',GalleryName,GalleryText,GalleryBottomText,GalleryType,GalleryEffect,GalleryTheme,SlideSpeed,SlideDelay,GalleryHeight,AutoPlay,NumSlices,ProductGallery,hmargin,wmargin,TumbsBGPic,TumbsWidth,TumbsHeight,PhotosOrder,GalleryOptions,Filters,FB_WIDGET,G_WIDGET FROM galleries WHERE GalleryID='$source_gID'
	";
	 $db->query($sql);
	 $dest_gID=mysqli_insert_id($db->dbConnectionID);
    }
    else {
	$dest_gID=$db->getField("GalleryID");
	$db->query("UPDATE `galleries` AS `t1`,`galleries` AS `t2` SET `t1`.`GalleryName`=`t2`.`GalleryName` WHERE `t2`.`GalleryID`='$source_gID' AND `t1`.`GalleryID`='$dest_gID' AND `t1`.`GalleryName`=''");
	$db->query("UPDATE `galleries` AS `t1`,`galleries` AS `t2` SET `t1`.`GalleryText`=`t2`.`GalleryText` WHERE `t2`.`GalleryID`='$source_gID' AND `t1`.`GalleryID`='$dest_gID' AND `t1`.`GalleryText`=''");
	$db->query("UPDATE `galleries` AS `t1`,`galleries` AS `t2` SET `t1`.`GalleryBottomText`=`t2`.`GalleryBottomText` WHERE `t2`.`GalleryID`='$source_gID' AND `t1`.`GalleryID`='$dest_gID' AND `t1`.`GalleryBottomText`=''");
	 if ($copyStyle=="true") $db->query("UPDATE `galleries` AS `t1`,`galleries` AS `t2` SET `t1`.`GalleryEffect`=`t2`.`GalleryEffect`,`t1`.`GalleryTheme`=`t2`.`GalleryTheme`,`t1`.`SlideSpeed`=`t2`.`SlideSpeed`,`t1`.`SlideDelay`=`t2`.`SlideDelay`,`t1`.`GalleryHeight`=`t2`.`GalleryHeight`,`t1`.`AutoPlay`=`t2`.`AutoPlay`,`t1`.`NumSlices`=`t2`.`NumSlices`,`t1`.`hmargin`=`t2`.`hmargin`,`t1`.`wmargin`=`t2`.`wmargin`,`t1`.`TumbsBGPic`=`t2`.`TumbsBGPic`,`t1`.`TumbsWidth`=`t2`.`TumbsWidth`,`t1`.`TumbsHeight`=`t2`.`TumbsHeight`,`t1`.`PhotosOrder`=`t2`.`PhotosOrder`,`t1`.`GalleryOptions`=`t2`.`GalleryOptions` WHERE `t2`.`GalleryID`='$source_gID' AND `t1`.`GalleryID`='$dest_gID'");
    }
   CopyGalleryPhotos($source_gID,$dest_gID);
   //return "source:".$source_gID."! dest:".$dest_gID;
}
function GeneratePageUrlKey($MenuTitle,$counter=0) {
	if ($CurrentMenuTitle==0)  $CurrentMenuTitle=$MenuTitle;
	
	$NewMenuTitle=strip_tags($MenuTitle);
	$NewMenuTitle=str_ireplace("?","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("&","and",$NewMenuTitle);
	$NewMenuTitle=trim($NewMenuTitle);
	$NewMenuTitle=str_ireplace("  "," ",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("   "," ",$NewMenuTitle);
	//$NewMenuTitle=str_ireplace(".","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("/","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace('"',"",$NewMenuTitle);
	$NewMenuTitle=stripslashes($NewMenuTitle);
	$NewMenuTitle=stripcslashes($NewMenuTitle);
	$NewMenuTitle=str_ireplace("'","",$NewMenuTitle);
	
	$NewMenuTitle=str_ireplace(" - ","-",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("- ","-",$NewMenuTitle);
	$NewMenuTitle=str_ireplace(" -","-",$NewMenuTitle);
	$SuggestedUrlKey=strtolower(str_ireplace(" ","-",$NewMenuTitle));
	while (strlen($SuggestedUrlKey)>45) {
			$NEWURLKEYARR=explode("-", $SuggestedUrlKey);
			$NEWURLKEYARR = array_slice($NEWURLKEYARR, 0, count($NEWURLKEYARR)-1);
			$SuggestedUrlKey=implode("-", $NEWURLKEYARR);
	}
	$db=new Database();
	$db2=new Database();
	//$db->query("SELECT UrlKey from content WHERE UrlKey='$SuggestedUrlKey'");
	$db2->query("SELECT UrlKey,PageTitle from content WHERE UrlKey='$SuggestedUrlKey'");
	
	while ($db2->nextRecord()) {
		$counter++;
		$SuggestedUrlKey=$SuggestedUrlKey."-".$counter;
		$db2->query("SELECT UrlKey,PageTitle from content WHERE UrlKey='$SuggestedUrlKey'");
	}
		$NewUrlKey=$SuggestedUrlKey;
		return strtolower($NewUrlKey);
	
}
function GenerateUrlKey($MenuTitle,$counter=0) {
	if ($CurrentMenuTitle==0)  $CurrentMenuTitle=$MenuTitle;
	
	$NewMenuTitle=strip_tags($MenuTitle);
	$NewMenuTitle=str_ireplace("?","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("&","and",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("%","",$NewMenuTitle);
	$NewMenuTitle=trim($NewMenuTitle);
	$NewMenuTitle=str_ireplace("  "," ",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("   "," ",$NewMenuTitle);
	$NewMenuTitle=str_ireplace(".","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("/","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace('"',"",$NewMenuTitle);
	$NewMenuTitle=stripslashes($NewMenuTitle);
	$NewMenuTitle=stripcslashes($NewMenuTitle);
	$NewMenuTitle=str_ireplace("'","",$NewMenuTitle);
	
	$NewMenuTitle=str_ireplace(" - ","-",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("- ","-",$NewMenuTitle);
	$NewMenuTitle=str_ireplace(" -","-",$NewMenuTitle);
	$SuggestedUrlKey=strtolower(str_ireplace(" ","-",$NewMenuTitle));
	while (strlen($SuggestedUrlKey)>45) {
			$NEWURLKEYARR=explode("-", $SuggestedUrlKey);
			$NEWURLKEYARR = array_slice($NEWURLKEYARR, 0, count($NEWURLKEYARR)-1);
			$SuggestedUrlKey=implode("-", $NEWURLKEYARR);
	}
	$db=new Database();
	$db2=new Database();
	//$db->query("SELECT UrlKey from content WHERE UrlKey='$SuggestedUrlKey'");
	$db2->query("SELECT UrlKey,MenuTitle from categories WHERE UrlKey='$SuggestedUrlKey'");
	
	while ($db2->nextRecord()) {
		$counter++;
		$SuggestedUrlKey=$SuggestedUrlKey."-".$counter;
		$db2->query("SELECT UrlKey,MenuTitle from categories WHERE UrlKey='$SuggestedUrlKey'");
	}
		$NewUrlKey=$SuggestedUrlKey;
		return strtolower($NewUrlKey);
	
}
function NewGuid() { 
    $s = strtoupper(md5(uniqid(rand(),true))); 
    $guidText = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 
    return $guidText;
}
function wrapEnglish($in) {
    $in_ar=explode(" ",strip_tags($in));
    $en=preg_replace('/[^a-zA-Z]/','',$in_ar);
    $en=array_filter($en);
    foreach($en as $en_val) {
	$en_val='<span class="english">'.$en_val.'</span>';
	$new_en[]=$en_val;
    }
    
    $new_str=str_ireplace($en,$new_en,$in);
   return $new_str;
   
    
}
function TumbsResize($img,$w,$h,$destIMG){
	 $image = new SimpleImage();
  	 $image->load($img);
  	 if ($image->getWidth()>($image->getHeight()*1.75)) {
  	 	 $image->resizeToHeight($h);
	   	// $image->save($destIMG);
		$image->resizeToWidth($w);
//	   	 $image->save($destIMG);

	   	
  	 }
  	 else {
		 if ($image->getHeight()*1.75>($image->getWidth())) {
  	 		$image->resizeToWidth($w);
	   		$image->resizeToHeight($h);
  	 	 }
  	 	 else $image->resize($w,$h);
  	 }
   	 $image->save($destIMG);
	
  	 $newImage= new SimpleImage();
  	 $newImage->load($destIMG);
  	 $inc=0;
  	  if ($newImage->getWidth()>($w)) {
  		 $newImage->load($img);
//  	 	$newImage->resizeToWidth($w-5);
  	 	 $newImage->resizeToHeight($h);
   	 	  $newImage->resizeToWidth($w);

//  	 	// $newImage->save($destIMG);
//  	 	 $inc++;
  	 }
  	 $newImage->save($destIMG);
  	  $newImage->load($destIMG);
  	 if ($newImage->getHeight()>($h)) {
 		$newImage->load($img);
  	 	$newImage->resizeToHeight($h);
//  	 	
  	}
	$newImage->save($destIMG);
}
function BigPhotoResize($img,$w,$h,$destIMG){
	 $image = new SimpleImage();
  	 $image->load($img);
  	 $OrigH=$image->getHeight();
  	 $OrigW=$image->getWidth();
  	
  	 if ($w>($h*1.5)) {
  	 	if ($OrigH>$h)  {
  	 	$image->resizeToHeight($h);
	   	$image->save($destIMG);
  	 	}
  	 	if ($OrigW>$w) {
  	 	$image->resizeToWidth($w);
	   	$image->save($destIMG);
  	 	}
	   	
  	 }
  	 else {
  	 	if ($OrigW>$w) {
  	 	 $image->resizeToWidth($w);
	   	 $image->save($destIMG);
  	 	}
		if ($OrigH>$h)  {
	   	 $image->resizeToHeight($h);
	   	 $image->save($destIMG);
		}

  	 }

}

function BigPhotoConvert($img,$w,$h,$destIMG){
    $newRes=$w. 'x'. $h;
    $cr=system("convert $img -resize $newRes -quality 100 -strip $destIMG",$retval);
    return $cr;
	    
}
function SavePhoto($photo_name,$itemID,$catID=0,$photo_alt_text='') {
	global $gallery_dir;
	global $SITE_LANG;
	global $ADMIN_TRANS;
	global $gallery_photo_w;
	global $gallery_photo_h;
	global $SITE;
	global $IS_PHOTO_PENDING;
	global $AWS_S3_ENABLED;

	if (!$SITE[galleryphotowidth]=="") $gallery_photo_w=$SITE[galleryphotowidth];
	if (!$SITE[galleryphotoheight]=="") $gallery_photo_h=$SITE[galleryphotoheight];
	$bigPhoto_w=1440;
	$bigPhoto_h=900;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT ContentPhotoWidth,ContentPhotoHeight,Options,CategoryType from categories WHERE CatID='$catID'");
	$db->nextRecord();
	$CONTENT_OPTIONS=json_decode($db->getField('Options'));
	$customPhotoWidth=$db->getField('ContentPhotoWidth');
	$customPhotoHeight=$db->getField('ContentPhotoHeight');
	$isCropMode=$CONTENT_OPTIONS->images_crop_mode;
	$c_type=$db->getField('CategoryType');
	if ($customPhotoWidth>0) $gallery_photo_w=$customPhotoWidth;
	if ($customPhotoHeight>0) $gallery_photo_h=$customPhotoHeight;
	
	if ($itemID==0) {
	    $P[NewPageUrlKey]=genRandomTitle();
	    if ($P[contentTitle]=="") 
	    $P[cType]=$c_type;
	    $P[parentPage]=$catID;
	    $itemID=AddContent($P);
	    if (!isset($_SESSION['IS_PHOTO_PENDING'])) $_SESSION['IS_PHOTO_PENDING']=1;
	    $IS_PHOTO_PENDING[ContentNewPageID]=$itemID;
	}
	$db->query("SELECT ContentPhotoName from content WHERE PageID='$itemID'");
	$db->nextRecord();
	$currentPhotoName=$oldPhotoName=$db->getField('ContentPhotoName');
	$currentPhotoName=$photo_name;
	$db->query("UPDATE content SET ContentPhotoName='$currentPhotoName' WHERE PageID='$itemID'");
	$tmpImg=new SimpleImage();
	$tmpImg->load("uploader/uploads/$photo_name");
	if ($tmpImg->getWidth()<=$bigPhoto_w) $bigPhoto_w=$tmpImg->getWidth();
	if ($tmpImg->getHeight()<=$bigPhoto_h) $bigPhoto_h=$tmpImg->getHeight();
	BigPhotoConvert("uploader/uploads/$photo_name",$bigPhoto_w,$bigPhoto_h,"../$gallery_dir/$currentPhotoName");
	
	if (($CONTENT_OPTIONS->DynamicHeight==1 OR $CONTENT_OPTIONS->DynamicHeight=="") AND ($tmpImg->getHeight()>$gallery_photo_h AND $c_type==21)) $gallery_photo_h=$tmpImg->getHeight(); 
	if ($tmpImg->getWidth()>$gallery_photo_w OR $tmpImg->getHeight()>$gallery_photo_h)
	{
		$rtio=$tmpImg->getWidth()/$tmpImg->getHeight();
		if($AWS_S3_ENABLED){
			BigPhotoConvertToAmazon("uploader/uploads/tumb_".$photo_name,$gallery_photo_w,$gallery_photo_h,"/$gallery_dir/articles/$currentPhotoName",100,1,$isCropMode,$rtio);
		}
		else{
			BigPhotoConvert("uploader/uploads/$photo_name",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/articles/$currentPhotoName");
		}
	}
	else{
		SetPhotoInStorage("","uploader/uploads/$photo_name","../","$gallery_dir/articles/$currentPhotoName");
	}
	if ($tmpImg->getWidth()>$bigPhoto_w OR $tmpImg->getHeight()>$bigPhoto_h){
		BigPhotoConvertToAmazon("uploader/uploads/$photo_name",$bigPhoto_w,$bigPhoto_h,"/$gallery_dir/$currentPhotoName");
		// copy("uploader/uploads/$photo_name","../".$gallery_dir."/$currentPhotoName");

		
	}
	else SetPhotoInStorage("","uploader/uploads/$photo_name","../","$gallery_dir/$currentPhotoName");
	DeletePhoto("../",$gallery_dir."/articles/".$oldPhotoName);
	DeletePhoto("../",$gallery_dir."/".$oldPhotoName);
}
function delPhoto($photo_id) {
	global $gallery_dir;
	global $SITE_LANG;
	global $AWS_S3_ENABLED;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT * from content WHERE PageID='$photo_id'");
	$db->nextRecord();
	$photo_fileName=$db->getField("ContentPhotoName");
	$db->query("update content SET ContentPhotoName=''  WHERE PageID='$photo_id'");

	DeletePhoto("../",$gallery_dir."/articles/".$photo_fileName);
	DeletePhoto("../",$gallery_dir."/".$photo_fileName);
}

//TODO:
$is_title_exists=0;
if ($IS_PHOTO_PENDING[ContentNewPageID]) {
    $pageID=$IS_PHOTO_PENDING[ContentNewPageID];
    $is_title_exists=1;
    unset ($GLOBALS['IS_PHOTO_PENDING']);
}
//if ($SITE_LANG[selected]=="he") $content=wrapEnglish($content);
$pathToUserFiles="http://".$bucket."/exitetogo/" . $SITE['S3_FOLDER'];

if ($AWS_S3_ENABLED) {
	$content=str_ireplace('src="'.$pathToUserFiles,'src="',$content);
	$content=str_ireplace('href="'.$pathToUserFiles,'href="',$content);
}
$content=$_POST['content'];
$parentCat=$_POST['parentCat'];
$titleLink=$_POST['titleLink'];
$newCatLink=urldecode($_POST['newCatLink']);
$pageUrlKey=$_POST['pageUrlKey'];
$pageURL=$_POST['pageURL'];
$contentType=$_POST['contentType'];
$pageID=$_POST['pageID'];
$action=$_POST['action'];
if (!$_POST['action'] AND $_GET['action']) $action=$_GET['action'];
$viewStatus=$_POST['viewStatus'];
$orderCat=$_POST['orderCat'];
$mobileView=$_POST['mobileView'];
$catPageID=$_POST['catPageID'];
$catParentID=$_POST['catParentID'];
$newCatName=urldecode($_POST['newCatName']);
$richTextPopup=$_POST['richTextPopup'];
$pageStyle=$_GET['pageStyle'];
$update_catID=$_GET['update_catID'];
if ($_POST['cType']) $cType=$_POST['cType'];
if ($_GET['cType']) $cType=$_GET['cType'];
$content=str_ireplace('href="'.$SITE[url],'href="',$content); //Converting local urls's to relative
$content=str_ireplace('src="'.$SITE[url],'src="',$content); //Converting local source url's to relative

$P[pageContent]=str_ireplace("'","&lsquo;",$content);
$P[contentTitle]=str_ireplace("'","&lsquo;",$_POST['pagetitle']);
$P[contentTitle]=str_ireplace('"',"&quot;",$P[contentTitle]);

$G[GalleryContent]=str_ireplace("'","&lsquo;",$content);
$P[pageURL]=$P[pageURL];
$P[contentOrder]=$pageOrder;
$P[Show]=intval($_POST['PShow']);
$P[homePage]=$PHome+0;
$P[parentPage]=$parentCat;
$P[isTitleLink]=$titleLink;
$C[categoryName]=$newCatName;
$C[orderCat]=isset($_POST['orderCat']) ? 1 : 0;
$CC=parse_url($newCatLink);
if (!$newCatLink=="") {
	$newCatLink=str_ireplace($SITE[url],'',$newCatLink);
	$C[categoryLink]=$newCatLink;
	if ($CC[scheme]=="" AND  substr($newCatLink,0,1)!="/") $C[categoryLink]="http://".$newCatLink;
	$C[categoryLink]=urlencode($C[categoryLink]);
}
$PP=parse_url($pageURL);
if (!$pageURL=="") {
	$P[pageURL]=$pageURL;
	if ($PP[scheme]=="" AND  substr($pageURL,0,1)!="/") $P[pageURL]="http://".$pageURL;
	$P[pageURL]=str_ireplace($SITE[url],"",$P[pageURL]);
	$P[pageURL]=urlencode($P[pageURL]);
	
}

$C[catParentID]=$catParentID;
$G[catParentID]=$catParentID;
$G[GalleryName]=$newGalleryName;
$G[GalleryType]=$gallery_type;
$I[ItemTitle]=$newItemName;
$I[catParentID]=$catParentID;

if ($P[contentTitle]=="" AND $pageUrlKey=="") $P[NewPageUrlKey]=genRandomTitle();
else $P[NewPageUrlKey]=GeneratePageUrlKey(htmlspecialchars_decode($P[contentTitle]));
if ($P[contentTitle]=="footer") $P[NewPageUrlKey]="footer";

function setDefaultOptions($cType,$catID,$resetDefaults=0) {
	$db=new Database();
	$db2=new Database();
	$db->query("SELECT * from categories WHERE Options='' AND ContentPhotoWidth=0 AND ContentPhotoHeight=0 AND ContentMarginH=0 AND ContentMarginW=0 AND ContentBGColor='' AND Options='' AND CatID='$catID'");
	$db2->query("SELECT * from categories WHERE isDefaultOptions=1");
	if ($db2->nextRecord() AND ($db->nextRecord() OR $resetDefaults==1)) { //We found that there is default option choosed
		$updatedContentPhotoW=$db2->getField('ContentPhotoWidth');
		$updatedContentPhotoH=$db2->getField('ContentPhotoHeight');
		$updatedContentMarginW=$db2->getField('ContentMarginW');
		$updatedContentMarginH=$db2->getField('ContentMarginH');
		$updatedContentBGColor=$db2->getField('ContentBGColor');
		$updatedContentPicBG=$db2->getField('ContentPicBG');
		$updatedOptions=$db2->getField('Options');
		$db->query("UPDATE categories SET ContentPhotoWidth='$updatedContentPhotoW',ContentPhotoHeight='$updatedContentPhotoH',ContentMarginW='$updatedContentMarginW',ContentMarginH='$updatedContentMarginH', ContentBGColor='$updatedContentBGColor', ContentPicBG='$updatedContentPicBG',Options='$updatedOptions' WHERE catID='$catID'");
	}
}

/*
	Handles the upload process, support amazon hosting.
*/
function SetPhotoInStorage($srcPrefix, $srcPath, $destPrefix, $destPath){
	global $SITE;
	global $AWS_S3_ENABLED;

	if($AWS_S3_ENABLED){
		UploadToAmazon($srcPath,"exitetogo/".$SITE['S3_FOLDER']."/".$destPath);
	}
	else{
		copy($srcPrefix.$srcPath,$destPrefix.$destPath);
	}
}

/*
	Duplicate photo in its storage.
*/
function DuplicatePhotoInStorage($srcPrefix, $srcPath, $destPrefix, $destPath){
	global $SITE;
	global $AWS_S3_ENABLED;
	global $bucket;

	if($AWS_S3_ENABLED){
		CopyPhotoInAmazon("exitetogo/".$SITE['S3_FOLDER']."/".$srcPath,"exitetogo/".$SITE['S3_FOLDER']."/".$destPath);
	}
	else{
		copy($srcPrefix.$srcPath,$destPrefix.$destPath);
	}
}
/*
	Handles the delete process for images, supports amazon hosting.
*/
function DeletePhoto($destPrefix, $destPath){
	global $SITE;
	global $AWS_S3_ENABLED;

	if($AWS_S3_ENABLED){
		DeleteImageFromAmazon("/".$destPath);
	}
	else{
		unlink($destPrefix.$destPath);
	}
}

switch ($action) {
	case "delPage":
	DeleteContent($pageID);
	break;
	case "saveLoc":
	$db=new Database();
	$sql="update content SET HomePage='$P[homePage]',PageOrder='$P[contentOrder]',ParentID='$P[parentPage]' WHERE PageID='$pageID'";
	$db->query($sql);
	break;
	case "saveMeta":

	$db=new Database();
	$db->connect();
	$pageMT=mysqli_real_escape_string($db->dbConnectionID,$_GET['pageMT']);
	$pageTT=mysqli_real_escape_string($db->dbConnectionID,$_GET['pageTT']);
	$pageDESC=mysqli_real_escape_string($db->dbConnectionID,$_GET['pageDESC']);
	$pageKY=mysqli_real_escape_string($db->dbConnectionID,$_GET['pageKY']);
	$catParent=$_GET['catParent'];
	$isSE_BLOCKED=$_GET['isSE_BLOCKED'];
	if(@$_POST['isShop'] == 1)
	{
		$sql="update products SET TagTitle='$pageTT', PageKeywords='$pageKY',PageDescribtion='$pageDESC' WHERE ProductID='$pageID'";
	}
	else
	{
		if ($catParent>0) $sql="update categories SET TagTitle='$pageTT', PageKeywords='$pageKY',PageDescribtion='$pageDESC',MetaTags='$pageMT', SEBlock='$isSE_BLOCKED' WHERE CatID='$catParent'";
		else $sql="update content SET TagTitle='$pageTT', PageKeywords='$pageKY',PageDescribtion='$pageDESC',MetaTags='$pageMT', SEBlock='$isSE_BLOCKED' WHERE PageID='$pageID'";

	}

	$db->query($sql);

	    $site_add_on_code=($_POST['siteAddOnCode'] ? $_POST['siteAddOnCode'] : $_GET['siteAddOnCode']);
	    if (!$siteAddOnCode=="") $db->query("UPDATE config SET VarValue='$site_add_on_code' WHERE VarName='SITE[addon_code]'");
	
	break;
	case "saveCat":
		$C[NewCatUrlKey]=GenerateUrlKey($C[categoryName]);
		$C[ViewStatus]=$viewStatus;
		$C[isSecured]=$securedCat;
		$C[mobileView]=$mobileView;
		$C[richTextPopup]=$richTextPopup;
		if (!$C[categoryName]=="") {
			print AddNewCat($C);
			
		}
		$m->flushAll();
	break;
	case "saveGallery":
		AddNewGallery($G);
		
	break;
	case "saveItem":
		AddNewItem($I);
	break;
	case "renameGallery":
		$ELID=explode("-",$editorId);
		$gal_id=$ELID[1];	
		$db=new Database();
		$G[GalleryName]=addslashes($value);
		$db->query("UPDATE galleries SET GalleryName='$G[GalleryName]' WHERE GalleryID='$gal_id'");
		print stripslashes($G[GalleryName]);
		
	break;
	case "renameItem":
		$ELID=explode("-",$editorId);
		$item_id=$ELID[1];
		
		$I[ItemTitle]=$value;
		$db=new Database();
		$db->query("UPDATE items SET ItemTitle='$I[ItemTitle]' WHERE ItemID='$item_id'");
		print $I[ItemTitle];
		
	break;
	case "delGal":
		$db=new Database();
		$db->query("DELETE from galleries WHERE GalleryID='$gallery_id'");
		$db->query("SELECT FileName from photos WHERE GalleryID='$gallery_id'");
		$gallery_dir=$SITE_LANG[dir].$gallery_dir;
		global $AWS_S3_ENABLED;
		while ($db->nextRecord()) {
		    $photo_fileName=$db->getField("FileName");

		 //    if($AWS_S3_ENABLED){
			// 	// TODO: Test on server.
			// 	DeleteImageFromAmazon("/".$gallery_dir."/".$photo_fileName);
			// 	DeleteImageFromAmazon("/".$gallery_dir."/tumbs/".$photo_fileName);
			// }
			// else{
			// 	unlink("../".$gallery_dir."/".$photo_fileName);
			//     unlink("../".$gallery_dir."/tumbs/".$photo_fileName);
			// }
		    DeletePhoto("../",$gallery_dir."/".$photo_fileName);
		    DeletePhoto("../",$gallery_dir."/tumbs/".$photo_fileName);
		}
		$db->query("DELETE from photos WHERE GalleryID='$gallery_id'");
	break;
	case "delItem":
		$db=new Database();
		$db->query("DELETE from items WHERE ItemID='$item_id'");
		
	break;
	case "delCat":
		$haveChildren=0;
		$cID=$_POST['cID'];
		$db=new Database();
		$db->query("SELECT UrlKey from categories WHERE CatID='$cID'");
		$db->nextRecord();
		$del_urlKey=$db->getField("UrlKey");
		$db->query("SELECT CatID from categories WHERE ParentID='$cID'");
		if ($db->nextRecord()) $haveChildren=1;
		$db->query("SELECT ParentID from products WHERE ParentID='$cID'");
		if ($db->nextRecord()) $haveChildren=1;
		
		if (($del_urlKey!="home" OR $del_urlKey!="צרו-קשר" OR $del_urlKey!="contact-us" OR !$haveChildren) AND $haveChildren==0) $del_results=DelCat($cID);
		if (!$del_results) print "FALSE";
		else print "OK";
		$m->flushAll();

	break;
	case "savePopUpRichText":
		$richText=$_POST['content'];
		$db=new Database();
		$db->query("UPDATE categories SET MenuRichText='{$richText}' WHERE CatID='$catID'");
	break;
	case "rename":

		if (!$C[categoryName]=="") {
			$newUrlKey=$_POST['newUrlKey'];
			//$C[NewCatUrlKey]=GenerateUrlKey($C[categoryName]);
			$C[PageID]=$catPageID;
			$C[ViewStatus]=$viewStatus;
			$C[isSecured]=$securedCat;
			$C[mobileView]=$mobileView;
			$C[richTextPopup]=$richTextPopup;
			$db=new Database();
			$db->query("SELECT UrlKey from categories WHERE CatID='$catPageID'");
			$db->nextRecord();
			$current_UrlKey=$db->getField("UrlKey");
			$haveNewCatUrlKey=0;
			if ($newUrlKey==$current_UrlKey OR $newUrlKey=="") $C[NewCatUrlKey]=$current_UrlKey;
			else {
				$haveNewCatUrlKey=1;
				$C[NewCatUrlKey]=GenerateUrlKey($newUrlKey);
			}

			if ($current_UrlKey=="home") $C[NewCatUrlKey]="home";
			//if ($current_UrlKey=="צרו-קשר" AND ($C[NewCatUrlKey]!="צרו-קשר" AND $C[NewCatUrlKey]!="contact-us")) $C[NewCatUrlKey]="צרו-קשר";
			//if ($current_UrlKey=="contact-us" AND ($C[NewCatUrlKey]!="צרו-קשר" AND $C[NewCatUrlKey]!="contact-us")) $C[NewCatUrlKey]="contact-us";
			
			$newCatNameRecieved=EditCat($C);

			if ($haveNewCatUrlKey==1) {
			    $newFULLCATURL=$SITE[url]."/category/".urlencode($C[NewCatUrlKey]);
			    $oldFULLCATURL=$SITE[url]."/category/".urlencode($current_UrlKey);
			    $db->query("INSERT INTO redirects SET Source='$oldFULLCATURL', Destination='$newFULLCATURL'");
			}
			print $haveNewCatUrlKey;
			$m->flushAll();
			
		}
	break;
	case "resetDefaultOptions":
		setDefaultOptions($cType,$update_catID,1);
		break;
	case "change_ctype":
		$db=new Database();	
		$additional = '';

		if($cType == 14)
		{
			$db->query("SELECT * FROM `categories` WHERE `CatID`='{$update_catID}'");
			$db->nextRecord();
			$cat = $db->record;
			if($cat['shopOptions'] == '')
				$additional = ",`shopOptions`='".json_encode(array('roundedCorners' => $SITE['roundcorners']))."'";
		}
		$sql="update categories SET CategoryType='$cType'{$additional} WHERE CatID='$update_catID'";
		$db->query($sql);
		if ($cType==12 OR $cType==21 OR $cType==11 OR $cType==1) setDefaultOptions($cType,$update_catID);
		$checkGaltype=0;
		if ($cType==3) $checkGaltype=1;
		$default_gal_effect=0;
		$default_gal_height=0;
		if ($SITE[defaulteffect]!="") $default_gal_effect=$SITE[defaulteffect];
		if ($SITE[effectgallerydefaultheight]!="") $default_gal_height=$SITE[effectgallerydefaultheight];
		//if ($subType==3) $checkGaltype=3;	
		$db->query("SELECT CatID,GalleryID from galleries WHERE CatID='$update_catID' AND GalleryType='$checkGaltype'");
		if (!$db->nextRecord() AND ($cType==2 OR $cType==3)) {
		    $db->query("INSERT INTO galleries SET CatID='$update_catID', GalleryType='$checkGaltype',GalleryEffect='$default_gal_effect', GalleryHeight='$default_gal_height' ,GalleryName='',SlideSpeed='1000'");
		    $newGalIDInserted=mysqli_insert_id($db->dbConnectionID);
		    $db->query("UPDATE `galleries` AS `t1`,`galleries` AS `t2` SET `t1`.`GalleryOptions`=`t2`.`GalleryOptions`,`t1`.`Filters`=`t2`.`Filters`,`t1`.`TumbsWidth`=`t2`.`TumbsWidth`,`t1`.`TumbsHeight`=`t2`.`TumbsHeight` ,`t1`.`wmargin`=`t2`.`wmargin`,`t1`.`hmargin`=`t2`.`hmargin`,`t1`.`PhotosOrder`=`t2`.`PhotosOrder`  WHERE `t2`.`isDefaultOptions`=1 AND t1.GalleryID='$newGalIDInserted'");
		}
		if ($cType==2) {
			$db->query("SELECT CatID,GalleryID,GalleryEffect,GalleryHeight from galleries WHERE CatID='$update_catID' AND (GalleryType=0 OR GalleryType=3)");
			if ($db->nextRecord()) {
				if ($db->getField("GalleryHeight")>0) $default_gal_height=$db->getField("GalleryHeight");
				$gal_updateID=$db->getField("GalleryID");
				print $gal_updateID;
				$db->query("UPDATE galleries SET GalleryType='$subType',GalleryHeight='$default_gal_height' WHERE GalleryID='$gal_updateID'");
			}
			if ($subType==3) {
				$db->query("UPDATE galleries SET GalleryEffect=7 WHERE CatID='$update_catID' AND GalleryType=4 AND GalleryEffect<4");
			}
		}
		
	break;
	case "change_pagestyle":
		$db=new Database();
		$sql="update categories SET PageStyle='$pageStyle' WHERE CatID='$update_catID'";
		$db->query($sql);
		
	break;
	
	case "renameSlogen":
	$newSlogen=$P[pageContent];
	$db=new Database();
	$sql="update config SET VarValue='$newSlogen' WHERE VarName='SITE[slogen]'";
	$db->query($sql);
//	print $newSlogen;
	break;
	
	case "sortCat":
		$db=new Database();
		$CAT_POS=$_POST['cat_item'];
		for ($a=0;$a<count($CAT_POS);$a++) {
			$cat_id=$CAT_POS[$a];
			$db->query("UPDATE categories SET PageOrder='$a' WHERE CatID='$cat_id'");
		}
	break;
	case "sortNews":
		$db=new Database();
		$NEWS_POS=$_POST['news_item'];
		for ($a=0;$a<count($NEWS_POS);$a++) {
			$news_id=$NEWS_POS[$a];
			$db->query("UPDATE news SET NewsOrder='$a' WHERE NewsID='$news_id'");
		}
	break;
	case "saveContentLoc":
		$db=new Database();
		$CONTENT_POS=$_POST['short_cell'];
		for ($a=0;$a<count($CONTENT_POS);$a++) {
			$page_id=$CONTENT_POS[$a];
			$db->query("UPDATE content SET PageOrder='$a' WHERE PageID='$page_id'");
		}
	break;
	case "sortContent":
		$db=new Database();
		parse_str($_POST['contentSort']); 
		  for ($i = 0; $i < count($contentContainer); $i++) { 
		$update_pageID=$contentContainer[$i]; 
		$sql="update content SET PageOrder='$i' WHERE PageID='$update_pageID'";
		$db->query($sql);
		}
	break;
	case "savePageContent":
		$P[contentType]=1;
		EditPageContent($P,$pageID);
		$post_key=base64_encode($parentCat);
		delCacheKey('multiContent',$m,$post_key);
	break;
	case "saveMiddleContent":

		$P[contentType]=1;
		$P[contentTitle]="middle_".$pageID;
		
		if (!$pageID OR $pageID==0) AddContent($P);
			else EditContent($P,$pageID);
		$post_key=base64_encode($_POST['parentCat'].'middle');
		delCacheKey('multiContent',$m,$post_key);

	break;
	case "saveGalleryContent":
		$db=new Database();
		switch ($divplace) {
			case "bottom":
			$sql="update galleries SET GalleryBottomText='$G[GalleryContent]' WHERE GalleryID='$galID'";
			break;
			case "side":
			$sql="update galleries SET GallerySideText='$G[GalleryContent]' WHERE GalleryID='$galID'";
			break;
			case "middle":
			$sql="update galleries SET GalleryBottomPicsText='$G[GalleryContent]' WHERE GalleryID='$galID'";
			break;
			default:
			$sql="update galleries SET GalleryText='$G[GalleryContent]' WHERE GalleryID='$galID'";
			break;
		}
		
		$db->query($sql);
	break;
	case "uploadPhoto":
		SavePhoto($photo_name,$itemID,$catID,$photo_alt_text);
	break;
	case "setContentPhotoEnlarge" :
		
		$db=new Database();
		print $enableEnlarge;
		$db->query("UPDATE content SET EnableEnlarge='$enableEnlarge' WHERE PageID='$pageID'");
	break;
	case 'updateBriefPhotoAlt' :
		$itemID=$_GET['itemID'];
	        $db=new Database();
		$alt_text=strip_tags($_GET['alt_text']);
		$alt_text=urldecode($alt_text);
		$db->query("UPDATE content SET ContentPhotoAlt='$alt_text' WHERE PageID='$itemID'");
	break;
	case "delPhoto":
		delPhoto($photo_id);
	break;
	case "setMiddleContentInherit":
		$db=new Database();
		$db->query("UPDATE config SET VarValue='$isInherit' WHERE VarName='SITE[middlecontenthome]'");
	break;
	case "setMainPicSideText":
		$db=new Database();
		$db->query("UPDATE categories SET MainPicSideText='$isInherit' WHERE CatID='$catID'");
	break;
	case "setTopMenuHidden":
		$db=new Database();
		$db->query("UPDATE categories SET HideTopMenu='$isHidden' WHERE CatID='$catID'");
	break;
	case "setMobileHomePage":
		$MobileHomeUrlKey="";
		$db=new Database();
		if ($isMobileHome==1) {
		    $db->query("SELECT UrlKey from categories WHERE CatID='$catID'");
		    $db->nextRecord();
		    $MobileHomeUrlKey=$db->getField("UrlKey");
		}
		if ($MobileHomeUrlKey!="home") $db->query("UPDATE config SET VarValue='$MobileHomeUrlKey' WHERE VarName='SITE[MobileHomePage]'");
		
	break;
	case "setSideContactForm":
		$db=new Database();
		$db->query("UPDATE categories SET ShowContactForm='$isChecked' WHERE UrlKey='$cat_urlKey'");
	break;
	case "changeFBWidget":
		
		$widgetType=$_POST['widgetType'];
		$fb_is_page=$_POST['fb_is_page'];
		$is_fb_product=$_POST['is_fb_product'];
		$update_catID=$_POST['update_catID'];
		$db=new Database();

		if ($fb_is_page==0) $db->query("UPDATE categories SET FB_WIDGET='$widgetType' WHERE CatID='$update_catID'");
		else {
			if ($is_fb_product) $db->query("UPDATE galleries SET FB_WIDGET='$widgetType' WHERE GalleryID='$update_catID'");
			else $db->query("UPDATE content SET FB_WIDGET='$widgetType' WHERE PageID='$update_catID'");
		}
		
	break;
	case "changeGWidget":
		$widgetType=$_POST['widgetType'];
		$fb_is_page=$_POST['fb_is_page'];
		$is_fb_product=$_POST['is_fb_product'];
		$update_catID=$_POST['update_catID'];
		$db=new Database();
		if ($fb_is_page==0) $db->query("UPDATE categories SET G_WIDGET='$widgetType' WHERE CatID='$update_catID'");
		else {
			if ($is_fb_product) $db->query("UPDATE galleries SET G_WIDGET='$widgetType' WHERE GalleryID='$update_catID'");
			else $db->query("UPDATE content SET G_WIDGET='$widgetType' WHERE PageID='$update_catID'");
		}
		
	break;
	case "enlargeFullLine": 
		$db=new Database();
		$db->query("UPDATE content SET isFullWidth='$full' WHERE PageID='$pageID'");

	break;
	case "saveContentOptions":
		$C_OPTIONS=array("ContentBorderColor"=>$borderColor,"ContentMinHeight"=>$content_min_height,"ContentRoundCorners"=>$content_rounded_corners,"ContentPicBGColor"=>$content_photo_bg_color,"ContentTextBGColor"=>$content_text_bg_color,"ContentTextColor"=>$content_text_color,"TitlesColor"=>$titles_color,"NumBriefsShow"=>$num_briefs_show,"CollageEasing"=>$collage_easing,"EasingSpeed"=>$easing_speed,"DynamicHeight"=>$is_dynamic_height,"FullLineBriefWidth"=>$full_line_width,"PhotosBorderColor"=>$photos_border_color,"isTitlesAbove"=>$is_titles_above,"ShowPinterestButton"=>$show_pinterest_button,"images_crop_mode"=>$images_crop_mode,"number_columns"=>$_POST['num_columns']);
		$c_options_store=json_encode($C_OPTIONS);
		$db=new Database();
		if ($isDefaultOptions==1) $db->query("UPDATE categories SET isDefaultOptions=-1 WHERE isDefaultOptions=1");
		$db->query("UPDATE categories SET ContentPhotoWidth='$pWidth',ContentPhotoHeight='$pHeight',ContentMarginW='$wMargin',ContentMarginH='$hMargin', ContentBGColor='$content_bg_color', isDefaultOptions='$isDefaultOptions',Options='$c_options_store' WHERE catID='$catID'");
	break;
	case "setCatStyleProperty":
		$catID=$_POST['catID'];
		$db=new Database();
		$db->query("SELECT CatStylingOptions from categories WHERE catID='$catID'");
		$db->nextRecord();
		$CURRENT_OP=json_decode($db->getField('CatStylingOptions'),true);
		$CURRENT_OP[$_POST['property_type']]=$_POST['val'];
		$c_style_store=json_encode($CURRENT_OP);
		$db->query("UPDATE categories SET CatStylingOptions='$c_style_store' WHERE catID='$catID'");
	break;
	case "changeCatLocation":
		$srcCatID=$_GET['sourceCatID'];
		$dstCatID=$_GET['destinationCatID'];
		if ($srcCatID==$dstCatID) die();
		$db=new Database();
		$db->query("UPDATE categories SET ParentID='$dstCatID' WHERE CatID='$srcCatID'");
		$db->query("SELECT CatID,MenuTitle,UrlKey from categories WHERE CatID='$srcCatID'");
		$db->nextRecord();
		$sourceCatName=$db->getField("MenuTitle");
		$db->query("SELECT CatID,MenuTitle,UrlKey from categories WHERE CatID='$dstCatID'");
		$db->nextRecord();
		$destinationCatName=$db->getField("MenuTitle");
		if ($dstCatID==0) $destinationCatName=$ADMIN_TRANS['top menu'];
		print $ADMIN_TRANS['the category']." ".$sourceCatName." ".$ADMIN_TRANS['moved to']." ".$destinationCatName;
	    break;
	case "cancelCopy":
	    unset($_SESSION['cp_catID']);
	    unset($_SESSION['cp_catType']);
	    $JS_A=array("statuscode"=>-2,"message"=>"");
	    print json_encode($JS_A);
	    break;
	case "copyPage":
	    if ($_GET['currentCatID']) {
		$_SESSION['cp_catID']=$_GET['currentCatID'];
		$db=new database();
		$db->query("SELECT CategoryType FROM categories WHERE CatID='{$_SESSION['cp_catID']}'");
		if ($db->nextRecord()) $_SESSION['cp_catType']=$db->getField("CategoryType");
	    }
	    
	    $JS_A=array("statuscode"=>0,"message"=>"");
	    print json_encode($JS_A);
	    break;
	case "pastePage" :
	    $db=new database;
	    if (isset($_SESSION['cp_catID']) AND $_GET['currentCatID']!=$_SESSION['cp_catID']) {
		$db->query("SELECT * from categories WHERE CatID='{$_SESSION['cp_catID']}'");
		$db->nextRecord();$cp_CatType=$db->getField("CategoryType");
		$db->query("SELECT * from categories WHERE CatID='{$_GET['currentCatID']}'");
		$db->nextRecord();$current_CatType=$db->getField("CategoryType");
		if ($current_CatType!=$cp_CatType) $msg_notificatication=$MESSAGE['templateSwitch'][$SITE_LANG[selected]];
		else $msg_notificatication="<b>".$MESSAGE['pasteGeneral'][$SITE_LANG[selected]]."</b>";
		$msg_notificatication.='<br><br>';
		if ($current_CatType!=$cp_CatType) $msg_notificatication.='<div class="pasteActionsChooser"><input type="checkbox" id="switchTemplate"><label for="switchTemplate"><span class="labelText">'.$MESSAGE['templateSwitchOption'][$SITE_LANG[selected]].'</span></label></div><br>';
		$msg_notificatication.='<div class="pasteActionsChooser"><input type="checkbox" id="pasteStylingCheckbox" checked><label for="pasteStylingCheckbox"><span class="labelText">'.$MESSAGE['stylePasting'][$SITE_LANG[selected]].'</span></label></div>
		';
		$msg_notificatication.='<br>
		    <div style="width:200px;margin:40px auto 20px auto">
			<div id="newSaveIcon" class="greenSave" style="float:right" onclick="confirmPaste(1)">'.$MESSAGE['pasteConfirm'][$SITE_LANG[selected]].'</div>
			<div id="newSaveIcon" style="float:left" onclick="confirmPaste(0)">'.$ADMIN_TRANS['cancel'].'</div>
		    </div>
		    ';
		
		$JS_A=array("statuscode"=>2,"message"=>$msg_notificatication);
		print json_encode($JS_A);
		
	    }
	    
	    break;
	    case "pastePageConfirmed":
		
			if(isset($_SESSION['cp_catID']) AND $_GET['currentCatID']!=$_SESSION['cp_catID']) {
			    $msg_notificatication='<div class="successCopiedContent">';
			    $db=new database();
			    $db->query("SELECT * from categories WHERE CatID='{$_SESSION['cp_catID']}'");
			    $db->nextRecord();$cp_CatType=$db->getField("CategoryType");
			    
			    if ($cp_CatType==0 OR $cp_CatType==1 OR $cp_CatType==11 OR $cp_CatType==21 OR $cp_CatType==12) {
					$msg_notificatication.="העמוד הועתק בהצלחה";
				
					CopyContent($_SESSION['cp_catID'],$_GET['currentCatID'],$cp_CatType,$_GET['stylePaste']);
			    }
			    if ($cp_CatType==2) {
					$msg_notificatication.="הגלרייה הועתקה בהצלחה";
					CopyGallery($_SESSION['cp_catID'],$_GET['currentCatID'],$cp_CatType,$_GET['stylePaste']);
			    }
			    $msg_notificatication.="</div><script>window.location.reload();</script>";
			    if ($_GET['switchTemplate']=="true")
			    	$db->query("UPDATE categories SET CategoryType='$cp_CatType' WHERE CatID='{$_GET['currentCatID']}'");
			    $JS_A=array("statuscode"=>4,"message"=>$msg_notificatication);
			    print json_encode($JS_A);
			}
			unset($_SESSION['cp_catID']);
			unset($_SESSION['cp_catType']);
	    break;
	default:
	$P[cType]=$contentType;
	if (!$pageID) AddContent($P);
	else {
		$db=new Database();
		$db->query("SELECT UrlKey,PageTitle from content WHERE PageID='$pageID'");
		$db->nextRecord();
		$current_UrlKey=$db->getField("UrlKey");
		$current_PageTitle=$db->getField("PageTitle");
		//$haveNewCatUrlKey=0;
		if ($pageUrlKey=="" AND $P[contentTitle]=="") $pageUrlKey=genRandomTitle();
		$check_title=stripcslashes($P[contentTitle]);
		
		if ($pageUrlKey==$current_UrlKey OR $pageUrlKey=="") $P[NewPageUrlKey]=$current_UrlKey;
		else $P[NewPageUrlKey]=GeneratePageUrlKey($pageUrlKey);
		if ($is_title_exists==1 AND $P[contentTitle]) $P[NewPageUrlKey]=GeneratePageUrlKey($P[contentTitle]);
		EditContent($P,$pageID);
		$post_key=base64_encode($_POST['parentCat']);
		delCacheKey('multiContent',$m,$post_key);
	}
	break;
}

$m->flushAll();
?>