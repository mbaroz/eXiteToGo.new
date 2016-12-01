<?
$nScroll=$NEWS[ScrollType][0];
if ($nScroll==1) $scroll_state_img="scroll_on.png";
else $scroll_state_img="scroll_off.png";
$scrollTypeShow="inline";
if (count($NEWS[NewsID])<1) $scrollTypeShow="none";
$isProductGal=$NEWS[GalleryID][0];

?>
<style>
	.newsEmbedCode {
		display: none;
		position: absolute;
		margin-<?=$SITE[align];?>:-8px;
		background-color:#efefef;
		direction: ltr;
		width:300px;
		padding:3px;
		border-radius:3px;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;
		z-index:200;
		color:#333333;
		font-family:arial;
		margin-<?=$SITE[align];?>:5px;
	}
	.newsEmbedCode textarea {
		background-color: #ffffff;
		width:280px;
		height:55px;
		border:1px solid silver;
		padding:2px;
		margin: 3px;
		font-size:10px;
	}

</style>
<script language="javascript">
var lightNewsDiv='<div id="lightnewsEditor"></div>';
var currentNewsEditing=0;
var newsContent;
var scrollType="<?=$nScroll;?>";
jQuery(function() {
	jQuery("#NewsBoxContainer").sortable({
		update: function(event, ui) {
		MakeNewsDragable(jQuery("#NewsBoxContainer").sortable('serialize'));
			}
			,handle: 'span',
		   	scroll:false,
		   	axis:'y'
			});
		});
var news_embed_code_backup;
function ShowNewsEmbed() {
	
	jQuery(".newsEmbedCode").toggle();
	news_embed_code_backup=jQuery('#news_embed_code').val();
	jQuery('#news_embed_code').select();
	jQuery('#news_embed_code').click(function() {jQuery('#news_embed_code').select()});
	var clip = null;
	ZeroClipboard.setMoviePath('/js/zeroclipboard/ZeroClipboard10.swf');
		jQuery(function() {
			
			clip = new ZeroClipboard.Client();
			clip.setHandCursor( true );
			clip.addEventListener('mouseOver', function (client) {
				clip.setText(jQuery("#news_embed_code").val());
			});
			clip.addEventListener('complete', function (client, text) {
				jQuery('#bef_copy_news').hide();
				jQuery('#af_copy_news').show();
				setTimeout(function(){
					jQuery('#af_copy_news').hide();
					jQuery('#bef_copy_news').show();
				}, 3000);
			});
			clip.glue( 'd_clip_button_news', 'd_clip_container_news' );
		});
}
function update_news_embed_code(op) {
	var updated_code;
	updated_code=news_embed_code_backup.replace("scroll=up","scroll="+op);
	if (op=="up") updated_code=news_embed_code_backup.replace("scroll=down","scroll="+op);
	jQuery("#news_embed_code").val(updated_code);
}
function ToggleScrollType() {
	if (scrollType=="" || scrollType==0) {
		scrollType=1;
		$('scrollTypeImg').src="<?=$SITE[url];?>/Admin/images/scroll_on.png";
	}
	else {
		scrollType=0;
		$('scrollTypeImg').src="<?=$SITE[url];?>/Admin/images/scroll_off.png";
		
	}
	var url = '<?=$SITE[url];?>/Admin/saveNews.php?action=changeScroll&newsGalID=<?=$isProductGal;?>';
	var pars = 'urlKey=<?=$urlKey;?>&scroll_type='+scrollType;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successToggleScroll, onFailure:failedEdit,onLoading:savingChanges});

	
}
function SetNewsEditor() {
	currentNewsEditing=$('newsselector').options[$('newsselector').options.selectedIndex].value;
	$('nT').value=$('newsselector').options[$('newsselector').options.selectedIndex].text;
	url="<?=$SITE[url];?>/Admin/GetNewsData.php?newsID="+currentNewsEditing;
	DivMessage="";
	GetRemoteHTML('contentNewsDIV');
	newsDIV=document.getElementById('contentNewsDIV');
	window.setTimeout("editor_ins.setData(newsDIV.innerHTML);",300);
}
function cancelNewsEditing() {
	ShowLayer("lightNewsContainer",0,1,0);
}
function EditNews(newsID) {
	var buttons_str;
	var newsTitle_str;
	var newsTitle="";
	if (newsID==0) newsContent="";
	else newsContent=$('newsContent_'+newsID).innerHTML;
	currentNewsEditing=newsID;
	buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="SaveNews();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
	buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancelNewsEditing();"><?=$ADMIN_TRANS['cancel'];?></div>';

	var div=$('lightNewsContainer');
	div.innerHTML=lightNewsDiv+buttons_str+"&nbsp;";
	
	editor_ins=CKEDITOR.appendTo('lightnewsEditor', {
		filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
		 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
		 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
		 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
		 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
		 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
		 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_news.js'
	});
	editor_ins.setData(newsContent);
	//ShowLayer("lightNewsContainer",1,1,0);
	slideOutEditor("lightNewsContainer",1);
	jQuery(function() {
		jQuery("#lightNewsContainer").draggable();
	});
}
function successEditNews() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['changes saved'];?></span>";
	//ShowLayer("lightNewsContainer",0,1,0);
	slideOutEditor("lightNewsContainer",0);
	window.setTimeout('ReloadPage()',1000);
}
function successToggleScroll() {
	document.getElementById("LoadingDiv").innerHTML="<span class='successEdit'><?=$ADMIN_TRANS['changes saved'];?></span>";
}

