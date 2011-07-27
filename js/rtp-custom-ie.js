/**
 * Custom Script for IE browsers only!!!
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

jQuery(document).ready(function() {
    jQuery('#rtp-nav-menu ul ul li:first').css('border-top', '1px solid #DDDDDD');
    jQuery('#rtp-nav-menu li:last').css('border-right', '1px solid #DDDDDD');
    jQuery('#footerbar .footerbar-widget:last').css('border', 'medium none');
});