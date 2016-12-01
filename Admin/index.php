<?
include_once("checkAuth.php");
include_once("header.inc.php");
//~~~~~~~~~~~~~~~~~~~~~~~Start Changes Copy Here~~~~~~~~~~~~~~~~~~~~~~~~~~~~
?>
<script src="../js/prototype.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$SITE['cdn_url'];?>/ckeditor/ckeditor.js"></script>
<div class="topAdminEditing">
	<a href="<?=$SITE[url];?>?m_p_o=1" title="<?=$ADMIN_TRANS['go to website'];?>"><?=$ADMIN_TRANS['go to website'];?><i class="fa fa-external-link icon"></i></a>
	<a href="<?=$SITE[url];?>/Admin/so.php" title="<?=$ADMIN_TRANS['sign out'];?>"><i class="fa fa-power-off icon"></i>&nbsp;</a>

</div>
<div class="sideAdminEditing">
	<div align="center" style="padding-top:10px 5px" class="logoAdminContainer">
	<?
	$CHK_LOGO=explode(".",$SITE[logo]);
	if ($CHK_LOGO[1]=="png" OR $CHK_LOGO[1]=="jpg")
		{
		?>
		<a href="<?=$SITE[url];?>?m_p_o=1"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[logo];?>" /></a>
		<?
		}
		else {
			print '<a href="'.$SITE[url].'?m_p_o=1"><div class="text_logo_insite">'.$SITE[logo].'</div></a>';
		}	
	?>
	</div>
	<div class="inside">
	<ul class="dropdown">
		

		<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {
			print '<li class="configAdmin"><i class="fa fa-cog icon"></i><a href="#configAdmin">'.$ADMIN_TRANS['general settings'].'</a><i class="fa fa-chevron-'.$SITE[opalign].' arrow"></i></li>';
			
			print '<li class="changePass"><i class="fa fa-unlock-alt icon"></i><a href="#changePass">'.$ADMIN_TRANS['change password'].'</a><i class="fa fa-chevron-'.$SITE[opalign].' arrow"></i></li>';
			print '<li class="listAdmins"><i class="fa fa-user-plus icon"></i><a href="#listAdmins">'.$ADMIN_TRANS['site managers'].'</a><i class="fa fa-chevron-'.$SITE[opalign].' arrow"></i></li>';
			print '<li class="listUsers"><i class="fa fa-users icon"></i><a href="#listUsers">'.$ADMIN_TRANS['users list'].'</a><i class="fa fa-chevron-'.$SITE[opalign].' arrow"></i></li>';
			print '<li class="formHistoryAdmin"><i class="fa fa-list-ul icon"></i><a href="#formHistoryAdmin">'.$ADMIN_TRANS['forms list'].'</a><i class="fa fa-chevron-'.$SITE[opalign].' arrow"></i></li>';
			if($shopActivated)
			{
				?> <li class="shopMenu"><i class="fa fa-usd icon"></i><i class="fa fa-chevron-<?=$SITE[opalign];?> arrow"></i><a onclick="showShopOptions();"><?=$SHOP_TRANS['shop'];?></a>
					<ul>
						<li class="shopConfigAdmin"><a href="#shopConfigAdmin"><?=$SHOP_TRANS['shopOptions'];?></a></i></li>
						<li class="emailsAdmin"><a href="#emailsAdmin"><?=$SHOP_TRANS['adminEmails'];?></a></li>
						<li class="shopOrdersAdmin"><a href="#shopOrdersAdmin"><?=$SHOP_TRANS['shopOrders'];?></a></li>
						<li class="shopCountriesAdmin"><a href="#shopCountriesAdmin"><?=$SHOP_TRANS['countries_admin'];?></a></li>
						<li class="shopShippingsAdmin"><a href="#shopShippingsAdmin"><?=$SHOP_TRANS['shippings_admin'];?></a></li>
						<li class="shopCouponsAdmin"><a href="#shopCouponsAdmin"><?=$SHOP_TRANS['coupons_admin'];?></a></li>
						<li class="shopProductsAdmin"><a href="#shopProductsAdmin"><?=$SHOP_TRANS['items'];?></a></li>
					</ul>
				</li>

				<?
			}
			print '<li class="ManageRedirects"><i class="fa fa-retweet icon"></i><a href="#ManageRedirects">'.$ADMIN_TRANS['301 redirects'].'</a><i class="fa fa-chevron-'.$SITE[opalign].' arrow"></i></li>';
			if ($SITE[mobileEnabled]) print '<li class="mobileConfig"><i class="fa fa-mobile icon"></i><a href="#mobileConfig">'.$ADMIN_TRANS['mobile settings'].'</a><i class="fa fa-chevron-'.$SITE[opalign].' arrow"></i></li>';
			
			print '<li id=""><i class="fa fa-question-circle icon"></i><a href="http://support.exite.co.il/" target=_newTarget>'.$ADMIN_TRANS['faq'].'</a><i class="fa fa-chevron-'.$SITE[opalign].' arrow"></i></li>';
		}
		?>
		<li style="color:silver;"><?=$ADMIN_TRANS['user'];?><b>: <?=$MEMBER[Email];?></li>
		
	</ul>
	<br><br>
</div>


</div>
<div class="leftAdmin">
	<div class="inside"></div>
</div>

<script type="text/javascript">
var lastLoadedPage="";
function loadAdminPanelFile(d) {
	if (d!="") jQuery(".leftAdmin .inside").load(d);
}
function loadAdminPanel(d) {
	//jQuery("ul.dropdown li").removeClass("current");
	//jQuery("ul.dropdown li."+d).addClass("current");

	lastLoadedPage=d;
	var loaderFile;
	if (d.indexOf("?")>0) loaderFile=d.replace("?",".php?");
	else loaderFile=d+".php";
	jQuery(".leftAdmin .inside").html('<div class="loader"><i class="fa fa-spin fa-5x fa-refresh"></i></div>');
	jQuery(".leftAdmin .inside").load(loaderFile);
	jQuery(".leftAdmin .inside").width(jQuery(window).width()-340+"px");
}
jQuery("ul.dropdown li").not("ul.dropdown li.shopMenu").click(function() {
	jQuery("ul.dropdown li").removeClass("current")
	jQuery(this).addClass("current");
	var loc=jQuery(this).children("a").attr("href").replace(/^.*?(#|$)/,'');
	loadAdminPanel(loc);


});
jQuery(document).ready(function() {
	var hashVAL=window.location.hash.replace(/^.*?(#|$)/,'');
	if (hashVAL=="") window.location.href="#configAdmin";
	if (hashVAL!="") loadAdminPanel(hashVAL);
	jQuery(window).on("hashchange",function(){
		var hashVAL=this.location.hash.replace(/^.*?(#|$)/,'');
		if (hashVAL!="") loadAdminPanel(hashVAL);
	});

})
</script>

<?include_once("footer.inc.php");?>