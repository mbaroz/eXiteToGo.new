<?
$sideMenuStyle="normal";
$main_pic_width_mode="98%";
$height_css="min-height";
$solganDivHeight="";
$solganDivWidth="min-width:40%;";
$topMenuTopHeaderWidth="72%";
$middleTextPadding=10;
$dynamicWidth=950;

if ($SITE[sitewidth]>950) $dynamicWidth=$SITE[sitewidth];
$dynamicWidthPadding=$dynamicWidth-20;
$dynamicWidthForTopMenu=$dynamicWidth-10;

$SITE[photosnavlabel]="Photo";
if ($default_lang=="he") $SITE[photosnavlabel]="תמונה";
if ($SITE[underlinelinks]==1) $links_style="underline";
if ($SITE[logoheight]==0) $SITE[logoheight]=30;
if ($SITE[logoheight]>2 AND $SITE[searchformtop]!=1) $solganDivHeight="height:".($SITE[logoheight]-15)."px;";
if ($SITE[logowidth]>2) $solganDivWidth="width:".($dynamicWidthForTopMenu-$SITE[logowidth])."px;";
if ($SITE[topmenubottom]==4) $solganDivWidth="width:".$dynamicWidthPadding."px;";
if ($SITE[logowidth]>0) $topMenuTopHeaderWidth=($dynamicWidthForTopMenu-$SITE[logowidth])."px";
if (isset($_SESSION['LOGGED_ADMIN'])) $topMenuTopHeaderWidth=($dynamicWidthForTopMenu-$SITE[logowidth])."px";
if ($SITE[contentfootermargin]=="") $SITE[contentfootermargin]=8;
if ($SITE[staticfooterheight]==1) $height_css="height";
if ($SITE[bgcolor]=="") $SITE[bgcolor]="ffffff";
if ($SITE[topmenusidemargin]=="" OR (ieversion()<8 AND ieversion()>0 AND $SITE[topmenuitembgpic])) $SITE[topmenusidemargin]=8;

if ($SITE[searchformwidth]=="") $SITE[searchformwidth]=200;
if ($SITE[searchformwidth]>230 AND $SITE[searchformtop]==3) $SITE[searchformwidth]=225;

if ($SITE[mainpicwidth]=="") $SITE[mainpicwidth]="930";
if ($SITE[mainpicwidth]=="930") $SITE[mainpicwidth]="934";

$CHECK_MAINPIC_WIDTH_MODE=CheckCatMainPicWidthParent($CHECK_CATPAGE[parentID]);

if ($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==2000) $SITE[mainpicwidth]=2000;
if ($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==950) $SITE[mainpicwidth]=950;

if ($SITE[sitewidth]>950) {
	$dynamicWidth=$SITE[sitewidth];
	$dynamicWidthPadding=$SITE[sitewidth]-20;
	if ($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==950) $SITE[mainpicwidth]=$dynamicWidth;
	if (($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==930 OR $CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]=="") AND $SITE[mainpicwidth]!=2000) $SITE[mainpicwidth]=$dynamicWidthPadding;
	if ($SITE[mainpicwidth]==$dynamicWidthPadding AND $SITE[middlebgcolor]=="") $SITE[mainpicwidth]=$dynamicWidth;
	$topHeaderMainWidth=$dynamicWidth."px";
}


if ($SITE[mainpicwidth]=="950" OR $SITE[mainpicwidth]==2000 OR $SITE[sitewidth]>950) {
	$main_pic_width_mode="100%";
	$middleTextPadding=0;
	
}
if ($CHECK_MAINPIC_WIDTH_MODE[MainPicWidthMode]==2000) $SITE[mainpicwidth]=2000;


$mainpictopmargin_defaultdiv=0;
if ($SITE[mainpictopmargin]=="") {
	$SITE[mainpictopmargin]=4;
	$mainpictopmargin_defaultdiv=4;
	if (!$SITE[roundcorners]) $mainpictopmargin_defaultdiv=8;
}
$mainpic_padding=8;
if ($SITE[roundcorners]) $mainpic_padding=4;
if ($SITE[galleryphotoheight]=="") $SITE[galleryphotoheight]=120;
if ($SITE[galleryphotowidth]=="") $SITE[galleryphotowidth]=164;
if ($SITE[topmenutextcolor]=="") $SITE[topmenutextcolor]="000000";
if ($SITE[submenutextcolor]=="") $SITE[submenutextcolor]="000000";
//if ($SITE[slidericoncolor]=="") $SITE[slidericoncolor]="ffffff";
if ($SITE[topmenumargin]=="" AND !$SITE[topmenubottom]==1) $SITE[topmenumargin]="0";
if ($SITE[topmenumargin]=="" AND ($SITE[topmenubottom]==2 OR $SITE[topmenubottom]==4)) $SITE[topmenumargin]="8";
if ($SITE[contenttopmargin]=="") $SITE[contenttopmargin]="8";
$top_content_margin="6";
if ($SITE[sidemenubold]==1) $sideMenuStyle="bold";
if ($SITE[topmenuhovercolor]=="") $SITE[topmenuhovercolor]=$SITE[submenutextcolor];
if ($SITE[submenuhovercolor]=="") $SITE[submenuhovercolor]=$SITE[topmenuhovercolor];
if ($SITE[submenumouseovercolor]=="") $SITE[submenumouseovercolor]=$SITE[submenuhovercolor];

if ($SITE[titlescolor]=="") $SITE[titlescolor]="000000";
if ($SITE[titlesbold]==1) $SITE[titlesbold]="bold";
	else $SITE[titlesbold]="normal";

