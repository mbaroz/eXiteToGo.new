<?
session_start();
if (!$inc_dir) $inc_dir="";
 //Added 06-12-2009
//include_once("vars.inc.php"); //for compatibility with register_globals=off

include_once("database.php");
include_once($inc_dir."inc/GetServerData.inc.php");
//unset($_SESSION['SITE_LANG']);
if (!isset($SITE_LANG)) {

	if (!$S_LANG=getCacheResult('deflang',$m)) {
		$db=new database();
		$db->query("SELECT LangCode,LangDirection from langs WHERE isDefault='1' LIMIT 1");
		$db->nextRecord();
		$SITE_LANG[selected]=$db->getField("LangCode");
		$SITE_LANG[direction]=$db->getField("LangDirection");
		$_SESSION['SITE_LANG']=setCacheVal('deflang',$SITE_LANG,$m);

	}
	else {
		$_SESSION['SITE_LANG']=$S_LANG;

	}
	$_SESSION['def_lang']=$SITE_LANG['selected'];
}
$SITE_LANG=$_SESSION['SITE_LANG'];
$default_lang=$SITE_LANG['selected'];

if ($SITE_LANG[selected]=="") $SITE_LANG[selected]=$default_lang;
$SITE_LANG[directive]=$SITE_LANG[dir]="";
	if ($SITE_LANG[selected]!=$default_lang) {
		$SITE_LANG[directive]="/".$SITE_LANG[selected];
		$SITE_LANG[dir]=$SITE_LANG[selected]."/";
}


//include_once($inc_dir."language.inc.php");
$AWS_S3_ENABLED=true;
//~~~~~SITE~~~~~~~~~~~~
//if (!session_is_registered('SITE')) session_register('SITE');
//if (!session_is_registered('RET_URL')) session_register('RET_URL'); //check!
//if (!session_is_registered('BASE_URI')) session_register('BASE_URI');//check!

if (!isset($SITE)) {

	$CONF=GetConfigVars();
		for ($a=0;$a<count($CONF[ConfigID]);$a++) {
			$pos=stripos($CONF[VarName][$a],"[");
			$ARRAY_NAME=substr($CONF[VarName][$a],0,$pos);
			$ARRAY_KEY=substr($CONF[VarName][$a],$pos+1,-1);
			$SITE[$ARRAY_KEY]=$CONF[VarValue][$a];

			//session_register($ARRAY_NAME);
			$_SESSION['set_vars']=1;
		}

		
		$SITE['S3_FOLDER']=$_SERVER['SERVER_NAME'];
		$SITE[media]=$SITE[url].$SITE_LANG[directive];
		
		$_SESSION['SITE']=$SITE;

}
$SITE[base_dir]="".$SITE_LANG[directive];
$SITE[encoding]="UTF-8";

$shopActivated=$SITE[shopEnabled];
if ($shopActivated) require_once 'shopLang.php';

if($AWS_S3_ENABLED){
		define('SITE_MEDIA', "//cdn.exiteme.com/exitetogo/" . $SITE['S3_FOLDER']);
		}
		else{
			define('SITE_MEDIA', $SITE[media]);
		}

if (!$PROD[totalperpage]) $PROD[totalperpage]=6;
if (!$SITE[url]) $SITE[url]="http://".$_SERVER['SERVER_NAME'];
$PROD[uploadmaxsize]=500000; // in Bytes
$PROD[imagesLocation]="images/products/"; // in Bytes
$SITE['cdn_url']="//cdn.exiteme.com";

// NOTE: $SITE['S3_FOLDER'] the directory of the user. 


// Define constant for site media URL.

 
//Overwrite ~~~~~~~~~~~~~~~
//$SITE[url]="http://localhost/demo";
//Overwrite ~~~~~~~~~~~~~~~
$gallery_dir="gallery";
$video_gallery_dir="video";
$gallery_photo_w="164";
$gallery_photo_h="120";
$CONVERT_EXIST=0; //Parameter to declare if convert2flv will occour on the server
if (isset($_SESSION['LOGGED_ADMIN']) AND !defined('ADMIN_MODE')) define('ADMIN_MODE',true);
?>