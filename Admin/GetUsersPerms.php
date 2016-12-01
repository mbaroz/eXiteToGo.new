<?header("Content-Type:text/html; charset=utf-8");?>
<?include_once("../config.inc.php");?>
<?include_once("../".$SITE_LANG[dir]."database.php");?>
<?include_once("../inc/GetServerData.inc.php");?>
<?
function GetPermsUsers($userType) {
	$db=new Database();
	$sql="SELECT users.UID, users.Email, users.FirstName,users.LastName, users_perms.CatID FROM users LEFT JOIN users_perms
        ON users.UID = users_perms.UID LEFT JOIN categories ON users_perms.CatID = categories.CatID
        GROUP BY users.UID";
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
$selectedCatID=$_GET['cID'];
$ALL_USERS=GetPermsUsers(0);
$db=new database();
$db->query("SELECT isSecured from categories WHERE CatID='$selectedCatID'");
$db->nextRecord();
$is_cat_secured=$db->getField("isSecured");
$class_secured="unlocked_cat";
$text_secured=$ADMIN_TRANS['access allowed to everyone'];
$selected_switch="onDo";
if ($is_cat_secured) {
	$class_secured="locked_cat";
	$text_secured=$ADMIN_TRANS['access restricted to users'];
	$selected_switch="";
}
?>
<style>
    .all_users {overflow-y: auto;max-height:250px;}
    .all_users table{width:680px;border:0px;}
    .all_users table td, .all_users table th {
        width:200px;
	padding:6px 6px 6px 6px;
	text-align: <?=$SITE[align];?>;
	font-size: 15px;
    }
    
    .user_unperm {      background-color: #cccccc; }
    .user_perm {      background-color: #92d17e;color:white }
    .u_row {cursor: pointer}
    .titleUsersPerm {font-size:16px;font-weight:bold;margin-bottom:50;margin-top: 10px;margin-<?=$SITE[align];?>:63px;float:<?=$SITE[align];?>;border-bottom:1px solid silver;}
    #addUserMiniForm {display: none;width:670px;position:static;margin-top:20px;background: #fff1a8;min-height: 75px}
    #addUserMiniForm .adduserfrm {display: inline-block;}
    .HEtextbox, .ENtextbox {width:150px;height:20px;}
    #email {width:180px;direction: ltr}
    #fullname {width:170px;}
    .button {
	
	font-family:arial;
	font-weight:bold;
	font-size:12px;
    }
	.lock_unlock_flag{
		float: <?=$SITE[opalign];?>;
		margin-<?=$SITE[opalign];?>:10px;
		font-size:12px;
		margin-top:5px;
		text-align: left;
	}
	.wrapper, .on {
		border-radius: 3px;
		-moz-box-shadow: 1px 1px 2px rgba(0,0,0,.2);
		-webkit-box-shadow: 1px 1px 2px rgba(0,0,0,.2);
		box-shadow: 1px 1px 2px rgba(0,0,0,.2);
		direction: ltr;
		text-align:left;
	    }
	    .wrapper {
		background-color:#dddddd;
		width:65px;height:22px;
		overflow: hidden;
		border: 1px solid #aaa;
		cursor: pointer;
		white-space: nowrap;
		direction: ltr;
		float:<?=$SITE[opalign];?>;
	    }
	    .on {
		display: inline-block;
		width:28px;
		height:22px;background-color: #FF0000;
		background-image: -webkit-linear-gradient(top,#E10000,#FF0000);
		background-image: -moz-linear-gradient(top,#E10000,#FF0000);
		border: 1px solid #E10000;
		
		padding:0px;
		
	    }
	    
	    .onText {
		margin-left:40px;
		background:url('/Admin/images/locked.png') no-repeat center left;
		width:25px;
		height:22px;
	    }
	   .offText {
		display: none;
		background:url('/Admin/images/unlocked.png') no-repeat center right;
		width:25px;
		height:22px;
	   }
	  
	    .onDo {
		margin-left:36px;
		-moz-transition: margin-left 230ms ease-in-out;
		-webkit-transition: margin-left 230ms ease-in-out;
		background-color: #61d10f;
		background-image: -webkit-linear-gradient(top,#61d10f,#52af0d);
		background-image: -moz-linear-gradient(top,#61d10f,#52af0d);
		border: 1px solid #61d10f;
	    }
	    .offDo {
		margin-left:0px;
		-moz-transition: margin-left 230ms ease-in-out;
		-webkit-transition: margin-left 230ms ease-in-out;
	    }
	    .onDo .onText {
		display: none;
	    }
	    .onDo .offText {
		display: block;
		margin-left: -40px;
	    }
	    .wrapper_all_lock_status {
		float:<?=$SITE[align];?>;
		width:350px;
		margin-<?=$SITE[opalign];?>:80px;
		margin-top:8px;
	    }
</style>
<script>
	
    function SavePerms() {
        var url="<?=$SITE[url];?>/Admin/saveUsersPerms.php";
        var inputStr = '?cID=<?=$selectedCatID;?>';
	jQuery('#U_P:checked').each(function(){
		inputStr += '&'+encodeURIComponent(jQuery(this).attr('name'))+'[]='+encodeURIComponent(jQuery(this).val());
	});
        jQuery("#LoadingDivPerms").load(url+inputStr);
    }
    function check_row(r,st) {
        if (st.checked) {
            jQuery('#'+r).removeClass("user_unperm");
            jQuery('#'+r).addClass("user_perm");
        }
        else {
            jQuery('#'+r).removeClass("user_perm");
            jQuery('#'+r).addClass("user_unperm");
          }
    }
    
    function select_all(st) {
        if (st.checked) jQuery('.all_users').find(':checkbox').attr('checked', 'checked');
        else jQuery('.all_users td').find(':checkbox').removeAttr('checked');
    }
    function AddNewUserPerm(s) {
        if (s) {
        	jQuery(".savepermswrapper").hide();
            jQuery("#addUserMiniForm").show();
            jQuery("#listAllUsers").css("opacity","0.5");
	    jQuery("#save_user_perms:input").hide();
	    jQuery(".add_button").hide();
        }
        else {
            jQuery("#addUserMiniForm").hide();
            jQuery(".savepermswrapper").show();
            
            jQuery("#listAllUsers").css("opacity","1");
            url="<?=$SITE[url];?>/Admin/GetUsersPerms.php?cID=<?=$selectedCatID;?>";
            jQuery("#UsersPerms").load(url);
	    jQuery("#save_user_perms:input").show();
	    jQuery(".add_button").show();
	   
        }
    }
    function delUserPerm(u_i_d) {
        var a=confirm("<?=$ADMIN_TRANS['are you sure ?'];?>");
        if (a) {
            var url="<?=$SITE[url];?>/Admin/saveUsersPerms.php?action=deluser&user_id="+u_i_d;
            jQuery("#LoadingDivPerms").load(url);
        }
            
    }
    function saveNewUser() {
        var fn=encodeURIComponent(jQuery("#fullname").val());
        var e=jQuery("#email").val();
        var p=jQuery("#pass").val();
        var url="<?=$SITE[url];?>/Admin/saveUsersPerms.php?action=adduser&fname="+fn+"&e="+e+"&p="+p;
          jQuery("#LoadingDivPerms").load(url);
    }
    function setCatSecured(cid,sec) {
	var url="<?=$SITE[url];?>/Admin/saveUsersPerms.php?action=setCatSecured&cID="+cid+"&sec="+sec;
	jQuery("#LoadingDivPerms").load(url);
    }
	var permStatus=0;
	function setPerm() {
	if (permStatus==0) {
		jQuery(".on").addClass("onDo");
		jQuery(".on").removeClass("offDo");
		jQuery("#LockText").html("<?=$ADMIN_TRANS['access allowed to everyone'];?>");
		permStatus=1;
		setCatSecured(<?=$selectedCatID;?>,0);
	    }
	    else {
		jQuery(".on").addClass("offDo");
		jQuery(".on").removeClass("onDo");
		jQuery("#LockText").html("<?=$ADMIN_TRANS['access restricted to users'];?>");
		permStatus=0;
		setCatSecured(<?=$selectedCatID;?>,1);
	    }
	}
    
</script>

<div class="all_users" align="center" id="listAllUsers">
	
    <div class="titleUsersPerm" align="<?=$SITE[align];?>"><?=$ADMIN_TRANS['users and permissions'];?></div>

	<div class="wrapper_all_lock_status">
		<div class="wrapper" onclick="setPerm();">
			<div class="on <?=$selected_switch;?>">
				<div class="onText"></div>
				<div class="offText"></div>
			</div>
		</div>
		<div class="lock_unlock_flag">
			<span id="LockText"><?=$text_secured;?></span>
		</div>
	</div>
	<div style="clear:both;height:20px;"></div>
    <table>
        <tr>
              <th><input type="checkbox" onclick="select_all(this);"><?=$ADMIN_TRANS['access to this page'];?></th>
            <th><?=$ADMIN_TRANS['user'];?></th>
            <th><?=$ADMIN_TRANS['full name'];?></th>
            <th><?=$ADMIN_TRANS['delete'];?></th>
        </tr>
        <?
        for($a=0;$a<count($ALL_USERS[UID]);$a++) {
            $is_checked="";
            $uid=$ALL_USERS[UID][$a];
            $selected_class="user_unperm";
            if (GetResolvedPerms($uid,$selectedCatID)) {
                $is_checked="checked";
                $selected_class="user_perm";
            }
            ?>
            <tr class="<?=$selected_class;?> u_row" id="row-<?=$a;?>">
                <td><input type="checkbox" id="U_P" value="<?=$uid;?>" name="U_P" <?=$is_checked;?> onclick="check_row('row-<?=$a;?>',this)";></td>
                <td stye="text-align:left"><?=$ALL_USERS[Email][$a];?></td>
                <td><?=$ALL_USERS[FirstName][$a]." ".$ALL_USERS[LastName][$a];?></td>
                <td onclick="delUserPerm(<?=$uid;?>);"><i class="fa fa-trash-o"></i></td>
            </tr>
                
            <?
        }
        ?>
    </table>
</div>
<div class="all_users" align="center">
        <table>
    <tr>
        <td colspan="3" style="padding:0px">
             <div style="text-align: <?=$SITE[align];?>;margin-top:20px">
              <span id="LoadingDivPerms"></span>

              <div onclick="AddNewUserPerm(1);" id="newSaveIcon" class="add_button"> <?=$ADMIN_TRANS['add new user'];?> </div>
             <div style="clear:both;height:10px;"></div>
             <div class="savepermswrapper">
		      	<div id="newSaveIcon" class="greenSave" onclick="SavePerms();" id="save_user_perms"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" align="absmiddle" border="0" />&nbsp;<?=$ADMIN_TRANS['save changes'];?></div>
				<div id="newSaveIcon" class="cancel" onclick="EditUsersPerms();"><?=$ADMIN_TRANS['cancel'];?></div>    
              </div>
                
            </div>
            <div id="addUserMiniForm" class="EditorBox">
                <div class="adduserfrm"><?=$ADMIN_TRANS['full name'];?>: <input type="text" class="ENtextbox" name="fullname" id="fullname"></div>
                <div class="adduserfrm"><?=$ADMIN_TRANS['email'];?>: <input type="text" class="ENtextbox" name="email" id="email"></div>
                <div class="adduserfrm"><?=$ADMIN_TRANS['password'];?>: <input type="text" class="ENtextbox" name="pass" id="pass"></div>
               	<div style="clear:both;height:20px;"></div>
                <div id="newSaveIcon" class="greenSave" onclick="saveNewUser()"><?=$ADMIN_TRANS['save'];?></div>
                <div id="newSaveIcon" class="cancel" onclick="AddNewUserPerm(0)"><?=$ADMIN_TRANS['cancel'];?></div>
                
            </div>
        </td>
    </tr>
    </table>
</div>