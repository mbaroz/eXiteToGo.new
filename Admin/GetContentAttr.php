<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
$pageID=$_GET['pageID'];
$action=$_GET['action'];
$ADMIN_TRANS['enter new tag']="Add New Criteria";
$ADMIN_TRANS['existing tags']="Avaliable criteria's";
if ($SITE_LANG[selected]=="he") {
    $ADMIN_TRANS['enter new tag']="רשמו קריטריון חדש להוספה (למשל: אזור מגורים)";
    $ADMIN_TRANS['existing tags']="קריטריונים קיימים במערכת";
}
function getAttrs ($pID,$q="") {
            
            $db=new database();
            $sql="SELECT
                            `content_attributes`.`AttributeID`,
                            `content_attributes`.`AttributeName`,
                            `content_attributes_values`.`ValueID`,
                            `content_attributes_values`.`ValueName`
                    FROM
                            `content_attributes`
                    LEFT JOIN
                            `content_attributes_values` USING(`AttributeID`)
                    ORDER BY
                            `content_attributes`.`AttributeID`,
                            `content_attributes_values`.`ValueID`
            ";
            $db->query($sql);
            $i=0;
            while ($db->nextRecord()) {
                    $numFields=$db->numFields();
                    for ($fNum=0;$fNum<$numFields;$fNum++) {
                        $fName=$db->getFieldName($fNum);
                        $ATTRS[$fName][$i]=$db->getField($fNum);
                    }
                if(!isset($attributes[$db->getField('AttributeID')]))
                            $attributes[$db->getField('AttributeID')] = array('name' => $db->getField('AttributeName'),'values' => array());
                if($db->getField('ValueID') > 0)
                    $attributes[$db->getField('AttributeID')]['values'][$db->getField('ValueID')] = $db->getField('ValueName');
                    $i++;
            }
            return $attributes;
}


