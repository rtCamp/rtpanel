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
		$post_author = rtp_get_option( 'post_author' );
		$post_date = rtp_get_option( 'post_date' );
		$post_categories = rtp_get_option( 'post_categories' );
		$post_tags = rtp_get_option( 'post_tags' );
		$post_comment = rtp_get_option( 'post_comment' );

		if ( $post_meta && ( 'post' == get_post_type() ) && ( $post_author || $post_date || $post_categories || $post_tags || $post_comment ) ) {
			?>

			<div class="clearfix post-meta">

				<?php
				rtp_hook_begin_post_meta();

				/* Post Author */
				if ( $post_author ) {
					printf( __( '<span class="rtp-post-author-prefix">Posted by</span> <span class="vcard author"><a class="fn" href="%s" title="%s">%s</a></span> ', 'rtPanel' ), get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ), esc_attr( sprintf( __( 'Posts by %s', 'rtPanel' ), get_the_author() ) ), get_the_author() );
				}

				/* Post Date */
				if ( $post_date ) {
					printf( __( '<time class="published date updated" datetime="%s">%s</time> ', 'rtPanel' ), get_the_date( 'c' ), get_the_time( apply_filters( 'rtp_post_date_format', 'F j, Y' ) ) );
				}

				/* Post Categories */
				if ( $post_categories && get_the_category_list() ) {
					echo '<span class="rtp-cat-list">';
					echo get_the_category_list( ', ' );
					echo '</span>';
				}

				/* Post Comments */
				if ( $post_comment && ( get_comments_number() || comments_open() ) ) {
					?>
					<span class="rtp-post-comment-count">
						<?php comments_popup_link( _x( 'Leave a comment', 'comments number', 'rtPanel' ), _x( '<span>1</span> Comment', 'comments number', 'rtPanel' ), _x( '<span>%</span> Comments', 'comments number', 'rtPanel' ), 'rtp-post-comment rtp-common-link' ); ?>
					</span><?php
				}

				/* Post Tags */
				echo ( $post_tags && get_the_tag_list() ) ? '<p class="post-tags">' . get_the_tag_list( __( 'Tagged', 'rtPanel' ) . ': <span>', ', ', '</span>' ) . '</p>' : '';

				rtp_hook_end_post_meta();
				?>

			</div>
			<?php
		}
	}

	/* Add Action */
	add_action( 'rtp_hook_end_post_title', 'rtp_post_meta' );
}

/**
 * Adds pagination to archives
 */
if ( ! function_exists( 'rtp_archive_pagination' ) ) {

	function rtp_archive_pagination() {
		$archives_pagination = rtp_get_option( 'archives_pagination' );

		/* Page-Navi Plugin Support with WordPress Default Pagination */
		if ( ! rtp_is_bbPress() && ! is_singular() ) {
			global $wp_query;

			if ( $archives_pagination ) {
				if ( $wp_query->max_num_pages > 1 ) {
					?>
					<nav class="wp-pagenavi rtp-pagenavi"><?php
						echo paginate_links(
								array(
									'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
									'format' => '?paged=%#%',
									'current' => max( 1, get_query_var( 'paged' ) ),
									'total' => $wp_query->max_num_pages,
									'prev_text' => esc_attr( rtp_get_option( 'prev_text' ) ),
									'next_text' => esc_attr( rtp_get_option( 'next_text' ) ),
									'end_size' => rtp_get_option( 'end_size' ),
									'mid_size' => rtp_get_option( 'mid_size' ),
									'type' => 'list',
								)
						);
						?>
					</nav>
					<?php
				}
			} elseif ( get_next_posts_link() || get_previous_posts_link() ) {
				?>
				<nav class="rtp-navigation clearfix">
					<?php if ( get_next_posts_link() ) { ?>
						<div class="left"><?php next_posts_link( __( '&larr; Older Entries', 'rtPanel' ) ); ?></div>
					<?php
					}
					if ( get_previous_posts_link() ) {
						?>
						<div class="right"><?php previous_posts_link( __( 'Newer Entries &rarr;', 'rtPanel' ) ); ?></div>
				<?php } ?>
				</nav><?php
			}
		}
	}

	add_action( 'rtp_hook_end_content', 'rtp_archive_pagination' );
}



/**
 * Adds pagination to single
 */
if ( ! function_exists( 'rtp_single_pagination' ) ) {

	function rtp_single_pagination() {
		$single_pagination = rtp_get_option( 'single_pagination' );

		if ( $single_pagination && is_single() && ( get_adjacent_post( '', '', true ) || get_adjacent_post( '', '', false ) ) ) {
			?>
			<div class="rtp-navigation clearfix">
				<?php if ( get_adjacent_post( '', '', true ) ) { ?>
					<div class="left"><?php previous_post_link( '%link', __( '&larr; %title', 'rtPanel' ) ); ?></div>
				<?php } ?>
				<?php if ( get_adjacent_post( '', '', false ) ) { ?>
					<div class="right"><?php next_post_link( '%link', __( '%title &rarr;', 'rtPanel' ) ); ?></div>
			<?php } ?>
			</div><!-- .rtp-navigation --><?php
		}
	}

	add_action( 'rtp_hook_end_post', 'rtp_single_pagination' );
}
