<?php
/**
 * rtPanel Hooks
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

/**
 * Adds content at the beginning of body
 *
 * @since rtPanel 2.1
 */
function rtp_hook_begin_body() {
    do_action( 'rtp_hook_begin_body' );
}

/**
 * Adds content at the end of body
 *
 * @since rtPanel 2.1
 */
function rtp_hook_end_body() {
    do_action( 'rtp_hook_end_body' );
}

/**
 * Adds content before #header
 *
 * @since rtPanel 2.0
 */
function rtp_hook_before_header() {
    do_action( 'rtp_hook_before_header' );
}

/**
 * Adds content after #header
 *
 * @since rtPanel 2.0
 */
function rtp_hook_after_header() {
    do_action( 'rtp_hook_after_header' );
}

/**
 * Adds content before site logo
 *
 * @since rtPanel 2.0
 */
function rtp_hook_before_logo() {
    do_action( 'rtp_hook_before_logo' );
}

/**
 * Adds content after site logo
 *
 * @since rtPanel 2.0
 */
function rtp_hook_after_logo() {
    do_action( 'rtp_hook_after_logo' );
}

/**
 * Adds content at the beginning of #content-wrapper
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_content_wrapper() {
    do_action( 'rtp_hook_begin_content_wrapper' );
}

/**
 * Adds content at the end of #content-wrapper
 *
 * @since rtPanel 2.0
 */
function rtp_hook_end_content_wrapper() {
    do_action( 'rtp_hook_end_content_wrapper' );
}

/**
 * Adds content at the beginning of #content
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_content() {
    do_action( 'rtp_hook_begin_content' );
}

/**
 * Adds content at the end of #content
 *
 * @since rtPanel 2.0
 */
function rtp_hook_end_content() {
    do_action( 'rtp_hook_end_content' );
}

/**
 * Adds content at the beginning of .post
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_post() {
    do_action( 'rtp_hook_begin_post' );
}

/**
 * Adds content at the end of .post
 *
 * @since rtPanel 2.0
 */
function rtp_hook_end_post() {
    do_action( 'rtp_hook_end_post' );
}

/**
 * Adds content before post's title
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_post_title() {
    do_action( 'rtp_hook_begin_post_title' );
}

/**
 * Adds content after post's title
 *
 * @since rtPanel 2.0
 */
function rtp_hook_end_post_title() {
    do_action( 'rtp_hook_end_post_title' );
}

/**
 * Adds Post Meta Box (default behavior)
 *
 * @since rtPanel 2.0
 */
function rtp_hook_post_meta( $placement ) {
    if( $placement == 'bottom' )
        do_action( 'rtp_hook_post_meta_bottom', $placement );
    else
        do_action( 'rtp_hook_post_meta_top', $placement );
}

/**
 * Adds content before Top Post Meta Box
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_post_meta_top() {
    do_action( 'rtp_hook_begin_post_meta_top' );
}

/**
 * Adds content after Top Post Meta Box
 *
 * @since rtPanel 2.0
 */
function rtp_hook_end_post_meta_top() {
    do_action( 'rtp_hook_end_post_meta_top' );
}

/**
 * Adds content before Bottom Post Meta Box
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_post_meta_bottom() {
    do_action( 'rtp_hook_begin_post_meta_bottom' );
}

/**
 * Adds content after Bottom Post Meta Box
 *
 * @since rtPanel 2.0
 */
function rtp_hook_end_post_meta_bottom() {
    do_action( 'rtp_hook_end_post_meta_bottom' );
}

/**
 * Adds content to the beginning of .post-content
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_post_content() {
    do_action( 'rtp_hook_begin_post_content' );
}

/**
 * Adds content at the end of .post-content
 *
 * @since rtPanel 2.0
 */
function rtp_hook_end_post_content() {
    do_action( 'rtp_hook_end_post_content' );
}

/**
 * Basically used for displaying the comment form and comments.
 *
 * @since rtPanel 2.1
 */
function rtp_hook_comments() {
    do_action( 'rtp_hook_comments' );
}

/**
 * Basically used for displaying the sidebar.
 *
 * @since rtPanel 2.1
 */
function rtp_hook_sidebar() {
    do_action( 'rtp_hook_sidebar' );
}

/**
 * Adds content at the beginning of #sidebar
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_sidebar() {
    do_action( 'rtp_hook_begin_sidebar' );
}

/**
 * Adds content at the end of #sidebar
 *
 * @since rtPanel 2.0
 */
function rtp_hook_end_sidebar() {
    do_action( 'rtp_hook_end_sidebar' );
}

/**
 * Adds content before #footer
 *
 * @since rtPanel 2.0
 */
function rtp_hook_before_footer() {
    do_action( 'rtp_hook_before_footer' );
}

/**
 * Adds content after #footer
 *
 * @since rtPanel 2.0
 */
function rtp_hook_after_footer() {
    do_action( 'rtp_hook_after_footer' );
}

/**
 * Adds content inside post meta top ( Basically to show comment count )
 *
 * @since rtPanel 2.1
 */
function rtp_hook_post_meta_top_comment() {
    do_action( 'rtp_hook_post_meta_top_comment' );
}

/**
 * Hook used basically for single pagination
 *
 * @since rtPanel 2.1
 */
function rtp_hook_single_pagination() {
    do_action( 'rtp_hook_single_pagination' );
}

/**
 * Hook used basically for archive pagination
 *
 * @since rtPanel 2.1
 */
function rtp_hook_archive_pagination() {
    do_action( 'rtp_hook_archive_pagination' );
}