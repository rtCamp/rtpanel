/**
 * * Custom Script for IE6 only!!!
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

jQuery(document).ready(function() {
    /* Admin Comment Support */
    jQuery('li.comment-author-admin > div.comment-body').addClass('rtp-admin-comment');
    jQuery('li.byuser > div.comment-body').addClass('rtp-admin-comment');
    jQuery('li.bypostauthor > div.comment-body').addClass('rtp-admin-comment');

    /* Navigation Support */
    jQuery('li.current-menu-item > a').addClass('current-menu');
    jQuery('ul#rtp-nav-menu li:first').css('border-left', '1px solid #DDD');
    jQuery('#rtp-nav-menu ul li:first').css('border-left', '0');
    jQuery('#rtp-nav-menu li:first').css('border-top', '1px solid #DDD');
        
    /* Footer Widgets Support */
    jQuery('#footerbar .footerbar-widget:last').css('border', 'none');
    
    /* IE6 Submit Hover */
    jQuery('#submit').hover( function() { jQuery(this).addClass('submit-over'); }, function() { jQuery(this).removeClass('submit-over'); } )
});