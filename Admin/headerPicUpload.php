<?
$GAL_OPTIONS=GetGalleryOptions($urlKey,4);
if ($GAL_OPTIONS[GalleryID]=="") $GAL_OPTIONS=GetGalleryOptions($urlKey,100);
$gal_ID=$GAL_OPTIONS[GalleryID];
$showExtraEffects="none";
if ($MEMBER[UserType]==0) $showExtraEffects="";
?>
<link href="<?=$SITE[url];?>/css/uploader/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.queue.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/fileprogress.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/handlers.js"></script>
<script language="javascript">
var uploadType;
var uploaded_filename;
var upload_global_type;
var urlKey="<?=$urlKey;?>";
var ofset=0;
var shownMainPicUploader=0;
var editPhotoGalID;
var lightRichTextDiv='<div id="richtextEditor"></div>';
var c_errors=0;
function UpdateUploadedFile(uploadedfile,original_name) {
		uploaded_filename=uploadedfile;
		if (upload_global_type=="sitepics") SaveUploadedSitePhoto(uploaded_filename);
		if (upload_global_type=="videogallery") PreUploadVideo(uploaded_filename);
		if (upload_global_type=="photogallery") SaveUploadedPhoto(uploaded_filename);
		if (upload_global_type=="articlepic") SaveUploadedArticlePhoto(uploaded_filename);
		if (upload_global_type=="gallerytumbsBG") SaveGalleryTumbsBG(uploaded_filename);
		if (upload_global_type=="contentPicBG") SaveContentTumbsBG(uploaded_filename);
		if (upload_global_type=="shop_product") ShopUploadedPic(uploaded_filename,original_name);
	}
function successUpload() {
	//if (uploadType!="delBGPic" || uploadType!="delTopMenuBGPic" || uploadType!="delGalBGPic") showUploadTools(0,0);
	$("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['photo uploaded successfully'];?></span>";
	
}
function showLSEffects(s) {
		if (s) {
			ShowLayer("eXite_OperationBox",1,0,0);
			jQuery("#eXite_OperationBox #OperationData").html('<div style="padding-top:50px;text-align:center"><img src="/Admin/images/ajax-loader.gif" align="absmiddle" /></div>');
			jQuery("#eXite_OperationBox #OperationData").load("<?=$SITE[url];?>/Admin/GetMainGalEffects.php?galID=<?=$gal_ID;?>");
		}
		else ShowLayer("eXite_OperationBox",0,0,0);
}
function deleteShadowBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delShadowPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}

function deleteContentBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delContentBgPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteSiteOverlayPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delSiteOverlayPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deletePageOverlayPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delPageOverlayPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deletePageHeaderBG() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deletePageHeaderBG";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteTopHeaderBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteTopHeaderBgPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteTopHeaderLogoBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteTopHeaderLogoBgPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteFavIcon() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delfavicon";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteTitlesIcon() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteTitlesIcon";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteLikeBoxBG() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="dellikeboxpic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteshopButtonImage() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delshopButtonImage";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteshopButtonOrderImage() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delshopButtonOrderImage";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteshopCartImage() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delshopCartImage";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteshopSingleItemImageBg() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delshopSingleItemImageBg";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteshopImage(type) {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="del"+type;
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteTopHeaderBgPicInside() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteTopHeaderBgPicInside";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteFooterBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteFooterBgPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteSiteBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delBGPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteTopMenuBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delTopMenuBGPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteSubMenuBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delSubMenuBGPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteSubSubMenuBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delSubSubMenuBGPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteSubMenuIcon() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delSubMenuIcon";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteGalleryBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="delGalBGPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteTopMenuItemBG() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteTopMenuItemBG";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteTopMenuSelectedItemBG() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteTopMenuSelectedItemBG";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteSideFormBgPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteSideFormBgPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteTopMenuSeperator() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteTopMenuSeperator";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteSubMenuSelectedBG() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteSubMenuSelectedBG";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteInnerPagesHeaderPic() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteInnerPagesHeaderPic";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function deleteUpNavigateIcon() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType="deleteUpNavigateIcon";
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function DelSitePhoto() {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		var uploadAction;
		var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
		if (uploadType=="pagepic") uploadAction="delSitePic";
		
		var v_txt=$('photo_text_pic').value;
		var galID="<?=$GAL[GID];?>";
		var pars = 'uploadtype='+uploadAction+'&urlkey='+urlKey;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',800);
	}
}
function DeleteBGPhoto(type) {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		uploadType=type;
		SaveUploadedSitePhoto(0,0);
		window.setTimeout('ReloadPage()',800);
	}
}
function showUploadTools(type,o) {
	upload_global_type="sitepics";
	var alt_text;
	var headerPic=0;
	var p_size="<?=$P_DETAILS[PhotoSize];?>";
	$('PhotoAltTextLabel').show();
	$('deleteSitePhotoButton').hide();
	$('SaveSitePicAltButton').hide();
	jQuery(".widthtip").hide();
	$('PhotoSizeLabel').hide();
	var alt_text_header_photo='<?=htmlspecialchars(html_entity_decode($P_DETAILS[PhotoAltText]),ENT_QUOTES);?>';
	switch (type) {
		case "logo":
			$('SaveSitePicAltButton').show();
			$('PhotoSizeLabel').hide();
			jQuery(".widthtip").hide();
			alt_text='<?=htmlspecialchars(html_entity_decode($SITE[logotext]),ENT_QUOTES);?>';
			ofset=0;
			if (document.getElementById("UploadToolsDiv").style.display=="none") jQuery("#additional_upload_tools").load("<?=$SITE[url];?>/Admin/GetStyleAdminAjax.php?type=logo");
		break;
		case "pagepic":
			$('deleteSitePhotoButton').hide();
			$('SaveSitePicAltButton').show();
			$('PhotoSizeLabel').show();
			jQuery(".widthtip").show();
			headerPic=1;
			alt_text=alt_text_header_photo;
			ofset=0;
			jQuery("#additional_upload_tools").load("<?=$SITE[url];?>/Admin/GetStyleAdminAjax.php?type=mainPic");

		break;
		case "topmenubgpic":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "submenubgpic":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "subsubmenubgpic":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "topmenuitembgpic":
			alt_text=alt_text_header_photo;
			ofset=150;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "topmenuseperatoricon":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "topmenuselecteditembgpic":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		
		case "submenuicon":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "gallerybgpic":
			alt_text=alt_text_header_photo;
			ofset=150;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "shadowpic":
			alt_text=alt_text_header_photo;
			ofset=150;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "topbglayer":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "headerlogobgpic":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "topbglayerpages":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "footerbglayer":
			alt_text=alt_text_header_photo;
			ofset=150;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "siteoverlaypic":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "pageoverlaypic":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "pageheaderbg":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "contentbgpic":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "favicon":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "titlesicon":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "innerpagesheaderpic":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "submenuselectedbgimage":
			alt_text=alt_text_header_photo;
			ofset=0;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "sideformbgpic":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "sitebgpic":
		$('PhotoAltTextLabel').hide();
		$('SaveSitePicAltButton').show();
		$('PhotoSizeLabel').hide();
		ofset=150;
		alt_text="";
		break;
		case "shopButtonImage":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "shopButtonOrderImage":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "shopCartImage":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "shopSingleItemImageBg":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "upnavigateicon":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "footermasterbgpic":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "headermasterbgpic":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "dropdownmenubgpic":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "searchbutton":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "searchfieldbg":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "slidoutcontenticon":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "mobilelogo":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "mobileheaderbgpic":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "mobilemainpichomepage":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "submenuselectedicon":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		case "ThisPageContentBGPic":
			alt_text=alt_text_header_photo;
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;
		default:
			alt_text="";
			ofset=100;
			$('PhotoAltTextLabel').hide();
			$('PhotoSizeLabel').hide();
			$('SaveSitePicAltButton').show();
		break;	
		
	}
	$('photo_text_pic').value=jQuery('<div/>').html(alt_text).text();
	$('photo_size').value=p_size;
	
	if (o) 
		if (!headerPic) SetPosition(o,'UploadToolsDiv',ofset);
	uploadType=type;
	if (document.getElementById("UploadToolsDiv").style.display=="none") {
		ShowLayer("UploadToolsDiv",1,0);
		showuploader(0,1,0,0,0,0);
			jQuery(function() {
			jQuery("#UploadToolsDiv").draggable({
			handle:'#make_dragable',
			cursor:'move'
				});
			});
	}
	else {jQuery("#additional_upload_tools").html(' ');ShowLayer("UploadToolsDiv",0,0);jQuery("form#HeaderPicUpload").show();}
}
function SaveUploadedSitePhoto(photo_name) {
	c_errors=0;
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var v_txt=jQuery('#photo_text_pic').val();
	var pic_size=jQuery('#photo_size').val();
	var galID="<?=$GAL[GID];?>";
	var pars = 'photo_name='+photo_name+'&photo_text='+v_txt+'&uploadtype='+uploadType+'&urlkey='+urlKey+'&photo_size='+pic_size+'&photo_id='+editPhotoGalID;
	
	jQuery("#notificationMessages_eXite").load(url,{
		'photo_name':photo_name,
		'photo_text':v_txt,
		'uploadtype':uploadType,
		'urlkey':urlKey,
		'photo_size':pic_size,
		'photo_id':editPhotoGalID
	});
	//var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout('check_if_style_pics_finished()',500);
	
}

