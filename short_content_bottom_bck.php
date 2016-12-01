<?
$ShortContentStyle=0;
$boxHeight=115;
$boxWidth=115;
$display_bgupload="none";
if (isset($_SESSION['LOGGED_ADMIN']) AND $MEMBER[UserType]==0) $display_bgupload="";
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
$axis="x,y";
$box_float="none";
$overflow="none";
$divider=2;
$minHeight="inherit";
$shortDivCSS="";
$is_rounded_checked=$is_default_options_checked=$is_titles_above_checked="";
$is_rounded=0;
// global $SITE_MEDIA;
$ADMIN_TRANS['crop tumbs images']="Crop Tumbs images";
if ($SITE_LANG[selected]=="he") $ADMIN_TRANS['crop tumbs images']="חתוך את התמונות הקטנות במקום להקטין אותן";
$CONTENT_OPTIONS=json_decode($P_DETAILS[Options]);
$P_DETAILS[ContentPhotoBGColor]=$CONTENT_OPTIONS->ContentPicBGColor;
$P_DETAILS[ContentTextBGColor]=$CONTENT_OPTIONS->ContentTextBGColor;
$P_DETAILS[ContentTextColor]=$CONTENT_OPTIONS->ContentTextColor;
$P_DETAILS[TitlesColor]=$CONTENT_OPTIONS->TitlesColor;
$P_DETAILS[NumBriefsShow]=$CONTENT_OPTIONS->NumBriefsShow;
$P_DETAILS[FullLineBriefWidth]=$CONTENT_OPTIONS->FullLineBriefWidth;
$P_DETAILS[ContentBorderColor]=$CONTENT_OPTIONS->ContentBorderColor;
$P_DETAILS[ContentMinHeight]=$CONTENT_OPTIONS->ContentMinHeight;
$P_DETAILS[isContentRoundCorners]=$CONTENT_OPTIONS->ContentRoundCorners;
$P_DETAILS[PhotosBorderColor]=$CONTENT_OPTIONS->PhotosBorderColor;
$P_DETAILS[isTitlesAbove]=$CONTENT_OPTIONS->isTitlesAbove;
$P_DETAILS[show_pinterest_button]=$CONTENT_OPTIONS->ShowPinterestButton;
if ($CONTENT_OPTIONS->images_crop_mode==1) $cropModeChecked="checked";
if ($P_DETAILS[isContentRoundCorners]==1 OR ($P_DETAILS[isContentRoundCorners]==0 AND $SITE[roundcorners]==1)) {
	$is_rounded_checked="checked";
	$is_rounded=1;
}
if ($P_DETAILS[isDefaultOptions]==1) $is_default_options_checked="checked";
if ($P_DETAILS[isTitlesAbove]==1) $is_titles_above_checked="checked";
if ($P_DETAILS[show_pinterest_button]==1) $showPinterestButton_check="checked";
$boxWidth=$SITE[galleryphotowidth];
$boxHeight=$SITE[galleryphotoheight];
$ContentMinHeight=5;
if ($P_DETAILS[ContentPhotoWidth]>0) $boxWidth=$P_DETAILS[ContentPhotoWidth];
if ($P_DETAILS[ContentPhotoHeight]>0) $boxHeight=$P_DETAILS[ContentPhotoHeight];
if ($P_DETAILS[ContentMarginW]==0) {
	$P_DETAILS[ContentMarginW]=6;
}
$tumbsWidth=$boxWidth;//for fields value
$tumbsHeight=$boxHeight;
if ($P_DETAILS[ContentMarginH]==0) $P_DETAILS[ContentMarginH]=10;
if($P_DETAILS[ContentBGColor]) $SITE[shortcontentbgcolor]=$P_DETAILS[ContentBGColor];
if ($P_DETAILS[ContentBorderColor] AND !$is_rounded) $border_css="border:1px solid #".$P_DETAILS[ContentBorderColor];
if ($P_DETAILS[ContentMinHeight]!="") $ContentMinHeight=$P_DETAILS[ContentMinHeight];



$topRoundedCornersColor=$bottomRoundedCornersColor=$SITE[shortcontentbgcolor];
if ($P_DETAILS[ContentPhotoBGColor]) $topRoundedCornersColor=$P_DETAILS[ContentPhotoBGColor];
if ($P_DETAILS[ContentTextBGColor]) $bottomRoundedCornersColor=$P_DETAILS[ContentTextBGColor];

$containerWidth=680;
if (intval($isLeftColumn)>0) $containerWidth=$containerWidth-$customLeftColWidth;
$num_short_content_in_line=$containerWidth/($boxWidth+$P_DETAILS[ContentMarginW]+6);
//print $boxWidth+$P_DETAILS[ContentMarginW];die();
$short_text_width=($containerWidth-$boxWidth-6);
if ($P_DETAILS[ContentBorderColor])  $short_text_width=$short_text_width-2;
if ($P_DETAILS[PageStyle]==1) {
	$containerWidth=930;
	if (intval($isLeftColumn)>0) $containerWidth=$containerWidth-$customLeftColWidth;
	$short_text_width=($containerWidth-$boxWidth-1);
	$num_short_content_in_line=$containerWidth/($boxWidth+$P_DETAILS[ContentMarginW]+6);
}

