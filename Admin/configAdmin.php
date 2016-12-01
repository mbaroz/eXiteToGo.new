<?
//General Config Form
include_once("checkAuth.php");
include("colorpicker.php");
$CONF=GetConfigVars();
for ($a=0;$a<count($CONF[ConfigID]);$a++) {
	$V[$CONF[VarName][$a]]=$CONF[VarValue][$a];
}
$fb_comment_text="Only for facebook comments box";
$ADMIN_TRANS['SITE_DIRECTION']="Language Direction";
$ADMIN_TRANS['accessi_enabled']="Accessibility installed";
$ADMIN_TRANS['accessi_install']="to install click here";
$ADMIN_TRANS['shop_activated']="Enable Shop";
if ($SITE_LANG[selected]=="he") {
	$fb_comment_text="משמש למערכת תגובות של פייסבוק באתר";
	$ADMIN_TRANS['SITE_DIRECTION']="כיוון שפת האתר";
	$ADMIN_TRANS['accessi_enabled']="נגישות לא מותקנת";
	$ADMIN_TRANS['accessi_install']="להתקנה לחץ/י כאן";
	$ADMIN_TRANS['shop_activated']="הוסף מודול חנות";
}
if ($SITE[fb_integration]=="") $SITE[fb_integration]=0;
$FB_SELECTED[$SITE[fb_integration]]="selected";
$G_SELECTED[$SITE[g_integration]]="selected";
$defLangDir[$SITE_LANG[direction]]="selected";
$accessi_class="no_accessi";
if (stristr($SITE[addon_code], "api.accessi.do") OR stristr($SITE[googleanalytics], "api.accessi.do")) {
	$accessi_class="accessi";
	$ADMIN_TRANS['accessi_enabled']="נגישות מותקנת";
	
}
?>
<style type="text/css">
	.generalScreen i.icon {
		width:13px;height:13px;
		line-height: 12px;
		font-size: 14px;
	}
	.generalScreen i.icon.checked {
		background-color: #245E8A;color:white;
	}
	.generalScreen i.icon.checked.no_accessi{background-color: silver}
	
</style>

<br />

<div style="width:900px;position:relative;text-align:center" class="generalScreen">
	<h3><?=$ADMIN_TRANS['general settings'];?></h3>
<form id="config" method="POST" action="saveConfig.php" target="ifrmData">
<table class="ConfigAdmin" style="width:100%" cellspacing="5">

<tr>
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['website name'];?>: </td><td align="<?=$SITE[align];?>"><input size="48" class="ConfigAdminInput" type="text" name="SITE[name]" value="<?=htmlspecialchars($V['SITE[name]']);?>"></td>

<tr>
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['webmaster name'];?>: </td><td align="<?=$SITE[align];?>"><input size="48" class="ConfigAdminInput" type="text" name="SITE[author]" value='<?=$V['SITE[author]'];?>'></td>
</tr>

