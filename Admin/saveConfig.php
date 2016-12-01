<?
include_once("../config.inc.php");
//include_once("../database.php");
?>
<html>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=<?=$SITE[encoding];?>">
<?
$SQL="UPDATE config SET ";
$db=new Database();
function GetFacebookPageID($url) {
		$options = array(
	        CURLOPT_RETURNTRANSFER => true,     // return web page
	        CURLOPT_HEADER         => false,    // don't return headers
	        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
	        CURLOPT_ENCODING       => "",       // handle all encodings
	        CURLOPT_USERAGENT      => "spider", // who am i
	        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
	        CURLOPT_CONNECTTIMEOUT => 420,      // timeout on connect
	        CURLOPT_TIMEOUT        => 320,      // timeout on response
	        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	    );
	    $ch      = curl_init( $url );
	    curl_setopt_array( $ch, $options );
	    $content = curl_exec( $ch );
	    $err     = curl_errno( $ch );
	    $errmsg  = curl_error( $ch );
	//    print $content;
	    $header  = curl_getinfo( $ch );
	    curl_close( $ch );
	    $id_pos=strpos($content,"?id=");
	    $sub_id_str=substr($content,$id_pos,25);
	    $sub_id_str=str_ireplace('"','',$sub_id_str);
	    $sub_id_str=str_ireplace('?id=','',$sub_id_str);
	    $subPID=explode("\\",$sub_id_str);
	    return $subPID[0];
}
if ($SITE[fb_page_id] !="") {
	//$fb_p_id=GetFacebookPageID($SITE[fb_page_id]);
	
}

if(isset($_POST['SITE']['shopProdsPerPage']) && !isset($_POST['SITE']['showWithTax']))
	$_POST['SITE']['showWithTax'] = 0;
	
if(isset($_POST['SITE']['shopProdsPerPage']) && !isset($_POST['SITE']['enabledVat']))
	$_POST['SITE']['enabledVat'] = 0;	
	
if(isset($_POST['SITE']['shopProdsPerPage']) && !isset($_POST['SITE']['greetingEnabled']))
	$_POST['SITE']['greetingEnabled'] = 0;
	
if(isset($_POST['SITE']['shopProdsPerPage']) && !isset($_POST['SITE']['shippingEnabled']))
	$_POST['SITE']['shippingEnabled'] = 0;
	
if(isset($_POST['SITE']['shopProdsPerPage']) && !isset($_POST['SITE']['memberEnabled']))
	$_POST['SITE']['memberEnabled'] = 0;

if(isset($_POST['SITE']['shopProdsPerPage']) && !isset($_POST['SITE']['couponsEnabled']))
	$_POST['SITE']['couponsEnabled'] = 0;
	
if(isset($_POST['SITE']['shopProdsPerPage']) && !isset($_POST['SITE']['paypal_only']))
	$_POST['SITE']['paypal_only'] = 0;

if ($MEMBER[UserType]==0 AND !$_POST['mobile_config_win'] AND !$_POST['shop_config_win']) {
	if(!isset($_POST['SITE']['formsEnabled']))
		$_POST['SITE']['formsEnabled'] = 0;
	if(!isset($_POST['SITE']['slidoutcontentenable']))
		$_POST['SITE']['slidoutcontentenable'] = 0;
	
	if ($MEMBER[Email]=="mbaroz@gmail.com" OR $MEMBER[Email]=="ofir@gafko.co.il") {
		if(!isset($_POST['SITE']['mobileEnabled']))
			$_POST['SITE']['mobileEnabled'] = 0;
	}
}

foreach ($_POST as $value=>$key) {
	if (!is_array($key)) continue;
	foreach ($key as $v=>$k) {
		
		$varName=$value."[".$v."]";
		if ($varName=='SITE[googleanalytics]' OR $varName=='SITE[googleremarketingcode]') {
			$k=htmlentities($k);
			$k=addslashes($k);

		}
		
		if ($varName=="SITE[description]" OR $varName=="SITE[keywords]" OR $varName=="SITE[title]" OR $varName=="SITE[name]" OR $varName=="SITE[searchformtext]") {
			$k=addslashes($k);
			$k=mysql_real_escape_string($k);
			$k=stripslashes($k);
		}
		if ($varName=='SITE[fb_page_id_num]' AND $fb_p_id!="" AND $k=="") $k=$fb_p_id;
		$updateQuery="VarValue='".$k."'";
		$updateQuery=$SQL." ".$updateQuery." WHERE VarName='".$varName."'";
		$db->query($updateQuery);
		//print $updateQuery."<br />";
	}
}
delCacheKey('siteCONFIG',$m);
delCacheKey('page_id_page',$m);
delCacheKey('id_page',$m);
if (isset($_POST['SITE']['defDirection']) AND $_POST['SITE']['defDirection']!=$SITE_LANG[direction]) {
	$db->query("UPDATE langs SET isDefault=0");
	$db->query("UPDATE langs SET isDefault=1 WHERE LangDirection='{$_POST['SITE']['defDirection']}'");
	$post_message=" To apply new language please Sign In again";
	if ($SITE_LANG[selected]=="he") $post_message="על מנת להפעיל את הגדרת השפה יש לצאת ולהיכנס שוב למצב ניהול";
	unset($SITE_LANG);
	delCacheKey('deflang',$m);
	delCacheKey('admin_translations',$m);
}
print $ADMIN_TRANS['changes saved'].'<br>'.$post_message;
?>

