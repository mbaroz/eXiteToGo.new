<?
include_once("checkAuth.php");
function changePassword($type,$oldPass,$newPass,$email) {
	$oldPass=sha1($oldPass);
	$newPass=sha1($newPass);
	global $ADMIN_TRANS;
	$db=new Database();
	if ($type=="admin") $table="admins";
		else $table="users";
	$db->query("SELECT * from $table WHERE Email='$email' AND Passwd='$oldPass'");
	if ($db->nextRecord()) {
		$uID=$db->getField("UID");
		$db->query("UPDATE $table SET Passwd='$newPass' WHERE UID='$uID'");
		$msgs="<font color=green>".$ADMIN_TRANS['password changed succesfully']."</font>";
		session_start();
		session_unset();
	}
	else {
		$msgs="<font color=red>".$ADMIN_TRANS['old password is incorrect. try again']."</font>";
	}
	return $msgs;
	
} //end function change pass
if ($sps==1 and $MEMBER[Email]!="") {
	print "<div align=center class=general><b>".changePassword("admin",$oldPass,$newPass,$MEMBER[Email])."</div>";
	die();
}

?>
<script language="javascript">
function CheckPass(f) {
		if (f.newPass.value!=f.newRePass.value) {
			alert("<?=$ADMIN_TRANS['password verification is not the same'];?>");
			return false;
		}
		return true;
}
jQuery(document).ready(function() { 
    var options = { 
        target:        '.msgGeneralAdminNotification', 
        success:       function(){showNotification(1);}  // target element(s) to be updated with server response 
        

    }; 
   	jQuery('#passChange').ajaxForm(options); 
}); 
</script>

<div style="width:900px;position:relative;text-align:center">
	<h3><?=$ADMIN_TRANS['change password'];?></h3>
<form name="passChange" id="passChange" action="<?=$PHP_SELF;?>" method="POST" onsubmit="return CheckPass(this);">
<table class="ConfigAdmin" style="margin:0 auto" cellspacing="7">
<tr>
<td class="titleText"><?=$ADMIN_TRANS['old password'];?>:<br>
<input class="ConfigAdminInput ENtextbox" type="password" name="oldPass" value=""></td>
</tr>
<tr><td style="height: 10px"></td></tr>
<tr>
<td class="titleText"><strong><?=$ADMIN_TRANS['new password'];?>:</strong><br>
<input class="ConfigAdminInput ENtextbox" type="password" name="newPass" value=""></td>
</tr>
<tr>
<td class="titleText"><strong><?=$ADMIN_TRANS['new password again'];?>:</strong><br>
<input type="password" class="ConfigAdminInput ENtextbox" name="newRePass" value=""></td>
</tr>
<tr>
<td colspan="5">
<input type="submit" name="change" value="<?=$ADMIN_TRANS['change password'];?>" id="newSaveIcon" class="greenSave">
<input type="hidden" name="sps" value=1>
</td>
</tr>
</table>
</form>
</div>
<?

include_once("footer.inc.php");
?>