function AddNewAttr($attrName,$values) {
    
}
switch ($action) {
    case 'getAttrs':
        $db=new Database();

        $attributes=getAttrs($pageID);
        if (!is_array($attributes)) {
            ?>
            <div class="addattr_tip" style="margin-top:50px;text-align:center;font-size:26px;color:silver">+ Add New Tag</div>
            <?

            die();
        }
        foreach($attributes as $id => $data) {
            ?>
            <div class="attrName" id="attrName_<?=$id;?>"><span id="attributeName"><?=$data['name'];?></span>
                <span id="tip"><span onclick="changeName(<?=$id;?>,'attr');"><?=$ADMIN_TRANS['click to rename'];?> </span><span class="delAttr" onclick="delAttr(<?=$id;?>);"><?=$ADMIN_TRANS['delete'];?></span></span>

            </div>
            <div class="delConfimation" id="delAttrConfirm_<?=$id;?>"><span><?=$ADMIN_TRANS['are you sure ?'];?> <?=$ADMIN_TRANS['deleting this category tag will remove it from all other linked items'];?></span> / <span class="confirmDel"><?=$ADMIN_TRANS['yes'];?>! <?=$ADMIN_TRANS['delete'];?></span></div>
            <? foreach($data['values'] as $vid => $value) {
                        $is_checked="";
                        $db->query("SELECT PageID from pages_attributes WHERE PageID='{$pageID}' AND AttributeID='{$id}' AND ValueID='{$vid}'");
                        if ($db->nextRecord()) $is_checked="checked";
                        ?>
                <div class="attrVAL" id="attrVAL_<?=$vid;?>"><input class="attrsChecks" type="checkbox" value="1" name="<?=$id;?>:<?=$vid;?>" <?=$is_checked;?>><span id="attributeName"><?=$value;?></span><span id="tip"><span  onclick="changeName(<?=$vid;?>,'val');">לחץ לשינוי שם  </span><span class="delVal" onclick="delVal(<?=$vid;?>);">מחק</span></span></div>
                <div class="delConfimation" id="delConfirm_<?=$vid;?>"><span><?=$ADMIN_TRANS['are you sure ?'];?> <?=$ADMIN_TRANS['deleting this tag will remove it from all other linked items'];?></span> / <span class="confirmDel"><?=$ADMIN_TRANS['yes'];?>! <?=$ADMIN_TRANS['delete'];?></span></div>
            <?
                }
                ?>
                                        <div class="addNewValBox new_attr_box" id="newValBox_<?=$id;?>" onclick="addNewVal(<?=$id;?>,1)"><span class="attrVAL"><span id="tip" class="newVal">
                                        <strong> + </strong><?=$ADMIN_TRANS['add'];?> <?=$data['name'];?> <?=$ADMIN_TRANS['new'];?>
</span></span><input type="text" placeholder="<?=$ADMIN_TRANS['enter new tag'];?>" />
                        <span class="add_attr button add_button" id="newSaveIcon" onclick="saveNewVal(<?=$id;?>)"><?=$ADMIN_TRANS['save'];?></span>
                    </div>
            <div class="attrs_group"></div>
                <?
        }
        die();
        break;
    case 'saveNewVal':
        $newValue=strip_tags($_GET['val']);
        $attr_ID=strip_tags($_GET['attrID']);
        $newValue=trim($newValue);
        if (!$newValue=="") {
            $db=new database();
            $db->query("INSERT INTO content_attributes_values SET AttributeID='{$attr_ID}', ValueName='{$newValue}'");
        }
        die();
        break;
    case 'saveNewAttr':
        $newAttr=strip_tags($_GET['attr']);
        $newAttr=trim($newAttr);
        if (!$newAttr=="") {
            $db=new database();
            $db->query("INSERT INTO content_attributes SET AttributeName='{$newAttr}'");
        }
        ?>
        <script>
            jQuery("#attrs_inner").load("<?=$SITE[url];?>/Admin/GetContentAttr.php?action=getAttrs&pageID=<?=$pageID;?>")
        </script>
        <?
        die();
        break;
    case 'delVal':
        $valID=strip_tags($_GET['valID']);
        if ($valID>0) {
            $db=new database();
            $db->query("DELETE FROM content_attributes_values WHERE ValueID='{$valID}'");
        }
        die();
        break;
    case 'delAttr':
        $attrID=strip_tags($_GET['attrID']);
        if ($attrID>0) {
            $db=new database();
            $db->query("DELETE FROM content_attributes_values WHERE AttributeID='{$attrID}'");
            $db->query("DELETE FROM content_attributes WHERE AttributeID='{$attrID}'");
        }
        die();
        break;
     case 'renameAttr':
        $newValue=strip_tags($_GET['val']);
        $attr_ID=strip_tags($_GET['attrID']);
        $newValue=trim($newValue);
        if (!$newValue=="") {
            $db=new database();
            if ($_GET['renameVal'])  $db->query("UPDATE content_attributes_values SET ValueName='{$newValue}' WHERE ValueID='{$attr_ID}'");
            else $db->query("UPDATE content_attributes SET AttributeName='{$newValue}' WHERE AttributeID='{$attr_ID}'");
        }
        die();
        break;
    case 'saveAllAttrs':
        $selectedAttrs=strip_tags($_GET['selectedAttrs']);
        $pageID=$_GET['pageID'];
        $selectedAttrs=trim($selectedAttrs);
        $db=new database();
        if ($pageID>0)  $db->query("DELETE from pages_attributes WHERE PageID='{$pageID}'");
        if (!$selectedAttrs=="" AND $pageID>0) {
            
            $SELECTED_ATTRS=explode("-",$selectedAttrs);
            foreach($SELECTED_ATTRS as $attr_str) {
                        if ($attr_str=="") break;
                        $insert_str.="(".$pageID.",".str_ireplace(":",",",$attr_str)."),";
            }
        $insert_str=substr($insert_str,0,-1);
       
        $db->query("INSERT into pages_attributes (PageID,AttributeID,ValueID) VALUES {$insert_str}");
        
        }
        
        
        die();
        break;
    default:
        break;
}
?>