if ($SITE[slogentextcolor]=="") $SITE[slogentextcolor]="000000";
if ($SITE[contenttextcolor]=="") $SITE[contenttextcolor]="333333";
if ($SITE[contenttextsize]=="") $SITE[contenttextsize]="13";
if ($SITE[menutextsize]=="") $SITE[menutextsize]="13";
if ($SITE[submenufontsize]=="") $SITE[submenufontsize]="13";
if ($SITE[footerlayerbgheight]=="") $SITE[footerlayerbgheight]=0;
if ($SITE[thumbsbordercolor]=="") $SITE[thumbsbordercolor]=$SITE[contenttextcolor];
if($SITE[photowrapperbg]=="") $SITE[photowrapperbg]="transparent";
	else $SITE[photowrapperbg]="#".$SITE[photowrapperbg];

if ($urlKey=="home") $SITE[topbglayer]=$SITE[topbglayer];
elseif ($SITE[topbglayerpages]) $SITE[topbglayer]=$SITE[topbglayerpages];

if ($CHECK_PAGE[parentID]) {
		if ($CHECK_PAGE[ProductID]) {
			$C_URLKEY=GetUrlKeyFromID($CHECK_PAGE[parentID]);
			$tmpUrlKey=$C_URLKEY[UrlKey];
		}
		else $tmpUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
		$SITE[pageheaderbg]=GetTopHeaderBG($tmpUrlKey);
		$db->query("SELECT HeaderBGPhotoName from categories WHERE UrlKey='$tmpUrlKey' AND HeaderBGPhotoName!=''");
		if ($db->nextRecord()) $SITE[pageheaderbg]=$db->getField("HeaderBGPhotoName");
}

if ($SITE[pageheaderbg]) $SITE[topbglayer]=$SITE[pageheaderbg];
else { //check if parent cats have topheaderBG
	$headerBGPICParent=GetTopHeaderBG($urlKey);
	if ($headerBGPICParent) $SITE[topbglayer]=$headerBGPICParent;
}
if ($SITE[effectgallerybgcolor]=="") $SITE[effectgallerybgcolor]="000000";
if ($SITE[effectgallerytextcolor]=="") $SITE[effectgallerytextcolor]=$SITE[contenttextcolor];
if ($SITE[titlesfontsize]=="") $SITE[titlesfontsize]=18;
if ($SITE[brieftitlesfontsize]=="") $SITE[brieftitlesfontsize]=14;


if ($SITE[slogen]=="" AND isset($_SESSION['LOGGED_ADMIN'])) $SITE[slogen]=$ADMIN_TRANS['untitled'];
if ($SITE[pageverlaypic]) {
	$SITE[siteoverlaypic]=$SITE[pageverlaypic];
	$SITE[siteoverlayheight]=$SITE[pageoverlayheight];
}
$SITE[align]="left";
$SITE[opalign]="right";
if ($SITE_LANG[direction]=="") $SITE_LANG[direction]="rtl";

if ($SITE_LANG[direction]=="rtl") {
	$SITE[align]="right";
	$SITE[opalign]="left";
}
if ($SITE[leftmargintopmenu]=="") $SITE[leftmargintopmenu]=0;
//--------------------Per page parameters------------------------------------
if ($SITE[CatFontFace]) $SITE[fontface]=$SITE[CatFontFace];
//--------------------Per page parameters------------------------------------
if ($SITE[fontface]=="") $SITE[cssfont]="Arial";
else $SITE[cssfont]=$SITE[fontface].",  Arial";

if ($SITE[menusfont]=="") $SITE[cssmenusfont]="Arial";
else $SITE[cssmenusfont]=$SITE[menusfont].",  Arial";

if ($SITE[titlesfont]=="") $SITE[csstitlesfont]="Arial";
else $SITE[csstitlesfont]=$SITE[titlesfont].",  Arial";

$topMenuAlignCSS="";
if ($SITE[topmenuoposition]==1) $topMenuAlignCSS="float:".$SITE[opalign].";";
//--------------------Per page parameters------------------------------------
if ($SITE[CurrentPageContentBGColor]) $SITE[contentbgcolor]=$SITE[CurrentPageContentBGColor];
if ($SITE[CatSiteBGColor]) $SITE[bgcolor]=$SITE[CatSiteBGColor];
if ($SITE[CatSiteTextColor]) $SITE[contenttextcolor]=$SITE[CatSiteTextColor];
if ($SITE[CatSiteTitlesColor]) $SITE[titlescolor]=$SITE[CatSiteTitlesColor];
if ($SITE[CatContentTextSize]) $SITE[contenttextsize]=$SITE[CatContentTextSize];
if ($SITE[CatTitlesTextSize]) $SITE[titlesfontsize]=$SITE[CatTitlesTextSize];
if ($SITE[ThisPageContentBGPic]) $SITE[contentbgpic]=$SITE[ThisPageContentBGPic];
if ($SITE[mobilemenutextsize]=="") $SITE[mobilemenutextsize]=18;
//--------------------Per page parameters------------------------------------

$leftColBorderCSS="border:1px solid #".$SITE[leftcolbordercolor];
if ($SITE[roundcorners]) $leftColBorderCSS.="
;border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;
-moz-border-radius:6px 6px 6px 6px / 6px 6px 6px 6px";
//if ($SITE[leftcolbgcolor] AND $SITE[roundcorners]) $leftColBorderCSS="";
function hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}

?>