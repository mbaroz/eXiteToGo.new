<?php

if ($AWS_S3_ENABLED) {
    if (!class_exists('S3')) require_once 'aws/S3.php';
    if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJTHBQC5L6NPUEWFQ');
    if (!defined('awsSecretKey')) define('awsSecretKey', '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');
    $s3 = new S3(awsAccessKey, awsSecretKey);
    $bucket="cdn.exiteme.com";

}

function UploadTumbToAmazon($s,$d) {
    //include("aws/s3_config.php");
    global $s33;
    global $bucket;
    if ($s33->putObjectFile($s, $bucket, $d, S3::ACL_PUBLIC_READ)) print "ok".$d;
    else print "faild amazon_upload, Error:".$d;
}
function UploadToAmazon($s,$d) {
    global $s3;
    global $bucket;

    if ($s3->putObjectFile($s, $bucket, $d, S3::ACL_PUBLIC_READ)){
        // print "ok".$s;
    }
    else{
        // print "faild amazon_copy, Error:".$s;
    }
}
function CopyPhotoInAmazon($s,$d){
    global $s3;
    global $bucket;

    if ($s3->copyObject($bucket, $s, $bucket, $d, S3::ACL_PUBLIC_READ)){
        // print "ok".$s;
    }
    else{
        // print "faild amazon_copy, Error:".$s;
    }
}
function DeleteImageFromAmazon($imagePath){
	global $bucket;
	global $s3;
	global $SITE;
	if($s3->deleteObject($bucket,"exitetogo/".$SITE['S3_FOLDER'].$imagePath)){
        // print "ok: "."exitetogo/".$SITE['S3_FOLDER'].$imagePath;
    }
    else{
    	// print "faild amazon_delete, Error: "."exitetogo/".$SITE['S3_FOLDER'].$imagePath;
    }
}
function BigPhotoConvertToAmazon($img,$w,$h,$dst,$quality=100,$istumb=0,$crop_mode=0,$ratio=0) {
    global $SITE;
    $newRes=$w. 'x'. $h;
    if ($istumb) $source_tumb=str_ireplace("tumb_","",$img);
    else $source_tumb=$img;
    if ($crop_mode==1) {
        
        if ($ratio>1) {
            $tmpRes_W=$w*$ratio;
            $tmpRes_H=$h*$ratio;
        }
        else {
            $tmpRes_W=$w/$ratio;
            $tmpRes_H=$h/$ratio;
            //if ($tmpRes_W<$w) $tmpRes_W=$w*1.2;
        }
        $tmpRes=$tmpRes_W;
        $cropRes=$newRes."+0+0";
        $cr=system("convert $source_tumb -resize $tmpRes -quality 100 -strip $img",$retval);
        $cr=system("convert $img -gravity center -crop $cropRes $img",$retval);
        
    }
    else $cr=system("convert $source_tumb -resize $newRes -quality $quality -strip $img",$retval);
    if ($istumb) UploadToAmazon($img,"exitetogo/".$SITE['S3_FOLDER'].$dst);
	else   UploadToAmazon($img,"exitetogo/".$SITE['S3_FOLDER'].$dst);
  return $cr;
}
function CheckForFile($destPrefix, $destPath){
    global $SITE;
    global $AWS_S3_ENABLED;
    global $bucket;
    
    if($destPath[0] == "/")
        $destPath = substr($destPath, 1);
    
    if($AWS_S3_ENABLED){
        $thePath = "http://".$bucket."/exitetogo/".$SITE['S3_FOLDER']."/".$destPath;
        $file_headers = @get_headers($thePath);
        foreach ($file_headers as $key => $value) {
            if($value == 'HTTP/1.1 404 Not Found')
                return false;
        }
        return true;
    }
    else{
        $result = is_file($destPrefix.$destPath);
    }   
    return $result;
}
?>