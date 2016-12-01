<?
$ShortContentStyle=0;
if ($CHECK_CATPAGE[CatType]==11) $ShortContentStyle=2;
$boxHeight=115;
$boxWidth=115;
$contentMarginH=20;
$display_bgupload="none";
$is_default_options_checked="";
if (isset($_SESSION['LOGGED_ADMIN']) AND $MEMBER[UserType]==0) $display_bgupload="";
$ADMIN_TRANS['crop tumbs images']="Crop Tumbs images";
if ($SITE_LANG[selected]=="he") $ADMIN_TRANS['crop tumbs images']="חתוך את התמונות הקטנות במקום להקטין אותן";
$customWidth=$SITE[galleryphotowidth];
$customHeight=$SITE[galleryphotoheight];
$CONTENT_OPTIONS=json_decode($P_DETAILS[Options]);
$P_DETAILS[ContentPhotoBGColor]=$CONTENT_OPTIONS->ContentPicBGColor;
$P_DETAILS[show_pinterest_button]=$CONTENT_OPTIONS->ShowPinterestButton;
if($P_DETAILS[ContentBGColor]) $SITE[shortcontentbgcolor]=$P_DETAILS[ContentBGColor];
if ($P_DETAILS[show_pinterest_button]==1) $showPinterestButton_check="checked";
if ($CONTENT_OPTIONS->images_crop_mode==1) $cropModeChecked="checked";
$P_DETAILS[ContentTextColor]=$CONTENT_OPTIONS->ContentTextColor;
$P_DETAILS[TitlesColor]=$CONTENT_OPTIONS->TitlesColor;
$P_DETAILS[FullLineBriefWidth]=$CONTENT_OPTIONS->FullLineBriefWidth;
if (!$P_DETAILS[FullLineBriefWidth]) {
	if ($isLeftColumn>0 AND $ShortContentStyle==2) {
		$left_ColSubStruct=210;
		if ($customLeftColWidth) $left_ColSubStruct=$customLeftColWidth+10;
		if ($P_DETAILS[PageStyle]==0) $P_DETAILS[FullLineBriefWidth]=$dynamicWidth-273-$left_ColSubStruct;
		else  $P_DETAILS[FullLineBriefWidth]=$dynamicWidthPadding-$left_ColSubStruct;
	}
}


if ($P_DETAILS[ContentPhotoWidth]>0) $customWidth=$P_DETAILS[ContentPhotoWidth];
if ($P_DETAILS[ContentPhotoHeight]>0) $customHeight=$P_DETAILS[ContentPhotoHeight];
if ($P_DETAILS[ContentMarginH]>0) $contentMarginH=$P_DETAILS[ContentMarginH];
if ($P_DETAILS[isDefaultOptions]==1) $is_default_options_checked="checked";
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
$short_text_width=($dynamicWidth-270-$customWidth-10);
if ($P_DETAILS[PageStyle]==1) $short_text_width=($dynamicWidthPadding-$customWidth-10);
$li_container_margin_left=8;
if ($ShortContentStyle!=2 AND $SITE[shortcontentbgcolor]) {
	$short_text_width=$short_text_width-5;
	$li_container_margin_left=13;
}

