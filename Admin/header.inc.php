<?
include_once("../config.inc.php");
$SITE['cdn_url']="//cdn.exiteme.com";
$href_url=$SITE[url].$_SERVER['REQUEST_URI'];
$site_url_check=str_ireplace("http://","",$SITE[url]);
if (stristr($SITE[url],"https://")) $site_url_check=str_ireplace("https://","",$SITE[url]);
if ($_SERVER['HTTP_HOST']!=$site_url_check) {
	Header("HTTP/1.1 301 Moved Permanently");
	header("Location:".$href_url);
}

//include_once("lang.admin.he.inc.php");
include_once("lang.admin.php");
include_once("../defaults.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl">
<head>
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/Admin/AdminEditing.css.php">
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/shadowbox/shadowbox.css">
<link rel="shortcut icon" href="<?=$SITE[url];?>/gallery/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/bootstrap_tooltips.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//d3jy1qiodf2240.cloudfront.net/css/animate.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//d3jy1qiodf2240.cloudfront.net/css/he_fonts.css">
<link rel="stylesheet" type="text/css" href="//d3jy1qiodf2240.cloudfront.net/css/loaders.min.css">
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

<script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
<script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.9.2.custom.min.js"></script>
<script language="javascript" src="<?=$SITE[url];?>/js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=$SITE[cdn_url];?>/js/datatables/dataTables.buttons.min.js"></script>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript">
function SetCookie(cookieName,cookieValue,nDays) {
	 var today = new Date();
	 var expire = new Date();
	 if (nDays==null || nDays==0) nDays=1;
	 expire.setTime(today.getTime() + 3600000*24*nDays);
	 document.cookie = cookieName+"="+escape(cookieValue) + ";expires="+expire.toGMTString();
}


function showShopOptions() {
	jQuery("ul.dropdown li.shopMenu").toggleClass("show");
	jQuery("ul.dropdown li.shopMenu ul").toggleClass("animated fadeIn");
}
function showNotification(st) {
	if (st==1) {
		jQuery(".msgGeneralAdminNotification").addClass("show animated fadeInUp").removeClass("fadeOutUp");
		window.setTimeout('showNotification(0)',3000);
	}
	else jQuery(".msgGeneralAdminNotification").addClass("animated fadeOutUp");

}
</script>
<?include_once("../clientscripts.inc.php");?>
<style type="text/css">
body {font-family: almoni-dl-aaa-400;-webkit-font-smoothing: antialiased !important;font-size: 17px;color:#222;}
h3 {font-size: 23px;}
a:active     { font-family: inherit; text-decoration:none }
a    { font-family: inherit; text-decoration:none;color:#222 }
.sideAdminEditing {
	background-color: #fff;
	width:300px;height: 100%;
	position: fixed;
	box-shadow: 0px 0px 10px -3px #333;
	<?=$SITE[align];?>:0;
}
.sideAdminEditing .logoAdminContainer{background-color: #efefef;min-height: 50px}
.sideAdminEditing .logoAdminContainer img {max-height: 50px;}
.leftAdmin{position:fixed;height: 100%;box-sizing:border-box;margin-<?=$SITE[align];?>: 300px}
.leftAdmin .inside {padding:15px;overflow: auto;height: 100%}
.sideAdminEditing .inside {overflow: auto;direction: ltr;height:100%;}
ul.dropdown {
 height:100%;
 padding:0px;margin:0px;
 direction: <?=$SITE_LANG[direction];?>;
 
}
ul.dropdown li {
	line-height: 1.2em;
	vertical-align: middle;
	zoom: 1;
	margin-bottom:0px;
	list-style: none;
	cursor:pointer;
	padding:10px;
	background-color: #f7f7f7;
	margin:10px 0px;
}

ul.dropdown li a {display: inline-block;width:50%;}
ul.dropdown > li:hover, ul.dropdown li.current {background-color: #dedede}
.topAdminEditing{position: fixed;top:20px;<?=$SITE[opalign];?>:20px;z-index:1000;}
ul.dropdown li i.icon, .topAdminEditing a i.icon, .generalScreen i.icon {
	padding:5px;
	background-color: #fff;
	border-radius: 50%;
	width:20px;height:20px;
	text-align: center;
	line-height: 20px;
	border:1px solid silver;
	border-spacing: 2px;
	margin:0 5px;

}
.topAdminEditing a i.icon:hover {background-color: #333;color:white;}
.topAdminEditing a i.icon.fa-power-off:hover{background-color: rgb(224, 6, 6);color:white;}
ul.dropdown li i.arrow {
	float:<?=$SITE[opalign];?>;
	margin-top:8px;
}
ul.dropdown li i {transition: all 0.4s;}
ul.dropdown li.shopMenu.show i.arrow {transform:rotate(-90deg);}
ul.dropdown li ul:hover {background-color: none;}
ul.dropdown li ul {
	margin:0px;padding:0px;
}
ul.dropdown li.shopMenu ul {display: none}
ul.dropdown li.shopMenu.show ul {display: block}
ul.dropdown li.shopMenu:hover {
	background-color: none;
}

.button {
	width:200px;
	padding:5px;
}
.msgGeneralAdminNotification {
	position:fixed;
	width:200px;min-height:30px;
	padding:10px;
	background-color:#333;
	color:white;
	height:50px;
	bottom:20px;
	<?=$SITE[opalign];?>:20px;
	display: none;
	text-align: center;
	z-index: 20000;
}
#newSaveIcon.greenSave{font-size:17px;width:180px;height:26px;line-height: 1.6}
.msgGeneralAdminNotification.show{display: block;}
.loader {width:800px;height:100%;margin:40% auto;text-align: center;}
.loader i.fa {color:silver;}
select#MassStatus {width:180px;height:26px;font-family: inherit;padding:3px;border:none;font-size: inherit;}
.selectBoxWrap {display:inline-block;width:180px;height:26px;border:1px solid silver;background-color: white}
</style>

</head>
<title><?=$SITE[name];?> - <?=$ADMIN_TRANS['welcome to management of'];?></title>
<body leftmargin="0" topmargin="0" class="adminBody">
	<div class="msgGeneralAdminNotification"></div>
