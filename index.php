<?php
/**
 * The generic template file
 * 
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */
get_header();

$rtp_content_class		= '';
$rtp_content_grid_class	= '';

// Full width grid for buddypress or bbpress
if ( rtp_get_sidebar_id() === 0 ) {
	$rtp_content_grid_class = apply_filters( 'rtp_set_full_width_grid_class', 'large-12 columns rtp-full-width-grid' );
} else {
	$rtp_content_grid_class = apply_filters( 'rtp_set_content_grid_class', 'large-8 columns' );
}

if ( is_archive() ) {
	$rtp_content_class = ' rtp-content-section ' . $rtp_content_grid_class . ' rtp-multiple-post ';
} elseif ( is_page() || is_single() || is_404() ) {
	$rtp_content_class = ' rtp-content-section ' . $rtp_content_grid_class . ' rtp-singular ';
} elseif ( is_home() ) {
	$rtp_content_class = ' rtp-content-section ' . $rtp_content_grid_class . ' rtp-blog-post ';
} else {
	$rtp_content_class = ' rtp-content-section ' . $rtp_content_grid_class;
}
?>

<section id="content" role="main" class="<?php echo esc_attr( $rtp_content_class ); ?>">
	<?php rtp_hook_begin_content(); ?>

	<?php get_template_part( 'loop', 'common' ); ?>

	<?php rtp_hook_end_content(); ?>
</section><!-- #content -->

<?php (rtp_get_sidebar_id() === 0) ? '' : rtp_hook_sidebar(); ?>

<?php
get_footer();
