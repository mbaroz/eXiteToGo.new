<?php
session_start();
$useragent = $_SERVER['HTTP_USER_AGENT'];
header("Content-Type: text/css");
$inc_dir="../";

include_once($inc_dir."inc/GetServerData.inc.php");
include_once($inc_dir.$SITE_LANG[dir]."database.php");
// Added include to config to support SITE_MEDIA constant.
include_once($inc_dir."config.inc.php");
include_once($inc_dir."defaults.php");
$SITE[isFullResponsive]=0;
$AWS_S3_ENABLED=true;
if($AWS_S3_ENABLED){
	define('SITE_MEDIA', "//cdn.exiteme.com/exitetogo/" . $SITE['S3_FOLDER']);
}
else{
	define('SITE_MEDIA', $SITE[media]);
}
$W_FONTS=explode("|",$SITE[webfonts]);
$G_FONTS=explode("|",$SITE[googlewebfonts]);
if (in_array($SITE[fontface],$W_FONTS) AND !stristr($SITE[fontface],"almoni-dl")) {
	?>
	@font-face {
	font-family: '<?=$SITE[fontface];?>';
	src: url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[fontface];?>.eot');
	src: url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[fontface];?>.eot?#iefix') format('embedded-opentype'),
	url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[fontface];?>.woff') format('woff'),
        url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[fontface];?>.ttf') format('truetype'),
        url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[fontface];?>.svg#<?=$SITE[fontface];?>') format('svg');
	font-weight: normal;
	font-style: normal;

}
	<?
}
if (in_array($SITE[menusfont],$W_FONTS) AND !stristr($SITE[menusfont],"almoni-dl")) {
	?>
	@font-face {
	font-family: '<?=$SITE[menusfont];?>';
	src: url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[menusfont];?>.eot');
	src: url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[menusfont];?>.eot?#iefix') format('embedded-opentype'),
	url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[menusfont];?>.woff') format('woff'),
        url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[menusfont];?>.ttf') format('truetype'),
        url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[menusfont];?>.svg#<?=$SITE[menusfont];?>') format('svg');
	font-weight: normal;
	font-style: normal;

}
	<?
}
if (in_array($SITE[titlesfont],$W_FONTS) AND !stristr($SITE[titlesfont],"almoni-dl")) {
	?>
	@font-face {
	font-family: '<?=$SITE[titlesfont];?>';
	src: url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[titlesfont];?>.eot');
	src: url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[titlesfont];?>.eot?#iefix') format('embedded-opentype'),
	url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[titlesfont];?>.woff') format('woff'),
        url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[titlesfont];?>.ttf') format('truetype'),
        url('<?=$SITE[cdn_url];?>/css/webfonts/<?=$SITE[titlesfont];?>.svg#<?=$SITE[titlesfont];?>') format('svg');
	font-weight: normal;
	font-style: normal;

}
<?
}
if (in_array($SITE[titlesfont],$G_FONTS) OR in_array($SITE[menusfont],$G_FONTS) OR in_array($SITE[fontface],$G_FONTS)) {
	$gfont_str=array();
	if (in_array($SITE[menusfont],$G_FONTS)) $gfont_str[]=$SITE[menusfont];
	if (in_array($SITE[titlesfont],$G_FONTS)) $gfont_str[]=$SITE[titlesfont];
	if (in_array($SITE[fontface],$G_FONTS)) $gfont_str[]=$SITE[fontface];
	$g_fonts=implode("|",$gfont_str);
	$g_fonts=str_ireplace(" ","+",$g_fonts);
}
$topHeaderCSS=$topHeaderFullCSS='';
$top_sub_rounded_css="";
$catID=$_GET['cID'];
if ($SITE[roundcorners]==1) $top_sub_rounded_css="
border-radius:0px 0px 6px 6px / 0px 0px 6px 6px;
-moz-border-radius:0px 0px 6px 6px / 0px 0px 6px 6px;";
if ($SITE[upnavopacity]=="") $SITE[upnavopacity]=100;
if ($SITE[footermasteropacty]=="") $SITE[footermasteropacty]=100;
if ($SITE[headermasteropacty]=="") $SITE[headermasteropacty]=100;
if ($SITE[submenudropdownopacity]=="") $SITE[submenudropdownopacity]=100;
$CHECK_MAINPIC_WIDTH_MODE=CheckCatMainPicWidthParent($catID);
if ($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==2000) $SITE[mainpicwidth]=2000;
if ($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==950) $SITE[mainpicwidth]=950;

$topHeaderMainWidth="950px";
$dynamicWidth=950;
$dynamicWidthPadding=$dynamicWidth-20;
if ($SITE[sitewidth]>950) {
	$dynamicWidth=$SITE[sitewidth];
	$dynamicWidthPadding=$SITE[sitewidth]-20;
	if ($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==950) $SITE[mainpicwidth]=$dynamicWidth;
	if (($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==930 OR $CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]=="") AND $SITE[mainpicwidth]!=2000) $SITE[mainpicwidth]=$dynamicWidthPadding;
	if ($SITE[mainpicwidth]==$dynamicWidthPadding AND $SITE[middlebgcolor]=="") $SITE[mainpicwidth]=$dynamicWidth;
	$topHeaderMainWidth=$dynamicWidth."px";

}
$topMainPicWidth=$SITE[mainpicwidth]."px";
if ($SITE[mainpicwidth]==2000) {
	$topHeaderMainWidth=$topMainPicWidth="100%";
	if ($SITE[topmenubottom]!=2) {
		$main_pic_width_mode="950px";
		if ($dynamicWidth>0) $main_pic_width_mode=$dynamicWidth."px";
	}

}