$shortTextLeft=15;
$axis="y";
$box_float="none";
$overflow="none";
$divider=2;
$minHeight="inherit";
$shortDivCSS="";
$orig_short_text_width=$short_text_width;
if ($ShortContentStyle==2) {
	$short_text_width=(314-$customWidth);
	if ($SITE[sitewidth]>950) $short_text_width=((($dynamicWidthPadding-282)/2)-$customWidth);
	if ($P_DETAILS[PageStyle]==1) {
		if ($SITE[sitewidth]>950) $short_text_width=($dynamicWidthPadding/3)-$customWidth-15;
			else $short_text_width=$short_text_width-22;

		$divider=3;
	}
	$shortTextLeft=10;
	$axis="x,y";
	$box_float=$SITE[align];
	//$overflow="hidden"; remarked on 08/02/2011
	$minHeight="10px";
	if (isset($_SESSION['LOGGED_ADMIN'])) $minHeight=($customHeight+35)."px";
}
if ($isLeftColumn>0 AND $ShortContentStyle!=2) {
	$left_ColSubStruct=210;
	if ($customLeftColWidth) $left_ColSubStruct=$customLeftColWidth+10;
	$short_text_width=$short_text_width-$left_ColSubStruct;
	
	if ($P_DETAILS[PageStyle]==1) $short_text_width=$short_text_width-60;
	if ($customLeftColWidth AND $P_DETAILS[PageStyle]==1) $short_text_width=$short_text_width+55;
}
if ($isLeftColumn>0 AND $ShortContentStyle==2 AND $P_DETAILS[PageStyle]==1) $short_text_width=$short_text_width+20;
$boxWidth=$short_text_width+$customWidth;
if ($ShortContentStyle==2 AND $b_ver==7) $shortDivCSS="width:".($boxWidth+15)."px";
$modified_short_text_width=$short_text_width;
$orgDivider=$divider;
$padding_left=1;
$top_text_padding=0;
if ($SITE[shortcontentbgcolor]) {
	$padding_left=1;
	$top_text_padding=3;
}
$place_photo_top=0;
?>
<style type="text/css">
.custom {
	width:<?=($customWidth);?>px;
	height:<?=$customHeight;?>px;
	<?
	if ($customWidth!=$SITE[galleryphotowidth] OR $customHeight!=$SITE[galleryphotoheight])
		{
			$place_photo_top=1;
			?>
			background-image:none;
			<?
		}
	?>
}
.custom img {
	max-width:<?=($customWidth);?>px;
	max-height:<?=$customHeight;?>px;
}
.customTitleStyle, .customTitleStyle a {
	<?if ($P_DETAILS[TitlesColor]) {
		?>
		color:#<?=$P_DETAILS[TitlesColor];?>;
	<?}?>
	
}
.customContentStyle {
	<?if ($P_DETAILS[ContentTextColor]) {
		?>
		color:#<?=$P_DETAILS[ContentTextColor];?>;
	<?}?>
}
<?
if ($P_DETAILS[ContentPicBG]) {
	?>
	.photoHolder {background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$P_DETAILS[ContentPicBG];?>');}
	<?
}
?>
#boxes  {
		font-family: <?=$SITE[cssfont];?>;
		list-style-type: none;
		margin-<?=$SITE[align];?>: 3px;
		padding-<?=$SITE[align];?>: 1px;
		width: 100%;
		margin-top:0px;
}
#boxes li {
		background-color:#<?=$SITE[shortcontentbgcolor];?>;
		margin-top:5px;
		margin-bottom:<?=$contentMarginH;?>px;
		margin-<?=$SITE[align];?>:1px;
		margin-<?=$SITE[opalign];?>:<?=$li_container_margin_left;?>px;
		padding-top:2px;
		padding-bottom:3px;
		padding-<?=$SITE[opalign];?>:<?=$padding_left+1;?>px;
		padding-<?=$SITE[align];?>:0px;
		float:<?=$box_float;?>;
		overflow-y:<?=$overflow;?>;
		<?=$shortDivCSS;?>
		box-sizing:border-box;
	}

