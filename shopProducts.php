<?
require_once 'inc/ProductsShop.inc.php';

$gallery_dir=$SITE_LANG[dir].$gallery_dir;
$PAGE_ID = GetIDFromUrlKey($urlKey);
global $SHOP_TRANS;
$thumbWidth = ($PAGE_ID['shopOptions']['ContentPhotoWidth'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoWidth'] : $SITE[productPicWidth];
$thumbHeight = ($PAGE_ID['shopOptions']['ContentPhotoHeight'] > 0) ? $PAGE_ID['shopOptions']['ContentPhotoHeight'] : $SITE[productPicHeight];

$nolimit = false;
if (isset($_SESSION['LOGGED_ADMIN']) && isset($_GET['allitemsinpage']))
	$nolimit=true;
?>
<script language="javascript">
cType=0;
</script>
<style type="text/css">
.round_bottom {
	display:none;
}


#boxes  {
		font-family: Arial, sans-serif;
		list-style-type: none;
		margin: 0px;
		padding: 0px;
		width: 100%;
}
#boxes li {
		margin: 5px 5px 5px 5px;
		border: 0px solid silver;
		padding: 1px;
}


#boxes_products  {
		visibility: hidden;
		font-family: inherit;
		list-style-type: none;
		margin: 0px;
		padding: 0px;
		width: 100%;
}
#boxes_products.show{visibility: visible;}
.loader_products {display: block;width:100%;font-size: 30px;color:#333;text-align: center;}
.loader_products.hide{display: none}
<?
$borderMinus = ($SITE[shopSingleItemBorderColor] == '') ? 0 : -2;
?>
#boxes_products li {
		margin-left: <?=($CHECK_CATPAGE['shopOptions']['productMargin'] > 0) ? round($CHECK_CATPAGE['shopOptions']['productMargin']/2) : '5';?>px;
		margin-right: <?=($CHECK_CATPAGE['shopOptions']['productMargin'] > 0) ? round($CHECK_CATPAGE['shopOptions']['productMargin']/2) : '5';?>px;
		margin-top:<?=($CHECK_CATPAGE['shopOptions']['productHMargin'] > 0) ? '0' : '5';?>px;
		margin-bottom:<?=($CHECK_CATPAGE['shopOptions']['productHMargin'] > 0) ? $CHECK_CATPAGE['shopOptions']['productHMargin'] : '5';?>px;
		float:<?=$SITE[align];?>;
		width:<?=$thumbWidth+16+$borderMinus;?>px;
		position: relative;
		overflow:hidden;
		<? if($SITE[shopSingleItemBorderColor] != ''){ ?>
			border:1px solid #<?=$SITE[shopSingleItemBorderColor];?>;
		<? } ?>
		
}

#boxes_products li .li_content {
	background:<? if($SITE[shopProductBgImage] != '') { ?>url(<?=$SITE[url].'/gallery/sitepics/'.$SITE[shopProductBgImage];?>) no-repeat <? } if($SITE[shopSingleItemBgColor] != '') { ?>#<?=$SITE[shopSingleItemBgColor];?><? } ?>;
	overflow:hidden;
	
}

#boxes_products li .roundBox{
	width:100%;
}

#boxes_products li.nonView {
	background:#cccccc;
}

#boxes_products li .ShortDesc {
	padding: 0 5px;
	<? if (isset($_SESSION['LOGGED_ADMIN'])){ ?>min-height:42px;<? } ?>
	overflow: hidden;
	font-size:<?=$SITE[shopProductShortDescSize];?>px;
	color:#<?=$SITE[shopProductShortDescColor];?>;
	font-weight: <?=($SITE[shopProductShortDescBold] == 1) ? 'bold' : 'normal';?>;
	background:#<?=$SITE[shopInfoBgColor];?>;
}

#boxes_products li .moreLink {
	<? if($SITE[shopMoreLinkFile] == ''){ ?>
	padding: <?=($SITE['align'] == 'right') ? '5px 0 7px 5px' : '5px 5px 7px 0px'; ?>;
	<? } else { ?>
	padding:5px 0 0;
	<? } ?>
	font-size:<?=$SITE[shopProductDetailsSize];?>px;
	text-align:<?=$SITE[opalign];?>;
	background:#<?=$SITE[shopInfoBgColor];?>;
	<? if($SITE[shopMoreLinkFile] == ''){ ?>
	height:15px;
	<? } else {
		$size = getimagesize('gallery/sitepics/'.$SITE[shopMoreLinkFile]);
		?>
		
		height:<?=$size[1];?>px;
		<?
	} ?>
}

#boxes_products li .moreLink a {
	<? if($SITE[shopMoreLinkFile] == ''){ ?>
	color:#<?=($SITE[shopMoreLinkColor] != '') ? $SITE[shopMoreLinkColor] : $SITE[shopProductDetailsColor];?>;
	text-decoration: underline;
	font-weight: <?=($SITE[shopProductDetailsBold] == 1) ? 'bold' : 'normal';?>;
	<? } else {
		$size = getimagesize('gallery/sitepics/'.$SITE[shopMoreLinkFile]);
		?>
		float:<?=$SITE[opalign];?>;
		display:block;
		color:transparent;
		font-size:0;
		line-height:0;
		text-decoration: none;
		width:<?=$size[0];?>px;
		height:<?=$size[1];?>px;
		background:url(<?=SITE_MEDIA.'/gallery/sitepics/'.$SITE[shopMoreLinkFile];?>) no-repeat;
		<?
	} ?>
}

#boxes_products li .titleContent {
	padding:5px 5px;
	background:#<?=$SITE[shopInfoBgColor];?>;
	<?=($CHECK_CATPAGE['shopOptions']['centeredTitle'] == 1) ? 'text-align:center;' : '';?>
}

#boxes_products li .titleContent h2 a {
	font-size:<?=$SITE[shopProductTitleSize];?>px;
	color:#<?=$SITE[shopProductTitleColor];?>;
	font-weight: <?=($SITE[shopProductTitleBold] == 1) ? 'bold' : 'normal';?>;
	width:100%;
	overflow:hidden;
	/* white-space: nowrap; */
}


#boxes_products li.richText {
	clear:both;
	margin:0px 0 10px;
	float:none;
	width:auto;
	border:0;
}

<?
$borderMinus += ($SITE[shopSingleItemPicBorder] == '') ? 0 : -2;
?>
#boxes_products li .pic {
	width:<?=$thumbWidth+16+$borderMinus;?>px;
	height:<?=$thumbHeight+14+$borderMinus;?>px;
	display: table;
	#position: relative;
	text-align: center;
	overflow:hidden;
	position:relative;
	background:<?=($SITE[shopSingleItemImageBg] != '') ? 'url('.$SITE[Url].'/gallery/sitepics/'.$SITE[shopSingleItemImageBg].') no-repeat ' : '';?>#<?=$SITE[shopImageBgColor];?>;
	<?=($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1) ? 'margin:0 0 0px 0;' :'margin:0 0 4px 0;';?>
	<? if($SITE[shopSingleItemPicBorder] != ''){ ?>border:1px solid #<?=$SITE[shopSingleItemPicBorder];?>;<? } ?>
	
}

#boxes_products li .pic a {
	#position: absolute;
	#top: 50%;
	#left:0;
	width:100%;
	display: table-cell;
	vertical-align: middle;
	
}

#boxes_products li .pic a img{
	max-width:<?=$thumbWidth;?>px;
	max-height:<?=$thumbHeight;?>px;
	#position: relative;
	#top: -50%;
}

.ItemPlus {
	<? /* padding:5px <?=($SITE[shopInfoBgColor] != '') ? '5px 0 5px' : '0 0 0';?>; */ ?>
	padding: 5px 5px 0;
	color:#<?=$SITE[titlescolor];?>;
	font-weight: bold;
	background:#<?=$SITE[shopInfoBgColor];?>;
	font-size: <?=$SITE[shopProductPriceSize];?>px;
}

<? if (isset($_SESSION['LOGGED_ADMIN'])) { ?>


.editable_attribute {
	font-weight:bold;
}

.editable_attribute form input,.editable_value form input,.editable.price form input {
	border:0;
	margin:0;
	padding:0;
}

.editable_value {
	width:250px;
} 

.editable_attribute:hover,.editable_value:hover,.editable:hover{
	background:#FFF1A8;
}

.editable_value form,.editable_attribute form,.editable form,.editable_value_price form ,.editable_string form{
	display:inline;
	padding:0;
	margin:0;
}

.editable_value_price form input {
	padding:2px;
	border:0;
	background:none;
	color:inherit;
	font-size:inherit;
	font-weight:inherit;
	font-family:inherit;
	height:15px;
	min-width:50px;
	display: inline;
}

.editable form input {
	padding:2px;
	border:0;
	background:none;
	color:inherit;
	font-size:inherit;
	font-weight:inherit;
	font-family:inherit;
	height:15px;
	min-width:50px;
	display: inline;
}

.editable.price form input {
	padding:0;
}

.editable_string form input {
	padding:2px;
	border:0;
	background:none;
	color:inherit;
	font-size:inherit;
	font-weight:inherit;
	font-family:inherit;
	height:15px;
	min-width:100px;
	display:inline;
}

.editable.price {
	overflow:hidden;
}

.editable form textarea {
	font-family:Arial;
}

.editable.price form textarea {
	min-width:50px;
}

#fsUploadProgress_morepics, #fsUploadProgress_morepicsmass {
	float:<?=$SITE[align];?>;
	width:auto;
}

