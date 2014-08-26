<?php
/**
 * rtPanel default functions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * Default post meta top
 *
 * @uses $post Post Data
 *
 * @since rtPanel 4.5
 */
function rtp_default_post_meta_top() {

	$post_date = ( rtp_get_titan_option( 'post_date' ) ) ? rtp_get_titan_option( 'post_date' ) : array();
	$post_author = ( rtp_get_titan_option( 'post_author' ) ) ? rtp_get_titan_option( 'post_author' ) : array();
	$post_category = ( rtp_get_titan_option( 'post_category' ) ) ? rtp_get_titan_option( 'post_category' ) : array();
	$post_tags = ( rtp_get_titan_option( 'post_tags' ) ) ? rtp_get_titan_option( 'post_tags' ) : array();

	if ( 'post' == get_post_type() && !rtp_is_bbPress() ) { ?>

		<div class="clearfix post-meta post-meta-top"><?php

			rtp_hook_begin_post_meta_top();

			// Author Link
			if ( ( in_array( 'show', $post_author ) || in_array( 'show', $post_date ) ) && ( in_array( 'above', $post_author ) || in_array( 'above', $post_date ) ) ) {

				if ( in_array( 'show', $post_author ) && in_array( 'above', $post_author ) ) {
					printf( __( '<span class="rtp-post-author-prefix">By</span> <span class="vcard author"><a class="fn" href="%s" title="%s">%s</a></span>', 'rtPanel' ), get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ), esc_attr( sprintf( __( 'Posts by %s', 'rtPanel' ), get_the_author() ) ), get_the_author() );
				}

				echo ( in_array( 'show', $post_author ) && in_array( 'show', $post_date ) ) ? ' ' : '';

				if ( in_array( 'show', $post_date ) && in_array( 'above', $post_date ) ) {
					printf( __( '<span class="rtp-meta-separator">&middot;</span> <time class="published date updated" datetime="%s">%s</time>', 'rtPanel' ), get_the_date( 'c' ), get_the_time( apply_filters( 'rtp_post_date_format', 'F j, Y' ) ) );
					echo ' <span class="rtp-meta-separator">&middot;</span> ';
				}
			}

			// Post Categories
			echo ( get_the_category_list() && ( in_array( 'show', $post_category ) && in_array( 'above', $post_category ) ) ) ? ' ' . get_the_category_list( ', ' ) . '' : '';

			// Comment Count
			rtp_default_comment_count();

			// Post Tags
			echo ( get_the_tag_list() && ( in_array( 'show', $post_tags ) && in_array( 'above', $post_tags ) ) ) ? '<p class="post-tags">' . get_the_tag_list( __( 'Tagged', 'rtPanel' ) . ': <span>', ', ', '</span>' ) . '</p>' : '';

			rtp_hook_end_post_meta_top(); ?>

		</div><!-- .post-meta --><?php
	}
}

add_action( 'rtp_hook_post_meta_top', 'rtp_default_post_meta_top' ); // Post Meta Top


/**
 * Default post meta bottom
 *
 * @uses $post Post Data
 *
 * @since rtPanel 4.5
 */
