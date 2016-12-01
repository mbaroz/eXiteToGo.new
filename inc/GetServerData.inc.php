<?
	function getCacheResult($k,$m,$post_key="") {
		$cache_pre=$_SERVER['SERVER_NAME'];
	    if ($m->exists($cache_pre.$k.$post_key)) return json_decode($m->get($cache_pre.$k.$post_key),true);
	    else return false;
	}
	function setCacheVal($k,$v,$m,$post_key="") {
	    $cache_pre=$_SERVER['SERVER_NAME'];
	    $m->del($cache_pre.$k.$post_key);
	    $m->set($cache_pre.$k.$post_key,json_encode($v));
	    return json_decode($m->get($cache_pre.$k.$post_key),true);
	}
	function delCacheKey($k,$m,$post_key=""){
		$cache_pre=$_SERVER['SERVER_NAME'];
		$m->del($cache_pre.$k.$post_key);
	}
	function GetAdminLanguages() {
		global $SITE_LANG;
		$db=new database;
		$sql="SELECT * from admin_lang";
		$db->query($sql);
		$i=0;
		$ADMIN_VALS['SITE[Edit Photo]']=$ADMIN_VALS['SITE[Edit Photo/Video]'];
		while ($db->nextRecord()) {
			$numFields=$db->numFields();
			for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$ADMIN_VALS[$fName][$i]=$db->getField($fNum);
			}
			$TRANSLATED=$ADMIN_VALS[Translated][$i];
			if ($TRANSLATED=="" OR $SITE_LANG['selected']!="he") $TRANSLATED=$ADMIN_VALS[Label][$i];
			
			$ADMIN_LANGS[strtolower($ADMIN_VALS[Label][$i])]=$TRANSLATED;
			$i++;
		}
		return $ADMIN_LANGS;
	}
	function GetLanguages() {
		$db=new database;
		$sql="SELECT * from langs";
		$db->query($sql);
		$i=0;
		while ($db->nextRecord()) {
			$numFields=$db->numFields();
			for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$LANGS[$fName][$i]=$db->getField($fNum);
			}
			
			$i++;
		}
		return $LANGS;
	}
	function GetConfigVars() {
		global $m;
		if (!$CONFIG=getCacheResult('siteCONFIG',$m)) {
			$db=new database;
			$sql="SELECT * from config";
			$db->query($sql);
			$i=0;
			while ($db->nextRecord()) {
				$numFields=$db->numFields();
				for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$CONFIG[$fName][$i]=$db->getField($fNum);
				}
				$i++;
			}
			$CONFIG=setCacheVal('siteCONFIG',$CONFIG,$m);
		}
		return $CONFIG;
	}
	function escape_quote( $str ) {
		return preg_replace ("/'/", "&rsquo;", $str);
	}
	function formatStrings($str) {
		$str=ereg_replace("%","&#37;",$str);
		$str = ereg_replace("'", "&#39;", $str);
		$str = ereg_replace('"',"&quot;", $str);
		
		return $str;
	}
	function GetContentMenu() {
		$db=new Database();
		$sql="select * from content WHERE PageTitle!='' ORDER BY ViewStatus DESC,PageOrder"; 
		$db->query($sql);
		$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
					$MENU[$fName][$i]=$db->getField($fNum);
			}
			$i++;
		}
	return $MENU;
}
	function HaveUrlKey($ID) {
		global $m;
		if (!$url_key_returned=getCacheResult('haveurlkey',$m,'_'.$ID)) {
			$db=new Database();
			$sql="select UrlKey from categories WHERE CatID='$ID' AND UrlKey!=''";
			$db->query($sql);
			if ($db->nextRecord()) {
				$uKeyRetrun = $db->getField("UrlKey");
			}
			else $uKeyRetrun= false;
			$url_key_returned=setCacheVal('haveurlkey',$uKeyRetrun,$m,'_'.$ID);
		}
		return $url_key_returned;
	}
	function GetCatMenu() {
		global $m;
		if (!$MENU=getCacheResult('_catMenu',$m)) {
			$db=new Database();
			$sql="select * from categories WHERE MenuTitle!='' ORDER BY ViewStatus DESC,PageOrder"; 
			$db->query($sql);
			$numFields=$db->numFields();
			$i=0;
			while ($db->nextRecord()) {
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
						$MENU[$fName][$i]=$db->getField($fNum);
				}
				$i++;
			}
			$MENU=setCacheVal('_catMenu',$MENU,$m);
		}
		return $MENU;
}
	function AddContent($P) {
		$pubDate=date('Y-m-d H:i:s');
		$db=new Database();
		if ($P[cType]==1 AND !$P[copyContentAction]) {
			$P[shortContent]=$P[pageContent];
			$P[pageContent]="";
		}
		if ($P[homePage]) $db->query("update content SET HomePage=0"); //resetting homepage
		$sql="insert into content (PageOrder,PageTitle,PageContent,ShortContent,PageUrl,ViewStatus,ParentID,HomePage,PublishDate,UrlKey,IsTitleLink,isFullWidth) VALUES ('$P[contentOrder]','$P[contentTitle]','$P[pageContent]','$P[shortContent]','$P[pageURL]','$P[Show]','$P[parentPage]','$P[homePage]','$pubDate','$P[NewPageUrlKey]','$P[isTitleLink]','$P[isFullWidth]')";
		$db->query($sql);
		$newPageID=mysqli_insert_id($db->dbConnectionID);
		$sql="INSERT INTO content_cats SET CatID='$P[parentPage]',PageID='$newPageID'";
		$db->query($sql);
		return $newPageID;
	}
	function DeleteContent($pageID) {
		LogAction($pageID,"PageID","PageContent","content",1,"Content Deleted","deleted");
		LogAction($pageID,"PageID","ShortContent","content",1,"Short Content Deleted","deleted");
		$db=new Database();
		$sql="DELETE from content WHERE PageID=$pageID";
		$db->query($sql);
		$db->query("DELETE from content_cats WHERE PageID='$pageID'");
	}
	function EditContent($P,$pageID) {
		
		$db=new Database();
		$objDataName="PageContent";
		if ($P[cType]==1) $objDataName="ShortContent";
		LogAction($pageID,"PageID",$objDataName,"content",1,"Page Content update","modified");
		if ($P[homePage]) $db->query("update content SET HomePage=0"); //resetting homepage
		if ($P[contentType]==1) $sql="update content SET PageContent='$P[pageContent]' WHERE PageID='$pageID'";
		else {
			if ($P[cType]==1 AND strpos($P[NewPageUrlKey],"footer")===false) $sql="update content SET UrlKey='$P[NewPageUrlKey]',HomePage='$P[homePage]',PageTitle='$P[contentTitle]',ShortContent='$P[pageContent]',PageUrl='$P[pageURL]',ViewStatus='$P[Show]',ParentID='$P[parentPage]',IsTitleLink='$P[isTitleLink]' WHERE PageID='$pageID' AND UrlKey NOT LIKE 'footer%'";
			else $sql="update content SET UrlKey='$P[NewPageUrlKey]',HomePage='$P[homePage]',PageTitle='$P[contentTitle]',PageContent='$P[pageContent]',PageUrl='$P[pageURL]',ViewStatus='$P[Show]',ParentID='$P[parentPage]',IsTitleLink='$P[isTitleLink]' WHERE PageID='$pageID'";
		}
		$db->query($sql);
		
		print strpos($P[NewPageUrlKey],"footer");
	}
	function EditPageContent($P,$pageID) {
		$db=new Database();
		
		if ($P[homePage]) $db->query("update content SET HomePage=0"); //resetting homepage
		if ($P[contentType]==1) $sql="update content SET FullContent='$P[pageContent]' WHERE PageID='$pageID'";
		else {
			if ($P[cType]==1 AND strpos($P[NewPageUrlKey],"footer")===false) $sql="update content SET UrlKey='$P[NewPageUrlKey]',HomePage='$P[homePage]',PageTitle='$P[contentTitle]',ShortContent='$P[pageContent]',PageUrl='$P[pageURL]',ViewStatus='$P[Show]',ParentID='$P[parentPage]' WHERE PageID='$pageID'";
			else $sql="update content SET UrlKey='$P[NewPageUrlKey]',HomePage='$P[homePage]',PageTitle='$P[contentTitle]',PageContent='$P[pageContent]',PageUrl='$P[pageURL]',ViewStatus='$P[Show]',ParentID='$P[parentPage]' WHERE PageID='$pageID'";
		}
		$db->query($sql);
		print strpos($P[NewPageUrlKey],"footer");
	}
	function GetContent($urlKey) {
		if ($urlKey) {
			$PAGE_ID=GetPageIDFromUrlKey($urlKey);
			$pageID=$PAGE_ID[parentID];
		}
		else $pageID=0;
		$db=new Database();
		$sql="select * from content WHERE PageID='$pageID'";
		$db->query($sql);
		$db->nextRecord();
		$numFields=$db->numFields();
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$CONTENT[$fName]=$db->getField($fNum);
			}
		return $CONTENT;
	}
	function GetMultiContent($urlKey,$searchUrlKey="") {
		global $m;
		global $CHECK_CATPAGE;
		if ($urlKey) {
			$pageID=$CHECK_CATPAGE[parentID];
		}
		else $pageID=0;
		
		$post_key=base64_encode($pageID);
		if ($searchUrlKey!="") $post_key=base64_encode($pageID.$searchUrlKey);
		if (!$CONTENT=getCacheResult('multiContent',$m,$post_key)) {
			$db=new Database();
			if ($searchUrlKey=="") $sql="select content.* from content_cats LEFT JOIN content  ON  content_cats.PageID=content.PageID WHERE content_cats.CatID='$pageID' AND content.PageTitle NOT LIKE '%footer_%' AND content.PageTitle NOT LIKE 'middle_%'  ORDER BY content.PageOrder,content.PageID DESC";
			else {
				if ($searchUrlKey=="footer") $sql="select content.* from content_cats LEFT JOIN content  ON  content_cats.PageID=content.PageID WHERE content_cats.CatID='$pageID' AND content.PageTitle LIKE '$searchUrlKey%' ORDER BY content.PageOrder,content.PageID DESC";
				else $sql="select content.* from content_cats LEFT JOIN content  ON  content_cats.PageID=content.PageID WHERE content_cats.CatID='$pageID' AND content.PageTitle LIKE '$searchUrlKey%' AND content.PageContent!='' ORDER BY content.PageOrder,content.PageID DESC";
			}
			
			$db->query($sql);
			$numFields=$db->numFields();
			$i=0;
			while ($db->nextRecord()) {
				for ($fNum=0;$fNum<$numFields;$fNum++) {
						$fName=$db->getFieldName($fNum);
						$CONTENT[$fName][$i]=$db->getField($fNum);
					}
					$i++;
			}
			$CONTENT=setCacheVal('multiContent',$CONTENT,$m,$post_key);

		}
		return $CONTENT;
	}
	function GetIDFromUrlKey($urlKey,$from_id = false) {
		global $m;
		$post_key=base64_encode('_'.$urlKey);
		if ($from_id) $post_key=base64_encode('_'.$urlKey."_1");

		if (!$PAGE=getCacheResult('id_page',$m,$post_key)) {
			$db=new Database();
			$URL_KEY=explode("/",$urlKey);
			$catUrlKey=$URL_KEY[0];
			$pageUrlKey=$URL_KEY[1];
			if (!$URL_KEY[1]) {
				$pageUrlKey=$URL_KEY[0];
				$catUrlKey=0;
			}
			
			if($URL_KEY[0] == 'shop_product')
			{
				$catUrlKey=$URL_KEY[1];
				$pageUrlKey=$URL_KEY[1];
			}
			
			

			$where = ($from_id) ? "catID='{$urlKey}'" : "UrlKey='{$pageUrlKey}'";
			if($URL_KEY[0] == 'shop_product') $where.=" AND CategoryType=14";
			$db->query("SELECT CatID,UrlKey,ParentID,MenuTitle,PhotoAltText,CategoryType,shopOptions from categories WHERE {$where}");
			
			if ($db->nextRecord()) {
				$PAGE[Status]=200;
				$PAGE['shopOptions']=json_decode($db->getField('shopOptions'),true);
				$PAGE[parentID]=$db->getField("CatID");
				$PAGE[fatherID]=$db->getField("ParentID");
				$PAGE[title]=$db->getField("MenuTitle");
				$PAGE[photo_alt]=$db->getField("PhotoAltText");
				$PAGE[CatType]=$db->getField("CategoryType");
				$PAGE[subID]=$db->getField("ParentID");
				$PAGE[subURLKEY]=$db->getField("UrlKey");
				$db->query("SELECT CatID,ParentID,UrlKey from categories WHERE ParentID='$PAGE[parentID]'");
				if ($db->nextRecord())	{
					$PAGE[subID]=$db->getField("CatID");
					$PAGE[subURLKEY]=$db->getField("UrlKey");

				}
				if ($PAGE[subID]==0) $PAGE[subID]=GetHomePageCatID();
				
				$URL_KEY[ParentUrlKey]=$db->getField("UrlKey");
				$URL_KEY[ParentID]=$parentID;
				$db->query("SELECT CatID,ParentID,UrlKey from categories WHERE CatID='$PAGE[fatherID]'");
				if ($db->nextRecord()) $PAGE[ParentUrlKey]=$db->getField("UrlKey");
				//else {
				//	$db->query("SELECT CatID,ParentID,UrlKey from categories WHERE CatID='$PAGE[parentID]'");
				//	$db->nextRecord();
					
				//	if ($PAGE[subID]==0) {
				//		$PAGE[subID]=GetHomePageCatID();
				//	}
				//}
				///print $PAGE[subID];
			}
			else {
				$PAGE[Status]=404;
				$db->query("SELECT * from categories WHERE UrlKey='404'");
				if (!$db->nextRecord()) {
					$db->query("INSERT INTO categories SET ViewStatus=0, UrlKey='404', ParentID=100000,MenuTitle='404-Not found'");
					$cID_404=mysqli_insert_id($db->dbConnectionID);
				}
				
			}
			if ($URL_KEY[0]=="category") $PAGE[Status]=404;
			$PAGE=setCacheVal('id_page',$PAGE,$m,$post_key);
		}
		return $PAGE;
	}
	function GetPageIDFromUrlKey($urlKey) {
		global $m;
		$post_key=base64_encode('_'.$urlKey);

		$isFullContent=$isProdPage=0;
		global $shopActivated;
		if (!$PAGE=getCacheResult('page_id_page',$m,$post_key)) {
			$db=new Database();
			$db2=new Database();
			$urlKey=addslashes($urlKey);
			if(substr($urlKey,-1) == "/")
				$urlKey = substr($urlKey,0,-1);
			$URL_KEY=explode("/",$urlKey);
			$PROD_URL_KEY=explode("product/",$urlKey);
			if($shopActivated && substr($urlKey,0,13) == "shop_product/")
			{
				$SHOP_URL_KEY=explode("/",$urlKey);
				$shopPageUrlKey=array_pop($SHOP_URL_KEY);
			}
			$productPageUrlKey=$PROD_URL_KEY[1];
			$catUrlKey=$URL_KEY[0];
			$pageUrlKey=$URL_KEY[1];
			if (!$URL_KEY[1]) {
				$pageUrlKey=$URL_KEY[0];
				$catUrlKey=0;
			}
			$found = false;
			if($shopActivated && $shopPageUrlKey != '')
			{
				$db->query("SELECT `ParentID`,`ProductID`,`FB_WIDGET` from `products` WHERE `UrlKey`='{$shopPageUrlKey}'");
				if($db->nextRecord())
				{

					$db2->query("SELECT `CatID` from categories WHERE UrlKey='{$pageUrlKey}' AND CatID='{$db->getField('ParentID')}'");

					if (!$db2->nextRecord()) {
						$db2->query("SELECT UrlKey from categories WHERE CatID='{$db->getField('ParentID')}'");
						$db2->nextRecord();
						$redirectLocation=$db2->getField("UrlKey");
						header("Location:/shop_product/".$redirectLocation."/".$shopPageUrlKey);
					}
					$PAGE = array(
						'Status' => 200,
						'parentID' => $db->getField('ParentID'),
						'ProductID' => $db->getField('ProductID'),
						'FB_WIDGET' => $db2->getField('FB_WIDGET'),
					);
					$found = true;
				}
			}
			if (!$found) 
			{
			$db->query("SELECT PageID,ParentID from content WHERE UrlKey='$pageUrlKey'");
			$db2->query("SELECT GalleryID,ProductUrlKey,GalleryName,FB_WIDGET from galleries WHERE ProductUrlKey='$urlKey' AND ProductUrlKey!=''");
			
			if ($db->nextRecord()) $isFullContent=1;
			if ($db2->nextRecord()) $isProdPage=1;
			if ($isFullContent OR $isProdPage) {
				$PAGE[Status]=200;
				$PAGE[parentID]=$db->getField("PageID");
				$PAGE[galleryID]=$db2->getField("GalleryID");
				$PAGE[productUrlKey]=$db2->getField("ProductUrlKey");
				$PAGE[galleryName]=$db2->getField("GalleryName");
				$PAGE[FB_WIDGET]=$db2->getField("FB_WIDGET");
				$db->query("SELECT PageID,ParentID from content WHERE ParentID='$PAGE[parentID]'");
				if ($db->nextRecord())	{
					$PAGE[subID]=$db->getField("PageID");
	//				if (!$PAGE[subID]) $PAGE[subID]=GetHomePageCatID();
					//$PAGE[parentID]=$db->getField("ParentID");
					}
				
				
			}
			else {
				$PAGE[Status]=404;
				$db->query("SELECT PageID from content WHERE UrlKey='404'");
				if (!$db->nextRecord()) {
					$db->query("INSERT INTO content SET PageTitle='Not Found-404', UrlKey='404'");
					$pid_404=mysqli_insert_id($db->dbConnectionID);
					$db->query("SELECT CatID from categories WHERE UrlKey='404'");
					if ($db->nextRecord())  $matchCatdID=$db->getField('CatID');
						else {
							$db->query("INSERT INTO categories SET ViewStatus=0, UrlKey='404', ParentID=100000,MenuTitle='404-Not found'");
							$matchCatdID=mysqli_insert_id($db->dbConnectionID);
						}
						$db->query("INSERT INTO content_cats SET PageiD='$pid_404', CatID='$matchCatdID'");
					
					}
				}
			}	
			$PAGE=setCacheVal('page_id_page',$PAGE,$m,$post_key);
		}
		return $PAGE;
	}
	function GetParentMenu($urlKey) {
		global $m;
		if ($urlKey){
			$PAGE_ID=GetIDFromUrlKey($urlKey);
			$parentID=$PAGE_ID[parentID];
			$subID=$PAGE_ID[subID];
			
		}
		$post_key=base64_encode('_'.$urlKey);
		if (!$subID) $subID=$parentID;
		if (!$MENU=getCacheResult('parentMenu',$m,$post_key)) {
			$db=new Database();
			$parentURLKEY=$PAGE_ID[ParentUrlKey];
			$tempParentUrlKey=$parentURLKEY;
			if ($parentURLKEY) {
				$parentID=$PAGE_ID[fatherID];
			}
			$MENU[ParentParentUrlKey]=$PAGE_ID[fatherID];

			if ($subID==$parentID) {
				$parentURLKEY=GetParentUrlKey($parentURLKEY);
				if ($parentURLKEY[ParentID]!=0) $parentID=$parentURLKEY[ParentID];
				
			}
			else {
				//$parentURLKEY=GetParentUrlKey($parentURLKEY[ParentUrlKey]);
				//if ($parentURLKEY[ParentID]!=0) $parentID=$parentURLKEY[ParentID];

				
			}
			$sql="select * from categories WHERE ParentID='$parentID' AND MenuTitle NOT LIKE 'footer%' ORDER BY PageOrder"; 
			$db->query($sql);
			if (!$db->nextRecord() and $subID>1) {
				$sql="select * from categories WHERE ParentID='$subID' AND MenuTitle NOT LIKE 'footer%' ORDER BY PageOrder"; 
			}
			else {
				
				$sql="select * from categories WHERE ParentID='$parentID' AND MenuTitle NOT LIKE 'footer%' OR (CatID='$parentID' AND ParentID!=0) ORDER BY PageOrder"; 
	//			print $parentID."|".$subID;

			}
			
			$db->query($sql);
			$numFields=$db->numFields();
			$i=0;
			while ($db->nextRecord()) {
			$MENU[isSubCat][$i]=0;
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
						$MENU[$fName][$i]=$db->getField($fNum);
				}
				
				if ($MENU[ParentID][$i]==$parentID) $MENU[isSubCat][$i]=1;
				$MENU_CAT_STYLE=json_decode($MENU[CatStylingOptions][$i],true);
				$MENU[enableRichTextPopUp][$i]=$MENU_CAT_STYLE['enableRichTextPopUp'];
				$i++;
				
			}
			$MENU=setCacheVal('parentMenu',$MENU,$m,$post_key);
		}
		
	return $MENU;
}

 	function GetSubMenu($urlKey,$numLevels=0) {
 		global $m;
 		$post_key=base64_encode('_'.$urlKey.'_'.$numLevels);
 		if (!$SUBTOPMENU=getCacheResult('subTopMenu',$m,$post_key)) {

			if ($urlKey){
				$PAGE_ID=GetIDFromUrlKey($urlKey);
				$parentID=$PAGE_ID[parentID];
				$subID=$PAGE_ID[subID];
			}
			//$SUBURLKEY=GetUrlKeyFromID($subID);
			//$sub_url_key=$SUBURLKEY[UrlKey];
			$sub_url_key=$PAGE_ID[subURLKEY];
			
			$parentURLKEY=$PAGE_ID[ParentUrlKey];
			$topParentID=$PAGE_ID[fatherID];
			$db=new Database();
			$sql="select * from categories WHERE ParentID='$parentID' AND ParentID!=0 AND MenuTitle NOT LIKE 'footer%' ORDER BY PageOrder"; 
			$db->query($sql);
			
			if (!$db->nextRecord() and $subID>1) {
				
				$parentURLKEY=$PAGE_ID[ParentUrlKey];
				
				if ($parentURLKEY) {
					
					$org_parentID=$parentID;
					$parentID=$PAGE_ID[fatherID];
					$db->query("SELECT ParentID from categories WHERE CatID='$parentID' AND ParentID!=0");
					if (!$db->nextRecord()) $parentID=$org_parentID;
				}
				$sql="select * from categories WHERE ParentID='$parentID' AND ParentID!=0 AND MenuTitle NOT LIKE 'footer%' ORDER BY PageOrder"; 
			}
			else {
				$org_parentID=$parentID;
				$db->query("SELECT ParentID from categories WHERE CatID='$topParentID' AND ParentID!=0");
				if (!$db->nextRecord()) $topParentID=$org_parentID;
				$sql="select * from categories WHERE  ParentID='$topParentID' AND ParentID!=0 AND MenuTitle NOT LIKE 'footer%' ORDER BY PageOrder"; 
			}
			//print $sql;
			$db->query($sql);
			$numFields=$db->numFields();
			if ($i=="") $i=0;
			while ($db->nextRecord()) {
			
				for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$SUBTOPMENU[$fName][$i]=$db->getField($fNum);
				}
				$SUBTOPMENU[HaveChild][$i]=0;
				$SUBTOPMENU[SubUrlKey][$i]=$sub_url_key;
				
				if ($topParentID!=$parentID AND $SUBTOPMENU[UrlKey][$i]==$urlKey AND $numLevels==0) $SUBTOPMENU[HaveChild][$i]=1;

				$i++;

			}
			$SUBTOPMENU=setCacheVal('subTopMenu',$SUBTOPMENU,$m,$post_key);
		}
		return $SUBTOPMENU;
	}
	function GetCatUrlKeyFromCatID($catID) {
		$db=new Database();
		$sql="select categories.`UrlKey` from categories WHERE `catID`='{$catID}' ORDER BY categories.PageOrder";
		$db->query($sql);
		$db->nextRecord();
		$CATURLKEY=$db->getField("UrlKey");
		return  $CATURLKEY;
	}
	
	function GetCatUrlKeyFromPageID($pageID) {
		$db=new Database();
		$sql="select categories.* from content_cats LEFT JOIN categories  ON  content_cats.CatID=categories.CatID WHERE content_cats.PageID='$pageID' AND content_cats.CatID=categories.CatID ORDER BY categories.PageOrder";
		$db->query($sql);
		$db->nextRecord();
		$CATURLKEY=$db->getField("UrlKey");
		return  $CATURLKEY;
	}
	
	function GetAdminDetails($uID) {
		$db=new database;
		$sql="SELECT * from admins where UID='$uID'";
		$db->query($sql);
		$db->nextRecord();
		$numFields=$db->numFields();
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$MEMBERDETAILS[$fName]=$db->getField($fNum);
			}
		
		return $MEMBERDETAILS;
	} //End function GetAdminDetails
	function GetUserDetails($uID) {
		$db=new database;
		$sql="SELECT * from users where UID='$uID'";
		$db->query($sql);
		$db->nextRecord();
		$numFields=$db->numFields();
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$MEMBERDETAILS[$fName]=$db->getField($fNum);
			}
		
		return $MEMBERDETAILS;
	} //End function GetAdminDetails
	function AddNewCat($C) {
		global $SITE;
		$C[categoryName]=str_ireplace("'", "׳", $C[categoryName]);
		$PageStyle=$SITE[defaultpagestyle];
		if ($PageStyle=="") $PageStyle=0;
		$pubDate=date('Y-m-d H:i:s');
		$db=new Database();
		
		$type_add = '';
		if($C[catParentID] > 0)
		{
			$parent = GetCategoryByID($C['catParentID']);
			if($parent['CategoryType'] == 14)
			{
				$C['CategoryType'] = $parent['CategoryType'];
				$s_o = json_decode($parent['shopOptions'],true);
				if($SITE[roundcorners]==1)
					$s_o['roundedCorners'] = 1;
				$C['shopOptions'] = json_encode($s_o);
			}
		}
		if($C['CategoryType'])
		{
			$type_add .= ",`CategoryType`='{$C['CategoryType']}'";
		}
		if($C['shopOptions'])
		{
			$type_add .= ",`shopOptions`='{$C['shopOptions']}'";
		}
		$db->query("SELECT MAX(PageOrder) from categories");
		$db->nextRecord();
		$max_PageOrder=$db->getField(0)+1;

		$sql="insert into categories SET MenuTitle='$C[categoryName]',PageOrder='{$max_PageOrder}',PageStyle='$PageStyle',ViewStatus='$C[ViewStatus]',ParentID='$C[catParentID]',UrlKey='$C[NewCatUrlKey]', PageUrl='$C[categoryLink]', MobileView='$C[mobileView]', isSecured='$C[isSecured]'{$type_add}";
		$db->query($sql);
		$newCatId = mysqli_insert_id($db->dbConnectionID);
		if($C['CategoryType'] == 14 && @$parent['CategoryType'] == 14)
		{
			$db2=new Database();
			$db->query("SELECT * FROM `categories_attributes` WHERE `CatID`='{$C['catParentID']}'");
			while($db->nextRecord())
			{
				$oldAttName = $db->getField('AttributeName');
				$oldAttID = $db->getField('AttributeID');
				$db2->query("INSERT INTO `categories_attributes`(`CatID`,`AttributeName`) VALUES('{$newCatId}','{$oldAttName}')");
				$attID = mysqli_insert_id($db->dbConnectionID);
				$db2->query("INSERT INTO `categories_attributes_values`(`AttributeID`,`ValueName`) SELECT '{$attID}',`ValueName` FROM `categories_attributes_values` WHERE `AttributeID`='{$oldAttID}'");
			}
		}
		return $newCatId;
	}
	function AddNewGallery($G) {
		$pubDate=date('Y-m-d H:i:s');
		$db=new Database();
		$sql="insert into galleries SET CatID='$G[catParentID]',GalleryName='$G[GalleryName]',GalleryType='$G[GalleryType]'";
		$db->query($sql);			
		//return mysqli_insert_id($db->dbConnectionID);
	}
	function EditCat($C) {
		$db=new Database();

		
		$sql="UPDATE categories SET MenuTitle='$C[categoryName]',UrlKey='$C[NewCatUrlKey]', PageUrl='$C[categoryLink]' ,ViewStatus='$C[ViewStatus]', MobileView='$C[mobileView]' WHERE CatID='$C[PageID]'";
		$db->query($sql);
		return $C[categoryName];
		//return mysqli_insert_id($db->dbConnectionID);
	}
	function DelCat($cID) {
		$db=new Database();
		$db2=new Database();
		$res=false;
		$sql="delete from  categories WHERE CatID='$cID'";
		$db->query("SELECT content_cats.CatID from content_cats LEFT JOIN content ON content_cats.PageID=content.PageID WHERE content_cats.CatID='$cID' AND content.PageTitle NOT LIKE 'footer_%' AND content.PageTitle NOT LIKE 'middle_%'");
		$db2->query("SELECT PhotoID from photos LEFT JOIN galleries on photos.GalleryID=galleries.GalleryID  WHERE galleries.CatID='$cID' AND photos.GalleryID=galleries.GalleryID AND (galleries.GalleryType=0 OR galleries.GalleryType=3)");
		if (!$db->nextRecord() AND !$db2->nextRecord())	{
			$res=true;
			$db->query($sql);
		}
		return $res;
	}
	function GetContentCats($pageID) {
		$db=new Database();
		$sql="SELECT categories.MenuTitle,content_cats.CatID from categories LEFT JOIN content_cats ON categories.CatID=content_cats.CatID WHERE content_cats.PageID='$pageID'";
		$db->query($sql);
		$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$CATS[$fName][$i]=$db->getField($fNum);
				}
				$i++;
		}
		return $CATS;
	}	
	function GetHomePageCatID() {
		$db=new Database();
		$sql="SELECT content_cats.CatID FROM content_cats LEFT JOIN content ON content_cats.PageID=content.PageID WHERE content.HomePage=1";
		$db->query($sql);
		$db->nextRecord();
		return $db->getField("CatID");
	}
	function GetBrowserType($type=0) {
		$useragent = $_SERVER['HTTP_USER_AGENT'];

		if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		    $browser_version=$matched[1];
		    $browser = 'IE';
		} elseif (preg_match( '|Opera ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		    $browser_version=$matched[1];
		    $browser = 'Opera';
		} elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
		        $browser_version=$matched[1];
		        $browser = 'Firefox';
		} elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
		        $browser_version=$matched[1];
		        $browser = 'Safari';
		} else {
		        // browser not recognized!	
		    $browser_version = 0;
		    $browser= 'other';
		}
		if ($type==0) return $browser;
		else return $browser_version;
}
	function GetMetaData($pID,$c=0) {
		global $CHECK_PAGE;
		global $m;
		$post_key=$pID.'_'.$c.'_'.$CHECK_PAGE['parentID'];
		if (!$META=getCacheResult('pageMetaData',$m,$post_key)) {
			$db=new Database();
			if ($c==1) $sql="select * from categories WHERE CatID='$pID'";
			elseif($c==2) $sql="select ProductPrice,ProductTitle as PageTitle,PageDescribtion,TagTitle,PageKeywords,FB_WIDGET,G_WIDGET from products WHERE ProductID='$pID'";
			else $sql="select PageTitle,PageDescribtion,TagTitle,PageKeywords,MetaTags,SEBlock,FB_WIDGET,G_WIDGET from content WHERE PageID='$pID'";
			
			$db->query($sql);
			$db->nextRecord();
			$numFields=$db->numFields();
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$META[$fName]=$db->getField($fNum);
				}
			if ($CHECK_PAGE[productUrlKey]) {
				$META[PageTitle]=$CHECK_PAGE[galleryName];
				
			}
			if ($CHECK_PAGE[parentID]) {
				$PARENT_OVERLAY=GetParentOverlayPic($CHECK_PAGE[parentID],$CHECK_PAGE['ProductID']);
				if ($PARENT_OVERLAY[OverlayPhotoName]) {
					$META[OverlayPhotoName]=$PARENT_OVERLAY[OverlayPhotoName];
					$META[OverlayPhotoHeight]=$PARENT_OVERLAY[OverlayPhotoHeight];
				}
				
				if ($CHECK_PAGE[ProductID]) {
					$c_id_q=$CHECK_PAGE[parentID];
					$db->query("SELECT * from categories WHERE CatID='$c_id_q'");
					
				}
				else {
					$C_UKEY=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
					$db->query("SELECT * from categories WHERE UrlKey='$C_UKEY'");
					
				}
				$db->nextRecord();
				$META[MainPicSideText]=$db->getField("MainPicSideText");
				
				
			}
			$META=setCacheVal('pageMetaData',$META,$m,$post_key);
		}
		return $META;
	}
	function GetGalleryPhotos($galID,$gallery_type=0) {
		$orderBy="DESC";
		$sortOrderBy="ASC";
		$db=new Database();
		$db->query("SELECT * from galleries WHERE GalleryID='$galID'");
		$db->nextRecord();
		$GALOP[PhotosOrder]=$db->getField("PhotosOrder");
		if ($GALOP[PhotosOrder]=="bottom") {
			$orderBy="ASC";
			$sortOrderBy="DESC";
		}
		
		$sql="SELECT photos.*  from photos  LEFT JOIN galleries ON photos.GalleryID=galleries.GalleryID WHERE galleries.GalleryID='$galID' ORDER BY photos.PhotoOrder $sortOrderBy ,photos.PhotoID $orderBy";
		$db->query($sql);
		$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$GALLERY[$fName][$i]=$db->getField($fNum);
				}
			$i++;
		}
		
		return $GALLERY;
	}
	function GetCatGallery($urlKey,$gallery_type=0,$ProductUrlPage=0) {
		if ($urlKey) {
			$PAGE_ID=GetIDFromUrlKey($urlKey);
			$pageID=$PAGE_ID[parentID];
		}
		$orderBy="DESC";
		$sortOrderBy="ASC";
		$GALOP=GetGalleryOptions($urlKey,$gallery_type,$ProductUrlPage);
		if ($GALOP[PhotosOrder]=="bottom") {
			$orderBy="ASC";
			$sortOrderBy="DESC";
		}
		$db=new Database();
		$sql="SELECT photos.*  from photos  LEFT JOIN galleries ON photos.GalleryID=galleries.GalleryID WHERE galleries.CatID='$pageID' AND galleries.GalleryType='$gallery_type' ORDER BY photos.PhotoOrder $sortOrderBy ,photos.PhotoID $orderBy";
		if ($ProductUrlPage) $sql="SELECT photos.*  from photos  LEFT JOIN galleries ON photos.GalleryID=galleries.GalleryID WHERE galleries.ProductUrlKey='$ProductUrlPage' AND galleries.GalleryType='$gallery_type' ORDER BY photos.PhotoOrder,photos.PhotoID $orderBy";
		if ($gallery_type==1) $sql="SELECT videos.*  from videos  LEFT JOIN galleries ON videos.GalleryID=galleries.GalleryID WHERE galleries.CatID='$pageID' ORDER BY videos.VideoOrder,videos.VideoID Desc";
		
		$db->query($sql);
		$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$GALLERY[$fName][$i]=$db->getField($fNum);
				}
			$i++;
		}
		
		$db->query("SELECT GalleryID,GalleryName,GalleryType,GalleryText,GalleryBottomText,GallerySideText,GalleryBottomPicsText,ProductGallery,hmargin,wmargin,TumbsBGPic,TumbsWidth,TumbsHeight,PhotosOrder,Filters,isDefaultOptions from galleries WHERE CatID='$pageID' AND GalleryType='$gallery_type'");
		if ($ProductUrlPage) $db->query("SELECT GalleryID,GalleryName,GalleryType,GalleryText,GalleryBottomText,GallerySideText,GalleryBottomPicsText,ProductGallery,hmargin,wmargin,TumbsBGPic,PhotosOrder,Filters,isDefaultOptions from galleries WHERE ProductUrlKey='$ProductUrlPage' AND GalleryType='$gallery_type'");
		$db->nextRecord();
		$GALLERY[GID]=$db->getField("GalleryID");
		$GALLERY[Type]=$db->getField("GalleryType");
		$GALLERY[GalleryName]=$db->getField("GalleryName");
		$GALLERY[GalleryText]=$db->getField("GalleryText");
		$GALLERY[GalleryBottomText]=$db->getField("GalleryBottomText");
		$GALLERY[GallerySideText]=$db->getField("GallerySideText");
		$GALLERY[ProductGallery]=$db->getField("ProductGallery");
		$GALLERY[GalleryBottomPicsText]=$db->getField("GalleryBottomPicsText");
		$GALLERY[wmargin]=$db->getField("wmargin");
		$GALLERY[hmargin]=$db->getField("hmargin");
		$GALLERY[TumbsBGPic]=$db->getField("TumbsBGPic");
		$GALLERY[TumbsWidth]=$db->getField("TumbsWidth");
		$GALLERY[TumbsHeight]=$db->getField("TumbsHeight");
		$GALLERY[PhotosOrder]=$db->getField("PhotosOrder");
		$GALLERY[Filters]=$db->getField("Filters");
		$GALLERY[isDefaultOptions]=$db->getField("isDefaultOptions");
		
		return $GALLERY;
		
	}
	function GetUrlKeyFromID($pID) {
		$db=new Database();
		$db->query("SELECT UrlKey,ParentID from categories WHERE CatID='$pID'");
		$db->nextRecord();
		$parentID=$db->getField("ParentID");
		$URL_KEY[UrlKey]=$db->getField("UrlKey");
		$db->query("SELECT UrlKey,ParentID from categories WHERE CatID='$parentID'");
		$db->nextRecord();
		$URL_KEY[ParentUrlKey]=$db->getField("UrlKey");
		return $URL_KEY;
	}
	function GetParentUrlKey($urlKey) {
		$db=new Database();
		$db->query("SELECT ParentID from categories WHERE UrlKey='$urlKey'");
		$db->nextRecord();
		$parentID=$db->getField("ParentID");
		$db->query("SELECT UrlKey,ParentID from categories WHERE CatID='$parentID'");
		$db->nextRecord();
		$URL_KEY[ParentUrlKey]=$db->getField("UrlKey");
		$URL_KEY[ParentID]=$parentID;
		return $URL_KEY;
	}
	function GetRootUrlKey($urlKey) {
		$db=new Database();
		global $CHECK_PAGE;
		if ($CHECK_PAGE) {
			$urlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
			if ($CHECK_PAGE[ProductID]) $urlKey=GetCatUrlKeyFromCatID($CHECK_PAGE[parentID]);
			elseif ($CHECK_PAGE[productUrlKey]) $urlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
		}
		$db->query("SELECT ParentID,CatID from categories WHERE UrlKey='$urlKey'");
		$db->nextRecord();
		$parentID=$db->getField("ParentID");
		if ($CHECK_PAGE[productUrlKey]) $parentID=$db->getField("CatID");
		while ($parentID!=0) {
			$db->query("SELECT UrlKey,ParentID,MenuTitle,CatID,CatTitle from categories WHERE CatID='$parentID'");
			$db->nextRecord();
			$URL_KEY[ParentUrlKey]=$db->getField("UrlKey");
			$URL_KEY[ParentMenuTitle]=$db->getField("MenuTitle");
			$URL_KEY[RootCatID]=$db->getField("CatID");
			$parentID=$db->getField("ParentID");
			if ($db->getField("CatTitle")) {
				$URL_KEY[ParentMenuTitle]=$db->getField("CatTitle");
				$parentID=0;
			}
		}
		
		return $URL_KEY;
	}
	function GetCatItem($urlKey,$itemType=0) {
		if ($urlKey) {
			$PAGE_ID=GetIDFromUrlKey($urlKey);
			$item_catID=$PAGE_ID[parentID];
		}
		$db=new Database();
		$sql="SELECT items.*  from items  LEFT JOIN categories ON items.CatID=categories.CatID WHERE items.CatID='$item_catID' ORDER BY items.ItemOrder";
		$db->query($sql);
		$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$ITEMS[$fName][$i]=$db->getField($fNum);
				}
			$i++;
		}
		$ITEMS[HaveItems]=$ITEMS[ItemTitle][0];
		return $ITEMS;
	}
	function AddNewItem($I) {
		$pubDate=date('Y-m-d H:i:s');
		$db=new Database();
		$sql="insert into items SET CatID='$I[catParentID]',ItemTitle='$I[ItemTitle]'";
		$db->query($sql);			
		//return mysqli_insert_id($db->dbConnectionID);
	}
	function GetBreadCrumb($urlKey) {
		global $SITE;
		global $SITE_LANG;
		$bc_level=$SITE[breadcrumblevel];
		if ($bc_level=="") $bc_level=3;
		$breadcrumb_dir="ltr";
		if ($SITE_LANG[direction]=="ltr") $breadcrumb_dir="rtl";
		$ex = explode('/',$urlKey);
		if ($urlKey) {
			$PAGE_ID=GetIDFromUrlKey($urlKey);
			$catID=$PAGE_ID[parentID];
			//$P_CID=GetParentUrlKey($urlKey);
			$parentID=$PAGE_ID['fatherID'];
			
		}
		$db=new Database();
		$db->query("SELECT MenuTitle,ParentID,UrlKey,PageUrl,ViewStatus from categories WHERE CatID='$catID'");
		$db->nextRecord();
		if($parentID < 1)
			$parentID = $db->getField("ParentID");
		$CURCAT[CatName]=$db->getField("MenuTitle");
		$CURCAT[UrlKey]=$db->getField("UrlKey");
		$CURCAT[ExtUrl]=$db->getField("PageUrl");
		$LINK_STR="<span style='align:".$SITE[align]."'><a href='".$SITE[media]."/category/".$CURCAT[UrlKey]."'>";
		if ($CURCAT[ExtUrl]) $LINK_STR="<span style='align:".$SITE[align]."'><a href='".urldecode($CURCAT[ExtUrl])."'>";
//		$STR_A_CAT[0]="<div style='padding-top:13px'>";
		if($ex[0] == 'shop_product')
			$STR_A_CAT[0]=$LINK_STR.$CURCAT[CatName]."</a>";
		else
			$STR_A_CAT[0]="<strong>".$CURCAT[CatName]."</strong>";
		$counter=1;
		
		while ($parentID!=0) {
			//print $urlKey;
			
			$db->query("SELECT MenuTitle,ParentID,UrlKey,PageUrl,ViewStatus from categories WHERE CatID='$parentID'");
			$db->nextRecord();
			$CURCAT[CatName]=$db->getField("MenuTitle");
			$CURCAT[UrlKey]=$db->getField("UrlKey");
			$CURCAT[ExtUrl]=$db->getField("PageUrl");
			$LINK_STR="<span style='align:".$SITE[align]."' itemscope itemtype='http://data-vocabulary.org/Breadcrumb'><a href='".$SITE[media]."/category/".$CURCAT[UrlKey]."' itemprop='url'>";
//			if ($CURCAT[UrlKey]==$urlKey) $LINK_STR="<span dir=ltr>";
			if ($db->getField("ViewStatus")==0) $LINK_STR='';
			if ($CURCAT[ExtUrl]) $LINK_STR="<span style='align:".$SITE[align]."' itemscope itemtype='http://data-vocabulary.org/Breadcrumb'><a href='".urldecode($CURCAT[ExtUrl])."' itemprop='url'>";
			$STR_A_CAT[$counter]='<span itemprop="title">'.$LINK_STR.$CURCAT[CatName]."</span></a>&nbsp; <span style='font-size:larger'>›</span> &nbsp;</span>";
			
			$parentID=$db->getField("ParentID");
			$counter++;
		}
		$STR_A_CAT=array_reverse($STR_A_CAT);
		
		if($ex[0] == 'shop_product')
		{
			$prod_url = array_pop($ex);
			$db->query("SELECT `ProductTitle` FROM `products` WHERE `UrlKey`='{$prod_url}'");
			if($db->nextRecord())
			{
				$prod_name = $db->getField('ProductTitle');
				$LINK_STR="&nbsp; <span style='font-size:larger'>›</span> &nbsp;</span><span style='align:".$SITE[align]."'><strong>";
				$STR_A_CAT[]=$LINK_STR.$prod_name."</strong>";
				$counter++;
			}
		}
		
		$STR_CAT="";
		
		for ($a=0;$a<count($STR_A_CAT);$a++) {
			$STR_CAT.=$STR_A_CAT[$a];
		}
		if ($bc_level<2) {
			$db->query("SELECT MenuTitle,UrlKey from categories WHERE UrlKey='home'");
			$db->nextRecord();
			$root_str_title=$db->getField("MenuTitle");
			$STR_CAT="<span style='align:".$SITE[align]."' itemscope itemtype='http://data-vocabulary.org/Breadcrumb'><a href='".$SITE[media]."' itemprop='url'><span itemprop='title'>".$root_str_title."</span></a>	&nbsp; <span style='font-size:larger'>›</span> &nbsp;</span>".$STR_CAT;
		}
		if($ex[0] == 'shop_product') $STR_CAT="&nbsp;".$STR_CAT;
		$STR_CAT="<div style='padding-top:10px'>".$STR_CAT."</div>";
		if ($urlKey=="home") $STR_CAT="";
		if ($counter<$bc_level && $ex[0] != 'shop_product') $STR_CAT="";
		return $STR_CAT;
}
	function isNewsPage($urlKey) {
		$CID=GetIDFromUrlKey($urlKey);
		$catID=$CID[parentID];
		if ($urlKey=="404") return true;
		else {
			$db=new Database();
			$db->query("SELECT CatID from news WHERE CatID='$catID'");
			if ($db->nextRecord() AND $catID!="") return true;
			else return false;
		}
}
	function isNewsProductPage($prodGallID) {
		$db=new Database();
		$db->query("SELECT GalleryID from news WHERE GalleryID='$prodGallID' AND GalleryID!=''");
		if ($db->nextRecord() AND $prodGallID!="") return true;
		else return false;
}
	function GetPageTitle($objectID,$objectType) {
		$db=new Database();
		$sql="SELECT * from titles WHERE ObjectType='$objectType' AND ObjectID='$objectID'";
		$db->query($sql);
		$db->nextRecord();
		$numFields=$db->numFields();
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$TITLE[$fName]=$db->getField($fNum);
			}
		return $TITLE;
	}
	function GetCatUrlKeyFromProductPage($prodUrlKey) {
		$db=new Database();
		$sql="SELECT galleries.* from galleries LEFT JOIN photos ON galleries.GalleryID=photos.GalleryID WHERE photos.ProductUrlKey='$prodUrlKey'";
		$db->query($sql);
		$db->nextRecord();
		$numFields=$db->numFields();
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$GAL[$fName]=$db->getField($fNum);
			}
		$cID=$GAL[CatID];
		$db->query("SELECT UrlKey from categories WHERE CatID='$cID'");
		$db->nextRecord();
		$GAL[CatUrlKey]=$db->getField("UrlKey");
		return $GAL[CatUrlKey];
	}
	function GetMiddleContent($urlKey) {
		global $CHECK_PAGE;
		if ($CHECK_PAGE AND $urlKey!="home") {
			$urlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
			if ($CHECK_PAGE[productUrlKey]) $urlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);
			if ($CHECK_PAGE[ProductID]) $urlKey=GetCatUrlKeyFromCatID($CHECK_PAGE[parentID]);
				
				
		}
		$tempUrlKey=$urlKey;
		$C_MIDDLE_MULTI=GetMultiContent($urlKey,"middle");
		$parentID=1;
		while (!is_array($C_MIDDLE_MULTI[PageContent]) AND $parentID!=0) {
			
			$parURL_KEY=GetParentUrlKey($tempUrlKey);
			$parent_url_key=$parURL_KEY[ParentUrlKey];
			$parentID=$parURL_KEY[ParentID];
			$tempUrlKey=$parent_url_key;
			$C_MIDDLE_MULTI=GetMultiContent($parent_url_key,"middle");
			
		}
		
		return $C_MIDDLE_MULTI;
	}
	function ieversion() {
		  preg_match('/MSIE ([0-9]\.[0-9])/',$_SERVER['HTTP_USER_AGENT'],$reg);
		  preg_match('/MSIE (10)/',$_SERVER['HTTP_USER_AGENT'],$reg2);
		  if (isset($reg2[1])) $reg[1]=$reg2[1];
		  if(!isset($reg[1])) {
		    return -1;
		  } else {
		    return floatval($reg[1]);
		  }
	}
	function GetGalleryOptions($urlKey,$gallery_type,$productUrlPage=0) {
		global $SITE;
		if ($urlKey) {
			global $CHECK_PAGE;
			if ($CHECK_PAGE[parentID]) $urlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
			$PAGE_ID=GetIDFromUrlKey($urlKey);
			$pageID=$PAGE_ID[parentID];
		}
		
		$db=new Database();
		$db->query("SELECT * from galleries WHERE CatID='$pageID' AND GalleryType='$gallery_type'");
		if ($productUrlPage) $db->query("SELECT * from galleries WHERE ProductUrlKey='$productUrlPage' AND GalleryType='$gallery_type'");
		$db->nextRecord();
		$numFields=$db->numFields();
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$GALOPTIONS[$fName]=$db->getField($fNum);
			}
		return $GALOPTIONS;
		
	}
	function GetGalleryStyling($urlKey,$galType=4) {
		global $ADMIN_TRANS;
		global $MainPicSelectedEffect;
		global $SITE;
		$DIAPO_EFFECTS=array('random','scrollHorz','scrollTop','scrollBottom','scrollLeft','scrollRight','simpleFade', 'curtainTopLeft', 'curtainTopRight', 'curtainBottomLeft', 'curtainBottomRight', 'curtainSliceLeft', 'curtainSliceRight', 'blindCurtainTopLeft', 'blindCurtainTopRight', 'blindCurtainBottomLeft', 'blindCurtainBottomRight', 'blindCurtainSliceBottom', 'blindCurtainSliceTop', 'stampede', 'mosaic', 'mosaicReverse', 'mosaicRandom', 'mosaicSpiral', 'mosaicSpiralReverse', 'topLeftBottomRight', 'bottomRightTopLeft', 'bottomLeftTopRight', 'bottomLeftTopRight');
		$LS_EFFECTS=array("Multi Effects Slides");
		$BACKGROUND_EFFECTS=array("Fade","Slide Top", "Slide Right","Slide Bottom","Slide Left", "Carousel Right", "Carousel Left");
		$EASINGS=array('linear','swing','easeInQuad','easeOutQuad','easeInOutQuad','easeInCubic','easeOutCubic','easeInOutCubic','easeInQuart','easeOutQuart','easeInOutQuart','easeInQuint','easeOutQuint','easeInOutQuint','easeInSine','easeOutSine','easeInOutSine','easeInExpo','easeOutExpo','easeInOutExpo','easeInCirc','easeOutCirc','easeInOutCirc','easeInElastic','easeOutElastic','easeInOutElastic','easeInBack','easeOutBack','easeInOutBack','easeInBounce','easeOutBounce','easeInOutBounce');
		$GAL_OPT=GetGalleryOptions($urlKey,$galType);
		//if ($GAL_OPT[GalleryEffect]<53) $GAL_OPT[GalleryEffect]=53;
		
		$MainPicSelectedEffect=$GAL_OPT[GalleryEffect];
		$GAL_EFFECT_OPTIONS=json_decode($GAL_OPT[EffectOptions]);
		$current_easing=GetGalleryAttribute("easingEffect",$GAL_OPT[GalleryID]);
		if (!$GAL_OPT[GalleryID]) $GAL_OPT=GetGalleryOptions($urlKey,100);
		if ($GAL_OPT[GalleryEffect]=="" OR $GAL_OPT[GalleryEffect]<53) $GAL_OPT[GalleryEffect]=53;
		$selected_effect=$selected_theme=$selected_easing=array();
		$auto_play="";
		if ($GAL_OPT[AutoPlay]==0) $auto_play="checked"; 
		$selected_effect[$GAL_OPT[GalleryEffect]]="selected";
		$selected_theme[$GAL_OPT[GalleryTheme]]="selected";
		$selected_easing[$current_easing]="selected";
		$theme_show=$easing_show=$ls_slider_show="";
		if ($GAL_OPT[SlideSpeed]==0) $GAL_OPT[SlideSpeed]=2000;
		if ($GAL_OPT[SlideDelay]==0) $GAL_OPT[SlideDelay]=3000;
		$GAL_OPT[SlideSpeed]=($GAL_OPT[SlideSpeed]/1000); //IN SECONDS
		$GAL_OPT[SlideDelay]=($GAL_OPT[SlideDelay]/1000); //IN SECONDS
		$num_slices_show="none";
		if ($GAL_OPT[GalleryEffect]>3) {
			$theme_show="none";
			$num_slices_show="";
		}

		if ($GAL_OPT[GalleryEffect]<24) $easing_show="none";
		if ($GAL_OPT[GalleryEffect]<53 OR $GAL_OPT[GalleryEffect]>54) $ls_slider_show="none";
		$html_out="";
		$html_out.='
		<table style="border:0px" cellspacing="2">
		<tr>
			<td>'.$ADMIN_TRANS['slides effect'].'</td>
			<td>
			<select id="gal_effect" style="direction:ltr" onchange="setEffectVisibleOptions(this.options[this.selectedIndex].value)">
			';
		$html_out.='	
			<optgroup label="Pixar Effects">';
				for ($e=0;$e<count($DIAPO_EFFECTS);$e++) {
					$op_val=$e+24;
					$html_out.= '<option value='.$op_val.' '.$selected_effect[$op_val].'>'.$DIAPO_EFFECTS[$e].'</option>';
				}
			$html_out.='
			</optgroup>
			<optgroup label="Layer Slider">';
				for ($e=0;$e<count($LS_EFFECTS);$e++) {
					$op_val=$e+53;
					$html_out.= '<option  value='.$op_val.' '.$selected_effect[$op_val].'>'.$LS_EFFECTS[$e].'</option>';
				}
			$html_out.='
			</optgroup>
			<optgroup label="Background Slider">';
				for ($e=0;$e<count($BACKGROUND_EFFECTS);$e++) {
					$op_val=$e+55;
					$html_out.= '<option value='.$op_val.' '.$selected_effect[$op_val].'>'.$BACKGROUND_EFFECTS[$e].'</option>';
				}
			$html_out.='
			</optgroup>
			</select>
			</td>
		</tr>
		<tr style="display:'.$theme_show.'">
			<td>'.$ADMIN_TRANS['gallery type'].'</td>
			<td>
			<select id="gal_theme">
			<option value=0 '.$selected_theme[0].'>Dots</option>
			<option value=1 '.$selected_theme[1].'>Classic</option>
			</select>
			</td>
		</tr>
		<tr style="display:'.$ls_slider_show.'" id="advanced_effects_show">
			<td colspan="2">
				<div id="ls_effect_chooser">'.$ADMIN_TRANS['choose multiple effects'].' <i class="fa fa-chevron-'.$SITE[opalign].'"></i></div>
			</td>
		</tr>

		<tr style="display:'.$easing_show.'" id="easing_selection">
			<td>Easing</td>
			<td>
			<select id="gal_easing" style="direction:ltr">';
			for ($e=0;$e<count($EASINGS);$e++) {
					$html_out.= '<option value='.$EASINGS[$e].' '.$selected_easing[$EASINGS[$e]].'>'.$EASINGS[$e].'</option>';
			}
			$html_out.='
			</select>
			</td>
		</tr>
		<tr>
		<td>'.$ADMIN_TRANS['slides speed'].'<br><small>(בשניות)</small></td><td><input type="text" maxlength="5" id="slide_speed" value='.$GAL_OPT[SlideSpeed].'></td>
		</tr>
		<tr>
		<tr>
		<td>'.$ADMIN_TRANS['slides delay'].'<br><small>(בשניות)</small></td><td><input type="text" maxlength="5" id="slide_delay" value='.$GAL_OPT[SlideDelay].'></td>
		</tr>
		<tr>
		<td>'.$ADMIN_TRANS['photo height'].' (px)</td><td><input type="text" maxlength="4" id="gal_height" value='.$GAL_OPT[GalleryHeight].'></td>
		</tr>
		<tr>
		<tr style="display:'.$num_slices_show.'">
		<td>'.$ADMIN_TRANS['slices'].'</td><td><input type="text" maxlength="4" id="num_slices" value='.$GAL_OPT[NumSlices].'></td>
		</tr>
		<tr>
		<td>'.$ADMIN_TRANS['auto start'].'</td><td><input type="checkbox" id="gal_autoplay" style="border:0px" '.$auto_play.'></td>
		</table>
		';
		return $html_out;
	}
	function GetGalleryPageStyling($urlKey,$galType=3,$productPageUrlKey=0) {
		global $ADMIN_TRANS;
		global $MainPicSelectedEffect;
		$GAL_OPT=GetGalleryOptions($urlKey,$galType,$productPageUrlKey);
		if (!$GAL_OPT[GalleryID]) $GAL_OPT=GetGalleryOptions($urlKey,100,$productPageUrlKey);
		$DIAPO_EFFECTS=array('random','scrollHorz','scrollTop','scrollBottom','scrollLeft','scrollRight','simpleFade', 'curtainTopLeft', 'curtainTopRight', 'curtainBottomLeft', 'curtainBottomRight', 'curtainSliceLeft', 'curtainSliceRight', 'blindCurtainTopLeft', 'blindCurtainTopRight', 'blindCurtainBottomLeft', 'blindCurtainBottomRight', 'blindCurtainSliceBottom', 'blindCurtainSliceTop', 'stampede', 'mosaic', 'mosaicReverse', 'mosaicRandom', 'mosaicSpiral', 'mosaicSpiralReverse', 'topLeftBottomRight', 'bottomRightTopLeft', 'bottomLeftTopRight', 'bottomLeftTopRight');
		$selected_effect=$selected_theme=array();
		$show_side_text_cb="none";
		$auto_play=$product_gallery=$orderBottom="";
		if ($GAL_OPT[AutoPlay]==0) $auto_play="checked";
		
		if ($GAL_OPT[ProductGallery]==1) {
			$product_gallery="checked";
			$show_side_text_cb="";
		}
		if ($productPageUrlKey) $show_side_text_cb="";
		if ($GAL_OPT[PhotosOrder]=="bottom") $isOrderBottom="checked";
		$selected_effect[$GAL_OPT[GalleryEffect]]="selected";
		$selected_theme[$GAL_OPT[GalleryTheme]]="selected";
		$theme_show="";
		$num_slices_show="none";
		if ($GAL_OPT[SlideSpeed]==0) $GAL_OPT[SlideSpeed]=400;
		if ($GAL_OPT[SlideDelay]==0) $GAL_OPT[SlideDelay]=4000;
		if ($GAL_OPT[GalleryHeight]==0) $GAL_OPT[GalleryHeight]=400;
		$GAL_OPT[SlideSpeed]=($GAL_OPT[SlideSpeed]/1000); //IN SECONDS
		$GAL_OPT[SlideDelay]=($GAL_OPT[SlideDelay]/1000); //IN SECONDS
		
		if ($GAL_OPT[GalleryEffect]>3) {
			$theme_show="none";
			$num_slices_show="";
		}
		$html_out="";
		$html_out.='
		<table style="border:0px" cellspacing="2">
		<tr>
			<td>'.$ADMIN_TRANS['slides effect'].'</td>
			<td>
			<select id="gal_effect_page" style="direction:ltr">
			<optgroup label="Standart Effects">
				<option value=0 '.$selected_effect[0].'>Slides</option>
				<option value=1 '.$selected_effect[1].'>Fade</option>
				<option value=2 '.$selected_effect[2].'>Flash</option>
				<option value=3 '.$selected_effect[3].'>Slide & Fade</option>
			</optgroup>';
			if($MainPicSelectedEffect<24) {
				$html_out.='
					<optgroup label="Pixar Effects">';
					for ($e=0;$e<count($DIAPO_EFFECTS);$e++) {
						$op_val=$e+4;
						$html_out.= '<option value='.$op_val.' '.$selected_effect[$op_val].'>'.$DIAPO_EFFECTS[$e].'</option>';
					}
				$html_out.='
				</optgroup>';
			}
			$html_out.='
			</select>
			</td>
		</tr>
		<tr style="display:'.$theme_show.'">
			<td>'.$ADMIN_TRANS['gallery type'].'</td>
			<td>
			<select id="gal_theme_page" style="direction:ltr">
			<option value=0 '.$selected_theme[0].'>Dots</option>
			<option value=1 '.$selected_theme[1].'>Classic</option>
			</select>
			</td>
		</tr>
		<tr>
		<td>'.$ADMIN_TRANS['slides speed'].'<br><small>(בשניות)</small></td><td><input type="text" maxlength="5" id="slide_speed_page" value='.$GAL_OPT[SlideSpeed].'></td>
		</tr>
		<tr>
		<tr>
		<td>'.$ADMIN_TRANS['slides delay'].'<br><small>(בשניות)</small></td><td><input type="text" maxlength="5" id="slide_delay_page" value='.$GAL_OPT[SlideDelay].'></td>
		</tr>
		<tr>
		<td>'.$ADMIN_TRANS['photo height'].' </td><td><input type="text" maxlength="4" id="gal_height_page" value='.$GAL_OPT[GalleryHeight].'><small>('.$ADMIN_TRANS['height in pixels'].')</small></td>
		</tr>
		<tr>
		<tr style="display:'.$num_slices_show.'">
		<td>'.$ADMIN_TRANS['slices'].'</td><td><input type="text" maxlength="4" id="num_slices_page" value='.$GAL_OPT[NumSlices].'></td>
		</tr>
		<tr>
		<td><input type="checkbox" id="gal_autoplay_page" style="border:0px" '.$auto_play.'>'.$ADMIN_TRANS['auto start'].'</td>
		</tr>
		<tr style="display:'.$show_side_text_cb.'">
		<td><input type="checkbox" id="is_product_gallery" style="border:0px" '.$product_gallery.'>'.$ADMIN_TRANS['show text right to images'].'</td>
		</tr>
		<tr>
		<td><input type="checkbox" id="is_order_bottom" style="border:0px" '.$isOrderBottom.'>'.$ADMIN_TRANS['order by first'].'</td>
		</td>
		</tr>
		
		</table>
		';
		return $html_out;
	}
	function isSlideGallery($urlKey) {
		if ($urlKey) {
			$PAGE_ID=GetIDFromUrlKey($urlKey);
			$pageID=$PAGE_ID[parentID];
		}
		$isSlide=false;
		$db=new Database();
		$db->query("SELECT GalleryType from galleries WHERE CatID='$pageID' AND GalleryType=4");
		if ($db->nextRecord()) {
			$GAL_PHOTOS=GetCatGallery($urlKey,4);
			if (count($GAL_PHOTOS[PhotoID])>0) $isSlide=true;
		}
		if (stristr($urlKey,"shop_product")) $isSlide=false;
		return $isSlide;
	}
	function isEffectGalleryPage($urlKey) {
		if ($urlKey) {
			$PAGE_ID=GetIDFromUrlKey($urlKey);
			$pageID=$PAGE_ID[parentID];
		}
		$isEffectGalPage=false;
		$db=new Database();
		$db->query("SELECT GalleryType from galleries WHERE CatID='$pageID' AND GalleryType=3");
		if ($db->nextRecord()) $isEffectGalPage=true;
		return $isEffectGalPage;
	}
	function GetCategoryByID($cID) {
		$db=new Database();
		$db->query("SELECT * from categories WHERE CatID='$cID'");
		$db->nextRecord();
		$numFields=$db->numFields();
		for ($fNum=0;$fNum<$numFields;$fNum++) {
				$fName=$db->getFieldName($fNum);
				$CATSETTING[$fName]=$db->getField($fNum);
			}
		
		return $CATSETTING;
	}
	function GetEmailText($emailID) {
		$db=new Database();
		$db->query("SELECT `emailText` FROM `email_texts` WHERE `emailID`='{$emailID}'");
		if($db->nextRecord())
			return $db->getField('emailText');
		return false;
	}
	function GetRedirects($sourceURL) {
		$sourceURL=addslashes($sourceURL);
		$db=new Database();
		$tmp_S=explode("/",$sourceURL);
		$lastFolder=$tmp_S[count($tmp_S)-2]."/*";

		$db->query("select * from redirects WHERE Source='$sourceURL' OR Source LIKE '%$lastFolder'");
		if ($db->nextRecord()) return ($db->getField("Destination"));
		else return false;
	}
	function ListRedirects($filter=0) {
		$db=new Database();
		$db->query("SELECT * from redirects ORDER BY Added DESC");
		$numFields=$db->numFields();
		$i=0;
		while ($db->nextRecord()) {
			for ($fNum=0;$fNum<$numFields;$fNum++) {
					$fName=$db->getFieldName($fNum);
					$R[$fName][$i]=$db->getField($fNum);
				}
				$i++;
		}
		return $R;
	}
	function GetCatStyle($AtributeName,$cID) {
		$db=new Database();
		$db->query("SELECT CatStylingOptions from categories WHERE CatID='$cID'");
		$db->nextRecord();
		$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
		$return_value=$CAT_STYLE[$AtributeName];
		return $return_value;
	}
	function GetGalleryAttribute($AtributeName,$galID) {
		$db=new Database();
		$db->query("SELECT GalleryOptions from galleries WHERE GalleryID='$galID'");
		$db->nextRecord();
		$GAL_ATTR=json_decode($db->getField("GalleryOptions"),true);
		$return_value=$GAL_ATTR[$AtributeName];
		return $return_value;
		
	}
	function CheckLeftColumnParent($cID) {
		$db=new Database();
		$db->query("SELECT CatStylingOptions,ParentID from categories WHERE CatID='$cID'");
		$db->nextRecord();
		$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
		$parent_cat=$db->getField("ParentID");
		$left_column_val=$CAT_STYLE["LeftColInherit"];
		$left_column_custom_width=$CAT_STYLE["LeftColWidth"];
		$left_column_custom_side=$CAT_STYLE["leftColSide"];
		while ($parent_cat!=0 AND $left_column_val!=1) {
			$db->query("SELECT CatStylingOptions,ParentID,CatID from categories WHERE CatID='$parent_cat'");
			$db->nextRecord();
			$parent_cat=$db->getField("ParentID");
			$c_id_parent=$db->getField("CatID");
			$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
			$left_column_val=$CAT_STYLE["LeftColInherit"];
			$left_column_custom_width=$CAT_STYLE["LeftColWidth"];
			$left_column_custom_side=$CAT_STYLE["leftColSide"];
		}
		$R[left_inherit]=$left_column_val;
		$R[parent_cat_id]=$c_id_parent;
		$R[custom_width]=$left_column_custom_width;
		$R[leftColSide]=$left_column_custom_side;
		return $R;
	}
	function CheckCatTopBottomContentParent($cID,$top_bottom) {
		$db=new Database();
		$db->query("SELECT CatStylingOptions,ParentID from categories WHERE CatID='$cID'");
		$db->nextRecord();
		$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
		$parent_cat=$db->getField("ParentID");
		$inherit_flag_cat_content=$CAT_STYLE["$top_bottom"];
		while ($parent_cat!=0 AND $inherit_flag_cat_content!=1) {
			$db->query("SELECT CatStylingOptions,ParentID,CatID from categories WHERE CatID='$parent_cat'");
			$db->nextRecord();
			$parent_cat=$db->getField("ParentID");
			$c_id_parent=$db->getField("CatID");
			$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
			$inherit_flag_cat_content=$CAT_STYLE["$top_bottom"];
		}
		$R[parent_cat_id]=$c_id_parent;
		$R[inherit_flag_cat_content]=$inherit_flag_cat_content;
		return $R;
		
	}