#boxes li .mainContentText li {
	margin:0;
	padding:0px;
	float:none;
	min-height:0;
}
#boxes li .mainContentText ul {list-style-type: disc}
#boxes li .mainContentText ul {list-style-type: disc}
#boxes li.ui-sortable-placeholder {background-color:transparent;border: 1px dotted silver;visibility: visible !important;}
<?
if ($P_DETAILS[ContentPhotoBGColor]) {
	?>
	.photoWrapper, .photoHolder {background-color:#<?=$P_DETAILS[ContentPhotoBGColor];?>;}
	.photoHolder {background-image:none;}
	#boxes li {padding-top:0px;padding-bottom:0px;}
	<?
}
if ($P_DETAILS[ContentPicBG] OR $SITE[gallerybgpic]) {
	?>
	#boxes li {padding-top:0px;padding-bottom:0px;}
	<?
}
?>
.photoHolder {
	float:<?=$SITE[align];?>;
	margin-<?=$SITE[align];?>:0px;
}
#lock_prop {cursor:pointer}
<?
if ($SITE[shortcontentbgcolor]=="" AND $P_DETAILS[ContentPhotoBGColor]=="" AND $P_DETAILS[ContentBGColor]=="") {
	?>
	.photoWrapper {display:block}
	<?
}
?>
</style>
<!--[if IE 9]>
<style>
	<?
	if ($SITE[contenttextsize]!=13) {
	?>
	.customContentStyle {letter-spacing: -0.5px;}
	<?
	}
	?>
</style>
<![endif]-->
<script>
	function showNULL(s) {};
</script>
<?
if ($P_DETAILS[show_pinterest_button]==1) {
?>
 <script type="text/javascript" async  data-pin-shape="round" data-pin-height="32" data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>
<?
}
$Proporsion=1;
if ($P_DETAILS[ContentPhotoHeight]>0) $Proporsion=$P_DETAILS[ContentPhotoWidth]/$P_DETAILS[ContentPhotoHeight];
if (isset($_SESSION['LOGGED_ADMIN'])) {
	$showAdvancedEditButton="none";
	if (ieversion()<0 OR ieversion()>9 ) $showAdvancedEditButton="";
	?>
	<style>
	#photoPreviewDisplay {
		width:160px;
		height:150px;
		padding:2px;
		border:1px solid #cfcfcf;
		background-repeat:no-repeat;
		background-position:center;
		background-size: contain;
		background-color:#fff;
	}
	</style>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/uploader.js"></script>
	<?
	if ($showAdvancedEditButton=="") {
		?>
		<script type="text/javascript">
			var currentEditedPhotoID;
			var featherEditor = new Aviary.Feather({
		       apiKey: 'd378530d86bbf078',
		       apiVersion: 3,
		       theme: 'light', // Check out our new 'light' and 'dark' themes!
		       tools: 'all',
		       appendTo: '',
		       maxSize:1024,
		       onSave: function(imageID, newURL) {
			   var img = document.getElementById(imageID);
			   jQuery("#photoPreviewDisplay").css("background-image",'url('+newURL+')');
			   img.src = newURL;
			   jQuery.get("<?=$SITE[url];?>/Admin/saveAdvancedPhotoEdit.php",{url:newURL,photo_id:currentEditedPhotoID,type:'short_content',catID:<?=$CHECK_CATPAGE[parentID];?>});	   
			   featherEditor.close();
				},
				//postUrl: '<?=$SITE[url];?>/Admin/saveAdvancedPhotoEdit.php?type=short_content&catID=<?=$CHECK_CATPAGE[parentID];?>',
				onError: function(errorObj) {
				    alert(errorObj.message);
				}
		    });
		</script>
		<?
	}
	?>
	<script>
	function launchAdvancedPhotoEditor(id, src,photoID) {
	       featherEditor.launch({
		   image: id,
		   url: src
	       });
	       currentEditedPhotoID=photoID;
	      return false;
	}
	var gal_editor_width="99%";
	var OrigTopContent;
	var OrigBottomContent;
	var photo_alt_text;
	var display_bg_upload="<?=$display_bgupload;?>";
	 function saveOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars =newPosition+'&action=saveContentLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
		
	}
	// jQuery.noConflict(); 
		jQuery(function() {
		jQuery("#boxes").sortable({
   		update: function(event, ui) {
   			saveOrder(jQuery("#boxes").sortable('serialize'));
   		}
   		,handle: '.briefs_edit>#newSaveIcon,img',
			scroll:true,
			axis:'<?=$axis;?>',
			connectWith: ".portlet",
			opacity: 0.6,tolerance: 'pointer',dropOnEmpty: false
	});
	
	});

	cType=1;
	var uploaded_filename;
	var buttonID= "photo_spanButtonPlaceHolder";
	var cancelButtonID= "photo_btnCancel";
	var progressTargetID="photo_fsUploadProgress";
	var allowed_photo_types="*.jpg;*.gif;*.png";
	var currentPhotoID;
	function SavePhotoArticle() {
		swfu.startUpload();
		photo_alt_text=jQuery("#photo_alt_text").val();
		var photo_alt_text_encoded=encodeURIComponent(photo_alt_text);
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=updateBriefPhotoAlt';
		jQuery.ajax({data:'alt_text='+photo_alt_text_encoded+'&itemID='+currentPhotoID,url:url,success:successEdit});
		window.setTimeout('check_if_gallery_pics_finished()',500);
		
	}
	function check_if_gallery_pics_finished() {
		my_stat = swfu.getStats();
		if(my_stat.in_progress == 1)
			setTimeout('check_if_gallery_pics_finished()',500);
		else{
			if (NewPicAdding==1) {
				ShowLayer('PicUploader',0,0,0);
				jQuery("#lightEditorContainer").css("z-index","1100");
				jQuery(".editor_addPhoto").hide();
				NewPicAdding=0;
			}
			else  {
				ShowLayer('PicUploader',0,1,0);
				window.setTimeout('ReloadPage()',700);
			}
		}
	}
	function AddNewArticlePic(item_id,alt_text,edit_photo) {
		upload_global_type="articlepic";
		currentPhotoID=item_id;
		jQuery("#PhotoPreview").hide();
		if (edit_photo==1) {
			jQuery("#PhotoPreview").show();
			var photo_src_location=jQuery("#photo_img_"+item_id).attr("src");
			var big_photo_src_location=photo_src_location.replace("articles/","");
			jQuery("#photoPreviewDisplay").css("background-image",'url('+photo_src_location+')');
			jQuery(".advancedEditorButton").click(function() {
				return launchAdvancedPhotoEditor("photo_img_"+item_id, big_photo_src_location,currentPhotoID);
			});
		}
		var alt_text_decoded=decodeURIComponent(alt_text);
			jQuery("#photo_alt_text").val(alt_text_decoded);
		if (document.getElementById("PicUploader").style.display=="none") {
			ShowLayer("PicUploader",1,1,0);
			showuploader(allowed_photo_types,1,buttonID,cancelButtonID,progressTargetID,0);
			$('itemID').value=item_id;
			
			
		}
		else {
			if (NewPicAdding==1) {
				ShowLayer("PicUploader",0,1,0);
				jQuery("#lightEditorContainer").css("z-index","1100");
				if (itemID==-1) NewPicAdding=0;
			}
			else ShowLayer("PicUploader",0,1,0);
		}
		
	}
	function SaveUploadedArticlePhoto(photo_name) {
	
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=uploadPhoto';
		var pars = 'photo_name='+photo_name+'&itemID='+currentPhotoID+'&catID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	}
	
	function delArticlePic(photo_id) {
		var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
		if (q) {
			deleted_photo_id=photo_id;
			var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delPhoto';
			var pars = 'photo_id='+photo_id;
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
			$("photo_img_holder_"+photo_id).hide();
			$('add_photo_label_'+photo_id).show();
			$('short_content_container_'+photo_id).style.width="<?=$short_text_width+$gallery_photo_w+$shortTextLeft;?>px";
			//$('short_content_container').style.width=<?//=$short_text_width+$gallery_photo_w+30;?>;
			
		}
	}

	function EditTopBottomContent(textDivID) {
		var contentDIV = document.getElementById(textDivID);
		OrigTopContent=contentDIV.innerHTML;
		var top_bottom_content_text=contentDIV.innerHTML;
		var buttons_str;
		buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveTopContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		if (textDivID=="bottomShortContent") buttons_str='<br><div id="newSaveIcon" onclick="saveBottomContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		
		buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancel();"><?=$ADMIN_TRANS['cancel'];?></div>';
		var div=$('lightEditorContainer');
		div.innerHTML=editorContainerLignboxDiv+buttons_str+"&nbsp;";
		
		editor_ins=CKEDITOR.appendTo('lightContainerEditor', {
				filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
				 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
				 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
				 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
				 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
				 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
				 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
			});
		editor_ins.setData(top_bottom_content_text);
				//ShowLayer("lightEditorContainer",1,1,0);
				editor_ins.on("loaded",function() {
					slideOutEditor("lightEditorContainer",1);
				});
				
				jQuery(function() {
					jQuery("#lightEditorContainer").draggable();
		});
	}
	function saveTopContent() {
		var cVal=editor_ins.getData();
		cVal=encodeURIComponent(cVal);
		var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
		var cpicstype="contentpics_text";
		//if (textDivID=="bottomShortContent") cpicstype="contentpics_text_bottom";
		var pars = 'type='+cpicstype+'&content='+cVal+'&objectID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
		
		jQuery('#topShortContent').html(decodeURIComponent(cVal));
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
	}
	function saveBottomContent() {
		var cVal=editor_ins.getData();
		cVal=encodeURIComponent(cVal);
		var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
		var cpicstype="contentpics_text_bottom";
		var pars = 'type='+cpicstype+'&content='+cVal+'&objectID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
		jQuery('#bottomShortContent').html(decodeURIComponent(cVal));
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
	}
	function cancel() {
		//ShowLayer("lightEditorContainer",0,1,0);
		slideOutEditor("lightEditorContainer",0);
		editor_ins.destroy();
	}
	function setEnlargeCheck(cID) {
		var isCheked=$('enlarge_'+cID).checked;
		if (isCheked) $('enlarge_'+cID).checked=false;
		else $('enlarge_'+cID).checked=true;
		setEnlarge(cID)
	}
	function setEnlarge(cID) {
		var setENLARGE=0;
		if ($('enlarge_'+cID).checked) setENLARGE=1;
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=setContentPhotoEnlarge';
		var pars = 'pageID='+cID+'&enableEnlarge='+setENLARGE;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});

	}
	function enlarge_line(pID,full) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=enlargeFullLine';
		var pars = 'pageID='+pID+'&full='+full;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',400);
	}
	function EditContentOptions(o) {
		if ($('ContentOptions').style.display=="none") {
			upload_global_type="contentPicBG";
			//ShowLayer("ContentOptions",1,1,1);
			slideOutSettings("ContentOptions",1);
			showuploader(allowed_photo_types,1,'photoBG_spanButtonPlaceHolder','photoBG_btnCancel','photoBG_fsUploadProgress',0);
			jQuery("#ContentOptions").draggable({
				handle:'#make_dragable',
				cursor:'move'
			});
		}
		else slideOutSettings("ContentOptions",0);
		
	}

	function SaveContentTumbsBG(photo_name) {
		var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=uploadContentTumbsBG';
		var pars = 'photo_name='+photo_name+'&catID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit,onLoading:savingChanges});
	}
	function delContentPicBG() {
		var url = '<?=$SITE[url];?>/Admin/uploadPhoto.php?action=delContentTumbsBG';
		var pars = 'catID=<?=$CHECK_CATPAGE[parentID];?>';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function (transport) {successEdit();}, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',300);
	}
	function resetDefaultOptions() {
		var catID="<?=$CHECK_CATPAGE[parentID];?>";
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars = 'action=resetDefaultOptions&update_catID='+catID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',300);
	}

	function showphotoedittools(w) {
		jQuery("#"+w).toggle();
	}
	var embed_code_backup;
	function ShowEmbedCode() {
		jQuery("#embedGalleryCode").toggle();
		embed_code_backup=jQuery("#embedCode").val();
			var clip = null;
			ZeroClipboard.setMoviePath('/js/zeroclipboard/ZeroClipboard10.swf');	
			jQuery(function() {
				clip = new ZeroClipboard.Client();
				clip.setHandCursor( true );
				clip.addEventListener('mouseOver', function (client) {
					clip.setText(jQuery("#embedCode").val());
				});
				clip.addEventListener('complete', function (client, text) {
					jQuery('#bef_copy').hide();
					jQuery('#af_copy').show();
					setTimeout(function(){
						jQuery('#af_copy').hide();
						jQuery('#bef_copy').show();
					}, 3000);
				});
				clip.glue( 'd_clip_button', 'd_clip_container' );
		});
	}
	</script>
