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
    /* added for name field when label is hidden */
    jQuery('.hide-labels #author').blur( function() { if( this.value == '' ) this.value='Name' ; } );
    jQuery('.hide-labels #author').focus( function() { if( this.value == 'Name' ) this.value=''; } );
    /* added for email field when label is hidden */
    jQuery('.hide-labels #email').blur( function() { if( this.value == '' ) this.value='Email' ; } );
    jQuery('.hide-labels #email').focus( function() { if( this.value == 'Email' ) this.value=''; } );
    /* added for url field when label is hidden */
    jQuery('.hide-labels #url').blur( function() { if( this.value == '' ) this.value='Website' ; } );
    jQuery('.hide-labels #url').focus( function() { if( this.value == 'Website' ) this.value=''; } );
    /* added for comment field default value */
    jQuery('#comment').blur( function() { if( this.value == '' ) this.value='Comment...' ; } );
    jQuery('#comment').focus( function() { if( this.value == 'Comment...' ) this.value=''; } );


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