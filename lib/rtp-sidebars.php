<?php

/**
 * rtPanel sidebars
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * Register sidebar on widgets initialization
 */
function rtp_widgets_init() {

	$rtp_footer_widget_grid_class = apply_filters( 'rtp_set_footer_widget_grid_class', 'large-4 columns' );

	// Sidebar Widget
	register_sidebar(
			array(
				'name' => __( 'Sidebar Widgets', 'rtPanel' ),
				'id' => 'sidebar-widgets',
				'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			)
	);

	// BuddyPress Sidebar
	if ( class_exists( 'BuddyPress' ) && rtp_get_titan_option( 'buddypress_sidebar' ) && ( 'buddypress-sidebar' === rtp_get_titan_option( 'buddypress_sidebar' ) ) ) {
		register_sidebar(
				array(
					'name' => __( 'BuddyPress Sidebar Widgets', 'rtPanel' ),
					'id' => 'buddypress-sidebar-widgets',
					'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => '</h3>',
				)
		);
	}

	// bbPress Sidebar
	if ( class_exists( 'bbPress' ) && rtp_get_titan_option( 'bbpress_sidebar' ) && ( 'bbpress-sidebar' === rtp_get_titan_option( 'bbpress_sidebar' ) ) ) {
		register_sidebar(
				array(
					'name' => __( 'bbPress Sidebar Widgets', 'rtPanel' ),
					'id' => 'bbpress-sidebar-widgets',
					'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => '</h3>',
				)
		);
	}

	// Footer Widget
	if ( rtp_get_titan_option( 'footer_sidebar' ) ) {
		register_sidebar(
				array(
					'name' => __( 'Footer Widgets', 'rtPanel' ),
					'id' => 'footer-widgets',
					'before_widget' => '<div id="%1$s" class="widget footerbar-widget ' . $rtp_footer_widget_grid_class . ' %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => '</h3>',
				)
		);
	}
}

add_action( 'widgets_init', 'rtp_widgets_init' );