<?
$DDD=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
$productUrlKey=$CHECK_PAGE[productUrlKey];


//print $DDD[CatUrlKey];
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script type="text/javascript" src="<?=$SITE['cdn_url'];?>/ckeditor/ckeditor.js"></script>
	<script language="javascript">
	var editor_browsePath="<?=$SITE[url];?>/ckfinder";
	function ReloadPage() {
		document.location.reload();
	}
	function successEditDelay() {
		document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['changes saved'];?></span>";
	}
	function successEdit() {
		window.setTimeout('successEditDelay()',700);	
	}
	
	function successDel() {
		document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><font color=red><?=$ADMIN_TRANS['this content has been deleted'];?></font></span>";
	}
	function successDelPhoto() {
		Effect.Fade("photo_cell-"+deleted_photo_id);
		document.getElementById("LoadingDiv").innerHTML="<span class='successEdit' style='color:red'><?=$ADMIN_TRANS['photo deleted'];?></span>";
	
	} 
	function DelGallery(GalleryID) {
		var q=confirm ("<?=$ADMIN_TRANS['are you sure ?'];?>\n\r<?=$PAG[PageTitle];?>");
		if (q) {
			var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=delGal';
			var pars = 'gallery_id='+GalleryID;
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successDelPhoto, onFailure:failedEdit,onLoading:savingChanges});
			window.setTimeout("ReloadPage()",800);
		}
	}
	</script>
	<?
}
if (($mobileDetect->isMobile() OR $debug) AND ($SITE[mobileEnabled])) include_once("effect_gallery.mobile.php");
else include_once("effect_gallery.php");
?>