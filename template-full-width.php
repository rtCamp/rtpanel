<?php
/**
 * Template Name: Full-Width Template
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
get_header();
$content_width = $max_content_width; ?>

    <section id="content" class="large-16 rtp-full-width">
        <?php rtp_hook_begin_content(); ?>

        <?php get_template_part( 'loop', 'common' ); ?>

        <?php rtp_hook_end_content(); ?>
    </section><!-- #content -->

<?php get_footer(); ?>