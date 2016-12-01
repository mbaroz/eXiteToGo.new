<?
reset($GAL);
$GAL=GetCatGallery($urlKey,1);
//videogallery.php : Ver:1.0 /  Last Update: 29/09/2009
//TODO: 
$galleryWidth=710;
$tumbsMargin=45;
$tumbsMarginHeight=35;
$defaultMarginHeight=10;
$display_fixgal="none";
$isGalFixedChecked="";
$containerPaddingRight=25;
if (isset($_SESSION['LOGGED_ADMIN']) AND $MEMBER[UserType]==0) $display_fixgal="";
if ($P_DETAILS[PageStyle]==1) {
	$galleryWidth=950;
	$tumbsMargin=50;
}
if (intval($isLeftColumn)>0) {
	$customLeftColSub=200;
	if ($customLeftColWidth) $customLeftColSub=$customLeftColWidth;
	$galleryWidth=$galleryWidth-$customLeftColSub;
	$galleryWidth=$rightColWidth-20;
}
if ($GAL[hmargin]) {
	$tumbsMarginHeight=$GAL[hmargin]; 
	$defaultMarginHeight=0;
}
if ($GAL[wmargin]) {
	$tumbsMargin=$GAL[wmargin];
	if ($tumbsMargin<-27) $tumbsMargin=-27;
}
$NumPerLine=4;
$boxHeight=$SITE[galleryphotoheight]+13;
$boxWidth=$SITE[galleryphotowidth]+11;
$textAlign="center";
$vertical=0;
$textLinesEdit=1;
$GalID=$GAL[GID];
$cursorStyle="pointer";
$uploaded_video_id="";
$video_gallery_dir=$SITE_LANG[dir].$video_gallery_dir;
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
session_unregister('uploaded_video_id');
session_unregister('lastuploadtype');
$GAL_OPTIONS[GalFixed]=GetGalleryAttribute('GalFixed',$GalID);
if ($GAL_OPTIONS[GalFixed]=="") $GAL_OPTIONS[GalFixed]=1;
if ($GAL_OPTIONS[GalFixed]==1) {
	$galleryWidth=$galleryWidth+$tumbsMargin-7; //Added 11/6/12
	$isGalFixedChecked="checked";
	$containerPaddingRight=7;
	if (!$GAL[wmargin]) $tumbsMargin=60;
}
if (!$SITE[gallerybgpic] AND $GAL_OPTIONS[GalFixed]==1) {
	$galleryWidth=$galleryWidth+20;
	$containerPaddingRight=$containerPaddingRight-7;
}
if (isset($_SESSION['LOGGED_ADMIN'])) {
	//$boxHeight=$boxHeight+40;
	$cursorStyle="move";
}
if ($vertical==1) {
	$boxWidth=$boxWidth*$NumPerLine;
	$textAlign="right";
	$textLinesEdit=4;
}
$video_button_css="position: absolute;";
if (ieversion()<8 AND ieversion()>0) $video_button_css="left:50%;position: relative;";
?>
<style type="text/css">
	#boxes  {
		font-family: Arial, sans-serif;
		list-style-type: none;
		margin: 0px;
		padding-<?=$SITE[align];?>: <?=$containerPaddingRight;?>px;
		padding-<?=$SITE[opalign];?>: 0px;
		width: <?=$galleryWidth;?>px;
		
	}
	#boxes li {
		float: <?=$SITE[align];?>;
		margin-top:5px;
		margin-bottom:<?=$defaultMarginHeight;?>px;
		margin-<?=$SITE[opalign];?>:<?=$tumbsMargin;?>px;
		margin-<?=$SITE[align];?>:0px;
		width: <?=$boxWidth+10;?>px;
		min-height: <?=$boxHeight+$tumbsMarginHeight;?>px;
		border: 0px solid silver;
		text-align: <?=$textAlign;?>;
	}

	.photoName {
		cursor: pointer;
		text-decoration:none;
		color:#<?=$SITE[contenttextcolor];?>;
		padding-top:4px;
		padding-<?=$SITE[align];?>:2px;
		text-align:<?=$SITE[align];?>;
		width:<?=$boxWidth-5;?>;
		font-weight:bold;
		height: 35px;
		overflow: hidden;
		font-size:<?=$SITE[contenttextsize];?>px;
	}
	
	
	.photoImageHolder {
		cursor: <?=$cursorStyle;?>;
	}
	.EditPhotoIcon {

	}
