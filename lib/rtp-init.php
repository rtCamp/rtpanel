<?php
/**
 * rtPanel Initialization
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

/**
 * Sets the content's width based on the theme's design and stylesheet
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet
 */
$content_width = ( isset( $content_width ) ) ? $content_width : 620;
$max_content_width = ( isset( $max_content_width ) ) ? $max_content_width : 940;

if ( !function_exists( 'rtpanel_setup' ) ) {
    /**
     * Sets up rtPanel
     *
     * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
     * @uses register_nav_menus() To add support for navigation menus.
     *
     * @since rtPanel 2.0
     */
    function rtpanel_setup() {
        rtp_theme_setup_values();
        add_theme_support( 'post-thumbnails' ); // This theme uses post thumbnails
        add_theme_support( 'automatic-feed-links' ); // Add default posts and comments RSS feed links to head
        add_editor_style( 'style.css' ); // This theme styles the visual editor with the themes style.css itself.
        load_theme_textdomain( 'rtPanel', get_template_directory() . '/languages' ); // Load the text domain

        add_theme_support( 'custom-background' ); // Add support for custom background
        
        // Add support for custom headers.
	$rtp_custom_header_support = array(
            // The height and width of our custom header.
            'width'                 => apply_filters( 'rtp_header_image_width', 960 ),
            'height'                => apply_filters( 'rtp_header_image_height', 140 ),
            'header-text'           => false,
            // Callback for styling the header.
            'wp-head-callback'      => '',
            // Callback for styling the header preview in the admin.
            'admin-head-callback'   => 'rtp_admin_header_style',
	);
	add_theme_support( 'custom-header', $rtp_custom_header_support );
        
        /* Backward Compatability for version prior to WordPress 3.4 */
        if ( ! function_exists( 'get_custom_header' ) ) {
            add_custom_background(); // Add support for custom background

            // Don't support text inside the header image
            if ( !defined( 'NO_HEADER_TEXT' ) ) {
                define( 'NO_HEADER_TEXT', true );
            }

            define( 'HEADER_TEXTCOLOR' , '' );
            define( 'HEADER_IMAGE_WIDTH' , apply_filters( 'rtp_header_image_width', 960 ) );
            define( 'HEADER_IMAGE_HEIGHT' , apply_filters( 'rtp_header_image_height', 140 ) );

            // adding support for the header image
            // Removed background image for header image
            // add_custom_image_header( 'rtp_header_style', 'rtp_admin_header_style' );
        }

        // Make use of wp_nav_menu() for navigation purpose
        register_nav_menus( array(
            'primary' => __( 'Primary Navigation', 'rtPanel' )
        ) );
    }
}
add_action( 'after_setup_theme', 'rtpanel_setup' );// Tell WordPress to run rtpanel_setup() when the 'after_setup_theme' hook is run

/**
* Site header image
*
* @since rtPanel 2.3
*/
if ( !function_exists( 'rtp_header_image' ) ) {
    function rtp_header_image() {
        if ( get_header_image() ) { ?>
            <img class="rtp-header-image rtp-margin-0" src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" /><?php
        }
    }
}
add_action('rtp_hook_before_header', 'rtp_header_image');


if ( !function_exists( 'rtp_admin_header_style' ) ) {
    /**
     * Admin header preview styling
     *
     * @since rtPanel 2.0
     */
    function rtp_admin_header_style() { ?>
        <style> #headimg { width: <?php echo HEADER_IMAGE_WIDTH; ?>px; height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; } </style><?php
    }
}

/**
 * Enqueues rtPanel Default Scripts
 *
 * @since rtPanel 2.0.7
 * @version 2.1
 */
function rtp_default_scripts() {
    global $rtp_general;

    /* Mobile Navigation Script */
    wp_enqueue_script( 'rtp-custom', RTP_JS_FOLDER_URL . '/rtp-mobile.js', array( 'jquery' ), '', true );

    echo ( $rtp_general['custom_styles'] ) ? '<style>' . $rtp_general['custom_styles'] . '</style>' . "\r\n" : '';
    // Nested Comment Support
    ( is_singular() && get_option( 'thread_comments' ) ) ? wp_enqueue_script('comment-reply') : '';

    if ( !rtp_is_bbPress() ) {
        wp_dequeue_style( array( 'bbpress-style', 'bbp-default-bbpress', 'bbp-twentyten-bbpress' ) );
    }
    
}
add_action( 'wp_enqueue_scripts', 'rtp_default_scripts' );

