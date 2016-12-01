<?
header("Content-Type: text/javascript");
if ($catType=="") $catType=0;
?>
var rwdDone=0;
var rwdBack=0;
var rwdIframeEffectGalleryDone=0;
var rwdTablesDone=0;
var rwdSize;
var scriptsLoaded=0;
var catType=<?=$catType;?>;
var galType="<?=$galType;?>";
var fixedToolbarOpen=false;
var loaded=0;
var mobile_logo="<?=$_GET['mobilelogo'];?>";
var mobile_mainpic_photo="<?=$_GET['mobilemainpichomepage'];?>";
var productPage="<?=$_GET['shop_productPage'];?>";
var media_url="/gallery";
<?
if ($_GET['aws_s3_enabled']==true) {
    ?>
    media_url="<?=$_GET['site_media'];?>/gallery";
    <?
}
?> 
rwdSize=jQuery(window).width();

if (rwdSize<680) {
    //jQuery('iframe').not('[id^="iframe_gallery"]').not('[id^="iframe_shortContent"]').not('[id^="iframe_form"]').not('[id^="search_content"]').addClass("hideElement");
    jQuery('iframe[src^="//www.youtube"]').removeClass("hideElement");
    jQuery('iframe[src^="http://www.youtube"]').removeClass("hideElement");
    jQuery('iframe[src^="https://www.youtube"]').removeClass("hideElement");
    jQuery('iframe[src^="//player.vimeo"]').removeClass("hideElement");
    jQuery('iframe[src^="http://player.vimeo"], iframe[src^="https://player.vimeo"]').removeClass("hideElement");
    jQuery('iframe[src^="https://w.soundcloud"]').removeClass("hideElement");
    //if (jQuery('#headerMaster_marginizer').length>0) jQuery('#headerMaster_marginizer').css("min-height",jQuery(".masterHeader_wrapper").height()+"px");
    
}


var contact_open=0;
var lastScrollTop = 0;
var footerHidden=0;
 if (!rwdDone && rwdSize<680) {
       if (jQuery(".mobileLogoMasterHeader").length>0) {
            jQuery(".mobileLogoMasterHeader").before(jQuery(".topHeaderLogo"));
            jQuery(".topHeaderLogo").before(jQuery(".dl-menuwrapper"));
        }
        else  jQuery(".topHeaderLogo").before(jQuery(".dl-menuwrapper"));
 }

function isScrolledIntoView_exite(elem)
{
    var docViewTop = jQuery(window).scrollTop();
    var docViewBottom = docViewTop + jQuery(window).height();

    var elemTop = jQuery(elem).offset().top;
    var elemBottom = elemTop + jQuery(elem).height();

    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom)
      && (elemBottom <= docViewBottom) &&  (elemTop >= docViewTop) );
}
function loadFixedToolbarContent(type) {
    contact_open=0;
    jQuery(".outer").load("/LoadAjaxContent.php?type="+type);
    if (type=="contact") contact_open=1;
}
function loadScripts2Dom(sName) {
    var scriptName=sName;
    (function() {
            var st = document.createElement('script'); st.type = 'text/javascript'; st.async = true;
            st.src=scriptName;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(st, s);
            
        })();
    scriptsLoaded=1;
};    