function rtp_default_post_meta_bottom() {

	$post_date = ( rtp_get_titan_option( 'post_date' ) ) ? rtp_get_titan_option( 'post_date' ) : array();
	$post_author = ( rtp_get_titan_option( 'post_author' ) ) ? rtp_get_titan_option( 'post_author' ) : array();
	$post_category = ( rtp_get_titan_option( 'post_category' ) ) ? rtp_get_titan_option( 'post_category' ) : array();
	$post_tags = ( rtp_get_titan_option( 'post_tags' ) ) ? rtp_get_titan_option( 'post_tags' ) : array();

	if ( 'post' == get_post_type() && !rtp_is_bbPress() ) { ?>
		<footer class="post-footer">
			<div class="clearfix post-meta post-meta-bottom"><?php

				rtp_hook_begin_post_meta_bottom();

				// Author Link
				if ( in_array( 'show', $post_author ) || in_array( 'show', $post_date ) ) {

					if ( in_array( 'show', $post_author ) && in_array( 'below', $post_author ) ) {
						printf( __( '<span class="rtp-post-author-prefix">By</span> <span class="vcard author"><a class="fn" href="%s" title="%s">%s</a></span>', 'rtPanel' ), get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ), esc_attr( sprintf( __( 'Posts by %s', 'rtPanel' ), get_the_author() ) ), get_the_author() );
					}

					echo ( in_array( 'show', $post_author ) && in_array( 'show', $post_date ) ) ? ' ' : '';

					if ( in_array( 'show', $post_date ) && in_array( 'below', $post_date ) ) {
						printf( __( '<span class="rtp-meta-separator">&middot;</span> <time class="published date updated" datetime="%s">%s</time>', 'rtPanel' ), get_the_date( 'c' ), get_the_time( apply_filters( 'rtp_post_date_format', 'F j, Y' ) ) );
						echo ' <span class="rtp-meta-separator">&middot;</span> ';
					}
				}

				// Post Categories
				echo ( get_the_category_list() && ( in_array( 'show', $post_category ) && in_array( 'below', $post_category ) ) ) ? ' ' . get_the_category_list( ', ' ) . '' : '';

				// Post Tags
				echo ( get_the_tag_list() && ( in_array( 'show', $post_tags ) && in_array( 'below', $post_tags ) ) ) ? '<p class="post-tags">' . get_the_tag_list( __( 'Tagged', 'rtPanel' ) . ': <span>', ', ', '</span>' ) . '</p>' : '';

				rtp_hook_end_post_meta_bottom(); ?>

			</div><!-- .post-meta -->
		</footer><!-- .post-footer --><?php
	}
}

add_action( 'rtp_hook_post_meta_bottom', 'rtp_default_post_meta_bottom' ); // Post Meta Top

/**
 * Default Navigation Menu
 *
 * @since rtPanel 2.0
 */
function rtp_default_nav_menu() {
	echo '<nav id="rtp-primary-menu" role="navigation" class="rtp-nav-wrapper' . apply_filters( 'rtp_mobile_nav_support', ' rtp-mobile-nav' ) . '">';
	rtp_hook_begin_primary_menu();

	/* Call wp_nav_menu() for Wordpress Navigaton with fallback wp_list_pages() if menu not set in admin panel */
	if ( function_exists( 'wp_nav_menu' ) && has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array( 'container' => '', 'menu_class' => 'menu rtp-nav-container clearfix', 'menu_id' => 'rtp-nav-menu', 'theme_location' => 'primary', 'depth' => apply_filters( 'rtp_nav_menu_depth', 4 ) ) );
	} else {
		echo '<ul id="rtp-nav-menu" class="menu rtp-nav-container clearfix">';
		wp_list_pages( array( 'title_li' => '', 'sort_column' => 'menu_order', 'number' => '5', 'depth' => apply_filters( 'rtp_nav_menu_depth', 4 ) ) );
		echo '</ul>';
	}

	rtp_hook_end_primary_menu();
	echo '</nav>';
}

add_action( 'rtp_hook_begin_header', 'rtp_default_nav_menu' ); // Adds default nav menu after #header


/**
 * Filter the submenu items
 * 
 * @param String $items markup of the menu items
 * @param $args arguments if any
 */
function filter_wp_nav_menu_items( $items, $args ) {
	$items = str_replace( "\"sub-menu\"", "\"sub-menu dropdown\"", $items );
	$strItems = explode( "<li", $items );
	$items = '';
	foreach ( $strItems as $item ) {
		if ( trim( $item ) == '' ) {
			continue;
		}
		if ( strpos( $item, "sub-menu" ) !== false ) {
			$item = str_replace( "\"menu-item ", "\"menu-item  has-dropdown ", $item );
		}
		$items .= '<li ' . $item;
	}
	return $items;
}

