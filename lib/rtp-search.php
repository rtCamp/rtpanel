<?php
/**
 * The template for Overriding wordpress default search engine
 * Support for Google custom search
 *
 * @param string $form
 * @return string
 * 
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

function rtp_custom_search_form( $form ) {
    $form = '<form class="searchform" action="' . home_url() . '/" >
                <div><label class="hidden">' . __( 'Search for:', 'rtPanel' ) . '</label>
                    <input type="text" value="' . ( ( get_search_query() ) ? esc_attr( apply_filters( 'the_search_query', get_search_query() ) ) : __( 'Search Here...', 'rtPanel' ) ) . '" name="s" class="search-text" title="' . __( 'Search Here...', 'rtPanel' ). '" />
                    <input type="submit" class="searchsubmit" value="' . esc_attr( __( 'Search', 'rtPanel' ) ) . '" title="Search" /></div>
             </form>';
    return $form;
}
add_filter( 'get_search_form', 'rtp_custom_search_form' ); //comment out this line to use wordpress's builtin search form


    /**
     * Used for changing the URL
     */

if( is_search() ) {
    $result_url = get_site_url( '', '?s=' );
        header( 'Location:' . $result_url . $s );
    exit;
}