<?php
/**
 * The generic template file
 * 
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */
get_header(); ?>

    <?php
        $rtp_content_class = '';
        $rtp_grid = "rtp-grid-8";

        // Full width grid for buddypress or bbpress
        if ( rtp_get_sidebar_id() === 0 )
            $rtp_grid = "rtp-grid-12";
        
        if ( is_archive() ) {
            $rtp_content_class = ' class="' . $rtp_grid . ' rtp-multiple-post" ';
        } elseif ( is_page() || is_single() || is_404() ) {
            $rtp_content_class = ' class="' . $rtp_grid . ' rtp-singular" ';
        } elseif ( is_home() ) {
            $rtp_content_class = ' class="' . $rtp_grid . ' rtp-blog-post" ';
        } else {
            $rtp_content_class = ' class="' . $rtp_grid . '"';
        }
    ?>
    <section id="content" role="main"<?php echo $rtp_content_class; ?>>
        <?php rtp_hook_begin_content(); ?>

        <?php get_template_part( 'loop', 'common' ); ?>

        <?php rtp_hook_end_content(); ?>
    </section><!-- #content -->

    <?php (rtp_get_sidebar_id() === 0) ? '' : rtp_hook_sidebar(); ?>

<?php get_footer(); ?>