$orig_short_text_width=$short_text_width;
$num_short_content_in_line=intval($num_short_content_in_line);

$orgDivider=$divider;
$padding_left=1;

$all_container_width=$containerWidth+$P_DETAILS[ContentMarginW];
if ($P_DETAILS[PageStyle]==1) $all_container_width=$all_container_width+3;
?>
<style type="text/css">
.custom {
	width:<?=($boxWidth);?>px;
	height:<?=$boxHeight;?>px;
	
}
.custom img {
	max-width:<?=($boxWidth);?>px;
	max-height:<?=$boxHeight;?>px;
}
.customTitleStyle, .customTitleStyle a {
	<?if ($P_DETAILS[TitlesColor]) {
		?>
		color:#<?=$P_DETAILS[TitlesColor];?>;
	<?}?>
	
}
.customTitleStyle {
	padding-<?=$SITE[opalign];?>:3px;
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
	.photoWrapper {background-color:transparent}
	<?
}
else {
	?>
	.photoHolder {background-image:none;}
	<?
}
if ($P_DETAILS[ContentPhotoBGColor]) {
	?>
	.photoWrapper, .photoHolder {background-color:#<?=$P_DETAILS[ContentPhotoBGColor];?>;}
	.photoHolder {background-image:none;}
	<?
}
if ($P_DETAILS[PhotosBorderColor]) {
	?>
	.photoHolder {border:1px solid #<?=$P_DETAILS[PhotosBorderColor];?>;}
	<?
	if ($P_DETAILS[isContentRoundCorners]==1 AND !$P_DETAILS[PhotosBorderColor]) {
		?>
		.photoHolder {border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;-moz-border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;}
		<?
	}
	
}
if ($is_rounded) {
	?>
		.photoHolder {border-top-left-radius:6px; border-top-right-radius:  6px;}
		#boxes li.wide .photoHolder{border-top-<?=$SITE[opalign];?>-radius:0px; border-top-<?=$SITE[align];?>-radius:6px;border-bottom-<?=$SITE[opalign];?>-radius:0px;border-bottom-<?=$SITE[align];?>-radius:6px;}
		.short_content_text_class{border-bottom-left-radius:6px; border-bottom-right-radius:  6px;}
		#boxes li.wide .short_content_text_class{border-bottom-<?=$SITE[opalign];?>-radius:6px; border-top-<?=$SITE[opalign];?>-radius:  6px;border-top-<?=$SITE[align];?>-radius:  6px;}
		<?
}

if (ieversion()<=8 AND ieversion()>0) {
	?>
	.photoWrapper {display:inline;line-height:<?=$boxHeight;?>px;}
	.photoWrapper img {vertical-align:middle;}
	<?
}
?>
.full_rounded {border-radius: 6px;}
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
<?
if ($SITE[shortcontentbgcolor] OR $P_DETAILS[ContentPhotoBGColor] OR $P_DETAILS[ContentBorderColor] OR $P_DETAILS[ContentPicBG] OR $P_DETAILS[PhotosBorderColor]) {
	$boxWidth=$boxWidth+6;
	//$P_DETAILS[ContentMarginW]=($P_DETAILS[ContentMarginW]-1);
	if ($P_DETAILS[PhotosBorderColor]) $boxWidth=$boxWidth+2;
}
$boxesBGColor=$SITE[shortcontentbgcolor];
if ($is_rounded) $boxesBGColor="";

if ($P_DETAILS[show_pinterest_button]==1) {
?>
 <script type="text/javascript" async  data-pin-shape="round" data-pin-height="32" data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>
<?
}
?>
<style type="text/css">
#boxes  {
		font-family: <?=$SITE[cssfont];?>;
		list-style-type: none;
		margin-<?=$SITE[align];?>: 5px;
		margin-<?=$SITE[opalign];?>: 5px;
		padding-<?=$SITE[align];?>: 0px;
		width: <?=$all_container_width;?>px;
		margin-top:0px;
		margin-bottom:0px;
}
#boxes li {
		background-color:#<?=$boxesBGColor;?>;
		margin-top:0px;
		margin-bottom:<?=$P_DETAILS[ContentMarginH];?>px;
		margin-<?=$SITE[align];?>:0px;
		margin-<?=$SITE[opalign];?>:<?=($P_DETAILS[ContentMarginW]);?>px;
		padding-top:1px;padding-bottom:2px;
		padding-<?=$SITE[align];?>:1px;
		padding-<?=$SITE[opalign];?>:6px;
		float: <?=$SITE[align];?>;
		min-height:<?=$ContentMinHeight;?>px;
		width:<?=$boxWidth;?>px;
		<?=$border_css;?>;
	}

#boxes li .innerDiv {
	background-color:#<?=$boxesBGColor;?>;
	margin:0;
	min-height:<?=$ContentMinHeight;?>px;
}
#boxes li.li_spacer {
	background-color:transparent !important;
	width:100%;
	height:0px;
	min-height:1px;
	border:0;
	clear:both;
	padding:0;
	margin:0px;
}