<?
}
	$P_TITLE=GetPageTitle($CHECK_CATPAGE[parentID],"contentpics");
	$P_TITLE_BOTTOM=GetPageTitle($CHECK_CATPAGE[parentID],"contentpics_bottom");
	
	if ($P_TITLE[Title]=="" AND isset($_SESSION['LOGGED_ADMIN'])) $P_TITLE[Title]="Enter Your title here";
	if (!isset($_SESSION['LOGGED_ADMIN']) AND $P_TITLE[Title]=="Enter Your title here") $P_TITLE[Title]="";
	?>
	<div class="titleContent_top">
	<?if ($SITE[titlesicon] AND !$P_TITLE[Title]=="") {
			?><div class="titlesIcon" style="margin-<?=$SITE[align];?>:10px;"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
			<?
			
		}
		if (!$P_TITLE[Title]=="") {
			$h_tag="h1";
			if ($pageHasHOne) $h_tag="h2";
			?>
			<<?=$h_tag;?> id="shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>"><?=$P_TITLE[Title];?></<?=$h_tag;?>>
			<?
		}
		?>

	</div>
	<?
	$CONTENT=GetMultiContent($urlKey);
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		$showTopEditLabel=$showBottomEditLabel="";
		if (count($CONTENT[PageID])<1 AND $P_TITLE[Content]=="") $showTopEditLabel="none";
		if (count($CONTENT[PageID])<1 AND $P_TITLE_BOTTOM[Content]=="") $showBottomEditLabel="none";
		?>
		<br />&nbsp;
		<div id="newSaveIcon" class="add_button" onclick="AddNewContentType();"><img src="<?=$SITE[url];?>/Admin/images/add_icon.png" border="0" align="absmiddle" />&nbsp;<?=$ADMIN_TRANS['add brief'];?></div>
		<div id="newSaveIcon"  onclick="EditContentOptions(event);"><img src="<?=$SITE[url];?>/Admin/images/settings_icon.png" align="absmiddle" />&nbsp;<?=$ADMIN_TRANS['options'];?></div>
		&nbsp;<div id="newSaveIcon" style="display: <?=$showTopEditLabel;?>" onclick="EditTopBottomContent('topShortContent');"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit top content'];?></div>
		<div style="height:5px"></div>
		<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>', '<?=$SITE[url];?>/Admin/saveTitles.php?type=contentpics', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>',formClassName:'titleContent_top'});
		</script>
		<?
	}
	?>
	<div id="topShortContent" style="padding-<?=$SITE[align];?>:6px;margin-<?=$SITE[opalign];?>:8px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=$P_TITLE[Content];?></div>
	
	<?
	
	if (isset($_SESSION['LOGGED_ADMIN']) AND $ShortContentStyle==2) {
		$ADMIN_TRANS['edit_temp']=$ADMIN_TRANS['edit'];
		$ADMIN_TRANS['move_temp']=$ADMIN_TRANS['change order'];
	}
	//if ($CONTENT[ShortContent][$a]=="") $CONTENT[ShortContent][$a]=$CONTENT[PageContent][$a];
	print '<ul id="boxes">';
