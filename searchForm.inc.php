<?
$isiPad = strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
$isiPhone =strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
$isiFF =strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'firefox');
$q=strip_tags($q);
$width_inc=60;
$SEARCH_LABELS=array("Search");
if ($SITE_LANG[selected]=="he" OR $SITE_LANG[direction]=="rtl") $SEARCH_LABELS=array("חפש");
else $width_inc=78;

$fieldMargin="0";
$topfieldMargin=1;
$top_bottom_padding=($SITE[searchformheight]-23)/2;
if ($SITE[searchformbgcolor]=="") {
	$fieldMargin=$SITE[searchformheight];
	//$SITE[searchformheight]=10;
}

if ($SITE[searchformtop]==1 AND !$SITE[searchformbgcolor]=="") $topfieldMargin=4;

?>
<style type="text/css">

.search_frm_image {
	vertical-align: middle;
	margin-bottom:5px;
}
.search_frm_div {
	width:<?=$SITE[searchformwidth]-2;?>px;
	height:<?=$SITE[searchformheight];?>px;
	background-color:#<?=$SITE[searchformbgcolor];?>;
	margin-bottom:0px;
	valign:middle;
	padding:5px 1px;
	text-align:center;
	
	
}
.search_frm_div form {
	margin:0px;
	position:relative;
	z-index:101;
	
}

.search_frm {
	width:<?=($SITE[searchformwidth]-$width_inc);?>px;
	outline: none;
	padding:3px 2px 1px 2px;
	border:0px solid silver;
	background-color:#<?=$SITE[formbgcolor];?>;
	font-family:inherit;
	font-size:inherit;
	color:#<?=$SITE[formtextcolor];?>;
	height:19px;
	margin-top:<?=$top_bottom_padding;?>px;
	margin-<?=$SITE[align];?>:0px;
	margin-bottom:<?=$top_bottom_padding;?>px;
	margin-<?=$SITE[opalign];?>:2px;
	<?
	if ($SITE[searchfieldbg]) {
		?>
		background-image:url('<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[searchfieldbg];?>');
		background-repeat: repeat-x;
		background-color: transparent;
		<?
	}
	?>
	

}
<?
if (($SITE[roundcorners] OR $_GET[roundcorners]==1)) {
    ?>
    .search_frm, .search_frm_div {border-radius:5px;}
    <?
}
?>
.search_frm_button {
	padding:3px 6px 3px 6px;
	background-color:#<?=$SITE[formbgcolor];?>;
	color:#<?=$SITE[formtextcolor];?>;
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
	margin-<?=$SITE[align];?>:0px;
	margin-bottom:<?=$top_bottom_padding;?>px;
	margin-<?=$SITE[opalign];?>:1px;
	
}
<?
if (($SITE[roundcorners] OR $_GET[roundcorners]==1)) {
	
    if ($SITE[searchformtop]==1) {
        ?>
        .search_frm_div {
            border-radius:0px 0px 6px 6px / 0px 0px 6px 6px;
            -moz-border-radius:0px 0px 6px 6px / 0px 0px 6px 6px;
           
        }
	 .search_frm_button {border-radius:6px;}
        <?
        
    }
    else {
    ?>
        .search_frm, .search_frm_div {
		border-radius:6px;
		 -moz-border-radius:6px;
        }
	.search_frm_button {border-radius:6px;}
    <?
    }
}

if (ieversion()>0 AND ieversion()<8) {
	?>
	<?if ($SITE[searchformtop]==3) print ".search_frm_div form {position:static}";?>
	.search_frm{width:<?=$SITE[searchformwidth]-70;?>px;margin:<?=$top_bottom_padding;?>px 0px <?=$top_bottom_padding;?>px 2px;}
	.search_frm_button{margin-top:<?=$top_bottom_padding+1;?>px;margin-<?=$SITE[align];?>:0px;margin-bottom:<?=$top_bottom_padding;?>px;margin-<?=$SITE[opalign];?>:4px;}
	<?
}


if ($isiPad OR $isiPhone) {
	?>
	.search_frm{width:<?=$SITE[searchformwidth]-78;?>px;
	.search_frm_button{margin-top:<?=$top_bottom_padding+2;?>px}
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
	var sr_urlKey="<?=$urlKey;?>";
	var q_str=jQuery('#q').val();
	if (sr_urlKey=="search_results") {
		sr_url="<?=$SITE[url];?>/GetInstantSR.php";
		GetResultsHTML("sr",q_str);
	}
}
function cleanBox(current) {
	if (current==" <?=$SITE[searchformtext];?>") document.getElementById('q').value='';
}
</script>
<?
//if ($SITE[roundcorners]==1 AND ($SITE[searchformtop]==2 OR $SITE[searchformtop]==3))  SetSearchDivRoundedCorners(1,1,$SITE[searchformbgcolor]);
if ($q=="") $q=" ".$SITE[searchformtext];
?>

<div class="search_frm_div">
	<form id="search_form" name="search_form" action="<?=$SITE[url];?>/search/" method="GET" style="padding:0;">
	<input type="text" class="search_frm" name="q" id="q" value="<?=$q;?>" onkeyup="doSearch()" onclick="cleanBox(this.value)">
	<?
	if ($SITE[searchbutton]) {
		?>
		<span id="search_frm_image_span">
			<input type="image" class="search_frm_image" src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[searchbutton];?>" />
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

<?
//if ($SITE[roundcorners]==1) SetSearchDivRoundedCorners(0,0,$SITE[searchformbgcolor]);
?>
<?
if ($SITE[searchbutton]) {
	?>
	<script>
		jQuery(".search_frm_image").load(function() {
	
			var search_box_width=jQuery(".search_frm_div").width();
			var search_but_w=jQuery("#search_frm_image_span").width();
			var search_field_width=search_box_width-search_but_w-23;
			jQuery(".search_frm").width(search_field_width+"px");
		});
		
		
	</script>

	<?
}
