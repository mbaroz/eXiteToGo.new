<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");

if(!isset($_GET['formID']) || $_GET['formID'] < 1)
	die;

if(isset($_GET['lang']))
{
	session_start();
	session_unregister('SITE_LANG');
	$SITE_LANG = array('selected' => substr(urlencode($_GET['lang']),0,2));
}

include_once("config.inc.php");
include_once("round_corners.inc.php");
if ($SITE_LANG[selected]=="he" OR $SITE_LANG[selected]=="ar") {
	$SITE[align]="right";
	$SITE[opalign]="left";
}
else {
	$SITE[align]="left";
	$SITE[opalign]="right";
}
$db = new database();
require_once('inc/GetServerData.inc.php');
require_once('inc/CustomForm.inc.php');

if(!$form = getFormByID($_GET['formID']))
	die;
	
$antiSpamSys = ($form['antiSpam'] == '1');

$urlKey = HaveUrlKey($form['catID']);

$fields_border_css=$buttons_css="border:0px;";
if ($SITE[fontface]!="Arial") $font_size=11;
if ($SITE[formfieldsborder]) $fields_border_css="border:1px solid #".$SITE[formfieldsborder].";";
if ($SITE[formbuttonsborder]) $buttons_css="border:1px solid #".$SITE[formbuttonsborder].";";

if($form['bgColor'] == '')
	$form['roundCorners'] = 0;