function SaveAltPhotoText() {
	
	swfu.startUpload();
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var v_txt=$('photo_text_pic').value;
	var pic_size=$('photo_size').value;
	var pars = 'photo_text='+v_txt+'&uploadtype=savePhotoAlt&urlkey='+urlKey+'&alttype='+uploadType+'&photo_size='+pic_size;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout('check_if_main_gal_pics_finished()',500);
	
}
function GetMainPicGalleryPics() {
	url="<?=$SITE[url];?>/Admin/GetMainPicGallery.php";
	remotePars="urlKey="+urlKey;
	window.setTimeout("GetRemoteHTML('PhotosContainer');",20);
	window.setTimeout('enableSorting()',470);
	jQuery(function() {
		jQuery("#UploadMainPicGalleryDiv").draggable({
		handle:'#make_dragable'
		});
		
	});
}
function saveMainGalOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
		var pars = 'galleryID=<?=$GalID;?>'+'&'+newPosition+'&uploadtype=saveLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
}
function showMainPicGalleryUploadTools(type,o) {
	if (o) SetPosition(o,'UploadMainPicGalleryDiv',ofset);
	upload_global_type="sitepics";
	uploadType=type;
	if (document.getElementById("UploadMainPicGalleryDiv").style.display=="none") {
		//window.setTimeout('GetMainPicGalleryPics();',200);
		if (shownMainPicUploader==0) showuploader(0,50,'spanButtonPlaceHolder_mainpic',0,'fsUploadProgress_mainpic',0);
		shownMainPicUploader=1;
		Effect.ScrollTo("TopHead",{duration:0.1});
		window.setTimeout('ShowLayer("UploadMainPicGalleryDiv",1,0,1);',250);
		GetMainPicGalleryPics();
	}
	else ShowLayer("UploadMainPicGalleryDiv",0,0);
	
}
function EditGalPhotoDetails(photo_url,photo_title,photo_id,extra_effects) {
	$('gal_photo_url').value=photo_url;
	$('gal_photo_text').value=photo_title;
	jQuery('#gal_photo_extra_effect').val(extra_effects);
	
	editPhotoGalID=photo_id;
	
	uploadType='updateMainGalPhoto';
	if (document.getElementById("GalPicUploader").style.display=="none") {
		ShowLayer("GalPicUploader",1,0,1);
		showuploader(0,1,'spanButtonPlaceHolder_updatemainpic',0,'fsUploadProgress_updatemainpic',0);
			jQuery(function() {
			jQuery("#GalPicUploader").draggable({
			handle:'#make_dragable'
			});
		
		});
	}
	else {
		ShowLayer("GalPicUploader",0,0,1);
		uploadType="mainpicgallery";
	}
}
function enableSorting() {
	jQuery(function() {
		jQuery("#boxesmainGal").sortable({
   		update: function(event, ui) {
   			saveMainGalOrder(jQuery("#boxesmainGal").sortable('serialize'));
   		}
   		
  		
   	});
		//jQuery("#boxes").disableSelection();
	});
}

