<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("../inc/imageResizer.php");
include_once("AmazonUtil.php");
session_start();
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
function GetImgSize($img){
	$image = new SimpleImage();
  	$image->load($img);
  	$IMG[w]=$image->getWidth();
  	$IMG[h]=$image->getHeight();
  	return $IMG;
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
function SavePageOverlayPhoto($photo_name,$photo_text,$urlKey,$overlay_or_bg=0) {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE_LANG;
	global $SITE;
	global $AWS_S3_ENABLED;

	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	$IMGSIZE=GetImgSize("uploader/uploads/$photo_name");
	$H=$IMGSIZE[h];
	$db=new Database();
	if ($overlay_or_bg==0) $db->query("UPDATE categories SET OverlayPhotoName='$photo_name' ,OverlayPhotoHeight='$H' WHERE UrlKey='$urlKey'");
	else $db->query("UPDATE categories SET HeaderBGPhotoName='$photo_name'  WHERE UrlKey='$urlKey'");
	print "תמונה הועלתה בהצלחה";
}
function SavePagePhoto($photo_name,$photo_text,$urlKey,$photo_size) {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE_LANG;
	global $SITE;
	global $AWS_S3_ENABLED;
	$photo_size=strtolower($photo_size);
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	// Update the photo to the server.
	
	if (!stristr($photo_name,".swf")) {
	    $MAINPICSIZE=GetImgSize("uploader/uploads/$photo_name");
	    $main_photo_height=$MAINPICSIZE[h];
	  
	}
	if ($main_photo_height>1200) {
		?><script>toggleNotification('mainpicHeightErr');var swfu_stats = swfu.getStats();swfu_stats.successful_uploads = swfu_stats.successful_uploads - 1;
  swfu.setStats(swfu_stats);swfu.fileDialogStart(function(){toggleNotification();});</script><?
		die();
	}
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	$db=new Database();
	$photo_text=strip_tags($photo_text);
	$photo_text=stripslashes($photo_text);

	if ($urlKey=="home") {
	    $db->query("UPDATE config SET VarValue='$photo_name' WHERE VarName='SITE[homepic]'");
	    $db->query("UPDATE categories SET MainPicHeight='$main_photo_height' WHERE UrlKey='$urlKey'");
	}
	else {
		if (stristr($urlKey, "shop_product")) {
			$P_A=explode("/", $urlKey);
			$productUrlKey=end($P_A);
			$catUrlKey=$P_A[1];
			$db->query("SELECT CatID from categories WHERE UrlKey='{$catUrlKey}'");
			$db->nextRecord();
			$cID=$db->getField("CatID");
			$db->query("UPDATE products SET HeaderPhotoName='{$photo_name}' WHERE UrlKey='{$productUrlKey}' AND ParentID='{$cID}'");

		}
		else $db->query("UPDATE categories SET PhotoName='$photo_name',PhotoAltText='$photo_text',PhotoSize='$photo_text',MainPicHeight='$main_photo_height'  WHERE UrlKey='$urlKey'");
	}
	print "תמונה הועלתה בהצלחה";

	?><script>window.setTimeout('check_if_style_pics_finished()',500);</script><?
}
function SaveMainPicGalleryPhoto($photo_name,$photo_text,$urlKey,$photo_size) {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE;
	global $SITE_LANG;
	global $AWS_S3_ENABLED;
	$mainPicGalWidth=328;
	$mainPicGalHeight=100;
	$photo_size=strtolower($photo_size);
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	// Update the photo to the server.
	if($AWS_S3_ENABLED){
		UploadToAmazon("uploader/uploads/$photo_name","exitetogo/".$SITE['S3_FOLDER']."/".$gallery_dir."/sitepics/$photo_name");
		BigPhotoConvertToAmazon("uploader/uploads/tumb_".$photo_name,$mainPicGalWidth,$mainPicGalHeight,
													"/".$gallery_dir."/tumbs/".$photo_name,95,1);

	}
	else{
		copy("uploader/uploads/$photo_name","../".$gallery_dir."/sitepics/$photo_name");
		TumbsResize("uploader/uploads/$photo_name",$mainPicGalWidth,$mainPicGalHeight,"../$gallery_dir/tumbs/$photo_name");
	}
	$db=new Database();
//	$photo_text=strip_tags($photo_text);
//	$photo_text=stripslashes($photo_text);
	$db->query("SELECT galleries.GalleryID from galleries LEFT JOIN  categories ON galleries.CatID=categories.CatID WHERE galleries.GalleryType=4 AND categories.UrlKey='$urlKey'");
	if (!$db->nextRecord()) {
		$db->query("SELECT CatID from categories WHERE UrlKey='$urlKey'");
		$db->nextRecord();
		$galCatID=$db->getField("CatID");
		$db->query("INSERT INTO galleries SET GalleryName='$urlKey', GalleryType=4 , CatID='$galCatID'");
		$galID=mysql_insert_id();
	}
	else {
		$galID=$db->getField("GalleryID");
	}
	$db->query("select count(*) as numPhotos from photos");
	$db->nextRecord();
	$photoOrderLast=$db->getField("numPhotos");
	$db->query("INSERT INTO photos SET GalleryID='$galID',FileName='$photo_name',PhotoOrder='$photoOrderLast'");
//	$db->query("UPDATE categories SET PhotoName='$photo_name',PhotoAltText='$photo_text',PhotoSize='$photo_text'  WHERE UrlKey='$urlKey'");
	print "תמונה הועלתה בהצלחה";
}
/*
	Handles the gallery photos for head pic.
*/
function UpdatePhoto($photo_name,$photo_id) {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE;
	global $AWS_S3_ENABLED;
	$mainPicGalWidth=164;
	$mainPicGalHeight=50;
	
	global $SITE_LANG;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$photo_fileName=$photo_name;
	$db=new Database();
	$db->query("UPDATE photos SET FileName='{$photo_fileName}' WHERE PhotoID='$photo_id'");
	
	
	// Update the photo to the server.
	if($AWS_S3_ENABLED){
		UploadToAmazon("uploader/uploads/$photo_name","exitetogo/".$SITE['S3_FOLDER']."/".$gallery_dir."/sitepics/$photo_fileName");
		BigPhotoConvertToAmazon("uploader/uploads/tumb_".$photo_name,$mainPicGalWidth,$mainPicGalHeight,
													"/".$gallery_dir."/tumbs/".$photo_fileName,95,1);

	}
	else{
		copy("uploader/uploads/$photo_name","../".$gallery_dir."/sitepics/$photo_fileName");
		TumbsResize("uploader/uploads/$photo_name",$mainPicGalWidth,$mainPicGalHeight,"../$gallery_dir/tumbs/$photo_fileName");
	}

	// Deletes the local image before moving it to its final location.
	unlink("uploader/uploads/$photo_name");

	print "התמונה עודכנה בהצלחה";
}
function SaveLogoPhoto($photo_name,$photo_text) {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE_LANG;
	global $SITE;
	global $AWS_S3_ENABLED;

	$gallery_dir=$SITE_LANG[dir].$gallery_dir;

	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	$db=new Database();
	$photo_text=strip_tags($photo_text);
	$photo_text=stripslashes($photo_text);
	$LOGOSIZE=GetImgSize("uploader/uploads/$photo_name");
	$H=$LOGOSIZE[h];
	$W=$LOGOSIZE[w];
	if ($H>500 OR $W>900) {
		?><script>c_errors=1;toggleNotification('mainpicHeightErr');var swfu_stats = swfu.getStats();swfu_stats.successful_uploads = swfu_stats.successful_uploads - 1;
  swfu.setStats(swfu_stats);swfu.fileDialogStart(function(){toggleNotification();});</script><?
		die();
	}
	$db->query("UPDATE config SET VarValue='$photo_name' WHERE VarName='SITE[logo]'");
	$db->query("UPDATE config SET VarValue='$photo_text' WHERE VarName='SITE[logotext]'");
	
	$db->query("UPDATE config SET VarValue='$H' WHERE VarName='SITE[logoheight]'");
	$db->query("UPDATE config SET VarValue='$W' WHERE VarName='SITE[logowidth]'");
	?><script>window.setTimeout('check_if_style_pics_finished()',500);</script><?
}
function SaveSiteBgPhoto($photo_name,$photo_text="",$type="") {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE_LANG;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	switch ($type) {
		case "topmenubg":
			$var_name='SITE[topmenubgpic]';
			break;
		case "topmenuitembgpic":
			$var_name='SITE[topmenuitembgpic]';
			break;
		case "topmenuseperatoricon":
			$var_name='SITE[topmenuseperatoricon]';
			break;	
		case "topmenuselecteditembgpic":
			$var_name='SITE[topmenuselecteditembgpic]';
			break;
		
		case "titlesicon":
			$var_name='SITE[titlesicon]';
			break;
		case "likeboxbgpic":
			$var_name='SITE[fb_likebox_bg_photo]';
			break;
		
		case "submenubg":
			$var_name='SITE[submenubgphoto]';
			break;
		case "subsubmenubg":
			$var_name='SITE[subsubmenubgphoto]';
			break;
		case "submenuselectedbgimage":
			$var_name='SITE[submenuselectedbgphoto]';
			break;
		case "submenuicon":
			$var_name='SITE[submenuicon]';
			break;
		case "gallerybg":
			$var_name='SITE[gallerybgpic]';
			break;
		case "shadowpic":
			$var_name='SITE[middleshadow]';
			break;
		case "topbglayer":
			$var_name='SITE[topbglayer]';
			break;
		case "headerlogobgpic":
			$var_name='SITE[headerlogobgpic]';
			break;
		case "topbglayerpages":
			$var_name='SITE[topbglayerpages]';
			break;
		case "contentbgpic":
			$var_name='SITE[contentbgpic]';
			break;
		case "innerpagesheaderpic":
			$var_name='SITE[innerpagesheaderpic]';
			$MAINPICSIZE=GetImgSize("uploader/uploads/$photo_name");
			$main_photo_height=$MAINPICSIZE[h];
			$db->query("UPDATE config SET VarValue='$main_photo_height' WHERE VarName='SITE[innerpagesmainpicheight]'");
			break;
		case "sideformbgpic":
			$var_name='SITE[sideformbgpic]';
			break;
		case "upnavigateicon":
			$var_name='SITE[upnavigateicon]';
			break;
		case "footermasterbgpic":
			$var_name='SITE[footermasterbgpic]';
			break;
		case "searchbutton":
			$var_name='SITE[searchbutton]';
			break;
		case "searchfieldbg":
			$var_name='SITE[searchfieldbg]';
			break;
		case "mobilelogo":
			$var_name='SITE[mobilelogo]';
			break;
		case "mobileheaderbgpic":
			$var_name='SITE[mobileheaderbgpic]';
			break;
		case "mobilemainpichomepage":
			$var_name='SITE[mobilemainpichomepage]';
			break;
		case "headermasterbgpic":
			$var_name='SITE[headermasterbgpic]';
			$IMGSIZE=GetImgSize("uploader/uploads/$photo_name");
			$H=$IMGSIZE[h];
			$db->query("UPDATE config SET VarValue='$H' WHERE VarName='SITE[masterheaderheight]'");
			break;
		case "slidoutcontenticon":
			$var_name='SITE[slidoutcontenticon]';
			$IMGSIZE=GetImgSize("uploader/uploads/$photo_name");
			$slide_out_icon_size=$IMGSIZE[w]."x".$IMGSIZE[h];
			$db->query("UPDATE config SET VarValue='$slide_out_icon_size' WHERE VarName='SITE[slideouticonsize]'");
			break;
		
		case "dropdownmenubgpic":
			$var_name='SITE[dropdownmenubgpic]';
			break;
		case "submenuselectedicon":
			$var_name='SITE[submenuselectedicon]';
			break;
		case "footerbglayer":
			$var_name='SITE[footerbglayer]';
			$IMGSIZE=GetImgSize("uploader/uploads/$photo_name");
			$H=$IMGSIZE[h];
			$db->query("UPDATE config SET VarValue='$H' WHERE VarName='SITE[footerlayerbgheight]'");
			break;
		case "siteoverlaypic":
			$var_name='SITE[siteoverlaypic]';
			$IMGSIZE=GetImgSize("uploader/uploads/$photo_name");
			$H=$IMGSIZE[h];
			$db->query("UPDATE config SET VarValue='$H' WHERE VarName='SITE[siteoverlayheight]'");
			break;
		case "ThisPageContentBGPic":
			$var_name='ThisPageContentBGPic';

		break;
		default:
			$var_name='SITE[sitebgpic]';
			break;
	}
	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");


	
	$photo_text=strip_tags($photo_text);
	$photo_text=stripslashes($photo_text);
	$db->query("UPDATE config SET VarValue='$photo_name' WHERE VarName='$var_name'");
	print "Success Uploaded BG Pic";
}
function SaveFavIcon($photo_name) {
	global $gallery_dir;
	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/favicon.ico");
	$db = new Database();
	$db->query("UPDATE config SET VarValue='favicon.ico' WHERE VarName='SITE[favicon]'");
}

function SaveshopButtonImage($photo_name) {
	global $gallery_dir;
	$db = new Database();
	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	$db->query("UPDATE `config` SET `VarValue`='{$photo_name}' WHERE `VarName`='SITE[shopButtonImage]'");
}

function SaveshopButtonOrderImage($photo_name) {
	global $gallery_dir;
	$db = new Database();
	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	$db->query("UPDATE `config` SET `VarValue`='{$photo_name}' WHERE `VarName`='SITE[shopButtonOrderImage]'");
}

function SaveshopCartImage($photo_name) {
	global $gallery_dir;
	$db = new Database();
	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	$db->query("UPDATE `config` SET `VarValue`='{$photo_name}' WHERE `VarName`='SITE[shopCartImage]'");
}

function SaveshopSingleItemImageBg($photo_name) {
	global $gallery_dir;
	$db = new Database();
	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	$db->query("UPDATE `config` SET `VarValue`='{$photo_name}' WHERE `VarName`='SITE[shopSingleItemImageBg]'");
}

function saveShopImage($photo_name,$type) {
	global $gallery_dir;
	$db = new Database();
	// Update the photo to the server.
	UploadPhoto("uploader/uploads/$photo_name","../",$gallery_dir."/sitepics/$photo_name");
	$db->query("UPDATE `config` SET `VarValue`='{$photo_name}' WHERE `VarName`='SITE[{$type}]'");
}
/*
	Handles the upload process, support amazon hosting.
*/
function UploadPhoto($srcPath, $destPrefix, $destPath){
	global $SITE;
	global $AWS_S3_ENABLED;

	if($AWS_S3_ENABLED){
		UploadToAmazon($srcPath,"exitetogo/".$SITE['S3_FOLDER']."/".$destPath);
	}
	else{
		copy($srcPath,$destPrefix.$destPath);
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


function delBGPhoto($type="") {
	global $gallery_dir;
	global $SITE_LANG;
	global $SITE;
	global $theme_db_name;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	
	switch ($type) {
		case "topmenubg":
			$file_name=$SITE[topmenubgpic];
			$var_name='SITE[topmenubgpic]';
		break;
		case "topmenuitembg":
			$file_name=$SITE[topmenuitembgpic];
			$var_name='SITE[topmenuitembgpic]';
		break;
		case "topmenuselecteditembg":
			$file_name=$SITE[topmenuselecteditembgpic];
			$var_name='SITE[topmenuselecteditembgpic]';
		break;
		case "topmenuseperatoricon":
			$file_name=$SITE[topmenuseperatoricon];
			$var_name='SITE[topmenuseperatoricon]';
		break;
		case "submenubg":
			$file_name=$SITE[submenubgphoto];
			$var_name='SITE[submenubgphoto]';
		break;
		case "subsubmenubg":
			$file_name=$SITE[subsubmenubgphoto];
			$var_name='SITE[subsubmenubgphoto]';
		break;
		case "submenuselectedbgimage":
			$file_name=$SITE[submenuselectedbgphoto];
			$var_name='SITE[submenuselectedbgphoto]';
		break;
		case "deleteinnerpagesheaderpic":
			$file_name=$SITE[innerpagesheaderpic];
			$var_name='SITE[innerpagesheaderpic]';
		break;
		case "submenuicon":
			$file_name=$SITE[submenuicon];
			$var_name='SITE[submenuicon]';
		break;
		case "contentbgpic":
			$file_name=$SITE[contentbgpic];
			$var_name='SITE[contentbgpic]';
		break;
		case "gallerybg":
			$file_name=$SITE[gallerybgpic];
			$var_name='SITE[gallerybgpic]';
		break;
		case "shadowpic":
			$file_name=$SITE[middleshadow];
			$var_name='SITE[middleshadow]';
		break;
		case "topheaderbglayer":
			$file_name=$SITE[topbglayer];
			$var_name='SITE[topbglayer]';
		break;
		case "titlesicon":
			$file_name=$SITE[titlesicon];
			$var_name='SITE[titlesicon]';
		break;
		case "dellikeboxpic":
			$file_name=$SITE[fb_likebox_bg_photo];
			$var_name='SITE[fb_likebox_bg_photo]';
		break;
		case "topheaderbglayerpages":
			$file_name=$SITE[topbglayerpages];
			$var_name='SITE[topbglayerpages]';
		break;
	        case "sideformbgpic":
			$file_name=$SITE[sideformbgpic];
			$var_name='SITE[sideformbgpic]';
		break;
		case "upnavigateicon":
			$file_name=$SITE[upnavigateicon];
			$var_name='SITE[upnavigateicon]';
		break;
		case "footermasterbgpic":
			$file_name=$SITE[footermasterbgpic];
			$var_name='SITE[footermasterbgpic]';
		break;
		case "headermasterbgpic":
			$file_name=$SITE[headermasterbgpic];
			$var_name='SITE[headermasterbgpic]';
		break;
		case "searchbutton":
			$file_name=$SITE[searchbutton];
			$var_name='SITE[searchbutton]';
		break;
		case "searchfieldbg":
			$file_name=$SITE[searchfieldbg];
			$var_name='SITE[searchfieldbg]';
		break;
		case "dropdownmenubgpic":
			$file_name=$SITE[dropdownmenubgpic];
			$var_name='SITE[dropdownmenubgpic]';
		break;
		case "footerbglayer":
			$file_name=$SITE[footerbglayer];
			$var_name='SITE[footerbglayer]';
			$db->query("UPDATE config SET VarValue='' WHERE VarName='SITE[footerlayerbgheight]'");
			
		break;
		case "delshopButtonImage":
			$file_name=$SITE[shopButtonImage];
			$var_name='SITE[shopButtonImage]';
		break;
		case "delshopButtonOrderImage":
			$file_name=$SITE[shopButtonOrderImage];
			$var_name='SITE[shopButtonOrderImage]';
		break;
		case "delslidoutcontenticon":
			$file_name=$SITE[slidoutcontenticon];
			$var_name='SITE[slidoutcontenticon]';
		break;
	    
		case "shopProdButtonOrderImage":
			$file_name=$SITE[shopProdButtonOrderImage];
			$var_name='SITE[shopProdButtonOrderImage]';
		break;
		case "shopAttrsTableCartPic":
			$file_name=$SITE[shopAttrsTableCartPic];
			$var_name='SITE[shopAttrsTableCartPic]';
		break;
		case "shopFeaturedArrows":
			$file_name=$SITE[shopFeaturedArrows];
			$var_name='SITE[shopFeaturedArrows]';
		break;
		case "shopProductBgImage":
			$file_name=$SITE[shopProductBgImage];
			$var_name='SITE[shopProductBgImage]';
		break;
		case "shopSaleLabel":
			$file_name=$SITE[shopSaleLabel];
			$var_name='SITE[shopSaleLabel]';
		break;
		case "shopMoreLinkFile":
			$file_name=$SITE[shopMoreLinkFile];
			$var_name='SITE[shopMoreLinkFile]';
		break;
		case "shopProductsCartIcon":
			$file_name=$SITE[shopProductsCartIcon];
			$var_name='SITE[shopProductsCartIcon]';
		break;
		case "delshopCartImage":
			$file_name=$SITE[shopCartImage];
			$var_name='SITE[shopCartImage]';
		break;
		case "shopSingleItemImageBg":
			$file_name=$SITE[shopSingleItemImageBg];
			$var_name='SITE[shopSingleItemImageBg]';
		break;
		case "orderPhoneOrderButton":
			$file_name=$SITE[orderPhoneOrderButton];
			$var_name='SITE[orderPhoneOrderButton]';
		break;
		case "orderPaypalOrderButton":
			$file_name=$SITE[orderPaypalOrderButton];
			$var_name='SITE[orderPaypalOrderButton]';
		break;
		case "orderSubmitButton":
			$file_name=$SITE[orderSubmitButton];
			$var_name='SITE[orderSubmitButton]';
		break;
		case "orderPaypalButton":
			$file_name=$SITE[orderPaypalButton];
			$var_name='SITE[orderPaypalButton]';
		break;
		case "cartBottomImage":
			$file_name=$SITE[cartBottomImage];
			$var_name='SITE[cartBottomImage]';
		break;
		case "cartRemoveButton":
			$file_name=$SITE[cartRemoveButton];
			$var_name='SITE[cartRemoveButton]';
		break;
		case "cartCloseButton":
			$file_name=$SITE[cartCloseButton];
			$var_name='SITE[cartCloseButton]';
		break;
		case "shopCartQtyArrows":
			$file_name=$SITE[shopCartQtyArrows];
			$var_name='SITE[shopCartQtyArrows]';
		break;
		case "shopAttrsSearchButton":
			$file_name=$SITE[shopAttrsSearchButton];
			$var_name='SITE[shopAttrsSearchButton]';
		break;
		case "siteoverlaypic":
			$file_name=$SITE[siteoverlaypic];
			$var_name='SITE[siteoverlaypic]';
		break;
		case "headerlogobgpic":
			$file_name=$SITE[headerlogobgpic];
			$var_name='SITE[headerlogobgpic]';
		break;
		case "mobileheaderbgpic":
			$file_name=$SITE[mobileheaderbgpic];
			$var_name='SITE[mobileheaderbgpic]';
		break;
		case "mobilemainpichomepage":
			$file_name=$SITE[mobilemainpichomepage];
			$var_name='SITE[mobilemainpichomepage]';
		break;
		case "submenuselectedicon":
			$file_name=$SITE[submenuselectedicon];
			$var_name='SITE[submenuselectedicon]';
		break;
		case 0:
			$file_name=$SITE[sitebgpic];
			$var_name='SITE[sitebgpic]';
		break;
		default:
		break;
	}
	print $var_name;
	$db->query("UPDATE config SET VarValue='' WHERE VarName='$var_name'");
	if ($SITE[sitebgpic]) {
		if (!$theme_db_name AND !session_is_registered('theme_db_name')){
			DeletePhoto("../",$gallery_dir."/sitepics/".$file_name);
			// unlink("../".$gallery_dir."/sitepics/".$file_name);
	 }
	}

}
function delCurrentPageContentBGPic($urlKey) {
	$db=new Database();
	$db->query("SELECT CatID from categories WHERE UrlKey='$urlKey'");
	$db->nextRecord();
	$cID=$db->getField("CatID");
	$photo_name_to_del=GetCatStyle("ThisPageContentBGPic",$cID);
	// unlink("../".$gallery_dir."/sitepics/".$photo_name_to_del);
	DeletePhoto("../",$gallery_dir."/sitepics/".$photo_name_to_del);
	setCatStyeProperty($urlKey,"ThisPageContentBGPic","");

}
function delPageOverlayPic($urlKey) {
	global $gallery_dir;
	global $SITE_LANG;
	global $SITE;
	global $theme_db_name;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT OverlayPhotoName from categories WHERE UrlKey='$urlKey'");
	$db->nextRecord();
	$photo_fileName=$db->getField("OverlayPhotoName");
	$db->query("UPDATE categories SET OverlayPhotoName='' WHERE UrlKey='$urlKey'");
	if (CheckForFile("../",$gallery_dir."/sitepics/".$photo_fileName)) {
		if (!$theme_db_name AND !session_is_registered('theme_db_name')){
			DeletePhoto("../",$gallery_dir."/sitepics/".$photo_fileName);
			// unlink("../".$gallery_dir."/sitepics/".$photo_fileName);
	}
 }
}
function delPageHeaderBG($urlKey) {
	global $gallery_dir;
	global $SITE_LANG;
	global $SITE;
	global $theme_db_name;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT HeaderBGPhotoName from categories WHERE UrlKey='$urlKey'");
	$db->nextRecord();
	$photo_fileName=$db->getField("HeaderBGPhotoName");
	$db->query("UPDATE categories SET HeaderBGPhotoName='' WHERE UrlKey='$urlKey'");
	if (CheckForFile("../",$gallery_dir."/sitepics/".$photo_fileName)) {
		if (!$theme_db_name AND !session_is_registered('theme_db_name')){
			DeletePhoto("../",$gallery_dir."/sitepics/".$photo_fileName);
			// unlink("../".$gallery_dir."/sitepics/".$photo_fileName);
	}
}
}
function delSitePic($urlKey) {
	global $gallery_dir;
	global $SITE_LANG;
	global $SITE;
	global $theme_db_name;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT PhotoName from categories WHERE UrlKey='$urlKey'");
	$db->nextRecord();
	$photo_fileName=$db->getField("PhotoName");
	$db->query("UPDATE categories SET PhotoName='' WHERE UrlKey='$urlKey'");
	if ($urlKey=="home") $db->query("UPDATE config SET VarValue='' WHERE VarName='SITE[homepic]'");

	if (CheckForFile("../",$gallery_dir."/sitepics/".$photo_fileName)) {
	    	if (!$theme_db_name AND !session_is_registered('theme_db_name')){
	    		DeletePhoto("../",$gallery_dir."/sitepics/".$photo_fileName);
		}
	}
}
function SaveAltPhoto($alt_type,$photo_text,$urlKey,$photo_size) {
	$db=new Database();
	$photo_text=strip_tags($photo_text);
	$photo_text=stripslashes($photo_text);
	global $SITE;
	switch ($alt_type) {
		case "pagepic" :
			$sql="UPDATE categories SET PhotoSize='$photo_size' , PhotoAltText='$photo_text' WHERE UrlKey='$urlKey'";
		break;
		case "logo" :
			$sql="UPDATE config SET VarValue='$photo_text' WHERE VarName='SITE[logotext]'";
			if ($SITE['logo_image_name']!="") {
				$LOGO_BCK=json_decode($SITE['logo_image_name']);
				$logo_image_name=$LOGO_BCK->logoimagename;
				$logo_height=$LOGO_BCK->logoheight;
				$logo_width=$LOGO_BCK->logowidth;
				//$db->query("UPDATE config SET VarValue='{$logo_image_name}' WHERE VarName='SITE[logo]'");
				//$db->query("UPDATE config SET VarValue='$logo_height' WHERE VarName='SITE[logoheight]'");
				//$db->query("UPDATE config SET VarValue='$logo_width' WHERE VarName='SITE[logowidth]'");
			}

		break;
		default:
		break;
	}
	$db->query($sql);
}
function delSiteGalPhoto($photo_id) {
	global $gallery_dir;
	global $SITE_LANG;
	global $SITE;
	global $theme_db_name;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$db=new Database();
	$db->query("SELECT FileName from photos WHERE PhotoID='$photo_id'");
	$db->nextRecord();
	$photo_fileName=$db->getField("FileName");
	$db->query("delete from photos WHERE PhotoID='$photo_id'");

	if (CheckForFile("../",$gallery_dir."/sitepics/".$photo_fileName)) {
	    	if (!$theme_db_name AND !session_is_registered('theme_db_name')) {
	    		// unlink("../".$gallery_dir."/sitepics/".$photo_fileName);
	    		// unlink("../".$gallery_dir."/tumbs/".$photo_fileName);
	    		DeletePhoto("../",$gallery_dir."/sitepics/".$photo_fileName);
	    		DeletePhoto("../",$gallery_dir."/tumbs/".$photo_fileName);
	    	}
	}
}
function UpdatePhotosFilters($galID,$gal_filters_str) {
	$gal_filters_str=stripcslashes($gal_filters_str);
	$gal_filters_str=str_ireplace("&quot;", "##", $gal_filters_str);
    $gal_filtersARRAY=explode("|",$gal_filters_str);
    $db=new Database();
    $db2=new Database();
    $db->query("SELECT PhotoFilters,PhotoID from photos WHERE GalleryID='$galID' AND PhotoFilters!=''");
    while($db->nextRecord()) {
	    $photo_filters_str=htmlspecialchars($db->getField("PhotoFilters"));
	    $photo_filters_str=str_ireplace("&quot;", "##", $photo_filters_str);
	    $photo_id=$db->getField("PhotoID");
	    $photoFiltersARRAY=explode("|",$photo_filters_str);
	    $PHOTO_FILTERS_TO_EXCLUDE=array_diff($photoFiltersARRAY,$gal_filtersARRAY);
	    $NEW_PHOTO_FILTERS=array_diff($photoFiltersARRAY,$PHOTO_FILTERS_TO_EXCLUDE);
	    $new_photo_filters_str=implode("|",$NEW_PHOTO_FILTERS);
	    $new_photo_filters_str=str_ireplace("##", '"', $new_photo_filters_str);
	    $db2->query("UPDATE photos SET PhotoFilters='$new_photo_filters_str' WHERE PhotoID='$photo_id'");
	    
    }
}
function setCatStyeProperty($urlKey,$p,$v) {
	$db=new Database();
	$db->query("SELECT CatStylingOptions,CatID from categories WHERE UrlKey='$urlKey'");
	$db->nextRecord();
	$catID=$db->getField('CatID');
	$CURRENT_OP=json_decode($db->getField('CatStylingOptions'),true);
	$CURRENT_OP[$p]=$v;
	$c_style_store=json_encode($CURRENT_OP);
	$db->query("UPDATE categories SET CatStylingOptions='$c_style_store' WHERE CatID='$catID'");
}
$uploadtype=$_POST['uploadtype'];
switch ($uploadtype) {
	case "logo":
		SaveLogoPhoto($_POST[photo_name],$_POST[photo_text]);
	break;
	case "pagepic":
		SavePagePhoto($_POST[photo_name],$_POST[photo_text],$_POST[urlkey],$_POST[photo_size]);
		
	break;
	case "mainpicgallery":
		SaveMainPicGalleryPhoto($_POST[photo_name],$_POST[photo_text],$_POST[urlkey],$_POST[photo_size]);
	break;
	case "updateMainGalPhoto": 
		UpdatePhoto($_POST[photo_name],$_POST[photo_id]);
	break;
	case "sitebgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text]);
	break;
	case "topmenubgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"topmenubg");
	break;
	case "topmenuitembgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"topmenuitembgpic");
	break;
	case "topmenuseperatoricon":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"topmenuseperatoricon");
	break;
	case "topmenuselecteditembgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"topmenuselecteditembgpic");
	break;
	
	case "submenubgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"submenubg");
	break;
	case "submenuselectedbgimage":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"submenuselectedbgimage");
	break;
	case "subsubmenubgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"subsubmenubg");
	break;
	case "submenuicon":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"submenuicon");
	break;
	case "submenuselectedicon":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"submenuselectedicon");
	break;
	case "gallerybgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"gallerybg");
	break;
	case "shadowpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"shadowpic");
	break;
	case "topbglayer":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"topbglayer");
	break;
	case "headerlogobgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"headerlogobgpic");
	break;
	case "contentbgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"contentbgpic");
	break;
	case "topbglayerpages":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"topbglayerpages");
	break;
	case "footerbglayer":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"footerbglayer");
	break;
	case "siteoverlaypic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"siteoverlaypic");
	break;
	case "pageoverlaypic":
		SavePageOverlayPhoto($_POST[photo_name],$_POST[photo_text],$_POST[urlkey]);
	break;
	case "pageheaderbg":
		SavePageOverlayPhoto($_POST[photo_name],$_POST[photo_text],$_POST[urlkey],1);
	break;
	case "innerpagesheaderpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"innerpagesheaderpic");
	break;
	case "upnavigateicon":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"upnavigateicon");
	break;
	case "footermasterbgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"footermasterbgpic");
	break;
	case "headermasterbgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"headermasterbgpic");
	break;
	case "searchbutton":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"searchbutton");
	break;
	case "searchfieldbg":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"searchfieldbg");
	break;
    
	case "dropdownmenubgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"dropdownmenubgpic");
	break;
	case "favicon":
		SaveFavIcon($_POST[photo_name]);
	break;
	case "shopButtonImage":
		SaveshopButtonImage($_POST[photo_name]);
	break;
	case "shopButtonOrderImage":
		SaveshopButtonOrderImage($_POST[photo_name]);
	break;
	case "shopCartImage":
		SaveshopCartImage($_POST[photo_name]);
	break;
	case "shopSingleItemImageBg":
		SaveshopSingleItemImageBg($_POST[photo_name]);
	break;
	case "shopProdButtonOrderImage":
		SaveShopImage($_POST[photo_name],'shopProdButtonOrderImage');
	break;
	case "shopAttrsTableCartPic":
		SaveShopImage($_POST[photo_name],'shopAttrsTableCartPic');
	break;
	case "shopFeaturedArrows":
		SaveShopImage($_POST[photo_name],'shopFeaturedArrows');
	break;
	case "shopProductBgImage":
		SaveShopImage($_POST[photo_name],'shopProductBgImage');
	break;
	case "shopSaleLabel":
		SaveShopImage($_POST[photo_name],'shopSaleLabel');
	break;
	case "shopMoreLinkFile":
		SaveShopImage($_POST[photo_name],'shopMoreLinkFile');
	break;
	case "shopProductsCartIcon":
		SaveShopImage($_POST[photo_name],'shopProductsCartIcon');
	break;
	case "orderPhoneOrderButton":
		SaveShopImage($_POST[photo_name],'orderPhoneOrderButton');
	break;
	case "orderPaypalOrderButton":
		SaveShopImage($_POST[photo_name],'orderPaypalOrderButton');
	break;
	case "orderSubmitButton":
		SaveShopImage($_POST[photo_name],'orderSubmitButton');
	break;
	case "orderPaypalButton":
		SaveShopImage($_POST[photo_name],'orderPaypalButton');
	break;
	case "cartBottomImage":
		SaveShopImage($_POST[photo_name],'cartBottomImage');
	break;
	case "cartRemoveButton":
		SaveShopImage($_POST[photo_name],'cartRemoveButton');
	break;
	case "cartCloseButton":
		SaveShopImage($_POST[photo_name],'cartCloseButton');
	break;
	case "shopCartQtyArrows":
		SaveShopImage($_POST[photo_name],'shopCartQtyArrows');
	break;
	case "shopAttrsSearchButton":
		SaveShopImage($_POST[photo_name],'shopAttrsSearchButton');
	break;
	case "titlesicon":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"titlesicon");
	break;
	case "sideformbgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"sideformbgpic");
	break;
	case "likeboxbgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"likeboxbgpic");
	break;
	 case "slidoutcontenticon":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"slidoutcontenticon");
	break;
	case "mobilelogo":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"mobilelogo");
	break;
	case "mobileheaderbgpic":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"mobileheaderbgpic");
	break;
	case "mobilemainpichomepage":
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"mobilemainpichomepage");
	break;
	case "ThisPageContentBGPic":
		setCatStyeProperty($urlkey,'ThisPageContentBGPic',$_POST[photo_name]);
		SaveSiteBgPhoto($_POST[photo_name],$_POST[photo_text],"ThisPageContentBGPic");
	break;
	case "delBGPic":
		delBGPhoto();
	break;
	case "delGalBGPic":
		delBGPhoto("gallerybg");
	break;
	case "delTopMenuBGPic":
		delBGPhoto("topmenubg");
	break;
	case "deleteTopMenuItemBG":
		delBGPhoto("topmenuitembg");
	break;
	case "deleteTopMenuSelectedItemBG":
		delBGPhoto("topmenuselecteditembg");
	break;
	case "delSubMenuBGPic":
		delBGPhoto("submenubg");
	break;
	case "delSubSubMenuBGPic":
		delBGPhoto("subsubmenubg");
	break;
	case "deleteSubMenuSelectedBG":
		delBGPhoto("submenuselectedbgimage");
	break;
	case "delSubMenuIcon":
		delBGPhoto("submenuicon");
	break;
	case "delShadowPic":
		delBGPhoto("shadowpic");
	break;
	case "deleteTopHeaderBgPic":
		delBGPhoto("topheaderbglayer");
	break;
	case "deleteTopHeaderLogoBgPic":
		delBGPhoto("headerlogobgpic");
	break;
	case "deleteTopHeaderBgPicInside":
		delBGPhoto("topheaderbglayerpages");
	break;
	case "deleteFooterBgPic":
		delBGPhoto("footerbglayer");
	break;
	case "delSiteOverlayPic":
		delBGPhoto("siteoverlaypic");
	break;
	case "delContentBgPic":
		delBGPhoto("contentbgpic");
	break;
	case "deleteUpNavigateIcon":
		delBGPhoto("upnavigateicon");
	break;
	case "delete_footermasterbgpic":
		delBGPhoto("footermasterbgpic");
	break;
	case "delete_headermasterbgpic":
	    delBGPhoto("headermasterbgpic");
	break;
	case "delete_dropdownmenubgpic":
	    delBGPhoto("dropdownmenubgpic");
	break;
	case "deleteTopMenuSeperator":
		delBGPhoto("topmenuseperatoricon");
	break;
	
	case "delPageOverlayPic":
		delPageOverlayPic($_POST[urlkey]);
	break;
	case "deletePageHeaderBG":
		delPageHeaderBG($_POST[urlkey]);
	break;
	case "deleteTitlesIcon":
		delBGPhoto("titlesicon");
	break;
	case "del_mobilelogo":
		delBGPhoto("mobilelogo");
	break;
	case "del_mobileheaderbgpic":
		delBGPhoto("mobileheaderbgpic");
	break;
	case "del_mobilemainpichomepage":
		delBGPhoto("mobilemainpichomepage");
	break;
	case "dellikeboxpic":
		delBGPhoto("dellikeboxpic");
	break;
	case "deleteSideFormBgPic":
		delBGPhoto("sideformbgpic");
	break;
	case "deleteInnerPagesHeaderPic":
		delBGPhoto("deleteinnerpagesheaderpic");
	break;
	case "delshopButtonImage":
		delBGPhoto("delshopButtonImage");
	break;
	case "delshopButtonOrderImage":
		delBGPhoto("delshopButtonOrderImage");
	break;
	case "delshopCartImage":
		delBGPhoto("delshopCartImage");
	break;
	case "delshopSingleItemImageBg":
		delBGPhoto("shopSingleItemImageBg");
	break;
	case "delorderPhoneOrderButton":
		delBGPhoto("orderPhoneOrderButton");
	break;
	case "delorderPaypalOrderButton":
		delBGPhoto("orderPaypalOrderButton");
	break;
	case "delorderSubmitButton":
		delBGPhoto("orderSubmitButton");
	break;
	case "delorderPaypalButton":
		delBGPhoto("orderPaypalButton");
	break;
	case "delshopProdButtonOrderImage":
		delBGPhoto("shopProdButtonOrderImage");
	break;
	case "delshopAttrsTableCartPic":
		delBGPhoto("shopAttrsTableCartPic");
	break;
	case "delshopFeaturedArrows":
		delBGPhoto("shopFeaturedArrows");
	break;
	case "delshopProductBgImage":
		delBGPhoto("shopProductBgImage");
	break;
	case "delshopSaleLabel":
		delBGPhoto("shopSaleLabel");
	break;
	case "delshopMoreLinkFile":
		delBGPhoto("shopMoreLinkFile");
	break;
	case "delshopProductsCartIcon":
		delBGPhoto("shopProductsCartIcon");
	break;
	case "delcartBottomImage":
		delBGPhoto("cartBottomImage");
	break;
	case "delcartRemoveButton":
		delBGPhoto("cartRemoveButton");
	break;
	case "delcartCloseButton":
		delBGPhoto("cartCloseButton");
	break;
	case "delshopCartQtyArrows":
		delBGPhoto("shopCartQtyArrows");
	break;
	case "delshopAttrsSearchButton":
		delBGPhoto("shopAttrsSearchButton");
	break;
	case "delfavicon":
		DeletePhoto("../",$gallery_dir."/favicon.ico");
		// unlink("../".$gallery_dir."/favicon.ico");
		$db=new Database();
		$db->query("UPDATE config SET VarValue='' WHERE VarName='SITE[favicon]'");
	break;
	
	case "delSitePic":
		delSitePic($_POST[urlkey]);
	break;
	case "delSearchbutton":
		delBGPhoto("searchbutton");
	break;
	case "delSearchfieldbg":
		delBGPhoto("searchfieldbg");
	break;
	case "del_submenuselectedicon":
		delBGPhoto("submenuselectedicon");
	break;
	
	case "delslidoutcontenticon":
		delBGPhoto("delslidoutcontenticon");
	break;
	case "DELThisPageContentBGPic":
		delCurrentPageContentBGPic($urlkey);
	break;
	
	case "delMainPicGal":
		$photo_to_del=$_POST[photo_id];
		delSiteGalPhoto($photo_to_del);
	break;
	case "savePhotoAlt":
		
		SaveAltPhoto($_POST['alttype'],$_POST[photo_text],$_POST[urlkey],$_POST[photo_size]);
	break;
	case "saveLoc":
		$db=new Database();
		$PHOTO_POS=$photoGal_cell;
		for ($a=0;$a<count($PHOTO_POS);$a++) {
//			$PHOTO_CELL=explode("-",$PHOTO_POS[$a]);
			$photo_id=$PHOTO_POS[$a];
			$db->query("UPDATE photos SET PhotoOrder='$a' WHERE PhotoID='$photo_id'");
		}
		
		//$db->query("UPDATE photos SET PhotoUrl='$PIC[url]' WHERE PhotoID='$photo_id'");
		
	break;
	case "saveGalOptions" :
		$db=new Database();
		$galID=$galleryID;
		$slides_delay=($slides_delay*1000); //convert to m.s
		$slides_speed=($slides_speed*1000); //convert to m.s
		$db->query("SELECT galleries.GalleryID from galleries LEFT JOIN  categories ON galleries.CatID=categories.CatID WHERE (galleries.GalleryType=4 OR galleries.GalleryType=100) AND categories.UrlKey='$urlKey'");
		if (!$db->nextRecord()) {
			$db->query("SELECT CatID from categories WHERE UrlKey='$urlKey'");
			$db->nextRecord();
			$galCatID=$db->getField("CatID");
			$db->query("INSERT INTO galleries SET GalleryName='$urlKey', GalleryType=4 , CatID='$galCatID'");
			$galID=mysql_insert_id();
		}
		$sql="UPDATE galleries SET GalleryType=4, GalleryEffect='$gal_effect', GalleryTheme='$gal_theme', AutoPlay='$autoplay', SlideSpeed='$slides_speed',GalleryHeight='$gal_height',SlideDelay='$slides_delay',NumSlices='$num_slices'  WHERE GalleryID='$galID'";
		$db->query($sql);
	break;
	case "saveGalPageOptions" :
		$db=new Database();
		$galID=$galleryID;
		$slides_delay=($slides_delay*1000); //convert to m.s
		$slides_speed=($slides_speed*1000); //convert to m.s
		$sql="UPDATE galleries SET GalleryType=3, GalleryEffect='$gal_effect', GalleryTheme='$gal_theme', AutoPlay='$autoplay', SlideSpeed='$slides_speed',GalleryHeight='$gal_height',SlideDelay='$slides_delay',NumSlices='$num_slices',ProductGallery='$selected_product_gallery',PhotosOrder='$selected_orderBottom'  WHERE GalleryID='$galID'";
		$db->query($sql);
	break;
	case "setGalleryAttributeProperty" :
		$db=new Database();
		$db->query("SELECT GalleryOptions from galleries WHERE GalleryID='$galID'");
		$db->nextRecord();
		$CURRENT_OP=json_decode($db->getField('GalleryOptions'),true);
		$CURRENT_OP[$property_type]=$val;
		$g_style_store=json_encode($CURRENT_OP);
		$db->query("UPDATE galleries SET GalleryOptions='$g_style_store' WHERE GalleryID='$galID'");
	break;
	
	case "saveGalPhotoDetails" :
		$NewPicUrl=trim($_POST['newPhotoUrl']);
		$NewPicUrl=str_ireplace($SITE[url],'',$NewPicUrl);
		$PURL=parse_url($NewPicUrl);
		if (!$NewPicUrl=="") {
			$PIC[url]=$NewPicUrl;
			if ($PURL[scheme]=="" and substr($NewPicUrl,0,1)!="/") $PIC[url]="http://".$NewPicUrl;
			if ($NewPicUrl=="#") $PIC[url]="#";
			$newPicUrl=urlencode($PIC[url]);
		}
		$db=new Database();
		$db->query("UPDATE photos SET PhotoText='$newPhotoText',PhotoUrl='$newPicUrl', PhotoExtraEffect='$newPhotoExtraEffect' WHERE PhotoID='$photo_id'");
	break;
	case "setProductGallery":
		$db=new Database();
		if ($_POST['galleryFilters']) {
		    $gal_store_filters=htmlspecialchars($_POST['galleryFilters']);
		  UpdatePhotosFilters($galID,$gal_store_filters);
		    
		}
		if ($isDefaultOptions==1) $db->query("UPDATE galleries SET isDefaultOptions=-1 WHERE isDefaultOptions=1");
		$db->query("UPDATE galleries SET ProductGallery='$isProdGal', wmargin='$wmargin',hmargin='$hmargin',TumbsWidth='$tumbsWidth',TumbsHeight='$tumbsHeight',PhotosOrder='$orderBottom', Filters='$gal_store_filters', isDefaultOptions='$isDefaultOptions' WHERE GalleryID='$galID'");
	case "SwitchToSingle":
		$db=new Database();
		$db->query("UPDATE galleries SET GalleryType=100 WHERE GalleryID='$galleryID'");
	default:
	break;
}
$m->flushAll();
?>