<?
//TODO:
if (!$CHECK_CATPAGE) $CHECK_CATPAGE=$pID;
$CURRENT_CTYPE=$CHECK_CATPAGE[CatType];
if ($CURRENT_CTYPE==11 OR $CURRENT_CTYPE==12 OR $CURRENT_CTYPE==21) $CURRENT_CTYPE=1;
$ADDNEW_DISPLAY="none";
$ADMIN_TRANS['add new']=$ADMIN_TRANS['add content'];
if ($CURRENT_CTYPE==11 OR $CURRENT_CTYPE==12 OR $CURRENT_CTYPE==13 OR $CURRENT_CTYPE==1 OR $CURRENT_CTYPE==21) $ADMIN_TRANS['add new']=$ADMIN_TRANS['add brief'];
if ($CURRENT_CTYPE==0) $ADDNEW_DISPLAY="";
$ShowLeftColumnLabel=$ADMIN_TRANS['add right/left column'];
$ShowLeftColumnValue=1;
$leftColSelectedClass="";
if ($isLeftColumn=="1") {
	$ShowLeftColumnLabel=$ADMIN_TRANS['remove right/left column'];
	$ShowLeftColumnValue="-1";
	$leftColSelectedClass="leftColSelected";
}
$COPY_LABELS['he']=array("CopyPage"=>"העתק תוכן","Copied"=>"התוכן הועתק","PastePage"=>"הדבק תוכן","PasteGallery"=>"הדבק גלרייה");
$COPY_LABELS['en']=array("CopyPage"=>"Copy Content","Copied"=>"Content Copied","PastePage"=>"Paste Content","PasteGallery"=>"Paste Gallery");
if ($CURRENT_CTYPE==2) {
	$COPY_LABELS['he']['CopyPage']="העתק גלרייה";$COPY_LABELS['he']['Copied']="גלריה הועתקה";
	$COPY_LABELS['en']['CopyPage']="Copy Gallery";$COPY_LABELS['en']['Copied']="Gallery Copied";
}
if ($_SESSION['cp_catType']==2) {
	$COPY_LABELS['he']['PastePage']=$COPY_LABELS['he']['PasteGallery'];
	$COPY_LABELS['en']['PastePage']=$COPY_LABELS['en']['PasteGallery'];
}
	
