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
    <aside id="sidebar" class="rtp-sidebar-section<?php echo esc_attr( $class_name ); echo ( ! empty( $rtp_sidebar_grid_class ) ) ? ' '.$rtp_sidebar_grid_class : $rtp_sidebar_grid_class; ?>" role="complementary">
        <div class="rtp-sidebar-inner-wrapper">
            <?php rtp_hook_begin_sidebar(); ?>

                <?php 
if ( ! ( $sidebar_id && dynamic_sidebar( $sidebar_id ) ) ) {
	// Default Widgets Content
	rtp_hook_sidebar_content();
} ?>
            
            <?php rtp_hook_end_sidebar(); ?>
        </div>
    </aside>