<?php
/**
 * rtPanel Post and Comments Tab.
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

/**
 * Displays the Post Comments Options tab
 *
 * @uses $screen_layout_columns int
 * @param srting $pagehook The page hook
 */
function rtp_post_comments_options_page( $pagehook ) {
    global $screen_layout_columns; ?>

    <div class="options-main-container">
        <?php settings_errors(); ?>
        <div class="options-container">

            <form name="rt_post_comments_form" id="rt_post_comments_form" action="options.php" method="post" enctype="multipart/form-data">
                <?php
                //nonce for security purpose
                wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
                wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
                ?>
                <input type="hidden" name="action" value="save_rtp_metaboxes_post_comments" />

                <div id="poststuff" class="metabox-holder alignleft <?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
                    <div id="side-info-column" class="inner-sidebar">
                        <?php do_meta_boxes( $pagehook, 'side', '' ); ?>
                    </div>
                    <div id="post-body" class="has-sidebar">
                        <div id="post-body-content" class="has-sidebar-content">
                            <?php settings_fields( 'post_comment_settings' ); ?>
                            <?php do_meta_boxes( $pagehook, 'normal', '' ); ?>
                        </div>
                    </div>
                    <br class="clear"/>
                    <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
                    <input class="button-link" value="<?php _e( 'Reset All Post &amp; Comments Settings', 'rtPanel' ); ?>" name="rtp_reset" type="submit" />
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