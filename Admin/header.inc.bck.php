<?
include_once("../config.inc.php");
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
<script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
<script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/js/exiteTooltip.js"></script>
<script type="text/javascript" src="<?=$SITE[url];?>/js/shadowbox/shadowbox.js"></script>
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


Shadowbox.init({
		    language:   "en",
		     viewportPadding:1,
		    autoplayMovies:true
		  
});
</script>
<?include_once("../clientscripts.inc.php");?>
<style type="text/css">
body {font-family: almoni-dl-aaa-400;-webkit-font-smoothing: antialiased !important;}
a:active     { font-family: inherit; text-decoration:none }
a    { font-family: inherit; text-decoration:none;color:blue }

ul.dropdown {
 position: relative;
 
}
ul.dropdown li {
	float: <?=$SITE[align];?>;
	line-height: 1.2em;
	vertical-align: middle;
	zoom: 1;
	margin-bottom:0px;
	list-style: none;
	cursor:pointer;
}
ul.TemplateDropDownNew li {
	float:none;
}
ul.TemplateDropDownNew li:hover >a{color:white}
ul.TemplateDropDownNew li a {text-decoration: none;color: #333333}
.seperator {
	width:1px;
	background-color:gray;
	height:11px;
	margin:2px 5px 0px 5px;
	
}
#shop_settings {
        padding:3px;
	cursor:auto;
}
</style>

</head>
<title><?=$SITE[name];?> - <?=$ADMIN_TRANS['welcome to management of'];?></title>
<body leftmargin="0" topmargin="0" class="adminBody">
<table border="0" class="general" cellpadding="5"  width="100%">
<tr>
<td class="title" align="<?=$SITE[align];?>" valign="top" style="height:30px;">
<?=$ADMIN_TRANS['welcome to management of'];?> - <a href="<?=$SITE[url];?>?m_p_o=1"><?=$SITE[name];?></a>
</td>
</tr>
<tr>
<td valign="top" align="<?=$SITE[align];?>" class="general" height="10">
<ul class="dropdown">
	<li><?=$ADMIN_TRANS['user'];?><b>: <?=$MEMBER[Email];?></li><li class="seperator"></li>

<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	print '<li><a href="configAdmin.php">'.$ADMIN_TRANS['general settings'].'</a></li><li class="seperator"></li>';
	if($shopActivated)
	{
		?> <li class="admin_menu_sub"><a onclick="showShopOptions();"><?=$SHOP_TRANS['shop'];?>
			<ul class="shopMenu" style="display: none">
				<li><a href="emailsAdmin.php"><?=$SHOP_TRANS['adminEmails'];?></a></li>
				<li><a href="shopConfigAdmin.php"><?=$SHOP_TRANS['shopOptions'];?></a></li>
				<li><a href="shopOrdersAdmin.php"><?=$SHOP_TRANS['shopOrders'];?></a></li>
				<li><a href="shopCountriesAdmin.php"><?=$SHOP_TRANS['countries_admin'];?></a></li>
				<li><a href="shopShippingsAdmin.php"><?=$SHOP_TRANS['shippings_admin'];?></a></li>
				<li><a href="shopCouponsAdmin.php"><?=$SHOP_TRANS['coupons_admin'];?></a></li>
			</ul>
		</li><li class="seperator"></li>
		
		
		
		<?
	}
	print '<li><a href="changePass.php">'.$ADMIN_TRANS['change password'].'</a></li><li class="seperator"></li>';
	print '<li><a href="listAdmins.php">'.$ADMIN_TRANS['site managers'].'</a></li><li class="seperator"></li>';
	print '<li><a href="listUsers.php">'.$ADMIN_TRANS['users list'].'</a></li><li class="seperator"></li>';
	print '<li><a href="formHistoryAdmin.php">'.$ADMIN_TRANS['forms list'].'</a></li><li class="seperator"></li>';
	print '<li><a href="ManageRedirects.php">'.$ADMIN_TRANS['301 redirects'].'</a></li><li class="seperator"></li>';
	if ($SITE[mobileEnabled]) print '<li><a href="mobileConfig.php">'.$ADMIN_TRANS['mobile settings'].'</a></li><li class="seperator"></li>';
	print '<li><a href="'.$SITE[url].'" target=_newTarget>'.$ADMIN_TRANS['go to website'].'</a></li><li class="seperator"></li>';
	print '<li><a href="http://www.exite.co.il/category/שאלות-ותשובות" target=_newTarget>'.$ADMIN_TRANS['faq'].'</a></li><li class="seperator"></li>';
}
?>
<li><a href="so.php"><?=$ADMIN_TRANS['sign out'];?></a></li>
</ul>
</td>
</tr>
<td align="left">
</td>
</tr>
</table>
<script>
jQuery(".admin_menu_sub").popover({
	placement:'bottom',trigger:'click',html:true,delay:{hideTip:3500},
	content:'<ul class="TemplateDropDownNew">'+jQuery(".shopMenu").html()+'</ul>',
});
	
</script>