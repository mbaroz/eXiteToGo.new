<style>
.map_site_col{float:none;width:31.3%;box-sizing:border-box;padding:10px;background:white;color:#333;margin:1%;}
.map_site_col a {text-decoration: underline;}
.sitemapWrapper .titleContent {padding-right: 10px;}
</style>

<div class="sitemapWrapper mainContentText">
<span style="titleContent"><h1>מפת אתר</h1></span>
<?
function GetCatMenuBySearch() {
		$db=new Database();
		$q=strip_tags($q);
		$q=ltrim($q);
		$sql="select * from categories WHERE MenuTitle!='' AND ViewStatus=1 AND MenuTitle NOT LIKE '%footer%' AND MenuTitle NOT LIKE '%result%' ORDER BY CatID ASC,PageOrder"; 
		$db->query($sql);
		$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
					$MENU[$fName][$i]=$db->getField($fNum);
			}
			$i++;
		}
	return $MENU;
}
function ListCatsTree($level, $parent,$pageID) {
	//if ($level==0) $qq=$_GET['s'];
	//else $qq="";
	global $SITE;
	$q=$_GET['s'];
	if ($q=="") $q=false;
	global $ALL_CATS;
	if ($level==0) {
		$root_class=" root_class";
		
	}

	for ($a=0;$a<count($ALL_CATS[CatID]);$a++) {
		$show=1;
		$indent="";
		$c_id=$ALL_CATS[CatID][$a];
		$c_name=$ALL_CATS[MenuTitle][$a];
		$c_link=$SITE[url]."/category/".$ALL_CATS['UrlKey'][$a];
		//if ($ALL_CATS[UrlKey][$a]=="home" AND $level==0) print $c_name."<br />";
		$checked="";
		
		if ($ALL_CATS[ParentID][$a] == $parent) {
			
			for ($j=0; $j<$level; $j++) {
	  			if ($j>0)  $indent.="─"; 
	  			else $indent.="&nbsp;&nbsp;┘";
  			
	   		} //end inner for
			if ($show==1) {
				if ($level==0) print '<div class="map_site_col">';
				
				print $indent."<span class='cat_node".$root_class."'><a href='".$c_link."'>".$c_name."</a></span><br />";
				

				
			}

	   		ListCatsTree($level+1, $ALL_CATS[CatID][$a],$pageID);
	   		if ($level==0) print '</div>';
		} //end if
 	} //end upper for
 	
} //end function
$ALL_CATS=GetCatMenuBySearch();
ListCatsTree(0,0,0);
?>
</div>
