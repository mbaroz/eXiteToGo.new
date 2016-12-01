<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<?
$fields_border_css=$buttons_css="border:0px;";
if ($SITE[fontface]!="Arial") $font_size=11;
if ($SITE[formfieldsborder]) $fields_border_css="border:1px solid #".$SITE[formfieldsborder].";";
if ($SITE[formbuttonsborder]) $buttons_css="border:1px solid #".$SITE[formbuttonsborder].";";
?>
<style type="text/css"> 
#contentForm,#embed_code {
	color:#<?=$SITE[contenttextcolor];?>;
}

#embed_code {
	text-align:<?=$SITE['align'];?>;
	padding:20px;
}

#embed_code textarea {
	direction:ltr;
	width:100%;
	height:20px;
}

#contact_layer {
	color:#<?=$SITE[contenttextcolor];?>;
	font-size:13px;
	text-align:<?=$SITE['align'];?>;
	margin: 0 8px;
	padding:10px;
}

#contact_layer label {
	display: inline-block;
	padding-bottom:5px;
	
}

#contentForm {
	margin:10px 0;
}

#contentForm .roundBox {
	margin:0 8px;
	width:auto;
}

.contact_frm {
	width:200px;
	background-color: #<?=$SITE[formbgcolor];?>;
	font-family:inherit;
	font-size:inherit;
	border-style: solid;
	color:#<?=$SITE[formtextcolor];?>;
	<?=$fields_border_css;?>

}
.contact_frm_txt {
	width:194px;
	padding:2px;
	padding-<?=$SITE['align'];?>:4px;
	background-color: #<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-size:inherit;
	scrollbar-base-color: #<?=$SITE[formbgcolor];?>;
	vertical-align:top;
	<?=$fields_border_css;?>
}
.frm_button {
	padding:3px 5px 3px 5px;
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	font-family:inherit;
	font-weight:bold;
	font-size:12px;
	cursor:pointer;
	white-space: nowrap;
	<?=$buttons_css;?>
}
input[disabled].frm_button {border:0px}
#boxes {
	list-style-type: none;
}

.progressWrapper {
	width:220px !important;
}

.progressWrapper .progressContainer .progressName, .progressWrapper .progressContainer .progressBarStatus  {
	width:auto;
}

</style> 
<?
$P_TITLE=GetPageTitle($CHECK_CATPAGE[parentID],"TopForm_Title");
$P_CONTENT_TOP=GetPageTitle($CHECK_CATPAGE[parentID],"TopForm_Content");
$P_CONTENT_BOTTOM=GetPageTitle($CHECK_CATPAGE[parentID],"BottomForm_Content");
	
	if ($P_TITLE[Title]=="" AND isset($_SESSION['LOGGED_ADMIN'])) $P_TITLE[Title]="Enter Your title here";

	?>
	<div class="titleContent_top" style="padding-<?=$SITE[align];?>:3px">
	<?if ($SITE[titlesicon] AND !$P_TITLE[Title]=="") {
			?><div class="titlesIcon" style="margin-<?=$SITE[align];?>:10px;"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
			<?
			
		}
		if (!$P_TITLE[Title]=="") {
			?>
			<h1 id="shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>"><?=$P_TITLE[Title];?></h1>
			<?
		}
		?>
	</div>
	<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<script type="text/javascript">
		var gal_editor_width="99%";
		var OrigTopContent;
		var OrigBottomContent;
		function EditTopBottomContent(textDivID) {
			var contentDIV = document.getElementById(textDivID);
			OrigTopContent=contentDIV.innerHTML;
			var top_bottom_content_text=contentDIV.innerHTML;
			var buttons_str;
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveTopContent(0);"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
			if (textDivID=="bottomShortContent") buttons_str='<br><div id="newSaveIcon" onclick="saveTopContent(1);"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
		
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
					slideOutEditor("lightEditorContainer",1);
					jQuery(function() {
						//jQuery("#lightEditorContainer").draggable();
			});
	}
			
			function saveTopContent(top_bottom) {
				//if (top_bottom==1) var cVal=editor_ins.getData('bottomShortContent');
				var cVal=editor_ins.getData();
				cVal=encodeURIComponent(cVal);
				var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
				var cpicstype="TopForm_Content";
				if (top_bottom==1) cpicstype="BottomForm_Content";
				var pars = 'type='+cpicstype+'&content='+cVal+'&objectID=<?=$CHECK_CATPAGE[parentID];?>';
				var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
				if (top_bottom==1) jQuery('#bottomShortContent').html(decodeURIComponent(cVal));
					else jQuery('#topShortContent').html(decodeURIComponent(cVal));
				slideOutEditor("lightEditorContainer",0);
				editor_ins.destroy();
				
			}
			function cancel(top_bottom) {
				slideOutEditor("lightEditorContainer",0);
				editor_ins.destroy();
			}
			function cancelInputFreeText() {
				slideOutEditor("InputFreeTextEditor",0);
				editor_ins.destroy();
			}
			
		</script>
		<br />
		<?
		if ($SITE[formsEnabled]==1 OR $MEMBER[UserType]==0) {
			?>
			<div id="newSaveIcon" class="add_button" onclick="AddInput();"><i class="fa fa-bars"></i> <?=$ADMIN_TRANS['add input'];?></div>
			<?
		}
		?>
		<div id="newSaveIcon" onclick="EditAttributes();" style="margin-<?=$SITE['align'];?>:7px;"><i class="fa fa-sliders"></i> <?=$ADMIN_TRANS['form settings'];?></div>

		&nbsp;&nbsp;<div id="newSaveIcon"  onclick="EditTopBottomContent('topShortContent');"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit top content'];?></div>
		<span style="display:none" id="saveGalButton"><div style="display:" id="newSaveIcon" onclick="saveTopContent(0)"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save changes'];?></div></span>
		<span style="display:none" id="closeGalButton"><div style="display:" id="newSaveIcon" onclick="cancel(0)"><img src="<?=$SITE[url];?>/Admin/images/close_icon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['cancel'];?></div></span>
		<div style="height:5px"></div>
		<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>', '<?=$SITE[url];?>/Admin/saveTitles.php?type=TopForm_Title', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>',formClassName:'titleContent_top'});
		</script>
		<?
	}
	?>
	<div id="topShortContent" style="padding-<?=$SITE[align];?>:10px;margin-<?=$SITE[opalign];?>:3px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=$P_CONTENT_TOP[Content];?></div>
 <?

require_once 'inc/CustomForm.inc.php';
if(!$form = getFormByUrlKey($urlKey))
	$form = createBlankForm($urlKey,$CHECK_CATPAGE['parentID']);
$antiSpamSys = ($form['antiSpam'] == '1');
$form['buttonData'] = unserialize($form['buttonFile']);	

$form['sendText'] = ($form['sendText'] == '') ? $translations[$SITE_LANG['selected']]['send'] : $form['sendText'];

if(@$form['buttonData']['file'] != '')
{
	$form['sendText'] = '';
	$form['clearText'] = '';
}

$form['inputBgColor'] = ($form['inputBgColor'] == '') ? $SITE['formbgcolor'] : $form['inputBgColor'];
$form['inputTextColor'] = ($form['inputTextColor'] == '') ? $SITE['formtextcolor'] : $form['inputTextColor'];
$form['inputBorderColor'] = ($form['inputBorderColor'] == '') ? $SITE['formfieldsborder'] : $form['inputBorderColor'];
	
$inputs = getFormInputs($form['formID'],true);

