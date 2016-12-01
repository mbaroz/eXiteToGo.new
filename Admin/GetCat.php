<?header("Content-Type:text/html; charset=utf-8");?>
<?include_once("../config.inc.php");?>
<?include_once("../".$SITE_LANG[dir]."database.php");?>
<?include_once("../inc/GetServerData.inc.php");?>
<?

$type=$_GET['type'];
$requestCategoryID=$_GET['catID'];
$CAT=GetCategoryByID($requestCategoryID);
switch($type) {
    case 'checkMobileView' :
    if ($SITE[mobileEnabled]) {
        if ($CAT[ViewStatus]==0 AND $CAT[MobileView]==0) $selected[-1]="selected";
            else $selected[$CAT[MobileView]]="selected";
        ?>
        <select name="mobileView" id="mobileView" style="width:140px;">
            <option value="1" <?=$selected[1];?>><?=$ADMIN_TRANS['show in mobile devices'];?></option>
            <option value="-1" <?=$selected[-1];?>><?=$ADMIN_TRANS['hide from mobile devices'];?></option>
            
       </select>&nbsp;<i style="color:#333333;font-size:20px;vertical-align: middle;" class="fa fa-mobile fa-2x"></i>
        <?
    }
        if ($CAT[ParentID]==0) {
            $isRichTextOnPopUp=GetCatStyle("enableRichTextPopUp",$requestCategoryID);
            $isChecked="";$toggleClassName="on";
            if ($isRichTextOnPopUp) {
                $isChecked="checked";
                $toggleClassName="off";
            }
            ?>
            <div>
            <input type="checkbox" name="showRichTextCheck" id="showRichTextCheck" value=1 <?=$isChecked;?> onclick="if(this.checked) this.value=1;else this.value=0;setCatStyleProperty(<?=$requestCategoryID;?>,jQuery('input#showRichTextCheck').val(),'enableRichTextPopUp')" />
            <?=$ADMIN_TRANS['enable rich text on mouse hover'];?>
            </div>
            <?
        }
    break;
    default :
        if ($CAT[isSecured]==1) print 1;
        else print 0;
        break;
}