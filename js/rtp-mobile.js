/**
 * Mobile Navigation Script
 *
 * @package rtPanel
 * @since rtPanel 2.1.2
 */

jQuery( document ).ready(function() {
    var nav_btn = '<button class="rtp-nav-btn" type="button"><span class="rtp-icon-bar"></span><span class="rtp-icon-bar"></span><span class="rtp-icon-bar"></span></button>';
    /* prepend menu icon */
    jQuery('.rtp-mobile-nav').prepend(nav_btn);

    /* toggle nav */
    jQuery('.rtp-nav-btn').on('click', function(){
        jQuery('#rtp-nav-menu').slideToggle();
        jQuery(this).toggleClass('active');
    });
});