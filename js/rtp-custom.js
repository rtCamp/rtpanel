/**
 * Custom Scripts
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */
jQuery(document).ready(function () {
    /* Show post edit and comment edit while over on post or comment */
    function rtp_edit_link(container) {
        jQuery(container).hover(
        function () {
            jQuery(this).find('.rtp-edit-link').css('visibility', 'visible');
        }, function () {
            jQuery(this).find('.rtp-edit-link').css('visibility', 'hidden');
        });
    }
    rtp_edit_link('.comment-body');
    rtp_edit_link('.hentry');

    /* Dropdown support for ie7 browsers (li:hover doesn't work in ie7 out of box) */
    jQuery('.ie7 #rtp-nav-menu li').hover(
        function() { jQuery(this).children('ul').css('display', 'block') },
        function() { jQuery(this).children('ul').css('display', 'none') }
    );
});