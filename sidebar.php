<?php
/**
 * The template for displaying Sidebar
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */
    
    $sidebar_id = rtp_get_sidebar_id();
    $class_name = '';
    $rtp_sidebar_grid_class = apply_filters( 'rtp_set_sidebar_grid_class', 'large-4 columns' );

    if ( $sidebar_id === 'buddypress-sidebar-widgets' )
        $class_name = ' rtp-buddypress-sidebar';
    else if ( $sidebar_id === 'bbpress-sidebar-widgets' )
        $class_name = ' rtp-bbpress-sidebar'; ?>

    <aside id="sidebar" class="rtp-sidebar-section<?php echo $class_name; echo ( !empty( $rtp_sidebar_grid_class ) ) ? ' '.$rtp_sidebar_grid_class : $rtp_sidebar_grid_class; ?>" role="complementary">
        <div class="rtp-sidebar-inner-wrapper">
            <?php rtp_hook_begin_sidebar(); ?>

            <?php   // Default Widgets ( Fallback )
                    if ( !($sidebar_id && dynamic_sidebar( $sidebar_id )) ) { ?>
            
                        <div class="widget sidebar-widget"><h3 class="widgettitle"><?php _e( 'Search', 'rtPanel' ); ?></h3><?php get_search_form(); ?></div>
                        <div class="widget sidebar-widget"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></div>
                        <div class="widget sidebar-widget"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></div><?php
                    } ?>

            <?php rtp_hook_end_sidebar(); ?>
        </div>
    </aside><!-- #sidebar -->