.CatEditor {
	color:black;
	}
.video_button {
	
	width:<?=$SITE[galleryphotowidth];?>px;
	height:<?=$SITE[galleryphotoheight];?>px;
	vertical-align:middle;
	display:table-cell;
	<?=$video_button_css;?>;
	
}
.video_button_img {
	background:transparent url('/images/play_video_bot-39-39.png') no-repeat;
	position:absolute;
	top:<?=($SITE[galleryphotoheight]/2)-19;?>px;
	left:<?=($SITE[galleryphotowidth]/2)-19;?>px;
	height:39px;
	width:39px;
	z-index:200;
	cursor:pointer;
}
.photoWrapper{
	
}

</style>
<link type="text/css" rel="stylesheet" href="<?=$SITE[url];?>/css/gallery.css">
<link type="text/css" rel="stylesheet" href="<?=$SITE[url];?>/css/ui.all.css">

<?
if (!isset($_SESSION['LOGGED_ADMIN'])) {

		?>
		
		<script type="text/javascript" language="javascript">
		
		</script>
		<?
		}

if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	 <script type="text/javascript">
	jQuery(function() {
		jQuery("#boxes").sortable({
   		update: function(event, ui) {
   			saveOrder(jQuery("#boxes").sortable('serialize'));
   		}
	});
		//jQuery("#boxes").disableSelection();
	});
 </script>
<link href="<?=$SITE[url];?>/css/uploader/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.queue.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/fileprogress.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/handlers.js"></script>
<script language="javascript">
var currentGALID="<?=$GalID;?>";
var editor_ins;
//var editor_browsePath="<?//=$SITE[base_dir];?>/ckfinder";
var gal_editor_width="99%";
var edit_video_id=0;
var uploaded_filename;
var buttonID= "photo_spanButtonPlaceHolder";
var cancelButtonID= "photo_btnCancel";
var progressTargetID="photo_fsUploadProgress";
var allowed_photo_types="*.jpg;*.gif;*.png";
var allowed_video_types="*.mpeg;*.flv;*.avi;*.swf;*.mp3;*.mp4;*.wmv;*.mov";
function PreUploadVideo(uploadedfile) {
		upload_global_type="videogallery";
		var up_type="video";
		uploaded_filename=uploadedfile;
		var filestr=new String(uploadedfile);
		var FILEEXT=filestr.split('.');
		fileext=FILEEXT[1].toLowerCase();
		if (fileext=="jpg" || fileext=="png" || fileext=="gif") up_type="photo";
		SaveUploadedVideo(uploaded_filename,up_type);
}
function AddNewVideo() {
	edit_video_id=0;
	$('video_label').show();
	var video_buttonID="video_spanButtonPlaceHolder";
	var video_progressTargetID="video_fsUploadProgress";
	if (document.getElementById("PicUploader").style.display=="none") {
		ShowLayer("PicUploader",1,1,1);
		showuploader(allowed_photo_types,1,buttonID,cancelButtonID,progressTargetID,0);
		showuploader(allowed_video_types,1,video_buttonID,cancelButtonID,video_progressTargetID,1);
	}
	else {
		ShowLayer("PicUploader",0,1,1);
		$('photo_but').innerHTML='<span id="'+buttonID+'"></span>';
		$('video_but').innerHTML='<span id="'+video_buttonID+'"></span>';
	}
	
}
function ismaxlength(obj){
	var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>mlength)
	obj.value=obj.value.substring(0,mlength);
}
function EditVideoDetails(video_url,video_title,video_id) {
	$('photo_url').value=video_url;
	$('photo_text').value=video_title;
	//$('video_label').hide();
	edit_video_id=video_id;
	var video_buttonID="video_spanButtonPlaceHolder";
	var video_progressTargetID="video_fsUploadProgress";
	if (document.getElementById('PicUploader').style.display=="none") {
		ShowLayer("PicUploader",1,1,1);
		showuploader(allowed_photo_types,1,buttonID,cancelButtonID,progressTargetID,0);
		showuploader(allowed_video_types,1,video_buttonID,cancelButtonID,video_progressTargetID,1);
		jQuery(function() {
		jQuery("#PicUploader").draggable();
		});
	}
	else {
		ShowLayer('PicUploader',0,1,1);
		$('photo_but').innerHTML='<span id="'+buttonID+'"></span>';
		$('video_but').innerHTML='<span id="'+video_buttonID+'"></span>';
	}
	
}
function SaveNewUrl() {
	var newVideoUrl=document.getElementById("photo_url").value;
	var newVideoText=document.getElementById("photo_text").value;
	var video_id=edit_video_id;
	var galID="<?=$GAL[GID];?>";
	var url = '<?=$SITE[url];?>/Admin/uploadVideo.php?action=rename_url';
	var pars = 'NewPicUrl='+newVideoUrl+'&video_id='+video_id+'&newVideoText='+newVideoText+'&galleryID='+galID;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	ShowLayer('PicUploader',0,1,1);
	window.setTimeout('ReloadPage()',100);
}
function DelVideo(video_id) {
	var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>");
	if (q) {
		deleted_photo_id=video_id;
		var url = '<?=$SITE[url];?>/Admin/uploadVideo.php?action=delVideo';
		var pars = 'video_id='+video_id;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
	}
}
function SaveUploadedVideo(video_name,upload_type) {
	var url = '<?=$SITE[url];?>/Admin/uploadVideo.php';
	var v_txt=$('photo_text').value;
	var v_url=$('photo_url').value;
	var galID="<?=$GAL[GID];?>";
	var pars = 'video_name='+video_name+'&upload_type='+upload_type+'&video_text='+v_txt+'&video_url='+v_url+'&galleryID='+galID+'&video_id='+edit_video_id;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
}
function saveOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/uploadVideo.php';
		var pars = 'galleryID=<?=$GalID;?>'+'&'+newPosition+'&action=saveLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
}
function StartUpload() {
	swfu.startUpload();
	if (swfu_2!=undefined) swfu_2.startUpload();
}


