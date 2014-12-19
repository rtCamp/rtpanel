<?php

global $rtp_options;


if ( ! function_exists( 'rtp_option' ) ) {

	function rtp_option( $id, $fallback = false, $param = false ) {

		if ( isset( $_GET[ 'rtp_' . $id ] ) ) {
			if ( '-1' == $_GET[ 'rtp_' . $id ] ) {
				return false;
			} else {
				return $_GET[ 'rtp_' . $id ];
			}
		} else {
			global $rtp_options;

			if ( $fallback == false ) {
				$fallback = '';
			}

			$output = ( isset( $rtp_options[ $id ] ) && $rtp_options[ $id ] !== '' ) ? $rtp_options[ $id ] : $fallback;

			if ( ! empty( $rtp_options[ $id ] ) && $param ) {
				$output = $rtp_options[ $id ][ $param ];
			}
		}

		return $output;
	}

}