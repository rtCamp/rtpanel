<?php
/**
 * rtPanel General options
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * Displays rtPanel General options tab
 *
 * @uses $screen_layout_columns int
 * @param string $pagehook The page hook
 *
 * @since rtPanel 2.0
 */
function rtp_general_options_page( $pagehook ) {
    global $screen_layout_columns; ?>

    <div class="options-main-container">
        <?php settings_errors(); ?>
        <a href="#" class="expand-collapse button-link" title="Show/Hide All">Show/Hide All</a>
        <div class="clear"></div>
        <div class="options-container">
            <form name="rt_general_form" id="rt_general_form" action="options.php" method="post" enctype="multipart/form-data">
                <?php
                /* nonce for security purpose */
                wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
                wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
                
                <input type="hidden" name="action" value="save_rtp_metaboxes_general" />
                <div id="poststuff" class="metabox-holder alignleft">
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
                    <?php submit_button('Save All Changes', 'primary', 'rtp_submit', false ); ?>
                    <?php submit_button('Reset All General Settings', 'button-link', 'rtp_reset', false ); ?>
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