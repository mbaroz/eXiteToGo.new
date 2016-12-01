<?php
session_start();
header("Content-Type: text/css");
$browser = $_SERVER['HTTP_USER_AGENT'];
$inc_dir="../";
include_once($inc_dir."inc/GetServerData.inc.php");
include_once($inc_dir.$SITE_LANG[dir]."database.php");
$CONF=GetConfigVars();
for ($a=0;$a<count($CONF[ConfigID]);$a++) {
	$pos=stripos($CONF[VarName][$a],"[");
	$ARRAY_NAME=substr($CONF[VarName][$a],0,$pos);
	$ARRAY_KEY=substr($CONF[VarName][$a],$pos+1,-1);
	${$ARRAY_NAME}[$ARRAY_KEY]=$CONF[VarValue][$a];
}
$SITE[media]=$SITE[url].$SITE_LANG[directive];

include_once($inc_dir."defaults.php");
?>
.ui-widget {font-family: inherit !important;}
.ui-widget-content a{color:inherit !important}
.title        {font-weight: bold }
.adminBody {background-color: #f7f7f7}
.general     { font-family: inherit,Arial; font-size: 12pt;font-weight:normal }
.button       { color: #000000; font-family: Arial; font-size: 10pt; font-weight: bold;cursor:pointer }
.button { background-color: #b9bfd1; border-radius:3px;}
.button.nobg {
	background:none;background-color:transparent;
}
.link       { cursor:pointer }
#saveContentButton {
	padding:3px;
	font-family:arial;
	font-weight:bold;
	font-size:12px;
	cursor:pointer;
	text-align:center;
	
}
.text_logo_insite{font-size:36px;margin-left:20px;margin-right:5px;text-decoration:none;height:<?=$SITE[logoheight];?>px;line-height:<?=($SITE[logoheight]) ? $SITE[logoheight] : '10' ;?>px}
#make_dragable {background-color:#333;padding:8px;cursor:move;margin-bottom:4px;border-radius:2px;height:20px;line-height:20px;}
#make_dragable .icon_close, .globalSettingsWrapper .icon_close {transition:all 0.5s;color:white;transform:rotate(45deg);-ms-transform:rotate(45deg);-webkit-transform:rotate(45deg);font-size:2.5rem;position:absolute;<?=$SITE[opalign];?>:8px;cursor:pointer}
.globalSettingsWrapper .icon_close{font-size:3rem;top:-8px;color:#000}
.globalSettingsWrapper .icon_close:hover {transform:(-45deg);-webkit-transform:rotate(-45deg)}
#make_dragable div.title {float:<?=$SITE[align];?>;color:white}
#newSaveIcon, input#saveContentButton,input#cancelContentButton, .newSaveIcon, .TemplateChooser  {
display: inline-block;
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
  cursor: pointer;
  padding: 6px 15px;
  border: none;
  font: normal 15px/normal almoni-dl-aaa-400,Arial, Helvetica, sans-serif;
  color: rgba(0,0,0,0.9);
  text-align: center;
  -o-text-overflow: clip;
  text-overflow: clip;
  background: -webkit-linear-gradient(-90deg, rgba(237,237,237,0.8) 0, rgba(237,237,237,0.8) 2%, rgba(255,255,255,0.8) 100%, rgba(255,255,255,0.8) 100%);
  background: -moz-linear-gradient(180deg, rgba(237,237,237,0.8) 0, rgba(237,237,237,0.8) 2%, rgba(255,255,255,0.8) 100%, rgba(255,255,255,0.8) 100%);
  background: linear-gradient(180deg, rgba(237,237,237,0.8) 0, rgba(237,237,237,0.8) 2%, rgba(255,255,255,0.8) 100%, rgba(255,255,255,0.8) 100%);
  background-position: 50% 50%;
  -webkit-background-origin: padding-box;
  background-origin: padding-box;
  -webkit-background-clip: border-box;
  background-clip: border-box;
  -webkit-background-size: auto auto;
  background-size: auto auto;
  -webkit-box-shadow: 0 0 1px 0 rgba(0,0,0,0.2) ;
  box-shadow: 0 0 1px 0 rgba(0,0,0,0.2) ;
  min-height:17px;
  white-space:nowrap;
  transition:all 0.4s;-webkit-transition:all 0.4s;

}
#newSaveIcon.round {width:20px;height:20px;border-radius:100%}
#newSaveIcon img {max-height:16px;}
#newSaveIcon .fa {font-size:18px;line-height:21px}
#newSaveIcon:hover, input#saveContentButton:hover,input#cancelContentButton:hover, .newSaveIcon:hover {
	background: -webkit-linear-gradient(-90deg, rgba(237,237,237,1) 0, rgba(237,237,237,1) 2%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);
 	background: -moz-linear-gradient(180deg, rgba(237,237,237,1) 0, rgba(237,237,237,1) 2%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);
 	background: linear-gradient(180deg, rgba(237,237,237,1) 0, rgba(237,237,237,1) 2%, rgba(255,255,255,1) 100%, rgba(255,255,255,1) 100%);

}
input#saveContentButton, input#cancelContentButton{line-height: normal;height:25px;color:black !important}
input#saveContentButton {background-image: url('<?=$SITE[url];?>/Admin/images/save-icon.png');background-repeat: no-repeat;background-position: <?=$SITE[align];?>;
	padding-<?=$SITE[align];?>:25px;
}
input#cancelContentButton {background-image: none;}
#newSaveIcon.add_button, .newSaveIcon_selected, .TemplateChooser span:hover, .TemplateChooser.green:hover {
	color: white;
	background-color: #2253d3;
	background-image: -ms-linear-gradient(top, #2253d3 0%, #2253d3 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #2253d3), color-stop(1, #2253d3));
         background-image: linear-gradient(to bottom, #2253d3 0%, #2253d3 100%);
         background-image: -webkit-linear-gradient(top, #2253d3 0%, #2253d3 100%);
         background-image: -moz-linear-gradient(top, #2253d3 0%, #2253d3 100%);
}
	
#newSaveIcon img {
	display:inline;
	margin-<?=$SITE[opalign];?>:3px;
	
}
.topMainPic:hover > .mainPicStaticAdminControl, .topMainPicCustom:hover > .mainPicStaticAdminControl {
	display:block;
}
.mainPicStaticAdminControl {z-index:810;left:auto;position:absolute;display:;}
.mainPicStaticAdminControl .newSaveIcon, .mainPicStaticAdminControl .newSaveIcon:hover {padding:3px}
.mainPicStaticAdminControl #newSaveIcon.greenSave, .mainPicStaticAdminControl #newSaveIcon.mainPicEditDD.show {visibility:hidden;transform:scale(0)}
.mainPicStaticAdminControl #newSaveIcon.greenSave.show, .mainPicStaticAdminControl #newSaveIcon.mainPicEditDD {visibility:visible;transform:scale(1)}
.mainPicStaticAdminControl.slider {top:auto}
.mainPicStaticAdminControl.widerSlider {;margin:0 10%;}
.mainPicStaticAdminControl.slider #newSaveIcon i.fa {font-size:13px;}

#newSaveIcon a {
	padding:3px;
	color:black;
	position:relative;
	font-family:arial;
}

.newSaveIcon_selected {
	
	padding:8px 0px 12px 0px;
	font-weight:bold;
	cursor:pointer;
}
#newSaveIcon.greenSave, .newSaveIcon.greenSave {
	background-color: #53a93f;
	color:white;
	float:<?=$SITE[opalign];?>;
	padding-right:8px;
	padding-left:8px;
	background-image:none;
	width:44%;
	max-width:210px;
	font-size:20px;
}