if (isset($_SESSION['LOGGED_ADMIN'])) {
	function my_json_encode($arr)
	{
		array_walk_recursive($arr, 'my_json_walk');
		return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');
	}
	
	function my_json_walk(&$item, $key)
	{
		if (is_string($item))
			$item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8');
	}
	
	require_once("Admin/colorpicker.php");
	$recieversValue = '';
	$recievers = unserialize($form['recievers']);
	if(is_array($recievers))
		foreach($recievers as $reciever)
			$recieversValue .= $reciever."\n";
	$successUrl = $SITE['url'].'/'.$form['successUrl'];
	?>
	<style type="text/css">
		.movableB {
			cursor:move;
		}
	</style>
	<script type="text/javascript" src="/js/md5-min.js"></script>
	<script type="text/javascript">
		var editInputID = 0;
		var buttonID= "form_spanButtonPlaceHolder";
		var allowed_photo_types="*.jpg;*.gif;*.png";
		var uploaded_filename = '';
		var upload_global_type = 'custom_form';
		var swfu,swfu_2;
		var data_sent = 0;
		var editor_ins = false;
		
		function EditAttributes() {
			if (document.getElementById("AttributesEditor").style.display=="none") {
				//ShowLayer("AttributesEditor",1,1,1);
				slideOutSettings("AttributesEditor",1);
				showuploader(allowed_photo_types,1,'spanButtonPlaceHolder_form',0,'fileProgress_form');
				jQuery("#AttributesSettingsInner").height(jQuery(window).height()-90);
			}
			else {
				//ShowLayer("AttributesEditor",0,1,1);
				slideOutSettings("AttributesEditor",0);
			}
		}
		
		function AddInput() {
			editInputID = 0;
			jQuery('#InputEditor input[type=text]').val('');
			jQuery('#InputEditor textarea').val('');
			jQuery('#InputEditor input[type=checkbox]').attr('checked',false);
			jQuery('#InputEditor select').val('');
			if (document.getElementById("InputEditor").style.display=="none") {
				ShowLayer("InputEditor",1,1,1);
			}
			else {
				ShowLayer("InputEditor",0,1,1);
			}
		}
		
		function editReceivers(inputID,options,receivers) {
			if (document.getElementById("InputReceiversEditor").style.display=="none") {
				editInputID = inputID;
				var html_options = '';
				var html_fields = '';
				jQuery.each(options,function(index,option){
					var recs = find_receivers(option,receivers);
					html_options += '<option value="'+index+'"';
					if(index == 0)
					{
						html_options += ' SELECTED';
					}
					html_options += '>'+option+'</option>';
					html_fields += '<input type="hidden" name="options[]" value="'+option+'" /><textarea style="';
					if(index > 0)
					{
						html_fields += 'display:none;';
					}
					html_fields += 'width:200px;height:150px;" class="gen_fields" name="receivers[]" dir="ltr" id="field_'+index+'">'+find_receivers(option,receivers)+'</textarea>';
				});
				jQuery('#receivers').html('<div style="float:<?=$SITE[align];?>;width:200px;height:180px;overflow:auto;"><select style="width:190px;height:150px;" onchange="jQuery(\'.gen_fields\').hide();jQuery(\'#field_\'+jQuery(this).val()+\'\').show();" multiple="multiple">'+html_options+'</select></div><div style="float:<?=$SITE[align];?>;width:200px;height:180px;">'+html_fields+'</div><div style="clear:both;"></div>');
				ShowLayer("InputReceiversEditor",1,1,1);
				SetPosition(false,"InputReceiversEditor",0);
			}
			else {
				ShowLayer("InputReceiversEditor",0,1,1);
			}
		}
		
		function saveInputReceivers(){
			var pars = 'action=saveReceivers&inputID='+editInputID+'&';
			pars += jQuery('#InputReceiversEditor form').serialize();
			
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveForm.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit(); setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
		}
		
		function find_receivers(option,receivers){
			var found = '';
			jQuery.each(receivers,function(index,receiver){
				if(hex_md5(receiver.option) == hex_md5(option))
					found = receiver.receivers;
			});
			return found;
		}
		
		function editFreeText(inputID,currentText) {
			if (document.getElementById("InputFreeTextEditor").style.display=="none") {
				editInputID = inputID;
				jQuery('#FreeTextArea').val(currentText);
				editor_ins=CKEDITOR.replace('FreeTextArea', {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
				});
				//ShowLayer("InputFreeTextEditor",1,1,1);
				slideOutEditor("InputFreeTextEditor",1);
				//jQuery('#InputFreeTextEditor').draggable();
				//SetPosition(false,"InputFreeTextEditor",0);
			}
			
		}
		
		function saveFreeText(){
			var pars = 'action=saveFreeText&inputID='+editInputID+'&';
			pars += 'freeText='+encodeURIComponent(editor_ins.getData());
			
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveForm.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit(); setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
			editor_ins.destroy();
		}

		function editInput(inputID,inputName,inputType,inputDefValue,inputValues,mandatoryError,mandatory,boldLabel,isSenderMail,maxLength,minTableWidth,maxTableWidth) {
			editInputID = inputID;
			if(minTableWidth < 1)
				minTableWidth = 150;
			if(maxTableWidth < 1)
				maxTableWidth = 400;
			jQuery('#inputName').val(inputName.replace(/&quot;/g,'"'));
			jQuery('#inputType').val(inputType);
			jQuery('#inputDefValue').val(inputDefValue.replace(/&quot;/g,'"'));
			jQuery('#inputValues').val(inputValues.replace(/&quot;/g,'"'));
			jQuery('#mandatoryError').val(mandatoryError.replace(/&quot;/g,'"'));
			jQuery('#maxLength').val(maxLength);
			jQuery('#minTableWidth').val(minTableWidth);
			jQuery('#maxTableWidth').val(maxTableWidth);
			if(mandatory == 1){
				jQuery('#mandatory').attr('checked',true);
				jQuery('#ErrMsgBlock').show();
			}
			else
				jQuery('#mandatory').attr('checked',false);
			if(isSenderMail == 1)
				jQuery('#isSenderMail').attr('checked',true);
			else
				jQuery('#isSenderMail').attr('checked',false);
			if(boldLabel == 1)
				jQuery('#boldLabel').attr('checked',true);
			else
				jQuery('#boldLabel').attr('checked',false);
			if (document.getElementById("InputEditor").style.display=="none") {
				ShowLayer("InputEditor",1,1,1);
			}
			toggleValuesBlock(inputType);
		}
		
		function beforeSaveForm() {
			if(data_sent == 0)
			{
				data_sent = 1;
				savingChanges(); 
				<? if($MEMBER[UserType]==0){ ?>swfu.startUpload();<? } ?>
				setTimeout('checkFormUploaded()',500);
			}
		}
		
		function checkFormUploaded() {
			<? if($MEMBER[UserType]==0){ ?>my_stat = swfu.getStats();
			if(my_stat.in_progress == 1)
				setTimeout('checkFormUploaded()',500);
			else <? } ?>
				saveFormSettings();
		}
		
		function saveFormSettings() {
			var roundCorners = 0;
			if(jQuery('#roundCorners:checked').length > 0)
				roundCorners = 1;
			var inputALine = 0;
			if(jQuery('#inputALine:checked').length > 0)
				inputALine = 1;
			var buttonsRoundCorners = 0;
			if(jQuery('#buttonsRoundCorners:checked').length > 0)
				buttonsRoundCorners = 1;
			var inputRoundedCorners = 0;
			if(jQuery('#inputRoundedCorners:checked').length > 0)
				inputRoundedCorners = 1;
			var defaultSettings = 0;
			if(jQuery('#defaultSettings:checked').length > 0)
				defaultSettings = 1;
			var placeholders = 0;
			if(jQuery('#placeholders:checked').length > 0)
				placeholders = 1;
			var saveFormData = 0;
			if(jQuery('#saveFormData:checked').length > 0)
				saveFormData = 1;
			var antiSpam = 0;
			if(jQuery('#antiSpam:checked').length > 0)
				antiSpam = 1;
			var delButtonFile = '';
			if(jQuery('#del_buttonFile:checked').length == 1)
				delButtonFile = '&del_buttonFile=<?=urlencode($form['buttonData']['file']);?>';
			var pars = 'action=saveForm&formID=<?=$form['formID'];?>'+
			'&formName='+encodeURIComponent(jQuery('#formName').val())+
			'&successMsg='+encodeURIComponent(jQuery('#successMsg').val())+
			'&successUrl='+encodeURIComponent(jQuery('#successUrl').val())+
			'&sendText='+encodeURIComponent(jQuery('#sendText').val())+
			'&clearText='+encodeURIComponent(jQuery('#clearText').val())+
			'&inputWidth='+encodeURIComponent(jQuery('#inputWidth').val())+
			'&inputHeight='+encodeURIComponent(jQuery('#inputHeight').val())+
			'&submitWidth='+encodeURIComponent(jQuery('#submitWidth').val())+
			'&submitHeight='+encodeURIComponent(jQuery('#submitHeight').val())+
			'&buttonFontSize='+encodeURIComponent(jQuery('#buttonFontSize').val())+
			'&textSize='+encodeURIComponent(jQuery('#textSize').val())+
			'&titleSize='+encodeURIComponent(jQuery('#titleSize').val())+
			'&buttonsRoundCorners='+buttonsRoundCorners+
			'&inputRoundedCorners='+inputRoundedCorners+
			'&bgColor='+encodeURIComponent(jQuery('#bgColor').val())+
			'&borderColor='+encodeURIComponent(jQuery('#borderColor').val())+
			'&textColor='+encodeURIComponent(jQuery('#textColor').val())+
			'&mandatoryTextColor='+encodeURIComponent(jQuery('#mandatoryTextColor').val())+
			'&inputBgColor='+encodeURIComponent(jQuery('#inputBgColor').val())+
			'&inputTextColor='+encodeURIComponent(jQuery('#inputTextColor').val())+
			'&inputBorderColor='+encodeURIComponent(jQuery('#inputBorderColor').val())+
			'&buttonsBgColor='+encodeURIComponent(jQuery('#buttonsBgColor').val())+
			'&buttonsTextColor='+encodeURIComponent(jQuery('#buttonsTextColor').val())+
			'&buttonsBorderColor='+encodeURIComponent(jQuery('#buttonsBorderColor').val())+
			'&subject='+encodeURIComponent(jQuery('#subject').val())+
			'&inputBottomMargin='+encodeURIComponent(jQuery('#inputBottomMargin').val())+
			'&roundCorners='+roundCorners+
			'&inputALine='+inputALine+
			'&saveFormData='+saveFormData+
			'&antiSpam='+antiSpam+
			'&recievers='+encodeURIComponent(jQuery('#recievers').val())+
			'&buttonFile='+uploaded_filename+
			'&placeholders='+placeholders+
			<? if($MEMBER[UserType]==0){ ?>'&defaultSettings='+defaultSettings+<? } ?>
			delButtonFile;
			
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveForm.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
		}
		
		function delButtonFile() {
			if(confirm('אתה בטוח?'))
			{
				var pars = 'action=delButtonFile&formID=<?=$form['formID'];?>&del_buttonFile=<?=urlencode($form['buttonData']['file']);?>';
				var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveForm.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
			}
		}
		
		function saveInput() {
			if(jQuery('#inputType').val() == 'select' || jQuery('#inputType').val() == 'radio' || jQuery('#inputType').val() == 'checkbox')
			{
				if(jQuery('#inputValues').val() == '')
				{
					alert('<?=$ADMIN_TRANS['please fill in at least one option to selections'];?>!');
					return false;
				}
			}
			var mandatory = 0;
			if(jQuery('#mandatory:checked').length > 0)
				mandatory = 1;
			var isSenderMail = 0;
			if(jQuery('#isSenderMail:checked').length > 0)
				isSenderMail = 1;
			var boldLabel = 0;
			if(jQuery('#boldLabel:checked').length > 0)
				boldLabel = 1;
			var pars = 'action=saveInput';
			if(editInputID > 0)
				pars += '&inputID='+editInputID;
			pars += '&formID=<?=$form['formID'];?>'+
			'&inputName='+encodeURIComponent(jQuery('#inputName').val())+
			'&inputType='+encodeURIComponent(jQuery('#inputType').val())+
			'&inputDefValue='+encodeURIComponent(jQuery('#inputDefValue').val())+
			'&inputValues='+encodeURIComponent(jQuery('#inputValues').val())+
			'&mandatoryError='+encodeURIComponent(jQuery('#mandatoryError').val())+
			'&boldLabel='+boldLabel+
			'&mandatory='+mandatory+
			'&isSenderMail='+isSenderMail+
			'&maxLength='+encodeURIComponent(jQuery('#maxLength').val())+
			'&minTableWidth='+encodeURIComponent(jQuery('#minTableWidth').val())+
			'&maxTableWidth='+encodeURIComponent(jQuery('#maxTableWidth').val());
			
			var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveForm.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
		}
		
		function delInput(inputID)
		{
			if(confirm('אתה בטוח?')){
				jQuery('#short_cell-'+inputID).remove();
				var pars = 'action=delInput&inputID='+inputID;
				var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveForm.php', {method:'post', parameters:pars, onSuccess: successEdit, onFailure:failedEdit, onLoading:savingChanges});
				saveInputsOrder(jQuery("#inputs").sortable('serialize'));
			}
		}
		
		function toggleValuesBlock(type)
		{
			var def_val = jQuery('#inputDefValue').val();
			if(type == 'select' || type == 'radio' || type =='checkbox')
			{
				jQuery('#inputValuesBlock').show();
				jQuery('#defValueInput').html('<select style="width:110px;" id="inputDefValue"></select>');
				newValuesBlock();
			}
			else
			{
				jQuery('#inputValuesBlock').hide();
				jQuery('#defValueInput').html('<input style="width:110px;" type="text" size="10" id="inputDefValue" value="'+def_val+'" />');
			}
		}
		
		function newValuesBlock()
		{
			if(jQuery('#inputType').val() == 'select' || jQuery('#inputType').val() == 'radio' || jQuery('#inputType').val() == 'checkbox')
			{
				var values = jQuery('#inputValues').val();
				var ar_vals = values.split("\n");
				var str_options = '<option></option>';
				jQuery.each(ar_vals,function(index,data){
					if(data != '')
						str_options += '<option>'+data+'</option>';
				});
				jQuery('#inputDefValue').html(str_options);
			}
		}
		
		function saveInputsOrder(newPosition) {
			var url = '<?=$SITE[url];?>/Admin/saveForm.php';
			var pars =newPosition+'&action=saveOrder';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});	
		}
		
		function checkErrMsg() {
			if(jQuery('#mandatory:checked').length > 0)
			{
				jQuery('#ErrMsgBlock').show();
			}
			else
			{
				jQuery('#ErrMsgBlock').hide();
			}
		}
		
		
	</script>
	<link type="text/css" rel="stylesheet" href="<?=$SITE[url];?>/css/ui.all.css">
	<div style="width:100%;height:20px;"></div>
	<div style="display:none">
		<iframe name="saveFormFrame" id="saveFormFrame"></iframe>
	</div>
	<div dir="<?=$SITE_LANG[direction];?>" id="AttributesEditor" style="display:none;min-width:300px;width:685px;" class="CatEditor settings_slider">
	<div align="<?=$SITE[opalign];?>" id="make_dragable"><div class="icon_close" onclick="EditAttributes()">+</div>
		<div class="title"><strong><?=$ADMIN_TRANS['options'];?></strong></div>
	</div>
	<div class="CenterBoxContent">
		<form onsubmit="beforeSaveForm();return false;" name="setting_custom_form" id="setting_custom_form">
		<div style="overflow-y: auto;height:auto;" id="AttributesSettingsInner">
			<input type="hidden" name="action" value="saveForm" />
			<input type="hidden" name="formID" value="<?=$form['formID'];?>" />
			
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
				<span><?=$ADMIN_TRANS['form title'];?></span> : <br />
				<input type="text" size="10" style="width:200px" id="formName" name="formName" value="<?=$form['formName'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;">
				<span><?=$ADMIN_TRANS['message of successful form submission'];?></span> : <br />
				<input type="text" size="10" style="width:200px" id="successMsg" name="successMsg" value="<?=$form['successMsg'];?>" /><br /><br />
			</div>
			<div style="clear:both;"></div>
			
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px">
				<span><?=$ADMIN_TRANS['clear button text'];?></span> : <br />
				<input type="text" size="10" style="width:200px" id="clearText" name="clearText" value="<?=$form['clearText'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;">
				<span><?=$ADMIN_TRANS['send button text'];?></span> : <br />
				<input type="text" size="10" style="width:200px" id="sendText" name="sendText" value="<?=$form['sendText'];?>" /><br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['redirect to page after submission'];?></span> : <br />
				<textarea style="font-family:Arial;direction:ltr;width:415px" id="successUrl" name="successUrl"><?=$successUrl;?></textarea><br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['fields width'];?></span> : <br />
				<input style="width:27px;" type="text" size="10" id="inputWidth" name="inputWidth" value="<?=$form['inputWidth'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['fields height'];?></span> : <br />
				<input style="width:27px;" type="text" size="10" id="inputHeight" name="inputHeight" value="<?=$form['inputHeight'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['button width'];?></span> : <br />
				<input style="width:27px;" type="text" size="10" id="submitWidth" name="submitWidth" value="<?=$form['submitWidth'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['button height'];?></span> : <br />
				<input style="width:27px;" type="text" size="10" id="submitHeight" name="submitHeight" value="<?=$form['submitHeight'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['font size'];?></span> : <br />
				<input style="width:27px;" type="text" size="10" id="textSize" name="textSize" value="<?=$form['textSize'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['title font size'];?></span> : <br />
				<input style="width:27px;" type="text" size="10" id="titleSize" name="titleSize" value="<?=$form['titleSize'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['buttons font size'];?></span> : <br />
				<input style="width:27px;" type="text" size="10" id="buttonFontSize" name="buttonFontSize" value="<?=$form['buttonFontSize'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['space between fields'];?></span> : <br />
				<input style="width:27px;" type="text" size="10" id="inputBottomMargin" name="inputBottomMargin" value="<?=$form['inputBottomMargin'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;margin-bottom:10px;">
				<span><?=$ADMIN_TRANS['buttons rounded corners'];?></span> : 
				<input type="checkbox" name="buttonsRoundCorners" id="buttonsRoundCorners" value="1"<?=($form['buttonsRoundCorners']==1) ? ' CHECKED' : '';?> /><br /><br />
	
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;margin-bottom:10px;">
				<span><?=$ADMIN_TRANS['inputs rounded corners'];?></span> : 
				<input type="checkbox" name="inputRoundedCorners" id="inputRoundedCorners" value="1"<?=($form['inputRoundedCorners']==1) ? ' CHECKED' : '';?> /><br /><br />
	
			</div>
			<div style="clear:both;"></div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['form background'];?></span> : <br />
				<? PickColor("bgColor",$form['bgColor']); ?><br /><br />
			</div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['form border'];?></span> : <br />
				<? PickColor("borderColor",$form['borderColor']); ?><br /><br />
			</div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['text color'];?></span> : <br />
				<? PickColor("textColor",$form['textColor']); ?><br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['fields background color'];?></span> : <br />
				<? PickColor("inputBgColor",$form['inputBgColor']); ?><br /><br />
			</div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['fields text color'];?></span> : <br />
				<? PickColor("inputTextColor",$form['inputTextColor']); ?><br /><br />
			</div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['fields border color'];?></span> : <br />
				<? PickColor("inputBorderColor",$form['inputBorderColor']); ?><br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['buttons background color'];?></span> : <br />
				<? PickColor("buttonsBgColor",$form['buttonsBgColor']); ?><br /><br />
			</div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['buttons text color'];?></span> : <br />
				<? PickColor("buttonsTextColor",$form['buttonsTextColor']); ?><br /><br />
			</div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['mandatory fields label text color'];?></span> : <br />
				<? PickColor("mandatoryTextColor",$form['mandatoryTextColor']); ?><br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;margin-top:3px;">
				<span><?=$ADMIN_TRANS['buttons border color'];?></span> : <br />
				<? PickColor("buttonsBorderColor",$form['buttonsBorderColor']); ?><br /><br />
			</div>
			<div style="width:200px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['rounded corners'];?></span> : 
				<input type="checkbox" id="roundCorners" name="roundCorners" value="1"<?=($form['roundCorners']==1) ? ' CHECKED' : '';?> /><br /><br />
			</div>
			<div style="width:230px;float:<?=$SITE[align];?>;<? if($MEMBER[UserType]!=0 AND !$SITE[formsEnabled]){ ?>display:none<? } ?>">
				<span><?=$ADMIN_TRANS['one checkbox a line'];?></span> : 
				<input type="checkbox" id="inputALine" name="inputALine" value="1"<?=($form['inputALine']==1) ? ' CHECKED' : '';?> /><br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['message subject'];?></span> : <br />
				<input type="text" size="10" style="width:200px" id="subject" name="subject" value="<?=$form['subject'];?>" /><br /><br />
			</div>
			<div style="width:210px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
				<span><?=$ADMIN_TRANS['message reciepts'];?></span> : <br/>
				<textarea id="recievers" name="recievers" style="font-family:Arial;width:200px;height:100px;direction:ltr;border:1px solid #000;"><?=$recieversValue;?></textarea><br />
				<small>(<?=str_replace('%%link%%','<a href="'.$SITE['url'].'/Admin/configAdmin.php">'.$ADMIN_TRANS['general settings'].'</a>',$ADMIN_TRANS['if you have not configured any reciepients, the only reciepient will be from general settings']);?>)</small>
				<br/><br />
			</div>
			
			
			<div style="float:<?=$SITE[align];?>;width:160px;">
				<span><?=$ADMIN_TRANS['button background image'];?></span> : <br />
				<!-- <input type="file" name="buttonFile" style="width:190px;" /><br /><br /> -->
				<span id="spanButtonPlaceHolder_form" style="cursor:pointer"></span>
				<? if($form['buttonData']['file'] != ''){ ?>
				&nbsp;&nbsp;&nbsp;
				<span class="button" onclick="delButtonFile()" style="color:red"><?=$ADMIN_TRANS['delete photo'];?></span>
				<? } ?>
				<span id="fileProgress_form"></span><br/><br/>
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;<? if($MEMBER[UserType]!=0 AND !$SITE[formsEnabled]){ ?>display:none<? } ?>">
				<span><?=$ADMIN_TRANS['use placeholders instead of labels'];?></span> : 
				<input type="checkbox" id="placeholders" name="placeholders" value="1"<?=($form['placeholders']==1) ? ' CHECKED' : '';?> /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;<? if($MEMBER[UserType]!=0 AND !$SITE[formsEnabled]){ ?>display:none<? } ?>">
				<span><?=$ADMIN_TRANS['use this form settings as default'];?></span> : 
				<input type="checkbox" id="defaultSettings" name="defaultSettings" value="1"<?=($form['defaultSettings']==1) ? ' CHECKED' : '';?> /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;<? if($MEMBER[UserType]!=0 AND !$SITE[formsEnabled]){ ?>display:none<? } ?>">
				<span><?=$ADMIN_TRANS['save form data'];?></span> : 
				<input type="checkbox" id="saveFormData" name="saveFormData" value="1"<?=($form['saveFormData']==1) ? ' CHECKED' : '';?> /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['add security question to prevent spam'];?></span> : 
				<input type="checkbox" id="antiSpam" name="antiSpam" value="1"<?=($form['antiSpam']==1) ? ' CHECKED' : '';?> /><br /><br />
			</div>
			<div style="clear:both;"></div>

		</div>
			<div id="newSaveIcon" class="greenSave" onclick="beforeSaveForm();return false;"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>
			<div id="newSaveIcon" class="cancel" onclick="EditAttributes();"><?=$ADMIN_TRANS['cancel'];?></div>
	</form>
	</div>
	</div>
	
	<div dir="<?=$SITE_LANG[direction];?>" id="InputEditor" style="display:none;font-family:arial;z-index:1000;padding:10px;position:absolute;top:100px;<?=$SITE[opalign];?>:295px;background-color:#E0ECFF;border:2px solid #C3D9FF;width:310px;">
		<div style="height:20px;"></div>
		<div style="float:<?=$SITE[align];?>;width:280px;margin-<?=$SITE[opalign];?>:20px;">
			<span><?=$ADMIN_TRANS['field title'];?></span> : <br />
			<input style="width:275px;" type="text" size="10" id="inputName" /><br /><br />
		</div>
		<div style="float:<?=$SITE[align];?>;">
			<span><?=$ADMIN_TRANS['default value'];?></span> : <br />
			<span id="defValueInput"><input style="width:110px;" type="text" size="10" id="inputDefValue" /></span><br /><br />
		</div>
		
		<div style="clear:both;"></div>
		<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
			<span><?=$ADMIN_TRANS['minimum column width'];?></span> : <br />
			<small>(<?=$ADMIN_TRANS['in form history table'];?>)</small><br/>
			<input style="width:110px;" type="text" size="10" id="minTableWidth" /><br /><br />
		</div>
		<div style="float:<?=$SITE[align];?>;">
			<span><?=$ADMIN_TRANS['maximum column width'];?></span> : <br />
			<small>(<?=$ADMIN_TRANS['in form history table'];?>)</small><br/>
			<input style="width:110px;" type="text" size="10" id="maxTableWidth" /><br /><br />
		</div>
		<div style="clear:both;"></div>
		
		<div style="float:<?=$SITE[align];?>;">
			<span><?=$ADMIN_TRANS['maximum input length'];?></span> : <br />
			<input style="width:110px;" type="text" size="10" id="maxLength" /><br /><br />
		</div>
		<div style="clear:both;"></div>
		<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
			<span><?=$ADMIN_TRANS['field type'];?></span> : <br />
			<select id="inputType" onchange="toggleValuesBlock(this.value);" style="width:200px;">
				<option value="text"><?=$ADMIN_TRANS['text (one line)'];?></option>
				<option value="textarea"><?=$ADMIN_TRANS['text (multi line)'];?></option>
				<option value="select"><?=$ADMIN_TRANS['combo box'];?></option>
				<option value="radio"><?=$ADMIN_TRANS['radio button'];?></option>
				<option value="checkbox"><?=$ADMIN_TRANS['checkbox'];?></option>
				<option value="hidden"><?=$ADMIN_TRANS['title only'];?></option>
				<option value="date"><?=$ADMIN_TRANS['date'];?></option>
				<option value="file"><?=$ADMIN_TRANS['file'];?></option>
				<option value="title"><?=$ADMIN_TRANS['free text'];?></option>
			</select><br /><br />
		</div>
		<div style="clear:both;"></div>
		<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;display:none" id="inputValuesBlock">
			<span><?=$ADMIN_TRANS['selection values (one value per line)'];?></span> : <br/>
			<textarea onchange="newValuesBlock();" id="inputValues" style="font-family:Arial;width:200px;height:100px;border:1px solid #000;"></textarea><br /><br />
		</div>
		<div style="clear:both;"></div>
		<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:40px;">
			<br/>
			<span><?=$ADMIN_TRANS['mandatory field'];?></span> : 
			<input type="checkbox" id="mandatory" value="1" style="vertical-align:top" onclick="checkErrMsg();" /><br />
		</div>
		<div style="float:<?=$SITE[align];?>;">
			<br/>
			<span><?=$ADMIN_TRANS['bold labels'];?></span> : 
			<input type="checkbox" id="boldLabel" value="1" style="vertical-align:top" /><br />
		</div>
		<div style="clear:both;"></div>
		<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
			<span><?=$ADMIN_TRANS['use as email for reply to sender'];?></span> : 
			<input type="checkbox" id="isSenderMail" value="1" style="vertical-align:top" /><br /><br />
		</div>
		<div style="clear:both;"></div>
		<div id="ErrMsgBlock" style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;display:none;">
			<span><?=$ADMIN_TRANS['error message for invalid value'];?></span> : <br />
			<input type="text" size="10" id="mandatoryError" style="width:250px;" /><br /><br />
		</div>
		<div style="clear:both;"></div>
		<div id="newSaveIcon" class="greenSave" onclick="saveInput();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>
		&nbsp; &nbsp;
		<div id="newSaveIcon" onclick="AddInput();"><?=$ADMIN_TRANS['cancel'];?></div>
	
	</div>
	
	<div dir="<?=$SITE_LANG[direction];?>" id="InputReceiversEditor" style="display:none;font-family:arial;z-index:1000;padding:10px;position:absolute;top:100px;<?=$SITE[opalign];?>:295px;background-color:#E0ECFF;border:2px solid #C3D9FF;width:400px;">
		<h3><?=$ADMIN_TRANS['receivers, who will receive this form, depending on different options'];?></h3>
		<small><?=$ADMIN_TRANS['here you can define one or more receivers, who will receive this form in accordance with an option, chosen for this field. click on an option to see/change the receivers'];?></small>
		<form>
		<div style="height:20px;"></div>
		<div id="receivers"></div>
		<div style="clear:both;"></div>
		<input id="saveContentButton" type="button" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="saveInputReceivers();">
		&nbsp; &nbsp;
		<input id="cancelContentButton" type="button" value="<?=$ADMIN_TRANS['cancel'];?>" onclick="editReceivers();">
		</form>
	</div>
	
	<div dir="<?=$SITE_LANG[direction];?>" id="InputFreeTextEditor" style="display:none;" class="editorWrapper">
		<textarea id="FreeTextArea" name="FreeTextArea"></textarea>
		<div style="clear:both;"></div>
		<input id="saveContentButton" type="button" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="saveFreeText();">
		&nbsp; &nbsp;
		<input id="cancelContentButton" type="button" value="<?=$ADMIN_TRANS['cancel'];?>" onclick="cancelInputFreeText();">
		</form>
	</div>

