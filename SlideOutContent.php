<?
$SLIDEOUTICON_DIMENSION=explode("x",$SITE[slideouticonsize]);
$s_o_c_w=$SLIDEOUTICON_DIMENSION[0];
$s_o_c_h=$SLIDEOUTICON_DIMENSION[1];
$slideoutAreaTopMargin="5%";
if ($SITE[slideouticontopmargin]) $slideoutAreaTopMargin=$SITE[slideouticontopmargin]."px";
$slideoutIconTopdecrement=0;
if ($SITE[slideouticontopmargin]<0) {
	$slideoutAreaTopMargin="0px";
	$slideoutIconTopdecrement=$SITE[slideouticontopmargin];
}

if (!$s_o_c_w) $s_o_c_w=10;
if (!$s_o_c_h) $s_o_c_h=0;
$homeARRAYCatID=GetIDFromUrlKey("home");
$homeCatID=$homeARRAYCatID[parentID];
$slideOutParentID=$CHECK_CATPAGE[parentID];
if ($CHECK_PAGE) {
	$PageCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
	if ($CHECK_PAGE[productUrlKey]) $PageCatUrlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
	$CAT_PARENT_ID=GetIDFromUrlKey($PageCatUrlKey);
	$slideOutParentID=$CAT_PARENT_ID[parentID];
}
$slideOutTextColor=$SITE[contenttextcolor];
if ($SITE[slidoutcontentcolor]) $slideOutTextColor=$SITE[slidoutcontentcolor];  
switch ($SITE[slidoutcontentposition]) {
    case 0: //right
        $pos_css="right";
        $op_pos_css="left";
        $top_pos="top:".$slideoutAreaTopMargin;
        break;
    case 1: //left
        $pos_css="left";
        $op_pos_css="right";
        $top_pos="top:".$slideoutAreaTopMargin;
        break;
    case 2: //top
        $pos_css="top";
        $op_pos_css="none";
        $top_pos="top:0";
        break;
    case 3: //bottom
        $pos_css="bottom";
        $op_pos_css="none";
        $top_pos="bottom:0";
        break;
    case 4: //bottom center
        $pos_css="bottom";
        $op_pos_css="none";
        $top_pos="bottom:0";
        $additional_css="width:100%;";
        break;
    default:
        break;
}

if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script type="text/javascript">
	var OrigSlideOutContent;
	var lightSlideOutTextDiv='<div id="slideOutContentEditor"></div>';
	function EditSlideOutContent() {
			var buttons_str;
			var contentDIV=$('slideOutContentMain').innerHTML;
			buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveSlideOutContent();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
			buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancelslideoutcontent();"><?=$ADMIN_TRANS['cancel'];?></div>';
			OrigSlideOutContent=contentDIV;
			var div=$('lightSlideOutContentContainer');
			div.innerHTML=lightSlideOutTextDiv+buttons_str+"&nbsp;";
			editor_ins=CKEDITOR.appendTo("slideOutContentEditor", {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
				});
			editor_ins.setData(contentDIV);
			//ShowLayer("lightSideMainPicContainer",1,1,1);
			slideOutEditor("lightSlideOutContentContainer",1);
			jQuery(function() {
				jQuery("#lightSlideOutContentContainer").draggable();
			});
		
		}
	function saveSlideOutContent() {
			var cVal=editor_ins.getData();
			cVal=encodeURIComponent(cVal);
			var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
			var pars = 'type=slideout_content_text'+'&content='+cVal+'&objectID=<?=$slideOutParentID;?>';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
			
			$('slideOutContentMain').innerHTML=decodeURIComponent(cVal);
			//ShowLayer("lightSideMainPicContainer",0,1,1);
			slideOutEditor("lightSlideOutContentContainer",0);
			editor_ins.destroy();
		}
	function cancelslideoutcontent() {
			$('slideOutContentMain').innerHTML=OrigSlideOutContent;
			slideOutEditor("lightSlideOutContentContainer",0);
			editor_ins.destroy();
			//ShowLayer("lightSlideOutContentContainer",0,1,1);
		}
	</script>
	
	<?

}

?>
<style>
    .exite_slideOutContentIcon {
        width:<?=$s_o_c_w;?>px;height:<?=$s_o_c_h;?>px;
        background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[slidoutcontenticon];?>');
        float:<?=$op_pos_css;?>;
        <?
        if ($SITE[slidoutcontentposition]==4) {
            ?>
            margin:0 auto;
            <?
        } 
        ?>
        
    }
    .slideoutContentText {
        float:<?=$op_pos_css;?>;
        background: #<?=$SITE[slidoutcontentbg];?>;
        min-height:<?=$s_o_c_h;?>px;
        <?
        if ($SITE[slidoutcontentroundcorners]) {
            ?>
            border-radius:6px;-moz-border-radius:6px;
            <?
        }
        if ($SITE[slidoutcontentposition]==4) {
            ?>
            width:100%;

            <?
        } 
        ?>

    }
    .exite_slideOutContent {
        position:fixed;
        z-index:1000;
        <?=$top_pos;?>;
        min-height:<?=$s_o_c_h;?>px;
        max-width:100%;
        <?=$pos_css;?>:-500px;
        transition:all .3s;
        <?=$additional_css;?>;
    }
    .slideoutContentText #slideOutContentMain {
        padding:5px;color:#<?=$slideOutTextColor;?>;direction: <?=$SITE_LANG[direction];?>;
        <?
        if ($SITE[slidoutcontentposition]==4) {
            ?>
            width:980px;margin:0 auto;
            <?
        }
        ?>

    }
