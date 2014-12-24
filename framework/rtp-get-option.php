<?php

/**
 * Get rtPanel options
 *
 *
 * @param string $id Option ID.
 * @param string $param Option type.
 *
 * @return $output False on failure, Option.
 */
if ( ! function_exists( 'rtp_get_option' ) ) {

	function rtp_get_option( $id, $param = null ) {

		global $rtp_options;

		/* Check if array subscript exist in options */
		if ( empty( $rtp_options[ $id ] ) ) {
			return false;
		}

		/**
		 * If $param exists,  then
		 * 1. It should be 'string'.
		 * 2. '$rtp_options[ $id ]' should be array.
		 * 3. '$param' array key exists.
		 */
		if ( ! empty( $param ) && is_string( $param ) && ( ! is_array( $rtp_options[ $id ] ) || ! array_key_exists( $param, $rtp_options[ $id ] ) ) ) {
			return false;
		}

		return empty( $param ) ? $rtp_options[ $id ] : $rtp_options[ $id ][ $param ];
	}

}