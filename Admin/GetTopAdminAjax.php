<?
include_once("../config.inc.php");
include_once("lang.admin.php");
$minShow="none";
$maxShow="";
if (!$aviary_path) $aviary_path="//feather.aviary.com/js/feather.js";
$class_secured="";
if ($HTTP_COOKIE_VARS['admin_min']=="1") {
	$minShow="";
	$maxShow="none";
}

if ($CAT_SECURED[isSecured]==1) $class_secured="secured_cat_indicator";
$isSEBlockedChecked="";
if ($P_DETAILS['SEBlock']==1) $isSEBlockedChecked="checked";
?>
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/bootstrap_tooltips.css">
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/Admin/AdminEditing.css.php">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="<?=$SITE[url];?>/js/exiteTooltip.js"></script>
<div id="overlayBG" class="overlayBG" style="display:none"></div>
<div id="TopAdminLabel" class="AdminTopNew" align="center">
<!--<div id="TopAdminBGMin" style="display:<?=$minShow;?>" onclick="toggleTopAdmin(2)"></div>-->
<div class="admin_switchViews" style="float:<?=$SITE[align];?>"><a href="<?=$SITE[url];?>/Admin/so.php"><i class="fa fa-power-off"></i> <?=$ADMIN_TRANS['sign out'];?></a></div>
<div class="admin_switchViews" style="float:<?=$SITE[align];?>"><a href="<?=$SITE[url];?>/Admin/switch_mode.php"><i class="fa fa-desktop"></i> <?=$ADMIN_TRANS['switch to view mode'];?></a></div>
<table class="general"  style="height:20px;min-width:300px" align="center">
<td style="width:5px"></td>
<td align="center"><a href="<?=$SITE[url];?>/Admin/configAdmin.php"><?=$ADMIN_TRANS['general settings'];?></a></td>
<?
$is_shop = false;
if ($urlKey!==0) {
	$P_ID=GetPageIDFromUrlKey($urlKey);
	$pID=$P_ID[parentID];	
	if($P_ID[ProductID] > 0)
	{
		$is_shop = true;
		$pID = $P_ID[ProductID];
	}
	?>
	<td width="8" align="center" style="font-weight:bold">|</td>
	<td align="right" style="cursor:pointer;" onclick="EditMeta();"><?=$ADMIN_TRANS['edit meta tags'];?></td>
	<?
}
include_once("clientscripts.inc.php");
$show_additional_metatags=$show_additional_code="none";
$flags_name=$SITE_LANG[selected];
if ($flags_name=="") $flags_name=$default_lang;
if ($MEMBER[UserType]==0 OR $MEMBER[UserType]==2) {
	$show_additional_metatags="";
	$show_additional_code="";
}

if (!$pID) $pID=0;
?>
<td width="8" align="center" style="font-weight:bold">|</td>
<td align="center" class="link" onclick="EditStyle();"><?=$ADMIN_TRANS['style editor'];?></td>

<?
if ($urlKey!="login" AND $SITE['allowuserperms']==1) {
	?>
	<td width="8" align="center" style="font-weight:bold">|</td>
	<td align="center" class="link <?=$class_secured;?>" onclick="EditUsersPerms();"><?=$ADMIN_TRANS['permissions'];?></td>
	<td width="8" align="center" style="font-weight:bold">|</td>
	<?
}

?>
<td align="<?=$SITE[opalign];?>" style="width:25px;"><img src="<?=$SITE['cdn_url'];?>/images/flags/<?=$flags_name;?>.png" align="absmiddle" style="margin-top:3px;" /></td>
<td align="<?=$SITE[opalign];?>" width="100" style="padding-<?=$SITE[opalign];?>:10px;padding-top:3px;">
<div id="LoadingDiv" class="LoadingDiv" style="display:;"><font color="#333333"><?=$ADMIN_TRANS['status'];?></font>

</div>
</td>

</table>
<div class="notification_admin">
	<div class="notify_icon" onclick="toggleNotification()"><i class="fa fa-bell-o fa-2x"></i></div>
	<div class="notification_message">
		<div class="message_from_admin"></div>
		<div class="arrow"><i class="fa fa-caret-up fa-2x"></i></div>
		
		
	</div>
</div>

	<?
	if (session_is_registered('theme_db_name') AND $MEMBER[UserType]==0) {
			print '<div id="TopAdminTheme">';
			print "<span style='direction:".$SITE[direction]."'>".$SITE[ThemeName]."-</span> <span id='savethemestatus'><a style='color:red;text-decoration:underline' href='#' onclick='SaveTheme(".$SITE[ThemeID].")'>Unsaved</a></span>";
	
	?>
	<script language="javascript">
	function savingTheme() {
		$('savethemestatus').innerHTML='Saving';
	}
	function successSaveTheme(rs) {
		$('savethemestatus').innerHTML='<font color=green>Saved</font>';
	}
	function SaveTheme (themeID) {
		var url = '<?=$SITE[url];?>/Admin/saveTheme.php';
		var pars='themeID='+themeID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function(transport){successSaveTheme(transport.responseText);}, onFailure:failedEdit,onLoading:savingTheme});
	}
	</script>
	</div>
	<?
	}
	
	?>
