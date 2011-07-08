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


//$args = array(
//            'method' => 'POST',
//            'headers' => array('content-type' => 'application/x-www-form-urlencoded' ),
//            'httpversion' => '1.1',
//            'body' => '<?xml version="1.0" encoding="utf-8" /?/>
//
//<YourMembership>
//    <Version>1.65</Version>
//    <ApiKey>3D638C5F-CCE2-4638-A2C1-355FA7BBC917</ApiKey>
//    <CallID>001</CallID>
//    <SessionID>A07C3BCC-0B39-4977-9E64-C00E918D572E</SessionID>
//    <Call Method="Member.Profile.Get"></Call>
//</YourMembership>',
//        );
//print_R(wp_remote_post('https://api.yourmembership.com', $args));