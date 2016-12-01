<?
//General Config Form
include_once("checkAuth.php");
include("colorpicker.php");
$CONF=GetConfigVars();
for ($a=0;$a<count($CONF[ConfigID]);$a++) {
	$V[$CONF[VarName][$a]]=$CONF[VarValue][$a];
}
if (!$SITE[mobileEnabled]) die();
if (isset($_SESSION['LOGGED_ADMIN'])) isset($_SESSION['MEMBER'])
isset($_SESSION['MEMBER'])
isset($_SESSION['MEMBER'])
$_SESSION['mobilePreview']=1;
?>

<form id="config" method="POST" action="saveConfig.php" target="ifrmData">
<div align="center" class="general" style="width:100%">
<br />
<div style="width:900px;">
<div style="width:450px;float:right;">
<table class="ConfigAdmin" style="width:100%">
<tr>
<td align="center" colspan="10"><h3><?=$ADMIN_TRANS['mobile settings'];?></h3></td>
</tr>
<tr>
	<td><?=$ADMIN_TRANS['business address'];?>: </td>
</tr>
<tr><td align="<?=$SITE[align];?>"><textarea cols="50" rows="3" class="ConfigAdminInputTxt" id="bizaddress" name="SITE[bizaddress]"><?=htmlspecialchars($V['SITE[bizaddress]']);?></textarea></td></tr>
<tr>
	<td><?=$ADMIN_TRANS['business phone'];?>: </td>

</tr>
<tr>
<td align="<?=$SITE[align];?>"><input size="48" class="ConfigAdminInput" type="text" name="SITE[bizphone]" value='<?=$V['SITE[bizphone]'];?>'></td>
</tr>
<?
if ($V['SITE[bizphone]']) {
	?>
	<tr>
	<td align="<?=$SITE[align];?>"><?=$ADMIN_TRANS['call count from mobile'];?>: <strong><?=$SITE[mobileCallCount];?></strong></td>
	</tr>
	<?
}
?>
<tr>
	
	<td align="right">
		

	<input type="submit" class="newSaveIcon greenSave" id="newSaveIcon" value="<?=$ADMIN_TRANS['save changes'];?>" style="height:27px;margin-top:10px">

</td>
</tr>
</table>
<input type="hidden" name="mobile_config_win" value=1 />
</form>
</div>
<div style="float:right;width:450px;">
	<div class="mobilePreviewWrapper">
		<div class="inner">
			<iframe allowtransparency="true" border="0" frameborder="0" height="480" id="mobilePreviewAdmin" scrolling="auto" src="<?=$SITE[url];?>/?mobile=1" width="320"></iframe>
		</div>
		<div class="bottom" align="center">
			<div class="homebutton"></div>
		</div>
	</div>
	<script>
		function openMap() {
			document.getElementById("mobilePreviewAdmin").contentWindow.toggleFixedToolbar("map");
		}
		function refreshMap() {
			document.getElementById("mobilePreviewAdmin").contentWindow.loadFixedToolbarContent("map");
		}
		jQuery("#saveMobile").on("click",function(){window.setTimeout('refreshMap();',2000)});
		window.setTimeout("openMap()",3000);

		jQuery(document).ready(function() { 
	    var options = { 
	        target:        '.msgGeneralAdminNotification', 
	        success:       function(){showNotification(1);}  // target element(s) to be updated with server response 
	        

	    }; 
	   	jQuery('#config').ajaxForm(options); 
		}); 
	</script>
	
</div>
</div>
</div>
<?
if (isset($_SESSION['MEMBER'])
isset($_SESSION['MEMBER'])
isset($_SESSION['MEMBER'])
isset($_SESSION['mobilePreview'])) {
	session_register("LOGGED_ADMIN");

}
?>

<?include_once("footer.inc.php");?>
