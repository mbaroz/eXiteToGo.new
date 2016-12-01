<?
if (!$SITE[mobilemenutextcolor]) $SITE[mobilemenutextcolor]="ffffff";
if (!$SITE[mobilemenubgcolor]) $SITE[mobilemenubgcolor]="bcbcbc";
if (!$SITE[mobilemenuopacity]) $SITE[mobilemenuopacity]=100;
if (!$SITE[mobilefooteropacity]) $SITE[mobilefooteropacity]=90;
if (!$SITE[mobilefooterbgcolor]) $SITE[mobilefooterbgcolor]="000000";
if (!$SITE[mobilefootericonscolor]) $SITE[mobilefootericonscolor]="ffffff";
if (!$SITE[mobilemenu_line_color]) $SITE[mobilemenu_line_color]="cac7c7";


function hex2rgb_mobile($hex,$returnARRAY=false) {
   $hex = str_replace("#", "", $hex);
 
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   if ($returnARRAY) return $rgb; // returns an array with the rgb values
   else return $r.",".$g.",".$b;
}
$MenuBG_RGB=hex2rgb_mobile($SITE[mobilemenubgcolor],true);
?>
<link rel="stylesheet" type="text/css" href="/css/component.css" />
<script src="/js/modernizr.custom.js"></script>
<script>
    var isNextLevel=0;
    function nextLevelClicked() {
	jQuery(window).scrollTop(0);
	isNextLevel=1;
	
    }
