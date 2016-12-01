<?
include_once("../config.inc.php");
include_once("../inc/GetServerData.inc.php");
include_once("../defaults.php");
include_once("lang.admin.php");

?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style type="text/css">

.ui-slider.ui-slider-horizontal {height:2px;background-color:#333;background-image:none;margin: 8px}
.ui-widget-content.ui-slider-horizontal {border:0px;}
a.ui-slider-handle.ui-corner-all {top:-0.5em;outline:none;border-bottom-right-radius:0;border-bottom-left-radius:0;border-top-left-radius:0;border-top-right-radius:0;width:14px;height:14px;border-radius: 100%;background-image:none;background-color: #333;}

.main-settings-container {height:auto;overflow-y:auto;overflow-x:hidden;text-align: <?=$SITE[align];?>}
.head_options{background-color: #f1f1f1;padding:0;box-sizing:border-box;width:100%;height:38px;border-bottom:1px solid #000;}
.head_options div {cursor:pointer;word-wrap:nowrap;float:<?=$SITE[align];?>;padding:8px;margin:0 1px;min-width:50px;height:21px;background-color: #f1f1f1;text-align: center;font-size: 14px;border-left:1px solid silver;}
.head_options div i.fa{font-size:16px;}
.head_options div.selected, .head_options div:hover{background-color: #333;color:#fff;transition:color 0.4s}

.head_options div#design {display: <?=($SITE['isFullResponsive']) ? '' : 'none';?>}
.seo_settings {direction: <?=$SITE_LANG[direction];?>;margin:10px;}
.seo_settings .advanced {visibility: hidden;transition:all 0.2s;height:0px;}
.seo_settings .advanced textarea {direction: ltr;font-family: courier}
.seo_settings .advanced.show {visibility: visible;height: auto}
.seo_settings .title {font-size:16px;font-family: inherit;margin:20px 0px 0px;background-color: silver;padding:3px;cursor: pointer}
.seo_settings label.in {padding-top:10px;display: block;}
.seo_settings textarea{outline:none;direction: <?=$SITE_LANG[direction];?>;width:98%;min-height:80px;padding:5px;border:1px solid silver;font-size:14px;}
.seo_settings textarea#MetaTagTitle{min-height: 50px}
.saveButtonsNew #newSaveIcon.newSave {border-radius: 0px;-webkit-border-radius:0px;width:44%;height:25px;box-shadow: none;font-family: inherit;font-size: 20px;float:left;}
.saveButtonsNew #newSaveIcon.newSave.cancel {float:right;background-color:#efefef }
.saveButtonsNew{position:fixed;bottom:1px;width:100%;}
.mobileViewSelector{width:170px;margin:10px;border:1px solid #333;padding:5px;outline: none;font-size: inherit;font-family: inherit;}
.pageStructureInner i {font-size: 2.5em;color:silver;}
.pageStructureInner.entranceEffects > div {width:58px;height: 70px;font-size: 14px;}
.pageStructureInner.entranceEffects > div i.second{position:relative;margin:-2px;font-size: 23px;bottom:5px;}
.pageStructureInner >div.rotate i {transform: rotate(90deg);font-size: 38px}
.pageStructureInner >div i.fa.fa-pause {font-size:38px;}
.pageStructureInner>div {border:1px solid #e4e4e4;margin-<?=$SITE[opalign];?>:25px;margin-<?=$SITE[align];?>:0px;margin-top:25px;margin-bottom:  0px;display:block;width:106px;background-color: #efefef;float:<?=$SITE[align];?>;padding:5px;cursor:pointer;height:72px;}
.pageStructureInner div label{display: block;word-wrap:nowrap;font-size: 15px}
.pageStructureInner {width:550px;text-align: center;margin:15px auto;}
.pageStructureInner>div:hover, .pageStructureInner>div.selected, .pageStructureInner>div.selected i {background-color: #b3babf;color:white;}
.pageStructureInner>div:hover i {color:white;}
.pageStructureInner>div.selected.remove {background-color: #efefef;color:gray;}
.pageStructureInner.template i {font-size: 2em;color:silver;display: block;}
.pageStructureInner.social i {font-size: 1.7em;margin-bottom:5px;}
.pageStructureInner.template>div{width:106px;}
.pageStructureInner>div.title, .sideMenuAdminWrapper>div.title{display: block;float: none;width:98%;margin:0 auto;font-family: inherit;height:auto;background-color: #dce5eb;font-size: 18px}
.pageStructureInner>div.last{margin-<?=$SITE[opalign];?>:0px;}
 div.title:hover {background-color: #dce5eb;color:inherit;}
.templateSettings table {width:100%;border-collapse: collapse;background-color: #fff;box-sizing:border-box;}
.templateSettings table tr{vertical-align: middle;}
.templateSettings table tr td{min-height:20px;padding:3px;height:30px;border:3px solid #eee;}
.templateSettings table tr td input {height:15px;padding:3px;outline-color: black;outline-width: 1px;}
.templateSettings table tr td input.pick {
	margin:0;
	padding:5px;
	border:0;
	height:20px;
	border-left:30px solid #efefef;
	line-height:25px;
	width:50px;cursor: pointer;
	background-color: #c5c5c5;

}
.colpick{z-index: 3000}
.globalSettingsWrapper.draggable, .globalSettingsWrapper.draggable .main-settings-container {overflow: inherit;}
.globalSettingsWrapper.draggable .pageStructureInner.template{width:120px;overflow: inherit;}
.globalSettingsWrapper.draggable  .saveButtonsNew{display: none;height:0px;}
.globalSettingsWrapper.draggable .pageStructureInner.template>div.ui-draggable{margin:10px 10px;cursor: move}
.globalSettingsWrapper.draggable .pageStructureInner.template>div.title {margin:0px 0px 10px;position: absolute;z-index:-2;top:0;right: 0;padding:10px 0px;}
.globalSettingsWrapper.draggable .pageStructureInner.template>div.title .title.arrow {position: absolute;left:45%;margin-top:2px;width:15px;height: 15px;background-color: inherit;padding:0px;-webkit-transform:rotate(45deg);z-index:-3;}
.metaCount{float:<?=$SITE[opalign];?>}
.catEdit {margin:10px;}
#catHelper {padding:3px;width:99.6%;background-color: #efefef;font-size: 13px;transition:all 0.2s;height: 0px;visibility: hidden;margin-top:1px;}
#catHelper.show{height: 56px;visibility: visible;}
#catHelper .newCatTreeHelper{display: block;font-weight: bold;margin-<?=$SITE[align];?>:15px;}
#catHelper .newCatTreeHelper.sub {}
#catHelper .subPageDemo {width: 31%;margin: 0 2px;background-color: #efefef;display: inline-block;float:<?=$SITE[align];?>}
#catHelper .subPageDemo.selected {background-color: white;}
.sideMenuAdminWrapper ul li a {color:#333;font-size: 17px;}
.sideMenuAdminWrapper {text-align: center;}
.sideMenuAdminWrapper ul.SideMenu li label.sideMenuEditTools {width:140px;}
.tip {clear: both;width:100%;box-sizing:border-box;margin:0 10px;}
.tip i.fa-bell-o{color:red;margin:10px;font-size:20px;}
.tip.submenu i.fa-bell-o{float:<?=$SITE[align];?>;margin:10px;}
.bottom {margin-top:40%;}
</style>
<?
$actionShow=$_GET['action'];
$urlKey=urldecode($_GET['urlKey']);

$isChildPage=0;
$P_ID=GetIDFromUrlKey($urlKey);

$fb_object_id=$P_ID[parentID];
$metaTagsLimits=array(
	'title'=>55,
	'description'=>155,
	'keywords'=>400
);
$CHECK_PAGE=GetPageIDFromUrlKey($urlKey);

if ($CHECK_PAGE[parentID]>0 AND $_GET['is_inner_page']==1) {
	$actionShow="SEO";
	$isChildPage=1;
	$P_ID[parentID]=$CHECK_PAGE[parentID];
}
if($CHECK_PAGE['ProductID'] > 0 AND $_GET['is_inner_page']==1) $P_DETAILS=GetMetaData($CHECK_PAGE['ProductID'],2);
else {
	$P_DETAILS=GetMetaData($P_ID[parentID],1);
	if ($CHECK_PAGE[parentID]>0 AND $_GET['is_inner_page']==1) $P_DETAILS=GetMetaData($CHECK_PAGE[parentID]);
}
$PARENT_P_DETAILS=GetMetaData($P_DETAILS[ParentID],1);

//if (!$P_DETAILS[TagTitle] AND $_GET['is_inner_page']==0) $P_DETAILS[TagTitle]=$P_DETAILS[MenuTitle];
if (!$P_DETAILS[PageDescribtion] AND $CHECK_PAGE AND $_GET['is_inner_page']==1)  $P_DETAILS[PageDescribtion]=$P_DETAILS[PageTitle];

if (!$P_DETAILS[PageDescribtion]) $P_DETAILS[PageDescribtion]=$SITE[description];
if (!$P_DETAILS[PageKeywords]) $P_DETAILS[PageKeywords]=$SITE[keywords];
if (!$P_DETAILS[TagTitle] AND $_GET['is_inner_page']==0) $P_DETAILS[TagTitle]=$P_DETAILS[MenuTitle]." - ".$SITE[title];
if ($CHECK_PAGE AND !$P_DETAILS[TagTitle] AND $_GET['is_inner_page']==1) $P_DETAILS[TagTitle]=$P_DETAILS[PageTitle]." - ".$SITE[title];

if ($actionShow=="") $actionShow="pagetructure";
$isLeftColumn=GetCatStyle("ShowLeftColumn",$P_ID[parentID]);
$entranceEffect=GetCatStyle("ContentEntranceEffect",$P_ID[parentID]);
$data_left_col="8";
$ShowLeftColumnLabel=$ADMIN_TRANS['add right/left column'];
$ADMIN_TRANS['social']="Social Networks";
$ADMIN_TRANS['switch to slides']="Slides Gallery";
$ADMIN_TRANS['social_intro']="Add Social widgets for current page";
$ADMIN_TRANS['social_types']=array("Like Button","Like button for this page","Share button","Like box","Comments","Remove facebook","Remove Goolgle+","Add Google+ button","Facebook Comments & Like+Share");
$ADMIN_TRANS['page and template']="Structure";
$ADMIN_TRANS['advanced']="Advanced";
$ADMIN_TRANS['page_name']="Page Name";
$ADMIN_LABEL['changeCatUrl']="Change Also Page URL to ";
$ADMIN_TRANS['catHelper_arrow']="&rdsh;";
$ADMIN_TRANS['hidden category']="Hide Page";
$ADMIN_TRANS['move category']="Move page";
$ADMIN_TRANS['edit page']="Edit page";
$ADMIN_TRANS['subpages']="Sub-Menu";
$ADMIN_TRANS['open_as_side_cat']=array("Create subpage","Create same-level page","Create top page");
$ADMIN_TRANS['choose template']="Choose Template";
$ADMIN_TRANS['choose page structure']="Choose page structure";
$ADMIN_TRANS['social remarks']="Facebook comments require you to open a <a target='_new' href='http://guide.exite.co.il/category/facebook-integration'>facebook APP !</a>";
$ADMIN_TRANS['submenu remarks']="Here you can Edit OR Delete Subpages that are hidden due to the current page structure.";
$ADMIN_TRANS['fullwidepage']="Full Screen Page";
$ADMIN_TRANS['entrance_effect']="Reveal effect for content/photos blocks";
if ($SITE_LANG['selected']=="he") {
	$ADMIN_TRANS['fullwidepage']="מסך מלא";
	$ADMIN_TRANS['advanced']="מתקדם";
	$ADMIN_TRANS['page and template']="מבנה/ותבנית";
	$ADMIN_TRANS['switch to slides']="גלריית תמונות מתחלפות";
	$ADMIN_TRANS['social']="רשתות חברתיות";
	$ADMIN_TRANS['social_intro']="הוספת תוספי רשתות חברתיות לעמוד הנוכחי";
	$ADMIN_TRANS['social_types']=array("כפתור לייק","לייק לעמוד הנוכחי","כפתור שתף","תיבת מעריצים","תגובות פייסבוק","הסר תוספי פייסבוק","הסר גוגל+","הוסף גוגל+","תגובות פייסבוק+לייק ושיתוף");
	$ADMIN_TRANS['page_name']="שם עמוד";
	$ADMIN_TRANS['edit page']="עריכת עמוד";
	$ADMIN_LABEL['changeCatUrl']="האם לשנות גם את כתובת העמוד ל ";
	$ADMIN_TRANS['catHelper_arrow']="&ldsh;";
	$ADMIN_TRANS['hidden category']="הסתר עמוד";
	$ADMIN_TRANS['move category']="העבר עמוד";
	$ADMIN_TRANS['open_as_side_cat']=array("צור כתת-עמוד","צור עמוד באותה רמה","צור עמוד ראשי");
	$ADMIN_TRANS['subpages']="תתי תפריטים";
	$ADMIN_TRANS['choose template']="בחירת תבנית לעמוד זה";
	$ADMIN_TRANS['choose page structure']="בחירת מבנה לעמוד זה";
	$ADMIN_TRANS['social remarks']="כדי לאפשר תגובות פייסבוק עליכם להגדיר <a target='_new' href='http://guide.exite.co.il/category/facebook-integration'>אפליקציה בפייסבוק</a>";
	$ADMIN_TRANS['submenu remarks']="כאן תוכלו לערוך או למחוק תתי-עמודים המשויכים לעמוד האב הנוכחי אך מוסתרים בתצוגת העמוד עקב המבנה הרחב של העמוד.";
	$ADMIN_TRANS['entrance_effect']="אפקט הופעת יחידות התוכן/תמונות";
}

if ($isLeftColumn==1) {$selectedPageStyle[8]="selected";$data_left_col="-8";$ShowLeftColumnLabel=$ADMIN_TRANS['remove right/left column'];}
$is_fb_page=$is_fb_product=0;
if($P_ID[ProductID] > 0)
{
	$is_shop=true;
	$pID = $P_ID[ProductID];
}

if ($CHECK_PAGE[parentID]) {
	$is_fb_page=$fb_object_id=$CHECK_PAGE[parentID];
	if ($CHECK_PAGE[productUrlKey]) $is_fb_product=$is_fb_page=$fb_object_id=$CHECK_PAGE[galleryID];
}
$selectedFBType[$P_DETAILS[FB_WIDGET]]="selected";
$selectedGoogleType[$P_DETAILS[G_WIDGET]]="selected";

$isSEBlockedChecked="";
if ($P_DETAILS['SEBlock']==1) $isSEBlockedChecked="checked";
if ($actionShow=="addPage" AND $_GET['isMenuTop']==1) $P_ID[parentID]=0;
//print_r($P_DETAILS);;
?>

<div class="head_options">
	<?
	if ($actionShow!="addPage") {
		?>
		<div id="design"><i class="fa fa-crop"></i> עיצוב </div>
		<div class="selected" id="pagetructure"><i class="fa fa-tasks"></i> <?=$ADMIN_TRANS['page and template'];?> </div>
		<div id="SEO"><i class="fa fa-tags"></i> SEO </div>
		<div id="social"><i class="fa fa-share-alt"></i> <?=$ADMIN_TRANS['social'];?> </div>
		<div id="editPage"><i class="fa fa-file-text"></i> <?=$ADMIN_TRANS['page_name'];?></div>
    	<div id="moveCatLocation" class="noloadtab"  onclick="startChangeCatLocation()"><i class="fa fa-arrow-<?=$SITE[opalign];?>"></i> <?=$ADMIN_TRANS['move category'];?></div>
    	<?if ($P_DETAILS['PageStyle']==1) {
    		?>
    		<div id="submenu" style="display:"><i class="fa fa-align-<?=$SITE[align];?>"></i> <?=$ADMIN_TRANS['subpages'];?> </div>
    		<?
    		}
			
		}
		else {
			?>
			<div id="addPage"><i class="fa fa-file"></i> <?=$ADMIN_TRANS['add new page'];?></div>
			<?
		}
	
	?>
</div>
<br>

<script>
var GlobalAction="<?=$actionShow;?>";
var currentCatEditedID="<?=$P_ID[parentID];?>";
var AvaliableAnchors={'mainContentAnchor':'MainContent'};
var bCount=0;
var is_child_page="<?=$isChildPage;?>";
jQuery(".mainContent ul#boxes li[id]",document).each(function () {
	bCount++;
	var elIDFound=jQuery(this).attr("id");
	var briefTitle=jQuery(this).find(".shortContentTitle").text().replace('\n\r','');
	if (briefTitle=="") briefTitle="תקציר מספר "+bCount;
	AvaliableAnchors[elIDFound]=briefTitle;
});
jQuery.each(AvaliableAnchors, function(key, value) {   
     //console.log(value);
});
function countChar(val,elementUpdateID,maxChars){
     var len = val.value.length;
     if (len >= maxChars) {
              val.value = val.value.substring(0, maxChars);
     } else {
              jQuery('#'+elementUpdateID).text(maxChars - len);
     }
};
function saveSocialAddOns() {
	var fb_selected=0;
	var fb_selected=jQuery(".pageStructureInner.social.facebook div.selected").attr("data-social-fb");
	var google_selected=jQuery(".pageStructureInner.social.google div.selected").attr("data-social-google");
	ButtonSavingChanges(1,0);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=changeFBWidget';
	var url2 = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=changeGWidget';
	var pars = 'update_catID=<?=$P_ID[parentID];?>&widgetType='+fb_selected+'&fb_is_page='+fb_is_page+'&is_fb_product=<?=$is_fb_product;?>';
	var pars2 = 'update_catID=<?=$P_ID[parentID];?>&widgetType='+google_selected+'&fb_is_page='+fb_is_page+'&is_fb_product=<?=$is_fb_product;?>';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	var myAjax = new Ajax.Request(url2, {method:'post', postBody:pars2, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});

	ButtonSavingChanges(0,1);
}
function saveChangesToTemplate() {
	var subtype=0;
	var c_type_choosed=jQuery(".pageStructureInner.template div.selected").attr("data-template");
	var pageStyle_choosed=jQuery(".pageStructureInner.pageStyle div.selected").attr("data-pagestyle");
	var content_entrance_choosed=jQuery(".pageStructureInner.entranceEffects div.selected").attr("data-entrance-effect");
	if (c_type_choosed==4) {c_type_choosed=2;subtype=3}
	ButtonSavingChanges(1,0);
	jQuery.get('<?=$SITE[url];?>/Admin/saveContentinplace.php?action=change_ctype&update_catID='+<?=$P_ID[parentID];?>+'&cType='+c_type_choosed+'&subType='+subtype,function(){
		ButtonSavingChanges(0,0);
	});
	if (pageStyle_choosed==8 || pageStyle_choosed==-8) {
		if (pageStyle_choosed==8) setCatStyleProperty(<?=$P_ID[parentID];?>,1,"ShowLeftColumn");
		if (pageStyle_choosed==-8) setCatStyleProperty(<?=$P_ID[parentID];?>,-1,"ShowLeftColumn");
		ButtonSavingChanges(0,1);
	}
	else {
		jQuery.get('<?=$SITE[url];?>/Admin/saveContentinplace.php?action=change_pagestyle&update_catID='+<?=$P_ID[parentID];?>+'&pageStyle='+pageStyle_choosed,function(){
		ButtonSavingChanges(0,1);
		});
	}
	if (content_entrance_choosed!="<?=$entranceEffect;?>") {
		setCatStyleProperty(<?=$P_ID[parentID];?>,content_entrance_choosed,'ContentEntranceEffect'); 
	}
	
	
}
function changeTemplateTo(what) {
	jQuery(what).parent().find("div").removeClass("selected");
	jQuery(what).addClass("selected");
	if (jQuery(what).attr("data-pagestyle")<0) jQuery(what).addClass("remove");
}	
function chooseTabSettings(i) {
	jQuery(".head_options div").removeClass("selected");
	jQuery(".head_options #"+i).addClass("selected");
	
}
function ButtonSavingChanges(s,refresh,close_settings) {
	if (s) jQuery(".newSave.greenSave i.fa").addClass("fa-spinner").removeClass("fa-save").addClass("fa-spin");
	else jQuery(".newSave.greenSave i.fa").addClass("fa-check").removeClass("fa-spinner").removeClass("fa-spin");
	if (close_settings==1) jQuery(".globalSettingsWrapper").removeClass("show");
	if (refresh==1) window.setTimeout("ReloadPage()",800);
}
function saveNewPage() {
	var currentCatAction="saveCat";
	if (GlobalAction=="editPage") currentCatAction="rename"; 
	var isHiddenMenu=jQuery("#hiddenMenu:checked").length;
	if (isHiddenMenu) isHiddenMenu=0;
	else isHiddenMenu=1;
	var mobileViewSelected=jQuery("#mobileView").val();
	var richTextPopup=jQuery("#showRichTextCheck").val();
	var newCatName=jQuery("#NewCatName").val();
	var newUrlKey=jQuery('#NewUrlKey').val();
	var newCatLink=jQuery("#NewCatLink").val();
	var currentCatName="<?=htmlspecialchars($P_DETAILS[MenuTitle]);?>";
	newCatLink=encodeURIComponent(newCatLink);
	var catParentID='<?=$P_ID[parentID];?>';
	if (jQuery("input#is_subcat:checked").val()==0) catParentID='<?=$P_DETAILS[ParentID];?>';
	if (jQuery("input#is_subcat:checked").val()==2) catParentID=0;
	ButtonSavingChanges(1,0);
	if (currentCatName!=newCatName && currentCatAction=="rename") {
		jQuery('#menu_item-'+currentCatEditedID).html(newCatName);
		var ask=confirm("<?=$ADMIN_LABEL['changeCatUrl'];?>'"+decodeURIComponent(newCatName)+"' ?");
		if (ask) newUrlKey=newCatName;
	}
	jQuery.post('<?=$SITE[url];?>/Admin/saveContentinplace.php',{action:currentCatAction,newCatName:encodeURIComponent(newCatName),newCatLink:newCatLink,catParentID:catParentID,catPageID:<?=$P_ID[parentID];?>,viewStatus:isHiddenMenu,newUrlKey:newUrlKey,orderCat:0,mobileView:mobileViewSelected,richTextPopup:richTextPopup},function(data){
	var newSavedCatID=data;
	if (currentCatAction=="saveCat") {
			var subtype=0;
			var c_type_choosed=jQuery(".pageStructureInner.template div.selected").attr("data-template");
			if (c_type_choosed==4) {c_type_choosed=2;subtype=3}
			if (c_type_choosed!="") jQuery.get('<?=$SITE[url];?>/Admin/saveContentinplace.php?action=change_ctype&update_catID='+newSavedCatID+'&cType='+c_type_choosed+'&subType='+subtype,function(){
					ButtonSavingChanges(0,1);
				});
			else ButtonSavingChanges(0,1);
		}
		else {
			
			ButtonSavingChanges(0,0,1);
		}
	});
	
}
function saveSerializeForm(fName,url) {
	var data=jQuery("form#"+fName).serialize();
	var isSE_BLOCKED=jQuery("input#isSEBlocked:checked").length;
	if (is_child_page=="1") data+="&action=saveMeta&pageID=<?=$P_ID[parentID];?>&isSE_BLOCKED="+isSE_BLOCKED;
	else data+="&action=saveMeta&catParent=<?=$P_ID[parentID];?>&isSE_BLOCKED="+isSE_BLOCKED;
	
	ButtonSavingChanges(1);
	jQuery.get(url+"?"+data,function(){ButtonSavingChanges(0,0,1);});
	
}
function updateCatHelper(g) {
	if (g.length>0) jQuery("#catHelper").addClass("show");
	else jQuery("#catHelper").removeClass("show");
	jQuery("#newCatNameHelper").text(g);
	jQuery("#newCatNameHelper.side").text(g);
	<?
	if ($P_DETAILS[ParentID]==0 AND $actionShow=="editPage") {
		?>jQuery('#menu_item-'+currentCatEditedID).text(g);<?
	}?>
}
jQuery(".head_options>div").click(function(){
	chooseTabSettings(this.id);
	if (jQuery(this).attr("id")!="moveCatLocation") jQuery(".globalSettingsWrapper.show #gSettingsInner").load("/Admin/GetGlobalSettings.php?urlKey=<?=$urlKey;?>&action="+this.id+'&is_inner_page=<?=$_GET['is_inner_page'];?>');
});
var fb_is_page="<?=$is_fb_page;?>";
</script>
<div class="main-settings-container">
<?

if ($_GET['action'] OR isset($actionShow)) {
	?>
	<script>
	chooseTabSettings("<?=$actionShow;?>");
	</script>
	<?
}
switch (1) {
	case $actionShow=='SEO':
	?>
		<div class="seo_settings">
			<form name="MetaTagsNew" id="MetaTagsNew">
				<label class="in" for="MetaTagTitle"><?=$ADMIN_TRANS['title tag'];?> <span class="metaCount" id="titleCount"><?=$metaTagsLimits['title'];?></span></label>
				<textarea id="MetaTagTitle" name="pageTT" onkeyup="countChar(this,'titleCount',<?=$metaTagsLimits['title'];?>);"><?=$P_DETAILS[TagTitle];?></textarea>

				<label class="in" for="PageDescribtion"><?=$ADMIN_TRANS['description tag'];?><span class="metaCount" id="descCount"><?=$metaTagsLimits['description'];?></span></label>
				<textarea id="PageDescribtion" name="pageDESC" onkeyup="countChar(this,'descCount',<?=$metaTagsLimits['description'];?>);"><?=$P_DETAILS[PageDescribtion];?></textarea>

				<label class="in" for="PageKeywords"><?=$ADMIN_TRANS['keywords'];?></label>
				<textarea id="PageKeywords" name="pageKY"><?=$P_DETAILS[PageKeywords];?></textarea>

				<div style="float:<?=$SITE[align];?>;margin-top:10px"><?=$ADMIN_TRANS['block page from search engines'];?></div>
				<div class="onoffswitch" style="float:left;margin:10px">
					<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="isSEBlocked" <?=$isSEBlockedChecked;?>>
					<label class="onoffswitch-label" for="isSEBlocked">
					    <div class="onoffswitch-inner"></div>
					    <div class="onoffswitch-switch"></div>
					</label>
		   		</div>
		   		<div style="clear:both"></div>
				<div class="title"><i class="fa fa-code"></i> <?=$ADMIN_TRANS['advanced'];?></div>
					
					<div class="advanced">
						<label class="in" for="PageKeywords"><?=$ADMIN_TRANS['additional meta tags'];?></label>
						<textarea class="autoExpand" id="AdditionalMetaTags" name="pageMT"><?=$P_DETAILS[MetaTags];?></textarea>
						<label class="in" for="PageKeywords"><?=$ADMIN_TRANS['site wide css/js code'];?></label>
						<textarea class="autoExpand" id="css_js_code" name="siteAddOnCode"><?=$SITE[addon_code];?></textarea>
						
					</div>
					
						
					
					
			</form>
		</div>
		<script type="text/javascript">
		//jQuery("input.goodcheckbox+label i").click(function(){jQuery(this).toggleClass("fa-toggle-on")});
		jQuery(".seo_settings .title").click(function(){jQuery(".seo_settings .advanced").toggleClass("show")});
		var theUrl='<?=$SITE[url];?>/Admin/saveContentinplace.php';
		jQuery("#newSaveIcon.newSave.greenSave").click(function() {saveSerializeForm("MetaTagsNew",theUrl)});
		
		</script>
	<?
	break;
	case $actionShow=='multipageAction':
	?>
		<div class="pageStructureInner template">
			<div class="title"><?=$ADMIN_TRANS['choose template'];?>
				<div class="title arrow"></div>
			</div>
			<br>
			<div data-template="11" class="<?=$selectedCatType[11];?>"><i class="fa fa-newspaper-o"></i><label><?=$ADMIN_TRANS['2-3 briefs per line'];?></label></div>
			<div data-template="21" class="rotate <?=$selectedCatType[21];?>"><i class="fa fa-tasks"></i><label><?=$ADMIN_TRANS['briefs collage'];?></label></div>
			<div data-template="2" class="<?=$selectedCatType[2];?>"><i class="fa fa-th"></i><label><?=$ADMIN_TRANS['photo/video gallery'];?></label></div>
			<div data-template="12" class="last <?=$selectedCatType[12];?>"><i class="fa fa-th-large"></i><label><?=$ADMIN_TRANS['brief under photo'];?></label></div>
			
			<div data-template="4" class="<?=$selectedCatType[4];?>"><i class="fa fa-photo"></i><label><?=$ADMIN_TRANS['switch to slides'];?></label></div>
			<div data-template="17" class="<?=$selectedCatType[17];?>"><i class="fa fa-check-square-o"></i><label><?=$ADMIN_TRANS['add form'];?></label></label></div>
		</div>
		<script>
		jQuery(".pageStructureInner.template>div").not(".title").draggable({
			containment: "document",
			revert: "invalid",
			helper: "clone",
			scroll: false
		});
		</script>
	<?
	break;
	case $actionShow=='pagetructure' OR $actionShow=="editPage" OR $actionShow=="addPage":

	if ($P_DETAILS['CategoryType']==2 AND isEffectGalleryPage($urlKey)) $selectedCatType[4]="selected";
		else $selectedCatType[$P_DETAILS['CategoryType']]="selected";
	if ($actionShow=="addPage" OR $actionShow=="editPage") {
		if ($actionShow=="addPage") {unset($selectedCatType);$P_DETAILS[MenuTitle]="";$selectedCatType[0]="selected";}
		
		if ($actionShow=="editPage") {
	        	?>
	    		<div class="CatLocationChooser" id="CatLocationChooser">
				<div><br><br><strong><?=$ADMIN_TRANS['choose parent category to move this category to'];?></strong></div>
				<div id="AllCatsContainerWrapper">
					<div class="search_cats"><input id="cat_s_q" type="text" results="10" placeholder="<?=$ADMIN_TRANS['filter by name'];?>" onkeyup="LoadAllCats(1);" /></div>
					<div id="AllCatsContainer">
						
						<div class="loadingCircle"><img src="<?=$SITE[url];?>/Admin/images/ajax-loader.gif" border="0" /></div>
					</div>
				</div>
				</div>
	    		<?
	    	}
	    	?>
		<div class="catEdit">
			<span id="AddCatTitle"><?=$ADMIN_TRANS['page_name'];?> </span><br />
			<input type="text" size="70" onkeyup="updateCatHelper(this.value);" id="NewCatName" name="NewCatName" dir="<?=$SITE_LANG[direction];?>" class="CatEditInputs" value="<?=htmlspecialchars($P_DETAILS[MenuTitle]);?>">
			<?
			if ($actionShow=="addPage" AND $_GET['isMenuTop']==0) {
        	?>
	        	<div id="catHelper">
	        		<div class="subPageDemo">
		        		<input type="radio" name="is_subcat" id="is_subcat" value="1" <?=($P_DETAILS[ParentID]==0) ? 'checked' : '';?> ><?=$ADMIN_TRANS['open_as_side_cat'][0];?>
		        		<div class="newCatTreeHelper sub"><?=$P_ID[title];?><br>&nbsp;&nbsp;<?=$ADMIN_TRANS['catHelper_arrow'];?><span id="newCatNameHelper"></span></div>
		        	</div>
		        	<div class="subPageDemo">
		        		<input type="radio" name="is_subcat" id="is_subcat" value="0" <?=($P_DETAILS[ParentID]>0) ? 'checked' : '';?>><?=$ADMIN_TRANS['open_as_side_cat'][1];?>
		        		<div class="newCatTreeHelper">-<?=$P_ID[title];?><br>-<span id="newCatNameHelper" class="side"></span></div>
		        	</div>
		        	<div class="subPageDemo">
		        		<input type="radio" name="is_subcat" id="is_subcat" value="2" <?=($P_DETAILS[ParentID]==0 AND $urlKey=="home") ? 'checked' : '';?>><?=$ADMIN_TRANS['open_as_side_cat'][2];?>
		        		<div class="newCatTreeHelper"><span id="newCatNameHelper" class="side"></span></div>
		        		<br>
		        	</div>
				</div>
	        <?}?>
	        <br /><br>
	        <div style="clear:both"></div>
			<?=$ADMIN_TRANS['external link'];?><br /><small>(<?=$ADMIN_TRANS['adding external link will link this menu item to it'];?>)</small>
			<input type="text" size="70" id="NewCatLink" name="NewCatLink" style="direction:ltr" class="CatEditInputs" value="<?=urldecode($P_DETAILS[PageUrl]);?>"><br />
			<br />
			
			<script type="text/javascript">jQuery("#NewCatName").focus();</script>
			
		<?
		if ($actionShow=="editPage") {
			?>
			<br>
			<span  id="UrlKeyLabel"><?=$ADMIN_TRANS['page address'];?>:<br/>
			<div style="direction:rtl;text-align:left"><input type="text" size="35" id="NewUrlKey" name="NewUrlKey" style="direction:ltr" class="CatEditInputs" value="<?=$P_DETAILS['UrlKey'];?>"></div></span>
			<br>
			
			<?
			if ($SITE[mobileEnabled]) {
				
      			  if ($P_DETAILS[ViewStatus]==0 AND $P_DETAILS[MobileView]==0) $selected[-1]="selected";
           			 else $selected[$P_DETAILS[MobileView]]="selected";
        		?>
        		&nbsp;<i style="color:#333333;font-size:20px;vertical-align: middle;" class="fa fa-mobile fa-2x"></i>
	        	<select name="mobileView" id="mobileView" class="mobileViewSelector">
		            <option value="1" <?=$selected[1];?>><?=$ADMIN_TRANS['show in mobile devices'];?></option>
		            <option value="-1" <?=$selected[-1];?>><?=$ADMIN_TRANS['hide from mobile devices'];?></option>
     			</select>
      			<?
    			}
    			
		}
		?>
		<span id="hideMenuLabel"><input id="hiddenMenu"  type="checkbox" name="hiddenMenu" onchange="askuser()" <?=$P_DETAILS[ViewStatus]==0 ? 'checked' : '';?> /> <?=$ADMIN_TRANS['hidden category'];?></span>
		<?	
		
		if ($P_DETAILS[ParentID]==0) {
            $isRichTextOnPopUp=GetCatStyle("enableRichTextPopUp",$P_ID['parentID']);
            $isChecked="";$toggleClassName="on";
            if ($isRichTextOnPopUp) {
                $isChecked="checked";
                $toggleClassName="off";
            }
            ?>
            <div style="height:12px"></div>
            <div>
	            <input type="checkbox" name="showRichTextCheck" id="showRichTextCheck" value=1 <?=$isChecked;?> onclick="if(this.checked) this.value=1;else this.value=0;setCatStyleProperty(<?=$P_ID[parentID];?>,jQuery('input#showRichTextCheck').val(),'enableRichTextPopUp')" />
	            <label for="showRichTextCheck"><?=$ADMIN_TRANS['enable rich text on mouse hover'];?></label>
            </div>
            <?
        }
        
        ?>
        <br>
		</div>
		<script>
		jQuery("#newSaveIcon.newSave.greenSave").click(function() {saveNewPage()});
		</script>
		<?
		}
		if ($actionShow!="editPage") {
		
		?>
		<div class="pageStructureInner template">
			<div class="title"><?=$ADMIN_TRANS['choose template'];?></div>
			<div data-template="0" class="<?=$selectedCatType[0];?>"><i class="fa fa-align-justify"></i><label><?=$ADMIN_TRANS['content page'];?></label></div>
			<div data-template="1" class="<?=$selectedCatType[1];?>"><i class="material-icons">art_track</i><label><?=$ADMIN_TRANS['1 brief per line'];?></label></div>
			<div data-template="11" class="<?=$selectedCatType[11];?>"><i class="material-icons" style="display:inline-block">art_track</i><i class="material-icons" style="display:inline-block">art_track</i><label><?=$ADMIN_TRANS['2-3 briefs per line'];?></label></div>
			<div data-template="12" class="last <?=$selectedCatType[12];?>"><i class="material-icons">view_comfy</i><label><?=$ADMIN_TRANS['brief under photo'];?></label></div>
			<div data-template="21" class="<?=$selectedCatType[21];?>"><i class="material-icons">dashboard</i><label><?=$ADMIN_TRANS['briefs collage'];?></label></div>
			
			<div data-template="2" class="<?=$selectedCatType[2];?>"><i class="fa fa-th"></i><label><?=$ADMIN_TRANS['photo/video gallery'];?></label></div>
			<div data-template="4" class="<?=$selectedCatType[4];?>"><i class="fa fa-photo"></i><label><?=$ADMIN_TRANS['switch to slides'];?></label></div>
			<div data-template="17" class="last <?=$selectedCatType[17];?>"><i class="fa fa-check-square-o"></i><label><?=$ADMIN_TRANS['add form'];?></label></label></div>
			<? if($shopActivated) {
				?>
				<div data-template="14" class="<?=$selectedCatType[14];?>"><i class="material-icons">shopping_basket</i><label><?=$ADMIN_TRANS['shop'];?></label></div>
				<?}?>
		</div>
		
		<div style="clear:both"></div><br>
		<?
		}
		if ($actionShow!="editPage" AND $actionShow!="addPage") {
			?>
			<div class="pageStructureInner pageStyle">
				<?
				$selectedPageStyle[$P_DETAILS['PageStyle']]="selected";
				?>
				<div class="title"><?=$ADMIN_TRANS['choose page structure'];?></div>
				<div class="<?=$selectedPageStyle[0];?>" data-pagestyle="0"><i class="fa fa-columns"></i><label><?=$ADMIN_TRANS['with side menu'];?></label></div>
				<div class="rotate <?=$selectedPageStyle[1];?>" data-pagestyle="1"><i class="fa fa-square-o"></i><label><?=$ADMIN_TRANS['full page'];?></label></label></div>
				<div class="<?=$selectedPageStyle[2];?>" data-pagestyle="2"><i class="fa fa-pause"></i><label><?=$ADMIN_TRANS['two separated columns'];?></label></div>
				<div class="rotate last <?=$selectedPageStyle[8];?>" data-pagestyle="<?=$data_left_col;?>"><i class="fa fa-bars"></i><label><?=$ShowLeftColumnLabel;?></label></div>
				<div style="display:none" class="<?=$selectedPageStyle[4];?>" data-pagestyle="4"><i class="material-icons">view_stream</i><label><?=$ADMIN_TRANS['fullwidepage'];?></label></div>
			</div>
			<div style="clear:both"></div><br>
			<div class="pageStructureInner entranceEffects">
				<div class="title"><?=$ADMIN_TRANS['entrance_effect'];?></div>
				<?
				$selectedEntranceEffect[$entranceEffect]="selected";
				?>
				<div class="none <?=$selectedEntranceEffect[''];?>" data-entrance-effect=""><i class="material-icons">blur_off</i><label>Off</label></div>
				<div class="none <?=$selectedEntranceEffect['fadeIn'];?>" data-entrance-effect="fadeIn"><i class="material-icons">blur_on</i><label>Fade In</label></div>
				<div class="none <?=$selectedEntranceEffect['fadeInUp'];?>" data-entrance-effect="fadeInUp"><i class="material-icons">blur_on</i><i class="material-icons second">arrow_upward</i><label>Fade In Up</label></div>
				<div class="none <?=$selectedEntranceEffect['fadeInDown'];?>" data-entrance-effect="fadeInDown"><i class="material-icons">blur_on</i><i class="material-icons second">arrow_downward</i><label>Fade In Down</label></div>
				<div class="none <?=$selectedEntranceEffect['fadeInLeft'];?>" data-entrance-effect="fadeInLeft"><i class="material-icons second">arrow_forward</i><i class="material-icons">blur_on</i><label>Fade In Left</label></div>
				<div class="last none <?=$selectedEntranceEffect['fadeInRight'];?>" data-entrance-effect="fadeInRight"><i class="material-icons">blur_on</i><i class="material-icons second">arrow_back</i><label>Fade In Right</label></div>
				<div class="none <?=$selectedEntranceEffect['bounceIn'];?>" data-entrance-effect="bounceIn"><i class="material-icons">all_out</i><label>Bounce in</label></div>
				<div class="none <?=$selectedEntranceEffect['bounceInUp'];?>" data-entrance-effect="bounceInUp"><i class="material-icons">all_out</i><i class="material-icons second">arrow_upward</i><label>Bounce in up</label></div>
				<div class="none <?=$selectedEntranceEffect['zoomIn'];?>" data-entrance-effect="zoomIn"><i class="material-icons">zoom_out_map</i><label>Zoom in</label></div>
				<div class="none <?=$selectedEntranceEffect['zoomInDown'];?>" data-entrance-effect="zoomInDown"><i class="material-icons">zoom_out_map</i><i class="material-icons second">arrow_downward</i><label>Zoom in down</label></div>
				<div class="none <?=$selectedEntranceEffect['zoomInUp'];?>" data-entrance-effect="zoomInUp"><i class="material-icons second">arrow_upward</i><i class="material-icons">zoom_out_map</i><label>Zoom in up</label></div>
				<div class="last none <?=$selectedEntranceEffect['zoomInLeft'];?>" data-entrance-effect="zoomInLeft"><i class="material-icons">zoom_out_map</i><i class="material-icons second">arrow_back</i><label>Zoom in Left</label></div>
	
				<div class="none <?=$selectedEntranceEffect['slideInUp'];?>" data-entrance-effect="slideInUp"><i class="material-icons">arrow_upward</i><label>Slide in up</label></div>
				<div class="none <?=$selectedEntranceEffect['slideInLeft'];?>" data-entrance-effect="slideInLeft"><i class="material-icons">arrow_forward</i><label>Slide in Left</label></div>
				<div class="none <?=$selectedEntranceEffect['slideInDown'];?>" data-entrance-effect="slideInDown"><i class="material-icons">arrow_downward</i><label>Slide in down</label></div>
				<div class="none <?=$selectedEntranceEffect['slideInRight'];?>" data-entrance-effect="slideInRight"><i class="material-icons">arrow_back</i><label>Slide in Right</label></div>
			</div>
			<div style="clear:both"></div><br>
			<?
		}
		?>
		<script>
		jQuery(".pageStructureInner.template div, .pageStructureInner div").not(".title").click(function(){changeTemplateTo(jQuery(this));});
		<?
		if ($actionShow!="editPage" AND $actionShow!="addPage") {
			?>
			jQuery("#newSaveIcon.newSave.greenSave").click(function() {saveChangesToTemplate()});
			<?
		}
		?>

		jQuery(".pageStructureInner.entranceEffects div.none").hover(function() {
			jQuery(this).addClass("animated "+jQuery(this).attr("data-entrance-effect"));
		});
		</script>
		<?
	break;
	case $actionShow=="design":
	include_once ("GetTemplateStyle.php");
	break;
	case $actionShow=="social" :
	?>
	<div class="pageStructureInner social facebook">
		<label><?=$ADMIN_TRANS['social_intro'];?></label><br><br>
		<div class="title">FACEBOOK</div>
		<div data-social-fb="1" class="<?=$selectedFBType[1];?>"><i class="fa fa-thumbs-o-up"></i><label><?=$ADMIN_TRANS['social_types'][0];?></label></div>
		<div data-social-fb="6" class="<?=$selectedFBType[6];?>"><i class="fa fa-thumbs-up"></i><label><?=$ADMIN_TRANS['social_types'][1];?></label></div>
		<div data-social-fb="3" class="<?=$selectedFBType[3];?>"><i class="fa fa-share"></i><label><?=$ADMIN_TRANS['social_types'][2];?></label></div>
		<div data-social-fb="4" class="last <?=$selectedFBType[4];?>"><i class="fa fa-heart-o"></i><label><?=$ADMIN_TRANS['social_types'][3];?></label></div>
		<div data-social-fb="2" class="<?=$selectedFBType[2];?>"><i class="fa fa-comment-o"></i><label><?=$ADMIN_TRANS['social_types'][4];?></label></div>
		<div data-social-fb="7" class="<?=$selectedFBType[7];?>"><i class="fa fa-comment-o"></i><label><?=$ADMIN_TRANS['social_types'][8];?></label></div>
		<div data-social-fb="-1" class="<?=$selectedFBType[0];?>"><i class="fa fa-circle-o-notch"></i><label><?=$ADMIN_TRANS['social_types'][5];?></label></div>
	</div>
	<div style="clear:both"></div><br>
	<div class="pageStructureInner social google">
		<div class="title">Google Plus</div>
		<div data-social-google="1" class="<?=$selectedGoogleType[1];?>"><i class="fa fa-google-plus"></i><label><?=$ADMIN_TRANS['social_types'][7];?></label></div>
		<div data-social-fb="0" class="<?=$selectedFBType[0];?>"><i class="fa fa-circle-o-notch"></i><label><?=$ADMIN_TRANS['social_types'][6];?></label></div>
	</div>
	<div class="tip bottom"><i class="fa fa-bell-o"></i> <?=$ADMIN_TRANS['social remarks'];?></div>
	<script>
	jQuery(".pageStructureInner.social div").not(".title").click(function(){changeTemplateTo(jQuery(this));});
	jQuery("#newSaveIcon.newSave.greenSave").click(function() {saveSocialAddOns()});
	jQuery(".tip.bottom i").addClass("animated swing");
	</script>

	<?
	break;
	case $actionShow=="submenu":
	unset($CHECK_PAGE);
		include_once("../inc/topmenu.inc.php");
		?>

		<div class="sideMenuAdminWrapper">
			<div class="title"><?=$ADMIN_TRANS['subpages'];?></div>
			<div style="height:20px"></div>
			<?SetSideMenu($urlKey);?>
		</div>
		<div class="tip bottom submenu"><i class="fa fa-bell-o"></i> <?=$ADMIN_TRANS['submenu remarks'];?></div>
		<script>jQuery(".tip.bottom i").addClass("animated swing");</script>
		<?

	break;
	default:
	break;
}
?>
</div>
<div style="height:20px;clear:both"></div>
<div class="saveButtonsNew">
	<div id="newSaveIcon" class="newSave greenSave"><i class="fa fa-save"></i> <?=$ADMIN_TRANS['save changes'];?></div>
	<div id="newSaveIcon" class="newSave cancel"><?=$ADMIN_TRANS['cancel'];?></div>
</div>
<script>
jQuery(".saveButtonsNew #newSaveIcon.newSave.cancel").click(function() {jQuery(".globalSettingsWrapper").toggleClass("show");})
jQuery(".main-settings-container").height(jQuery(window).height()-jQuery(".saveButtonsNew").height()-90+"px");
</script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/autogrow.min.js"></script>
<script>
jQuery(".globalSettingsWrapper .icon_close").click(function(){jQuery(".globalSettingsWrapper").removeClass("show");});

jQuery(document).ready(function() {
	 if (GlobalAction=="SEO") jQuery('textarea').autogrow({onInitialize:true});
	});
</script>