//	print "<table width=100% border=0 cellspacing=3><tr>";
	for ($a=0;$a<count($CONTENT[PageID]);$a++) {
		//$photo_alt=htmlspecialchars($CONTENT[ContentPhotoAlt][$a],ENT_QUOTES);
		if ($CONTENT[ContentPhotoName][$a]=="" AND $CONTENT[PageTitle][$a]=="" AND $CONTENT[ShortContent][$a]=="" AND $CONTENT[PageContent][$a]=="") continue;
		$photo_alt=str_replace("'","&lsquo;",$CONTENT[ContentPhotoAlt][$a]);
		$photo_alt=str_replace('"',"&quot;",$photo_alt);
		$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
		$photo_alt=str_ireplace("’","&rsquo;",$photo_alt);
		$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
		$p_url=$SITE[url]."/".$CONTENT[UrlKey][$a];
		$rel_code="";
		$page_url=$CONTENT[PageUrl][$a];
		$target_location="_self";
		if (!stripos(urldecode($page_url),"/")==0 AND $page_url!="") $target_location="_blank";
		if ($CONTENT[IsTitleLink][$a]) $page_url=$p_url;
		$titleShow="";
		$short_text_width=$modified_short_text_width;
		if ($ShortContentStyle==2 AND isset($_SESSION['LOGGED_ADMIN'])) {
			$ADMIN_TRANS['edit']=$ADMIN_TRANS['edit_temp'];
			$ADMIN_TRANS['change order']=$ADMIN_TRANS['move_temp'];
		}
		if ($ShortContentStyle==2 AND $CONTENT[isFullWidth][$a]==1) $short_text_width=$orig_short_text_width;
		
		$short_text_width_complete=$short_text_width+$customWidth+$shortTextLeft;
		if ($short_text_width_complete>($dynamicWidth-273)) $short_text_width_complete=$dynamicWidth-273;
		if ($short_text_width_complete>($dynamicWidth-280) AND !$ShortContentStyle==2) $short_text_width_complete=$dynamicWidth-296;
		
		if ($CONTENT[PageTitle][$a]=="") $titleShow="none";
		if (!$CONTENT[PageUrl][$a]=="") {
			$page_url=urldecode($CONTENT[PageUrl][$a]);
			$cursor="pointer";
			if (stristr($page_url,"youtu.be/") OR stristr($page_url,"youtube.com")) {
				$page_url=str_ireplace("youtu.be/","youtube.com/embed/",$page_url);
				if (stristr($page_url,"youtube.com")) {
					$page_url=str_ireplace("watch?v=","embed/",$page_url);
					$page_url=str_ireplace("&feature=","?feature=",$page_url);
					
				}
				if (!stristr($page_url,"?rel=")) $page_url=$page_url."?rel=0";
				$rel_code='rel="shadowbox;width=720;height=450"';
			}
			if (stristr($page_url,"vimeo.com/")) {
				$page_url=str_ireplace("vimeo.com/","player.vimeo.com/video/",$page_url);
				$rel_code='rel="shadowbox;width=720;height=450"';
			}
			
			
		}
		$ItemID=$CONTENT[PageID][$a];
		$SwitchLineViewLabel=$ADMIN_TRANS['full horizental view'];
		$SwitchLineEditClass="fa-align-justify";
		$isfull=1;
		$float_code="";
		$m_height="";
		$classNameBlocks="portlet";
		$controls_margin=0;
		if ($CONTENT[isFullWidth][$a]==1) {
			$SwitchLineViewLabel=$ADMIN_TRANS['half horizental view'];
			$SwitchLineEditClass="fa-th-large";
			$isfull=0;
			if (!is_file($gallery_dir."/articles/".$CONTENT[ContentPhotoName][$a])) $m_height="min-height:10px;margin-bottom:5px";
			$float_code='style="float:none;clear:both;'.$m_height;
			if ($ShortContentStyle==2 AND $P_DETAILS[FullLineBriefWidth]>0) {
				$short_text_width_complete=$P_DETAILS[FullLineBriefWidth];
				$float_code.=';width:'.$short_text_width_complete.'px';
				
			}
			$float_code.='"';
			$labelContainerWidth=$short_text_width_complete;
			$classNameBlocks="portlet wide";
		}
		if (isset($_SESSION['LOGGED_ADMIN'])) $eventMouseOverPic="showphotoedittools";
		else $eventMouseOverPic="showNULL";
		?>
		<li id="short_cell-<?=$CONTENT[PageID][$a];?>" <?=$float_code;?> class="<?=$classNameBlocks;?>">
		<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {
				$enlarge_checked="";
				if ($CONTENT[ContentPhotoName][$a]=="") $controls_margin=20;
				if ($CONTENT[EnableEnlarge][$a]==1) $enlarge_checked="checked";
				?>
				<div class="briefs_edit" id="photo_edit_tools_<?=$a;?>" style="margin-top:<?=$controls_margin;?>px">
					<div id="newSaveIcon" onclick="jQuery('#pDropDownMenu_<?=$a;?>').toggle()"><i class="fa fa-angle-down"></i> | <?=$ADMIN_TRANS['edit brief/photo'];?></div>
					<div id="pDropDownMenu_<?=$a;?>" class="newSaveIcon popMenu" style="display:block;height: auto;display:none" onblur="jQuery(this).toggle();">
						
						<div class="photoEditDropDown" onclick="EditHere(<?=$CONTENT[PageID][$a];?>,'',1);"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit content'];?></div>

						<?
						if ($CONTENT[ContentPhotoName][$a]=="") {
							?>
							<div class="photoEditDropDown" onclick="AddNewArticlePic(<?=$ItemID;?>,'',0)"><i class="fa fa-picture-o"></i> <?=$ADMIN_TRANS['add photo'];?></div>
							<?
						}
						else {
							?>
							<div class="photoEditDropDown" onclick="AddNewArticlePic(<?=$ItemID;?>,'<?=$photo_alt;?>',1)"><i class="fa fa-picture-o"></i> <?=$ADMIN_TRANS['edit photo'];?></div>
							<div class="photoEditDropDown" onclick="setEnlarge(<?=$CONTENT[PageID][$a];?>);"><input style="width:12px;height:12px"  type="checkbox" id="enlarge_<?=$CONTENT[PageID][$a];?>" value="1" <?=$enlarge_checked;?>><span onclick="setEnlargeCheck(<?=$CONTENT[PageID][$a];?>);"><?=$ADMIN_TRANS['enlarge'];?></span></div>
							<div style="color:red" class="photoEditDropDown" onclick="delArticlePic(<?=$CONTENT[PageID][$a];?>,<?=$CONTENT[isFullWidth][$a];?>)"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete photo'];?></div>
						
							<?
						}
						?>
						<div style="color:red" class="photoEditDropDown" onclick="deleteContent(<?=$CONTENT[PageID][$a];?>)"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete this content'];?></div>
						<?if ($ShortContentStyle==2) {
							?>
							<div class="photoEditDropDown" onclick="enlarge_line(<?=$CONTENT[PageID][$a]; ?>,<?=$isfull;?>)"><i class="fa <?=$SwitchLineEditClass;?>"></i> <?=$SwitchLineViewLabel;?> </div>
							<?
						}
						?>
						<?if ($SITE[enableContentAttributes]==1) {
							?>
							<div class="photoEditDropDown" onclick="selectContentAttr(<?=$CONTENT[PageID][$a];?>);"><i class="fa fa-tags"></i> <?=$ADMIN_TRANS['assign tags'];?></div>
							<?}?>
					</div>
				</div>
				<?
		}
		$have_pic=0;
		$add_photo_show="";
		$short_content_padding=9;
		$short_content_padding_left=0;
		$button_control_w=155;
		if ($CONTENT[ContentPhotoName][$a]=="") {
			$CONTENT[ContentPhotoName][$a]="content_nopic.png";
			if ($ShortContentStyle==2 AND isset($_SESSION['LOGGED_ADMIN'])) {
				$ADMIN_TRANS['edit']=$ADMIN_TRANS['edit_temp'];
				$ADMIN_TRANS['change order']=$ADMIN_TRANS['move_temp'];
			}
			if ($ShortContentStyle==2 AND $SITE[shortcontentbgcolor]) $short_content_padding_left=7;
			if (!$SITE[shortcontentbgcolor]) $short_content_padding=0;
			$short_text_width_complete=$short_text_width+$customWidth+($shortTextLeft-9);
			if ($P_DETAILS[FullLineBriefWidth]>0 AND $ShortContentStyle==2 AND $CONTENT[isFullWidth][$a]==1) $short_text_width_complete=$P_DETAILS[FullLineBriefWidth];
		
		}
		else {
			if (!$CONTENT[isFullWidth][$a]==1) $button_control_w=100;
			$add_photo_show="none";
			$have_pic=1;
			$short_text_width_complete=$short_text_width-4; // we strech the text to fill the space+photo
			
			if ($P_DETAILS[FullLineBriefWidth]>0 AND $ShortContentStyle==2 AND $CONTENT[isFullWidth][$a]==1) $short_text_width_complete=$P_DETAILS[FullLineBriefWidth]-$customWidth-12;
			
		?>
			<div class="photoHolder custom" id="photo_img_holder_<?=$CONTENT[PageID][$a];?>">
			<div class="photoWrapper custom">
			<?
			$id_text="";
			if ($CONTENT[EnableEnlarge][$a]==1) {
				?>
				<a href="<?=SITE_MEDIA."/".$gallery_dir."/".$CONTENT[ContentPhotoName][$a];?>" class="photo_gallery"  title="<?=$CONTENT[PageTitle][$a];?>">
				<?
			}
			if (!$page_url=="" AND !$CONTENT[EnableEnlarge][$a]==1) {
				
				?>
				<a href="<?=$page_url;?>" target="<?=$target_location;?>" <?=$rel_code;?>>
				<?
			}
			?>
			<img border="0" id="photo_img_<?=$CONTENT[PageID][$a];?>"  src="<?=SITE_MEDIA;?>/gallery/articles/<?=$CONTENT[ContentPhotoName][$a];?>" alt='<?=$photo_alt;?>' title='<?=$photo_alt;?>' /><?if ($CONTENT[PageUrl][$a] OR $CONTENT[EnableEnlarge][$a]==1 OR $page_url) print '</a>';?>
			</div>
	
		</div>
		
		<?
		} 	//End Check if Photo NOT Exist so we put only text content
		
		?>
		<div id="short_content_container_<?=$CONTENT[PageID][$a];?>" style="padding-<?=$SITE[align];?>:0px;margin-<?=$SITE[align];?>:0px;width:<?=$short_text_width_complete;?>px;float:<?=$SITE[align];?>;align:<?=$SITE[align];?>;padding-top:<?=$top_text_padding;?>px;padding-bottom:<?=$top_text_padding;?>px;padding-<?=$SITE[opalign];?>:<?=$short_content_padding_left;?>px">
		<?
		
		if (isset($_SESSION['LOGGED_ADMIN']) OR $titleShow=="") 
			{
			?>
			<strong><div class="shortContentTitle customTitleStyle" id="titleContent_<?=$CONTENT[PageID][$a]; ?>"  style="display:<?=$titleShow;?>;padding-<?=$SITE[align];?>:<?=$short_content_padding;?>px;">
			<?
			if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
			?>
			<?=$CONTENT[PageTitle][$a];?></a></div></strong>
			<?
			}
			?>
		<div id="printArea"><div id="divContent_<?=$CONTENT[PageID][$a]; ?>" align="<?=$SITE[align];?>" class="mainContentText customContentStyle" style="padding-left:0px;padding-<?=$SITE[align];?>:<?=$short_content_padding;?>px">
		<?
		if ($CONTENT[ShortContent][$a]=="") $CONTENT[ShortContent][$a]=$CONTENT[PageContent][$a];
		print str_ireplace("&lsquo;","'",$CONTENT[ShortContent][$a]);
		?></div></div>
	<?
	
	print "</div>";
	print "<div class='clear'></div>";
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
			<span style="display:none" id="p_url_<?=$CONTENT[PageID][$a];?>"><?=urldecode($CONTENT[PageUrl][$a]);?></span>
			<div class="cHolder" id="cHolder-item_<?=$CONTENT[PageID][$a];?>"></div>
			
		<?
		
		
	}
	print "</li>";
	if (!$counter_new) $counter_new=1;
	if ($CONTENT[isFullWidth][$a]==1 AND $ShortContentStyle==2) {
		print "<li class='clear' style='float:none;min-height:2px;margin:0px;padding:0px;background-color:transparent'></li>";
		$counter_new=0;
		//$divider=$divider+1;
		//if ($orgDivider==3) $divider=$orgDivider+1;
		
	}
	if ($counter_new==$orgDivider AND $ShortContentStyle==2) {
		print "<li class='clear' style='float:none;min-height:0px;margin:0px;padding:0px;background-color:transparent'></li>";
		$counter_new=0;
	}
	$counter_new++;

	}
	print '</ul>';
