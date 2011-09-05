<?php
/* 
 * rtPanel default functions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * Default post meta
 *
 * @uses $rtp_post_comments Post Comments DB array
 * @param string $placement Specify the position of the post meta (top/bottom)
 *
 * @since rtPanel 2.0
 */
function rtp_default_post_meta( $placement ) { ?>
    <?php if ( !is_page() ) {
            global $post, $rtp_post_comments; ?>

            <div class="post-meta post-meta-<?php echo $placement; ?>">

            <?php   if( $placement == 'bottom' )
                        rtp_hook_begin_post_meta_bottom();
                    else
                        rtp_hook_begin_post_meta_top();

                    $position = ( $placement == 'bottom' ) ? 'l' : 'u'; // l = Lower/Bottom , u = Upper/Top ?>

                <?php   // Author Link
                        if ( $rtp_post_comments['post_author_'.$position] || $rtp_post_comments['post_date_'.$position] ) { ?>
                            <p class="alignleft post-publish"><?php
                                if ( $rtp_post_comments['post_author_'.$position] ) {
                                    printf( __( 'by <span class="author vcard">%s</span>', 'rtPanel' ), ( !$rtp_post_comments['author_link_'.$position] ? get_the_author() . ( $rtp_post_comments['author_count_'.$position] ? '(' . get_the_author_posts() . ')' : '' ) : sprintf( __( '<a href="%1$s" title="%2$s">%3$s</a>', 'rtPanel' ), get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ), esc_attr( sprintf( __( 'Posts by %s', 'rtPanel' ), get_the_author() ) ), get_the_author() ) . ( $rtp_post_comments['author_count_'.$position] ? '(' . get_the_author_posts() . ')' : '' ) ) );
                                }
                                echo ( $rtp_post_comments['post_author_'.$position] && $rtp_post_comments['post_date_'.$position] ) ? ' ' : '';
                                if ( $rtp_post_comments['post_date_'.$position] ) {
                                    printf( __( 'on <abbr class="published" title="%s">%s</abbr>', 'rtPanel' ), get_the_time( 'Y-m-d' ), get_the_time( $rtp_post_comments['post_date_format_'.$position] ) );
                                } ?>
                            </p><?php
                        } ?>
                
                <?php   // Comment Count
                        if ( @comments_open() && $position == 'u' ) { // If post meta is set to top then only display the comment count. ?>
                            <p class="alignright rtp-post-comment-count"><span class="rtp-courly-bracket">{</span><?php comments_popup_link( __( '<span>0</span> Comments', 'rtPanel' ), __( '<span>1</span> Comment', 'rtPanel' ), __( '<span>%</span> Comments', 'rtPanel' ), 'rtp-post-comment' ); ?><span class="rtp-courly-bracket">}</span></p><?php
                        } ?>

                <?php   // Post Categories
                        echo ( get_the_category_list() && $rtp_post_comments['post_category_'.$position] ) ? '<p class="post-category alignleft">' . __( 'Category', 'rtPanel' ) . ': <span>' . get_the_category_list( ', ' ) . '</span></p>' : ''; ?>

                <?php   // Post Tags
                        echo ( $rtp_post_comments['post_tags_'.$position] ) ? '<p class="post-tags alignleft">' . get_the_tag_list( __( 'Tagged in', 'rtPanel' ) . ': <span>', ', ', '</span>' ) . '</p>' : ''; ?>

                <?php   // Post Custom Taxonomies
                        $args = array( '_builtin' => false );
                        $taxonomies = get_taxonomies( $args, 'names' );
                        foreach ( $taxonomies as $taxonomy ) {
                            ( isset( $rtp_post_comments['post_'.$taxonomy.'_'.$position] ) && $rtp_post_comments['post_'.$taxonomy.'_'.$position] ) ? the_terms( $post->ID, $taxonomy, '<p class="post-custom-tax post-' . $taxonomy . ' alignleft">' . ucfirst( $taxonomy ) . ': ', ', ', '</p>' ) : '';
                        }

                if( $placement == 'bottom' )
                    rtp_hook_end_post_meta_bottom();
                else
                    rtp_hook_end_post_meta_top(); ?>
            </div><!-- .post-meta --><?php
        }
 }
add_action('rtp_hook_post_meta_top','rtp_default_post_meta'); // Post Meta Top
add_action('rtp_hook_post_meta_bottom','rtp_default_post_meta'); // Post Meta Bottom

/**
 * Default Navigation Menu
 *
 * @since rtPanel 2.0
 */
function rtp_default_nav_menu() {
     echo '<div id="rtp-primary-menu">';
        /* Call wp_nav_menu() for Wordpress Navigaton with fallback wp_list_pages() if menu not set in admin panel */
        if ( function_exists( 'wp_nav_menu' ) && has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array( 'container' => '', 'menu_id' => 'rtp-nav-menu', 'theme_location' => 'primary', 'depth' => apply_filters( 'rtp_nav_menu_depth', 4 ) ) );
        } else {
            echo '<ul class="menu" id="rtp-nav-menu">';
                wp_list_pages( array( 'title_li' => '', 'sort_column' => 'menu_order', 'number' => '5', 'depth' => apply_filters( 'rtp_nav_menu_depth', 4 ) ) );
            echo '</ul>';
        }
    echo '</div>';
}
add_action('rtp_hook_after_header','rtp_default_nav_menu'); // Adds default nav menu after #header

/**
 * 'Edit this post' link for post/page
 *
 * @since rtPanel 2.0
 */
function rtp_edit_link() {
    // Call Edit Link
    edit_post_link( __( 'Edit this post', 'rtPanel' ), '<p class="rtp-edit-link">[', ']</p>');
}
add_action('rtp_hook_end_post_meta_top', 'rtp_edit_link');

/**
 * Prepends and Appends Braces to Read More text
 *
 * @param int $text read more text
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_readmore_braces($text) {
   return '<span class="rtp-courly-bracket">[ </span>'. $text .'<span class="rtp-courly-bracket"> ]</span>';
}
add_filter( 'rtp_readmore', 'rtp_readmore_braces' );
