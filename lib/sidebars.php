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

	global $rtp_general;
	$rtp_footer_widget_grid_class = apply_filters( 'rtp_set_footer_widget_grid_class', 'large-4 columns' );

	// Sidebar Widget
	register_sidebar(
		array(
			'name'			 => __( 'Sidebar Widgets', 'rtPanel' ),
			'id'			 => 'sidebar-widgets',
			'before_widget'	 => '<div id="%1$s" class="widget sidebar-widget %2$s">',
			'after_widget'	 => '</div>',
			'before_title'	 => '<h3 class="widgettitle">',
			'after_title'	 => '</h3>',
		)
	);

	// BuddyPress Sidebar
	if ( class_exists( 'BuddyPress' ) && isset( $rtp_general[ 'buddypress_sidebar' ] ) && ($rtp_general[ 'buddypress_sidebar' ] === 'buddypress-sidebar') ) {
		register_sidebar(
			array(
				'name'			 => __( 'BuddyPress Sidebar Widgets', 'rtPanel' ),
				'id'			 => 'buddypress-sidebar-widgets',
				'before_widget'	 => '<div id="%1$s" class="widget sidebar-widget %2$s">',
				'after_widget'	 => '</div>',
				'before_title'	 => '<h3 class="widgettitle">',
				'after_title'	 => '</h3>',
			)
		);
	}

	// bbPress Sidebar
	if ( class_exists( 'bbPress' ) && isset( $rtp_general[ 'bbpress_sidebar' ] ) && ($rtp_general[ 'bbpress_sidebar' ] === 'bbpress-sidebar') ) {
		register_sidebar(
			array(
				'name'			 => __( 'bbPress Sidebar Widgets', 'rtPanel' ),
				'id'			 => 'bbpress-sidebar-widgets',
				'before_widget'	 => '<div id="%1$s" class="widget sidebar-widget %2$s">',
				'after_widget'	 => '</div>',
				'before_title'	 => '<h3 class="widgettitle">',
				'after_title'	 => '</h3>',
			)
		);
	}

	// Footer Widget
	if ( isset( $rtp_general[ 'footer_sidebar' ] ) && $rtp_general[ 'footer_sidebar' ] ) {
		register_sidebar(
			array(
				'name'			 => __( 'Footer Widgets', 'rtPanel' ),
				'id'			 => 'footer-widgets',
				'before_widget'	 => '<div id="%1$s" class="widget footerbar-widget ' . $rtp_footer_widget_grid_class . ' %2$s">',
				'after_widget'	 => '</div>',
				'before_title'	 => '<h3 class="widgettitle">',
				'after_title'	 => '</h3>',
			)
		);
	}
}

add_action( 'widgets_init', 'rtp_widgets_init' );
