jQuery(document).ready(function() {
	jQuery('.topMenuNew nav a').click(function(event) {
		event.preventDefault();
		var currentURL=jQuery(this).attr('href');
		jQuery('.mainPage').addClass('fadeOut');
		jQuery(".mainPage").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
			top.location=currentURL;
		});



	})

});