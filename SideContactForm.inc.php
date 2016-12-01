<?
//if ($urlKey=="home") $ADMIN_TRANS['remove contact form']=$ADMIN_TRANS['add contact form'];
function GetSideContactFormStatus($urlKey) {
	global $P_DETAILS;
	$db=new Database();
	$sideContactShow=$P_DETAILS[ShowContactForm];
	$parentID=1;
	$urlKey=str_ireplace("/","",$urlKey);
	$tempUrlKey=$urlKey;
	while ($sideContactShow==0 AND $parentID!=0) {
		$parURL_KEY=GetParentUrlKey($tempUrlKey);
		$parent_url_key=$parURL_KEY[ParentUrlKey];
		$sql="SELECT ShowContactForm from categories WHERE UrlKey='$parent_url_key'";
		$db->query($sql);
		$db->nextRecord();
		$parentID=$parURL_KEY[ParentID];
		$tempUrlKey=$parent_url_key;
		$sideContactShow=$db->getField("ShowContactForm");
		
	}
	return $sideContactShow;
	
}
$sideContactStatus=GetSideContactFormStatus($urlKey);

$contactside_checked="";
if ($sideContactStatus==1) $contactside_checked="checked";

if (isset($_SESSION['LOGGED_ADMIN']) AND $CHECK_CATPAGE) {
	if ($P_DETAILS[ShowContactForm]==1)
	?>
	<script language="javascript">
		function setSideContactForm() {
			var side_contact_check;
			if($('set_side_contact').checked) side_contact_check=1;
			else side_contact_check=-1;
			var cat_urlkey='<?=$urlKey;?>';
			var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
			var pars = 'action=setSideContactForm&isChecked='+side_contact_check+'&cat_urlKey='+cat_urlkey;
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			window.setTimeout('ReloadPage()',800);
		}
	</script>
	<div style="border:1px dotted #<?=$SITE[contenttextcolor];?>">
	<div style="color:#<?=$SITE[contenttextcolor];?>;"><input onclick="setSideContactForm()" type="checkbox" id="set_side_contact" name="set_side_contact" <?=$contactside_checked;?>><?=$ADMIN_TRANS['add contact form'];?></div>
	<?
}	

if ($sideContactStatus==1) {
	include_once("SideContactText.php");
	if (!strpos($SIDE_CONTACT_CONTENT[Content],"iframeCustomForm.php")) include_once("contact_side".$contactAdvanced.".php");
}
if (isset($_SESSION['LOGGED_ADMIN']) AND $CHECK_CATPAGE) print '</div>'; //closing the dootted fram border