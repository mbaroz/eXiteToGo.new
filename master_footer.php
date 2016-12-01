<?
$cat_parentID=$CHECK_CATPAGE[parentID];
if ($CHECK_PAGE) {
	
	//$PageCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
	//if ($CHECK_PAGE[productUrlKey]) $PageCatUrlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
        //$CAT_PARENT_ID=GetIDFromUrlKey($PageCatUrlKey);
	//$cat_parentID=$CAT_PARENT_ID[parentID];
	//if ($CHECK_PAGE[ProductID]) $cat_parentID=$CHECK_PAGE[parentID];
}


if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script type="text/javascript">
        var lightMasterFooterTextDiv='<div id="lightmasterfooterEditor"></div>';
	function EditMasterFooterContent() {
			var buttons_str;
			var masterfooterContent=$('master_footer_content').innerHTML;
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveMasterFooterContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
			buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" class="cancel" onclick="cancelmasterfooteredit();"><?=$ADMIN_TRANS['cancel'];?></div>';
			var div=$('lightMasterFooterTextContainer');
			div.innerHTML=lightMasterFooterTextDiv+buttons_str+"&nbsp;";
			editor_ins=CKEDITOR.appendTo("lightmasterfooterEditor", {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
				});
			editor_ins.setData(masterfooterContent);
			//ShowLayer("lightMasterFooterTextContainer",1,1,0);
			
			editor_ins.on("loaded",function() {
				slideOutEditor("lightMasterFooterTextContainer",1);
			});
			
			jQuery(function() {
				jQuery("#lightMasterFooterTextContainer").draggable();
			});
		
		}
	function saveMasterFooterContent() {
			var cVal=editor_ins.getData();
			cVal=encodeURIComponent(cVal);
			var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
			var pars = 'type=master_footer_text'+'&content='+cVal+'&objectID=<?=$cat_parentID;?>';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			
			//ShowLayer("lightMasterFooterTextContainer",0,1,0);
			slideOutEditor("lightMasterFooterTextContainer",0);
			editor_ins.destroy();
			$('master_footer_content').innerHTML=decodeURIComponent(cVal);
		}
	function cancelmasterfooteredit() {
			
			slideOutEditor("lightMasterFooterTextContainer",0);
			//ShowLayer("lightMasterFooterTextContainer",0,1,0);
			editor_ins.destroy();
		}
	
	</script>
	
        <div dir="<?=$SITE_LANG[direction];?>" id="lightMasterFooterTextContainer" style="display:none;" class="editorWrapper" align="center"></div>
	<?
	
}
$marginiaer_increment=0;
if (ieversion()>0 AND ieversion()>7) $marginiaer_increment=1;
$MASTER_FOOTER_CONTENT=GetPageTitle($cat_parentID,"master_footer_text");
if ($MASTER_FOOTER_CONTENT[Content]=="") $MASTER_FOOTER_CONTENT=GetPageTitle(1,"master_footer_text");
?>
<div id="footerMaster_marginizer" style="clear:both"></div>
<div class="masterFooter_wrapper" align="center">
    <div class="masterFooter_inner mainContentText" id="master_footer_content"><?=$MASTER_FOOTER_CONTENT[Content];?></div>
    <?
   if (isset($_SESSION['LOGGED_ADMIN'])) {
        ?>
        <div style="clear: both"></div>
        <div id="newSaveIcon"  onclick="EditMasterFooterContent();" dir="<?=$SITE_LANG[direction];?>"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit content'];?></div>
        <?
    }
    ?>
</div>
<script>
var master_footer_height=jQuery(".masterFooter_wrapper").height()-<?=$marginiaer_increment;?>;

<?
if ($SITE[footermasteropacty]=="" OR $SITE[footermasteropacty]==100 OR isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	jQuery("#mini_cart").css("margin-bottom",master_footer_height+"px");
	jQuery("#footerMaster_marginizer").css('height',master_footer_height+"px");
	<?
}
?>
		
</script>
