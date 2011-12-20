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
$content_width = ( isset( $content_width ) ) ? $content_width : 615;

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
        global $rtp_general;
        rtp_theme_setup_values();
        add_theme_support( 'post-thumbnails' ); // This theme uses post thumbnails
        add_theme_support( 'automatic-feed-links' ); // Add default posts and comments RSS feed links to head
        add_editor_style( './css/rtp-editor-style.css' ); // This theme styles the visual editor with editor-style.css to match the theme style.
        load_theme_textdomain( 'rtPanel', TEMPLATEPATH . '/languages' ); // Load the text domain
        add_custom_background(); // Add support for custom background

        // Don't support text inside the header image
        if ( !defined( 'NO_HEADER_TEXT' ) ) {
            define( 'NO_HEADER_TEXT', true );
        }

        define( 'HEADER_TEXTCOLOR' , '' );
        define( 'HEADER_IMAGE_WIDTH' , apply_filters( 'rtp_header_image_width', 960 ) );
        define( 'HEADER_IMAGE_HEIGHT' , apply_filters( 'rtp_header_image_height', 190 ) );

        // adding support for the header image
        add_custom_image_header( 'rtp_header_style', 'rt_admin_header_style' );

        // Make use of wp_nav_menu() for navigation purpose
        register_nav_menus( array(
            'primary' => __( 'Primary Navigation', 'rtPanel' )
        ) );

    }
}
add_action( 'after_setup_theme', 'rtpanel_setup' );// Tell WordPress to run rtpanel_setup() when the 'after_setup_theme' hook is run

if ( !function_exists( 'rtp_header_style' ) ) {
    /**
     * Site header styling
     *
     * @since rtPanel 2.0
     */
    function rtp_header_style() {
        if ( get_header_image() ) { ?>
            <style type="text/css"> #header-wrapper { background: url(<?php header_image(); ?>) no-repeat;width: <?php echo HEADER_IMAGE_WIDTH; ?>px; height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; } </style><?php
        }
    }
}

if ( !function_exists( 'rt_admin_header_style' ) ) {
    /**
     * Admin header preview styling
     *
     * @since rtPanel 2.0
     */
    function rt_admin_header_style() { ?>
        <style type="text/css">  #headimg { width: <?php echo HEADER_IMAGE_WIDTH; ?>px; height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; } </style><?php
    }
}

/**
 * Enqueues IE Specific CSS
 *
 * @since rtPanel 2.0
 */
function rtp_ie_css() {
    wp_register_style( 'rtp-styles-ie7', RTP_CSS_FOLDER_URL . '/rtp-ie7.css', '', '', 'screen, projection' );
    wp_register_style( 'rtp-styles-ie6', RTP_CSS_FOLDER_URL . '/rtp-ie6.css', '', '', 'screen, projection' );
    $GLOBALS['wp_styles']->add_data( 'rtp-styles-ie7', 'conditional', 'IE 7' );
    $GLOBALS['wp_styles']->add_data( 'rtp-styles-ie6', 'conditional', 'IE 6' );
    wp_enqueue_style( 'rtp-styles-ie7' );
    wp_enqueue_style( 'rtp-styles-ie6' );
}
add_action( 'wp_enqueue_scripts', 'rtp_ie_css' );

/**
 * Enqueues rtPanel Default Styles
 *
 * @since rtPanel 2.0.7
 */
function rtp_default_css() {
    wp_register_style( 'rtp-print-css', RTP_CSS_FOLDER_URL . '/rtp-print.css', '', '', 'print' );
    wp_enqueue_style( 'rtp-print-css' );
}
add_action( 'wp_enqueue_scripts', 'rtp_default_css' );

/**
 * Displays Custom Styles
 *
 * @since rtPanel 2.0
 */
function rtp_custom_styles() { 
    global $rtp_general;
    echo ( $rtp_general['custom_styles'] ) ? '<style type="text/css" media="screen">' . $rtp_general['custom_styles'] . '</style>' : '';
}
add_action( 'wp_enqueue_scripts', 'rtp_custom_styles' );

/**
 * Enqueues rtPanel Default Scripts
 *
 * @since rtPanel 2.0.7
 */
function rtp_default_scripts() { 
    // Nested Comment Support
    ( is_singular() && get_option( 'thread_comments' ) ) ? wp_enqueue_script('comment-reply') : '';
    wp_enqueue_script( 'rtp-custom', RTP_JS_FOLDER_URL . '/rtp-custom.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'rtp_default_scripts' );

/**
 * Outputs Scripts in the footer
 * Files which are attached in rtp_footer_scripts() should append in wp_footer();
 *
 * @since rtPanel 2.0
 */
function rtp_footer_scripts() { ?>
    <!--[if lte IE 7]>
        <script type="text/javascript" src="<?php echo RTP_JS_FOLDER_URL; ?>/rtp-custom-ie7.js"></script>
    <![endif]-->
    
    <!--[if IE 6]>
        <script type="text/javascript" src="<?php echo RTP_JS_FOLDER_URL; ?>/rtp-custom-ie6.js"></script>
    <![endif]--><?php
}
add_action( 'wp_footer', 'rtp_footer_scripts' );

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