#fsUploadProgress_morepics .progressWrapper, #fsUploadProgress_morepicsmass .progressWrapper {
	width:auto;
	float:<?=$SITE[align];?>;
}

#fsUploadProgress_morepics .progressWrapper .progressContainer, #fsUploadProgress_morepicsmass .progressWrapper .progressContainer {
	width:auto;
}

#fsUploadProgress_morepics .progressWrapper .progressContainer .progressName, #fsUploadProgress_morepicsmass .progressWrapper .progressContainer .progressName {
	width:62px;
	overflow:hidden;
}

#fsUploadProgress_morepics .progressWrapper .progressContainer .progressBarStatus, #fsUploadProgress_morepicsmass .progressWrapper .progressContainer .progressBarStatus {
	width:auto;
}

#fsUploadProgress_morepics_main .progressWrapper {
	width:auto;
}

<? } ?>
#pages {
	width:100%;
	text-align: center;
	padding: 20px 0;
	color:#<?=$SITE[contenttextcolor];?>;
	font-weight:bold;
}

#pages a {
	padding:3px;
	border:1px solid #<?=($SITE[shopPageBorder] != '' ) ? $SITE[shopPageBorder] : $PROD[smallpicBorderColor] ;?>;
	margin:0 3px;
	color:#<?=$SITE[linkscolor];?>;
	<? if($SITE[shopPageBg] != ''){ ?>background:#<?=$SITE[shopPageBg];?>;<? } ?>
}

#pages .one {
	padding:3px;
	border:1px solid #<?=($SITE[shopPageBorder] != '' ) ? $SITE[shopPageBorder] : $PROD[smallpicBorderColor] ;?>;
	margin:0 3px;
	<? if($SITE[shopPageBg] != ''){ ?>background:#<?=$SITE[shopPageBg];?>;<? } ?>
}


