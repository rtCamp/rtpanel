<?php
/**
 * Template Name: Full-Width Template
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
get_header(); ?>

    <div id="content" class="rtp-grid-12">
        <?php rtp_hook_begin_content(); ?>

        <?php get_template_part( 'loop', 'common' ); ?>

        <?php rtp_hook_end_content(); ?>
    </div><!-- #content -->

<?php get_footer(); ?>