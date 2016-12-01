<?
//$ParentCatContentBGColor=GetCatStyle("CatContentBGColor",$CHECK_)
if ($CHECK_PAGE) {
	$PCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
	if ($CHECK_PAGE[productUrlKey]) $PCatUrlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
	$PARENT_CAT_INFO=GetIDFromUrlKey($PCatUrlKey);
	$parent_contentBGColor=GetCatStyle("CatContentBGColor",$PARENT_CAT_INFO[parentID]);
	if ($parent_contentBGColor) {
		$SITE[contentbgcolor]=$parent_contentBGColor;
		print '<style>.customBGColor {background-color:#'.$parent_contentBGColor.';}</style>';
	}
}
$class_post="";
if ($CHECK_PAGE[ProductID]) $class_post=" productPage_eXite";
?>
<!-- If Rounded Corners then -->
<?if ($SITE[roundcorners]==1) SetRoundedCorners(1,0,$SITE[contentbgcolor]);?>
<!--END OF: Rounded Corners -->
<div class="mainContentContainer customBGColor<?=$class_post;?>">
	<div class="mainContent customBGColor">
<div class="rightSide" style="padding-top:10px">
	<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		if (!$CHECK_PAGE OR $CHECK_PAGE[galleryID]) include_once("Admin/CatNewsSwitch.php");
		 include_once("Admin/CategoryEdit.php");
		}
	
	if ($CHECK_PAGE) {
		$PageCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
		
	}
	if (isset($_SESSION['LOGGED_ADMIN']) OR ($ROOT_URLKEY[ParentMenuTitle]!=" " AND !$CHECK_PAGE) OR $CHECK_PAGE[galleryID] OR $CHECK_PAGE[ProductID]) {
		?><span id="sideCatTitle" class="sideCatTitle">
		<?
		if ($SITE[titlesicon] AND $ROOT_URLKEY[ParentMenuTitle]!="") {
			?><div class="titlesIcon"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
			<?
		}
		?>
		<div id="catTitle-<?=$CHECK_CATPAGE[parentID];?>"><?=$ROOT_URLKEY[ParentMenuTitle];?></div>
		</span>
		<?
		
	}
	if($CHECK_CATPAGE['CatType'] == 14 && $SITE['attrSearchPosition'] == 'ontoSiteSearch')
			require_once 'shopSearchAttrs.php';
			
	if ($SITE[searchformtop]==3) {
		?>
		<div style="margin-<?=$SITE[align];?>:16px;margin-bottom:10px">
		<?include_once("searchForm.inc.php");?>
		
		</div>
		<?
	}
	if($CHECK_CATPAGE['CatType'] == 14 && $SITE['attrSearchPosition'] == 'ontoSubMenus')
			require_once 'shopSearchAttrs.php';
			
	if($urlKey == 'order' && $SITE['shopOrderListSide'] == 1)
			require_once 'shopCartList.php';
	
	include_once("sideCatContentTop.php");
	if (isNewsPage($urlKey) OR isNewsProductPage($CHECK_PAGE[galleryID])) include_once("news.php");
		else {
			if (isset($_SESSION['LOGGED_ADMIN'])) include_once("Admin/CatEditIcon.php");
			SetSideMenu($urlKey);
			
		}
	 include_once("sideCatContent.php");
	 include_once("SideContactForm.inc.php");
	 if(($CHECK_PAGE['ProductID'] > 0 || $CHECK_CATPAGE['CatType'] == 14) && $SITE['attrSearchPosition'] == 'underSubMenus')
			require_once 'shopSearchAttrs.php';
	if($CHECK_PAGE['ProductID'] > 0 && $SITE['shopRelatedPosition'] == 'side')
			require_once 'shopRelated.php';
		?>
	</div><!-- End RightSide -->
		
	<div class="leftSide">
		<div class="breadCrumb">
			<?
			if (!$P_DETAILS[HideTopMenu]) print GetBreadCrumb($urlKey);?>
			</div>
			<div class="contentOuter">
				<?if ($urlKey) include_once("GetPageContent.php");?>
				<div class="clear"></div>
			</div>
		<div style="height:15px"></div>
</div>
<?if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('catTitle-<?=$CHECK_CATPAGE[parentID];?>', '<?=$SITE[url];?>/Admin/saveTitles.php?type=cat', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'catTitle-<?=$CHECK_CATPAGE[parentID];?>',formClassName:'sideCatTitle'});
		</script>
		<?
	}
?>
</div><!-- End MainContent -->
</div><!-- End Main Content Container -->
<!-- If Rounded Corners then -->
<?if ($SITE[roundcorners]==1) SetRoundedCorners(0,0,$SITE[contentbgcolor]);?>
<!--END OF: Rounded Corners -->