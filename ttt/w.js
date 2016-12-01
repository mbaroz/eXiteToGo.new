function detectMe() {
	var hashLocation=window.location.hash;
	var paragrafID=hashLocation.split("#")[1];
	if (paragrafID!="") {
		 $('html, body').animate({
        	scrollTop: $('[data-sharerid="'+paragrafID+'"]').offset.top
    	}, 2000);
		$('[data-sharerid="'+paragrafID+'"]').css({
			'box-sizing':'border-box',
			'border':'3px solid #FFFF04',
			'transition':'border 0.3s',
			'transition-delay':'1s',
			'padding':'5px'
			
		});
	}
}
var tagsCollection='';
function initMe() {
	$('body').append('<div class="widgetWrapper"><div class="ic"></div></div>');
	var targetP_ID;
	
	$('body p').each(function() {
		targetP_ID="p82977123"+$(this).position().top;
		$(this).attr('data-sharerID',targetP_ID);
		$(this).click(function() {
			var targetP_SharID=$(this).attr("data-sharerID");
			var paragrafText=$(this).text();
			var paragrafPosX=$(this).innerWidth()-200;
			var paragrafPosY=$(this).position().top+100;
			var widgetPosX=paragrafPosX+100;
			var widgetPosY=paragrafPosY-100;
			$(".widgetWrapper").attr('data-targetP',targetP_SharID);
			$(".widgetWrapper").css({
				'left':widgetPosX+'px',
				'top':widgetPosY+'px'
			});
			$(".widgetWrapper").addClass("show");

		});

		
	});
	$(".widgetWrapper .ic").click(function() {
			tagsCollection+='|'+$(this).parent().attr('data-targetP');
			
			//tagsCollection.replace($(this).parent().attr('data-targetP'),'');
			var linkShareURL=top.location.href+"#"+tagsCollection;
			//console.log(tagsCollection);
	});

}

$(document).ready(function() {
	initMe();
	detectMe();
});