function EditGalleryContent(textDivID) {
	switch (textDivID) {
		case "galleryContent":
			$('saveGalButton').show();
			$('closeGalButton').show();
		break;
		case "galleryContentBottom":
			$('saveGalButton_bottom').show();
			$('closeGalButton_bottom').show();
		break;
	}
	var contentDIV = document.getElementById(textDivID);
	editor_ins=CKEDITOR.replace(contentDIV, {
			filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
			 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
			 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
			 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
			 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
			 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_galleries.js'
		});

}
function saveGalleryContent() {
	var cVal=editor_ins.getData('galleryContent');
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	editor_ins.destroy();
	$('saveGalButton').hide();
	$('closeGalButton').hide();
}
function saveGalleryContentBottom() {
	var cVal=editor_ins.getData("galleryContentBottom");
	cVal=encodeURIComponent(cVal);
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
	var pars = 'galID='+currentGALID+'&content='+cVal+'&action=saveGalleryContent&divplace=bottom';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
	editor_ins.destroy();
	$('saveGalButton_bottom').hide();
	$('closeGalButton_bottom').hide();
}
function EditVideoGalleryOptions(galID) {
	    if ($('VideoGalOptions').style.display=="none") ShowLayer('VideoGalOptions',1,1,0);
	    else ShowLayer('VideoGalOptions',0,1,0);
}
function setGalAttributeProperty(gID,v,p) {
	var url = '<?=$SITE[url];?>/Admin/uploadHeadPic.php';
	var pars = 'uploadtype=setGalleryAttributeProperty&galID='+gID+'&property_type='+p+'&val='+v;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
}
function SaveVideoGalOptions(gallery_id) {
	var galID=gallery_id;
	var hMargin=$('hmargin').value;	
	var wMargin=$('wmargin').value;
	var isGalFixed=0;
	if ($('gal_is_fixed').checked) isGalFixed=1;
	var url = '<?=$SITE[url];?>/Admin/uploadVideo.php';
	var pars = 'action=setGalleryOptions&galID='+galID+'&hmargin='+hMargin+'&wmargin='+wMargin;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
	setGalAttributeProperty(galID,isGalFixed,"GalFixed");
	window.setTimeout('ReloadPage()',600);
}

