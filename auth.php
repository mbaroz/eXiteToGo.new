<?
$temp_urlKey=$urlKey;

if ($CHECK_PAGE) {
	$temp_urlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
	$CP_ID=GetIDFromUrlKey($temp_urlKey);
	$CAT_SECURED=GetCategoryByID($CP_ID[parentID]);
}
else $CAT_SECURED=GetCategoryByID($CHECK_CATPAGE[parentID]);
if ($CAT_SECURED[isSecured]==1) {
	if (!isset($scid)) $_SESSION['scid']=session_id();
	if ($urlKey!="login") $scid=$CAT_SECURED[CatID];
	$secured_urlKey=$CAT_SECURED[UrlKey];
	if (!isset($_SESSION['ret_url'])) $_SESSION['ret_url']="";
	//$checkUrlKey=GetRootUrlKey($temp_urlKey);
	
	if ($urlKey!="login" AND !isset($_SESSION['USER_LOGGEDIN']) AND !isset($_SESSION['LOGGED_ADMIN'])) {
		if ($urlKey!="login") $ret_url=$_SERVER['REQUEST_URI'];
		header("Location:/pages/login");
	}
	if (isset($_SESSION['USER_LOGGEDIN'])) {
		$sCID=$CAT_SECURED[CatID];
		if ($urlKey!="login") $ret_url=$_SERVER['REQUEST_URI'];
		if (!GetResolvedPerms($USER_LOGGED[uid],$CAT_SECURED[CatID])) header("Location:/pages/login");
	}
}

?>