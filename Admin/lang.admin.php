<?
if (!isset($ADMIN_TRANS)) {
	if (!$ADMIN_TRANS=getCacheResult('admin_translations',$m)) {
		$ADMIN_TRANS=GetAdminLanguages();
		$_SESSION['ADMIN_TRANS']=setCacheVal('admin_translations',$ADMIN_TRANS,$m);
	}
	
	$ADMIN_TRANS['edit photo']="Edit Photo/Video";
	$ADMIN_TRANS['upload/edit photo']="Upload/Edit Photo or Video";
	$ADMIN_TRANS['page style']="Page Settings";
	$ADMIN_TRANS['add new page']="Add new page";
	if ($SITE_LANG[selected]=="he") {
		$ADMIN_TRANS['edit photo']="ערוך תמונה/וידאו";
		$ADMIN_TRANS['upload/edit photo']="העלאת תמונה או וידאו";
		$ADMIN_TRANS['add new page']="הוסף עמוד חדש";
		$ADMIN_TRANS['page style']="הגדרות עמוד";
	}

	$_SESSION['ADMIN_TRANS']=$ADMIN_TRANS;
}
?>