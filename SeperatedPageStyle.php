<div class="mainContentContainer">
<div class="rightSide" style="padding-top:2px;">
	<?if ($SITE[roundcorners]==1) SetSideRoundedCorners(1,0,$SITE[sidebgcolor]);?>
	<div class="rightSideSeperated">
		<div style="width:242px;">
		<?if (isset($_SESSION['LOGGED_ADMIN'])) {
			if (!$CHECK_PAGE) include_once("Admin/CatNewsSwitch.php");
			 include_once("Admin/CategoryEdit.php");
			}
		?>
		<?if (isset($_SESSION['LOGGED_ADMIN']) OR $ROOT_URLKEY[ParentMenuTitle]!=" ") {
			?><span id="sideCatTitle" class="sideCatTitle">
			<?
			if ($SITE[titlesicon]) {
				?><div class="titlesIcon"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
				<?
			}
			?>
			<div id="catTitle-<?=$CHECK_CATPAGE[parentID];?>"><?=$ROOT_URLKEY[ParentMenuTitle];?></div>
			</span>
		
		<?
		}
		if ($SITE[searchformtop]==3) {
			?>
			<div style="margin-<?=$SITE[align];?>:16px;margin-bottom:10px">
			<?include_once("searchForm.inc.php");?>
			</div>
			<?
		}
		include_once("sideCatContentTop.php");
		if (isNewsPage($urlKey)) include_once("news.php");
			else {
				if (isset($_SESSION['LOGGED_ADMIN'])) include_once("Admin/CatEditIcon.php");
				SetSideMenu($urlKey);
				
			}
		 include_once("sideCatContent.php");
		  include_once("SideContactForm.inc.php");
			?>
		</div>
	<div style="padding:1px"></div>
	</div><!--  End RightSideSpertarted-->
	
	<?if ($SITE[roundcorners]==1) SetSideRoundedCorners(0,0,$SITE[sidebgcolor]);?>
	
</div><!-- End RightSide -->

<div class="leftSide" style="padding-top:2px;">
	<?if ($SITE[roundcorners]==1) SetMiddleRoundedCorners(1,0,$SITE[contentbgcolor]);?>
	
	<div class="mainContentSeperated">
		
		<div class="breadCrumb" style="padding-right:6px;margin-top:-7px;margin-bottom:7px;">
			<?if (!$P_DETAILS[HideTopMenu]) print GetBreadCrumb($urlKey);?>
			</div>
			<?if ($urlKey) include_once("GetPageContent.php");?>
				<div class="clear"></div>
			
		<div style="height:15px"></div>
	</div> <!--End mainContentSeperated-->
	<?if ($SITE[roundcorners]==1) SetMiddleRoundedCorners(0,0,$SITE[contentbgcolor]);?>
</div>
</div><!-- End Main Content Container -->
<div class="clear"></div>
<?if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('catTitle-<?=$CHECK_CATPAGE[parentID];?>', '<?=$SITE[url];?>/Admin/saveTitles.php?type=cat', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'catTitle-<?=$CHECK_CATPAGE[parentID];?>',formClassName:'sideCatTitle'});
		</script>
		<?
	}
	
?>
<!--27/7/2012-->
<script>
	
	function SetSeperatedEqualHeight() {
		var rightSeperatedHeight=jQuery(".rightSideSeperated").height();
		var leftSideSeperatedHeight=jQuery(".mainContentSeperated").height();
		if (rightSeperatedHeight<leftSideSeperatedHeight) jQuery('.rightSideSeperated').css('min-height',(leftSideSeperatedHeight)+"px");
		if (rightSeperatedHeight>leftSideSeperatedHeight) jQuery('.mainContentSeperated').css('min-height',(rightSeperatedHeight)+"px");
	}
	
</script>