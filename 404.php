<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
get_header();

$rtp_content_grid_class = apply_filters( 'rtp_set_content_grid_class', 'large-8 columns' );
?>

<main id="main" class="rtp-main-content <?php echo esc_attr( $rtp_content_grid_class ); ?>" role="main">

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'rtPanel' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'rtPanel' ); ?></p>

			<?php get_search_form(); ?>
		</div><!-- .page-content -->
	</section><!-- .error-404 -->

</main><!-- .site-main -->

<?php ( rtp_get_sidebar_id() === 0 ) ? '' : rtp_hook_sidebar(); ?>

<?php
get_footer();
