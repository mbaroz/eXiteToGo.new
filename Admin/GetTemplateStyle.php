<?
include_once("../config.inc.php");
include_once("../inc/GetServerData.inc.php");
include_once("SettingsBuilder.php");
$c_Type=$P_DETAILS['CategoryType'];
if (!$P_DETAILS) $c_Type=$_GET['cType'];
$CONTENT_OPTIONS=json_decode($P_DETAILS[Options]);
$CONTENT_OPTIONS->ContentPhotoHeight=$P_DETAILS[ContentPhotoHeight];
$CONTENT_OPTIONS->ContentPhotoWidth=$P_DETAILS[ContentPhotoWidth];
$CONTENT_OPTIONS->ContentBGColor=$P_DETAILS[ContentBGColor];
$CONTENT_OPTIONS->isDefaultOptions=$P_DETAILS[isDefaultOptions];
if ($MEMBER[UserType]==0) $display_bgupload="";
$ADMIN_TRANS['crop tumbs images']="Crop Tumbs images";
if ($SITE_LANG[selected]=="he") $ADMIN_TRANS['crop tumbs images']="חתוך את התמונות הקטנות במקום להקטין אותן";
$customWidth=$SITE[galleryphotowidth];
$customHeight=$SITE[galleryphotoheight];
if ($CONTENT_OPTIONS->ContentPhotoWidth>0) $customWidth=$CONTENT_OPTIONS->ContentPhotoWidth;
if ($CONTENT_OPTIONS->ContentPhotoHeight>0) $customHeight=$CONTENT_OPTIONS->ContentPhotoHeight;
if ($CONTENT_OPTIONS->ContentPhotoBGColor) $SITE[shortcontentbgcolor]=$CONTENT_OPTIONS->ContentPhotoBGColor;
if ($CONTENT_OPTIONS->ShowPinterestButton) $showPinterestButton_check="checked";
if ($CONTENT_OPTIONS->images_crop_mode==1) $cropModeChecked="checked";
if ($CONTENT_OPTIONS->ContentMarginH>0) $contentMarginH=$CONTENT_OPTIONS->ContentMarginH;
if ($CONTENT_OPTIONS->isDefaultOptions==1) $is_default_options_checked="checked";
if ($CONTENT_OPTIONS->FullLineBriefWidth=="") {
	$CONTENT_OPTIONS->FullLineBriefWidth=677;
}
$is_rounded_checked=$is_titles_above="";
if ($CONTENT_OPTIONS->isTitlesAbove) $is_titles_above="checked";
if ($P_DETAILS[ContentMarginH]==0) $P_DETAILS[ContentMarginH]=10;
if ($P_DETAILS[ContentMarginW]==0) $P_DETAILS[ContentMarginW]=6;
if ($CONTENT_OPTIONS->ContentRoundCorners==1 OR ($P_DETAILS[isContentRoundCorners]==0 AND $SITE[roundcorners]==1)) {
	$is_rounded_checked="checked";
	$is_rounded=1;
}
$Proporsion=1;
if ($CONTENT_OPTIONS->ContentPhotoHeight>0) $Proporsion=$CONTENT_OPTIONS->ContentPhotoWidth/$CONTENT_OPTIONS->ContentPhotoHeight;
$ADMIN_TRANS['num_columns']="Number of columns";
if ($SITE_LANG['selected']=="he") {
	$ADMIN_TRANS['num_columns']="מספר עמודות";
}
?>
<script src="<?=$SITE[cdn_url];?>/js/colorpicker/colpick.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=$SITE[cdn_url];?>/js/colorpicker/colpick.css" type="text/css"/>
<?

