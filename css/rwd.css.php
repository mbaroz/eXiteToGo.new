<?
$useragent = $_SERVER['HTTP_USER_AGENT'];

header("Content-Type: text/css");
?>
html {font-size: 100%}
body, .mainContentText, .middleContent, .topShortContent, .bottomShortContent {
    font-size:1rem;
    line-height:1;
    box-sizing:border-box;
}
<?
if ($_GET['hide_all_bgs']==1) {
    ?>
    body, .mainPage, .footer_bg, .footerTopColor, .topHeaderMain, .topHeader, .topHeaderFull, .topHeaderMain, .topHeaderMainFull, .mainContentFull, .mainContentSeperated, .mainContentContainer, .middleContent, .middleContentFull, .shadow_layer, .masterFooter_wrapper {
        background: none;
        background-color: transparent;
        background-image: none;
    }
    .masterHeader_wrapper {background-image: none;}
    <?
}
?>
body {
    <?
    if ($_GET['mobile_bg_color']) {
        ?>
        background-color: #<?=$_GET['mobile_bg_color'];?>;
        <?
    }
    ?>
}
@media only screen and (max-width: 320px), only screen and (max-device-width: 320px) {
    body, .mainContentText {
    font-size:1rem;
    }
    
}
.topHeader, .topHeaderMain, .topMainPic, .middleContent, .middleContentText, .mainContentSeperated, .masterHeader_inner, .masterHeader_inner_bottom_menu, .mainContentContainer, .topHeaderSlogen, .masterHeader_innerTopMenu, .masterHeader_inner_bottom_menu, iframe#iframe_gallery, .footer{
    width:100%;
    padding:0;
}
iframe {width:100%;}

#master_header_content {padding-right:7px;padding-left:7px;width:auto;}
.mainContentText div {width:100% !important}
.facebook_like_box {display:none}
.mainContentText img, .mainContentText object, .middleContentText img, .mainContentText embed {height:auto !important;max-width: 100%; padding:0px !important}
.topHeaderLogo {float:none;text-align: center;min-height:65px}
.topHeaderLogo img {display: inherit;max-height: 65px;max-width: 250px;}
.middleContentText  {padding:0px;width:97%}
.middleContent{padding:5px;}
.topMainPic #galleria {
    width:100%;
}
#marginizer {margin-top:0px !important}
.masterHeader_inner_bottom_menu {width:auto}
.topHeaderMain, .topHeaderSlogen, .topHeaderTopMenu, .roundBox, .search_frm_div, #footerMaster_marginizer, .masterFooter_wrapper {
    display: none;
}
<?
if ($_GET['show_main_gallery_mobile']=="true") {
    ?>
    .topHeaderMain {display:block;}
    .ls-l div span, .ls-l span {font-size:3em !important}
    .ls-l span {box-sizing:border-box;padding:7px;}
    <?
}
?>
.topHeader {min-height:68px;}

