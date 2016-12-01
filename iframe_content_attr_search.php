<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
$catID=$_GET['cID'];
$isiPad = strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
$isiPhone =strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
$isiFF =strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'firefox');
$ADMIN_TRANS['search content']="Search";
$ADMIN_TRANS['free text search']="Free text";
if ($SITE_LANG[selected]=="he") {
    $ADMIN_TRANS['search content']="חפש";
    $ADMIN_TRANS['free text search']="טקסט חופשי";
}
if ($_GET['button_search_text']) $ADMIN_TRANS['search content']=$_GET['button_search_text'];
if ($_GET['rand_results']==1) $_SESSION['rand_results']=1;
else $_SESSION['rand_results']=0;
function GetAvaliableAttrs() {
    $db=new database();
    $sql='SELECT `content_attributes`.`AttributeID`,
            `content_attributes`.`AttributeName`,
            `content_attributes_values`.`ValueID`,
            `content_attributes_values`.`ValueName`
        FROM
            `content_attributes`
        LEFT JOIN
            `content_attributes_values` USING(`AttributeID`)
        LEFT JOIN
        `pages_attributes` USING(`AttributeID`,`ValueID`)
        WHERE pages_attributes.ValueID=content_attributes_values.ValueID
        ORDER BY
        `content_attributes`.`AttributeID`,
        `content_attributes_values`.`ValueID`
    ';
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
$all_attributes=array();
$all_attributes=GetAvaliableAttrs();
if (count($all_attributes)<1) die();
?>
<html>
    <head>
    <base target="_top" />
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="<?=$SITE[url];?>/js/jquery-1.9.1.min.js"></script>
    <script src="<?=$SITE[url];?>/js/jquery-migrate-1.2.1.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.9.2.custom.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=$SITE['url'];?>/css/styles.css.php?urlKey=home" />
    <link rel="stylesheet" type="text/css" href="<?=$SITE[cdn_url];?>/css/he_fonts.css">
    <style>
        body {padding:0;margin: 0}
        .selections {
            direction: <?=$SITE_LANG[direction];?>;
            width:100%;
            background-color: <?=($_GET['backcolor']) ? '#'.$_GET['backcolor'] : 'transparent';?>;
            padding:6px;
            font-family: inherit;
            box-sizing:border-box;
            
            }
        .selections div.attr_block {
            margin:5px;
            float:<?=$SITE[align];?>;
            background-color: <?=($_GET['bgcolor']) ? '#'.$_GET['bgcolor'] : '#dedede';?>;
            border:0px;
            border-radius:3px;
            max-width:300px;
            
        }
        .selections div.attr_block select,.selections div.attr_block input[type="text"] {
            background-color: transparent;
            padding:6px;
            border: 0;
            outline:none;
            min-width:120px;
            height: <?=($_GET['height']) ? $_GET['height'].'px' : '25px';?>;
            color: <?=($_GET['textcolor']) ? '#'.$_GET['textcolor'] : 'inherit';?>;
            width: <?=($_GET['width']) ? ($_GET['width']).'px' : 'inherit';?>;
            
        }
        .selections div.attr_block.button {
            padding:2px 10px;
            font-family:inherit;
            cursor: pointer;
            text-align: center;
            font-weight: bold;
            color:<?=($_GET['buttontextcolor']) ? '#'.$_GET['buttontextcolor'] : 'inherit';?>;
            background-color:<?=($_GET['buttonbgcolor']) ? '#'.$_GET['buttonbgcolor'] : '';?>;
            height: <?=($_GET['height']) ? ($_GET['height']-4).'px' : '22px';?>;
            line-height: <?=($_GET['height']) ? ($_GET['height']-4).'px' : '22px';?>;
        }
        #content_attr_results {
            min-height:100px;
            
        }
        .selections.narrow div.attr_block {
            float:none;
            max-width: 100%;
        }
        .selections.narrow div.attr_block select {width: 100%}
        .selections.narrow div.attr_block.button{padding: 8px;}
    </style>
    </head>
    <body>
        <div class="selections">
                <?
                foreach($all_attributes as $id => $data) {
                    ?>
                        <div class="attr_block">
                        <select name="attr">
                            <option value="0"><?=$data['name'];?></option>
                            <?
                             foreach($data['values'] as $vid => $value) {
                                    ?>
                                    <option value="<?=$id.":".$vid;?>"><?=$value;?></option>
                                    <?
                             }
                             ?>
                        </select>
                        </div>
                    <?
                }
                if ($_GET['show_free_text']==1) {
                    ?>
                     <div class="attr_block">
                        <input type="text" id="search_content_q" name="search_content_q" placeholder="<?=$ADMIN_TRANS['free text search'];?>">
                     </div>
                    <?
                }
                ?>

            <div class="attr_block button" id="send_search">
                <div class="button_inner"><?=$ADMIN_TRANS['search content'];?></div>
            </div>
        
        <div style="clear: both"></div>
        </div>
        <script>

        	var resultsContainerBackup="";
            function getAttributeResults() {
            	var w_hash=window.parent.location.hash;
            	var q="";
            	if (!w_hash==""){
	            	    	var Q_H=w_hash.split("content_q=");
	            	    	q=Q_H[1];
            	}
            	 
                var resultsContainer="";
                if ($(".contentOuter",parent.document).length>0) resultsContainer=$(".contentOuter", parent.document);
                if ($(".mainContentSeperated", parent.document).length>0) var resultsContainer=$(".mainContentSeperated",parent.document);
                if ($(".widePage", parent.document).length>0) var resultsContainer=$(".widePage",parent.document);
                if (resultsContainerBackup=="") resultsContainerBackup=resultsContainer.html();
                
                if (q!="") {
                    resultsContainer.html('<div style="padding-top:50px;text-align:center"><img src="/Admin/images/ajax-loader.gif" align="absmiddle" /></div>');
                    resultsContainer.load('/GetContentAttrResults.php?q='+q);
                }
                      else resultsContainer.html(resultsContainerBackup);
                
                //$("#content_attr_results").html("ddd");
            }
            function eXite_unbindMe() {
                $(window,document.parent).unbind("hashchange");
            }
            var is_hash_change_binded=0;
             
            function search_content_attr() {
                var hash_q="";
                $(".attr_block select").each(function() {
                    if ($(this).val()!=0) hash_q+=$(this).val()+"-";
                });
                hash_q=hash_q.substr(0,hash_q.length-1);
                if ($(".attr_block input#search_content_q").val()!="" && $(".attr_block input#search_content_q").length>0) hash_q+="-free_q:"+encodeURIComponent($(".attr_block input#search_content_q").val());
                window.parent.location.hash="content_q="+hash_q;
                $(window.parent).trigger("hashchange");

             }
            
            $(function() {
            	eXite_unbindMe();
            	                
                $("#send_search").click(function() {
                   if (is_hash_change_binded==0) 
                    {
                        $(window.parent).bind("hashchange",function() {
                        getAttributeResults();                
	                   });
                    is_hash_change_binded=1;
                    }
                    search_content_attr();
                });
                
                
            });
            if ($(document).width()<350) {$(".selections").addClass("narrow")}

            function setIframeHeight() {
                var h=$(".selections").height()+10;

                $("#search_content_attr_iframe",parent.document.body).height(h+"px");
            }
            $(document).ready(function() {
                setIframeHeight();
            });
        </script>
    </body>
</html>