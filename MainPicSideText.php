<?
$homeARRAYCatID=GetIDFromUrlKey("home");
$homeCatID=$homeARRAYCatID[parentID];
$mainPicParentID=$CHECK_CATPAGE[parentID];

if ($CHECK_PAGE) {
	$PageCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
	if ($CHECK_PAGE[productUrlKey]) $PageCatUrlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
	$CAT_PARENT_ID=GetIDFromUrlKey($PageCatUrlKey);
	$mainPicParentID=$CAT_PARENT_ID[parentID];
}
if (isset($_SESSION['LOGGED_ADMIN']) AND ($MEMBER[UserType]==0 OR $SITE[usersPerms]==1)) {
	?>
	<script type="text/javascript">
	var OrigTopMainPicSideContent;
	var lightMainPicSideTextDiv='<div id="lightsidepicEditor"></div>';
	function EditMainPicSideContent() {
			var buttons_str;
			var contentDIV=$('mainPicSideText').innerHTML;
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveMainPicSideContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
			buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancelmainpicside();"><?=$ADMIN_TRANS['cancel'];?></div>';
			OrigTopMainPicSideContent=contentDIV;
			var div=$('lightEditorContainer');
			div.innerHTML=lightMainPicSideTextDiv+buttons_str+"&nbsp;";
			editor_ins=CKEDITOR.appendTo("lightsidepicEditor", {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
				});
			editor_ins.setData(contentDIV);
			//ShowLayer("lightSideMainPicContainer",1,1,1);
			slideOutEditor("lightEditorContainer",1);
			
		
		}
	function saveMainPicSideContent() {
			var cVal=editor_ins.getData();
			cVal=encodeURIComponent(cVal);
			var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
			var pars = 'type=mainpic_side_text'+'&content='+cVal+'&objectID=<?=$mainPicParentID;?>';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			
			$('mainPicSideText').innerHTML=decodeURIComponent(cVal);
			//ShowLayer("lightSideMainPicContainer",0,1,1);
			slideOutEditor("lightEditorContainer",0);
			editor_ins.destroy();
		}
	function cancelmainpicside() {
			$('mainPicSideText').innerHTML=OrigTopMainPicSideContent;
			slideOutEditor("lightEditorContainer",0);
			editor_ins.destroy();
			//ShowLayer("lightSideMainPicContainer",0,1,1);
		}
	</script>
	
	<?

}

$SIDE_MAINPIC_CONTENT=GetPageTitle($mainPicParentID,"mainpic_side_text");
if ($SIDE_MAINPIC_CONTENT[Content]=="") $SIDE_MAINPIC_CONTENT=GetParentMainPicSideText($urlKey);

//if ($SIDE_MAINPIC_CONTENT[Content]=="") $SIDE_MAINPIC_CONTENT=GetPageTitle($homeCatID,"mainpic_side_text");
?>
<div class="topMainPicSideText">
	<div id="mainPicSideText" style="padding-top:0px;padding-<?=$SITE[opalign];?>:1px" align="<?=$SITE[align];?>"><?=$SIDE_MAINPIC_CONTENT[Content];?></div>
	
<?
if (isset($_SESSION['LOGGED_ADMIN']) AND ($MEMBER[UserType]==0 OR $SITE[usersPerms]==1)) {
	?>
	<div id="newSaveIcon"  onclick="EditMainPicSideContent();" style="position:absolute;top:1%;left:0"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit'];?></div>
	
	<?
}
?>
</div>


