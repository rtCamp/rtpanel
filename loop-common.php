<?php
/**
 * The loop that displays the post according to the query.
 *
 * This can be called using get_template_part() function
 * We ask for the loop with :
 * <code>get_template_part( 'loop', 'common' );</code>
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

global $rtp_post_comments;
// ========== [ Breadcrumb Support ] ========== //
if ( function_exists( 'bcn_display' ) ) {
    echo '<div class="breadcrumb">';
        bcn_display();
    echo '</div>';
}

/* If there are no posts to display */
if ( ! have_posts() ) : ?>
    <div id="post-0"> <!-- post_class begins -->
        <div class="post-title rtp-main-title">
            <h1><?php _e( 'Not Found', 'rtPanel' ); ?></h1>
        </div>
        <div class="post-content">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </div><!-- end post_class -->
<?php endif;


/* Start the Loop.
 *
 * we use the same loop in multiple contexts.
 *
 * we sometimes check for whether we are on an
 * archive page, a search page, etc., allowing for small differences
 * in the loop without actually duplicating
 * the rest of the loop that is shared.
 *
 * the loop:
 */

if ( have_posts () ) :

    // ========== [ Call Archive Pages Title ] ========== //
    if ( is_search() ) {
        ?><div class="post-title rtp-main-title"><h1><?php printf( __( 'Search Results for: %s', 'rtPanel' ), '<span>' . get_search_query() . '</span>' ); ?></h1></div><?php
    }
    if ( is_tag() ) {
        ?><div class="post-title rtp-main-title"><h1><?php printf( __( 'Tags: %s', 'rtPanel' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1></div><?php
    }
    if ( is_category() ) {
        ?><div class="post-title rtp-main-title"><h1><?php printf( __( 'Category: %s', 'rtPanel' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1></div><?php
    }
    if ( is_day() ) {
        ?><div class="post-title rtp-main-title"><h1><?php printf( __( 'Archive for %s', 'rtPanel' ), '<span>' . get_the_time( 'F jS, Y' ) . '</span>' ); ?></h1></div><?php
    }
    if ( is_month() ) {
        ?><div class="post-title rtp-main-title"><h1><?php printf( __( 'Archive for  %s', 'rtPanel' ), '<span>' . get_the_time( 'F, Y' ) . '</span>' ); ?></h1></div><?php
    }
    if ( is_year() ) {
        ?><div class="post-title rtp-main-title"><h1><?php printf( __( 'Archive for  %s', 'rtPanel' ), '<span>' . get_the_time( 'Y' ) . '</span>' ); ?></h1></div><?php
    }
    if ( get_query_var( 'author_name' ) ) {
        $cur_auth = '';
        $cur_auth = get_user_by( 'slug', get_query_var( 'author_name' ) );
        ?><div class="post-title rtp-main-title"><h1><?php printf( __( 'Author: %s', 'rtPanel' ), '<span>' . trim( ucfirst( $cur_auth->display_name ) ) . '</span>' ); ?></h1></div><?php
    }

    while( have_posts() ) : the_post();
    
            /* rtpanel_hook for adding content before .post start */
            rtp_hook_before_post_start();
        ?>
        <div <?php post_class(); ?>> <!-- post_class begins -->
            <div class="post-title"> <!-- post-title begins -->
                <!-- ========== [ Call Post Title ] ========== -->
                <?php if ( is_singular() ) { ?>
                    <h1><?php the_title(); ?></h1>
                <?php } else { ?>
                    <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permanent Link to %s', 'rtPanel' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
                <?php } ?>
                <div class="clear"></div>
            </div><!-- end post-title -->

            <div class="post-meta post-meta-top"> <!-- post-meta begins -->
                <?php if ( !is_page() ) { ?>
                
                <!-- ========== [ Call Author Link ] ========== -->
                    <p class="alignleft post-publish"><?php
                        if ( $rtp_post_comments['post_author_u'] ) {
                            printf( __( 'by <span class="author vcard">%s</span>', 'rtPanel' ), ( !$rtp_post_comments['author_link_u'] ? get_the_author() . ( $rtp_post_comments['author_count_u'] ? '(' . get_the_author_posts() . ')' : '' ) : sprintf( __( '<a href="%1$s" title="%2$s">%3$s</a>', 'rtPanel' ), get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ), esc_attr( sprintf( __( 'Posts by %s', 'rtPanel' ), get_the_author() ) ), get_the_author() ) . ( $rtp_post_comments['author_count_u'] ? '(' . get_the_author_posts() . ')' : '' ) ) );
                        }
                        echo ( $rtp_post_comments['post_author_u'] && $rtp_post_comments['post_date_u'] ) ? ' ' : '';
                        if ( $rtp_post_comments['post_date_u'] ) {
                            printf( __( 'on <abbr class="published" title="%s">%s</abbr>', 'rtPanel' ), get_the_time( 'Y-m-d' ), get_the_time( $rtp_post_comments['post_date_format_u'] ) );
                        } ?>
                    </p>

                    <!-- ========== [ Call Comments ] ========== -->
                    <?php if ( comments_open() ) { ?>
                        <p class="alignright rtp-post-comment-count"><?php comments_popup_link( __( '<span>0</span> Comments', 'rtPanel' ), __( '<span>1</span> Comment', 'rtPanel' ), __( '<span>%</span> Comments', 'rtPanel' ), 'rtp-post-comment' ); ?></p>
                    <?php } ?>
                    <div class="clear"></div>

                    <!-- ========== [ Call Category ] ========== -->
                    <?php echo ( get_the_category_list() && $rtp_post_comments['post_category_u'] ) ? '<p class="post-category">' . __( 'Category', 'rtPanel' ) . ': <span>' . get_the_category_list( ', ' ) . '</span></p><div class="clear"></div>' : ''; ?>

                    <!-- ========== [ Call Tags ] ========== -->
                    <?php echo ( $rtp_post_comments['post_tags_u'] ) ? '<p class="post-tags">' . get_the_tag_list( __( 'Tagged in', 'rtPanel' ) . ': <span>', ', ', '</span>' ) . '</p>' : ''; ?>

                    <!-- ========== [ Call Custom Taxonomies ] ========== -->
                    <?php
                    $args = array( '_builtin' => false );
                    $taxonomies = get_taxonomies( $args, 'names' );
                    foreach ( $taxonomies as $taxonomy ) {
                        ( $rtp_post_comments['post_'.$taxonomy.'_u'] ) ? the_terms( $post->ID, $taxonomy, ucfirst( $taxonomy ) . ': ', ', ', '<br />' ) : '';
                    }
                }
                // ========== [ Call Edit Link ] ========== //
                    edit_post_link( __( 'Edit this post', 'rtPanel' ), '<p class="rtp-edit-link">(', ')</p>');
                ?>
            </div><!-- end post-meta -->
            <div class="post-content"> <!-- post-content begins -->
                <?php
                // ========== [ Get Attachment Image Thumbnail ] ========== //
                if ( !is_singular() && $rtp_post_comments['summary_show'] && $rtp_post_comments['thumbnail_show'] ) {
                    $thumbnail_frame = ( $rtp_post_comments['thumbnail_frame'] ) ? ' thumbnail-shadow' : '';
                    $thumb = get_post_thumbnail_id();
                    $image = rtp_generate_thumbs( $thumb );
                        if ( $image ) { ?>
                            <span class="post-img<?php echo '-' . strtolower( $rtp_post_comments['thumbnail_position'] ); ?>">
                                <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><img class="post-thumb<?php echo $thumbnail_frame; ?>" alt="<?php echo get_the_title(); ?>" src="<?php echo $image; ?>" /></a>
                            </span>
        <?php           }
                    }
                    // ========== [ Call Post Content ] ========== //
                    if ( is_singular() || !$rtp_post_comments['summary_show'] ) {
                        the_content( 'Read More &rarr;' );
                        wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rtPanel' ), 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                    } else {
                        the_excerpt();
                    }
                ?>
                <div class="clear"></div>
            </div> <!-- end post-content -->
            <?php if ( !is_page() ) { ?>
                <div class="post-meta post-meta-bottom">

                    <!-- ========== [ Call Author Link ] ========== -->
                        <p class="alignleft post-publish"><?php
                            if ( $rtp_post_comments['post_author_l'] ) {
                                printf( __( 'by <span class="author vcard">%s</span>', 'rtPanel' ), ( !$rtp_post_comments['author_link_l'] ? get_the_author() . ( $rtp_post_comments['author_count_l'] ? '(' . get_the_author_posts() . ')' : '' ) : sprintf( __( '<a href="%1$s" title="%2$s">%3$s</a>', 'rtPanel' ), get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ), esc_attr( sprintf( __( 'Posts by %s', 'rtPanel' ), get_the_author() ) ), get_the_author() ) . ( $rtp_post_comments['author_count_l'] ? '(' . get_the_author_posts() . ')' : '' ) ) );
                            }
                            echo ( $rtp_post_comments['post_author_l'] && $rtp_post_comments['post_date_l'] ) ? ' ' : '';
                            if ( $rtp_post_comments['post_date_l'] ) {
                                printf( __( 'on <abbr class="published" title="%s">%s</abbr>', 'rtPanel' ), get_the_time( 'Y-m-d' ), get_the_time( $rtp_post_comments['post_date_format_l'] ) );
                            } ?>
                        </p>
                        <div class="clear"></div>

                        <!-- ========== [ Call Category ] ========== -->
                        <?php echo ( get_the_category_list() && $rtp_post_comments['post_category_l'] ) ? '<p class="post-category">' . __( 'Category', 'rtPanel' ) . ': <span>' . get_the_category_list( ', ' ) . '</span></p><div class="clear"></div>' : ''; ?>

                        <!-- ========== [ Call Tags ] ========== -->
                        <?php echo ( $rtp_post_comments['post_tags_l'] ) ? '<p class="post-tags">' . get_the_tag_list( __( 'Tagged in', 'rtPanel' ) . ': <span>', ', ', '</span>' ) . '</p>' : ''; ?>

                        <!-- ========== [ Call Custom Taxonomies ] ========== -->
                        <?php
                        $args = array( '_builtin' => false );
                        $taxonomies = get_taxonomies( $args , 'names' );
                            foreach( $taxonomies as $taxonomy ) {
                                ( $rtp_post_comments['post_'.$taxonomy.'_l'] ) ? the_terms( $post->ID, $taxonomy, ucfirst( $taxonomy ) . ': ', ', ', '<br />' ) : '';
                            } ?>

                </div><!-- .post-meta -->
            <?php } ?>
        </div><!-- end post_class -->
        <?php 
            /* rtpanel_hook for adding content after .post end */
            rtp_hook_after_post_end();
        ?>
        <?php
            // ========== [ Call Post Pagination ] ========== //
            if ( is_single() ) { ?>
            <div class="rtp-navigation clearfix"> <!-- rtp-navigation begins -->
                <div class="alignleft"><?php previous_post_link( '%link', '&larr; %title' ); ?></div>
                <div class="alignright"><?php next_post_link( '%link', '%title &rarr;' ); ?></div>
            </div> <!-- end rtp-navigation -->
        <?php }
            // ========== [ Call Comment Form ] ========== //
            is_singular() ? comments_template( '', true ) : '';
    endwhile;
    
    // ========== [ Page-Navi Plugin Support with WP Default Pagination ] ========== //
    if ( !is_singular() ) {
            if ( function_exists( 'wp_pagenavi' ) ) {
                wp_pagenavi();
            } elseif ( get_next_posts_link() || get_previous_posts_link() ) { ?>
                <div class="rtp-navigation clearfix"> <!-- rtp-navigation begins -->
                    <div class="alignleft"><?php next_posts_link( '&larr; Older Entries' ); ?></div>
                    <div class="alignright"><?php previous_posts_link( 'Newer Entries &rarr;' ); ?></div>
                </div> <!-- end rtp-navigation -->
        <?php } //if wp_pagenavi
    } //is singular
endif; ?>