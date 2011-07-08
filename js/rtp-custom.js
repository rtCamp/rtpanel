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

jQuery(window).load( function(){
    var count = 0;
    var max = null;
    var id = new Array();
   
   jQuery('.footerbar-widget').each(function(){
       if( ( count % 3 ) == 0) {
           //jQuery(this).width( ( jQuery('#footer-wrapper').width()/3 ) - ( parseFloat(jQuery(this).css('padding-left')) + parseFloat(jQuery(this).css('padding-right')) ) - 1);
          for( var oid in id ){
              jQuery('#'+id[oid]).height(max);
          }
          id = new Array();
          max = null;
       } else {
           //jQuery(this).width( ( jQuery('#footer-wrapper').width()/3 ) - ( parseFloat(jQuery(this).css('padding-left')) + parseFloat(jQuery(this).css('padding-right')) ) - 2);
       }
       if( count >= 3 ) {
           id[count-3] = jQuery(this).attr('id');
       } else {
           id[count] = jQuery(this).attr('id');
       }
       if( (jQuery(this).height()) > max ) {
           
           max = jQuery(this).height();
       }
       count++;
   });
   for( var aoid in id ){
              jQuery('#'+id[aoid]).height(max);
   }


   
});

//function sticky_widgets(s) {
//   //make sidebar widget stickyvar $scrollingDiv = jQuery(".sidebar-widget:last");
//   var $scrollingDiv = jQuery(s);
//   var side_top = jQuery('#sidebar').offset().top - parseFloat(jQuery('#sidebar').css('marginTop').replace(/auto/, 0));
//  var top = jQuery($scrollingDiv).offset().top - parseFloat($scrollingDiv.css('marginTop').replace(/auto/, 0));
//  var bottom = side_top + jQuery( '#content' ).height() - parseFloat(jQuery('#content').css('margin-bottom').replace(/auto/, 0));
//  jQuery(window).scroll(function (event) {
//    // what the y position of the scroll is
//    var y = jQuery(this).scrollTop();
//    var z = y + $scrollingDiv.height();
//
//    // whether that's below the form
//    if (y >= top && z<bottom ) {
//      // if so, ad the fixed class
//      $scrollingDiv.addClass('fixed-widget');
//      $scrollingDiv.removeClass( 'fixed-bottom' );
//      $scrollingDiv.each(function(idx,el){
//                el.style.bottom='';
//            });
//    } else {
//      // otherwise remove it
//      if(z>bottom)
//      $scrollingDiv.addClass( 'fixed-bottom' );
////      //jQuery( '.fixed-bottom' ).css( 'bottom',jQuery( '#footer-wrapper' ).height());
//      $scrollingDiv.removeClass('fixed-widget');
//    }
//  });
//}
  

  