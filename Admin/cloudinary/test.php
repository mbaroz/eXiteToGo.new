<?
error_reporting(E_ALL);
require 'Cloudinary.php';
require 'Uploader.php';
require 'Api.php';
?>

<?
\Cloudinary::config(array( 
  "cloud_name" => "mbaroz", 
  "api_key" => "276227296165133", 
  "api_secret" => "UGnj8Y2Kb3z8sbTJVGDCooAVUYY"
));
\Cloudinary\Uploader::upload("../uploader/uploads/1.JPG",array("public_id" => "www.ddd.com/gallery/344333","width"=>900));
