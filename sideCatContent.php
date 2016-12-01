<?
$cat_parentID=$CHECK_CATPAGE[parentID];
if ($CHECK_PAGE) {
	
	$PageCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
	if ($CHECK_PAGE[productUrlKey]) $PageCatUrlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
	$CAT_PARENT_ID=GetIDFromUrlKey($PageCatUrlKey);
	$cat_parentID=$CAT_PARENT_ID[parentID];
	if ($CHECK_PAGE[ProductID]) $cat_parentID=$CHECK_PAGE[parentID];
}
$CHECK_BOTTOM_CAT_CONTENT_INHERITED=CheckCatTopBottomContentParent($cat_parentID,"bottomCatContentInherit");

if (isset($_SESSION['LOGGED_ADMIN'])) {
	$isCatBottomContentInherit=GetCatStyle("bottomCatContentInherit",$cat_parentID);
	if ($isCatBottomContentInherit==1) $isCatBottomContentInheritChecked="checked";
		else $isCatBottomContentInheritChecked="";
	?>
	<script type="text/javascript">
	function EditSideCatsContent() {
			var buttons_str;
			var sideCatTopContent=$('sideCatContent').innerHTML;
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveSideCatsContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
			buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancelsideedit();"><?=$ADMIN_TRANS['cancel'];?></div>';
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
			editor_ins.setData(sideCatTopContent);
			//ShowLayer("lightSideTextContainer",1,1,0);
			slideOutEditor("lightSideTextContainer",1);
			jQuery(function() {
				jQuery("#lightSideTextContainer").draggable();
			});
		
		}
	function saveSideCatsContent() {
			var cVal=editor_ins.getData();
			cVal=encodeURIComponent(cVal);
			var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
			var pars = 'type=sidecats_text'+'&content='+cVal+'&objectID=<?=$cat_parentID;?>';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			
			//ShowLayer("lightSideTextContainer",0,1,0);
			slideOutEditor("lightSideTextContainer",0);
			editor_ins.destroy();
			$('sideCatContent').innerHTML=decodeURIComponent(cVal);
		}
	function cancelsideedit() {
			//ShowLayer("lightSideTextContainer",0,1,0);
			slideOutEditor("lightSideTextContainer",0);
			editor_ins.destroy();
		}
	function setTopBottomContentCatInherit(o,what) {
		var inherit_flag=0;
		if (jQuery(o).attr('checked')) inherit_flag=1;
		setCatStyleProperty(<?=$cat_parentID;?>,inherit_flag,what);
	}
	</script>
	<br /><br />
	&nbsp; <div id="newSaveIcon"  onclick="EditSideCatsContent();"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit bottom content'];?></div>
	<span class="mainContentText" style="font-size:12px;"><input type="checkbox" <?=$isCatBottomContentInheritChecked;?> id="setCatBottomContentInherit" onclick="setTopBottomContentCatInherit(this,'bottomCatContentInherit')"><?=$ADMIN_TRANS['show in all sub-pages'];?></span>
	<?
	
}
$SIDE_CONTENT=GetPageTitle($cat_parentID,"sidecats_text");
if ($SIDE_CONTENT[Content]=="" AND $CHECK_BOTTOM_CAT_CONTENT_INHERITED[inherit_flag_cat_content]==1 AND $CHECK_BOTTOM_CAT_CONTENT_INHERITED[parent_cat_id]!="") $SIDE_CONTENT=GetPageTitle($CHECK_BOTTOM_CAT_CONTENT_INHERITED[parent_cat_id],"sidecats_text");
?>
<div id="sideCatContent" style="padding-<?=$SITE[align];?>:12px;padding-top:1px;padding-<?=$SITE[opalign];?>:1px" align="<?=$SITE[align];?>" class="mainContentText"><?=$SIDE_CONTENT[Content];?></div>
<?include_once("sideCatAddOns.inc.php");?>