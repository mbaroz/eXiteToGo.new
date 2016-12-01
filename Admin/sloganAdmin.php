<script language="javascript">
var lightSloganDiv='<div id="lightsloganEditor"></div>';

function EditSloganContent() {
	var buttons_str;
	var sloganContent=$('topSlogen').innerHTML;
	buttons_str='<br><div id="newSaveIcon" onclick="saveSloganContent();" class="greenSave"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
	buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" class="cancel" onclick="cancelSloganEdit();"><?=$ADMIN_TRANS['cancel'];?></div>';
	var div=$('lightEditorContainer');
	div.innerHTML=lightSloganDiv+buttons_str+"&nbsp;";
	editor_ins=CKEDITOR.appendTo('lightsloganEditor', {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
		});
		editor_ins.setData(sloganContent);
		slideOutEditor("lightEditorContainer",1);
		//ShowLayer("lightSloganContainer",1,1,0);
		

}
function saveSloganContent() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'content='+cVal+'&action=renameSlogen';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	slideOutEditor("lightEditorContainer",0);
	//ShowLayer("lightSloganContainer",0,1,0);
	editor_ins.destroy();
	$('topSlogen').innerHTML=decodeURIComponent(cVal);
}
function cancelSloganEdit() {
	//ShowLayer("lightSloganContainer",0,1,0);
	slideOutEditor("lightEditorContainer",0);
	editor_ins.destroy();
}
</script>

<div id="newSaveIcon" style="position:absolute;" onclick="EditSloganContent();"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit content'];?></div>
