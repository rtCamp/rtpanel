<?php
/**
 * The loop that displays the post according to the query
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

    global $rtp_post_comments;

    /* Archive Page Titles */
    if ( is_search() ) { ?>
        <h1 class="post-title rtp-main-title"><?php printf( __( 'Search Results for: %s', 'rtPanel' ), '<span>' . get_search_query() . '</span>' ); ?></h1><?php
    } elseif ( is_tag() ) { ?>
        <h1 class="post-title rtp-main-title"><?php printf( __( 'Tags: %s', 'rtPanel' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1><?php
    } elseif ( is_category() ) { ?>
        <h1 class="post-title rtp-main-title"><?php printf( __( 'Category: %s', 'rtPanel' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1><?php
    } elseif ( is_day() ) { ?>
        <h1 class="post-title rtp-main-title"><?php printf( __( 'Archive for %s', 'rtPanel' ), '<span>' . get_the_time( 'F jS, Y' ) . '</span>' ); ?></h1><?php
    } elseif ( is_month() ) { ?>
        <h1 class="post-title rtp-main-title"><?php printf( __( 'Archive for  %s', 'rtPanel' ), '<span>' . get_the_time( 'F, Y' ) . '</span>' ); ?></h1><?php
    } elseif ( is_year() ) { ?>
        <h1 class="post-title rtp-main-title"><?php printf( __( 'Archive for  %s', 'rtPanel' ), '<span>' . get_the_time( 'Y' ) . '</span>' ); ?></h1><?php
    } elseif ( get_query_var( 'author_name' ) ) {
        $cur_auth = get_user_by( 'slug', get_query_var( 'author_name' ) ); ?>
        <h1 class="post-title rtp-main-title"><?php printf( __( 'Author: %s', 'rtPanel' ), '<span>' . trim( ucfirst( $cur_auth->display_name ) ) . '</span>' ); ?></h1><?php
    }

    /* the loop */
    if ( have_posts () ) {
        while( have_posts() ) {
            the_post(); ?>

            <article <?php post_class( 'rtp-post-box' ); ?>>
                <?php rtp_hook_begin_post(); ?>

                <header class="post-header">
                    <?php rtp_hook_begin_post_title(); ?>

                    <?php   if ( is_singular() ) { ?>
                                <h1 class="post-title"><?php the_title(); ?></h1><?php
                            } else { ?>
                                <h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permanent Link to %s', 'rtPanel' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2><?php
                            } ?>

                    <?php rtp_hook_end_post_title(); ?>

                    <div class="clear"></div>

                    <?php rtp_hook_post_meta( 'top' ); ?>

                </header><!-- .post-title -->

                <div class="post-content">
                    <?php rtp_hook_begin_post_content(); ?>

                    <?php rtp_show_post_thumbnail(); ?>

                    <?php   if ( is_singular() || !$rtp_post_comments['summary_show'] ) {
                                the_content( __( 'Read More &rarr;', 'rtPanel' ) );
                                wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rtPanel' ), 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                            } else {
                                @the_excerpt();
                            } ?>

                    <?php rtp_hook_end_post_content(); ?>

                    <div class="clear"></div>
                </div><!-- .post-content -->
                
                <?php rtp_hook_post_meta( 'bottom' ); ?>
                
                <?php rtp_hook_end_post(); ?>
            </article><!-- .rtp-post-box --><?php

            /* Post Pagination */
            if ( is_single() ) { ?>
                <div class="rtp-navigation clearfix">
                    <div class="alignleft"><?php previous_post_link( '%link', __( '&larr; %title', 'rtPanel' ) ); ?></div>
                    <div class="alignright"><?php next_post_link( '%link', __( '%title &rarr;', 'rtPanel' ) ); ?></div>
                </div><!-- .rtp-navigation --><?php
            }

            // Comment Form
            is_singular() ? comments_template( '', true ) : '';
        }
        
        if ( !is_singular() ) {
            /* Page-Navi Plugin Support with WordPress Default Pagination */
            if ( function_exists( 'wp_pagenavi' ) ) {
                wp_pagenavi();
            } elseif ( get_next_posts_link() || get_previous_posts_link() ) { ?>
                <div class="rtp-navigation clearfix">
                    <div class="alignleft"><?php next_posts_link( __( '&larr; Older Entries', 'rtPanel' ) ); ?></div>
                    <div class="alignright"><?php previous_posts_link( __( 'Newer Entries &rarr;', 'rtPanel' ) ); ?></div>
                </div><!-- .rtp-navigation --><?php
            }
        }
    } else {
        /* If there are no posts to display */ ?>
        <article id="post-0" <?php post_class('rtp-not-found'); ?>>
            <?php rtp_hook_begin_post(); ?>

            <div class="post-content">
                <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
                <?php get_search_form(); ?>
            </div>

            <?php rtp_hook_end_post();  ?>
        </article><!-- #post-0 --><?php
    } ?>