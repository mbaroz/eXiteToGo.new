<?php
// Bucket Name
$bucket="cdn.exiteme.com";
if (!class_exists('S3'))require_once('aws/S3.php');
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJTHBQC5L6NPUEWFQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);
$s33 = new S3(awsAccessKey, awsSecretKey);
if (!defined('bucketDone')) {
    $s3->putBucket($bucket, S3::ACL_PUBLIC_READ);
    $s33->putBucket($bucket, S3::ACL_PUBLIC_READ);
    define ('bucketDone',1);
}

?>