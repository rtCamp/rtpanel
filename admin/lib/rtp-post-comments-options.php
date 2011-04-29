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
        <?php rtp_get_error_or_update_messages(); ?>
        <div class="options-container">

            <form name="rt_post_comments_form" id="rt_post_comments_form" action="options.php" method="post" enctype="multipart/form-data">
                <?php
                //Display the required metaboxes declared in rt-settings-metaboxes.php
                add_meta_box( 'post_summaries_options', __( 'Post Summaries Options', 'rtPanel' ), 'rtp_post_summaries_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'post_thumbnail_options', __( 'Post Thumbnail Options', 'rtPanel' ), 'rtp_post_thumbnail_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'post_meta_options', __( 'Post Meta Options', 'rtPanel' ), 'rtp_post_meta_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'comment_form_options', __( 'Comment Form Settings', 'rtPanel' ), 'rtp_comment_form_metabox', $pagehook, 'normal', 'core' );
                add_meta_box( 'gravatar_options', __( 'Gravatar Settings', 'rtPanel' ), 'rtp_gravatar_metabox', $pagehook, 'normal', 'core' );

                //nonce for security purpose
                wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
                wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
                ?>
                <input type="hidden" name="action" value="save_rt_metaboxes_general" />

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
                    <input class="button-primary" value="<?php _e( 'Save', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
                    <input class="button-secondary" value="<?php _e( 'Reset All Post &amp; Comments Options', 'rtPanel' ); ?>" name="rtp_reset" type="submit" />
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