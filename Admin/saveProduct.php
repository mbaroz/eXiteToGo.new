<?
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type:text/html; charset=UTF-8");
include_once("../config.inc.php");
require_once('../inc/ProductsShop.inc.php');
include_once("AmazonUtil.php");

if (!isset($_SESSION['LOGGED_ADMIN']))
	die;
	
function GenerateUrlKey($MenuTitle) {
	$NewMenuTitle=strip_tags($MenuTitle);
	$NewMenuTitle=str_ireplace("?","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("&","and",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("%","",$NewMenuTitle);
	$NewMenuTitle=trim($NewMenuTitle);
	$NewMenuTitle=str_ireplace("  "," ",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("   "," ",$NewMenuTitle);
	$NewMenuTitle=str_ireplace(".","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("/","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace('"',"",$NewMenuTitle);
	$NewMenuTitle=stripslashes($NewMenuTitle);
	$NewMenuTitle=stripcslashes($NewMenuTitle);
	$NewMenuTitle=str_ireplace("'","",$NewMenuTitle);
	$NewMenuTitle=str_ireplace(" - ","-",$NewMenuTitle);
	$NewMenuTitle=str_ireplace("- ","-",$NewMenuTitle);
	$NewMenuTitle=str_ireplace(" -","-",$NewMenuTitle);
	$SuggestedUrlKey=strtolower(str_ireplace(" ","-",$NewMenuTitle));

	$db=new Database();

	$db->query("SELECT `ProductID` from `products` WHERE `UrlKey`='{$SuggestedUrlKey}'");
	
	$counter = 0;
	$origKey = $SuggestedUrlKey;
	
	while ($db->nextRecord()) {
		$counter++;
		$SuggestedUrlKey=$origKey."-".$counter;
		$db->query("SELECT `ProductID` from `products` WHERE `UrlKey`='{$SuggestedUrlKey}'");
	}
	
	$NewUrlKey=$SuggestedUrlKey;
	
	return strtolower($NewUrlKey);
}

function image_resize($img,$destIMG,$w,$h,$crop){
	global $AWS_S3_ENABLED;
	global $SITE;
	$now_size = getimagesize($img);
	if($now_size[0] > $w || $now_size[1] > $h)
	{
		if($AWS_S3_ENABLED){
			
			if ($crop) {
				$src_ARRAY=explode("/", $img);
				$t_src="tumb_".end($src_ARRAY);
				$img=str_ireplace(end($src_ARRAY), $t_src, $img);
			}

			$destIMG=str_ireplace("..", "", $destIMG);
			BigPhotoConvertToAmazon($img, $w, $h, $destIMG, 95,$crop);
		}
		else{
			$newRes=$w. 'x'. $h;
			$cr=system("convert {$img} -resize {$newRes} -quality 100 {$destIMG} 2>&1",$retval);
		}
		//var_dump($retval);die;
		
	}
	else{
		if($AWS_S3_ENABLED){
			$destIMG=str_ireplace("..", "", $destIMG);
			UploadToAmazon($img,"exitetogo/".$SITE['S3_FOLDER'].$destIMG);
		}
		else{
			copy($img,$destIMG);
		}
	}
	return true;
}
/*
	Handles the delete process for images, supports amazon hosting.
*/
function DeletePhoto($destPrefix, $destPath){
	global $SITE;
	global $AWS_S3_ENABLED;

	if($AWS_S3_ENABLED){
		DeleteImageFromAmazon("/".$destPath);
	}
	else{
		unlink($destPrefix.$destPath);
	}
}

/*
function image_resize($src, $dst, $width, $height, $crop = false){

  if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";

  $type = strtolower(substr(strrchr($src,"."),1));
  if($type == 'jpeg') $type = 'jpg';
  switch($type){
    case 'bmp': $img = imagecreatefromwbmp($src); break;
    case 'gif': $img = imagecreatefromgif($src); break;
    case 'jpg': $img = imagecreatefromjpeg($src); break;
    case 'png': $img = imagecreatefrompng($src); break;
    default : return "Unsupported picture type!";
  }

  // resize
  if($crop){
    if($w < $width or $h < $height) 
    {
    	if($src != $dst)
    		@unlink($dst);
    	copy($src,$dst);
    	return true;
    }
    $ratio = max($width/$w, $height/$h);
    $h = $height / $ratio;
    $x = ($w - $width / $ratio) / 2;
    $w = $width / $ratio;
  }
  else{
    if($w < $width and $h < $height)
    {
    	if($src != $dst)
    		@unlink($dst);
    	copy($src,$dst);
    	return true;
    }
    
    if($width > $height)
    	$ratio = $width/$w;
    else
    	$ratio = $height/$h;
    	
    $width = $w * $ratio;
    $height = $h * $ratio;
    $x = 0;
  }

  $new = imagecreatetruecolor($width, $height);

  // preserve transparency
  if($type == "gif" or $type == "png"){
    imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
    imagealphablending($new, false);
    imagesavealpha($new, true);
  }

  imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

  $type = strtolower(substr(strrchr($dst,"."),1));
  if($type == 'jpeg')
  	$type = 'jpg';
	@unlink($dst);
  switch($type){
    case 'bmp': imagewbmp($new, $dst); break;
    case 'gif': imagegif($new, $dst); break;
    case 'jpg': imagejpeg($new, $dst,100); break;
    case 'png': imagepng($new, $dst); break;
  }
  return true;
}
*/

$db=new Database();

$action = (isset($_POST['action'])) ? $_POST['action'] : $_GET['action'];
$gallery_dir=$SITE_LANG[dir].$gallery_dir;
switch($action)
{
	case 'saveRichText':
		$_POST['richText'] = addslashes(urldecode($_POST['richText']));
		$db->query("
			UPDATE
				`products`
			SET
				`ProductDescription`='{$_POST['richText']}'
			WHERE
				`ProductID` = '{$_POST['ProductID']}'
		");
		break;
	case 'addRichText':
		if(@$_POST['ProductID'] > 0)
		{
			$db->query("
				SELECT
					*
				FROM
					`products`
				WHERE
					`ProductID` = '{$_POST['ProductID']}'
			");
			$db->nextRecord();
			$item = $db->record;
			
			$db->query("
				UPDATE
					`products`
				SET
					`ProductOrder`=`ProductOrder`+1
				WHERE
					`ProductOrder` > '{$item['order']}'
				AND
					`ParentID` = '{$item['ParentID']}'
			");
			
			$torder = $item['order']+1;
			$ParentID = $item['ParentID'];
		}
		elseif(@$_POST['urlKey'] != '')
		{
			$PAGE_ID = GetIDFromUrlKey($_POST['urlKey']);
			$ParentID = $PAGE_ID['parentID'];
			$torder = 0;
			$db->query("
				UPDATE
					`products`
				SET
					`ProductOrder`=`ProductOrder`+1
				WHERE
					`ParentID` = '{$ParentID}'
			");
		}
		
		$text = addslashes(urldecode(@$_POST['richText']));
		
		$db->query("
			INSERT INTO
				`products`
			SET
				`ProductOrder`='{$torder}',
				`ParentID`='{$ParentID}',
				`ViewStatus` = '1',
				`ProductDescription` = '{$text}',
				`UrlKey` = '',
				`richText` = '1'
		");
		break;
	case 'addCatAttribute':
		$PAGE_ID=GetIDFromUrlKey($_POST['urlKey']);
		$categoryID=$PAGE_ID['parentID'];
		if($_POST['AttributeName'] != '')
		{
			$db->query("
				INSERT INTO
					`categories_attributes`
				SET
					`CatID` = '{$categoryID}',
					`AttributeName` = '{$_POST['AttributeName']}'
			");
			echo mysql_insert_id();
		}	
		break;
	case 'addCatAttributeValue':
		$AttributeID = intval($_POST['AttributeID']);
		if($_POST['ValueName'] != '')
		{
			$db->query("INSERT INTO `categories_attributes_values`(`AttributeID`,`ValueName`) VALUES('{$AttributeID}','{$_POST['ValueName']}')");
			echo mysql_insert_id();
		}	
		break;
	case 'renameCatAttribute':
		$AttributeID = intval(str_replace('attribute_','',$_POST['id']));
		if($AttributeID > 0 && $_POST['value'] != '')
			$db->query("UPDATE `categories_attributes` SET `AttributeName`='{$_POST['value']}' WHERE `AttributeID`='{$AttributeID}'");
		echo $_POST['value'];
		break;
	case 'renameCatAttributeValue':
		$ValueID = intval(str_replace('value_','',$_POST['id']));
		if($ValueID > 0 && $_POST['value'] != '')
			$db->query("UPDATE `categories_attributes_values` SET `ValueName`='{$_POST['value']}' WHERE `ValueID`='{$ValueID}'");
		echo $_POST['value'];
		break;
	case 'changeCatAttributeValuePrice':
		$ValueID = intval(str_replace('value_price_','',$_POST['id']));
		if($ValueID > 0 && $_POST['value'] != '')
			$db->query("UPDATE `categories_attributes_values` SET `price_effect`='".floatval($_POST['value'])."' WHERE `ValueID`='{$ValueID}'");
		echo $_POST['value'];
		break;
	case 'delCatAttribute':
		$AttributeID = intval($_POST['AttributeID']);
		if($AttributeID > 0)
		{
			$db->query("DELETE FROM `categories_attributes` WHERE `AttributeID` = '{$AttributeID}'");
			$db->query("DELETE FROM `items_attributes` WHERE `AttributeID` = '{$AttributeID}'");
			$db->query("DELETE FROM `categories_attributes_values` WHERE `AttributeID` = '{$AttributeID}'");
		}
		break;
	case 'delCatAttributeValue':
		$ValueID = intval($_POST['ValueID']);
		if($ValueID > 0)
		{
			$db->query("DELETE FROM `items_attributes` WHERE `ValueID` = '{$ValueID}'");
			$db->query("DELETE FROM `categories_attributes_values` WHERE `ValueID` = '{$ValueID}'");
		}
		break;
	case 'saveRelated':
		$ProductID = intval($_POST['ProductID']);
		if($ProductID > 0)
		{
			$db->query("DELETE FROM `products_related` WHERE `ProductID` = '{$ProductID}'");
			if(count($_POST['related']) > 0)
			{
				$insert = "INSERT INTO `products_related`(`ProductID`,`RelatedProductID`) VALUES";
				foreach($_POST['related'] as $relID)
				{
					$insert .= "('{$ProductID}','{$relID}'),";
				}
				$insert = substr($insert, 0, -1);
				$db->query($insert);
			}
		}
		break;
	case 'saveAttributes':
		$ProductID = intval($_POST['ProductID']);
		if($ProductID > 0)  $db->query("DELETE FROM `items_attributes` WHERE `ProductID` = '{$ProductID}'");
		if($ProductID > 0 && count($_POST['values']))
		{
			$db->query("DELETE FROM `items_attributes` WHERE `ProductID` = '{$ProductID}'");
			$sql_vals = 'INSERT INTO `items_attributes`(`ProductID`,`AttributeID`,`ValueID`) VALUES';
			foreach($_POST['values'] as $v_data)
			{
				$v_data = explode(':',$v_data);
				$sql_vals .= "('{$ProductID}','{$v_data[0]}','{$v_data[1]}'),";
			}
			$sql_vals = substr($sql_vals,0,-1);
			$db->query($sql_vals);
		}
		if($ProductID > 0)
		{
			if($_POST['defaultProduct'] == 1)
			{
				$db->query("
				UPDATE
					`products`
				SET
					`defaultProduct`='0'");
			}
			
			$_POST['urlkey'] = preg_replace('/[^0-9a-zA-Zא-ת\-_\.\(\)\+:&]/','', str_replace(' ','-',$_POST['urlkey']));
			$db->query("
				UPDATE
					`products`
				SET
					`ViewStatus` = '{$_POST['ViewStatus']}',
					`featured` = '{$_POST['featured']}',
					`galleryEffect` = '{$_POST['galleryEffect']}',
					`effectID` = '{$_POST['effectID']}',
					`galleryTheme` = '{$_POST['galleryTheme']}',
					`galleryAside` = '{$_POST['galleryAside']}',
					`quantity` = '{$_POST['quantity']}',
					`UrlKey`='{$_POST['urlkey']}',
					`noBigPics`='{$_POST['noBigPics']}',
					`picsZoom`='{$_POST['picsZoom']}',
					`mainPicNotShown`='{$_POST['mainPicNotShown']}',
					`specialAttrsTable`='{$_POST['specialAttrsTable']}',
					`defaultProduct`='{$_POST['defaultProduct']}',
					`onSale`='{$_POST['onSale']}'
				WHERE
					`ProductID` = '{$ProductID}'");
			
			echo $_POST['urlkey'];
		}
		break;
	case 'saveCatSettings':
		$centeredTitle = intval($_POST['centeredTitle']);
		$roundedCorners = intval($_POST['roundedCorners']);
		$galleryEffekts = intval($_POST['galleryEffekts']);
		$productMargin = intval($_POST['productMargin']);
		$productHMargin = intval($_POST['productHMargin']);
		$ContentPhotoWidth = intval($_POST['ContentPhotoWidth']);
		$ContentPhotoHeight = intval($_POST['ContentPhotoHeight']);
		$ContentPagePhotoWidth = intval($_POST['ContentPagePhotoWidth']);
		$ContentPagePhotoHeight = intval($_POST['ContentPagePhotoHeight']);
		$new_addition_order = intval($_POST['NewAddOrder']);
		$GalleryHeight = intval($_POST['GalleryHeight']);
		$GalleryWidth = intval($_POST['GalleryWidth']);
		$options = json_encode(array('NewAddOrder' => $new_addition_order,'GalleryHeight' => $GalleryHeight,'GalleryWidth' => $GalleryWidth,'ContentPhotoWidth' => $ContentPhotoWidth,'ContentPhotoHeight' => $ContentPhotoHeight,'ContentPagePhotoWidth' => $ContentPagePhotoWidth,'ContentPagePhotoHeight' => $ContentPagePhotoHeight,'productMargin' => $productMargin,'productHMargin' => $productHMargin,'roundedCorners' => $roundedCorners,'galleryEffekts' => $galleryEffekts,'centeredTitle' => $centeredTitle));
		$PAGE_ID=GetIDFromUrlKey($_POST['urlKey']);
		$categoryID=$PAGE_ID['parentID'];
		$db->query("UPDATE `categories` SET `shopOptions`='{$options}' WHERE `CatID`='{$categoryID}'");
		break;
	case 'addPics':
		$ProductID = intval($_POST['ProductID']);
		$catID = intval($_POST['catID']);
		
		$PAGE_ID = GetIDFromUrlKey($catID,true);
		
		$thumbWidth = ($PAGE_ID['shopOptions']['ContentPhotoWidth'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoWidth'] : $SITE[productPicWidth];
		$thumbHeight = ($PAGE_ID['shopOptions']['ContentPhotoHeight'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoHeight'] : $SITE[productPicHeight];
		
		//$thumbWidth = ($SITE[productPicWidth] > 0) ? $SITE[productPicWidth] : $SITE[galleryphotowidth];
		//$thumbHeight = ($SITE[productPicHeight] > 0) ? $SITE[productPicHeight] : $SITE[galleryphotoheight];
		
		if($ProductID > 0)
		{
			$db->query("SELECT `ProductPhotoName`,`more_pics` FROM `products` WHERE `ProductID`='{$ProductID}'");
			if($db->nextRecord())
			{
				$add_sql = '';
				if(!$more_pics = unserialize($db->getField('more_pics')))
					$more_pics = array();
				if($db->getField('ProductPhotoName') != '')
					array_unshift($more_pics,$db->getField('ProductPhotoName'));
				$placeToInsert = count($more_pics);
				if($_POST['delPic'] != '')
				{
					$new_more_pics = array();
					foreach($more_pics as $i => $pic_name)
						if($pic_name != $_POST['delPic']){
							$new_more_pics[] = $pic_name;
						}
						else
						{
							DeletePhoto('../',$gallery_dir.'/products/'.$pic_name);
							// @unlink('../'.$gallery_dir.'/products/'.$pic_name);
							DeletePhoto('../',$gallery_dir.'/products/thumb_'.$pic_name);
							// @unlink('../'.$gallery_dir.'/products/thumb_'.$pic_name);
							$placeToInsert = $i;
						}
					$more_pics = $new_more_pics;
				}
				$new_more_pics = array();
				for($i = 0;$i < $placeToInsert;$i++)
					$new_more_pics[] = $more_pics[$i];
				$leftPics = $placeToInsert;
				foreach($_POST['more_pics'] as $pic_name)
				{
					$src = 'uploader/uploads/'.$pic_name;
					$dst = '../'.$gallery_dir.'/products/'.$pic_name;
					$dst_thumb = '../'.$gallery_dir.'/products/thumb_'.$pic_name;
					//rename($src,$dst);
					if(image_resize($src,$dst_thumb,$thumbWidth,$thumbHeight,1))
					{

						$new_more_pics[] = $pic_name;
						image_resize($src,$dst,760,540,0);
						DeletePhoto($src);
						// unlink($src);
						
					}
				}
				for($i = $leftPics;$i < count($more_pics);$i++)
					$new_more_pics[] = $more_pics[$i];
				$more_pics = $new_more_pics;
				$photo_name = '';
				if(count($more_pics) > 0)
					$photo_name = array_shift($more_pics);
				$more_pics = serialize($more_pics);
				$db->query("UPDATE `products` SET `ProductPhotoName`='{$photo_name}',`more_pics` = '{$more_pics}' WHERE `ProductID`='{$ProductID}'");
			}
		}
		break;
	case 'sortPics':
		$ProductID = intval($_POST['ProductID']);
		
		$pics = $_POST;
		array_shift($pics);
		array_shift($pics);
		$pics = array_keys($pics);
				
		if($ProductID > 0)
		{
			$photo_name = array_shift($pics);
			$photo_name = base64_decode($photo_name);
			if(strtolower(substr($photo_name,-4)) != '.jpg' && strtolower(substr($photo_name,-4)) != '.gif' && strtolower(substr($photo_name,-4)) != '.png' && strtolower(substr($photo_name,-5)) != '.jpeg')
				$photo_name = '';
			$more_pics = array();
			foreach($pics as $pic)
			{
				$pic = base64_decode($pic);
				if(strtolower(substr($pic,-4)) == '.jpg' || strtolower(substr($pic,-4)) == '.gif' || strtolower(substr($pic,-4)) == '.png' || strtolower(substr($pic,-4)) == '.jpeg')
					$more_pics[] = $pic;
			}
			$more_pics = serialize($more_pics);
			$db->query("UPDATE `products` SET `ProductPhotoName`='{$photo_name}',`more_pics`='{$more_pics}' WHERE `ProductID`='{$ProductID}'");
		}
		break;
	case 'delMainPic':
		$ProductID = intval($_POST['ProductID']);
		$picName = $_POST['picName'];
		if($ProductID > 0 && $picName != '')
		{
			$db->query("SELECT `ProductPhotoName`,`more_pics` FROM `products` WHERE `ProductID`='{$ProductID}'");
			if($db->nextRecord())
			{
				DeletePhoto('../',$gallery_dir.'/products/'.$picName);
				// @unlink('../'.$gallery_dir.'/products/'.$picName);
				DeletePhoto('../',$gallery_dir.'/products/thumb_'.$picName);
				// @unlink('../',$gallery_dir.'/products/thumb_'.$picName);
				$more_pics = unserialize($db->getField('more_pics'));
				$main_pic  = (count($more_pics) > 0) ? array_shift($more_pics) : '';
				$more_pics = (count($more_pics) > 0) ? serialize($more_pics) : '';
				$db->query("UPDATE `products` SET `ProductPhotoName`='{$main_pic}',`more_pics`='{$more_pics}' WHERE `ProductID`='{$ProductID}'");
			}
		}
		break;
	case 'delMorePic':
		$ProductID = intval($_POST['ProductID']);
		$picName = $_POST['picName'];
		if($ProductID > 0 && $picName != '')
		{
			$db->query("SELECT `more_pics` FROM `products` WHERE `ProductID`='{$ProductID}' AND `more_pics` != ''");
			if($db->nextRecord())
			{
				$more_pics = unserialize($db->getField('more_pics'));
				$new_more_pics = array();
				foreach($more_pics as $pic)
				{
					if($pic == $picName)
					{
						DeletePhoto('../',$gallery_dir.'/products/'.$pic);
						// @unlink('../'.$gallery_dir.'/products/'.$pic);
						DeletePhoto('../',$gallery_dir.'/products/thumb_'.$pic);
						// @unlink('../'.$gallery_dir.'/products/thumb_'.$pic);
					}
					else
						$new_more_pics[] = $pic;
				}
				$mpics = serialize($new_more_pics);
				$db->query("UPDATE `products` SET `more_pics`='{$mpics}' WHERE `ProductID`='{$ProductID}'");
			}
		}
		break;
	case 'addMass':
		$PAGE_ID=GetIDFromUrlKey($_POST['urlKey']);
		$categoryID=$PAGE_ID['parentID'];
		$db->query("SELECT `shopOptions` FROM `categories` WHERE `CatID`='{$categoryID}'");
		$db->nextRecord();
		$catOptions = json_decode($db->getField('shopOptions'),true);
		
		if($catOptions['NewAddOrder'] == 1)
		{
			$db->query("SELECT MAX(`ProductOrder`) as `max` FROM `products` WHERE `ParentID`='{$categoryID}'");
			$db->nextRecord();
			$max = $db->getField('max');
		}
		
		$thumbWidth = ($PAGE_ID['shopOptions']['ContentPhotoWidth'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoWidth'] : $SITE[productPicWidth];
		$thumbHeight = ($PAGE_ID['shopOptions']['ContentPhotoHeight'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoHeight'] : $SITE[productPicHeight];
		
		$more_pics = array();
		foreach($_POST['more_pics'] as $pic_name)
		{
			$ex = explode(':-=-:',$pic_name);
			$pic_name = $ex[0];
			$eo_name = explode('.',$ex[1]);
			array_pop($eo_name);
			$original_name = implode('.',$eo_name);
			$src = 'uploader/uploads/'.$pic_name;
			$dst = '../'.$gallery_dir.'/products/'.$pic_name;
			$dst_thumb = '../'.$gallery_dir.'/products/thumb_'.$pic_name;
			//rename($src,$dst);
			if(image_resize($src,$dst_thumb,$thumbWidth,$thumbHeight,1))
			{
				$more_pics[] = array('file' => $pic_name,'name' => $original_name);
				image_resize($src,$dst,760,540,0);
				DeletePhoto($src);
				// unlink($src);
			}
		}
		$sql_vals = '';
		if(count($_POST['values']) > 0)
		{
			foreach($_POST['values'] as $v_data)
			{
				$v_data = explode(':',$v_data);
				$sql_vals .= "('%%product_id%%','{$v_data[0]}','{$v_data[1]}'),";
			}
			$sql_vals = substr($sql_vals,0,-1);
		}
		$ViewStatus = ($_POST['ViewStatus'] == 1) ? 1 : 0;
		$featured = ($_POST['featured'] == 1) ? 1 : 0;
		if(trim($_POST['ProductDescription']) == '')
		{
			if($default = GetDefaultProduct())
				$_POST['ProductDescription'] = $default['ProductDescription'];
		}
		foreach($more_pics as $pic)
		{
			if($catOptions['NewAddOrder'] == 1)
			{
				$max++;
				$order = $max;
			}
			else
				$order = 0;
				
			$urlKey = GenerateUrlKey($pic['name']);
			$db->query("
				INSERT INTO
					`products`
				SET
					`ProductOrder`='{$order}',
					`ProductTitle`='{$pic['name']}',
					`ProductShortDesc`='{$_POST['ProductShortDesc']}',
					`ProductPhotoName`='{$pic['file']}',
					`ProductPrice`='{$_POST['ProductPrice']}',
					`discountPrice`='{$_POST['discountPrice']}',
					`ParentID`='{$categoryID}',
					`PublishDate`=NOW(),
					`ViewStatus` = '{$ViewStatus}',
					`featured` = '{$featured}',
					`ProductDescription` = '{$_POST['ProductDescription']}',
					`UrlKey` = '{$urlKey}',
					`galleryEffect` = '{$_POST['galleryEffect']}',
					`effectID` = '{$_POST['effectID']}',
					`galleryTheme` = '{$_POST['galleryTheme']}',
					`galleryAside` = '{$_POST['galleryAside']}',
					`quantity` = '{$_POST['quantity']}',
					`picsZoom` = '{$_POST['picsZoom']}',
					`mainPicNotShown` = '{$_POST['mainPicNotShown']}'
				");
			$ProductID = mysql_insert_id();
			if($sql_vals != '')
				$db->query('INSERT INTO `items_attributes`(`ProductID`,`AttributeID`,`ValueID`) VALUES'.str_replace('%%product_id%%',$ProductID,$sql_vals));
		}
		break;
	case 'saveMainPic':
		if(count($_POST['more_pics']) > 0)
		{
			$ProductID = intval($_POST['ProductID']);
			$db->query("
				SELECT
					`products`.*
				FROM
					`products`
				WHERE
					`products`.`ProductID` = '{$ProductID}'
			");
			$db->nextRecord();
			$product = $db->record;
			
			$PAGE_ID = GetIDFromUrlKey($product['ParentID'],true);
			
			$thumbWidth = ($PAGE_ID['shopOptions']['ContentPhotoWidth'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoWidth'] : $SITE[productPicWidth];
			$thumbHeight = ($PAGE_ID['shopOptions']['ContentPhotoHeight'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoHeight'] : $SITE[productPicHeight];
			$pic_name = array_pop($_POST['more_pics']);
			$src = 'uploader/uploads/'.$pic_name;

			$dst = '../'.$gallery_dir.'/products/'.$pic_name;
			$dst_thumb = '../'.$gallery_dir.'/products/thumb_'.$pic_name;
			//rename($src,$dst);
			if(image_resize($src,$dst_thumb,$thumbWidth,$thumbHeight,1))
			{
				//$more_pics[] = $pic_name;
				image_resize($src,$dst,760,540,0);
				DeletePhoto($src);
				// unlink($src);
				$db->query("
					UPDATE
						`products`
					SET
						`ProductPhotoName`='{$pic_name}'
					WHERE
						`ProductID` = '{$ProductID}'
				");
			}
		}
		break;
	case 'add':
		$PAGE_ID=GetIDFromUrlKey($_POST['urlKey']);
		$categoryID=$PAGE_ID['parentID'];
		$db->query("SELECT `shopOptions` FROM `categories` WHERE `CatID`='{$categoryID}'");
		$db->nextRecord();
		$catOptions = json_decode($db->getField('shopOptions'),true);
		
		if($catOptions['NewAddOrder'] == 1)
		{
			$db->query("SELECT MAX(`ProductOrder`) as `max` FROM `products` WHERE `ParentID`='{$categoryID}'");
			$db->nextRecord();
			$max = $db->getField('max');
		}
		
		$thumbWidth = ($PAGE_ID['shopOptions']['ContentPhotoWidth'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoWidth'] : $SITE[productPicWidth];
		$thumbHeight = ($PAGE_ID['shopOptions']['ContentPhotoHeight'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoHeight'] : $SITE[productPicHeight];
		
		$productID = (isset($_POST['ProductID'])) ? intval($_POST['ProductID']) : 0;
		
		$ViewStatus = ($_POST['ViewStatus'] == 1) ? 1 : 0;
		$featured = ($_POST['featured'] == 1) ? 1 : 0;
		$more_pics = array();
		foreach($_POST['more_pics'] as $pic_name)
		{
			$src = 'uploader/uploads/'.$pic_name;
			$dst = '../'.$gallery_dir.'/products/'.$pic_name;
			$dst_thumb = '../'.$gallery_dir.'/products/thumb_'.$pic_name;
			//rename($src,$dst);
			if(image_resize($src,$dst_thumb,$thumbWidth,$thumbHeight,1))
			{
				$more_pics[] = $pic_name;
				image_resize($src,$dst,760,540,0);
				DeletePhoto($src);
				// unlink($src);
			}
		}
		
		$main_pic = (count($more_pics) > 0) ? array_shift($more_pics) : '';
		
		$more_pics = (count($more_pics) > 0) ? serialize($more_pics) : '';
		
		if ($productID == 0)
		{
			if($catOptions['NewAddOrder'] == 1)
			{
				$max++;
				$order = $max;
			}
			else
				$order = 0;
			$urlKey = GenerateUrlKey($_POST['ProductName']);
			if(trim($_POST['ProductDescription']) == '')
			{
				if($default = GetDefaultProduct())
					$_POST['ProductDescription'] = $default['ProductDescription'];
			}
			$db->query("
				INSERT INTO
					`products`
				SET
					`ProductOrder`='{$order}',
					`ProductTitle`='{$_POST['ProductName']}',
					`ProductShortDesc`='{$_POST['ProductShortDesc']}',
					`ProductPhotoName`='{$main_pic}',
					`ProductPrice`='{$_POST['ProductPrice']}',
					`discountPrice`='{$_POST['discountPrice']}',
					`ParentID`='{$categoryID}',
					`PublishDate`=NOW(),
					`ViewStatus` = '{$ViewStatus}',
					`featured` = '{$featured}',
					`ProductDescription` = '{$_POST['ProductDescription']}',
					`UrlKey` = '{$urlKey}',
					`more_pics` = '{$more_pics}',
					`galleryEffect` = '{$_POST['galleryEffect']}',
					`effectID` = '{$_POST['effectID']}',
					`galleryTheme` = '{$_POST['galleryTheme']}',
					`galleryAside` = '{$_POST['galleryAside']}',
					`quantity` = '{$_POST['quantity']}',
					`picsZoom` = '{$_POST['picsZoom']}',
					`mainPicNotShown` = '{$_POST['mainPicNotShown']}'
				");
			$ProductID = mysql_insert_id();
			if(count($_POST['values']) > 0)
			{
				$sql_vals = 'INSERT INTO `items_attributes`(`ProductID`,`AttributeID`,`ValueID`) VALUES';
				foreach($_POST['values'] as $v_data)
				{
					$v_data = explode(':',$v_data);
					$sql_vals .= "('{$ProductID}','{$v_data[0]}','{$v_data[1]}'),";
				}
				$sql_vals = substr($sql_vals,0,-1);
				$db->query($sql_vals);
			}
		}
		break;
	case 'editParameter':
		$ProductID = (isset($_POST['ProductID'])) ? intval($_POST['ProductID']) : intval($_GET['ProductID']);
		if($ProductID < 1)
		{
			$ex = explode('-',$_POST['id']);
			$ProductID = intval($ex[1]);
			$_POST['id'] = $ex[0];
		}
		if($_POST['id'] == 'ProductShortDesc') $_POST['value']=htmlentities($_POST['value'],ENT_QUOTES,"UTF-8");
		if($ProductID > 0) {
			$db->query("
				UPDATE
					`products`
				SET
					`{$_POST['id']}` = '{$_POST['value']}'
				WHERE
					`ProductID` = '{$ProductID}'
			");
			/* if ($_POST['id']=="ProductTitle") {
				$newUrlKey=GenerateUrlKey($_POST['value']);
				$db->query("UPDATE products SET UrlKey='$newUrlKey' WHERE ProductID='$ProductID'");
			} */
		}
		if($_POST['id'] == 'ProductShortDesc')
			{
				$_POST['value'] = nl2br($_POST['value']);

			}

		echo stripslashes($_POST['value']);
		break;
	case 'delete':
		$db->query("SELECT `more_pics` FROM `products` WHERE `ProductID` = '{$_POST['ProductID']}' AND `more_pics` != ''");
		if($db->nextRecord())
		{
			$more_pics = unserialize($db->getField('more_pics'));
			foreach($more_pics as $pic)
			{
				DeletePhoto('../',$gallery_dir.'/products/'.$pic);
				DeletePhoto('../',$gallery_dir.'/products/thumb_'.$pic);
				// @unlink('../'.$gallery_dir.'/products/'.$pic);
				// @unlink('../'.$gallery_dir.'/products/thumb_'.$pic);
			}
		}
		// @unlink('../'.$gallery_dir.'/products/'.$_POST['ProductPhotoName']);
		DeletePhoto('../',$gallery_dir.'/products/'.$_POST['ProductPhotoName']);
		// @unlink('../'.$gallery_dir.'/products/thumb_'.$_POST['ProductPhotoName']);
		DeletePhoto('../',$gallery_dir.'/products/thumb_'.$_POST['ProductPhotoName']);
		$db->query("DELETE FROM `products` WHERE `ProductID`='{$_POST['ProductID']}'");
		$db->query("DELETE FROM `items_attributes` WHERE `ProductID`='{$_POST['ProductID']}'");
		break;
	case 'saveOrder':
		foreach($_POST['short_cell'] as $i => $ProductID)
			$db->query("UPDATE `products` SET `ProductOrder`='{$i}' WHERE `ProductID`='{$ProductID}'");
		break;
}

?>