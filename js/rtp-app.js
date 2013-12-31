/* Documentation can be found at: http://foundation.zurb.com/docs */
jQuery(document).foundation();

/**
 * Responsive Table JS
 */
jQuery(document).ready(function($) {
    
    /* WooCommerce Promo code */
    if($('p.demo_store').length > 0){
        $('body').addClass('rtp-has-promo-bar');
    }

    /* Add parent-menu class in navigation */
    $('.rtp-page-nav-wrapper .menu > li').each(function() {
        if ($(this).children().hasClass('sub-menu')) {
            $(this).addClass('rtp-parent-menu');
        }
    });

    /* WP Calendar Widget */
    $('.widget_calendar table').addClass('no-responsive');

    /* No Responsive Tables */
    var switched = false;
    var updateTables = function() {
        if (($(window).width() < 768) && !switched) {
            switched = true;
            $("table").each(function(i, element) {
                if ($(this).hasClass("no-responsive")) {
                    return true;
                }
                splitTable($(element));
            });
            return true;
        }
        else if (switched && ($(window).width() > 768)) {
            switched = false;
            $("table").each(function(i, element) {
                if ($(this).hasClass("no-responsive")) {
                    return true;
                }
                unsplitTable($(element));
            });
        }
    };

    $(window).load(updateTables);
    $(window).bind("resize", updateTables);

    function splitTable(original) {
        original.wrap("<div class='table-wrapper' />");

        var copy = original.clone();
        copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
        copy.removeClass("responsive");

        original.closest(".table-wrapper").append(copy);
        copy.wrap("<div class='pinned' />");
        original.wrap("<div class='scrollable' />");
    }

    function unsplitTable(original) {
        original.closest(".table-wrapper").find(".pinned").remove();
        original.unwrap();
        original.unwrap();
    }

    /* Mobile Slide Menu */
    if ($.isFunction($.fn.sidr)) {
        if( $('#rtp-primary-menu').hasClass('rtp-mobile-nav') ) {
            $('#rtp-primary-menu').prepend('<a class="rtp-menu-icon" id="rtp-mobile-menu-button" href="#rtp-primary-menu"><i class="rtp-icon-menu"></i></a>');
            $('#rtp-mobile-menu-button').sidr({
                side: 'left',
                speed: 800,
                source: '.rtp-mobile-nav'
            });
        }
    }
});