.ProductEditorBrowsePics object {
	vertical-align: middle;
}
</style>
<?
if (isset($_SESSION['LOGGED_ADMIN'])) {
	$effects = array('slide','fade','flash','fadeslide','sliceUp','sliceDown','sliceUpDown','fade','fold','random');
	?>
	<link type="text/css" rel="stylesheet" href="<?=$SITE[url];?>/css/ui.all.css">
	<div id="newSaveIcon" class="add_button" onclick="AddShopProduct();"><?=$SHOP_TRANS['add_item'];?></div>
	<div id="newSaveIcon" class="add_button" onclick="MassAdd();"><?=$SHOP_TRANS['add_some_items'];?></div>
	<div id="newSaveIcon" onclick="EditAttributes();"><?=$SHOP_TRANS['changeCatAttrs'];?></div>
	
	<div id="newSaveIcon" onclick="addRichText();"><?=$ADMIN_TRANS['add rich text'];?></div>
	<div id="newSaveIcon" onclick="document.location.href='<?=$SITE[url];?>/cat.php?urlKey=<?=$urlKey;?><?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?><?=(!$nolimit) ? '&allitemsinpage=1' : '';?>'"><?=(!$nolimit) ? $SHOP_TRANS['allItemsInPage'] : $SHOP_TRANS['backToPages'];?></div>

	<div style="width:100%;height:20px;"></div>
	
	<div dir="<?=$SITE_LANG[direction];?>" id="AttributesEditor" style="display:none;z-index:1000;padding:10px;position:absolute;top:100px;<?=$SITE[opalign];?>:50%;margin-<?=$SITE[opalign];?>:-240px;background-color:#E0ECFF;border:2px solid #C3D9FF;width:480px;">
		<div id="categoryPars">
			<h3><?=$SHOP_TRANS['category_options'];?></h3>
			<div style="height:20px;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
				<span><?=$SHOP_TRANS['AproductVMargin'];?></span> : <br />
				<input type="text" size="10" id="productMargin" name="productMargin" value="<?=($CHECK_CATPAGE['shopOptions']['productMargin'] > 0) ? $CHECK_CATPAGE['shopOptions']['productMargin'] : '10';?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
				<span><?=$SHOP_TRANS['AproductHMargin'];?></span> : <br />
				<input type="text" size="10" id="productHMargin" name="productHMargin" value="<?=($CHECK_CATPAGE['shopOptions']['productHMargin'] > 0) ? $CHECK_CATPAGE['shopOptions']['productHMargin'] : '10';?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
				<span><?=$SHOP_TRANS['AproductPicWidth'];?></span> : <br />
				<input type="text" size="10" id="ContentPhotoWidth" name="ContentPhotoWidth" value="<?=($CHECK_CATPAGE['shopOptions']['ContentPhotoWidth'] > 0) ? $CHECK_CATPAGE['shopOptions']['ContentPhotoWidth'] : $SITE['productPicWidth'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
				<span><?=$SHOP_TRANS['AproductPicHeight'];?></span> : <br />
				<input type="text" size="10" id="ContentPhotoHeight" name="ContentPhotoHeight" value="<?=($CHECK_CATPAGE['shopOptions']['ContentPhotoHeight'] > 0) ? $CHECK_CATPAGE['shopOptions']['ContentPhotoHeight'] : $SITE['productPicHeight'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
				<span><?=$SHOP_TRANS['AproductPagePicWidth'];?></span> : <br />
				<input type="text" size="10" id="ContentPagePhotoWidth" name="ContentPagePhotoWidth" value="<?=($CHECK_CATPAGE['shopOptions']['ContentPagePhotoWidth'] > 0) ? $CHECK_CATPAGE['shopOptions']['ContentPagePhotoWidth'] : $SITE['productPicWidth'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:10px;">
				<span><?=$SHOP_TRANS['AproductPagePicHeight'];?></span> : <br />
				<input type="text" size="10" id="ContentPagePhotoHeight" name="ContentPagePhotoHeight" value="<?=($CHECK_CATPAGE['shopOptions']['ContentPagePhotoHeight'] > 0) ? $CHECK_CATPAGE['shopOptions']['ContentPagePhotoHeight'] : $SITE['productPicHeight'];?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:15px;">
				<input type="checkbox" class="AdminCheckbox" id="roundedCorners" name="roundedCorners" value="1" <?=($CHECK_CATPAGE['shopOptions']['roundedCorners'] == 1) ? ' CHECKED' : '';?> /><span><?=$ADMIN_TRANS['rounded corners'];?></span>
				<br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:15px;">
				<input type="checkbox" class="AdminCheckbox" id="centeredTitle" name="centeredTitle" value="1" <?=($CHECK_CATPAGE['shopOptions']['centeredTitle'] == 1) ? ' CHECKED' : '';?> /><span><?=$SHOP_TRANS['centeredTitle'];?></span><br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:15px;">
				<span><?=$SHOP_TRANS['GalleryWidth'];?></span> : 
				<input type="text" size="10" id="GalleryWidth" name="GalleryWidth" value="<?=($CHECK_CATPAGE['shopOptions']['GalleryWidth'] > 0) ? $CHECK_CATPAGE['shopOptions']['GalleryWidth'] : 400;?>" /><br /><br />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:15px;">
				<span><?=$SHOP_TRANS['GalleryHeight'];?></span> : 
				<input type="text" size="10" id="GalleryHeight" name="GalleryHeight" value="<?=($CHECK_CATPAGE['shopOptions']['GalleryHeight'] > 0) ? $CHECK_CATPAGE['shopOptions']['GalleryHeight'] : 350;?>" /><br /><br />
			</div>
			
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:15px;">
				<input type="checkbox" class="AdminCheckbox" id="galleryEffekts" name="galleryEffekts" value="1" <?=($CHECK_CATPAGE['shopOptions']['galleryEffekts'] == 1) ? ' CHECKED' : '';?> /><span><?=$SHOP_TRANS['effects_gallery'];?></span><br /><br />
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:15px;">
				<span style="margin-right: 3px;"><?=$SHOP_TRANS['new_products_added'];?></span> : <br />
				<input type="radio" class="AdminCheckbox" name="NewAddOrder" value="1" <?=($CHECK_CATPAGE['shopOptions']['NewAddOrder'] == 1) ? 'CHECKED' : '';?> /><?=$SHOP_TRANS['end_of_list'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="AdminCheckbox" name="NewAddOrder" value="0" <?=($CHECK_CATPAGE['shopOptions']['NewAddOrder'] != 1) ? 'CHECKED' : '';?> /><?=$SHOP_TRANS['start_of_list'];?><br/>
			</div>
			<div style="clear:both;height:20px;"></div>
			<hr/>
		</div>
		<div id="categoryAtts">
			<h3><?=$SHOP_TRANS['categoryProductsAttributes'];?></h3>
			<div id="newSaveIcon" class="add_button" onclick="AddCatAttribute();"><?=$SHOP_TRANS['add_attr'];?></div>
			<div style="clear:both;height:20px;"></div>
			<table cellspacing="5" cellpadding="0" border="0" id="atts_table">
			<?
			$attributes = GetCategoryAttributes($urlKey);
			foreach($attributes as $id => $data) { ?>
				<tr id="at_tr_<?=$id;?>">
					<td width="68">
						<div style="width:68px;text-align:<?=$SITE[opalign];?>"><a href="#" onclick="AddAttributeValue(<?=$id;?>);return false;"><img src="<?=$SITE[url];?>/Admin/images/plus.png" border="0" alt="<?=$SHOP_TRANS['add_value'];?>" title="<?=$SHOP_TRANS['add_value'];?>" /></a> <a href="#" onclick="LoadAttributeValues(<?=$id;?>);return false;"><img src="<?=$SITE[url];?>/Admin/images/values.png" border="0" alt="<?=$SHOP_TRANS['attrs'];?>" title="<?=$SHOP_TRANS['attrs'];?>"/></a> <a href="#" onclick="DeleteAttribute(<?=$id;?>);return false;"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" border="0" alt="<?=$SHOP_TRANS['del'];?>" title="<?=$SHOP_TRANS['del'];?>"/></a></div>
					</td>
					<td colspan="2" style="background:#efefef;border:1px solid #b7bbc2"><div class="editable_attribute" id="attribute_<?=$id;?>"><?=$data['name'];?></div></td>
					
				</tr>
				<? foreach($data['values'] as $vid => $value) { ?>
				<tr id="val_tr_<?=$vid;?>" class="values_<?=$id;?>">
					<td style="text-align:<?=$SITE[opalign];?>"><a href="#" onclick="DeleteAttributeValue(<?=$vid;?>);return false;"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" border="0" alt="<?=$SHOP_TRANS['del'];?>" title="<?=$SHOP_TRANS['del'];?>" /></a></td>
					<td style="background:#fff;border:1px solid #b7bbc2" width="250"><div class="editable_value" id="value_<?=$vid;?>"><?=$value;?></div></td>
					<td width="200"><b><?=$SHOP_TRANS['additional_price'];?>:</b> <span class="editable_value_price" id="value_price_<?=$vid;?>"><?=floatval($data['valuesPrices'][$vid]);?></span> <?=$SITE[ItemsCurrency];?></td>
				</tr>
				<? } ?>
			<? } ?>
			</table>
			<div style="height:20px;"></div>
			<input id="saveContentButton" type="button" class="greenSave" value="<?=$ADMIN_TRANS['save changes'];?>" onclick="saveCatSettings();">
			&nbsp; &nbsp;
			<input id="cancelContentButton" type="button" value="<?=$ADMIN_TRANS['cancel'];?>" onclick="EditAttributes();">
			<div style="clear:both;"></div>
		</div>
		
		<div style="clear:both;"></div>
	</div>
	<div dir="<?=$SITE_LANG[direction];?>" id="ProductPicUpload" style="display:none;z-index:1000;position:absolute;top:100px;<?=$SITE[opalign];?>:50%;margin-<?=$SITE[opalign];?>:-360px;width:550px;" class="CenterBoxWrapper">
		<div id="make_dragable" align="<?=$SITE[opalign];?>"><div class="icon_close" onclick="AddProductPicture()">+</div>
			<div class="title"><?=$SHOP_TRANS['product_main_pic'];?></div>
		</div>
		<div class="CenterBoxContent">
		<input type="hidden" name="ProductPicID" id="ProductPicID" value="0" />
		
		<div id="productPicDets">
			<div style="float:<?=$SITE[align];?>;">
				<span><?=$SHOP_TRANS['add_main_pic'];?></span> :
				<span id="spanButtonPlaceHolder_morepics_main" style="cursor:pointer"></span>
			</div>
			<div style="clear:both;"></div>
			<div class="fieldset flash" id="fsUploadProgress_morepics_main" style="width:auto"></div>
			<div style="clear:both;border-bottom:1px solid #000;padding-top:20px;margin-bottom:20px;"></div>
			
		</div>
		<div style="clear:both;height:10px;"></div>
		<div id="newSaveIcon" class="greenSave" onclick="beforeSaveProductPicture();"><i class="fa fa-cloud-upload"></i> <?=$ADMIN_TRANS['upload and save'];?></div>
		&nbsp; &nbsp;
		<div id="newSaveIcon" onclick="AddProductPicture();"><?=$ADMIN_TRANS['cancel'];?></div>
		<div style="clear:both;"></div>
	</div>
	</div>
	<div dir="<?=$SITE_LANG[direction];?>" id="RichTextEditor" style="display:none;z-index:1000;" class="editorWrapper">
		<h1 style="font-size:16px;"><?=$ADMIN_TRANS['add rich text'];?></h1>
		<textarea id="RichText" name="RichText"></textarea>
		<div style="clear:both;height:10px;"></div>
		<div id="newSaveIcon" class="greenSave" onclick="saveRichText();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>
		&nbsp; &nbsp;
		<div id="newSaveIcon" onclick="addRichText();"><?=$ADMIN_TRANS['cancel'];?></div>
		<div style="clear:both;"></div>
	</div>
	<div dir="<?=$SITE_LANG[direction];?>" id="ProductEditor" style="display:none;z-index:1000;" class="editorWrapper">
		<h1 style="font-size:16px;float:<?=$SITE[align];?>"><?=$SHOP_TRANS['add_item'];?></h1>
		<div style="float:<?=$SITE[opalign];?>;margin-top:10px;" class="ProductEditorBrowsePics">
			<span style="vertical-align:middle;font-size:14px;font-weight:bold;"><?=$SHOP_TRANS['add_item_pics'];?>:</span>
			<span id="spanButtonPlaceHolder_morepics" style="cursor:pointer;vertical-align:middle"></span>
		</div>
		<div style="clear:both"></div>
		<input type="hidden" name="ProductID" id="ProductID" value="0" />
		<div id="productPars">
			<?
			$attributes = GetCategoryAttributes($urlKey);
			foreach($attributes as $id => $data) { ?>
				<h2 style="font-size:14px;"><?=$data['name'];?></h2>
				<? foreach($data['values'] as $vid => $value) { ?>
				<input type="checkbox" value="1" name="value_<?=$id;?>:<?=$vid;?>" class="ProductValues AdminCheckbox" CHECKED /><?=$value;?>&nbsp;&nbsp;&nbsp;
				<? } ?>
				<hr style="border: 0;border-bottom: 1px solid #b7bbc2;border-collapse: collapse;height: 1px;" />
			<? } ?>
			<div style="clear:both;"></div>
		</div>
		<div id="productDets">
			
			<div class="fieldset flash" id="fsUploadProgress_morepics"></div>
			<div style="clear:both"></div>
			<div style="float:<?=$SITE[align];?>;">
				<span><?=$ADMIN_TRANS['product name'];?></span> : <br />
				<input type="text" style="width:693px;" id="ProductName" name="ProductName"/>
			</div>
			<div style="clear:both"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['product price'];?></span> : <br />
				<input type="text" size="10" id="ProductPrice" name="ProductPrice"/>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['discount price'];?></span> : <br />
				<input type="text" size="10" id="discountPrice" name="discountPrice"/>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$SHOP_TRANS['quantity_has'];?></span> : <br />
				<input type="text" size="10" id="quantity" name="quantity" value="<?=$SITE[shop_default_quantity];?>" />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="ViewStatus" id="ViewStatus" value="1" CHECKED /><?=$ADMIN_TRANS['show this product'];?>
			</div>
			<div style="float:<?=$SITE[align];?>;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="featured" id="featured" value="1" /><?=$SHOP_TRANS['featured_product'];?>
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$SHOP_TRANS['short_desc'];?></span> : <br />
				<input type="text" style="width:693px;" id="ProductShortDesc" name="ProductShortDesc"/>
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;padding-top:2px;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="galleryEffect" id="galleryEffect" value="1" CHECKED /><?=$SHOP_TRANS['effects_gallery'];?>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;padding-top:2px;" id="picsZoomBox">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="picsZoom" id="picsZoom" value="1" /><?=$SHOP_TRANS['picsZoom'];?>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;" id="effectIDSelect">
				<br/>
				<span><?=$SHOP_TRANS['effect'];?></span> :
				<select name="effectID" id="effectID" style="width:120px;">
					<? foreach($effects as $effectID => $effectName) { ?><option value="<?=$effectID;?>"><?=$effectName;?></option><? } ?>
				</select>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;" id="galleryThemeSelect">
				<br/>
				<span><?=$SHOP_TRANS['gallery_type'];?></span> : 
				<select name="galleryTheme" id="galleryTheme" style="width:120px;">
					<option value="0"><?=$SHOP_TRANS['without_preview'];?></option>
					<option value="1" selected><?=$SHOP_TRANS['with_preview'];?></option>
				</select>
			</div>
			<div style="clear:both"></div>
			<!-- <div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;" id="galleryAsideSelect">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="galleryAside" id="galleryAside" value="1" />&nbsp;<?=$SHOP_TRANS['desc_right_to_gallery'];?>
			</div> -->
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="mainPicNotShown" id="mainPicNotShown" value="1" /><?=$SHOP_TRANS['mainPicNotShown'];?>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br/>
				<span><?=$SHOP_TRANS['text_is_shown_at'];?></span> : 
				<select name="galleryAside" id="galleryAside" style="width:120px;">
					<option value="1"><?=$SHOP_TRANS['text_to_the_left'];?></option>
					<option value="0"><?=$SHOP_TRANS['text_under'];?></option>
				</select>
			</div>
			
			<div style="clear:both;margin-top:20px;"></div>
			
			<span><b><?=$ADMIN_TRANS['product description'];?></b></span> : <br />
			<textarea id="ProductDesc" name="ProductDesc"></textarea>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;height:10px;"></div>
		<div id="newSaveIcon" class="greenSave" onclick="beforeSaveProduct();"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>
		&nbsp; &nbsp;
		<div id="newSaveIcon" onclick="AddShopProduct();"><?=$ADMIN_TRANS['cancel'];?></div>
		<div style="clear:both;"></div>
	</div>
	<div dir="<?=$SITE_LANG[direction];?>" id="MassProductAdd" style="display:none;z-index:1000;" class="editorWrapper">
		<h1 style="font-size:16px;float:<?=$SITE[align];?>"><?=$SHOP_TRANS['add_some_items'];?></h1>
		<div style="float:<?=$SITE[opalign];?>;margin-top:10px;" class="ProductEditorBrowsePics">
			<span style="vertical-align:middle;font-size:14px;font-weight:bold;"><?=$SHOP_TRANS['add_item_pics'];?>:</span>
			<span id="spanButtonPlaceHolder_morepicsmass" style="cursor:pointer;vertical-align:middle"></span>
		</div>
		<div style="clear:both"></div>
		<div id="MassProductPars">
			<?
			$attributes = GetCategoryAttributes($urlKey);
			foreach($attributes as $id => $data) { ?>
				<h2 style="font-size:14px;"><?=$data['name'];?></h2>
				<? foreach($data['values'] as $vid => $value) { ?>
				<input type="checkbox" class="AdminCheckbox" value="1" name="value_<?=$id;?>:<?=$vid;?>" class="MassProductValues" CHECKED /><?=$value;?>&nbsp;&nbsp;&nbsp;
				<? } ?>
				<hr style="border: 0;border-bottom: 1px solid #b7bbc2;border-collapse: collapse;height: 1px;" />
			<? } ?>
			<div style="clear:both;"></div>
		</div>
		
		<div id="MassProductDets">
			<div class="fieldset flash" id="fsUploadProgress_morepicsmass"></div>
			<div style="clear:both;"></div>
			
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['product price'];?></span> : <br />
				<input type="text" size="10" id="MassProductPrice" name="MassProductPrice"/>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$ADMIN_TRANS['discount price'];?></span> : <br />
				<input type="text" size="10" id="MassDiscountPrice" name="MassDiscountPrice"/>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$SHOP_TRANS['quantity_has'];?></span> : <br />
				<input type="text" size="10" id="Massquantity" name="Massquantity" value="<?=$SITE[shop_default_quantity];?>" />
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="MassViewStatus" id="MassViewStatus" value="1" CHECKED /><?=$ADMIN_TRANS['show this product'];?>
			</div>
			<div style="float:<?=$SITE[align];?>;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="Massfeatured" id="Massfeatured" value="1" /><?=$SHOP_TRANS['featured_product'];?>
			</div>
			<div style="clear:both;"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<span><?=$SHOP_TRANS['short_desc'];?></span> : <br />
				<input type="text" style="width:693px;" id="MassProductShortDesc" name="MassProductShortDesc"/>
			</div>
			<div style="clear:both"></div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;padding-top:2px;">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="massgalleryEffect" id="massgalleryEffect" value="1" CHECKED /><?=$SHOP_TRANS['effects_gallery'];?>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;padding-top:2px;" id="masspicsZoomBox">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="masspicsZoom" id="masspicsZoom" value="1" /><?=$SHOP_TRANS['picsZoom'];?>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;" id="masseffectIDSelect">
				<br/>
				<span><?=$SHOP_TRANS['effect'];?></span> : 
				<select name="masseffectID" id="masseffectID" style="width:120px;">
					<? foreach($effects as $effectID => $effectName) { ?><option value="<?=$effectID;?>"><?=$effectName;?></option><? } ?>
				</select>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;" id="massgalleryThemeSelect">
				<br/>
				<span><?=$SHOP_TRANS['gallery_type'];?></span> : 
				<select name="massgalleryTheme" id="massgalleryTheme" style="width:120px;">
					<option value="0"><?=$SHOP_TRANS['without_preview'];?></option>
					<option value="1"><?=$SHOP_TRANS['with_preview'];?></option>
				</select>
			</div>
			<div style="clear:both"></div>
			<!-- <div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;" id="massgalleryAsideSelect">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="massgalleryAside" id="massgalleryAside" value="1" />&nbsp;<?=$SHOP_TRANS['desc_right_to_gallery'];?>
			</div> -->
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;padding-top:2px;" id="massmainPicNotShownBox">
				<br/>
				<input type="checkbox" class="AdminCheckbox" name="massmainPicNotShown" id="massmainPicNotShown" value="1" /><?=$SHOP_TRANS['mainPicNotShown'];?>
			</div>
			<div style="float:<?=$SITE[align];?>;margin-<?=$SITE[opalign];?>:20px;">
				<br/>
				<span><?=$SHOP_TRANS['text_is_shown_at'];?></span> : 
				<select name="massgalleryAside" id="massgalleryAside" style="width:120px;">
					<option value="1"><?=$SHOP_TRANS['text_to_the_left'];?></option>
					<option value="0"><?=$SHOP_TRANS['text_under'];?></option>
				</select>
			</div>
			<div style="clear:both;margin-bottom:20px;"></div>
			<span><b><?=$ADMIN_TRANS['product description'];?></b></span> : <br />
			<textarea id="MassProductDesc" name="MassProductDesc"></textarea>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;height:10px;"></div>
		<div id="newSaveIcon" class="greenSave" onclick="beforeMassAdd();"><?=$ADMIN_TRANS['save changes'];?></div>
		&nbsp; &nbsp;
		<div id="newSaveIcon" onclick="MassAdd();"><?=$ADMIN_TRANS['cancel'];?></div>
		<div style="clear:both;"></div>
	</div>
	<script type="text/javascript" src="<?=$SITE[url];?>/js/jquery.jeditable.mini.js"></script>
	<script type="text/javascript">
	var editor_browsePath="<?=$SITE[url];?>/ckfinder";
	var data_sent = 0;
	var buttonID= "photo_spanButtonPlaceHolder";
	var allowed_photo_types="*.jpg;*.gif;*.png";
	var uploaded_filename = '';
	var my_uploaded_file = '';
	var upload_global_type = 'shop_product';
	var editor_ins = false;
	var swfu,swfu_2;
	var changed_attrs = false;
	var more_pics = [];
	var more_pics_names = [];
	var more_pics_cnt = 0;
	var in_more_pics = false;
	
	jQuery('document').ready(function() {
		jQuery('.editable_attribute').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=renameCatAttribute',{saveonenter : true,onblur:'submit'});
		jQuery('.editable_value').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=renameCatAttributeValue',{saveonenter : true,onblur:'submit'});
		jQuery('.editable_value_price').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=changeCatAttributeValuePrice',{saveonenter : true,onblur:'submit'});
		jQuery('.editable_string,.editable.price').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=editParameter',{saveonenter : true,onblur:'submit'});
		jQuery('.editable').not('.price').not('.ShortDesc').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=editParameter',{type:'textarea',saveonenter : true,onblur:'submit',placeholder:'<?=$SHOP_TRANS['AddShortDesc'];?>'});
		jQuery('.editable.ShortDesc').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=editParameter',{type:'textarea',saveonenter : false,onblur:'submit',placeholder:'<?=$SHOP_TRANS['AddShortDesc'];?>',data: function(value, settings) {
      /* Convert <br> to newline. */
      var retval = value.replace(/<br[\s\/]?>/gi, '');
      return retval;
    }});
		jQuery('.editable,.editable_attribute,.editable_value,.editable_value_price,.editable_string').mouseover(function () {
		      jQuery(this).effect("highlight", {}, 1000);
		});
	});
	
	function saveCatSettings() {
		var roundedCorners = jQuery('#roundedCorners:checked').length;
		var galleryEffekts = jQuery('#galleryEffekts:checked').length;
		var centeredTitle = jQuery('#centeredTitle:checked').length;
		var pars = 'action=saveCatSettings&urlKey=<?=$urlKey;?>&roundedCorners='+roundedCorners+'&centeredTitle='+centeredTitle+'&galleryEffekts='+galleryEffekts+'&productMargin='+jQuery('#productMargin').val()+'&productHMargin='+jQuery('#productHMargin').val()+'&ContentPhotoHeight='+jQuery('#ContentPhotoHeight').val()+'&ContentPhotoWidth='+jQuery('#ContentPhotoWidth').val()+'&ContentPagePhotoHeight='+jQuery('#ContentPagePhotoHeight').val()+'&ContentPagePhotoWidth='+jQuery('#ContentPagePhotoWidth').val()+'&NewAddOrder='+jQuery('input[name=NewAddOrder]:checked').val()+'&GalleryHeight='+jQuery('#GalleryHeight').val()+'&GalleryWidth='+jQuery('#GalleryWidth').val();
		var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
	}
	
	function ShopUploadedPic(flname,original_name) {
		more_pics[more_pics_cnt] = flname;
		more_pics_names[more_pics_cnt] = original_name;
		more_pics_cnt++;
	}
	
	function LoadAttributeValues(att_id) {
		jQuery('.values_'+att_id).toggle();
	}
	
	function AddCatAttribute() {
		defAttributeName = '<?=$SHOP_TRANS['new_attr'];?>';
		var myAjax = new Ajax.Request(
			'<?=$SITE[url];?>/Admin/saveProduct.php',
			{
				method:'post',
				parameters:'action=addCatAttribute&urlKey=<?=$urlKey;?>&AttributeName='+encodeURIComponent(defAttributeName),
				onSuccess:function (transport) {
					AttributeID = parseInt(transport.responseText);
					if(AttributeID > 0) {
						jQuery('#atts_table').append('<tr id="at_tr_'+AttributeID+'"><td width="68"><div style="width:68px;text-align:<?=$SITE[opalign];?>"><a href="#" onclick="AddAttributeValue('+AttributeID+');return false;"><img src="<?=$SITE[url];?>/Admin/images/plus.png" border="0" alt="<?=$SHOP_TRANS['add_value'];?>" title="<?=$SHOP_TRANS['add_value'];?>" /></a> <a href="#" onclick="LoadAttributeValues('+AttributeID+');return false;"><img src="<?=$SITE[url];?>/Admin/images/values.png" border="0" alt="<?=$SHOP_TRANS['attrs'];?>" title="<?=$SHOP_TRANS['attrs'];?>" /></a> <a href="#" onclick="DeleteAttribute('+AttributeID+');return false;"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" border="0" alt="<?=$SHOP_ATTRS['del'];?>" title="<?=$SHOP_ATTRS['del'];?>" /></a></div></td><td colspan="2" style="background:#efefef;border:1px solid #b7bbc2"><div class="editable_attribute" id="attribute_'+AttributeID+'">'+defAttributeName+'</div></td></tr>');
						jQuery('.editable_attribute').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=renameCatAttribute',{saveonenter : true,onblur:'submit'});
						jQuery('.editable_attribute').mouseover(function () {
						      jQuery(this).effect("highlight", {}, 1000);
						});
						jQuery('#attribute_'+AttributeID).click();
						changed_attrs = true;
					}
				}
			}
		);
	}
	
	function AddAttributeValue(AttributeID) {
		defValueName = '<?=$SHOP_TRANS['new_value'];?>';
		jQuery('.values_'+AttributeID).show();
		var myAjax = new Ajax.Request(
			'<?=$SITE[url];?>/Admin/saveProduct.php',
			{
				method:'post',
				parameters:'action=addCatAttributeValue&AttributeID='+AttributeID+'&ValueName='+encodeURIComponent(defValueName),
				onSuccess:function (transport) {
					ValueID = parseInt(transport.responseText);
					if(ValueID > 0) {
						jQuery('#at_tr_'+AttributeID).after('<tr id="val_tr_'+ValueID+'" class="values_'+AttributeID+'"><td style="text-align:<?=$SITE[opalign];?>"><a href="#" onclick="DeleteAttributeValue('+ValueID+');return false;"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" border="0" alt="<?=$SHOP_TRANS['del'];?>" title="<?=$SHOP_TRANS['del'];?>" /></a></td><td style="background:#fff;border:1px solid #b7bbc2" width="250"><div class="editable_value" id="value_'+ValueID+'">'+defValueName+'</div></td><td width="200"><b><?=$SHOP_TRANS['additional_price'];?>:</b> <span class="editable_value_price" id="value_price_'+ValueID+'">0</span> <?=$SITE[ItemsCurrency];?></td></tr>');
						jQuery('.editable_value').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=renameCatAttributeValue',{saveonenter : true,onblur:'submit'});
						jQuery('.editable_value_price').editable('<?=$SITE[url];?>/Admin/saveProduct.php?action=changeCatAttributeValuePrice',{saveonenter : true,onblur:'submit'});
						jQuery('.editable_value,.editable_value_price').mouseover(function () {
						      jQuery(this).effect("highlight", {}, 1000);
						});
						jQuery('#value_'+ValueID).click();
						changed_attrs = true;
					}
				}
			}
		)
	}
	
	function DeleteAttribute(AttributeID) {
		if(confirm('<?=$SHOP_TRANS['you_sure'];?>?')) {
			var myAjax = new Ajax.Request(
				'<?=$SITE[url];?>/Admin/saveProduct.php',
				{
					method:'post',
					parameters:'action=delCatAttribute&AttributeID='+AttributeID,
					onSuccess:function (transport) {
						jQuery('#at_tr_'+AttributeID).remove();
						jQuery('.values_'+AttributeID).remove();
						changed_attrs = true;
					}
				}
			);
		}
	}
	
	function DeleteAttributeValue(ValueID) {
		if(confirm('<?=$SHOP_TRANS['you_sure'];?>?')) {
			var myAjax = new Ajax.Request(
				'<?=$SITE[url];?>/Admin/saveProduct.php',
				{
					method:'post',
					parameters:'action=delCatAttributeValue&ValueID='+ValueID,
					onSuccess:function (transport) {
						jQuery('#val_tr_'+ValueID).remove();
						changed_attrs = true;
					}
				}
			);
		}
	}
	
    
	 function EditAttributes() {
		if (document.getElementById("AttributesEditor").style.display=="none") {
			ShowLayer("AttributesEditor",1,1,1);
		}
		else {
			if(changed_attrs)
				document.location.reload(); 
			else
				ShowLayer("AttributesEditor",0,1,1);
		}
	}
	
	function MassAdd() {
		if (document.getElementById("MassProductAdd").style.display=="none") {
			more_pics = [];
			more_pics_cnt = 0;
			//ShowLayer("MassProductAdd",1,1,1);
			slideOutEditor("MassProductAdd",1);
			editor_ins=CKEDITOR.replace('MassProductDesc', {
				filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
				 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
				 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
				 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
				 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
				 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
				 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js',
				extraPlugins : 'autogrow',
				autoGrow_maxHeight: 400,
				autoGrow_minHeight: 100,
				height:150
			});
			swfu_2 = false;
			showuploader(allowed_photo_types,20,'spanButtonPlaceHolder_morepicsmass',0,'fsUploadProgress_morepicsmass',2);

		}
		else {
			slideOutEditor("MassProductAdd",0);
			editor_ins.destroy();
		}
	}
	
	function beforeMassAdd() {
		var my_stat = swfu_2.getStats();
		if(my_stat.files_queued > 0 && data_sent == 0)
		{
			data_sent = 1;
			savingChanges(); 
			swfu_2.startUpload();
			setTimeout('checkMassProductMorePicsUploaded()',500);
		}
	}
	
	function checkMassProductMorePicsUploaded() {
		var my_stat = swfu_2.getStats();
		if(my_stat.in_progress == 1 || my_stat.files_queued > 0)
			setTimeout('checkMassProductMorePicsUploaded()',500);
		else
			saveMassProduct();
	}
	
	function saveMassProduct() {
		var ViewStatus = 0;
		if(jQuery('#MassViewStatus:checked').length > 0)
			ViewStatus = 1;
		var featured = 0;
		if(jQuery('#Massfeatured:checked').length > 0)
			featured = 1;
		var picsZoom = 0;
		var galleryEffect = 0;
		var effectID = 0;
		var galleryTheme = 0;
		var galleryAside = 0;
		var mainPicNotShown = 0;
		if(jQuery('#massgalleryEffect:checked').length > 0)
		{
			galleryEffect = 1;
			effectID = jQuery('#masseffectID option:selected').val();
			galleryTheme = jQuery('#massgalleryTheme option:selected').val();
			//if(jQuery('#massgalleryAside:checked').length > 0)
			//	galleryAside = 1;
			galleryAside = jQuery('#massgalleryAside option:selected').val();
			
		}
		if(jQuery('#masspicsZoom:checked').length > 0)
			picsZoom = 1;
		if(jQuery('#massmainPicNotShown:checked').length > 0)
			mainPicNotShown = 1;
		var pars = 'action=addMass&urlKey=<?=$urlKey;?>&ProductShortDesc='+encodeURIComponent(jQuery('#MassProductShortDesc').val())+'&ProductPrice='+jQuery('#MassProductPrice').val()+'&discountPrice='+jQuery('#MassDiscountPrice').val()+'&quantity='+jQuery('#Massquantity').val()+'&featured='+featured+'&ViewStatus='+ViewStatus+'&ProductDescription='+encodeURIComponent(editor_ins.getData('contentDIV'))+'&galleryEffect='+galleryEffect+'&effectID='+effectID+'&galleryTheme='+galleryTheme+'&galleryAside='+galleryAside+'&picsZoom='+picsZoom+'&mainPicNotShown='+mainPicNotShown;
		jQuery('.MassProductValues:checked').each(function(){
			pars+='&values[]='+jQuery(this).attr('name').replace('value_','');
		});
		jQuery.each(more_pics, function(index,value) {
	      pars += '&more_pics[]='+value+':-=-:'+more_pics_names[index];
	   	});
		var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
	}
	
	function AddProductPicture(productID){
		if (document.getElementById("ProductPicUpload").style.display=="none") {
			jQuery('#ProductPicID').val(productID);
			jQuery('#productPicDets').html('<div style="float:<?=$SITE[align];?>;"><span><?=$SHOP_TRANS['add_main_pic'];?></span> : <span id="spanButtonPlaceHolder_morepics_main" style="cursor:pointer"></span></div><div style="clear:both;"></div><div class="fieldset flash" id="fsUploadProgress_morepics_main" style="width:auto"></div><div style="clear:both;border-bottom:1px solid #000;padding-top:20px;margin-bottom:20px;"></div>');
			more_pics = [];
			more_pics_cnt = 0;
			ShowLayer("ProductPicUpload",1,1,1);
			if(jQuery('#spanButtonPlaceHolder_morepics_main').length > 0)
				showuploader(allowed_photo_types,1,'spanButtonPlaceHolder_morepics_main',0,'fsUploadProgress_morepics_main',2);
		}
		else ShowLayer("ProductPicUpload",0,1,1);
	}
	
	function beforeSaveProductPicture() {
		if(data_sent == 0)
		{
			data_sent = 1;
			savingChanges(); 
			swfu_2.startUpload();
			setTimeout('checkProductPictureUploaded()',500);
		}
	}
	
	function checkProductPictureUploaded() {
		my_stat = swfu_2.getStats();
		if(my_stat.in_progress == 1)
			setTimeout('checkProductPictureUploaded()',500);
		else
			saveProductPicture();
	}
	
	function saveProductPicture() {
		var pars = 'action=saveMainPic&urlKey=<?=$urlKey;?>&ProductID='+jQuery('#ProductPicID').val();
		jQuery.each(more_pics, function() {
	      pars += '&more_pics[]='+this;
	   });
		var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
	}

	 function AddShopProduct() {
		if (document.getElementById("ProductEditor").style.display=="none") {
			more_pics = [];
			more_pics_cnt = 0;
			//ShowLayer("ProductEditor",1,1,1);
			
			$('ProductName').focus();
			editor_ins=CKEDITOR.replace('ProductDesc', {
				filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
				 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
				 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
				 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
				 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
				 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
				 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js',
				extraPlugins : 'autogrow',
				autoGrow_maxHeight: 400,
				autoGrow_minHeight: 100,
				height:150
			});
			editor_ins.on('loaded',function() {
				slideOutEditor("ProductEditor",1);	
			});
			showuploader(allowed_photo_types,10,'spanButtonPlaceHolder_morepics',0,'fsUploadProgress_morepics',2);

		}
		else {
			slideOutEditor("ProductEditor",0);
			editor_ins.destroy();
		}
	}
	
	function check_form() {
		ret_val = true;
		if(jQuery('#ProductName').val() == '')
		{
			ret_val = false;
			alert('<?=$SHOP_TRANS['name_cant_be_empty'];?>!');
		}
		return ret_val;
	}
	
	function beforeSaveProduct() {
		if(check_form() && data_sent == 0)
		{
			data_sent = 1;
			savingChanges(); 
			swfu_2.startUpload();
			setTimeout('checkProductMorePicsUploaded()',500);
		}
	}
	
	function checkProductMorePicsUploaded() {
		my_stat = swfu_2.getStats();
		if(my_stat.in_progress == 1)
			setTimeout('checkProductMorePicsUploaded()',500);
		else
			saveProduct();
	}
	
	function saveProduct() {
		var ViewStatus = 0;
		if(jQuery('#ViewStatus:checked').length > 0)
			ViewStatus = 1;
		var featured = 0;
		if(jQuery('#featured:checked').length > 0)
			featured = 1;
		var picsZoom = 0;
		var galleryEffect = 0;
		var effectID = 0;
		var galleryTheme = 0;
		var galleryAside = 0;
		var mainPicNotShown = 0;
		if(jQuery('#galleryEffect:checked').length > 0)
		{
			galleryEffect = 1;
			effectID = jQuery('#effectID option:selected').val();
			galleryTheme = jQuery('#galleryTheme option:selected').val();
			//if(jQuery('#galleryAside:checked').length > 0)
			//	galleryAside = 1;
			galleryAside = jQuery('#galleryAside option:selected').val();
		}
		if(jQuery('#picsZoom:checked').length > 0)
			picsZoom = 1;
		if(jQuery('#mainPicNotShown:checked').length > 0)
			mainPicNotShown = 1;
		var pars = 'action=add&urlKey=<?=$urlKey;?>&ProductID='+jQuery('#ProductID').val()+'&ProductName='+jQuery('#ProductName').val()+'&ProductShortDesc='+encodeURIComponent(jQuery('#ProductShortDesc').val())+'&ProductPrice='+jQuery('#ProductPrice').val()+'&discountPrice='+jQuery('#discountPrice').val()+'&quantity='+jQuery('#quantity').val()+'&featured='+featured+'&ViewStatus='+ViewStatus+'&ProductDescription='+encodeURIComponent(editor_ins.getData('contentDIV'))+'&galleryEffect='+galleryEffect+'&effectID='+effectID+'&galleryTheme='+galleryTheme+'&galleryAside='+galleryAside+'&picsZoom='+picsZoom+'&mainPicNotShown='+mainPicNotShown;
		jQuery('.ProductValues:checked').each(function(){
			pars+='&values[]='+jQuery(this).attr('name').replace('value_','');
		});
		jQuery.each(more_pics, function() {
	      pars += '&more_pics[]='+this;
	   });
		var myAjax = new Ajax.Request('<?=$SITE[url];?>/Admin/saveProduct.php', {method:'post', parameters:pars, onSuccess:function (transport) {successEdit();setTimeout('document.location.reload()',500);}, onFailure:failedEdit, onLoading:savingChanges});
	}
	
	function fileDialogStart() {
		swfu.cancelUpload();
		var txtFileName = document.getElementById("txtFileName");
		txtFileName.innerHTML = '';
	}
	
	 
	function saveProductsOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/saveProduct.php';
		var pars = newPosition+'&action=saveOrder';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});
	}
	
	function saveOrder(newPosition) {
		var url = '<?=$SITE[url];?>/Admin/saveContentinplace.php';
		var pars =newPosition+'&action=saveContentLoc';
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit,onLoading:savingChanges});	
	}
	
	function deleteProduct(ProductID,ProductPhotoName) {
		if(confirm('<?=$SHOP_TRANS['you_sure'];?>?')) {
			var url = '<?=$SITE[url];?>/Admin/saveProduct.php';
			var pars = 'ProductID='+ProductID+'&ProductPhotoName='+ProductPhotoName+'&action=delete';
			var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function(transport){successEdit(); setTimeout('document.location.reload()',500);}, onFailure:failedEdit,onLoading:savingChanges});
		}
	}
	
	var richTextId = 0;
	var rich_editor_ins = false;
	
	function addRichText(){
		if (document.getElementById("RichTextEditor").style.display=="none") {
			richTextId = 0;
			slideOutEditor("RichTextEditor",1);
			//ShowLayer("RichTextEditor",1,1,1);
			if(!rich_editor_ins)
			{
				rich_editor_ins=CKEDITOR.replace('RichText', {
					filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
					 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
					 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
					 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
					 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
					 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
					 
				});
			}
			rich_editor_ins.setData('');
			
		}
		else slideOutEditor("RichTextEditor",0);
	}
	
	function editRichText(productID)
	{
		if (document.getElementById("RichTextEditor").style.display=="none") {
			richTextId = productID;
			var contentDIV = document.getElementById("richContent_"+productID);
			//ShowLayer("RichTextEditor",1,1,1);
			slideOutEditor("RichTextEditor",1);
			if(!rich_editor_ins)
			{
				rich_editor_ins=CKEDITOR.replace('RichText', {
						filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
						 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
						 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
						 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
						 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
						 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
						 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
					});
			}
			rich_editor_ins.setData(contentDIV.innerHTML);
		}
		else slideOutEditor("RichTextEditor",0);
	}
	
	function saveRichText(){
		var url = '<?=$SITE[url];?>/Admin/saveProduct.php';
		var pars = 'urlKey=<?=$urlKey;?>&richText='+encodeURIComponent(rich_editor_ins.getData());
		if(richTextId > 0)
			pars += '&action=saveRichText&ProductID='+richTextId;
		else
			pars += '&action=addRichText';	
		var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:function(transport){successEdit(); setTimeout('document.location.reload()',500);}, onFailure:failedEdit,onLoading:savingChanges});
	}
	
	jQuery(function() {
		jQuery("#boxes").sortable({
	   		update: function(event, ui) {
	   			saveOrder(jQuery("#boxes").sortable('serialize'));
	   		},
	   		scroll:false,
		});
		jQuery("#boxes_products").sortable({
	   		update: function(event, ui) {
	   			saveProductsOrder(jQuery("#boxes_products").sortable('serialize'));
	   		},
	   		scroll:false,
		});
	});
 	</script>
	<?
}
/*
?>
<ul id="boxes">
<?

$CONTENT=GetMultiContent($urlKey);
for ($a=0;$a<count($CONTENT[PageID]);$a++) {
	$titleShow="block";
	$p_url=SITE_MEDIA."/".$CONTENT[UrlKey][$a];
	$page_url=SITE_MEDIA."/".$CONTENT[UrlKey][$a];
	if ($CONTENT[PageTitle][$a]=="") $titleShow="none";
	if (!$CONTENT[PageUrl][$a]=="") $page_url=urldecode($CONTENT[PageUrl][$a]);
	?>
	<li id="short_cell-<?=$CONTENT[PageID][$a];?>" class="ui-state-default">
	<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<span style="display:none" id="p_url_<?=$CONTENT[PageID][$a];?>"><?=urldecode($CONTENT[PageUrl][$a]);?></span>
		<div class="cHolder" id="cHolder-item_<?=$CONTENT[PageID][$a];?>">
		<div>
		<span id="AdminErea_<?=$CONTENT[PageID][$a];?>" style="display:">
		<?include 'Admin/EditAreaClient.php'; ?>
		</span></div>
		<?
	}
	$h_tag="h1";
	if ($pageHasHOne) $h_tag="h2";
	if ($a>0) {
			$h_tag="h2";
			if ($pageHasHOne) $h_tag="h3";		
	}
	?>
	<div class="titleContent">
	<<?=$h_tag;?>  id="titleContent_<?=$CONTENT[PageID][$a]; ?>" style="display:<?=$titleShow;?>">
	<?
	if (count($CONTENT[PageID])>1) {
		?><a id="c_url_<?=$CONTENT[PageID][$a];?>" href="<?=$page_url;?>"><? }
	else {
		?><a id="c_url_<?=$CONTENT[PageID][$a];?>"><? }
		?><?=$CONTENT[PageTitle][$a];?></a>
		</<?=$h_tag;?>></div>
		<?

	?>

	<div id="printArea"><div id="divContent_<?=$CONTENT[PageID][$a]; ?>" align="<?=$SITE[align];?>" class="mainContentText">
	<?
	print $CONTENT[PageContent][$a];
	?></div></div>
<?

if (isset($_SESSION['LOGGED_ADMIN'])) print "</div><br>";
print "</li>";
}
?>
</ul>
<? */
$P_TITLE=GetPageTitle($CHECK_CATPAGE[parentID],"TopForm_Title");
$P_CONTENT_TOP=GetPageTitle($CHECK_CATPAGE[parentID],"TopForm_Content");
$P_CONTENT_BOTTOM=GetPageTitle($CHECK_CATPAGE[parentID],"BottomForm_Content");
if ($P_TITLE[Title]=="" AND isset($_SESSION['LOGGED_ADMIN'])) $P_TITLE[Title]="Enter Your title here";

	?>
	<div class="titleContent_top">
	<? if ($SITE[titlesicon] AND !$P_TITLE[Title]=="") {
			?><div class="titlesIcon" style="margin-<?=$SITE[align];?>:10px;"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[titlesicon];?>" /></div>
			<?
			
		}
		if (!$P_TITLE[Title]=="") {
			?>
			<h1 id="shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>"><?=$P_TITLE[Title];?></h1>
			<?
		}
		?>
	</div>
	<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
				<br />
		&nbsp;&nbsp;<div id="newSaveIcon"  onclick="EditTopContent();"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit top content'];?></div>
		
		<script language="javascript" type="text/javascript">
		new Ajax.InPlaceEditor('shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>', '<?=$SITE[url];?>/Admin/saveTitles.php?type=TopForm_Title', {clickToEditText:'Click to rename',submitOnBlur:true,okButton:false,cancelButton:false,okText:'SAVE',rows:1,cancelText:'Cancel',highlightcolor:'#FFF1A8',externalControl:'shortContentTitle-<?=$CHECK_CATPAGE[parentID];?>',formClassName:'titleContent_top'});
		</script>
		<?
	}
	?>
	<div id="topShortContent" style="padding-<?=$SITE[align];?>:5px;margin-<?=$SITE[opalign];?>:3px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=$P_CONTENT_TOP[Content];?></div>

	<ul id="boxes_products"><?
	$attrs_search = false;
	$page_str = '&';
	if(!empty($_GET))
	{
		$attrs_search = array();
		foreach($_GET as $k => $v)
			if(substr($k,0,5) == 'attr_' && $v > 0){
				$attrs_search[substr($k,5)] = $v;
				$page_str .= $k.'='.$v.'&';
			}
	}
