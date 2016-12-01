<?
$ExpireTime=360000;
header('Cache-Control: max-age=' . $ExpireTime); // must-revalidate
header('Expires: '.gmdate('D, d M Y H:i:s', time()+$ExpireTime).' GMT');
header("Content-Type:text/html; charset=utf-8");
?>
<?include_once("../config.inc.php");?>
<?include_once("../".$SITE_LANG[dir]."database.php");?>
<?include_once("../inc/GetServerData.inc.php");?>
<?include("colorpicker.php");?>
<?include("lang.admin.php");?>

<form id="styleseditor" name="styleseditor">
<?
$FONT_FACES=array("Arial","Verdana","Tahoma");
$W_FONTS=explode("|",$SITE[webfonts]);
$G_FONTS=explode("|",$SITE[googlewebfonts]);
$FONT_FACES=array_merge($FONT_FACES,$W_FONTS,$G_FONTS);
$selected_font=$SITE[fontface];

$menus_selected_font=$SITE[menusfont];
$titles_selected_font=$SITE[titlesfont];
$user_style_view=$slideout_user_style_view=$mobile_user_style_view="none";
if ($MEMBER[UserType]==0) $user_style_view=$slideout_user_style_view="";
if ($MEMBER[UserType]==0 AND ($MEMBER[Email]=="ofir@gafko.co.il" OR $MEMBER[Email]=="mbaroz@gmail.com"))  $mobile_user_style_view="";
if ($SITE[mobileEnabled]) $mobile_user_style_view="";
if (!$SITE[slidoutcontentenable]==1) $slideout_user_style_view="none";

if ($SITE[mainpicwidth]=="") $SITE[mainpicwidth]="930";
if ($SITE[breadcrumblevel]=="") $SITE[breadcrumblevel]=3;

$roundcorners_checkbox=$topmenu_oposition_checkbox="";
$links_underline="";
$bold_titles="";
$mainpic_sidetext_global="";
$mainpic_sidetext_currentpage="";
$hide_top_menu_here=$isMobileHomepage=$isMobileBackgroundsRemoved="";
$subtopmenuhover_checkbox="";
$staticfooterheight_checkbox=$topmenuunderlogo_checkbox="";
$show_top_nav_icon=$show_slideoutcontent_opened=$slideoutcontent_roundcorners="";
$topmenu_location_selected=$searchform_selected=$mainpicwidthmode_selected=$selected_fb_comments=$selected_breadcrumb_level=$selected_defaultpagestyle=$page_mainPicWidthMode_selected=$maingallery_behind_selected=$selected_showmasterheaderfooter=$selected_slideoutcontent_position=array();

$topmenu_location_selected[$SITE[topmenubottom]]="selected";
$mainpicwidthmode_selected[$SITE[mainpicwidth]]="selected";
$searchform_selected[$SITE[searchformtop]]="selected";
$selected_fb_comments[$SITE[fb_comments_theme]]="selected";
$selected_breadcrumb_level[$SITE[breadcrumblevel]]="selected";
$selected_defaultpagestyle[$SITE[defaultpagestyle]]="selected";
$maingallery_behind_selected[$SITE[maingallerybehind]]="selected";
$selected_showmasterheaderfooter[$SITE[showmasterheaderfooter]]="selected";
$selected_slideoutcontent_position[$SITE[slidoutcontentposition]]="selected";
$side_menu_bold="";
$CONF=GetConfigVars();
for ($a=0;$a<count($CONF[ConfigID]);$a++) {
 $V[$CONF[VarName][$a]]=$CONF[VarValue][$a];
}
if ($SITE[roundcorners]==1) $roundcorners_checkbox="checked";
if ($SITE[topmenuoposition]==1) $topmenu_oposition_checkbox="checked";
if ($SITE[globalsidetextmainpic]==1) $mainpic_sidetext_global="checked";
if ($SITE[subtopmenuhover]==1) $subtopmenuhover_checkbox="checked";
if ($SITE[topmenubottom]==1) $topmenu_under_photo_checkbox="checked";
if ($SITE[sidemenubold]==1) $side_menu_bold="checked";
if ($SITE[staticfooterheight]==1) $staticfooterheight_checkbox="checked";
if ($SITE[underlinelinks]==1) $links_underline="checked";
if ($SITE[titlesbold]==1) $bold_titles="checked";
if ($SITE[showtoupicon]==1) $show_top_nav_icon="checked";
if ($SITE[slideoutcontentopen]==1) $show_slideoutcontent_opened="checked";
if ($SITE[slidoutcontentroundcorners]==1) $slideoutcontent_roundcorners="checked";
if ($SITE[show_topbg_mobile]==1) $mobile_top_bg="checked";
if ($SITE[hide_all_bgs]==1) $isMobileBackgroundsRemoved="checked";
if ($SITE[topmenuunderlogo]==1) $topmenuunderlogo_checkbox="checked";
if ($V['SITE[mobilemenutextsize]']=="") $V['SITE[mobilemenutextsize]']=16;
$shop_title_bold = '';
$shop_desc_bold = '';
$shop_price_bold = '';
$shop_details_bold = '';
$shop_cart_bottom = '';
$shop_cart_hide = $shop_cart_hide_thispage= '';
$shop_cart_list_pic = '';
$shop_order_list_side = '';
if ($SITE[shopProductTitleBold]==1) $shop_title_bold="checked";
if ($SITE[shopProductShortDescBold]==1) $shop_desc_bold="checked";
if ($SITE[shopProductPriceBold]==1) $shop_price_bold="checked";
if ($SITE[shopProductDetailsBold]==1) $shop_details_bold="checked";
if ($SITE[shopCartBottom]==1) $shop_cart_bottom="checked";
if ($SITE[shopCartHide]==1) $shop_cart_hide="checked";
if ($SITE[shopOrderListSide]==1) $shop_order_list_side="checked";
if ($SITE[cartListViewPics] == 1) $shop_cart_list_pic="checked";

$META_DATA=GetMetaData($cID,1);
if ($META_DATA[MainPicSideText]==0) $META_DATA[MainPicSideText]=$_GET['isParentMainPicSideText'];
if ($META_DATA[MainPicSideText]==1 OR ($SITE[globalsidetextmainpic]==1 AND $META_DATA[MainPicSideText]==0)) $mainpic_sidetext_currentpage="checked";
if ($META_DATA[HideTopMenu]==1) $hide_top_menu_here="checked";
if ($SITE[MobileHomePage]) {
 $db=new database();
 $db->query("SELECT UrlKey from categories WHERE CatID='$cID'");
 $db->nextRecord();
 if ($SITE[MobileHomePage]==$db->getField("UrlKey")) $isMobileHomepage="checked";
}


$C_STYLING=json_decode($META_DATA[CatStylingOptions],true);
if (is_array($C_STYLING)) {
 foreach($C_STYLING AS $key=>$val) {
  $CAT_STYLE_VAL[$key]=$val;
 }
}
if ($CAT_STYLE_VAL[HideShopCart]==1) $shop_cart_hide_thispage="checked";
if ($CAT_STYLE_VAL[ShowShopCart]==1) $shop_cart_show_thispage="checked";

