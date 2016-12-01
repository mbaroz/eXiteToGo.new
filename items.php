<style type="text/css">
.ItemTitle {
	color:green;
	font-size:13.5px;
	font-weight:bold;
	text-align:center;
}
.ItemTitle input {
	font-size:13.5px;
	font-family:arial;
	border:1px solid #efefef;
	color:green;
	font-weight:bold;
	background-color:#ffff99;
}
</style>
<?
$ITEMS=GetCatItem($urlKey,1);

for ($a=0;$a<count($ITEMS[ItemID]);$a++) {
	$ItemID=$ITEMS[ItemID][$a];
	if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<div align="right"  class="cHolder" id="item-<?=$ItemID;?>">
	<img title="מחק פריט זה" src="<?=$SITE[url];?>/Admin/images/delIcon.gif" border="0" align="absmiddle" class="button" onclick="DelItem(<?=$ItemID;?>)" align="absmiddle">
	<div align="center" class="ItemTitle"  id="itemTitle_item-<?=$ItemID;?>"><?=$ITEMS[ItemTitle][$a];?></div>
	</div>
	<script language="javascript" type="text/javascript">
	new Ajax.InPlaceEditor('itemTitle_item-<?=$ItemID;?>', '<?=$SITE[url];?>/Admin/saveContentinplace.php?action=renameItem', {clickToEditText:'לחץ לשינוי שם',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'itemTitle_item-<?=$ItemID;?>',formClassName:'ItemTitle'});
	</script>
	<?
	}
		else print '<h3 align="center" style="margin-top:1">'.$ITEMS[ItemTitle][$a].'</h3>';
	

}	
?>
