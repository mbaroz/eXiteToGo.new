<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("AmazonUtil.php");
include_once("../inc/imageResizer.php");


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
  	 if ($image->getWidth()>($image->getHeight()*1.75) AND $image->getWidth()>$w) {
  	 	 $image->resizeToHeight($h);
	   	// $image->save($destIMG);
		$image->resizeToWidth($w);
//	   	 $image->save($destIMG);
	   	
  	 }
  	 else {
  	 	 if ($image->getHeight()==$image->getWidth()) {
  	 		$image->resize($w,$h);
  	 	 }
  	 	 else {
  	 	 	if ($image->getWidth()>$w AND $image->getHeight()>$h) {
  	 	 		$image->resizeToWidth($w);
	   			$image->resizeToHeight($h);
  	 	 	}
			else {//added 11/8/11
			        if ($image->getWidth()>$w OR $image->getHeight()>$h) {
  	 	 		//was opozite before 27/10/11
	   			$image->resizeToHeight($h);
				$image->resizeToWidth($w);
			    }
			}
  	 	 	
  	 	 }
  	 	 

  	 }
   	 $image->save($destIMG);
}
function SetRoundCorners($radius,$w,$h,$destIMG) {
   $newRes=$w. 'x'. $h;
   $cr=system('convert -size "'.$newRes.'" -draw "roundrectangle 0,0,'.$w.','.$h.',15,15" uploader/uploads/mask2.png',$retval);
   //$cr=system('convert '.$destIMG.' -matte uploader/uploads/mask.png -compose DstIn -composite '.$destIMG,$retval);

}

