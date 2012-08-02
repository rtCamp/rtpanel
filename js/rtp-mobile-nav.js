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
        // jQuery('#rtp-nav-menu').removeAttr('style');
    });
});