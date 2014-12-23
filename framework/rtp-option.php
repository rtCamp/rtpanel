<?php

/*
 * Get Option
 */

if ( ! function_exists( 'rtp_option' ) ) {

	function rtp_option( $id, $param = false ) {

		global $rtp_options;

		$output = false;

		if ( ! empty( $rtp_options[ $id ] ) && $param ) {
			$output = $rtp_options[ $id ][ $param ];
		}

		return $output;
	}

}