<?header("Content-Type:text/html; charset=utf-8");?>
<?include_once("../config.inc.php");?>
<?include_once("../".$SITE_LANG[dir]."database.php");?>
<?include_once("../inc/GetServerData.inc.php");?>
<style>
	.catNodeA {color:red;}
</style>
<?
if ($_GET['s']=="") {
	?>
	<script src="<?=$SITE[url];?>/js/jquery.highlight-4.closure.js"></script>
	<?
}
?>
<div style="direction: <?=$SITE_LANG[direction];?>" class="cat_tree_all">
<?
function GetCatMenuBySearch($q="") {
		$db=new Database();
		$q=strip_tags($q);
		$q=ltrim($q);
		//$sql="select * from categories WHERE MenuTitle!='' AND MenuTitle LIKE '%$q%' ORDER BY CatID ASC,PageOrder"; 
		$sql="select * from categories WHERE MenuTitle!='' AND MenuTitle NOT LIKE '%footer%' AND MenuTitle NOT LIKE '%result%' ORDER BY CatID ASC,PageOrder"; 
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
$currentCatID=$_GET['currentCatEditedID'];
function ListCatsTree($level, $parent,$pageID) {
	//if ($level==0) $qq=$_GET['s'];
	//else $qq="";
	$q=$_GET['s'];
	if ($q=="") $q=false;
	global $ALL_CATS;
	global $currentCatID;
	if ($level==0) $root_class=" root_class";
	for ($a=0;$a<count($ALL_CATS[CatID]);$a++) {
		if ($currentCatID==$ALL_CATS[ParentID][$a]) continue;
		$show=1;
		$indent="";
		$c_id=$ALL_CATS[CatID][$a];
		$c_name=$ALL_CATS[MenuTitle][$a];
		//if ($ALL_CATS[UrlKey][$a]=="home" AND $level==0) print $c_name."<br />";
		$checked="";
		if (!stristr($c_name,$q) AND $q!="") $show=0;
		
		if ($ALL_CATS[ParentID][$a] == $parent) {
			
			if ($q) {
				if (!stristr($c_name,$q)) $show=0;
			}
			
			for ($j=0; $j<$level; $j++) {
	  			if ($j>0)  $indent.="─"; 
	  			else $indent.="&nbsp;&nbsp;┘";
  			
	   		} //end inner for
			if ($show==1) {
				if ($level==0) print "<br/>";
				print $indent."<span class='cat_node".$root_class."' onclick='moveCategory(".$c_id.");'>".$c_name."</span><br />";
				
			}
	   		ListCatsTree($level+1, $ALL_CATS[CatID][$a],$pageID);
		} //end if
 	} //end upper for
} //end function
$ALL_CATS=GetCatMenuBySearch($_GET['s']);
print "<span class='cat_node root_class' onclick='moveCategory(0);'>".$ADMIN_TRANS['top menu']."</span><hr size='1' width='99%'>";
ListCatsTree(0,0,0);
?>

</div>