<script language="javascript">
var lightProdGalDiv='<div id="lightProdTextEditor"></div>';

function EditGalContent() {
	var buttons_str;
	var sloganContent=$('galSideText').innerHTML;
	
	buttons_str='<input type="button" id="saveContentButton" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="saveSloganContent();" style="color:green">';
	buttons_str+='&nbsp;&nbsp;<input type="button" id="saveContentButton" value="<?=$ADMIN_TRANS['cancel'];?>" onclick="cancelSloganEdit();" style="color:gray">';
	
	var div=$('lightGalTextContainer');
	div.innerHTML=lightProdGalDiv+buttons_str+"&nbsp;";
	editor_ins=CKEDITOR.appendTo('lightProdTextEditor', {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[url];?>/ckeditor/config_full_inline.js'
		});
		editor_ins.setData(sloganContent);
		ShowLayer("lightGalTextContainer",1,1,1);
			jQuery(function() {
				jQuery("#lightGalTextContainer").draggable();
	});

}
function saveProdGalContent() {
	var cVal=editor_ins.getData();
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'content='+cVal+'&action=renameSlogen';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	editor_ins.destroy();
	ShowLayer("lightSloganContainer",0,1,1);
	$('topSlogen').innerHTML=decodeURIComponent(cVal);
}
function cancelProdGalEdit() {
	ShowLayer("lightSloganContainer",0,1,1);
	editor_ins.destroy();
}
</script>
<div dir="<?=$SITE_LANG[direction];?>" id="lightGalTextContainer" style="display:none;z-index:1100;padding:10px;background-color:#E0ECFF;border:3px solid #C3D9FF;position:absolute;width:auto"></div>