</div>
<div class="AdminTopMarginizer"></div>
<script language="javascript" type="text/javascript" src="<?=$SITE[url];?>/js/jscolor/jscolor.js"></script>
<script type="text/javascript" src="<?=$aviary_path;?>"></script>
<script language="javascript">
var siteURL="<?=$SITE[url];?>";
var catParentID="<?=$CHECK_CATPAGE[parentID];?>";
var url="";
var DivMessage="Loading...";
var SiteDirection="<?=$SITE_LANG[direction];?>";
var myPicker;
var remotePars;
var TopHeaderGalType;
var editorContainerLignboxDiv='<div id="lightContainerEditor"></div>';
var notificationOpen=false;
function toggleNotification(messageAction) {
	if (messageAction) notificationOpen=false;
	if (!notificationOpen) {
		 jQuery(".notification_message").fadeIn("fast");
		jQuery(".message_from_admin").load("<?=$SITE[url];?>/Admin/GetNotificationMessage.php?messageAction="+messageAction);
		notificationOpen=true;
	}
	else {
		jQuery(".message_from_admin").html("...");
		notificationOpen=false;
		 jQuery(".notification_message").fadeOut("fast");
	}
}
function SetPosition(o,e_id,ofset) {
	var arrayPosition=GetPosition(o);
	var leftPad=-300;
	
	if (SiteDirection=="rtl") leftPad=leftPad+ofset;
	else  leftPad=leftPad-ofset;
	//Element.setLeft(e_id,arrayPosition[0]+leftPad);
	Element.setTop(e_id,arrayPosition[1]+0);
}
function createPicker(id,color_id) {
	myPicker = new jscolor.color(document.getElementById(color_id), {
		valueElement: id,
		styleElement: color_id
	})
	
}
function toggleTopAdmin(t) {
	var AdminMinimized="1";
	if (t==2) AdminMinimized="0";
	SetCookie("admin_min",AdminMinimized,0);
	Effect.toggle('TopAdminBGMax','slide',{duration:0.5});
	window.setTimeout("$('TopAdminBGMin').toggle();",t);
	//doFixScroll();
}
function slideOutSettings(d,st) {
	var arrayScroll=getPageScroll();
	arrayPageSize = getPageSize();
	jQuery('#overlayBG').height(arrayPageSize[1]);
	var settings_div_width=jQuery("#"+d).width();
	if (st) {
		jQuery("#overlayBG").show();
		jQuery("#"+d).css("<?=$SITE[align];?>","-"+settings_div_width+"px");
		jQuery("#"+d).show();
		jQuery("#"+d).animate({
			<?=$SITE[align];?>:'0px'
		},200,'easeOutExpo');
		
	}
	else {
		jQuery("#overlayBG").hide();
		jQuery("#"+d).animate({
			<?=$SITE[align];?>:-(settings_div_width)+"px"
		},200,function() {
			jQuery("#"+d).hide();
			});
	
	}
	jQuery(document).scrollTop(0);
}
var editorOpeninit;
function slideOutEditor(d,st) {
	arrayPageSize = getPageSize();
	jQuery('#overlayBG').height(arrayPageSize[1]);
	if (!editorOpeninit)  {
		var shadowHTML='<div class="editorShadow"></div>';
		jQuery(".editorWrapper").after(shadowHTML);
		editorOpeninit=1;
	}
	var minimizeHTML='<div class="minimize_editor")"></div><div style="clear:both"></div>';
	jQuery(".minimize_editor").remove();
	jQuery(".editorWrapper").prepend(minimizeHTML);
		jQuery(".minimize_editor").click(function() {
			slideOutEditor(d,0);
		});
	
	
	var settings_div_height=jQuery("#"+d).height()+20;
	if (st) {
		jQuery("#overlayBG").show();
		jQuery(".editorShadow").show();
		//jQuery("#"+d).css("bottom","-"+settings_div_height+"px");
		jQuery("#"+d).fadeIn('fast');
		//jQuery("#"+d).animate({
		//	bottom:'0px'
		//},420);
		
	}
	else {
		jQuery("#overlayBG").hide();
		jQuery(".editorShadow").hide();
		//jQuery("#"+d).animate({
		//	bottom:-(settings_div_height)+"px"
		//},430,function() {
		//	jQuery("#"+d).hide();
		//	});
		jQuery("#"+d).fadeOut('fast');
	}
}
function successSavePageCats() {
	ShowLayer("pageCatsContainer",0,1);
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['category saved'];?></span>";
}
function successEditMeta() {
	document.getElementById("LoadingDivMeta").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['changes saved'];?></span>";
	
}
function successEditStyle() {
	document.getElementById("LoadingDivStyle").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['changes saved, to view please'];?> <a href=# onclick='document.location.reload()'><?=$ADMIN_TRANS['refresh the page'];?></a></span>";
	
}
function MakeContentDragable(x){
	
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=sortContent';
	//var pars = 'catSort='+x+'&action=sortCat';
	//var myAjax = new Ajax.Request(url, {method:'post',parameters: { data: Sortable.serialize("list_to_sort")} , onSuccess:successEditCat, onFailure:failedEdit,onLoading:savingChanges});
	new Ajax.Request(url, {  
           method: "post", 
	parameters: { contentSort: x },
	onSuccess:successMoveContent
	
       });
}
function MakeTopDragable(newPosition){
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars =newPosition+'&action=sortCat';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successMoveContent, onFailure:failedEdit,onLoading:savingChanges});
		
}
function MakeNewsDragable(newPosition){
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars =newPosition+'&action=sortNews';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successMoveContent, onFailure:failedEdit,onLoading:savingChanges});
		
}
function successMoveContent() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['order of item saved!'];?></span>";
}
function failedEdit() {
	msgDivText="<span class='failedEdit'><?=$ADMIN_TRANS['an error occurred during server communication , please try again .'];?></span>";
}
function savingChanges() {
	document.getElementById("LoadingDiv").innerHTML="<span class='progressEdit'><img src='<?=$SITE[url];?>/images/loading.gif' border=0>&nbsp; <?=$ADMIN_TRANS['saving changes'];?>. . .</span>";
}
function savingChangesMeta() {
	document.getElementById("LoadingDivMeta").innerHTML="<span class='progressEdit'><img src='images/loading.gif' border=0>&nbsp; <?=$ADMIN_TRANS['saving changes'];?>. . .</span>";
}