$s=array();
	if ($c_Type==1 OR $c_Type==11) array_push($s,array(
			"Label"=>$ADMIN_TRANS['margin between briefs'],"Defvalue"=>$P_DETAILS[ContentMarginH] ,"type"=>"text","icon"=>"","class"=>"some","id"=>"contentmarginheight","slider"=>true,"postLabel"=>"PX","css-class"=>"#boxes li","css-prop"=>"margin-bottom","max-val"=>200)
		);
	array_push($s,	array(
		"Label"=>$ADMIN_TRANS['photos bg color'],"Defvalue"=>$CONTENT_OPTIONS->ContentPicBGColor ,"type"=>"color","icon"=>"","class"=>"some","id"=>"P_DETAILS[ContentPhotoBGColor]","slider"=>false,"postLabel"=>"","css-class"=>".inside_div .tumbs","css-prop"=>"background-color"),
	array(
		"Label"=>$ADMIN_TRANS['content and photo bg color'],"Defvalue"=>$CONTENT_OPTIONS->ContentBGColor ,"type"=>"color","icon"=>"","class"=>"some","id"=>"P_DETAILS[ContentBGColor]","slider"=>false,"postLabel"=>"","css-class"=>".inside_div","css-prop"=>"background-color"),
	array(
		"Label"=>$ADMIN_TRANS['titles text color'],"Defvalue"=>$CONTENT_OPTIONS->TitlesColor ,"type"=>"color","icon"=>"","class"=>"some","id"=>"P_DETAILS[TitlesColor]","slider"=>false,"postLabel"=>"","css-class"=>".inside_div h2","css-prop"=>"color"),
	array(
		"Label"=>$ADMIN_TRANS['content text color'],"Defvalue"=>$CONTENT_OPTIONS->ContentTextColor ,"type"=>"color","icon"=>"","class"=>"some","id"=>"P_DETAILS[ContentTextColor]","slider"=>false,"postLabel"=>"","css-class"=>".inside_div .content div > p","css-prop"=>"color")
	);
	
	
	if ($c_Type==12 OR $c_Type==21) {
		array_push($s,
		array(
			"Label"=>$ADMIN_TRANS['border color'],"Defvalue"=>$CONTENT_OPTIONS->ContentBorderColor ,"type"=>"color","icon"=>"","class"=>"some","id"=>"P_DETAILS[ContentBorderColor]","slider"=>false,"postLabel"=>"","css-class"=>".inside_div","css-prop"=>"border-color"),
		array(
			"Label"=>$ADMIN_TRANS['briefs text bg color'],"Defvalue"=>$CONTENT_OPTIONS->ContentTextBGColor ,"type"=>"color","icon"=>"","class"=>"some","id"=>"P_DETAILS[ContentTextBGColor]","slider"=>false,"postLabel"=>"","css-class"=>".short_content_container, #boxes li.wide .innerDiv","css-prop"=>"background-color"),
		
		array(
			"Label"=>$ADMIN_TRANS['rounded corners'],"Defvalue"=>$is_rounded_checked ,"type"=>"checkbox","icon"=>"<i class='fa fa-square-o'> </i>","class"=>"some","id"=>"is_rounded_corners","slider"=>false,"postLabel"=>"","css-class"=>"","css-prop"=>""),
		
		array(
			"Label"=>$ADMIN_TRANS['show title above photos'],"Defvalue"=>$is_titles_above ,"type"=>"checkbox","icon"=>"<i class='fa fa-list-alt'></i>","class"=>"some","id"=>"titles_above","slider"=>false,"postLabel"=>"")
		);

	}
	array_push($s,	
	array(
		"Label"=>$ADMIN_TRANS['show pinterest on photo hover'],"Defvalue"=>$showPinterestButton_check ,"type"=>"checkbox","icon"=>"<i class='fa fa-pinterest'></i>","class"=>"some","id"=>"show_pinterest_button","slider"=>false,"postLabel"=>""),
	array(
		"Label"=>$ADMIN_TRANS['crop tumbs images'],"Defvalue"=>$cropModeChecked ,"type"=>"checkbox","icon"=>"<i class='fa fa-crop'></i>","class"=>"some","id"=>"crop_mode","slider"=>false,"postLabel"=>""),
	array(
		"Label"=>$ADMIN_TRANS['set these options as default for new templates'],"Defvalue"=>$is_default_options_checked ,"type"=>"checkbox","icon"=>"<i class='fa fa-sliders'></i>","class"=>"some","id"=>"is_default_options","slider"=>false,"postLabel"=>"","css-class"=>"","css-prop"=>"")
	
);

