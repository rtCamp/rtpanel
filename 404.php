<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */
?>

<?php get_header(); ?>

    <?php get_sidebar(); ?>

    <?php rtp_hook_begin_content(); ?>

    <div id="content" class="rtp-home-posts"><?php
            global $rtp_post_comments;
            
            // Breadcrumb Support
            if ( function_exists( 'bcn_display' ) ) {
                echo '<div class="breadcrumb">';
                    bcn_display();
                echo '</div>';
            } ?>

        <div id="post-0" <?php post_class('rtp-post-box'); ?>>
            <?php rtp_hook_begin_post(); ?>

            <div class="post-title rtp-main-title">
                <h1><?php _e( 'Not Found', 'rtPanel' ); ?></h1>
            </div>

            <div class="post-content">
                <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
                <?php get_search_form(); ?>
            </div>

            <?php rtp_hook_end_post();?>
        </div><!-- #post-0 -->
    </div><!-- #content -->

    <?php rtp_hook_end_content(); ?>

<?php get_footer(); ?>