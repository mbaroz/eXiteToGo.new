<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
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
	$imagedata = getimagesize($img);

	   if ($w && ($imagedata[0] < $imagedata[1])) {
	         $w = ($h / $imagedata[1]) * $imagedata[0];
		} 
	 	  else {
	        $h = ($w / $imagedata[0]) * $imagedata[1];
	}
	
	$im2 = ImageCreateTrueColor($w,$h);
	$image = ImageCreateFromJpeg($img);
	imagecopyResampled ($im2, $image, 0, 0, 0, 0, $w, $h, $imagedata[0],
	$imagedata[1]);
	imagejpeg($im2, $destIMG, 100);
}
$pageID=$_POST['pageID'];
function SavePhoto($photo,$photo_text,$galleryID,$photo_url,$video,$video_name,$video_filename) {
	global $gallery_dir;
	global $video_gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	
	if (!$video_name=="" AND $video_filename=="") {
		$VID_NAME=explode(".",$video_name);
		$video_file_ext=$VID_NAME[1];	
		$video_filename=NewGuid().".".$video_file_ext;
		copy($video,"../".$video_gallery_dir."/$video_filename");
	}
	if (!$photo=="") {
		$photo_filename=NewGuid().".jpg";
		copy($photo,"../".$gallery_dir."/$photo_filename");
		copy($photo,"../".$gallery_dir."/tumbs/$photo_filename");
	}
	$db=new Database();
	$photo_text=strip_tags($photo_text);
	$photo_text=stripslashes($photo_text);
	$new_photo_url=str_ireplace("watch?v=","v/",$photo_url);
	$db->query("INSERT INTO videos SET GalleryID='$galleryID',FileName='$photo_filename',VideoText='$photo_text',VideoUrl='$new_photo_url',VideoFileName='$video_filename'");
	//TumbsResize("../".$gallery_dir."/$photo_filename",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$photo_filename");
	print "הוידאו הועלה בהצלחה";
}
function convert2flv($video,$video_name) {
	global $video_gallery_dir;
	$video_filename="";
	if (!$video_name=="") {
		$VID_NAME=explode(".",$video_name);
		$video_file_ext=$VID_NAME[1];	
		$video_filename=NewGuid().".".$video_file_ext;
		copy($video,"/home/converter/in/$video_filename");
		//exec('/home/converter/check');copying via crontab
		//copy("/home/converter/out/".$video_filename.".flv","../".$video_gallery_dir."/".$video_filename.".flv");
		return $video_filename.".flv";
	}
}
function delVideo($video_id) {
	global $gallery_dir;
	global $video_gallery_dir;
	$db=new Database();
	$db->query("SELECT * from videos WHERE VideoID='$video_id'");
	$db->nextRecord();
	$video_fileName=$db->getField("VideoFileName");
	unlink("../".$video_gallery_dir."/".$video_fileName);
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
		$PIC[url]=str_ireplace("watch?v=","v/",$NewPicUrl);
		$NewVideoText=$_POST['newVideoText'];
		$photo_id=$_POST['video_id'];
		$db=new Database();
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
	break;
	
	default:
	if ($CONVERT_EXIST==1) {
		$video_filename="";
		 if ($video_type=="video/mpeg" OR $video_type=="video/x-ms-wmv") {
		 	$video_filename=convert2flv($video,$video_name);
		 	}
		 }
		 
	if ($photo_type=="image/jpeg" OR $photo_type=="image/pjpeg" OR $photo_type=="" OR $video_type=="video/mpeg" OR $video_type=="video/x-flv" OR $video_type=="video/x-ms-wmv") SavePhoto($photo,$photo_text,$galleryID,$photo_url,$video,$video_name,$video_filename); 
	break;
}
?>