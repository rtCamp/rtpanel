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
    $search_class = 'search-text search-field rtp-search-input';
    if ( preg_match( '/customSearchControl.draw\(\'cse\'(.*)\)\;/i', @$rtp_general["search_code"] ) ) {
        $search_class .= ' rtp-google-search';
        $placeholder = NULL;
    } else {
        $placeholder = 'placeholder="' . apply_filters( 'rtp_search_placeholder', __( 'Search Here...', 'rtPanel' ) ) . '" ';
    }
    $chrome_voice_search = ( $is_chrome ) ? ' x-webkit-speech="x-webkit-speech" speech="speech" onwebkitspeechchange="this.form.submit();"' : '';
    $form = '<form role="search" method="get" class="searchform search-form" action="' . esc_url( home_url( '/' ) ) . '">
                <div class="rtp-search-form-wrapper">
                    <label class="screen-reader-text hide">' . __( 'Search for:', 'rtPanel' ) . '</label>
                    <input type="search" required="required" ' . $placeholder . 'value="' . esc_attr( apply_filters( 'the_search_query', get_search_query() ) ).'" name="s" class="' . esc_attr( $search_class ) . '" title="' . apply_filters( 'rtp_search_placeholder', __( 'Search Here...', 'rtPanel' ) ). '"' . $chrome_voice_search . ' />
                    <input type="submit" class="searchsubmit search-submit rtp-search-button button tiny" value="' . esc_attr( __( 'Search', 'rtPanel' ) ) . '" title="' . esc_attr( __( 'Search', 'rtPanel' ) ) . '" />
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