<tr style="display:none">
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['website url'];?>: </td><td align="<?=$SITE[align];?>"><input size="48" class="ConfigAdminInput" type="text" name="SITE[url]" value="<?=$V['SITE[url]'];?>"></td>
</tr>
<tr style="display:none">
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['website secure url'];?>: </td><td align="<?=$SITE[align];?>"><input size="48" class="ConfigAdminInput" type="text" name="SITE[secureurl]" value="<?=$V['SITE[secureurl]'];?>"></td>
</tr>
<tr>
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['forms email'];?>: </td><td align="<?=$SITE[align];?>"><input style="direction: ltr;text-align: left" size="48" class="ConfigAdminInput" type="text" name="SITE[FromEmail]" value="<?=$V['SITE[FromEmail]'];?>"></td>
</tr>
</tr>
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['title tag'];?>:</br> </td><td align="<?=$SITE[align];?>"><input size="34" style="font-size:14px;font-weight:bold;color:gray" class="ConfigAdminInput" type="text" name="SITE[title]" value="<?=htmlspecialchars($V['SITE[title]']);?>"></td>
</tr>
<tr>
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['description tag'];?>:</br></td><td align="<?=$SITE[align];?>"><textarea cols="50" rows="3" class="ConfigAdminInputTxt" name="SITE[description]"><?=$V['SITE[description]'];?></textarea></td>
</tr>
<tr>
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['keywords'];?>: </br>(Keywords Tag) </td><td align="<?=$SITE[align];?>"><textarea cols="50" rows="3" class="ConfigAdminInputTxt" name="SITE[keywords]"><?=$V['SITE[keywords]'];?></textarea></td>
</tr>
<tr>
<td style="width:200px;padding-top:3px;" valign="top" align="<?=$SITE[opalign];?>">FB APP ID:  </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[fb_app_id]" value="<?=$V['SITE[fb_app_id]'];?>">
</br><small>(<?=$fb_comment_text;?>)</small>
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" align="<?=$SITE[opalign];?>">FB Page URL: </td><td align="<?=$SITE[align];?>"><textarea rows="4" class="ConfigAdminInputTxt"  name="SITE[fb_page_id]"><?=$V['SITE[fb_page_id]'];?></textarea>
</br><small>( <a href="http://www.facebook.com/developers/apps.php" rel="shadowbox;width=720;height=470">Where can i find it ?</a></small> ) 
</td>
</tr>
<tr style="display:none">
<td style="padding-top:3px;" valign="top" align="<?=$SITE[opalign];?>">FB Page ID: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[fb_page_id_num]" value="<?=$V['SITE[fb_page_id_num]'];?>">
</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['add facebook widgets'];?>: </td>
<td align="<?=$SITE[align];?>">
	<select name="SITE[fb_integration]" id="SITE[fb_integration]" class="ConfigAdminInput ConfigAdminSelect">
		<option value=0 <?=$FB_SELECTED[0];?>>None</option>
		<option value=1 <?=$FB_SELECTED[1];?>>Like Button</option>
		<option value=6 <?=$FB_SELECTED[6];?>>Like Button for specific Page</option>
		<option value=4 <?=$FB_SELECTED[4];?>>Like(Fans) Box</option>
		<option value=3 <?=$FB_SELECTED[3];?>>Share Button</option>
		<option value=2 <?=$FB_SELECTED[2];?>>Comments box</option>
		<option value=7 <?=$FB_SELECTED[7];?>>Comments box+Like+Share</option>
		
	</select><br><small>For all pages</small>

</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" align="<?=$SITE[opalign];?>">Google Plus: </td>
<td align="<?=$SITE[align];?>">
	<select name="SITE[g_integration]" id="SITE[g_integration]" class="ConfigAdminInput ConfigAdminSelect">
		<option value=0 <?=$G_SELECTED[0];?>>None</option>
		<option value=1 <?=$G_SELECTED[1];?>>Google Plus Button</option>
	</select><br><small>For all pages</small>

</td>
</tr>
<tr>
<td style="padding-top:3px;" valign="top" align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['search box label'];?>: </td><td align="<?=$SITE[align];?>"><input size="40" class="ConfigAdminInput" type="text" name="SITE[searchformtext]" value="<?=$V['SITE[searchformtext]'];?>">
</td>
</tr>
<tr>
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['google analytics code'];?>:</br></td><td align="<?=$SITE[align];?>"><textarea dir="ltr" rows="3" class="ConfigAdminInputTxt" style="direction:ltr;text-align:left" name="SITE[googleanalytics]"><?=stripslashes($V['SITE[googleanalytics]']);?></textarea></td>
</tr>
<tr>
<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['google remarketing code/other'];?>:</br><small>(Before the &lt;/body&gt;)</small></td><td align="<?=$SITE[align];?>"><textarea dir="ltr" rows="5" class="ConfigAdminInputTxt" style="direction:ltr;text-align:left" name="SITE[googleremarketingcode]"><?=stripslashes($V['SITE[googleremarketingcode]']);?></textarea></td>
</tr>
<tr>
	<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['SITE_DIRECTION'];?>:</td><td align="<?=$SITE[align];?>">
	<select name="SITE[defDirection]" id="SITE[defDirection]" class="ConfigAdminInput ConfigAdminSelect">
			<option value='rtl' <?=$defLangDir[rtl];?>>Right to left</option>
			<option value='ltr' <?=$defLangDir[ltr];?>>Left to right</option>
	</select>
	</td>