#boxes li .mainContentText li {
	margin:0;
	padding:0px;
	border:0px;
	float:none;
	width:auto;
	min-height:0;
	background-color:transparent;
	
}
#boxes li.ui-widget.ui-corner-all {border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;border-top-right-radius: 0px;border-top-left-radius: 0px;}
#boxes li .mainContentText ul {list-style-type: disc}
#boxes li.ui-sortable-placeholder {background-color:transparent;border: 1px dotted silver;visibility: visible !important;min-height:50px;}
#boxes li.ui-sortable-placeholder.wide{width:<?=$short_text_width+$boxWidth-($P_DETAILS[ContentMarginW])+10;?>px;}
#lock_prop {cursor:pointer}
<?
if ($P_DETAILS[ContentPhotoBGColor] OR $P_DETAILS[ContentBorderColor]) {
	?>
	.photoWrapper, .photoHolder {background-color:#<?=$P_DETAILS[ContentPhotoBGColor];?>;}
	.photoHolder {background-image:none;}
	#boxes li {padding-top:0px;padding-bottom:0px;padding-<?=$SITE[align];?>:0px;}
	<?
}
if ($boxesBGColor) {
	?>
	#boxes li {padding-top:0px;padding-bottom:0px;padding-<?=$SITE[align];?>:0px;}
	<?
}
if  (!$P_DETAILS[ContentPhotoBGColor] AND !$P_DETAILS[ContentPicBG] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[ContentBorderColor] AND !$P_DETAILS[PhotosBorderColor] AND !$P_DETAILS[ContentTextBGColor]) {
	?>
	.photoHolder {padding-right:0px;padding-left:0px}
	<?
}
if ($is_rounded) {
	?>
	#boxes li.portlet.ui-widget {background-color: transparent !important}
	<?
}
$Proporsion=1;
if ($P_DETAILS[ContentPhotoHeight]>0 AND $P_DETAILS[ContentPhotoWidth]>0) $Proporsion=$P_DETAILS[ContentPhotoWidth]/$P_DETAILS[ContentPhotoHeight];

?>
</style>
<script>
	function showNULL(){}
</script>
<?
print $is_rounded;
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
		jQuery( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" );
		
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
		var alt_text_decoded=decodeURIComponent(alt_text);
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
	
	function delArticlePic(photo_id,isFullLine) {
		var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
		if (q) {
			deleted_photo_id=photo_id;
			var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delPhoto';
			var pars = 'photo_id='+photo_id;
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
			$("photo_img_holder_"+photo_id).hide();
			$('add_photo_label_'+photo_id).show();
			if (isFullLine) $('short_content_container_'+photo_id).style.width="<?=$short_text_width+$gallery_photo_w+$shortTextLeft;?>px";
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
			slideOutSettings("ContentOptions",1);
			//ShowLayer("ContentOptions",1,1,1);
			showuploader(allowed_photo_types,1,'photoBG_spanButtonPlaceHolder','photoBG_btnCancel','photoBG_fsUploadProgress',0);
				
		}
			else slideOutSettings("ContentOptions",0);
		
	}
	function SaveContentOptions() {
		var catID="<?=$CHECK_CATPAGE[parentID];?>";
		var pWidth=$('contentphotowidth').value;
		var pHeight=$('contentphotoheight').value;
		var marginW=$('contentmarginwidth').value;
		var marginH=$('contentmarginheight').value;
		var num_briefs_show=$('num_briefs_display').value;
		var content_bg_color=$('P_DETAILS[ContentBGColor]').value;
		var content_border_color=$('P_DETAILS[ContentBorderColor]').value;
		var photos_border_color=$('P_DETAILS[PhotosBorderColor]').value;
		var content_min_height=$('content_min_height').value;
		var content_photo_bg_color=$('P_DETAILS[ContentPhotoBGColor]').value;
		var content_text_bg_color=$('P_DETAILS[ContentTextBGColor]').value;
		var content_text_color=$('P_DETAILS[ContentTextColor]').value;
		var titles_color=$('P_DETAILS[TitlesColor]').value;
		var full_line_width=$('full_brief_width').value;
		var is_rounded=-1;
		var options_default=-1;
		var is_titles_above=0;
		var show_pinterest_button=0;
		var imagesCropMode=0;
		if (jQuery("input#crop_mode").is(":checked")) imagesCropMode=1;
		<?if ($display_bgupload=="") {
		?>swfu.startUpload();
		<? }	?>
		if ($('is_rounded_corners').checked) is_rounded=1;
		if ($('titles_above').checked) is_titles_above=1;
		if ($('is_default_options').checked) options_default=1;
		if ($('show_pinterest_button').checked) show_pinterest_button=1;
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars = 'action=saveContentOptions&catID='+catID+'&pWidth='+pWidth+'&pHeight='+pHeight+'&wMargin='+marginW+'&hMargin='+marginH+'&content_bg_color='+content_bg_color+'&borderColor='+content_border_color+'&content_min_height='+content_min_height+'&content_rounded_corners='+is_rounded+'&content_photo_bg_color='+content_photo_bg_color+'&content_text_bg_color='+content_text_bg_color+'&titles_color='+titles_color+'&content_text_color='+content_text_color+'&num_briefs_show='+num_briefs_show+'&full_line_width='+full_line_width+'&isDefaultOptions='+options_default+'&photos_border_color='+photos_border_color+'&is_titles_above='+is_titles_above+'&show_pinterest_button='+show_pinterest_button+'&images_crop_mode='+imagesCropMode;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
		if (display_bg_upload=="") window.setTimeout('check_if_gallery_pics_finished()',900);
		else window.setTimeout('ReloadPage()',900);
		
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
	var currentLock=1;
	
	var tumbsProportion=<?=$Proporsion;?>;
	function lockPropotionals() {
		if (currentLock==1) {
			document.getElementById("prop_lock_image").src="<?=$SITE[url];?>/Admin/images/unlock_prop_icon.png";
			currentLock=0;
		}
		else {
			document.getElementById("prop_lock_image").src="<?=$SITE[url];?>/Admin/images/lock_prop_icon.png";
			currentLock=1;
		}
	}
	function updateWidthHeight(wh) {
		var h=jQuery("#contentphotoheight").val();
		var w=jQuery("#contentphotowidth").val();
		if (currentLock==1) {
			if (wh=="width") jQuery("#contentphotoheight").val(Math.round(w/tumbsProportion));
			if (wh=="height") jQuery("#contentphotowidth").val(Math.round(h*tumbsProportion));
		}
	}
	function resetWidthHeight() {
		jQuery("#contentphotoheight").val(<?=$P_DETAILS[ContentPhotoHeight];?>);
		jQuery("#contentphotowidth").val(<?=$P_DETAILS[ContentPhotoWidth];?>);
	}
	function showphotoedittools(w) {
		jQuery("#"+w).toggle();
		
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
		<div id="newSaveIcon" class="add_button" onclick="AddNewContentType();"><img src="<?=$SITE[url];?>/Admin/images/add_icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['add brief'];?></div>
		<div id="newSaveIcon"  onclick="EditContentOptions(event);"><img src="<?=$SITE[url];?>/Admin/images/settings_icon.png" align="absmiddle" />&nbsp;<?=$ADMIN_TRANS['options'];?></div>
		&nbsp;&nbsp;<div id="newSaveIcon" style="display: <?=$showTopEditLabel;?>" onclick="EditTopBottomContent('topShortContent');"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit top content'];?></div>
		<div style="height:5px"></div>
		<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>', '<?=$SITE[url];?>/Admin/saveTitles.php?type=contentpics', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>',formClassName:'titleContent_top'});
		</script>
		<?
	}
	?>
	<div id="topShortContent" style="padding-<?=$SITE[align];?>:6px;margin-<?=$SITE[opalign];?>:7px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=$P_TITLE[Content];?></div>
	
	<?
	
	print '<ul id="boxes">';
	print '<li class="li_spacer" style="min-height:3px;"></li>';
	$num_inline=0;
	$briefs_limit=count($CONTENT[PageID]);
	if ($P_DETAILS[NumBriefsShow]>0 AND !isset($_SESSION['LOGGED_ADMIN'])) $briefs_limit=$P_DETAILS[NumBriefsShow];
	for ($a=0;$a<$briefs_limit;$a++) {
		//$photo_alt=htmlspecialchars($CONTENT[ContentPhotoAlt][$a],ENT_QUOTES);
		if ($CONTENT[ContentPhotoName][$a]=="" AND $CONTENT[PageTitle][$a]=="" AND $CONTENT[ShortContent][$a]=="" AND $CONTENT[PageContent][$a]=="") continue;
		$photo_alt=str_replace("'","&lsquo;",$CONTENT[ContentPhotoAlt][$a]);
		$photo_alt=str_replace('"',"&quot;",$photo_alt);
		$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
		$photo_alt=str_ireplace("’","&rsquo;",$photo_alt);
		$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
		$num_inline++;
		$p_url=$SITE[url]."/".$CONTENT[UrlKey][$a];
		$page_url=$CONTENT[PageUrl][$a];
		$target_location="_self";
		$rel_code="";
		if (!stripos(urldecode($page_url),"/")==0 AND $page_url!="") $target_location="_blank";
		//$prefix_url="";
		//if (stripos(urldecode($page_url),"/category")===0) $prefix_url="/".$SITE_LANG[selected];
		//if ($SITE_LANG[selected]!=$default_lang) $CONTENT[PageUrl][$a]=$prefix_url.$page_url;
		
		if ($CONTENT[IsTitleLink][$a]) $page_url=$p_url;
		$cFloating=$pFloating="none";
		$float_code="";
		$isfull=1;
		$short_text_padding=6;
		$short_content_padding=6;
		$class="portlet";
		$roundedCornersWidth=$boxWidth+6;
		$inner_div_rightPadding=0;
		$innerDivWidth=$boxWidth+6;
		$inner_min_height=$ContentMinHeight;
		$SwitchLineViewLabel=$ADMIN_TRANS['full horizental view'];
		$SwitchLineEditClass="fa-align-justify";
		$photoHolderExtraCSS="";
		$controls_margin=0;
		if ($is_rounded AND !$P_DETAILS[ContentPhotoBGColor] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[PhotosBorderColor] AND $P_DETAILS[ContentTextBGColor]) $roundedCornersWidth=$boxWidth;
		
		$short_content_extra_css="width:".$roundedCornersWidth."px;background-color:#".$P_DETAILS[ContentTextBGColor];
		if ($P_DETAILS[ContentTextBGColor] AND !$P_DETAILS[ContentPhotoBGColor] AND !$P_DETAILS[ContentPicBG] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[ContentBorderColor] AND !$P_DETAILS[PhotosBorderColor] AND !$is_rounded) $short_content_extra_css="width:".$boxWidth."px;margin-".$SITE[align].":6px;background-color:#".$P_DETAILS[ContentTextBGColor];
		if ($P_DETAILS[ContentPhotoBGColor] AND !$is_rounded) $short_content_extra_css.=";margin-top:5px;";
		if ($P_DETAILS[PhotosBorderColor]) $short_content_extra_css.=";width:".($boxWidth+6)."px;";
		if ($P_DETAILS[ContentMinHeight] AND $P_DETAILS[ContentTextBGColor]) $short_content_extra_css.=";min-height:".($inner_min_height-$boxHeight)."px;";
		if ($P_DETAILS[ContentPhotoBGColor] AND !$P_DETAILS[isTitlesAbove]) $topRoundedCornersColor=$P_DETAILS[ContentPhotoBGColor];
		if ($P_DETAILS[ContentTextBGColor]) $bottomRoundedCornersColor=$P_DETAILS[ContentTextBGColor];
		if ($is_rounded AND !$P_DETAILS[ContentPhotoBGColor] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[ContentPicBG] AND !$P_DETAILS[PhotosBorderColor] AND $P_DETAILS[ContentTextBGColor]) $photoHolderExtraCSS=";margin-".$SITE[align].":-6px"; //Added 2/9/2012
		if ($CONTENT[isFullWidth][$a]==1) {
			$pFloating=$cFloating=$SITE[align];
			$containerWidth=$short_text_width+$boxWidth-($P_DETAILS[ContentMarginW]/2)-8;
			$labelContainerWidth=$containerWidth;
			if ($P_DETAILS[FullLineBriefWidth]>0) $containerWidth=$P_DETAILS[FullLineBriefWidth];
			//$padding_right=6;
			if ($SITE[shortcontentbgcolor] OR $P_DETAILS[ContentBorderColor] OR $P_DETAILS[ContentPicBG] OR $P_DETAILS[ContentPhotoBGColor] OR $P_DETAILS[PhotosBorderColor]) $padding_right=6;
			if ($is_rounded) {
				$padding_right=0;
				$containerWidth=$containerWidth+8;
				$labelContainerWidth=$labelContainerWidth+8;
			}
			
			$extra_float_css="";
			if (!$is_rounded AND $P_DETAILS[ContentTextBGColor]) $extra_float_css.="background-color:#".$P_DETAILS[ContentTextBGColor].";";
			//if ($SITE[shortcontentbgcolor]) $containerWidth=$containerWidth-25;
			$float_code='style="width:'.$containerWidth.'px;margin-'.$SITE[align].':1px;padding-right:'.$padding_right.'px;min-height:5px;'.$extra_float_css.'"';
			if ($P_DETAILS[ContentPhotoBGColor] OR $P_DETAILS[ContentPicBG] OR $P_DETAILS[PhotosBorderColor]) $float_code='style="width:'.$containerWidth.'px;margin-'.$SITE[align].':0px;padding-right:0px;min-height:5px;padding-top:0px;padding-bottom:0px;'.$extra_float_css.'"';
			$inner_min_height=5;
			$inner_div_rightPadding=6;
			$innerDivWidth=$containerWidth-1;
			$isfull=0;
			$SwitchLineViewLabel=$ADMIN_TRANS['half horizental view'];
			$SwitchLineEditClass="fa-th-large";
			$short_text_padding=0;
			$num_inline=0;
			$class="portlet wide";
			$roundedCornersWidth=$containerWidth+5;
			$topRoundedCornersColor=$bottomRoundedCornersColor=$SITE[shortcontentbgcolor];
			$photoHolderExtraCSS="margin-".$SITE[opalign].":5px";
			if (!$P_DETAILS[PhotosBorderColor] AND !$P_DETAILS[ContentPicBG] AND !$P_DETAILS[ContentPhotoBGColor] AND !$P_DETAILS[ContentTextBGColor]) $photoHolderExtraCSS.=";padding-right:0px;padding-left:0px";
			$short_content_extra_css="background-color:#".$P_DETAILS[ContentTextBGColor];
			
		}
		if (!$is_rounded AND !$P_DETAILS[ContentTextBGColor] AND !$P_DETAILS[ContentBorderColor] AND !$SITE[shortcontentbgcolor]) $roundedCornersWidth=$roundedCornersWidth+15;
		$titleShow="";
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
		$m_height="";
		if (isset($_SESSION['LOGGED_ADMIN'])) $eventMouseOverPic="showphotoedittools";
			else $eventMouseOverPic="showNULL";
		?>
		<li id="short_cell-<?=$CONTENT[PageID][$a];?>" <?=$float_code;?> class="<?=$class;?>">
		
		<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {
				$enlarge_checked="";
				
				if ($CONTENT[ContentPhotoName][$a]=="") $controls_margin=25;
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
						
						<div class="photoEditDropDown" onclick="enlarge_line(<?=$CONTENT[PageID][$a]; ?>,<?=$isfull;?>)"><i class="fa <?=$SwitchLineEditClass;?>"></i> <?=$SwitchLineViewLabel;?> </div>
						<?if ($SITE[enableContentAttributes]==1) {
							?>
							<div class="photoEditDropDown" onclick="selectContentAttr(<?=$CONTENT[PageID][$a];?>);"><i class="fa fa-tags"></i> <?=$ADMIN_TRANS['assign tags'];?></div>
							<?}?>
					</div>
				</div>
				<?
		}
		
		if (!$P_DETAILS[ContentPhotoBGColor]) $topRoundedCornersColor=$SITE[shortcontentbgcolor];
		if ($is_rounded) {
			if ($P_DETAILS[isTitlesAbove]==1) $topRoundedCornersColor=$SITE[shortcontentbgcolor];
			// Check if the image is in the database.
			if ($CONTENT[ContentPhotoName][$a]=="") {
				if (!$CONTENT[isFullWidth][$a]==1) $topRoundedCornersColor=$SITE[shortcontentbgcolor];
				if (!$CONTENT[isFullWidth][$a]==1 AND $P_DETAILS[ContentTextBGColor])  $topRoundedCornersColor=$P_DETAILS[ContentTextBGColor];
			}
			
			//SetShortContentRoundedCorners(1,0,$topRoundedCornersColor,$roundedCornersWidth);
			?>
			<div <?=$inner_float_code;?> class="innerDiv" style="min-height:<?=$inner_min_height;?>px;width:<?=$innerDivWidth-6;?>px;padding-<?=$SITE[align];?>:<?=$inner_div_rightPadding;?>px;padding-<?=$SITE[opalign];?>:6px;padding-bottom:0px;">
			<?
		}
		
		$have_pic=0;
		$add_photo_show="";
		$text_class="";
		if ($CONTENT[ContentPhotoName][$a]=="") {
			if ($is_rounded) $text_class="full_rounded";
			$CONTENT[ContentPhotoName][$a]="content_nopic.png";
			//if (!$SITE[shortcontentbgcolor]) $short_content_padding=0;
			$short_text_width_complete=$short_text_width+$SITE[galleryphotowidth]+($shortTextLeft-6);
			if ($CONTENT[isFullWidth][$a]==1) $short_content_padding=0;
			$short_content_extra_css="width:".($roundedCornersWidth-12)."px;background-color:#".$P_DETAILS[ContentTextBGColor];
			if (!$CONTENT[isFullWidth][$a]==1) $short_content_extra_css="width:".($roundedCornersWidth)."px;background-color:#".$P_DETAILS[ContentTextBGColor];
			if ($CONTENT[isFullWidth][$a]==1 AND !$is_rounded) $short_content_extra_css.=";padding-".$SITE[align].":6px;width:".($roundedCornersWidth-5)."px";
			if ($CONTENT[isFullWidth][$a]==1 AND $is_rounded) $short_content_extra_css.=";padding-".$SITE[align].":5px;width:".($roundedCornersWidth-16)."px";
			if ($CONTENT[isFullWidth][$a]==1 AND ($P_DETAILS[ContentTextBGColor] OR $SITE[shortcontentbgcolor] OR $P_DETAILS[ContentBorderColor])) $short_content_extra_css.=";padding-top:6px;padding-bottom:6px;";
			if ($P_DETAILS[ContentMinHeight] AND !$CONTENT[isFullWidth][$a]==1 AND $P_DETAILS[ContentTextBGColor]) $short_content_extra_css.=";min-height:".($inner_min_height)."px;";
			
			if (!$P_DETAILS[ContentBorderColor] AND !$P_DETAILS[ContentPicBG] AND !$P_DETAILS[ContentPhotoBGColor] AND !$SITE[shortcontentbgcolor] AND !$P_DETAILS[ContentTextBGColor]) {
				$short_content_extra_css.=";padding-".$SITE[align].":0px;margin-".$SITE[align].":0px";
				if (!$CONTENT[isFullWidth][$a]==1) $short_content_extra_css.=";margin-".$SITE[align].":-5px";
			}
			
		}
		else {
			
			if ($CONTENT[isFullWidth][$a]==1 AND !$is_rounded) $short_content_extra_css.=";padding-".$SITE[align].":0px;width:".($roundedCornersWidth+1)."px"; //25/7/12
			
			$add_photo_show="none";
			$have_pic=1;
			//Added 6/12/12:
			if ($P_DETAILS[isTitlesAbove]==1 AND !$CONTENT[isFullWidth][$a]==1) {
				if (isset($_SESSION['LOGGED_ADMIN']) OR $titleShow=="")
					{
					?>
					<strong><div class="shortContentTitle customTitleStyle topShortContentTitle" id="titleContent_<?=$CONTENT[PageID][$a]; ?>"  style="display:<?=$titleShow;?>;padding-<?=$SITE[align];?>:<?=$short_content_padding;?>px;padding-top:3px;padding-bottom:5px;">
					<?
					if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
					?>
					<?=$CONTENT[PageTitle][$a];?></a></div></strong>
					<?
				}
			}
			?>
			<div class="photoHolder custom" id="photo_img_holder_<?=$CONTENT[PageID][$a];?>" style="float:<?=$pFloating;?>;<?=$photoHolderExtraCSS;?>">
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
			<img border="0" id="photo_img_<?=$CONTENT[PageID][$a];?>"  src="<?=SITE_MEDIA;?>/gallery/articles/<?=$CONTENT[ContentPhotoName][$a];?>" alt='<?=$photo_alt;?>' title='<?=$photo_alt;?>' /><?if (!$page_url=="" OR $CONTENT[EnableEnlarge][$a]==1) print '</a>';?>
			</div>
		
		</div>
		
		<?
		} 	//End Check if Photo NOT Exist so we put only text content
		
		if ($CONTENT[isFullWidth][$a]==0) $short_content_extra_css.=";padding-bottom:5px";
		//if ($CONTENT[isFullWidth][$a]==1 AND ) $short_content_extra_css.=";padding-bottom:5px";
		if ($CONTENT[isFullWidth][$a]==0) print '<div class="clear"></div>';
		//TO BE Added 4/9
		?>
		<div class="short_content_text_class <?=$text_class;?>" id="short_content_container_<?=$CONTENT[PageID][$a];?>" style="padding-<?=$SITE[align];?>:0px;margin-<?=$SITE[align];?>:0px;align:<?=$SITE[align];?>;padding-top:0px;<?=$short_content_extra_css;?>">
		<?
		
		if (!$P_DETAILS[isTitlesAbove] OR $CONTENT[isFullWidth][$a]==1 OR $have_pic==0) {
			if (isset($_SESSION['LOGGED_ADMIN']) OR $titleShow=="")
				{
				?>
				<strong><div class="shortContentTitle customTitleStyle" id="titleContent_<?=$CONTENT[PageID][$a]; ?>"  style="display:<?=$titleShow;?>;padding-<?=$SITE[align];?>:<?=$short_content_padding;?>px;padding-top:3px;">
				<?
				if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
				?>
				<?=$CONTENT[PageTitle][$a];?></a></div></strong>
				<?
				}
		}
			?>
		<div id="printArea"><div id="divContent_<?=$CONTENT[PageID][$a]; ?>" align="<?=$SITE[align];?>" class="mainContentText customContentStyle" style="margin-<?=$SITE[opalign];?>:6px;padding-<?=$SITE[align];?>:<?=$short_text_padding;?>px">
		<?
		if ($CONTENT[ShortContent][$a]=="") $CONTENT[ShortContent][$a]=$CONTENT[PageContent][$a];
		print str_ireplace("&lsquo;","'",$CONTENT[ShortContent][$a]);
		?></div></div>
		<div style="clear:both;"></div>
	<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
			<span style="display:none" id="p_url_<?=$CONTENT[PageID][$a];?>"><?=urldecode($CONTENT[PageUrl][$a]);?></span>
			<div class="cHolder" id="cHolder-item_<?=$CONTENT[PageID][$a];?>"></div>
			<?
	}
		if (!$is_rounded) print "</div>";
		print "<div class='clear'></div>";
		if ($is_rounded) {
			if (!$CONTENT[isFullWidth][$a]==1 AND $CONTENT[ShortContent][$a]=="" AND $CONTENT[PageTitle][$a]=="") $bottomRoundedCornersColor=$topRoundedCornersColor;
			print "</div></div>";
			//SetShortContentRoundedCorners(0,0,$bottomRoundedCornersColor,$roundedCornersWidth);
			
		}
		print "</li>";
		if ($num_inline==$num_short_content_in_line) {
			print '<li class="li_spacer"></li>'; //13/6/12
			$num_inline=0;
		}
	}
	print '<li class="li_spacer"></li>';
	print '</ul>';
