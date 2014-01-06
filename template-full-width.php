<?php
/**
 * Template Name: Full-Width Template
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
get_header();

    $content_width = $max_content_width;
    $rtp_content_grid_class = apply_filters( 'rtp_set_full_width_grid_class', 'large-12 columns rtp-full-width-grid' ); ?>

    <section id="content" class="rtp-content-section <?php echo $rtp_content_grid_class; ?>">
        <?php rtp_hook_begin_content(); ?>

        <?php get_template_part( 'loop', 'common' ); ?>

        <?php rtp_hook_end_content(); ?>
    </section><!-- #content -->

<?php get_footer();