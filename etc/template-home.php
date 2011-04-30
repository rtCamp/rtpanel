<?php
/*
Template Name: HomePage
*/

/* ========== [ Call Header ] ========== */
get_header();

/* ========== [ rtpanel_hook for adding content before #sidebar ] ========== */
rtp_hook_begin_sidebar();

/* ========== [ Call Sidebar ] ========== */
get_sidebar();

/* ========== [ rtpanel_hook for adding content after #sidebar ] ========== */
rtp_hook_end_sidebar();

/* ========== [ rtpanel_hook for adding content before #content ] ========== */
rtp_hook_begin_content();
?>
<div id="content" class="rtp-home-posts"> <!-- content begins -->

    <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
            <div <?php post_class() ?>>
                <div class="post-title">
                    <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <div class="clear"></div>
                </div><!-- .post-title -->

                <div class="post-meta">
                    <!-- ========== [ Edit Post ] ========== -->
                    <?php edit_post_link( 'Edit this post', '<p class="rtp-edit-link">[', ']</p>' ); ?>
                </div><!-- .post-meta -->

                <div class="post-content">
                    <?php the_content( 'Read More &rarr;' ); ?>
		</div>

            <div class="clear"></div>
            </div><!-- .post_class -->

    <?php endwhile; ?>
    <?php
    /* ========== [ Page-Navi Plugin Support with WP Default Pagination ] ========== */
            if ( function_exists( 'wp_pagenavi' ) ) {
                wp_pagenavi();
            } elseif ( get_next_posts_link() || get_previous_posts_link() ) { ?>
                <div class="rtp-navigation clearfix"> <!-- rtp-navigation begins -->
                    <div class="alignleft"><?php next_posts_link( '&larr; Older Entries' ); ?></div>
                    <div class="alignright"><?php previous_posts_link( 'Newer Entries &rarr;' ); ?></div>
                </div> <!-- end rtp-navigation -->
        <?php } //if wp_pagenavi
    endif; ?>
</div><!-- end content -->
<?php
/* ========== [ rtpanel_hook for adding content after #content ] ========== */
rtp_hook_end_content();

/* ========== [ Call Footer ] ========== */
get_footer(); ?>