#newSaveIcon.cancel, .newSaveIcon.cancel {
	float:<?=$SITE[align];?>;
	width:44%;
	max-width:210px;
}

#newSaveIcon.greenSave:hover, .newSaveIcon.greenSave:hover  {
	background-color: #458d35;

}
.saveButtonsNew, .settings_slider .saveButtonsNew{position:fixed;bottom:1px;width:inherit}

.TemplateChooser span:hover {

	padding:8px 0px 12px 0px;
}
<?
	if (ieversion()>0) {
		?>
		.newSaveIcon_selected, .TemplateChooser span:hover {
			padding-bottom:9px;
		}
		<?
	}
?>

.NewContentBg {
	background-image:url('<?=$SITE[url];?>/Admin/images/add_button_bg.png');
	background-repeat:repeat-x;
	min-width:50px;
	padding:3px;
	font-family:arial;
	height:33px;
	font-weight:bold;
	font-size:11px;
	cursor:pointer;
	display:inline;
	border:1px solid #015993;
	color:white;
}

.TemplateChooser {
	min-width:50px;
	padding:8px 0px 9px 0px;
	font-family:almoni-dl-aaa-400;
	
	font-size:12px;
	cursor:pointer;
	position:relative;
	z-index:200;
	
	float:<?=$SITE[align];?>;
}

.TemplateChooser.green {background:#369f40;color:white;}
.TemplateChooser.copied, .TemplateChooser.copied:hover, .TemplateChooser.copied span:hover {background:#616865;color:white;}
.TemplateChooser span i {padding:0px 3px 0px 3px;font-size:12px;}
<?


?>
.SideCatChooser {
	visibility:visible;
	position:absolute;
	margin:0;
	margin-top:-44px;
	transition:all 0.2s;
	-webkit-transition:all 0.2s;
	opacity:0;
	background-color:#333;
	color:#222;
	border-radius:none;
	width:228px;
	padding:0;
	font-size:15px;
	font-family:almoni-dl-aaa-400;
	
}
.SideCatChooser.TemplateChooser span {display:inline-block;width:50%;}
<?if ($_GET['mode']!="view") {
	?>
	.rightSide:hover{border:1px dotted blue;outline:none;}
	.rightSide:hover .SideCatChooser, .rightSideSeperated > div:hover .SideCatChooser {visibility:visible;display:block;opacity:1;transition-delay:0.25s}
	<?
}

	if (ieversion()>0) {
		?>
		.newSaveIcon_selected, .TemplateChooser span:hover, .SideCatChooser {
			padding-bottom:7px;padding-top:9px;
		}
		<?
	}
?>
.TemplateChooser span {
	position:relative;
	width:140px;
}
ul.PageStyleChooser {
	padding:0px;
	margin:0px;
}

.selected_p_type_0 {
	background-image:url('<?=$SITE[url];?>/Admin/images/RegularTemplate.png');
}
.selected_p_type_1 {
	background-image:url('<?=$SITE[url];?>/Admin/images/FullPage.png');
}
.selected_p_type_2 {
	background-image:url('<?=$SITE[url];?>/Admin/images/SeperatedCols.png');
}
.selected_p_type_3 {
	background-image:url('<?=$SITE[url];?>/Admin/images/LeftCol.png');
	width:28px;
}
.PageStyleChooser li {
	float:<?=$SITE[align];?>;
	background-repeat: no-repeat;
	background-position: center;
	width:28px;height:24px;
	margin:0;
	list-style:none;
	list-type:none;
	cursor:pointer;
	font-family:arial;
	font-weight:normal;
	opacity: 0.8;
}
.PageStylesWrapper {
	float:<?=$SITE[opalign];?>;
	margin-<?=$SITE[opalign];?>:10px;
	padding:2px;
	height:24px;
}
.PageStyleChooser li:hover {
	opacity: 1;
}

#TopAdminLabel a {
	color:white;
	padding-top:2px;
}
ul.TemplateDropDown {
	position:absolute;
	top:100%;
	left:0;
	width:100px;
	margin:-5px;
	padding:5px;
	
}
.TemplateDropDown li {
	background:#fff1a8;
	width:140px;
	border-bottom:1px solid silver;
	padding:2px;
	list-style:none;
	list-type:none;
	margin:0px;
	cursor:pointer;
	font-family:arial;
	color:black;
	font-weight:normal;
	font-size:12px;
}
.TemplateDropDown li:hover {
	background:silver;
	padding:2px;
	border-bottom:1px solid silver;
	color:white;
	width:140px;
	cursor:pointer;
}
.cHolder {
	border:0px
	
}
#TopAdminTheme {
	color:black;
	direction:<?=$SITE_LANG[direction];?>;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	position: absolute;
	top: 0px;
	left: 0px;
	padding-top:0px;
	align:center;
	z-index:1300;
	background:transparent url('<?=$SITE[url];?>/Admin/images/TopThemeBG.png') no-repeat;
	width:210px;
	height:32px;
}
#TopAdminLabel {
	color:white;
	direction:<?=$SITE_LANG[direction];?>;
	font-family: Arial, Helvetica, sans-serif;
	font-style: normal;
	position: fixed;
	z-index: 100;
	width:100%;
	top: 0px;
	padding-top:0px;
	align:center;
	z-index:1300;
	transition:all 0.3s;
	
}


