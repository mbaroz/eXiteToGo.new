<?php

if(isset($_GET['lang']))
	$SITE_LANG[selected] = substr(urlencode($_GET['lang']),0,2);

include_once("../config.inc.php");

$db = new Database();
$db->query("SELECT * FROM `categories` WHERE `categoryType`='14'");
$categories = array();
while($db->nextRecord())
{
	$cat = $db->record;
	$categories[$cat['CatID']]['details'] = $cat;
	$categories[$cat['ParentID']]['children'][] = $cat['CatID'];
}

$parents = '';

foreach($categories as $catID => $category)
{
	if(!isset($category['details']) && $catID > 0)
		$parents .= "'{$catID}',";
}

while($parents != '')
{
	$parents = substr($parents,0,-1);
	$db->query("SELECT * FROM `categories` WHERE `catID` IN ({$parents})");
	$parents = '';
	if($db->numRows() > 0)
	{
		while($db->nextRecord())
		{
			$cat = $db->record;
			$categories[$cat['CatID']]['details'] = $cat;
			$categories[$cat['ParentID']]['children'][] = $cat['CatID'];
		}
		foreach($categories as $catID => $category)
		{
			if(!isset($category['details']) && $catID > 0)
				$parents .= "'{$catID}',";
		}
	}
}

function generate_d($catID) {
	global $categories;
	if(!is_array($categories[$catID]['children']))
		return false;
	foreach($categories[$catID]['children'] as $subCatID) {
		echo "d.add({$subCatID},{$catID},'{$categories[$subCatID]['details']['MenuTitle']}','{$SITE['url']}/zap/category.php?catID={$subCatID}');\r\n";
		generate_d($subCatID);
	}
}

?>
<html<? if($SITE['align'] == 'right'){ ?> dir="rtl"<? } ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html;  charset=utf-8" />
		<link rel="stylesheet" href="dtree/dtree.css" type="text/css" />
		<script language="javascript" src="dtree/dtree.js"></script>
		<title>Categories Tree</title>
	</head>
	<body>
		<div class="dtree">
			<script type="text/javascript">
				var d = new dTree('d', '<?=$SITE['url'];?>/zap');
				d.add(0,-1,'Default Category','<?=$SITE['url'];?>/zap/category.php?catID=0')
				<? generate_d(0); ?>
				document.write(d);
			</script>
		</div>
	</body>
</html><!-- This page generated in  sec -->