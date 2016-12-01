<style>
	#newCatNameHelper{border:1px dotted silver;min-width:100px;min-height:20px;font-weight:bold}
</style>
<?
$ADMIN_LABEL['en']['change']="Change Also Page URL to ";
$ADMIN_LABEL['he']['change']="האם לשנות גם את כתובת העמוד ל ";;
$isMobileEnabledShow="none";
if ($SITE[mobileEnabled]) $isMobileEnabledShow="";
?>

<script language="javascript" type="text/javascript">
var action="saveCat";
var currentCatEditedID;
var currentCatParentID=catParentID;
var add_sub=1;
var ofset=0;
var newCatTreeStr='<br>&nbsp;&nbsp;&larr;';
var currentCatName;
var is_MobileEnabled="<?=$SITE[mobileEnabled];?>";
if (SiteDirection=='ltr') newCatTreeStr='<br>&nbsp;&nbsp;&rarr;';
var rootCat="<?=$ROOT_URLKEY[RootCatID];?>";
function AddSideCat(o) {
	jQuery("#CatEditor").css("width","600px");
	add_sub=1;
	AddNewCat(o);
	$("rootMenuLabel").hide();
	$('hiddenMenu').checked="";
	$('securedCat').checked="";
	if (!rootCat=="") catParentID=rootCat;
	jQuery("#newCatTreeHelper").html('<?=htmlspecialchars($ROOT_URLKEY[ParentMenuTitle],ENT_QUOTES);?>'+newCatTreeStr);
}
function AddTopCat(o) {
	jQuery("#CatEditor").css("width","410px");
	$("delCatButton").hide();
	$("rootMenuLabel").hide();
	$("rootMenu").checked="checked";
	$('hiddenMenu').checked="";
	$('securedCat').checked="";
	add_sub=0;
	AddNewCat(o);
	jQuery("#catHelper").hide();
}
function AddSubCat(o,parentCatID) {
	jQuery("#CatEditor").css("width","600px");
	add_sub=1;
	catParentID=parentCatID;
	$("rootMenu").checked="";
	$('hiddenMenu').checked="";
	$('securedCat').checked="";
	$("rootMenuLabel").hide();
	$("UrlKeyLabel").hide();
	AddNewCat(o);
	
	jQuery("#newCatTreeHelper").html(jQuery('li#cat_item-'+parentCatID+' a').text()+newCatTreeStr);
	$('AddCatTitle').innerHTML="<?=$ADMIN_TRANS['add sub category'];?>";
}
function AddNewCat(o) {
	
	action="saveCat";
	$("NewUrlKey").value="";
	$("UrlKeyLabel").hide();
	jQuery("#catHelper").show();
	$('NewCatName').value="";
	ofset=-300;
	if (SiteDirection=="rtl") ofset=-220;
	if (add_sub==0) ofset=30;
	//SetPosition(o,'CatEditor',ofset);
	$("delCatButton").hide();
	$("moveCatLocation").hide();
	if (document.getElementById("CatEditor").style.display=="none") {
		ShowLayer("CatEditor",1,0);
		$('NewCatName').focus();
		jQuery(function() {
		jQuery("#CatEditor").draggable();
		});
	}
	else {
		$("delCatButton").show();
		ShowLayer("CatEditor",0,1);
		catParentID=currentCatParentID;
		$('AddCatTitle').innerHTML="<?=$ADMIN_TRANS['add/edit category'];?>";
		add_sub=0;
	}
	
	
}