$page_mainPicWidthMode_selected[$CAT_STYLE_VAL[MainPicWidthMode]]="selected";
$cat_selected_font=$CAT_STYLE_VAL[CatFontFace];
$selected_def_effect=array();
$selected_def_effect[$SITE[defaulteffect]]="selected";
$ADMIN_TRANS['site width']="Site Width";
$ADMIN_TRANS['showmenuunderlogo']="Align Menu under logo";
$ADMIN_TRANS['edit_bg_photo']="Upload photo";
$ADMIN_TRANS['overlay backgrounds']="Overlays";
$ADMIN_TRANS['show_landingpage_logo']="Show logo";
$ADMIN_TRANS['show_maingallery_mobile']="Show Header Gallery on this page";
$ADMIN_TRANS['bottom_center']="Bottom Center";
$ADMIN_TRANS['reload_page']="Refresh changes";
if ($default_lang=="he") {
  $ADMIN_TRANS['site width']="רוחב האתר";
  $ADMIN_TRANS['showmenuunderlogo']="הצג תפריט עליון מתחת ללוגו";
  $ADMIN_TRANS['edit_bg_photo']="העלה תמונה";
  $ADMIN_TRANS['overlay backgrounds']="שכבות על";
  $ADMIN_TRANS['show_landingpage_logo']="הצג לוגו בעמוד נחיתה";
  $ADMIN_TRANS['show_maingallery_mobile']="הצג גלריה ראשית בעמוד זה";
  $ADMIN_TRANS['bottom_center']="מרכז תחתית האתר";
  $ADMIN_TRANS['reload_page']="רענן שינויים";
}
$SLIDEOUTICONPOS=array($ADMIN_TRANS['left'],$ADMIN_TRANS['right'],$ADMIN_TRANS['top'],$ADMIN_TRANS['bottom'],$ADMIN_TRANS['bottom_center']);
if ($SITE[ailgn]=="left") $SLIDEOUTICONPOS=array($ADMIN_TRANS['right'],$ADMIN_TRANS['left'],$ADMIN_TRANS['top'],$ADMIN_TRANS['bottom'],$ADMIN_TRANS['bottom_center']);
?>
  <style type="text/css">
  form#styleseditor table tbody td input[type='button'] {width:20px !important;float:<?=$SITE[opalign];?>}
  </style>
 <fieldset style="border-color:silver;border:1px solid silver;"><legend onclick="ShowLegend('bgs');" style="font-weight:bold;color:blue;cursor:pointer"><?=$ADMIN_TRANS['general site backgrounds'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="bgs" style="display:none;">
 <tr>
 <td valign="middle"><?=$ADMIN_TRANS['site background color'];?>: </td><td valign="middle"><?PickColor("SITE[bgcolor]",$V['SITE[bgcolor]']);?></td>
 <td valign="middle"><?=$ADMIN_TRANS['site background image'];?>:&nbsp;<input  type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[sitebgpic];?>');height:20px;width:40px;vertical-align:middle;margin:0px;vertical-align:middle"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('sitebgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 if (!$SITE[sitebgpic]=="") {
  ?>
  &nbsp;<a href="#" onclick="deleteSiteBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
 <td valign="middle"><?=$ADMIN_TRANS['top background layer'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[topbglayer];?>');height:20px;width:40px;vertical-align:middle;"></td><td valign="top"><a class="uploadertoolsbutton" onclick="showUploadTools('topbglayer',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 if (!$SITE[topbglayer]=="") {
  ?>
  &nbsp;<a href="#" onclick="deleteTopHeaderBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td>
 <td valign="middle"><?=$ADMIN_TRANS['bottom background layer'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[footerbglayer];?>');height:20px;width:40px;vertical-align:middle;"></td><td valign="top"><a class="uploadertoolsbutton" onclick="showUploadTools('footerbglayer',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 if (!$SITE[footerbglayer]=="") {
  ?>
  &nbsp;<a href="#" onclick="deleteFooterBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
 <td valign="middle"><?=$ADMIN_TRANS['top bg layer in pages'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[topbglayerpages];?>');height:20px;width:40px;vertical-align:middle;"></td><td valign="top"><a class="uploadertoolsbutton" onclick="showUploadTools('topbglayerpages',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 if (!$SITE[topbglayerpages]=="") {
  ?>
  &nbsp;<a href="#" onclick="deleteTopHeaderBgPicInside()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td>
 <td valign="middle"><?=$ADMIN_TRANS['middle image shadow'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[middleshadow];?>');height:20px;width:40px;vertical-align:middle;"></td><td valign="top"><a class="uploadertoolsbutton" onclick="showUploadTools('shadowpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 if (!$SITE[middleshadow]=="") {
  ?>
  &nbsp;<a href="#" onclick="deleteShadowBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
 <td><?=$ADMIN_TRANS['this page header bg'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$META_DATA[HeaderBGPhotoName];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('pageheaderbg',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 
 if (!$META_DATA[HeaderBGPhotoName]=="") {
  ?>
  &nbsp;<a href="#" onclick="deletePageHeaderBG()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td> 
 <td><?=$ADMIN_TRANS['footer bg static height'];?>: </td><td><input type="checkbox" id="SITE[staticfooterheight]" value=1 <?=$staticfooterheight_checkbox;?> /></td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
 <td valign="middle"><?=$ADMIN_TRANS['top header logo bg pic'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[headerlogobgpic];?>');height:20px;width:40px;vertical-align:middle;"></td><td valign="top"><a class="uploadertoolsbutton" onclick="showUploadTools('headerlogobgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 if (!$SITE[headerlogobgpic]=="") {
  ?>
  &nbsp;<a href="#" onclick="deleteTopHeaderLogoBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td>
 <td></td><td></td>
 </tr>
 
 
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 <!--Overlay simage -->
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('overlays');"><?=$ADMIN_TRANS['overlay backgrounds'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="overlays" style="display:none;">
 <tr>
 <td>
 <?=$ADMIN_TRANS['general overlay photo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[siteoverlaypic];?>');background-position:top;height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('siteoverlaypic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 if (!$SITE[siteoverlaypic]=="") {
  ?>
  &nbsp;<a href="#" onclick="deleteSiteOverlayPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td>
 <td><?=$ADMIN_TRANS['this page overlay photo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$META_DATA[OverlayPhotoName];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('pageoverlaypic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
 
 if (!$META_DATA[OverlayPhotoName]=="") {
  ?>
  &nbsp;<a href="#" onclick="deletePageOverlayPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
  <?
 }
  ?>
 </td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['show main gallery behind'];?>:</td>
  <td>
   <select id="SITE[maingallerybehind]" style="width:110px">
   <option value=0 <?=$maingallery_behind_selected[0];?>><?=$ADMIN_TRANS['not set'];?></option>
   <option value=1 <?=$maingallery_behind_selected[1];?>><?=$ADMIN_TRANS['only in homepage'];?></option>
   <option value=2 <?=$maingallery_behind_selected[2];?>><?=$ADMIN_TRANS['homepage and inner pages'];?></option>
   </select>
  </td>
   
 </tr>
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 <!--Menus -->
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('mnus');"><?=$ADMIN_TRANS['menus styling'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="mnus" style="display:none">
 <tr>
  <td><?=$ADMIN_TRANS['submenu font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[submenufontsize]" name="SITE[submenufontsize]" value="<?=$V['SITE[submenufontsize]'];?>" /></td>
  <td><?=$ADMIN_TRANS['menu font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[menutextsize]" name="SITE[menutextsize]" value="<?=$V['SITE[menutextsize]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['sub-sub menu font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[subsubmenufontsize]" name="SITE[subsubmenufontsize]" value="<?=$V['SITE[subsubmenufontsize]'];?>" /></td>
  <td style="width:160px;"><?=$ADMIN_TRANS['top menu background color'];?>: </td><td><?PickColor("SITE[topmenubgcolor]",$V['SITE[topmenubgcolor]']);?></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['top menu background image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[topmenubgpic];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('topmenubgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[topmenubgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteTopMenuBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['sub menu selected icon'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[submenuselectedicon];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('submenuselectedicon',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[submenuselectedicon]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('del_submenuselectedicon')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['submenu background image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[submenubgphoto];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('submenubgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[submenubgphoto]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteSubMenuBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['submenu icon image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[submenuicon];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('submenuicon',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[submenuicon]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteSubMenuIcon()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['top menu text color'];?>: </td><td><?PickColor("SITE[topmenutextcolor]",$V['SITE[topmenutextcolor]']);?></td>
  <td><?=$ADMIN_TRANS['sub menu text color'];?>: </td><td><?PickColor("SITE[submenutextcolor]",$V['SITE[submenutextcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['menu selected color'];?>: </td><td><?PickColor("SITE[topmenuhovercolor]",$V['SITE[topmenuhovercolor]']);?></td>
  <td><?=$ADMIN_TRANS['submenu selected color'];?>: </td><td><?PickColor("SITE[submenuhovercolor]",$V['SITE[submenuhovercolor]']);?></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['top menu location'];?>: </td><td>
   <select id="SITE[topmenubottom]" style="width:110px">
   <option value=0 <?=$topmenu_location_selected[0];?>><?=$ADMIN_TRANS['above main photo'];?></option>
   <option value=1 <?=$topmenu_location_selected[1];?>><?=$ADMIN_TRANS['below main photo'];?></option>
   <option value=2 <?=$topmenu_location_selected[2];?>><?=$ADMIN_TRANS['near logo'];?></option>
   <option value=3 <?=$topmenu_location_selected[3];?>><?=$ADMIN_TRANS['in master header'];?></option>
   <option value=4 <?=$topmenu_location_selected[4];?>><?=$ADMIN_TRANS['in master header with logo'];?></option>
   </select> 
  </td>
  <td><?=$ADMIN_TRANS['menus font'];?>: </td><td>
  <select id="SITE[menusfont]" style="width:100px" onchange="changeFontSample(this.options[this.selectedIndex].value);">
   <?
   for ($f=0;$f<count($FONT_FACES);$f++) {
    if ($FONT_FACES[$f]=="") continue;
    $selected_label="";
    $font_face=$FONT_FACES[$f];
    if (strtoupper($menus_selected_font)==strtoupper($font_face)) $selected_label="selected";
    ?>
    <option value="<?=$font_face;?>" <?=$selected_label;?>><?=$font_face;?></option>
    <?
   }
   ?>
  </select>
  </td>
 
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS[showmenuunderlogo];?></td><td><input type="checkbox" id="SITE[topmenuunderlogo]" value=1 <?=$topmenuunderlogo_checkbox;?> /></td>
  <td></td><td></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['submenu popup bg color'];?>: </td><td><?PickColor("SITE[submenuhovebgcolor]",$V['SITE[submenuhovebgcolor]']);?></td>
  <td><?=$ADMIN_TRANS['submenu seperators color'];?>: </td><td><?PickColor("SITE[submenuseperatorcolor]",$V['SITE[submenuseperatorcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['sub-sub menu color'];?>: </td><td><?PickColor("SITE[subsubmenucolor]",$V['SITE[subsubmenucolor]']);?></td>
  <td><?=$ADMIN_TRANS['sub-sub selected menu color'];?>: </td><td><?PickColor("SITE[subsubmenuselectedcolor]",$V['SITE[subsubmenuselectedcolor]']);?></td>
 </tr>
 <tr>
 <td><?=$ADMIN_TRANS['top menu item bg image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[topmenuitembgpic];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('topmenuitembgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[topmenuitembgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteTopMenuItemBG()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
 </td>
 <td style="width:170px;"><?=$ADMIN_TRANS['top menu selected item bg image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[topmenuselecteditembgpic];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('topmenuselecteditembgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[topmenuselecteditembgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteTopMenuSelectedItemBG()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
 </td>
 </tr>
 
 <tr>
  <td><?=$ADMIN_TRANS['sub-sub menu background image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[subsubmenubgphoto];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('subsubmenubgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[subsubmenubgphoto]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteSubSubMenuBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['topmenu seperator icon'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[topmenuseperatoricon];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('topmenuseperatoricon',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[topmenuseperatoricon]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteTopMenuSeperator()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['top menu item text color'];?>:<small><br>(Only if BG Pic exists)</small></td><td><?PickColor("SITE[topmenuitemcolor]",$V['SITE[topmenuitemcolor]']);?></td>
  <td><?=$ADMIN_TRANS['show submenu on mouse over topmenu'];?>: </td><td><input type="checkbox" id="SITE[subtopmenuhover]" value=1 <?=$subtopmenuhover_checkbox;?> /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['submenu selected bg image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[submenuselectedbgphoto];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('submenuselectedbgimage',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[submenuselectedbgphoto]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteSubMenuSelectedBG()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['align top menu right'];?>: </td><td><input type="checkbox" id="SITE[topmenuoposition]" value=1 <?=$topmenu_oposition_checkbox;?> /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['mouse over submenu color'];?>:</td><td><?PickColor("SITE[submenumouseovercolor]",$V['SITE[submenumouseovercolor]']);?></td>
  <td><?=$ADMIN_TRANS['popup menu font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[popupmenufontsize]" name="SITE[popupmenufontsize]" value="<?=$V['SITE[popupmenufontsize]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['drop-down submenu opacity'];?>: (%)</td><td><input maxlength="3" style="width:30px;height:15px;direction:ltr" id="SITE[submenudropdownopacity]" name="SITE[submenudropdownopacity]" value="<?=$V['SITE[submenudropdownopacity]'];?>" /></td>
  <td><?=$ADMIN_TRANS['popup menu bg photo'];?>: &nbsp;<input type="button" style="height:20px;width:20px;vertical-align:middle;border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[dropdownmenubgpic];?>');"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('dropdownmenubgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[dropdownmenubgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('delete_dropdownmenubgpic')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 <!--Galleries -->
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('glry');"><?=$ADMIN_TRANS['galleries styling'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="glry" style="display:none">
 
 <tr>
  <td><?=$ADMIN_TRANS['gallery background image'];?>: &nbsp;<input type="button" style="height:20px;width:20px;vertical-align:middle;border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[gallerybgpic];?>');"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('gallerybgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[gallerybgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteGalleryBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['gallery photo bg color'];?>: </td><td><?PickColor("SITE[photowrapperbg]",$V['SITE[photowrapperbg]']);?></td>
 </tr>
 <tr>
 <td><?=$ADMIN_TRANS['tumbnail size'];?>: (pixels)</td><td>
  W:<input maxlength="3" style="width:40px;height:15px;direction:ltr" id="SITE[galleryphotowidth]" name="SITE[galleryphotowidth]" value="<?=$V['SITE[galleryphotowidth]'];?>" />
  x <input maxlength="3" style="width:40px;height:15px;direction:ltr" id="SITE[galleryphotoheight]" name="SITE[galleryphotoheight]" value="<?=$V['SITE[galleryphotoheight]'];?>" />:H
 </td>
 <td><?=$ADMIN_TRANS['slide gallery bullets color'];?>: </td><td><?PickColor("SITE[slidericoncolor]",$V['SITE[slidericoncolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['text photo seperated line color'];?>: </td><td><?PickColor("SITE[gallerylinecolor]",$V['SITE[gallerylinecolor]']);?></td>
  <td><?=$ADMIN_TRANS['gallery side text bg color'];?>: </td><td><?PickColor("SITE[gallerysidetextbg]",$V['SITE[gallerysidetextbg]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['gallery thumbnails border color'];?>: </td><td><?PickColor("SITE[thumbsbordercolor]",$V['SITE[thumbsbordercolor]']);?></td>
  <td><?=$ADMIN_TRANS['product gallery width'];?>: (pixels)</td><td><input maxlength="3" style="width:40px;height:15px;direction:ltr" id="SITE[productgallerywidth]" name="SITE[productgallerywidth]" value="<?=$V['SITE[productgallerywidth]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['effect gallery text bg'];?>: </td><td><?PickColor("SITE[effectgallerybgcolor]",$V['SITE[effectgallerybgcolor]']);?></td>
  <td><?=$ADMIN_TRANS['effect gallery text color'];?></td><td><?PickColor("SITE[effectgallerytextcolor]",$V['SITE[effectgallerytextcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['effect gallery border'];?>: </td><td><?PickColor("SITE[effectgallerybordercolor]",$V['SITE[effectgallerybordercolor]']);?></td>
  <td><?=$ADMIN_TRANS['effect gallery bg color'];?>: </td><td><?PickColor("SITE[effectgallerybg]",$V['SITE[effectgallerybg]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['default effect'];?>: </td>
  <td>
   <select id="SITE[defaulteffect]" style="width:100px">
    <option value=0 <?=$selected_def_effect[0];?>>Slides</option>
    <option value=1 <?=$selected_def_effect[1];?>>Fade</option>
    <option value=2 <?=$selected_def_effect[2];?>>Flash</option>
    <option value=3 <?=$selected_def_effect[3];?>>Slide & Fade</option>
   </select>
   
  </td>
  <td><?=$ADMIN_TRANS['photos height in effect gallery'];?>: (px)</td><td><input maxlength="3" style="width:40px;height:15px;direction:ltr" id="SITE[effectgallerydefaultheight]" name="SITE[effectgallerydefaultheight]" value="<?=$V['SITE[effectgallerydefaultheight]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['3d effect bg color'];?>: </td><td><?PickColor("SITE[3deffectbgcolor]",$V['SITE[3deffectbgcolor]']);?></td>
  <td></td><td></td>
 </tr>
 </table>
 </fieldset>
 <br style="display:"/>
 <fieldset style="border-color:silver;border:1px solid silver;display:"><legend style="font-weight:bold;color:blue;cursor:pointer"  onclick="ShowLegend('areasbg');"><?=$ADMIN_TRANS['site areas background colors'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="areasbg" style="display:none">
 <tr>
  <td><?=$ADMIN_TRANS['header background color'];?>: </td><td><?PickColor("SITE[topheaderbg]",$V['SITE[topheaderbg]']);?></td>
  <td width="220"><?=$ADMIN_TRANS['middle image background color'];?>: </td><td><?PickColor("SITE[middlebgcolor]",$V['SITE[middlebgcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['content background color'];?>: </td><td><?PickColor("SITE[contentbgcolor]",$V['SITE[contentbgcolor]']);?></td>
  <td><?=$ADMIN_TRANS['footer background color'];?>: </td><td><?PickColor("SITE[footerbgcolor]",$V['SITE[footerbgcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['bottom image background color'];?>: </td><td><?PickColor("SITE[bottompicbgcolor]",$V['SITE[bottompicbgcolor]']);?></td>
  <td><?=$ADMIN_TRANS['side area bg color'];?>: </td><td><?PickColor("SITE[sidebgcolor]",$V['SITE[sidebgcolor]']);?></td>

 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['content area bgcolor this page'];?>: </td><td><?PickColor("CAT[CatContentBGColor]",$CAT_STYLE_VAL[CatContentBGColor],"setCatStyleProperty('$cID',this.value,'CatContentBGColor')",'onchange');?></td>
  <td><?=$ADMIN_TRANS['right column bg color'];?>: </td><td><?PickColor("SITE[leftcolbgcolor]",$V['SITE[leftcolbgcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['right column border'];?>: </td><td><?PickColor("SITE[leftcolbordercolor]",$V['SITE[leftcolbordercolor]']);?></td>
  <td><?=$ADMIN_TRANS['right column seperator color'];?>: </td><td><?PickColor("SITE[leftcolseperatorcolor]",$V['SITE[leftcolseperatorcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['content background photo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[contentbgpic];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('contentbgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[contentbgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteContentBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['top footer bg color'];?>: </td><td><?PickColor("SITE[topfooterbgcolor]",$V['SITE[topfooterbgcolor]']);?></td>
  
 </tr>
<tr>
 	<td><?=$ADMIN_TRANS['content background photo for this page'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$CAT_STYLE_VAL[ThisPageContentBGPic];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('ThisPageContentBGPic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
	 <?
	 
	 if (!$CAT_STYLE_VAL[ThisPageContentBGPic]=="") {
	  ?>
	  &nbsp;<a href="#" onclick="DeleteBGPhoto('DELThisPageContentBGPic')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
	  <?
	 }
	  ?>
	 </td>
</tr>
 <tr>
  <td style="width:170px;"><?=$ADMIN_TRANS['master footer bg photo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[footermasterbgpic];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('footermasterbgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[footermasterbgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('delete_footermasterbgpic')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['master footer bg color'];?>: </td><td><?PickColor("SITE[footermasterbgcolor]",$V['SITE[footermasterbgcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['master footer opacity'];?>: (%)</td><td><input maxlength="3" style="width:30px;height:15px;direction:ltr" id="SITE[footermasteropacty]" name="SITE[footermasteropacty]" value="<?=$V['SITE[footermasteropacty]'];?>" /></td>
  <td><?=$ADMIN_TRANS['master header opacity'];?>: (%)</td><td><input maxlength="3" style="width:30px;height:15px;direction:ltr" id="SITE[headermasteropacty]" name="SITE[headermasteropacty]" value="<?=$V['SITE[headermasteropacty]'];?>" /></td>
 </tr>
 <tr>
  <td style="width:170px;"><?=$ADMIN_TRANS['master header bg photo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[headermasterbgpic];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('headermasterbgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[headermasterbgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('delete_headermasterbgpic')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['master header bg color'];?>: </td><td><?PickColor("SITE[headermasterbgcolor]",$V['SITE[headermasterbgcolor]']);?></td>
 </tr>
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 <fieldset style="border-color:silver;border:1px solid silver"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('cntnt');"><?=$ADMIN_TRANS['content and link styling'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="cntnt" style="display:none">
 <tr>
  <td><?=$ADMIN_TRANS['titles text color'];?>: </td><td><?PickColor("SITE[titlescolor]",$V['SITE[titlescolor]']);?></td>
  <td><?=$ADMIN_TRANS['content and photo bg color'];?>: </td><td><?PickColor("SITE[shortcontentbgcolor]",$V['SITE[shortcontentbgcolor]']);?></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['content text color'];?>: </td><td><?PickColor("SITE[contenttextcolor]",$V['SITE[contenttextcolor]']);?></td>
  <td><?=$ADMIN_TRANS['links color'];?>: </td><td><?PickColor("SITE[linkscolor]",$V['SITE[linkscolor]']);?></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['content font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[contenttextsize]" name="SITE[contenttextsize]" value="<?=$V['SITE[contenttextsize]'];?>" /></td>
  <td><?=$ADMIN_TRANS['side menu bold'];?>: </td><td><input type="checkbox" id="SITE[sidemenubold]" value=1 <?=$side_menu_bold;?> /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['titles font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[titlesfontsize]" name="SITE[titlesfontsize]" value="<?=$V['SITE[titlesfontsize]'];?>" /></td>
  <td><?=$ADMIN_TRANS['brief title font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[brieftitlesfontsize]" name="SITE[brieftitlesfontsize]" value="<?=$V['SITE[brieftitlesfontsize]'];?>" /></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['site font'];?>: </td><td>
  <select id="SITE[fontface]" style="width:100px" onchange="changeFontSample(this.options[this.selectedIndex].value);">
   <?
   for ($f=0;$f<count($FONT_FACES);$f++) {
    if ($FONT_FACES[$f]=="") continue;
    $selected_label="";
    $font_face=$FONT_FACES[$f];
    if (strtoupper($selected_font)==strtoupper($font_face)) $selected_label="selected";
    ?>
    <option value="<?=$font_face;?>" <?=$selected_label;?>><?=$font_face;?></option>
    <?
   }
   ?>
  </select>
  </td>
  <td><?=$ADMIN_TRANS['titles font'];?>: </td><td>
  <select id="SITE[titlesfont]" style="width:100px" onchange="changeFontSample(this.options[this.selectedIndex].value);">
   <?
   for ($f=0;$f<count($FONT_FACES);$f++) {
    if ($FONT_FACES[$f]=="") continue;
    $selected_label="";
    $font_face=$FONT_FACES[$f];
    if (strtoupper($titles_selected_font)==strtoupper($font_face)) $selected_label="selected";
    ?>
    <option value="<?=$font_face;?>" <?=$selected_label;?>><?=$font_face;?></option>
    <?
   }
   ?>
  </select>
  </td>
 </tr>
 
 <tr>
  <td><?=$ADMIN_TRANS['titles bold'];?>: </td><td><input type="checkbox" id="SITE[titlesbold]" value=1 <?=$bold_titles;?> /></td>
  <td><?=$ADMIN_TRANS['underline links'];?>: </td><td><input type="checkbox" id="SITE[underlinelinks]" value=1 <?=$links_underline;?> /></td>
  </tr>
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('sizes');"><?=$ADMIN_TRANS['areas size and heights'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="sizes" style="display:none">
 <tr>
  <td><?=$ADMIN_TRANS['top header width'];?>: </td><td>%<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[topheaderfullwidth]" name="SITE[topheaderfullwidth]" value="<?=$V['SITE[topheaderfullwidth]'];?>" /></td>
  <td><?=$ADMIN_TRANS['main photo area width'];?>: </td><td>%<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[topheadermainfullwidth]" name="SITE[topheadermainfullwidth]" value="<?=$V['SITE[topheadermainfullwidth]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['middle content width'];?>: </td><td>%<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[middlecontentfullwidth]" name="SITE[middlecontentfullwidth]" value="<?=$V['SITE[middlecontentfullwidth]'];?>" /></td>
  <td><?=$ADMIN_TRANS['main content width'];?>: </td><td>%<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[maincontentfullwidth]" name="SITE[maincontentfullwidth]" value="<?=$V['SITE[maincontentfullwidth]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['footer width'];?>: </td><td>%<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[footerfullwidth]" name="SITE[footerfullwidth]" value="<?=$V['SITE[footerfullwidth]'];?>" /></td>
  <td><?=$ADMIN_TRANS['main photo width mode'];?>: </td><td>px
  <select id="SITE[mainpicwidth]" style="width:90px">
   <option value="930" <?=$mainpicwidthmode_selected[930];?>>930</option>
   <option value="950"<?=$mainpicwidthmode_selected[950];?>>950</option>
   <option value="2000"<?=$mainpicwidthmode_selected[2000];?>>2000</option>
  </select>
  </td>
 </tr>
 <tr>
  <td><b><?=$ADMIN_TRANS['site width'];?>:</b></td><td>px<input maxlength="4" style="width:50px;height:15px;direction:ltr" id="SITE[sitewidth]" name="SITE[sitewidth]" value="<?=$V['SITE[sitewidth]'];?>" /></td>
  <td><?=$ADMIN_TRANS['header photo width in this page'];?></td><td>px
  <select id="page_mainpicWidth" style="width:90px" onchange="setMainHeaderGalleryWidth(<?=$cID;?>,this);">
   <option value="">Default</option>
   <option value="950" <?=$page_mainPicWidthMode_selected[0];?>>930/950</option>
   <option value="2000" <?=$page_mainPicWidthMode_selected[2000];?>>2000</option>
  </select>
  </td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['top menu margin'];?>: </td><td>px<input maxlength="4" style="width:50px;height:15px;direction:ltr" id="SITE[topmenumargin]" name="SITE[topmenumargin]" value="<?=$V['SITE[topmenumargin]'];?>" /></td>
  <td><?=$ADMIN_TRANS['content area margin from main pic'];?>: </td><td>px<input maxlength="4" style="width:50px;height:15px;direction:ltr" id="SITE[contenttopmargin]" name="SITE[contenttopmargin]" value="<?=$V['SITE[contenttopmargin]'];?>" /></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['margin between content and footer'];?>: </td><td>px<input maxlength="4" style="width:50px;height:15px;direction:ltr" id="SITE[contentfootermargin]" name="SITE[contentfootermargin]" value="<?=$V['SITE[contentfootermargin]'];?>" /></td>
  <td><?=$ADMIN_TRANS['top menu sides margin'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[topmenusidemargin]" name="SITE[topmenusidemargin]" value="<?=$V['SITE[topmenusidemargin]'];?>" /></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['main pic top margin'];?>: </td><td>px<input maxlength="4" style="width:50px;height:15px;direction:ltr" id="SITE[mainpictopmargin]" name="SITE[mainpictopmargin]" value="<?=$V['SITE[mainpictopmargin]'];?>" /></td>
  <td><?=$ADMIN_TRANS['main photo width'];?>: </td><td>px<input maxlength="4" style="width:50px;height:15px;direction:ltr" id="SITE[mainpiccustomwidth]" name="SITE[mainpiccustomwidth]" value="<?=$V['SITE[mainpiccustomwidth]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['show left text to mainpic in all pages'];?>: </td><td><input type="checkbox" id="SITE[globalsidetextmainpic]" value=1 <?=$mainpic_sidetext_global;?> /></td>
  <td><?=$ADMIN_TRANS['show left text to mainpic in this page'];?>: </td><td><input type="checkbox" onclick="setMainPicSideTextGlobal(<?=$cID;?>);" id="mainPicSideText" value=1 <?=$mainpic_sidetext_currentpage;?> /></td>
  
 </tr>
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 
 <fieldset style="border-color:silver;border:1px solid silver;"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('gnrl');"><?=$ADMIN_TRANS['general styling'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="gnrl" style="display:none">
 <tr style="display:<?=$user_style_view;?>">
  <td><?=$ADMIN_TRANS['form text color'];?>: </td><td><?PickColor("SITE[formtextcolor]",$V['SITE[formtextcolor]']);?></td>
  <td><?=$ADMIN_TRANS['form background color'];?>: </td><td><?PickColor("SITE[formbgcolor]",$V['SITE[formbgcolor]']);?></td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
  <td><?=$ADMIN_TRANS['form fields border'];?>: </td><td><?PickColor("SITE[formfieldsborder]",$V['SITE[formfieldsborder]']);?></td>
  <td><?=$ADMIN_TRANS['side form bg pic'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[sideformbgpic];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('sideformbgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[sideformbgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteSideFormBgPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
  <td><?=$ADMIN_TRANS['form button text color'];?>: </td><td><?PickColor("SITE[formbuttontextcolor]",$V['SITE[formbuttontextcolor]']);?></td>
  <td><?=$ADMIN_TRANS['form buttons border'];?>: </td><td><?PickColor("SITE[formbuttonsborder]",$V['SITE[formbuttonsborder]']);?></td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
  <td><?=$ADMIN_TRANS['separator line color'];?>: </td><td><?PickColor("SITE[seperatorcolor]",$V['SITE[seperatorcolor]']);?></td>
  <td><?=$ADMIN_TRANS['rounded corners'];?>: </td><td><input type="checkbox" id="SITE[roundcorners]" value=1 <?=$roundcorners_checkbox;?> /></td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
  <td style="display:<?=$user_style_view;?>"><?=$ADMIN_TRANS['show search box'];?>: </td><td>
  <select id="SITE[searchformtop]" style="width:100px">
   <option value=0 <?=$searchform_selected[0];?>><?=$ADMIN_TRANS['hidden'];?></option>
   <option value=1 <?=$searchform_selected[1];?>><?=$ADMIN_TRANS['on top right header'];?></option>
   <option value=2 <?=$searchform_selected[2];?>><?=$ADMIN_TRANS['in middle content box'];?></option>
   <option value=3 <?=$searchform_selected[3];?>><?=$ADMIN_TRANS['on left side'];?></option>
  </select>
  </td>
  <td><?=$ADMIN_TRANS['search box bg color'];?>: </td><td><?PickColor("SITE[searchformbgcolor]",$V['SITE[searchformbgcolor]']);?></td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
  
  <td><?=$ADMIN_TRANS['search box button image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[searchbutton];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('searchbutton',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[searchbutton]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('delSearchbutton')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['search box field bg image'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[searchfieldbg];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('searchfieldbg',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[searchfieldbg]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('delSearchfieldbg')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
 <td><?=$ADMIN_TRANS['search box dimensions'];?>: (pixels)</td><td>
  W:<input maxlength="3" style="width:30px;height:15px;direction:ltr" id="SITE[searchformwidth]" name="SITE[searchformwidth]" value="<?=$V['SITE[searchformwidth]'];?>" />
  x <input maxlength="3" style="width:30px;height:15px;direction:ltr" id="SITE[searchformheight]" name="SITE[searchformheight]" value="<?=$V['SITE[searchformheight]'];?>" />:H
 </td>
 <td>FAV ICON</td><td>
 <a class="uploadertoolsbutton" onclick="showUploadTools('favicon',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
 <?
  if (!$SITE[favicon]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteFavIcon()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
  ?>
 </td>
 </tr>
 <tr>
 <td style="display:<?=$user_style_view;?>"><?=$ADMIN_TRANS['titles icon'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[titlesicon];?>');height:20px;width:40px;vertical-align:middle;"></td><td style="display:<?=$user_style_view;?>"><a class="uploadertoolsbutton" onclick="showUploadTools('titlesicon',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[titlesicon]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteTitlesIcon()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
  ?>
 </td>
 <td><?=$ADMIN_TRANS['news ticker delay'];?>: (seconds)</td>
 <td>
  <input maxlength="3" style="width:30px;height:15px;direction:ltr" id="SITE[newstickerdelay]" name="SITE[newstickerdelay]" value="<?=$V['SITE[newstickerdelay]'];?>" />
 </td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
  <td><?=$ADMIN_TRANS['news border color'];?>: </td><td><?PickColor("SITE[newsbordercolor]",$V['SITE[newsbordercolor]']);?></td>
  <td><?=$ADMIN_TRANS['news bg color'];?>: </td><td><?PickColor("SITE[newsbgcolor]",$V['SITE[newsbgcolor]']);?></td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
 <td><?=$ADMIN_TRANS['inner pages header photo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[innerpagesheaderpic];?>');height:20px;width:40px;vertical-align:middle;"></td><td style="display:<?=$user_style_view;?>"><a class="uploadertoolsbutton" onclick="showUploadTools('innerpagesheaderpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[innerpagesheaderpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteInnerPagesHeaderPic()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
  ?>
 </td>
  <td><?=$ADMIN_TRANS['show up navigation icon'];?>: </td><td><input type="checkbox" id="SITE[showtoupicon]" value=1 <?=$show_top_nav_icon;?> /></td>
  
 </tr>
 <tr>
 <td style="display:<?=$user_style_view;?>"><?=$ADMIN_TRANS['up navigation icon opacity'];?>: (%)</td><td style="display:<?=$user_style_view;?>"><input maxlength="3" style="width:30px;height:15px;direction:ltr" id="SITE[upnavopacity]" name="SITE[upnavopacity]" value="<?=$V['SITE[upnavopacity]'];?>" /></td>
 <td><?=$ADMIN_TRANS['show breadcrumb from level'];?>:</td>
 <td>
  <select id="SITE[breadcrumblevel]">
   <option value=8 <?=$selected_breadcrumb_level[8];?>>8</option>
   <option value=7 <?=$selected_breadcrumb_level[7];?>>7</option>
   <option value=6 <?=$selected_breadcrumb_level[6];?>>6</option>
   <option value=5 <?=$selected_breadcrumb_level[5];?>>5</option>
   <option value=4 <?=$selected_breadcrumb_level[4];?>>4</option>
   <option value=3 <?=$selected_breadcrumb_level[3];?>>3</option>
   <option value=2 <?=$selected_breadcrumb_level[2];?>>2</option>
   <option value=1 <?=$selected_breadcrumb_level[1];?>>1</option>
  </select>
 </td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
 <td><?=$ADMIN_TRANS['up navigation icon'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[upnavigateicon];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('upnavigateicon',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[upnavigateicon]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteUpNavigateIcon()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
  ?>
 </td>
 <td><?=$ADMIN_TRANS['default page style'];?>:</td>
 <td>
  <select id="SITE[defaultpagestyle]">
   <option value=0 <?=$selected_defaultpagestyle[0];?> ><?=$ADMIN_TRANS['with side menu'];?></option>
   <option value=2 <?=$selected_defaultpagestyle[2];?> ><?=$ADMIN_TRANS['two separated columns'];?></option>
   <option value=1 <?=$selected_defaultpagestyle[1];?> ><?=$ADMIN_TRANS['full page'];?></option>
  </select>
 </td>
 </tr>
 <tr style="display:<?=$user_style_view;?>">
  <td><?=$ADMIN_TRANS['show header/footer master'];?>:</td>
  <td>
  <select id="SITE[showmasterheaderfooter]">
   <option value=0 <?=$selected_showmasterheaderfooter[0];?> ><?=$ADMIN_TRANS['hide both'];?></option>
   <option value=1 <?=$selected_showmasterheaderfooter[1];?> ><?=$ADMIN_TRANS['show master header'];?></option>
   <option value=2 <?=$selected_showmasterheaderfooter[2];?> ><?=$ADMIN_TRANS['show master footer'];?></option>
   <option value=3 <?=$selected_showmasterheaderfooter[3];?> ><?=$ADMIN_TRANS['show both'];?></option>
  </select>
  </td>
  
  <td></td><td></td>
 </tr>
 </table>
 </fieldset>
 
 <br style="display:<?=$user_style_view;?>" />
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$slideout_user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('Slideoutcontent');"><?=$ADMIN_TRANS['slideout content'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="Slideoutcontent" style="display:none">
 
 <tr style="display:<?=$user_style_view;?>">
  
  <td><?=$ADMIN_TRANS['slideout content icon'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[slidoutcontenticon];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('slidoutcontenticon',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[slidoutcontenticon]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('delslidoutcontenticon')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['slideout content position'];?></td>
  <td>
  <select id="SITE[slidoutcontentposition]">
   <option value=0 <?=$selected_slideoutcontent_position[0];?> ><?=$SLIDEOUTICONPOS[0];?></option>
   <option value=1 <?=$selected_slideoutcontent_position[1];?> ><?=$SLIDEOUTICONPOS[1];?></option>
   <option value=2 <?=$selected_slideoutcontent_position[2];?> ><?=$SLIDEOUTICONPOS[2];?></option>
   <option value=3 <?=$selected_slideoutcontent_position[3];?> ><?=$SLIDEOUTICONPOS[3];?></option>
   <option value=4 <?=$selected_slideoutcontent_position[4];?> ><?=$SLIDEOUTICONPOS[4];?></option>
  </select>
  </td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['slideout content bg'];?>: </td><td><?PickColor("SITE[slidoutcontentbg]",$V['SITE[slidoutcontentbg]']);?></td>
  <td><?=$ADMIN_TRANS['slideout content color'];?>: </td><td><?PickColor("SITE[slidoutcontentcolor]",$V['SITE[slidoutcontentcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['show slideout content opened'];?>: </td><td><input type="checkbox" id="SITE[slideoutcontentopen]" value=1 <?=$show_slideoutcontent_opened;?> /></td>
  <td><?=$ADMIN_TRANS['slideout roundcorners'];?>: </td><td><input type="checkbox" id="SITE[slidoutcontentroundcorners]" value=1 <?=$slideoutcontent_roundcorners;?> /></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['top margin to slide icon'];?>: </td><td><input maxlength="3" style="width:30px;height:15px;direction:ltr" id="SITE[slideouticontopmargin]" name="SITE[slideouticontopmargin]" value="<?=$V['SITE[slideouticontopmargin]'];?>" /></td>
  <td></td><td></td>
 </tr>
 </table>
 </fieldset>
 <br style="display:<?=$slideout_user_style_view;?>" />
 <fieldset style="border-color:silver;border:1px solid silver;"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('fb');">Facebook</legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="fb" style="display:none">
 <tr>
  <td><?=$ADMIN_TRANS['like-box border color'];?>: </td><td><?PickColor("SITE[likeboxbordercolor]",$V['SITE[likeboxbordercolor]']);?></td>
  <td><?=$ADMIN_TRANS['like-box background color'];?>: </td><td><?PickColor("SITE[likeboxbgcolor]",$V['SITE[likeboxbgcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['titles text color'];?>: </td><td><?PickColor("SITE[slogentextcolor]",$V['SITE[slogentextcolor]']);?></td>
  <td><?=$ADMIN_TRANS['fb photos border color'];?>: </td><td><?PickColor("SITE[fb_names_border_color]",$V['SITE[fb_names_border_color]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['fb names color'];?>: </td><td><?PickColor("SITE[fb_names_color]",$V['SITE[fb_names_color]']);?></td>
  <td><?=$ADMIN_TRANS['fb num connections'];?>: </td><td><input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[fb_num_connections]" name="SITE[fb_num_connections]" value="<?=$V['SITE[fb_num_connections]'];?>" /></td>
  
 </tr>
 <tr style="display:<?=$user_style_view;?>">
  <td><?=$ADMIN_TRANS['likebox bg photo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[fb_likebox_bg_photo];?>/gallery/sitepics/<?=$SITE[fb_likebox_bg_photo];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('likeboxbgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[fb_likebox_bg_photo]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteLikeBoxBG()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['fb likebox height'];?>: </td><td>px<input maxlength="3" style="width:40px;height:15px;direction:ltr" id="SITE[fb_likebox_height]" name="SITE[fb_likebox_height]" value="<?=$V['SITE[fb_likebox_height]'];?>" /></td>
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['comments theme']?>:</td>
  <td><select id="SITE[fb_comments_theme]" style="width:100px">
    <option value="light" <?=$selected_fb_comments[light];?>>Light</option>
    <option value="dark" <?=$selected_fb_comments[dark];?>>Dark</option>
   </select>
  </td>
  <td></td><td></td>
  
 </tr>
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 <fieldset style="border-color:silver;border:1px solid silver;display:"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('landingpages');"><?=$ADMIN_TRANS['landing pages'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="landingpages" style="display:none">
 <tr>
  <td><?=$ADMIN_TRANS['hide top menu on this page'];?>: </td><td><input type="checkbox" onclick="setTopMenuHide(<?=$cID;?>);" id="HideTopMenu" value=1 <?=$hide_top_menu_here;?> /></td>
  <td valign="middle"><?=$ADMIN_TRANS['site background color'];?>: </td><td valign="middle"><?PickColor("CAT[CatSiteBGColor]",$CAT_STYLE_VAL[CatSiteBGColor],"setCatStyleProperty('$cID',this.value,'CatSiteBGColor')",'onchange');?></td></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['show_landingpage_logo'];?>: </td><td><input type="checkbox"  onclick="setCatStyleProperty('<?=$cID;?>',jQuery(this).is(':checked'),'showLogoOnLandingPage');" id="showLogoOnLandingPage" value=1 <?=($CAT_STYLE_VAL[showLogoOnLandingPage]=="true") ? 'checked' : '';?> /></td>
  <td><?=$ADMIN_TRANS['site font'];?>: </td><td>
  <select id="CAT[fontface]" style="width:100px" onchange="changeFontSample(this.options[this.selectedIndex].value);setCatStyleProperty('<?=$cID;?>',this.options[this.selectedIndex].value,'CatFontFace')">
   <?
   for ($f=0;$f<count($FONT_FACES);$f++) {
    if ($FONT_FACES[$f]=="") continue;
    $selected_label="";
    $font_face=$FONT_FACES[$f];
    if (strtoupper($cat_selected_font)==strtoupper($font_face)) $selected_label="selected";
    ?>
    <option value="<?=$font_face;?>" <?=$selected_label;?>><?=$font_face;?></option>
    <?
   }
   ?>
  </select>
 </td>
  </tr>
 <tr>
  <td valign="middle"><?=$ADMIN_TRANS['content text color'];?>: </td><td valign="middle"><?PickColor("CAT[CatSiteTextColor]",$CAT_STYLE_VAL[CatSiteTextColor],"setCatStyleProperty('$cID',this.value,'CatSiteTextColor')",'onchange');?></td></td>
  <td valign="middle"><?=$ADMIN_TRANS['titles text color'];?>: </td><td valign="middle"><?PickColor("CAT[CatSiteTitlesColor]",$CAT_STYLE_VAL[CatSiteTitlesColor],"setCatStyleProperty('$cID',this.value,'CatSiteTitlesColor')",'onchange');?></td></td>
  
 </tr>
 
 <tr>
  <td><?=$ADMIN_TRANS['content font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="CAT[CatContentTextSize]" name="CAT[CatContentTextSize]" value="<?=$CAT_STYLE_VAL['CatContentTextSize'];?>" onblur="setCatStyleProperty('<?=$cID;?>',this.value,'CatContentTextSize')" /></td>
  <td><?=$ADMIN_TRANS['titles font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="CAT[CatTitlesTextSize]" name="CAT[CatTitlesTextSize]" value="<?=$CAT_STYLE_VAL['CatTitlesTextSize'];?>" onblur="setCatStyleProperty('<?=$cID;?>',this.value,'CatTitlesTextSize')" /></td>

 </tr>
 
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('IE7');">IE7</legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="IE7" style="display:none">
 <tr>
  <td><?=$ADMIN_TRANS['top menu text color'];?>: </td><td><?PickColor("SITE[topmenutextcolorIE7]",$V['SITE[topmenutextcolorIE7]']);?></td>
  <td><?=$ADMIN_TRANS['menu selected color'];?>: </td><td><?PickColor("SITE[topmenuhovercolorIE7]",$V['SITE[topmenuhovercolorIE7]']);?></td>
 </tr>
 </table>
 </fieldset>
 <br style="display:<?=$mobile_user_style_view;?>" />
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$mobile_user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('mobile_settings');"><?=$ADMIN_TRANS['mobile settings'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="mobile_settings" style="display:none">
 <tr style="display:<?=$mobile_user_style_view;?>">
  <td><?=$ADMIN_TRANS['top menu text color'];?>: </td><td><?PickColor("SITE[mobilemenutextcolor]",$V['SITE[mobilemenutextcolor]']);?></td>
  <td><?=$ADMIN_TRANS['top menu background color'];?>: </td><td><?PickColor("SITE[mobilemenubgcolor]",$V['SITE[mobilemenubgcolor]']);?></td>
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['menu font size'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[mobilemenutextsize]" name="SITE[mobilemenutextsize]" value="<?=$V['SITE[mobilemenutextsize]'];?>" /></td>
  <td><?=$ADMIN_TRANS['show_maingallery_mobile'];?>: </td><td><input type="checkbox"  onclick="setCatStyleProperty('<?=$cID;?>',jQuery(this).is(':checked'),'showMainGalleryMobile');" id="" value=1 <?=($CAT_STYLE_VAL[showMainGalleryMobile]=="true") ? 'checked' : '';?> /></td>
 </tr>
 <tr style="display:<?=$mobile_user_style_view;?>">
  <td><?=$ADMIN_TRANS['fixed footer bg color'];?>: </td><td><?PickColor("SITE[mobilefooterbgcolor]",$V['SITE[mobilefooterbgcolor]']);?></td>
  <td><?=$ADMIN_TRANS['fixed footer icons color'];?>: </td><td><?PickColor("SITE[mobilefootericonscolor]",$V['SITE[mobilefootericonscolor]']);?></td>
 </tr>
 <tr style="display:<?=$mobile_user_style_view;?>">
  <td><?=$ADMIN_TRANS['mobile menu opacity'];?>: </td><td>%<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[mobilemenuopacity]" name="SITE[mobilemenuopacity]" value="<?=$V['SITE[mobilemenuopacity]'];?>" /></td>
  <td><?=$ADMIN_TRANS['fixed footer opacity'];?>: </td><td>%<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[mobilefooteropacity]" name="SITE[mobilefooteropacity]" value="<?=$V['SITE[mobilefooteropacity]'];?>" /></td>
  
 </tr>
 <tr style="display:<?=$mobile_user_style_view;?>">
  <td><?=$ADMIN_TRANS['edit logo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[mobilelogo];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('mobilelogo',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[mobilelogo]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('del_mobilelogo')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['top background layer'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[mobileheaderbgpic];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('mobileheaderbgpic',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[mobileheaderbgpic]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('del_mobileheaderbgpic')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr style="display:<?=$mobile_user_style_view;?>">
  <td><?=$ADMIN_TRANS['site background color'];?>: </td><td><?PickColor("SITE[mobilesitebgcolor]",$V['SITE[mobilesitebgcolor]']);?></td></td>
  <td><?=$ADMIN_TRANS['seperator line for mobile menu'];?>: </td><td><?PickColor("SITE[mobilemenu_line_color]",$V['SITE[mobilemenu_line_color]']);?></td></td>
  
  
 </tr>
 <tr style="display:<?=$mobile_user_style_view;?>">
  <td><?=$ADMIN_TRANS['mobile main photo'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[media];?>/gallery/sitepics/<?=$SITE[mobilemainpichomepage];?>');height:20px;width:40px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('mobilemainpichomepage',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[mobilemainpichomepage]=="") {
   ?>
   &nbsp;<a href="#" onclick="DeleteBGPhoto('del_mobilemainpichomepage')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$ADMIN_TRANS['show site bg image'];?>: </td><td><input type="checkbox" id="SITE[show_topbg_mobile]" value=1 <?=$mobile_top_bg;?> /></td>
  
  
 </tr>
 <tr>
  <td><?=$ADMIN_TRANS['set as mobile homepage'];?>: </td><td><input type="checkbox" onclick="setPageMobileHomepage(<?=$cID;?>);" id="setMobileHomepage" value=1 <?=$isMobileHomepage;?> /></td>
  <td style="display:<?=$mobile_user_style_view;?>"><?=$ADMIN_TRANS['remove all backgrounds'];?>: </td><td><input type="checkbox"  id="SITE[hide_all_bgs]" value=1 <?=$isMobileBackgroundsRemoved;?> /></td>
 </tr>
 </table>
 </fieldset>
 
 <? if($shopActivated) { ?>
 <br style="display:<?=$user_style_view;?>" />
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('shopStyles');"><?=$SHOP_TRANS['shopStyle'];?></legend>
 <table cellpadding="1" cellspacing="3" width="100%" id="shopStyles" style="display:none">
 <tr><td colspan="10" style="font-weight:bold;border-bottom:1px solid silver"><?=$ADMIN_TRANS['products page design'];?></td></tr>
 <tr> 
  <td><?=$SHOP_TRANS['AshopProductTitleSize'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[shopProductTitleSize]" name="SITE[shopProductTitleSize]" value="<?=$V['SITE[shopProductTitleSize]'];?>" /></td>
  <td><?=$SHOP_TRANS['AshopProductTitleColor'];?>: </td><td><? PickColor("SITE[shopProductTitleColor]",$V['SITE[shopProductTitleColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopProductTitleBold'];?>: </td><td><input type="checkbox" id="SITE[shopProductTitleBold]" value=1 <?=$shop_title_bold;?> /></td>
 </tr>
 <tr> 
  <td><?=$SHOP_TRANS['AshopProductShortDescSize'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[shopProductShortDescSize]" name="SITE[shopProductShortDescSize]" value="<?=$V['SITE[shopProductShortDescSize]'];?>" /></td>
  <td><?=$SHOP_TRANS['AshopProductShortDescColor'];?>: </td><td><? PickColor("SITE[shopProductShortDescColor]",$V['SITE[shopProductShortDescColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopProductShortDescBold'];?>: </td><td><input type="checkbox" id="SITE[shopProductShortDescBold]" value=1 <?=$shop_desc_bold;?> /></td>
 </tr>
 <tr> 
  <td><?=$SHOP_TRANS['AshopProductPriceSize'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[shopProductPriceSize]" name="SITE[shopProductPriceSize]" value="<?=$V['SITE[shopProductPriceSize]'];?>" /></td>
  <td><?=$SHOP_TRANS['AshopProductPriceColor'];?>: </td><td><? PickColor("SITE[shopProductPriceColor]",$V['SITE[shopProductPriceColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopProductPriceBold'];?>: </td><td><input type="checkbox" id="SITE[shopProductPriceBold]" value=1 <?=$shop_price_bold;?> /></td>
 </tr>
 <tr> 
    
  <td><?=$SHOP_TRANS['AshopDiscountPriceColor'];?>: </td><td><? PickColor("SITE[shopProductsPageDiscountColor]",$V['SITE[shopProductsPageDiscountColor]']); ?></td>  
  
 </tr>
 <tr> 
  <td><?=$SHOP_TRANS['AshopProductDetailsSize'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[shopProductDetailsSize]" name="SITE[shopProductDetailsSize]" value="<?=$V['SITE[shopProductDetailsSize]'];?>" /></td>
  <td><?=$SHOP_TRANS['AshopProductDetailsColor'];?>: </td><td><? PickColor("SITE[shopProductDetailsColor]",$V['SITE[shopProductDetailsColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopProductDetailsBold'];?>: </td><td><input type="checkbox" id="SITE[shopProductDetailsBold]" value=1 <?=$shop_details_bold;?> /></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopImageBgColor'];?>: </td><td><? PickColor("SITE[shopImageBgColor]",$V['SITE[shopImageBgColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopInfoBgColor'];?>: </td><td><? PickColor("SITE[shopInfoBgColor]",$V['SITE[shopInfoBgColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopSingleItemBgColor'];?>: </td><td><? PickColor("SITE[shopSingleItemBgColor]",$V['SITE[shopSingleItemBgColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopSingleItemBorderColor'];?>: </td><td><? PickColor("SITE[shopSingleItemBorderColor]",$V['SITE[shopSingleItemBorderColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopSingleItemPriceSize'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[shopSingleItemPriceSize]" name="SITE[shopSingleItemPriceSize]" value="<?=$V['SITE[shopSingleItemPriceSize]'];?>" /></td>
  <td><?=$SHOP_TRANS['AshopProductsCartIcon'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopProductsCartIcon];?>');height:20px;width:10px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopProductsCartIcon',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopProductsCartIcon]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopProductsCartIcon')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>

 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopMoreLinkColor'];?>: </td><td><? PickColor("SITE[shopMoreLinkColor]",$V['SITE[shopMoreLinkColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopMoreLinkFile'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopMoreLinkFile];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopMoreLinkFile',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopMoreLinkFile]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopMoreLinkFile')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopProductsPagePriceColor'];?>: </td><td><? PickColor("SITE[shopProductsPagePriceColor]",$V['SITE[shopProductsPagePriceColor]']); ?></td>
  <td><?=$SHOP_TRANS['shopProductBgImage'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopProductBgImage];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopProductBgImage',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopProductBgImage]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopProductBgImage')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopSingleItemPicBorder'];?>: </td><td><? PickColor("SITE[shopSingleItemPicBorder]",$V['SITE[shopSingleItemPicBorder]']); ?></td>
  <td><?=$SHOP_TRANS['shopSaleLabel'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopSaleLabel];?>');height:20px;width:30px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopSaleLabel',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopSaleLabel]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopSaleLabel')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr><td colspan="10" style="font-weight:bold;border-bottom:1px solid silver"><?=$ADMIN_TRANS['product page design'];?></td></tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopAttrsBgColor'];?>: </td><td><? PickColor("SITE[shopAttrsBgColor]",$V['SITE[shopAttrsBgColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopPicsBorderColor'];?>: </td><td><? PickColor("SITE[shopPicsBorderColor]",$V['SITE[shopPicsBorderColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopAttrBgColor'];?>: </td><td><? PickColor("SITE[shopAttrBgColor]",$V['SITE[shopAttrBgColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopSingleItemImageBg'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopSingleItemImageBg];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopSingleItemImageBg',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopSingleItemImageBg]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopSingleItemImageBg()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopSelectBg'];?>: </td><td><? PickColor("SITE[shopSelectBg]",$V['SITE[shopSelectBg]']); ?></td>
  <td><?=$SHOP_TRANS['AshopSelectTextColor'];?>: </td><td><? PickColor("SITE[shopSelectTextColor]",$V['SITE[shopSelectTextColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopButtonImage'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopButtonImage];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopButtonImage',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopButtonImage]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopButtonImage()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['AshopProdButtonOrderImage'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopProdButtonOrderImage];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopProdButtonOrderImage',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopProdButtonOrderImage]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopProdButtonOrderImage')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 <tr>
  <td><?=$SHOP_TRANS['AshopProductPageImagesBg'];?>: </td><td><? PickColor("SITE[shopProductPageImagesBg]",$V['SITE[shopProductPageImagesBg]']); ?></td>
  <td><?=$SHOP_TRANS['AproductPicsBlockBorder'];?>: </td><td><? PickColor("SITE[productPicsBlockBorder]",$V['SITE[productPicsBlockBorder]']); ?></td>
  </tr>
 <tr>
 <td><?=$SHOP_TRANS['shopAttrsTableCartPic'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopAttrsTableCartPic];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopAttrsTableCartPic',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopAttrsTableCartPic]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopAttrsTableCartPic')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['productPicWidth'];?>: </td><td>px<input maxlength="5" style="width:50px;height:15px;direction:ltr" id="SITE[productPicWidth]" name="SITE[productPicWidth]" value="<?=$V['SITE[productPicWidth]'];?>" /></td>
  <td><?=$SHOP_TRANS['productPicHeight'];?>: </td><td>px<input maxlength="5" style="width:50px;height:15px;direction:ltr" id="SITE[productPicHeight]" name="SITE[productPicHeight]" value="<?=$V['SITE[productPicHeight]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopGalleryDuration'];?>: </td><td><input maxlength="5" style="width:50px;height:15px;direction:ltr" id="SITE[shopGalleryDuration]" name="SITE[shopGalleryDuration]" value="<?=$V['SITE[shopGalleryDuration]'];?>" /></td>
  <td><?=$SHOP_TRANS['shopRelatedPosition'];?>: </td><td><select id="SITE[shopRelatedPosition]">
    <option value="bottom"><?=$SHOP_TRANS['bottom'];?></option>
    <option value="side" <?=($SITE[shopRelatedPosition] == 'side') ? ' SELECTED' : '';?>><?=$SHOP_TRANS['side'];?></option>
  </select></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopRelatedProductsTitle'];?>: </td><td><input style="width:150px;height:15px;" id="SITE[shopRelatedProductsTitle]" name="SITE[shopRelatedProductsTitle]" value="<?=$V['SITE[shopRelatedProductsTitle]'];?>" /></td>
  <td><?=$SHOP_TRANS['AshopProductsPageDiscountPriceColor'];?>: </td><td><? PickColor("SITE[shopProductsPageDiscountPriceColor]",$V['SITE[shopProductsPageDiscountPriceColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopButtonBgColor'];?>: </td><td><? PickColor("SITE[shopButtonBgColor]",$V['SITE[shopButtonBgColor]']); ?></td>
  <td><?=$SHOP_TRANS['AshopButtonTextColor'];?>: </td><td><? PickColor("SITE[shopButtonTextColor]",$V['SITE[shopButtonTextColor]']); ?></td>
 </tr>
 <tr>
 <td colspan="10" style="font-weight:bold;border-bottom:1px solid silver"><?=$ADMIN_TRANS['shopping cart'];?></td></tr>
  
 <tr>
  <td><?=$SHOP_TRANS['AshopButtonBorderColor'];?>: </td><td><? PickColor("SITE[shopButtonBorderColor]",$V['SITE[shopButtonBorderColor]']); ?></td>
  <td><?=$ADMIN_TRANS['hide shopping cart in this page'];?>: </td><td><input type="checkbox" onclick="setHiddenCartHere(<?=$cID;?>)" id="hideShopCart" value=1 <?=$shop_cart_hide_thispage;?> /></td>
 </tr>
  <tr>
  <!-- <td><?=$SHOP_TRANS['AshopCartBottom'];?>: </td><td><input type="checkbox" id="SITE[shopCartBottom]" value=1 <?=$shop_cart_bottom;?> /></td> -->
  <td><?=$SHOP_TRANS['AshopCartType'];?>: </td><td><select name="SITE[shopCartBottom]" id="SITE[shopCartBottom]">
   <option value="0"><?=$SHOP_TRANS['AshopCartTypeTop'];?></option>
   <option value="1"<?=($SITE[shopCartBottom] == 1) ? ' SELECTED' : '';?>><?=$SHOP_TRANS['AshopCartTypeBottom'];?></option>
   <option value="2"<?=($SITE[shopCartBottom] == 2) ? ' SELECTED' : '';?>><?=$SHOP_TRANS['AshopCartTypeLabel'];?></option>
  </select>
  </td>
  <td><?=$SHOP_TRANS['AshopCartHide'];?>: </td><td><input type="checkbox" id="SITE[shopCartHide]" value=1 <?=$shop_cart_hide;?> /></td>
  </tr>
 
 <tr>
  <td><?=$SHOP_TRANS['shopCartBottomPics'];?>: </td><td><input type="checkbox" id="SITE[shopCartBottomPics]" value=1 <?=($SITE[shopCartBottomPics] == 1) ? ' CHECKED' : '';?> /></td>
  <td></td><td></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopButtonOrderImage'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopButtonOrderImage];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopButtonOrderImage',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopButtonOrderImage]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopButtonOrderImage()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['AcartRemoveButton'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[cartRemoveButton];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('cartRemoveButton',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[cartRemoveButton]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('cartRemoveButton')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>

  <td><?=$SHOP_TRANS['AshopMiniCartBg'];?>: </td><td><? PickColor("SITE[shopMiniCartBg]",$V['SITE[shopMiniCartBg]']); ?></td>
  <td><?=$ADMIN_TRANS['cart text color'];?>: </td><td><? PickColor("SITE[shopCartTextColor]",$V['SITE[shopCartTextColor]']); ?></td>

 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopCartImage'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopCartImage];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopCartImage',event);"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopCartImage]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopCartImage()" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['AshopProductInCartColor'];?>: </td><td><? PickColor("SITE[shopProductInCartColor]",$V['SITE[shopProductInCartColor]']); ?></td>
 </tr>
 <tr> 
  <td><?=$SHOP_TRANS['AshopCartTopMinWidth'];?>: </td><td>px<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[shopCartTopMinWidth]" name="SITE[shopCartTopMinWidth]" value="<?=$V['SITE[shopCartTopMinWidth]'];?>" /></td>
  <td><?=$SHOP_TRANS['AshopCartTopMinHeight'];?>: </td><td>px<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[shopCartTopMinHeight]" name="SITE[shopCartTopMinHeight]" value="<?=$V['SITE[shopCartTopMinHeight]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AcartBottomImage'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[cartBottomImage];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('cartBottomImage',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[cartBottomImage]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('cartBottomImage')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['AshopPlusMinusColor'];?>: </td><td><? PickColor("SITE[shopPlusMinusColor]",$V['SITE[shopPlusMinusColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['cartProductPicBgColor'];?>: </td><td><? PickColor("SITE[cartProductPicBgColor]",$V['SITE[cartProductPicBgColor]']); ?></td>
  <td><?=$SHOP_TRANS['cartProductPicBorderColor'];?>: </td><td><? PickColor("SITE[cartProductPicBorderColor]",$V['SITE[cartProductPicBorderColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['cartCloseButton'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[cartCloseButton];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('cartCloseButton',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[cartCloseButton]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('cartCloseButton')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['cartBgOpacity'];?>: </td><td>%<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[cartBgOpacity]" name="SITE[cartBgOpacity]" value="<?=$V['SITE[cartBgOpacity]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopCartBottomLabelBg'];?>: </td><td><? PickColor("SITE[shopCartBottomLabelBg]",$V['SITE[shopCartBottomLabelBg]']); ?></td>
  <td><?=$SHOP_TRANS['cartListViewPics'];?>: </td><td><input type="checkbox" id="SITE[cartListViewPics]" value=1 <?=$shop_cart_list_pic;?> /></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopCartLabelHeight'];?>: </td><td>px<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[shopCartLabelHeight]" name="SITE[shopCartLabelHeight]" value="<?=$V['SITE[shopCartLabelHeight]'];?>" /></td>
  <td><?=$SHOP_TRANS['shopCartQtyArrows'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopCartQtyArrows];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a href="#" onclick="showUploadTools('shopCartQtyArrows',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopCartQtyArrows]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopCartQtyArrows')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr><td colspan="10" style="font-weight:bold;border-bottom:1px solid silver"><?=$ADMIN_TRANS['general'];?></td></tr>
 <tr>
  <td><?=$SHOP_TRANS['AshopPageBorder'];?>: </td><td><? PickColor("SITE[shopPageBorder]",$V['SITE[shopPageBorder]']); ?></td>
  <td><?=$SHOP_TRANS['AshopPageBg'];?>: </td><td><? PickColor("SITE[shopPageBg]",$V['SITE[shopPageBg]']); ?></td>
 </tr>
 
 <tr>
  
  <td><?=$SHOP_TRANS['AattrSearchPosition'];?></td><td><select id="SITE[attrSearchPosition]" name="SITE[attrSearchPosition]">
   <option value="underSubMenus" <?=($SITE['attrSearchPosition'] == 'underSubMenus') ? 'SELECTED' : '';?>><?=$SHOP_TRANS['AunderSubMenus'];?></option>
   <option value="ontoSubMenus" <?=($SITE['attrSearchPosition'] == 'ontoSubMenus') ? 'SELECTED' : '';?>><?=$SHOP_TRANS['AontoSubMenus'];?></option>
   <option value="ontoSiteSearch" <?=($SITE['attrSearchPosition'] == 'ontoSiteSearch') ? 'SELECTED' : '';?>><?=$SHOP_TRANS['AontoSiteSearch'];?></option>
  </select>
  </td>
  <td><?=$SHOP_TRANS['AshopCurrencySide'];?>: </td><td><select name="SITE[shopCurrencySide]" id="SITE[shopCurrencySide]"><option value="l"><?=$SHOP_TRANS['left'];?></option><option value="r"<?=($SITE['shopCurrencySide'] == 'r') ? ' selected' : '';?>><?=$SHOP_TRANS['right'];?></option></select></td>

 <tr>
  <td><?=$SHOP_TRANS['shopMarkOutOfStock'];?>: </td><td><input type="checkbox" id="SITE[shopMarkOutOfStock]" value=1 <?=($SITE[shopMarkOutOfStock] == 1) ? ' CHECKED' : '';?> /></td>
  <td><?=$SHOP_TRANS['shopOutOfStockColor'];?>: </td><td><? PickColor("SITE[shopOutOfStockColor]",$V['SITE[shopOutOfStockColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopAttrsSearchButton'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopAttrsSearchButton];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopAttrsSearchButton',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopAttrsSearchButton]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopAttrsSearchButton')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['shopSearchByAttrsTextColor'];?>: </td><td><? PickColor("SITE[shopSearchByAttrsTextColor]",$V['SITE[shopSearchByAttrsTextColor]']); ?></td>
 </tr> 
 
 </table>
 </fieldset>
 <br style="display:<?=$user_style_view;?>" />
 <fieldset style="border-color:silver;border:1px solid silver;display:<?=$user_style_view;?>"><legend style="font-weight:bold;color:blue;cursor:pointer" onclick="ShowLegend('orderPageStyles');"><?=$SHOP_TRANS['orderPageStyles'];?></legend>
 <table cellpadding="1" cellspacing="4" width="100%" id="orderPageStyles" style="display:none">
 <tr> 
  <td><?=$SHOP_TRANS['AorderPageInputWidth'];?>: </td><td>px<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[orderPageInputWidth]" name="SITE[orderPageInputWidth]" value="<?=$V['SITE[orderPageInputWidth]'];?>" /></td>
  <td><?=$SHOP_TRANS['AorderPageInputHeight'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[orderPageInputHeight]" name="SITE[orderPageInputHeight]" value="<?=$V['SITE[orderPageInputHeight]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AorderPageInputBgColor'];?>: </td><td><? PickColor("SITE[orderPageInputBgColor]",$V['SITE[orderPageInputBgColor]']); ?></td>
  <td><?=$SHOP_TRANS['AorderPageInputTextColor'];?>: </td><td><? PickColor("SITE[orderPageInputTextColor]",$V['SITE[orderPageInputTextColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AorderPageLabelTextSize'];?>: </td><td>px<input maxlength="2" style="width:50px;height:15px;direction:ltr" id="SITE[orderPageLabelTextSize]" name="SITE[orderPageLabelTextSize]" value="<?=$V['SITE[orderPageLabelTextSize]'];?>" /></td>
  <td><?=$SHOP_TRANS['AorderPageLabelTextColor'];?>: </td><td><? PickColor("SITE[orderPageLabelTextColor]",$V['SITE[orderPageLabelTextColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AorderPhoneOrderButton'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[orderPhoneOrderButton];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('orderPhoneOrderButton',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[orderPhoneOrderButton]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('orderPhoneOrderButton')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['AorderPaypalOrderButton'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[orderPaypalOrderButton];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('orderPaypalOrderButton',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[orderPaypalOrderButton]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('orderPaypalOrderButton')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AorderSubmitButton'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[orderSubmitButton];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('orderSubmitButton',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[orderSubmitButton]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('orderSubmitButton')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['AorderPageInputBorder'];?>: </td><td><? PickColor("SITE[orderPageInputBorder]",$V['SITE[orderPageInputBorder]']); ?></td>
 </tr>
 <tr> 
  <td><?=$SHOP_TRANS['AorderPageSubmitWidth'];?>: </td><td>px<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[orderPageSubmitWidth]" name="SITE[orderPageSubmitWidth]" value="<?=$V['SITE[orderPageSubmitWidth]'];?>" /></td>
  <td><?=$SHOP_TRANS['AorderPageSubmitHeight'];?>: </td><td>px<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[orderPageSubmitHeight]" name="SITE[orderPageSubmitHeight]" value="<?=$V['SITE[orderPageSubmitHeight]'];?>" /></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AorderPageSubmitBg'];?>: </td><td><? PickColor("SITE[orderPageSubmitBg]",$V['SITE[orderPageSubmitBg]']); ?></td>
  <td><?=$SHOP_TRANS['AorderPageSubmitBorder'];?>: </td><td><? PickColor("SITE[orderPageSubmitBorder]",$V['SITE[orderPageSubmitBorder]']); ?></td>
 </tr>
 <tr> 
  <td><?=$SHOP_TRANS['AorderPageSubmitFontSize'];?>: </td><td>px<input maxlength="3" style="width:50px;height:15px;direction:ltr" id="SITE[orderPageSubmitFontSize]" name="SITE[orderPageSubmitFontSize]" value="<?=$V['SITE[orderPageSubmitFontSize]'];?>" /></td>
  <td><?=$SHOP_TRANS['AorderPageSubmitFontColor'];?>: </td><td><? PickColor("SITE[orderPageSubmitFontColor]",$V['SITE[orderPageSubmitFontColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AorderPageSubmitSendText'];?>: </td><td><input style="width:100px;height:15px;" id="SITE[orderPageSubmitSendText]" name="SITE[orderPageSubmitSendText]" value="<?=$V['SITE[orderPageSubmitSendText]'];?>" /></td>
  <td><?=$SHOP_TRANS['shopOrderListSide'];?>: </td><td><input type="checkbox" id="SITE[shopOrderListSide]" value=1 <?=$shop_order_list_side;?> /></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['AorderPaypalButton'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[orderPaypalButton];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('orderPaypalButton',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[orderPaypalButton]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('orderPaypalButton')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  <td><?=$SHOP_TRANS['cartListProductNameColor'];?>: </td><td><? PickColor("SITE[cartListProductNameColor]",$V['SITE[cartListProductNameColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopFeaturedArrows'];?>: <input type="button" style="border:0px;background-image:url('<?=$SITE[Url];?>/gallery/sitepics/<?=$SITE[shopFeaturedArrows];?>');height:20px;width:20px;vertical-align:middle;"></td><td><a class="uploadertoolsbutton" onclick="showUploadTools('shopFeaturedArrows',event);$('PhotoAltTextLabel').hide();"><?=$ADMIN_TRANS['edit_bg_photo'];?></a>
  <?
  if (!$SITE[shopFeaturedArrows]=="") {
   ?>
   &nbsp;<a href="#" onclick="deleteshopImage('shopFeaturedArrows')" style="color:red"><?=$ADMIN_TRANS['delete'];?></a>
   <?
  }
   ?>
  </td>
  
  <td><?=$SHOP_TRANS['shopFeaturedTop'];?>: </td><td><select name="SITE[shopFeaturedTop]" id="SITE[shopFeaturedTop]"><option value="1"><?=$SHOP_TRANS['shopFeaturedTopTop'];?></option><option value="0"<?=($SITE['shopFeaturedTop'] == '0') ? ' selected' : '';?>><?=$SHOP_TRANS['shopFeaturedTopBottom'];?></option></select></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopOrderPaypalAdditionalFields'];?>: </td><td><input type="checkbox" id="SITE[shopOrderPaypalAdditionalFields]" value=1 <?=($SITE['shopOrderPaypalAdditionalFields'] == '1') ? ' CHECKED' : '';?> /></td>
  <td><?=$SHOP_TRANS['shopFeaturedBgColor'];?>: </td><td><? PickColor("SITE[shopFeaturedBgColor]",$V['SITE[shopFeaturedBgColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['payBlockTitleBgColor'];?>: </td><td><? PickColor("SITE[payBlockTitleBgColor]",$V['SITE[payBlockTitleBgColor]']); ?></td>
  <td><?=$SHOP_TRANS['payBlockTitleTextColor'];?>: </td><td><? PickColor("SITE[payBlockTitleTextColor]",$V['SITE[payBlockTitleTextColor]']); ?></td>
 </tr>
 <tr>
  <td><?=$SHOP_TRANS['shopFeaturedShown'];?>: </td><td><input type="checkbox" id="SITE[shopFeaturedShown]" value=1 <?=($SITE[shopFeaturedShown] == '1') ? 'CHECKED' : '';?> /></td>
 </tr>
 </table>
 </fieldset>
 <? } ?>
 
 
</form><br />
<script>
jQuery(document).ready(function() {
  jQuery('#styleseditor input, #styleseditor select').each(function() {
    jQuery(this).on('change',function() {
      var inType=jQuery(this).prop('type');
      var inName=jQuery(this).attr('id');
      var inVal=jQuery(this).val();
      if (inType=="checkbox") inVal=jQuery(this).is(':checked') ? 1 : 0;
      var url = '<?=$SITE[url];?>/Admin/saveStyle.php';
      var stylesData=inName+'='+inVal;
      
      jQuery.post(url,stylesData,function() {
        savingChanges();
      }).done(function() {successEdit();});
    })
    
  });
});
</script>
<div id="newSaveIcon" class="greenSave" onclick="EditStyle();ReloadPage();"><i class="fa fa-refresh"></i>&nbsp; <?=$ADMIN_TRANS['reload_page'];?></div>&nbsp;&nbsp;
<div id="newSaveIcon" onclick="EditStyle();"><?=$ADMIN_TRANS['close'];?></div>
&nbsp <span id="LoadingDivStyle"></span>&nbsp;

<span style="display:<?=$user_style_view;?>" id="font_sample"><iframe id="iframe_font_sample" name="iframe_font_sample" width="300" height="15" src="<?=$SITE[url];?>/Admin/iframeFontSample.php" border="0" frameborder="0" scrolling="no" allowtransparency="true"></iframe></span>