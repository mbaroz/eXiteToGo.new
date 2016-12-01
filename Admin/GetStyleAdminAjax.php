<?
session_start();
if (!isset($_SESSION['LOGGED_ADMIN'])) die();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
switch ($_POST['action']) {
	case 'saveTextLogo':
	$db=new Database();
	if ($_POST['logoText']) {
		$CHK_LOGO=explode(".",$SITE[logo]);
		$backupVAL=array("logoheight"=>$SITE[logoheight],"logowidth"=>$SITE[logowidth],"logoimagename"=>$SITE[logo]);
		$backupVAL_JSON=json_encode($backupVAL);
		if ($CHK_LOGO[1]=="png" OR $CHK_LOGO[1]=="jpg") $db->query("UPDATE config set VarValue='{$backupVAL_JSON}' WHERE VarName='SITE[logo_image_name]'");
		$db->query("UPDATE config set VarValue='{$_POST['logoText']}' WHERE VarName='SITE[logo]'");
		$db->query("UPDATE config set VarValue='{$_POST['logoW']}' WHERE VarName='SITE[logowidth]'");
		$db->query("UPDATE config set VarValue='{$_POST['logoH']}' WHERE VarName='SITE[logoheight]'");

	}
	die();
	break;
	default:
	break;
}
$CHK_LOGO=explode(".",$SITE[logo]);
	if (!strtolower($CHK_LOGO[1])=="jpg" AND !strtolower($CHK_LOGO[1])=="png") {
		$text_inLogo=$SITE[logo];
	}


?>

