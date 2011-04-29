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
/* ========== [ Breadcrumb Support ] ========== */
if ( function_exists( 'bcn_display' ) ) {
    echo '<div class="breadcrumb">';
        bcn_display();
    echo '</div>';
}

/* If there are no posts to display */
if ( ! have_posts() ) : ?>
    <div id="post-0" <?php post_class('rtp-post-box'); ?>> <!-- post_class begins -->
        <?php rtp_hook_begin_post(); /* rtpanel_hook for adding content after .rtp-post-box begins */?>
        <div class="post-title rtp-main-title">
            <h1><?php _e( 'Not Found', 'rtPanel' ); ?></h1>
        </div>
        <div class="post-content">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
        <?php rtp_hook_end_post();/* rtpanel_hook for adding content before .rtp-post-box ends */ ?>
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

    /* ========== [ Call Archive Pages Title ] ========== */
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

    while( have_posts() ) : the_post(); ?>
        
        <div <?php post_class('rtp-post-box'); ?>> <!-- post_class begins -->
            <?php rtp_hook_begin_post(); /* rtpanel_hook for adding content after .rtp-post-box begins */?>
            <div class="post-title"> <!-- post-title begins -->
                <?php
                        rtp_hook_begin_post_title(); /* rtpanel_hook for adding content before post's title appears. */
                        /* ========== [ Call Post Title ] ========== */
                        if ( is_singular() ) { ?>
                        <h1><?php the_title(); ?></h1>
                <?php } else { ?>
                        <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permanent Link to %s', 'rtPanel' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
                <?php }
                        /* ========== [ Call Edit Link ] ========== */
                        edit_post_link( __( 'Edit this post', 'rtPanel' ), '<p class="rtp-edit-link">[', ']</p>'); ?>
                <?php rtp_hook_end_post_title(); /* rtpanel_hook for adding content after post's title appears. */ ?>
                <div class="clear"></div>
            </div><!-- end post-title -->

            <?php rtp_hook_post_meta( 'top' ); /* displays rtp post meta top */ ?>
            
            <div class="post-content"> <!-- post-content begins -->
                <?php 
                        rtp_hook_begin_post_content(); /* rtpanel_hook for adding content before post-content begins */

                        rtp_show_post_thumbnail(); /* Displays post thumbnail */
                        
                        /* ========== [ Call Post Content ] ========== */
                        if ( is_singular() || !$rtp_post_comments['summary_show'] ) {
                            the_content( 'Read More &rarr;' );
                            wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rtPanel' ), 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                        } else {
                            the_excerpt();
                        }

                        rtp_hook_end_post_content(); /* rtpanel_hook for adding content after post-content ends */
                ?>
                <div class="clear"></div>
            </div> <!-- end post-content -->
            
            <?php rtp_hook_post_meta( 'bottom' ); /* displays rtp post meta bottom */ ?>
            
            <?php rtp_hook_end_post();/* rtpanel_hook for adding content before .rtp-post-box ends */ ?>
            
        </div><!-- end post_class -->        
        <?php
            /* ========== [ Call Post Pagination ] ========== */
            if ( is_single() ) { ?>
            <div class="rtp-navigation clearfix"> <!-- rtp-navigation begins -->
                <div class="alignleft"><?php previous_post_link( '%link', '&larr; %title' ); ?></div>
                <div class="alignright"><?php next_post_link( '%link', '%title &rarr;' ); ?></div>
            </div> <!-- end rtp-navigation -->
        <?php }
            /* ========== [ Call Comment Form ] ========== */
            is_singular() ? comments_template( '', true ) : '';
    endwhile;
    
    /* ========== [ Page-Navi Plugin Support with WP Default Pagination ] ========== */
    if ( !is_singular() ) {
        if ( function_exists( 'wp_pagenavi' ) ) { /* if wp_pagenavi */
            wp_pagenavi();
        } elseif ( get_next_posts_link() || get_previous_posts_link() ) { ?>
            <div class="rtp-navigation clearfix"> <!-- rtp-navigation begins -->
                <div class="alignleft"><?php next_posts_link( '&larr; Older Entries' ); ?></div>
                <div class="alignright"><?php previous_posts_link( 'Newer Entries &rarr;' ); ?></div>
            </div> <!-- end rtp-navigation -->
    <?php }
    }
endif; ?>