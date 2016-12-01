<div style="margin-top:<?=$SITE[contenttopmargin];?>px;" class="clear"></div>
<?
$inherit_checked="";
if ($SITE[middlecontenthome]==1) $inherit_checked="checked";
$C_MIDDLE_MULTI=GetMultiContent($urlKey,"middle");
$multiContentPageID=$C_MIDDLE_MULTI[PageID][0];
if ($SITE[middlecontenthome]==1) $multiContentPageID=$middleCONTENT[PageID][0];
if (!$multiContentPageID) $multiContentPageID=0;
if($SITE[middlecontentfullwidth]) print '<div class="middleContentFull">';
if ($SITE[roundcorners]==1) SetRoundedCorners(1,0,$SITE[bottompicbgcolor]);?>

<div class="middleContent">
	<div class="middleContentText">
	<?
	if (isset($_SESSION['LOGGED_ADMIN']) AND $CHECK_CATPAGE) {
		?>
		<script language="javascript">
		var middlepageTitle='middle_<?=$multiContentPageID;?>';
		var lightEditorDiv='<textarea id="lightEditor"></textarea>';
		var inheritChecked="<?=$SITE[middlecontenthome]?>";
		function InheritFromHomepage() {
			var checked_inherit;
			if($('homepage_inherit').checked) checked_inherit=1;
			else checked_inherit=0;
			var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
			var pars = 'action=setMiddleContentInherit&isInherit='+checked_inherit;
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			window.setTimeout('ReloadPage()',800);
		}
		</script>
		<div style="padding:3px 0px 3px 0px;">
		<div id="newSaveIcon" onclick="EditMiddleContent(<?=$multiContentPageID;?>)"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" align="absmiddle" border="0"><?=$ADMIN_TRANS['edit'];?></div>
		<?if ($multiContentPageID!=0) {
			?><div id="newSaveIcon" onclick="deleteContent(<?=$multiContentPageID;?>)"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" align="absmiddle" border="0" title="<?=$ADMIN_TRANS['delete'];?>">&nbsp;<?=$ADMIN_TRANS['delete'];?></div>
			<?
			}
			?>
		<span style="display:none" id="closeEditorButton"><div id="newSaveIcon" onclick="cancelMiddleContent()"><img src="<?=$SITE[url];?>/Admin/images/close_icon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['cancel'];?></div></span>
		<span style="display:none" id="saveButton"><div id="newSaveIcon" onclick="saveMiddleContent()"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save'];?></div></span>
		<span><input onclick="InheritFromHomepage()" type="checkbox" id="homepage_inherit" name="homepage_inherit" <?=$inherit_checked;?>><?=$ADMIN_TRANS['always use homepage content'];?></span>
		</div>
		<?
	}
	
	if ($SITE[searchformtop]==2) {
		?>
		<div class="searchFormTop" style="margin-top:1px;"><?include_once("searchForm.inc.php");?></div>
		<div style="float:<?=$SITE[align];?>;width:<?=930-$SITE[searchformwidth];?>px">
		<?	
		}
		?>
		<span id="divContent_<?=$multiContentPageID;?>">
		<?
		print $middleCONTENT[PageContent][0];
		?>
		</span>
		<?if ($SITE[searchformtop]==2) print '</div>';?>
	</div>
</div>
<!-- If Rounded Corners then -->
<?if ($SITE[roundcorners]==1) SetRoundedCorners(0,0,$SITE[bottompicbgcolor]);?>
<!--END OF: Rounded Corners -->
<?if($SITE[middlecontentfullwidth]) print '</div>';?>