function SaveNews() {
	var newsContent=editor_ins.getData();
	newsContent=encodeURIComponent(newsContent);
	var url = '<?=$SITE[url];?>/Admin/saveNews.php';
	var pars = 'newsID='+currentNewsEditing+'&urlKey=<?=$urlKey;?>&newsContent='+newsContent+'&newsGalID=<?=$isProductGal;?>&scroll_type='+scrollType;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEditNews, onFailure:failedEdit,onLoading:savingChanges});
}
function DelNews(newsID) {
		var q=confirm("<?=$ADMIN_TRANS['are you sure ?'];?>");
		if (q) {
			var url = '<?=$SITE[url];?>/Admin/saveNews.php?action=delNews';
			var pars = 'newsID='+newsID;
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEditNews, onFailure:failedEdit,onLoading:savingChanges});
	}
}
</script>
<script type="text/javascript" src="/js/zeroclipboard/ZeroClipboard.js"></script>
	<div style="padding-top:10px;margin-<?=$SITE[align];?>:10px;">
	<div id="newSaveIcon" class="add_button" onclick="EditNews(0)" style="font-size:12px;margin-bottom: 5px;"><img src="<?=$SITE[url];?>/Admin/images/add-news-bot.png" alt="<?=$ADMIN_TRANS['add news'];?>" border="0" align="absmiddle" /> <?=$ADMIN_TRANS['add news'];?></div>
	<div style="display:<?=$scrollTypeShow;?>;color:#<?=$SITE[contenttextcolor];?>"><?=$ADMIN_TRANS['scroll'];?><img id="scrollTypeImg" class="button" src="<?=$SITE[url];?>/Admin/images/<?=$scroll_state_img;?>" border="0" align="absmiddle" onclick="ToggleScrollType()" />
	<span onclick="ShowNewsEmbed()"><div id="newSaveIcon" style="font-size:10px;padding:1px 2px;float:<?=$SITE[opalign];?>;margin-top:3px;margin-<?=$SITE[opalign];?>:2px;" class="r"><img align="absmiddle" src="<?=$SITE[url];?>/Admin/images/embed_icon.png" border="0" style="width:10px;" /> <?=$ADMIN_TRANS['embed'];?></div></span>
	<div class="newsEmbedCode">
	<div style="float:<?=$SITE[opalign];?>" class="button" onclick="ShowNewsEmbed()";>x <?=$ADMIN_TRANS['close'];?></div>
	<div style="direction: <?=$SITE_LANG[direction];?>;font-family:arial;font-size:11px;"><input type="radio" checked="checked" name="news_embed_op" onclick="update_news_embed_code('up');" style="vertical-align:middle;"><?=$ADMIN_TRANS['scroll up'];?> &nbsp; <input name="news_embed_op" type="radio" onclick="update_news_embed_code('down');" style="vertical-align :middle;"><?=$ADMIN_TRANS['scroll down'];?></div>
	<div id="d_clip_container_news" style="position:relative;margin-top:5px">
		<div id="d_clip_button_news" class="my_clip_button_news" style="font-size:11px;"><b id="bef_copy_news"><?=$ADMIN_TRANS['copy code to clipboard'];?></b><b id="af_copy_news" style="display:none"><?=$ADMIN_TRANS['copied! now you can paste and embed it in rich text content editor'];?></b></div>
	</div>
	<br/>
	<div><?=$ADMIN_TRANS['source html code'];?></div>
	<textarea id="news_embed_code">&lt;iframe src="/iframe_news.php?cID=<?=$CHECK_CATPAGE[parentID];?>&scroll=up&border=&bgcolor=" id="nframe_<?=$CHECK_CATPAGE[parentID];?>" allowtransparency="true" border="0" frameborder="0" width="100%" scrolling="no"&gt;&lt;/iframe&gt;</textarea><br>
	<?=$ADMIN_TRANS['copy this code to other areas in the site to display these news elsewhere'];?></div>
	</div>
	
</div>
<div dir="<?=$SITE_LANG[direction];?>" id="lightNewsContainer" style="display:none;" class="editorWrapper sidesEditorWrapper"></div>
<div style="display:none" id="contentNewsDIV"></div>