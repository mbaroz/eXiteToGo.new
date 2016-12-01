<?
include_once("checkAuth.php");
include_once("header.inc.php");
include_once("../formgenerator.inc.php");
include_once("../GetData.php");
include_once("../cats.inc.php");
include("../editor/fckeditor.php") ;
?>
<div class="general">
<form name=editcontent action="<?=$PHP_SELF;?>" method="GET">
<span class="maincolor"><?=$CONTENT_LABEL[0];?> : </span>
<select name="pageID" class="HETextbox" onchange="editcontent.submit()">
<option value=""><-<?=$CONTENT_LABEL[6];?>-></option>
<?
function ListTopPagesTree($level, $parent,$pageID) {
	global $parentID;
	$cID=$parentID;
	$CATS=GetContentMenu();
	$categoryCount=count($CATS[PageID]);
	 for ($i=0; $i<$categoryCount; $i++) {
	 	$indent="";
	 	$font_color="black";
	  	if ($CATS[ParentID][$i] == $parent) {
	  		if ($level==0) $font_color="red";
	  		for ($j=0; $j<$level; $j++) {
	  			$indent.="&nbsp;›";
	   		} //end for
	   		if ($pageID==$CATS[PageID][$i]) print "<option style='color:$font_color' value=".$CATS[PageID][$i]." selected>".$indent.$CATS[PageTitle][$i]."</option>";
	   		else print "<option style='color:$font_color' value=".$CATS[PageID][$i].">".$indent.$CATS[PageTitle][$i]."</option>";
	   		ListTopPagesTree($level+1, $CATS[PageID][$i],$pageID);
	   	} //end if
	   	  
 	} //end for
} //end function
function ListPagesTree($level, $parent) {
	global $parentID;
	$cID=$parentID;
	$CATS=GetContentMenu();
	$categoryCount=count($CATS[PageID]);
	 for ($i=0; $i<$categoryCount; $i++) {
	 	$indent="";
	  	if ($CATS[ParentID][$i] == $parent) {
	  		for ($j=0; $j<$level; $j++) {
	  			$indent.="&nbsp;›";
	   		} //end for
	   		if ($cID==$CATS[PageID][$i]) print "<option value=".$CATS[PageID][$i]." selected>".$indent.$CATS[PageTitle][$i]."</option>";
	   		else print "<option value=".$CATS[PageID][$i].">".$indent.$CATS[PageTitle][$i]."</option>";
	   		ListPagesTree($level+1, $CATS[PageID][$i]);
	   	} //end if
	   	  
 	} //end for
} //end function

ListTopPagesTree(0,0,$pageID);
?>
</select>
<?
$CPAGE[LastUpdate]=date('Y-m-d H:i');
if ($pageID) {
	$CPAGE=GetContent($pageID);
	$pageContent=$CPAGE[PageContent];
	$pageOrder=$CPAGE[PageOrder];
	$pageTitle=$CPAGE[PageTitle];
	$parentID=$CPAGE[ParentID];
	if ($CPAGE[ViewStatus]==1) $stateShow="checked";
	else $stateShow="";
	if ($CPAGE[HomePage]==1) $HomePageStat="checked";
	else $HomePageStat="";
	
	?>
	&nbsp;<a href="saveContent.php?action=delpage&pageID=<?=$pageID;?>" target="ifrm"><img src="images/del.gif" border="0" align="מחק עמוד זה"></a>
	<?
}
?>

</form>
</div>
<form name=content action="saveContent.php" method="POST" target="ifrm">
<table border="0" class="general">
<tr>

<td class="general"><?=$CONTENT_TREE_LABEL[0];?> : 
<select name="P[parentPage]" class="HEtextbox"  style="width:200px">
<option value=0  style="color:GREEN;"><-<?=$CONTENT_TREE_LABEL[1];?>-></option>
<?


ListPagesTree(0,0);
?>
</select>

</td>

<td class="general"><?=$CONTENT_LABEL[1];?> :
<input type="text" class="HEtextbox" name="P[contentTitle]" value="<?=$pageTitle;?>">
&nbsp;
<?=$CONTENT_LABEL[2];?>
<input type="checkbox" name="P[Show]" value="1" <?=$stateShow;?> class="HETextbox">
</td>

<td><?=$CONTENT_LABEL[3];?> :
<select name="P[contentOrder]" class="HEtextbox">
<?
for ($a=1;$a<=15;$a++) {
	if ($a==$pageOrder) print "<option  selected value=".$a.">".$a."</option>";
	else print "<option value=".$a.">".$a."</option>";
}
?>
</select>
&nbsp;

</td>
</tr>
<tr>
<td class="titleText" colspan="1"><b>
<?=$CONTENT_LABEL[4];?><small>(למשל:mypage.php)</small>
<input type="text" name="P[pageURL]" value="<?=$CPAGE[PageUrl];?>" class="HETextbox">
</td>
<td class="titleText" colspan="1" ><b>

<input type="checkbox"  value=1 name="P[homePage]" <?=$HomePageStat;?> class="HETextbox">
&nbsp;<?=$MAIN[content][4];?>&nbsp;
<input type="submit" value="<?=$MAIN[general][4];?>" class="button">
</td>
</tr>
</table>
<br>
<div class="GeneralBG" align="center"><?=$CONTENT_LABEL[5];?> :&nbsp;&nbsp;<span class="smalltext"><?=$PAGES_CONTENT_LABEL[4];?> :<?=formatDate($CPAGE[LastUpdate],"HE");?></span></div>
<?
$oFCKeditor = new FCKeditor('P[pageContent]') ;
$oFCKeditor->Config['CustomConfigurationsPath'] = "/editor/InPlaceConfig.js";
//$oFCKeditor->Config['SkinPath'] = $SITE[url]."/editor/editor/skins/silver/";
$oFCKeditor->BasePath= "/editor/";
$oFCKeditor->Height="500";
$oFCKeditor->Width="100%";
$oFCKeditor->Value= $pageContent;
$oFCKeditor->Create();
?>
</div>
<input type="hidden" name="pageID" value="<?=$pageID;?>">
</form>
<iframe name="ifrm" id="ifrm" style="display:none"></iframe>