/**
 * 'Edit' link for post/page
 *
 * @since rtPanel 2.0
 */
function rtp_edit_link() {
	// Call Edit Link
	edit_post_link( __( 'Edit', 'rtPanel' ), '<span class="rtp-edit-link">', '&nbsp;</span>' );
}

add_action( 'rtp_hook_begin_post_meta_top', 'rtp_edit_link' );

/**
 * Adds breadcrumb support to the theme.
 *
 * @since rtPanel 2.0.7
 * @param String $text
 */
function rtp_breadcrumb_support( $text ) {
	// Breadcrumb Support
	if ( function_exists( 'yoast_breadcrumb' ) ) {   // WordPress SEO by Yoast Plugin Support
		yoast_breadcrumb( '<nav role="navigation" id="breadcrumbs" class="breadcrumbs breadcrumbs-yoast">', '</nav>' );
	} else if ( function_exists( 'bcn_display' ) ) {   // Breadcrumb NavXT Plugin Support
		echo '<nav role="navigation" class="breadcrumbs breadcrumbs-navxt">';
		bcn_display();
		echo '</nav>';
	}
}

add_action( 'rtp_hook_begin_content', 'rtp_breadcrumb_support' );

/**
 * Adds pagination to single
 *
 * @since rtPanel 2.1
 */
function rtp_default_single_pagination() {
	if ( !rtp_is_yarpp() && is_single() && ( get_adjacent_post( '', '', true ) || get_adjacent_post( '', '', false ) ) ) {
		?>
		<div class="rtp-navigation clearfix">
			<?php if ( get_adjacent_post( '', '', true ) ) { ?><div class="left"><?php previous_post_link( '%link', __( '&larr; %title', 'rtPanel' ) ); ?></div><?php } ?>
			<?php if ( get_adjacent_post( '', '', false ) ) { ?><div class="right"><?php next_post_link( '%link', __( '%title &rarr;', 'rtPanel' ) ); ?></div><?php } ?>
		</div><!-- .rtp-navigation --><?php
	}
}

add_action( 'rtp_hook_single_pagination', 'rtp_default_single_pagination' );

/**
 * Adds pagination to archives
 *
 * @since rtPanel 2.1
 */
function rtp_default_archive_pagination() {
	/* Page-Navi Plugin Support with WordPress Default Pagination */
	if ( !rtp_is_bbPress() ) {
		if ( !is_singular() ) {
			global $wp_query;
			if ( rtp_get_titan_option( 'pagination_show' ) ) {
				if ( ( $wp_query->max_num_pages > 1 ) ) {
					?>
					<nav class="wp-pagenavi rtp-pagenavi"><?php
						echo paginate_links(
								array(
									'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
									'format' => '?paged=%#%',
									'current' => max( 1, get_query_var( 'paged' ) ),
									'total' => $wp_query->max_num_pages,
									'prev_text' => esc_attr( rtp_get_titan_option( 'prev_text' ) ),
									'next_text' => esc_attr( rtp_get_titan_option( 'next_text' ) ),
									'end_size' => rtp_get_titan_option( 'end_size' ),
									'mid_size' => rtp_get_titan_option( 'mid_size' ),
									'type' => 'list',
								)
						);
						?>
					</nav> <!-- End of .wp-pagenavi .rtp-pagenavi -->
					<?php
				}
			} elseif ( function_exists( 'wp_pagenavi' ) ) { // WP-PageNavi Plugin Support
				wp_pagenavi();
			} elseif ( get_next_posts_link() || get_previous_posts_link() ) {
				?>
				<nav class="rtp-navigation clearfix">
					<?php if ( get_next_posts_link() ) { ?><div class="left"><?php next_posts_link( __( '&larr; Older Entries', 'rtPanel' ) ); ?></div><?php } ?>
					<?php if ( get_previous_posts_link() ) { ?><div class="right"><?php previous_posts_link( __( 'Newer Entries &rarr;', 'rtPanel' ) ); ?></div><?php } ?>
				</nav><!-- End of .rtp-navigation --><?php
			}
		}
	}
}

