<?php
/**
 * The loop that displays the post according to the query
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

    global $rtp_post_comments;

    // Breadcrumb Support
    if ( function_exists( 'bcn_display' ) ) {
        echo '<div class="breadcrumb">';
            bcn_display();
        echo '</div>';
    }

    /* Archive Page Titles */
    if ( is_search() ) { ?>
        <div class="post-title rtp-main-title"><h1><?php printf( __( 'Search Results for: %s', 'rtPanel' ), '<span>' . get_search_query() . '</span>' ); ?></h1></div><?php
    } elseif ( is_tag() ) { ?>
        <div class="post-title rtp-main-title"><h1><?php printf( __( 'Tags: %s', 'rtPanel' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1></div><?php
    } elseif ( is_category() ) { ?>
        <div class="post-title rtp-main-title"><h1><?php printf( __( 'Category: %s', 'rtPanel' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1></div><?php
    } elseif ( is_day() ) { ?>
        <div class="post-title rtp-main-title"><h1><?php printf( __( 'Archive for %s', 'rtPanel' ), '<span>' . get_the_time( 'F jS, Y' ) . '</span>' ); ?></h1></div><?php
    } elseif ( is_month() ) { ?>
        <div class="post-title rtp-main-title"><h1><?php printf( __( 'Archive for  %s', 'rtPanel' ), '<span>' . get_the_time( 'F, Y' ) . '</span>' ); ?></h1></div><?php
    } elseif ( is_year() ) { ?>
        <div class="post-title rtp-main-title"><h1><?php printf( __( 'Archive for  %s', 'rtPanel' ), '<span>' . get_the_time( 'Y' ) . '</span>' ); ?></h1></div><?php
    } elseif ( get_query_var( 'author_name' ) ) {
        $cur_auth = get_user_by( 'slug', get_query_var( 'author_name' ) ); ?>
        <div class="post-title rtp-main-title"><h1><?php printf( __( 'Author: %s', 'rtPanel' ), '<span>' . trim( ucfirst( $cur_auth->display_name ) ) . '</span>' ); ?></h1></div><?php
    }

    /* If there are no posts to display */
    if ( ! have_posts() ) { ?>
        <div id="post-0" <?php post_class('rtp-post-box'); ?>>
            <?php rtp_hook_begin_post(); ?>

            <div class="post-content">
                <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rtPanel' ); ?></p>
                <?php get_search_form(); ?>
            </div>
            
            <?php rtp_hook_end_post();  ?>
        </div><!-- #post-0 --><?php
    }

    /* the loop */
    if ( have_posts () ) {
        while( have_posts() ) {
            the_post(); ?>

            <div <?php post_class( 'rtp-post-box' ); ?>>
                <?php rtp_hook_begin_post(); ?>

                <div class="post-title">
                    <?php rtp_hook_begin_post_title(); ?>

                    <?php   if ( is_singular() ) { ?>
                                <h1><?php the_title(); ?></h1><?php
                            } else { ?>
                                <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permanent Link to %s', 'rtPanel' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2><?php
                            } ?>

                    <?php rtp_hook_end_post_title(); ?>

                    <div class="clear"></div>
                </div><!-- .post-title -->

                <?php rtp_hook_post_meta( 'top' ); ?>

                <div class="post-content">
                    <?php rtp_hook_begin_post_content(); ?>

                    <?php rtp_show_post_thumbnail(); ?>

                    <?php   if ( is_singular() || !$rtp_post_comments['summary_show'] ) {
                                the_content( 'Read More &rarr;' );
                                wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rtPanel' ), 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                            } else {
                                @the_excerpt();
                            } ?>

                    <?php rtp_hook_end_post_content(); ?>

                    <div class="clear"></div>
                </div><!-- .post-content -->

                <?php rtp_hook_post_meta( 'bottom' ); ?>

                <?php rtp_hook_end_post(); ?>
            </div><!-- .rtp-post-box --><?php

            /* Post Pagination */
            if ( is_single() ) { ?>
                <div class="rtp-navigation clearfix">
                    <div class="alignleft"><?php previous_post_link( '%link', '&larr; %title' ); ?></div>
                    <div class="alignright"><?php next_post_link( '%link', '%title &rarr;' ); ?></div>
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
                    <div class="alignleft"><?php next_posts_link( '&larr; Older Entries' ); ?></div>
                    <div class="alignright"><?php previous_posts_link( 'Newer Entries &rarr;' ); ?></div>
                </div><!-- .rtp-navigation --><?php
            }
        }
    } ?>