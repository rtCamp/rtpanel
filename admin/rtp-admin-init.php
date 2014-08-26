<?php

/**
 * rtPanel Theme Options
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * Includes PHP files located in 'admin/php/' folder
 */
foreach ( glob( get_template_directory() . '/admin/lib/*.php' ) as $lib_filename ) {
	require_once( $lib_filename );
}

/* Options */
require_once( get_template_directory() . '/admin/rtp-options-main.php' );

/*
 * Global Menus
 */

global $rtpanel_admin_pages;

$rtpanel_admin_pages = apply_filters( 'rtpanel_admin_subpage', array(
	'plugins' => array(
		'menu_title' => __( 'Plugins', 'rtPanel' ),
		'menu_slug' => 'plugins',
		'callback' => 'rtp_plugins_submenu_page_callback',
	),
	'support' => array(
		'menu_title' => __( 'Support', 'rtPanel' ),
		'menu_slug' => 'support',
		'callback' => 'rtp_support_submenu_page_callback',
	),
		)
);

/*
 * Register Submenu Pages for rtPanel Menu Page
 */

function rtp_register_submenu_page() {
	global $rtpanel_admin_pages;
	foreach ( $rtpanel_admin_pages as $rtpanel_admin_page ) {
		$page_hook_suffix = add_submenu_page( 'rtpanel', $rtpanel_admin_page[ 'menu_title' ], $rtpanel_admin_page[ 'menu_title' ], 'manage_options', $rtpanel_admin_page[ 'menu_slug' ], $rtpanel_admin_page[ 'callback' ] );
		add_action( 'admin_print_scripts-' . $page_hook_suffix, 'rtp_admin_page_script' );
	}

	/* This Line is Added Scripts and Styles on Main rtPanel Page */
	add_action( 'admin_print_scripts-toplevel_page_rtpanel', 'rtp_admin_page_script' );
}

/**
 * Add Toolbar Menus
 */
function rtpanel_admin_bar() {
	global $wp_admin_bar, $rtpanel_admin_pages;

	$wp_admin_bar->add_menu( array(
		'id' => 'rtpanel',
		'title' => __( 'rtPanel', 'rtPanel' ),
		'href' => esc_url( home_url( '/wp-admin/admin.php?page=rtpanel' ) ),
	) );

	$wp_admin_bar->add_menu( array(
		'id' => 'rtpanel_settings',
		'parent' => 'rtpanel',
		'title' => __( 'Settings', 'rtPanel' ),
		'href' => esc_url( home_url( '/wp-admin/admin.php?page=rtpanel' ) ),
	) );

	foreach ( $rtpanel_admin_pages as $rtpanel_admin_page ) {

		$wp_admin_bar->add_menu( array(
			'id' => $rtpanel_admin_page[ 'menu_slug' ],
			'parent' => 'rtpanel',
			'title' => $rtpanel_admin_page[ 'menu_title' ],
			'href' => esc_url( home_url( '/wp-admin/admin.php?page=' . $rtpanel_admin_page[ 'menu_slug' ] ) ),
		) );
	}
}

/* Hook into the 'wp_before_admin_bar_render' action */
add_action( 'wp_before_admin_bar_render', 'rtpanel_admin_bar', 999 );

/**
 * Admin Style and Scripts
 */
function rtp_admin_page_script() {
	wp_enqueue_script( 'rtp-admin-scripts', RTP_TEMPLATE_URL . '/admin/js/rtp-admin-min.js' );
	wp_enqueue_style( 'rtp-admin-styles', RTP_TEMPLATE_URL . '/admin/css/rtp-admin.css' );
}

add_action( 'admin_menu', 'rtp_register_submenu_page' );

/**
 * Submit support request
 */
function rtp_submit_support_request() {
	if ( class_exists( 'rtPanelSupport' ) ) {
		$ib_support = new rtPanelSupport( false );
		$ib_support->submit_request();
	}
}

add_action( 'wp_ajax_rtpanel_submit_request', 'rtp_submit_support_request', 1 );

/**
 * Change rtPanel title to setting in WP Dashboard menu.
 */
function rtp_admin_menu_js() { ?>
	<script type="text/javascript">
		jQuery(document).ready( function() {
			jQuery( '#toplevel_page_rtpanel li.wp-first-item a' ).text( 'Settings' );
		} );
	</script><?php
}

add_action( 'admin_head', 'rtp_admin_menu_js' );