</style>
<div class="exite_slideOutContent">
    <?
    if ($SITE[slidoutcontentposition]!=2) {
        ?>
         <div class="exite_slideOutContentIcon"></div>
        <?
    }
    
$SLIDEOUT_CONTENT=GetPageTitle($slideOutParentID,"slideout_content_text");
if ($SLIDEOUT_CONTENT[Content]=="") $SLIDEOUT_CONTENT=GetPageTitle($homeCatID,"slideout_content_text");
?>
   
    <div class="slideoutContentText">
     <?   if (isset($_SESSION['LOGGED_ADMIN'])) {
                    ?>
                    <div id="newSaveIcon"  onclick="EditSlideOutContent();" style=""><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit'];?></div>
                    <?
                    
    }
    ?>
       	<div id="slideOutContentMain" style="padding-top:0px;padding-<?=$SITE[opalign];?>:1px" align="<?=$SITE[align];?>"><?=$SLIDEOUT_CONTENT[Content];?></div>
                
      
    </div>
    <?
     if ($SITE[slidoutcontentposition]==2) {
        ?>
         <div class="exite_slideOutContentIcon"></div>
        <?
    }
    
?>
</div>

<script>
    var isSlideOutOpened="<?=$SITE[slideoutcontentopen];?>";
    function alignSidesSlider() {
        var browserWidth=jQuery(window).width();
        var sidesMargin=Math.round((browserWidth-950)/2);
        jQuery(".exite_slideOutContent").css("<?=$SITE[opalign];?>",sidesMargin+"px");
        
    }
    var slideoutContentHeight=jQuery(".slideoutContentText").height();
    var slideoutContentWidth=jQuery(".slideoutContentText").width();
    var slideoutIconHeight=<?=$s_o_c_h;?>;
    var slideourContentTextMarginTop=(slideoutContentHeight/2)-(slideoutIconHeight/2);
    slideourContentTextMarginTop=(slideourContentTextMarginTop+<?=$slideoutIconTopdecrement;?>);
    var slideTo=slideoutContentWidth;
    <?
    if ($SITE[slidoutcontentposition]==2 OR $SITE[slidoutcontentposition]==3 OR $SITE[slidoutcontentposition]==4) {
        ?>
        slideTo=slideoutContentHeight;
        //alignSidesSlider();
        <?
    }
    else {
        ?>
         jQuery(".exite_slideOutContentIcon").css("margin-top",slideourContentTextMarginTop+"px");
        <?
    }
    ?>
    var slideOUtStat=0;
    if (isSlideOutOpened==1) slideTo=0;
    function toggelSlideOutStat(x) {
	slideOUtStat=x;
    }
    jQuery(".exite_slideOutContent").css("<?=$pos_css;?>","-"+slideTo+"px");
   
    jQuery(".exite_slideOutContent").hover(function() {
		jQuery(".exite_slideOutContent").animate(
                             {
                                "<?=$pos_css;?>":"0px"
                             },80)
        
    },function() {
		jQuery(".exite_slideOutContent").animate({
			"<?=$pos_css;?>":"-"+slideTo+"px"
			},80,function(){toggelSlideOutStat(0);})
	});
	
	 
	//jQuery(".slideoutContentText").on("mouseout",function() {
           
        
       // });
    function showSlideOutContent(isOpen) {
        if (isOpen) {
          jQuery(".exite_slideOutContent").animate(
                             {
                                "<?=$pos_css;?>":"0px"
                             },150,"linear",function() {BindScroll();})
        }
        else {
            jQuery(".exite_slideOutContent").animate({
                "<?=$pos_css;?>":"-"+slideTo+"px"
            },150,function() {BindScroll();})
        }
         
    }
</script>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<div dir="<?=$SITE_LANG[direction];?>" id="lightSlideOutContentContainer" style="display:none;" class="editorWrapper"></div>
	<?
}
?>
<script>
function BindScroll() {
    jQuery(window).scroll(function(){
            var sc_top=jQuery(window).scrollTop();
            if (sc_top>300) {
                 jQuery(this).unbind("scroll");
                showSlideOutContent(1);
            }
            else {
                  jQuery(this).unbind("scroll");
                showSlideOutContent(0);
            }
    });
    
}
//BindScroll();
</script>