function SaveMeta() {
	var pageID=<?=$pID;?>;
	var pageKY=document.getElementById("PageKeywords").value;
	var pageDESC=document.getElementById("PageDescription").value;
	var pageTT=document.getElementById("PageTagTitle").value;
	var pageMT=document.getElementById("AdditionalMetaTags").value;
	var siteAddOnCode=document.getElementById("css_js_code").value;
	var isSE_BLOCKED=jQuery("input#isSEBlocked:checked").length;
	pageKY=encodeURIComponent(pageKY);
	pageDESC=encodeURIComponent(pageDESC);
	pageTT=encodeURIComponent(pageTT);
	pageMT=encodeURIComponent(pageMT);
	siteAddOnCode=encodeURIComponent(siteAddOnCode);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?catParent=<?=$CHECK_CATPAGE[parentID];?>';
	
	var pars = 'pageID='+pageID+'&action=saveMeta&pageKY='+pageKY+'&pageDESC='+pageDESC+'&pageTT='+pageTT+'&pageMT='+pageMT+'&isSE_BLOCKED='+isSE_BLOCKED+'&siteAddOnCode='+siteAddOnCode+'&isShop=<?=($is_shop) ? '1' : '0';?>';
	
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEditMeta, onFailure:failedEdit,onLoading:savingChangesMeta});
}
function SaveStyles() {
	var round_corners=0;
	var mainpic_sidetext_global=0;
	var subtopmenuhover=0;
	var staticfooterheight=0;
	var underlinelinks=0;
	var titlesbold=0;
	var topmenuoposition=0;
	var show_top_nav_icon=0;
	var topmenu_under_photo=$('SITE[topmenubottom]').options[$('SITE[topmenubottom]').selectedIndex].value;
	var main_pic_widthmode=$('SITE[mainpicwidth]').options[$('SITE[mainpicwidth]').selectedIndex].value;
	var show_search_box=$('SITE[searchformtop]').options[$('SITE[searchformtop]').selectedIndex].value;
	var font_face=$('SITE[fontface]').options[$('SITE[fontface]').selectedIndex].value;
	var menus_font=$('SITE[menusfont]').options[$('SITE[menusfont]').selectedIndex].value;
	var titles_font=$('SITE[titlesfont]').options[$('SITE[titlesfont]').selectedIndex].value;
	var selected_def_effect=$('SITE[defaulteffect]').options[$('SITE[defaulteffect]').selectedIndex].value;
	var selected_fb_comments_theme=$('SITE[fb_comments_theme]').options[$('SITE[fb_comments_theme]').selectedIndex].value;
	var selected_bc_level=$('SITE[breadcrumblevel]').options[$('SITE[breadcrumblevel]').selectedIndex].value;
	var selected_defaultpagestyle=$('SITE[defaultpagestyle]').options[$('SITE[defaultpagestyle]').selectedIndex].value;
	var selected_maingallery_behind=$('SITE[maingallerybehind]').options[$('SITE[maingallerybehind]').selectedIndex].value;
	var selected_headerfootermaster=$('SITE[showmasterheaderfooter]').options[$('SITE[showmasterheaderfooter]').selectedIndex].value;
	var side_menu_bold=0;
	var slideout_content_open=0;
	var slideout_roundcorners=0;
	var mobile_top_bg_image=0;
	var mobile_bgs_removed=0;
	if ($('SITE[roundcorners]').checked) round_corners=1;
	if ($('SITE[subtopmenuhover]').checked) subtopmenuhover=1;
	if ($('SITE[staticfooterheight]').checked) staticfooterheight=1;
	if ($('SITE[sidemenubold]').checked) side_menu_bold=1;
	if ($('SITE[globalsidetextmainpic]').checked) mainpic_sidetext_global=1;
	if ($('SITE[underlinelinks]').checked) underlinelinks=1;
	if ($('SITE[titlesbold]').checked) titlesbold=1;
	if ($('SITE[topmenuoposition]').checked) topmenuoposition=1;
	if ($('SITE[showtoupicon]').checked) show_top_nav_icon=1;
	if ($('SITE[slideoutcontentopen]').checked) slideout_content_open=1;
	if ($('SITE[slidoutcontentroundcorners]').checked) slideout_roundcorners=1;
	if ($('SITE[show_topbg_mobile]').checked) mobile_top_bg_image=1;
	if ($('SITE[hide_all_bgs]').checked) mobile_bgs_removed=1;
	var shopProductTitleBold = 0;
	var shopProductShortDescBold = 0;
	var shopProductPriceBold = 0;
	var shopProductDetailsBold = 0;
	var shopOrderListSide = 0;
	var shopCartHide = 0;
	var shopCartBottomPics = 0;
	var cartListViewPics = 0;
	var shopMarkOutOfStock = 0;
	var shopOrderPaypalAdditionalFields = 0;
	var shopFeaturedShown = 0;
	<? if($shopActivated) { ?>
	if ($('SITE[shopProductTitleBold]').checked) shopProductTitleBold=1;
	if ($('SITE[shopProductShortDescBold]').checked) shopProductShortDescBold=1;
	if ($('SITE[shopProductPriceBold]').checked) shopProductPriceBold=1;
	if ($('SITE[shopProductDetailsBold]').checked) shopProductDetailsBold=1;
	if ($('SITE[shopOrderListSide]').checked) shopOrderListSide=1;
	if ($('SITE[shopCartHide]').checked) shopCartHide=1;
	if ($('SITE[cartListViewPics]').checked) cartListViewPics=1;
	if ($('SITE[shopMarkOutOfStock]').checked) shopMarkOutOfStock=1;
	if ($('SITE[shopOrderPaypalAdditionalFields]').checked) shopOrderPaypalAdditionalFields=1;
	if ($('SITE[shopFeaturedShown]').checked) shopFeaturedShown=1;
	if ($('SITE[shopCartBottomPics]').checked) shopCartBottomPics=1;
	<? } ?>
	var pars="SITE[bgcolor]="+$('SITE[bgcolor]').value+"&SITE[topheaderbg]="+$('SITE[topheaderbg]').value
	+"&SITE[middlebgcolor]="+$('SITE[middlebgcolor]').value+"&SITE[contentbgcolor]="+$('SITE[contentbgcolor]').value
	+"&SITE[footerbgcolor]="+$('SITE[footerbgcolor]').value+"&SITE[topmenubgcolor]="+$('SITE[topmenubgcolor]').value
	+"&SITE[topmenutextcolor]="+$('SITE[topmenutextcolor]').value+"&SITE[submenutextcolor]="+$('SITE[submenutextcolor]').value
	+"&SITE[topmenuhovercolor]="+$('SITE[topmenuhovercolor]').value+"&SITE[titlescolor]="+$('SITE[titlescolor]').value
	+"&SITE[slogentextcolor]="+$('SITE[slogentextcolor]').value+"&SITE[roundcorners]="+round_corners+"&SITE[topmenubottom]="+topmenu_under_photo
	+"&SITE[contenttextcolor]="+$('SITE[contenttextcolor]').value+"&SITE[contenttextsize]="+$('SITE[contenttextsize]').value
	+"&SITE[formbgcolor]="+$('SITE[formbgcolor]').value+"&SITE[formtextcolor]="+$('SITE[formtextcolor]').value
	+"&SITE[bottompicbgcolor]="+$('SITE[bottompicbgcolor]').value+"&SITE[linkscolor]="+$('SITE[linkscolor]').value
	+"&SITE[photowrapperbg]="+$('SITE[photowrapperbg]').value+"&SITE[menutextsize]="+$('SITE[menutextsize]').value
	+"&SITE[submenuhovercolor]="+$('SITE[submenuhovercolor]').value+"&SITE[sidebgcolor]="+$('SITE[sidebgcolor]').value
	+"&SITE[seperatorcolor]="+$('SITE[seperatorcolor]').value+"&SITE[topmenumargin]="+$('SITE[topmenumargin]').value+"&SITE[contenttopmargin]="+$('SITE[contenttopmargin]').value
	+"&SITE[sidemenubold]="+side_menu_bold+"&SITE[galleryphotowidth]="+$('SITE[galleryphotowidth]').value
	+"&SITE[galleryphotoheight]="+$('SITE[galleryphotoheight]').value+"&SITE[shortcontentbgcolor]="+$('SITE[shortcontentbgcolor]').value
	+"&SITE[slidericoncolor]="+$('SITE[slidericoncolor]').value+"&SITE[mainpicwidth]="+$('SITE[mainpicwidth]').value+"&SITE[effectgallerybg]="+$('SITE[effectgallerybg]').value
	+"&SITE[topheaderfullwidth]="+$('SITE[topheaderfullwidth]').value+"&SITE[topheadermainfullwidth]="+$('SITE[topheadermainfullwidth]').value
	+"&SITE[middlecontentfullwidth]="+$('SITE[middlecontentfullwidth]').value+"&SITE[maincontentfullwidth]="+$('SITE[maincontentfullwidth]').value+"&SITE[footerfullwidth]="+$('SITE[footerfullwidth]').value
	+"&SITE[subtopmenuhover]="+subtopmenuhover+"&SITE[submenuhovebgcolor]="+$('SITE[submenuhovebgcolor]').value+"&SITE[submenuseperatorcolor]="+$('SITE[submenuseperatorcolor]').value
	+"&SITE[searchformtop]="+show_search_box+"&SITE[searchformwidth]="+$('SITE[searchformwidth]').value+"&SITE[searchformheight]="+$('SITE[searchformheight]').value
	+"&SITE[searchformbgcolor]="+$('SITE[searchformbgcolor]').value+"&SITE[staticfooterheight]="+staticfooterheight+"&SITE[topmenusidemargin]="+$('SITE[topmenusidemargin]').value
	+"&SITE[contentfootermargin]="+$('SITE[contentfootermargin]').value+"&SITE[likeboxbordercolor]="+$('SITE[likeboxbordercolor]').value+"&SITE[likeboxbgcolor]="+$('SITE[likeboxbgcolor]').value
	+"&SITE[topfooterbgcolor]="+$('SITE[topfooterbgcolor]').value+"&SITE[gallerylinecolor]="+$('SITE[gallerylinecolor]').value+"&SITE[gallerysidetextbg]="+$('SITE[gallerysidetextbg]').value
	+"&SITE[thumbsbordercolor]="+$('SITE[thumbsbordercolor]').value+"&SITE[productgallerywidth]="+$('SITE[productgallerywidth]').value+"&SITE[fb_names_color]="+$('SITE[fb_names_color]').value
	+"&SITE[fb_num_connections]="+$('SITE[fb_num_connections]').value+"&SITE[fb_names_border_color]="+$('SITE[fb_names_border_color]').value+"&SITE[fb_likebox_height]="+$('SITE[fb_likebox_height]').value
	+"&SITE[effectgallerytextcolor]="+$('SITE[effectgallerytextcolor]').value+"&SITE[effectgallerybgcolor]="+$('SITE[effectgallerybgcolor]').value
	+"&SITE[mainpictopmargin]="+$('SITE[mainpictopmargin]').value+"&SITE[effectgallerybordercolor]="+$('SITE[effectgallerybordercolor]').value+"&SITE[topmenuitemcolor]="+$('SITE[topmenuitemcolor]').value
	+"&SITE[mainpiccustomwidth]="+$('SITE[mainpiccustomwidth]').value+"&SITE[globalsidetextmainpic]="+mainpic_sidetext_global+"&SITE[submenufontsize]="+$('SITE[submenufontsize]').value
	+"&SITE[topmenutextcolorIE7]="+$('SITE[topmenutextcolorIE7]').value+"&SITE[topmenuhovercolorIE7]="+$('SITE[topmenuhovercolorIE7]').value+"&SITE[underlinelinks]="+underlinelinks
	+"&SITE[titlesfontsize]="+$('SITE[titlesfontsize]').value+"&SITE[brieftitlesfontsize]="+$('SITE[brieftitlesfontsize]').value+"&SITE[titlesbold]="+titlesbold
	+"&SITE[formfieldsborder]="+$('SITE[formfieldsborder]').value+"&SITE[formbuttontextcolor]="+$('SITE[formbuttontextcolor]').value
	+"&SITE[formbuttonsborder]="+$('SITE[formbuttonsborder]').value+"&SITE[fontface]="+font_face+"&SITE[menusfont]="+menus_font+"&SITE[titlesfont]="+titles_font
	+"&SITE[newstickerdelay]="+$('SITE[newstickerdelay]').value+"&SITE[topmenuoposition]="+topmenuoposition+"&SITE[leftcolbgcolor]="+$('SITE[leftcolbgcolor]').value
	+"&SITE[leftcolbordercolor]="+$('SITE[leftcolbordercolor]').value+"&SITE[leftcolseperatorcolor]="+$('SITE[leftcolseperatorcolor]').value+"&SITE[showtoupicon]="+show_top_nav_icon
	+"&SITE[upnavopacity]="+$('SITE[upnavopacity]').value+"&SITE[defaulteffect]="+selected_def_effect+"&SITE[effectgallerydefaultheight]="+$('SITE[effectgallerydefaultheight]').value
	+"&SITE[submenumouseovercolor]="+$('SITE[submenumouseovercolor]').value+"&SITE[subsubmenucolor]="+$('SITE[subsubmenucolor]').value+"&SITE[subsubmenuselectedcolor]="+$('SITE[subsubmenuselectedcolor]').value
	+"&SITE[fb_comments_theme]="+selected_fb_comments_theme+"&SITE[breadcrumblevel]="+selected_bc_level+"&SITE[popupmenufontsize]="+$('SITE[popupmenufontsize]').value
	+"&SITE[defaultpagestyle]="+selected_defaultpagestyle+"&SITE[maingallerybehind]="+selected_maingallery_behind+"&SITE[footermasterbgcolor]="+$('SITE[footermasterbgcolor]').value
	+"&SITE[footermasteropacty]="+$('SITE[footermasteropacty]').value+"&SITE[headermasterbgcolor]="+$('SITE[headermasterbgcolor]').value+"&SITE[headermasteropacty]="+$('SITE[headermasteropacty]').value
	+"&SITE[showmasterheaderfooter]="+selected_headerfootermaster+"&SITE[newsbgcolor]="+$('SITE[newsbgcolor]').value+"&SITE[newsbordercolor]="+$('SITE[newsbordercolor]').value
	+"&SITE[submenudropdownopacity]="+$('SITE[submenudropdownopacity]').value+"&SITE[slidoutcontentbg]="+$('SITE[slidoutcontentbg]').value+"&SITE[slidoutcontentposition]="+$('SITE[slidoutcontentposition]').value
	+"&SITE[slidoutcontentcolor]="+$('SITE[slidoutcontentcolor]').value+"&SITE[slideoutcontentopen]="+slideout_content_open+"&SITE[slidoutcontentroundcorners]="+slideout_roundcorners
	+"&SITE[slideouticontopmargin]="+$('SITE[slideouticontopmargin]').value+"&SITE[mobilemenutextcolor]="+$('SITE[mobilemenutextcolor]').value+"&SITE[mobilemenubgcolor]="+$('SITE[mobilemenubgcolor]').value
	+"&SITE[mobilefooterbgcolor]="+$('SITE[mobilefooterbgcolor]').value+"&SITE[mobilefootericonscolor]="+$('SITE[mobilefootericonscolor]').value+"&SITE[mobilemenuopacity]="+$('SITE[mobilemenuopacity]').value
	+"&SITE[mobilemenu_line_color]="+$('SITE[mobilemenu_line_color]').value+"&SITE[mobilesitebgcolor]="+$('SITE[mobilesitebgcolor]').value+"&SITE[mobilefooteropacity]="+$('SITE[mobilefooteropacity]').value
	+"&SITE[show_topbg_mobile]="+mobile_top_bg_image+"&SITE[hide_all_bgs]="+mobile_bgs_removed+"&SITE[subsubmenufontsize]="+$('SITE[subsubmenufontsize]').value+"&SITE[3deffectbgcolor]="+$('SITE[3deffectbgcolor]').value
	+"&SITE[mobilemenutextsize]="+$('SITE[mobilemenutextsize]').value+"&SITE[sitewidth]="+$('SITE[sitewidth]').value
	<? if($shopActivated) { ?>
	+"&SITE[shopButtonBgColor]="+$('SITE[shopButtonBgColor]').value
	+"&SITE[shopButtonTextColor]="+$('SITE[shopButtonTextColor]').value
	+"&SITE[shopButtonBorderColor]="+$('SITE[shopButtonBorderColor]').value
	+"&SITE[shopProductTitleSize]="+$('SITE[shopProductTitleSize]').value
	+"&SITE[shopProductTitleColor]="+$('SITE[shopProductTitleColor]').value
	+"&SITE[shopProductShortDescSize]="+$('SITE[shopProductShortDescSize]').value
	+"&SITE[shopProductShortDescColor]="+$('SITE[shopProductShortDescColor]').value
	+"&SITE[shopProductPriceSize]="+$('SITE[shopProductPriceSize]').value
	+"&SITE[shopProductPriceColor]="+$('SITE[shopProductPriceColor]').value
	+"&SITE[shopProductDetailsSize]="+$('SITE[shopProductDetailsSize]').value
	+"&SITE[shopProductDetailsColor]="+$('SITE[shopProductDetailsColor]').value
	+"&SITE[shopProductTitleBold]="+shopProductTitleBold
	+"&SITE[shopProductShortDescBold]="+shopProductShortDescBold
	+"&SITE[shopProductPriceBold]="+shopProductPriceBold
	+"&SITE[shopProductDetailsBold]="+shopProductDetailsBold
	+"&SITE[shopAttrsBgColor]="+$('SITE[shopAttrsBgColor]').value
	+"&SITE[shopPicsBorderColor]="+$('SITE[shopPicsBorderColor]').value
	+"&SITE[shopImageBgColor]="+$('SITE[shopImageBgColor]').value
	+"&SITE[shopInfoBgColor]="+$('SITE[shopInfoBgColor]').value
	+"&SITE[shopSingleItemBgColor]="+$('SITE[shopSingleItemBgColor]').value
	+"&SITE[shopSingleItemBorderColor]="+$('SITE[shopSingleItemBorderColor]').value
	+"&SITE[shopSingleItemPriceSize]="+$('SITE[shopSingleItemPriceSize]').value
	+"&SITE[shopProductPageImagesBg]="+$('SITE[shopProductPageImagesBg]').value
	+"&SITE[shopAttrBgColor]="+$('SITE[shopAttrBgColor]').value
	+"&SITE[shopSelectBg]="+$('SITE[shopSelectBg]').value
	+"&SITE[shopSelectTextColor]="+$('SITE[shopSelectTextColor]').value
	+"&SITE[shopMiniCartBg]="+$('SITE[shopMiniCartBg]').value
	+"&SITE[shopCartTextColor]="+$('SITE[shopCartTextColor]').value
	+"&SITE[shopCartBottom]="+$('SITE[shopCartBottom]').value
	+"&SITE[shopOrderListSide]="+shopOrderListSide
	+"&SITE[orderPageInputWidth]="+$('SITE[orderPageInputWidth]').value
	+"&SITE[orderPageInputHeight]="+$('SITE[orderPageInputHeight]').value
	+"&SITE[orderPageInputBgColor]="+$('SITE[orderPageInputBgColor]').value
	+"&SITE[orderPageInputTextColor]="+$('SITE[orderPageInputTextColor]').value
	+"&SITE[orderPageLabelTextSize]="+$('SITE[orderPageLabelTextSize]').value
	+"&SITE[orderPageLabelTextColor]="+$('SITE[orderPageLabelTextColor]').value
	+"&SITE[shopCartTopMinHeight]="+$('SITE[shopCartTopMinHeight]').value
	+"&SITE[shopCartTopMinWidth]="+$('SITE[shopCartTopMinWidth]').value
	+"&SITE[productPicsBlockBorder]="+$('SITE[productPicsBlockBorder]').value
	+"&SITE[attrSearchPosition]="+$('SITE[attrSearchPosition]').value
	+"&SITE[shopProductInCartColor]="+$('SITE[shopProductInCartColor]').value
	+"&SITE[shopPageBg]="+$('SITE[shopPageBg]').value
	+"&SITE[shopPageBorder]="+$('SITE[shopPageBorder]').value
	+"&SITE[orderPageInputBorder]="+$('SITE[orderPageInputBorder]').value
	+"&SITE[orderPageSubmitWidth]="+$('SITE[orderPageSubmitWidth]').value
	+"&SITE[orderPageSubmitHeight]="+$('SITE[orderPageSubmitHeight]').value
	+"&SITE[orderPageSubmitBg]="+$('SITE[orderPageSubmitBg]').value
	+"&SITE[orderPageSubmitBorder]="+$('SITE[orderPageSubmitBorder]').value
	+"&SITE[orderPageSubmitFontSize]="+$('SITE[orderPageSubmitFontSize]').value
	+"&SITE[orderPageSubmitFontColor]="+$('SITE[orderPageSubmitFontColor]').value
	+"&SITE[orderPageSubmitSendText]="+$('SITE[orderPageSubmitSendText]').value
	+"&SITE[shopMoreLinkColor]="+$('SITE[shopMoreLinkColor]').value
	+"&SITE[shopPlusMinusColor]="+$('SITE[shopPlusMinusColor]').value
	+"&SITE[shopCartHide]="+shopCartHide
	+"&SITE[shopCurrencySide]="+$('SITE[shopCurrencySide]').value
	+"&SITE[cartProductPicBgColor]="+$('SITE[cartProductPicBgColor]').value
	+"&SITE[cartProductPicBorderColor]="+$('SITE[cartProductPicBorderColor]').value
	+"&SITE[cartBgOpacity]="+$('SITE[cartBgOpacity]').value
	+"&SITE[shopProductsPagePriceColor]="+$('SITE[shopProductsPagePriceColor]').value
	+"&SITE[shopCartBottomLabelBg]="+$('SITE[shopCartBottomLabelBg]').value
	+"&SITE[cartListViewPics]="+cartListViewPics
	+"&SITE[cartListProductNameColor]="+$('SITE[cartListProductNameColor]').value
	+"&SITE[shopGalleryDuration]="+$('SITE[shopGalleryDuration]').value
	+"&SITE[shopFeaturedTop]="+$('SITE[shopFeaturedTop]').value
	+"&SITE[shopMarkOutOfStock]="+shopMarkOutOfStock
	+"&SITE[shopOutOfStockColor]="+$('SITE[shopOutOfStockColor]').value
	+"&SITE[shopSingleItemPicBorder]="+$('SITE[shopSingleItemPicBorder]').value
	+"&SITE[shopSearchByAttrsTextColor]="+$('SITE[shopSearchByAttrsTextColor]').value
	+"&SITE[shopOrderPaypalAdditionalFields]="+shopOrderPaypalAdditionalFields
	+"&SITE[shopFeaturedBgColor]="+$('SITE[shopFeaturedBgColor]').value
	+"&SITE[shopCartLabelHeight]="+$('SITE[shopCartLabelHeight]').value
	+"&SITE[payBlockTitleBgColor]="+$('SITE[payBlockTitleBgColor]').value
	+"&SITE[payBlockTitleTextColor]="+$('SITE[payBlockTitleTextColor]').value
	+"&SITE[shopFeaturedShown]="+shopFeaturedShown
	+"&SITE[shopCartBottomPics]="+shopCartBottomPics
	+"&SITE[productPicWidth]="+$('SITE[productPicWidth]').value
	+"&SITE[productPicHeight]="+$('SITE[productPicHeight]').value
	+"&SITE[shopRelatedPosition]="+$('SITE[shopRelatedPosition]').value
	+"&SITE[shopRelatedProductsTitle]="+$('SITE[shopRelatedProductsTitle]').value
	+"&SITE[shopProductsPageDiscountColor]="+$('SITE[shopProductsPageDiscountColor]').value
	+"&SITE[shopProductsPageDiscountPriceColor]="+$('SITE[shopProductsPageDiscountPriceColor]').value
	<? } ?>;
	
	var url = '<?=$SITE[url];?>/Admin/saveStyle.php';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEditStyle, onFailure:failedEdit,onLoading:savingChangesMeta});
	window.setTimeout('ReloadPage()',800);
}
function ShowLegend(id) {
	if($(id).style.display=="none") $(id).show();
	else $(id).hide();
}
function EditMeta() {
	var MetaEditLayer=document.getElementById("topMetaTags");
	if (MetaEditLayer.style.display=="none") Effect.SlideDown("topMetaTags",{duration:0.3});
		else  Effect.SlideUp("topMetaTags",{duration:0.3});
	//jQuery(MetaEditLayer).toggle("SlideDown");
	
}
function EditUsersPerms() {
	url="<?=$SITE[url];?>/Admin/GetUsersPerms.php?cID=<?=$CHECK_CATPAGE[parentID];?>";
	var userPermsEditLayer=document.getElementById("topUsersPerms");

	DivMessage='<div style="height:100px;padding-top:50px;" align="center"><img src="<?=$SITE[url];?>/Admin/images/loading_2.gif" /></div>';
	jQuery('#UsersPerms').html(DivMessage);
	if (userPermsEditLayer.style.display=="none") Effect.SlideDown("topUsersPerms",{duration:0.3});
		else  Effect.SlideUp("topUsersPerms",{duration:0.3});
	jQuery("#UsersPerms").load(url);
	//Effect.ScrollTo("TopHead",{duration:0.5}); in case position is not fixed
}
function EditStyle() {
	var StyleEditLayer=document.getElementById("topStyleEditor");
	DivMessage='<div style="height:100px;padding-top:50px;" align="center"><img src="<?=$SITE[url];?>/Admin/images/loading_2.gif" /></div>';
	document.getElementById("StyleEditDiv").innerHTML=DivMessage;
	if (StyleEditLayer.style.display=="none") {
		url="<?=$SITE[url];?>/Admin/GetStyleEditor.php?cID=<?=$CHECK_CATPAGE[parentID];?>&isParentMainPicSideText=<?=$P_DETAILS[MainPicSideText];?>";
		
		Effect.SlideDown("topStyleEditor",{duration:0.3});
		Effect.ScrollTo("TopHead",{duration:0.5});
		window.setTimeout("GetRemoteHTML('StyleEditDiv');",100);
		
	}
		else  Effect.SlideUp("topStyleEditor",{duration:0.3});
	
	
}
function getPageScroll(){
	var yScroll;
	if (self.pageYOffset) {
		yScroll = self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
		yScroll = document.documentElement.scrollTop;
	} else if (document.body) {// all other Explorers
		yScroll = document.body.scrollTop;
	}

	arrayPageScroll = new Array('',yScroll) 
	return arrayPageScroll;
}

