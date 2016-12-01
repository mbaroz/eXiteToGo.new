<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("../inc/imageResizer.php");
session_start();
if (!session_is_registered('uploaded_video_id')) session_register('uploaded_video_id');
if (!session_is_registered('lastuploadtype')) session_register('lastuploadtype');
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
function BigPhotoConvert($img,$w,$h,$destIMG){
    $newRes=$w. 'x'. $h;
    $cr=system("convert $img -resize $newRes -quality 100 $destIMG",$retval);
    return $cr;
	    
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
		 $image->resizeToWidth($w);
	   	 //$image->save($destIMG);
	   	 $image->resizeToHeight($h);
  	 }
   	 $image->save($destIMG);
	
  	 $newImage= new SimpleImage();
  	 $newImage->load($destIMG);
  	 $inc=0;
  	  if ($newImage->getWidth()>($w-2)) {
  		 $newImage->load($img);
//  	 	$newImage->resizeToWidth($w-5);
  	 	 $newImage->resizeToHeight($h);
   	 	  $newImage->resizeToWidth($w-2);

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
$pageID=$_POST['pageID'];
function UploadToAmazon($s,$d) {
    global $s3;
    global $bucket;
    if($s3->putObjectFile($s, $bucket, $d, S3::ACL_PUBLIC_READ))
    	print "ok: ".$s;
}
function SaveVideo($video_name,$video_url,$video_text,$galleryID,$video_id) {
	global $gallery_dir;
	global $video_gallery_dir;
	global  $uploaded_video_id;
	global $SITE_LANG;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$video_gallery_dir=$SITE_LANG[dir].$video_gallery_dir;
//	print $video_filename;
	copy("uploader/uploads/$video_name","../".$video_gallery_dir."/$video_name");
	$db=new Database();
	$video_text=strip_tags($video_text);
	$video_text=stripslashes($video_text);
	$video_text=str_ireplace("\n"," ",$video_text);
	$video_text=str_ireplace("\r"," ",$video_text);
	$video_url=strip_tags($video_url);
	$video_url=trim($video_url);
	$new_photo_url=str_ireplace("watch?v=","embed/",$video_url);
	$new_photo_url=str_ireplace("www.vimeo.com","vimeo.com",$video_url);
	if (!stristr($new_photo_url,"player.vimeo.com")) $new_photo_url=str_ireplace("vimeo.com","player.vimeo.com/video",$new_photo_url);
	
	$sql="INSERT INTO videos SET GalleryID='$galleryID',VideoText='$video_text',VideoUrl='$new_photo_url',VideoFileName='$video_name'";
	if (!$uploaded_video_id=="") $sql="UPDATE videos SET GalleryID='$galleryID',VideoText='$video_text',VideoUrl='$new_photo_url',VideoFileName='$video_name' WHERE VideoID='$uploaded_video_id'";
	if ($video_id) $sql="UPDATE videos SET GalleryID='$galleryID',VideoText='$video_text',VideoUrl='$new_photo_url',VideoFileName='$video_name' WHERE VideoID='$video_id'";
	//if (!$video_id==0) $sql="UPDATE videos SET GalleryID='$galleryID',VideoText='$video_text',VideoUrl='$new_photo_url',VideoFileName='$video_name' WHERE VideoID='$video_id'";
	print "v:".$uploaded_video_id;
	$db->query($sql);
	$uploaded_video_id=mysql_insert_id();
	//TumbsResize("../".$gallery_dir."/$photo_filename",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$photo_filename");
	print "הוידאו הועלה בהצלחה";
}
function SavePhoto($video_name,$video_url,$video_text,$galleryID,$video_id) {
	global $gallery_dir;
	global $video_gallery_dir;
	global  $uploaded_video_id;
	global $gallery_photo_h;
	global $gallery_photo_w;
	global $SITE;
	if (!$SITE[galleryphotowidth]=="") $gallery_photo_w=$SITE[galleryphotowidth];
	if (!$SITE[galleryphotoheight]=="") $gallery_photo_h=$SITE[galleryphotoheight];
	global $lastuploadtype;
	global $SITE_LANG;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$video_gallery_dir=$SITE_LANG[dir].$video_gallery_dir;
	$db=new Database();
	$new_photo_url=str_ireplace("watch?v=","v/",$video_url);
	$tmpImg=new SimpleImage();
	$tmpImg->load("uploader/uploads/$video_name");
	if ($tmpImg->getWidth()>$gallery_photo_w OR $tmpImg->getHeight()>$gallery_photo_h)
	{
		BigPhotoConvert("uploader/uploads/$video_name",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$video_name");
		//TumbsResize("uploader/uploads/$video_name",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$video_name");
	}
	else copy("uploader/uploads/$video_name","../$gallery_dir/tumbs/$video_name");
	
	
//	copy("uploader/uploads/$video_name","../".$gallery_dir."/tumbs/$video_name");
	$sql="INSERT INTO videos SET GalleryID='$galleryID',VideoText='$video_text',VideoUrl='$new_photo_url',FileName='$video_name'";
	if (!$uploaded_video_id=="") $sql="UPDATE videos SET FileName='$video_name' WHERE VideoID='$uploaded_video_id'";
	if (!$video_id==0) $sql="UPDATE videos SET VideoText='$video_text',VideoUrl='$new_photo_url',FileName='$video_name' WHERE VideoID='$video_id'";
	$db->query($sql);
	$uploaded_video_id=mysql_insert_id();
	$lastuploadtype="photo";
}
function convert2flv($video_name) {
	global $video_gallery_dir;
		copy("uploader/uploads/$video_name","/home/converter/in/$video_name");
		//copy($video,"/home/converter/in/$video_filename"); just cause we run on localhosy
		//exec('/home/converter/check');copying via crontab
		//copy("/home/converter/out/".$video_filename.".flv","../".$video_gallery_dir."/".$video_filename.".flv");
		return $video_name;
	
}
function delVideo($video_id) {
	global $gallery_dir;
	global $video_gallery_dir;
	global $SITE_LANG;
	$gallery_dir=$SITE_LANG[dir].$gallery_dir;
	$video_gallery_dir=$SITE_LANG[dir].$video_gallery_dir;
	$db=new Database();
	$db->query("SELECT * from videos WHERE VideoID='$video_id'");
	$db->nextRecord();
	$video_fileName=$db->getField("VideoFileName");
//	print $video_gallery_dir;
	$video_photoName=$db->getField("FileName");
	unlink("../".$video_gallery_dir."/".$video_fileName);
	unlink("../".$gallery_dir."/tumbs/".$video_photoName);
	$db->query("delete from videos WHERE VideoID='$video_id'");

}
switch ($action) {
	case "rename":
		$ELID=explode("-",$editorId);
		$PIC[name]=$value;
		$photo_id=$ELID[1];
		$db=new Database();
		$db->query("UPDATE videos SET VideoText='$PIC[name]' WHERE VideoID='$photo_id'");
		print $PIC[name];
		
	break;
	case "rename_url":
		//$ELID=explode("-",$editorId);
		$PIC[url]=str_ireplace("watch?v=","embed/",$NewPicUrl);
		$PIC[url]=str_ireplace("www.vimeo.com","vimeo.com",$PIC[url]);
		if (!stristr($PIC[url],"player.vimeo.com")) $PIC[url]=str_ireplace("vimeo.com","player.vimeo.com/video",$PIC[url]);
		$NewVideoText=$_POST['newVideoText'];
		$NewVideoText=str_replace("'","&rsquo;",$NewVideoText);
		$NewVideoText=strip_tags($NewVideoText);
		$NewVideoText=stripcslashes($NewVideoText);
		$NewVideoText=str_ireplace("\n"," ",$NewVideoText);
		$photo_id=$_POST['video_id'];
		if (!$photo_id) $photo_id=$uploaded_video_id;
		$db=new Database();
		
		if (!$_POST['video_id'] and !$uploaded_video_id AND !$lastuploadtype=="photo") $db->query("INSERT INTO videos SET VideoUrl='$PIC[url]',VideoText='$NewVideoText',GalleryID='$galleryID'");
		$db->query("UPDATE videos SET VideoUrl='$PIC[url]',VideoText='$NewVideoText' WHERE VideoID='$photo_id'");
		
		print $NewVideoText;
		
	break;
	case "saveLoc":
		$db=new Database();
		$PHOTO_POS=$photo_cell;
		for ($a=0;$a<count($PHOTO_POS);$a++) {
//			$PHOTO_CELL=explode("-",$PHOTO_POS[$a]);
			$photo_id=$PHOTO_POS[$a];
			$db->query("UPDATE videos SET VideoOrder='$a' WHERE VideoID='$photo_id'");
		}
	
	break;
	case "delVideo":
		delVideo($video_id);
		session_unregister('uploaded_video_id');
	break;
	case "setGalleryOptions":
	    $db=new Database();
	    $db->query("UPDATE galleries SET wmargin='$wmargin',hmargin='$hmargin' WHERE GalleryID='$galID'");
	    break;
	default:
	
	$VID=explode(".",$_POST[video_name]);
	$video_type=strtolower($VID[1]);
	$video_filename="";
	if ($CONVERT_EXIST==1 AND $upload_type=="video") {
			
		 if ($video_type=="mpg" OR $video_type=="avi" OR $video_type=="wmv") {
		 	$video_filename=convert2flv($video_name);
		 	//print $video_filename;
		 	}
		 }

	if ($upload_type=="video") SaveVideo($_POST[video_name],$_POST[video_url],$_POST[video_text],$_POST[galleryID],$_POST[video_id]);
	if ($upload_type=="photo") SavePhoto($_POST[video_name],$_POST[video_url],$_POST[video_text],$_POST[galleryID],$_POST[video_id]);
//	if () SavePhoto($photo,$photo_text,$galleryID,$photo_url,$video,$video_name,$video_filename); 
	break;
}
?>