$totalPages = getTotalPagesByCategory($urlKey,$attrs_search);
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if($page < 1)
	$page = 1;
if($page > $totalPages)
	$page = $totalPages;
	
if($nolimit)
{
	$SITE[shopProdsPerPage] *= $totalPages;
	$page = 1;
}

$items = GetProductsByCategory($urlKey,$page,$attrs_search);
$shopCartImage = ($SITE[shopProductsCartIcon] != '') ? $SITE[shopProductsCartIcon] : false;
foreach($items as $item)
{
	$titleShow='block';
	$page_url=$SITE['media'].'/'.'shop_product/'.$urlKey.'/'.$item['UrlKey'];
	$img_url=($item['ProductPhotoName'] != '') ? SITE_MEDIA.'/'.$gallery_dir.'/products/thumb_'.$item['ProductPhotoName'] : '';
	if ($item['ProductTitle']=='')
		$titleShow='none';
	if ($item['ProductUrl']!='')
		$page_url=urldecode($item['ProductUrl']);
	?>
	<li id="short_cell-<?=$item['ProductID'];?>" class="ui-state-default<?=($item['ViewStatus'] == 0) ? ' nonView' : '';?><?=($item['richText'] == '1') ? ' richText' : '';?>" <?=(!isset($_SESSION['LOGGED_ADMIN']) && $item['richText'] == '1' && trim(stripslashes($item[ProductDescription])) == '') ? ' style="display:none;"' : '';?>>
	<? if($item['onSale'] == 1 && $item['richText'] != 1 && $SITE[shopSaleLabel] != ''){ ?>
		<a href="<?=$page_url;?>"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$SITE[shopSaleLabel];?>" style="position:absolute;top:0;<?=$SITE[align];?>:1px;z-index:200;" border="0" /></a>
	<? } ?>
	<? if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1 && $item['richText'] != '1') SetRoundedCorners(1,1,$SITE[shopImageBgColor]); ?>
	<?
	if (isset($_SESSION['LOGGED_ADMIN']))
	{
		?>
		<span style="display:none" id="p_url_<?=$CONTENT[PageID][$a];?>"><?=urldecode($CONTENT[PageUrl][$a]);?></span>
		<div class="cHolder" id="cHolder-item_<?=$CONTENT[PageID][$a];?>">
		<div>
		<span id="AdminErea_<?=$CONTENT[PageID][$a];?>" style="display:">
			<Table class="AdminArea" id="AdminArea" cellpadding="0" width="100%" cellpadding="0">
			<tr>
				<td class="AdminAreaItem" style="cursor:move"><img src="<?=$SITE[url];?>/Admin/images/moveicon.gif" align="absmiddle" border="0" title="<?=$ADMIN_TRANS['change order'];?> ↓↑"><?=$ADMIN_TRANS['change order'];?></td>
				<td class="AdminAreaItem" onclick="deleteProduct(<?=$item['ProductID'];?>,'<?=$item['ProductPhotoName'];?>')"><img src="<?=$SITE[url];?>/Admin/images/delIcon.png" align="absmiddle" border="0" title="<?=$ADMIN_TRANS['delete'];?>">&nbsp;<?=$ADMIN_TRANS['delete'];?></td>
				<!-- <td class="AdminAreaItem" onclick="addRichText(<?=$item['ProductID'];?>)"></td> -->
			</tr>
			</Table>
		</span></div>
		<?
	} ?>
	<div class="li_content"<?=($item['richText'] == '1') ? ' style="background:none"' : '';?>>
	<?
	if (isset($_SESSION['LOGGED_ADMIN']) && $item['featured'] == '1'){
		?>
		<img src="/images/star.png" style="position:absolute;top:<?=($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1) ? '10' : '5';?>px;<?=$SITE[align];?>:5px;z-index:10;width:16px" />
		<?
	}
	if($item['richText'] == '1')
	{
		if (isset($_SESSION['LOGGED_ADMIN'])) {
			?>
			<div style="height:10px;"></div>
			&nbsp;&nbsp;
			<div id="newSaveIcon"  onclick="editRichText(<?=$item['ProductID'];?>);"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit'];?></div>
			<div style="height:5px"></div>
				<?
		}
		?>
		<div id="richContent_<?=$item['ProductID'];?>" style="padding-<?=$SITE[align];?>:10px;padding-<?=$SITE[opalign];?>:5px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=stripslashes($item[ProductDescription]);?></div>
		<?
		
	}
	else
	{
		?>
		<div class="pic">
		<? if($img_url != ''){ ?>
			<a id="c_url_<?=$item['ProductID'];?>" href="<?=$page_url;?>"><img src="<?=$img_url;?>" border="0" /></a>
		<? } ?>
		<? if (isset($_SESSION['LOGGED_ADMIN'])){ ?>
			<a href="#" onclick="AddProductPicture(<?=$item['ProductID'];?>);return false;" style="display:block;position:absolute;bottom:5px;<?=$SITE[opalign];?>:5px;"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" /></a>
		<? } ?>
		</div>
		<? if ($SITE[roundcorners]==1 AND !$SITE[shopInfoBgColor] AND !$SITE[shopSingleItemBgColor] AND @$PAGE_ID['shopOptions']['roundedCorners'] == 1) SetRoundedCorners(0,1,$SITE[shopImageBgColor],0); ?>
		<div class="titleContent">
			<h2 id="titleContent_<?=$item['ProductID'];?>" style="display:<?=$titleShow;?>">
				<? if (isset($_SESSION['LOGGED_ADMIN'])){ ?><a id="ProductTitle-<?=$item['ProductID'];?>" class="editable_string"><? } else { ?><a id="c_url_<?=$item['ProductID'];?>" href="<?=$page_url;?>"><? } ?><?=$item['ProductTitle'];?></a>
			</h2>
			<? if($SITE[shopMarkOutOfStock] == 1 && $item['quantity'] < 1){ ?>
				<br/><span style="color:#<?=$SITE[shopOutOfStockColor];?>"><?=$SHOP_TRANS['outOfStock'];?></span>
			<? } ?>
		</div>
		<div class="ShortDesc editable" id="ProductShortDesc-<?=$item['ProductID'];?>"><?=nl2br($item['ProductShortDesc']);?></div>
		<div class="ItemPlus">
			<? if($shopCartImage AND $item['ProductPrice']>0) { ?>
				<div style="float:<?=$SITE[opalign];?>;"><a href="#" onclick="AddToCart(<?=$item['ProductID'];?>);return false;"><img src="<?=SITE_MEDIA;?>/gallery/sitepics/<?=$shopCartImage;?>" border="0" align="middle" /></a></div>
			<? } ?>
			<div style="float:<?=$SITE[align];?>;font-size:<?=$SITE[shopSingleItemPriceSize];?>px;min-height:16px;">
			<? if(floatval($item['ProductPrice']) > 0 || isset($_SESSION['LOGGED_ADMIN'])){ ?>
				<?=$SHOP_TRANS['price'];?>: <span style="color:#<?=$SITE[shopProductsPagePriceColor];?>;<? if(floatval($item['discountPrice']) > 0){ ?>text-decoration: line-through;<? } ?>"><?=show_price_side(floatval($item['ProductPrice']),true,$item['ProductID']);?></span>
				<? if(floatval($item['discountPrice']) > 0 || isset($_SESSION['LOGGED_ADMIN'])){ ?>
					<br/><?=$SHOP_TRANS['discount_price'];?>: <span style="color:#<?=$SITE[shopProductsPageDiscountColor];?>"><?=show_price_side(floatval($item['discountPrice']),true,$item['ProductID'],false,'discountPrice');?></span>
				<? } ?>
			<? } ?>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="moreLink">
			<a href="<?=$page_url;?>"><?=$SHOP_TRANS['more_details'];?></a>
		</div>
		<div style="clear:both;"></div>
		<? if (isset($_SESSION['LOGGED_ADMIN'])) print "</div>";
	}	
	?>
	</div>
	<?
	$roundColor = ($SITE[shopInfoBgColor] != '') ? $SITE[shopInfoBgColor] : $SITE[shopSingleItemBgColor];
	if ($SITE[roundcorners]==1 && @$PAGE_ID['shopOptions']['roundedCorners'] == 1 && $item['richText'] != '1') SetRoundedCorners(0,1,$roundColor); ?>
	</li>
	<?
}