/**
 * Browser detection and OS detection
 *
 * Ref: http://wpsnipp.com/index.php/functions-php/browser-detection-and-os-detection-with-body_class/
 *
 * @param array $classes
 * @return array
 *
 * @since rtPanel 2.0
 */
function rtp_body_class( $classes ) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

    if ( $is_lynx ) $classes[] = 'lynx';
    elseif ( $is_gecko ) $classes[] = 'gecko';
    elseif ( $is_opera ) $classes[] = 'opera';
    elseif ( $is_NS4 ) $classes[] = 'ns4';
    elseif ( $is_safari ) $classes[] = 'safari';
    elseif ( $is_chrome ) $classes[] = 'chrome';
    elseif ( $is_IE ) {
        $classes[] = 'ie';
        if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) ) {
            $classes[] = 'ie'.$browser_version[1];
        }
    } else $classes[] = 'unknown';

    if ( $is_iphone ) $classes[] = 'iphone';

    if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && stristr( $_SERVER['HTTP_USER_AGENT'], "mac") ) {
        $classes[] = 'osx';
    } elseif ( isset( $_SERVER['HTTP_USER_AGENT'] ) && stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
        $classes[] = 'linux';
    } elseif ( isset( $_SERVER['HTTP_USER_AGENT'] ) && stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
        $classes[] = 'windows';
    }

    return $classes;
}
add_filter( 'body_class', 'rtp_body_class' );

/**
 * Remove category from rel attribute to solve validation error.
 *
 * @since rtPanel 2.1
 */
function rtp_remove_category_list_rel( $output ) {
    $output = str_replace( ' rel="category tag"', ' rel="tag"', $output );
    return $output;
}
add_filter( 'wp_list_categories', 'rtp_remove_category_list_rel' );
add_filter( 'the_category', 'rtp_remove_category_list_rel' );

/**
 * Check if bbPress Exists and if on a bbPress Page
 *
 * @since rtPanel 2.1
 */
function rtp_is_bbPress() {
    return ( class_exists( 'bbPress' ) && is_bbPress() );
}

/**
 * Sanitizes options having urls in serilized data.
 *
 * @since rtPanel 2.1
 */
function rtp_general_sanitize_option(){
    global $wpdb;
    
    $option = 'rtp_general';
    $default = false;
    
    $option = trim($option);
    if ( empty($option) )
        return false;
    
    if ( defined( 'WP_SETUP_CONFIG' ) )
        return false;

    if ( ! defined( 'WP_INSTALLING' ) ) {
        // prevent non-existent options from triggering multiple queries
        $notoptions = wp_cache_get( 'notoptions', 'options' );
        if ( isset( $notoptions[$option] ) )
                return $default;

        $alloptions = wp_load_alloptions();

        if ( isset( $alloptions[$option] ) ) {
            $value = $alloptions[$option];
        } else {
            $value = wp_cache_get( $option, 'options' );

            if ( false === $value ) {
                $row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", $option ) );

                // Has to be get_row instead of get_var because of funkiness with 0, false, null values
                if ( is_object( $row ) ) {
                    $value = $row->option_value;
                    wp_cache_add( $option, $value, 'options' );
                } else { // option does not exist, so we must cache its non-existence
                    $notoptions[$option] = true;
                    wp_cache_set( 'notoptions', $notoptions, 'options' );
                    return $default;
                }
            }
        }
    } else {
        $suppress = $wpdb->suppress_errors();
        $row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", $option ) );
        $wpdb->suppress_errors( $suppress );
        if ( is_object( $row ) )
            $value = $row->option_value;
        else
            return $default;
    }

	// If home is not set use siteurl.
	if ( 'home' == $option && '' == $value )
            return get_option( 'siteurl' );

	if ( in_array( $option, array('siteurl', 'home', 'category_base', 'tag_base') ) )
            $value = untrailingslashit( $value );
    
    /* Hack for serialized data containing URLs http://www.php.net/manual/en/function.unserialize.php#107886 */
    $value = preg_replace( '!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $value );
    
    return apply_filters( 'option_' . $option, maybe_unserialize( $value ) );
}
add_filter( 'pre_option_rtp_general','rtp_general_sanitize_option', 1 );