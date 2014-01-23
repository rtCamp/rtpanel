<?php
/**
 * rtPanel Hooks
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

/**
 * Adds styles or scripts after wp_head()
 *
 * @since rtPanel 3.2
 */
function rtp_head() {
    do_action( 'rtp_head' );
}

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
 * Adds content at the beginning of #main-wrapper
 *
 * @since rtPanel 2.1
 */
function rtp_hook_begin_main_wrapper() {
    do_action( 'rtp_hook_begin_main_wrapper' );
}

/**
 * Adds content at the end of #main-wrapper
 *
 * @since rtPanel 2.1
 */
function rtp_hook_end_main_wrapper() {
    do_action( 'rtp_hook_end_main_wrapper' );
}

/**
 * Adds content begin #header
 *
 * @since rtPanel 2.0
 */
function rtp_hook_begin_header() {
    do_action( 'rtp_hook_begin_header' );
}

/**
 * Adds content end #header
 *
 * @since rtPanel 4.0
 */
function rtp_hook_end_header() {
    do_action( 'rtp_hook_end_header' );
}

/**
 * Adds content before #header
 *
 * @since rtPanel 4.0
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
 * Adds content at the beginning of primary_menu
 *
 * @since rtPanel 4.0
 */
function rtp_hook_begin_primary_menu() {
    do_action( 'rtp_hook_begin_primary_menu' );
}

/**
 * Adds content at the end of primary_menu
 *
 * @since rtPanel 4.0
 */
function rtp_hook_end_primary_menu() {
    do_action( 'rtp_hook_end_primary_menu' );
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
 * Adds content at the begin of content row
 *
 * @since rtPanel 4.1.4
 */
function rtp_hook_begin_content_row() {
    do_action( 'rtp_hook_begin_content_row' );
}

/**
 * Adds content at the end of content row
 *
 * @since rtPanel 4.1.4
 */
function rtp_hook_end_content_row() {
    do_action( 'rtp_hook_end_content_row' );
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
 * Adds default content in sidebar
 *
 * @since rtPanel 4.1.3
 */
function rtp_hook_sidebar_content() {
    do_action( 'rtp_hook_sidebar_content' );
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
 * Adds content before #footer-wrapper
 *
 * @since rtPanel 2.0
 */
function rtp_hook_before_footer() {
    do_action( 'rtp_hook_before_footer' );
}

/**
 * Adds content after #footer-wrapper
 *
 * @since rtPanel 2.0
 */
function rtp_hook_after_footer() {
    do_action( 'rtp_hook_after_footer' );
}

/**
 * Adds content begin #footer-wrapper
 *
 * @since rtPanel 4.1.2
 */
function rtp_hook_begin_footer() {
    do_action( 'rtp_hook_begin_footer' );
}

/**
 * Adds content ends #footer-wrapper
 *
 * @since rtPanel 4.1.2
 */
function rtp_hook_end_footer() {
    do_action( 'rtp_hook_end_footer' );
}

/**
 * Hook used basically for pagination on single posts
 *
 * @since rtPanel 2.1
 */
function rtp_hook_single_pagination() {
    do_action( 'rtp_hook_single_pagination' );
}

/**
 * Hook used basically for pagination on archive listings
 *
 * @since rtPanel 2.1
 */
function rtp_hook_archive_pagination() {
    do_action( 'rtp_hook_archive_pagination' );
}

function rtp_hook_before_content_wrapper(){
    do_action("rtp_hook_before_content_wrapper");
}

function rtp_hook_after_content_wrapper(){
    do_action("rtp_hook_after_content_wrapper");
}

function rtp_hook_after_comment_author_avatar(){
    do_action("rtp_hook_after_comment_author_avatar");
}