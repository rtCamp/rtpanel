/**
 * The template for displaying custom Scripts for browsers
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

    /**
     * Shows Search Default text and hide on focus
     */

jQuery(document).ready(function() {
    jQuery('input[type=submit]').css('cursor', 'pointer');
    
    /* added for search field default value */
    jQuery('.search-text').blur( function() { if( this.value == '' ) this.value='Search Here...' ; } );
    jQuery('.search-text').focus( function() { if( this.value == 'Search Here...' ) this.value=''; } );


/**
 * Show post edit and comment edit while over on post or comment
 */

    function rtp_edit_link( container ) {
        jQuery(container).hover(
            function() { jQuery(this).find('.rtp-edit-link').css('visibility', 'visible'); },
            function() { jQuery(this).find('.rtp-edit-link').css('visibility', 'hidden'); }
        );
    }
    rtp_edit_link('.comment-body');
    rtp_edit_link('.hentry');
});