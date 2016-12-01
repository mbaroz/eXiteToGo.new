<?
$contact_width=350;
if ($P_DETAILS[PageStyle]==1) $contact_width=600;
?>
<script language="javascript">
cType=0;
</script>
<style type="text/css">
#boxes  {
		font-family: <?=$SITE[cssfont];?>;
		list-style-type: none;
		margin: 0px;
		padding: 0px;
		width: 100%;
}
#boxes li {
		margin: 5px 5px 5px 5px;
		border: 0px solid silver;
		padding: 1px;
}
.contact_left {
	float:<?=$SITE[align];?>;
	width:310px;
	margin-<?=$SITE[opalign];?>:15px;
	
}

.contact_right {
	float:<?=$SITE[align];?>;
	width:<?=$contact_width;?>px;
	padding-top:15px;
}
#boxes li.spacer {
		margin:0px;
		border:0px;
		clear:both;
		float:none;
		height:0px;
}
</style>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	
	 <script type="text/javascript">
	 function saveOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars =newPosition+'&action=saveContentLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
			
	}

		jQuery(function() {
		jQuery("#boxes").sortable({
   		update: function(event, ui) {
   			saveOrder(jQuery("#boxes").sortable('serialize'));
   		}
   		,handle: '#movable_content',
   		scroll:false,
   		axis:'y',tolerance: 'pointer',dropOnEmpty: false
	});
		//jQuery("#boxes").disableSelection();
	});
 	</script>
	<?

	?>
	<div id="newSaveIcon" class="add_button" style="margin-<?=$SITE[align];?>:8px;"  onclick="AddNewContentType();"><img src="<?=$SITE[url];?>/Admin/images/add_icon.png" alt="<?=$ADMIN_TRANS['add new item'];?>" border="0" align="absmiddle" />&nbsp;<?=$ADMIN_TRANS['add new'];?></div>
	<?
}
$CONTENT=GetMultiContent($urlKey);
	$titleShow="";
	print '<ul id="boxes" class="long_content_page">';
	for ($a=0;$a<count($CONTENT[PageID]);$a++) {
		$titleShow="block";
		$p_url=$SITE[url]."/".$CONTENT[UrlKey][$a];
		$page_url=$SITE[url]."/".$CONTENT[UrlKey][$a];
		if ($CONTENT[PageTitle][$a]=="") $titleShow="none";
		if (!$CONTENT[PageUrl][$a]=="") $page_url=urldecode($CONTENT[PageUrl][$a]);
		$target_location="_self";
		if (!stripos(urldecode($CONTENT[PageUrl][$a]),"/")==0 AND $CONTENT[PageUrl][$a]!="") $target_location="_blank";
		if ($CONTENT[PageContent][$a]=="") $CONTENT[PageContent][$a]=$CONTENT[ShortContent][$a];
		?>
		<li id="short_cell-<?=$CONTENT[PageID][$a];?>">
		<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {
			?>
			<span style="display:none" id="p_url_<?=$CONTENT[PageID][$a];?>"><?=urldecode($CONTENT[PageUrl][$a]);?></span>
			<div class="cHolder" id="cHolder-item_<?=$CONTENT[PageID][$a];?>">
			<div>
			<span id="AdminErea_<?=$CONTENT[PageID][$a];?>" style="display:">
			<?include 'Admin/EditAreaClient.php'; ?>
			</span></div>
			<?
		}
		$h_tag="h1";
		if ($pageHasHOne) $h_tag="h2";
		if ($a>0) {
				$h_tag="h2";
				if ($pageHasHOne) $h_tag="h3";		
		}
		if (isset($_SESSION['LOGGED_ADMIN']) OR $titleShow=="block") 
			{
		
				?>
				<div class="titleContent">
				<<?=$h_tag;?>  id="titleContent_<?=$CONTENT[PageID][$a]; ?>" style="display:<?=$titleShow;?>">
				<?
				if ($CONTENT[IsTitleLink][$a] OR $CONTENT[PageUrl][$a]!="") {
					?><a id="c_url_<?=$CONTENT[PageID][$a];?>" href="<?=$page_url;?>" target="<?=$target_location;?>"><?}
				else {
					?><a id="c_url_<?=$CONTENT[PageID][$a];?>"><?}
					?><?=$CONTENT[PageTitle][$a];?></a>
					</<?=$h_tag;?>></div>
					<?
			}
		if ($urlKey=="צרו-קשר" or $urlKey=="contact-us") {
		
		
		print '<div class="contact_left">';
		if ($SITE_LANG[selected]=="") include_once("contact".$contactAdvanced.".".$default_lang.".php");
		else include_once("contact".$contactAdvanced.".".$SITE_LANG[selected].".php");
		print '</div>';
		}
		if ($urlKey=="צרו-קשר" or $urlKey=="contact-us") {
			if ($a==0) print '<div class="contact_right">';
			else print "<div style='clear:both'></div>";
		}
		?>

		<div id="printArea"><div id="divContent_<?=$CONTENT[PageID][$a]; ?>" align="<?=$SITE[align];?>" class="mainContentText">
		<?
		print str_ireplace("&lsquo;","'",$CONTENT[PageContent][$a]);
		?></div></div>
		
	<?
	
	if (isset($_SESSION['LOGGED_ADMIN'])) print "</div><br>";
	print "</li>";
	if ($urlKey=="צרו-קשר" or $urlKey=="contact-us") print "<li class='spacer'></li>";
	}
	print '</ul>';

if ($C_STYLING['ContentEntranceEffect']!="" AND !isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script src="//d3jy1qiodf2240.cloudfront.net/js/wow.min.js"></script>
	<script>
	new WOW().init();
	jQuery(document).ready(function(){
	jQuery("ul#boxes li").addClass("wow <?=$C_STYLING['ContentEntranceEffect'];?>");

	});
	</script>

	<?
}
?>
