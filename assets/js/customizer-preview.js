/**
 * Live preview of Customizer color settings in real-time.
 */
(function($) {
    // Primary / Brand Color
    wp.customize('iran_color_brand', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-brand', newval);
        });
    });

    // Secondary Color
    wp.customize('iran_color_secondary', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-secondary', newval);
        });
    });

    // Body Background
    wp.customize('iran_color_bg', function(value) {
        value.bind(function(newval) {
            $('body:not(.dark)').css('background-color', newval);
        });
    });

    // Body Text Color
    wp.customize('iran_color_text', function(value) {
        value.bind(function(newval) {
            $('body:not(.dark)').css('color', newval);
        });
    });

    // Header Background
    wp.customize('iran_color_header_bg', function(value) {
        value.bind(function(newval) {
            $('.sticky-nav:not(.dark)').css('background-color', newval);
        });
    });

    // Footer Background
    wp.customize('iran_color_footer_bg', function(value) {
        value.bind(function(newval) {
            $('footer').css('background-color', newval);
        });
    });

    // Footer Text Color
    wp.customize('iran_color_footer_text', function(value) {
        value.bind(function(newval) {
            $('footer, footer p, footer a, footer h3').css('color', newval);
        });
    });
})(jQuery);
