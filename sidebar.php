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

    if ( $sidebar_id === 'buddypress-sidebar-widgets' ) {
        $class_name = ' rtp-buddypress-sidebar';
    }

    else if ( $sidebar_id === 'bbpress-sidebar-widgets' ) {
        $class_name = ' rtp-bbpress-sidebar';
    } ?>

    <!-- #sidebar -->
    <aside id="sidebar" class="rtp-sidebar-section<?php echo esc_attr($class_name); echo ( !empty( $rtp_sidebar_grid_class ) ) ? ' '.$rtp_sidebar_grid_class : $rtp_sidebar_grid_class; ?>" role="complementary">
        <div class="rtp-sidebar-inner-wrapper">
            <?php rtp_hook_begin_sidebar(); ?>

            <?php   // Default Widgets ( Fallback )
                    if ( !( $sidebar_id && dynamic_sidebar( $sidebar_id ) ) ) { ?>
                        <div class="widget sidebar-widget">
                            <p>
                                <?php _e( '<strong>rtPanel</strong> is equipped with everything you need to produce a professional website. <br />It is one of the most optimized WordPress Theme Framework available today.', 'rtPanel' ); ?>
                            </p>

                            <p class="rtp-message-success">
                                <?php printf( __( 'This theme comes with free technical <a title="Click here for rtPanel Free Support" target="_blank" href="%s">Support</a> by team of 30+ full-time developers.', 'rtPanel' ), 'https://rtcamp.com/support/forum/rtpanel/' ); ?>
                            </p>
                        </div><?php
                    } ?>
            <?php rtp_hook_end_sidebar(); ?>
        </div>
    </aside>