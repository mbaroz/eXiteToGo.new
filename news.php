<?
include_once("config.inc.php");
include_once("inc/GetNewsData.inc.php");
$NEWS=GetNews($CHECK_CATPAGE[parentID]);
if ($CHECK_PAGE[galleryID]) {
	$NEWS=GetNews(0,$CHECK_PAGE[galleryID]);
	print '<div style="margin-top:5px"></div>'; //spaces to same line as the photo gallery
}
$scrollspeed=0;
$marqueeheight="";
$scrollamount=2;
if ($NEWS[ScrollType][0]==1 AND !isset($_SESSION['LOGGED_ADMIN'])) {
	$scrollspeed="1";
	$marqueeheight="280px";
}
if ($SITE[newstickerdelay]=="") $SITE[newstickerdelay]=4;
$tickerDelay=($SITE[newstickerdelay]*1000);
?>
<?if (isset($_SESSION['LOGGED_ADMIN'])) include_once("Admin/EditNewsArea.inc.php");?>
<style type="text/css">
.NewsBoxContainer li {
	list-style:none;
	list-type:none;
	
}
</style>
<script type="text/javascript" src="<?=$SITE[url];?>/js/jquery.vticker.js"></script> 
<script type="text/javascript"> 
	jQuery(function(){
		jQuery('.news-container').vTicker({
		speed: 650,
		pause: <?=$tickerDelay;?>,
		showItems: 1,
		animation:'fade',
		mousePause: true,
		height: 0,
		direction: 'up'
		});
		
	});
</script>
<div class="NewsBox">
	
	<?
	if ($scrollspeed>0) print '<div class="news-container">';
	else print '<div id="vmarquee">';
	print "<ul  id='NewsBoxContainer'>";
	for ($a=0;$a<count($NEWS[NewsID]);$a++) {
		$nDate=formatDate($NEWS[NewsDate][$a],"il");
		$nTitle=$NEWS[NewsTitle][$a];
		$nContent=$NEWS[NewsBody][$a];
		if ($nContent=="") continue;
		
		?>
		<li class="NewsItem" id="news_item-<?=$NEWS[NewsID][$a];?>"  style="width:230px">
			<div id="newsContent_<?=$NEWS[NewsID][$a];?>"><?=$nContent;?></div>
		

		
		<?if (isset($_SESSION['LOGGED_ADMIN'])) {
			?>
			<div style="display:block;padding-top:5px;clear:both;"></div>
			<div  style="font-size:10px;px;" id="newSaveIcon"  onclick="EditNews(<?=$NEWS[NewsID][$a];?>)"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" align="absmiddle" border="0"><?=$ADMIN_TRANS['edit'];?></div>
			<div  style="font-size:10px" id="newSaveIcon"  onclick="DelNews(<?=$NEWS[NewsID][$a];?>)"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" align="absmiddle" border="0"><?=$ADMIN_TRANS['delete'];?></div>
			<span><div style="cursor:move;font-size:10px" id="newSaveIcon"><img src="<?=$SITE[url];?>/Admin/images/moveicon.gif" align="absmiddle" border="0"><?=$ADMIN_TRANS['change order'];?></div></span>

			<?
		}
		print '<div style="clear:both;display:block;padding-top:5px"></div>';
		if (count($NEWS[NewsID])>2) print '<div style="padding-top:2px;" class="NewsSeperator"></div></li>';
	}
	print "</ul>";
	?>
	<div style="display:block;padding-top:1px;clear:both;"></div>
	</div>
</div>
