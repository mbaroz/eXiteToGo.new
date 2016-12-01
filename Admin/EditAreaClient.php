<?
$parentID=$CONTENT[PageID][$a];

if ($CONTENT[ViewStatus][$a]==1) $stateShow="checked";
else $stateShow="";
if ($CONTENT[HomePage]==1) $HomePageStat="checked";
else $HomePageStat="";
$pageOrder=$CONTENT[PageOrder][$a];
$pageOrder_STR='<select id="pageOrder" name="pageOrder" class="selectBox">';
for ($c=1;$c<=25;$c++) {
	if ($c==$pageOrder) $pageOrder_STR.="<option  selected value=".$c.">".$c."</option>";
	else $pageOrder_STR.= "<option value=".$c.">".$c."</option>";
}
$pageOrder_STR.='</select>';
?>
<script language="javascript" type="text/javascript">
pageUrlKey[<?=$parentID;?>]="<?=$CONTENT[UrlKey][$a];?>";
pageTextUrlKey[<?=$parentID;?>]="<?=$CONTENT[UrlKey][$a];?>";
pageIsTitleLink[<?=$parentID;?>]="<?=$CONTENT[IsTitleLink][$a];?>";
</script>

<Table class="AdminArea" id="AdminArea" cellpadding="0" width="100%" cellpadding="0">
<tr>
<td class="AdminAreaItem" onclick="EditHere(<?=$parentID;?>,'',1)"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" align="absmiddle" border="0"> <?=$ADMIN_TRANS['edit'];?></td>

<td style="display:none"><span class="AdminAreaItem" onclick="EditHere(<?=$pID;?>,'',0)"><img src="<?=$SITE[url];?>/images/editIcon.gif" align="absmiddle" border="0"></td>
<td style="display:none" class="AdminAreaItem" onclick="ShowPageCats(<?=$parentID;?>)"><img src="<?=$SITE[url];?>/images/ParentSelectIcon.gif" align="absmiddle" border="0" title="">
</td>
<td class="AdminAreaItem" id="movable_content" style="cursor:move"><img src="<?=$SITE[url];?>/Admin/images/moveicon.gif" align="absmiddle" border="0" title="<?=$ADMIN_TRANS['change order'];?> ↓↑"><?=$ADMIN_TRANS['change order'];?></td>

<td class="AdminAreaItem" onclick="deleteContent(<?=$parentID;?>)"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" align="absmiddle" border="0" title="<?=$ADMIN_TRANS['delete content'];?>">&nbsp;<?=$ADMIN_TRANS['delete content'];?></td>
</tr>
</Table>