<?
$cat_parentID=$CHECK_CATPAGE[parentID];
$isiFF =strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'firefox');
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
        var lightMasterHeaderTextDiv='<div id="lightmasterheaderEditor"></div>';
	var saveType;
	function EditMasterHeaderContent(top_bottom_menu) {
			var buttons_str;
			var masterheaderContent=$('master_header_content').innerHTML;
			saveType="master_header_text";
			if (top_bottom_menu=="bottommenu") {
				masterheaderContent=$('master_header_content_bottommenu').innerHTML;
				saveType="master_header_text_bottommenu";
			}
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveMasterHeaderContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
			buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" class="cancel" onclick="cancelmasterheaderedit();"><?=$ADMIN_TRANS['cancel'];?></div>';
			
			var div=$('lightMasterHeaderTextContainer');
			div.innerHTML=lightMasterHeaderTextDiv+buttons_str+"&nbsp;";
			editor_ins=CKEDITOR.appendTo("lightmasterheaderEditor", {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
				});
			editor_ins.setData(masterheaderContent);
			//ShowLayer("lightMasterHeaderTextContainer",1,1,0);
			editor_ins.on("loaded",function() {
				slideOutEditor("lightMasterHeaderTextContainer",1);
			});
			jQuery(function() {
				jQuery("#lightMasterHeaderTextContainer").draggable();
			});
		
		}
	function saveMasterHeaderContent() {
			var cVal=editor_ins.getData();
			//if (saveType=="master_header_text_bottommenu") cVal=editor_ins.getData('master_header_content_bottommenu');
			cVal=encodeURIComponent(cVal);
			var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
			var pars = 'type='+saveType+'&content='+cVal+'&objectID=<?=$cat_parentID;?>';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			//ShowLayer("lightMasterHeaderTextContainer",0,1,0);
			slideOutEditor("lightMasterHeaderTextContainer",0);
			editor_ins.destroy();
			if (saveType=="master_header_text_bottommenu") $('master_header_content_bottommenu').innerHTML=decodeURIComponent(cVal);
				else $('master_header_content').innerHTML=decodeURIComponent(cVal);
		}
	function cancelmasterheaderedit() {
			slideOutEditor("lightMasterHeaderTextContainer",0);
			editor_ins.destroy();
			//ShowLayer("lightMasterHeaderTextContainer",0,1,0);
		}
		
	</script>
	
        <div dir="<?=$SITE_LANG[direction];?>" id="lightMasterHeaderTextContainer" style="display:none;" class="editorWrapper" align="center"></div>
	<?
	
}
$MASTER_HEADER_CONTENT=GetPageTitle($cat_parentID,"master_header_text");
//$MASTER_HEADER_CONTENT_UNDERMENU=GetPageTitle($cat_parentID,"master_header_text_undermenu");
if ($MASTER_HEADER_CONTENT[Content]=="") $MASTER_HEADER_CONTENT=CheckMasterHeaderContent($urlKey,"master_header_text");

if ($MASTER_HEADER_CONTENT[Content]=="") $MASTER_HEADER_CONTENT=GetPageTitle(1,"master_header_text");

?>

<div class="masterHeader_wrapper" align="center">
    <div class="masterHeader_inner mainContentText" id="master_header_content"><?=$MASTER_HEADER_CONTENT[Content];?></div>
    <?
	if (($SITE[topmenubottom]==3 OR $SITE[topmenubottom]==4) AND ($P_DETAILS[HideTopMenu]==0)) {
		print '<div class="masterHeader_innerTopMenu">';
		if ($SITE[topmenubottom]==4) {
			?>
			<style>.masterHeader_inner{padding:0px 10px 0px 10px;} .topMenuNew {width:100%}</style>
			<div class="topHeaderLogo"><?=SetLogo($P_DETAILS[HideTopMenu]);?></div>
			<div class="topHeaderTopMenu"><?SetTopMenuNew();?></div>
			<?
		}
		else 	{
			if ($inc_mobile_menu==0) {
				print '<div style="margin-top:'.$SITE[topmenumargin].'px;">';
				SetTopMenuNew();
			}
			if ($SITE[mobileEnabled]) print '<span class="mobileLogoMasterHeader"></span>';
			if ($inc_mobile_menu==0) print '</div>';
		}
		print '</div>';
		
		$MASTER_HEADER_CONTENT_BOTTOMMENU=GetPageTitle($cat_parentID,"master_header_text_bottommenu");
		if ($MASTER_HEADER_CONTENT_BOTTOMMENU[Content]=="") $MASTER_HEADER_CONTENT_BOTTOMMENU=CheckMasterHeaderContent($urlKey,"master_header_text_bottommenu");
		if ($MASTER_HEADER_CONTENT_BOTTOMMENU[Content]=="") $MASTER_HEADER_CONTENT_BOTTOMMENU=GetPageTitle(1,"master_header_text_bottommenu");
		?>
		 <div style="clear: both"></div>
		<div class="mainContentText masterHeader_inner_bottom_menu" id="master_header_content_bottommenu"><?=$MASTER_HEADER_CONTENT_BOTTOMMENU[Content];?></div>
		<?
		
	}
	if (isset($_SESSION['LOGGED_ADMIN'])) {
	      ?>
	      <style type="text/css">.masterHeaderContentBut{position: absolute;margin:10px 10px;cursor: pointer;left:0px;bottom:0px;}#pDropDownMenu_masterHeader{display: none;position: absolute;height: auto;}</style>
	      <div class="masterHeaderContentBut">
	      	<div id="newSaveIcon" onclick="jQuery('#pDropDownMenu_masterHeader').toggle()"><i class="fa fa-angle-down"></i> | <?=$ADMIN_TRANS['edit content'];?></div>
	      	<div id="pDropDownMenu_masterHeader" class="newSaveIcon popMenu">
				<div class="photoEditDropDown" onclick="EditMasterHeaderContent('top');" dir="<?=$SITE_LANG[direction];?>"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit content above menu'];?></div>
				<?
				if ($SITE[topmenubottom]>2) {?><div class="photoEditDropDown"  onclick="EditMasterHeaderContent('bottommenu');" class="newSaveIcon" dir="<?=$SITE_LANG[direction];?>"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit content under menu'];?></div><?}?>
	      	</div>
	 	 	</div>

	      <?
	 }
	?>
</div>

<div id="headerMaster_marginizer" style="clear:both"></div>
<script>
   function setMasterHeaderMargin() {
	   	var master_header_height=jQuery(".masterHeader_wrapper").height();
		jQuery("#headerMaster_marginizer").css('height',master_header_height+"px");
		jQuery(".site_overbg").css('top',master_header_height+"px");
   }
   jQuery(document).ready(function() {
		window.setTimeout("setMasterHeaderMargin()",400);
   });
</script>
<style type="text/css">
	.topHeader {min-height:1px;}
	.topHeaderSlogen {height:auto}
</style>