<?php
/**
 * rtPanel options metaboxes
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * Registers rtPanel General and Post & Comments options
 *
 * @since rtPanel 2.0
 */
function rtp_admin_init_general() {
    register_setting( 'general_settings', 'rtp_general', 'rtp_general_validate' );
    register_setting( 'post_comment_settings', 'rtp_post_comments', 'rtp_post_comments_validate' );
}
add_action( 'admin_init', 'rtp_admin_init_general' );

/**
 * Logo Settings Metabox - General Tab
 * 
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_logo_option_metabox() {
    global $rtp_general; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="logo_show">Show Logo</label></th>
                <td>
                    <input type="hidden" name="rtp_general[logo_show]" value="0" />
                    <input type="checkbox" name="rtp_general[logo_show]" value="1" id="logo_show" <?php checked( $rtp_general['logo_show'] ); ?> />
                    <span class="description"><label for="logo_show"><?php _e( 'Check this box to display logo uploaded below instead of Site Title as text', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
            <tr valign="top" class="show-fields-logo">
                <th scope="row">
                    <input type="radio" name="rtp_general[use_logo]" value="use_logo_url" id="use_logo_url" class="rtp_logo" <?php checked( 'use_logo_url', $rtp_general['use_logo'] ); ?> />
                    <label for="use_logo_url"><?php _e( 'Logo URL', 'rtPanel' ); ?></label>
                </th>
                <td class="img-url">
                    <input<?php disabled( 'use_logo_upload', $rtp_general['use_logo'] ); ?> type="text" value="<?php echo $rtp_general['logo_url']; ?>" name="rtp_general[logo_url]" size="40" id="logo_url" /><br />
                    <span class="description"><label class="example" for="logo_url"><?php _e( 'Eg. http://www.example.com/logo.jpg', 'rtPanel' ); ?></label></span>
                </td>
                <td class="img-preview" rowspan="2">
                    <div class="image-preview" id="logo_metabox">
                        <p><?php _e( 'Preview', 'rtPanel' ); ?></p>
                        <img height="90" alt="Logo" src="<?php echo rtp_logo_fav_src(); ?>" />
                    </div>
                </td>
            </tr>
            <tr valign="top" class="show-fields-logo">
                <th>
                    <input type="radio" name="rtp_general[use_logo]" value="use_logo_upload" id="use_logo_upload" class="rtp_logo" <?php checked( 'use_logo_upload', $rtp_general['use_logo'] ) ? 'checked="checked"' : '' ?> />
                    <label for="use_logo_upload"><?php _e( 'Upload Logo', 'rtPanel' ); ?></label>
                </th>
                <td>
                <input<?php disabled( 'use_logo_url', $rtp_general['use_logo'] ); ?> type="button" value="<?php _e( 'Upload Logo', 'rtPanel' ); ?>" class="button " id="logo_upload" />
                <input type="hidden"  name="rtp_general[logo_upload]" id="logo_upload_url" value="<?php if( isset( $rtp_general['logo_upload'] ) ) echo $rtp_general['logo_upload']; ?>" />
                </td>
            </tr>
            <tr valign="top" class="show-fields-logo">
                <th scope="row"><label for="login_head"><?php _e( 'Admin Logo', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="hidden" name="rtp_general[login_head]" value="0" />
                    <input type="checkbox" name="rtp_general[login_head]" value="1" id="login_head" <?php checked( $rtp_general['login_head'] ); ?> />
                    <span class="description"><label for="login_head"><?php printf( __( 'Check this box to display logo on <a href="%s" title="Wordpress Login">WordPress Login Screen</a>', 'rtPanel' ), site_url('/wp-login.php') ); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Logo Settings', 'rtPanel' ); ?>" name="rtp_logo_reset" type="submit" />
        <div class="clear"></div>
    </div>
<?php
}

/**
 * Favicon Settings Metabox - General Tab
 *
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_fav_option_metabox() {
    global $rtp_general; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row">
                    <input type="radio" name="rtp_general[use_favicon]" value="use_favicon_url" id="use_favicon_url" class="rtp_favicon" <?php checked( 'use_favicon_url', $rtp_general['use_favicon'] ); ?> />
                    <label for="use_favicon_url"><?php _e( 'Favicon URL', 'rtPanel' ); ?></label>
                </th>
                <td class="img-url">
                    <input<?php disabled( 'use_favicon_upload', $rtp_general['use_favicon'] ); ?> type="text" value="<?php echo $rtp_general['favicon_url']; ?>" name="rtp_general[favicon_url]" size="40" id="favicon_url" /><br />
                    <span class="description"><label class="example" for="favicon_url"><?php _e( 'Eg. http://www.example.com/favicon.ico', 'rtPanel' ); ?></label></span>
                </td>
                <td class="img-preview" rowspan="2">
                    <div class="alignleft image-preview"  id="favicon_metabox">
                        <p><?php _e( 'Preview', 'rtPanel' ); ?></p>
                        <img width="16" height="16" alt="favicon" src="<?php echo rtp_logo_fav_src('favicon'); ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <th>
                    <input type="radio" name="rtp_general[use_favicon]" value="use_favicon_upload" id="use_favicon_upload" class="rtp_favicon" <?php checked( 'use_favicon_upload', $rtp_general['use_favicon'] ); ?> />
                    <label for="use_favicon_upload"><?php _e( 'Upload Favicon', 'rtPanel' ); ?></label>
                </th>
                <td>
                    <input<?php disabled( 'use_favicon_url', $rtp_general['use_favicon'] ); ?> type="button" value="<?php _e( 'Upload Favicon', 'rtPanel' ); ?>" name="rtp_general[favicon_upload]" class="button" id="favicon_upload" />
                    <input type="hidden"  name="rtp_general[favicon_upload]" id="favicon_upload_url" value="<?php if( isset( $rtp_general['favicon_upload'] ) ) echo $rtp_general['favicon_upload']; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Favicon Settings', 'rtPanel' ); ?>" name="rtp_fav_reset" type="submit" />
        <div class="clear"></div>
    </div><?php
}

/**
 * Facebook Open Graph Metabox - General Tab
 *
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_facebook_ogp_metabox() {
    global $rtp_general; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="fb_app_id"><?php _e( 'Facebook App ID', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rtp_general['fb_app_id'] ?>" size="40" name="rtp_general[fb_app_id]" id="fb_app_id" />
                    <span class="description"><label for="fb_app_id"><?php _e( 'Specify Facebook App ID', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="fb_admins"><?php _e( 'Facebook Admin ID(s)', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rtp_general['fb_admins'] ?>" size="40" name="rtp_general[fb_admins]" id="fb_admins" />
                    <span class="description"><label for="fb_admins"><?php _e( 'Specify Facebook Admin ID(s) ( Comma separated )', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Facebook OGP Settings', 'rtPanel' ); ?>" name="rtp_fb_ogp_reset" type="submit" />
        <div class="clear"></div>
    </div>
<?php
}

/**
 * Feedburner Settings Metabox - General Tab
 *
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_feed_option_metabox() {
    global $rtp_general; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="feedburner_url"><?php _e( 'FeedBurner URL', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="text" value="<?php echo $rtp_general['feedburner_url'] ?>" size="40" name="rtp_general[feedburner_url]" id="feedburner_url" />
                    <span class="description"><label for="feedburner_url"><?php printf( __( 'Specify <a href="%s" title="FeedBurner">FeedBurner</a> URL to redirect feeds', 'rtPanel' ), 'http://www.feedburner.com/' ); ?></label><br /><label class="example" for="feedburner_url"><?php _e( 'Eg. http://www.example.com', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset FeedBurner Settings', 'rtPanel' ); ?>" name="rtp_feed_reset" type="submit" />
        <div class="clear"></div>
    </div>
<?php
}

/**
 * Misc. Settings Metabox - General Tab
 * 
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_sidebar_options_metabox() {
    global $rtp_general; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="footer_sidebar"><?php _e( 'Enable Footer Sidebar', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="hidden" name="rtp_general[footer_sidebar]" value="0" />
                    <input type="checkbox" value="1" size="40" name="rtp_general[footer_sidebar]" id="footer_sidebar" <?php checked( $rtp_general['footer_sidebar'] ); ?> />
                    <span class="description"><label for="footer_sidebar"><?php _e( 'Check this to enable footer sidebar', 'rtPanel' ); ?></label><br /></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Sidebar Settings', 'rtPanel' ); ?>" name="rtp_sidebar_reset" type="submit" />
        <div class="clear"></div>
    </div>
<?php
}

/**
 * Google Custom Search Integration Metabox - General Tab
 * 
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_google_search_metabox() {
    global $rtp_general; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="search_code"><?php _e( 'Google Custom Search Element Code', 'rtPanel' ); ?></label></th>
                <td>
                    <textarea cols="33" rows="5" name="rtp_general[search_code]" id="search_code"><?php echo $rtp_general['search_code']; ?></textarea><br />
                    <label for="search_code"><span class="description"><?php printf( __( 'The Google Search Code Obtained by Default. You can obtain the Google Custom Search Code <a href="%s" title="Googel Custom Search">here</a><br />', 'rtPanel' ), 'http://www.google.com/cse/' ); ?></span>
                    <strong><?php _e( 'NOTE', 'rtPanel' ); ?>: </strong><span class="description"><?php _e( 'The hosting option must be "Search Element" and layout either "full-width" or "compact".', 'rtPanel' ); ?></span></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="search_layout"><?php _e( 'Hide Sidebar', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="hidden" name="rtp_general[search_layout]" value="0" />
                        <input type="checkbox" name="rtp_general[search_layout]" value="1" id="search_layout" <?php checked( $rtp_general['search_layout'] ); ?> />
                    <span class="description"><label for="search_layout"><?php _e( 'Do not show sidebar on Search Results Page ( When using Google Custom Search )', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Google Custom Search Integration', 'rtPanel' ); ?>" name="rtp_google_reset" type="submit" />
        <div class="clear"></div>
    </div>
<?php
}

/**
 * Custom Styles Metabox - General Tab
 * 
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_custom_styles_metabox() {
    global $rtp_general; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="custom_styles"><?php _e( 'Add your CSS here &rarr;', 'rtPanel' ); ?></label></th>
                <td>
                    <textarea cols="33" rows="5" name="rtp_general[custom_styles]" id="custom_styles"><?php echo $rtp_general['custom_styles']; ?></textarea><br />
                    <span class="description"><label for="custom_styles"><?php _e( 'Add your extra CSS rules here. No need to use !important. Rules written above will be loaded last.', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Custom Styles', 'rtPanel' ); ?>" name="rtp_custom_styles_reset" type="submit" />
        <div class="clear"></div>
    </div>
<?php
}

/**
 * Plugin Support Metabox - General Tab
 *
 * @since rtPanel 2.0
 */