$hori = isset($_GET['horizontal']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;  charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=$SITE['url'];?>/css/styles.css.php?urlKey=home" />
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<link href="<?=$SITE[url];?>/css/uploader/default.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/css/he_fonts.css">
		<script language="JavaScript" type="text/javascript" src="<?=$SITE['url'];?>/js/gallery/jquery-1.7.2.min.js"></script>
		<script language="JavaScript" type="text/javascript" src="<?=$SITE['url'];?>/js/gallery/jquery-ui-1.8.20.custom.min.js"></script>
		<script type="text/javascript" src="<?=$SITE[url];?>/js/placeholder.js"></script>
	</head>
	<body style="direction:<?=($SITE['align']=='right') ? 'rtl' : 'ltr';?>;background:none;padding:0;margin:0;">
		<style type="text/css"> 
		#contact_layer {
			color:#<?=$SITE[contenttextcolor];?>;
			font-size:13px;
			text-align:<?=$SITE['align'];?>;
			padding:<? if($hori){
							if($form[roundCorners]==1) echo '2px 7px 0 7px';
							else echo '7px';
						}else echo '10px';?>;
		}
		
		#contact_layer label {
			display: inline-block;
			<?=($hori) ? 'padding-bottom:0;' : 'padding-bottom:5px;';?>
		}
		
		#contentForm .roundBox {
			width:auto;
			margin-<?=$SITE[opalign];?>:1px;
		}
		
		#contentForm .round_bottom {
			display: none;
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
			vertical-align:middle;
			
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
		.progressWrapper .progressContainer .progressName, .progressWrapper .progressContainer .progressBarStatus  {
			width:auto;
		}
		.progressWrapper {
			<? if(!$hori){ ?>width: 220px !important;<? }
			else { ?>width:auto;float:<?=$SITE[align];?>;<? } ?>
		}
		
		div.flash {
			<? if(!$hori){ ?>width: 220px;<? }
			else { ?>width:auto;float:<?=$SITE[align];?>;margin:0;<? } ?>
		}
		
		<? if($hori){ ?>
		.progressContainer {
			margin: 5px 0 0;
			width:63px;
		}
		<? } ?>
		</style> 
		
		<?
		
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
		
		$sel_plus = 0;
		if($form['inputBorderColor'] != '')
			$sel_plus = 2;
			
		if($form['submitHeight'] ==0) $form['submitHeight']=20;
			
		$input_minus = 6;
		if($form['inputBorderColor'] != '')
			$input_minus = 8;
		
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
						if($form['submitWidth'] >= $form['inputWidth'] && !$hori){
							?>width:<?=$form['submitWidth'];?>px;<?
						}
						else
						{
							?>
							min-width:<?=$form['submitWidth'];?>px;
							<? if(!$hori){ ?>max-width:<?=$form['inputWidth'];?>px;<? } ?>
							<?
						}
					} ?>
					<? if($form['submitHeight'] > 0){ ?>min-height:<?=$form['submitHeight'];?>px;<? } ?>
					<? if($form['buttonsRoundCorners'] == 1){ ?>border-radius:<?=round($form['submitHeight']/5);?>px;<? } ?>
					<? if($form['buttonsBgColor'] != ''){ ?>background:#<?=$form['buttonsBgColor'];?>;<? } ?>
					<? if($form['buttonsBorderColor'] != ''){ ?>border:1px solid #<?=$form['buttonsBorderColor'];?>;<? } ?>
				<? } ?>
				<? if($form['buttonFontSize'] > 0){ ?>font-size:<?=$form['buttonFontSize'];?>px;<? } ?>
				<? if($form['buttonsTextColor'] != ''){ ?>color:#<?=$form['buttonsTextColor'];?>;<? } ?>
				vertical-align:middle;
				margin:0;
			}
			
			.formInput {
				width:<?=($hori) ? ($form['inputWidth']-6).'px' : '100%';?>;
				<? if($form['inputHeight'] > 0){ ?>height:<?=($form['inputHeight']-4);?>px;<? } ?>
				<? if($form['inputBgColor'] != ''){ ?>background:#<?=$form['inputBgColor'];?>;<? } ?>
				<? if($form['inputTextColor'] != ''){ ?>color:#<?=$form['inputTextColor'];?>;<? } ?>
				<? if($form['inputBorderColor'] != ''){ ?>border:1px solid #<?=$form['inputBorderColor'];?>;<? }
				else { ?>border:0;<? } ?>
				<? if($form['inputRoundedCorners'] == 1){ ?>border-radius:4px;<? } ?>
				font-size:inherit;
				font-family: Arial;
				<?=($form['placeholders'] == '1') ? 'margin-bottom:2px;' : '';?>
			}
	
			select.formInput {
				<? if($form['inputHeight'] > 0){ ?>height:<?=($form['inputHeight']+$sel_plus);?>px;<? } ?>
				vertical-align:middle;
			}
						
			textarea.formInput {
				height:100px;
				overflow:auto;
			}
			
			#contact_layer{
				<? if($form['textColor'] != ''){ ?>color:#<?=$form['textColor'];?>;<? } ?>
				<? if($form['bgColor'] != ''){ ?>background:#<?=$form['bgColor'];?>;<? }
				elseif($hori && $form[roundCorners]!=1 && $form['borderColor'] == '') { ?>padding: 7px 0;<? }
				elseif($form['borderColor'] == '') { ?>padding:0;<? } ?>
				margin-<?=$SITE['opalign'];?>:1px;
				<? if($form['borderColor'] != '' && $form['roundCorners'] == 0){ ?>border:1px solid #<?=$form['borderColor'];?>;<? } ?>
				<? if($form['textSize'] > 0){ ?>font-size:<?=$form['textSize'];?>px;<? } ?>
			}
			.formtitle {
				color:#<?=($form['textColor']) ? $form['textColor'] :$SITE[titlescolor];?>;
			}
		</style>
		<script type="text/javascript">
			var hasFiles = false;
	
			function submitSuccess() {
				<? if($form['successUrl'] != ''){ ?>window.top.location.href='<?=$SITE['media'];?>/<?=$form['successUrl'];?>';<? }
				elseif($form['successMsg'] != ''){ ?>jQuery('#succ_msg').fadeIn('fast');jQuery('#contact_form')[0].reset();<? } ?>
			}
			
			jQuery(function(){
				jQuery('input.formInput').width((jQuery('input.formInput').width()-<?=$input_minus;?>)+'px');
				jQuery('textarea.formInput').width((jQuery('textarea.formInput').width()-<?=$input_minus;?>)+'px');
				<? //if($hori) { ?>
				jQuery('#succ_msg').show();
				//this_frame = parent.document.getElementById('iframe_form_<?=$form['formID'];?>');
				//jQuery(this_frame).height(jQuery('body').height());
				jQuery('#succ_msg').hide();
				<? //} ?>
			});
			
			
		</script>
		<script type="text/javascript">
			jQuery(function(){
				jQuery('.customFormDate').datepicker({'dateFormat':'dd.mm.yy'});
				jQuery('.customFormDate').each(function(){
					var ptop = Math.round((jQuery(this).outerHeight()-20)/2);
					if(ptop < 0)
						ptop = 0;
					jQuery(this).next().css('bottom',(ptop<?=(!$hori) ? '+8' : '';?>)+'px');
				});
			});
		</script>
		<div style="display:none">
			<iframe name="saveFormFrame" id="saveFormFrame"></iframe>
		</div>
		<div id="contentForm">
		<div id="form_result"></div>
		<? if ($form[roundCorners]==1) SetRoundedCorners(1,1,$form['bgColor']); ?>
		<div id="contact_layer" align="<?=$SITE['align'];?>"> 
			<? if($form['formName'] != ''){ ?><div class="formtitle" style="font-size:<?=($form['titleSize'] > 0) ? $form['titleSize'] : '20';?>px;text-align:<?=$SITE['align']?>;padding-bottom:20px"><?=$form['formName']?></div><? } ?>
			<form id="contact_form" target="saveFormFrame" name="contact_form" method="post" enctype="multipart/form-data" action="<?=$SITE['url'];?>/sendCustomForm.php" onsubmit="return submitForm(this);"> 
			<input type="hidden" name="from_uri" value="<?=urlencode($_SERVER['HTTP_REFERER']);?>" />
			<input type="hidden" name="formID" value="<?=$form['formID'];?>" />
			<input type="hidden" name="sentIframe" id="sentIframe" value="0" />
			<? if(!$hori){ ?>
			<div id="inputs">
			<? }
		 	foreach($inputs as $input){
		 		$inputValuesArr = unserialize($input['inputValues']);
				$inputValues = '';
				if(is_array($inputValuesArr))
					foreach($inputValuesArr as &$inval)
					{
						$inval = str_replace(array('\"','\&quot;'),'"',$inval);
						$inputValues .= $inval.'\n';
					}
				else
					$inputValues = ''; ?>
		 	<? $br = '&nbsp;';
		 	if(!$hori){
			 	$br = '<br/>';
		 	 ?>
		 		<div style="<?=($form['inputBottomMargin'] > 0) ? 'margin-bottom:'.$form['inputBottomMargin'].'px;' : '';?>position:relative;">
		 		<? } ?>
		 		<?=(substr($input['inputID'],0,8) == 'question' && !$hori && $form['placeholders'] == '1') ? '<small>('.$translations[$SITE_LANG['selected']]['anti_spam'].')</small>'.$br : '';?>
		 		<label for="input_<?=$input['inputID'];?>" style="<?=($hori) ? 'vertical-align:middle' : 'padding-top:3px';?>;<?=($form['mandatoryTextColor'] != '' && $input['mandatory'] == 1) ? 'color:#'.$form['mandatoryTextColor'].';' : '';?><?=($form['placeholders'] == '1' && $input['inputType'] !='file' && $input['inputType'] !='hidden') ? 'display:none;' : '';?>"><?=(substr($input['inputID'],0,8) == 'question' && !$hori && $form['placeholders'] != '1') ? '<small>('.$translations[$SITE_LANG['selected']]['anti_spam'].')</small>'.$br : '';?><?=($input['boldLabel'] == 1) ? '<b>' : '';?><?=($input['inputType'] != 'title' || isset($_SESSION['LOGGED_ADMIN'])) ? $input['inputName'] : '';?><?=($input['mandatory'] == 1) ? ' *' : '';?><?=($input['boldLabel'] == 1) ? '</b>' : '';?></label><? if($input['inputType'] == 'file'){ ?>&nbsp;&nbsp;<? } else { ?><?=($hori || $form['placeholders'] == '1') ? '' : '<br/>';?><? } ?>
		 		<? switch($input['inputType']){
		 			case 'text':
		 			default:
		 				if($hori && $input['inputType'] == 'date'){
			 				?>
			 				<span style="position:relative;">
			 				<?
		 				}
		 				?><input alt="<?=$input['inputName'];?>" type="text" name="input_<?=$input['inputID'];?>" id="input_<?=$input['inputID'];?>" class="contact_frm_txt formInput<?=($input['inputType'] == 'date') ? ' customFormDate' : '';?>" aria-required="<?=($input['mandatory']==1) ? 'true' : 'false';?>" placeholder='<?=($form['placeholders'] == '1') ? ($input['mandatory']==1) ? '*'.$input['inputName'] : $input['inputName'] : $input['inputDefValue'];?>' autocomplete="off" /><?
		 				if($input['inputType'] == 'date')
		 				{
			 				?>
			 				<a href="#" onclick="jQuery('#input_<?=$input['inputID'];?>').datepicker('show');return false;" style="display:block;position:absolute;<?=$SITE[opalign];?>:5px;bottom:<?=($hori) ? '0' : '10';?>px;"><img src="/images/calendar_icon.png" border="0" /></a>
			 				<?
			 				if($hori){
				 				?></span><?
			 				}
		 				}
		 				break;
		 			case 'title':
		 				echo '<div>'.stripslashes($input['inputValues']).'</div>';
		 				break;
		 			case 'file':
				 		?>
				 		<? if ($hori) { ?>
				 		<div style="display:inline-block;width:90px;vertical-align:top">
				 		<? } ?>
		 				<span id="input_<?=$input['inputID'];?>" class="formFile" style="cursor:pointer"></span>
						<div class="fieldset flash" id="progress_input_<?=$input['inputID'];?>"></div>
						<input type="hidden" name="input_<?=$input['inputID'];?>" />
		 				<script type="text/javascript">
		 					hasFiles = true;
		 				</script>
		 				<? if ($hori) { ?>
				 		</div>
				 		<? } ?>
		 				<?
		 				break;
		 			case 'textarea':
		 				?><textarea alt="<?=$input['inputName'];?>" class="contact_frm_txt formInput" name="input_<?=$input['inputID'];?>" id="input_<?=$input['inputID'];?>" placeholder='<?=($form['placeholders'] == '1') ? ($input['mandatory']==1) ? '*'.$input['inputName'] : $input['inputName'] : $input['inputDefValue'];?>'></textarea><?
		 				break;
		 			case 'select':
		 				?><select alt="<?=$input['inputName'];?>" class="formInput" name="input_<?=$input['inputID'];?>" id="input_<?=$input['inputID'];?>">
		 				<option<?=($input['mandatory'] == 1) ? ' value="novalue"' : '';?>><?=$input['inputName'];?></option><?
		 				foreach($inputValuesArr as $option)
		 				{
		 					echo '<option';
		 					if($option == $input['inputDefValue'])
		 						echo ' SELECTED';
		 					echo '>'.$option.'</option>';
		 				}
		 				?></select><?
		 				break;
		 			case 'radio':
		 				if(!$hori){
		 					?><div style="margin-<?=$SITE['align'];?>:-2px;<?=($form['placeholders'] == '1') ? 'margin-bottom:2px;' : '';?>"><?
		 				}
		 				foreach($inputValuesArr as $i => $option)
		 				{
		 					?><?=($form['inputALine'] == '1' && !$hori) ? '<div style="float:'.$SITE[align].';line-height:20px;vertical-align:middle;width:25px;">' : '<div style="float:'.$SITE[align].';line-height:20px;vertical-align:middle;white-space:nowrap">';?><input alt="<?=$input['inputName'];?>" style="vertical-align:middle;" type="radio" name="input_<?=$input['inputID'];?>" value="<?=$option;?>" id="input_<?=$input['inputID'];?>_<?=$i;?>"<?=($input['inputDefValue'] == $option) ? ' CHECKED' : '';?> />&nbsp;<?=($form['inputALine'] == '1' && !$hori) ? '</div><div style="width:auto;margin-'.$SITE[align].':25px;line-height:20px;vertical-align:middle;">' : '';?><label<?=($form['inputALine'] == '1' && !$hori) ? ' style="padding:0;display:inline-block;vertical-align:middle;margin-'.$SITE[align].':-2px;"' : '';?> for="input_<?=$input['inputID'];?>_<?=$i;?>"><?=$option;?></label><?=($form['inputALine'] == '1' && !$hori) ? '</div><div style="clear:both;"></div>' : '&nbsp;&nbsp;&nbsp;&nbsp;</div>';?><?
		 				}
		 				if(!$hori) {
		 					?>
		 					<div style="clear:both;"></div>
		 					</div>
		 					<?
		 				}
		 				break;
		 			case 'checkbox':
		 				if(!$hori) {
		 					?><div style="margin-<?=$SITE['align'];?>:-2px;<?=($form['placeholders'] == '1') ? 'margin-bottom:2px;' : '';?>"><?
		 				}
		 				foreach($inputValuesArr as $i => $option)
		 				{
		 					?><?=($form['inputALine'] == '1' && !$hori) ? '<div style="float:'.$SITE[align].';line-height:20px;vertical-align:middle;width:25px;">' : '<div style="float:'.$SITE[align].';line-height:20px;vertical-align:middle;white-space:nowrap">';?><input alt="<?=$input['inputName'];?>" style="vertical-align:middle;" type="checkbox" name="input_<?=$input['inputID'];?>[]" value="<?=$option;?>" id="input_<?=$input['inputID'];?>_<?=$i;?>"<?=($input['inputDefValue'] == $option) ? ' CHECKED' : '';?> />&nbsp;<?=($form['inputALine'] == '1' && !$hori) ? '</div><div style="width:auto;margin-'.$SITE[align].':25px;line-height:20px;vertical-align:middle;">' : '';?><label<?=($form['inputALine'] == '1' && !$hori) ? ' style="padding:0;display:inline-block;vertical-align:middle;margin-'.$SITE[align].':0px;"' : '';?> for="input_<?=$input['inputID'];?>_<?=$i;?>"><?=$option;?></label><?=($form['inputALine'] == '1' && !$hori) ? '</div><div style="clear:both;"></div>' : '&nbsp;&nbsp;&nbsp;&nbsp;</div>';?><?
		 				}
		 				if(!$hori) {
		 					?>
		 					<div style="clear:both;"></div>
		 					</div>
		 					<?
		 				}
		 				break;
		 			case 'hidden':
		 				?><input type="hidden" name="input_<?=$input['inputID'];?>" id="input_<?=$input['inputID'];?>" value="<?=$input['inputName'];?>" /><?
		 				break;
		 		}
			 	if(!$hori) {
				 	?><div style="height:5px"></div> 
				 	</div><?
			 	}
			 	else {
			 		?>&nbsp;&nbsp;<?
			 	}
		 	} 
		 	if(!$hori) { ?>
		 	</div>
		 	<div>
			<table style="margin-top:<?=($form['placeholders'] == '1') ? '0px' : '5px';?>;border:0px;" width="100%" cellpadding="0" cellspacing="0"> 
			<tr>
			<? } ?>
			<?
			if($form['clearText'] != ''){ 
				if(!$hori){ ?>
					<td align="<?=$SITE['align'];?>" style="height:30px;">
				<? } ?>
				<input type="reset" value="<?=$form['clearText'];?>" class="frm_button" />
				<? if(!$hori){ ?>
					</td> 
					<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<? }
			}
			if(!$hori){ ?>
			<td align="<?=($form['clearText'] != '') ? $SITE[opalign] : $SITE['align'];?>" style="height:30px;">
			<? } ?>
			<input type="submit" value="<?=$form['sendText'];?>" class="frm_button" alt="שלח פנייתך" />
			<? if(!$hori){ ?>
			</td>
			<? }
			/* if($form['clearText'] != ''){ 
				if(!$hori){ ?>
					<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="<?=$SITE['align'];?>" style="height:30px;">
				<? } ?>
				<input type="reset" value="<?=$form['clearText'];?>" class="frm_button" />
				<? if(!$hori){ ?>
					</td> 
				<? }
			} */
			if(!$hori) { ?>
			</tr> 
			</table>
			</div>
			<? } ?>
			</form> 
			<div id="succ_msg" style="display:none;margin-top:2px;">
			<center>
			<? if($form['successMsg'] != '') { ?><div style="padding:2px;<? if($form['inputBgColor'] != ''){ ?>background:#<?=$form['inputBgColor'];?>;<? } ?><? if($form['inputTextColor'] != ''){ ?>color:#<?=$form['inputTextColor'];?>;<? } ?><? if($form['textSize'] > 0){ ?>font-size:<?=$form['textSize'];?>px;<? } ?>font-weight:bold;"><?=$form['successMsg'];?></div><? } ?>
			</center>
			</div>  
		</div>
		<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.js"></script>
		<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/swfupload.queue.js"></script>
		<script type="text/javascript" src="<?=$SITE[url];?>/Admin/uploader/fileprogress.js"></script>
		<script type="text/javascript" src="<?=$SITE[url];?>/js/formHandlers.js"></script>
		<script type="text/javascript">
		var siteURL = '<?=$SITE[url];?>';
		var inputTextColor = '<?=$form['inputTextColor'];?>';
		var waitForSendLabel='<?=$translations[$SITE_LANG['selected']]['please_wait'];?>';
		</script>
		<script type="text/javascript" src="<?=$SITE[url];?>/js/customFormFile.js"></script>
		<script type="text/javascript">
			var but_width = 0;
			jQuery(function(){
				
				but_width = parseInt(jQuery('#contact_form .frm_button').first().css('min-width').replace('px',''));
				but_width2 = jQuery('#contact_form .frm_button').first().width();
				if(jQuery('#contact_form').width() < but_width || jQuery('#contact_form').width() < but_width2)
				{
					jQuery('#contact_form .frm_button').width(jQuery('#contact_form').width());
					jQuery('#contact_form .frm_button').css('min-width',(jQuery('#contact_form').width()-1)+'px');
				}
				Placeholder.init({normal:"#<?=$form['inputTextColor'];?>"});
			});
		</script>
		<? if ($form[roundCorners]==1) SetRoundedCorners(0,1,$form['bgColor']); ?>
		</div>
				<? if (isset($_SESSION['LOGGED_ADMIN'])){ 
				$target_url=$SITE[media]."/category/".$urlKey;
				if ($urlKey=="") $target_url=$SITE[media];
				?>
			
			<div class="mainContentText"><a href="<?=$target_url;?>" target="_top"><?=$ADMIN_TRANS['go to form settings page'];?></a></div>
		<? } ?>
		<?
		if(file_exists('sites/'.$SITE['S3_FOLDER'].'/iframeCustomFormAddition.php'))
			{
				require_once('sites/'.$SITE['S3_FOLDER'].'/iframeCustomFormAddition.php');
			}
		?>
	</body>
</html>