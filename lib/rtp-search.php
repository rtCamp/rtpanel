<?php
/**
 * Over-riding WordPress default search mechanism
 *
 * Support for Google Custom Search ( Bonus !!! )
 * 
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * rtPanel Custom Search Form
 *
 * @param string $form
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_custom_search_form( $form ) {
    global $rtp_general, $is_chrome;
    $search_class = 'search-text';
    if ( preg_match( '/customSearchControl.draw\(\'cse\'(.*)\)\;/i', @$rtp_general["search_code"] ) ) {
        $search_class .= ' rtp-google-search';
        $placeholder = NULL;
    } else {
        $placeholder = 'placeholder="' . apply_filters( 'rtp_search_placeholder', __( 'Search Here...', 'rtPanel' ) ) . '" ';
    }
    $chrome_voice_search = ( $is_chrome ) ? ' x-webkit-speech="x-webkit-speech" speech="speech" onwebkitspeechchange="this.form.submit();"' : '';
    //<label class="hidden">' . __( 'Search for:', 'rtPanel' ) . '</label>
    $form = '<form role="search" class="searchform" action="' . home_url( '/' ) . '">
                <div class="row collapse">
                    <div class="small-9 columns">
                        <input type="search" required="required" ' . $placeholder . 'value="' . esc_attr( apply_filters( 'the_search_query', get_search_query() ) ).'" name="s" class="' . $search_class . '" title="' . apply_filters( 'rtp_search_placeholder', __( 'Search Here...', 'rtPanel' ) ). '"' . $chrome_voice_search . ' />
                    </div>
                    <div class="small-3 columns">
                        <input type="submit" class="searchsubmit postfix radius" value="' . esc_attr( __( 'Search', 'rtPanel' ) ) . '" title="Search" />
                    </div>
               </div>
             </form>';          
    return $form;
}
add_filter( 'get_search_form', 'rtp_custom_search_form' );


/* Customizing URLs, when using Google Custom Search */
if( is_search() ) {
    $result_url = get_site_url( '', '?s=' );
        header( 'Location:' . $result_url . $s );
    exit;
}