function cancel() {
	$('saveGalButton').hide();
	$('closeGalButton').hide();
	$('saveGalButton_bottom').hide();
	$('closeGalButton_bottom').hide();
	editor_ins.destroy();
}
</script>
	<?
include_once("Admin/uploader/uploader_settings.php");
if ($GAL[GalleryName]=="") $GAL[GalleryName]=$ADMIN_TRANS['untitled'];
}
$h_tag="h1";
if ($pageHasHOne) $h_tag="h2";
?>
	<div class="titleContent_top">
	<?if ($SITE[titlesicon]) {
			?><div class="titlesIcon"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
			<?
		}
		?>
		<<?=$h_tag;?> id="galleryTitle-<?=$GAL[GID];?>"><?=$GAL[GalleryName];?></<?=$h_tag;?>>
	</div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<br />&nbsp;
	<div id="newSaveIcon"  onclick="AddNewVideo();"><img align="absmiddle" src="<?=$SITE[url];?>/Admin/images/add_icon.png" border="0" /><?=$ADMIN_TRANS['add videos'];?></div>
	<div id="newSaveIcon"  onclick="EditGalleryContent('galleryContent');"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit']." ".$ADMIN_TRANS['content'];?></div>
	<div id="newSaveIcon"  onclick="DelGallery(<?=$GAL[GID];?>)">&nbsp;<img src="<?=$SITE[url];?>/Admin/images/delIcon.png" border="0" align="absmiddle"/>&nbsp;<?=$ADMIN_TRANS['delete gallery'];?></div>
	<div id="newSaveIcon"  onclick="EditVideoGalleryOptions(<?=$GAL[GID];?>)">&nbsp;<img src="<?=$SITE[url];?>/Admin/images/slides.png" border="0" align="absmiddle"/>&nbsp;<?=$ADMIN_TRANS['gallery options'];?></div>
	&nbsp;&nbsp;<span style="display:none" id="saveGalButton"><div style="display:" id="newSaveIcon" onclick="saveGalleryContent()"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save changes'];?></div></span>
	<span style="display:none" id="closeGalButton"><div style="display:" id="newSaveIcon" onclick="cancel()"><img src="<?=$SITE[url];?>/Admin/images/close_icon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['cancel'];?></div></span>
	<div style="height:5px"></div>
	<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('galleryTitle-<?=$GAL[GID];?>', '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=renameGallery', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'galleryTitle-<?=$GAL[GID];?>',formClassName:'titleContent_top'});
	</script>
	<?
}
?>
<div id="galleryContent" style="padding-<?=$SITE[align];?>:6px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=$GAL[GalleryText];?></div>

