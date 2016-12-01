<!-- If Rounded Corners then -->
<?if ($SITE[roundcorners]==1) SetRoundedCorners(1,0,$SITE[contentbgcolor]);
if ($P_DETAILS[PageStyle]==4) $additionalClassaName="fullscreen";

?>
<!--END OF: Rounded Corners -->
<div class="mainContentContainer <?=$additionalClassaName;?>">
	<div class="mainContent">
	<?if (isset($_SESSION['LOGGED_ADMIN'])) {
			 include_once("Admin/CategoryEdit.php");
			}
	?>
		<div class="widePage">
				<div class="breadCrumb" style="margin-<?=$SITE[align];?>:-4px;margin-bottom:10px;"><?if (!$P_DETAILS[HideTopMenu]) print GetBreadCrumb($urlKey);?></div>
				<?if ($urlKey) include_once("GetPageContent.php");?>
				<div class="clear" style="height:5px"></div>
				
		</div>
	
	</div><!-- End MainContent -->
</div><!-- End Main Content Container -->
<!-- If Rounded Corners then -->
<?if ($SITE[roundcorners]==1) SetRoundedCorners(0,0,$SITE[contentbgcolor]);?>
<!--END OF: Rounded Corners -->
<?
if ($additionalClassaName=="fullscreen") {
	?>
	<script type="text/javascript">
		jQuery(window).resize(function() {
			jQuery(".mainContentContainer.fullscreen .mainContent").width(jQuery(this).width()+"px");

		})
	</script>
	<?
}