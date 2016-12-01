<?
include_once("config.inc.php");
include_once("inc/GetServerData.inc.php");
$SEARCH_LABELS=array("לא נמצאו תוצאות חיפוש עבור הביטוי");
if ($SITE_LANG[selected]=="en") $SEARCH_LABELS=array("No search results were found for ");
if ($SITE_LANG[selected]=="ru") $SEARCH_LABELS=array("Не найдено результатов по запросу ");
function GetResults($q) {
	$q=strip_tags($q);
	$q=stripslashes($q);
	if ($q=="") return false;
	$db=new Database();
	$sql="SELECT content.PageTitle,content.PageContent,content.ShortContent,categories.UrlKey,content.PageID,categories.MenuTitle,categories.TagTitle from content LEFT JOIN content_cats ON content.PageID=content_cats.PageID  LEFT JOIN categories ON content_cats.CatID=categories.CatID WHERE (content.PageContent LIKE '%$q%' OR  content.PageTitle LIKE '%$q%' OR  content.ShortContent LIKE '%$q%' OR categories.PageKeywords LIKE '%$q%') AND (categories.ViewStatus=1)";
	$db->query($sql);
	$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
					$RES[$fName][$i]=$db->getField($fNum);
			}
			if (stristr($RES[PageTitle][$i],"footer") OR stristr($RES[PageTitle][$i],"middle")) continue;
			if ($RES[UrlKey][$i]=="404") continue;
			if ($RES[PageTitle][$i]=="")$RES[PageTitle][$i]=$RES[MenuTitle][$i];
			$i++;
			
			
		}
		$sql="SELECT DISTINCT galleries.GalleryText,galleries.GalleryBottomText,galleries.GalleryName,categories.UrlKey,categories.MenuTitle from galleries LEFT JOIN categories ON galleries.CatID=categories.CatID LEFT JOIN photos ON galleries.GalleryID=photos.GalleryID WHERE (galleries.GalleryText LIKE '%$q%' OR  galleries.GalleryName LIKE '%$q%' OR  galleries.GalleryBottomText LIKE '%$q%' OR galleries.GallerySideText LIKE '%$q%' OR photos.PhotoText LIKE '%$q%'  OR categories.PageKeywords LIKE '%$q%') AND (galleries.ProductUrlKey='' AND categories.ViewStatus=1 AND categories.MenuTitle NOT LIKE '%footer%')";
		$db->query($sql);
		$numFields=$db->numFields();
		while ($db->nextRecord()) {
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
					$RES[$fName][$i]=$db->getField($fNum);
			}
			$RES[PageID][$i]=$RES[CatID][$i];
			$RES[PageTitle][$i]=$RES[MenuTitle][$i];
			$RES[PageContent][$i]=$RES[GalleryText][$i];
			if ($RES[GalleryText][$i]=="") $RES[PageContent][$i]=$RES[GalleryBottomText][$i];
			if (stristr($RES[PageTitle][$i],"footer") OR stristr($RES[PageTitle][$i],"middle")) continue;
			$i++;
		}
		$sql="SELECT DISTINCT galleries.GalleryText,galleries.GalleryBottomText,galleries.GallerySideText,galleries.ProductUrlKey,galleries.GalleryName,categories.UrlKey,categories.MenuTitle from galleries LEFT JOIN categories ON galleries.CatID=categories.CatID LEFT JOIN videos ON galleries.GalleryID=videos.GalleryID WHERE (galleries.GalleryText LIKE '%$q%' OR  galleries.GalleryName LIKE '%$q%' OR videos.VideoText LIKE '%$q%'  OR categories.PageKeywords LIKE '%$q%') AND (categories.ViewStatus=1 AND categories.MenuTitle NOT LIKE '%footer%')";
		$db->query($sql);
		$numFields=$db->numFields();
		while ($db->nextRecord()) {
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
					$RES[$fName][$i]=$db->getField($fNum);
			}
			if ($RES[ProductUrlKey][$i]) continue;
			$RES[PageID][$i]=$RES[CatID][$i];
			$RES[PageTitle][$i]=$RES[MenuTitle][$i];
			
			$RES[PageContent][$i]=$RES[GalleryText][$i];
			if ($RES[PageContent][$i]=="") $RES[PageContent][$i]=$RES[MenuTitle][$i];
			if ($RES[PageContent][$i]=="") $RES[PageContent][$i]=$RES[GallerySideText][$i];
			if ($RES[PageContent][$i]=="") $RES[PageContent][$i]=$RES[GalleryBottomText][$i];
			
			if (stristr($RES[PageTitle][$i],"footer") OR stristr($RES[PageTitle][$i],"middle")) continue;
			$i++;
		}
		$sql="SELECT * from galleries WHERE (GalleryBottomPicsText LIKE '%$q%' OR galleries.GalleryText LIKE '%$q%' OR  galleries.GalleryName LIKE '%$q%' OR galleries.GallerySideText LIKE '%$q%') AND galleries.ProductUrlKey !=''";
		$db->query($sql);
		$numFields=$db->numFields();
		while ($db->nextRecord()) {
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
						$RES[$fName][$i]=$db->getField($fNum);
				}
			$RES[PageID][$i]=$RES[GalleryID][$i];
			$RES[PageTitle][$i]=$RES[GalleryName][$i];
			$RES[PageContent][$i]=$RES[GalleryText][$i];
			if (stristr($RES[GalleryBottomText][$i],$q)) $RES[PageContent][$i]=$RES[GalleryBottomText][$i];
			if (stristr($RES[GallerySideText][$i],$q)) $RES[PageContent][$i]=$RES[GallerySideText][$i];
			if (stristr($RES[GalleryBottomPicsText][$i],$q)) $RES[PageContent][$i]=$RES[GalleryBottomPicsText][$i];
			
			$i++;
		}
		// Added 10/9/2012
		$sql="SELECT products.*,categories.UrlKey AS CatURLKey from products LEFT JOIN categories
		ON products.ParentID=categories.CatID WHERE
		(products.ProductTitle LIKE '%$q%' OR products.ProductShortDesc LIKE '%$q%' OR categories.PageKeywords LIKE '%$q%') AND products.ViewStatus=1";
		$db->query($sql);
		$numFields=$db->numFields();
		while ($db->nextRecord()) {
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$RES[$fName][$i]=$db->getField($fNum);
			}
			$RES[PageID][$i]=$RES[ProductID][$i];
			$RES[PageTitle][$i]=$RES[ProductTitle][$i];
			$RES[PageContent][$i]=$RES[ProductShortDesc][$i];
			$RES[ProductUrlKey][$i]="shop_product/".$RES[CatURLKey][$i]."/".$RES[UrlKey][$i];
			
			$i++;
		}
		//Added 10/9/2012
	return $RES;
}
$q=trim($q);
$q_string = urldecode($q);
$q_string=mysql_escape_string($q_string);
$RESULTS=GetResults($q_string);
$q_string=stripslashes($q_string);
$q_string=stripcslashes($q_string);
$a=0;
?>
<div class="results">
	<ul>
		<?
		for ($a=0;$a<count($RESULTS[PageID]);$a++) {
			$c_title=$RESULTS[PageTitle][$a];
			if (stristr($c_title,"footer") OR stristr($c_title,"middle")) continue;
			$c_content=$RESULTS[PageContent][$a];
			if (stristr($RESULTS[ShortContent][$a],$q_string)) $c_content=$RESULTS[ShortContent][$a];
//			$RESULTS[PageContent][$a]=html_entity_decode($RESULTS[PageContent][$a]);
			$c_content=str_ireplace('"','',$c_content);
			$c_content=nl2br($c_content);
			$c_content=htmlspecialchars_decode($c_content,ENT_QUOTES);
//			$c_content=substr(strip_tags($c_content),0,180);
			$c_content=strip_tags($c_content);
			$c_content=trim($c_content);
			$dot_pos=@strpos($c_content,".",120);
			if (!$dot_pos) $dot_pos=@strpos($c_content,' ',150);
			if (!$dot_pos) $dot_pos=100;
			if ($dot_pos>200) {
				$length=strlen($c_content)-100;
				$end_c_content=substr($c_content,200,$length);
				$start_c_content=substr($c_content,0,200);
				$c_content=$start_c_content.' '.$end_c_content;
				$dot_pos=@strpos($c_content,' ',50);
			}
			//$dot_pos=200;
			$c_content=substr($c_content,0,$dot_pos);
			$c_content=str_ireplace("&nbsp;"," ",$c_content);
			
			$c_content=str_ireplace(".","",$c_content);
			$c_content=str_ireplace("\r"," ",$c_content);
			if (!$c_content=="") $c_content=$c_content."...";
			
			$c_urlkey=$RESULTS[UrlKey][$a];
			$res_url=$SITE[media]."/category/".$c_urlkey;
			if ($RESULTS[ProductUrlKey][$a]) $res_url=$SITE[url]."/".$RESULTS[ProductUrlKey][$a];
			if ($c_urlkey=="home") $res_url=$SITE[url];
			
			?>
			<li>
			<div class="resultsTitle"><a href="<?=$res_url;?>"><?=$c_title;?></a></div>
			<div class="resultsDesc"><?=$c_content;?></div>
			</li>	
			<?
		}
		if ($a==0) print '<div class="resultsDesc"> '.$SEARCH_LABELS[0].'"<strong>'.$q_string.'</strong>"</div>';
		?>
			
	</ul>
</div>