function toggleFixedToolbar(type) {
    if (type=="phone" || type=="exite_topTop" || type=="shopping_cart" || type=="wu") {
        if (type=="phone") {
            loadFixedToolbarContent("countCalls");
            if (typeof(ga)=="undefined") _gaq.push(['_trackEvent', 'Calls From Mobile', 'Call', 'Clicked on Call']);
            else ga('send','event','Calls From Mobile', 'Call', 'Clicked on Call');
        }
        return;
    
    }
    //contact_open=0;
    if (fixedToolbarOpen) {
        jQuery("html").removeClass("modal-noscroll");
        jQuery(".fixed_footer.open").removeClass("open");
        jQuery(".fixed_footer .inner .icon").removeClass("opened");
        fixedToolbarOpen=false;
        jQuery(".fixed_footer .inner .icon_close").hide();
    }
    else {
        jQuery("html").addClass("modal-noscroll");
        jQuery(".fixed_footer").addClass("open");
        jQuery(".fixed_footer .inner #"+type).addClass("opened");
       
        if (loaded!=type) {
            if (contact_open==0 || type!="contact") {
                jQuery('.outer').html('<i class="fa fa-refresh fa-spin fa-2x" style="margin-top:40%"></i>');
                window.setTimeout('loadFixedToolbarContent("'+type+'");',1400);
                
            }
            loaded=type;
        }
        fixedToolbarOpen=true;
        jQuery(".fixed_footer .inner .icon_close").show();
    }
     
}
function BindFixedFooter() {
    jQuery(".fixed_footer .inner>div").click(function() {
        toggleFixedToolbar(jQuery(this).attr('id'));
        });
        jQuery(window).scroll(function(event){
            var st = jQuery(this).scrollTop();
            if (st > lastScrollTop && st>150){
                 if (footerHidden==0) {
                    jQuery(".fixed_footer").addClass("hiddenFooter");
                    jQuery("#mini_cart").addClass("go_down");
                    footerHidden=1;
               }
            } else {
               if (footerHidden) {
                    jQuery(".fixed_footer").removeClass("hiddenFooter");
                    jQuery("#mini_cart").removeClass("go_down");
                    footerHidden=0;
               }
            }
            lastScrollTop = st;
         });

    
}
function rwdGlobal() {
    if (scriptsLoaded==0) {
      //  loadScripts2Dom('/js/jquery.lazy.min.js');
        
    }
    if (!rwdIframeEffectGalleryDone) {
        //jQuery(".topHeaderLogo").before(jQuery(".MobileMenuWrapper"));
        if (jQuery('iframe[id^="iframe_gallery"]').length>0) jQuery('.mainContentText iframe[id^="iframe_gallery"]').attr("src",jQuery('iframe[id^="iframe_gallery"]').attr("src").replace("iframe_effectGallery.php","iframe_effectGallery.mobile.php"));
        if (mobile_logo) jQuery(".topHeaderLogo img").attr('src',media_url+'/sitepics/'+mobile_logo);
        if (mobile_mainpic_photo && jQuery(".mobile_mainpic_homepage").length>0) jQuery(".mobile_mainpic_homepage").html('<img src="'+media_url+'/sitepics/'+mobile_mainpic_photo+'" border="0" />');
        else {
            if (jQuery(".staticHeadPic").length>0) jQuery(".mobile_mainpic_homepage").html('<img src='+jQuery("img.staticHeadPic").attr("src")+' border="0" />');
        }
      
        rwdIframeEffectGalleryDone=1;
    }
}


function refreshGridView() {
        var screenResW=jQuery(window).width();
        var gridWidth=Math.round(screenResW/3)-3;
        var mobile_imagesSizeReduce="contain";
        if (mobileReduceImageSize!="100") mobile_imagesSizeReduce=mobileReduceImageSize+"%";
        if (mobileColumnsCount/1) gridWidth=Math.round(screenResW/mobileColumnsCount)-2;
        if (mobileColumnsCount==1) {
            jQuery(".boxes li").css({
			'width':'100%',
			'line-height':(gridWidth-2)+'px',
                        'height':'235px',
                        'margin-bottom':'12px',
                        'background-size':mobile_imagesSizeReduce,
                        'margin-right':'-7px'
		});
        }
        else {
            jQuery(".boxes li").css({
			'width':gridWidth-2+'px',
			'height':gridWidth+'px',
			'line-height':(gridWidth-2)+'px',
                        'border-bottom':'0px'
		});
        }
        
         $listContainer.isotope('reLayout');
}

