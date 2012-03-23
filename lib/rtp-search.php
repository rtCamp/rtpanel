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
    $form = '<form class="searchform" action="' . home_url() . '/" >
                <div><label class="hidden">' . __( 'Search for:', 'rtPanel' ) . '</label>
                    <input type="text" placeholder="'. apply_filters( 'rtp_search_placeholder', __( 'Search Here...', 'rtPanel' ) ).'" value="' . esc_attr( apply_filters( 'the_search_query', get_search_query() ) ).'" name="s" class="search-text" title="' . __( 'Search Here...', 'rtPanel' ). '" x-webkit-speech="x-webkit-speech" speech="speech" onwebkitspeechchange="this.form.submit();" />
                    <input type="submit" class="searchsubmit" value="' . esc_attr( __( 'Search', 'rtPanel' ) ) . '" title="Search" />
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