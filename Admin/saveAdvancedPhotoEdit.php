<?
include_once("../config.inc.php");
include_once("../database.php");
include_once("../inc/imageResizer.php");
include_once("AmazonUtil.php");

function BigPhotoConvert($img,$w,$h,$destIMG,$quality=100){
    $newRes=$w. 'x'. $h;
    $cr=system("convert $img -resize $newRes -quality $quality -strip $destIMG",$retval);
}
$image_data = file_get_contents($_REQUEST['url']);
$db=new database();
$photo_id=$_REQUEST['photo_id'];

$AMAZON_FILE_LOCATION = "//".$bucket."/exitetogo/".$SITE['S3_FOLDER']."/".$gallery_dir."/";

if ($_GET['type']=="short_content") {
    $cID=$_GET['catID'];
    $db->query("SELECT ContentPhotoName from content WHERE PageID='$photo_id'");
    $db->nextRecord();
 
    $photoFileName=$db->getField("ContentPhotoName");
    $db->query("SELECT ContentPhotoWidth,ContentPhotoHeight,CategoryType,Options from categories WHERE catID='$cID'");
    $db->nextRecord();
    $w=$db->getField("ContentPhotoWidth");
    $h=$db->getField("ContentPhotoHeight");
    $c_type=$db->getField("CategoryType");
    $CONTENT_OPTIONS=json_decode($db->getField('Options'));
    
    if ($c_type==21) {
        $tmpImg=new SimpleImage();
        if($AWS_S3_ENABLED){
            $tmpImg->load($AMAZON_FILE_LOCATION.$photoFileName);
        }
        else{
            $tmpImg->load("../gallery/$photoFileName");
        }
        if (($CONTENT_OPTIONS->DynamicHeight==1 OR $CONTENT_OPTIONS->DynamicHeight=="") AND ($tmpImg->getHeight()>$h AND $c_type==21))  $h=$tmpImg->getHeight();
    }
    
    if (!$w) $w=$SITE[galleryphotowidth];
    if (!$h) $h=$SITE[galleryphotoheight];
    if($AWS_S3_ENABLED){
        file_put_contents("uploader/uploads/".$photoFileName,$image_data);
        UploadToAmazon("uploader/uploads/".$photoFileName,"exitetogo/".$SITE['S3_FOLDER']."/".$gallery_dir."/".$photoFileName);
        BigPhotoConvertToAmazon("uploader/uploads/tumb_".$photoFileName,$w,$h,"/".$gallery_dir."/articles/".$photoFileName,95,1);
        // Delete the photo from uploader...
        unlink("uploader/uploads/".$photoFileName);
        unlink("uploader/uploads/tumb_".$photoFileName);
    }
    else{
        file_put_contents("../gallery/".$photoFileName,$image_data);
        BigPhotoConvert("../gallery/".$photoFileName,$w,$h,"../gallery/articles/".$photoFileName);
    }
    die();
}

$db->query("SELECT photos.FileName, galleries.TumbsWidth,galleries.TumbsHeight,galleries.GalleryOptions from photos LEFT JOIN galleries ON photos.GalleryID=galleries.GalleryID where photos.PhotoID='$photo_id'");
$db->nextRecord();
$photoFileName=$db->getField("FileName");
$w=$db->getField("TumbsWidth");
$h=$db->getField("TumbsHeight");
$GAL_ATTR=json_decode($db->getField("GalleryOptions"),true);
$isCollage=$GAL_ATTR['collage_gallery'];



if($AWS_S3_ENABLED){
    file_put_contents("uploader/uploads/".$photoFileName,$image_data);
    $tmpImg=new SimpleImage();
    $tmpImg->load("../gallery/".$photoFileName);
    if ($isCollage==1) $h=$tmpImg->getHeight();
    UploadToAmazon("uploader/uploads/".$photoFileName,"exitetogo/".$SITE['S3_FOLDER']."/gallery/".$photoFileName);
    BigPhotoConvertToAmazon("uploader/uploads/tumb_".$photoFileName,$w,$h,"/".$gallery_dir."/tumbs/".$photoFileName,95,1);
    // Delete the photo from uploader...
    unlink("uploader/uploads/".$photoFileName);
    unlink("uploader/uploads/tumb_".$photoFileName);
}
else{
    file_put_contents("../gallery/".$photoFileName,$image_data);
    $tmpImg=new SimpleImage();
    $tmpImg->load("../gallery/".$photoFileName);
    if ($isCollage==1) $h=$tmpImg->getHeight();
    BigPhotoConvert("../gallery/".$photoFileName,$w,$h,"../gallery/tumbs/".$photoFileName);
}
//file_put_contents("../gallery/a_".time(),$w.":".$h);
?>
