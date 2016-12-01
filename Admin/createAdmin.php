<?
include_once("checkAuth.php");
function AddAdmin($ADMIN,$uid) {
	$db=new Database();
	global $ADMIN_TRANS;
	if ($ADMIN[email]=="") die($ADMIN_TRANS['email field is required']);
	if ($ADMIN[pass]=="" OR $ADMIN[repass]=="") die($ADMIN_TRANS['password is required']);
	if (strlen($ADMIN[pass])<6) die($ADMIN_TRANS['minimum password length 6 characters']);
	if ($ADMIN[pass]!=$ADMIN[repass]) die($ADMIN_TRANS['password verification is not the same']);
	if ($uid=="") {
		$db->query("select * from admins WHERE Email='$ADMIN[email]'");
		if (!$db->nextRecord()) {
			$ADMIN[securePass]=sha1($ADMIN[pass]);
			$sql="INSERT INTO admins (FirstName,LastName,Email,Passwd,UserType) VALUES ('$ADMIN[fname]','$ADMIN[lname]','$ADMIN[email]','$ADMIN[securePass]',1)";
			
			$db->query($sql);
			print 'משתמש מערכת הוסף בהצלחה';
			?>
			<script>loadAdminPanel('listAdmins');</script>
			<?

		}
		else {
			print 'שגיאה במערכת נמצא מנהל מערכת עם כתובת דואל זהה !';
		}
	}
	else {
		
		$sql="update admins SET FirstName='$ADMIN[fname]',LastName='$ADMIN[lname]',Email='$ADMIN[email]' WHERE UID='$uid'";
		
		$db->query($sql);
		print 'פרטי משתמש נשמרו בהצלחה';
		?>
		<script>loadAdminPanel('listAdmins');</script>
		<?
	}
	die();
}
$show_pass=1;
if ($_GET['uid']) {
	$uID=$_GET['uid'];
	$USID=explode("|",$uID);
	$uID=$USID[1];
	$EDIT_ADMIN=GetAdminDetails($uID);
	$show_pass=0;
}

if ($sent==1) AddAdmin($ADMIN,$_POST['uid']);
?>


	
<script language="javascript">

jQuery(document).ready(function() { 
    var options = { 
        target:        '.msgGeneralAdminNotification', 
        success:       function(){showNotification(1);}  // target element(s) to be updated with server response 
        

    }; 
   	jQuery('#createadmin').ajaxForm(options); 
}); 
</script>
<div style="width:900px;position:relative;text-align:center">
<h2><?=$ADMIN_TRANS['add new manager'];?></h2> 
	
<form name="createadmin" id="createadmin" method="POST" action="<?=$PHP_SELF;?>">
<table class="ConfigAdmin" style="margin:0 auto" cellpadding="3" cellspacing="5">
<tr>
<td class="ConfigAdmin">
<?=$ADMIN_TRANS['first name'];?>:<br>
<input class="ConfigAdminInput  HETextbox" type="text"  name="ADMIN[fname]" value="<?=$EDIT_ADMIN[FirstName];?>"></td>
</tr>
<tr>
<td class="ConfigAdmin">
<?=$ADMIN_TRANS['last name'];?>:<br>
<input class="ConfigAdminInput  HETextbox" type="text"  name="ADMIN[lname]" value="<?=$EDIT_ADMIN[LastName];?>"></td>
</tr>
<tr>
<td class="ConfigAdmin"><?=$ADMIN_TRANS['email'];?>:<br>
<input class="ConfigAdminInput ENtextbox" type="text"  name="ADMIN[email]" value="<?=$EDIT_ADMIN[Email];?>"></td>
</tr>
<?
if ($show_pass==1) {
	?>
	<tr>
	<td class="ConfigAdmin">
	<?=$ADMIN_TRANS['password'];?>:<br>
	<input type="password" class="ConfigAdminInput ENtextbox" name="ADMIN[pass]" value="<?=$EDIT_ADMIN[Passwd];?>"></td>
	</tr>
	<tr>
	<td class="ConfigAdmin">
	<?=$ADMIN_TRANS['password again'];?>:<br>
	<input type="password" class="ConfigAdminInput ENtextbox" name="ADMIN[repass]" value="<?=$EDIT_ADMIN[Passwd];?>"></td>
	</tr>
	<?
}
?>
<tr>
<td>
<br>
	<input type="submit" value="<?=$ADMIN_TRANS['add new manager'];?>" id="newSaveIcon" class="greenSave"></td>
</tr>
</table>
<input type="hidden" name="sent" value=1>
<input type="hidden" name="uid" value="<?=$uID;?>">
</form>
</div>

<?include_once("footer.inc.php");?>