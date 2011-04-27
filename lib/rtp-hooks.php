<?php
/* 
 * The template contain all hooks in rtPanel
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */


/**
 * Fire the rtp_hook_before_header action
 *
 * @uses do_action() Calls 'rtp_hook_before_header' hook.
 * @uses for adding content before #header
 */
function rtp_hook_before_header() {
    do_action( 'rtp_hook_before_header' );
}


/**
 * Fire the rtp_hook_after_header action
 *
 * @uses do_action() Calls 'rtp_hook_after_header' hook.
 * @uses Used for adding content after #header
 */
function rtp_hook_after_header() {
    do_action( 'rtp_hook_after_header' );
}

/**
 * Fire the rtp_hook_before_header action
 *
 * @uses do_action() Calls 'rtp_hook_before_header' hook.
 * @uses for adding content before #header
 */
function rtp_hook_before_logo() {
    do_action( 'rtp_hook_before_logo' );
}


/**
 * Fire the rtp_hook_after_header action
 *
 * @uses do_action() Calls 'rtp_hook_after_header' hook.
 * @uses Used for adding content after #header
 */
function rtp_hook_after_logo() {
    do_action( 'rtp_hook_after_logo' );
}


/**
 * Fire the rtp_hook_before_content_wrapper action
 *
 * @uses do_action() Calls 'rtp_hook_before_content_wrapper' hook.
 * @uses Used for adding content before #content-wrapper
 */
function rtp_hook_before_content_wrapper() {
    do_action( 'rtp_hook_before_content_wrapper' );
}


/**
 * Fire the rtp_hook_after_content_wrapper action
 *
 * @uses do_action() Calls 'rtp_hook_after_content_wrapper' hook.
 * @uses Used for adding content after #content-wrapper
 */
function rtp_hook_after_content_wrapper() {
    do_action( 'rtp_hook_after_content_wrapper' );
}


/**
 * Fire the rtp_hook_before_content action
 *
 * @uses do_action() Calls 'rtp_hook_before_content' hook.
 * @uses Used for adding content before #content
 */
function rtp_hook_before_content() {
    do_action( 'rtp_hook_before_content' );
}


/**
 * Fire the rtp_hook_after_content action
 *
 * @uses do_action() Calls 'rtp_hook_after_content' hook.
 * @uses Used for adding content after #content
 */
function rtp_hook_after_content() {
    do_action( 'rtp_hook_after_content' );
}


/**
 * Fire the rtp_hook_before_post_start action
 *
 * @uses do_action() Calls 'rtp_hook_before_post_start' hook.
 * @uses Used for adding content before .post start
 */
function rtp_hook_before_post_start() {
    do_action( 'rtp_hook_before_post_start' );
}


/**
 * Fire the rtp_hook_after_post_end action
 *
 * @uses do_action() Calls 'rtp_hook_after_post_end' hook.
 * @uses Used for adding content after .post end
 */
function rtp_hook_after_post_end() {
    do_action( 'rtp_hook_after_post_end' );
}


/**
 * Fire the rtp_hook_before_sidebar action
 *
 * @uses do_action() Calls 'rtp_hook_before_sidebar' hook.
 * @uses Used for adding content before #sidebar
 */
function rtp_hook_before_sidebar() {
    do_action( 'rtp_hook_before_sidebar' );
}


/**
 * Fire the rtp_hook_after_sidebar action
 *
 * @uses do_action() Calls 'rtp_hook_after_sidebar' hook.
 * @uses Used for adding content after #sidebar
 */
function rtp_hook_after_sidebar() {
    do_action( 'rtp_hook_after_sidebar' );
}


/**
 * Fire the rtp_hook_before_footer action
 *
 * @uses do_action() Calls 'rtp_hook_before_footer' hook.
 * @uses Used for adding content before #footer
 */
function rtp_hook_before_footer() {
    do_action( 'rtp_hook_before_footer' );
}


/**
 * Fire the rtp_hook_after_footer action
 *
 * @uses do_action() Calls 'rtp_hook_after_footer' hook.
 * @uses Used for adding content after #footer
 */
function rtp_hook_after_footer() {
    do_action( 'rtp_hook_after_footer' );
}