<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
include_once("inc/GetNewsData.inc.php");
$catID=$_GET['cID'];
$NEWS=GetNews($catID);
if (count($NEWS[NewsID])<1) $NEWS=GetNews("999999".$catID);
$scrollspeed=0;
$marqueeheight="";
$scrollamount=2;
if ($NEWS[ScrollType][0]==1 AND !isset($_SESSION['LOGGED_ADMIN'])) {
	$scrollspeed="1";
	$marqueeheight="280px";
}
if ($SITE[newstickerdelay]=="") $SITE[newstickerdelay]=4;
$tickerDelay=($SITE[newstickerdelay]*1000);
$scroll_direction="up";
if ($_GET['scroll']=="down") $scroll_direction="down";
$padding=0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<base target="_top" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/css/styles.css.php?urlKey=<?=$urlKey;?>">
	<link rel="stylesheet" type="text/css" href="<?=$SITE[url];?>/js/lightbox/css/jquery.lightbox-0.5.css" media="screen" />
        <script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-1.7.2.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?=$SITE[url];?>/js/gallery/jquery-ui-1.8.10.custom.min.js"></script>
	<script language="javascript" type="text/javascript">
	jQuery.noConflict();
        </script>
	<style type="text/css">
	body {background:none;background-image:none;background-color:transparent;margin:0;padding:0;direction:<?=$SITE_LANG[direction];?>}
        .NewsBoxContainer li {
                list-style:none;
                list-type:none;
        }
	.NewsBox {
		padding-<?=$SITE[align];?>:0px;
		margin-<?=$SITE[align];?>:0px;
		<?
		if ($_GET['border'] OR $_GET['bgcolor']) {
			$padding=14;
			?>
			padding:6px;
			<?
		}
		if ($_GET['border']) {
			?>
			border:1px solid #<?=$_GET['border'];?>;
			<?
		}
		if ($_GET['bgcolor']) {
			?>
			background:#<?=$_GET['bgcolor'];?>;
			<?
		}
		if ($SITE[roundcorners]) {
			?>
			border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;
			-moz-border-radius:6px 6px 6px 6px / 6px 6px 6px 6px;";
			<?
		}
		?>
	}
	</style>
        <script type="text/javascript" src="<?=$SITE[url];?>/js/jquery.vticker.js"></script> 
        <script type="text/javascript"> 
                jQuery(function(){
			
                });
</script>
</head>
<body>
    
<div class="NewsBox">
	
	<?
	
	print '<div class="news-container">';
	print "<ul  id='NewsBoxContainer'>";
	for ($a=0;$a<count($NEWS[NewsID]);$a++) {
		$nDate=formatDate($NEWS[NewsDate][$a],"il");
		$nTitle=$NEWS[NewsTitle][$a];
		$nContent=$NEWS[NewsBody][$a];
		if ($nContent=="") continue;
		
		?>
		<li class="NewsItem" id="news_item-<?=$NEWS[NewsID][$a];?>"  style="width:100%">
			<div id="newsContent_<?=$NEWS[NewsID][$a];?>"><?=$nContent;?></div>
			<div style="clear:both;display:block;padding-top:5px"></div>
		<?
                if (count($NEWS[NewsID])>2) print '<div style="padding-top:2px;" class="NewsSeperator"></div>';
                print "</li>";
	}
	print "</ul>";
	?>
	<div style="display:block;padding-top:1px;clear:both;"></div>
	</div>

    <?
    if (isset($_SESSION['LOGGED_ADMIN'])) {
        $UKEY=GetUrlKeyFromID($catID);
        $news_url_key=$UKEY[UrlKey];
        
        ?>
        <div id="editMode" class="mainContentText" style="display:none;font-size:12px;position:absolute;top:0px;z-index:1000;background-color:#<?=$SITE[contentbgcolor];?>"><a href="<?=$SITE[media];?>/category/<?=$news_url_key;?>"><?=$ADMIN_TRANS['go to news settings page'];?></a></div>
    
            <script>
            jQuery(".NewsBox").mouseover(function() {
                    jQuery("#editMode").show();
            });
            jQuery(".NewsBox").mouseout(function() {
                    jQuery("#editMode").hide();
            });
            jQuery(".news-container").mouseover(function() {
                    jQuery("#editMode").show();
            });
            
        </script>
    <?
    }
    ?>
</div>
<script>
function setVtiker() {
	jQuery('.news-container').vTicker({
                        speed: 650,
                        pause: <?=$tickerDelay;?>,
                        showItems: 1,
                        animation:'fade',
                        mousePause: true,
                        height: 0,
                        direction: '<?=$scroll_direction;?>'
                        });
	 var news_iframe_height=jQuery(".news-container").height()+<?=$padding;?>;
	jQuery("#nframe_<?=$catID;?>",parent.document.body).height(news_iframe_height+"px");
	parent.goMason();
}
jQuery(document).ready(function() {
	window.setTimeout('setVtiker()',400);
             
	
    });
</script>
</body>
</html>