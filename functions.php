<?php
/**
 * rtPanel Functions and Definitions
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

$rtp_general = get_option( 'rtp_general' );
$rtp_post_comments = get_option( 'rtp_post_comments' );
$rtp_hooks = get_option( 'rtp_hooks' );

/* ========== [ Define Directory Constants ] ========== */
define( 'RTP_ADMIN', get_template_directory() . '/admin' );
define( 'RTP_CSS', get_template_directory() . '/css' );
define( 'RTP_JS', get_template_directory() . '/js' );
define( 'RTP_IMG', get_template_directory() . '/img' );

/* ========== [ Define Directory URL Constants ] ========== */

/**
 * @uses RTP_TEMPLATE_URL returns Theme directory URL.
 */
define( 'RTP_TEMPLATE_URL', get_template_directory_uri() );

/**
 * @uses RTP_CSS_FOLDER_URL returns /css/ directory in theme folder URL.
 */
define( 'RTP_CSS_FOLDER_URL', get_template_directory_uri() . '/css' );

/**
 * @uses RTP_JS_FOLDER_URL returns /js/ directory in theme folder URL.
 */
define( 'RTP_JS_FOLDER_URL', get_template_directory_uri() . '/js' );

/**
 * @uses RTP_IMG_FOLDER_URL returns /img/ directory in theme folder URL.
 */
define( 'RTP_IMG_FOLDER_URL', get_template_directory_uri() . '/img' );

/* ========== [ Include all PHP files inside 'php' folder ] ========== */
foreach( glob ( get_template_directory() . "/lib/*.php" ) as $lib_filename ) {
    require_once( $lib_filename );
}

/* ========== [ Include rtPanel Theme Options ] ========== */
require_once( get_template_directory() . "/admin/rtp-theme-options.php" );