<style type="text/css">
#UploadToolsDiv{width:550px !important;font-family: almoni-dl-aaa-400}
#photo_text_pic{padding:5px;border:1px solid silver;font-family: arial;font-size:14px;outline: none}
#PhotoSizeLabel{display: none}
.logo_styling{width:535px;height:40px;cursor: pointer;background-color: transparent;box-shadow: 0px 2px 10px silver;font-size:14px;margin-bottom: 5px}
.logo_styling .tabs {color:#333;width:50%;padding:13px;background-color: white;float:right;margin:0px;box-sizing:border-box;line-height: 10px}
.logo_styling .tabs.selected,.logo_styling .tabs:hover {background-color: #5080C7;color:white;}
.logo_text_div {width:100%;height:140px;line-height:110px;text-align:center;background-color: #ffffee;display: none;margin-bottom: 10px;padding: 10px;font-size:36px;box-sizing:border-box;}
.logotextSaveBut{display: none;float:right;margin-bottom: 20px}
.fakeLogoText{font-size:36px;display: none}
.ui-slider.ui-slider-horizontal {height:2px;background-color:#333;background-image:none;}
.ui-widget-content.ui-slider-horizontal {border:0px;}
a.ui-slider-handle.ui-corner-all {top:-0.5em;outline:none;border-bottom-right-radius:0;border-bottom-left-radius:0;border-top-left-radius:0;border-top-right-radius:0;width:14px;height:14px;border-radius: 100%;background-image:none;background-color: #333;}
</style>
<?
$ADMIN_TRANS['logo_text'][en]="Textual Logo";
$ADMIN_TRANS['logo_image'][en]="Logo Image";
$ADMIN_TRANS['logo_top_margin'][en]="Logo top margin";

$ADMIN_TRANS['logo_text'][he]="לוגו טקסטואלי";
$ADMIN_TRANS['logo_image'][he]="הצג לוגו תמונה";
$ADMIN_TRANS['logo_top_margin'][he]="מרווח עליון ללוגו";
$dynamicDecrease=910;
if ($SITE[sitewidth]>950) $dynamicDecrease=$SITE[sitewidth]-40;
switch ($_GET['type']) {
	case 'logo':
		?>

		<div class="logo_styling">
			<div class="tabs selected upload_logo_pic"><?=$ADMIN_TRANS['logo_image'][$SITE_LANG[selected]];?></div>
			<div class="tabs text_logo"><?=$ADMIN_TRANS['logo_text'][$SITE_LANG[selected]];?></div>
			
		</div>

		<div id="logoTextEditor" class="logo_text_div" contenteditable="true" onkeyup="updateLogoNow(this);" onmouseup="updateLogoNow(this);"><?=$text_inLogo;?></div>
		<div class="clear"></div>
		<div style="" class="fakeLogoText"></div>
		<div id="logo_height_label" style="display:none;width:200px;float:left;margin-top:10px">
			<?=$ADMIN_TRANS['logo_top_margin'][$SITE_LANG[selected]];?>:<br><div id="logo_height_slider"></div>
		</div>
		<div style="clear:both;height:10px"></div>
		<div id="newSaveIcon" class="logotextSaveBut greenSave" style="display:none"><i class="fa fa-save"></i> <?=$ADMIN_TRANS['save changes'];?></div>
		<div id="newSaveIcon" class="logotextSaveButCancel cancel" style="display:none"><?=$ADMIN_TRANS['cancel'];?></div>

		<script type="text/javascript">
			var editorInlneIsinitieted=false;
			jQuery(".logo_styling .tabs").click(function(){jQuery(".logo_styling .tabs").removeClass("selected");jQuery(this).toggleClass("selected");});
			jQuery(".logo_styling .tabs.text_logo").click(function(){
				jQuery("form#HeaderPicUpload").hide();
				jQuery(".logo_text_div").show();
				jQuery(".logotextSaveBut, #logo_height_label, .logotextSaveButCancel").show();
					

			});
			jQuery(".logo_styling .tabs.upload_logo_pic").click(function(){
				jQuery(".logotextSaveBut, .logotextSaveButCancel").hide();

				jQuery("form#HeaderPicUpload").show();
				jQuery(".logo_text_div, #logo_height_label").hide();

			});
			jQuery(".logo_text_div").click(function(){if (!editorInlneIsinitieted) initLogoTextEdit();});
			jQuery("#logo_height_slider").slider({
				range:'max',max:200,value:jQuery(".text_logo_insite").height(),
				 slide: function( event, ui ) {
				 	jQuery(".text_logo_insite").height(ui.value+"px");
				 	jQuery(".text_logo_insite").css("line-height",ui.value+"px");
				 }
			});
			if (jQuery(".text_logo_insite").length>0) jQuery(".logo_styling .tabs.text_logo").click();
			jQuery(".logotextSaveBut").click(function(){saveTextLogo(jQuery(".text_logo_insite").html())});
			jQuery(".logotextSaveButCancel").click(function(){showUploadTools(uploadType,this);});
		function updateLogoNow(t) {
			
			if (jQuery(".text_logo_insite").length<1) jQuery(".topHeaderLogo a").html('<div class="text_logo_insite"></div>');
			jQuery(".text_logo_insite").html(jQuery(t).html());
			<?
			if ($SITE[topmenubottom]==2 OR $SITE[topmenubottom]==4) {
				?>
				if (jQuery(".text_logo_insite").length<1) jQuery(".topHeaderTopMenu").width(<?=$dynamicDecrease;?>-(jQuery(".fakeLogoText").width())+"px");
				else jQuery(".topHeaderTopMenu").width(<?=$dynamicDecrease;?>-(jQuery(".text_logo_insite").width())+"px");
				<?
			}
			?>
		}
		function initLogoTextEdit() {
		
		CKEDITOR.inline('logoTextEditor'  ,{
		        on:{
		            blur: function(event){
		                 if (event.editor.checkDirty()) {
		                    
		                	if (editorInlneIsinitieted) CKEDITOR.instances.logoTextEditor.destroy();
		                	editorInlneIsinitieted=false;
		                }
		            }
		        },
		        customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_logo.js'
		       
		    });
			jQuery(".logotextSaveBut").click(function(){
				var logoTextVal=jQuery(".text_logo_insite").html();
				if (jQuery(".text_logo_insite").length<1) logoTextVal=jQuery(".logo_text_div").html();
				saveTextLogo(logoTextVal);
				CKEDITOR.instances.logoTextEditor.destroy();
				editorInlneIsinitieted=false;

			});
			editorInlneIsinitieted=true;
		}
		function saveTextLogo(text_data) {
			
			var logoText=encodeURIComponent(text_data);
			if (jQuery(".text_logo_insite").length<1) {
				var logoWidth=jQuery(".fakeLogoText").width()+16;
				var logoHeight=jQuery(".fakeLogoText").height();
			}
			else {
				var logoWidth=jQuery(".text_logo_insite").width()+16;
				var logoHeight=jQuery(".text_logo_insite").height();
			}
			console.log(logoWidth);
			var url = '<?=$SITE[url];?>/Admin/GetStyleAdminAjax.php';
			var pars = 'action=saveTextLogo'+'&logoText='+logoText+"&logoW="+logoWidth+"&logoH="+logoHeight;
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			ShowLayer("UploadToolsDiv",0,0);
		}
		</script>
		<?
	break;
	default:
		
	break;

}
?>
<link rel="stylesheet" href="//d3jy1qiodf2240.cloudfront.net/css/jquery-ui.1.11.2.css">
