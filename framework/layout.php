<?php

/*
 * HTML Classes
 */

if ( ! function_exists( 'rtp_html_classes' ) ) {

	function rtp_html_classes( $classes ) {

		$layout = rtp_get_option( 'main_layout' );

		if ( $layout ) {
			return $classes . ' ' . $layout;
		}
	}

	/* Add Filter */
	add_filter( 'rtp_set_html_class', 'rtp_html_classes' );
}