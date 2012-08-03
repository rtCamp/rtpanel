/**
 * Mobile Navigation Script
 *
 * @package rtPanel
 * @since rtPanel 2.1.2
 */

jQuery( document ).ready(function() {
    jQuery('#rtp-primary-menu, #rtp-nav-menu, .rtp-nav-btn').addClass('rtp-js');
    jQuery('.rtp-nav-btn').on('click', function(e){
        e.preventDefault();
        jQuery(this).next('#rtp-nav-menu').slideToggle('slow');
    });
    jQuery( window ).resize(function(){
        var win_width = jQuery(window).width();
        if( win_width >= 760 ){
            jQuery('#rtp-nav-menu').show();
        }
    });
});