</tr>
<? //visible only to Top Admins
if ($MEMBER[UserType]==0) {
	if ($SITE[usersPerms]=="") $SITE[usersPerms]=0;
	$userPerms_selected[$SITE[usersPerms]]="selected";
	?>
	
	<tr>
	<td align="<?=$SITE[opalign];?>"><?=$ADMIN_TRANS['site owner permission'];?>:</td><td align="<?=$SITE[align];?>">
	<select name="SITE[usersPerms]" id="SITE[usersPerms]" class="ConfigAdminInput ConfigAdminSelect">
			<option value=0 <?=$userPerms_selected[0];?>>General User</option>
			<option value=1 <?=$userPerms_selected[1];?>>Manage Header Photos</option>
	</select>
	</td>
	</tr>
	<tr>
	<td> </td><td align="<?=$SITE['align'];?>">
		<input type="checkbox" id="SITE[formsEnabled]" name="SITE[formsEnabled]" value="1" <?=($SITE[formsEnabled] == 1) ? 'CHECKED' : '';?> />
		<i class="fa fa-check-square-o icon <?=($SITE[formsEnabled] == 1) ? 'checked' : '';?>"></i>&nbsp;<label for="SITE[formsEnabled]"><?=$ADMIN_TRANS['enable forms generator'];?></label>
	</td>
	</tr>
	<tr>
	<td> </td><td align="<?=$SITE['align'];?>">
		<input type="checkbox" id="SITE[allowuserperms]" name="SITE[allowuserperms]" value="1" <?=($SITE[allowuserperms] == 1) ? 'CHECKED' : '';?> />
		<i class="fa fa-unlock-alt icon <?=($SITE[allowuserperms] == 1) ? 'checked' : '';?>"></i>&nbsp;<label for="SITE[allowuserperms]"><?=$ADMIN_TRANS['permissions manager'];?></label>
	</td>
	</tr>
	<tr>
	<td> </td><td align="<?=$SITE['align'];?>">
		<input type="checkbox" id="SITE[shopEnabled]" name="SITE[shopEnabled]" value="1" <?=($SITE[shopEnabled] == 1) ? 'CHECKED' : '';?> />
		<i class="fa fa-usd icon <?=($SITE[shopEnabled] == 1) ? '' : '';?>"></i>&nbsp;<label for="SITE[shopEnabled]"><?=$ADMIN_TRANS['shop_activated'];?></label>
	</td>
	</tr>
	<tr>
	<td> </td><td align="<?=$SITE['align'];?>">
		<input type="checkbox" id="SITE[slidoutcontentenable]" name="SITE[slidoutcontentenable]" value="1" <?=($SITE[slidoutcontentenable] == 1) ? 'CHECKED' : '';?> />
		<i class="fa fa-long-arrow-<?=$SITE[align];?> icon <?=($SITE[slidoutcontentenable] == 1) ? 'checked' : '';?>"></i>&nbsp;<label for="SITE[slidoutcontentenable]"><?=$ADMIN_TRANS['slideout content'];?></label>
	</td>
	</tr>
	<?
	if ($MEMBER[Email]=="mbaroz@gmail.com" OR $MEMBER[Email]=="ofir@gafko.co.il") {
		?>
		<tr>
		<td> </td><td align="<?=$SITE['align'];?>">
			<input type="checkbox" id="SITE[mobileEnabled]" name="SITE[mobileEnabled]" value="1" <?=($SITE[mobileEnabled] == 1) ? 'CHECKED' : '';?> />
			<i class="fa fa-mobile icon <?=($SITE[mobileEnabled] == 1) ? 'checked' : '';?>"></i>&nbsp;<label for="SITE[mobileEnabled]">Mobile Enabled</label>
		</td>
		</tr>
		<?
	}
	
}
?>
<tr>
	<td> </td><td align="<?=$SITE['align'];?>">
		<?
		if ($accessi_class=="accessi") print '<i class="fa fa-check"></i>';
		?>
		<i class="fa fa-wheelchair icon checked <?=$accessi_class;?>"></i>&nbsp;

		<label><?=$ADMIN_TRANS['accessi_enabled'];?> <?=($accessi_class=="accessi") ? '': '<a href="http://www.accessi.do" style="text-decoration:underline" target="_new">'.$ADMIN_TRANS['accessi_install'].'</a>';?></label>
	</td>
	</tr>
<tr>
<td></td>
<td><br />

<input type="submit" id="newSaveIcon" class="greenSave" value="<?=$ADMIN_TRANS['save changes'];?>">

</td>
</tr>
</table>

</form>
</div>
<br><br>
<script>
jQuery(document).ready(function() { 
    var options = { 
        target:        '.msgGeneralAdminNotification', 
        success:       function(){showNotification(1);}  // target element(s) to be updated with server response 
        
    }; 
   	jQuery('#config').ajaxForm(options); 
}); 
</script>
<?include_once("footer.inc.php");?>
