<?php
/**
 * rtPanel General Tab.
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */


/**
 * Displays The General Options tab
 *
 * @uses $screen_layout_columns int
 * @param string $pagehook The page hook
 */
 
function rtp_general_options_page( $pagehook ) {
    global $screen_layout_columns;
?>

    <div class="options-main-container">
        <?php rtp_get_error_or_update_messages(); ?>
        <div class="options-container">
            <form name="rt_general_form" id="rt_general_form" action="options.php" method="post" enctype="multipart/form-data">
                <?php
                //Display the required metaboxes declared in rt-settings-metaboxes.php
                add_meta_box( 'logo_options', __( 'Logo Settings', 'rtPanel' ), 'rtp_logo_option_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'fav_options', __( 'Favicon Settings', 'rtPanel' ), 'rtp_fav_option_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'feed_options', __( 'Feedburner Settings', 'rtPanel' ), 'rtp_feed_option_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'google_search', __( 'Google Custom Search Integration', 'rtPanel' ), 'rtp_google_search_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'custom_styles_options', __( 'Custom Styles', 'rtPanel' ), 'rtp_custom_styles_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'plugin_support', __( 'Plugin Support', 'rtPanel' ), 'rtp_plugin_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'backup_options', __( 'Backup rtPanel Options', 'rtPanel' ), 'rtp_backup_metabox', $pagehook, 'normal', 'core' );

                //nonce for security purpose
                wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
                wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
                
                <input type="hidden" name="action" value="save_rt_metaboxes_general" />
                <div id="poststuff" class="metabox-holder alignleft <?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
                    <div id="side-info-column" class="inner-sidebar">
                        <?php do_meta_boxes( $pagehook, 'side', '' ); ?>
                    </div>
                    <div id="post-body" class="has-sidebar">
                        <div id="post-body-content" class="has-sidebar-content">
                            <?php settings_fields( 'general_settings' ); ?>
                            <?php do_meta_boxes( $pagehook, 'normal', '' ); ?>
                            
                        </div>
                    </div>
                    <br class="clear"/>
                    <input class="button-primary" value="<?php _e( 'Save', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
                    <input class="button-secondary" value="<?php _e( 'Reset', 'rtPanel' ); ?>" name="rtp_reset" type="submit" />
                </div>

                <script type="text/javascript">
                    //<![CDATA[
                    jQuery(document).ready( function($) {
                        // close postboxes that should be closed
                        $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                        // postboxes setup
                        postboxes.add_postbox_toggles('<?php echo $pagehook; ?>');
                    });
                    //]]>
                </script>
            </form>
            
        </div>
    </div><?php
}