/**
 * Custom Script for IE7 only!!!
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

jQuery(document).ready(function(){
    /* Dropdown support for ie7 browsers (li:hover doesn't work in ie7 out of box) */
    jQuery('#rtp-nav-menu li').hover(
        function() { jQuery(this).children('ul').css('display','block') },
        function() { jQuery(this).children('ul').css('display','none') }
    );
});