<?
//TODO:
if (!$CHECK_CATPAGE) $CHECK_CATPAGE=$pID;
function ListPagesTree($level, $parent) {
	global $parentID;
	$cID=$parentID;
	$CATS=GetCatMenu();
	$categoryCount=count($CATS[CatID]);
	 for ($i=0; $i<$categoryCount; $i++) {
	 	$indent="";
	  	if ($CATS[ParentID][$i] == $parent) {
	  		for ($j=0; $j<$level; $j++) {
	  			$indent.="&nbsp;›";
	   		} //end for
	   		if ($cID==$CATS[CatID][$i]) print "<option value=".$CATS[CatID][$i]." selected>".$indent.$CATS[PageTitle][$i]."</option>";
	   		else print "<option value=".$CATS[CatID][$i].">".$indent.$CATS[MenuTitle][$i]."</option>";
	   		ListPagesTree($level+1, $CATS[CatID][$i]);
	   	} //end if
	   	  
 	} //end for
} //end function
?>
<script type="text/javascript" src="<?=$SITE[url];?>/editor/fckeditor.js"></script>
<script language="javascript" type="text/javascript">
var OriginalContent;
var msgDivText="";
var currentPageID;
var SavedPageTitle;
//var divContent;
var openDiv=0;
//var printArea;
var pageUrlKey=new Array();
var newPage=0;
var url="";
var DivMessage="Loading...";
function loadingData() {
	$('pageCatsContainer').innerHTML=DivMessage;
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
	ShowLayer("pageCatsContainer",1,1);
	url="<?=$SITE[url];?>/Admin/GetPageCats.php?pageID="+pageID;
	GetRemoteHTML("pageCatsContainer");
	
}
function GetRemoteHTML(TargetDiv) {
	
	if (DivMessage) document.getElementById(TargetDiv).innerHTML=DivMessage;
	if (TargetDiv) 
		var TargetDATA=document.getElementById(TargetDiv);
	
	new Ajax.Request(url, {
	  method: 'post',
	  onCreate:loadingData,
	  onSuccess: function(transport){
	     var response = transport.responseText;
	    if (TargetDiv)  TargetDATA.innerHTML=response;
	       }
	    });
}

function EditHere(pID,newPG,open) {
	currentPageID=pID;
	newPage=newPG;
	if (newPage) {
		currentPageID="";
		pageUrlKey="";
	}
	else {
		var pageTitle=document.getElementById("titleContent_"+pID).innerText  || document.getElementById("titleContent_"+pID).textContent;
		
		}
	
	var buttons_str;
	openDiv=open;
	if(openDiv) ShowLayer("lightEditorContainer",1,1);
	
	//if (!OriginalContent) OriginalContent=document.getElementById("printArea").innerHTML;
	if (openDiv) {
		var div = document.getElementById("lightEditorContainer"); //changed from document.getElementById("printArea")
		var fck = new FCKeditor("lightEditor");
	}
	else {
		var div = document.getElementById("printArea")
		var fck = new FCKeditor("printArea");
	}
	fck.BasePath="<?=$SITE[url];?>/editor/";
	fck.Config["CustomConfigurationsPath"]="<?=$SITE[url];?>/editor/InPlaceConfig.js";
	fck.Height=400;
	fck.Width=700;
	fck.Config["ToolbarStartExpanded "]=false;
	fck.Config["ContentLangDirection"]="rtl";
	if (!newPage) fck.Value=document.getElementById('divContent_'+pID).innerHTML;
	
	buttons_str='<input type="button" id="saveContentButton" value="שמור שינויים" onclick="saveContent();" style="color:green">';
	buttons_str+='&nbsp;&nbsp;<input type="button" id="saveContentButton" value="ביטול" onclick="cancelEditing();" style="color:gray">';
	pageTitle_str='<h4 align="right">כותרת <input class="inputTextTitle"  type="text" id="pageT" name="pageT" value="'+pageTitle+'">&nbsp; <img src="<?=$SITE[url];?>/images/saveIcon.gif" class="button" onclick="saveContent();">&nbsp; <img src="<?=$SITE[url];?>/images/close_icon.gif" border="0" class="button" onclick="cancelEditing();"></h4>';
	var setHomePage_str='<input class="checkBox" type="checkbox" id="PHome" name="PHome" value="1" <?=$HomePageStat;?>>קבע כעמוד הבית &nbsp; ';
	setHomePage_str+='<input class="checkBox" type="checkbox" id="PShow" name="PShow" value="1" <?=$stateShow;?>>הצג דף<br />';
	
	div.innerHTML=pageTitle_str+fck.CreateHtml()+"<br />"+buttons_str+"&nbsp;"+setHomePage_str;
	
	//document.getElementById("AdminArea").style.display="none";
	if (newPage) {
		document.getElementById("pageT").value="";
		document.getElementById("PHome").checked=false;
	}
}

function cancelEditing() {
	if (!openDiv) printArea.innerHTML=OriginalContent;
	//document.getElementById("AdminArea").style.display="";
	ShowLayer("lightEditorContainer",0,1);
	
}

