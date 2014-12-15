<?php

/**
 * rtPanel functions and definitions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
/**
 * Define Theme Version
 */
define( 'RTP_VERSION', '4.2' );

/* Define Links */
define( 'RTP_AUTHOR_URL', 'https://rtcamp.com/' ); // Theme Author URL
define( 'RTP_THEME_URL', RTP_AUTHOR_URL . 'rtpanel/' );  // Theme URI
define( 'RTP_DONATE_URL', RTP_AUTHOR_URL . 'donate/' );  // Theme Donate URL
define( 'RTP_DOCS_URL', RTP_THEME_URL . 'docs/' ); // Theme Documentation URL
define( 'RTP_FORUM_URL', RTP_AUTHOR_URL . 'support/forum/rtpanel/' );   // Theme Support Forum URL

/* Define Directory Constants */
define( 'RTP_ADMIN', get_template_directory() . '/admin' );
define( 'RTP_CSS', get_template_directory() . '/css' );
define( 'RTP_JS', get_template_directory() . '/js' );
define( 'RTP_IMG', get_template_directory() . '/img' );

/* Define Directory URL Constants */
define( 'RTP_TEMPLATE_URL', get_template_directory_uri() );
define( 'RTP_CSS_FOLDER_URL', get_template_directory_uri() . '/css' );
define( 'RTP_JS_FOLDER_URL', get_template_directory_uri() . '/js' );
define( 'RTP_IMG_FOLDER_URL', get_template_directory_uri() . '/img' );
define( 'RTP_ASSETS_URL', get_template_directory_uri() . '/assets' );
define( 'RTP_BOWER_COMPONENTS_URL', get_template_directory_uri() . '/assets/foundation/bower_components' );

$rtp_version = get_option( 'rtp_version' ); // rtPanel Version

/**
 * Add Redux Framework & extras
 */
require get_template_directory() . '/admin/admin-init.php';


/* Includes PHP files located in 'lib' folder */
foreach ( glob( get_template_directory() . '/lib/*.php' ) as $lib_filename ) {
	require_once( $lib_filename );
}