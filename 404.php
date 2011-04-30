<?php
/**
 * The template Shows if no posts or no results found
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

/* ========== [ Call Header ] ========== */
get_header();

/* ========== [ Call Sidebar ] ========== */
get_sidebar();

/* ========== [ rtpanel_hook for adding content before #content ] ========== */
rtp_hook_begin_content();
?>
<div id="content" class="rtp-home-posts"> <!-- content begins -->
 <?php    
    global $rtp_post_comments;
    /* ========== [ Breadcrumb Support ] ========== */
    if ( function_exists( 'bcn_display' ) ) {
        echo '<div class="breadcrumb">';
            bcn_display();
        echo '</div>';
    }
    ?>
    <div id="post-0" <?php post_class('rtp-post-box'); ?>> <!-- post_class begins -->
        <?php rtp_hook_begin_post(); /* rtpanel_hook for adding content after .rtp-post-box begins */?>
        <div class="post-title rtp-main-title">
            <h1><?php _e( 'Not Found', 'rtPanel' ); ?></h1>
        </div>
        <div class="post-content">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
        <?php rtp_hook_end_post();/* rtpanel_hook for adding content before .rtp-post-box ends */ ?>
    </div><!-- end post_class -->
</div><!-- end content -->
<?php
/* ========== [ rtpanel_hook for adding content after #content ] ========== */
rtp_hook_end_content();

/* ========== [ Call Footer ] ========== */
get_footer(); ?>