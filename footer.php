<?php
/**
 * The template for displaying the footer
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
global $rtp_general; ?>

                <?php rtp_hook_end_content_wrapper(); ?>
            </div><!-- #content-wrapper -->

            <?php rtp_hook_after_content_wrapper(); ?>

            <footer id="footer-wrapper" role="contentinfo" class="clearfix rtp-footer-wrapper"><?php
                /* Grid class for widget */
                $rtp_footer_widget_grid_class = apply_filters( 'rtp_set_footer_widget_grid_class', 'large-4 columns' );

                if ( $rtp_general['footer_sidebar'] ) { ?>
                    <aside role="complementary" id="rtp-footer-widgets-wrapper" class="rtp-footerbar row"><?php
                        // Default Widgets ( Fallback )
                        if ( !dynamic_sidebar( 'footer-widgets' ) ) { ?>
                            <div class="widget footerbar-widget <?php echo $rtp_footer_widget_grid_class; ?>"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></div>
                            <div class="widget footerbar-widget <?php echo $rtp_footer_widget_grid_class; ?>"><h3 class="widgettitle"><?php _e( 'Tags', 'rtPanel' ); ?></h3><div class="tagcloud"><?php wp_tag_cloud(); ?></div></div>
                            <div class="widget footerbar-widget <?php echo $rtp_footer_widget_grid_class; ?>"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></div><?php
                        } ?>
                    </aside><!-- #footerbar --><?php
                } ?>

                <?php rtp_hook_before_footer(); ?>

                <div id="footer" class="rtp-footer">
                    <p>&copy; <?php echo date( 'Y' ); echo ' - '; bloginfo( 'name' ); ?>
                    <em><?php printf( __( 'Designed on <a role="link" href="%s" class="rtp-common-link" title="rtPanel WordPress Theme Framework">rtPanel WordPress Theme Framework</a>.', 'rtPanel' ), 'http://rtcamp.com/rtpanel/' ); ?></em></p>
                </div><!-- #footer -->

                <?php rtp_hook_after_footer(); ?>

            </footer><!-- #footer-wrapper-->

            <?php rtp_hook_end_main_wrapper(); ?>

        </div><!-- #main-wrapper -->

        <?php wp_footer(); ?>

        <?php rtp_hook_end_body(); ?>
        <!--<script src="//localhost:35729/livereload.js"></script>-->
    </body>
</html>