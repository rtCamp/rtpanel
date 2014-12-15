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
global $content_width, $max_content_width;
$content_width = ( isset( $content_width ) ) ? $content_width : 780;
$max_content_width = ( isset( $max_content_width ) ) ? $max_content_width : 1200;

if ( ! function_exists( 'rtpanel_setup' ) ) {

	/**
	 * Sets up rtPanel
	 *
	 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
	 * @uses register_nav_menus() To add support for navigation menus.
	 *
	 * @since rtPanel 2.0
	 */
	function rtpanel_setup() {

		/*
		 * Make rtPanle available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on rtPanel, use a find and
		 * replace to change 'rtPanel' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'rtPanel', get_template_directory() . '/languages' );

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( 'style.css' );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background' );

		// Add support for custom headers.
		$rtp_custom_header_support = array(
			// The height and width of our custom header.
			'width' => apply_filters( 'rtp_header_image_width', 1200 ),
			'height' => apply_filters( 'rtp_header_image_height', 200 ),
			'header-text' => false,
			'wp-head-callback' => '',
			'admin-head-callback' => '',
		);
		add_theme_support( 'custom-header', $rtp_custom_header_support );

		/*
		 * Switches default core markup for search form, comment form,
		 * and comments to output valid HTML5.
		 */
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

		/**
		 * Adds RSS feed links to head for posts and comments.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// Make use of wp_nav_menu() for navigation purpose
		register_nav_menus(
				array(
					'primary' => __( 'Primary Navigation', 'rtPanel' )
				)
		);
	}

}
add_action( 'after_setup_theme', 'rtpanel_setup' ); // Tell WordPress to run rtpanel_setup() when the 'after_setup_theme' hook is run

/**
 * Site header image
 *
 * @since rtPanel 2.3
 */
if ( ! function_exists( 'rtp_header_image' ) ) {

	/**
	 * Get header image if it exists
	 */
	function rtp_header_image() {
		if ( get_header_image() ) {
			?>
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

	/* Register Theme jQuery */
	wp_register_script( 'rtp-package-min', RTP_JS_FOLDER_URL . '/rtp-package-min.js', array( 'jquery' ), RTP_VERSION, true );

	/* Register Theme Main Stylesheet. */
	wp_register_style( 'rtp-style', get_stylesheet_uri(), array(), RTP_VERSION );

	/**
	 * Enqueue Scripts and Styles
	 */
	wp_enqueue_script( 'rtp-package-min' );
	wp_enqueue_style( 'rtp-style' );

	// Nested Comment Support
	( is_singular() && get_option( 'thread_comments' ) ) ? wp_enqueue_script( 'comment-reply' ) : '';
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

	if ( $is_lynx )
		$classes[] = 'lynx';
	elseif ( $is_gecko )
		$classes[] = 'gecko';
	elseif ( $is_opera )
		$classes[] = 'opera';
	elseif ( $is_NS4 )
		$classes[] = 'ns4';
	elseif ( $is_safari )
		$classes[] = 'safari';
	elseif ( $is_chrome )
		$classes[] = 'chrome';
	elseif ( $is_IE ) {
		$classes[] = 'ie';
		if ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) && preg_match( '/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER[ 'HTTP_USER_AGENT' ], $browser_version ) ) {
			$classes[] = 'ie' . $browser_version[ 1 ];
		}
	} else {
		$classes[] = 'unknown';
	}

	if ( $is_iphone ) {
		$classes[] = 'iphone';
	}

	if ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) && stristr( $_SERVER[ 'HTTP_USER_AGENT' ], 'mac' ) ) {
		$classes[] = 'osx';
	} elseif ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) && stristr( $_SERVER[ 'HTTP_USER_AGENT' ], 'linux' ) ) {
		$classes[] = 'linux';
	} elseif ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) && stristr( $_SERVER[ 'HTTP_USER_AGENT' ], 'windows' ) ) {
		$classes[] = 'windows';
	}

	if ( ! is_multi_author() ) {
		$classes[] = 'rtp-single-author';
	}

	if ( is_multi_author() ) {
		$classes[] = 'rtp-group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} else {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'rtp-list-view';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	return $classes;
}

add_filter( 'body_class', 'rtp_body_class' );

/**
 * Remove category from rel attribute to solve validation error.
 *
 * @since rtPanel 2.1
 * @param String $output markup of categories list
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
	return ( function_exists( 'bp_current_component' ) && bp_current_component() );
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
		if ( isset( $rtp_yarpp[ 'auto_display_post_types' ] ) && is_array( $rtp_yarpp[ 'auto_display_post_types' ] ) ) {
			return ( in_array( $post->post_type, $rtp_yarpp[ 'auto_display_post_types' ] ) );
		} else {
			return false;
		}
	} else {
		return false;
	}
}

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

	if ( is_feed() ) {
		return $title;
	}

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
	return ( in_array( get_post_type(), array( 'rtmedia', 'bp_member', 'bp_group' ) ) );
}