</script>
<style>
    @media only screen and (max-device-width: 680px) ,(max-width:680px) {
	.topHeaderLogo  {margin-<?=$SITE[align];?>:48px;}
    }
    .dl-menuwrapper.style_two ul.dl-submenu li.dl-back {
    	display: none;
    }
	.dl-menuwrapper.style_two .dl-menu.dl-subview li, .dl-menu.dl-subview li.dl-subviewopen > a, .dl-menu.dl-subview li.dl-subview > a {display: block}
	.dl-menuwrapper.style_two .dl-menu.dl-subview li.dl-subviewopen > .dl-submenu {padding-<?=$SITE[align];?>:15px;}
    .dl-menuwrapper {
	position: absolute;
	margin:12px 10px 0px;
	z-index: 10000;
	display: none;
	<?=$SITE[align];?>:0;
    }
    .dl-menuwrapper li  a.hasChild {
	color:#<?=$SITE[mobilemenutextcolor];?>;
	text-decoration:none;
	outline: none;
	width:210px;
    }
    .dl-menuwrapper li a {font-size:<?=$SITE[mobilemenutextsize];?>px}
    .dl-menuwrapper li  {
	<?
	if ($SITE[mobilemenu_line_color]) {
	    ?>
	    border-bottom:1px solid #<?=$SITE[mobilemenu_line_color];?>;
	    <?
	}
	else {
	   ?>
	   margin-bottom:1px;
	   <?
	}
	?>
	
    }
     .dl-menuwrapper ul {
	background: rgba(<?=hex2rgb_mobile($SITE[mobilemenubgcolor]);?>,<?=($SITE[mobilemenuopacity]/100);?>);
	
     }
    .no-touch .dl-menuwrapper li a:hover, .dl-menuwrapper li a:hover  {
	background: rgba(<?=hex2rgb_mobile($SITE[mobilemenubgcolor]);?>,<?=($SITE[mobilemenuopacity]/100)+0.2;?>);
      }
    .mobileMenuArrow {
	background: #<?=$SITE[mobilemenubgcolor];?>;
	background: rgb(<?=$MenuBG_RGB[0]-10;?>,<?=$MenuBG_RGB[1]-10;?>,<?=$MenuBG_RGB[2]-10;?>);
	width:30px;
	height:32px;
	position: absolute;
	<?=$SITE[opalign];?>:0;
	text-align: center;
	top:0;
	line-height: 28px;
	font-size:20pt;font-family:arial;
	padding:9px;
	cursor:pointer;
	color:#<?=$SITE[mobilemenutextcolor];?>;
    }
    .dl-menuwrapper button {
	position: absolute;
	<?=$SITE[align];?>:0px;
	background: #<?=$SITE[mobilemenubgcolor];?>;
	<?
	if ($SITE[roundcorners]) {?>border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;<?}
	
	?>
    }
    .dl-menuwrapper button:after {
	background:#<?=$SITE[mobilemenutextcolor];?>;
	box-shadow: 0 10px 0 #<?=$SITE[mobilemenutextcolor];?>, 0 20px 0 #<?=$SITE[mobilemenutextcolor];?>;
    }
    .dl-menuwrapper .dl-menu {
	margin-top:42px;
	text-align: <?=$SITE[align];?>;
	
    }
    .dl-menuwrapper li {
	text-align: <?=$SITE[align];?>;
    }
    .dl-menuwrapper:first-child {margin-right:10px;}
    button.dl-trigger.dl-active:after {
	display: none;
	
    }
    button.dl-trigger.dl-active {
	text-indent:inherit;
	color:#<?=$SITE[mobilemenutextcolor];?>;
	text-align: center;
	
    }
    .dl-menuwrapper button.dl-active, .dl-menuwrapper li a {
	background: rgba(<?=hex2rgb_mobile($SITE[mobilemenubgcolor]);?>,<?=($SITE[mobilemenuopacity]/100);?>);
	color:#<?=$SITE[mobilemenutextcolor];?>;
    }
    .dl-menuwrapper button:hover{background: rgba(<?=hex2rgb_mobile($SITE[mobilemenubgcolor]);?>,0.9)}
    button.dl-trigger.dl-active .close {
	color:#<?=$SITE[mobilemenutextcolor];?>;
	font-family: arial;
	font-size:45px;
	font-weight:lighter;
	transform:rotate(45deg);
	-ms-transform:rotate(45deg);
	-webkit-transform:rotate(45deg);
	background: transparent;
	line-height: 43px;
	padding:0px;
	-webkit-font-smoothing: antialiased;
    }
    .fixed_footer {
	background:#<?=$SITE[mobilefooterbgcolor];?>;
	background: rgba(<?=hex2rgb_mobile($SITE[mobilefooterbgcolor]);?>,<?=($SITE[mobilefooteropacity]/100);?>);
	color:#<?=$SITE[mobilefootericonscolor];?>;
    }
    .fixed_footer .inner div.icon a,  .fixed_footer .inner div.icon, .fixed_footer .inner div.icon_close {color:#<?=$SITE[mobilefootericonscolor];?>;}
    .fixed_footer .inner div.icon, .fixed_footer .inner div.icon_close  {border-right:1px inset #<?=$SITE[mobilefootericonscolor];?>}
    .fixed_footer .inner div:first-child {border-right:0px;}
    .fixed_footer.open {background: rgba(<?=hex2rgb_mobile($SITE[mobilefooterbgcolor]);?>,1);?>);}
</style>
<?
$MENU_BACK_LABEL="Back";
if ($SITE_LANG[selected]=="he") $MENU_BACK_LABEL="חזרה";
function GetAllMobileMenu($rootUrlKey) {
   	$db=new Database();
   	$db2=new Database();
   	$db3=new Database();
	$sql="select * from categories WHERE MenuTitle!='' AND ParentID<1000 AND MenuTitle NOT LIKE '%footer%' AND MenuTitle NOT LIKE '%result%' AND (MobileView!=-1 OR ViewStatus=1) AND (MobileView=0 AND ViewStatus=1) OR MobileView=1 ORDER BY PageOrder";
	
	if ($rootUrlKey) {
	    $db->query("SELECT CatID from categories WHERE UrlKey='$rootUrlKey' LIMIT 1");
	    $db->nextRecord();
	    $rootCatID=$db->getField("CatID");
	    $sql="select * from categories WHERE MenuTitle!='' AND ParentID='$rootCatID'  AND ParentID<1000 AND MenuTitle NOT LIKE '%footer%' AND MenuTitle NOT LIKE '%result%' AND (MobileView!=-1 OR ViewStatus=1) AND (MobileView=0 AND ViewStatus=1) OR MobileView=1 ORDER BY PageOrder";
	}
	$db->query($sql);
	$numFields=$db->numFields();
	$i=0;
	while ($db->nextRecord()) {
		for ($fNum=0;$fNum<$numFields;$fNum++) {
			$fName=$db->getFieldName($fNum);
				$MENU[$fName][$i]=$db->getField($fNum);
		}
	    $curMenuID=$MENU[CatID][$i];
	    $db2->query("SELECT CatID from categories WHERE ParentID='$curMenuID' AND (MobileView=1 OR (ViewStatus=1 AND MobileView!=-1))");
	    if ($db2->nextRecord()) {
		$db3->query("SELECT CatID from news WHERE CatID='$curMenuID'");
		if (!$db3->nextRecord()) $MENU[hasChilds][$i]=1;
		    else $MENU[hasChilds][$i]=0;
	    }
	
	    $i++;
	}
    return $MENU;
}
function SetMobileMenu($parent,$level=0) {
    global $TOPMOBILEMENU;
    $className="dl-menu";
    if ($level>0) $className="dl-submenu";
    ?>
      <ul class="<?=$className;?>">
    <?
    for ($a=0;$a<count($TOPMOBILEMENU[CatID]);$a++){
        $ExternalUrl="";
	$target="_self";
     
        if (!$TOPMOBILEMENU[PageUrl][$a]) {
            $TOPMOBILEMENU[PageUrl][$a]=$SITE[url]."/category/".$TOPMOBILEMENU[UrlKey][$a];
            if ($TOPMOBILEMENU[UrlKey][$a]=="home") $TOPMOBILEMENU[PageUrl][$a]=$SITE[mobile_url]."/";
        }
	else {
            $TOPMOBILEMENU[PageUrl][$a]=urldecode($TOPMOBILEMENU[PageUrl][$a]);
            $ExternalUrl=$TOPMOBILEMENU[PageUrl][$a];
            }
	if (!stripos($ExternalUrl,"/")==0 AND $ExternalUrl!="") $target="_blank";
        $TOPCONTENTMENU_LINK=$TOPMOBILEMENU[PageUrl][$a];
        if ($TOPMOBILEMENU[ParentID][$a] == $parent) {
    	?>
	    <li>
		<a href="<?=$TOPCONTENTMENU_LINK;?>" class="<?=$linkClass;?>">
			<?=$TOPMOBILEMENU[MenuTitle][$a];?>
		</a>
		<?
		$linkClass="";
		if ($TOPMOBILEMENU[hasChilds][$a]==1) {
		    $linkClass="hasChild";
		    ?>
		  <div class="mobileMenuArrow" onclick="nextLevelClicked()">›</div>
		    <?SetMobileMenu($TOPMOBILEMENU[CatID][$a],$level+1);?>
		    <?
		}
		?>
		    
	    </li>
	   
	    <?
	}
    }
    ?>
     </ul>
    <?
}

?>
<?
if (!$P_DETAILS[HideTopMenu]) {
    ?>
    <span class="MobileMenuWrapper">
	<div id="dl-menu" class="dl-menuwrapper style_two">
		<button class="dl-trigger">Open Menu</button>
		<?
		$TOPMOBILEMENU=GetAllMobileMenu(0);
		//$TOPMOBILEMENU=GetAllMobileMenu($SITE[MobileHomePage]);
		SetMobileMenu(0,0);
		?>
	</div>
    </span>
    <script src="/js/jquery.dlmenu.js"></script>
    <script>
	jQuery(function() {
	    jQuery( '#dl-menu' ).dlmenu({
		animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5'}
	       
	    });
	jQuery("#dl-menu .dl-back a").html("<?=$MENU_BACK_LABEL;?>");
    });
    </script>
    <script>
	var menuOpen=0;
	jQuery(".dl-menuwrapper button").click(function() {
	    jQuery(".dl-menuwrapper button:after").hide();
	    jQuery(".dl-menuwrapper button").html("<div class='close'>+</div>");
	    menuOpen=1;
	    if (jQuery(".dl-trigger.dl-active").length>0) jQuery(".masterHeader_wrapper").removeClass("setAbsolute");
	    else {
		jQuery(".masterHeader_wrapper").addClass("setAbsolute");
		jQuery("body").scrollTop(0);
	    }
	})
    
	
    </script>
    <?
}
else {
    ?>
    <style>
	html.touch .topHeaderLogo a {height:1px !important}
    </style>
    <?
}
