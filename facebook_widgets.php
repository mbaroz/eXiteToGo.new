<div class="clear"></div>
<?

$fb_widget_local="en_US";
$ShareText="Share on facebook";
if (($SITE_LANG[selected]=="" OR $SITE_LANG[selected]=="he") AND ($default_lang=="he")) {
	$fb_widget_local="he_IL";
	$ShareText="שתף בפייסבוק";
}

function AddFB($widgetType,$share_url="") {
	global $fb_widget_local;
	global $SITE;
	global $P_DETAILS;
	global $ShareText;
	global $SITE_LANG;
	global $isLeftColumn;
	global $rightColWidth;
	$box_css="";
	$like_url=$SITE[fb_page_id];
	if ($like_url=="") $like_url=$share_url;
	if ($SITE[fb_like_sitepage]) $like_url=$share_url;
	if ($SITE[roundcorners]==1) $box_css='-moz-border-radius: 7px;-webkit-border-radius: 7px;border-radius: 7px';
	
	if (!$SITE[fb_num_connections]) $SITE[fb_num_connections]=26;
	if (!$SITE[fb_likebox_height]) $SITE[fb_likebox_height]=205;
	$comments_box_width=660;
	$fb_lb_height=$SITE[fb_likebox_height];
	$numconnection=$SITE[fb_num_connections];
	if ($P_DETAILS[PageStyle]==1) {
		$comments_box_width=916;
		$numconnection=$numconnection+8;
	}
	if ($isLeftColumn) $comments_box_width=$rightColWidth;
 	$scriptCode='<script src="https://connect.facebook.net/'.$fb_widget_local.'/all.js#appId='.$SITE[fb_app_id].'&amp;xfbml=1" async="true"></script>';
	
	switch ($widgetType) {
		case 1:
			$srcCode=$scriptCode;
			$srcCode.='<div id="fb-root"></div>';
			$srcCode.='<div style="margin-right:5px;margin-top:10px;min-height:80px;" class="exite_fb_like_wrapper"><div class="fb-share-button" data-href="'.$share_url.'" data-width="60" data-type="button"></div>&nbsp;<div class="fb-like" data-href="'.$like_url.'" data-send="false" data-width="420" data-show-faces="false" data-font="arial"></div></div>';
			break;
		case 6:
			$srcCode=$scriptCode;
			$srcCode.='<div id="fb-root"></div>';
			$srcCode.='<div style="margin-right:5px;margin-top:10px;min-height:80px;" class="exite_fb_like_wrapper"><div class="fb-like" data-href="'.$share_url.'" data-send="false" data-width="320" data-show-faces="false" data-font="arial" data-share="true"></div></div>';
			break;
		case 2:
			$srcCode=$scriptCode;
			$href_url=$SITE[url].$_SERVER['REQUEST_URI'];
			$srcCode.='<div id="fb-root"></div><div style="margin-right:5px;"><fb:comments href="'.$href_url.'" width="'.$comments_box_width.'" colorscheme="'.$SITE[fb_comments_theme].'"  css="'.$SITE[url].'/css/fb.css.php?'.rand(12,23231020).'"></fb:comments></div>';
			if (!$SITE[fb_app_id]) $srcCode="";
			break;
		case 3:
			$srcCode=$scriptCode;
			$srcCode.='<div class="fb-share-button" data-href="'.$share_url.'" data-width="60" data-type="button_count"></div>';
			//$srcCode.='<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>';
			break;
		case 4:
			$srcCode=$scriptCode;
			$srcCode.='<div id="fb-root"></div>';
			//$srcCode.='<div class="facebook_like_box" style="border:1px solid #'.$SITE[likeboxbordercolor].';margin-right:6px;margin-bottom:8px;overflow-x:hidden;background-color:#'.$SITE[likeboxbgcolor].';width:'.($comments_box_width+12).'px;'.$box_css.'"><fb:fan profile_id="'.$SITE[fb_page_id_num].'" height="'.$fb_lb_height.'" href="'.$SITE[fb_page_id].'" width="'.($comments_box_width).'" stream="false" connections="'.$numconnection.'" logobar="0"  header="false" css="'.$SITE[url].'/css/fb.css.php?'.rand(12,23231020).'"></fb:fan></div>';
			$srcCode.='<div class="facebook_like_box" style="height:'.$SITE[fb_likebox_height].'px;overflow:hidden;border:1px solid #'.$SITE[likeboxbordercolor].';margin-right:6px;margin-bottom:8px;background-color:#'.$SITE[likeboxbgcolor].';width:'.($comments_box_width+12).'px;'.$box_css.'">
			<div class="fb-like-box" data-href="'.$SITE[fb_page_id].'" data-width="'.($comments_box_width+12).'" data-show-faces="true" data-stream="false" data-header="false" data-show-border="false" data-border-color="#'.$SITE[likeboxbordercolor].'" data-colorscheme="'.$SITE[fb_comments_theme].'" data-connections="'.$numconnection.'"></div>
			</div>';
			if (!$SITE[fb_page_id]) $srcCode="";
			break;
		case 5:
			$srcCode=$scriptCode;
			$srcCode.='<div id="fb-root"></div>';
			$href_url=$SITE[url].$_SERVER['REQUEST_URI'];
			$srcCode.='<div style="margin-right:15px;height:80px"><fb:like send="true" font="arial" href="'.$href_url.'" layout="standard" show_faces="false" width="450"  action="like" css="'.$SITE[url].'/css/fb.css.php?'.rand(12,23231020).'"></fb:like></div>';
			break;
		case 7:
			$srcCode=$scriptCode;
			$srcCode.='<div id="fb-root"></div>';
			$href_url=$SITE[url].$_SERVER['REQUEST_URI'];
			$srcCode.='<div style="margin-right:5px;margin-top:10px;min-height:40px;" class="exite_fb_like_wrapper"><div class="fb-share-button" data-href="'.$share_url.'" data-width="60" data-type="button"></div>&nbsp;<div class="fb-like" data-href="'.$like_url.'" data-send="false" data-width="420" data-show-faces="false" data-font="arial"></div></div>';
			$srcCode.='<div style="margin-right:5px;"><div class="fb-comments" data-href="'.$href_url.'" data-width="'.$comments_box_width.'" data-colorscheme="'.$SITE[fb_comments_theme].'" data-mobile="auto-detect"></div></div>';
			break;
		default:
			$srcCode="";
			break;
	}
	return $srcCode;
	
	
}

$shareFullUrl=$SITE[url].'/'.$_SERVER['REQUEST_URI'];
if ($SITE[fb_integration] AND !$P_DETAILS[FB_WIDGET]) $P_DETAILS[FB_WIDGET]=$SITE[fb_integration];
?>
<div style="float:<?=$SITE[align];?>">
<? print AddFB($P_DETAILS[FB_WIDGET],$shareFullUrl);?>
</div>