.AdminTopNew{
	background-color:#222;
	box-shadow:0px 0px 10px 0px #333;
	padding:0px 0px 0px
	transition:all 0.3s;
	min-height:40px;
}
.AdminTopNew table td a:hover, .AdminTopNew td:hover {color:#efefef}
.AdminTopNew table {margin-top:8px;font-size:14px;}
.AdminTopMarginizer{min-height:40px}
.BottomAdminBG{
	background-color:red;
	height: 60px;
	margin-top:0;
	width:320px;
	color:white;
	padding:6px 10px 10px 5px;
}
.BottomAdminMessages {
	position: fixed;
	z-index: 2500;
	width:50%;
	bottom: 0;
	text-align:<?=$SITE[align];?>;
}
#ContentTypesDiv {
	overflow:scroll-y;
	border:1px solid silver;
	background:#efefef;
	padding:4px;
	margin-bottom:20px;
	font-family:arial;
}
.ConfigAdminInput, .ConfigAdminSelect, .ConfigAdminInputTxt, .ConfigAdminInput.ENtextbox {
	direction:<?=$SITE_LANG[direction];?>;
	padding:5px;
	text-align:<?=$SITE[align];?>;
	width:400px;
	border:1px solid #e7e7e7;
	background:#fff;
	box-shadow:0px 0px 6px #ededed;
	outline:none;
	font-size:14px;
}
.ConfigAdminInput {
	height:30px;

}
.ConfigAdminInput.ENtextbox {direction:ltr;text-align:left;}
.ConfigAdminSelect {
	height:30px;
	width:410px;
}
.ConfigAdminInputTxt {
	font-family:arial;
	min-height:100px;
}
.ConfigAdmin {
	direction:<?=$SITE_LANG[direction];?>;
	font-size:17px;
	text-align:<?=$SITE[align];?>;
	font-weight:normal;
}
table.ConfigAdmin.listTable tr {background-color:#fff}
table.ConfigAdmin.listTable tr td {font-weight:normal;}
.ContentTypes {
	display:inline;
	margin:1px;
	padding:2px 5px 2px 5px;
}



.AdminArea {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: bold;
	color:black;
	border:1px solid silver;
	z-index: 100;
	cursor:pointer;
	padding:0px;
	height:12px;
	direction:<?=$SITE_LANG[direction];?>;
	text-align:center;
	background-image:url('<?=$SITE[url];?>/Admin/images/button_bg.png');
	background-repeat:repeat-x;
}
.AdminNewsArea {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	color:black;
	border:1px solid silver;
	background-color: #efefef;
	z-index: 100;
	height: 17px;
	cursor:pointer;
	padding:1px;
	width:95%;
}
.AdminAreaItem {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color:black;
	border:0px;
	padding:1px;
	cursor:pointer;
	
}
.AdminAreaItemOver {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	color:black;
	border:0px solid silver;
	background-color:#E3F2F9;
	padding:1px;
	
}

.LoadingDiv {
	font-size:14px;
	font-family: Arial, Helvetica, sans-serif;
	position:fixed;
	bottom:20px;
	<?=$SITE[opalign];?>:15px;
	padding:10px;
	background-color:green;
	color:white;
	display:none;
}
.LoadingDiv.show{display:block}
.inputText {
	font-size:12px;
	height:15px;
	width:180px;
	font-family: Arial, Helvetica, sans-serif;
		
}
.LoadingDiv.deleted {background-color:red;color:white}
.inputTextTitle {
	font-size:16px;
	width:98.5%;
	font-family: Arial, Helvetica, sans-serif;
	border:1px solid #eeeeee;
	font-weight:bold;
	padding:4px;

}
.inputExternalUrl {
	height:25px;
	font-size:11px;
}
.inputPageUrl {
	width:97%;
}
.selectBox {
	font-size:10.5px;
	width:40px;
	height:18px;
	font-family: Arial, Helvetica, sans-serif;
		
}
.generalCombo {
	font-size:10.5px;
	font-family: inherit,Arial, Helvetica, sans-serif;
	height:18px;
	width:150px;
	direction:<?=$SITE_LANG[direction];?>;
	text-align:<?=$SITE[align];?>
}
.checkBox {
	font-size:121px;
	height:20px;
	width:20px;
	font-family: Arial, Helvetica, sans-serif;
		
}
.successEdit {
	text-align:center;
	padding:3px;
}
.failedEdit {
	font-size:12px;
	color:white;
	font-family: Arial, Helvetica, sans-serif;
	background-color:red;
}


#topStyleEditor, #topUsersPerms, #topMetaTags {position:absolute;width:100%;top:0;z-index:1002;top:35px;}
#topUsersPerms, #topMetaTags {position:fixed;}

.overlayBG{
	position: absolute;
	top: 0;
	left: 0;
	z-index: 890;
	width: 100%;
	height: 500px;
	background-color: rgba(0, 0, 0, .6);
}
.globalSettingsWrapper {
	visibility:hidden;
	position:fixed;top:0;<?=$SITE[align];?>:0px;
	width:600px;
	height:100%;
	overflow:hidden;
	box-shadow:0px 0px 15px 0px #333;
	background-color:#fff;
	z-index:2000;
	transition:all 0.3s;
	transform:scale(1);
	transition-timing-function:cubic-bezier(0.2, 0.15, 0.36, 1);
	<?=$SITE[align];?>:-600px;
	
}
.globalSettingsWrapper.show{visibility:visible;transform:scale(1);<?=$SITE[align];?>:0px}
.globalSettingsWrapper.show.draggable {
	width:140px;
}
.globalSettingsWrapper.show.draggable .head_options {display:none}
.rightMenuAdminOver {
	border:1px dotted silver;
	cursor:move;
	margin:0px;
	padding:0px;
	font-family:arial;
}
.globalSettingsWrapper #gSettingsInner{}
.rightMenuItem input{
	font-size:12px;
	padding:0px;
	margin:0;
	font-family:arial;
	text-align:<?=$SITE[align];?>;
	width:160px;
	display:inline;
}
.rightMenuItem form{
	display:inline;
	
}
.topMenuItem a{
       
      padding:0px;
      font: bold 13.5px arial;
     
}

.titleContent input {
	width:80%;
	margin:0px;
	
}
.topHeaderSlogen textarea {
	text-align:<?=$SITE[align];?>;
	font-size:19px;
	font-family:arial;
	color:#<?=$SITE[slogentextcolor];?>;
	width:470px;
	font-weight:bold;
	padding:14px 5px 3px 5px;
	overflow:hidden;
	margin:0px;
	display:inline;
	max-height:43px;
}

.sideCatTitle input {
	text-align:<?=$SITE[align];?>;
	font-size:18px;
	color:#<?=$SITE[titlescolor];?>;
	display:inline;
	margin-left:10px;
	background:#<?=$SITE[contentbgcolor];?>;
	overflow:hidden;
	border:1px dotted silver;
	padding:2px
	
}
.titleContent_top input{
	width:80%;
	text-align:<?=$SITE[align];?>;
	font-size:18px;
	color:#<?=$SITE[titlescolor];?>;
	display:inline;
	margin-left:10px;
	background:#<?=$SITE[contentbgcolor];?>;
	overflow:hidden;
	border:1px dotted silver;
	padding:2px
}

.topmenu  input {
        list-style: none;
        margin: 0;
       display: inline;
       
}
.topmenu span form {
        margin: 0;
        display: inline;
      
}
i.close_edit_notify{cursor:pointer;transition:zoom 0.4s}
i.close_edit_notify:hover{transform:zoom(1.1)}

.photo_text {
	 font-family: Arial;
	 font-weight:normal;
	 font-size: 11px;
	 width:260px;
	 height:70px;
	 rows:3;
	 cols:90;
}
.article_upload_button {
	border:0px;
	font-size:12px;
	font-family:arial;
	font-weight:bold;
	height:22px;
	color:#333333;
	background-color:silver;
	cursor:pointer;
}
.pagePic {
	border:1px dotted silver;
	
}
.logoPic {
	border:0px;
}
#newsselector {
	width:440px;
	border:1px solid silver;
	padding:2px;
	font-size:12px;
}
.small_select {
	font-family:arial;
	font-size:12px;
	border:1px solid #efefef;
	padding:0.2px;
	height:20px;
}
#time_out_min,#time_out_sec {
	background:transparent;
	border:0px;
	width:17px;
	color:white;
	font-weight:bold;
	text-align:center;
}
.galleryInputText input {
	border:1px solid silver;
	padding:2px;
}
#tooltipBG {
	position:absolute;
	z-index:800;
	text-align:<?=$SITE[align];?>;
}
.hint {
	direction:ltr;
        background:-webkit-gradient(linear, 100% 100%, 85% 53%, from(#fff1a8), to(#fff1a8));
        background:-moz-linear-gradient(113deg, #fff1a8, #fff1a8 28%);
        background: -o-linear-gradient(113deg, #fff1a8, #fff1a8 28%);
        background-color: #fff1a8;
        border:1px solid silver;
        border-radius:5px 5px 5px 5px;
        padding:5px;
        font-family:arial;
        width:180px;
        min-height:75px;
        position:relative;
	font-size:11px;
       
    }
.curl {
        -webkit-border-bottom-right-radius: 120px 25px;
        -moz-border-radius-bottomright: 120px 25px;
        border-bottom-right-radius: 120px 25px;
}
    .curl::before {
        background: transparent;
        bottom: 15px;
        -webkit-box-shadow: 11px 11px 11px gray;
        box-shadow: 11px 11px 11px gray;
        content: '';
        height: 50%;
        position: absolute;
        right: 12px;
        width: 50%;
        z-index: -1;
}
.wrapper_hint {
        position:relative;
        display:block;
        padding-bottom:13px;
        
}
.wrapper_hint .arrowdown {
        position:absolute;
        bottom:1px;
        background-image:url('<?=$SITE[url];?>/Admin/images/hint_arrow_down.png');
        background-repeat:no-repeat;
        width:26px;
        height:13px;
        left:20px;
        
    }
#embedGalleryCode {
	display:none;
	
}
#embedCode, .embedCode {
	background-color:#efefef;
	border:1px solid silver;
	padding:3px;
	width:98%;
	direction:ltr;
	text-align:left;
	height:50px;
	}
.AdminCheckbox {
	width:20px;height:20px;margin:0;padding:0px;
	vertical-align:middle;
}
.EditorBox {
	 background-color:#efefef;
         padding:8px;
         position:absolute;
         right: 0;
         left: 0;
         top:20%;
         margin:0 auto;
         -moz-border-radius: 5px;
         -webkit-border-radius: 5px;
         -webkit-box-shadow:0px 0px 9px silver;
	 border-radius: 5px;
}
.uploadertoolsbutton {
	cursor:pointer;
	text-decoration:none;
	color:blue;
}
.uploadertoolsbutton:hover {
	color:green;
}
.editor_addPhoto {
	margin-top:5px;
	float:<?=$SITE[opalign];?>;
	
}
#PhotoFiltersContainer {
	overflow-y:auto;
	border:1px solid silver;
	background-color:white;
	margin:5px;
	height:255px;
	text-align:<?=$SITE[align];?>;
}
.CatLocationChooser {
	min-height:330px;
	display:none;
}
.loadingCircle {
	margin:auto;
	text-align:center;
}
.CatEditInputs {
	border:1px solid #ccc;
	padding:8px;
	font-family:arial;
	width:97%;
	font-size:16px;
	outline-width:1px;
	outline-color:black;
	background-color:#f7f7f7;
}
#AllCatsContainer {
	overflow-y:auto;
	height:275px;
	padding:5px;
	margin-bottom:20px
}
#AllCatsContainerWrapper {
	background:#efefef;
	min-height:300px;
	
	
	
}
.search_cats input {
	width:94%;
	border:1px solid silver;
	font-size:17px;
	padding:8px;
	outline:none;
	margin:3px;
	font-family:inherit;
}
.cat_tree_all .cat_node {
	color:#333333;
	cursor:pointer;
}
.root_class {font-weight:bold}
.cat_tree_all .cat_node:hover {
	background:#037ecc;
	color:white;
}
#moveCatLocation {
	cursor:pointer;
	
}
.settings_slider {
	position:fixed;
	width:430px;
	z-index:3100;
	top:0px;
	<?=$SITE[align];?>:0px;
	background-color:#efefef;
	border:0px;
	height:100%;
	padding:0px;
	font-family:arial;
	direction:<?=$SITE_LANG[direction];?>;
	box-shadow:0px 2px 0px #333;
}
.settings_slider .inner_settings {padding:5px;font-family: almoni-dl-aaa-400;}
.settings_slider .CenterBoxContent {background:#fff;font-size:14px;}
#movedConfirmed {color:white;background:green}
.secured_cat_indicator {
	color:red;
}
.CenterBoxContent {font-size:15px;background:#fff}
.editorWrapper {
	background-color: #ededed;
	border:2px solid #fefefe;
	font-family:arial;
	position:fixed;
	bottom:0px;
	padding:5px;
	z-index:2000;
	width:940px;
	left:50%;
	margin-left:-485px;
	padding-bottom:50px;
	
}
ul.SideMenu li, ul.SideMenu li .SubSubCategory {position:relative;}
ul.SideMenu li label.sideMenuEditTools, ul.SideMenu li .SubSubCategory label.sideMenuEditTools{font-family:almoni-dl-aaa-300;margin-<?=$SITE[align];?>:40px;margin-top:-10px;font-weight:normal;font-size:15px;}

ul.dropdown li label.topMenuEditTools, ul.SideMenu li label.sideMenuEditTools, ul.SideMenu li .SubSubCategory label.sideMenuEditTools {cursor:pointer;line-height:10px;opacity:0;transition:all 0s;box-sizing:border-box;padding:5px;position:absolute;top:-17px;<?=$SITE[align];?>:-30px;width:150px;background-color:#333;color:white;visibility:hidden}
ul.dropdown li:hover > label.topMenuEditTools,  ul.SideMenu li #s_menu:hover > label.sideMenuEditTools, ul.SideMenu li .SubSubCategory:hover > label.sideMenuEditTools{visibility:visible;transition:all 0.2s;opacity:1;transition-delay:0.15s}
ul.dropdown li label.topMenuEditTools a, ul.SideMenu li label.sideMenuEditTools a, ul.SideMenu li .SubSubCategory label.sideMenuEditTools a{display:inline-block;color:white;text-decoration:none;font-weight:bold;font-family:almoni-dl-aaa-300;font-size:15px;}
ul.dropdown li label.topMenuEditTools i, ul.SideMenu li label.sideMenuEditTools i, ul.SideMenu li .SubSubCategory label.sideMenuEditTools i {font-size:15px;padding:4px;text-align:center}
ul.dropdown li label.topMenuEditTools a.del:hover > i,ul.SideMenu li label.sideMenuEditTools a.del:hover > i, ul.SideMenu li .SubSubCategory label.sideMenuEditTools a.del:hover > i {color:red}
ul.dropdown li label.topMenuEditTools i.fa-chevron-down.arrow, ul.SideMenu li label.sideMenuEditTools i.fa-chevron-down.arrow, ul.SideMenu li .SubSubCategory label.sideMenuEditTools i.fa-chevron-down.arrow{position:absolute;top:20px;left:40%;color:#333}
ul.SideMenu li .move_vertical_cat {visibility:hidden;font-weight:normal;font-size:13px;float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:5px;margin-top:4px;}
ul.SideMenu li:hover > .move_vertical_cat{visibility:visible}
.minimize_editor {
	float:<?=$SITE[opalign];?>;
	width:16px;height:16px;
	font-size:30px;
	line-height:15px;
	background-repeat:no-repeat;
	background-position:center;
	cursor:pointer;
	background-color:#3B4B66;
	clear:both;
	color:white;
	margin-bottom:5px;
	margin-top:-19px;
	margin-<?=$SITE[opalign];?>:-19px;
	padding:5px;
	border-radius:22px;
	border:1px solid #fefefe;
	transform:rotate(45deg);-webkit-transform:rotate(45deg);
	font-family:-webkit-pictograph;transition:all 0.3s;
}
.minimize_editor:hover {transform:rotate(-45deg)}
.sidesEditorWrapper {left:auto;<?=$SITE[align];?>:0px;margin-<?=$SITE[align];?>:170px;width:380px}
.editorShadow {
	position:fixed;
	bottom:0px;
	width:100%;
	z-index:2000;
	height:13px;
	background-color:transparent;
	background-image:url('<?=$SITE[url];?>/Admin/images/editorShadowBottom.png');
	background-repeat:no-repeat;
	background-position: center bottom;
	left:2%;
}
.photoEditDropDown {
	width:170px;
	padding:2px;
	min-height:17px;
	line-height:22px;
	border-bottom:1px solid #efefef;
	text-align:<?=$SITE[align];?>;
}
.photoEditDropDown:hover {
	background-color:#efefef;
}
.ex_help_button {
	width:14px;height:14px;
	border:1px solid #e8da98;
	border-radius:15px;
	font-size:14px;
	font-weight:normal;
	font-family:verdana;
	text-align:center;
	background:#fff1a8;
	padding:4px;
	min-width:2px;
	position:absolute;
	margin-top:-27px;
	z-index:20000;
	cursor:pointer;
	opacity:0;
	-webkit-transform: scale(0,0);
	-webkit-transition-timing-function: ease-out;
	-webkit-transition-duration: 100ms;
	-moz-transform: scale(0,0);
	-moz-transition-timing-function: ease-out;
	-moz-transition-duration: 100ms;
}
.TemplateChooser:hover >.ex_help_button {-webkit-transition:all 0.2s;opacity:1;
	-webkit-transform: scale(1,1);
	-webkit-transition-duration: 250ms;
	-moz-transform: scale(1,1);
	-moz-transition-timing-function: ease-out;
	-moz-transition-duration: 250ms;
}

.BottomAdminBG #timeLeft {font-size:18px;}
input, textarea {font-family: arial}
.highlight { background-color: yellow }
#PhotoFiltersDiv {display:none}
.pageStyleSample {float:left;display:block;background-color:gray;margin:3px;height:20px;width:100px;}
.pageStyleSample.narrow {width:20px;}
.pageStyleSample.wide {width:123px;}

.mobilePreviewWrapper {
	width:320px;
	height:480px;
	background:#e7e7e7;
	border-top:30px solid;
	border-right:20px solid;
	border-bottom:45px solid;
	border-left:20px solid;
	border-radius:15px;
	border-color:#757575;
	display:block;
	margin-bottom:20px;
	
}

.mobilePreviewWrapper .bottom {
	text-align:center;
	margin-top:5px;
	bottom:7px;
	direction:ltr;
	
}
.mobilePreviewWrapper .homebutton {
	width:30px;height:30px;
	background:white;
	border-radius:40px;
	margin-left:41%;
}
.mobilePreviewWrapper .inner iframe{
	width:320px;
	height:480px;
	overflow-x:hidden;
	overflow-y:auto;
	border-radius:4px;
}

#newSaveIcon.advancedEditorButton {
	background-color:#98bfeb;
	background-image:none;
	padding:8px;
	width:150px;
}
.notification_admin {
	float:<?=$SITE[opalign];?>;
	margin-<?=$SITE[opalign];?>:60px;
	margin-top:-39px;
	width:40px;
	
}
.notification_admin .notify_icon {
	border:1px solid;
	border-radius:25px;
	padding:3px;
	cursor:pointer;
	width:25px;height:25px;
	transition:all 0.3s
}
.notification_admin .notify_icon:hover {background-color:#fff;color:#333}
.notification_admin .notify_icon:hover i {color:#333}
.notification_admin .notify_icon i {line-height:25px;text-align:center}
.notification_admin .notify_icon:hover {
	color:#fff;
}
.notification_admin .notification_message {
	position:absolute;
	top:45px;
	<?=$SITE[opalign];?>:22px;
	width:250px;
	min-height:50px;
	background:#efefef;
	border-radius:2px;
	box-shadow: 3px 3px 5px rgba(0,0,0,.3);
	-moz-box-shadow: 3px 3px 5px rgba(0,0,0,.3);
	padding:10px;
	display:none;
	color:#333;
}
.notification_admin .notification_message .arrow {
	position:absolute;
	top:-16px;
	<?=$SITE[opalign];?>:50px;
	color:#efefef;
}
#eXite_OperationBox {
	min-height:200px;
}
.pasteActionsChooser {
	width: 16px;	
	
	position: relative;
}
.pasteActionsChooser label {
	cursor: pointer;
	position: absolute;
	width: 16px;
	height: 16px;
	top: 0;
	border-radius: 2px;
	background: #efefef;
	border:2px solid white;
}
.pasteActionsChooser label .labelText {
	width:400px;
	position:absolute;
	margin-<?=$SITE[align];?>:23px;
}
.pasteActionsChooser label:after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
	filter: alpha(opacity=0);
	opacity: 0;
	content: '';
	position: absolute;
	width: 9px;
	height: 5px;
	background: transparent;
	top: 2px;
	left: 2px;
	border: 3px solid #333;
	border-top: none;
	border-right: none;
	-webkit-transform: rotate(-45deg);
	-moz-transform: rotate(-45deg);
	-o-transform: rotate(-45deg);
	-ms-transform: rotate(-45deg);
	transform: rotate(-45deg);
}
.pasteActionsChooser label:hover::after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
	filter: alpha(opacity=30);
	opacity: 0.5;
}
.pasteActionsChooser input[type=checkbox]:checked + label:after {
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=100);
	opacity: 1;
}
.pasteActionsChooser input[type=checkbox] {
	visibility: hidden;
}
.notification_admin .notify_icon i {font-size:18px;}
#newSaveIcon.greenSave i, .newSaveIcon.greenSave i {margin-<?=$SITE[opalign];?>:4px;font-size:17px;vertical-align:middle}
.successCopiedContent {color:green;font-size:16px;font-weight:bold;margin-top:20px;text-align:center}
.mobilePreviewWrapper .inner {overflow-y:auto;border-radius:4px;}
.hidemobile {border:1px dotted silver;}
.mainContentText .mobileonly, .mainContentText .mobileonly, .middleContentText .mobileonly {display: inherit !important}

.resizeWrapper.adminMode {
	border-bottom: 1px solid blue;
}
.ui-resizable-handle.ui-resizable-s {cursor:row-resize}
.topMainPic .dragger {
	position: absolute;height:10px;width: 10px;left:50%;
	border:1px solid blue;border-radius: 7px;margin-top:-5px;background: white;
}

.content_controls_buttons img:hover{
	opacity:0.8;
	background-color:#efefef;
	border-radius:3px;
}
.content_controls_buttons {
	z-index:300;
}
#ls_effect_chooser {
	cursor:pointer;
}
.onoffswitch {
    position: relative; width: 65px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    direction:ltr;
    text-align:left;
}

