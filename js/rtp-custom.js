/**
 * Custom Scripts
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */

jQuery(document).ready(function() {
    jQuery( 'input[type=submit]' ).css( 'cursor', 'pointer' );
    
    /* added for search field default value */
    jQuery( '.search-text' ).blur( function() { if( this.value == '' ) this.value='Search Here...'; } );
    jQuery( '.search-text' ).focus( function() { if( this.value == 'Search Here...' ) this.value=''; } );

    /* added for name field when label is hidden */
    jQuery( '.hide-labels #author' ).blur( function() { if( this.value == '' ) this.value='Name*'; } );
    jQuery( '.hide-labels #author' ).focus( function() { if( this.value == 'Name*' ) this.value=''; } );

    /* added for email field when label is hidden */
    jQuery( '.hide-labels #e-mail' ).blur( function() { if( this.value == '' ) this.value='Email*'; } );
    jQuery( '.hide-labels #e-mail' ).focus( function() { if( this.value == 'Email*' ) this.value=''; } );

    /* added for url field when label is hidden */
    jQuery( '.hide-labels #url' ).blur( function() { if( this.value == '' ) this.value='Website'; } );
    jQuery( '.hide-labels #url' ).focus( function() { if( this.value == 'Website' ) this.value=''; } );

    /* added for comment field default value */
    jQuery( '#comment' ).blur( function() { if( this.value == '' ) this.value='Comment...'; } );
    jQuery( '#comment' ).focus( function() { if( this.value == 'Comment...' ) this.value=''; } );

    /* Show post edit and comment edit while over on post or comment */
    function rtp_edit_link( container ) {
        jQuery(container).hover(
            function() { jQuery(this).find( '.rtp-edit-link' ).css( 'visibility', 'visible' ); },
            function() { jQuery(this).find( '.rtp-edit-link' ).css( 'visibility', 'hidden' ); }
        );
    }
    rtp_edit_link( '.comment-body' );
    rtp_edit_link( '.hentry' );
});

jQuery(window).load( function(){
    var count = 0;
    var max = null;
    var id = new Array();
   
   jQuery( '.footerbar-widget' ).each( function() {
       if( ( count % 3 ) == 0) {
          for( var oid in id ){
              jQuery( '#'+id[oid] ).height(max);
          }
          id = new Array();
          max = null;
       }

       if( count >= 3 ) {
           id[count-3] = jQuery(this).attr( 'id' );
       } else {
           id[count] = jQuery(this).attr( 'id' );
       }

       if( (jQuery(this).height()) > max ) {
           max = jQuery(this).height();
       }
       count++;
   } );
   for( var aoid in id ) {
      jQuery( '#'+id[aoid] ).height( max );
   }
});