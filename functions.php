<?php
/**
 * rtPanel Functions and Definitions
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

$rtp_general = get_option( 'rtp_general' ); // rtPanel General Options
$rtp_post_comments = get_option( 'rtp_post_comments' ); // rtPanel Post & Comments Options

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

// Nofollow external links only
add_filter( 'the_content', 'rt_nofollow' );
add_filter( 'the_excerpt', 'rt_nofollow' );
function rt_nofollow( $content ) {
    return preg_replace_callback( '/<a[^>]+/', 'rt_nofollow_callback', $content );
}
function rt_nofollow_callback( $matches ) {
    $link = $matches[0];
    $site_link = get_bloginfo( 'url' );
    if ( strpos( $link, 'rel' ) === false ) {
        $link = preg_replace( "%(href=\S(?!$site_link))%i", 'rel="nofollow" $1', $link );
    } elseif ( preg_match( "%href=\S(?!$site_link)%i", $link ) ) {
        $link = preg_replace( '/rel=\S(?!nofollow)\S*/i', 'rel="nofollow"', $link );
    }
    return $link;
}

/* 
 * Browser Decection code and apply class to <?php body_class(); ?>
 * Ref: http://wpsnipp.com/index.php/functions-php/browser-detection-and-os-detection-with-body_class/?utm_source=feedburner&utm_medium=feed&utm_campaign=Feed%3A+wpsnipp+(wpsnipp+-+wordpress+code+snippets)&utm_content=Google+Reader
 */
function rt_body_class( $classes ) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    if ( $is_lynx ) $classes[] = 'lynx';
    elseif ( $is_gecko ) $classes[] = 'gecko';
    elseif ( $is_opera ) $classes[] = 'opera';
    elseif ( $is_NS4 ) $classes[] = 'ns4';
    elseif ( $is_safari ) $classes[] = 'safari';
    elseif ( $is_chrome ) $classes[] = 'chrome';
    elseif ( $is_IE ) {
        $classes[] = 'ie';
        if ( preg_match( '/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) ) {
            $classes[] = 'ie'.$browser_version[1];
        }
    } else $classes[] = 'unknown';
    if ( $is_iphone ) $classes[] = 'iphone';
    if ( stristr( $_SERVER['HTTP_USER_AGENT'], "mac") ) {
        $classes[] = 'osx';
    } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
        $classes[] = 'linux';
    } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
        $classes[] = 'windows';
    }
    return $classes;
}
add_filter( 'body_class', 'rt_body_class' );