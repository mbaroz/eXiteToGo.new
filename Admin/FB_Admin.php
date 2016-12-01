<?
$is_fb_page=0;
$is_fb_product=0;
$fb_object_id=$CHECK_CATPAGE[parentID];
if ($CHECK_PAGE) {
	$is_fb_page=$fb_object_id=$CHECK_PAGE[parentID];
	if ($CHECK_PAGE[productUrlKey]) $is_fb_product=$is_fb_page=$fb_object_id=$CHECK_PAGE[galleryID];
}
?>
<script language="javascript">
var fb_is_page=<?=$is_fb_page;?>;
function Reload_after_fb() {
	document.location.reload();	
}
function ShowGWidgets(o) {
	var ofset=240;
	if (SiteDirection=="ltr") ofset=-240;
	SetPosition(o,'google_widgets',ofset);
	if ($('google_widgets').style.display=="none") $('google_widgets').show();
	else $('google_widgets').hide();
}
function ShowFBWidgets(o) {
	var ofset=240;
	if (SiteDirection=="ltr") ofset=-240;
	SetPosition(o,'fb_widgets',ofset);
	if ($('fb_widgets').style.display=="none") $('fb_widgets').show();
	else $('fb_widgets').hide();
}
function AddFBWidgetOld(type) {
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=changeFBWidget';
	var pars = 'update_catID=<?=$fb_object_id;?>&widgetType='+type+'&fb_is_page='+fb_is_page+'&is_fb_product=<?=$is_fb_product;?>';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout("Reload_after_fb()",800);
}
function AddGWidget(type) {
	var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=changeGWidget';
	var pars = 'update_catID=<?=$fb_object_id;?>&widgetType='+type+'&fb_is_page='+fb_is_page+'&is_fb_product=<?=$is_fb_product;?>';
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	window.setTimeout("Reload_after_fb()",800);
}
</script>
<style>
	#fb_widgets, #google_widgets {
		left:auto;margin:15px 10px;
	}
	#google_widgets {margin-<?=$SITE[align];?>:179px;}
</style>
<div class="clear" style="margin-top:5px;"></div>
<div style="margin-right:15px;z-index:195;" class="TemplateChooser" onclick="ShowFBWidgets(event)">&nbsp;<img src="<?=$SITE[url];?>/Admin/images/fb_icon.png" align="absmiddle"> <?=$ADMIN_TRANS['add facebook widgets'];?><img src="<?=$SITE[url];?>/Admin/images/dropdown.png" align="absmiddle"></div>
<ul id="fb_widgets" style="display:none;z-index:200;top:30px;text-align: left" class="TemplateDropDown">
<?
$commentsWidgetText="Comments Box";
$likeWidgetText="Like Box";
$commentOnClick=$likeOnClick="AddFBWidget";

if (!$SITE[fb_page_id]) {
	$likeWidgetText='Set FB <a href="'.$SITE[url].'/Admin/configAdmin.php">PAGE URL</a>';
	$likeOnClick="void";
}
?>

<li onclick="AddFBWidget(1)">Like Button</li>
<li onclick="AddFBWidget(6)">Like Button for this Page</li>
<li onclick="<?=$likeOnClick;?>(4)"><?=$likeWidgetText;?></li>
<li onclick="AddFBWidget(3)">Share Button</li>
<?
if (!$sideIncluded) {
	?>
	<li onclick="<?=$commentOnClick;?>(2)"><?=$commentsWidgetText;?></li>
	<?
}
?>
<li onclick="AddFBWidget(-1)">Remove Facebook</li>
</ul>
<!--Google WIDGET-->
<div style="margin-right:15px;z-index: 195;" class="TemplateChooser" onclick="ShowGWidgets(event)">&nbsp;<img src="<?=$SITE[url];?>/Admin/images/google_icon.png" align="absmiddle"> Add Google+ Button<img src="<?=$SITE[url];?>/Admin/images/dropdown.png" align="absmiddle"></div>
<ul id="google_widgets" style="display:none;z-index:200" class="TemplateDropDown">
	<li onclick="AddGWidget(1)">Google+ Button</li>
	<li onclick="AddGWidget(0)">Remove Google Button</li>
</ul>
<div class="clear" style="height:10px;clear:both"></div>