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

function SavePhoto($photo,$photo_text,$galleryID,$photo_url) {
	global $gallery_dir;
	global $gallery_photo_h;
	global $gallery_photo_w;
	$photo_filename=NewGuid().".jpg";
	copy($photo,"../".$gallery_dir."/$photo_filename");
	$db=new Database();
	$photo_text=strip_tags($photo_text);
	$photo_text=stripslashes($photo_text);
	$db->query("INSERT INTO photos SET GalleryID='$galleryID',FileName='$photo_filename',PhotoText='$photo_text',PhotoUrl='$photo_url'");
	TumbsResize("../".$gallery_dir."/$photo_filename",$gallery_photo_w,$gallery_photo_h,"../$gallery_dir/tumbs/$photo_filename");
	print "תמונה הועלתה בהצלחה";
}
function delPhoto($photo_id) {
	global $gallery_dir;
	$db=new Database();
	$db->query("SELECT * from photos WHERE PhotoID='$photo_id'");
	$db->nextRecord();
	$photo_fileName=$db->getField("FileName");
	unlink("../".$gallery_dir."/".$photo_fileName);
	unlink("../".$gallery_dir."/tumbs/".$photo_fileName);
	$db->query("delete from photos WHERE PhotoID='$photo_id'");

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
		$ELID=explode("-",$editorId);
		$PIC[url]=$value;
		$photo_id=$ELID[1];
		$db=new Database();
		$db->query("UPDATE photos SET PhotoUrl='$PIC[url]' WHERE PhotoID='$photo_id'");
		print $PIC[url];
		
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
	case "delPhoto":
		delPhoto($photo_id);	
	break;
	default:
	if ($photo_type=="image/jpeg" OR $photo_type=="image/pjpeg") SavePhoto($photo,$photo_text,$galleryID,$photo_url); 
	break;
}
?>