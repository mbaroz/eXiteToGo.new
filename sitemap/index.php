<?
include_once("../config.inc.php");
include_once("../database.php");
header ("Content-Type:text/xml");
print '<?xml version="1.0" encoding="UTF-8"?>';
?>
 <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
 <?
$db=new Database();

$db->query("SELECT * from categories WHERE ViewStatus=1 AND isSecured=0 ORDER BY LastUpdate DESC");
$f=0;
while ($db->nextRecord()) {
	$UrlKey=$db->getField("UrlKey");
	if ($UrlKey=="404") continue;
	$PubDate=$db->getField("LastUpdate");
	$LASTMOD=explode(" ",$PubDate);
	$PubDate=$LASTMOD[0];
	if ($PubDate==0) $PubDate=date('Y-m-d');
	$urlLocation=$SITE[url]."/category/".$UrlKey;
	$priority=number_format(abs(0.9-$f),1);
	if ($priority<0.5) $priority=$priority+(0.5);
	if ($priority>1) {
		$priority=1;
		$f-0;
	}
	print '<url>';
	print '<loc>'.$urlLocation.'</loc>';
	print '<lastmod>'.$PubDate.'</lastmod>';
	print '<changefreq>daily</changefreq>';
	print '<priority>'.$priority.'</priority>';
	print '</url>';
	$f=$f+0.1;
}
$db->query("
    SELECT  `c` . * 
    FROM  `content`  `c` 
    LEFT JOIN  `content_cats`  `cc` ON (  `c`.`PageID` =  `cc`.`PageID` ) 
    LEFT JOIN  `categories`  `ca` ON (  `cc`.`CatID` =  `ca`.`CatID` ) 
    WHERE  `ca`.`ViewStatus` =  '1' AND `c`.`PageTitle` NOT LIKE 'middle_%' AND `c`.`PageTitle` NOT LIKE 'footer%'
        ");

 $f=0;

while ($db->nextRecord()) {
	
	$UrlKey=$db->getField("UrlKey");
	if ($UrlKey=="404") continue;
	$PubDate=$db->getField("PublishDate");
	$LASTMOD=explode(" ",$PubDate);
	$PubDate=$LASTMOD[0];
	$urlLocation=$SITE[url]."/".$UrlKey;
	$priority=number_format(abs(0.9-$f),1);
	if ($priority<0.5) $priority=$priority+(0.5);
	if ($priority>1) {
		$priority=1;
		$f-0;
	}
	print '<url>';
	print '<loc>'.$urlLocation.'</loc>';
	print '<lastmod>'.$PubDate.'</lastmod>';
print '<changefreq>daily</changefreq>';
print '<priority>'.$priority.'</priority>';
print '</url>';
	$f=$f+0.1;
}
?>
</urlset>