function getPageSize(){
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}

	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){	
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}


	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) 
	return arrayPageSize;
}
function ScrollDetect() {
	var arrayScroll=getPageScroll();
	var scrollTop=arrayScroll[1];
	document.getElementById("TopAdminLabel").style.top=scrollTop-1+"px";	;
	//document.TopAdminLabel.top=scrollTop-1;
}
Object.extend(Element, {
	getWidth: function(element) {
	   	element = $(element);
	   	return element.offsetWidth; 
	},
	getHeight: function(element) {
	   	element = $(element);
	   	return element.offsetHeight; 
	},
	setWidth: function(element,w) {
	   	element = $(element);
    	element.style.width = w +"px";
	},
	setHeight: function(element,h) {
   		element = $(element);
    	element.style.height = h +"px";
	},
	setTop: function(element,t) {
	   	element = $(element);
    	element.style.top = t +"px";
	},
	setLeft: function(element,t) {
	   	element = $(element);
    	element.style.left = t +"px";
	},
	setSrc: function(element,src) {
    	element = $(element);
    	element.src = src; 
	},
	setHref: function(element,href) {
    	element = $(element);
    	element.href = href; 
	},
	setInnerHTML: function(element,content) {
		element = $(element);
		element.innerHTML = content;
	}
});
//window.onscroll=ScrollDetect;
//window.onresize=ScrollDetect;
function GetPosition(e) {
	var posx = 0;
	var posy = 0;
	if (!e) var e = window.event;
	if (e.pageX || e.pageY) 	{
		posx = e.pageX;
		posy = e.pageY;
	}
	else if (e.clientX || e.clientY) 	{
		posx = e.clientX + document.body.scrollLeft
			+ document.documentElement.scrollLeft;
		posy = e.clientY + document.body.scrollTop
			+ document.documentElement.scrollTop;
	}
	mousePOS=new Array(posx,posy);
	// posx and posy contain the mouse position relative to the document
	// Do something with this information
	return mousePOS;
}
function loadingStyles(TargetDiv) {
	if (DivMessage) document.getElementById(TargetDiv).innerHTML=DivMessage;
}
function GetRemoteHTML(TargetDiv) {
	
	if (TargetDiv) var TargetDATA=document.getElementById(TargetDiv);
	var pars=remotePars;
	var myAjax = new Ajax.Request(url, {method: 'post',postBody:pars,onSuccess: function(transport){
	     var response = transport.responseText;
	   	 if (TargetDiv)  TargetDATA.innerHTML=response;
	       },onFailure:failedEdit,onLoading:function () {loadingStyles(TargetDiv)}
	    });
}
var mins = 42;
var secs = mins * 60;
var currentTitle=document.title;
function countdown() {
	setTimeout('Decrement()',1000);
}