.footerText {width:inherit;padding:10px;}
.footer_bg {min-height:15px;}
.footer_bg, .footerWide, .footerFull, .footer {background-color: transparent;background: none;background-image: none;}
.masterHeader_wrapper {position:fixed !important;height: auto;min-height:65px;}
#headerMaster_marginizer{display:block !important;min-height:65px;}
.topMainPic #galleria #galleria-container {
    height:auto;
}
.text_logo_insite {text-overflow:ellipsis;overflow-x:hidden}
.mobileLogoMasterHeader{display: block}
.leftSide {
    margin-right:0px;margin-left:0px;
}
#topmainpic_margin_height {margin-top:0 !important;height:0 !important}
.widePage {margin-right:0px;margin-left:0px;}
.exite_slideOutContent, .topMenuNew, .rightSide  {
    display: none;
}
.mainContent, .leftSide {
    width:100%;
}
.setAbsolute {position: absolute !important}
.mainPage {
    
    <?
    if ($_GET['mobileheaderbgpic']) {
        $mobileheader_bg_pic=$_GET['mobileheaderbgpic'];
        ?>background:transparent url('//cdn.exiteme.com/exitetogo/<?=$_SERVER['SERVER_NAME'];?>/gallery/sitepics/<?=$mobileheader_bg_pic;?>') no-repeat;
        <?
    }
    else {
        if ($_GET['show_top_bg']==0) {
            ?>
            background-image: none;
            <?
        }
    }
    
    ?>
    
}
.marginizer {margin-top:0px !important}
.mobile_mainpic_homepage {width:100%;padding:0;background: #efefef;display:block;text-align: center}
.mobile_mainpic_homepage img {height:auto;max-width: 100%}
#contentForm #contact_layer, .formInput {width:100% !important;outline:none;zoom:1}
#contentForm input.frm_button {font-size:1em;border:0px;border-radius:0;width:102% !important}

.contentOuter {border-right:0px;padding:0px;min-height:10px !important}
ul#boxes, #boxes li {width:100%;}
#boxes li.wide, #boxes li.wide div {width:100%;padding:0}
#boxes li .short_content_roundBox, .middle_roundBox {display: none}
#boxes li .innerDiv {width:100% !important;padding:0 !important;min-height:0 !important;}
#boxes li > div {margin-right:0px!important;margin-left:0px!important;}
#boxes {opacity: 0;}
div.brief_photo {
    padding: 0px;
    border:0px solid silver;
    text-align: center;
    background: transparent;
    //padding-bottom: 56.25%; /* 16:9 ratio */
    //position: relative;
    margin-top:5px;
    margin-bottom:5px;
    overflow: hidden;
    display: block;
    }
    .brief_photo img {
    max-width:100%;max-height: 100%;
    padding: 0;
    vertical-align: middle;
    //position: absolute;
    top: 0;
    left: 0;
    //height:100%;width:100%;
}
.mm_button_wrapper, .dl-menuwrapper {display:block}
.tablesWrapper {
    width:100%;
    overflow-x:auto;
    padding:0;
    margin:0;

}
.tablesWrapper .sidesShadow {
    width:15px;background: #ffffff;
    box-shadow:   0 0 20px #333333;
   position: absolute;
   top:0px;
   right:0px;
   font-size: 30px;
   font-weight: bold;
   direction: ltr;
   cursor: pointer;
}
.sidesShadow.left {left:2px;right:auto;direction: rtl;}
.tablesWrapper table tr td,.tablesWrapper table tr th {
    white-space: nowrap;
}
.tablesWrapper table.mobileview tr td {white-space: normal}

.boxes {display: block;}
.boxes .photoWrapper img {opacity: 0}
.boxes li .photoWrapper a{display: block;}
.boxes li .photoHolder {background-image:none !important}
.boxes li .photoWrapper .video_button {display: none}
.boxes li.grid {
    float:right;
    margin-bottom:1px;
    margin-top:1px;
    margin-left:2px;
    margin-right:0px;
    border:0px;
    background-color: transparent;
    background-position:center;
    background-repeat:no-repeat;
}
.boxes li.grid .photoWrapper img {
    //opacity:0;
}
.boxes li .photoWrapper {background: transparent}
#site_wide_footer {display: none}
.fixed_footer_marginizer {height:20px;clear: both}
.fixed_footer {
    width:100%;
    zoom:1;
    z-index: 10000;
    background: rgba(0, 0, 0, 0.8);
    display: block;
    position: fixed;
    bottom:-100%;left:0;
    height:100%;
    margin-bottom:50px;
    transition:all 0.3s;-webkit-transition:all 0.3s;-moz-transition:marallgin 0.3s;
    
}
.fixed_footer.hiddenFooter {
    margin-bottom:0px;
    transition:margin 0.2s;-webkit-transition:margin 0.2s;-moz-transition:margin 0.2s;
}
.fixed_footer .inner {
    padding:0px 10px 0px 0px;
    font-size: 1em;
    color:white;
    text-align: left;
    height:49px;
}
.fixed_footer .inner div.icon {float:right;padding:5px;border-right:1px inset #333333;min-width:50px;text-align: center;cursor: pointer;height: 30px;margin-top:5px;}
.fixed_footer .inner div.icon#shopping_cart{float:left;}
.fixed_footer .inner div:first-child {border-right:0px;}
.fixed_footer .inner div.icon a {text-decoration: none;color:white;font-size: 14px;}
.fixed_footer .inner div.icon.opened {background: #fff;color:#000}
.fixed_footer .outer {border-top:1px inset #ffffff;min-height:0px;color:white;margin-bottom:0px;background: rgba(0, 0, 0, 1);height:0px;}
.fixed_footer.open {bottom:-50px;transition:bottom 0.5s;-webkit-transition:bottom 0.5s;-moz-transition:bottom 0.5s;overflow-y: auto;overflow-x: hidden}
.fixed_footer .inner div.icon_close {display: none;font-size:2em;float:left;padding:0px 0 0px;border-right:0px inset #333333;min-width:50px;text-align: center;cursor: pointer;margin-top:5px;}
.fixed_footer .inner div.icon_close div {transform:rotate(45deg);-ms-transform:rotate(45deg);-webkit-transform:rotate(45deg);}
.modal-noscroll
{
    position: fixed;
    overflow-y: scroll;
    width: 100%;
}
#mini_cart {display:}
#mini_cart {width:100% !important;bottom:50px !important;transition:bottom 0.2s;-webkit-transition:bottom 0.2s;-moz-transition:bottom 0.2s;}
#mini_cart.go_down {bottom:0px !important;transition:bottom 0.2s;-webkit-transition:bottom 0.2s;-moz-transition:bottom 0.2s;}

.mainContentText .no-mobile, .mainContentText .hidemobile, .middleContentText .hidemobile, #topSlogen .hidemobile, .ls-l .hidemobile, .footerText .hidemobile {display: none}
.mainContentText .mobileonly, .mainContentText .mobileonly, .middleContentText .mobileonly, .footerText .mobileonly {display: inherit}
.hideElement{display: none}
iframe#iframe_search {display: none}
.exite.buttonWrapper {
    	cursor: pointer;
        height:25px;
	min-width:50px;
        background-color: #f3f3f3;
        background-image: -ms-linear-gradient(top, #f3f3f3 0%, #ebebeb 100%);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #f3f3f3), color-stop(1, #ebebeb));
        background-image: linear-gradient(to bottom, #f3f3f3 0%, #ebebeb 100%);
       background-image: -webkit-linear-gradient(top, #f3f3f3 0%, #ebebeb 100%);
       background-image: -moz-linear-gradient(top, #f3f3f3 0%, #ebebeb 100%);
       color:black;
       font-size:13px;
       font-weight: bold;
       font-family: arial;
       border-radius:4px;
       line-height: 25px;
       padding:5px 10px 5px 10px;
        border:1px solid #e4e4e4;
        -moz-box-shadow: 0 0 3px #ebebeb;
        -webkit-box-shadow: 0 0 3px #ebebeb;
        box-shadow: 0 0 3px #ebebeb;
}
.photoWrapper .video_button {top:auto !important;width:100% !important;height:100% !important}
.opacityMe{opacity: 0;}
.opacityMe_off{opacity: 1;transition:opacity 1s}
.exite.circle_arrow {width:30px;height:30px;border-radius:30px;-webkit-border-radius:30px;-moz-border-radius:30px;line-height: 25px;text-align: center;padding:2px}
#ProductDescription{width:100%;}
.oneProduct > div > div{float:none !important;width:100% !important}

ul#boxes_products{padding:0px;margin:0px;}
ul#boxes_products li {
    width:48%;
    box-sizing:border-box;
    margin-left:5px;margin-right:5px;
   
}
@media only screen and (max-width: 500px), only screen and (max-device-width: 500px) {
    ul#boxes_products li { width:47%;}
}
@media only screen and (max-width: 330px), only screen and (max-device-width: 330px) {
    ul#boxes_products li { width:46%;}
}
@media only screen and (max-width: 250px), only screen and (max-device-width: 250px) {
    ul#boxes_products li { width:45%;}
}
@media only screen and (max-width: 200px), only screen and (max-device-width: 200px) {
    ul#boxes_products li { width:44%;}
}
ul#boxes_products li .li_content .pic {width:100%;box-sizing:border-box}
ul#boxes_products li .li_content .pic img {max-width:94%}

.eXite.bubble {
    z-index:200000;
    display: block;
    opacity: 0;
    width: 0px;height:0px;
    border-radius: 43px;
    display: none;
    padding:3px;
    background:#fff;
    position:fixed;
    bottom:7px;left:20px;
    -webkit-transition: opacity 0.2s, width 0.5s, height 0.5s;transition: opacity 0.2s, width 0.5s, height 0.5s;
    
}
.eXiteBubbleOverlay {
    position: absolute;
    bottom:0;left:0;
    background: #fff;
    background: rgba(255,255,255,0);
    width:100%;height: 100%;
    z-index:100000;
    display: none;
}
.eXiteBubbleOverlay.open {
    background: rgba(255,255,255,0.75);
    -webkit-transition: background 0.7s;transition: background 0.7s;
}
.eXite.bubble div {
    background: #000;
    background: rgba(0,0,0,0.6);
    width:100%;height:100%;
    border-radius: inherit;
    color:white;
}
.eXite.bubble div i {
    line-height: 35px;
    font-size: 16px;
}
.eXite.bubble.open {
    opacity: 1;
    width:32px;height:32px;
    -webkit-transition:opacity 0.2s,width 0.4s, height 0.4s;transition: opacity 0.2s,width 0.4s, height 0.4s;
}
.eXite.bubble:hover {
    background: rgba(255,255,255,1);
    -webkit-transition:background 0.8s;transition: background 0.3s;
}

@-webkit-keyframes ting /* Safari and Chrome */ {
  0%   {padding-right:0;}
  10%  {padding-right:10px;}
  50%  {padding-right:20px;}
  70%  {padding-right:10px;}
  100%  {padding-right:0px;}

}
.exite_scroll_animate {-webkit-animation: ting 1.5s linear 2;}

