<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
include_once("../inc/GetServerData.inc.php");
$LOGIN_LABEL=array("User added succefully","Email address is invalid","Password should contain at least 4 characters","A user with same username/email already exists","Restrict access to this category for selected users only?");
if ($SITE_LANG[selected]=="he") {
	$LOGIN_LABEL=array("משתמש התווסף בהצלחה","כתובת אימייל/שם משתמש אינם תקינים","אורך סיסמה חייב להיות לפחות 4 תוים","נמצא משתמש עם כתובת אימייל/שם משתמש זהים","האם להפוך קטגוריה זו למוגנת סיסמה עבור המשתמשים שנבחרו?");
}
$resolvedPerms=$_GET['U_P'];
$selected_cat=$_GET['cID'];
if (!isset($_SESSION['LOGGED_ADMIN'])) die();
function AddUser($U) {
        global $LOGIN_LABEL;
        if ($U[email]=="") die("<font color=red>".$LOGIN_LABEL[1]."</font>");
        if (strlen($U[pass])<3) die("<font color=red>".$LOGIN_LABEL[2]."</font>");
	$db=new Database();
		$db->query("select * from users WHERE Email='$U[email]'");
		if (!$db->nextRecord()) {
			$U[securePass]=sha1($U[pass]);
			$sql="INSERT INTO users (FirstName,LastName,Email,Passwd,UserType,CategoryPerms) VALUES ('{$U[fname]}','{$U[lname]}','$U[email]','$U[securePass]',1,1)";
			$db->query($sql);
			print $LOGIN_LABEL[0];
                        ?>
                        <script>AddNewUserPerm(0)</script>
                        <?

		}
		else 	print "<font color='red'>".$LOGIN_LABEL[3]."</font>";
}

switch($_GET['action']) {
    case "adduser":
	$FN=explode(" ",$_GET['fname']);
	$U[fname]=$FN[0];
        $U[lname]=$FN[1];
        if ($FN[2]) $U[lname].=" ".$FN[2];
	if ($FN[2]) $U[lname].=" ".$FN2[2];
        $U[email]=$_GET['e'];
        $U[pass]=$_GET['p'];
        AddUser($U);
        die();
        break;
    case "deluser":
        $db=new database();
        $userID_Delete=$_GET['user_id'];
        $db->query("delete from users WHERE UID='$userID_Delete'");
         ?>
        <script>AddNewUserPerm(0)</script>
        <?
        break;
    case "setCatSecured":
	$cat_to_be_secured=$_GET['cID'];
	$setSecured=$_GET['sec'];
	$db=new database();
	$db->query("UPDATE categories SET isSecured=".$setSecured." WHERE CatID='$cat_to_be_secured'");
	break;
    default:
        if ($selected_cat=="") die();
        $db=new database();
	$db->query("SELECT isSecured from categories WHERE CatID='$selected_cat'");
	$db->nextRecord();
	$is_cat_secured=$db->getField("isSecured");
        $db->query("DELETE from users_perms WHERE CatID='$selected_cat'");
        if (is_array($resolvedPerms)) {
           
            for ($a=0;$a<count($resolvedPerms);$a++) {
                $uid=$resolvedPerms[$a];
                $users_insertion_val.="(".$resolvedPerms[$a].",".$selected_cat."),";
                $db->query("UPDATE users SET CategoryPerms=1 WHERE UID='$uid'");
            }
            $users_insertion_val=substr($users_insertion_val,0,strlen($users_insertion_val)-1);
           $db->query("INSERT INTO users_perms (UID,CatID) VALUES  ".$users_insertion_val);
	   if ($is_cat_secured==0) {
		?>
		<script>
			var s=confirm("<?=$LOGIN_LABEL[4];?>");
			if (s) setCatSecured(<?=$selected_cat;?>,1);
		</script>
		<?
	   }
        }
        ?>
        <script>
            window.setTimeout('EditUsersPerms()',1000);
	    
        </script>
        <?
        break;
}
?>
<span class='successEdit'><?=$ADMIN_TRANS['changes saved'];?></span>