switch (1) {
	case $c_Type==1 or $c_Type==11 or $c_Type==12 OR $c_Type==21:
	?>
	<div class="templateSettings">
	<table border="0" cellspacing="0">
			<tr>
				<td style="border-top:0px"><?=$ADMIN_TRANS['num_columns'];?></td>
				<td style="border-top:0px">
					<select id="n_cols">
						<?
						for ($a=2;$a<=10;$a++) {
							$selected_option="";
							if ($a==$CONTENT_OPTIONS->number_columns) $selected_option="selected";
							?>
							<option value="<?=$a;?>" <?=$selected_option;?>><?=$a;?></option>
							<?
						}
						?>
					</select>
				</td>
			</tr>
			<tr style="display:none">
			<td style="border-top:0px"><?=$ADMIN_TRANS['tumbnail size'];?></td>
			<td style="border-top:0px">
				(W)<input type="text" maxlength="3" value="<?=$customWidth;?>" name="contentphotowidth" id="contentphotowidth" style="width:40px;direction:ltr;text-align:center" onkeyup="updateWidthHeight('width');"/>x<input type="text" maxlength="3" value="<?=$customHeight;?>" name="contentphotoheight" id="contentphotoheight" style="width:40px;direction:ltr;text-align:center" onkeyup="updateWidthHeight('height');"/>(H)
				&nbsp; <span style="cursor:pointer" onclick="resetWidthHeight();" title="reset"> <i class="fa fa-repeat"></i></span>			
				<br>
				<span id="lock_prop" onclick="lockPropotionalsNew()" style="margin-<?=$SITE[align];?>:55px"><img id="prop_lock_image" src="<?=$SITE[url];?>/Admin/images/lock_prop_icon.png" border="0"></span>
			</td>
			</tr>
			<?
			if ($c_Type==12 OR $c_Type==21) {
				?>
				<tr>
				<td><?=$ADMIN_TRANS['margin between briefs'];?></td>
				<td>
					<input type="text" maxlength="3" value="<?=$P_DETAILS[ContentMarginW];?>" name="contentmarginwidth" id="contentmarginwidth" style="width:50px;direction:ltr"/>&nbsp; X&nbsp;
					<input type="text" maxlength="3" value="<?=$P_DETAILS[ContentMarginH];?>" name="contentmarginheight" id="contentmarginheight" style="width:50px;direction:ltr"/><br>
					<small><?=$ADMIN_TRANS['width in pixels'];?>
					&nbsp;
					<?=$ADMIN_TRANS['height in pixels'];?></small>
				</td>
				</tr>
				<?
			}

			print AddSetting($s,0);
			?>		
		
			<tr>
				<td colspan=2><br><a href="#" onclick="resetDefaultOptions()"><?=$ADMIN_TRANS['reset options from default template'];?></a></td>
			</tr>
			
			<tr>
				<td colspan="4">
					<div class="button" onclick="ShowEmbedCode(this)"><?=$ADMIN_TRANS['embed code to insert briefs into'];?></div>
				<div id="embedGalleryCode">
				<br>
				<div id="d_clip_container" style="position:relative;margin-top:5px">
					<div id="d_clip_button" class="my_clip_button"><b id="bef_copy"><?=$ADMIN_TRANS['copy code to clipboard'];?></b><b id="af_copy" style="display:none"><?=$ADMIN_TRANS['copied! now you can paste and embed it in rich text content editor'];?></b></div>
					</div>
					<br/>
					<br>
					<div><?=$ADMIN_TRANS['source html code'];?></div>
						<textarea readonly="readonly" id="embedCode"><?=htmlspecialchars('<iframe allowtransparency="true" border="0" frameborder="0" id="iframe_shortContent" scrolling="no" src="'.$SITE[url].'/iframe_ShortContent.php?cat_url='.$urlKey.'&limit=" width="100%"></iframe>');?></textarea>
				</div>
				</td>
			</tr>
		</table>
	</div>
	<script>jQuery("#newSaveIcon.newSave.greenSave").click(function() {SaveContentOptions()});</script>
	<script>
	var currentLock=1;
	var tumbsProportion=<?=$Proporsion;?>;
	var display_bg_upload="none";
	var embed_code_backup;
	function SaveContentOptions() {
		ButtonSavingChanges(1,0)
		var catID="<?=$P_ID[parentID];?>";
		var pWidth=jQuery('#contentphotowidth').val();
		var pHeight=jQuery('#contentphotoheight').val();
		var content_photo_bg_color=$('P_DETAILS[ContentPhotoBGColor]').value;
		var content_bg_color=$('P_DETAILS[ContentBGColor]').value;
		var content_text_color=$('P_DETAILS[ContentTextColor]').value;
		if ($('P_DETAILS[ContentBorderColor]')) var content_border_color=$('P_DETAILS[ContentBorderColor]').value;
		if ($('P_DETAILS[PhotosBorderColor]')) var photos_border_color=$('P_DETAILS[PhotosBorderColor]').value;
		if ($('P_DETAILS[ContentTextBGColor]')) var content_text_bg_color=$('P_DETAILS[ContentTextBGColor]').value;
		var titles_color=$('P_DETAILS[TitlesColor]').value;
		var marginH=jQuery('#contentmarginheight').val();
		if (jQuery('#contentmarginwidth').length>0) var marginW=jQuery('#contentmarginwidth').val();
		var full_line_width=jQuery('#full_brief_width').val();
		var is_rounded=-1;
		var options_default=-1;
		var show_pinterest_button=0;
		var imagesCropMode=0;
		var number_columns=jQuery("select#n_cols option:selected").val();
		var is_titles_above=0;
		if (jQuery("input#crop_mode").is(":checked")) imagesCropMode=1;
		//if ($('is_rounded_corners').checked) is_rounded=1;
		<?if ($display_bgupload=="") {
		?>//swfu.startUpload();
		<? }	?>
		if (jQuery('input#is_default_options').is(":checked")) options_default=1;
		if ($('show_pinterest_button').checked) show_pinterest_button=1;
		if (jQuery('input#is_rounded_corners').is(":checked")) is_rounded=1;
		if ($('titles_above') && $('titles_above').checked) is_titles_above=1;
		
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars = 'action=saveContentOptions&catID='+catID+'&pWidth='+pWidth+'&pHeight='+pHeight+'&content_photo_bg_color='+content_photo_bg_color+'&content_bg_color='+content_bg_color+'&titles_color='+titles_color+'&content_text_color='+content_text_color+'&content_text_bg_color='+content_text_bg_color+'&photos_border_color='+photos_border_color+'&borderColor='+content_border_color+'&hMargin='+marginH+'&wMargin='+marginW+'&isDefaultOptions='+options_default+'&full_line_width='+full_line_width+'&show_pinterest_button='+show_pinterest_button+'&images_crop_mode='+imagesCropMode+'&content_rounded_corners='+is_rounded+'&num_columns='+number_columns+'&is_titles_above='+is_titles_above;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:ButtonSavingChanges(0,0), onFailure:failedEdit,onLoading:savingChanges});
		//if (display_bg_upload=="") window.setTimeout('check_if_gallery_pics_finished()',900);
		//else window.setTimeout('ReloadPage()',900);
		
		//ShowLayer("ContentOptions",0,0); 
		//window.setTimeout('ReloadPage()',600);
	}
	function lockPropotionalsNew() {
		if (currentLock==1) {

			document.getElementById("prop_lock_image").src="<?=$SITE[url];?>/Admin/images/unlock_prop_icon.png";
			currentLock=0;
		}
		else {
			document.getElementById("prop_lock_image").src="<?=$SITE[url];?>/Admin/images/lock_prop_icon.png";
			currentLock=1;
		}
	}
	function resetDefaultOptions() {
		var catID="<?=$CHECK_CATPAGE[parentID];?>";
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars = 'action=resetDefaultOptions&update_catID='+catID;
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successUpload, onFailure:failedEdit,onLoading:savingChanges});
		window.setTimeout('ReloadPage()',300);
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
	break;
	default:
	break;
}
?>
<script>
function SetCSSVAL(c,p,v) {
	var valueExt;
	var valuePre="";
	if (p.indexOf("color")<0) valueExt="px";
	else valuePre="#";
	//var theVAL=v.replace("#","");
	jQuery(c).each(function() {jQuery(this).css(p,valuePre+v+valueExt);});
}
function initPickerNow() {
	jQuery('.pick').each(function(){jQuery(this).colpick({
			layout:'hex',
			submit:0,
			colorScheme:'light',
			onChange:function(hsb,hex,rgb,el,bySetColor) {
				jQuery(el).css('border-color','#'+hex);
				if(!bySetColor) jQuery(el).val(hex);
				var theCSS_CLASS=jQuery(el).attr("data-css-class");
				var theCSS_PROP=jQuery(el).attr("data-css-prop");
				if (theCSS_PROP && theCSS_CLASS) SetCSSVAL(theCSS_CLASS,theCSS_PROP,jQuery(el).val());
			}
			}).keyup(function(){
				jQuery(this).colpickSetColor(this.value);
			});
			if (jQuery(this).val()) jQuery(this).css("border-color","#"+jQuery(this).colpickSetColor(this.value));
		});
}
jQuery(document).ready(function(){
	window.setTimeout('initPickerNow()',500);
	jQuery(".s_slider").each(function(){
		var max_value=jQuery(this).attr("data-max-val");
		jQuery(this).slider({
				range:'max',max:200,value:jQuery("#"+jQuery(this).attr("data-input")).val(),
				 slide: function( event, ui ) {
				 	var theCSS_CLASS=jQuery(this).attr("data-css-class");
				 	var theCSS_PROP=jQuery(this).attr("data-css-prop");
				 	if (theCSS_PROP && theCSS_CLASS) SetCSSVAL(theCSS_CLASS,theCSS_PROP,ui.value);
				 	jQuery("input#"+jQuery(this).attr("data-input")).val(ui.value);

				 }
			})});
})


</script>