function Decrement() {
	if (document.getElementById) {
		minutes = document.getElementById("time_out_min");
		seconds = document.getElementById("time_out_sec");
		// if less than a minute remaining
		if (seconds < 59) {
			seconds.value = secs;
		} else {
			minutes.value = getminutes();
			seconds.value = getseconds();
		}
		secs--;
		if (minutes.value < 1 && seconds.value<1) alert("המערכת יצאה ממצב ניהול \n שמירת שינויים לא תבוצע !");
		else setTimeout('Decrement()',1000);
		if (minutes.value == 5 && seconds.value<1) {
			Effect.BlindDown('BottomAdminMessages');
			
		}
	}
	
}
function getminutes() {
	// minutes is seconds divided by 60, rounded down
	mins = Math.floor(secs / 60);
	return mins;
}
function getseconds() {
	// take mins remaining (as seconds) away from total seconds remaining
	return secs-Math.round(mins *60);
}
var origTitle=false;
function showAdminAlertTimeout() {
	  jQuery("#BottomAdminMessages").show();
	  TimePassed=1;
	  jQuery("#timeLeft").fadeIn(100).fadeOut(100).fadeIn(100);
	  if (origTitle) {
		document.title=currentTitle;
		origTitle=false;
	  }
	  else {
		document.title="System Message";
		origTitle=true;
	  }
}