$cp_action="copyPage";
if (isset($_SESSION['cp_catID'])) {
	if ($_SESSION['cp_catID']==$CHECK_CATPAGE[parentID]) {
		$COPY_LABELS[$SITE_LANG[selected]]['CopyPage']=$COPY_LABELS[$SITE_LANG[selected]]['Copied'];
		$cp_action="nothing";
	}
	else {
		$COPY_LABELS[$SITE_LANG[selected]]['CopyPage']=$COPY_LABELS[$SITE_LANG[selected]]['PastePage'];
		$cp_action="pastePage";
	}
}
?>
<style type="text/css">
	.TemplateDropDownNew li.selected_c_type_<?=$CHECK_CATPAGE[CatType];?>, .TemplateDropDownNew li.selected_g_type_<?=$GAL[Type];?> {
		color:#ffffff;
		background:#3383c1;
	}
	li.selected_p_type_<?=$P_DETAILS[PageStyle];?>, li.leftColSelected {
		background-color: #efefef;
		opacity: 1;
		
	}
	li.selected_p_type_<?=$P_DETAILS[PageStyle];?>:hover, li.leftColSelected:hover {
		opacity: 0.8;
		background-color: transparent;
	}
	<?
	if (!$shopActivated) {
		if (ieversion()>0) {?>.TemplateChooser .newSaveIcon_selected#ctype_2 {border-top-<?=$SITE[align];?>-radius:3px;border-bottom-<?=$SITE[align];?>-radius:3px}<?}
		else	{?>.TemplateChooser .newSaveIcon_selected#ctype_2 {border-top-<?=$SITE[opalign];?>-radius:3px;border-bottom-<?=$SITE[opalign];?>-radius:3px;direction: ltr;}<?}
	}
	?>
</style>

<script type="text/javascript" src="<?=$SITE[cdn_url];?>/ckeditor/ckeditor.js"></script>
<script language="javascript" type="text/javascript">
var OriginalContent;
var msgDivText="";
var currentPageID;
var SavedPageTitle;
//var divContent;
var openDiv=0;
//var printArea;
var pageUrlKey=new Array();
var pageTextUrlKey=new Array();
var pageIsTitleLink=new Array();
var newPage=0;
var url="";
var DivMessage="Loading...";
var lightEditorDiv='<textarea id="lightEditor"></textarea>';
var editor_ins;
var editor_browsePath="<?=$SITE[url];?>/ckfinder";
var GalleryType=0;
var cType=0;
var currentCTYPE=<?=$CURRENT_CTYPE;?>;
function trim_spaces(str) {
        return str.replace(/^\s+|\s+$/g,"");
}
function loadingData() {
	$('pageCatsContainer').innerHTML=DivMessage;
}

function EditMiddleContent(pID) {
	currentPageID=pID;
	var buttons_str;
	buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveMiddleContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
	buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" class="cancel" onclick="cancelMiddleContent();"><?=$ADMIN_TRANS['cancel'];?></div>';
	var contentDIV = document.getElementById("divContent_"+pID);
	var div=$('lightEditorContainer');
	div.innerHTML=lightEditorDiv+buttons_str+"&nbsp;";
	editor_ins=CKEDITOR.replace('lightEditor', {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
		});
	editor_ins.setData(contentDIV.innerHTML);
	
	editor_ins.on("loaded",function() {
		slideOutEditor("lightEditorContainer",1);
	});
	
}
function saveMiddleContent() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var parentCat=<?=$CHECK_CATPAGE[parentID];?>;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'pageID='+currentPageID+'&content='+cVal+'&parentCat='+parentCat+'&action=saveMiddleContent';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	jQuery("#divContent_"+currentPageID).html(decodeURIComponent(cVal));
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
	
}
function cancelMiddleContent() {
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
}
function SavePageCats(frm) {
	url="<?=$SITE[url];?>/Admin/saveCats.php";
	 var pars=Form.serialize(frm);
	new Ajax.Request(url, {  
           	method: "post", 
	parameters: pars,
	onSuccess:successSavePageCats
	
       });
}

function ShowPageCats(pageID) {
	ShowLayer("pageCatsContainer",1,1,1);
	url="<?=$SITE[url];?>/Admin/GetPageCats.php?pageID="+pageID;
	GetRemoteHTML("pageCatsContainer");
	
}
var NewPicAdding=0;
function AddNewPicToNewArticle() {
	jQuery("#lightEditorContainer").css("z-index","10");
	NewPicAdding=1;
	AddNewArticlePic(0,'');
}
function showAdminBar(pID) {
	$("AdminErea_"+pID).toggle();
}

function EditHere(pID,newPG,open) {
	currentPageID=pID;
	newPage=newPG;
	var pageUrl;
	var pageCURRENTUrlKey;
	var displayUrlKey="";
	if (newPage) {
		currentPageID="";
		pageUrlKey="";
		pageCURRENTUrlKey="";
		pageUrl="";
		displayUrlKey="none";
		if (footerMultiTitle) {
			var pageTitle;
			pageTitle=footerMultiTitle;
		}
	}
	else {
		var pageTitle=jQuery("#titleContent_"+pID).text()  || jQuery("#titleContent_"+pID).text();
		pageUrl=document.getElementById("p_url_"+pID).innerText || document.getElementById("p_url_"+pID).textContent;
		pageCURRENTUrlKey=pageTextUrlKey[pID];
	}
	if (!pageCURRENTUrlKey) {
		pageCURRENTUrlKey="";
		displayUrlKey="none";
	}
	var buttons_str;
	var isTitleLink="";
	var pageTitleLink_str;
	if (pageIsTitleLink[pID]==1) isTitleLink="checked";
	openDiv=open;
	if (!pageUrl) pageUrl="";
	if (!pageTitle) pageTitle="";
	//if (!OriginalContent) OriginalContent=document.getElementById("printArea").innerHTML;
	if (openDiv) {
		var div = document.getElementById("lightEditorContainer"); //changed from document.getElementById("printArea")
		var contentDIV = document.getElementById("divContent_"+pID);
	}
	else {
		var div = document.getElementById("printArea")
		//var fck = new FCKeditor("printArea");
	}
	var pageTitle_field=pageTitle;
	if (!pageTitle=="") {
		pageTitle=pageTitle.replace(/\"/g,"&quot;");
		pageTitle=trim_spaces(pageTitle);
	}
	var ifFooterTitle=pageTitle.indexOf("footer_");
	
	var titleFieldShow="";
	if (pageTitle=="footer") titleFieldShow="none";
	buttons_str='<br><div style="clear:both"></div><div id="newSaveIcon" onclick="saveContent();" class="greenSave"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
	buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" class="cancel" onclick="cancelEditing();"><?=$ADMIN_TRANS['cancel'];?></div>';
	pageTitle_str='<h4 style="margin:2px;display:'+titleFieldShow+'" align="<?=$SITE[align];?>"><?=$ADMIN_TRANS['title'];?> <input class="inputTextTitle"  type="text" id="pageT" name="pageT" value="'+pageTitle+'"></h4>';
	pageURL_str='<div align="<?=$SITE[align];?>" style="display:'+titleFieldShow+'"><?=$ADMIN_TRANS['external link'];?><br><textarea style="direction:ltr" class="inputTextTitle inputExternalUrl" id="pageURL" name="pageURL" rows="3">'+pageUrl+'</textarea></div>';
	pageURL_str+='<div align="<?=$SITE[align];?>" style="float:<?=$SITE[align];?>;display:'+displayUrlKey+'"><?=$ADMIN_TRANS['page address'];?> : </div><div align="<?=$SITE[align];?>" dir="ltr" style="display:'+displayUrlKey+'"><?=$SITE[url];?>/</div><div style="text-align:<?=$SITE[align];?>;display:'+displayUrlKey+'"><input style="direction:ltr" class="inputTextTitle inputPageUrl"  type="text" id="pageURLKEY" name="pageURLKEY" value="'+pageCURRENTUrlKey+'"></div>';
	pageTitleLink_str='<input type="checkbox" id="is_title_link" name="is_title_link" value="1" '+isTitleLink+' /><?=$ADMIN_TRANS['linked to full story'];?>';
	if (newPage && ifFooterTitle==-1 && currentCTYPE!=0) pageTitleLink_str+='<div style="clear:both"></div><div class="editor_addPhoto add_button" id="newSaveIcon" onclick="AddNewPicToNewArticle();"><img src="/Admin/images/slides.png" border="0" align="absmiddle" /> <?=$ADMIN_TRANS['add photo'];?></div>';
	//if (currentCTYPE==0) pageTitleLink_str='<input  style="display:none"type="checkbox" id="is_title_link" name="is_title_link" value="1" '+isTitleLink+' />';
	var setHomePage_str='<span style="display:none"><input class="checkBox" type="checkbox" id="PHome" name="PHome" value="1" <?=$HomePageStat;?>>קבע כעמוד הבית &nbsp; </span>'+pageTitleLink_str;
		
	div.innerHTML=pageTitle_str+pageURL_str+"<br />"+lightEditorDiv+buttons_str+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+setHomePage_str;
	editor_ins=CKEDITOR.replace('lightEditor', {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js',
			autoGrow_maxHeight: jQuery(window).height()-400,
			autoGrow_minHeight: jQuery(window).height()-400,
			height:jQuery(window).height()-400
		});
	
	if (newPage) {
		if (!footerMultiTitle) document.getElementById("pageT").value="";
		else document.getElementById("pageT").readOnly=true;
		
		
		document.getElementById("PHome").checked=false;
	}
	else editor_ins.setData(contentDIV.innerHTML);
	//ShowLayer("lightEditorContainer",1,1,0);
	editor_ins.on("loaded",function() {
		slideOutEditor("lightEditorContainer",1);
	});
	
}

function cancelEditing() {
	if (!openDiv) printArea.innerHTML=OriginalContent;
	//document.getElementById("AdminArea").style.display="";
	//ShowLayer("lightEditorContainer",0,1,0);
	slideOutEditor("lightEditorContainer",0);
	NewPicAdding=0;
	editor_ins.destroy();
	
}

function ReloadPage() {
	document.location.reload();
}

function saveContent() {
	SavedPageTitle=document.getElementById("pageT").value;
	var encodedSavedPageTitle=encodeURIComponent(SavedPageTitle);
	var pageURL=document.getElementById("pageURL").value;
	var pageNEW_URL_KEY=document.getElementById("pageURLKEY").value;
//	if  (SavedPageTitle=="" || SavedPageTitle==" ") {
//		alert ("<?//=$ADMIN_TRANS['title is a required field'];?>");
//		return false;
//	}
	//var parentPage=document.getElementById("parentPage").options[document.getElementById("parentPage").selectedIndex].value;
	var pageShow=1;
	var isTitleLink=0;
	var homePage=document.getElementById("PHome").checked;
	if (document.getElementById("is_title_link").checked) isTitleLink=1;
	
	
	var contentType=cType;
	var parentCat=<?=$CHECK_CATPAGE[parentID];?>;
	
	//var pageOrder=document.getElementById("pageOrder").options[document.getElementById("pageOrder").selectedIndex].value;
	
	if (homePage) homePage=1;
	if (openDiv) var cVal=editor_ins.getData();
	else var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	pageUrl=encodeURIComponent(pageURL);
	//document.getElementById("printArea_"+currentPageID).innerHTML="<div id='divContent_'"+currentPageID+"'></div>";
	
	overDIV.style.display="none";
	//OriginalContent=cVal;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'pageID='+currentPageID+'&content='+cVal+'&pagetitle='+encodedSavedPageTitle+'&PShow='+pageShow+'&PHome='+homePage+'&pageUrlKey='+pageNEW_URL_KEY+'&parentCat='+parentCat+'&pageURL='+pageUrl+'&contentType='+contentType+'&titleLink='+isTitleLink;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit, onLoading:savingChanges});
	slideOutEditor("lightEditorContainer",0);
	if (!newPage) {
	document.getElementById("divContent_"+currentPageID).innerHTML=decodeURIComponent(cVal);
	document.getElementById("titleContent_"+currentPageID).innerHTML=SavedPageTitle;
	document.getElementById("p_url_"+currentPageID).innerHTML=pageURL;
	}
	else window.setTimeout('ReloadPage()',1000);
	editor_ins.destroy();

}
function saveContentLocations(pID) {
	currentPageID=pID;
	var pageOrder=document.getElementById("pageOrder").options[document.getElementById("pageOrder").selectedIndex].value;
	var parentPage=document.getElementById("parentPage").options[document.getElementById("parentPage").selectedIndex].value;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'pageID='+currentPageID+'&action=saveLoc&pageOrder='+pageOrder+'&parentPage='+parentPage;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	
}

function successEditDelay() {
	document.getElementById("LoadingDiv").innerHTML="<i class='fa fa-times close_edit_notify'></i>&nbsp;<span class='successEdit'><?=$ADMIN_TRANS['changes saved'];?></span>";
	jQuery(".close_edit_notify").click(function(){jQuery(".LoadingDiv").removeClass("show")});
}
function successEdit() {
	jQuery(".LoadingDiv").removeClass("deleted");
	window.setTimeout('successEditDelay()',700);	
}

function successDel() {
	jQuery(".LoadingDiv").addClass("deleted");
	document.getElementById("LoadingDiv").innerHTML="<i class='fa fa-times close_edit_notify'></i>&nbsp;<span class='successEdit'><?=$ADMIN_TRANS['this content has been deleted'];?></span>";
	jQuery(".close_edit_notify").click(function(){jQuery(".LoadingDiv").removeClass("show")});
}

function deleteContent(pID) {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>\n\r<?=$PAG[PageTitle];?>");
	if (q) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delPage';
		var pars = 'pageID='+pID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDel, onFailure:failedEdit,onLoading:savingChanges});
		Effect.Fade('short_cell-'+pID);
	}
	else return false;
}
function ShowSelectParentPage() {
	if (document.getElementById('SelectPageLocationDiv').style.display=="none") Element.show("SelectPageLocationDiv");
	else Element.hide("SelectPageLocationDiv");
	if (document.getElementById('SelectorLocationDiv').style.display=="none") Element.show("SelectorLocationDiv");
	else Element.hide("SelectorLocationDiv");
}