function DelMainPicGalPhoto(photo_id) {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		var uploadAction;
		var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
		var v_txt=$('photo_text_pic').value;
		var galID="<?=$GAL[GID];?>";
		var pars = 'uploadtype=delMainPicGal&photo_id='+photo_id;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
		Effect.Fade('photoGal_cell-'+photo_id);
	}
}
function SaveMainPicGalUrl() {
	swfu.startUpload();
	var newGalPhotoText=document.getElementById("gal_photo_text").value;
	var newGalPhotoUrl=document.getElementById("gal_photo_url").value;
	var newGalPhotoExtraEffect=jQuery("#gal_photo_extra_effect option:selected").val();
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var pars = 'uploadtype=saveGalPhotoDetails&photo_id='+editPhotoGalID+'&newPhotoText='+newGalPhotoText+'&newPhotoUrl='+newGalPhotoUrl+'&newPhotoExtraEffect='+newGalPhotoExtraEffect;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout('check_if_main_gal_pics_finished()',500);

}
function SaveGalOptions() {
	var selected_GalEffect=$('gal_effect').options[$('gal_effect').selectedIndex].value;
	var selected_GalTheme=$('gal_theme').options[$('gal_theme').selectedIndex].value;
	var selected_GalEasing=$('gal_easing').options[$('gal_easing').selectedIndex].value;
	var selected_GalAutoPlay=1;
	if ($('gal_autoplay').checked==true) selected_GalAutoPlay=0;
	var slides_speed=$('slide_speed').value;
	var slides_delay=$('slide_delay').value;
	var gallery_height=$('gal_height').value;
	var gallery_num_slices=$('num_slices').value;
	var gal_id='<?=$gal_ID;?>'
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var pars = 'uploadtype=saveGalOptions&gal_effect='+selected_GalEffect+'&gal_theme='+selected_GalTheme+'&autoplay='+selected_GalAutoPlay+
	'&slides_speed='+slides_speed+'&gal_height='+gallery_height+'&galleryID='+gal_id+'&urlKey='+urlKey+'&slides_delay='+slides_delay+'&num_slices='+gallery_num_slices;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	pars = 'uploadtype=setGalleryAttributeProperty&galID='+gal_id+'&property_type=easingEffect&val='+selected_GalEasing;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	
	window.setTimeout('ReloadPage()',600);
}
function setEffectVisibleOptions(selected_effect) {
		if (selected_effect>23) jQuery("#easing_selection").show();
		else  jQuery("#easing_selection").hide();
		if (selected_effect>52) jQuery("#advanced_effects_show").show();
		else  jQuery("#advanced_effects_show").hide();
		
}
function SwitchToSingle() {
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var gal_id='<?=$gal_ID;?>';
	var pars = 'uploadtype=SwitchToSingle&galleryID='+gal_id;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout('ReloadPage()',600);
}

function setRichTextEditor() {
	var buttons_str;
	var richtextContentDiv=$('richtextContent').innerHTML;
	buttons_str='<input type="button" id="saveContentButton" class="greenSave" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="saveMainPicRichText();" style="color:green">';
	buttons_str+='&nbsp;&nbsp;<input type="button" id="saveContentButton" value="<?=$ADMIN_TRANS['cancel'];?>" onclick="cancelMainPicRichTextEdit();" style="color:gray">';
	
	var div=$('lightMainPicRichTextContainer');
	div.innerHTML=lightRichTextDiv+buttons_str+"&nbsp;";
	editor_ins=CKEDITOR.appendTo('richtextEditor', {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
		});
		editor_ins.setData(richtextContentDiv);
		//jQuery("#lightMainPicRichTextContainer").show();
		slideOutEditor("lightMainPicRichTextContainer",1);
			jQuery(function() {
				//jQuery("#lightMainPicRichTextContainer").draggable();
	});	
}
function editMainPicRichText(photoID) {
		editPhotoGalID=photoID;
	url="<?=$SITE[url];?>/Admin/GetMainPicRichText.php";
	remotePars="photoID="+photoID;
	GetRemoteHTML('richtextContent');
	window.setTimeout("setRichTextEditor()",500);

}
function saveMainPicRichText() {
		var cVal=editor_ins.getData();
		cVal=encodeURIComponent(cVal);
		var url = '<?=$SITE[url];?>/Admin/GetMainPicRichText.php';
		var pars = 'action=saveRichText&photoID='+editPhotoGalID+'&content='+cVal;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
		//ShowLayer("lightMainPicRichTextContainer",0,0,1);
		slideOutEditor("lightMainPicRichTextContainer",0);
}
function cancelMainPicRichTextEdit() {
		//ShowLayer("lightMainPicRichTextContainer",0,0,1);
		slideOutEditor("lightMainPicRichTextContainer",0);
		editor_ins.destroy();
}
function check_if_style_pics_finished() {
		
		my_stat = swfu.getStats();
		if(my_stat.in_progress == 1 || my_stat.files_queued > 0)
			setTimeout('check_if_style_pics_finished()',500);
		else{
			
				ShowLayer('UploadToolsDiv',0,0,1);
				window.setTimeout('ReloadPage()',500);
			
		}
}
function check_if_main_gal_pics_finished() {
		my_stat = swfu.getStats();
		if(my_stat.in_progress == 1 || my_stat.files_queued > 0)
			setTimeout('check_if_main_gal_pics_finished()',500);
		else{
			ShowLayer("GalPicUploader",0,0,1);
			GetMainPicGalleryPics();
		}
}
</script>
<?include_once("uploader/uploader_settings.php");?>
<?
$boxHeight=65;
$boxWidth=180;
$textAlign="center";
?>
<style type="text/css">
	#gallery {
	}
	
	