<style>
    .CenterBoxWrapper {width: 685px;-webkit-transition: width 0.5s}
    .attr_wrapper {max-width:100%;min-height: 100px;font-family:inherit}
    #newSaveIcon.button.add_attr  {display: inline-block;margin:4px 3px}
    #newSaveIcon.button.add_attr {border:1px solid silver;border-radius:4px;min-width:0;text-align: center;line-height: 18px;font-size: 15px;font-weight:normal}
    .new_attr_box {width:85%;background: #ffffff;-webkit-box-shadow:0px 0px 1px #333333;padding:8px;display: inline-block;margin-bottom:20px}
    .new_attr_box input {border:0px;height:20px;font-size:15px;background: transparent;outline: none;width:96%}
    .new_attr_box.addNewValBox {width:280px;-webkit-transition: all 0.3s;display:block;height:25px;margin:10px;padding:0px;opacity: 1;box-shadow:none;}
    .new_attr_box.addNewValBox input, .new_attr_box.addNewValBox.show .attrVAL {display: none;}
    .new_attr_box.addNewValBox.show input, .new_attr_box.addNewValBox .attrVAL{display: inline-block;}
    .new_attr_box.addNewValBox.show input {width:200px;}
    .new_attr_box.addNewValBox #newSaveIcon.add_attr.button {margin-top:-15px;display: none}
    .new_attr_box.addNewValBox.show #newSaveIcon.add_attr.button {display: inline-block}
    .current_attrs {min-height:200px;max-height:350px;overflow-y: auto;border:1px solid silver;background: #fcfcfc;padding:3px;}
    #attrs_inner .attrName {font-size:15px;font-weight:bold;}
    #attrs_inner .attrName input {border:0px;width:150px;height:16px;outline: none;border-bottom:1px solid silver;font-weight:bold;font-size: 15px}
    #attrs_inner .attrVAL input {font-weight:normal;border:0px;border-bottom:1px solid silver;outline:none;}
    #attrs_inner .attrVAL {font-size:15px;font-weight:normal;cursor: pointer}
    #attrs_inner .attrVAL #tip, #attrs_inner .attrName #tip{color:gray;margin-<?=$SITE[align];?>:5px;font-style: italic;display: none;cursor: pointer}
    #attrs_inner .attrVAL #tip .delVal, #attrs_inner .attrName #tip .delAttr  {color: red;font-style:normal}
    #attrs_inner .attrVAL:hover>#tip, #attrs_inner .attrName:hover>#tip {display: inline-block;}
    #attrs_inner .attrVAL #tip.newVal{display: inline-block}
    #attrs_inner .attrs_group{border-bottom:1px solid silver;width:100%;height:2px;margin-bottom:10px;}
    .delConfimation {height: 0px;-webkit-transition:all 0.5s;overflow: hidden;color:red}
    .delConfimation .confirmDel {background-color: red;color:white;cursor: pointer;padding:3px;}
    .delConfimation.show{height: 15px; -webkit-transition:all 0.5s}
    .actionLinks{cursor: pointer;font-size:15px;color: green}
    .actionLinks.cancel {color: silver;}
</style>
<div class="attr_wrapper">
    <div class="new_attr_box"><input type="text" id="new_attr_name" placeholder="<?=$ADMIN_TRANS['enter new tag'];?>" /></div>
    <div class="add_attr button add_button" id="newSaveIcon" onclick="addNewAttr()">+ <?=$ADMIN_TRANS['add'];?></div>
    <div style="clear: both"></div>
    
    <strong><?=$ADMIN_TRANS['existing tags'];?></strong>
    <div class="current_attrs">
        <span id="attrs_inner"></span>    
    </div>
    <br>
    <div id="newSaveIcon" class="greenSave" onclick="saveRelatedAttrs()"><?=$ADMIN_TRANS['save changes'];?></div>&nbsp;
    <div id="newSaveIcon" class="cancel" onclick="closeAttrWin()"><?=$ADMIN_TRANS['cancel'];?></div>
    
</div>
<script>
    
     function addNewAttr() {
        var newAttrName=jQuery("#new_attr_name").val();
        newAttrName=encodeURIComponent(newAttrName);
        jQuery("#attrs_inner").load("<?=$SITE[url];?>/Admin/GetContentAttr.php?action=saveNewAttr&attr="+newAttrName);
    }
    function renameAttr(id,type) {
        var renameVal=0;
        var newAttrVal=jQuery("#attrName_"+id+" input").val();
        if (type=="val") {
            renameVal=1;
            newAttrVal=jQuery("#attrVAL_"+id+" input").val();
        }
        
         jQuery.ajax({
            url: "<?=$SITE[url];?>/Admin/GetContentAttr.php?action=renameAttr&val="+newAttrVal+"&attrID="+id+"&renameVal="+renameVal,
            success:function() {jQuery("#attrs_inner").load("<?=$SITE[url];?>/Admin/GetContentAttr.php?action=getAttrs&pageID=<?=$pageID;?>")}
          });
    }
    function addNewVal(boxID,s) {
        jQuery(".new_attr_box").removeClass("show");
        if (s) {
            jQuery("#newValBox_"+boxID).addClass("show");
            jQuery("#newValBox_"+boxID+" input").focus();
        }
        else jQuery("#newValBox_"+boxID+".show").removeClass("show");
    }
    function saveNewVal(attrID) {
        var newAttrVal=jQuery("#newValBox_"+attrID+" input").val();
          jQuery.ajax({
            url: "<?=$SITE[url];?>/Admin/GetContentAttr.php?action=saveNewVal&val="+newAttrVal+"&attrID="+attrID,
            success:function() {jQuery("#attrs_inner").load("<?=$SITE[url];?>/Admin/GetContentAttr.php?action=getAttrs&pageID=<?=$pageID;?>")}
          });
    }
    jQuery("#attrs_inner").load("<?=$SITE[url];?>/Admin/GetContentAttr.php?action=getAttrs&pageID=<?=$pageID;?>");
    
    function delVal(boxID) {
        if (jQuery(".delConfimation.show#delConfirm_"+boxID).length>0) jQuery(".delConfimation.show#delConfirm_"+boxID).removeClass("show");
        else {
            jQuery(".delConfimation#delConfirm_"+boxID).addClass("show");
            jQuery(".delConfimation#delConfirm_"+boxID+" .confirmDel").click(function() {
                 jQuery.ajax({
                url: "<?=$SITE[url];?>/Admin/GetContentAttr.php?action=delVal&valID="+boxID,
                success:function() {jQuery("#attrs_inner").load("<?=$SITE[url];?>/Admin/GetContentAttr.php?action=getAttrs&pageID=<?=$pageID;?>")}
                });
            })
        }
    }
    function delAttr(boxID) {
        if (jQuery(".delConfimation.show#delAttrConfirm_"+boxID).length>0) jQuery(".delConfimation.show#delAttrConfirm_"+boxID).removeClass("show");
        else {
            jQuery(".delConfimation#delAttrConfirm_"+boxID).addClass("show");
            jQuery(".delConfimation#delAttrConfirm_"+boxID+" .confirmDel").click(function() {
                 jQuery.ajax({
                url: "<?=$SITE[url];?>/Admin/GetContentAttr.php?action=delAttr&attrID="+boxID,
                success:function() {jQuery("#attrs_inner").load("<?=$SITE[url];?>/Admin/GetContentAttr.php?action=getAttrs&pageID=<?=$pageID;?>")}
                });
            })
        }
    }
    var nameBCK;
    function cancelRename(eID) {
         jQuery(eID).html(nameBCK);
    }
    
    function changeName(id,t) {
        var elID="#attrName_"+id;
        if (t=="val") elID="#attrVAL_"+id;
        var theName=jQuery(elID+" #attributeName").text();
        nameBCK=jQuery(elID).html();
        var replacement='<input type="text" value="'+theName+'" /><span class="actionLinks" onclick=renameAttr('+id+',"'+t+'")><?=$ADMIN_TRANS['save'];?></span> / <span class="actionLinks cancel" onclick=cancelRename("'+elID+'")><?=$ADMIN_TRANS['cancel'];?></span>';
       
        //var actionsBCK=jQuery("#attrs_inner .attrName #tip").html();
        jQuery(elID).html(replacement);
         jQuery(elID+" input").focus();
    }
    function closeAttrWin() {
            ShowLayer("eXite_OperationBox",0,1,1);
    }
    function saveRelatedAttrs() {
            var selectedAttrs="";
            jQuery(".attrsChecks:checked").each(function() {
               selectedAttrs+=jQuery(this).attr("name")+"-";
            });
             jQuery.ajax({
                url: "<?=$SITE[url];?>/Admin/GetContentAttr.php?action=saveAllAttrs&selectedAttrs="+selectedAttrs+"&pageID=<?=$pageID;?>",
                success:closeAttrWin()
                 });
            
    }
</script>