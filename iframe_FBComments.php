<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");

$fb_page=strip_tags($_GET['url']);
$border=strip_tags($_GET['border']);
$bgcolor=strip_tags($_GET['bgcolor']);
$theme=strip_tags($_GET['theme']);
$roundcorners=strip_tags($_GET['roundcorners']);
$height=strip_tags($_GET['height']);
$width=strip_tags($_GET['width']);
$fb_widget_local="en_US";
if ($theme=="") $theme="light";
if ($width=="") $width=430;
if ($height=="") $height=100;
if (($SITE_LANG[selected]=="" OR $SITE_LANG[selected]=="he") AND ($default_lang=="he")) $fb_widget_local="he_IL";
$numconnection=$SITE[fb_num_connections];
if ($P_DETAILS[PageStyle]==1) $numconnection=$numconnection+8;
if ($_GET['connections']) $numconnection=$_GET['connections'];
if($fb_page=="") $fb_page=$SITE[fb_page_id];
$box_css="";
if ($SITE[roundcorners]==1) $box_css='-moz-border-radius: 7px;-webkit-border-radius: 7px;border-radius: 7px';
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
<script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
<style>
body {background:none;background-image:none;background-color:transparent;margin:0;padding:0;direction:<?=$SITE_LANG[direction];?>}
.fb-like-box {
   
}
.fb-wrapper > div {
     margin: -1px -1px -1px -2px;
     
}
.fb-wrapper {
     border: 1px solid #<?=$border;?>;
    background: #<?=$bgcolor;?>;
    <?=$box_css;?>;
    width:<?=($width-2);?>px;
    overflow: hidden;
   
    
}
</style>
<script src="https://connect.facebook.net/<?=$fb_widget_local;?>/all.js#appId=<?=$SITE[fb_app_id];?>&amp;xfbml=1"></script>
</head>
<body>
    <div class="fb-wrapper">  
        
        </div>
    </div>
<script>
var documentURL=window.parent.location.href;

var comments_htmlSRC='<div class="fb-comments" data-width="<?=$width;?>" data-href="'+documentURL+'" data-numposts="5" data-colorscheme="<?=$SITE[fb_comments_theme];?>"></div>'
$(".fb-wrapper").html(comments_htmlSRC);
function setFBCommentsHeight() {
    var docHeight=$('body').height()+5;
     $("#iframe_fbcomments",parent.document.body).height(docHeight+"px");
}
$(document).ready(function() {
    
    window.setTimeout('setFBCommentsHeight()',1000);
   
});

</script>
</body>
</html>