function GetTopHeaderBG($urlKEY) {
	$db=new Database();
	$tempUrlKey=$urlKEY;
	$parentID=1;
	$headerBGPic='';
	
	
	while ($headerBGPic=="" AND $parentID!=0) {
		$parURL_KEY=GetParentUrlKey($tempUrlKey);
		$parent_url_key=$parURL_KEY[ParentUrlKey];
		$sql="SELECT * from categories WHERE UrlKey='$parent_url_key'";
		$db->query($sql);
		$db->nextRecord();
		$parentID=$parURL_KEY[ParentID];
		$tempUrlKey=$parent_url_key;
		$headerBGPic=$db->getField("HeaderBGPhotoName");
	}
	
	return $headerBGPic;
}
function GetParentMainPicSideText($urlKEY) {
	$db=new Database();
	$tempUrlKey=$urlKEY;
	$parentID=1;
	$sideText='';
	while ($sideText=="" AND $parentID!=0) {

		$parURL_KEY=GetParentUrlKey($tempUrlKey);
		$parent_url_key=$parURL_KEY[ParentUrlKey];
		$parentID=$parURL_KEY[ParentID];
		$MAIN_PIC_SIDE_TEXT=GetPageTitle($parentID,"mainpic_side_text");
		
		$tempUrlKey=$parent_url_key;
		$sideText=$MAIN_PIC_SIDE_TEXT[Content];
	}
	if ($parentID==0 AND $sideText=="") $MAIN_PIC_SIDE_TEXT=GetPageTitle(1,"mainpic_side_text");
	return $MAIN_PIC_SIDE_TEXT;
}
function isParentMainPicSideTextDisabled($urlKEY) {
	$db=new Database();
	
	$tempUrlKey=$urlKEY;
	$parentID=1;
	$main_picSideText=0;
	while ($main_picSideText==0 AND $parentID!=0) {
		$parURL_KEY=GetParentUrlKey($tempUrlKey);
		$parent_url_key=$parURL_KEY[ParentUrlKey];
		$parentID=$parURL_KEY[ParentID];
		$db->query("SELECT MainPicSideText,ParentID from categories WHERE CatID='$parentID'");
		$db->nextRecord();
		
		$tempUrlKey=$parent_url_key;
		$main_picSideText=$db->getField("MainPicSideText");
	}
	return $main_picSideText;
}
function WrapEnglishText($myString) {
	if (preg_match_all('/([A-Za-z])+/', $myString, $occur)){
		$words = array_unique($occur[0]);
		foreach($words as $word){
			$myString = str_ireplace($word,'<span style="font-family:arial">'.$word.'</span>',$myString);
			}
		}
		return $myString;
}
function GetParentOverlayPic($pageID,$shopProductID=0) {
	$db=new Database();
	$PARENT_OVERLAY='';
	if ($shopProductID>0) $sql="SELECT OverlayPhotoName,OverlayPhotoHeight from categories WHERE CatID='$pageID' AND OverlayPhotoName!=''";
	else  {
		$parentURLKEY=GetCatUrlKeyFromPageID($pageID);
		$sql="SELECT OverlayPhotoName,OverlayPhotoHeight from categories WHERE UrlKey='$parentURLKEY' AND OverlayPhotoName!=''";	
	}
	$db->query($sql);
	if ($db->nextRecord()) {
		$PARENT_OVERLAY[OverlayPhotoName]=$db->getField("OverlayPhotoName");
		$PARENT_OVERLAY[OverlayPhotoHeight]=$db->getField("OverlayPhotoHeight");
	}
	return $PARENT_OVERLAY;
}
function GetGalleryAvaliableFilters($galID,$gal_filters) {
	$db=new Database();
	$ALL_FILTER=explode("|",$gal_filters);
	$RETURN_FILTERS=array();
	$b=0;
	for ($a=0;$a<count($ALL_FILTER);$a++) {
		$gal_filter_name=htmlspecialchars_decode($ALL_FILTER[$a]);
		
		$db->query("SELECT PhotoFilters FROM photos WHERE GalleryID='$galID' AND PhotoFilters LIKE '%$gal_filter_name%'");
		if ($db->nextRecord()) {
			$RETURN_FILTERS[$b]=$ALL_FILTER[$a];
			$b++;
		}
	}
	return $RETURN_FILTERS;
}
function CheckCatMainPicWidthParent($cID) {
		$db=new Database();
		$db->query("SELECT CatStylingOptions,ParentID from categories WHERE CatID='$cID'");
		$db->nextRecord();
		$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
		$parent_cat=$db->getField("ParentID");
		$MainPicWidthMode=$CAT_STYLE["MainPicWidthMode"];
		
		while ($parent_cat!=0 AND $MainPicWidthMode=="") {
			$db->query("SELECT CatStylingOptions,ParentID,CatID from categories WHERE CatID='$parent_cat'");
			$db->nextRecord();
			$parent_cat=$db->getField("ParentID");
			$c_id_parent=$db->getField("CatID");
			$CAT_STYLE=json_decode($db->getField("CatStylingOptions"),true);
			$MainPicWidthMode=$CAT_STYLE["MainPicWidthMode"];
			
		}
		$R[MainPicWidthMode]=$MainPicWidthMode;
		return $R;
}

