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
    jQuery('#rtp-nav-menu ul ul li:first').css('border-top', '1px solid #DDDDDD');
    jQuery('#rtp-nav-menu li:last').css('border-right', '1px solid #DDDDDD');
        
    /* Footer Widgets Support */
    jQuery('#footerbar .footerbar-widget:last').css('border', 'none');
    
    /* IE6 Submit Hover */
    jQuery('#submit').hover( function() { jQuery(this).addClass('submit-over'); }, function() { jQuery(this).removeClass('submit-over'); } )
});