.gal_styling{direction:<?=$SITE_LANG[direction];?>;}
</style>
<div id="notificationMessages_eXite" style="display:none"></div>
<div dir="<?=$SITE_LANG[dir];?>" id="UploadToolsDiv" class="CenterBoxWrapper" style="min-width:500px;width:50%;display:none;z-index:1100;position:absolute;" align="<?=$SITE[align];?>">
	<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="showUploadTools(uploadType,this)">+</div>
		<div class="title"><strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong></div>
	</div>
	<div class="CenterBoxContent">
		<div id="additional_upload_tools"></div>
		<form id="HeaderPicUpload" method="post" onsubmit="return false;">
			<div style="margin-top:20px"></div>
		 <div><?=$ADMIN_TRANS['browse to upload photo'];?> <span class="widthtip" style="display:none"><?='('.($SITE_LANG[selected]=='he' ? 'רוחב תמונות אופטימלי' : 'Optimal photos width'). ':'.$SITE[mainpicwidth];?>px)</span></div>
		 <div style="clear:both;margin-top:30px"></div>
		 <span id="spanButtonPlaceHolder" style="cursor:pointer;margin-top:10px"></span>
		 <span id="PhotoAltTextLabel" style="float:<?=$SITE[opalign];?>;margin-top:-15px"><?=$ADMIN_TRANS['photo alt text'];?> (alt):<br />
			<input type="text" class="HETextbox" id="photo_text_pic" name="photo_text_pic" style="width:310px" />
		</span>
			
		 &nbsp; <!--<input id="upload_button_Head" type="button"  value="Start Upload" onclick="swfu.startUpload()" disabled />-->

		<div class="fieldset flash" id="fsUploadProgress">		
		</div>
		<div id="divStatus" dir="ltr"></div>
		  
		<br />
		<script language="javascript">
		var video_instance_id_1;
		var video_instance_id_2;
		</script>
		
		<br /><br />

		<span id="PhotoSizeLabel"><?=$ADMIN_TRANS['middle flash dimensions'];?> :<br />
		<input type="text" class="ENTextbox" id="photo_size" name="photo_size" style="width:135px" />(width X height - in pixels)
		</span>
		
		
		<div style="height:5px;"></div>
		
		<div id="SaveSitePicAltButton" onclick="SaveAltPhotoText();" class="newSaveIcon greenSave"><i class="fa fa-cloud-upload"></i> <?=$ADMIN_TRANS['upload and save'];?></div>
		<div id="newSaveIcon" class="cancel" onclick="showUploadTools(uploadType,this)"><?=$ADMIN_TRANS['cancel'];?></div>
		<input style="display:none" id="btnCancel" type="button" value="Cancel All" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 22px;" />
		<input id="deleteSitePhotoButton" style="color:RED" type="button" value="<?=$ADMIN_TRANS['delete photo'];?>" onclick="DelSitePhoto();" class="newSaveIcon cancel">
		<div style="height:5px;clear:both"></div>
		</form>
	</div>
