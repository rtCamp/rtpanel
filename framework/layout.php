<?php

/*
 * HTML Classes
 */

if ( ! function_exists( 'rtp_html_classes' ) ) {

	function rtp_html_classes( $classes ) {

		$layout = rtp_option( 'main_layout' );

		if ( $layout ) {
			return $classes . ' ' . $layout;
		}
	}

}

add_filter( 'rtp_set_html_class', 'rtp_html_classes' );
