<?
$parentID=$CONTENT[PageID];
?>

<script type="text/javascript" src="<?=$SITE[cdn_url];?>/ckeditor/ckeditor.js"></script>
<script language="javascript" type="text/javascript">
var pageUrlKey="<?=$CONTENT[UrlKey];?>";
var currentPageID;
var editor_ins;
var editor_browsePath="<?=$SITE[url];?>/ckfinder";
function EditInPlace(pID) {
	var contentDIV = document.getElementById("divContent");
	currentPageID=pID;
	editor_ins=CKEDITOR.replace(contentDIV, {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full_inline.js'
		});
	$('closeEditorButton').show();
	$('saveButton').show();
}
function saveContent() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'pageID='+currentPageID+'&content='+cVal+'&action=savePageContent';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	editor_ins.destroy();
	$('saveButton').hide();
	$('closeEditorButton').hide();
}
function cancelediting() {
	$('saveContentButton').hide();
	$('closeEditorButton').hide();
	editor_ins.destroy();
}
function deleteContent(pID) {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delPage';
		var pars = 'pageID='+pID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDel, onFailure:failedEdit,onLoading:savingChanges});
		Effect.Fade("cHolder");
	}
	else return false;
}
function successEdit() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['changes saved'];?></span>";
	
}
function successDel() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><font color=red><?=$ADMIN_TRANS['content deleted'];?></font></span>";
}
</script>
<div style="padding-top:10px;padding-<?=$SITE[align];?>:10px">
	<div id="newSaveIcon" onclick="EditInPlace(<?=$parentID;?>,'',1)"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" align="absmiddle" border="0"> <?=$ADMIN_TRANS['edit'];?></div>
	<span style="display:none" id="closeEditorButton"><div id="newSaveIcon" onclick="cancelediting()"><img src="<?=$SITE[url];?>/Admin/images/close_icon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['cancel'];?></div></span>
	<span style="display:none" id="saveButton"><div id="newSaveIcon" onclick="saveContent()"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save'];?></div></span>
	<div id="newSaveIcon" style="display:none" onclick="deleteContent(<?=$parentID;?>)"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" align="absmiddle" border="0" title="<?=$ADMIN_TRANS['delete'];?>">&nbsp;<?=$ADMIN_TRANS['delete content'];?></div>
</div>
<div style="height:10px"></div>