if ($SITE[headerlogobgpic]) $topHeaderCSS=$topHeaderFullCSS="background-image:url('".SITE_MEDIA."/gallery/sitepics/".$SITE[headerlogobgpic]."');background-repeat:no-repeat;background-position:center top;";
if ($SITE[topheaderfullwidth]) $topHeaderCSS="";
$upNavigateIconUrl=$SITE[cdn_url]."/images/arrow-up-exite.png";
if ($SITE[upnavigateicon]) $upNavigateIconUrl=SITE_MEDIA."/gallery/sitepics/".$SITE[upnavigateicon];

?>
body {
	margin:0;
	font-family: <?=$SITE[cssfont];?>;
	font-size:13px;
	background-color:#<?=$SITE[bgcolor];?>;
	<?
	if ($SITE[sitebgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[sitebgpic];?>');
		<?
	}
	?>
	background-position:center top;
	-webkit-font-smoothing: antialiased !important;
}

a:link,a:visited {
	text-decoration:none;
}
span a {
	color:inherit;
}
.mainPage {
	width:100%;
	<?
	if ($SITE[topbglayer]) {
		?>
		background:transparent url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[topbglayer];?>') no-repeat scroll;
		<?
	}
	?>
	background-position:center top;
	direction:<?=$SITE_LANG[direction];?>;
	
}
.clear {
	clear:both;
}
.mobile_mainpic_homepage, .mobileLogoMasterHeader {display: none;}
 
.topHeader {
	width:<?=$dynamicWidth;?>px;
	background-color:#<?=$SITE[topheaderbg];?>;
	min-height:50px;
	padding:0px;
	margin:0px;
	<?=$topHeaderCSS;?>
	<?
	if ($SITE[roundcorners] AND !$SITE[topheaderfullwidth]) {
		?>
		border-bottom-right-radius:8px;border-bottom-left-radius:8px;
		-webkit-border-bottom-right-radius:8px;-webkit-border-bottom-left-radius:8px;
		-moz-border-bottom-right-radius:8px;-moz-border-bottom-left-radius:8px;
		<?
	}
	?>
	
}
.topHeaderFull {
	width:100%;
	background-color:#<?=$SITE[topheaderbg];?>;
	margin:0;
	padding:0;
	<?=$topHeaderFullCSS;?>
}
.topHeaderLogo{
	float:<?=$SITE[align];?>;
	text-align:<?=$SITE[align];?>;
	position:relative;
	z-index:800;
	
}
.topHeaderLogo img{
	display:block;
	
}
.topHeaderTopMenu {
	margin-top:<?=$SITE[topmenumargin];?>px;
	float:<?=$SITE[align];?>;
	<?if ($SITE[topmenuunderlogo]==1) {
		?>
		width:100%;
		margin-bottom:8px;
		<?
	}
	else {
		?>
		width:<?=$topMenuTopHeaderWidth;?>;
		<?		
	}
	?>
	
	
}
.topHeaderSlogen {
	float:<?=$SITE[align];?>;
	color:#<?=$SITE[contenttextcolor];?>;
	<?=$solganDivWidth;?>
	<?=$solganDivHeight;?>
	position:relative;
	z-index:800;
	margin-top:0px;
	margin-bottom:0px;
	padding-bottom:0px;
	padding-top:0px;
	margin-<?=$SITE[align];?>:5px;
	overflow-x:hidden;
	overflow-y:hidden;
	text-align:<?=$SITE[align];?>;
	box-sizing:border-box;
	
}

.topHeaderMain {
	width:<?=$topHeaderMainWidth;?>;
	background:#<?=$SITE[middlebgcolor];?>;
	margin:0px;
	padding:0px;
	<?
	if ($SITE[roundcorners] AND !$SITE[topheadermainfullwidth]) {
		?>
		border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;
		<?
	}
	?>
	direction:initial;
}
.topHeaderMainFull {
	width:100%;
	background:#<?=$SITE[middlebgcolor];?>;
	padding:0;
	margin:0
}

.roundBox {
	display:block;
	width:<?=$dynamicWidth;?>px;
	clear:both;
	height:7px;
	
}
.search_roundBox {
	display:block;
	width:<?=$SITE[searchformwidth];?>px;
	clear:both;
	height:7px;
	
}
.short_content_roundBox {
	display:block;
	
	
}
.side_roundBox {
	display:block;
	width:250px;
	clear:both;
	height:7px;
	
}
.middle_roundBox {
	display:block;
	width:695px;
	clear:both;
	height:7px;
}

.b1,.b2,.b3,.b4 {
	font-size:1px;
	display:block;
	overflow:hidden;	
	background: '' none repeat scroll 0 0;
}

.b4 {
	height:2px;
	
	margin: 0 1px;
}

.b3 {
	height:1px;
	margin: 0 2px;
}

.b2 {
	height:1px;
	margin: 0 3px;
}
.b1 {
	height:1px;
	margin: 0 5px;
}

.round_top {
	height:2px;
	
}
.round_bottom {
	height:5px;
}
.h_margin {
	font-size:1px;
	clear:both;
	height:4px;
}

.topMainPic {
	width:<?=$topMainPicWidth;?>;
	padding-bottom:8px;
	padding-top:8px;
	overflow:hidden;
	direction:<?=$SITE_LANG[direction];?>;
	
}
<?if ($SITE[mainpicwidth]!=2000) {
	?>
	.topMainPic img#staticHeadPic{max-width:<?=$topMainPicWidth;?>}	
	<?
}
?>
.topMainPicCustom {
	float:<?=$SITE[opalign];?>;
	width:<?=$SITE[mainpiccustomwidth];?>px;
	overflow:hidden;
	
	
}
.topMainPicSideText {
	float:<?=$SITE[align];?>;
	width:<?=($SITE[mainpicwidth]-$SITE[mainpiccustomwidth]-8);?>px;
	margin-<?=$SITE[opalign];?>:4px;
	margin-<?=$SITE[align];?>:3px;
	color:#<?=$SITE[contenttextcolor];?>;
	text-align:<?=$SITE[align];?>;
	z-index:200;
	position:relative;

}
#mainPicSideText img {
	display:inline;
	margin-bottom:auto;
}
.topMainPic .resizeWrapper {
	padding:0;margin:0;overflow:hidden;
}
.topMainPic img {
	display:block;
	
}
.mainContentContainer.fullscreen {width:100%}
.mainContentContainer.fullscreen .mainContent {margin:0 10px;width:100%}
.mainContent {
	background:#<?=$SITE[contentbgcolor];?>;
	width:<?=$dynamicWidth;?>px;
	<?
	if ($SITE[isFullResponsive]==1) 
		{
		?>
		width:100%;
		max-width:1350px;
		<?
		}
	?>
	overflow:hidden;
	
}
.mainContentFull {
	width:100%;
	background:#<?=$SITE[contentbgcolor];?>;
	padding:0;
	margin:0;
	<?if ($SITE[contentbgpic] AND $SITE[maincontentfullwidth]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[contentbgpic];?>');
		<?
	}?>
}
.mainContentSeperated {
	width:<?=($dynamicWidth-255);?>px;
	min-height:160px;
	background:#<?=$SITE[contentbgcolor];?>;
	padding-top:9px;
	<?if ($SITE[contentbgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[contentbgpic];?>');
		<?
	}?>
}
.mainContentContainer {
	width:<?=$dynamicWidth;?>px;
	<?
	if ($SITE[isFullResponsive]==1) 
		{
		?>
		width:100%;
		max-width:1350px;
		<?
		}
	?>
	text-align:center;
	background-color:#<?=$SITE[contentbgcolor];?>;
	<?if (!$SITE[maincontentfullwidth] AND $SITE[contentbgpic]) {
		?>background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[contentbgpic];?>');
		<?}?>
}

.middleContent {
	min-height:5px;
	width:<?=$dynamicWidth;?>px;
		<?
	if ($SITE[isFullResponsive]==1) 
		{
		?>
		width:100%;
		max-width:1350px;
		<?
		}
	?>
	background:#<?=$SITE[bottompicbgcolor];?>;
	padding-top:0px
	padding-bottom:0px;
	text-align:center;
}

.middleContentFull {
	width:100%;
	background:#<?=$SITE[bottompicbgcolor];?>;
	padding-top:0;
	margin:0;
}
.middleContentText {
	text-align:<?=$SITE[align];?>;
	font-size:<?=$SITE[contenttextsize];?>px;
	color:#<?=$SITE[contenttextcolor];?>;
	padding-<?=$SITE[align];?>:10px;
	padding-top:5px;
	padding-bottom:5px;
	width:<?=$dynamicWidthPadding;?>px;
	<?
	if ($SITE[isFullResponsive]==1) 
		{
		?>
		width:100%;
		max-width:1350px;
		box-sizing:border-box;
		<?
		}
	?>
	overflow:hidden;
	position:relative;
	z-index:105;
}

ul.dropdown,ul.dropdown li,ul.dropdown ul {
 list-style: none;
 margin: 0;
 padding: 0;
}

ul.dropdown {
 position: relative;
 z-index:800;
<?=$topMenuAlignCSS;?>
 }
.topMenuNew {
	<?if ($SITE[topmenubgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[topmenubgpic];?>');
		<?
	}
	?>
	
	background-color:#<?=$SITE[topmenubgcolor];?>;
	width:<?=$main_pic_width_mode;?>;
	min-height:36px;
	direction:<?=$SITE_LANG[direction];?>;
	
}
ul.dropdown li div.right_bg_topmenu.selectedTopMenu, ul.dropdown li div.left_bg_topmenu.selectedTopMenu, ul.dropdown li div.middle_bg_topmenu.selectedTopMenu {
	<?if ($SITE[topmenuselecteditembgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[topmenuselecteditembgpic];?>');
		<?
	}?>
	
}
ul.dropdown li div.right_bg_topmenu {
	<?if ($SITE[topmenuitembgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[topmenuitembgpic];?>');
		<?
	}?>
	background-position:right top;
	background-repeat:no-repeat;
	height:33px;
	width:7px;
	padding:0;
	margin:-8px 0 0 0;
	float:right;
	
}

ul.dropdown li div.left_bg_topmenu {
	<?if ($SITE[topmenuitembgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[topmenuitembgpic];?>');
		<?
	}?>
	background-position:left top;
	background-repeat:no-repeat;
	height:33px;
	width:7px;
	padding:0;
	margin:-8px 0 0 0;
	float:left;
	
}
ul.dropdown li div.middle_bg_topmenu {
	<?if ($SITE[topmenuitembgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[topmenuitembgpic];?>');
		<?
	}?>
	background-position:50% 0;
	background-repeat:repeat-x;
	height:25px;
	padding:8px 3px 0px 3px;
	margin:-8px 0 0 0;
	float:right;
	
}

ul.dropdown li {
	float: <?=$SITE[align];?>;
	line-height: 1.2em;
	vertical-align: middle;
	zoom: 1;
	padding:10px <?=$SITE[topmenusidemargin];?>px 10px;
	color:#<?=$SITE[topmenutextcolor];?>;
	font-weight:<?=stristr($SITE[menusfont],"almoni") ? 'normal' : 'bold';?>;
	font-size:<?=$SITE[menutextsize];?>px;
	margin-bottom:0px;
	font-family:<?=$SITE[cssmenusfont];?>;
}
ul.dropdown li:last {padding-<?=$SITE[opalign];?>:0px}
ul.dropdown li a {
	color:#<?=$SITE[topmenutextcolor];?>;
	text-decoration:none;
	margin:0;
	
}
ul.dropdown li a:hover {
	color:#<?=$SITE[topmenuhovercolor];?>;

}
ul.dropdown span.topMenu_selectedWithBG  a {color:#<?=$SITE[topmenuitemcolor];?>;}
ul.dropdown span.topMenu_selected  a, ul.dropdown ul span.topSubMenu_selected  a{
	text-decoration:none;
	color:#<?=$SITE[topmenuhovercolor];?>;
}
ul.dropdown li.hover,ul.dropdown li:hover {
	position: relative;
 	cursor: default;
 	background-color:#<?=$SITE[submenuhovebgcolor];?>;
	opacity:<?=($SITE[submenudropdownopacity]/100);?>;
	<?if ($SITE[dropdownmenubgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[dropdownmenubgpic];?>');
		<?
	}
	?>
}

ul.dropdown li.nobg:hover {
	background-color:transparent;
	
}

ul.dropdown ul {
	visibility: hidden;
	position: absolute;
	top: 100%;
	<?=$SITE[align];?>: 0;
	color:#<?=$SITE[topmenutextcolor];?>;
	background-color:#<?=$SITE[submenuhovebgcolor];?>;
	width: 180px;
	opacity:<?=($SITE[submenudropdownopacity]/100);?>;
	<?if ($SITE[dropdownmenubgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[dropdownmenubgpic];?>');
		<?
	}
	?>
	
	
}
ul.dropdown ul li {
	float: none;
	text-align:<?=$SITE[align];?>;
	padding:5px;
	font-weight:<?=$sideMenuStyle;?>;
	<?=($SITE[popupmenufontsize]) ? 'font-size:'.$SITE[popupmenufontsize].'px;' :'';?>
}
ul.dropdown ul li:not(:last-child) {
	border-bottom:1px solid #<?=$SITE[submenuseperatorcolor];?>;
}
ul.dropdown li:hover > ul {
	visibility: visible;
	opacity:1;
	
}

ul.dropdown li.nobg:hover > ul {
	background-color:transparent;
}
ul.dropdown li.seperator:hover {
	background-color:transparent;
	background-image:none;
}
ul.dropdown li.seperator_icon{
	background-color:transparent;
	margin:0px 0px 0px 0px;
	padding:0px;
	
}
ul.dropdown ul:last-child {
	<?=$top_sub_rounded_css;?>
	
}
div.richTextPopup {
	padding:0px;
	width:<?=$dynamicWidth;?>px;
	min-height:50px;
	position:absolute;
	margin-top:35px;
	z-index:890;
	background-color:#<?=$SITE[submenuhovebgcolor];?>;
	<?if ($SITE[dropdownmenubgpic]) {
		?>
		background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[dropdownmenubgpic];?>');
		<?
	}
	?>
	visibility:hidden;
	color:#<?=$SITE[topmenutextcolor];?>;
	transition:all 0.3s;
	opacity:0;
}
div.richTextPopup.show {
	visibility:visible;
	
	opacity:1;
}
div.richTextPopup div {
	text-align:<?=$SITE[align];?>;
	padding:7px;
	color:#<?=$SITE[topmenutextcolor];?>;
}
.footerWide {
	min-height:20px;
	width:100%;
	background:#<?=$SITE[footerbgcolor];?>;
	margin-top:0px;
	
}
.footerTopColor {
	background:#<?=$SITE[topfooterbgcolor];?>;
	margin:0px;
	padding:0px;
}
.footer {
	min-height:20px;
	width:<?=$dynamicWidth;?>px;
	background:#<?=$SITE[footerbgcolor];?>;
	margin-top:0px;
	text-align:center;
	
}
.footerFull {
	width:100%;
	background:#<?=$SITE[footerbgcolor];?>;
	padding:0;
	margin:0;
}
.footerFullText {
	width:100%;
	background:silver;
	padding:0;
	margin:0;
}
.footerText{
	text-align:<?=$SITE[align];?>;
	padding:0px 0px 0px 20px;
	text-decoration:none;
	padding-<?=$SITE[align];?>:10px;
	width:<?=($dynamicWidthPadding-10);?>px;
	color:#<?=$SITE[contenttextcolor];?>;
	overflow:hidden;
	font-size:<?=$SITE[contenttextsize];?>px;
}
.footerText  a {
	text-decoration:<?=$links_style;?>;
	color:#<?=$SITE[linkscolor];?>;
}
.rightSide {
	float:<?=$SITE[align];?>;
	width:250px;
	min-height:200px;
	text-align:<?=$SITE[align];?>;
	
}
.rightSideSeperated {
	min-height:160px;
	width:250px;
	background:#<?=$SITE[sidebgcolor];?>;
	text-align:<?=$SITE[align];?>;
	padding-top:10px;
	<?
	if ($SITE[contentbgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[contentbgpic];?>');
		<?
	}?>
	
}
.sideCatTitle h2, .sideCatTitle h1, .sideCatTitle>div{
	font-size:<?=$SITE[titlesfontsize];?>px;
	font-weight:<?=$SITE[titlesbold];?>;
	color:#<?=$SITE[titlescolor];?>;
	text-align:<?=$SITE[align];?>;
	padding-<?=$SITE[align];?>:13px;
	padding-top:0px;
	margin-top:0px;
	font-family:<?=$SITE[csstitlesfont];?>;
	
}
.breadCrumb{
	direction:<?=$SITE_LANG[direction];?>;
	color:#<?=$SITE[titlescolor];?>;
	text-align:<?=$SITE[align];?>;
	padding-<?=$SITE[align];?>:10px;
}
.leftSide {
	float:<?=$SITE[align];?>;
	width:<?=($dynamicWidth-255);?>px;
	text-align:<?=$SITE[align];?>;
	min-height:160px;
	margin-<?=$SITE[align];?>:5px;
}
.widePage {
	text-align:<?=$SITE[align];?>;
	min-height:10px;
	margin-<?=$SITE[align];?>:3px;
	margin-top:1px;
}
.contentOuter {
	border-<?=$SITE[align];?>:1px solid #<?=$SITE[seperatorcolor];?>;
	padding-<?=$SITE[align];?>:5px;
	margin-top:10px;
	padding-top:0px;
	min-height:100px;
	
}
.leftColumn {
	float:<?=$SITE[opalign];?>;
	width:220px;
	min-height:100px;
	margin-top:0px;
	padding-<?=$SITE[align];?>:6px;
	
}
#leftColumnContent {
	padding-top:0px;
	padding-<?=$SITE[align];?>:5px;
	padding-<?=$SITE[opalign];?>:5px;
	background-color:#<?=$SITE[leftcolbgcolor];?>;
	
}
.leftColumn_border {
	<?=$leftColBorderCSS;?>;
	margin-<?=$SITE[opalign];?>:7px;
	padding:0px;

}
.leftColumn_right {
	float:<?=$SITE[align];?>;
	padding:0;
	margin:0;
	width:440px;
	

}
.mainContentText {
	text-align:<?=$SITE[align];?>;
	font-size:<?=$SITE[contenttextsize];?>px;
	color:#<?=$SITE[contenttextcolor];?>;
	padding-<?=$SITE[align];?>:0px;
	overflow:hidden;
	padding-<?=$SITE[opalign];?>:5px;
}
.mainContentText h1,.mainContentText h2,.mainContentText h3 {
	margin:auto
}
.galleryText {
	padding-<?=$SITE[opalign];?>:12px;
	overflow:hidden;
	width:98%;
}
.gallerySideText,.galleryMiddleText {
	text-align:<?=$SITE[align];?>;
	font-size:<?=$SITE[contenttextsize];?>px;
	color:#<?=$SITE[contenttextcolor];?>;
	padding-<?=$SITE[align];?>:0px;
	
}
.galleryMiddleText {
	margin-<?=$SITE[opalign];?>:15px;
	padding-<?=$SITE[align];?>:10px;
}
.mainContentText a, .middleContentText a,.NewsItem a, .gallerySideText a, .galleryMiddleText a, .topMainPicSideText a, .topHeaderSlogen a,  #galContent a{
	text-decoration:<?=$links_style;?>;
	color:#<?=$SITE[linkscolor];?>;
}
.mainContentText a img, .NewsItem a img, .middleContentText a img,  .galleryMiddleText a img, .topMainPicSideText a img, .topHeaderSlogen a img, .footerText a img {border:0px}

.titleContent h2,.titleContent h1,.titleContent h3,.titleContent a,.titleContent input {
	font-size:<?=$SITE[titlesfontsize];?>px;
	font-weight:<?=$SITE[titlesbold];?>;
	font-family:<?=$SITE[csstitlesfont];?>;
	line-height:normal;
	color:#<?=$SITE[titlescolor];?>;
	text-decoration:none;
	padding-<?=$SITE[align];?>:0px;
	padding-bottom:0px;
	margin:0px;
	display:inline-block;
}
.titleContent_top h2,.titleContent_top h1 {
	min-height:20px;
	padding-<?=$SITE[align];?>:6px;
	color:#<?=$SITE[titlescolor];?>;
	margin:0px;
	font-size:<?=$SITE[titlesfontsize];?>px;
	font-weight:<?=$SITE[titlesbold];?>;
	line-height:normal;
	padding-bottom:2px;
	font-family:<?=$SITE[csstitlesfont];?>;
	
}
.shortContentTitle {
	color:#<?=$SITE[titlescolor];?>;
	font-weight:<?=$SITE[titlesbold];?>;
	padding-<?=$SITE[align];?>:9px;
	font-size:<?=$SITE[brieftitlesfontsize];?>px;
	font-family:<?=$SITE[csstitlesfont];?>;
}
.shortContentTitle a{
	color:#<?=$SITE[titlescolor];?>;
	text-decoration:none;
}
h2.shortContentTitle, .shortContentTitle h1 {
	padding:0px;margin:0px;font-size:<?=$SITE[brieftitlesfontsize];?>px;
	font-weight:<?=$SITE[titlesbold];?>;
}
.SideMenu li {
	list-style:none;
	margin:0px 0px 3px 0px;
	color:#<?=$SITE[submenutextcolor];?>;
	
	
}
.ls-l div span, .ls-l span{line-height:1.2}

.top_bg_sidemenu {
	<?
	if ($SITE[submenubgphoto]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[submenubgphoto];?>');
		<?
	}?>
	background-position:<?=$SITE[align];?> top;
	background-repeat:no-repeat;
	width:220px;
	height:6px;
	padding:0px;
	margin:0px;
	line-height:normal;
}

.middle_bg_sidemenu {
	<?
	if ($SITE[submenubgphoto]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[submenubgphoto];?>');
		<?
	}?>
	background-position:0px 50%;
	background-repeat:repeat-y;
	width:214px;
	padding:0px 3px 2px 3px;
	margin:0px;
	
}
.bottom_bg_sidemenu {
	<?
	if ($SITE[submenubgphoto]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[submenubgphoto];?>');
		<?
	}?>
	background-position:right bottom;
	background-repeat:no-repeat;
	width:220px;
	height:6px;
	margin-bottom:1px;
}
.top_bg_sub_sidemenu {
	<?
	if ($SITE[subsubmenubgphoto]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[subsubmenubgphoto];?>');
		<?
	}?>
	background-position:<?=$SITE[align];?> top;
	background-repeat:no-repeat;
	width:220px;
	height:3px;
	padding:0px;
	margin:0px;
	line-height:normal;
}

.middle_bg_sub_sidemenu {
	<?
	if ($SITE[subsubmenubgphoto]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[subsubmenubgphoto];?>');
		<?
	}?>
	background-position:0px 50%;
	background-repeat:repeat-y;
	width:214px;
	padding:0px 3px 2px 3px;
	margin:0px;
	
}
.bottom_bg_sub_sidemenu {
	<?
	if ($SITE[subsubmenubgphoto]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[subsubmenubgphoto];?>');
		<?
	}?>

	background-position:right bottom;
	background-repeat:no-repeat;
	width:220px;
	height:3px;
	margin-bottom:1px;
}
.sub_menu_selected_bg {
	<?
	if ($SITE[submenuselectedbgphoto]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[submenuselectedbgphoto];?>');
		<?
	}?>
}
.SideMenu ul {
	margin-top:4px;
	list-style:none;	
	list-type:none;	
	
}
.SideMenu {
	text-align:<?=$SITE[align];?>;
	margin-top:5px;
	margin-<?=$SITE[align];?>:0px;
	padding-<?=$SITE[align];?>:15px;
}
.iconPlaceHolder {
	min-width:18px;
	height:20px;
	padding-bottom:0px;
	margin-top:0px;
	float:<?=$SITE[align];?>;
	
}
.rightMenuItem a{
	text-decoration:none;
	color:#<?=$SITE[submenutextcolor];?>;
	font-weight:<?=$sideMenuStyle;?>;
	font-size:<?=$SITE[submenufontsize];?>px;
	font-family:<?=$SITE[cssmenusfont];?>;
}
.rightMenuItem a:hover {
	color:#<?=$SITE[submenumouseovercolor];?>;
}
.rightMenuItem_selected a{
	text-decoration:none;
	color:#<?=$SITE[submenuhovercolor];?>;
	font-weight:bold;
	font-size:<?=$SITE[submenufontsize];?>px;
}
.rightMenuItem_selected {
	color:#<?=$SITE[submenuhovercolor];?>;
	font-weight:bold;
	font-family:<?=$SITE[cssmenusfont];?>;
}

.rightMenuItem a:visited{
	text-decoration:none;
	
}
.rightMenuSubSubItem a {
	color:#<?=$SITE[subsubmenucolor];?>;
	
}
<?if ($SITE[subsubmenufontsize]) {
	?>
	label.rightMenuItem#subsubMenu a{
		font-size:<?=$SITE[subsubmenufontsize];?>px;
		}
	<?
	}
	?>
}
.rightMenuSubSubItem_selected, .rightMenuSubSubItem_selected a, .rightMenuSubSubItem a:hover {
	color:#<?=$SITE[subsubmenuselectedcolor];?>;
}
.vertical_seperator {
	background-image:url('<?=SITE_MEDIA;?>/images/background.png');
	background-repeat: repeat-y;
	width:2px;
	min-height:200px;
	float:<?=$SITE[align];?>;
	margin:0px 10px 0px 10px;
	
}
.NewsBox {
	overflow: none;
	padding-<?=$SITE[align];?>:3px;
	padding-<?=$SITE[opalign];?>:3px;
	
	text-align:<?=$SITE[align];?>;
	margin-<?=$SITE[align];?>:7px;
	<?
	if ($SITE[newsbordercolor] OR $SITE[newsbgcolor]) {
		?>
		margin-<?=$SITE[align];?>:12px;
		<?
	}
	
	if ($SITE[newsbordercolor]) {
		?>
		border:1px solid #<?=$SITE[newsbordercolor];?>;
		<?
	}
	if ($SITE[newsbgcolor]) {
		?>
		background:#<?=$SITE[newsbgcolor];?>;
		<?
	}
	if ($SITE[roundcorners]) {
		?>
		border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;
		-moz-border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;";
		<?
	}
		?>
}
#NewsBoxContainer {
	list-type:none;
	padding:0px;
	margin:0px;
	
}

.NewsItem,NewsItem a:visited {
	color:#<?=$SITE[contenttextcolor];?>;
	text-decoration:none;
	padding-bottom:10px;
	font-size:<?=$SITE[contenttextsize];?>px;
	list-type:none;
	list-style:none;
	overflow: hidden;
}

.NewsSeperator {
	border-bottom:1px dotted #<?=$SITE[seperatorcolor];?>;
}

#marqueecontainer{
	padding-<?=$SITE[opalign];?>:2px;
}

.shadow_layer {
	<?
	if ($SITE[middleshadow]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[middleshadow];?>');
		<?
	}?>
	background-repeat:no-repeat;
	background-position:top;
		
}
.searchFormTop{
	width:<?=$SITE[searchformwidth];?>px;
	float:<?=$SITE[opalign];?>;
	margin-top:0;
}
.topLangSelector select {
	font-size:12px;
	padding:1px;
	height:21px;
	font-family:<?=$SITE[cssfont];?>;
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	border:1px solid silver;
	margin-top:10px;
	margin-<?=$SITE[opalign];?>:5px;
}
.topLangSelector {
	width:98px;
	float:<?=$SITE[opalign];?>;
	margin-top:15px;
}
.lang_selector {
	text-align:<?=$SITE[opalign];?>;
	width:80px;
} 
.photoHolder {
	<?
	if ($SITE[gallerybgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[gallerybgpic];?>');
		<?
	}
	?>
	background-repeat:no-repeat;
	width:<?=$SITE[galleryphotowidth];?>px;
	height:<?=$SITE[galleryphotoheight];?>px;
	padding:6px 6px 6px 6px;
	text-align:center;
	display:block;
	
}

.photoWrapper {
	width:<?=$SITE[galleryphotowidth];?>px;
	height:<?=$SITE[galleryphotoheight]-0.6;?>px;
	background:<?=$SITE[photowrapperbg];?>;
	padding:0px 0px 0px 0px;
	vertical-align:middle;
	margin:0px 0px 0px 0px;
	text-align:center;
	display:table-cell;
	
}


.photoWrapper img {
	padding:0px;
	border:0px;
}
.videoHolder {
	<?
	if ($SITE[gallerybgpic]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[gallerybgpic];?>');
		<?
	}?>
	background-repeat:no-repeat;
	width:178px;
	height:136px;
	padding:8px;
	
}
.footer_bg {
	//float:left;
	<?=$height_css;?>:<?=$SITE[footerlayerbgheight];?>px;
	width:100%;
	<?
	if ($SITE[footerbglayer]) {
		?>
		background:transparent url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[footerbglayer];?>') no-repeat scroll;
		<?
	}?>
	
	background-position:center bottom;
}
.site_overbg {
	min-height:<?=$SITE[siteoverlayheight];?>px;
	max-height:500px;
	position:absolute;
	top:0px;
	left:0;
	width:100%;
	<?
	if ($SITE[siteoverlaypic]) {
		?>
		background: url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[siteoverlaypic];?>') no-repeat scroll 50% 0 transparent;
		<?
		if ($SITE[mainpicwidth]==2000) {
			?>
			top:0px !important;
			min-height:auto;height:100%;
			background-size:contain;
			background-position:center;
			<?
		}
	}
	
	?>
	
	z-index:100;
}
<?
if ($SITE[siteoverlaypic] AND $SITE[mainpicwidth]==2000) {
	?>
	.topHeaderMain {position:relative}
	<?
}	
?>
.galleria-thumbnails .galleria-image, .pagination li a, #pix_pag_ul > li > span {
	background-color:#<?=$SITE[slidericoncolor];?>; 
}
#pix_pag_ul > li.diapocurrent > span > span {background-color:#efefef;}
.slides_container #galContent, .pix_diapo #galContent {
	text-align:<?=$SITE[align];?>;
	direction:<?=$SITE_LANG[direction];?>;
	font-size:<?=$SITE[contenttextsize];?>px;
	color:#<?=$SITE[contenttextcolor];?>;
	
}
.pix_diapo .captionRich {
	<?=$SITE[align];?>:0px;
}
.nivo-caption p {
	direction:<?=$SITE_LANG[direction];?>;
}
.titlesIcon {
	margin-<?=$SITE[align];?>:20px;
	margin-<?=$SITE[opalign];?>:5px;
	float:<?=$SITE[align];?>;
	padding:0px;
	
}
.titlesIcon img{
	vertical-align:middle;
	
}
.facebook_like_box {
	<?
	if ($SITE[fb_likebox_bg_photo]) {
		?>
		background: url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[fb_likebox_bg_photo];?>') no-repeat;
		<?
	}?>
	
}
#toTop {
	display:none;
	text-decoration:none;
	position:fixed;
	bottom:10px;
	<?if ($SITE[upnavigateicon]) print 'bottom:0px;';?>
	right:10px;
	overflow:hidden;
	width:80px;
	height:51px;
	border:none;
	text-indent:-999px;

	background:url('<?=$upNavigateIconUrl;?>') no-repeat left bottom;
	z-index:1900;
	opacity:<?=($SITE[upnavopacity]/100);?>
}

#toTopHover {
	background:url('<?=$upNavigateIconUrl;?>') no-repeat left bottom;
	width:80px;
	height:51px;
	display:block;
	overflow:hidden;
	float:left;
	opacity: 0;
	-moz-opacity: 0;
	filter:alpha(opacity=0);
}

#toTop:active, #toTop:focus {
	outline:none;
}
.CenterBoxWrapper {
        width:500px;
        min-height: 150px;
        background-color:#e9f1fd;
        padding:0px;
        position:absolute;
        right: 0;
        left: 0;
        top:20%;
        margin:0 auto;
        -moz-border-radius: 5px;
		-webkit-border-radius: 5px;
	        border-radius: 5px;
		-webkit-box-shadow:0px 0px 40px #111111;
	        box-shadow:0px 0px 40px #111111;
		direction:<?=$SITE_LANG[direction];?>;
		transition:all 0.5s;
		-webkit-transition:all 0.5s;
		
}
.CenterBoxWrapper.show {
	display:block;
}
.CenterBoxContent {
	background-color: #e9f1fd;
	height: 100%;
        color: black;
        outline: none;
	padding:15px 8px 15px 8px;
	border-radius:inherit;
}
.ui-datepicker.ui-widget.ui-widget-content {font-size:12px !important;;}
.left2right {
	direction:ltr;
	text-align:left;
}
.right2left {
	direction:rtl;
	text-align:right;
}
.mainContentText .english {font-family:arial}
.photoGalley_filter {
	float:<?=$SITE[align];?>;
	margin:10px 0px 10px 0px;
	cursor:pointer;
	

}

