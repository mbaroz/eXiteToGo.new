<?php
session_start();
$useragent = $_SERVER['HTTP_USER_AGENT'];
header("Content-Type: text/css");
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
body,.like{
	color:#<?=$SITE[contenttextcolor];?>;
}
.like {
	text-align:<?=$SITE[opalign];?>;
	margin-right:60px;
	margin-bottom:10px;
}
.wallkit_postcontent,.wallkit_postcontent a,.connect_widget,.connect_widget_not_connected_text  {
	color:#<?=$SITE[contenttextcolor];?>;
}
.uiBoxGray  {
	background-color:transparent;
	border:0px;
}
.fbFeedbackContent {
	background-color:#<?=$SITE[formbgcolor];?>;
}
.wallkit_form,label,.namelink a {
	color:#<?=$SITE[formtextcolor];?>;
}
.wallkit_form textarea {
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
	border-color:#<?=$SITE[seperatorcolor];?>;
}
.wallkit_post {
	border-bottom:1px solid #<?=$SITE[seperatorcolor];?>;
}
.profile_pic {
	margin-top:23px;
	
	padding:0px;
}
.profile_pic img {
	border:1px solid #<?=$SITE[seperatorcolor];?>;
}
.fbConnectWidgetTopmost {
	border-width:0px;
}

.fan_box .connections{
  padding-<?=$SITE[align];?>: 5px !important;
  margin-<?=$SITE[align];?>: 0 !important;
  border: 0 !important;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
  font-weight: bold;
 color:#<?=$SITE[slogentextcolor];?>;;
}
.fan_box .connect_top{
  background: none !important;
  padding-<?=$SITE[align];?>: 15px !important;
  font-family:arial;
}

.fan_box .full_widget {
	border: 0 !important;
	background: none !important;

}
.fan_box .connections{
	border: 0 !important;
}
.fan_box .connections span.total{
	padding-<?=$SITE[align];?>:11px;
}
.fan_box .connections_grid .grid_item{
	padding: 0 10px 11px 0 !important;
	width:55px;
}
.fan_box .connect_action .name, .fan_box .connect_action a {
	color:#<?=$SITE[slogentextcolor];?>;
	font-family:arial;
}
.fan_box .connections_grid .grid_item .name{color:#<?=$SITE[fb_names_color];?>;}
.fan_box .connections_grid .grid_item img {border:2px solid #<?=$SITE[fb_names_border_color];?>;}