function AddGallery(type) {
	GalleryType=type;
	$('GalleryTypeTitle').innerHTML="<?=$ADMIN_TRANS['add new photo gallery'];?>";
	if (type==1) $('GalleryTypeTitle').innerHTML="<?=$ADMIN_TRANS['add new video gallery'];?>";
		if (document.getElementById("GalleryEditor").style.display=="none") {
		ShowLayer("GalleryEditor",1,1,1);
		$('NewGalleryName').focus();
	}
	else ShowLayer("GalleryEditor",0,1,1);
}
function AddItem() {
	if (document.getElementById("NewItem").style.display=="none") {
		ShowLayer("NewItem",1,1,1);
		$('NewItem').focus();
	}
	else ShowLayer("NewItem",0,1,1);
}
function successEditGallery() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['changes saved'];?></span>";
	AddGallery(GalleryType);
	document.location.reload();
}
 function successDelPhotoDelay() {
 	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit' style='color:red'><?=$ADMIN_TRANS['photo deleted'];?></span>";
	
 }
 var pasteActionTaken=0;
 var switchPastedTemplate=false;
 function confirmPaste(ok) {
	if (ok) {
		var stylePaste=jQuery("input#pasteStylingCheckbox").is(":checked");
		switchPastedTemplate=jQuery("input#switchTemplate").is(":checked");
		
		copyCategory(<?=$CHECK_CATPAGE[parentID];?>,"pastePageConfirmed",stylePaste);
	}
	else {
		pasteActionTaken=-1;
		copyCategory(0,"nothing",0);
	}
 }
 function selectContentAttr(pageID) {
	ShowLayer("eXite_OperationBox",1,0,1);
	jQuery("#eXite_OperationBox #OperationData").html('<div style="padding-top:50px;text-align:center"><img src="/Admin/images/ajax-loader.gif" align="absmiddle" /></div>');
	jQuery("#eXite_OperationBox #OperationData").load("<?=$SITE[url];?>/Admin/GetContentAttr.php?pageID="+pageID);
 }
 function copyCategory(cID,cpAction,pasteStyle) {
	if (cpAction!="nothing") {
		if (cpAction!="copyPage") ShowLayer("eXite_OperationBox",1,1,1);
		else toggleNotification(cpAction);
		jQuery("#eXite_OperationBox #OperationData").html('<div style="padding-top:50px;text-align:center"><img src="/Admin/images/ajax-loader.gif" align="absmiddle" /></div>');
		jQuery.getJSON("<?=$SITE[url];?>/Admin/saveContentinplace.php?action="+cpAction+"&currentCatID="+cID+"&stylePaste="+pasteStyle+"&switchTemplate="+switchPastedTemplate,function(data)
		   {
			jQuery(".TemplateChooser.green, .adminAction .add.copypage").addClass("copied");
			jQuery(".TemplateChooser.green.copied span#cp, .adminAction .add.copypage .label").html("<?=$COPY_LABELS[$SITE_LANG[selected]]['Copied'];?>");
			switch(data.statuscode) {
				case 2:
					
					jQuery("#eXite_OperationBox #OperationData").html(data.message);
					//var cp_confirm=confirm(data.message);
				break;
				case 4:
					jQuery("#eXite_OperationBox #OperationData").html(data.message);
				break;
			}
			//toggleNotification(cpAction);
		});	
	}
	else {
		 
		if (pasteActionTaken==-1) {
			ShowLayer("eXite_OperationBox",0,1,1);
			jQuery(".TemplateChooser.green").removeClass("copied");
			jQuery(".TemplateChooser.green span#cp").html("<?=$COPY_LABELS[$SITE_LANG[selected]]['PastePage'];?>");
		}
		else {
			jQuery.getJSON("<?=$SITE[url];?>/Admin/saveContentinplace.php?action=cancelCopy");
			alert("Cannot copy a page to itself");
		}
	}
		
}
function successDelPhoto() {
	Effect.Fade("photo_cell-"+deleted_photo_id);
	window.setTimeout('successDelPhotoDelay()',700);	
}
function successDelItem() {
	jQuery(".LoadingDiv").addClass("deleted");
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['item removed'];?></span>";
	Effect.Fade("item-"+deleted_photo_id);
}
function SaveNewGallery(type) {
	var newGalleryName=document.getElementById("NewGalleryName").value;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=saveGallery';
	var pars = 'newGalleryName='+newGalleryName+'&catParentID='+catParentID+'&gallery_type='+GalleryType;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEditGallery, onFailure:failedEdit,onLoading:savingChanges});
}

