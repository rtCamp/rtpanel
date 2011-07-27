<?php
/**
 * The template used to register sidebars
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */

/**
 * Registers the sidebars
 *
 * @since rtPanel 2.0
 */
function rtp_widgets_init() {
    global $rtp_general;

    // Register Sidebar Widget
    register_sidebar( array(
        'name' => __( 'Sidebar Widgets', 'rtPanel' ),
        'id' => 'sidebar-widgets',
        'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ) );

    // Register Footer Widget
    if ( $rtp_general['footer_sidebar'] ) {
         register_sidebar( array(
            'name' => __( 'Footer Widgets', 'rtPanel' ),
            'id' => "footer-widgets",
            'before_widget' => '<div id="%1$s" class="widget footerbar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>',
        ) );
    }
}
add_action( 'widgets_init', 'rtp_widgets_init' );