.onoffswitch-checkbox {
    display: none;
}

.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 1px solid #efefef; border-radius: 16px;
}

.onoffswitch-inner {
    width: 200%; margin-left: -100%;
    -moz-transition: margin 0.2s ease-in 0s; -webkit-transition: margin 0.2s ease-in 0s;
    -o-transition: margin 0.2s ease-in 0s; transition: margin 0.2s ease-in 0s;
}

.onoffswitch-inner:before, .onoffswitch-inner:after {
    float: left; width: 50%; height: 28px; padding: 0; line-height: 28px;
    font-size: 15px; color: white;;
    -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
}

.onoffswitch-inner:before {
    content: "YES";
    padding-left: 10px;
    background-color: #a00c1a; color: #FFFFFF;
}

.onoffswitch-inner:after {
    content: "NO";
    padding-right: 10px;
    background-color: GREEN; color: #fff;
    text-align: right;
}

.onoffswitch-switch {
    width: 18px; margin: 5px;
    background: #FFFFFF;
    border: 1px solid #CFCFCF; border-radius: 16px;
    position: absolute; top: 0; bottom: 0; right: 35px;
    -moz-transition: all 0.2s ease-in 0s; -webkit-transition: all 0.2s ease-in 0s;
    -o-transition: all 0.2s ease-in 0s; transition: all 0.2s ease-in 0s; 
}

