<?
$side_type=2;
$action_news="change_newscat";
if (isNewsPage($urlKey) OR  isNewsProductPage($CHECK_PAGE[galleryID])) $side_type=1;
if ($CHECK_PAGE[galleryID]) $action_news="change_newsgal";

?>
<div class="TemplateChooser SideCatChooser">
	<span id="sidetype_1" onclick="ToogleNewsCats(1)">&nbsp;<?=$ADMIN_TRANS['show news'];?>&nbsp;</span>
	&nbsp;<font style="color:silver">|</font>&nbsp;
	<span id="sidetype_2" onclick="ToogleNewsCats(2)">&nbsp;<?=$ADMIN_TRANS['show menu'];?>&nbsp;</span>
</div>


<script language="javascript">
$('sidetype_'+<?=$side_type;?>).className='newSaveIcon_selected';
function resetSideype() {
	for (a=1;a<3;a++) {
		$('sidetype_'+a).className='';
	}
}
function ToogleNewsCats(side_type) {
	resetSideype();
	$('sidetype_'+side_type).className='newSaveIcon_selected';
	var url = '<?=$SITE[url];?>/Admin/saveNews.php?action=<?=$action_news;?>';
	var pars = 'urlKey=<?=$urlKey;?>&set_type='+side_type+'&prodgalleryID=<?=$CHECK_PAGE[galleryID];?>';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout("ReloadPage()",800);
}
</script>