add_action( 'rtp_hook_archive_pagination', 'rtp_default_archive_pagination' );

/**
 * Displays the sidebar.
 *
 * @since rtPanel 2.1
 */
function rtp_default_sidebar() {
	get_sidebar();
}

add_action( 'rtp_hook_sidebar', 'rtp_default_sidebar' );

/**
 * Displays the comments and comment form.
 *
 * @since rtPanel 2.1
 */
function rtp_default_comments() {
	if ( is_singular() ) {
		comments_template( '', true );
	}
}

add_action( 'rtp_hook_comments', 'rtp_default_comments' );

/**
 * Outputs the comment count linked to the comments of the particular post/page
 *
 * @since rtPanel 2.1
 */
function rtp_default_comment_count() {
	// Comment Count
	add_filter( 'get_comments_number', 'rtp_only_comment_count', 11, 2 );
	$rtp_attachment_comment = ( rtp_get_titan_option( 'extra_form_settings' ) ) ? rtp_get_titan_option( 'extra_form_settings' ) : array();
	if ( ( ( get_comments_number() || @comments_open() ) && !is_attachment() && !rtp_is_bbPress() ) || ( is_attachment() && in_array( 'attachment_comments', $rtp_attachment_comment ) ) ) { // If post meta is set to top then only display the comment count. 
		?>
		<span class="rtp-meta-separator">&middot;</span> <span class="rtp-post-comment-count"><?php comments_popup_link( _x( 'Leave a comment', 'comments number', 'rtPanel' ), _x( '<span>1</span> Comment', 'comments number', 'rtPanel' ), _x( '<span>%</span> Comments', 'comments number', 'rtPanel' ), 'rtp-post-comment rtp-common-link' ); ?></span><?php
	}
	remove_filter( 'get_comments_number', 'rtp_only_comment_count', 11, 2 );
}

/**
 * Get the sidebar ID for current page.
 *
 * @since rtPanel 3.1
 */
function rtp_get_sidebar_id() {
	$sidebar_id = 'sidebar-widgets';

	if ( function_exists( 'bp_current_component' ) && bp_current_component() ) {

		if ( 'buddypress-sidebar' === rtp_get_titan_option( 'buddypress_sidebar' ) ) {
			$sidebar_id = 'buddypress-sidebar-widgets';
		} else if ( 'no-sidebar' === rtp_get_titan_option( 'buddypress_sidebar' ) ) {
			$sidebar_id = 0;
		}
	} else if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {

		if ( 'bbpress-sidebar' === rtp_get_titan_option( 'bbpress_sidebar' ) ) {
			$sidebar_id = 'bbpress-sidebar-widgets';
		} else if ( 'no-sidebar' === rtp_get_titan_option( 'bbpress_sidebar' ) ) {
			$sidebar_id = 0;
		}
	}
	return $sidebar_id;
}

/**
 * Gallery Shortcode Hack with Foundation
 * 
 * @since rtPanel 3.2
 * @param String $output is the default gallery markup
 * @param Array $attr parameters for the gallery shortcode
 */
