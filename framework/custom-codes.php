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

// Start function
if ( ! function_exists( 'rtp_custom_css' ) ) {

	function rtp_custom_css() {
		$css = rtp_get_option( 'custom_css' );

		if ( $css ) {
			$css = '<style>' . $css . '</style>';
		}

		echo $css;
	}

	// Hook function to wp_head
	add_action( 'wp_head', 'rtp_custom_css' );
}

// Start function
if ( ! function_exists( 'rtp_custom_js' ) ) {

	function rtp_custom_js() {
		$js = rtp_get_option( 'custom_js' );

		if ( $js ) {
			$js = '<script>' . $js . '</script>';
		}

		echo $js;
	}

	// Hook function to wp_footer
	add_action( 'wp_footer', 'rtp_custom_js', 999 );
}