<?php
/* 
 * The template containing default rtPanel functions
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

/**
 * Displays default post meta.
 *
 * @uses $rtp_post_comments Post Comments DB array
 * @param string $placement Specify the position of the post meta (top/bottom)
 *
 * @since rtPanel Theme 2.0
 */
function rtp_default_post_meta( $placement ) { ?>
    <?php if ( !is_page() ) {
            global $post, $rtp_post_comments; ?>

            <div class="post-meta post-meta-<?php echo $placement; ?>"><!-- post-meta begins -->

            <?php if( $placement == 'bottom' )
                    rtp_hook_begin_post_meta_bottom(); // rtpanel_hook for adding content after post meta bottom appears.
                else
                    rtp_hook_begin_post_meta_top(); // rtpanel_hook for adding content before post meta top appears.

                        $position = ( $placement == 'bottom' ) ? 'l' : 'u'; // l = Lower/Bottom , u = Upper/Top ?>

                <!-- ========== [ Call Author Link ] ========== -->
                <p class="alignleft post-publish"><?php
                    if ( $rtp_post_comments['post_author_'.$position] ) {
                        printf( __( 'by <span class="author vcard">%s</span>', 'rtPanel' ), ( !$rtp_post_comments['author_link_'.$position] ? get_the_author() . ( $rtp_post_comments['author_count_'.$position] ? '(' . get_the_author_posts() . ')' : '' ) : sprintf( __( '<a href="%1$s" title="%2$s">%3$s</a>', 'rtPanel' ), get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ), esc_attr( sprintf( __( 'Posts by %s', 'rtPanel' ), get_the_author() ) ), get_the_author() ) . ( $rtp_post_comments['author_count_'.$position] ? '(' . get_the_author_posts() . ')' : '' ) ) );
                    }
                    echo ( $rtp_post_comments['post_author_'.$position] && $rtp_post_comments['post_date_'.$position] ) ? ' ' : '';
                    if ( $rtp_post_comments['post_date_'.$position] ) {
                        printf( __( 'on <abbr class="published" title="%s">%s</abbr>', 'rtPanel' ), get_the_time( 'Y-m-d' ), get_the_time( $rtp_post_comments['post_date_format_'.$position] ) );
                    } ?>
                </p>

                <!-- ========== [ Call Comments ] ========== -->
                <?php if ( comments_open() && $position == 'u' ) { // If post meta is set to top then only display the comment count. ?>
                    <p class="alignright rtp-post-comment-count"><span class="rtp-courly-bracket">{</span><?php comments_popup_link( __( '<span>0</span> Comments', 'rtPanel' ), __( '<span>1</span> Comment', 'rtPanel' ), __( '<span>%</span> Comments', 'rtPanel' ), 'rtp-post-comment' ); ?><span class="rtp-courly-bracket">}</span></p>
                <?php } ?>
                <div class="clear"></div>

                <!-- ========== [ Call Category ] ========== -->
                <?php echo ( get_the_category_list() && $rtp_post_comments['post_category_'.$position] ) ? '<p class="post-category">' . __( 'Category', 'rtPanel' ) . ': <span>' . get_the_category_list( ', ' ) . '</span></p><div class="clear"></div>' : ''; ?>

                <!-- ========== [ Call Tags ] ========== -->
                <?php echo ( $rtp_post_comments['post_tags_'.$position] ) ? '<p class="post-tags">' . get_the_tag_list( __( 'Tagged in', 'rtPanel' ) . ': <span>', ', ', '</span>' ) . '</p>' : ''; ?>

                <!-- ========== [ Call Custom Taxonomies ] ========== -->
                <?php
                $args = array( '_builtin' => false );
                $taxonomies = get_taxonomies( $args, 'names' );
                foreach ( $taxonomies as $taxonomy ) {
                    ( $rtp_post_comments['post_'.$taxonomy.'_'.$position] ) ? the_terms( $post->ID, $taxonomy, ucfirst( $taxonomy ) . ': ', ', ', '<br />' ) : '';
                }

                if( $placement == 'bottom' )
                    rtp_hook_end_post_meta_bottom(); /* rtpanel_hook for adding custom content after post meta bottom appears. */
                else
                    rtp_hook_end_post_meta_top(); /* rtpanel_hook for adding custom content before post meta top appears. */ ?>
            </div><!-- end post-meta --><?php
        }
 }

add_action('rtp_hook_post_meta_top','rtp_default_post_meta'); /* Adds default post meta top */
add_action('rtp_hook_post_meta_bottom','rtp_default_post_meta'); /* Adds default post meta bottom */

/**
 * Displays default primary nav menu
 *
 * @since rtPanel Theme 2.0
 */
function rtp_default_nav_menu() {
     echo '<div id="rtp-primary-menu">';
        /* Call wp_nav_menu() for Wordpress Navigaiton with fallback wp_list_pages() if menu not set in admin panel */
        if ( function_exists( 'wp_nav_menu' ) && has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array( 'container' => '', 'menu_id' => 'rtp-nav-menu', 'theme_location' => 'primary', 'depth' => apply_filters( 'rtp_nav_menu_depth', 4 ) ) );
        } else {
            echo '<ul class="menu" id="rtp-nav-menu">';
                wp_list_pages( array( 'title_li' => '', 'sort_column' => 'menu_order', 'number' => '5', 'depth' => apply_filters( 'rtp_nav_menu_depth', 4 ) ) );
            echo '</ul>';
        }
    echo '</div>';
}
add_action('rtp_hook_after_header','rtp_default_nav_menu'); /* Adds default nav menu after #header */

/**
 * Displays an edit link for the post/page
 *
 * @since rtPanel Theme 2.0
 */
function rtp_edit_link() {
    /* ========== [ Call Edit Link ] ========== */
    edit_post_link( __( 'Edit this post', 'rtPanel' ), '<p class="rtp-edit-link">[', ']</p>');
}
add_action('rtp_hook_end_post_meta_top', 'rtp_edit_link');