function rtp_gallery_shortcode( $output, $attr ) {
	$post = get_post();
	static $instance = 0;
	$instance ++;
	if ( isset( $attr[ 'orderby' ] ) ) {
		$attr[ 'orderby' ] = sanitize_sql_orderby( $attr[ 'orderby' ] );
		if ( !$attr[ 'orderby' ] )
			unset( $attr[ 'orderby' ] );
	}
	extract(
			shortcode_atts(
					array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'id' => $post->ID,
		'itemtag' => 'li',
		'icontag' => '',
		'captiontag' => '',
		'columns' => 3,
		'size' => 'thumbnail',
		'include' => '',
		'exclude' => '',
					), $attr
			)
	);

	$id = intval( $id );
	$orderby = ( 'RAND' == $order ) ? 'none' : '';

	if ( !empty( $include ) ) {
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}
	} elseif ( !empty( $exclude ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}

	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$icontag = tag_escape( $icontag );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( !isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'li';
	}
	if ( !isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = '';
	}
	if ( !isset( $valid_tags[ $icontag ] ) ) {
		$icontag = '';
	}

	$columns = intval( $columns );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';

	$size_class = sanitize_html_class( $size );
	$gallery_div = "<ul id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} large-block-grid-{$columns} small-block-grid-{$columns} gallery-size-{$size_class} clearing-thumbs' data-clearing>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	foreach ( $attachments as $id => $attachment ) {
		$url = wp_get_attachment_image_src( $id, 'full' );
		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "<a href='" . $url[ 0 ] . "'>" . wp_get_attachment_image( $id, 'thumbnail', false, array( 'data-caption' => trim( $attachment->post_excerpt ) ) ) . "</a>";
		$output .= "</{$itemtag}>";
	}

	$output .= "</ul>\n";
	return $output;
}

add_filter( 'post_gallery', 'rtp_gallery_shortcode', 1, 2 );

/**
 * Get string with image size
 * 
 * @param Integer $ID
 * @param Boolean $large
 * @param Boolean $medium
 * @param Boolean $small
 * @return string
 */
function rtp_img_attachement_interchange_string( $ID, $large = false, $medium = false, $small = false, $custom = array() ) {
	$str = '';
	$sep = '';
	$img = wp_get_attachment_image_src( $ID, 'small' );
	if ( $img ) {
		$str .= $sep . '[' . $img[ 0 ] . ',(default)]';
		$sep = ',';
	}
	if ( $small ) {
		$img = wp_get_attachment_image_src( $ID, $small );
		if ( $img ) {
			$str .= $sep . '[' . $img[ 0 ] . ',(small)]';
			$sep = ',';
		}
	}
	if ( $medium ) {
		$img = wp_get_attachment_image_src( $ID, $medium );
		if ( $img ) {
			$str .= $sep . '[' . $img[ 0 ] . ',(medium)]';
			$sep = ',';
		}
	}
	if ( $large ) {
		$img = wp_get_attachment_image_src( $ID, $large );
		if ( $img ) {
			$str .= $sep . '[' . $img[ 0 ] . ',(large)]';
			$sep = ',';
		}
	}
	foreach ( $custom as $sz ) {
		$str .= $sep . '[' . $sz[ 'path' ] . ',(' . $sz[ 'query' ] . ')]';
		$sep = ',';
	}
	return $str;
}

/**
 * Add WooCommerce support, tested upto WooCommerce version 2.0.20
 * 
 * @since rtPanel 4.0
 */
function rtp_add_woocommerce_support() {
	if ( class_exists( 'Woocommerce' ) ) {

		/**
		 * Unhook WooCommerce Wrappers
		 */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		/**
		 * Hook rtPanel wrappers
		 */
		add_action( 'woocommerce_before_main_content', 'rtp_woocommerce_wrapper_start', 10 );
		add_action( 'woocommerce_after_main_content', 'rtp_woocommerce_wrapper_end', 10 );

		/**
		 * Declare theme support for WooCommerce
		 */
		add_theme_support( 'woocommerce' );
	}
}

add_action( 'init', 'rtp_add_woocommerce_support' );

/**
 * rtPanel WooCommerce Wrapper Start
 * 
 * @since rtPanel 4.0
 */
function rtp_woocommerce_wrapper_start() {
	$rtp_content_grid_class = apply_filters( 'rtp_set_content_grid_class', 'large-8 columns ' );

	if ( is_shop() || is_archive() || is_category() ) {
		$rtp_content_class = ' class="rtp-content-section ' . $rtp_content_grid_class . ' rtp-woocommerce-archive" ';
	} else {
		$rtp_content_class = ' class="rtp-content-section ' . $rtp_content_grid_class . ' rtp-singular" ';
	}
	echo '<section id="content" role="main"' . $rtp_content_class . '>';
}

