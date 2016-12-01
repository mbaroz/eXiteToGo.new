<?header("Content-Type:text/html; charset=utf-8");?>
<?include_once("../config.inc.php");?>
<?include_once("../".$SITE_LANG[dir]."database.php");?>
<?include_once("../inc/GetServerData.inc.php");?>
<?include_once("lang.admin.php");?>
<div style="text-align:left"><img src="<?=$SITE[url];?>/images/close_icon.gif" border="0" class="button" onclick="ShowLayer('pageCatsContainer',0,1);"></div>
<input id="saveContentButton" type="button" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="SavePageCats(document.all_cats);">
<p></p>
<form id="all_cats" name="all_cats">
<?
function ListCatsTree($level, $parent,$pageID) {
	
	$C_CATS=GetContentCats($pageID);
	$ALL_CATS=GetCatMenu();
	for ($a=0;$a<count($ALL_CATS[CatID]);$a++) {
		$indent="";
		$c_id=$ALL_CATS[CatID][$a];
		$c_name=$ALL_CATS[MenuTitle][$a];
		$checked="";
		for ($b=0;$b<count($C_CATS[CatID]);$b++) {
			if ($c_id==$C_CATS[CatID][$b]) {
				$checked="checked";
				break;
			}
		}
		if ($ALL_CATS[ParentID][$a] == $parent) {
	  		for ($j=0; $j<$level; $j++) {
	  			if ($j>0)	  $indent.="──"; 
	  			else $indent.="&nbsp;&nbsp;&nbsp;┘";
  			
	   		} //end inner for
	   		?>
	   		<?=$indent;?><input type="checkbox" id="CAT_SELECTED[]" name="CAT_SELECTED[]" <?=$checked;?> value="<?=$c_id;?>">&nbsp;
	   		<?=$c_name."<br />";
	   		ListCatsTree($level+1, $ALL_CATS[CatID][$a],$pageID);
		} //end if
 	} //end upper for
} //end function
ListCatsTree(0,0,$pageID);
?>
<input type="hidden" name="pageID" value="<?=$pageID;?>">
</form><br />
<input id="saveContentButton" type="button" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="SavePageCats(document.all_cats);"> 