function setMainPicSideTextGlobal(cID) {
	var checked_sidetext;
	if($('mainPicSideText').checked) checked_sidetext=1;
		else checked_sidetext=-1;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'action=setMainPicSideText&isInherit='+checked_sidetext+'&catID='+cID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
}
function setPageMobileHomepage(cID) {
	var checked_MobileHome;
	if($('setMobileHomepage').checked) checked_MobileHome=1;
		else checked_MobileHome=0;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'action=setMobileHomePage&isMobileHome='+checked_MobileHome+'&catID='+cID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
}
function setTopMenuHide(cID) {
	var checked_hidetopmenu;
	if($('HideTopMenu').checked) checked_hidetopmenu=1;
		else checked_hidetopmenu=0;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'action=setTopMenuHidden&isHidden='+checked_hidetopmenu+'&catID='+cID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
}
function setMainHeaderGalleryWidth(cID,w) {
	var selected_pageMainPicWidth=jQuery(w).val();
	setCatStyleProperty(cID,selected_pageMainPicWidth,"MainPicWidthMode");
}
function setHiddenCartHere(cID) {
	var checked_hidetcart;
	if($('hideShopCart').checked) checked_hidetcart=1;
		else checked_hidetcart=0;
	setCatStyleProperty(cID,checked_hidetcart,"HideShopCart");
}
function setShownCartHere(cID) {
	var checked_showtcart;
	if($('showShopCart').checked) checked_showtcart=1;
		else checked_showtcart=0;
	setCatStyleProperty(cID,checked_showtcart,"ShowShopCart");
}
function setCatStyleProperty(cID,v,p) {
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'action=setCatStyleProperty&catID='+cID+'&property_type='+p+'&val='+v;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
}
function changeFontSample(f) {
	//jQuery("head").append('<style>@import url(http://fonts.googleapis.com/css?family='+f+'</style>');
	iframe_font_sample.location.href="/Admin/iframeFontSample.php?font="+f;
}
</script>

