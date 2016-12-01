<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
include_once("round_corners.inc.php");
$catID=$_GET['cID'];
$isiPad = strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
$isiPhone =strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
$isiFF =strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'firefox');
$height=$_GET['height'];
$bgcolor=$_GET['bgcolor'];
$border_color=$_GET['border_color'];
$searchCustomHeight=$SITE[searchformheight];
if (!$searchCustomHeight) $searchCustomHeight=35;
if (!$height) $height=19;
$backColor=$_GET['backcolor'];
if (!$backColor) $backColor=$SITE[searchformbgcolor];
$textColor=$_GET['textcolor'];
if (!$textColor) $textColor=$SITE[formtextcolor];
$buttonBGcolor=$_GET['buttonbgcolor'];
if (!$buttonBGcolor AND !$bgcolor=='') $buttonBGcolor=$bgcolor;
if (!$buttonBGcolor) $buttonBGcolor=$SITE[formbgcolor];
$buttonTextColor=$_GET['buttontextcolor'];
if (!$buttonTextColor AND $_GET['textcolor']) $buttonTextColor=$textColor;
if (!$buttonTextColor) $buttonTextColor=$SITE[formtextcolor];
$q=strip_tags($q);
$width_inc=60;
$SEARCH_LABELS=array("Search");
if ($SITE_LANG[selected]=="he" OR $SITE_LANG[direction]=="rtl") $SEARCH_LABELS=array("חפש");
if ($_GET['button_search_text']) $SEARCH_LABELS[0]=strip_tags($_GET['button_search_text']);
else $width_inc=78;

$fieldMargin="0";
$topfieldMargin=1;
$top_bottom_padding=($searchCustomHeight-23)/2;
if ($SITE[searchformbgcolor]=="") {
	$fieldMargin=$SITE[searchformheight];
	//$SITE[searchformheight]=10;
}

if ($SITE[searchformtop]==1 AND !$SITE[searchformbgcolor]=="") $topfieldMargin=4;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<base target="_top" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php?urlKey=<?=$urlKey;?>">
<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/lightbox/css/jquery.lightbox-0.5.css" media="screen" />
<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-1.7.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.8.10.custom.min.js"></script>
<script language="javascript" type="text/javascript">
	jQuery.noConflict();
</script>
<style type="text/css">
body {background:none;background-image:none;background-color:transparent;margin:0;padding:0;direction:<?=$SITE_LANG[direction];?>}
.search_frm_image {
	vertical-align: middle;
	
	cursor: pointer;
}
.search_frm_div {
	width: 100%;
	min-height: <?=$searchCustomHeight;?>px;
	background-color:#<?=$backColor;?>;
	margin-bottom:0px;
	valign:middle;
	padding:5px 0 5px 0;
	text-align:center;
}
.search_frm_div form {
	margin:0px;
	z-index:101;
}

.search_frm {
	width:<?=($SITE[searchformwidth]-$width_inc);?>px;
	padding:3px 3px 2px 3px;
	border:0px solid silver;
	<?
	if ($border_color) {
		?>
		border:1px solid #<?=$border_color;?>;
		<?
	}
	?>
	background-color:#<?=$SITE[formbgcolor];?>;
	font-family:inherit;
	font-size:inherit;
	color:#<?=$textColor;?>;
	height:<?=$height;?>px;
	margin-top:<?=$top_bottom_padding;?>px;
	margin-<?=$SITE[align];?>:6px;
	margin-bottom:<?=$top_bottom_padding;?>px;
	margin-<?=$SITE[opalign];?>:2px;
        outline: none;
	<?
	if ($SITE[searchfieldbg]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[searchfieldbg];?>');
		background-repeat: repeat-x;
		background-color: transparent;
		<?
	}
	if ($bgcolor) {
		?>
		background-color:#<?=$bgcolor;?>;
		<?
	}
	?>
}
<?
if ($_GET['nobg']==1) {
    ?>
    .search_frm {background-image: none}
    <?
}
if (($SITE[roundcorners] AND $_GET['roundcorners']!=-1) OR $_GET['roundcorners']==1) {
      ?>
        .search_frm, .search_frm_div, .search_frm_button {
            border-radius:5px;
            -moz-border-radius:5px;
        
        }
    <?
}
?>

.search_frm_button {
	padding:3px 6px 3px 6px;
	background-color:#<?=$buttonBGcolor;?>;
	color:#<?=$buttonTextColor;?>;
	font-family:inherit;
	font-size:inherit;
	font-weight:bold;
	border:0px solid silver;
	font-size:12px;
	cursor:pointer;
	height:23px;
	vertical-align:top;
	text-align:center;
	margin-top:<?=$top_bottom_padding;?>px;
	margin-<?=$SITE[align];?>:5px;
	margin-bottom:<?=$top_bottom_padding;?>px;
	margin-<?=$SITE[opalign];?>:5px;
        <?
	if ($SITE[searchfieldbg]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[searchfieldbg];?>');
		background-repeat: repeat-x;
		background-color: transparent;
		<?
	}
	else {
		$new_height=$height+5;
		if ($border_color) {
			$new_height=$new_height+2;
			?>
			border:1px solid #<?=$border_color;?>;
			<?
		}
		
		$prop=($new_height/23);
		$new_width=round(35+(35*$prop));
		if (!$height) 
		?>
		height:<?=$new_height;?>px;
		
		
		<?
		if ($_GET['height']>30) {
			?>
			width:<?=$new_width;?>px;
			<?
		}
		
		
	
	}
	
	?>
}