function EditCat(o,MenuID,ViewStatus,currentUrlKey,orderPage) {
	if (jQuery(".globalSettingsWrapper.show").length<1) jQuery(".globalSettingsWrapper").toggleClass("show");
	jQuery(".globalSettingsWrapper.show #gSettingsInner").load("/Admin/GetGlobalSettings.php?urlKey="+currentUrlKey+"&action=editPage");
}
function EditCat_org(o,MenuID,ViewStatus,currentUrlKey,orderPage) {
	jQuery("#catHelper").hide();
	action="rename";
	ofset=-300;
	currentCatEditedID=MenuID;
	jQuery("#CatEditor").css("width","410px");
	if (SiteDirection=="rtl") ofset=0;
	var url_check = '<?=$SITE[url];?>/Admin/GetCat.php?type=checkMobileView&catID='+MenuID;
	//var pars = 'catID='+MenuID;
	//var catSecured;
	jQuery("#mobileViewLabel").load(url_check);	  
		  
	if (ViewStatus==1) $('hiddenMenu').checked="";
	else $('hiddenMenu').checked="checked";
	//if (catSecured==1) $('securedCat').checked="checked";
	//else $('securedCat').checked="";
	//SetPosition(o,'CatEditor',ofset);
	$("UrlKeyLabel").show();
	$("rootMenu").checked="";
	$("rootMenuLabel").hide();
	$("delCatButton").show();
	$("moveCatLocation").show();

	$('NewCatName').value=decodeURIComponent($('text_'+MenuID).value) //was decodeURIComponent(1/6/2011);
	currentCatName=jQuery("#NewCatName").val();
	$('NewCatLink').value=$('url_'+MenuID).value;
	$('NewUrlKey').value=currentUrlKey;
	$('catID').value=MenuID;
	if (document.getElementById("CatEditor").style.display=="none") {
		ShowLayer("CatEditor",1,0);
		$('NewCatName').focus();
		jQuery(function() {
		jQuery("#CatEditor").draggable({
			handle:'#make_dragable'
			});
		});
	}
	else ShowLayer("CatEditor",0,0);
}

function successEditCat(res) {
	var editedCatID=$('catID').value;
	document.getElementById("LoadingDiv").innerHTML="<i class='fa fa-times close_edit_notify'></i>&nbsp; <span class='successEdit'><?=$ADMIN_TRANS['category saved'];?></span>";
	if (action=="saveCat") document.location.reload();
	else {
		$('menu_item-'+editedCatID).innerHTML=$('NewCatName').value;
		$('text_'+editedCatID).value=encodeURIComponent($('NewCatName').value);
		ShowLayer("CatEditor",0,1);
		if (res==1) window.setTimeout('document.location.reload();',500);
	}
	
}
function successDelCat(response,cID) {
	var msgText="<?=$ADMIN_TRANS['category deleted'];?>";
	if (response=="FALSE") msgText="<?=$ADMIN_TRANS['cannot delete category that contains content block'];?>";
	else {
		//Effect.Fade('drag-item_'+cID);
		Effect.Fade('cat_item-'+cID);
	}
	//$('drag-item_'+cID).hide();
	jQuery(".LoadingDiv").addClass("deleted");
	document.getElementById("LoadingDiv").innerHTML="<i class='fa fa-times close_edit_notify'></i>&nbsp; <span class='successEdit'>"+msgText+"</span>";
	
}
function successMoveCat() {
	document.getElementById("LoadingDiv").innerHTML="<i class='fa fa-times close_edit_notify'></i>&nbsp; <span class='successEdit'><?=$ADMIN_TRANS['category saved'];?></span>";

}

