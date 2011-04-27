<?php
/**
 * The template Shows if no posts or no results found
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

// ========== [ Call Header ] ========== //
get_header();

// ========== [ Call Sidebar ] ========== //
get_sidebar();

// ========== [ rtpanel_hook for adding content before #content ] ========== //
rtp_hook_before_content();
?>
<div id="content" class="rtp-home-posts"> <!-- content begins -->
 <?php    
 
    global $rtp_post_comments;
    // ========== [ Breadcrumb Support ] ========== //
    if ( function_exists( 'bcn_display' ) ) {
        echo '<div class="breadcrumb">';
            bcn_display();
        echo '</div>';
    }

    /* rtpanel_hook for adding content before .post start */
    rtp_hook_before_post_start();
    ?>
    <div id="post-0"> <!-- post_class begins -->
        <div class="post-title rtp-main-title">
            <h1><?php _e( 'Not Found', 'rtPanel' ); ?></h1>
        </div>
        <div class="post-content">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </div><!-- end post_class -->
    <?php
    /* rtpanel_hook for adding content after .post end */
    rtp_hook_after_post_end();
?>
</div><!-- end content -->
<?php
// ========== [ rtpanel_hook for adding content after #content ] ========== //
rtp_hook_after_content();

// ========== [ Call Footer ] ========== //
get_footer(); ?>