function saveContent() {
	SavedPageTitle=document.getElementById("pageT").value;
	if  (SavedPageTitle=="" || SavedPageTitle==" ") {
		alert ("יש לרשום כותרת עמוד");
		return false;
	}
	//var parentPage=document.getElementById("parentPage").options[document.getElementById("parentPage").selectedIndex].value;
	var pageShow=document.getElementById("PShow").checked;
	var homePage=document.getElementById("PHome").checked;
	var parentCat=<?=$CHECK_CATPAGE[parentID];?>;
	
	//var pageOrder=document.getElementById("pageOrder").options[document.getElementById("pageOrder").selectedIndex].value;
	if (pageShow) pageShow=1;
	if (homePage) homePage=1;
	if (openDiv) var cVal=FCKeditorAPI.GetInstance('lightEditor').GetData(true);
	else var cVal=FCKeditorAPI.GetInstance('printArea').GetData(true);
	cVal=encodeURIComponent(cVal);
	//document.getElementById("printArea_"+currentPageID).innerHTML="<div id='divContent_'"+currentPageID+"'></div>";
	
	overDIV.style.display="none";
	//OriginalContent=cVal;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'pageID='+currentPageID+'&content='+cVal+'&pagetitle='+SavedPageTitle+'&PShow='+pageShow+'&PHome='+homePage+'&pageUrlKey='+pageUrlKey[currentPageID]+'&parentCat='+parentCat;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	$('lightEditorContainer').hide();
	if (!newPage) {
	document.getElementById("divContent_"+currentPageID).innerHTML=decodeURIComponent(cVal);
	document.getElementById("titleContent_"+currentPageID).innerHTML=SavedPageTitle;
	}
	else document.location.reload();

}
function saveContentLocations(pID) {
	currentPageID=pID;
	var pageOrder=document.getElementById("pageOrder").options[document.getElementById("pageOrder").selectedIndex].value;
	var parentPage=document.getElementById("parentPage").options[document.getElementById("parentPage").selectedIndex].value;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'pageID='+currentPageID+'&action=saveLoc&pageOrder='+pageOrder+'&parentPage='+parentPage;
	
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	
}
function successEdit() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'>השינויים נשמרו בהצלחה</span>";
	
}
function successDel() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><font color=red>תוכן זה נמחק מהאתר</font></span>";
}

function deleteContent(pID) {
	var q=confirm ("האם למחוק עמוד זה ? \n\r<?=$PAG[PageTitle];?>");
	if (q) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delPage';
		var pars = 'pageID='+pID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDel, onFailure:failedEdit,onLoading:savingChanges});
		Effect.Fade('cHolder-item_'+pID);
	}
	else return false;
}
function ShowSelectParentPage() {
	if (document.getElementById('SelectPageLocationDiv').style.display=="none") Element.show("SelectPageLocationDiv");
	else Element.hide("SelectPageLocationDiv");
	if (document.getElementById('SelectorLocationDiv').style.display=="none") Element.show("SelectorLocationDiv");
	else Element.hide("SelectorLocationDiv");
}

function AddGallery() {
		if (document.getElementById("GalleryEditor").style.display=="none") {
		ShowLayer("GalleryEditor",1,1);
		$('NewGalleryName').focus();
	}
	else ShowLayer("GalleryEditor",0,1);
}
function successEditGallery() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'>גלריה נשמרה בהצלחה</span>";
	AddGallery();
	document.location.reload();
}
function successDelPhoto() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit' style='color:red'>תמונה נמחקה בהצלחה</span>";
	Effect.Fade("photo_cell-"+deleted_photo_id);
}
function SaveNewGallery() {
	var newGalleryName=document.getElementById("NewGalleryName").value;
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=saveGallery';
	var pars = 'newGalleryName='+newGalleryName+'&catParentID='+catParentID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEditGallery, onFailure:failedEdit,onLoading:savingChanges});
}
function AddNewPic() {
	if (document.getElementById("PicUploader").style.display=="none") {
		ShowLayer("PicUploader",1,1);
		$('PicUploader').focus();
	}
	else ShowLayer("PicUploader",0,1);
	
}
function DelPhoto(photo_id) {
	deleted_photo_id=photo_id;
	var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=delPhoto';
	var pars = 'photo_id='+photo_id;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
}
function DelGallery(GalleryID) {
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delGal';
	var pars = 'gallery_id='+GalleryID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
	document.location.reload();
}
var deleted_photo_id;
</script>
<div dir="rtl" id="lightEditorContainer" style="display:none;z-index:100;padding:10px;position:absolute;top:100px;left:200px;background-color:#E0ECFF;border:3px solid #C3D9FF"></div>
<div dir="rtl" id="pageCatsContainer" style="width:280px;height:300px;overflow-y:auto;display:none;z-index:100;padding:10px;position:absolute;top:90px;left:390px;background-color:#E0ECFF;border:2px solid #C3D9FF"></div>
<div dir="rtl" id="GalleryEditor" style="display:none;z-index:100;padding:10px;position:absolute;top:200px;left:300px;background-color:#E0ECFF;border:2px solid #C3D9FF">
הוספת גלריית תמונות : <br />
<input type="text" size="50" id="NewGalleryName" name="NewGalleryName"><br /><br />

<input id="saveContentButton" type="button" value="הוסף" onclick="SaveNewGallery();">
&nbsp; &nbsp;
<input id="saveContentButton" type="button" value="ביטול" onclick="AddGallery();">
</div>

<img class="button" onclick="EditHere(<?=$CHECK_CATPAGE[parentID]; ?>,1,1)" src="<?=$SITE[url];?>/images/NewPageIcon.gif" align="absmiddle" border="0" title="&nbsp;הוסף עמוד חדש">
&nbsp;&nbsp;
<img class="button" onclick="AddGallery()" src="<?=$SITE[url];?>/images/addGaleryIcon.gif" align="absmiddle" border="0" title="&nbsp;הוסף גלריה">