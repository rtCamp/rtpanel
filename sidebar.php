<?php
/**
 * The template for displaying Sidebar
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */
?>
    <div id="sidebar" class="rtp-grid-4 rtp-omega" role="complementary">
        <?php rtp_hook_begin_sidebar(); ?>

            <?php   // Default Widgets ( Fallback )
                if ( !dynamic_sidebar( 'sidebar-widgets' ) ) { ?>
                    <aside class="widget rtp-grid-4 rtp-alpha rtp-omega sidebar-widget"><h3 class="widgettitle"><?php _e( 'Search', 'rtPanel' ); ?></h3><?php get_search_form(); ?></aside>
                    <aside class="widget rtp-grid-4 rtp-alpha rtp-omega sidebar-widget"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></aside>
                    <aside class="widget rtp-grid-4 rtp-alpha rtp-omega sidebar-widget"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></aside><?php
                } ?>

        <?php rtp_hook_end_sidebar(); ?>
    </div><!-- #sidebar -->