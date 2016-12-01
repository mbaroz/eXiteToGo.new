<?
include_once("checkAuth.php");
function GetUsers($userType) {
	$db=new Database();
	$sql="SELECT * from users ORDER BY FirstName,LastName";
	//if ($userType==0) $sql="SELECT * from users";
	$db->query($sql);
	$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$USERS[$fName][$i]=$db->getField($fNum);
			}
			$i++;
		}
	return $USERS;
}
function DelUser($uID) {
	$db=new Database();
	$USID=explode("-",$uID);
	$uID=$USID[1];
	$db->query("DELETE from users WHERE UID='$uID'");
	print "Done !";
	die();
	
}
if ($action=="delUser") DelUser($user_id);
?>
<script language="javascript">
function delUser(uid) {
	var q=confirm("Are you sure ?");
	var sID="<?=session_id();?>-";
	if (q) {
		jQuery(".msgGeneralAdminNotification").load("<?=$PHP_SELF;?>?user_id="+sID+uid+"&action=delUser",function(){showNotification(1);loadAdminPanel(lastLoadedPage);});

	}
	
}

</script>
<div style="width:900px;position:relative;text-align:center">
	<h2><?=$ADMIN_TRANS['site managers'];?></h2>
<table class="ConfigAdmin listTable" width="900" border="0" style="border-collapse:" cellpadding="3" cellspacing="5">
<tr style="background-color:#efefef">
<th><i class="fa fa-trash-o"></i></th><th>First Name</th><th>Last Name</th><th>Email/Username</th><th>LoginCount</th><th style="display:none">Edit</th>
</tr>
<?
$C=GetUsers($MEMBER[UserType]);
for ($a=0;$a<count($C[UID]);$a++) {
	$fName=$C[FirstName][$a];
	$lName=$C[LastName][$a];
	$email=$C[Email][$a];
	$numLogins=$C[LoginCount][$a];
	$uID=$C[UID][$a];
	?>
	<tr>
	<td><a onclick="delUser(<?=$uID;?>);"><i style="color:red;cursor:pointer" class="fa fa-trash-o"></i></td><td><?=$fName;?></td><td><?=$lName;?></td><td><?=$email;?></td><td><?=$numLogins;?></td><td style="display:none"><a href="createUser.php?uid=<?=session_id().'|'.$uID;?>">Edit</a></td>
	</tr>
	<?
}
?>
</table>
<br>
<div style="text-align: <?=$SITE[align];?>;width: 600px;margin-top:30px;">
<a href="#createUser"><div id="newSaveIcon" class="greenSave"><img src="<?=$SITE[url];?>/Admin/images/add_icon.png" border="0" align="absmiddle" /> <?=$ADMIN_TRANS['add new user'];?></div></a>
</div>
</div>