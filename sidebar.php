<?php
/**
 * The template for displaying Sidebar
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */
?>
    <aside id="sidebar" class="rtp-grid-4" role="complementary">
        <?php rtp_hook_begin_sidebar(); ?>

            <?php   // Default Widgets ( Fallback )
                if ( !dynamic_sidebar( 'sidebar-widgets' ) ) { ?>
                    <div class="widget sidebar-widget"><h3 class="widgettitle"><?php _e( 'Search', 'rtPanel' ); ?></h3><?php get_search_form(); ?></div>
                    <div class="widget sidebar-widget"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></div>
                    <div class="widget sidebar-widget"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></div><?php
                } ?>

        <?php rtp_hook_end_sidebar(); ?>
    </aside><!-- #sidebar -->