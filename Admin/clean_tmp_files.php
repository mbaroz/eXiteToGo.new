<?
$mask = "uploader/uploads/*.jpg";
$mask_2 = "uploader/uploads/*.JPG";
$mask_3= "uploader/uploads/*.png";
$mask_4= "uploader/uploads/*.PNG";
$mask_5= "uploader/uploads/*.gif";
$mask_6= "uploader/uploads/*.GIF";
array_map( "unlink", glob($mask));
array_map( "unlink", glob($mask_2));
array_map( "unlink", glob($mask_3));
array_map( "unlink", glob($mask_4));
array_map( "unlink", glob($mask_5));
array_map( "unlink", glob($mask_6));
?>