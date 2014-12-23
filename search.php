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

<main id="main" class="rtp-main-content <?php echo esc_attr( $rtp_content_grid_class ); ?>" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'rtPanel' ), get_search_query() ); ?></h1>
		</header><!-- .page-header -->

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
			?>

			<?php
			/*
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-search.php and that will be used instead.
			 */
			get_template_part( 'templates/content' );

		// End the loop.
		endwhile;

	// Previous/next page navigation.
//		the_posts_pagination( array(
//			'prev_text' => __( 'Previous page', 'rtPanel' ),
//			'next_text' => __( 'Next page', 'rtPanel' ),
//			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'rtPanel' ) . ' </span>',
//		) );
	// If no content, include the "No posts found" template.
	else :
		get_template_part( 'templates/content', 'none' );

	endif;
	?>

</main><!-- .site-main -->


<?php
if ( ( ! $rtp_general[ 'search_code' ] || ! $rtp_general[ 'search_layout' ] ) && ( rtp_get_sidebar_id() !== 0 ) ) {
	rtp_hook_sidebar();
}
?>

<?php
get_footer();
