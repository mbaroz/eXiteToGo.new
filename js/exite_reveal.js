(function ( $ ) {
    $.fn.exiteReveal = function( options ) {
       this.wrap('<div class="exiteRevealWrapper"></div>');
       this.addClass('exiteReveal');
       this.append('<div class="closeIcon">+</div>');
        // This is the easiest way to have default options.

        var settings = $.extend({
            // These are the defaults.
            html: " ",
            backgroundColor: "white",
            minWidth: "250px",
            effectIn:'fadeIn',
            effectOut:'fadeOut',
            delay:500
        }, options );

            window.setTimeout(function() {
                $('.exiteRevealWrapper').fadeIn('fast');
                $('.exiteRevealWrapper .exiteReveal').addClass("animated "+settings.effectIn).show();
                $('.exiteRevealWrapper .exiteReveal .closeIcon').click(function() {
                    
                    $('.exiteRevealWrapper .exiteReveal').addClass(settings.effectOut).removeClass(settings.effectIn);
                    $('.exiteRevealWrapper').fadeOut('fast');
                });
            },settings.delay
        );

    }       
 
}( jQuery ));