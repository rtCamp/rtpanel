<?php
/**
 * The template for displaying Google Custom Search or WordPress Default Search
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

get_header();

$rtp_content_grid_class = apply_filters( 'rtp_set_content_grid_class', 'large-8 columns' );
?>

<section id="content" role="main" class="rtp-content-section rtp-multiple-post <?php echo esc_attr( $rtp_content_grid_class ); ?>">
	<?php rtp_hook_begin_content(); ?>

	<?php get_template_part( 'loop', 'common' ); ?>

<?php rtp_hook_end_content(); ?>

</section><!-- #content --><?php

/* Sidebar */
if ( rtp_get_sidebar_id() !== 0 ) {
	rtp_hook_sidebar();
}

/* Footer */
get_footer();