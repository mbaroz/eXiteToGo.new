<?
$cat_parentID=$CHECK_CATPAGE[parentID];
$check_box="";

$leftColSide_Selected[$LeftColSide]="selected";
if (intval($isLeftColumnInherit)==1 OR ($check_left_col_inherit AND $isLeftColumnInherit=="")) {
	$check_box="checked";
}
if (isset($_SESSION['LOGGED_ADMIN'])) {
	include_once("Admin/colorpicker.php");
	?>
	<script type="text/javascript">
	var lightLeftColDiv='<div id="lightleftColEditor"></div>';
	function EditLeftColText() {
			var buttons_str;
			var leftColContent=$('leftColumnContent').innerHTML;
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveLeftColContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
			buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancel_edit_leftCol();"><?=$ADMIN_TRANS['cancel'];?></div>';
			var div=$('leftColEditContainer');
			div.innerHTML=lightLeftColDiv+buttons_str+"&nbsp;";
			editor_ins=CKEDITOR.appendTo("lightleftColEditor", {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_news.js'
				});
			editor_ins.setData(leftColContent);
			//ShowLayer("leftColEditContainer",1,1,0);
			slideOutEditor("leftColEditContainer",1);
			jQuery(function() {
				jQuery("#leftColEditContainer").draggable();
			});
		
		}
	function saveLeftColContent() {
			var cVal=editor_ins.getData();
			cVal=encodeURIComponent(cVal);
			var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
			var pars = 'type=left_column_text'+'&content='+cVal+'&objectID=<?=$cat_parentID;?>';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			slideOutEditor("leftColEditContainer",0);
			editor_ins.destroy();
			//ShowLayer("leftColEditContainer",0,1,0);
			$('leftColumnContent').innerHTML=decodeURIComponent(cVal);
			
		}
	function cancel_edit_leftCol() {
			//ShowLayer("leftColEditContainer",0,1,0);
			slideOutEditor("leftColEditContainer",0);
			editor_ins.destroy();
		}
        function setLeftColInherit() {
            var left_col_inherit=1;
           if($('leftColumnCheck').checked) left_col_inherit=1;
			else left_col_inherit=0;
            setCatStyleProperty(<?=$cat_parentID;?>,left_col_inherit,"LeftColInherit");
        }
	function EditLeftColOptions() {
		  if ($('leftColOptions').style.display=="none") slideOutSettings("leftColOptions",1);
		  else  slideOutSettings("leftColOptions",0);
	}
	function saveLeftColOptions() {
		var leftColWidth=$('leftColWidth').value;
		if (leftColWidth<50) leftColWidth=50;
		var leftColSepColor=$('leftColSeperatorColor').value;
		var leftColSide=$('leftColSide').options[$('leftColSide').selectedIndex].value;
		 setCatStyleProperty(<?=$cat_parentID;?>,leftColWidth,"LeftColWidth");
		 setCatStyleProperty(<?=$cat_parentID;?>,leftColSepColor,"leftColSepColor");
		 setCatStyleProperty(<?=$cat_parentID;?>,leftColSide,"leftColSide");
		 ShowLayer('leftColOptions',0,1,1);
		 window.setTimeout('ReloadPage()',600);
	}
	</script>
	
        <div style="clear:both;height:10px;"></div>
	
	<div id="newSaveIcon" onclick="EditLeftColText();"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" />&nbsp;<?=$ADMIN_TRANS['edit content'];?></div>
	&nbsp;
	<div id="newSaveIcon"  onclick="EditLeftColOptions();"><img src="<?=$SITE[url];?>/Admin/images/settings_icon.png" border="0" align="absmiddle" /> <?=$ADMIN_TRANS['options'];?></div>
	
	<div dir="<?=$SITE_LANG[direction];?>" id="leftColEditContainer" style="display:none;width:320px;<?=$SITE[opalign];?>:15%;margin-left:auto;" class="editorWrapper"></div>
		
	<div style="width:450px;display:none;" id="leftColOptions" class="CatEditor settings_slider"  dir="<?=$SITE[direction];?>">
	<div align="<?=$SITE[opalign];?>"><img class="button" src="<?=$SITE[url];?>/images/close_icon.gif" border="0" onclick="EditLeftColOptions()"></div>
		<strong><?=$ADMIN_TRANS['options'];?></strong>
		<br />
		<input type="checkbox" name="leftColumnCheck" id="leftColumnCheck" onclick="setLeftColInherit()" <?=$check_box;?>><?=$ADMIN_TRANS['show in all sub-pages from here'];?>
		<table border="0" cellspacing="2">
			<tr>
			<td><?=$ADMIN_TRANS['column width'];?>: </td>
			<td><input type="text" maxlength="3" value="<?=$customLeftColWidth;?>" name="leftColWidth" id="leftColWidth" style="width:50px;direction:ltr"/>
				&nbsp;<small>(<?=$ADMIN_TRANS['width in pixels'];?>)</small>
			</td>
			</tr>
			<tr>
			<td style="width:155px;"><?=$ADMIN_TRANS['seperator line color for this column'];?>: </td><td><?PickColor("leftColSeperatorColor",$leftColSeperatorColor);?> (<a href="#" onclick="$('leftColSeperatorColor').value='-';">Transparent</a>)</td>
			</tr>
			<tr>
			<td style="width:155px;"><?=$ADMIN_TRANS['show this column at'];?>:</td>
			<td>
				<select name="leftColSide" id="leftColSide">
				<option value="<?=$SITE[opalign];?>" <?=$leftColSide_Selected[$SITE[opalign]];?>><?=$ADMIN_TRANS[right];?></option>
				<option value="<?=$SITE[align];?>" <?=$leftColSide_Selected[$SITE[align]];?>><?=$ADMIN_TRANS[left];?></option>
			</td>
			</tr>
			
		</table>
		<br><br>
		<div align="center"><div id="newSaveIcon" class="greenSave"  onclick="saveLeftColOptions()"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" borde="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div></div>
	</div>
	<?
	
}

?>
<div class="leftColumn_border">
<?
$LEFT_COLUMN_CONTENT=GetPageTitle($cat_parentID,"left_column_text");

if ($LEFT_COLUMN_CONTENT[Content]=="" AND $leftCol_Parent_Cat!="" AND $CHECK_INHERIT_LEFT[left_inherit]==1) $LEFT_COLUMN_CONTENT=GetPageTitle($leftCol_Parent_Cat,"left_column_text");

if ($LEFT_COLUMN_CONTENT[Content]=="" AND $CHECK_LEFT_INHERIT_TMP[left_inherit]==1) $LEFT_COLUMN_CONTENT=GetPageTitle(1,"left_column_text"); //added 5/6/12

if ($SITE[roundcorners] AND $LEFT_COLUMN_CONTENT[Content] AND $SITE[leftcolbgcolor]) SetShortContentRoundedCorners(1,1,$SITE[leftcolbgcolor],"100%");
?>
<div id="leftColumnContent" align="<?=$SITE[align];?>" class="mainContentText"><?=$LEFT_COLUMN_CONTENT[Content];?></div>
<?
if ($SITE[roundcorners] AND $LEFT_COLUMN_CONTENT[Content] AND $SITE[leftcolbgcolor]) SetShortContentRoundedCorners(0,0,$SITE[leftcolbgcolor],"100%");
if ($LEFT_COLUMN_CONTENT[Content]) print '<div style="clear:both;height:0px;"></div>';
?>
</div>