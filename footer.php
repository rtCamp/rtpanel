<?php
/**
 * The template for displaying the footer
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

global $rtp_general; ?>

                <div class="clear"></div>

                <?php rtp_hook_end_content_wrapper(); ?>

            </div><!-- #content-wrapper -->
           
            <div id="footer-wrapper"><?php
                if ( $rtp_general['footer_sidebar'] ) { ?>
                    <div id="footerbar"><?php
                        //If footer widgets are set by user
                        if ( function_exists('dynamic_sidebar') && is_active_sidebar('footer-widgets') ) {
                            dynamic_sidebar('footer-widgets');
                        } else { // Default Widgets ( Fallback ) ?>
                            <div class="widget footerbar-widget"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></div>
                            <div class="widget footerbar-widget"><h3 class="widgettitle"><?php _e( 'Tags', 'rtPanel' ); ?></h3><div class="tagcloud"><?php wp_tag_cloud(); ?></div></div>
                            <div class="widget footerbar-widget"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></div><?php
                        } ?>
                    </div><!-- #footerbar -->
                    <div class="clear"></div><?php
                } ?>

                <?php rtp_hook_before_footer(); ?>

                <div id="footer">
                    <p>&copy; <?php echo date( 'Y' ); echo ' - '; bloginfo( 'name' ); ?></p>
                    <p><em><?php printf( __( 'Designed on <a href="%s" title="rtPanel WordPress Theme Framework">rtPanel WordPress Theme Framework</a>.', 'rtPanel' ), 'http://rtpanel.com/' ); ?></em></p>
                </div><!-- #footer -->

                <?php rtp_hook_after_footer(); ?>

            </div><!-- #footer-wrapper-->
	</div><!-- #main-wrapper -->

        <?php wp_footer(); ?>

    </body>
</html>