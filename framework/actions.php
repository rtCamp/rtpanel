<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Navigation
add_action( 'rtp_hook_within_header', 'rtp_default_nav_menu' );

// Header Logo
add_action( 'rtp_hook_within_header', 'rtp_header_logo' );

// Favicon
add_action( 'wp_head', 'rtp_favicon' );
add_action( 'admin_head', 'rtp_favicon' );

//Footer
add_action( 'widgets_init', 'rtp_register_footer_sidebar' );
add_action( 'rtp_hook_begin_footer', 'rtp_show_footer_sidebar' );
add_action( 'rtp_hook_end_footer', 'rtp_footer_navigation' );
add_action( 'rtp_hook_end_footer', 'rtp_footer_content' );