?>
<div class="clear"></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	&nbsp;&nbsp;
	<div id="newSaveIcon" style="display: <?=$showBottomEditLabel;?>"  onclick="EditTopBottomContent('bottomShortContent');"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit bottom content'];?></div>
	<div style="height:5px"></div>
	<?
	}
?>
<div id="bottomShortContent" style="padding-<?=$SITE[align];?>:6px;margin-<?=$SITE[opalign];?>:7px;" align="<?=$SITE[align];?>" class="mainContentText"><?=$P_TITLE_BOTTOM[Content];?></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	include_once("Admin/colorpicker.php");
	$ADMIN_TRANS['edit']=$ADMIN_TRANS['edit_temp'];
	$ADMIN_TRANS['change order']=$ADMIN_TRANS['move_temp'];
	$ADMIN_TRANS['delete content']=$ADMIN_TRANS['del_temp'];
	?>
	<div style="width:550px;display:none;z-index:1100;position:fixed;top:150px;" id="PicUploader" class="CatEditor CenterBoxWrapper" align="center" dir="<?=$SITE[direction];?>">
	<div id="make_dragable" align="<?=$SITE[opalign];?>"><div class="icon_close" onclick="AddNewArticlePic(-1)">+</div>
		<div class="title"><strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong></div>
	</div>
		<div class="CenterBoxContent">
		<div style="float:<?=$SITE[align];?>;width:190px;" id="PhotoPreview"><strong><?=$ADMIN_TRANS['edit photo'];?></strong>
			<div id="photoPreviewDisplay"></div>
			<div style="margin-top:10px;"></div>
			<div id="newSaveIcon" style="display: <?=$showAdvancedEditButton;?>" class="advancedEditorButton"><i class="fa fa-magic"></i> <?=$ADMIN_TRANS['advanced photo editor'];?></div>
		</div>
		<form id="ArticlePicUpload" method="post" onsubmit="return false;">
		 <div><?=$ADMIN_TRANS['browse to upload photo'];?></div>
		 <span id="photo_spanButtonPlaceHolder" style="cursor:pointer"></span>
		<div class="fieldset flash" id="photo_fsUploadProgress">		
		</div>
		<div id="divStatus" dir="ltr"></div>
		
		<br />
		<div align="center" style="clear: both">
		<br />
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
		
	<div style="display: none;" id="ContentOptions" class="CatEditor settings_slider" align="<?=$SITE[align];?>" dir="<?=$SITE[direction];?>">
		<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="EditContentOptions(event)">+</div>
			<div class="title"><strong><?=$ADMIN_TRANS['options'];?></strong></div>
		</div>
		<div class="CenterBoxContent">
		<table border="0" cellspacing="2">
			<tr>
			<td><?=$ADMIN_TRANS['tumbnail size'];?></td>
			<td>
				(W)<input type="text" maxlength="3" value="<?=$tumbsWidth;?>" name="contentphotowidth" id="contentphotowidth" style="width:40px;direction:ltr" onkeyup="updateWidthHeight('width');"/>x<input type="text" maxlength="3" value="<?=$tumbsHeight;?>" name="contentphotoheight" id="contentphotoheight" style="width:40px;direction:ltr" onkeyup="updateWidthHeight('height');"/>(H)
				&nbsp; <span style="cursor:pointer" onclick="resetWidthHeight();" title="reset"><img src="<?=$SITE[url];?>/Admin/images/reset_prop_icon.png" border="0"></span>			
				<br>
				<span id="lock_prop" onclick="lockPropotionals()" style="margin-<?=$SITE[align];?>:48px"><img id="prop_lock_image" src="<?=$SITE[url];?>/Admin/images/lock_prop_icon.png" border="0"></span>
			</td>
			</tr>
			
			
			
			<tr>
			<td><?=$ADMIN_TRANS['min height/brief'];?></td>
			<td>
				<input type="text" maxlength="3" value="<?=$P_DETAILS[ContentMinHeight];?>" name="content_min_height" id="content_min_height" style="width:50px;direction:ltr"/><br><small>(<?=$ADMIN_TRANS['height in pixels'];?>)</small>
			</td>
			</tr>
			
			
			<tr>
			<td style="width:160px;"><?=$ADMIN_TRANS['number of briefs to show'];?>: </td><td><input class="StyleEditFrm" name="num_briefs_display" id="num_briefs_display" value="<?=$P_DETAILS[NumBriefsShow];?>" type="text" style="width:50px"></td>
			</tr>
			
			<tr>
			<td><?=$ADMIN_TRANS['show title above photos'];?>: </td><td><input type="checkbox" name="titles_above" id="titles_above" value=1 <?=$is_titles_above_checked;?> /> </td>
			</tr>
			<tr style="display:<?=$display_bgupload;?>">
				<td colspan="2"><?=$ADMIN_TRANS['gallery background image'];?>: 				
					<span id="photoBG_spanButtonPlaceHolder" name="photoBG_spanButtonPlaceHolder" style="cursor:pointer"></span>
					<input id="photoBG_btnCancel" type="button" value="Cancel All" onclick="swfu.cancelQueue();" disabled="disabled" />
					<?
					
					if ($P_DETAILS[ContentPicBG]) {
							?><span class="button" onclick="delContentPicBG()" style="color:red"><?=$ADMIN_TRANS['delete photo'];?></span><?
					}
					?>
					<div class="fieldset flash" id="photoBG_fsUploadProgress"></div>
					<div id="divStatus" dir="ltr"></div>
				</td>
			</tr>
			<tr>
				<td colspan="8"></td>
			</tr>
			
			<tr>
				<td colspan=2><br><a href="#" onclick="resetDefaultOptions()"><?=$ADMIN_TRANS['reset options from default template'];?></a></td>
			</tr>
		</table>
		<br>
		<div align="center"><div class="greenSave" id="newSaveIcon"  onclick="SaveContentOptions()"><img align="absmiddle" src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" /><?=$ADMIN_TRANS['save changes'];?></div></div>
	</div>
	</div>

	<?
}
?>