.photoGalley_filter div {
	padding:5px;

}
.photoGalley_filter div a {text-decoration:none}
.photoGalleryFiltersWrapper {
	padding:0px;
	display:block;
	border:0px;
	width:96.5%;
	margin-<?=$SITE[align];?>:8px;
	margin-top:5px;
	
}

.masterFooter_wrapper {
	width:100%;
	min-height:30px;
	position:fixed;
	bottom:0px;
	opacity:<?=($SITE[footermasteropacty]/100);?>;
	z-index:801;
	<?if ($SITE[footermasterbgpic]) {
		?>
		background: url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[footermasterbgpic];?>') repeat-x;
		background-position:center bottom;
		<?
	}
	?>
	<?if ($SITE[footermasterbgcolor]) {
		?>
		background-color:#<?=$SITE[footermasterbgcolor];?>;
		<?
	}
	?>
	
}

.masterHeader_wrapper {
	!opacity:<?//=($SITE[headermasteropacty]/100);?>;
	z-index:801;
	top:0;
	width:100%;
	min-height:30px;
	position:fixed;
	<?if ($SITE[headermasterbgpic]) {
		?>
		background: url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[headermasterbgpic];?>') repeat-x;
		background-position:center top;
		<?
		if ($SITE[masterheaderheight]>0) {
			?>
			height:<?=$SITE[masterheaderheight];?>px;
			<?
		}
	}
	?>
	<?if ($SITE[headermasterbgcolor]) {
		?>
		background:<?=hex2rgba('#'.$SITE[headermasterbgcolor],($SITE[headermasteropacty]/100));?>;
		<?
	}
	?>
	
}
.masterFooter_inner, .masterHeader_inner {
	text-align:<?=$SITE[align];?>;
	width:<?=$dynamicWidthPadding;?>px;
	padding:5px 10px 0px 10px;
	opaciy:1;
	direction:<?=$SITE_LANG[direction];?>;
}