?>
<div style="clear:both"></div>
</ul>

<script type="text/javascript">
jQuery(window).load(function(){
	var max_height = 0;
	jQuery('.li_content .titleContent').each(function(){
		if(jQuery(this).height() > max_height)
			max_height = jQuery(this).height();
	});
	if(max_height > 0)
		jQuery('.li_content .titleContent').height(max_height);
		
	max_height = 0;
	jQuery('#boxes_products li .ShortDesc').each(function(){
		if(jQuery(this).height() > max_height)
			max_height = jQuery(this).height();
	});
	
	jQuery('#boxes_products li .ShortDesc').height(max_height);
	
	max_height = 0;
	jQuery('#boxes_products li .ItemPlus').each(function(){
		if(jQuery(this).height() > max_height)
			max_height = jQuery(this).height();
	});
	
	jQuery('#boxes_products li .ItemPlus').height(max_height);
	jQuery('#boxes_products').addClass("show");
	jQuery('.loader_products').addClass("hide");
});
</script>
<? if($totalPages > 1 && !$nolimit) { ?>
<div id="pages">
	<?
	for($p = 1;$p <= $totalPages;$p++) {
		if($p == $page) { ?><span class="one"><?=$p;?></span><? }
		else { ?><a href="<?=$SITE[url];?>/cat.php?urlKey=<?=$urlKey;?><?=($SITE_LANG[selected] != 'he') ? '&lang='.$SITE_LANG[selected] : '';?>&page=<?=$p;?><?=$page_str;?>#boxes_products"><?=$p;?></a><? }
	}
	?>
</div>
<? }

