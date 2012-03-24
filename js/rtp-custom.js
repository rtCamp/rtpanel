/**
 * Custom Scripts
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */

jQuery(document).ready(function() {
    
    jQuery('#footerbar .footerbar-widget:nth-child(3n+1)').css('border', '0');
    
    /* Show post edit and comment edit while over on post or comment */
    function rtp_edit_link( container ) {
        jQuery(container).hover(
            function() { jQuery(this).find( '.rtp-edit-link' ).css( 'visibility', 'visible' ); },
            function() { jQuery(this).find( '.rtp-edit-link' ).css( 'visibility', 'hidden' ); }
        );
    }
    rtp_edit_link( '.comment-body' );
    rtp_edit_link( '.hentry' );
    
    /* Placeholder IE Support */
    jQuery('[placeholder]').focus(function() {
        var input = jQuery(this);
        if (input.val() == input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function() {
        var input = jQuery(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
        }
    }).blur().parents('form').submit(function() {
        jQuery(this).find('[placeholder]').each(function() {
            var input = jQuery(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
            }
        });
    });
    
});

jQuery(window).load( function(){
    
    var sidebar_h = jQuery( '#sidebar' ).height();
    if( sidebar_h != undefined ) {
        var content_h = jQuery( '#content' ).height()*1 + jQuery('#content').css( 'padding-bottom' ).replace( 'px', '' )*1 + jQuery('#content').css( 'padding-top' ).replace( 'px', '' )*1 - ( jQuery( '#sidebar' ).css( 'padding-bottom' ).replace( 'px', '' )*1 + jQuery( '#sidebar' ).css( 'padding-bottom' ).replace( 'px', '' )*1 );
    
        if ( content_h > sidebar_h ) {
            jQuery( '#sidebar' ).height( content_h );
        }
    }
    
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