<? }
$sel_plus = 0;
if($form['inputBorderColor'] != '')
	$sel_plus = 2;
if($form['submitHeight'] ==0) $form['submitHeight']=20;
?>
<style type="text/css">
	.frm_button {
		<? if(@$form['buttonData']['file'] != ''){ ?>
			background:url(<?=SITE_MEDIA;?>/gallery/sitepics/<?=$form['buttonData']['file'];?>) no-repeat;
			width:<?=$form['buttonData']['width'];?>px;
			height:<?=$form['buttonData']['height'];?>px;
			text-align: center;
			border:0;
		<? } else { ?>
			<? if($form['submitWidth'] > 0){
				if($form['submitWidth'] >= $form['inputWidth']){
					?>width:<?=$form['submitWidth'];?>px;<?
				}
				else
				{
					?>
					min-width:<?=$form['submitWidth'];?>px;
					max-width:<?=$form['inputWidth'];?>px;
					<?
				}
			} ?>
			<? if($form['submitHeight'] > 0){ ?>min-height:<?=$form['submitHeight'];?>px;<? } ?>
			<? if($form['buttonsRoundCorners'] == 1){ ?>border-radius:<?=round($form['submitHeight']/5);?>px;<? } ?>
			<? if($form['buttonsBgColor'] != ''){ ?>background:#<?=$form['buttonsBgColor'];?>;<? } ?>
			<? if($form['buttonsBgColor'] != ''){ ?>background:#<?=$form['buttonsBgColor'];?>;<? } ?>
			<? if($form['buttonsBorderColor'] != ''){ ?>border:1px solid #<?=$form['buttonsBorderColor'];?>;<? } ?>
		<? } ?>
		<? if($form['buttonFontSize'] > 0){ ?>font-size:<?=$form['buttonFontSize'];?>px;<? } ?>
		<? if($form['buttonsTextColor'] != ''){ ?>color:#<?=$form['buttonsTextColor'];?>;<? } ?>
		vertical-align:middle;
		margin:0;
	}
	
	.formInput {
		<? if($form['inputWidth'] > 0){ ?>width:<?=($form['inputWidth']-6-$sel_plus);?>px;<? } ?>
		<? if($form['inputHeight'] > 0){ ?>height:<?=($form['inputHeight']-4);?>px;<? } ?>
		<? if($form['inputBgColor'] != ''){ ?>background:#<?=$form['inputBgColor'];?>;<? } ?>
		<? if($form['inputTextColor'] != ''){ ?>color:#<?=$form['inputTextColor'];?>;<? } ?>
		<? if($form['inputBorderColor'] != ''){ ?>border:1px solid #<?=$form['inputBorderColor'];?>;<? }
		else { ?>border:0;<? } ?>
		<? if($form['inputRoundedCorners'] == 1){ ?>border-radius:4px;<? } ?>
		font-size:inherit;
		font-family: inherit;
		<?=($form['placeholders'] == '1') ? 'margin-bottom:2px;' : '';?>
	}
	
	select.formInput {
		<? if($form['inputWidth'] > 0){ ?>width:<?=($form['inputWidth']+$sel_plus);?>px;<? } ?>
		<? if($form['inputHeight'] > 0){ ?>height:<?=($form['inputHeight']+$sel_plus);?>px;<? }
		else {?>height:22px;<?}?>
		
	}
	
	textarea.formInput {
		height:100px;
		overflow:auto;
	}
	
	#contact_layer{
		<? if($form['textColor'] != ''){ ?>color:#<?=$form['textColor'];?>;<? } ?>
		<? if($form['bgColor'] != ''){ ?>background:#<?=$form['bgColor'];?>;<? }
		elseif($form['borderColor'] == '') { ?>padding: 10px 0;<? } ?>
		<? if($form['borderColor'] != '' && $form['roundCorners'] == 0){ ?>border:1px solid #<?=$form['borderColor'];?>;<? } ?>
		<? if($form['inputWidth'] > 0){ ?>width:<?=($form['inputWidth']+$sel_plus);?>px;<? }
		else { ?>width:<?=(200+$sel_plus);?>px;<? } ?>
		<? if($form['textSize'] > 0){ ?>font-size:<?=$form['textSize'];?>px;<? } ?>
	}
	
	#contentForm .roundBox {
		<? if($form['inputWidth'] > 0){ ?>width:<?=($form['inputWidth']+20+$sel_plus);?>px;<? }
		else { ?>width:auto;<? } ?>
	}
	
	.formtitle {
		color:#<?=($form['textColor']) ? $form['textColor'] :$SITE[titlescolor];?>;
	}
	
</style>

<script type="text/javascript">
	
	var hasFiles = false;
	
	function submitSuccess() {
		<? if($form['successUrl'] != ''){ ?>document.location.href='<?=$SITE['media'];?>/<?=$form['successUrl'];?>';<? }
		elseif($form['successMsg'] != ''){ ?>jQuery('#succ_msg').fadeIn('fast').focus();jQuery('#contact_form')[0].reset();<? } ?>
	}
	
	
</script>
<div style="display:none"><iframe name="iframeFormTarget" id="iframeFormTarget"></iframe></div>
<div id="contentForm">
<div id="form_result"></div>
<? if ($form[roundCorners]==1) SetRoundedCorners(1,1,$form['bgColor']); ?>
<div id="contact_layer" align="<?=$SITE['align'];?>"> 
	<? if($form['formName'] != ''){ ?><div class="formtitle" style="font-size:<?=($form['titleSize'] > 0) ? $form['titleSize'] : '20';?>px;text-align:<?=$SITE['align']?>;padding-bottom:20px"><?=$form['formName']?></div><? } ?>
	<form id="contact_form" target="iframeFormTarget" name="contact_form" method="post" action="<?=$SITE['url'];?>/sendCustomForm.php" enctype="multipart/form-data" onsubmit="return submitForm(this);"> 
	<input type="hidden" name="formID" value="<?=$form['formID'];?>" />
	<input type="hidden" name="from_uri" value="<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI']);?>" />
	<div id="inputs">
 	<? foreach($inputs as $input){
 		$inputValuesArr = unserialize($input['inputValues']);
		$inputValues = '';
		if(is_array($inputValuesArr))
			foreach($inputValuesArr as &$inval)
			{
				$inval = stripslashes($inval);
				$inval = str_replace(array('&quot;'),'"',$inval);
				$inval = str_replace('&#039;',"׳",$inval);
				$inputValues .= $inval.'\n';
			}
		else
			$inputValues = ''; ?>
 	<div id="short_cell-<?=$input['inputID'];?>" style="<?=($form['inputBottomMargin'] > 0) ? 'margin-bottom:'.$form['inputBottomMargin'].'px;' : '';?>position:relative;">
 		<? if (isset($_SESSION['LOGGED_ADMIN']) && substr($input['inputID'],0,8) != 'question') {
			?>
			<img src="<?=$SITE['url'];?>/Admin/images/move_cat_icon.gif" class="movableB" />&nbsp;
			<?
			if ($SITE[formsEnabled] == 1 OR $MEMBER[UserType]==0)  { ?>
 		
 		<a href="#" onclick="editInput(<?=$input['inputID'];?>,'<?=str_replace(array("'",'"'),array("\'",'&quot;'),$input['inputName']);?>','<?=$input['inputType'];?>','<?=str_replace(array("'",'"'),array("\'",'&quot;'),$input['inputDefValue']);?>','<?=str_replace(array("'",'"'),array("\'",'&quot;'),$inputValues);?>','<?=str_replace(array("'",'"'),array("\'",'&quot;'),$input['mandatoryError']);?>','<?=$input['mandatory'];?>','<?=$input['boldLabel'];?>','<?=$input['isSenderMail'];?>',<?=$input['maxLength'];?>,<?=$input['minTableWidth'];?>,<?=$input['maxTableWidth'];?>);return false;"><img src="<?=$SITE[url];?>/Admin/images/editIcon_new.png" border="0" class="button" /></a>&nbsp;
 		<a href="#" onclick="delInput(<?=$input['inputID'];?>);return false;"><img class="button" src="<?=$SITE['url'];?>/Admin/images/delIcon_new.png" border="0" /></a>&nbsp;
 		<? if($input['inputType'] == 'select' || $input['inputType'] == 'radio'){ ?>
 		<a href="#" id="receiversLink<?=$input['inputID'];?>"><img src="<?=$SITE[url];?>/Admin/images/receiversIcon.png" border="0" class="button" /></a>&nbsp;&nbsp;
 		<script type="text/javascript">
 			jQuery('#receiversLink<?=$input['inputID'];?>').click(function(){
	 			editReceivers(<?=$input['inputID'];?>,<?=json_encode($inputValuesArr,JSON_HEX_QUOT | JSON_HEX_APOS);?>,<?=json_encode(unserialize($input['receivers']));?>);
	 			return false;
 			});
 		</script>
 		<? } 
 		if($input['inputType'] == 'title'){ ?>
 		<a href="#" onclick="editFreeText(<?=$input['inputID'];?>,'<?=str_replace(array(chr(10),chr(13)),'',htmlspecialchars($input['inputValues']));?>');return false;"><img src="<?=$SITE[url];?>/Admin/images/values.png" border="0" /></a>&nbsp;&nbsp;
 		<? } 
 		} } ?>
 		<?=(substr($input['inputID'],0,8) == 'question' && $form['placeholders'] == '1') ? '<small>('.$translations[$SITE_LANG['selected']]['anti_spam'].')</small><br/>' : '';?>
 		<label for="input_<?=$input['inputID'];?>" style="padding-top:3px;<?=($form['mandatoryTextColor'] != '' && $input['mandatory'] == 1) ? 'color:#'.$form['mandatoryTextColor'].';' : '';?><?=($form['placeholders'] == '1' && $input['inputType'] !='file' && $input['inputType'] !='hidden') ? 'display:none;' : '';?>"><?=(substr($input['inputID'],0,8) == 'question' && $form['placeholders'] != '1') ? '<small>('.$translations[$SITE_LANG['selected']]['anti_spam'].')</small><br/>' : '';?><?=($input['boldLabel'] == 1) ? '<b>' : '';?><?=($input['inputType'] != 'title' || isset($_SESSION['LOGGED_ADMIN'])) ? $input['inputName'] : '';?><?=($input['mandatory'] == 1) ? ' *' : '';?><?=($input['boldLabel'] == 1) ? '</b>' : '';?></label><? if($input['inputType'] == 'file'){ ?>&nbsp;&nbsp;<? } else { ?><?=($form['placeholders'] == '1' && !isset($_SESSION['LOGGED_ADMIN'])) ? '' : '<br/>';?><? } ?>
 		<? switch($input['inputType']){
 			case 'text':
 			default:
 				?><input alt="<?=$input['inputName'];?>" type="text" name="input_<?=$input['inputID'];?>" id="input_<?=$input['inputID'];?>" class="contact_frm_txt formInput<?=($input['inputType'] == 'date') ? ' customFormDate' : '';?>" aria-required="<?=($input['mandatory']==1) ? 'true' : 'false';?>" placeholder='<?=($form['placeholders'] == '1') ? ($input['mandatory']==1) ? '*'.$input['inputName'] : $input['inputName'] : $input['inputDefValue'];?>' autocomplete="off"<?=($input['maxLength'] > 0) ? ' maxlength="'.$input['maxLength'].'"' : '';?> /><?
 				if($input['inputType'] == 'date')
 				{
	 				?>
	 				<a href="#" onclick="jQuery('#input_<?=$input['inputID'];?>').datepicker('show');return false;" style="display:block;position:absolute;<?=$SITE[opalign];?>:5px;bottom:10px;"><img src="/images/calendar_icon.png" border="0"/></a>
	 				<?
 				}
 				break;
 			case 'title':
 				echo '<div>'.stripslashes($input['inputValues']).'</div>';
 				break;
 			case 'file':
 				?>
 				<span id="input_<?=$input['inputID'];?>" class="formFile" style="cursor:pointer"></span>
				<div class="fieldset flash" id="progress_input_<?=$input['inputID'];?>"></div>
				<input type="hidden" name="input_<?=$input['inputID'];?>" />
 				<script type="text/javascript">
 					hasFiles = true;
 				</script>
 				<?
 				break;
 			case 'textarea':
 				?><textarea alt="<?=$input['inputName'];?>" class="contact_frm_txt formInput" name="input_<?=$input['inputID'];?>" id="input_<?=$input['inputID'];?>" placeholder='<?=($form['placeholders'] == '1') ? ($input['mandatory']==1) ? '*'.$input['inputName'] : $input['inputName'] : $input['inputDefValue'];?>'<?=($input['maxLength'] > 0) ? ' maxlength="'.$input['maxLength'].'"' : '';?>></textarea><?
 				break;
 			case 'select':
 				?><select alt="<?=$input['inputName'];?>" class="formInput" name="input_<?=$input['inputID'];?>" id="input_<?=$input['inputID'];?>">
 				<option<?=($input['mandatory'] == 1) ? ' value="novalue"' : '';?>><?=$input['inputName'];?></option><?
 				foreach($inputValuesArr as $option)
 				{
 					echo '<option';
 					if($option == $input['inputDefValue'])
 						echo ' SELECTED';
 					echo '>'.stripslashes($option).'</option>';
 				}
 				?></select><?
 				break;
 			case 'radio':
 				?><div style="margin-<?=$SITE['align'];?>:-2px;<?=($form['placeholders'] == '1') ? 'margin-bottom:2px;' : '';?>"><?
 				foreach($inputValuesArr as $i => $option)
 				{
 					?><?=($form['inputALine'] == '1') ? '<div style="float:'.$SITE[align].';line-height:20px;vertical-align:middle;width:25px;">' : '<div style="float:'.$SITE[align].';line-height:20px;vertical-align:middle;white-space:nowrap;">';?><input alt="<?=$input['inputName'];?>" style="vertical-align:middle;" type="radio" name="input_<?=$input['inputID'];?>" value="<?=$option;?>" id="input_<?=$input['inputID'];?>_<?=$i;?>"<?=($input['inputDefValue'] == $option) ? ' CHECKED' : '';?> />&nbsp;<?=($form['inputALine'] == '1') ? '</div><div style="width:auto;margin-'.$SITE[align].':25px;line-height:20px;vertical-align:middle;">' : '';?><label for="input_<?=$input['inputID'];?>_<?=$i;?>"<?=($form['inputALine'] == '1') ? ' style="padding:0;display:inline-block;vertical-align:middle;margin-'.$SITE[align].':-2px;"' : '';?>><?=stripslashes($option);?></label><?=($form['inputALine'] == '1') ? '</div><div style="clear:both;"></div>' : '&nbsp;&nbsp;&nbsp;&nbsp;</div>';?><?
 				}
 				?>
 				<div style="clear:both;"></div>
 				</div>
 				<?
 				break;
 			case 'checkbox':
 				?><div style="margin-<?=$SITE['align'];?>:-2px;<?=($form['placeholders'] == '1') ? 'margin-bottom:2px;' : '';?>"><?
 				foreach($inputValuesArr as $i => $option)
 				{
 					?><?=($form['inputALine'] == '1') ? '<div style="float:'.$SITE[align].';line-height:20px;vertical-align:middle;width:25px;">' : '<div style="float:'.$SITE[align].';line-height:20px;vertical-align:middle;white-space:nowrap;">';?><input alt="<?=$input['inputName'];?>" style="vertical-align:middle;" type="checkbox" name="input_<?=$input['inputID'];?>[]" value="<?=$option;?>" id="input_<?=$input['inputID'];?>_<?=$i;?>"<?=($input['inputDefValue'] == $option) ? ' CHECKED' : '';?> />&nbsp;<?=($form['inputALine'] == '1') ? '</div><div style="width:auto;margin-'.$SITE[align].':25px;line-height:20px;vertical-align:middle;">' : '';?><label for="input_<?=$input['inputID'];?>_<?=$i;?>"<?=($form['inputALine'] == '1') ? ' style="padding:0;display:inline-block;margin-'.$SITE[align].':0px;vertical-align:middle"' : '';?>><?=$option;?></label><?=($form['inputALine'] == '1') ? '</div><div style="clear:both;"></div>' : '&nbsp;&nbsp;&nbsp;&nbsp;</div>';?><?
 				}
 				?>
 				<div style="clear:both;"></div>
 				</div>
 				<?
 				break;
 			case 'hidden':
 				?><input type="hidden" name="input_<?=$input['inputID'];?>" id="input_<?=$input['inputID'];?>" value="<?=$input['inputName'];?>" /><?
 				break;
 		} ?>
 	<div style="height:5px"></div> 
 	</div>
 	<? } ?>
 	</div>
 	<div style="position:relative;margin-<?=$SITE[opalign];?>:<?=$sel_plus;?>px">
		<table style="margin-top:<?=($form['placeholders'] == '1') ? '0px' : '5px';?>;border:0px;" width="100%" cellpadding="0" cellspacing="0"> 
			<tr> 
				<? if($form['clearText'] != ''){ ?>
				<td align="<?=$SITE['align'];?>" style="height:30px;">
					<input type="reset" value="<?=$form['clearText'];?>" class="frm_button" style="margin-<?=$SITE['align'];?>:2px;" />
				</td>
				<? } ?> 
				<td align="<?=($form['clearText'] != '') ? $SITE[opalign] : $SITE['align'];?>" style="height:30px;">
					<input type="submit" value="<?=$form['sendText'];?>" class="frm_button" alt="שלח פנייתך" />
				</td>
			</tr> 
		</table>
	</div>
	</form>
	<div id="succ_msg" style="display:none;margin-top:10px;">
	<center>
	<? if($form['successMsg'] != '') { ?><div style="padding:10px;<? if($form['inputBgColor'] != ''){ ?>background:#<?=$form['inputBgColor'];?>;<? } ?><? if($form['inputTextColor'] != ''){ ?>color:#<?=$form['inputTextColor'];?>;<? } ?><? if($form['textSize'] > 0){ ?>font-size:<?=$form['textSize'];?>px;<? } ?>font-weight:bold;"><?=$form['successMsg'];?></div><? } ?>
	</center>
	</div>  
</div>
<script type="text/javascript">
	jQuery(function(){
		jQuery('.customFormDate').datepicker({'dateFormat':'dd.mm.yy'});
		jQuery('.customFormDate').each(function(){
			var ptop = Math.round((jQuery(this).outerHeight()-20)/2);
			if(ptop < 0)
				ptop = 0;
			jQuery(this).next().css('bottom',(ptop+8)+'px');
		});
	});
</script>
<? if ($form[roundCorners]==1) SetRoundedCorners(0,1,$form['bgColor']); ?>
</div>
<? if (!isset($_SESSION['LOGGED_ADMIN'])) { ?>
<link href="<?=$SITE[url];?>/css/uploader/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.queue.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/fileprogress.js"></script>
<? } ?>
<script type="text/javascript" src="<?=$SITE[url];?>/js/formHandlers.js"></script>
<script type="text/javascript">
var siteURL = '<?=$SITE[url];?>';
var inputTextColor = '<?=$form['inputTextColor'];?>';
var waitForSendLabel='<?=$translations[$SITE_LANG['selected']]['please_wait'];?>';
</script>
<script type="text/javascript" src="<?=$SITE[url];?>/js/customFormFile.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/js/placeholder.js"></script>
<? if(!isset($_SESSION['LOGGED_ADMIN'])) { ?>
<script type="text/javascript">
	jQuery(function(){
		Placeholder.init({normal:"#<?=$form['inputTextColor'];?>"});
	});
</script>
<? } ?>
<? if(isset($_SESSION['LOGGED_ADMIN'])) { ?>
<? if($form['saveFormData'] == 1){ ?>
	<div style="margin:10px;"><a href="/Admin/#formHistoryAdmin?formID=<?=$form['formID'];?>" style="font-weight:bold;color:#<?=$SITE[linkscolor];?>" target="_blank"><?=$ADMIN_TRANS['view form history'];?></a></div>
<? } ?>
<script type="text/javascript">
var embed_backup = '';
		jQuery(function() {
			jQuery("#inputs").sortable({
		   		update: function(event, ui) {
		   			saveInputsOrder(jQuery("#inputs").sortable('serialize'));
		   		},
		   		scroll:false,
		   		handle : '.movableB'
			});
			
			embed_backup = jQuery('#embed_code_txt').val();
			generate_embed();
			Placeholder.init({normal:"#<?=$form['inputTextColor'];?>"});
		});
		
		<?
		
		$def_hori_height = 30;
		if($form['inputHeight'] > 0)
			$def_hori_height = $form['inputHeight']+14;
		if($form['inputBorderColor'] != '')
			$def_hori_height += 2;
		if($form['bgColor'] != '' || $form['borderColor'] != '')
			$def_hori_height += 10;
		if($form['successMsg']!='')
		{
			if($form['textSize'] > 0)
				$def_hori_height += $form['textSize'] + 6;
			else
				$def_hori_height += 17;
		}
		
		
		?>
		
		function generate_embed() {
			jQuery('#succ_msg').show();
			width = jQuery('#contact_layer').width()<? if($form['bgColor'] != '' || $form['borderColor'] != ''){ ?>+20<? } ?>;
			height = jQuery('#contact_layer').height()+50<? if($form[roundCorners]==1){ ?>+14<? } ?>;
			hori = '';
			jQuery('#succ_msg').hide();
			if(jQuery('input[name=embed_hori]:checked').val() == '1')
			{
				width = '100%';
				height = '<?=$def_hori_height;?>';
				hori = '&horizontal=1';
			}
			jQuery('#embed_code_txt').val(embed_backup.replace('%WIDTH%',width).replace('%HEIGHT%',height).replace('%HORI%',hori));
		}
</script>
<div id="embed_code">
<br/><b><?=$ADMIN_TRANS['if you want to paste this form to another content page, please copy this code and paste it in the destination page source'];?>:</b><br/><br/>
<input type="radio" name="embed_hori" id="embed_hori_0" onclick="generate_embed()" value="0" CHECKED />&nbsp;<label for="embed_hori_0"><?=$ADMIN_TRANS['embed vertically'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="embed_hori" id="embed_hori_1" onclick="generate_embed()" value="1" />&nbsp;<label for="embed_hori_1"><?=$ADMIN_TRANS['embed horizontally'];?></label><br/>
<div id="d_clip_container_form" style="position:relative;margin-top:2px">
	<div id="d_clip_button_form" class="my_clip_button_news_form"><b id="bef_copy_form"><?=$ADMIN_TRANS['copy code to clipboard'];?></b><b id="af_copy_form" style="display:none"><?=$ADMIN_TRANS['copied! now you can paste and embed it in rich text content editor'];?></b></div>
</div>
<br/>
<div><?=$ADMIN_TRANS['source html code'];?></div>

<textarea style="height:50px;"  readonly="readonly" id="embed_code_txt"><iframe id="iframe_form_<?=$form['formID'];?>" width="%WIDTH%" height="%HEIGHT%" src="/iframeCustomForm.php?formID=<?=$form['formID'];?>%HORI%" border="0" frameborder="0" scrolling="no" allowTransparency="true"></iframe></textarea>


<script type="text/javascript" src="/js/zeroclipboard/ZeroClipboard.js"></script>
<script language="JavaScript">
	var clip = null;
	ZeroClipboard.setMoviePath('/js/zeroclipboard/ZeroClipboard10.swf');	
	jQuery(function() {
		clip = new ZeroClipboard.Client();
		clip.setHandCursor( true );
		clip.addEventListener('mouseOver', function (client) {
			clip.setText( jQuery('#embed_code_txt').val() );
		});
		clip.addEventListener('complete', function (client, text) {
			jQuery('#bef_copy_form').hide();
			jQuery('#af_copy_form').show();
			setTimeout(function(){
				jQuery('#af_copy_form').hide();
				jQuery('#bef_copy_form').show();
			}, 3000);
		});
		clip.glue( 'd_clip_button_form', 'd_clip_container_form' );
	});
	
	
	
	
</script>
</div>
<? } ?>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<div style="height:10px;"></div>
	&nbsp;&nbsp;
	<div id="newSaveIcon"  onclick="EditTopBottomContent('bottomShortContent');"><i class="fa fa-pencil-square-o"></i> <?=$ADMIN_TRANS['edit bottom content'];?></div>
	&nbsp;&nbsp;<span style="display:none" id="saveGalButton_bottom"><div style="display:" id="newSaveIcon" onclick="saveTopContent(1)"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save changes'];?></div></span>
	<span style="display:none" id="closeGalButton_bottom"><div style="display:" id="newSaveIcon" onclick="cancel(1)"><img src="<?=$SITE[url];?>/Admin/images/close_icon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['cancel'];?></div></span>
	<div style="height:5px"></div>
	
		<?
	}
?>
<div id="bottomShortContent" style="padding-<?=$SITE[align];?>:10px;padding-<?=$SITE[opalign];?>:5px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=$P_CONTENT_BOTTOM[Content];?></div>