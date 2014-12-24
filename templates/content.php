<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package rtPanel
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix rtp-entry' ); ?>>

	<?php rtp_hook_begin_post(); ?>

	<header class="entry-header">
		<?php rtp_hook_begin_post_title(); ?>

		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
		?>

		<?php rtp_hook_end_post_title(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content post-content">
		<?php rtp_hook_begin_post_content(); ?>

		<?php
		if ( is_singular() || rtp_is_bbPress() || rtp_is_rtmedia() ) {

			the_content(
					sprintf(
							__( 'Continue reading %s', 'rtPanel' ), the_title( '<span class="screen-reader-text">', '</span>', false )
					)
			);

			wp_link_pages( array(
				'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'rtPanel' ) . '</span>',
				'after' => '</div>',
				'link_before' => '<span>',
				'link_after' => '</span>',
				'pagelink' => '<span class="screen-reader-text">' . __( 'Page', 'rtPanel' ) . ' </span>%',
				'separator' => '<span class="screen-reader-text">, </span>',
			) );
		} else {
			the_excerpt();
		}
		?>

		<?php rtp_hook_end_post_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit', 'rtPanel' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

	<?php rtp_hook_end_post(); ?>
</article><!-- #post-## -->

<?php
// Comment Form
rtp_hook_comments();
