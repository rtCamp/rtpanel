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
 * Fire the rtp_hook_after_content_wrapper_begins action
 *
 * @uses do_action() Calls 'rtp_hook_after_content_wrapper_begins' hook.
 * @uses Used for adding content after #content-wrapper begins
 */
function rtp_hook_after_content_wrapper_begins() {
    do_action( 'rtp_hook_after_content_wrapper_begins' );
}


/**
 * Fire the rtp_hook_before_content_wrapper_ends action
 *
 * @uses do_action() Calls 'rtp_hook_before_content_wrapper_ends' hook.
 * @uses Used for adding content before #content-wrapper ends
 */
function rtp_hook_before_content_wrapper_ends() {
    do_action( 'rtp_hook_before_content_wrapper_ends' );
}


/**
 * Fire the rtp_hook_after_content_begins action
 *
 * @uses do_action() Calls 'rtp_hook_after_content_begins' hook.
 * @uses Used for adding content after #content begins
 */
function rtp_hook_after_content_begins() {
    do_action( 'rtp_hook_after_content_begins' );
}


/**
 * Fire the rtp_hook_before_content_ends action
 *
 * @uses do_action() Calls 'rtp_hook_before_content_ends' hook.
 * @uses Used for adding content before #content ends
 */
function rtp_hook_before_content_ends() {
    do_action( 'rtp_hook_before_content_ends' );
}


/**
 * Fire the rtp_hook_before_post action
 *
 * @uses do_action() Calls 'rtp_hook_before_post' hook.
 * @uses Used for adding content before .post starts
 */
function rtp_hook_before_post() {
    do_action( 'rtp_hook_before_post' );
}


/**
 * Fire the rtp_hook_after_post action
 *
 * @uses do_action() Calls 'rtp_hook_after_post' hook.
 * @uses Used for adding content after .post ends
 */
function rtp_hook_after_post() {
    do_action( 'rtp_hook_after_post' );
}


/**
 * Fire the rtp_hook_before_post_content_begins action
 *
 * @uses do_action() Calls 'rtp_hook_before_post_content_begins' hook.
 * @uses Used for adding content before post-content begins
 */
function rtp_hook_before_post_content_begins() {
    do_action( 'rtp_hook_before_post_content_begins' );
}


/**
 * Fire the rtp_hook_after_post_content_ends action
 *
 * @uses do_action() Calls 'rtp_hook_after_post_content_ends' hook.
 * @uses Used for adding content after post-content ends
 */
function rtp_hook_after_post_content_ends() {
    do_action( 'rtp_hook_after_post_content_ends' );
}


/**
 * Fire the rtp_hook_after_sidebar_begins action
 *
 * @uses do_action() Calls 'rtp_hook_after_sidebar_begins' hook.
 * @uses Used for adding content after #sidebar begins
 */
function rtp_hook_after_sidebar_begins() {
    do_action( 'rtp_hook_after_sidebar_begins' );
}


/**
 * Fire the rtp_hook_before_sidebar_ends action
 *
 * @uses do_action() Calls 'rtp_hook_before_sidebar_ends' hook.
 * @uses Used for adding content before #sidebar ends
 */
function rtp_hook_before_sidebar_ends() {
    do_action( 'rtp_hook_before_sidebar_ends' );
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