?>
<div class="clear"></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	&nbsp;&nbsp;
	<div id="newSaveIcon" style="display: <?=$showBottomEditLabel;?>" onclick="EditTopBottomContent('bottomShortContent');"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit bottom content'];?></div>
	<div style="height:5px"></div>
		<?
	}
?>
<div id="bottomShortContent" style="padding-<?=$SITE[align];?>:6px;margin-<?=$SITE[opalign];?>:8px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=$P_TITLE_BOTTOM[Content];?></div>
<?
if (isset($_SESSION['LOGGED_ADMIN']))  {
	if ($ShortContentStyle==2) {
		$ADMIN_TRANS['edit']=$ADMIN_TRANS['edit_temp'];
		$ADMIN_TRANS['change order']=$ADMIN_TRANS['move_temp'];
	}
	include_once("Admin/colorpicker.php");
	?>
	<script type="text/javascript" src="/js/zeroclipboard/ZeroClipboard.js"></script>
	<div style="width:550px;display:none;z-index:1100;position:fixed;top:150px;" id="PicUploader" class="CatEditor CenterBoxWrapper" align="center" dir="<?=$SITE[direction];?>">
	<div id="make_dragable" align="<?=$SITE[opalign];?>"><div class="icon_close" onclick="AddNewArticlePic()">+</div>
		<div class="title"><strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong></div>
	</div>
		<div class="CenterBoxContent">
		<div style="float:<?=$SITE[align];?>;width:190px;" id="PhotoPreview"><strong><?=$ADMIN_TRANS['edit photo'];?></strong>
			<div id="photoPreviewDisplay"></div>
			<div style="margin-top:10px;"></div>
			<div id="newSaveIcon" class="advancedEditorButton" style="display: <?=$showAdvancedEditButton;?>"><i class="fa fa-magic"></i> <?=$ADMIN_TRANS['advanced photo editor'];?></div>
		</div>
		
		
		<form id="ArticlePicUpload" method="post" onsubmit="return false;">
		 <div><?=$ADMIN_TRANS['browse to upload photo'];?></div>
		 <span id="photo_spanButtonPlaceHolder" name="photo_spanButtonPlaceHolder" style="cursor:pointer"></span>
		<div class="fieldset flash" id="photo_fsUploadProgress">
		</div>
		<div id="divStatus" dir="ltr"></div>
		<br />
		<div align="center" style="clear: both">
		<?=$ADMIN_TRANS['photo alt text'];?>(ALT)
		<br>
		<textarea id="photo_alt_text" name="photo_alt_text" style="width:98%;font-family:arial" maxlength="150" /></textarea>
		<br />
		<input id="photo_btnCancel" type="button" value="Cancel All" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 22px;" />
		<div id="newSaveIcon" class="greenSave" onclick="SavePhotoArticle()"><i class="fa fa-cloud-upload"></i> <?=$ADMIN_TRANS['upload and save'];?></div>
	
		</div>
		<input type="hidden" name="itemID" id="itemID">
		</form>
		</div>
	</div>
	<div style="display:none" id="ContentOptions" class="CatEditor settings_slider" align="<?=$SITE[align];?>" dir="<?=$SITE[direction];?>">
		<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="EditContentOptions(event)">+</div>
			<div class="title"><strong><?=$ADMIN_TRANS['options'];?></strong></div>
		</div>
		<div class="CenterBoxContent">
		<table border="0" cellspacing="2">
			
			
		</table>
		<br>
		<div align="center"><div class="greenSave" id="newSaveIcon"  onclick="SaveContentOptions()"><img align="absmiddle" src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" /><?=$ADMIN_TRANS['save changes'];?></div></div>
		</div>
	</div>
	
	<?
}
?>