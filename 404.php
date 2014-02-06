<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */
get_header();

	$rtp_content_grid_class = apply_filters( 'rtp_set_content_grid_class', 'large-8 columns' ); ?>

	<section id="content" role="main" class="rtp-content-section rtp-singular rtp-404-content <?php echo esc_attr( $rtp_content_grid_class ); ?>">

		<?php rtp_hook_begin_content(); ?>

            <h1 class="post-title rtp-main-title"><?php _e( 'Not Found', 'rtPanel' ); ?></h1>

            <?php rtp_hook_begin_post(); ?>

            <div class="post-content clearfix rtp-not-found">
                <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
                <?php get_search_form(); ?>
            </div>

            <?php rtp_hook_end_post();?>

        <?php rtp_hook_end_content(); ?>

    </section><!-- #content -->

    <?php ( rtp_get_sidebar_id() === 0 ) ? '' : rtp_hook_sidebar(); ?>

<?php get_footer();