/**
 * rtPanel WooCommerce Wrapper End
 * 
 * @since rtPanel 4.0
 */
function rtp_woocommerce_wrapper_end() {
	echo '</section> <!-- End of #content -->';
}

/**
 * Footer Copyright Section
 *
 * @since rtPanel 4.0
 */
function rtp_footer_copyright_content() {
	?>
	<div id="footer" class="rtp-footer rtp-section-container">
		<?php
		$rtp_set_grid_class = apply_filters( 'rtp_set_full_width_grid_class', 'large-12 columns rtp-full-width-grid' );

		$footer_content = ( rtp_get_titan_option( 'footer_info' ) ) ? rtp_get_titan_option( 'footer_info' ) : '';
		$show_powered_by = ( rtp_get_titan_option( 'powered_by' ) ) ? rtp_get_titan_option( 'powered_by' ) : '';
		$affiliate_id = ( rtp_get_titan_option( 'affiliate_ID' ) ) ? '?ref=' . rtp_get_titan_option( 'affiliate_ID' ) : ''; ?>

		<div class="rtp-footer-section <?php echo esc_attr( $rtp_set_grid_class ); ?>">

			<?php
			if ( $footer_content ) {
				echo $footer_content;
			}
			?>

	<?php
	if ( $show_powered_by ) {
		printf( __( '<p class="rtp-powered-by">Powered by <a role="link" target="_blank" href="%s" class="rtp-common-link" title="rtPanel">rtPanel</a>.</p>', 'rtPanel' ), RTP_THEME_URL . $affiliate_id );
	}
	?>

		</div>
	</div><!-- #footer -->
	<?php
}

add_action( 'rtp_hook_end_footer', 'rtp_footer_copyright_content' );

/**
 * Default sidebar text if widgets are inactive
 * 
 * @since rtPanel 4.1.3
 */
function rtp_sidebar_content() { ?>
	<div class="widget sidebar-widget">
		<p>
	<?php _e( '<strong>rtPanel</strong> is equipped with everything you need to produce a professional website. <br />It is one of the most optimized WordPress Theme available today.', 'rtPanel' ); ?>
		</p>
		<p class="rtp-message-success">
	<?php printf( __( 'This theme comes with excellent technical <a title="Click here for rtPanel Support" target="_blank" href="%s">Support</a> by team of 30+ full-time developers.', 'rtPanel' ), RTP_FORUM_URL ); ?>
		</p>
	</div><?php
}

add_action( 'rtp_hook_sidebar_content', 'rtp_sidebar_content' );

/**
 * Fetch Google Analytics Code
 */
function rtp_google_analytics() {
	echo ( rtp_get_titan_option( 'google_analytics' ) ) ? rtp_get_titan_option( 'google_analytics' ) : '';
}

add_action( 'wp_head', 'rtp_google_analytics' );


/*
 * Theme Styles
 */
function rtp_get_theme_styles() {
	$styles = rtp_get_titan_option( 'body_font_option' );
	$family = $styles['font-family'];
	$size = $styles['font-size'];

	$heading = rtp_get_titan_option( 'heading_font_option' );
	$heading_font = $heading['font-family'];

	$coding = rtp_get_titan_option( 'coding_font_option' );
	$coding_font = $coding['font-family'];
	?>

	<style type="text/css">
		body {
			font-family : <?php echo $family; ?>;
			font-size : <?php echo $size; ?>;
		}
		h1, h2, h3, h4, h5, h6 {
			font-family : <?php echo $heading_font; ?>;
		}
		code, kbd, pre, samp {
			font-family : <?php echo $coding_font; ?>;
		}
	</style><?php
}

add_action( 'wp_head', 'rtp_get_theme_styles', 9999 );