</div>
<!--Gallery Photos Uploader-->
<div dir="<?=$SITE_LANG[dir];?>" id="UploadMainPicGalleryDiv" class="CenterBoxWrapper" style="display:none;z-index:1100;width:850px;min-height:400px" align="<?=$SITE[align];?>">
	
	<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="showMainPicGalleryUploadTools(uploadType,this)">+</div>
		<div class="title" align="center"><strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong></div>
	</div>
        <div class="CenterBoxContent">
		<div style="float:<?=$SITE[align];?>;width:450px;overflow-x:hidden;overflow-y:auto;margin-<?=$SITE[align];?>:5px">
				
				<form id="HeaderPicUpload" method="post" onsubmit="return false;">
				<strong><?=$ADMIN_TRANS['add photos'];?></strong> <?='('.($SITE_LANG[selected]=='he' ? 'רוחב תמונות אופטימלי' : 'Optimal photos width'). ':'.$SITE[mainpicwidth];?>px)<br><br>
				 <span id="spanButtonPlaceHolder_mainpic" style="cursor:pointer;"></span>
				 <div id="newSaveIcon" class="greenSave" onclick="swfu.startUpload()" style="margin-<?=$SITE[opalign];?>:50px"><i class="fa fa-cloud-upload"></i><?=$ADMIN_TRANS['upload and save'];?></div>
				
				<div class="fieldset flash" id="fsUploadProgress_mainpic">		
				</div>
				<div id="divStatus" dir="ltr"></div>
				</form>
		
			<br>
			<div style="padding:3px;max-height:400px;min-height:280px;overflow-y:auto;overflow-x:hidden" id="PhotosContainer">
			<div style="padding-top:40px" align="center">Loading . . .</div>
			</div>
		</div>
		<div style="float:<?=$SITE[opalign];?>;" class="gal_styling MainSliders">
			<strong><?=$ADMIN_TRANS['gallery options'];?></strong><br><br>
			<?=GetGalleryStyling($urlKey);?>
			</p>
		</div>
		<div class="clear"></div>
		<div id="newSaveIcon" class="greenSave" onclick="SaveGalOptions()"><?=$ADMIN_TRANS['save changes'];?></div>
		<div id="newSaveIcon" class="cancel" onclick="showMainPicGalleryUploadTools(uploadType,this);"><?=$ADMIN_TRANS['cancel'];?></div>
		<div style="clear:both"></div>
	</div>
</div>

<div dir="<?=$SITE_LANG[dir];?>" id="GalPicUploader" class="CenterBoxWrapper" style="width:450px;display:none;z-index:1100;">
	<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="EditGalPhotoDetails(uploadType,this)">+</div>
		<div class="title" align="center"><strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong></div>
	</div>
	<div class="CenterBoxContent">
		<form id="HeaderPicUpload" method="post" onsubmit="return false;">
		<strong><?=$ADMIN_TRANS['upload/edit photo'];?></strong> &nbsp;
		 <span id="spanButtonPlaceHolder_updatemainpic" style="cursor:pointer"></span>
		 &nbsp; <!--<input id="upload_button_Head_updatemainpic" type="button"  value="Start Upload" onclick="swfu.startUpload()" disabled />-->
		 <div class="fieldset flash" id="fsUploadProgress_updatemainpic"></div>
		<div id="divStatus" dir="ltr"></div>
		<div align="<?=$SITE[align];?>"><label><?=$ADMIN_TRANS['photo alt text'];?>:</label><br><textarea id="gal_photo_text" name="gal_photo_text" style="width:98%;font-family:arial" maxlength="50" /></textarea></div>
		<div align="<?=$SITE[align];?>"><?=$ADMIN_TRANS['external link'];?>:<br><textarea id="gal_photo_url" name="gal_photo_url" style="width:98%;font-family:arial" maxlength="500" /></textarea></div>
		<div align="<?=$SITE[align];?>" style="display:<?=$showExtraEffects;?>">Rich Text Effect:<br>
			<select id="gal_photo_extra_effect" name="gal_photo_extra_effect" style="width:98%;font-family:arial" />
			<option value="data-class:fromLeft">From Left</option>
			<option value="data-class:fromRight">From Right</option>
			<option value="data-class:fromTop">From Top</option>
			<option value="data-class:fromBottom">From Bottom</option>
			<option value="data-class:fadeIn">Fade In</option>
			<option value="data-class:">None</option>
			</select>
			
		</div>
		<br>
		<div align="<?=$SITE[align];?>" style="display:<?=$showExtraEffects;?>" id="ls_extra_effects">Advanced Animations:<br>
			<textarea name="LS_EXTRA_EFFECTS" style="width:98%;border:1px solid silver;padding:4px;font-family:arial;direction:ltr;text-align:left"></textarea>
		</div>
		
		
		</form>
		<br><div align="center">
		<div id="newSaveIcon" class="greenSave" onclick="SaveMainPicGalUrl()" style="margin-<?=$SITE[align];?>:47px"><i class="fa fa-cloud-upload"></i><?=$ADMIN_TRANS['upload and save'];?></div>
		
       </div>

</div>
</div>
<div dir="<?=$SITE_LANG[direction];?>" id="lightMainPicRichTextContainer" style="display:none;" class="editorWrapper"></div>

<script>
jQuery(document).ready(function() {
	jQuery("#ls_effect_chooser").click(function(){showLSEffects(1);});
});
</script>
<div id="richtextContent" style="display:none"></div>
<!-- END Gallery Photos Uploader-->