.masterHeader_innerTopMenu {
	width:<?=$dynamicWidth;?>px;
	text-align:<?=$SITE[align];?>;
	direction:<?=$SITE_LANG[direction];?>;
}
.masterHeader_inner_bottom_menu {
	width:<?=$dynamicWidthPadding;?>px;
	text-align:<?=$SITE[align];?>;
	direction:<?=$SITE_LANG[direction];?>;
}

.gallery_zoom_hover {
	width:78px;
	height:80px;
	position:absolute;
	top:-85px;
	left:50%;
	margin-left:-44px;
	background: url('<?=SITE_MEDIA;?>/images/zoom_gallery.png') no-repeat;
	z-index:30;
}
.fixed_footer .inner div.icon#shopping_cart .cart_count {position:absolute;border-radius:100%;border:1px solid white;background:red;font-size:19px;color:white;width:25px;height:25px;top:-7px;line-height:29px;}
table.tables, table.tables tr td {border:1px solid;border-collapse: collapse;}
.isotope-item {z-index:100}
.isotope-hidden {z-index:0}
#lightbox-image-details {direction:<?=$SITE_LANG[direction];?>}
.exite_opacity_over {opacity:0.8}
.exite_opacity_over:hover {opacity:1}
.exite_button_shadow_over:hover {box-shadow: 0 0 3px rgba(0, 0, 0, .2);-webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .2);}
.fixed_footer {
	display:none;
}
.text_logo_insite{font-size:36px;margin-left:20px;margin-right:5px;text-decoration:none;height:<?=$SITE[logoheight];?>px;line-height:<?=$SITE[logoheight];?>px}
.topHeaderLogo a{color:#<?=$SITE[contenttextcolor];?>}
.dl-menuwrapper {display:none;}
.mainContentText \ly, .mainContentText .mobileonly, .middleContentText .mobileonly, .footerText .mobileonly {display: none}
.spinner {width:80px;position: relative;margin:0 auto;z-index:30000;}
.spinner >div {-webkit-animation-fill-mode:both;width:20px;height: 20px;background-color: #333;border-radius: 100%;display: inline-block;-webkit-animation:bouncedelay 1.2s infinite ease-in-out;animation:bouncedelay 1.2s infinite ease-in-out;} 
.spinner .bo1{animation-delay:-0.32s;-webkit-animation-delay:-0.32s;}
.spinner .bo2{animation-delay:-0.16s;-webkit-animation-delay:-0.16s;}
@-webkit-keyframes bouncedelay{0%,100%,80%{-webkit-transform:scale(0)}40%{-webkit-transform:scale(1)}}@keyframes bouncedelay{0%,100%,80%{transform:scale(0);-webkit-transform:scale(0)}40%{transform:scale(1);-webkit-transform:scale(1)}}
