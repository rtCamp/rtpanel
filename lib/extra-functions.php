<?php
/**
 * rtPanel default functions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

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
 * Default Navigation Menu
 */
function rtp_default_nav_menu() {
	echo '<nav id="rtp-primary-menu" role="navigation" class="clearfix rtp-nav-wrapper' . apply_filters( 'rtp_mobile_nav_support', ' rtp-mobile-nav' ) . '">';
	rtp_hook_begin_primary_menu();

	/* Call wp_nav_menu() for Wordpress Navigaton with fallback wp_list_pages() if menu not set in admin panel */
	if ( function_exists( 'wp_nav_menu' ) && has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array( 'container' => '', 'menu_class' => 'menu rtp-nav-container clearfix', 'menu_id' => 'rtp-nav-menu', 'theme_location' => 'primary', 'depth' => apply_filters( 'rtp_nav_menu_depth', 4 ), ) );
	} else {
		echo '<ul id="rtp-nav-menu" class="menu rtp-nav-container clearfix">';
		wp_list_pages( array( 'title_li' => '', 'sort_column' => 'menu_order', 'number' => '5', 'depth' => apply_filters( 'rtp_nav_menu_depth', 4 ), ) );
		echo '</ul>';
	}

	rtp_hook_end_primary_menu();
	echo '</nav>';
}

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
			<img class="rtp-header-image" src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" /><?php
		}
	}

}

add_action( 'rtp_hook_within_header', 'rtp_header_image' );

/**
 * 'Edit' link for post/page
 *
 * @since rtPanel 2.0
 */
function rtp_edit_link() {
	// Call Edit Link
	edit_post_link( __( 'Edit', 'rtPanel' ), '<span class="rtp-edit-link">', '&nbsp;</span>' );
}

add_action( 'rtp_hook_begin_post_meta_top', 'rtp_edit_link' );

/**
 * Adds Site Description
 *
 * @since rtPanel 2.0.7
 */
function rtp_blog_description() {
	if ( get_bloginfo( 'description' ) ) {
		?>
		<p class="tagline"><?php bloginfo( 'description' ); ?></p><?php
	}
}

add_action( 'rtp_hook_after_logo', 'rtp_blog_description' );

/**
 * Displays the sidebar.
 *
 * @since rtPanel 2.1
 */
function rtp_default_sidebar() {
	get_sidebar();
}

add_action( 'rtp_hook_sidebar', 'rtp_default_sidebar' );

/**
 * Get the sidebar ID for current page.
 *
 * @since rtPanel 3.1
 */
function rtp_get_sidebar_id() {
	global $rtp_general;
	$sidebar_id = 'sidebar-widgets';

	if ( function_exists( 'bp_current_component' ) && bp_current_component() ) {

		if ( $rtp_general[ 'buddypress_sidebar' ] === 'buddypress-sidebar' ) {
			$sidebar_id = 'buddypress-sidebar-widgets';
		} else if ( $rtp_general[ 'buddypress_sidebar' ] === 'no-sidebar' ) {
			$sidebar_id = 0;
		}
	} else if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {

		if ( $rtp_general[ 'bbpress_sidebar' ] === 'bbpress-sidebar' ) {
			$sidebar_id = 'bbpress-sidebar-widgets';
		} else if ( $rtp_general[ 'bbpress_sidebar' ] === 'no-sidebar' ) {
			$sidebar_id = 0;
		}
	}
	return $sidebar_id;
}

/**
 * Add WooCommerce support, tested upto WooCommerce version 2.0.20
 *
 * @since rtPanel 4.0
 */
function rtp_add_woocommerce_support() {
	if ( class_exists( 'Woocommerce' ) ) {

		/**
		 * Unhook WooCommerce Wrappers
		 */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		/**
		 * Hook rtPanel wrappers
		 */
		add_action( 'woocommerce_before_main_content', 'rtp_woocommerce_wrapper_start', 10 );
		add_action( 'woocommerce_after_main_content', 'rtp_woocommerce_wrapper_end', 10 );

		/**
		 * Declare theme support for WooCommerce
		 */
		add_theme_support( 'woocommerce' );
	}
}

add_action( 'init', 'rtp_add_woocommerce_support' );

/**
 * rtPanel WooCommerce Wrapper Start
 *
 * @since rtPanel 4.0
 */
function rtp_woocommerce_wrapper_start() {
	$rtp_content_grid_class = apply_filters( 'rtp_set_content_grid_class', 'large-8 columns ' );

	if ( is_shop() || is_archive() || is_category() ) {
		$rtp_content_class = ' class="rtp-content-section ' . $rtp_content_grid_class . ' rtp-woocommerce-archive" ';
	} else {
		$rtp_content_class = ' class="rtp-content-section ' . $rtp_content_grid_class . ' rtp-singular" ';
	}
	echo '<section id="content" role="main"' . $rtp_content_class . '>';
}

/**
 * rtPanel WooCommerce Wrapper End
 *
 * @since rtPanel 4.0
 */
function rtp_woocommerce_wrapper_end() {
	echo '</section> <!-- End of #content -->';
}

/**
 * Default sidebar text if widgets are inactive
 *
 * @since rtPanel 4.1.3
 */
function rtp_sidebar_content() {
	?>
	<div class="widget sidebar-widget">
		<p>
			<?php _e( '<strong>rtPanel</strong> is equipped with everything you need to produce a professional website. <br />It is one of the most optimized WordPress Theme Framework available today.', 'rtPanel' ); ?>
		</p>
		<p class="rtp-message-success">
			<?php printf( __( 'This theme comes with free technical <a title="Click here for rtPanel Free Support" target="_blank" href="%s">Support</a> by team of 30+ full-time developers.', 'rtPanel' ), RTP_FORUM_URL ); ?>
		</p>
	</div><?php
}

add_action( 'rtp_hook_sidebar_content', 'rtp_sidebar_content' );
