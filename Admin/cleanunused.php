<?
include_once("../config.inc.php");
function isConfigUse($filename) {
	$db=new Database();
	$db->query("SELECT * from config WHERE VarValue = '$filename'");
	if ($db->nextRecord()) return true;
	else return false;
}
function isCatUse($filename) {
	$db=new Database();
	$db->query("SELECT * from categories WHERE PhotoName='$filename' OR OverlayPhotoName='$filename'");
	if ($db->nextRecord()) return true;
	else return false;
}
function isPhotoUse($filename) {
	$db=new Database();
	$db->query("SELECT * from photos WHERE FileName='$filename'");
	if ($db->nextRecord()) return true;
	else return false;
}
function GetDirList($rootDir) {
	if ($rootDir=="") $rootDir="../";
	$d = opendir($rootDir);
	$i=0;
	while($file_name=readdir($d)){  
//	     	$file_name=$d->read();
	     	$DIRS[name][$i]=$file_name;
	     	$DIRS[isDir][$i]=is_dir($rootDir.$file_name);
	   	if ($file_name=="." OR $file_name==".." OR $DIRS[isDir][$i]) continue;

	     	$isF=$DIRS[isDir][$i];
	     	$DIRS[name][$i];
	     	$DIRS[path][$i]=$rootDir;
	     	//$DIRS[timestamp][$i]=date ("YmdHis", filemtime($rootDir.$file_name));
	     	$i++;
	     	
	 
	}
	closedir($d);
	return $DIRS;
}
$F=GetDirList("../gallery/sitepics/");
if (!is_dir("../gallery/sitepics/trash")) {
	mkdir("../gallery/sitepics/trash");
	chmod("../gallery/sitepics/trash",0777);
}
for ($a=0;$a<count($F[name]);$a++) {
	$f_name=$F[name][$a];
	if (isConfigUse($f_name) OR isCatUse($f_name) OR isPhotoUse($f_name)) continue;
	else {
		$src_file=$F[path][$a].$f_name;
		$dst_file=$F[path][$a]."trash/".$f_name;
		copy($src_file,$dst_file);
		unlink($src_file);
		print $a.": ".$src_file."<br>";
	}
}
?>