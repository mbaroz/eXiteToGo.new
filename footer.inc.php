<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<?if ($SITE[mobileEnabled] AND !isset($_SESSION['LOGGED_ADMIN'])) {?>
	<link rel='stylesheet' type="text/css" media="only screen and (max-device-width: 680px) ,(max-width:680px)" href='<?=$SITE[url];?>/css/rwd-post.css.php?catType=<?=$CHECK_CATPAGE[CatType];?>&site_align=<?=$SITE[align];?>&collageGallery=<?=$GAL_OPTIONS[collage_gallery];?>&shop_productPage=<?=$CHECK_PAGE[ProductID];?>' />
	<div class="fixed_footer">
		<div class="inner">
			<div class="icon" id="exite_topTop"><a href="#/TopHead"><i class="fa fa-angle-up fa-2x"></i></a></div>
			<div class="icon" id="contact"><i class="fa fa-envelope-o fa-2x"></i></div>
			<?
			if ($SITE[bizaddress]) {
				?><div class="icon" id="map"><i class="fa fa-map-marker fa-2x"></i></div><?
			}
			
			if ($SITE[bizphone]) {
			?><div class="icon" id="phone"><a href="tel:<?=$SITE[bizphone];?>"><i class="fa fa-phone fa-2x"></i></a></div><?}
			?>
			<div class="icon" id="wu"><a href="whatsapp://send?text=<?=$P_DETAILS[TagTitle];?> <?=$SITE[url].$_SERVER['REQUEST_URI'];?>" data-text="" data-href="<?=$SITE[url].$_SERVER['REQUEST_URI'];?>" style="display:" class="wu"><i class="fa fa-whatsapp fa-2x"></i></a></div>
			<div class="icon_close" id="close_icon"><div>+</div></div>
			<div class="icon" onclick="toggleCart();" id="shopping_cart" <?=(count($_SESSION['ShoppingCart'])==0) ? 'style=display:none;' : '';?>><div class="cart_count animated bounceIn"><?=count($_SESSION['ShoppingCart']);?></div><i class="fa fa-shopping-cart fa-2x"></i></div>
		</div>
		<div class="outer">
			<i class="fa fa-spinner fa-cog"></i>
		</div>
	
	</div>
	<?
	if ($SITE[mobileEnabled] AND $mobileDetect->isMobile()) {
		if (file_exists("mobileAddons.php")) include_once("mobileAddons.php");
	}
	if ($SITE[mobile_preview]==1 AND isset($mobilePreview)) {
		$_SESSION['LOGGED_ADMIN']=sha1(session_id());
		}
}
	?>
<div class="footer_bg">
<!-- If Rounded Corners then -->
<?
$allfooterClass="footer";
if ($SITE[contentfootermargin]=="") $SITE[contentfootermargin]=0;
print '<div style="height:'.$SITE[contentfootermargin].'px;margin:0px"></div>';
if ($SITE[footerfullwidth]) {
	print '<div class="footerFull">';
	$allfooterClass="footerWide";
}
$topfooter_roundedcolor=$SITE[footerbgcolor];
if ($SITE[topfooterbgcolor]) $topfooter_roundedcolor=$SITE[topfooterbgcolor];
?>
<?
if ($SITE[roundcorners]==1 AND !$SITE[footerfullwidth]) SetRoundedCorners(1,0,$topfooter_roundedcolor);
$C=GetContent("footer");
$C_MULTI=GetMultiContent($urlKey,"footer");
$footerPageID=$C[PageID];
$multiFooterPageID=$C_MULTI[PageID][0];