<ul id="boxes">
<?
for ($a=0;$a<count($GAL[VideoID]);$a++){
		//if (fmod($a,$NumPerLine)==0) print "<tr>";
		$GAL[VideoText][$a]=str_ireplace("\n"," ",$GAL[VideoText][$a]);
		$GAL[VideoText][$a]=str_ireplace("\r"," ",$GAL[VideoText][$a]);
		$videoWidth=720;$videoHeight=420;
		$VIDEX=explode(".",$GAL[VideoFileName][$a]);
		$videoExtension=$VIDEX[count($VIDEX)-1];
		if (strtolower($videoExtension)=="mp3") {
			$videoWidth=350;
			$videoHeight=70;
		}
		?>
		<li id="photo_cell-<?=$GAL[VideoID][$a];?>" class="ui-state-default">
		<div class="photoHolder">
		<?
		if ($CONVERT_EXIST==1) {
			$convert_status=1;
			if (is_file("/home/converter/out/".$GAL[VideoFileName][$a])) {
				copy("/home/converter/out/".$GAL[VideoFileName][$a],$video_gallery_dir."/".$GAL[VideoFileName][$a]);
				unlink("/home/converter/out/".$GAL[VideoFileName][$a]);
				$convert_status=1;
			}
		}
		if (!is_file($gallery_dir."/tumbs/".$GAL[FileName][$a])) $GAL[FileName][$a]="movies-icon.png";
		if (!is_file($video_gallery_dir."/".$GAL[VideoFileName][$a]) AND $GAL[VideoUrl][$a]=="" AND $convert_status==1) $GAL[FileName][$a]="movies-icon_convert.png";
		$video_url=$GAL[VideoUrl][$a]."?autoplay=1&rel=0";
		if ($GAL[VideoFileName][$a]) $video_url=$SITE[url]."/".$video_gallery_dir."/".$GAL[VideoFileName][$a];
		?>
		<div class="video_button">
		<div class="photoWrapper">
		
			
		
		<?
		if (!isset($_SESSION['LOGGED_ADMIN'])) {
			?>
			<a rel="shadowbox[Mixed];width=<?=$videoWidth;?>;height=<?=$videoHeight;?>;" href="<?=$video_url;?>">
			<?
		}
		?>
		<div class="video_button_img"></div>
		
		<img  src="<?=$SITE[url];?>/<?=$gallery_dir;?>/tumbs/<?=$GAL[FileName][$a];?>"  border="0" class="photoImageHolder" /></a>
		</div>
		</div>
		</div>
		<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {
			$edit_controlsSpace=$SITE[galleryphotowidth]+15;
			if ($tumbsMargin<40) $edit_controlsSpace=$SITE[galleryphotowidth];
			?>
			<div style="position:absolute;width:<?=$edit_controlsSpace;?>px;margin-top:-17px;margin-left:15px;" align="center">
			<span style="float:right" class="EditPhotoIcon">
			<img onclick="EditVideoDetails('<?=$GAL[VideoUrl][$a];?>','<?=htmlspecialchars($GAL[VideoText][$a]);?>',<?=$GAL[VideoID][$a];?>)"  src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" class="button" title="<?=$ADMIN_TRANS['edit photo'];?>">
			</span>
			<span style="float:left">
			<img onclick="DelVideo(<?=$GAL[VideoID][$a];?>)" src="<?=$SITE[url];?>/Admin/images/delIcon.png" border="0" align="absmiddle" class="button" title="<?=$ADMIN_TRANS['delete video'];?>">
			</span>
			</div>
		
			<?
		}
			?>
			<div class="photoName"><?=$GAL[VideoText][$a];?></div>
			
		</li>
		<?
	}
	?>
</ul>
<div style="clear:both"></div>
<!--Here comes Gallery Bottom Text-->

