<?php
/**
 * The generic template file
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
get_header();

$rtp_content_grid_class = '';

// Full width grid for buddypress or bbpress
if ( rtp_get_sidebar_id() === 0 ) {
	$rtp_content_grid_class = apply_filters( 'rtp_set_full_width_grid_class', 'large-12 columns rtp-full-width-grid' );
} else {
	$rtp_content_grid_class = apply_filters( 'rtp_set_content_grid_class', 'large-8 columns' );
}
?>

<main id="main" class="rtp-main-content <?php echo esc_attr( $rtp_content_grid_class ); ?>" role="main">
	<?php rtp_hook_begin_content(); ?>

	<?php
	if ( have_posts() ) :

		// Page Header
		get_template_part( 'templates/page', 'header' );

		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'templates/content', get_post_format() );

		// End the loop.
		endwhile;

	// If no content, include the "No posts found" template.
	else :
		get_template_part( 'templates/content', 'none' );

	endif;
	?>

<?php rtp_hook_end_content(); ?>

</main><!-- .site-main -->

<?php (rtp_get_sidebar_id() === 0) ? '' : rtp_hook_sidebar(); ?>

<?php
get_footer();
