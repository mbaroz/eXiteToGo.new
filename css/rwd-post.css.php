<?
$useragent = $_SERVER['HTTP_USER_AGENT'];
header("Content-Type: text/css");
$site_opalign="left";
if ($site_align=="left") $site_opalign="right";
?>
#boxes li {
    width:100%;
    margin-right:0px;
    margin-left:0px;
    padding:0 0 0 0;
    min-height:0px;
}
ul#boxes {
    margin:0px;
    opacity:1;
}

.titleContent a {padding-<?=$site_opalign;?>:4px;}
.mainContentText {padding-<?=$site_align;?>:5px;box-sizing:border-box}
.masterHeader_inner {padding:0;}
.masterHeader_wrapper {
left:0;top:0;
}

.dl-menuwrapper  {display:block}
#contentForm {margin-<?=$site_opalign;?>:20px;}
#contentForm #contact_layer, .formInput {width:100%;outline:none;zoom:1}
#contentForm input.frm_button {font-size:1em;border:0px;border-radius:0;width:102% !important}
#contentForm input.frm_button[type="reset"] {display:none}
#contact_layer select.formInput {width:102.5%;}
.mainContentText table, .footerText table {width:100% !important;}

#mini_cart #label_for_ie {margin-<?=$site_align;?>:10px;}
.shopMainCartWrapper {width:100% !important}
.shopButton{box-sizing:border-box}
#sub_mini_cart, #a_mini_cart, #in_cart_content  {width:100%}
#in_cart_content #theCartItems {width:auto}

#toTop {display:none !important;opacity:0 !important}
#cart_order_button {position:absolute;<?=$site_opalign;?>:10px;float:none}
<?

if ($catType==12 OR $catType==21 OR $catType==1 OR $catType==11) { 
    ?>
    #boxes li .photoWrapper {
        width:100% !important;
        height:100%;
        border:0px;
        background-color:transparent;
        padding:0px !important;
        margin-top:0px !important;
        
    }
    #boxes li .photoHolder {
        width:100% !important;
        height:100%;
        padding:0px !important;
        border:0px;
        background-color:transparent;
        background-image:none;
        margin-right:0px !important;
        margin-left:0px !important;
    }
    ul#boxes {padding:0}
    #boxes li.wide #printArea{width:auto;padding-<?=$site_opalign;?>:6px;}
    #boxes li #printArea div.mainContentText{padding-<?=$site_opalign;?>:6px;padding-<?=$site_align;?>:0px !important;overflow:inherit}
    #boxes li div div.shortContentTitle {padding-<?=$site_align;?>:0px !important;}
    #boxes li div div.topShortContentTitle {padding-<?=$site_align;?>:6px !important;}
    
<?
    
}
if ($catType==2) {
      ?>
        ul.boxes {width:100%;padding-right:0px;margin:0 0px 0px 6px;display:block}
        .boxes li {
            padding:0;width: 100%;
            margin-bottom:1px;
            margin-top:1px;
            margin-left:2px;
            margin-right:0px;
            border:0px;
            background-position:center;
            background-repeat:no-repeat;
        }
        
        .boxes li .photoWrapper {background-color:transparent;border:0px;width:auto}
        .boxes li .photoHolder {background-color:transparent;padding:3px;background-image:none;border:0px; }
        .boxes li .photoWrapper img {opacity:1}
        .boxes li .photoName {font-size:0.8em;padding-<?=$site_align;?>:4px;padding-<?=$site_opalign;?>:4px;padding-top:0px;width:100%;margin:3px;}
        <?
        if (!$collageGallery) {
            ?>
            .boxes {padding:0px;}
            //.boxes li .photoName {display:none}
            .boxes li .photoWrapper img {opacity:0 !important}
            .boxes li .photoWrapper a {display:block;width:100%;height:100%;}
            .boxes li .photoHolder{width:100%;height:100%;overflow:hidden;}
            .boxes li .photoWrapper {display:block;width:100%;height:100%;}
            .boxes li {background-size:cover}
            <?
        }
}
    
    
if ($catType==0) {
    ?>
    #boxes {padding-<?=$site_align;?>:8px;}
    #boxes li .mainContentText {padding-<?=$site_opalign;?>:20px;}
    <?
}
if ($catType==17) {
    ?>
    
    <?
}
if ($shop_productPage>0) {
	?>
	.oneProduct {width:100%;padding:0;}
	.oneProduct .left_part > div {margin:0px !important;width:100% !important}
	.oneProduct .left_part {width:100%;float:none;margin:0px;}
	.oneProduct .right_part {width:100%;float:none}
	.oneProduct .left_part #more_pics {width:100%;padding:0}
	.oneProduct .left_part #more_pics .pic {width:auto;padding:0}
	.oneProduct .left_part #more_pics .pic .inpic img {max-width:100%;}
	<?
}
?>
    .mainContentText input.login_text {width:98%;background-color:#fff;color:#333;padding:3px;height:30px;font-zise:14px;border:0px;outline:none;box-shadow: 2px 2px 2px #888;-webkit-box-shadow: 2px 2px 2px #888;}
    .mainContentText input.login_button {width:100%;height:30px;}
  .leftColumn_right, .rightColCustom {float:none;width:100%}
  .leftColumn {width:100%;min-height:1px !important;border:0px;}
  .leftColumn_border{width:100%;margin:5px;border:0px}
  
.mobile_credit {float:<?=$site_align;?>;font-size:12px;}
.mobile_credit a {text-decoration: none;color:inherit}
.mobile_credit img{margin:6px;vertical-align:middle;max-height:35px;}

table.mobileview {
    height:auto !important;
}

table.mobileview th, table.mobileview thead, table.mobileview tbody {width:auto !important}
table.mobileview td {width:92% !important;padding:inherit;}
table.mobileview, table.mobileview thead, table.mobileview tr, table.mobileview th, table.mobileview th, table.mobileview td, .footerText table, .footerText thead, .footerText tbody, .footerText th, .footerText td, .footerText tr, .mainContentText #printArea table, .mainContentText#printArea  thead, .mainContentText#printArea  tbody, .mainContentText #printArea th, .mainContentText #printArea td, .mainContentText #printArea tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	.mainContentText #printArea  thead tr, .footerText thead tr, table.mobileview thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	
	
	.mainContentText #printArea td, .footerText td { 
		/* Behave  like a "row" */
		border: none;
		position: relative;
		padding-<?=$site_opalign;?>: 50%; 
	}
	
	.mainContentText #printArea td:before, .footerText td:before, table.mobileview td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-<?=$site_align;?>: 10px; 
		white-space: nowrap;
	}
