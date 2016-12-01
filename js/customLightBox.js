function initCustomLightBox() {
	var lb='<style>#overlayLB.show{opacity:0.8;visibility:visible;z-index:890;}#overlayLB{z-index:0;visibility:hidden;-webkit-transition:opacity 0.2s;width:100%;height:100%;background-color:#000;opacity:0;position:absolute;top:0;left:0}.CenterBoxContent .text_container{margin:10px auto;text-align:right;max-width:600px}.CenterBoxWrapper.hide{display:none;transform:scale(0.2)} .CenterBoxWrapper{max-width:750px;width:auto;min-height:10px;trasition:all 0.5s;transform:scale(1);border-radius:0}</style><div id="overlayLB"></div><div id="cLB" class="CenterBoxWrapper" style="display:none;z-index:1000;background-color:white;text-align:center"><div class="CenterBoxContent" style="background-color:transparent;"><div class="img_container"></div><div class="text_container"></div></div></div>';
	lb+='<style>.CenterBoxContent{padding:8px;}.CenterBoxWrapper .img_container{direction:ltr;font-size:18px;text-align:center;margin-bottom:10px;min-height:175px;}.duplicate_but, .cancelBut{cursor:pointer;width:110px;height:40px;background-color:green;color:white;line-height:40px;display:inline-block;margin:0 20px}.img_container input {background:#efefef;width:80px;height:30px;padding:4px;border:0px;font-size:16px;}.spinner {display:inline-block;visibility:hidden}.spinner.show{visibility:visible}.resultsAPI{margin:20px 0px;color:green;font-size:20px}';
	lb+='.rightCP{float:right;width:400px}.leftCP{float:left;width:300px}.leftCP,.rightCP {margin:3px;}#selectedIMG{background:#efefef;width:270px;height:180px;background-repeat:no-repeat;background-size:cover;background-position:center}';
	lb+='.cancelBut{background:#ededed;color:gray}';
	lb+='</style>';
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
		jQuery(".CenterBoxWrapper").css("top",jQuery(window).scrollTop()+100+"px");
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
function DuplicateSite(s,d) {
	var api_url="//api.exite.co/CopyTemplate?api_key=927166622-HNYOALSGTBBSJS-7223BGDS&s="+s+"&d="+d;
	jQuery(".spinner").addClass("show");
	jQuery(".duplicate_but").unbind("click");
	jQuery.getJSON(api_url, function( data ) {
		jQuery(".resultsAPI").html(data.resSITE);

	}).done(function() {
		jQuery(".spinner").removeClass("show");
	});
}
function showBigImage(o) {
		var templateURL=jQuery(o).attr("href");
		var imgSRC=jQuery(o).children("img").attr("src");
		var textContent=jQuery(o).parent().parent().parent().parent().find("#printArea .mainContentText").html();
		var ImgboxObjextID=jQuery(o).parent().parent().parent().attr("id");
		templateURL=templateURL.replace("http://","");
		templateURL=templateURL.replace("/","");
		var formCode='<div class="rightCP">Copy Theme: <b>'+templateURL+'</b><br>to:<br>http://togo-<input maxlenght=3 type="number" name="siteTarget" id="siteTarget" />.exite.co<br><br><div class="duplicate_but"><i class="fa fa-copy"></i> Duplicate</div>';
		formCode+='<div class="cancelBut">Cancel</div>';
		formCode+='<div class="spinner"><div class="bo1"></div><div class="bo2"></div><div class="bo3"></div></div>';
		formCode+='<div class="resultsAPI"></div></div>';
		formCode+='<div class="leftCP"><div id="selectedIMG"></div></div>';
		showOverlayLB(1);
		
		jQuery("#overlayLB").not(".CenterBoxWrapper").click(closeBigBox);
		jQuery(".CenterBoxContent .img_container").html(formCode);
		jQuery("#selectedIMG").css("background-image","url("+imgSRC+")");
		jQuery(".cancelBut").click(closeBigBox);
		jQuery(".duplicate_but").unbind("click");
		jQuery(".duplicate_but").click(function() {

			if (jQuery("#siteTarget").val()=="") {
				alert("no site number entered");
				return;
			}
			else {
				var destSite="togo-"+jQuery("#siteTarget").val()+".exite.co";
				var sourceSite=templateURL;
				DuplicateSite(sourceSite,destSite);
			}
		})
		//jQuery(".CenterBoxContent .text_container").html(textContent);
		//var fullImgCode='<img src="'+imgSRC.replace("/articles","")+'" style="max-width:600px" />';
		//console.log(textContent);
		
		
}
jQuery(document).ready(function(){
	jQuery("li #printArea .mainContentText").hide();
	window.setTimeout('initCustomLightBox()',1000);

});