if (isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<div style="height:10px;"></div>
	&nbsp;&nbsp;
	<div id="newSaveIcon"  onclick="EditBottomContent();"><img src="<?=$SITE[url];?>/Admin/images/editIcon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['edit bottom content'];?></div>
	&nbsp;&nbsp;<span style="display:none" id="saveGalButton_bottom"><div style="display:" id="newSaveIcon" onclick="saveTopContent(1)"><img src="<?=$SITE[url];?>/Admin/images/saveIcon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['save changes'];?></div></span>
	<span style="display:none" id="closeGalButton_bottom"><div style="display:" id="newSaveIcon" onclick="cancel(1)"><img src="<?=$SITE[url];?>/Admin/images/close_icon.gif" align="absmiddle" border="0"> <?=$ADMIN_TRANS['cancel'];?></div></span>
	<div style="height:5px"></div>
		<?
	}
?>
<div id="bottomShortContent" style="padding-<?=$SITE[align];?>:10px;padding-<?=$SITE[opalign];?>:5px;" align="<?=$SITE[align];?>" class="mainContentText" style="margin-right:1px;"><?=$P_CONTENT_BOTTOM[Content];?></div>
<?
	if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<script type="text/javascript">
			var gal_editor_width="99%";
			var OrigBottomContent;
			var OrigTopContent;
			function EditBottomContent() {
				var contentDIV = document.getElementById("bottomShortContent");
				OrigBottomContent=contentDIV.innerHTML;
				var bottom_content_text=contentDIV.innerHTML;
				var buttons_str;
				var div=$('lightEditorContainer');
				buttons_str='<br><div id="newSaveIcon" class="greenSave" onclick="saveTopContent(1);"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
				buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancel(0);"><?=$ADMIN_TRANS['cancel'];?></div>';
				div.innerHTML=editorContainerLignboxDiv+buttons_str+"&nbsp;";
				editor_ins=CKEDITOR.appendTo('lightContainerEditor', {
						filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
						 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
						 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
						 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
						 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
						 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
						 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
					});
				editor_ins.setData(bottom_content_text);
				slideOutEditor("lightEditorContainer",1);
				jQuery(function() {
					jQuery("#lightEditorContainer").draggable();
				});
			}
			
			function EditTopContent() {
				var contentDIV = document.getElementById("topShortContent");
				OrigTopContent=contentDIV.innerHTML;
				var top_content_text=contentDIV.innerHTML;
				var buttons_str;
				var div=$('lightEditorContainer');
				buttons_str='<br><div id="newSaveIcon"  class="greenSave" onclick="saveTopContent(0);"><img src="<?=$SITE[url];?>/Admin/images/save-icon.png" border="0" align="absmiddle" /><?=$ADMIN_TRANS['save changes'];?></div>';
				buttons_str+='&nbsp;&nbsp; <div id="newSaveIcon" onclick="cancel(1);"><?=$ADMIN_TRANS['cancel'];?></div>';
				div.innerHTML=editorContainerLignboxDiv+buttons_str+"&nbsp;";
				editor_ins=CKEDITOR.appendTo('lightContainerEditor', {
						filebrowserBrowseUrl : editor_browsePath+'/ckfinder.html',
						 filebrowserImageBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Images',
						 filebrowserFlashBrowseUrl : editor_browsePath+'/ckfinder.html?Type=Flash',
						 filebrowserUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Files',
						 filebrowserImageUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Images',
						 filebrowserFlashUploadUrl : editor_browsePath+'/core/connector/php/connector.php?command=QuickUpload&type=Flash',
						 customConfig : '<?=$SITE[cdn_url];?>/ckeditor/config_full.js'
					});
				editor_ins.setData(top_content_text);
				slideOutEditor("lightEditorContainer",1);
				jQuery(function() {
					jQuery("#lightEditorContainer").draggable();
				});
			}
			
			function saveTopContent(top_bottom) {
				var cVal=editor_ins.getData();
				cVal=encodeURIComponent(cVal);
				var url = '<?=$SITE[url];?>/Admin/saveTitles.php';
				var cpicstype="TopForm_Content";
				if (top_bottom==1) cpicstype="BottomForm_Content";
				var pars = 'type='+cpicstype+'&content='+cVal+'&objectID=<?=$CHECK_CATPAGE[parentID];?>';
				var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:successEdit, onFailure:failedEdit, onLoading:savingChanges});
				if (top_bottom==1) jQuery('#bottomShortContent').html(decodeURIComponent(cVal));
				else jQuery('#topShortContent').html(decodeURIComponent(cVal));
				slideOutEditor("lightEditorContainer",0);
				editor_ins.destroy();
				
			}
			
			function cancel(top_bottom) {
				slideOutEditor("lightEditorContainer",0);
				editor_ins.destroy();
				if (top_bottom==1) $('topShortContent').innerHTML=OrigTopContent;
				else $('bottomShortContent').innerHTML=OrigBottomContent;
			}
			
		</script>
		<br />
		
		<?
	}
if ($C_STYLING['ContentEntranceEffect']!="" AND !isset($_SESSION['LOGGED_ADMIN'])) {
	?>
	<script src="//d3jy1qiodf2240.cloudfront.net/js/wow.min.js"></script>
	<script>
	new WOW().init();
	jQuery(document).ready(function(){
	jQuery("ul#boxes_products li").addClass("wow <?=$C_STYLING['ContentEntranceEffect'];?>");

	});
	</script>

	<?
}
	?>