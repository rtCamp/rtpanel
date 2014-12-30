<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// We don't need this in the admin
if ( is_admin() ) {
	return;
}


// Tracking Code
if ( ! function_exists( 'rtp_tracking' ) ) {

	function rtp_tracking() {
		$on = rtp_get_option( 'tracking' );
		$tracking = rtp_get_option( 'tracking_code' );

		if ( $on && $tracking ) {
			echo $tracking;
		}
	}

	// Hook function to wp_footer
	add_action( 'wp_footer', 'rtp_tracking', 9999 );
}

// Custom CSS
if ( ! function_exists( 'rtp_custom_css' ) ) {

	function rtp_custom_css() {
		$on = rtp_get_option( 'css' );
		$css = rtp_get_option( 'custom_css' );

		if ( $on && $css ) {
			echo '<style>' . $css . '</style>';
		}
	}

	// Hook function to wp_head
	add_action( 'wp_head', 'rtp_custom_css' );
}

// Custom JavaScript
if ( ! function_exists( 'rtp_custom_js' ) ) {

	function rtp_custom_js() {
		$on = rtp_get_option( 'js' );
		$js = rtp_get_option( 'custom_js' );

		if ( $on && $js ) {
			echo '<script>' . $js . '</script>';
		}
	}

	// Hook function to wp_footer
	add_action( 'wp_footer', 'rtp_custom_js', 999 );
}