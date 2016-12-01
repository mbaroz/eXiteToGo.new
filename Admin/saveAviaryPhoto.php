<?

include_once("../config.inc.php");
include_once("../database.php");
include_once("AmazonUtil.php");

if (! isset($_REQUEST['url'])) die();
//$postdata = json_decode(stripslashes($_REQUEST['postdata']));
//if(! isset($postdata->source_filename) OR empty($postdata->source_filename)) die();
$source_filename=$_REQUEST['source_filename'];

$image_data = file_get_contents($_REQUEST['url']);

$path_base = "../userfiles/";
$thumbs_base = $path_base . "_thumbs/Images/";

$image_path = $path_base . "images/" . $source_filename;
$image_thumb_path = $thumbs_base . $source_filename;



// Upload to amazon.
if($AWS_S3_ENABLED){
	file_put_contents("uploader/uploads/".$source_filename, $image_data);
    UploadToAmazon("uploader/uploads/".$source_filename,"exitetogo/".$SITE['S3_FOLDER'].
    											"/userfiles/images/".$source_filename);
	
    // Delete the temp photo from uploader...
    unlink("uploader/uploads/".$source_filename);
    // Delete the thumbnail photo so CKFinder will create new one after the change.
	if(CheckForFile("","userfiles/_thumbs/Images/".$source_filename)){
		DeleteImageFromAmazon("/userfiles/_thumbs/Images/".$source_filename);
	}

}
else{
	file_put_contents($image_path, $image_data);
	if(file_exists($image_thumb_path)) unlink($image_thumb_path);
}

?>