function SaveNewCat() {
	var isRootMenu=$("rootMenu").checked;
	var isHiddenMenu=$("hiddenMenu").checked;
	var isSecuredMenu=$("securedCat").checked;
	var mobileViewSelected=jQuery("#mobileView").val();
	var richTextPopup=jQuery("#showRichTextCheck").val();
	var isOrderCat = 0;
	var ViewMenuStatus=1;
	var isSecuredCat=0;
	if (isHiddenMenu) ViewMenuStatus=0;
	if (isSecuredMenu) isSecuredCat=1;
	if (isRootMenu) catParentID=0;
	var newCatName=document.getElementById("NewCatName").value;
	newCatName=encodeURIComponent(newCatName);
	var newCatLink=document.getElementById("NewCatLink").value;
	newCatLink=encodeURIComponent(newCatLink);
	var catPageID=document.getElementById("catID").value;
	var newUrlKey=$('NewUrlKey').value;
	if (currentCatName!=document.getElementById("NewCatName").value && action=="rename") {
		var ask=confirm("<?=$ADMIN_LABEL[$SITE_LANG[selected]]['change'];?>'"+decodeURIComponent(newCatName)+"' ?");
		if (ask) newUrlKey=newCatName;
	}
	
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action='+action;
	var pars = 'newCatName='+newCatName+'&newCatLink='+newCatLink+'&catParentID='+catParentID+'&catPageID='+catPageID+'&viewStatus='+ViewMenuStatus+'&newUrlKey='+newUrlKey+'&securedCat='+isSecuredCat+'&orderCat='+isOrderCat+'&mobileView='+mobileViewSelected+'&richTextPopup='+richTextPopup;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEditCat(transport.responseText);}, onFailure:failedEdit,onLoading:savingChanges});
	
}
function QuickDelCat() {
	DelCat($('catID').value);
	ShowLayer("CatEditor",0,1);
}

function DelCat(catID) {
	
	var answer=confirm("<?=$ADMIN_TRANS['delete this category ?'];?>");
	if(answer) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delCat';
		var pars = 'cID='+catID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {
			successDelCat(transport.responseText,catID);
			}, onFailure:failedEdit,onLoading:savingChanges});
	}
}
function LoadAllCats(x) {
	var search_hl=jQuery("#cat_s_q").val();
	var search_q=encodeURIComponent(jQuery("#cat_s_q").val());
	if (x) jQuery("#AllCatsContainer").load("<?=$SITE[url];?>/Admin/GetSiteCats.php?s="+search_q+"&currentCatEditedID="+currentCatEditedID);
	
	if (search_hl) {
	window.setTimeout(function() {
		//jQuery('#AllCatsContainer').removeHighlight();
		jQuery("#AllCatsContainer").highlight(search_hl);	
	},500);
	
	}
	
	
}
function ToggleMoveIcon(x,id) {
	if (x) $('move_icon_'+id).src="<?=$SITE[url];?>/Admin/images/move_cat_icon.gif";
	else $('move_icon_'+id).src="<?=$SITE[url];?>/Admin/images/move_cat_icon_space.gif";
}
function startChangeCatLocation() {
	
	jQuery(".CatLocationChooser").toggle("slideDown",function() {
		if (jQuery(".CatLocationChooser").is(":hidden")) {
			jQuery(".")
		}
		else {
			
			LoadAllCats(1);
		}
	});
}
function moveCategory(cID) {
	if (currentCatEditedID!=cID) {
		var x=confirm("<?=$ADMIN_TRANS['are you sure ?'];?>");
		if (x) {
			var sourceCatID=currentCatEditedID;
			jQuery("#movedConfirmed").fadeIn("slow");
			jQuery("#movedConfirmed").load("<?=$SITE[url];?>/Admin/saveContentinplace.php?action=changeCatLocation&sourceCatID="+sourceCatID+"&destinationCatID="+cID,function() {
				window.setTimeout('document.location.reload();',200);
			});

		}
	}
	
}
</script>


<div dir="<?=$SITE_LANG[direction];?>" id="CatEditor" style="display:none;z-index:1100;width:600px" align="<?=$SITE[align];?>" class="CenterBoxWrapper">
<div align="<?=$SITE[opalign];?>" id="make_dragable"><div onclick="AddNewCat(this)" class="icon_close">+</div>
	<div class="title"><?=$ADMIN_TRANS['add/edit category'];?></div>
