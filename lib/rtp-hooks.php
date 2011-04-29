<?php
/* 
 * The template contain all hooks in rtPanel
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

/** for adding content before #header */
function rtp_hook_before_header() {
    do_action( 'rtp_hook_before_header' );
}

/** for adding content after #header */
function rtp_hook_after_header() {
    do_action( 'rtp_hook_after_header' );
}

/** for adding content before site logo*/
function rtp_hook_before_logo() {
    do_action( 'rtp_hook_before_logo' );
}

/** for adding content after site logo */
function rtp_hook_after_logo() {
    do_action( 'rtp_hook_after_logo' );
}

/** for adding content after #content-wrapper begins */
function rtp_hook_begin_content_wrapper() {
    do_action( 'rtp_hook_begin_content_wrapper' );
}

/** for adding content before #content-wrapper ends */
function rtp_hook_end_content_wrapper() {
    do_action( 'rtp_hook_end_content_wrapper' );
}

/** for adding content after #content begins */
function rtp_hook_begin_content() {
    do_action( 'rtp_hook_begin_content' );
}

/** for adding content before #content ends */
function rtp_hook_end_content() {
    do_action( 'rtp_hook_end_content' );
}

/** for adding content after .post begins */
function rtp_hook_begin_post() {
    do_action( 'rtp_hook_begin_post' );
}

/** for adding content before .post ends */
function rtp_hook_end_post() {
    do_action( 'rtp_hook_end_post' );
}

/** for adding content before post's title appears. */
function rtp_hook_begin_post_title() {
    do_action( 'rtp_hook_begin_post_title' );
}

/** for adding content after post's title appears. */
function rtp_hook_end_post_title() {
    do_action( 'rtp_hook_end_post_title' );
}

/** for adding content before post's meta appears. */
function rtp_hook_begin_post_meta_top() {
    do_action( 'rtp_hook_begin_post_meta_top' );
}

/** for displaying default rtp post's meta. */
function rtp_hook_post_meta( $placement ) {
    if( $placement == 'bottom' )
        do_action( 'rtp_hook_post_meta_bottom', $placement );
    else
        do_action( 'rtp_hook_post_meta_top', $placement );
}

/** for adding content after post's meta appears. */
function rtp_hook_end_post_meta_top() {
    do_action( 'rtp_hook_end_post_meta_top' );
}

/** for adding content before post's meta appears.
 */
function rtp_hook_begin_post_meta_bottom() {
    do_action( 'rtp_hook_begin_post_meta_bottom' );
}

/** for adding content after post's meta appears. */
function rtp_hook_end_post_meta_bottom() {
    do_action( 'rtp_hook_end_post_meta_bottom' );
}

/** for adding content before post-content begins */
function rtp_hook_begin_post_content() {
    do_action( 'rtp_hook_begin_post_content' );
}

/** for adding content after post-content ends */
function rtp_hook_end_post_content() {
    do_action( 'rtp_hook_end_post_content' );
}

/** for adding content after #sidebar begins */
function rtp_hook_begin_sidebar() {
    do_action( 'rtp_hook_begin_sidebar' );
}

/** for adding content before #sidebar ends */
function rtp_hook_end_sidebar() {
    do_action( 'rtp_hook_end_sidebar' );
}

/** for adding content before #footer */
function rtp_hook_before_footer() {
    do_action( 'rtp_hook_before_footer' );
}

/** for adding content after #footer */
function rtp_hook_after_footer() {
    do_action( 'rtp_hook_after_footer' );
}