<div id="topMetaTags" dir="ltr" style="display:none;z-index:1000;">
<div class="MetaEdit" align="center">
<strong><?=$ADMIN_TRANS['edit meta tags'];?></strong>
<br />
<table class="general" border="0" cellspacing="5">
<tr>
<td align="left"><?=$ADMIN_TRANS['title tag'];?></td>
<td align="right"><textarea class="MetaEditFrm" name="PageTagTitle" id="PageTagTitle"><?=$P_DETAILS[TagTitle];?></textarea></td>
</tr>
<tr>
<td align="left"><?=$ADMIN_TRANS['description tag'];?></td>
<td align="right"><textarea class="MetaEditFrm" name="PageDescription" id="PageDescription"><?=$P_DETAILS[PageDescribtion];?></textarea></td>
</tr>
<tr>
<td align="left"><?=$ADMIN_TRANS['keywords'];?></td>
<td align="right"><sub><?=$ADMIN_TRANS['seperate with comma'];?></sub><br /><textarea class="MetaEditFrm" name="PageKeywords" id="PageKeywords"><?=$P_DETAILS[PageKeywords];?></textarea></td>
</tr>

<tr style="display:<?=$show_additional_metatags;?>">
<td align="left"><?=$ADMIN_TRANS['additional meta tags'];?></td>
<td align="right"><textarea class="MetaEditFrm" name="AdditionalMetaTags" id="AdditionalMetaTags" dir="ltr"><?=$P_DETAILS[MetaTags];?></textarea></td>
</tr>
<tr><td colspan="10"></td></tr>
<tr style="display:<?=$show_additional_code;?>">
<td align="left"><?=$ADMIN_TRANS['site wide css/js code'];?></td>
<td align="right"><textarea class="MetaEditFrm" name="css_js_code" id="css_js_code" dir="ltr"><?=$SITE[addon_code];?></textarea></td>
</tr>
<tr>
	<td align="left"><?=$ADMIN_TRANS['block page from search engines'];?></td>
	<td align="right">
		<div class="onoffswitch">
			<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="isSEBlocked" <?=$isSEBlockedChecked;?>>
			<label class="onoffswitch-label" for="isSEBlocked">
			    <div class="onoffswitch-inner"></div>
			    <div class="onoffswitch-switch"></div>
			</label>
		    </div>

	</td>