</div>
<div class="CenterBoxContent" style="min-height: 230px">
	<div id="catHelper__" style="float:<?=$SITE[opalign];?>;width: 170px;font-size:12px;padding:5px;margin-<?=$SITE[align];?>:5px;background: #ffffff;min-height:180px;"><?=$ADMIN_TRANS['the new created category will be in:'];?>
		<br><br><span id="newCatTreeHelper"></span><span id="newCatNameHelper__">&nbsp; &nbsp;&nbsp; &nbsp;</span>
	</div>
	
	<div style="float:<?=$SITE[align];?>;width:390px" id="catCreate">
	<span id="AddCatTitle"><?=$ADMIN_TRANS['add/edit category'];?> </span> <br />
	<input type="text" size="70" id="NewCatName__" name="NewCatName__" dir="<?=$SITE_LANG[direction];?>" class="CatEditInputs"><br /><br />
	<?=$ADMIN_TRANS['external link'];?> <br /><small>(<?=$ADMIN_TRANS['adding external link will link this menu item to it'];?>)</small>
	<input type="text" size="70" id="NewCatLink__" name="NewCatLink__" style="direction:ltr" class="CatEditInputs"><br />
	<span  id="UrlKeyLabel" style="display:none"><?=$ADMIN_TRANS['page address'];?>:<br/>
	<span dir="ltr"><?=$SITE[url];?>/category/<input type="text" size="35" id="NewUrlKey__" name="NewUrlKey__" style="direction:ltr" class="CatEditInputs"></span></span>
	<br />
	<span id="hideMenuLabel"><input id="hiddenMenu__"  type="checkbox" name="hiddenMenu__" onchange="askuser()" /> <?=$ADMIN_TRANS['hidden category'];?></span>
	<span id="mobileViewLabel" style="margin-<?=$SITE[align];?>:10px"></span>
	<span id="securedCatLabel" style="display: none;"><input id="securedCat"  type="checkbox" name="securedCat"  /> <?=$ADMIN_TRANS['protected category'];?></span>
	
	<br>
	<br>
	<div id="newSaveIcon" class="greenSave" onclick="SaveNewCat();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" />&nbsp;<?=$ADMIN_TRANS['save'];?></div>
	&nbsp;
	<div class="newSaveIcon" id="moveCatLocation__"  onclick="startChangeCatLocation()" /><?=$ADMIN_TRANS['move category'];?></div>
	&nbsp; &nbsp;
	<div class="newSaveIcon" id="delCatButton" style="color:RED"  onclick="QuickDelCat();"><img src="<?=$SITE[urldecode];?>/Admin/images/delIcon.png" align="absmiddle" />&nbsp;<?=$ADMIN_TRANS['delete'];?></div>
	<span style="float:<?=$SITE[opalign];?>;margin-<?=$SITE[opalign];?>:8px;">
		<div id="newSaveIcon"  onclick="AddNewCat(this);"><?=$ADMIN_TRANS['close'];?></div>
	</span>
	<span id="rootMenuLabel"><input id="rootMenu" style="display:none"  type="checkbox" name="rootMenu" /> <?=$ADMIN_TRANS['add to top menu'];?></span>
	&nbsp;&nbsp;
	<input id="catID" type="hidden" value="">
		<div id="movedConfirmed" style="display: none"></div>
		<div class="CatLocationChooser__" id="CatLocationChooser__">
			<div><br><br><strong><?=$ADMIN_TRANS['choose parent category to move this category to'];?></strong></div>
			
			
			<div id="AllCatsContainerWrapper__">
				<div class="search_cats__"><input id="cat_s_q__" type="text" results="10" placeholder="<?=$ADMIN_TRANS['filter by name'];?>" onkeyup="LoadAllCats(1);" /></div>
				<div id="AllCatsContainer__">
					
					<div class="loadingCircle"><img src="<?=$SITE[url];?>/Admin/images/ajax-loader.gif" border="0" /></div>
				</div>
			</div>
		</div>
	
	</div>
</div>
</div>
<script>
	jQuery('#NewCatName').on('keyup',function() {
		jQuery('#newCatNameHelper').text(jQuery(this).val());
	})
	
</script>