<?
if (ieversion()>0 AND ieversion()<8) {
	?>
	<?if ($SITE[searchformtop]==3) print ".search_frm_div form {position:static}";?>
	.search_frm{width:<?=$SITE[searchformwidth]-70;?>px;margin:<?=$top_bottom_padding;?>px 0px <?=$top_bottom_padding;?>px 2px;}
	.search_frm_button{margin-top:<?=$top_bottom_padding+1;?>px;margin-<?=$SITE[align];?>:0px;margin-bottom:<?=$top_bottom_padding;?>px;margin-<?=$SITE[opalign];?>:4px;}
	<?
}
if ($isiPad OR $isiPhone) {
	?>
	.search_frm{width:<?=$SITE[searchformwidth]-70;?>px;
	.search_frm_button{margin-top:<?=$top_bottom_padding+2;?>px;margin-<?=$SITE[align];?>:0px;}
	<?
}
if ($isiFF) {
	?>
	.search_frm{width:<?=$SITE[searchformwidth]-70;?>px;}
	
	<?
	if ($width_inc==78) {
		?>
		.search_frm{width:<?=$SITE[searchformwidth]-85;?>px;}
		<?
		}
	}
?>
</style>
<script language="javascript">
var sr_url;
function doSearch() {
        var parentLocation="";
        parentLocation=top.location.toString();
	var q_str=jQuery('#q').val();
	if (parentLocation.indexOf("<?=$SITE[url];?>/search/")>-1) {
		parent.eval('var sr_url="<?=$SITE[url];?>/GetInstantSR.php";');
                //sr_url="<?=$SITE[url];?>/GetInstantSR.php";
                
		parent.GetResultsHTML("sr",q_str);
	}
}
function cleanBox(current) {
	if (current==" <?=$SITE[searchformtext];?>") document.getElementById('q').value='';
}
function initSearchBox() {
    pairSearch=Array();
    var topLocation=top.location.search;
    pairSearch=topLocation.split("q=");
    var currentSearchVal=decodeURIComponent(pairSearch[1]).replace("+"," ");
    if (currentSearchVal!="undefined") jQuery("#q").val(currentSearchVal);
}
</script>
<?
//if ($SITE[roundcorners]==1 AND ($SITE[searchformtop]==2 OR $SITE[searchformtop]==3))  SetSearchDivRoundedCorners(1,1,$SITE[searchformbgcolor]);
if ($q=="") $q=" ".$SITE[searchformtext];
?>
</head>
<body>
<div class="search_frm_div">
	<form id="search_form" name="search_form" action="<?=$SITE[url];?>/search/" method="GET" style="padding:0;" target="_top">
	<input type="text" class="search_frm" name="q" id="q" value="<?=$q;?>" onkeyup="doSearch()" onclick="cleanBox(this.value)">
	<?
	if ($SITE[searchbutton]) {
		?>
		<span id="search_frm_image_span">
			<img class="search_frm_image" src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[searchbutton];?>" border="0" onclick="search_form.submit();" />
		</span>
		<?
	}
	else {
		?>
		<input class="search_frm_button" type="submit" value="<?=$SEARCH_LABELS[0];?>"  />
		<?
	}
	?>
	</form>
</div>
<script>
function setSizes() {
	
    var docWidth=jQuery(document).width();
    var buttonWidth=jQuery(".search_frm_button").width();
    var frmWidth=docWidth-buttonWidth-51;
    jQuery(".search_frm").width(frmWidth+"px");
    
    <?
    if ($SITE[searchbutton]) {
	?>
		jQuery(".search_frm_image").load(function() {
			var search_box_width=jQuery(".search_frm_div").width();
			var search_but_w=jQuery("#search_frm_image_span").width();
			var search_field_width=search_box_width-search_but_w-25;
			jQuery(".search_frm").width(search_field_width+"px");
		});

	<?
}
    ?>
}

jQuery(window).resize(function() {
	setSizes();
});
    jQuery(document).ready(function() {
            var search_frm_h=jQuery(".search_frm_div").height()+10;
            jQuery("#iframe_search",parent.document.body).height(search_frm_h+"px");
	    setSizes();
            initSearchBox();
    });
</script>
<?
//if ($SITE[roundcorners]==1) SetSearchDivRoundedCorners(0,0,$SITE[searchformbgcolor]);
?>
</body>
</html>