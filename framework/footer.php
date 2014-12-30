<?php
/**
 * Footer Area
 */
if ( ! function_exists( 'rtp_footer_content' ) ) {

	function rtp_footer_content() {
		$footer_area = rtp_get_option( 'footer_area' );
		$footer_text = rtp_get_option( 'footer_content' );
		$rtp_set_grid_class = apply_filters( 'rtp_set_full_width_grid_class', 'large-12 columns rtp-full-width-grid' );

		if ( ! empty( $footer_area ) && ! empty( $footer_text ) ) {
			?>
			<div class="rtp-footer-section <?php echo esc_attr( $rtp_set_grid_class ); ?>">
				<p><?php echo $footer_text; ?></p>
			</div><?php } else {
			?>
			<div class="rtp-footer-section <?php echo esc_attr( $rtp_set_grid_class ); ?>">
				<p>&copy; <?php
					echo date( 'Y' );
					echo ' - ';
					bloginfo( 'name' );
					?>
					<em><?php printf( __( 'Designed on <a role="link" target="_blank" href="%s" class="rtp-common-link" title="rtPanel WordPress Theme Framework">rtPanel WordPress Theme Framework</a>.', 'rtPanel' ), RTP_THEME_URL ); ?></em></p>
			</div><?php
		}
	}

}

/**
 * Footer sidebar
 */
if ( ! function_exists( 'rtp_register_footer_sidebar' ) ) {

	function rtp_register_footer_sidebar() {

		$footer_sidebar_enable = rtp_get_option( 'footer_sidebar' );
		$rtp_footer_widget_grid_class = apply_filters( 'rtp_set_footer_widget_grid_class', 'large-4 columns' );

		if ( $footer_sidebar_enable ) {
			register_sidebar( array(
				'name' => __( 'Footer Widgets', 'rtPanel' ),
				'id' => "footer-widgets",
				'before_widget' => '<div id="%1$s" class="widget footerbar-widget ' . $rtp_footer_widget_grid_class . ' %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			) );
		}
	}

}

if ( ! function_exists( 'rtp_show_footer_sidebar' ) ) {

	function rtp_show_footer_sidebar() {
		$footer_sidebar_enable = rtp_get_option( 'footer_sidebar' );
		$rtp_footer_widget_grid_class = apply_filters( 'rtp_set_footer_widget_grid_class', 'large-4 columns' );

		if ( $footer_sidebar_enable ) {
			?>
			<aside role="complementary" id="rtp-footer-widgets-wrapper" class="rtp-footerbar rtp-section-container row"><?php
				// Default Widgets ( Fallback )
				if ( ! dynamic_sidebar( 'footer-widgets' ) ) {
					?>
					<div class="widget footerbar-widget <?php echo esc_attr( $rtp_footer_widget_grid_class ); ?>"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></div>
					<div class="widget footerbar-widget <?php echo esc_attr( $rtp_footer_widget_grid_class ); ?>"><h3 class="widgettitle"><?php _e( 'Tags', 'rtPanel' ); ?></h3><div class="tagcloud"><?php wp_tag_cloud(); ?></div></div>
					<div class="widget footerbar-widget <?php echo esc_attr( $rtp_footer_widget_grid_class ); ?>"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></div><?php }
				?>
			</aside><!-- #footerbar --><?php
		}
	}

}

/**
 * Footer Navigation
 */
if ( ! function_exists( 'rtp_footer_navigation' ) ) {

	function rtp_footer_navigation() {
		$footer_navigation_enable = rtp_get_option( 'footer_navigation' );

		if ( $footer_navigation_enable && function_exists( 'wp_nav_menu' ) && has_nav_menu( 'footer' ) ) {
			wp_nav_menu( array( 'container' => '', 'menu_id' => 'rtp-footer-menu', 'theme_location' => 'footer', 'depth' => 1 ) );
		}
	}

}