function CheckMasterHeaderContent($urlKEY,$top_bottom_menu) {
		
		$tempUrlKey=$urlKEY;
		$parentID=1;
		$masterHeaderText='';
		while ($masterHeaderText=="" AND $parentID!=0) {
			$parURL_KEY=GetParentUrlKey($tempUrlKey);
			$parent_url_key=$parURL_KEY[ParentUrlKey];
			$parentID=$parURL_KEY[ParentID];
			$MASTER_HEADER_TEXT=GetPageTitle($parentID,$top_bottom_menu);
			
			$tempUrlKey=$parent_url_key;
			$masterHeaderText=$MASTER_HEADER_TEXT[Content];
		}
		return $MASTER_HEADER_TEXT;
}

function GetResolvedPerms($uID,$cID) {
	$userGranted=false;
	$db=new Database();
	$db->query("SELECT UID,CatID from users_perms WHERE UID='$uID' AND CatID='$cID'");
	if ($db->nextRecord()) $userGranted=true;
	$db->query("SELECT CategoryPerms from users WHERE UID='$uID'");
	$db->nextRecord();
	$catPerms=$db->getField("CategoryPerms");
	if ($catPerms==0) $userGranted=true;
	return $userGranted;
}

function LogAction($obID,$obName,$obDataName,$tableName,$restorable=0,$describtion="",$action="") {
	global $MEMBER;
	$db=new database();
	$db->query("DELETE from `backlog` WHERE Modified< (NOW() - INTERVAL 4 DAY)");
	$admin_name=$MEMBER[Email];
	$sql="SELECT $obDataName from $tableName WHERE ".$obName."='$obID'";
	$db->query($sql);
	if ($db->nextRecord()) {
		$data=$db->getField("$obDataName");
		$sql_backlog="INSERT INTO backlog SET ObjectID='$obID', Content='$data', TableName='$tableName',AdminName='$admin_name', TableFieldName='$obDataName', Restorable='$restorable', Description='$describtion', Action='$action'";
		$db->query($sql_backlog);
	}
}