function setGridView() {
		
        var screenResW=jQuery(window).width();
        var gridWidth=Math.round(screenResW/3)-2;
             
                 jQuery (".photoGalley_filter").click(function() {
                         jQuery(".boxes li").lazy({bind:'event',delay:0});
                });
                jQuery(".boxes li").lazy({enableThrottle: true,throttle: 100,threshold:690,effect:'fadeIn',effectTime:200,afterLoad:function() {
                         jQuery(".boxes li .photoWrapper .video_button").show();                
                        }
                 });
               
		//jQuery(".boxes li").each(function(index) {
			//var i_s=jQuery(this).find(".photoWrapper img").attr("src");
		//	var i_s=jQuery(this).attr("data-src");
                        //i_s=i_s.replace("/tumbs","");
                        
		//	var cellID=jQuery(this).attr("id");
			
                        //if (rwdDone==0) jQuery(this).css("background-image",'url("' + i_s + '")');
			//jQuery(this).css("background-size","cover");
			//jQuery("#"+cellID+" .photoWrapper img").load(function(){
			//	var i_w=jQuery(this).width();
			//	var i_h=jQuery(this).height();
			//	if (i_w<i_h) jQuery("#"+cellID).css("background-size",gridWidth+"px auto");
			//	else jQuery("#"+cellID).css("background-size","auto "+gridWidth+"px");
				
			//});
			//jQuery(this).find(".photoWrapper img").load();
		//});
		
		galleryDefaultView="grid";
                 if (rwdDone==0) {
                    refreshGridView();
                    setGalleryLightBox();
                   
                    rwdDone=1;
                }
}
function rwdCollageGallery() {
        var cols=2;
        
        var screenResW=jQuery(window).width();
        if (screenResW>480) cols=3;
	    var gridWidth=Math.round(screenResW/cols)-2;
        if (mobileColumnsCount==1) {
            cols=1;
            if (screenResW>480) cols=2;
            gridWidth=Math.round(screenResW/cols)-10;
        }
        
        jQuery(".boxes li .photoName").css({'width':gridWidth-16+'px'});
            //jQuery(".boxes li .photoName").append('</div>');
        jQuery(".boxes li").css({'width':gridWidth-2+'px'});
         
        jQuery(".boxes li").each(function(index) {
            var i_s=jQuery(this).find(".photoWrapper img").attr("src");
            i_s=i_s.replace("/tumbs","");
            jQuery(this).find(".photoWrapper img").attr("src",i_s);
            jQuery(this).find(".photoWrapper img").css({'max-width':gridWidth-8+"px"});
                           // jQuery(this).find(".photoWrapper img").load(function() {
                         //   var i_w=jQuery(this).width();
                           
                       // });
			//var cellID=jQuery(this).attr("id");
			//jQuery(this).css("background-image",'url("' + i_s + '")');
			
			//jQuery(this).find(".photoWrapper img").load(function(){
			//	var i_w=jQuery(this).width();
			//	var i_h=jQuery(this).height();
			//	jQuery("#"+cellID).css("min-height",i_h+"px");
                          //      if (i_w<i_h) jQuery("#"+cellID).css("background-size",gridWidth+"px auto");
			//	else jQuery("#"+cellID).css("background-size","auto "+gridWidth+"px");
				
			//});
			//jQuery(this).find(".photoWrapper img").load();
                        
		});
           
        window.setTimeout("$listContainer.isotope('reLayout');",150);
        if (rwdDone==0) {
            setGalleryLightBox();
            rwdDone=1;
        }
        
}
function setGalleryLightBox() {
            if (jQuery("a.photo_gallery").length>0) {
                jQuery("a.photo_gallery").addClass("enlarge");
                jQuery("a.photo_gallery").unbind("click");
                jQuery("a.photo_gallery").removeClass("photo_gallery");
                var myPhotoSwipe = jQuery(".boxes li  a.enlarge").photoSwipe({ enableMouseWheel: true , enableKeyboard: true,backButtonHideEnabled:false });
            }
            if (jQuery("a.fancybox").length>0) {
               jQuery("a.fancybox").addClass("enlarge");
                jQuery("a.fancybox").unbind("click");
                jQuery("a.fancybox").removeAttr("data-fancybox-group");
                jQuery("a.fancybox").removeClass("fancybox");
                var myPhotoSwipe = jQuery(".boxes li  a.enlarge").photoSwipe({ enableMouseWheel: true, enableKeyboard: true,backButtonHideEnabled:false });
            }
           if (jQuery("a.fancybox-thumbs").length>0) {
                jQuery("a.fancybox-thumbs").addClass("enlarge");
                jQuery("a.fancybox-thumbs").unbind("click");
                jQuery("a.fancybox-thumbs").removeAttr("data-fancybox-group");
                jQuery("a.fancybox-thumbs").removeClass("fancybox-thumbs");
                var myPhotoSwipe = jQuery(".boxes li  a.enlarge").photoSwipe({ enableMouseWheel: true , enableKeyboard: true,backButtonHideEnabled:false });
            }
}
function rwdForms() {
        //jQuery("#contact_layer input.frm_button").width(jQuery("#contact_layer .formInput").width()-25+"px");
        jQuery("#contact_layer input.customFormDate").attr("readonly","true");
        jQuery("#inputs div>label").each(function() {
            var input_label=jQuery(this).text();
            if (input_label=="טלפון") {
                jQuery("#"+jQuery(this).attr("for")).attr("type","number");
                jQuery("#"+jQuery(this).attr("for")).attr("pattern","[0-9]*");
            }
            if (input_label=="אימייל" || input_label=="כתובת אימייל" || input_label=="Email" || input_label=="Email address")   jQuery("#"+jQuery(this).attr("for")).attr("type","email");
                
        });
}
function rwdShortContent(rwdSize) {
    
    
}
function rwdTables() {
    if (rwdTablesDone==0) {
            //jQuery(".mainContentText table, .middleContentText table").addClass("responsive");
            jQuery(".middleContentText table").not(".mobileview").wrap('<div class="tablesWrapper">');
            //jQuery(".mainContentText table").wrap('<div class="tablesWrapper">');
              if (jQuery(".tablesWrapper").length>0) {
                if (isScrolledIntoView_exite(jQuery(".tablesWrapper"))) jQuery(".tablesWrapper table").addClass("exite_scroll_animate");
              }
            rwdTablesDone=1;
    }
}
 function desktopShortContent() {
          jQuery("#boxes li .photoWrapper img").each(function(){
                var articleImgSrc=jQuery(this).attr('src');
                var newArticleImgSrc=articleImgSrc.replace("/gallery/","/gallery/articles/");
                
                jQuery(this).attr("src",newArticleImgSrc);
                
        });
          rwdDone=0;
          rwdBack=1;
}