function rtp_plugin_metabox() {
    $plugins = get_plugins();
    $subscribe_activate = wp_create_nonce( RTP_SUBSCRIBE_TO_COMMENTS . '-activate' );
    $subscribe_deactivate = wp_create_nonce( RTP_SUBSCRIBE_TO_COMMENTS . '-deactivate' );
    $subscribe_delete = wp_create_nonce( RTP_SUBSCRIBE_TO_COMMENTS . '-delete' );
    $pagenavi_activate = wp_create_nonce( RTP_WP_PAGENAVI . '-activate' );
    $pagenavi_deactivate = wp_create_nonce( RTP_WP_PAGENAVI . '-deactivate' );
    $pagenavi_delete = wp_create_nonce( RTP_WP_PAGENAVI . '-delete' );
    $breadcrumb_activate = wp_create_nonce( RTP_BREADECRUMB_NAVXT . '-activate' );
    $breadcrumb_deactivate = wp_create_nonce( RTP_BREADECRUMB_NAVXT . '-deactivate' );
    $breadcrumb_delete = wp_create_nonce( RTP_BREADECRUMB_NAVXT . '-delete' ); ?>
    <table class="form-table">
        <tr>
            <th><?php _e( 'Name', 'rtPanel' ); ?></th>
            <th><?php _e( 'Status', 'rtPanel' ); ?></th>
            <th><?php _e( 'Action', 'rtPanel' ); ?></th>
            <th><?php _e( 'Edit', 'rtPanel' ); ?></th>
        </tr>
        <tr>
            <td><a href="http://wordpress.org/extend/plugins/subscribe-to-comments/"><?php _e( 'Subscribe to Comments', 'rtPanel' ); ?></a></td>
            <td>
                <?php
                if ( is_plugin_active( RTP_SUBSCRIBE_TO_COMMENTS ) ) {
                    echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
                } elseif ( array_key_exists( RTP_SUBSCRIBE_TO_COMMENTS, $plugins ) ) {
                    echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
                } else {
                    echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
                }
                ?>
            </td>
            <td>
                <?php if ( is_plugin_active( RTP_SUBSCRIBE_TO_COMMENTS ) ) { ?>
                    <input type="hidden" value="<?php echo $subscribe_deactivate; ?>" name="_wpnonce_subscribe_deactivate" id="_wpnonce_subscribe_deactivate" /><input id="subscribe-deactivate" type="hidden" name="subscribe-deactivate" value="0" /><a class="subscribe-deactivate" href="#subscribe-deactivate" onclick="deactivate_plugin('Subscribe To Comments')"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
                <?php } elseif ( array_key_exists( RTP_SUBSCRIBE_TO_COMMENTS, $plugins ) ) { ?>
                    <input type="hidden" value="<?php echo $subscribe_activate; ?>" name="_wpnonce_subscribe_activate" id="_wpnonce_subscribe_activate" /><input id="subscribe-activate" type="hidden" name="subscribe-activate" value="0" /><a class="subscribe-activate" href="#subscribe-activate" onclick="activate_plugin('Subscribe To Comments')"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo $subscribe_delete; ?>" name="_wpnonce_subscribe_delete" id="_wpnonce_subscribe_delete" /><input id="subscribe-delete" type="hidden" name="subscribe-delete" value="0" /><a class="subscribe-delete" href="#subscribe-delete" onclick="delete_plugin_confirmation( 'Subscribe To Comments' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
                <?php } else { ?>
                    <a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=subscribe-to-comments' ), 'install-plugin_subscribe-to-comments' ); ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
                <?php } ?>
            </td>
            <td>
                <?php if ( is_plugin_active( RTP_SUBSCRIBE_TO_COMMENTS ) || array_key_exists( RTP_SUBSCRIBE_TO_COMMENTS, $plugins ) ) { ?>
                    <a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_SUBSCRIBE_TO_COMMENTS ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
                <?php } else { ?>
                    <span class="not-installed"> ----- </span>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td><a href="http://wordpress.org/extend/plugins/wp-pagenavi/"><?php _e( 'WP PageNavi', 'rtPanel' ); ?></a></td>
            <td>
                <?php
                if ( is_plugin_active( RTP_WP_PAGENAVI ) ) {
                    echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
                } elseif ( array_key_exists( RTP_WP_PAGENAVI, $plugins ) ) {
                    echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
                } else {
                    echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
                }
                ?>
            </td>
            <td>
                <?php if ( is_plugin_active(RTP_WP_PAGENAVI ) ) { ?>
                    <input type="hidden" value="<?php echo $pagenavi_deactivate; ?>" name="_wpnonce_pagenavi_deactivate" id="_wpnonce_pagenavi_deactivate" /><input id="pagenavi-deactivate" type="hidden" name="pagenavi-deactivate" value="0" /><a class="pagenavi-deactivate" href="#pagenavi-deactivate" onclick="deactivate_plugin('WP PageNavi')"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
                <?php } elseif ( array_key_exists( RTP_WP_PAGENAVI, $plugins ) ) { ?>
                    <input type="hidden" value="<?php echo $pagenavi_activate; ?>" name="_wpnonce_pagenavi_activate" id="_wpnonce_pagenavi_activate" /><input id="pagenavi-activate" type="hidden" name="pagenavi-activate" value="0" /><a class="pagenavi-activate" href="#pagenavi-activate" onclick="activate_plugin( 'WP PageNavi' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo $pagenavi_delete; ?>" name="_wpnonce_pagenavi_delete" id="_wpnonce_pagenavi_delete" /><input id="pagenavi-delete" type="hidden" name="pagenavi-delete" value="0" /><a class="pagenavi-delete" href="#pagenavi-delete" onclick="delete_plugin_confirmation( 'WP PageNavi' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
                <?php } else { ?>
                    <a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=wp-pagenavi' ), 'install-plugin_wp-pagenavi' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
                <?php } ?>
            </td>
            <td>
                <?php if ( is_plugin_active( RTP_WP_PAGENAVI ) || array_key_exists( RTP_WP_PAGENAVI, $plugins ) ) { ?>
                    <a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_WP_PAGENAVI ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
                <?php } else { ?>
                    <span class="not-installed"> ----- </span>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="last-child"><a href="http://wordpress.org/extend/plugins/breadcrumb-navxt/"><?php _e( 'Breadcrumb NavXT', 'rtPanel' ); ?></a></td>
            <td class="last-child">
                <?php
                if ( is_plugin_active( RTP_BREADECRUMB_NAVXT ) ) {
                    echo '<span class="active">Active</span>';
                } elseif ( array_key_exists( RTP_BREADECRUMB_NAVXT, $plugins ) ) {
                    echo '<span class="inactive">Inactive</span>';
                } else {
                    echo '<span class="not-installed">Not Installed</span>';
                } ?>
            </td>
            <td class="last-child">
                <?php if ( is_plugin_active( RTP_BREADECRUMB_NAVXT ) ) { ?>
                    <input type="hidden" value="<?php echo $breadcrumb_deactivate; ?>" name="_wpnonce_breadcrumb_deactivate" id="_wpnonce_breadcrumb_deactivate" /><input id="breadcrumb-deactivate" type="hidden" name="breadcrumb-deactivate" value="0" /><a class="breadcrumb-deactivate" href="#breadcrumb-deactivate" onclick="deactivate_plugin( 'Breadcrumb NavXT' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
                <?php } elseif ( array_key_exists( RTP_BREADECRUMB_NAVXT, $plugins ) ) { ?>
                    <input type="hidden" value="<?php echo $breadcrumb_activate; ?>" name="_wpnonce_breadcrumb_activate" id="_wpnonce_breadcrumb_activate" /><input id="breadcrumb-activate" type="hidden" name="breadcrumb-activate" value="0" /><a class="breadcrumb-activate" href="#breadcrumb-activate" onclick="activate_plugin( 'Breadcrumb NavXT' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo $breadcrumb_delete; ?>" name="_wpnonce_breadcrumb_delete" id="_wpnonce_breadcrumb_delete" /><input id="breadcrumb-delete" type="hidden" name="breadcrumb-delete" value="0" /><a class="breadcrumb-delete" href="#breadcrumb-delete" onclick="delete_plugin_confirmation( 'Breadcrumb NavXT' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
                <?php } else { ?>
                    <a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=breadcrumb-navxt' ), 'install-plugin_breadcrumb-navxt' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
                <?php } ?>
            </td>
            <td class="last-child">
                <?php if ( is_plugin_active( RTP_BREADECRUMB_NAVXT ) || array_key_exists( RTP_BREADECRUMB_NAVXT, $plugins ) ) { ?>
                    <a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_BREADECRUMB_NAVXT ); ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
                <?php } else { ?>
                    <span class="not-installed"> ----- </span>
                <?php } ?>
            </td>
        </tr>
    </table><?php
}

/**
 * rtPanel Options Backup / Restore Metabox - General Tab
 * 
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_backup_metabox() {
    global $rtp_general; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th><label for="rtp_export"><?php _e( 'Export rtPanel Options', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="submit" id="rtp_export" value="<?php _e( 'Export', 'rtPanel' ); ?>" name="rtp_export" class="button" />
                </td>
            </tr>
            <tr valign="top">
                <th><label for="rtp_import"><?php _e( 'Import rtPanel Options', 'rtPanel' ); ?></label></th>
                <td>
                <input type="file" id="rtp_import" name="rtp_import" />
                    <input type="submit" value="<?php _e( 'Import', 'rtPanel' ); ?>" name="rtp_import" class="button" />
                </td>
            </tr>
        </tbody>
    </table>
<?php
}

/**
 * Post Summary Settings Metabox - Post & Comments Tab
 * 
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.0
 */
function rtp_post_summaries_metabox() {
    global $rtp_post_comments; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="summary_show"><?php _e( 'Enable Summary', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[summary_show]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[summary_show]" value="1" id="summary_show" <?php checked( $rtp_post_comments['summary_show'] ); ?> />
                    <span class="description"><label for="summary_show"><?php _e( 'Check this to enable excerpts on Archive pages ( Pages with multiple posts on them )', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="word_limit"><?php _e( 'Word Limit', 'rtPanel' ); ?></label></th>
                <td>
                    <input  maxlength="4" type="number" value="<?php echo $rtp_post_comments['word_limit']; ?>" size="4" name="rtp_post_comments[word_limit]" id="word_limit" />
                    <span class="description"><label for="word_limit"><?php _e( 'Post Content will be cut around Word Limit you will specify here.', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="read_text"><?php _e( 'Read More Text', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="text" value="<?php echo esc_attr( $rtp_post_comments['read_text'] ); ?>" size="30" name="rtp_post_comments[read_text]" id="read_text" />
                    <span class="description"><label for="read_text"><?php _e( 'This will be added after each post summary. Text added here will be automatically converted into a hyperlink pointing to the respective post.', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Post Sumarry Settings', 'rtPanel' ); ?>" name="rtp_summary_reset" type="submit" />
        <div class="clear"></div>
    </div><?php
}

/**
 * Post Thumbnail Settings Metabox - Post & Comments Tab
 * 
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.0
 */
function rtp_post_thumbnail_metabox() {
    global $rtp_post_comments;
    $alignment = ( isset ( $rtp_post_comments['thumbnail_position'] ) ) ? $rtp_post_comments['thumbnail_position'] : ''; ?> <br />
    <span class="description post-summary-hide"><strong><?php _e( 'Enable Summary must be checked on the Post Summary Settings to show these Options', 'rtPanel' ); ?></strong></span>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_show"><?php _e( 'Enable Thumbnails', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[thumbnail_show]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[thumbnail_show]" value="1" id="thumbnail_show" <?php checked( $rtp_post_comments['thumbnail_show'] ); ?> />
                    <span class="description"><label for="thumbnail_show"><?php _e( 'Check this to display thumbnails as part of Post Summaries on Archive pages', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label><?php _e( 'Thumbnail Alignment', 'rtPanel' ); ?></label></th>
                <td>
                    <div class="alignleft"><input type="radio" name="rtp_post_comments[thumbnail_position]" value="None" id="None" <?php checked( 'None', $rtp_post_comments['thumbnail_position'] ); ?> /><label for="None"><?php _e( 'None', 'rtPanel' ); ?></label></div>
                    <div class="alignleft"><input type="radio" name="rtp_post_comments[thumbnail_position]" value="Left" id="Left" <?php checked( 'Left', $rtp_post_comments['thumbnail_position'] ); ?> /><label for="Left"><?php _e( 'Left', 'rtPanel' ); ?></label></div>
                    <div class="alignleft"><input type="radio" name="rtp_post_comments[thumbnail_position]" value="Right" id="Right" <?php checked( 'Right', $rtp_post_comments['thumbnail_position'] ); ?> /><label for="Right"><?php _e( 'Right', 'rtPanel' ); ?></label></div>
                    <div class="alignleft"><input type="radio" name="rtp_post_comments[thumbnail_position]" value="Center" id="Center" <?php checked( 'Center', $rtp_post_comments['thumbnail_position'] ); ?> /><label for="Center"><?php _e( 'Center', 'rtPanel' ); ?></label></div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_width"><?php _e( 'Width', 'rtPanel' ); ?></label></th>
                <td>
                    <input maxlength="3" type="number" value="<?php echo get_option( 'thumbnail_size_w' ); ?>" size="3" name="rtp_post_comments[thumbnail_width]" id="thumbnail_width" /> px
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_height"><?php _e( 'Height', 'rtPanel' ); ?></label></th>
                <td>
                    <input maxlength="3" type="number" value="<?php echo get_option( 'thumbnail_size_h' ); ?>" size="3" name="rtp_post_comments[thumbnail_height]" id="thumbnail_height" /> px
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_crop"><?php _e( 'Crop Thumbnail', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[thumbnail_crop]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[thumbnail_crop]" value="1" id="thumbnail_crop" <?php checked( get_option( 'thumbnail_crop' ) ); ?> />
                    <span class="description"><label for="thumbnail_crop"><?php _e( 'Crop thumbnail to exact dimensions (normally thumbnails are proportional)', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="thumbnail_frame"><?php _e( 'Add Frame (Border Effect around Image)', 'rtPanel' ); ?></label></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[thumbnail_frame]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[thumbnail_frame]" value="1" id="thumbnail_frame" <?php echo checked( $rtp_post_comments['thumbnail_frame'] ) ?> />
                    <span class="description"><label for="thumbnail_frame"><?php _e( 'Check this to display a light shadow border effect for the thumbnails', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
            <tr valign="top">
                <td colspan="2">
                    <strong><?php _e( 'Note', 'rtPanel' ); ?> : </strong><span class="description"><?php printf( __( 'If you make changes to thumbnail height, width or crop settings, you must use "<a target="_blank" href="%s" title="Regenerate Thumbnail Plugin">Regenerate Thumbnail Plugin</a>" to regenerate thumbnails on old posts.', 'rtPanel' ), rtp_regenerate_thumbnail_notice( true ) ); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Post Thumbnail Settings', 'rtPanel' ); ?>" name="rtp_thumbnail_reset" type="submit" />
        <div class="clear"></div>
    </div><?php
}

/**
 * Post Meta Settings Metabox - Post & Comments Tab
 *
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.0
 */
function rtp_post_meta_metabox() {
    global $rtp_post_comments;
    $date_format_u = ( $rtp_post_comments['post_date_format_u'] != 'F j, Y' && $rtp_post_comments['post_date_format_u'] != 'Y/m/d' && $rtp_post_comments['post_date_format_u'] != 'm/d/Y' && $rtp_post_comments['post_date_format_u'] != 'd/m/Y' ) ? true : false;
    $date_format_l = ( $rtp_post_comments['post_date_format_l'] != 'F j, Y' && $rtp_post_comments['post_date_format_l'] != 'Y/m/d' && $rtp_post_comments['post_date_format_l'] != 'm/d/Y' && $rtp_post_comments['post_date_format_l'] != 'd/m/Y' ) ? true : false;
    $args = array( '_builtin' => false );
    $taxonomies = get_taxonomies( $args, 'names' ); ?><br />
    <span class="description"><strong><?php _e( 'This option will allow you to specify the post meta attributes and their position', 'rtPanel' ); ?></strong></span><br /><br />
    <strong><?php _e( 'These Post Meta will be displayed above content', 'rtPanel' ); ?></strong>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><p><label for="post_date_u"><?php _e( 'Post Date', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[post_date_u]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[post_date_u]" value="1" id="post_date_u" <?php checked( $rtp_post_comments['post_date_u'] ); ?> />
                    <span class="description"><label for="post_date_u"><?php _e( 'Check this box to include Post Dates in meta', 'rtPanel' ); ?></label></span>
                    <div class="post-meta-common post_date_format_u">
                        <strong><?php _e( 'Select a Date Format', 'rtPanel' ); ?> :</strong><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_u]" id="full-date-u" value="F j, Y" <?php checked( 'F j, Y', $rtp_post_comments['post_date_format_u'] ); ?> /><label class="full-date-u" for="full-date-u" title="F j, Y"><?php echo date_i18n( __( 'F j, Y' ) ); ?></label><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_u]" id="y-m-d-u" value="Y/m/d" <?php checked( 'Y/m/d', $rtp_post_comments['post_date_format_u'] ); ?> /><label class="y-m-d-u" for="y-m-d-u" title="Y/m/d"><?php echo date_i18n( __( 'Y/m/d' ) ); ?></label><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_u]" id="m-d-y-u" value="m/d/Y" <?php checked( 'm/d/Y', $rtp_post_comments['post_date_format_u'] ); ?> /><label class="m-d-y-u" for="m-d-y-u" title="m/d/Y"><?php echo date_i18n( __( 'm/d/Y' ) ); ?></label><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_u]" id="d-m-y-u" value="d/m/Y" <?php checked( 'd/m/Y', $rtp_post_comments['post_date_format_u'] ); ?> /><label class="d-m-y-u" for="d-m-y-u" title="d/m/Y"><?php echo date_i18n( __( 'd/m/Y' ) ); ?></label><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_u]" id="post_date_custom_format_u" value="<?php echo esc_attr( $rtp_post_comments['post_date_custom_format_u'] ) ;  ?>" <?php checked( $date_format_u ); ?> /><label for="custom-date-u" title="<?php echo esc_attr( $rtp_post_comments['post_date_custom_format_u'] ); ?>">Custom :<input id="custom-date-u" value="<?php echo esc_attr( $rtp_post_comments['post_date_custom_format_u'] ) ; ?>" type="text" size="5" name="rtp_post_comments[post_date_custom_format_u]" /> <span><?php echo date_i18n( __( $rtp_post_comments['post_date_custom_format_u'] ) ); ?></span><img class="ajax-loading" alt="loading.." src="<?php echo admin_url( '/images/wpspin_light.gif' ); ?>" /></label><br />
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_author_u"><?php _e( 'Post Author', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[post_author_u]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[post_author_u]" value="1" id="post_author_u" <?php checked( $rtp_post_comments['post_author_u'] ); ?> />
                    <span class="description"><label for="post_author_u"><?php _e( 'Check this box to include Author Name in meta', 'rtPanel' ); ?></label></span>
                    <div class="post-meta-common post_author_u-sub">
                        <input type="hidden" name="rtp_post_comments[author_count_u]" value="0" />
                        <input type="checkbox" name="rtp_post_comments[author_count_u]" value="1" id="author_count_u" <?php checked( $rtp_post_comments['author_count_u'] ); ?> /><label for="author_count_u"><?php _e( 'Show Author Posts Count', 'rtPanel' ); ?></label><br />
                        <input type="hidden" name="rtp_post_comments[author_link_u]" value="0" />
                        <input type="checkbox" name="rtp_post_comments[author_link_u]" value="1" id="author_link_u" <?php checked( $rtp_post_comments['author_link_u'] ); ?> /><label for="author_link_u"><?php _e( 'Link to Author Archive page', 'rtPanel' ); ?></label><br />
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_category_u"><?php _e( 'Post Categories', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[post_category_u]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[post_category_u]" value="1" id="post_category_u" <?php checked( $rtp_post_comments['post_category_u'] ); ?> />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_tags_u"><?php _e( 'Post Tags', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[post_tags_u]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[post_tags_u]" value="1" id="post_tags_u" <?php checked( $rtp_post_comments['post_tags_u'] ); ?> />
                </td>
            </tr><?php
            if ( !empty( $taxonomies ) ) {
                foreach ( $taxonomies as $taxonomy ) { ?>
                    <tr valign="top">
                        <th scope="row"><p><label for="<?php echo 'post_' . $taxonomy . '_u'; ?>"><?php printf( __( 'Post %s', 'rtPanel' ), ucfirst( $taxonomy ) ); ?></label></p></th>
                        <td>
                            <input type="hidden" name="rtp_post_comments[<?php echo 'post_' . $taxonomy . '_u'; ?>]" value="0" />
                            <input type="checkbox" name="rtp_post_comments[<?php echo 'post_' . $taxonomy . '_u'; ?>]" value="1" id="<?php echo 'post_' . $taxonomy . '_u'; ?>" <?php checked( $rtp_post_comments['post_' . $taxonomy . '_u'] ); ?> />
                        </td>
                    </tr><?php
                }
            } ?>
        </tbody>
    </table>
    <br />
    <strong><?php _e( 'These Post Meta will be displayed below content', 'rtPanel' ); ?></strong>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><p><label for="post_date_l"><?php _e( 'Post Date', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[post_date_l]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[post_date_l]" value="1" id="post_date_l" <?php checked( $rtp_post_comments['post_date_l'] ); ?> />
                    <span class="description"><label for="post_date_l"><?php _e( 'Check this box to include Post Dates in meta', 'rtPanel' ); ?></label></span>
                    <div class="post-meta-common post_date_format_l">
                        <strong><?php _e( 'Select a Date Format', 'rtPanel' ); ?> :</strong><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_l]" id="full-date-l" value="F j, Y" <?php checked( 'F j, Y', $rtp_post_comments['post_date_format_l'] ); ?> /><label class="full-date-l" for="full-date-l" title="F j, Y"><?php echo date_i18n( __( 'F j, Y' ) ); ?></label><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_l]" id="y-m-d-l" value="Y/m/d" <?php checked( 'Y/m/d', $rtp_post_comments['post_date_format_l'] ); ?> /><label class="y-m-d-l" for="y-m-d-l" title="Y/m/d"><?php echo date_i18n( __( 'Y/m/d' ) ); ?></label><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_l]" id="m-d-y-l" value="m/d/Y" <?php checked( 'm/d/Y', $rtp_post_comments['post_date_format_l'] ); ?> /><label class="m-d-y-l" for="m-d-y-l" title="m/d/Y"><?php echo date_i18n( __( 'm/d/Y' ) ); ?></label><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_l]" id="d-m-y-l" value="d/m/Y" <?php checked( 'd/m/Y', $rtp_post_comments['post_date_format_l'] ); ?> /><label class="d-m-y-l" for="d-m-y-l" title="d/m/Y"><?php echo date_i18n( __( 'd/m/Y' ) ); ?></label><br />
                        <input type="radio" name="rtp_post_comments[post_date_format_l]" id="post_date_custom_format_l" value="<?php echo esc_attr( $rtp_post_comments['post_date_custom_format_l'] ) ;  ?>" <?php checked( $date_format_l ); ?> /><label for="custom-date-l" title="<?php echo esc_attr( $rtp_post_comments['post_date_custom_format_l'] ); ?>">Custom :<input id="custom-date-l" value="<?php echo esc_attr( $rtp_post_comments['post_date_custom_format_l'] ) ; ?>" type="text" size="5" name="rtp_post_comments[post_date_custom_format_l]" /> <span><?php echo date_i18n( __( $rtp_post_comments['post_date_custom_format_l'] ) ); ?></span><img class="ajax-loading" alt="loading.." src="<?php echo admin_url( '/images/wpspin_light.gif' ); ?>" /></label><br />
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_author_l"><?php _e( 'Post Author', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[post_author_l]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[post_author_l]" value="1" id="post_author_l" <?php checked( $rtp_post_comments['post_author_l'] ); ?> />
                    <span class="description"><label for="post_author_l"><?php _e( 'Check this box to include Author Name in meta', 'rtPanel' ); ?></label></span>
                    <div class="post-meta-common post_author_l-sub">
                        <input type="hidden" name="rtp_post_comments[author_count_l]" value="0" />
                        <input type="checkbox" name="rtp_post_comments[author_count_l]" value="1" id="author_count_l" <?php checked( $rtp_post_comments['author_count_l'] ); ?> /><label for="author_count_l"><?php _e( 'Show Author Posts Count', 'rtPanel' ); ?></label><br />
                        <input type="hidden" name="rtp_post_comments[author_link_l]" value="0" />
                        <input type="checkbox" name="rtp_post_comments[author_link_l]" value="1" id="author_link_l" <?php checked( $rtp_post_comments['author_link_l'] ); ?> /><label for="author_link_l"><?php _e( 'Link to Author Archive page', 'rtPanel' ); ?></label><br />
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_category_l"><?php _e( 'Post Categories', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[post_category_l]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[post_category_l]" value="1" id="post_category_l" <?php checked( $rtp_post_comments['post_category_l'] ); ?> />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><p><label for="post_tags_l"><?php _e( 'Post Tags', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[post_tags_l]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[post_tags_l]" value="1" id="post_tags_l" <?php checked( $rtp_post_comments['post_tags_l'] ); ?> />
                </td>
            </tr><?php
            if ( !empty( $taxonomies ) ) {
                foreach ( $taxonomies as $taxonomy ) { ?>
                    <tr valign="top">
                        <th scope="row"><p><label for="<?php echo 'post_' . $taxonomy . '_l'; ?>"><?php printf( __( 'Post %s', 'rtPanel' ), ucfirst( $taxonomy ) ); ?></label></p></th>
                        <td>
                            <input type="hidden" name="rtp_post_comments[<?php echo 'post_' . $taxonomy . '_l'; ?>]" value="0" />
                            <input type="checkbox" name="rtp_post_comments[<?php echo 'post_' . $taxonomy . '_l'; ?>]" value="1" id="<?php echo 'post_' . $taxonomy . '_l'; ?>" <?php checked( $rtp_post_comments['post_' . $taxonomy . '_l'] ); ?> />
                        </td>
                    </tr><?php
                }
            } ?>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Post Meta Settings', 'rtPanel' ); ?>" name="rtp_meta_reset" type="submit" />
        <div class="clear"></div>
    </div><?php
}

/**
 * Comment Form Settings Metabox - Post & Comments Tab
 *
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.0
 */
function rtp_comment_form_metabox() {
    global $rtp_post_comments; ?>
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><p><label for="compact_form"><?php _e( 'Enable Compact Form', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[compact_form]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[compact_form]" value="1" id="compact_form" <?php checked( $rtp_post_comments['compact_form'] ); ?> />
                    <span class="description"><label for="compact_form"><?php _e( 'Check this box to compact comment form. Name, URL & Email Fields will be on same line', 'rtPanel' ); ?></label></span>
                    <br />
                    <input type="hidden" name="rtp_post_comments[hide_labels]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[hide_labels]" value="1" id="hide_labels" <?php checked( $rtp_post_comments['hide_labels'] ); ?> />
                    <span class="description"><label for="hide_labels"><?php _e( 'Hide Labels for Name, Email, URL & Comment Textarea. These will be shown inside fields as default text', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
            <tr valign="top" class="show-fields-comments">
                <th scope="row"><p><label for="comment_textarea"><?php _e( 'Extra Settings', 'rtPanel' ); ?></label></p></th>
                <td>
                    <input type="hidden" name="rtp_post_comments[comment_textarea]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[comment_textarea]" value="1" id="comment_textarea" <?php checked( $rtp_post_comments['comment_textarea'] ); ?> />
                    <span class="description"><label for="comment_textarea"><?php _e( 'Display Comment textarea above Name, Email, &amp; URL Fields', 'rtPanel' ); ?></label></span>
                    <br />
                    <input type="hidden" name="rtp_post_comments[comment_separate]" value="0" />
                    <input type="checkbox" name="rtp_post_comments[comment_separate]" value="1" id="comment_separate" <?php checked( $rtp_post_comments['comment_separate'] ); ?> />
                    <span class="description"><label for="comment_separate"><?php _e( 'Separate Comments from Trackbacks &amp; Pingbacks', 'rtPanel' ); ?></label></span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="rtp_submit">
        <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
        <input class="button-secondary" value="<?php _e( 'Reset Comment Form Settings', 'rtPanel' ); ?>" name="rtp_comment_reset" type="submit" />
        <div class="clear"></div>
    </div><?php
}

/**
 * Gravatar Settings Metabox - Post & Comments Tab
 *
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.0
 */
function rtp_gravatar_metabox() {
    global $rtp_post_comments; ?>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><p><label for="gravatar_show"><?php _e( 'Enable Gravatar Support', 'rtPanel' ); ?></label></p></th>
                    <td>
                        <input type="hidden" name="rtp_post_comments[gravatar_show]" value="0" />
                        <input type="checkbox" name="rtp_post_comments[gravatar_show]" value="1" id="gravatar_show" <?php checked( $rtp_post_comments['gravatar_show'] ); ?> />
                    </td>
                </tr>
                <tr valign="top" class="gravatar-size">
                    <th scope="row"><p><label for="gravatar_size"><?php _e( 'Gravatar Size', 'rtPanel' ); ?></label></p></th>
                    <td>
                        <select name="rtp_post_comments[gravatar_size]" id="gravatar_size">
                            <option value="32" <?php selected( '32', $rtp_post_comments['gravatar_size'] ); ?>>32px X 32px</option>
                            <option value="40" <?php selected( '40', $rtp_post_comments['gravatar_size'] ); ?>>40px X 40px</option>
                            <option value="48" <?php selected( '48', $rtp_post_comments['gravatar_size'] ); ?>>48px X 48px</option>
                            <option value="56" <?php selected( '56', $rtp_post_comments['gravatar_size'] ); ?>>56px X 56px</option>
                            <option value="64" <?php selected( '64', $rtp_post_comments['gravatar_size'] ); ?>>64px X 64px</option>
                            <option value="96" <?php selected( '96', $rtp_post_comments['gravatar_size'] ); ?>>96px X 96px</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="rtp_submit">
            <input class="button-primary" value="<?php _e( 'Save All Changes', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
            <input class="button-secondary" value="<?php _e( 'Reset Gravatar Settings', 'rtPanel' ); ?>" name="rtp_gravatar_reset" type="submit" />
            <div class="clear"></div>
        </div><?php
}