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
           
            <footer id="footer-wrapper"  role="contentinfo"><?php
                if ( $rtp_general['footer_sidebar'] ) { ?>
                    <div id="footerbar"><?php
                        // Default Widgets ( Fallback )
                        if ( !dynamic_sidebar( 'footer-widgets' ) ) {  ?>
                            <aside class="widget footerbar-widget"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></aside>
                            <aside class="widget footerbar-widget"><h3 class="widgettitle"><?php _e( 'Tags', 'rtPanel' ); ?></h3><div class="tagcloud"><?php wp_tag_cloud(); ?></div></aside>
                            <aside class="widget footerbar-widget"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></aside><?php
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

            </footer><!-- #footer-wrapper-->
	</div><!-- #main-wrapper -->

        <?php wp_footer(); ?>

    </body>
</html>