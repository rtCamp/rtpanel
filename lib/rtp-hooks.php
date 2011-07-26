<?php
/**
 * The template containing all hooks in rtPanel
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

/**
 * For adding content before #header
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_before_header() {
    do_action( 'rtp_hook_before_header' );
}

/**
 * For adding content after #header
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_after_header() {
    do_action( 'rtp_hook_after_header' );
}

/**
 * For adding content before site logo
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_before_logo() {
    do_action( 'rtp_hook_before_logo' );
}

/**
 * For adding content after site logo
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_after_logo() {
    do_action( 'rtp_hook_after_logo' );
}

/**
 * For adding content at the beginning of #content-wrapper
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_begin_content_wrapper() {
    do_action( 'rtp_hook_begin_content_wrapper' );
}

/**
 * For adding content at the end of #content-wrapper
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_end_content_wrapper() {
    do_action( 'rtp_hook_end_content_wrapper' );
}

/**
 * For adding content at the beginning of #content
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_begin_content() {
    do_action( 'rtp_hook_begin_content' );
}

/**
 * For adding content at the end of #content
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_end_content() {
    do_action( 'rtp_hook_end_content' );
}

/**
 * For adding content at the beginning of .post
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_begin_post() {
    do_action( 'rtp_hook_begin_post' );
}

/**
 * For adding content at the end of .post
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_end_post() {
    do_action( 'rtp_hook_end_post' );
}

/**
 * For adding content before post's title appears
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_begin_post_title() {
    do_action( 'rtp_hook_begin_post_title' );
}

/**
 * For adding content after post's title appears
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_end_post_title() {
    do_action( 'rtp_hook_end_post_title' );
}

/**
 * For displaying default post's meta
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_post_meta( $placement ) {
    if( $placement == 'bottom' )
        do_action( 'rtp_hook_post_meta_bottom', $placement );
    else
        do_action( 'rtp_hook_post_meta_top', $placement );
}

/**
 * For adding content before post's meta that appears on top
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_begin_post_meta_top() {
    do_action( 'rtp_hook_begin_post_meta_top' );
}

/**
 * For adding content after post's meta that appears on top
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_end_post_meta_top() {
    do_action( 'rtp_hook_end_post_meta_top' );
}

/**
 * For adding content before post's meta that appears at bottom
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_begin_post_meta_bottom() {
    do_action( 'rtp_hook_begin_post_meta_bottom' );
}

/**
 * For adding content after post's meta that appears at the bottom
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_end_post_meta_bottom() {
    do_action( 'rtp_hook_end_post_meta_bottom' );
}

/**
 * For adding content at the beginning of post content
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_begin_post_content() {
    do_action( 'rtp_hook_begin_post_content' );
}

/**
 * For adding content at the end of post content
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_end_post_content() {
    do_action( 'rtp_hook_end_post_content' );
}

/**
 * For adding content at the beginning of #sidebar
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_begin_sidebar() {
    do_action( 'rtp_hook_begin_sidebar' );
}

/**
 * For adding content at the end of #sidebar
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_end_sidebar() {
    do_action( 'rtp_hook_end_sidebar' );
}

/**
 * For adding content before #footer
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_before_footer() {
    do_action( 'rtp_hook_before_footer' );
}

/**
 * For adding content after #footer
 *
 * @since rtPanel Theme 2.0
 */
function rtp_hook_after_footer() {
    do_action( 'rtp_hook_after_footer' );
}