</tr>
</table>

<div style="width:300px;hight:10px;padding-top:10px;padding-right:5px;text-align:right;cursor:pointer">
<div class="greenSave" id="newSaveIcon" onclick="SaveMeta();"><img align="absmiddle" src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" /><?=$ADMIN_TRANS['save changes'];?></div>
&nbsp;&nbsp;&nbsp;<div id="newSaveIcon" onclick="EditMeta();"><?=$ADMIN_TRANS['close'];?></div>
&nbsp;&nbsp;<span id="LoadingDivMeta"></span>
</div>
<br /><br />
</div>
</div>

<div dir="ltr" id="topUsersPerms" style="display:none;z-index:1000;text-align:center">
	<div class="UsersPerms" align="<?=$SITE[align];?>" id="UsersPerms"></div>
</div>
<div dir="ltr" id="topStyleEditor" style="display:none;z-index:1001;text-align:center">
	<div class="StyleEdit" align="<?=$SITE[align];?>" id="StyleEditDiv"></div>
</div>
<div class="BottomAdminMessages" id="BottomAdminMessages" align="center" style="display:none">
	<div class="BottomAdminBG">
	 :שים/י לב ! . המערכת תצא ממצב עריכה בעוד  
	<br><br>
	
		<span id="timeLeft"></span>
	<br>
	לביטול וחזרה לעריכה <a href="">לחץ/י כאן.</a>
	</div>
</div>
<script language="javascript">
//countdown();

</script>
<script>
	var timeLeft;
	var TimePassed=0;
	function checkLoggedInTimeout() {
		var url="<?=$SITE[url];?>/Admin/GetSessionTime.php?startTime=<?=time();?>";
		jQuery("#timeLeft").load(url);
		//console.log(timeLeft);
	}
	//checkLoggedInTimeout();
	var intervalAdminExit=setInterval("checkLoggedInTimeout()",30000);
</script>
<div class="adminAction">
	<div class="add newpage sub"><i class="fa fa-files-o"></i>
		<div class="label">New Sub page</div>
	</div>
	<div class="add newpage"><i class="fa fa-file"></i>
		<div class="label">New Page</div>
	</div>
	<div class="add">+
		<div class="label">New Page</div>
	</div>

</div>
<div class="admin_settings"><i class="fa fa-cogs"></i>
<div class="label">Setttings</div>
</div>
<style type="text/css">.masterHeader_wrapper{margin-top:47px;}</style>