function DelPhoto(photo_id) {
	deleted_photo_id=photo_id;
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=delPhoto';
	var pars = 'photo_id='+photo_id;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
}

function DelGallery(GalleryID) {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>\n\r<?=$PAG[PageTitle];?>");
	if (q) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delGal';
		var pars = 'gallery_id='+GalleryID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout("ReloadPage()",800);
	}
}
function DelItem(itemID) {
	deleted_photo_id=itemID;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delItem';
	var pars = 'item_id='+itemID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelItem, onFailure:failedEdit,onLoading:savingChanges});
	
}
function resetAll() {
	for (a=0;a<=2;a++) {
		$('ctype_'+a).className='';
	}
}
function AddNewContentType() {
	switch(currentCTYPE) {
		case 2:
		AddGallery(0);
		break;
		case 3:
		AddGallery(1);
		break;
		default :
		EditHere(<?=$CHECK_CATPAGE[parentID]; ?>,1,1);
		break;
	}
}
function change_ctype(type) {
	resetAll();
	var subtype=0;
	if (type==4) {
		type=2;
		subtype=3;//Effect Gallery
	}
	var css_type=type;
	if (css_type==11) css_type=1;
	if (css_type==12 || css_type==21) css_type=1;
	if (css_type==0 || css_type==17) css_type=0;
	if (css_type==15 || css_type==16) css_type=14;
	
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=change_ctype';
	var pars = 'update_catID='+<?=$CHECK_CATPAGE[parentID];?>+'&cType='+type+'&subType='+subtype;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout("ReloadPage()",800);
}

var positioned=0;
var hintClosed=0;


function SetPageStyle(p_style) {
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=change_pagestyle';
	var pars = 'update_catID='+<?=$CHECK_CATPAGE[parentID];?>+'&pageStyle='+p_style;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout("ReloadPage()",800);
}
function SetCatProperty(p,v) {
	setCatStyleProperty(<?=$CHECK_CATPAGE[parentID];?>,v,p);
	window.setTimeout("ReloadPage()",800);
	
}
var deleted_photo_id;

</script>
<?
//$label_for_content=$ADMIN_TRANS['content page'];
//if ($MEMBER[UserType]==0 || $SITE[formsEnabled] == 1) $label_for_content=$ADMIN_TRANS['content or form'];
?>
<div id="eXite_OperationBox" class="CenterBoxWrapper" style="display: none;z-index:10000">
	<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="jQuery(this).parent().parent().toggle();">+</div></div>
	<div class="CenterBoxContent">
		<span id="OperationData"></span>
		<div style="clear: both"></div>
	</div>
</div>
<div dir="<?=$SITE_LANG[direction];?>" id="lightEditorContainer" style="display:none;" align="center" class="editorWrapper"></div>
