function initCustomLightBox() {
	var lb='<style>#overlayLB.show{opacity:0.8;visibility:visible;z-index:890;}#overlayLB{z-index:0;visibility:hidden;-webkit-transition:opacity 0.2s;width:100%;height:100%;background-color:#000;opacity:0;position:absolute;top:0;left:0}.CenterBoxContent .text_container{margin:10px auto;text-align:right;max-width:600px}.CenterBoxWrapper.hide{display:none;transform:scale(0.2)} .CenterBoxWrapper{max-width:650px;width:auto;min-height:10px;trasition:all 0.5s;transform:scale(1)}</style><div id="overlayLB"></div><div id="cLB" class="CenterBoxWrapper" style="display:none;z-index:1000;background-color:white;text-align:center"><div class="CenterBoxContent" style="background-color:transparent;"><div class="img_container"></div><div class="text_container"></div></div></div>';
	if (jQuery(".CenterBoxWrapper").length<1) jQuery("body").append(lb);
	jQuery("li .photoWrapper a.photo_gallery").unbind("click");
	
	jQuery("li .photoWrapper a").click(function() {
		showBigImage(jQuery(this));
		return false;
	});
}
function showOverlayLB(s){
	if (s) {
		jQuery("#overlayLB").height(jQuery(window).height()+jQuery(window).scrollTop()+"px");
		
		jQuery("#overlayLB").addClass("show");
		jQuery(".CenterBoxWrapper").show();
	}
	else {
		jQuery("#overlayLB").removeClass("show");
		jQuery(".CenterBoxWrapper").hide();
	}
}
function closeBigBox() {
	
	showOverlayLB(0);
}
function showBigImage(o) {
		var imgSRC=jQuery(o).attr("href");
		var textContent=jQuery(o).parent().parent().parent().parent().find("#printArea .mainContentText").html();

		var fullImgCode='<img src="'+imgSRC.replace("/articles","")+'" style="max-width:600px" />';
		//console.log(textContent);
		
		jQuery(".CenterBoxWrapper").css("top",(jQuery(window).scrollTop()+50)+"px");
		showOverlayLB(1);
		
		jQuery("#overlayLB").not(".CenterBoxWrapper").click(closeBigBox);
		jQuery(".CenterBoxContent .img_container").html(fullImgCode);
		jQuery(".CenterBoxContent .text_container").html(textContent);
		
}
jQuery(document).ready(function(){
	jQuery("li #printArea .mainContentText").hide();
	window.setTimeout('initCustomLightBox()',1000);

});