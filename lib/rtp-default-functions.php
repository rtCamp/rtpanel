<?php
/**
 * rtPanel default functions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

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
		<h3 class="tagline"><?php bloginfo( 'description' ); ?></h3><?php
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
 * Displays the comments and comment form.
 *
 * @since rtPanel 2.1
 */
function rtp_default_comments() {
	if ( is_singular() ) {
		comments_template( '', true );
	}
}

add_action( 'rtp_hook_comments', 'rtp_default_comments' );

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
 * Footer Copyright Section
 *
 * @since rtPanel 4.1.2
 */
function rtp_footer_copyright_content() {
	?>
	<div id="footer" class="rtp-footer rtp-section-container row">
		<?php $rtp_set_grid_class = apply_filters( 'rtp_set_full_width_grid_class', 'large-12 columns rtp-full-width-grid' ); ?>
		<div class="rtp-footer-section <?php echo esc_attr( $rtp_set_grid_class ); ?>">
			<p>&copy; <?php
				echo date( 'Y' );
				echo ' - ';
				bloginfo( 'name' );
				?>
				<em><?php printf( __( 'Designed on <a role="link" target="_blank" href="%s" class="rtp-common-link" title="rtPanel WordPress Theme Framework">rtPanel WordPress Theme Framework</a>.', 'rtPanel' ), RTP_THEME_URL ); ?></em></p>
		</div>
	</div><!-- #footer -->
	<?php
}

add_action( 'rtp_hook_end_footer', 'rtp_footer_copyright_content' );

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
