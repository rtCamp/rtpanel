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
                <hr class="rtp-horizontal-border rtp-grid-12" />
            </div><!-- #content-wrapper -->
           
            <footer id="footer-wrapper" role="contentinfo" class="rtp-container-12"><?php
                if ( $rtp_general['footer_sidebar'] ) { ?>
                    <div id="footerbar"><?php
                        // Default Widgets ( Fallback )
                        if ( !dynamic_sidebar( 'footer-widgets' ) ) {  ?>
                            <aside class="widget rtp-grid-4 footerbar-widget"><h3 class="widgettitle"><?php _e( 'Archives', 'rtPanel' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly' ) ); ?></ul></aside>
                            <aside class="widget rtp-grid-4 footerbar-widget"><h3 class="widgettitle"><?php _e( 'Tags', 'rtPanel' ); ?></h3><div class="tagcloud"><?php wp_tag_cloud(); ?></div></aside>
                            <aside class="widget rtp-grid-4 footerbar-widget"><h3 class="widgettitle"><?php _e( 'Meta', 'rtPanel' ); ?></h3><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li><?php wp_meta(); ?></ul></aside><?php
                        } ?>
                    </div><!-- #footerbar --><?php
                } ?>

                <?php rtp_hook_before_footer(); ?>
                    <hr class="rtp-horizontal-border rtp-grid-12" />
                <div id="footer" class="rtp-grid-12">
                    <div>&copy; <?php echo date( 'Y' ); echo ' - '; bloginfo( 'name' ); ?></div>
                    <div><em><?php printf( __( 'Designed on <a href="%s" class="rtp-common-link" title="rtPanel WordPress Theme Framework">rtPanel WordPress Theme Framework</a>.', 'rtPanel' ), 'http://rtpanel.com/' ); ?></em></div>
                </div><!-- #footer -->

                <?php rtp_hook_after_footer(); ?>

            </footer><!-- #footer-wrapper-->
            
            <?php rtp_hook_end_main_wrapper(); ?>

        </div><!-- #main-wrapper -->

        <?php wp_footer(); ?>
        
        <?php rtp_hook_end_body(); ?>
        
    </body>
</html>
