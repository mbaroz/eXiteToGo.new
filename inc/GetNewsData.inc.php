<?
function formatDate($date,$type) {
		$DATETIME_ARRAY=explode(" ",$date);
		$DATE_ARRAY=explode("-",$DATETIME_ARRAY[0]);
		$TIME_ARRAY=explode(":",$DATETIME_ARRAY[1]);
		$month=$DATE_ARRAY[1];
		$year=$DATE_ARRAY[0];
		$day=$DATE_ARRAY[2];
		$hour=$TIME_ARRAY[0];
		$minute=$TIME_ARRAY[1];
		if ($type=="EN") $D=date('m-d-Y H:i',mktime($hour,$minute,0,$month,$day,$year));
			else $D=date('d/m/Y H:i',mktime($hour,$minute,0,$month,$day,$year));
	return $D;
}
function GetNews($catID=0,$galID="") {
		$db=new database;
		$sql="SELECT * from  news WHERE CatID='$catID' ORDER BY NewsOrder, NewsDate DESC";
		if ($galID) $sql="SELECT * from  news WHERE GalleryID='$galID' ORDER BY NewsOrder, NewsDate DESC";
		$db->query($sql);
		$i=0;
		while ($db->nextRecord()) {
			$numFields=$db->numFields();
			for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$NEWS[$fName][$i]=$db->getField($fNum);
			}
			$i++;
		}
		return $NEWS;
}
function GetNewsContent($newsID) {
		$db=new database;
		$sql="SELECT * from news where NewsID='$newsID'";
		$db->query($sql);
		$db->nextRecord();
		$numFields=$db->numFields();
		for ($fNum=0;$fNum<$numFields;$fNum++) {
			$fName=$db->getFieldName($fNum);
			$NEWSDETAILS[$fName]=$db->getField($fNum);
		}
		return $NEWSDETAILS;
}
