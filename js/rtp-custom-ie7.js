/**
 * The template for displaying custom jquery for IE7 browser only
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

/**
 * Dropdown support for ie7 and 6 browsers
 * li:hover dose't work in ie7 and 6
 */

jQuery(document).ready(function(){
    jQuery('#rtp-nav-menu li').hover(
        function() { jQuery(this).children('ul').css('display','block') },
        function() { jQuery(this).children('ul').css('display','none') }
    );
});