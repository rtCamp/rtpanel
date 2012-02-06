<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */
get_header(); ?>

    <div id="content" class="rtp-home-posts">
        <?php rtp_hook_begin_content();?>

        <div id="post-0" <?php post_class('rtp-post-box'); ?>>
            <div class="hentry rtp-not-found">
                <?php rtp_hook_begin_post(); ?>

                <div class="post-title rtp-main-title">
                    <h1><?php _e( 'Not Found', 'rtPanel' ); ?></h1>
                </div>

                <div class="post-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
                    <?php get_search_form(); ?>
                </div>

                <?php rtp_hook_end_post();?>
            </div>
        </div><!-- #post-0 -->
        
        <?php rtp_hook_end_content(); ?>

    </div><!-- #content -->
    
    <?php get_sidebar(); ?>

<?php get_footer(); ?>