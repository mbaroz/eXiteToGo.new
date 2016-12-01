<?
header("Cache-Control: no-cache, must-revalidate");
include_once("config.inc.php");
session_start();
$search_q=strip_tags($_GET['q']);
$searchARRAY=array();
$searchARRAY=explode("-",$search_q);
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$custom_inc_dir=ini_get("include_path");
if ($custom_inc_dir=="../") $gallery_dir="../".$gallery_dir;
//die();
$c=0;
$w_j="";
foreach($searchARRAY as $val) {
	$attrARRAY=explode(":",$val);
	if ($val=="") continue;
	
	if ($attrARRAY[0]=="free_q") {
		$free_q_str.="(content.PageTitle LIKE '%{$attrARRAY[1]}%' OR content.ShortContent LIKE '%{$attrARRAY[1]}%')";
	}
	else {
		$w_j.="JOIN pages_attributes AS `attr_{$attrARRAY[0]}` ON `content`.`PageID`=`attr_{$attrARRAY[0]}`.`PageID`";
		$w_s.="`attr_{$attrARRAY[0]}`.`AttributeID`='{$attrARRAY[0]}' AND `attr_{$attrARRAY[0]}`.`ValueID`='{$attrARRAY[1]}' AND ";
	}

	$c++;
}
if ($w_s AND $free_q_str) $free_q_str="AND ".$free_q_str;
$w_s = substr($w_s,0,-5)." ".$free_q_str;
$db=new Database();
$db2=new Database();
$sql="SELECT content.* from content {$w_j} WHERE {$w_s}";
if ($_SESSION['rand_results']==1) $sql.=" ORDER BY RAND()";
	else $sql.=" ORDER BY content.PageTitle ASC";
$db->query($sql);

?>

<style>
.resultsWrapper {
	width: 100%;
	margin:6px;
}
.resultsWrapper div.sr {
	margin:0px 0px 10px;
	clear: both;
}
.resultsWrapper div.sr a.pic {
	float:<?=$SITE[align];?>;
	width:162px;height: 162px;
	background-repeat:no-repeat;
	background-size: contain;
	background-position: center;
	background-color: #<?=$SITE[shortcontentbgcolor];?>;
	margin-<?=$SITE[opalign];?>:7px;
	display: block;
}
.resultsWrapper div.sr .content {
	width:75%;
	
	float:<?=$SITE[align];?>;
}
</style>
<div class="resultsWrapper">
	<?
	  $i=0;
while($db->nextRecord()) {

		$numFields=$db->numFields();
        for ($fNum=0;$fNum<$numFields;$fNum++) {
            $fName=$db->getFieldName($fNum);
            $RES[$fName][$i]=$db->getField($fNum);
        }
        if ($free_q_str) {
        	//$parentID=$RES['ParentID'][$i];
        	$pageID=$RES['PageID'][$i];
			$db2->query("SELECT PageID from pages_attributes WHERE PageID='{$pageID}'");
			if (!$db2->nextRecord()) continue;
		}
        $content=$RES['ShortContent'][$i];
	$title=$RES['PageTitle'][$i];
        $photo_name=$RES['ContentPhotoName'][$i];
	$photo_src=SITE_MEDIA."/".$gallery_dir."/articles/".$photo_name;
	$big_photo_src=SITE_MEDIA."/".$gallery_dir."/".$photo_name;
	$photo_alt=str_replace("'","&lsquo;",$RES[ContentPhotoAlt][$i]);
	$photo_alt=str_replace('"',"&quot;",$photo_alt);
	$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
	$photo_alt=str_ireplace("Õ","&rsquo;",$photo_alt);
	$photo_alt=str_ireplace("'","&rsquo;",$photo_alt);
	$p_url=$SITE[url]."/".$RES[UrlKey][$i];
	$rel_code="";
	$page_url=urldecode($RES[PageUrl][$i]);
	$target_location="_self";
	if (!stripos($page_url,"/")==0 AND $page_url!="") $target_location="_blank";
	if ($RES[IsTitleLink][$i]) $page_url=$p_url;

        ?>
        <div class="sr">
			<?if ($photo_name!="") {
				$link_str='href="'.$page_url.'"';
				if ($page_url=="") $link_str="";
				?><a <?=$link_str;?> class="pic" style="background-image: url(<?=$photo_src;?>);"></a>
			<?
			}
			?>
			<div class="content">
				<?if ($title) {
					?>
					<div class="shortContentTitle">
					<?
					if (!$page_url=="") print '<a href="'.$page_url.'" target="'.$target_location.'" '.$rel_code.'>';
					print $title;
					if (!$page_url=="") print "</a>";
					?></div><?
				}
				?>
				<div class="mainContentText" style="margin-<?=$SITE[align];?>:8px;"><?=$content;?></div>
			</div>
			<div style="clear:both"></div>
		</div>
        <?     
        $i++;
}
	?>
</div>