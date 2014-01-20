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
            'width'                 => apply_filters( 'rtp_header_image_width', 1200 ),
            'height'                => apply_filters( 'rtp_header_image_height', 200 ),
            'header-text'           => false,
            'wp-head-callback'      => '',
            'admin-head-callback'   => '',
	);
	add_theme_support( 'custom-header', $rtp_custom_header_support );
        
        /*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
        
        /**
         * Adds RSS feed links to head for posts and comments.
         */
	add_theme_support( 'automatic-feed-links' );

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
add_action( 'rtp_hook_begin_header', 'rtp_header_image' );

/**
 * Enqueues rtPanel Default Scripts
 *
 * @since rtPanel 2.0.7
 * @version 2.1
 */
function rtp_default_scripts() {
    /* Mobile Navigation Script */
    wp_enqueue_script( 'rtp-modernizr', RTP_BOWER_COMPONENTS_URL . '/foundation/js/vendor/custom.modernizr.js', array( 'jquery' ), '', false );
    wp_enqueue_script( 'rtp-foundation-js', RTP_BOWER_COMPONENTS_URL . '/foundation/js/foundation.min.js', array( 'jquery', 'rtp-modernizr' ), '', true );
    wp_enqueue_script( 'rtp-jquery-sidr', RTP_JS_FOLDER_URL . '/jquery.sidr.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'rtp-app-js', RTP_JS_FOLDER_URL . '/rtp-app.js', array( 'jquery', 'rtp-foundation-js', 'rtp-jquery-sidr' ), '', true );

    /* Google Font: Open Sans */
    wp_enqueue_style( 'rtp-google-font', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700', '', NULL );

    /* Fontello icons */
    wp_enqueue_style( 'rtp-icon-fonts-animation', RTP_ASSETS_URL . '/fontello/css/animation.css', '', NULL );
    wp_enqueue_style( 'rtp-icon-fonts', RTP_ASSETS_URL . '/fontello/css/rtpanel-fontello.css', '', NULL );

    // Loads our main stylesheet.
    wp_enqueue_style( 'rtpanel-style', get_stylesheet_uri(), array( 'rtp-google-font', 'rtp-icon-fonts-animation', 'rtp-icon-fonts' ), RTP_VERSION );

    // Nested Comment Support
    ( is_singular() && get_option( 'thread_comments' ) ) ? wp_enqueue_script('comment-reply') : '';
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
 * Check if BuddyPress Exists and if on a BuddyPress Page
 *
 * @since rtPanel 4.0
 */
function rtp_is_buddypress() {
    return ( function_exists('bp_current_component') && bp_current_component() );
}

/**
 * Check if yarpp plugin exists and if cuurent post type is activated in yarpp
 *
 * @since rtPanel 4.0
 */
function rtp_is_yarpp() {
    global $post;
    $rtp_yarpp = '';
    if ( function_exists( 'related_posts' ) ) {
        $rtp_yarpp = get_option( 'yarpp' );
        return ( in_array( $post->post_type, $rtp_yarpp['auto_display_post_types'] ) );
    } else {
        return false;
    }
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
    $value = preg_replace( '!s:(\d+):"(.*?)";!s', "'s:'.strlen('$2').':\"$2\";'" , $value );
    
    return apply_filters( 'option_' . $option, maybe_unserialize( $value ) );
}
add_filter( 'pre_option_rtp_general','rtp_general_sanitize_option', 1 );

/**
 * rtp_head() function call in wp_head
 * 
 * @since rtPanel 4.1
 */
function rtp_head_call() {
    if ( function_exists( 'rtp_head' ) ) {
        rtp_head();
    }
}
add_action( 'wp_head', 'rtp_head_call', 999 );

/**
 * rtp_hook_end_body() function call in wp_footer
 * 
 * @since rtPanel 4.1
 */
function rtp_footer_call() {
    if ( function_exists( 'rtp_hook_end_body' ) ) {
        rtp_hook_end_body();
    }
}
add_action( 'wp_footer', 'rtp_footer_call', 999 );

/**
 * Create formatted and SEO friendly title
 * 
 * @param string $title Default title text for current view
 * @param string $sep Optional separator
 * @return string The filtered title
 * 
 * @since rtPanel 4.1.1
 */
function rtp_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() ) { return $title; }
    
    // Add the site name
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ) {
            $title = "$title $sep " . sprintf( __( 'Page %s', 'rtPanel' ), max( $paged, $page ) );
    }
    return $title;
}
add_filter( 'wp_title', 'rtp_wp_title', 10, 2 );


/**
 * Check if current page is rtMedia page
 *
 * @since rtPanel 4.1.1
 */
function rtp_is_rtmedia() {
    return ( in_array( get_post_type(), array( 'rtmedia', 'bp_member', 'bp_group') ) );
}