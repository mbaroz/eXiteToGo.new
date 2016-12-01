<?php
session_start();
$useragent = $_SERVER['HTTP_USER_AGENT'];
header("Content-Type: text/css");
$inc_dir="../";
?>
.galleria-image-nav {display:none}
ul.dropdown {
    position:relative;
    float:<?=$SITE[opalign];?>;
 }
.topLangSelector {
	margin-top:0px;
}
#cart_wrapper {text-align:left}