<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script type="text/javascript">
	var OrigSideContactText;
	function EditSideContactContent() {
			var contentDIV = document.getElementById("sideContactText");
			OrigSideContactText=contentDIV.innerHTML;
			var buttons_str;
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveSideContactContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
			buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancelsidecontactedit();"><?=$ADMIN_TRANS['cancel'];?></div>';
			var div=$('lightSideTextContainer');
			div.innerHTML=lightSideTextDiv+buttons_str+"&nbsp;";
			editor_ins=CKEDITOR.appendTo("lightsideEditor", {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_news.js'
				});
			editor_ins.setData(contentDIV.innerHTML);
			//ShowLayer("lightSideTextContainer",1,1,0);
			slideOutEditor("lightSideTextContainer",1);
	}
	function saveSideContactContent() {
			var cVal=editor_ins.getData();
			cVal=encodeURIComponent(cVal);
			var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
			var pars = 'type=sidecontact_text'+'&content='+cVal+'&objectID=0';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			//ShowLayer("lightSideTextContainer",0,1,0);
			slideOutEditor("lightSideTextContainer",0);
			$('sideContactText').innerHTML=decodeURIComponent(cVal);
			editor_ins.destroy();
		}
	function cancelsidecontactedit() {
			$('sideContactText').innerHTML=OrigSideContactText;
			//ShowLayer("lightSideTextContainer",0,1,0);
			slideOutEditor("lightSideTextContainer",0);
			editor_ins.destroy();
		}
	</script>
	<br /><br />
	&nbsp;<div id="newSaveIcon"  onclick="EditSideContactContent();"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit content'];?></div>
	&nbsp;<span style="display:none" id="saveSideContactButton"><div style="display:" id="newSaveIcon" onclick="saveSideContactContent()"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save'];?></div></span>
	&nbsp;&nbsp;<span style="display:none" id="closeSideContactButton"><div id="newSaveIcon" onclick="cancelsidecontactedit()"><img src="<?=$SITE[url];?>/Admin/images/close_icon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['cancel'];?></div></span>
	<?
	
}
$SIDE_CONTACT_CONTENT=GetPageTitle(0,"sidecontact_text");
?>
<div id="sideContactText" style="padding-<?=$SITE[align];?>:12px;padding-top:1px;padding-<?=$SITE[opalign];?>:1px" align="<?=$SITE[align];?>" class="mainContentText"><?=$SIDE_CONTACT_CONTENT[Content];?></div>