.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}

.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px; 
}
.gal_styling.MainSliders {
	width:300px;
	overflow-x:hidden;
	font-size:15px;
}
.gal_styling.MainSliders table tr {
	border-bottom:1px solid silver;height:25px;
	cell-spacing:3px;
}
.gal_styling.MainSliders table{border-collapse:collapse}
.gal_styling.MainSliders select, .gal_styling.MainSliders input[type="text"] {
	padding:4px;
	border:1px solid silver;
	outline:none;
	min-width:70px;
	max-width:100px;
	font-size:13px;
}
.plusPhotos {font-size:20px;margin:auto;width:100%;}
.addNewGalPhoto {width:210px;padding:10px;text-align:center;height:90px;background-color:#efefef;border:1px solid silver;margin-<?=$SITE[align];?>:30px}
.div100p .div_all .inside_div .briefs_edit {

	display:none;
}
.div100p .div_all .inside_div:hover > .briefs_edit {

	z-index:300;
	position:absolute;
	display:block;
}
.briefs_edit>#newSaveIcon {cursor:move;}
.briefs_edit i.fa {cursor:pointer}
.briefs_edit .popMenu, .gerneraldropdown.popMenu {
	position:absolute;
	
}
ul#boxes li:hover>.briefs_edit {display:block}
.CenterBoxWrapper {z-index:2000 !important;background-color:#fff}
.AdminTopNew .AdminTopMenu, .AdminTopNew a, .adminAction, .globalSettingsWrapper,.head_options, .AdminTopNew .admin_switchViews,.StyleEdit, .UsersPerms, .MetaEdit, .CenterBoxWrapper{font-family:ALMONI-DL-AAA-400;font-size:18px;direction:<?=$SITE_LANG[direction];?>}
.AdminTopNew .AdminTopMenu {width:600px;margin:0 auto;cursor:pointer}
.AdminTopNew .AdminTopMenu div {transition:background 0.2s;box-sizing:border-box;display:inline-block;min-width:100px;padding:12px;margin-<?=$SITE[align];?>:-5px;border-<?=$SITE[opalign];?>:1px solid silver}
.AdminTopNew .AdminTopMenu div:hover {background-color:#3B4B66}
.AdminTopNew .AdminTopMenu div:last-child{border-<?=$SITE[opalign];?>:0px;}
.AdminTopNew .AdminTopMenu div:last-child:hover{background:none;}
.AdminTopNew .admin_switchViews{padding:10px 10px;background-color:#3B4B66;line-height:20px}
.AdminTopNew .admin_switchViews:hover{background:gray}
.AdminTopNew .admin_switchViews i {font-size:20px;margin:0px 5px 5px 5px;float:<?=$SITE[align];?>}
.adminAction, .admin_settings {position: fixed;bottom:100px;<?=$SITE[align];?>:20px;direction: <?=$SITE_LANG[direction];?>;z-index:1100}
.adminAction, .admin_settings{font-family:almoni-dl-aaa-300}
.StyleEdit, .UsersPerms, .MetaEdit {
	font-size:15px;
	z-index:1100;
	color:black;
	align:center;
	background-color:#fff;
	width:800px;
	padding:35px 10px 10px 10px;
	direction:<?=$SITE_LANG[direction];?>;
	border:1px solid silver;
	border-top:0px;
	border-radius:0px 0px 3px 3px / 0px 0px 3px 3px;
	-moz-border-radius:0px 0px 3px 3px / 0px 0px 3px 3px;
	box-shadow: 1px 1px 5px rgba(0,0,0,.3);
	-moz-box-shadow: 1px 1px 5px rgba(0,0,0,.3);
	min-height:200px;
	margin:0 auto;
}
.StyleEditFrm {
	width:48px;
	height:15px;
	border:1px solid silver;
	font-family:inherit;
	font-size:12px;
}

.MetaEditFrm {
	font-size:12px;
	font-family: inherit;
	color:#000;
	width:400px;
	height:50px;
	border:1px solid silver;
	
}	
	.adminAction .add, .admin_settings {
		
		width:60px;height: 60px;
		border-radius: 40px;
		background-color: #DB4437;
		box-shadow: 0 0 6px rgba(0,0,0,.16),0 5px 10px rgba(0,0,0,.32);
		color:white;
		transition:all 0.2s;
		font-size: 50px;
		padding:5px;
		text-align: center;
		line-height: 60px;
		cursor: pointer;
		margin-top:15px;
		transform:scale(0.85);
	}
	.admin_settings {bottom:20px;background-color: #fafafa;transform:scale(0.9);font-size: 18px}
	.admin_settings i.fa {color:#333333;font-size: 30px;line-height: 60px;transition:all 0.2s;}
	.admin_settings:hover {transform:scale(1);}
	.admin_settings:hover i.fa {transform:rotate(90deg);}
	
	.adminAction .add:hover {
		opacity: 1;
		
	}
	.adminAction .add.copypage {font-size:25px;background-color:blue}
	.adminAction .add.copypage:hover {background-color:gray;transform:scale(0.96)}
	.adminAction .add.copypage.copied, .adminAction .add.copypage.pastePage {background-color:orange}
	.adminAction .add.newpage i, .adminAction .add.copypage i {line-height:60px}
	.adminAction .add.newpage {line-height:normal;font-size: 18px;transform:scale(0.9);transition:all 0.2s;background-color: green;text-overflow:clip;color: white}
	//.adminAction:hover > .add.newpage{transform:none;transition-delay:0.05s;}
	//.adminAction:hover > .add.newpage.sub{background-color: orange;transition-delay:0.1s;}
	.adminAction.top {visibility:hidden;margin-top:-20px;position:absolute;<?=$SITE[align];?>:auto;top:auto;bottom:auto;display:inline-block;margin-<?=$SITE[align];?>:40px;}
	.adminAction.top .add.newpage {width:40px;height:40px;}
	.adminAction.top .add.newpage i {line-height:40px;}
	.topMenuNew nav:hover .adminAction.top {visibility:visible}
	.adminAction .add.newpage .label , .admin_settings .label, .adminAction .add .label{
		width:120px;
		position:absolute;
		margin:-45px 90px 0px;
		background-color: #333333;
		border-radius:3px;
		height:20px;
		padding:5px;
		line-height: normal;
		opacity: 0;
		transition:all 0.2s;
		z-index: 1;
		font-size:20px;
		transform:scale(0.8);
	}
	.adminAction .add:hover .label, .admin_settings:hover .label {
		opacity:1;
		transform:scale(1);
		
	}
.gal_styling {}
.rightSide {box-sizing:border-box;border:1px solid transparent}	

.elEditorButton{display:none;position:absolute;margin-top:-30px;}

.topHeaderLogo #newSaveIcon {display:inline;}
.topHeaderLogo:hover .elEditorButton{display:block}
	
	 input.goodcheckbox[type=checkbox] {visibility: hidden;}
	 i.fa.checkbox {font-size: 30px;transition:all 0.3s;}
	 label[for="goodcheckbox"] {position: absolute;left:0;cursor: pointer;}
	 input.goodcheckbox[type=checkbox]:checked + label {color:green;}