function BigPhotoConvert($img,$w,$h,$destIMG,$quality=100){
    $newRes=$w. 'x'. $h;
    $cr=system("convert $img -resize $newRes -quality $quality -strip $destIMG",$retval);
    //$tmpImg=new SimpleImage();
    //$tmpImg->load($destIMG);
    //$newWidth=$tmpImg->getWidth();
    //$newHeight=$tmpImg->getHeight();
    //SetRoundCorners(15,$newWidth,$newHeight,$destIMG);
    return $cr;
}
function SaveTumbsBGPhoto($photo_name,$galleryID) {
	global $gallery_dir;
	global $SITE_LANG;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("UPDATE galleries SET TumbsBGPic='$photo_name' WHERE GalleryID='$galleryID'");
	// copy("uploader/uploads/$photo_name","../".$gallery_dir."/sitepics/$photo_name");
	SetPhotoInStorage("","uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	
}
function SaveContentTumbsBG($photo_name,$catID) {
	global $gallery_dir;
	global $SITE_LANG;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("UPDATE categories SET ContentPicBG='$photo_name' WHERE CatID='$catID'");
	// copy("uploader/uploads/$photo_name","../".$gallery_dir."/sitepics/$photo_name");
	SetPhotoInStorage("","uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
}
function delTumbsBGPhoto($galleryID) {
	global $gallery_dir;
	global $SITE_LANG;
	global $AWS_S3_ENABLED;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT TumbsBGPic from galleries WHERE GalleryID='$galleryID'");
	$db->nextRecord();
	$galTumbsBGPIC=$db->getField("TumbsBGPic");
	if($AWS_S3_ENABLED){
		DeleteImageFromAmazon("/".$gallery_dir."/sitepics/$galTumbsBGPIC");
	}
	else{
		unlink("../".$gallery_dir."/sitepics/$galTumbsBGPIC");
	}
	$db->query("UPDATE galleries SET TumbsBGPic='' WHERE GalleryID='$galleryID'");
}
function delContentTumbsBG($catID) {
	global $gallery_dir;
	global $SITE_LANG;
	global $AWS_S3_ENABLED;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT ContentPicBG from categories WHERE CatID='$catID'");
	$db->nextRecord();
	$contentTumbsBGPIC=$db->getField("ContentPicBG");
	if($AWS_S3_ENABLED){
		DeleteImageFromAmazon("/".$gallery_dir."/sitepics/$contentTumbsBGPIC");
	}
	else{
		unlink("../".$gallery_dir."/sitepics/$contentTumbsBGPIC");
	}
	$db->query("UPDATE categories SET ContentPicBG='' WHERE CatID='$catID'");
}
function SavePhoto($photo_name,$photo_url,$photo_text,$galleryID,$p_style,$isCollage,$photoAltText) {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE;
	global $AWS_S3_ENABLED;
	$db=new Database();
	if (!$SITE[galleryphotowidth]=="") $gallery_photo_w=$SITE[galleryphotowidth];
	if (!$SITE[galleryphotoheight]=="") $gallery_photo_h=$SITE[galleryphotoheight];
	$db->query("SELECT TumbsWidth,TumbsHeight,GalleryType,GalleryOptions from galleries WHERE GalleryID='$galleryID'");
	$db->nextRecord();
	$customTumbWidth=$db->getField("TumbsWidth");
	$customTumbHeight=$db->getField("TumbsHeight");
	$galType=$db->getField("GalleryType");
	$GAL_ATTR=json_decode($db->getField("GalleryOptions"),true);
	$isCropMode=$GAL_ATTR['images_crop_mode'];
	if ($customTumbHeight>0) $gallery_photo_h=$customTumbHeight;
	if ($customTumbWidth>0) $gallery_photo_w=$customTumbWidth;
	$bigPhoto_w=1440;
	$bigPhoto_h=900;
	
	global $SITE_LANG;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	//print $gallery_dir;
	//copy("uploader/uploads/$photo_name","../".$gallery_dir."/$photo_name");
	
	$photo_text=str_replace("'","&rsquo;",$photo_text);
	$photo_text=strip_tags($photo_text);
	$photo_text=stripslashes($photo_text);
	$photo_text=str_ireplace("\n"," ",$photo_text);
	$photo_text=str_ireplace("\r"," ",$photo_text);
	$photo_url=str_ireplace($SITE[url],'',$photo_url);
	$photoAltText=strip_tags($photoAltText);
	$photoAltText=stripslashes($photoAltText);
	$PURL=parse_url($photo_url);
		if (!$photo_url=="") {
			$PIC[url]=$photo_url;
			if ($PURL[scheme]=="" AND substr($photo_url,0,1)!="/") $PIC[url]="http://".$photo_url;
			if ($photo_url=="#") $PIC[url]="#";
			$PIC[url]=urlencode($PIC[url]);
	}
	$photo_url=$PIC[url];
	$db->query("INSERT INTO photos SET GalleryID='$galleryID',FileName='$photo_name',PhotoText='$photo_text',PhotoUrl='$photo_url',PhotoAlt='$photoAltText'");
	//BigPhotoResize("uploader/uploads/$photo_name",$bigPhoto_w,$bigPhoto_h,"../".$gallery_dir."/$photo_name");
	$tmpImg=new SimpleImage();
	$tmpImg->load("uploader/uploads/$photo_name");
	if ($tmpImg->getWidth()<=$bigPhoto_w) $bigPhoto_w=$tmpImg->getWidth();
	if ($tmpImg->getHeight()<=$bigPhoto_h) $bigPhoto_h=$tmpImg->getHeight();
	if ($AWS_S3_ENABLED)  BigPhotoConvertToAmazon("uploader/uploads/$photo_name",$bigPhoto_w,$bigPhoto_h,"/".$gallery_dir."/".$photo_name,100);
	    else BigPhotoConvert("uploader/uploads/$photo_name",$bigPhoto_w,$bigPhoto_h,"../".$gallery_dir."/$photo_name",100);
	
	//TumbsResize("uploader/uploads/$photo_name",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$photo_name");
	//sleep(1);
	
	
	if ($isCollage==1 AND $galType==0) $gallery_photo_h=$tmpImg->getHeight();
	//if ($tmpImg->getWidth()>$gallery_photo_w AND $tmpImg->getHeight()>$gallery_photo_h AND $tmpImg->getWidth()<>$tmpImg->getHeight()) 
	//	BigPhotoResize("../".$gallery_dir."/$photo_name",$bigPhoto_w,$bigPhoto_h,"../$gallery_dir/$photo_name");
	if ($tmpImg->getWidth()>$gallery_photo_w OR $tmpImg->getHeight()>$gallery_photo_h)
	{
		$rtio=$tmpImg->getWidth()/$tmpImg->getHeight();
		if ($AWS_S3_ENABLED)  BigPhotoConvertToAmazon("uploader/uploads/tumb_".$photo_name,$gallery_photo_w,$gallery_photo_h,"/".$gallery_dir."/tumbs/".$photo_name,100,1,$isCropMode,$rtio);
		else BigPhotoConvert("uploader/uploads/$photo_name",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$photo_name");
		
	}
	else {
		if ($AWS_S3_ENABLED) UploadToAmazon("uploader/uploads/$photo_name","exitetogo/".$SITE['S3_FOLDER']."/$gallery_dir/tumbs/$photo_name");
		else copy("uploader/uploads/$photo_name","../$gallery_dir/tumbs/$photo_name");
	}
	// TODO: ask Moshe about this scenario...
	if ($tmpImg->getWidth()<=$bigPhoto_w AND $tmpImg->getHeight()<=$bigPhoto_h){
		if ($AWS_S3_ENABLED) 
			UploadToAmazon("uploader/uploads/$photo_name","exitetogo/".$SITE['S3_FOLDER']."/$gallery_dir/$photo_name");
		else
			copy("uploader/uploads/$photo_name","../".$gallery_dir."/$photo_name");
	}
	//unlink("uploader/uploads/$photo_name");
	print "התמונה הועלתה בהצלחה";
}
function delPhoto($photo_id) {
	global $gallery_dir;
	global $SITE_LANG;
	global $AWS_S3_ENABLED;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT * from photos WHERE PhotoID='$photo_id'");
	$db->nextRecord();
	$photo_fileName=$db->getField("FileName");
	if($AWS_S3_ENABLED){
		DeleteImageFromAmazon("/".$gallery_dir."/tumbs/".$photo_fileName);
		DeleteImageFromAmazon("/".$gallery_dir."/".$photo_fileName);
	}
	else{
		unlink("../".$gallery_dir."/".$photo_fileName);
		unlink("../".$gallery_dir."/tumbs/".$photo_fileName);
	}
	$db->query("delete from photos WHERE PhotoID='$photo_id'");

}
function UpdatePhoto($photo_name,$photo_id,$galleryID,$p_style,$isCollage) {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE;
	global $AWS_S3_ENABLED;
	global $SITE_LANG;
	$db=new Database();
	if (!$SITE[galleryphotowidth]=="") $gallery_photo_w=$SITE[galleryphotowidth];
	if (!$SITE[galleryphotoheight]=="") $gallery_photo_h=$SITE[galleryphotoheight];
	$db->query("SELECT TumbsWidth,TumbsHeight,GalleryType,GalleryOptions from galleries WHERE GalleryID='$galleryID'");
	$db->nextRecord();
	$customTumbWidth=$db->getField("TumbsWidth");
	$customTumbHeight=$db->getField("TumbsHeight");
	$galType=$db->getField("GalleryType");
	$GAL_ATTR=json_decode($db->getField("GalleryOptions"),true);
	$isCropMode=$GAL_ATTR['images_crop_mode'];
	if ($customTumbHeight>0) $gallery_photo_h=$customTumbHeight;
	if ($customTumbWidth>0) $gallery_photo_w=$customTumbWidth;
	$bigPhoto_w=1440;
	$bigPhoto_h=900;
	
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db->query("SELECT FileName from photos WHERE PhotoID='$photo_id'");
	$db->nextRecord();
	$photo_fileName=$db->getField("FileName");
	$photo_oldfileName=$photo_fileName=$db->getField("FileName");
	$photo_fileName=$photo_name;
	
	$db->query("UPDATE photos SET FileName='$photo_fileName' WHERE PhotoID='$photo_id'");
	
	//TumbsResize("uploader/uploads/$photo_name",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$photo_fileName");
	$tmpImg=new SimpleImage();
	$tmpImg->load("uploader/uploads/$photo_name");
	if ($isCollage==1 AND $galType==0) $gallery_photo_h=$tmpImg->getHeight();
	// Check if the image is thumbnanil.
    
	if ($tmpImg->getWidth()>$gallery_photo_w OR $tmpImg->getHeight()>$gallery_photo_h)
	{
		$rtio=$tmpImg->getWidth()/$tmpImg->getHeight();
		if ($AWS_S3_ENABLED) {
		   
			BigPhotoConvertToAmazon("uploader/uploads/tumb_".$photo_name,$gallery_photo_w,$gallery_photo_h,"/".$gallery_dir."/tumbs/".$photo_fileName,100,1,$isCropMode,$rtio);
		}
	    else{
	    	BigPhotoConvert("uploader/uploads/$photo_name",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$photo_fileName");
	    }
	}
	else{ 
		if ($AWS_S3_ENABLED){
			UploadToAmazon("uploader/uploads/$photo_name","exitetogo/".$SITE['S3_FOLDER']."/$gallery_dir/tumbs/$photo_fileName");
		}
		else{
			copy("uploader/uploads/$photo_name","../$gallery_dir/tumbs/$photo_fileName");
		}
	}
	//copy("uploader/uploads/$photo_name","../$gallery_dir/$photo_fileName");
	//sleep(2);
	if ($tmpImg->getWidth()>$bigPhoto_w OR $tmpImg->getHeight()>$bigPhoto_h)
	{
		if ($AWS_S3_ENABLED)
			BigPhotoConvertToAmazon("uploader/uploads/".$photo_name,$bigPhoto_w,$bigPhoto_h,"/".$gallery_dir."/".$photo_fileName,95);
	    else{
	    	BigPhotoConvert("uploader/uploads/$photo_name",$bigPhoto_w,$bigPhoto_h,"../$gallery_dir/$photo_fileName");
	    }
	}
	else{
		if ($AWS_S3_ENABLED){
			UploadToAmazon("uploader/uploads/$photo_name","exitetogo/".$SITE['S3_FOLDER']."/$gallery_dir/$photo_fileName");
		}
		else{
			copy("uploader/uploads/$photo_name","../$gallery_dir/$photo_fileName");
		}
	}
	DeleteImageFromAmazon("/".$gallery_dir."/tumbs/".$photo_oldfileName);
	DeleteImageFromAmazon("/".$gallery_dir."/".$photo_oldfileName);
	print "התמונה עודכנה בהצלחה";
}
function GenerateProdUrlKey($photo_id,$initialUrlKey,$counter=0) {
	$db=new Database();
	$NewMenuTitle=strip_tags($MenuTitle);
	$initialUrlKey=str_ireplace("?","",$initialUrlKey);
	$initialUrlKey=trim($initialUrlKey);
	$initialUrlKey=str_ireplace("  "," ",$initialUrlKey);
	$initialUrlKey=str_ireplace("   "," ",$initialUrlKey);
	$initialUrlKey=str_ireplace(".","",$initialUrlKey);
	$initialUrlKey=str_ireplace('"',"",$initialUrlKey);
	$initialUrlKey=str_ireplace("'","",$initialUrlKey);
	$initialUrlKey=str_ireplace(" - ","-",$initialUrlKey);
	$initialUrlKey=str_ireplace("- ","-",$initialUrlKey);
	$initialUrlKey=str_ireplace(" -","-",$initialUrlKey);
	$initialUrlKey=strtolower(str_ireplace(" ","-",$initialUrlKey));
	
	$initialUrlKey=str_ireplace("&","and",$initialUrlKey);
	if ($counter==0) $originalUrlKey=$initialUrlKey;
	$newInitialUrlKey=$initialUrlKey;
	$sql="SELECT ProductUrlKey from photos WHERE ProductUrlKey='$initialUrlKey' AND PhotoID!='$photo_id'";
	$db->query($sql);
	if ($db->nextRecord()) {
		$counter=$counter+1;
		$newInitialUrlKey=$originalUrlKey."-".$counter;
		GenerateProdUrlKey($photo_id,$newInitialUrlKey,$counter);
	}
	if ($newInitialUrlKey=="") $newInitialUrlKey=$originalUrlKey;
	return $newInitialUrlKey;
}
function CreateProductGal($photo_id,$newProdUrlKey,$galName="") {
	$db=new Database();
	$db->query("SELECT * from photos WHERE PhotoID='$photo_id'");
	$db->nextRecord();
	$origProdUrlKey=$db->getField("ProductUrlKey");
	if ($origProdUrlKey=="") $sql="INSERT INTO galleries SET ProductUrlKey='$newProdUrlKey',GalleryType=3,ProductGallery=1,GalleryName='$galName',GalleryTheme=1,GalleryEffect=1,GalleryHeight=400,AutoPlay=1";
	else $sql="UPDATE galleries SET ProductUrlKey='$newProdUrlKey' WHERE ProductUrlKey='$origProdUrlKey'";
	$db->query($sql);	

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
switch ($action) {
	case "rename":
		$ELID=explode("-",$editorId);
		$PIC[name]=$value;
		$photo_id=$ELID[1];
		$db=new Database();
		$db->query("UPDATE photos SET PhotoText='$PIC[name]' WHERE PhotoID='$photo_id'");
		print $PIC[name];
		
	break;
	case "rename_url":
		$NewPicUrl=trim($NewPicUrl);
		$NewPicUrl=str_ireplace($SITE[url],'',$NewPicUrl);
		$PURL=parse_url($NewPicUrl);
		if (!$NewPicUrl=="") {
			$PIC[url]=$NewPicUrl;
			if ($PURL[scheme]=="" and substr($NewPicUrl,0,1)!="/") $PIC[url]="http://".$NewPicUrl;
			if ($NewPicUrl=="#") $PIC[url]="#";
			$PIC[url]=urlencode($PIC[url]);
		}
		$newPhotoText=htmlspecialchars($newPhotoText);
		$newPhotoText=str_replace("'","&rsquo;",$newPhotoText);
		$newPhotoAltText=htmlspecialchars($photo_alt);
		$newPhotoAltText=str_replace("'","&rsquo;",$newPhotoAltText);
		$newPhotoAltText=strip_tags($newPhotoAltText);
		$newPhotoAltText=stripcslashes($newPhotoAltText);
		$newPhotoAltText=str_ireplace("\n"," ",$newPhotoAltText);
		//$PIC[text]=strip_tags($newPhotoText);
		$PIC[text]=nl2br($newPhotoText);
		$PIC[text]=stripcslashes($PIC[text]);
		//$PIC[text]=str_ireplace("\n"," ",$PIC[text]);
		$db=new Database();
		if ($isProdUrl==0 OR $isProdUrl==1) {
			if ($prodUrlKey) $fullProdUrlKey='product/'.$prodUrlKey;
			$newProdUrlKey=GenerateProdUrlKey($photo_id,$fullProdUrlKey);
			if (!trim($prodUrlKey)=="") {
				if ($isProdUrl==1) CreateProductGal($photo_id,$newProdUrlKey,$prodUrlKey);
				$db->query("UPDATE photos SET isProductLink='$isProdUrl',ProductUrlKey='$newProdUrlKey' WHERE PhotoID='$photo_id'");
				
			}
			
			
		}
		$photo_id=$photo_id;
		if($photo_id==0 AND $_POST[haveFiles]==0){
			$db->query("INSERT INTO photos SET GalleryID='$galID',PhotoUrl='$PIC[url]',PhotoText='$PIC[text]',PhotoAlt='$newPhotoAltText'");
		}
		else{
			$db->query("UPDATE photos SET PhotoUrl='$PIC[url]',PhotoText='$PIC[text]',PhotoAlt='$newPhotoAltText' WHERE PhotoID='$photo_id'");
		}
		
	break;
	case "saveLoc":
		$db=new Database();
		$PHOTO_POS=$photo_cell;
		for ($a=0;$a<count($PHOTO_POS);$a++) {
//			$PHOTO_CELL=explode("-",$PHOTO_POS[$a]);
			$photo_id=$PHOTO_POS[$a];
			$db->query("UPDATE photos SET PhotoOrder='$a' WHERE PhotoID='$photo_id'");
		}
		
		//$db->query("UPDATE photos SET PhotoUrl='$PIC[url]' WHERE PhotoID='$photo_id'");
		
	break;
	case "uploadTumbsBG":
		SaveTumbsBGPhoto($_POST[photo_name],$_POST[galleryID]);
	break;
	case "uploadContentTumbsBG":
		SaveContentTumbsBG($_POST[photo_name],$_POST[catID]);
	break;
	case "delTumbsBG":
		delTumbsBGPhoto($_POST[galleryID]);    
	break;
	case "delContentTumbsBG":
		delContentTumbsBG($_POST[catID]);    
	break;
    
	case "delPhoto":
		delPhoto($photo_id);	
	break;
	case "saveFilters":
	    if (!is_array($P_FILTERS)) $P_FILTERS=array();
	    $P_filters_str=implode("|",$P_FILTERS);
	    //P_filters_str=htmlentities($P_filters_str);
	    $db=new database();
	    $db->query("UPDATE photos SET PhotoFilters='$P_filters_str' WHERE PhotoID='$photo_id'");
	break;
	default:
	if ($photo_id==0) SavePhoto($_POST[photo_name],$_POST[photo_url],$_POST[photo_text],$_POST[galleryID],$_POST[p_style],$_POST[is_collage],$_POST[photo_alt]);
	else UpdatePhoto($_POST[photo_name],$_POST[photo_id],$_POST[galleryID],$_POST[p_style],$_POST[is_collage]);
	break;
}
?>