?>
<!--END OF: Rounded Corners -->
<div class="<?=$allfooterClass;?>">
	<div class="footerTopColor">
	<div class="footerText">
	<?
	
	if (isset($_SESSION['LOGGED_ADMIN']) AND $CHECK_CATPAGE AND $multiFooterPageID) {
		?>
		<script language="javascript">
		var footerMultiTitle="";
		
		currentPageID="<?=$multiFooterPageID;?>";
		var pageUrlKey=new Array();
		pageUrlKey[<?=$multiFooterPageID;?>]="<?=$C_MULTI[UrlKey][0];?>";
		</script>
		<span id="titleContent_<?=$multiFooterPageID;?>" style="display:none;"><?=$C_MULTI[PageTitle][0];?></span>
		<span id="p_url_<?=$multiFooterPageID;?>" style="display:none"><?=$C_MULTI[PageUrl][0];?></span>
		<div id="newSaveIcon" style="min-width:138px" onclick="EditHere(<?=$multiFooterPageID;?>,'',1)"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" align="absmiddle" border="0"><?=$ADMIN_TRANS['edit page footer'];?></div>
		<div style="clear:both"></div>
		<?
	}
	else if (isset($_SESSION['LOGGED_ADMIN']) AND $CHECK_CATPAGE) {
		?>
		<script language="javascript">
		
		var footerMultiTitle="";
		function setFooterTitle() {
			footerMultiTitle="footer_<?=$CHECK_CATPAGE[parentID];?>";
			EditHere(<?=$CHECK_CATPAGE[parentID];?>,1,1);
		}
		</script>
		<div id="newSaveIcon" style="min-width:138px" onclick="setFooterTitle();"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" align="absmiddle" border="0" title="<?=$ADMIN_TRANS['edit page footer'];?>"><?=$ADMIN_TRANS['edit page footer'];?></div>
		
		<?
	}
	?>
		<span id="divContent_<?=$multiFooterPageID;?>">
	<?
	print str_ireplace("&lsquo;","'",$C_MULTI[PageContent][0]);
	?>
	</span>
	</div>
	</div>
	<?
	if ($SITE[mobileEnabled] AND !$NoMobileCredit==1) {
		if ($mobileDetect->isMobile()) {
			if ($SITE_LANG[selected]=="he") $credit_text="עיצוב אתרי מובייל";
			else $credit_text="Mobile web design";
			print '<div class="mobile_credit"><a href="http://www.exite.co.il" target="_blank" style="outline:none"><img src="http://www.exite.co.il/userfiles/images/mobile/logo_mobile.png" border="0">'.$credit_text.'</a></div>';
		}
		?>
		<div class="fixed_footer_marginizer"></div>
		<?
	}
	?>
	<div class="footerText" id="site_wide_footer">
	<?
	
	if (isset($_SESSION['LOGGED_ADMIN']) AND $CHECK_CATPAGE AND $P_DETAILS[HideTopMenu]==0) {
		?>
		<script language="javascript">
		currentPageID="<?=$footerPageID;?>";
		var pageUrlKey=new Array();
		pageUrlKey[<?=$footerPageID;?>]="<?=$C[UrlKey];?>";
		</script>
		<span id="titleContent_<?=$footerPageID;?>" style="display:none;"><?=$C[PageTitle];?></span>
		<span id="p_url_<?=$footerPageID;?>" style="display:none"><?=$C[PageUrl];?></span>
		<div style="margin-top:5px;min-width:138px" id="newSaveIcon" onclick="EditHere(<?=$footerPageID;?>,'',1)"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" align="absmiddle" border="0"> <?=$ADMIN_TRANS['edit global footer'];?></div>
		<div class="clear"></div>
		<?
	}
	?>
		<span id="divContent_<?=$footerPageID;?>">
	<?
	if ($P_DETAILS[HideTopMenu]==0) print str_ireplace("&lsquo;","'",$C[PageContent]);
	?>
	</span>
	</div>
</div>

<!-- If Rounded Corners then -->
	<?if ($SITE[roundcorners]==1AND !$SITE[footerfullwidth]) SetRoundedCorners(0,0,$SITE[footerbgcolor]);?>
<!--END OF: Rounded Corners -->
<?if ($SITE[footerfullwidth]) print '</div>';
else print '<br />';?> <!--  End of Footer full-->

	</div>
</div>

<!--Google Analytics Code-->
<?
if ($SITE[siteoverlaypic] OR $SITE[pageoverlaypic]) {
	?>
	<script language="javascript">
	jQuery(document).ready(function() {
	window.setTimeout('jQuery("#site_overbg").show();',80);
	});
//	
	</script>
	<?
}


