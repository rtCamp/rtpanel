<?php
/**
 * Changes the excerpt default length
 *
 * @return int
 *
 */
if ( ! function_exists( 'rtp_excerpt_length' ) ) {

	function rtp_excerpt_length( $length ) {

		$excerpt = rtp_get_option( 'blog_excerpt' );

		if ( $excerpt ) {
			$length = rtp_get_option( 'blog_excerpt_length' );
		}

		return $length;
	}

	/* Add Filter */
	add_filter( 'excerpt_length', 'rtp_excerpt_length' );
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
if ( ! function_exists( 'rtp_excerpt_more' ) ) {

	function rtp_excerpt_more( $more ) {

		$blog_entry_readmore = rtp_get_option( 'blog_entry_readmore' );
		$text = rtp_get_option( 'blog_entry_readmore_text' );

		if ( $blog_entry_readmore ) {
			$more = apply_filters( 'rtp_readmore', ('&hellip; <br /><a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . sprintf( __( '%s', 'rtPanel' ), $text ) . '</a>' ) );
		}

		return $more;
	}

	/* Add Filter */
	add_filter( 'excerpt_more', 'rtp_excerpt_more' );
}

/**
 * Displays Feature Image Thumbnail
 */
if ( ! function_exists( 'rtp_post_thumbnail' ) ) {

	function rtp_post_thumbnail() {
		$post_thumbnails = rtp_get_option( 'post_thumbnails' );
		$alignment = rtp_get_option( 'thumbnail_alignment' );

		if ( $post_thumbnails && ! is_singular() && has_post_thumbnail() ) {
			?>
			<a role="link" class="rtp-post-thumb <?php echo esc_attr( $alignment ); ?>" href="<?php echo get_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'thumbnail', array( 'title' => the_title_attribute( array( 'echo' => false ) ), 'class' => 'post-thumb ' . $alignment ) ); ?>
			</a>
			<?php
		}
	}

	/* Add Action */
	add_action( 'rtp_hook_begin_post_content', 'rtp_post_thumbnail' );
}


/**
 * Displays Feature Image Thumbnail
 */
if ( ! function_exists( 'rtp_singular_featured_image' ) ) {

	function rtp_singular_featured_image() {

		$feature_image = rtp_get_option( 'blog_single_thumbnail' );
		$alignment = rtp_get_option( 'single_thumbnail_alignment' );

		if ( $feature_image && is_singular() ) {
			?>
			<figure class="rtp-post-thumb <?php echo esc_attr( $alignment ); ?>">
				<?php the_post_thumbnail( 'full', array( 'title' => the_title_attribute( array( 'echo' => false ) ), 'class' => 'post-thumb ' . $alignment ) ); ?>
			</figure>
			<?php
		}
	}

	/* Add Action */
	add_action( 'rtp_hook_begin_post_content', 'rtp_singular_featured_image' );
}


/**
 * Displays Post Meata
 */
if ( ! function_exists( 'rtp_post_meta' ) ) {

	function rtp_post_meta() {

		$post_meta = rtp_get_option( 'post_meta' );

		if ( $post_meta && ( 'post' == get_post_type() ) && ! rtp_is_bbPress() ) {
			?>
			<div class="clearfix post-meta">
				<?php
				the_author_link();
				?>
			</div>
			<?php
		}
	}

	/* Add Action */
	add_action( 'rtp_hook_end_post_title', 'rtp_post_meta' );
}
