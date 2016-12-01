<?
include_once("checkAuth.php");
include_once("../config.inc.php");
$REDIRECTS=ListRedirects();
$action_sent=$_POST['action'];
if (!isset($_SESSION['LOGGED_ADMIN'])) die("Administration Session expired, please login!");
if ($action=="add" AND ($_POST['src']=="" OR $_POST['dst']=="")) die("Please enter a valid source or destination URL"); 
if ($action=="add" AND ($_POST['src']==$_POST['dst'])) die("Source and destination cannot be ithe same!"); 
if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-=]+)*(:[0-9]+)?(/.*)?$|i', $_POST['src']) AND $action=="add") die("Source URL is invalid");
if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $_POST['dst']) AND $action=="add") die("Destination URL is invalid");
function AddRedirect($s,$d) {
    global $SITE;
    $db=new Database();
    $s_Parsed=parse_url($s);
    $s_Host=$s_Parsed['host'];
    $s_HostUrl=$s_Parsed['scheme'].'://'.$s_Host;
    $newDest=str_ireplace($SITE[url],$s_HostUrl,$d);
    
    $db->query("SELECT * FROM redirects WHERE  Source='$s' AND Destination='$d'");
    if ($db->nextRecord()) die("Redirect URL's already exists");
    else $db->query("INSERT INTO redirects SET Source='$s',Destination='$newDest'");
    
}
function DelRedirect($rID) {
    $db=new Database();
    $db->query("DELETE from redirects WHERE RedirectID='$rID'");      
}
if ($action=="add") {
    AddRedirect($_POST['src'],$_POST['dst']);
    die("Redirection Added Succefully.");
}
if ($action=="delredirect" AND $sc=session_id() AND $rID) {
    DelRedirect($rID);
    die("<font color='red'>Redirection Removed</font>");
        
    
}
?>


<table cellpadding="2" cellspacing="2">
<tr style="background-color:#efefef">
        <th><?=$ADMIN_TRANS['delete'];?></th>
        <th><?=$ADMIN_TRANS['source page url'];?></th>
        <th><?=$ADMIN_TRANS['destination page url'];?></th>
</tr>
<?
for ($a=0;$a<count($REDIRECTS[RedirectID]);$a++) {
    $redirID=$REDIRECTS[RedirectID][$a];
    ?>
    <tr>
        <td style="width:10px;cursor:pointer" onclick="deleteRedirect(<?=$redirID;?>);"><img src="/Admin/images/delIcon.png" /></td>
        <td style="width:400px;max-width: 400px"><a href="<?=urldecode($REDIRECTS[Source][$a]);?>" target="_blank"><?=urldecode($REDIRECTS[Source][$a]);?></a></td>
        <td style="width:400px;max-width: 400px"><?=urldecode($REDIRECTS[Destination][$a]);?></td>
    </tr>
        
    <?
}
?>
</table>