?>
<?
if ($SITE[addon_code]) print $SITE[addon_code];
?>
<?include_once("footerAddons.php");?>
<?
if ($SITE[showmasterheaderfooter]==2 OR $SITE[showmasterheaderfooter]==3) include_once("master_footer.php");
?>
<script>
	jQuery('iframe[src*="youtube.com"]').each(function() {
	
		var current_iframe_src=jQuery(this).attr("src");
		if (current_iframe_src.indexOf("wmode=transparent")==-1) {
			var fixed_src = jQuery(this).attr('src') + '?wmode=transparent';
			if (current_iframe_src.indexOf("?")>-1) fixed_src = jQuery(this).attr('src') + '&amp;wmode=transparent';
			jQuery(this).attr('src', fixed_src);	
		}
		
});
var docHeight=jQuery(window).height();
var siteHeight=jQuery(".mainPage").height();
function setContentAreaMinHeight() {
	var siteHeight=jQuery(".mainPage").height();
	var expectedHeight=docHeight-jQuery(".footer_bg").height()-jQuery(".topHeaderMain").height()-jQuery(".topHeader").height()-jQuery(".masterHeader_wrapper").height()-40;
	console.log(expectedHeight);

	if (siteHeight<(docHeight)) jQuery(".mainContentContainer").css('min-height',expectedHeight+'px');
	jQuery(".footer_bg").css("opacity","1");
	
}

jQuery(document).ready(function() {
	jQuery(".footer_bg").css("opacity","0");
	window.setTimeout('setContentAreaMinHeight();',500);

	
});
<?if (!$SITE[showmasterheaderfooter]==2 AND !$SITE[showmasterheaderfooter]==3) {
	?>
	jQuery(window).resize(function() {
			docHeight=jQuery(window).height();
			var expectedHeight=docHeight-jQuery(".footer_bg").height()-jQuery(".topHeaderMain").height()-jQuery(".topHeader").height()-jQuery(".masterHeader_wrapper").height()-40;
			
			if (siteHeight<docHeight) jQuery(".mainContentContainer").css('min-height',expectedHeight+'px');	
		});
	<?
	}?>
</script>
<?

if ($SITE[slidoutcontentenable]==1) include_once("SlideOutContent.php");
//include_once("accecibility.php");
if (!isset($_SESSION['LOGGED_ADMIN']) AND $SITE[googleremarketingcode]) print stripslashes(htmlspecialchars_decode($SITE[googleremarketingcode]));
//if ($db) mysqli_close($db->$dbConnectionID);
if (isset($_SESSION['LOGGED_ADMIN'])) {	
	$is_inner_page=0;
	if ($CHECK_PAGE) $is_inner_page=1;
	print '<div class="globalSettingsWrapper"><div class="icon_close">+</div><div id="gSettingsInner"></div></div>';
	?>
	
	<style>.ui-corner-all {border:0px;border-color:none}</style>
	<div class="adminAction">
	
	<div class="add newpage"><i class="fa fa-plus"></i>
		<div class="label"><?=$ADMIN_TRANS['add new page'];?></div>
	</div>
	<?
	if (($CURRENT_CTYPE==0 OR $CURRENT_CTYPE==1 OR $CURRENT_CTYPE==2  OR $CURRENT_CTYPE==11 OR $CURRENT_CTYPE==12 OR $CURRENT_CTYPE==21) AND (!$CHECK_PAGE)) {
		?>
		<div class="add copypage <?=$cp_action;?>" onclick="copyCategory(<?=$CHECK_CATPAGE[parentID];?>,'<?=$cp_action;?>',0);"><i class="fa fa-files-o"></i>
			<div class="label"><?=$COPY_LABELS[$SITE_LANG[selected]]['CopyPage'];?></div>
		</div>
		<?
	}
	
	?>

	</div>
	<div class="admin_settings"><i class="fa fa-cogs"></i>
	<div class="label"><?=$ADMIN_TRANS['page style'];?></div>
	</div>
	<script>
	jQuery(".admin_settings").click(function(){
		if (jQuery(".globalSettingsWrapper.show").length<1) {
			jQuery(".globalSettingsWrapper #gSettingsInner").load("/Admin/GetGlobalSettings.php?urlKey=<?=$urlKey;?>&is_inner_page=<?=$is_inner_page;?>",function() {
				jQuery(".globalSettingsWrapper").toggleClass("show");
			});
		}
		
			
		
	});
	jQuery(".adminAction .add.newpage").click(function(){
		if (jQuery(".globalSettingsWrapper.show").length<1) {
			jQuery(".globalSettingsWrapper #gSettingsInner").load("/Admin/GetGlobalSettings.php?urlKey=<?=$urlKey;?>&action=addPage",function() {
				jQuery(".globalSettingsWrapper").toggleClass("show");
			});
		}
		

	});

	</script>
	<?
	
	
	$MEMBER_GUIDE_SHOWN=json_decode($MEMBER['FAILS'],true);
	
	if ($MEMBER_GUIDE_SHOWN['guide_activated']!=1) include_once("guide.php");
}
?>

</body>
</html>