function rwdShopProductPage() {
		jQuery(".oneProduct .right_part").before(jQuery(".left_part"));
}

function rwdShortContentCollage(rwdSize) {
        //jQuery("#boxes li.wide, #boxes li.wide div").css({"width":"","padding":"0px"});
        //jQuery("#boxes li.wide div").css({"width":"","padding-left":"2px","padding-right":"2px"});
        //jQuery("#boxes li.wide div").css({"width":(rwdSize-15)+'px'});
        
        jQuery("#boxes li").find("div[id*='short_content_container']").css({"width":"auto","float":"none","padding":"0 6px"});
        jQuery("#boxes li .photoWrapper img").each(function(){
                var articleImgSrc=jQuery(this).attr('src');
                var newArticleImgSrc=articleImgSrc.replace("articles/","");
                
                jQuery(this).attr("src",newArticleImgSrc);
                
        });
        jQuery("#boxes li div.photoWrapper").addClass("brief_photo");
        jQuery("#boxes li").css("width","");
        jQuery("#boxes li .photoHolder, #boxes li .photoWrapper").removeClass("custom");
         if (jQuery("a.photo_gallery").length>0) {
            jQuery("a.photo_gallery").addClass("enlarge");
            jQuery("a.photo_gallery").unbind("click");
            jQuery("a.photo_gallery").removeClass("photo_gallery");
            var myPhotoSwipe = jQuery(".brief_photo a.enlarge").photoSwipe({ enableMouseWheel: true , enableKeyboard: true });
         }
        //jQuery("ul#boxes").addClass("opacityMe_off");
        if (catType==21) jQuery('#boxes').masonry('destroy');
        rwdDone=1;
        rwdBack=0;
}
function showBubble() {
     jQuery(".eXite.bubble").addClass("open");
     jQuery(".eXite.bubble").click(function() {
        jQuery(".eXiteBubbleOverlay").addClass("open");
     })
}

if (rwdSize<680) rwdGlobal();
jQuery(document).ready(function() {
     if (rwdSize<680) {
            
            BindFixedFooter();
            //rwdGlobal();
            rwdTables();
            if (catType==12 || catType==21 || catType==1 || catType==11)  {
                rwdShortContentCollage(rwdSize);
            }
            if (catType==17) {
                    //jQuery("#boxes li div[id^='short_content_container_']").css("float","none");
                     rwdForms();
            }
            if (catType==2 && galType==0) {
                  if (this_is_collage_gal==0) setGridView();
                  else {
                    rwdCollageGallery();
                    window.setTimeout("jQuery(window).resize();",700);
                  }
                
            }
            if (productPage!="") rwdShopProductPage();
            //loadFixedToolbarContent('contact');
      }
});

var w_width = jQuery(window).width(), w_height = jQuery(window).height();
jQuery(window).resize(function() {
        rwdSize=jQuery(this).width();
        if (rwdSize<680 && rwdSize!=w_width) {
            rwdShortContent(rwdSize);
            rwdForms();
            rwdGlobal();
            //rwdTables();
            if (catType==2 && galType==0) {
                if (this_is_collage_gal==0) setGridView();
                else rwdCollageGallery();
                
            }
            if (!rwdDone) {
                 if (catType==12 || catType==21 || catType==1 || catType==11)  rwdShortContentCollage(rwdSize);
            }
        }
        else {
            if (rwdDone==1 && rwdSize!=w_width) {
                 if (catType==12 || catType==21 || catType==1 || catType==11) desktopShortContent();
            }
        }
});
jQuery(window).bind('orientationchange',function() {
    if (catType==2 && this_is_collage_gal==0) refreshGridView();
    if (catType==2 && this_is_collage_gal==1) rwdCollageGallery();
        });