<?
$bottomTextMargin=5;
if ($tumbsMarginHeight<0) $bottomTextMargin=-($tumbsMarginHeight)+5;
?>
<div class="clear" style="margin-top:<?=$bottomTextMargin;?>px"></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<br />&nbsp;&nbsp;
	<div id="newSaveIcon"  onclick="EditGalleryContent('galleryContentBottom');"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit']." ".$ADMIN_TRANS['content'];?></div>
	&nbsp;&nbsp;<span style="display:none" id="saveGalButton_bottom"><div style="display:" id="newSaveIcon" onclick="saveGalleryContentBottom()"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save changes'];?></div></span>
	<span style="display:none" id="closeGalButton_bottom"><div style="display:" id="newSaveIcon" onclick="cancel()"><img src="<?=$SITE[url];?>/Admin/images/close_icon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['cancel'];?></div></span>
	<div style="height:5px"></div>
	
	<?
}
?>
<div id="galleryContentBottom" style="padding-<?=$SITE[align];?>:12px;" align="<?=$SITE[align];?>" class="mainContentText galleryText"><?=$GAL[GalleryBottomText];?></div>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
		<div style="width:450px;display:none;z-index:1100;padding:10px;position:fixed;top:150px;background-color:#E0ECFF;border:2px solid #C3D9FF" id="VideoGalOptions" class="CatEditor"  dir="<?=$SITE[direction];?>">
		<div align="<?=$SITE[opalign];?>"><img class="button" src="<?=$SITE[url];?>/images/close_icon.gif" border="0" onclick="EditVideoGalleryOptions(<?=$GAL[GID];?>)"> </div>
		<strong><?=$ADMIN_TRANS['gallery options'];?></strong>
		<p>
		
		<table border="0" cellspacing="2">
			<tr>
			<td><?=$ADMIN_TRANS['margin between photos'];?>(W)</td>
			<td><input type="text" maxlength="3" value="<?=$GAL[wmargin];?>" name="wmargin" id="wmargin" style="width:50px;direction:ltr"/></td>
			</tr>
			<tr>
			<td><?=$ADMIN_TRANS['margin between photos'];?>(H)</td>
			<td><input  type="text" maxlength="3" value="<?=$GAL[hmargin];?>" name="hmargin" id="hmargin" style="width:50px;direction:ltr" /></td>
			</tr>
			<tr style="display:<?=$display_fixgal;?>">
			<td colspan="3">
				<input type="checkbox" name="gal_is_fixed" id="gal_is_fixed" <?=$isGalFixedChecked;?>> Fix Gallery Container
			</td>
			</tr>
		</table>
		</p>
		<div align="center"><input type="button" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="SaveVideoGalOptions(<?=$GAL[GID];?>)" class="saveContentButton" /></div>
	</div>
	
	<div style="width:580px;display:none;z-index:1000;padding:15px;position:absolute;top:150px;left:240px;background-color:#E0ECFF;border:2px solid #C3D9FF" id="PicUploader" class="CatEditor" align="<?=$SITE[align];?>">
	<div align="<?=$SITE[opalign];?>"><img class="button" src="<?=$SITE[url];?>/images/close_icon.gif" border="0" onclick="AddNewVideo()"> </div>
	<h4 style="line-height:0.1"><?=$ADMIN_TRANS['add videos'];?></h4>
	<form id="VideoUploadFrm"  method="post" onsubmit="return false;">
	<label style="padding-top:5px" id="photo_label"><?=$ADMIN_TRANS['choose thumbnail photo'];?>:<span id="photo_but"><span id="photo_spanButtonPlaceHolder" style="cursor:pointer;"></span></span></label> 
	&nbsp;&nbsp;
	<label style="padding-top:5px" id="video_label"><?=$ADMIN_TRANS['choose video file'];?>: <span id="video_but"><span id="video_spanButtonPlaceHolder" style="cursor:pointer"></span></span></label>
	<span style="text-align:<?=$SITE[opalign];?>;margin-<?=$SITE[align];?>:30px"><input type="button" style="color:green" value="Start Upload" onclick="StartUpload()" /></span>
	<div class="fieldset flash" id="photo_fsUploadProgress" dir="ltr"></div>
	<div class="fieldset flash" id="video_fsUploadProgress" dir="ltr"></div>
	<div id="divStatus" dir="ltr"></div>
	<script language="javascript">
	upload_global_type="videogallery";
	</script>
       	<div align="<?=$SITE[align];?>"><label><?=$ADMIN_TRANS['photo alt text'];?>:</label><br><textarea id="photo_text" name="photo_text" class="photo_text" style="width:550px" maxlength="62" onkeyup="return ismaxlength(this)" /></textarea></div>
       	<div align="<?=$SITE[align];?>"><label><?=$ADMIN_TRANS['link to youtube'];?>:</label><br><input  style="direction:ltr;width:550px" type="text" id="photo_url" name="photo_url" />
       	<div style="color:silver">e.g : http://www.youtube.com/?v=3gsj5 or http://www.vimeo.com/23244</div>
       	</div>
     	<br />
	<div align="center">
	
	<input id="photo_btnCancel" type="button" value="Cancel All" onclick="swfu.cancelQueue();swfu_2.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 22px;" />
	<input type="button" value="Save & Finish" onclick="SaveNewUrl();" />
	</div>
	<input type="hidden" name="galleryID" value="<?=$GAL[GID];?>">
  	</form>
	<div id="uploading" dir="ltr" align="center"></div>
	</div>
	<?
}
?>