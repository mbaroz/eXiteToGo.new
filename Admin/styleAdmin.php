<?
//General Config Form
include_once("checkAuth.php");
include_once("header.inc.php");
include("colorpicker.php");
$CONF=GetConfigVars();
for ($a=0;$a<count($CONF[ConfigID]);$a++) {
	$V[$CONF[VarName][$a]]=$CONF[VarValue][$a];
}

?>
<form id="config" method="POST" action="saveConfig.php" target="ifrmData">
<div align="center" class="general">
<h3> <font color="blue"><?=$MAIN[config][3];?></font></h3>
<hr class="seperator" />
<br>
<table class="maincolor">
<tr>
<td><?=$STYLE_LABEL[0];?>: </td><td>
<select name="SITE[globalalign]" class="HETextbox" style="width:100px">
<?
foreach ($STYLE_ALIGN_OPTIONS as $key=>$value) {
	if ($V['SITE[globalalign]']==$key) print "<option selected value=".$key.">".$value."</option>";
	else print "<option value=".$key.">".$value."</option>";
}
?>
</select>
</td>
</tr>
<td><?=$STYLE_LABEL[1];?></td><td><input class="ENTEXTBOX" type="text" name="SITE[width]" value="<?=$V['SITE[width]'];?>"></td>
</tr>
<tr>
<td><?=$STYLE_LABEL[2];?> </td><td><input class="ENTEXTBOX" type="text" name="SITE[sidewidth]" value="<?=$V['SITE[sidewidth]'];?>"></td>
</tr>
<tr>
<td><?=$STYLE_LABEL[3];?>: </td><td><input class="ENTextbox" type="text" name="SITE[rightmargin]" value="<?=$V['SITE[rightmargin]'];?>"></td>
</tr>
<tr>
<td><?=$STYLE_LABEL[4];?>: </td><td><input class="ENTextbox" type="text" name="SITE[topmargin]" value="<?=$V['SITE[topmargin]'];?>"></td>
</tr>
<tr>
<td><?=$STYLE_LABEL[5];?> : </td><td><input class="ENTextbox" type="text" name="SITE[SideMenuWidth]" value="<?=$V['SITE[SideMenuWidth]'];?>"></td>
</tr>
<tr>
<td><?=$STYLE_LABEL[6];?>: </td><td>
<select name="SITE[newslocation]" class="HETextbox" style="width:100px">
<?
foreach ($STYLE_NEWS_OPTIONS as $key=>$value) {
	if ($V['SITE[newslocation]']==$key) print "<option selected value=".$key.">".$value."</option>";
	else print "<option value=".$key.">".$value."</option>";
}
?>
</select>
</td>
</tr>
<tr>
<td><?=$STYLE_LABEL[7];?>: </td><td>
<select name="SITE[menutype]" class="HETextbox" style="width:100px">
<?
foreach ($STYLE_MENU_OPTIONS as $key=>$value) {
	if ($V['SITE[menutype]']==$key) print "<option selected value=".$key.">".$value."</option>";
	else print "<option value=".$key.">".$value."</option>";
}
?>
</select>
</td>
</tr>
<tr>
<td><?=$STYLE_LABEL[8];?> : </td><td><?PickColor("SITE[bgcolor]",$V['SITE[bgcolor]']);?></td>
</tr>
<tr>
<td><?=$STYLE_LABEL[11];?>: </td><td><?PickColor("TOPMENU[bgstaticcolor]",$V['TOPMENU[bgstaticcolor]']);?></td>
</tr>
<tr>
<td><?=$STYLE_LABEL[9];?>: </td><td><?PickColor("TOPMENU[bgcolor]",$V['TOPMENU[bgcolor]']);?></td>
</tr>
<tr>
<td><?=$STYLE_LABEL[10];?> : </td><td><?PickColor("TOPMENU[textcolor]",$V['TOPMENU[textcolor]']);?></td>
</tr>
<tr>
<td><?=$CONTENT_SUBS_LABEL[0];?> : </td><td><?PickColor("SITE[SubMenuBgColor]",$V['SITE[SubMenuBgColor]']);?></td>
</tr>
<tr>
<td><?=$CONTENT_SUBS_LABEL[1];?>: </td><td><?PickColor("SITE[SubMenuHoverColor]",$V['SITE[SubMenuHoverColor]']);?></td>
</tr>
<tr>
<td><?=$CONTENT_SUBS_LABEL[2];?> : </td><td><?PickColor("SITE[SubMenuTextColor]",$V['SITE[SubMenuTextColor]']);?></td>
</tr>

</table>
<input type="submit" class="button" value="<?=$MAIN[general][4];?>">
</div>
</form>
<?include_once("footer.inc.php");?>
