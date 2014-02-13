<?php
/**
 * rtPanel options metaboxes
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */
/* Define plugin support constants */
define( 'RTP_SOCIAL', 'rtsocial/source.php' );
define( 'RTP_RTWIDGETS', 'rtwidgets/rtwidgets-main.php' );
define( 'RTP_HOOKS_EDITOR', 'rtpanel-hooks-editor/rtpanel-hooks-editor.php' );
define( 'RTP_SUBSCRIBE_TO_COMMENTS', 'subscribe-to-comments-reloaded/subscribe-to-comments-reloaded.php' );
define( 'RTP_YOAST_SEO', 'wordpress-seo/wp-seo.php' );
define( 'RTP_REGENERATE_THUMBNAILS', 'regenerate-thumbnails/regenerate-thumbnails.php' );
define( 'RTP_BUDDYPRESS', 'buddypress/bp-loader.php' );
define( 'RTP_BBPRESS', 'bbpress/bbpress.php' );
define( 'RTP_MEDIA', 'buddypress-media/index.php' );
define( 'RTP_CF7', 'contact-form-7/wp-contact-form-7.php' );
define( 'RTP_NINJA_FORM', 'ninja-forms/ninja-forms.php' );
define( 'RTP_WOOCOMMERCE', 'woocommerce/woocommerce.php' );
define( 'RTP_JETPACK', 'jetpack/jetpack.php' );
define( 'RTP_YARPP', 'yet-another-related-posts-plugin/yarpp.php' );

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
	global $rtp_general;
	$rtp_general[ 'logo_use' ]    = isset( $rtp_general[ 'logo_use' ] ) ? $rtp_general[ 'logo_use' ] : 'site_title';
	$rtp_general[ 'favicon_use' ] = isset( $rtp_general[ 'favicon_use' ] ) ? $rtp_general[ 'favicon_use' ] : 'disable';
	$logo_style                   = ( 'site_title' == $rtp_general[ 'logo_use' ] ) ? ' style="display: none"' : '';
	$favicon_style                = ( in_array( $rtp_general[ 'favicon_use' ], array( 'disable', 'logo' ) ) ) ? ' style="display: none"' : '';
	?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="logo_use"><?php _e( 'For Logo', 'rtPanel' ); ?></label></th>
				<td colspan="3">
					<div class="alignleft">
						<p style="margin-bottom: 10px;">
							<input type="radio" name="rtp_general[logo_use]" value="site_title" id="use_site_title" class="rtp_logo" <?php checked( 'site_title', $rtp_general[ 'logo_use' ] ); ?> />
							<label for="use_site_title" style="margin-right: 30px;"><?php _e( 'Use Site Title', 'rtPanel' ); ?></label>
							<input type="radio" name="rtp_general[logo_use]" value="image" id="use_logo_image" class="rtp_logo" <?php checked( 'image', $rtp_general[ 'logo_use' ] ); ?> />
							<label for="use_logo_image"><?php _e( 'Upload Logo', 'rtPanel' ); ?></label>
						</p>
						<input type="file" name="html-upload-logo" id="html-upload-logo"<?php echo $logo_style; ?>>
						<input type="hidden"  name="rtp_general[logo_upload]" id="logo_upload_url" value="<?php if ( isset( $rtp_general[ 'logo_upload' ] ) ) echo esc_attr( $rtp_general[ 'logo_upload' ] ); ?>" />
						<input type="hidden"  name="rtp_general[logo_id]" id="logo_id" value="<?php if ( isset( $rtp_general[ 'logo_id' ] ) ) echo esc_attr( $rtp_general[ 'logo_id' ] ); ?>" />
						<input type="hidden"  name="rtp_general[logo_width]" id="logo_width" value="<?php if ( isset( $rtp_general[ 'logo_width' ] ) ) echo esc_attr( $rtp_general[ 'logo_width' ] ); ?>" />
						<input type="hidden"  name="rtp_general[logo_height]" id="logo_height" value="<?php if ( isset( $rtp_general[ 'logo_height' ] ) ) echo esc_attr( $rtp_general[ 'logo_height' ] ); ?>" />
						<p class="login-head"<?php echo $logo_style; ?>>
							<input type="hidden" name="rtp_general[login_head]" value="0" />
							<input type="checkbox" name="rtp_general[login_head]" value="1" id="login_head" <?php checked( $rtp_general[ 'login_head' ] ); ?> />
							<span class="description"><label for="login_head"><?php printf( __( 'Check this box to display logo on <a href="%s" title="Wordpress Login">WordPress Login Screen</a>', 'rtPanel' ), site_url( '/wp-login.php' ) ); ?></label></span>
						</p>
					</div>
					<div class="image-preview alignright" id="logo_metabox"<?php echo $logo_style; ?>>
						<img alt="Logo" src="<?php echo esc_attr( $rtp_general[ 'logo_upload' ] ); ?>" />
					</div>
				</td>

			</tr>
			<tr valign="top">
				<th scope="row"><label for="favicon_use"><?php _e( 'For Favicon', 'rtPanel' ); ?></label></th>
				<td rowspan="3">
					<div class="alignleft">
						<p style="margin-bottom: 10px;"><input type="radio" name="rtp_general[favicon_use]" value="disable" id="favicon_disable" class="rtp_favicon" <?php checked( 'disable', $rtp_general[ 'favicon_use' ] ); ?> />
	                        <label for="favicon_disable" style="margin-right: 30px;"><?php _e( 'Disable', 'rtPanel' ); ?></label>
	                        <input type="radio" name="rtp_general[favicon_use]" value="logo" id="use_logo" class="rtp_favicon" <?php disabled( $rtp_general[ 'logo_use' ], 'site_title' );
	checked( 'logo', $rtp_general[ 'favicon_use' ] ); ?> />
	                        <label for="use_logo"  style="margin-right: 30px;"><?php _e( 'Resize Logo and use as Favicon', 'rtPanel' ); ?></label>
	                        <input type="radio" name="rtp_general[favicon_use]" value="image" id="use_favicon_image" class="rtp_favicon" <?php checked( 'image', $rtp_general[ 'favicon_use' ] ); ?> />
	                        <label for="use_favicon_image"><?php _e( 'Upload Favicon', 'rtPanel' ); ?></label></p>
						<input type="file" name="html-upload-fav" id="html-upload-fav"<?php echo $favicon_style; ?>>
						<input type="hidden"  name="rtp_general[favicon_upload]" id="favicon_upload_url" value="<?php if ( isset( $rtp_general[ 'favicon_upload' ] ) ) echo esc_attr( $rtp_general[ 'favicon_upload' ] ); ?>" />
						<input type="hidden"  name="rtp_general[favicon_id]" id="favicon_id" value="<?php if ( isset( $rtp_general[ 'favicon_id' ] ) ) echo esc_attr( $rtp_general[ 'favicon_id' ] ); ?>" />
					</div>
					<div class="image-preview alignright" id="favicon_metabox"<?php echo ( 'disable' == $rtp_general[ 'favicon_use' ] ) ? ' style="display: none"' : ''; ?>>
						<img alt="Favicon" src="<?php echo esc_attr( $rtp_general[ 'favicon_upload' ] ); ?>" />
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="rtp_submit">
	<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Logo & Favicon Settings', 'secondary', 'rtp_logo_favicon_reset', false ); ?>
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
	global $rtp_general;
	?>
	<table class="form-table">
		<tbody>
		<input type="hidden" name="rtp_general[buddypress_sidebar]" value="default-sidebar" /><?php if ( is_plugin_active( RTP_BUDDYPRESS ) ) { ?>
			<tr valign="top">
				<th scope="row"><label for="buddypress_sidebar"><?php _e( 'BuddyPress Sidebar', 'rtPanel' ); ?></label></th>
				<td>
					<select id="buddypress_sidebar" name="rtp_general[buddypress_sidebar]">
						<option <?php selected( $rtp_general[ 'buddypress_sidebar' ], 'default-sidebar' ); ?> value="default-sidebar"><?php _e( 'Default Sidebar', 'rtPanel' ); ?></option>
						<option <?php selected( $rtp_general[ 'buddypress_sidebar' ], 'buddypress-sidebar' ); ?> value="buddypress-sidebar"><?php _e( 'Enable BuddyPress Sidebar', 'rtPanel' ); ?></option>
						<option <?php selected( $rtp_general[ 'buddypress_sidebar' ], 'no-sidebar' ); ?> value="no-sidebar"><?php _e( 'Disable Sidebar', 'rtPanel' ); ?></option>
					</select>
				</td>
			</tr><?php }
	?>
		<input type="hidden" name="rtp_general[bbpress_sidebar]" value="default-sidebar" /><?php if ( is_plugin_active( RTP_BBPRESS ) ) { ?>
			<tr valign="top">
				<th scope="row"><label for="bbpress_sidebar"><?php _e( 'bbPress Sidebar', 'rtPanel' ); ?></label></th>
				<td>
					<select id="bbpress_sidebar" name="rtp_general[bbpress_sidebar]">
						<option <?php selected( $rtp_general[ 'bbpress_sidebar' ], 'default-sidebar' ); ?> value="default-sidebar"><?php _e( 'Default Sidebar', 'rtPanel' ); ?></option>
						<option <?php selected( $rtp_general[ 'bbpress_sidebar' ], 'bbpress-sidebar' ); ?> value="bbpress-sidebar"><?php _e( 'Enable bbPress Sidebar', 'rtPanel' ); ?></option>
						<option <?php selected( $rtp_general[ 'bbpress_sidebar' ], 'no-sidebar' ); ?> value="no-sidebar"><?php _e( 'Disable Sidebar', 'rtPanel' ); ?></option>
					</select>
				</td>
			</tr><?php }
	?>
		<tr valign="top">
			<th scope="row"><label for="footer_sidebar"><?php _e( 'Enable Footer Sidebar', 'rtPanel' ); ?></label></th>
			<td>
				<input type="hidden" name="rtp_general[footer_sidebar]" value="0" />
				<input type="checkbox" value="1" size="40" name="rtp_general[footer_sidebar]" id="footer_sidebar" <?php checked( $rtp_general[ 'footer_sidebar' ] ); ?> />
				<span class="description"><label for="footer_sidebar"><?php _e( 'Check this to enable footer sidebar', 'rtPanel' ); ?></label><br /></span>
			</td>
		</tr>
	</tbody>
	</table>
	<div class="rtp_submit">
		<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Sidebar Settings', 'secondary', 'rtp_sidebar_reset', false ); ?>
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
	global $rtp_general;
	?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="search_code"><?php _e( 'Google Custom Search Element Code', 'rtPanel' ); ?></label></th>
				<td>
					<textarea cols="80" rows="5" name="rtp_general[search_code]" id="search_code"><?php echo esc_textarea( $rtp_general[ 'search_code' ] ); ?></textarea><br />
					<label for="search_code"><span class="description"><?php printf( __( 'The Google Search Code Obtained by Default. You can obtain the Google Custom Search Code <a href="%s" title="Google Custom Search">here</a><br />', 'rtPanel' ), 'http://www.google.com/cse/' ); ?></span>
	                    <strong><?php _e( 'NOTE', 'rtPanel' ); ?>: </strong><span class="description"><?php _e( 'The hosting option must be "Search Element" and layout should be either "full-width" or "compact".', 'rtPanel' ); ?></span></label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="search_layout"><?php _e( 'Hide Sidebar', 'rtPanel' ); ?></label></th>
				<td>
					<input type="hidden" name="rtp_general[search_layout]" value="0" />
					<input type="checkbox" name="rtp_general[search_layout]" value="1" id="search_layout" <?php checked( $rtp_general[ 'search_layout' ] ); ?> />
					<span class="description"><label for="search_layout"><?php _e( 'Do not show sidebar on "Search Results" Page ( While using Google Custom Search )', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="rtp_submit">
	<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Google Custom Search Integration', 'secondary', 'rtp_google_reset', false ); ?>
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
	global $rtp_general;
	?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="custom_styles"><?php _e( 'Add your CSS here &rarr;', 'rtPanel' ); ?></label></th>
				<td>
					<textarea cols="80" rows="5" name="rtp_general[custom_styles]" id="custom_styles"><?php echo esc_textarea( $rtp_general[ 'custom_styles' ] ); ?></textarea><br />
					<span class="description"><label for="custom_styles"><?php _e( 'Add your extra CSS rules here. No need to use !important. Rules written above will be loaded last.', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="rtp_submit">
	<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Custom Styles', 'secondary', 'rtp_custom_styles_reset', false ); ?>
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
	$plugins					 = get_plugins();
	$rtp_hooks_editor_activate   = wp_create_nonce( RTP_HOOKS_EDITOR . '-activate' );
	$rtp_hooks_editor_deactivate = wp_create_nonce( RTP_HOOKS_EDITOR . '-deactivate' );
	$rtp_hooks_editor_delete     = wp_create_nonce( RTP_HOOKS_EDITOR . '-delete' );
	$rtp_social_activate		 = wp_create_nonce( RTP_SOCIAL . '-activate' );
	$rtp_social_deactivate		 = wp_create_nonce( RTP_SOCIAL . '-deactivate' );
	$rtp_social_delete			 = wp_create_nonce( RTP_SOCIAL . '-delete' );
	$subscribe_activate			 = wp_create_nonce( RTP_SUBSCRIBE_TO_COMMENTS . '-activate' );
	$subscribe_deactivate		 = wp_create_nonce( RTP_SUBSCRIBE_TO_COMMENTS . '-deactivate' );
	$subscribe_delete			 = wp_create_nonce( RTP_SUBSCRIBE_TO_COMMENTS . '-delete' );
	$yoast_seo_activate			 = wp_create_nonce( RTP_YOAST_SEO . '-activate' );
	$yoast_seo_deactivate		 = wp_create_nonce( RTP_YOAST_SEO . '-deactivate' );
	$yoast_seo_delete			 = wp_create_nonce( RTP_YOAST_SEO . '-delete' );
	$regenerate_activate		 = wp_create_nonce( RTP_REGENERATE_THUMBNAILS . '-activate' );
	$regenerate_deactivate		 = wp_create_nonce( RTP_REGENERATE_THUMBNAILS . '-deactivate' );
	$regenerate_delete			 = wp_create_nonce( RTP_REGENERATE_THUMBNAILS . '-delete' );
	$rtmedia_activate			 = wp_create_nonce( RTP_MEDIA . '-activate' );
	$rtmedia_deactivate			 = wp_create_nonce( RTP_MEDIA . '-deactivate' );
	$rtmedia_delete				 = wp_create_nonce( RTP_MEDIA . '-delete' );
	$rtp_bbpress_activate		 = wp_create_nonce( RTP_BBPRESS . '-activate' );
	$rtp_bbpress_deactivate		 = wp_create_nonce( RTP_BBPRESS . '-deactivate' );
	$rtp_bbpress_delete			 = wp_create_nonce( RTP_BBPRESS . '-delete' );
	$rtp_buddypress_activate     = wp_create_nonce( RTP_BUDDYPRESS . '-activate' );
	$rtp_buddypress_deactivate   = wp_create_nonce( RTP_BUDDYPRESS . '-deactivate' );
	$rtp_buddypress_delete		 = wp_create_nonce( RTP_BUDDYPRESS . '-delete' );
	$rtp_cf7_activate			 = wp_create_nonce( RTP_CF7 . '-activate' );
	$rtp_cf7_deactivate			 = wp_create_nonce( RTP_CF7 . '-deactivate' );
	$rtp_cf7_delete				 = wp_create_nonce( RTP_CF7 . '-delete' );
	$rtp_jetpack_activate		 = wp_create_nonce( RTP_JETPACK . '-activate' );
	$rtp_jetpack_deactivate		 = wp_create_nonce( RTP_JETPACK . '-deactivate' );
	$rtp_jetpack_delete			 = wp_create_nonce( RTP_JETPACK . '-delete' );
	$rtp_ninja_form_activate     = wp_create_nonce( RTP_NINJA_FORM . '-activate' );
	$rtp_ninja_form_deactivate   = wp_create_nonce( RTP_NINJA_FORM . '-deactivate' );
	$rtp_ninja_form_delete		 = wp_create_nonce( RTP_NINJA_FORM . '-delete' );
	$rtp_woocommerce_activate    = wp_create_nonce( RTP_WOOCOMMERCE . '-activate' );
	$rtp_woocommerce_deactivate	 = wp_create_nonce( RTP_WOOCOMMERCE . '-deactivate' );
	$rtp_woocommerce_delete		 = wp_create_nonce( RTP_WOOCOMMERCE . '-delete' );
	$rtp_yarpp_activate			 = wp_create_nonce( RTP_YARPP . '-activate' );
	$rtp_yarpp_deactivate		 = wp_create_nonce( RTP_YARPP . '-deactivate' );
	$rtp_yarpp_delete			 = wp_create_nonce( RTP_YARPP . '-delete' );
	$rtp_rtwidgets_activate		 = wp_create_nonce( RTP_RTWIDGETS . '-activate' );
	$rtp_rtwidgets_deactivate    = wp_create_nonce( RTP_RTWIDGETS . '-deactivate' );
	$rtp_rtwidgets_delete		 = wp_create_nonce( RTP_RTWIDGETS . '-delete' );
	?>

	<table class="form-table">
	<tr>
		<th><?php _e( 'Name', 'rtPanel' ); ?></th>
		<th><?php _e( 'Status', 'rtPanel' ); ?></th>
		<th><?php _e( 'Action', 'rtPanel' ); ?></th>
		<th><?php _e( 'Edit', 'rtPanel' ); ?></th>
	</tr>

	<!-- Start of bbPress Plugin -->
	<tr>
		<td><a target="_blank" href="http://wordpress.org/plugins/bbpress/"><?php _e( 'bbPress', 'rtPanel' ); ?></a></td>
		<td>
	<?php
	if ( is_plugin_active( RTP_BBPRESS ) ) {
			echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_BBPRESS, $plugins ) ) {
			echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
			echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
		<?php if ( is_plugin_active( RTP_BBPRESS ) ) { ?>
			<input type="hidden" value="<?php echo esc_attr( $rtp_bbpress_deactivate ); ?>" name="_wpnonce_bbpress_deactivate" id="_wpnonce_bbpress_deactivate" /><input id="bbpress-deactivate" type="hidden" name="bbpress-deactivate" value="0" /><a class="bbpress-deactivate" href="#bbpress-deactivate" onclick="deactivate_plugin( 'bbPress' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
		<?php } elseif ( array_key_exists( RTP_BBPRESS, $plugins ) ) { ?>
			<input type="hidden" value="<?php echo esc_attr( $rtp_bbpress_activate ); ?>" name="_wpnonce_bbpress_activate" id="_wpnonce_bbpress_activate" /><input id="bbpress-activate" type="hidden" name="bbpress-activate" value="0" /><a class="bbpress-activate" href="#bbpress-activate" onclick="activate_plugin( 'bbPress' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_bbpress_delete ); ?>" name="_wpnonce_bbpress_delete" id="_wpnonce_bbpress_delete" /><input id="bbpress-delete" type="hidden" name="bbpress-delete" value="0" /><a class="bbpress-delete" href="#bbpress-delete" onclick="delete_plugin_confirmation( 'bbPress' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
		<?php } else { ?>
			<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=bbpress' ), 'install-plugin_bbpress' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
		<?php } ?>
	</td>
	<td>
		<?php if ( is_plugin_active( RTP_BBPRESS ) || array_key_exists( RTP_BBPRESS, $plugins ) ) { ?>
			<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_BBPRESS ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
		<?php } else { ?>
				<span class="not-installed"> ----- </span>
		<?php } ?>
	</td>
	</tr>
	<!-- End of bbPress Plugin -->

	<!-- Start of BuddyPress Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/buddypress/"><?php _e( 'BuddyPress', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_BUDDYPRESS ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_BUDDYPRESS, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_BUDDYPRESS ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_buddypress_deactivate ); ?>" name="_wpnonce_buddypress_deactivate" id="_wpnonce_buddypress_deactivate" /><input id="buddypress-deactivate" type="hidden" name="buddypress-deactivate" value="0" /><a class="buddypress-deactivate" href="#buddypress-deactivate" onclick="deactivate_plugin( 'BuddyPress' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_BUDDYPRESS, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_buddypress_activate ); ?>" name="_wpnonce_buddypress_activate" id="_wpnonce_buddypress_activate" /><input id="buddypress-activate" type="hidden" name="buddypress-activate" value="0" /><a class="buddypress-activate" href="#buddypress-activate" onclick="activate_plugin( 'BuddyPress' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_buddypress_delete ); ?>" name="_wpnonce_buddypress_delete" id="_wpnonce_buddypress_delete" /><input id="buddypress-delete" type="hidden" name="buddypress-delete" value="0" /><a class="buddypress-delete" href="#buddypress-delete" onclick="delete_plugin_confirmation( 'BuddyPress' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=buddypress' ), 'install-plugin_buddypress' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_BUDDYPRESS ) || array_key_exists( RTP_BUDDYPRESS, $plugins ) ) { ?>
			<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_BUDDYPRESS ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
			<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of BuddyPress Plugin -->

	<!-- Start of Contact Form 7 Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/contact-form-7/"><?php _e( 'Contact Form 7', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_CF7 ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_CF7, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_CF7 ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_cf7_deactivate ); ?>" name="_wpnonce_cf7_deactivate" id="_wpnonce_cf7_deactivate" /><input id="cf7-deactivate" type="hidden" name="cf7-deactivate" value="0" /><a class="cf7-deactivate" href="#cf7-deactivate" onclick="deactivate_plugin( 'Contact Form 7' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_CF7, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_cf7_activate ); ?>" name="_wpnonce_cf7_activate" id="_wpnonce_cf7_activate" /><input id="cf7-activate" type="hidden" name="cf7-activate" value="0" /><a class="cf7-activate" href="#cf7-activate" onclick="activate_plugin( 'Contact Form 7' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_cf7_delete ); ?>" name="_wpnonce_cf7_delete" id="_wpnonce_cf7_delete" /><input id="cf7-delete" type="hidden" name="cf7-delete" value="0" /><a class="cf7-delete" href="#cf7-delete" onclick="delete_plugin_confirmation( 'Contact Form 7' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=contact-form-7' ), 'install-plugin_contact-form-7' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_CF7 ) || array_key_exists( RTP_CF7, $plugins ) ) { ?>
		<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_CF7 ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of Contact Form 7 Plugin -->

	<!-- Start of Jetpack by WordPress.com Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/jetpack/"><?php _e( 'Jetpack by WordPress.com', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_JETPACK ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_JETPACK, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_JETPACK ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_jetpack_deactivate ); ?>" name="_wpnonce_jetpack_deactivate" id="_wpnonce_jetpack_deactivate" /><input id="jetpack-deactivate" type="hidden" name="jetpack-deactivate" value="0" /><a class="jetpack-deactivate" href="#jetpack-deactivate" onclick="deactivate_plugin( 'Jetpack by WordPress.com' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_JETPACK, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_jetpack_activate ); ?>" name="_wpnonce_jetpack_activate" id="_wpnonce_jetpack_activate" /><input id="jetpack-activate" type="hidden" name="jetpack-activate" value="0" /><a class="jetpack-activate" href="#jetpack-activate" onclick="activate_plugin( 'Jetpack by WordPress.com' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_jetpack_delete ); ?>" name="_wpnonce_jetpack_delete" id="_wpnonce_jetpack_delete" /><input id="jetpack-delete" type="hidden" name="jetpack-delete" value="0" /><a class="jetpack-delete" href="#jetpack-delete" onclick="delete_plugin_confirmation( 'Jetpack by WordPress.com' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=jetpack' ), 'install-plugin_jetpack' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_JETPACK ) || array_key_exists( RTP_JETPACK, $plugins ) ) { ?>
		<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_JETPACK ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of Jetpack by WordPress.com Plugin -->

	<!-- Start of Ninja Forms Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/ninja-forms/"><?php _e( 'Ninja Forms', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_NINJA_FORM ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_NINJA_FORM, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_NINJA_FORM ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_ninja_form_deactivate ); ?>" name="_wpnonce_ninja_form_deactivate" id="_wpnonce_ninja_form_deactivate" /><input id="ninja_form-deactivate" type="hidden" name="ninja_form-deactivate" value="0" /><a class="ninja_form-deactivate" href="#ninja_form-deactivate" onclick="deactivate_plugin( 'Ninja Forms' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_NINJA_FORM, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_ninja_form_activate ); ?>" name="_wpnonce_ninja_form_activate" id="_wpnonce_ninja_form_activate" /><input id="ninja_form-activate" type="hidden" name="ninja_form-activate" value="0" /><a class="ninja_form-activate" href="#ninja_form-activate" onclick="activate_plugin( 'Ninja Forms' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_ninja_form_delete ); ?>" name="_wpnonce_ninja_form_delete" id="_wpnonce_ninja_form_delete" /><input id="ninja_form-delete" type="hidden" name="ninja_form-delete" value="0" /><a class="ninja_form-delete" href="#ninja_form-delete" onclick="delete_plugin_confirmation( 'Ninja Forms' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=ninja-forms' ), 'install-plugin_ninja-forms' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_NINJA_FORM ) || array_key_exists( RTP_NINJA_FORM, $plugins ) ) { ?>
		<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_NINJA_FORM ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of Ninja Forms Plugin -->

	<!-- Start of Regenerate Thumbnails Plugin -->
	<tr>
	<td><a href="http://wordpress.org/plugins/regenerate-thumbnails/"><?php _e( 'Regenerate Thumbnails', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_REGENERATE_THUMBNAILS ) ) {
		echo '<span class="active">Active</span>';
	} elseif ( array_key_exists( RTP_REGENERATE_THUMBNAILS, $plugins ) ) {
		echo '<span class="inactive">Inactive</span>';
	} else {
		echo '<span class="not-installed">Not Installed</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_REGENERATE_THUMBNAILS ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $regenerate_deactivate ); ?>" name="_wpnonce_regenerate_deactivate" id="_wpnonce_regenerate_deactivate" /><input id="regenerate-deactivate" type="hidden" name="regenerate-deactivate" value="0" /><a class="regenerate-deactivate" href="#regenerate-deactivate" onclick="deactivate_plugin( 'Regenerate Thumbnails' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_REGENERATE_THUMBNAILS, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $regenerate_activate ); ?>" name="_wpnonce_regenerate_activate" id="_wpnonce_regenerate_activate" /><input id="regenerate-activate" type="hidden" name="regenerate-activate" value="0" /><a class="regenerate-activate" href="#regenerate-activate" onclick="activate_plugin( 'Regenerate Thumbnails' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $regenerate_delete ); ?>" name="_wpnonce_regenerate_delete" id="_wpnonce_regenerate_delete" /><input id="regenerate-delete" type="hidden" name="regenerate-delete" value="0" /><a class="regenerate-delete" href="#regenerate-delete" onclick="delete_plugin_confirmation( 'Regenerate Thumbnails' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=regenerate-thumbnails' ), 'install-plugin_regenerate-thumbnails' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_REGENERATE_THUMBNAILS ) || array_key_exists( RTP_REGENERATE_THUMBNAILS, $plugins ) ) { ?>
			<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_REGENERATE_THUMBNAILS ); ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
			<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of Regenerate Thumbnails Plugin -->

	<!-- Start of rtMedia Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/buddypress-media/"><?php _e( 'rtMedia for WordPress, BuddyPress and bbPress', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_MEDIA ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_MEDIA, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_MEDIA ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtmedia_deactivate ); ?>" name="_wpnonce_rtmedia_deactivate" id="_wpnonce_rtmedia_deactivate" /><input id="rtmedia-deactivate" type="hidden" name="rtmedia-deactivate" value="0" /><a class="rtmedia-deactivate" href="#rtmedia-deactivate" onclick="deactivate_plugin( 'rtMedia for WordPress, BuddyPress and bbPress' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_MEDIA, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtmedia_activate ); ?>" name="_wpnonce_rtmedia_activate" id="_wpnonce_rtmedia_activate" /><input id="rtmedia-activate" type="hidden" name="rtmedia-activate" value="0" /><a class="rtmedia-activate" href="#rtmedia-activate" onclick="activate_plugin( 'rtMedia for WordPress, BuddyPress and bbPress' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtmedia_delete ); ?>" name="_wpnonce_rtmedia_delete" id="_wpnonce_rtmedia_delete" /><input id="rtmedia-delete" type="hidden" name="rtmedia-delete" value="0" /><a class="rtmedia-delete" href="#rtmedia-delete" onclick="delete_plugin_confirmation( 'rtMedia for WordPress, BuddyPress and bbPress' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=buddypress-media' ), 'install-plugin_buddypress-media' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_MEDIA ) || array_key_exists( RTP_MEDIA, $plugins ) ) { ?>
			<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_MEDIA ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
			<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of rtMedia Plugin -->

	<!-- Start of rtPanel Hooks Editor Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/rtpanel-hooks-editor/"><?php _e( 'rtPanel Hooks Editor', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_HOOKS_EDITOR ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_HOOKS_EDITOR, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_HOOKS_EDITOR ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_hooks_editor_deactivate ); ?>" name="_wpnonce_rtp_hooks_editor_deactivate" id="_wpnonce_rtp_hooks_editor_deactivate" /><input id="rtp-hooks-editor-deactivate" type="hidden" name="rtp-hooks-editor-deactivate" value="0" /><a class="rtp-hooks-editor-deactivate" href="#rtp-hooks-editor-deactivate" onclick="deactivate_plugin( 'rtPanel Hooks Editor' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_HOOKS_EDITOR, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_hooks_editor_activate ); ?>" name="_wpnonce_rtp_hooks_editor_activate" id="_wpnonce_rtp_hooks_editor_activate" /><input id="rtp-hooks-editor-activate" type="hidden" name="rtp-hooks-editor-activate" value="0" /><a class="rtp-hooks-editor-activate" href="#rtp-hooks-editor-activate" onclick="activate_plugin( 'rtPanel Hooks Editor' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_hooks_editor_delete ); ?>" name="_wpnonce_rtp_hooks_editor_delete" id="_wpnonce_rtp_hooks_editor_delete" /><input id="rtp-hooks-editor-delete" type="hidden" name="rtp-hooks-editor-delete" value="0" /><a class="rtp-hooks-editor-delete" href="#rtp-hooks-editor-delete" onclick="delete_plugin_confirmation( 'rtPanel Hooks Editor' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=rtpanel-hooks-editor' ), 'install-plugin_rtpanel-hooks-editor' ); ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_HOOKS_EDITOR ) || array_key_exists( RTP_HOOKS_EDITOR, $plugins ) ) { ?>
				<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_HOOKS_EDITOR ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
				<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of rtPanel Hooks Editor Plugin -->

	<!-- Start of rtSocial Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/rtsocial/"><?php _e( 'rtSocial', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_SOCIAL ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_SOCIAL, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_SOCIAL ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_social_deactivate ); ?>" name="_wpnonce_rtsocial_deactivate" id="_wpnonce_rtsocial_deactivate" /><input id="rtsocial-deactivate" type="hidden" name="rtsocial-deactivate" value="0" /><a class="rtsocial-deactivate" href="#rtsocial-deactivate" onclick="deactivate_plugin( 'rtSocial' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_SOCIAL, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_social_activate ); ?>" name="_wpnonce_rtsocial_activate" id="_wpnonce_rtsocial_activate" /><input id="rtsocial-activate" type="hidden" name="rtsocial-activate" value="0" /><a class="rtsocial-activate" href="#rtsocial-activate" onclick="activate_plugin( 'rtSocial' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_social_delete ); ?>" name="_wpnonce_rtsocial_delete" id="_wpnonce_rtsocial_delete" /><input id="rtsocial-delete" type="hidden" name="rtsocial-delete" value="0" /><a class="rtsocial-delete" href="#rtsocial-delete" onclick="delete_plugin_confirmation( 'rtSocial' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=rtsocial' ), 'install-plugin_rtsocial' ); ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_SOCIAL ) || array_key_exists( RTP_SOCIAL, $plugins ) ) { ?>
				<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_SOCIAL ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
				<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of rtSocial Plugin -->

	<!-- Start of rtWidgets Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/rtwidgets/"><?php _e( 'rtWidgets', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_RTWIDGETS ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_RTWIDGETS, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_RTWIDGETS ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_rtwidgets_deactivate ); ?>" name="_wpnonce_rtwidgets_deactivate" id="_wpnonce_rtwidgets_deactivate" /><input id="rtwidgets-deactivate" type="hidden" name="rtwidgets-deactivate" value="0" /><a class="rtwidgets-deactivate" href="#rtwidgets-deactivate" onclick="deactivate_plugin( 'rtWidgets' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_RTWIDGETS, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_rtwidgets_activate ); ?>" name="_wpnonce_rtwidgets_activate" id="_wpnonce_rtwidgets_activate" /><input id="rtwidgets-activate" type="hidden" name="rtwidgets-activate" value="0" /><a class="rtwidgets-activate" href="#rtwidgets-activate" onclick="activate_plugin( 'rtWidgets' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_rtwidgets_delete ); ?>" name="_wpnonce_rtwidgets_delete" id="_wpnonce_rtwidgets_delete" /><input id="rtwidgets-delete" type="hidden" name="rtwidgets-delete" value="0" /><a class="rtwidgets-delete" href="#rtwidgets-delete" onclick="delete_plugin_confirmation( 'rtWidgets' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=rtwidgets' ), 'install-plugin_rtwidgets' ); ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_RTWIDGETS ) || array_key_exists( RTP_RTWIDGETS, $plugins ) ) { ?>
				<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_RTWIDGETS ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
				<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of rtWidgets Plugin -->

	<!-- Start of Subscribe To Comments Reloaded Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/subscribe-to-comments-reloaded/"><?php _e( 'Subscribe To Comments Reloaded', 'rtPanel' ); ?></a></td>
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
		<input type="hidden" value="<?php echo esc_attr( $subscribe_deactivate ); ?>" name="_wpnonce_subscribe_deactivate" id="_wpnonce_subscribe_deactivate" /><input id="subscribe-deactivate" type="hidden" name="subscribe-deactivate" value="0" /><a class="subscribe-deactivate" href="#subscribe-deactivate" onclick="deactivate_plugin( 'Subscribe To Comments Reloaded' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_SUBSCRIBE_TO_COMMENTS, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $subscribe_activate ); ?>" name="_wpnonce_subscribe_activate" id="_wpnonce_subscribe_activate" /><input id="subscribe-activate" type="hidden" name="subscribe-activate" value="0" /><a class="subscribe-activate" href="#subscribe-activate" onclick="activate_plugin( 'Subscribe To Comments Reloaded' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $subscribe_delete ); ?>" name="_wpnonce_subscribe_delete" id="_wpnonce_subscribe_delete" /><input id="subscribe-delete" type="hidden" name="subscribe-delete" value="0" /><a class="subscribe-delete" href="#subscribe-delete" onclick="delete_plugin_confirmation( 'Subscribe To Comments Reloaded' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=subscribe-to-comments-reloaded' ), 'install-plugin_subscribe-to-comments-reloaded' ); ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
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
	<!-- End of Subscribe To Comments Reloaded Plugin -->

	<!-- Start of WooCommerce Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/woocommerce/"><?php _e( 'WooCommerce - excelling eCommerce', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_WOOCOMMERCE ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_WOOCOMMERCE, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_WOOCOMMERCE ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_woocommerce_deactivate ); ?>" name="_wpnonce_woocommerce_deactivate" id="_wpnonce_woocommerce_deactivate" /><input id="woocommerce-deactivate" type="hidden" name="woocommerce-deactivate" value="0" /><a class="woocommerce-deactivate" href="#woocommerce-deactivate" onclick="deactivate_plugin( 'WooCommerce - excelling eCommerce' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_WOOCOMMERCE, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_woocommerce_activate ); ?>" name="_wpnonce_woocommerce_activate" id="_wpnonce_woocommerce_activate" /><input id="woocommerce-activate" type="hidden" name="woocommerce-activate" value="0" /><a class="woocommerce-activate" href="#woocommerce-activate" onclick="activate_plugin( 'WooCommerce - excelling eCommerce' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_woocommerce_delete ); ?>" name="_wpnonce_woocommerce_delete" id="_wpnonce_woocommerce_delete" /><input id="woocommerce-delete" type="hidden" name="woocommerce-delete" value="0" /><a class="woocommerce-delete" href="#woocommerce-delete" onclick="delete_plugin_confirmation( 'WooCommerce - excelling eCommerce' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=woocommerce' ), 'install-plugin_woocommerce' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_WOOCOMMERCE ) || array_key_exists( RTP_WOOCOMMERCE, $plugins ) ) { ?>
				<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_WOOCOMMERCE ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
				<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of WooCommerce Plugin -->

	<!-- Start of WordPress SEO by Yoast Plugin -->
	<tr>
	<td><a target="_blank" href="http://wordpress.org/plugins/wordpress-seo/"><?php _e( 'WordPress SEO by Yoast', 'rtPanel' ); ?></a></td>
	<td>
	<?php
	if ( is_plugin_active( RTP_YOAST_SEO ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_YOAST_SEO, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_YOAST_SEO ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $yoast_seo_deactivate ); ?>" name="_wpnonce_yoast_seo_deactivate" id="_wpnonce_yoast_seo_deactivate" /><input id="yoast_seo-deactivate" type="hidden" name="yoast_seo-deactivate" value="0" /><a class="yoast_seo-deactivate" href="#yoast_seo-deactivate" onclick="deactivate_plugin( 'Yoast WordPress SEO' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_YOAST_SEO, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $yoast_seo_activate ); ?>" name="_wpnonce_yoast_seo_activate" id="_wpnonce_yoast_seo_activate" /><input id="yoast_seo-activate" type="hidden" name="yoast_seo-activate" value="0" /><a class="yoast_seo-activate" href="#yoast_seo-activate" onclick="activate_plugin( 'Yoast WordPress SEO' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $yoast_seo_delete ); ?>" name="_wpnonce_yoast_seo_delete" id="_wpnonce_yoast_seo_delete" /><input id="yoast_seo-delete" type="hidden" name="yoast_seo-delete" value="0" /><a class="yoast_seo-delete" href="#yoast_seo-delete" onclick="delete_plugin_confirmation( 'Yoast WordPress SEO' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=wordpress-seo' ), 'install-plugin_wordpress-seo' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td>
	<?php if ( is_plugin_active( RTP_YOAST_SEO ) || array_key_exists( RTP_YOAST_SEO, $plugins ) ) { ?>
				<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_YOAST_SEO ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
				<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of WordPress SEO by Yoast Plugin -->

	<!-- Start of Yet Another Related Posts Plugin (YARPP) Plugin -->
	<tr>
	<td class="last-child"><a target="_blank" href="http://wordpress.org/plugins/yet-another-related-posts-plugin/"><?php _e( 'Yet Another Related Posts Plugin (YARPP)', 'rtPanel' ); ?></a></td>
	<td class="last-child">
	<?php
	if ( is_plugin_active( RTP_YARPP ) ) {
		echo '<span class="active">' . __( 'Active', 'rtPanel' ) . '</span>';
	} elseif ( array_key_exists( RTP_YARPP, $plugins ) ) {
		echo '<span class="inactive">' . __( 'Inactive', 'rtPanel' ) . '</span>';
	} else {
		echo '<span class="not-installed">' . __( 'Not Installed', 'rtPanel' ) . '</span>';
	}
	?>
	</td>
	<td class="last-child">
	<?php if ( is_plugin_active( RTP_YARPP ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_yarpp_deactivate ); ?>" name="_wpnonce_yarpp_deactivate" id="_wpnonce_yarpp_deactivate" /><input id="yarpp-deactivate" type="hidden" name="yarpp-deactivate" value="0" /><a class="yarpp-deactivate" href="#yarpp-deactivate" onclick="deactivate_plugin( 'Yet Another Related Posts Plugin (YARPP)' )"><?php _e( 'Deactivate', 'rtPanel' ); ?></a>
	<?php } elseif ( array_key_exists( RTP_YARPP, $plugins ) ) { ?>
		<input type="hidden" value="<?php echo esc_attr( $rtp_yarpp_activate ); ?>" name="_wpnonce_yarpp_activate" id="_wpnonce_yarpp_activate" /><input id="yarpp-activate" type="hidden" name="yarpp-activate" value="0" /><a class="yarpp-activate" href="#yarpp-activate" onclick="activate_plugin( 'Yet Another Related Posts Plugin (YARPP)' )"><?php _e( 'Activate', 'rtPanel' ); ?></a> / <input type="hidden" value="<?php echo esc_attr( $rtp_yarpp_delete ); ?>" name="_wpnonce_yarpp_delete" id="_wpnonce_yarpp_delete" /><input id="yarpp-delete" type="hidden" name="yarpp-delete" value="0" /><a class="yarpp-delete" href="#yarpp-delete" onclick="delete_plugin_confirmation( 'Yet Another Related Posts Plugin (YARPP)' )"><?php _e( 'Delete', 'rtPanel' ); ?></a>
	<?php } else { ?>
		<a href="<?php echo wp_nonce_url( admin_url( 'update.php?action=install-plugin&amp;plugin=yet-another-related-posts-plugin' ), 'install-plugin_yet-another-related-posts-plugin' ) ?>"><?php _e( 'Install', 'rtPanel' ); ?></a>
	<?php } ?>
	</td>
	<td class="last-child">
	<?php if ( is_plugin_active( RTP_YARPP ) || array_key_exists( RTP_YARPP, $plugins ) ) { ?>
				<a href="<?php echo admin_url( 'plugin-editor.php?file=' . RTP_YARPP ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
	<?php } else { ?>
				<span class="not-installed"> ----- </span>
	<?php } ?>
	</td>
	</tr>
	<!-- End of Yet Another Related Posts Plugin (YARPP) Plugin -->

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
	?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th><label for="rtp_export"><?php _e( 'Export rtPanel Options', 'rtPanel' ); ?></label></th>
				<td>
					<?php submit_button( 'Export', 'secondary', 'rtp_export', false ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th><label for="rtp_import"><?php _e( 'Import rtPanel Options', 'rtPanel' ); ?></label></th>
				<td>
	                <input type="file" id="rtp_import" name="rtp_import" />
					<?php submit_button( 'Import', 'secondary', 'rtp_import', false ); ?>
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
	global $rtp_post_comments;
	?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="summary_show"><?php _e( 'Enable Summary', 'rtPanel' ); ?></label></th>
				<td>
					<input type="hidden" name="rtp_post_comments[summary_show]" value="0" />
					<input type="checkbox" name="rtp_post_comments[summary_show]" value="1" id="summary_show" <?php checked( $rtp_post_comments[ 'summary_show' ] ); ?> />
					<span class="description"><label for="summary_show"><?php _e( 'Check this to enable excerpts on Archive pages ( Pages with multiple posts on them )', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="word_limit"><?php _e( 'Word Limit', 'rtPanel' ); ?></label></th>
				<td>
					<input  maxlength="4" type="number" value="<?php echo esc_attr( $rtp_post_comments[ 'word_limit' ] ); ?>" size="4" name="rtp_post_comments[word_limit]" id="word_limit" />
					<span class="description"><label for="word_limit"><?php _e( 'Post Content will be cut around Word Limit you will specify here.', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="read_text"><?php _e( 'Read More &rarr;', 'rtPanel' ); ?></label></th>
				<td>
					<input type="text" value="<?php echo esc_attr( $rtp_post_comments[ 'read_text' ] ); ?>" size="30" name="rtp_post_comments[read_text]" id="read_text" />
					<span class="description"><label for="read_text"><?php _e( 'This will be added after each post summary. Text added here will be automatically converted into a hyperlink pointing to the respective post.', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="rtp_submit">
	<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Post Sumarry Settings', 'secondary', 'rtp_summary_reset', false ); ?>
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
	?> 
	<br />
	<span class="description post-summary-hide"><strong><?php _e( 'Enable Summary must be checked on the Post Summary Settings to show these Options', 'rtPanel' ); ?></strong></span>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="thumbnail_show"><?php _e( 'Enable Thumbnails', 'rtPanel' ); ?></label></th>
				<td>
					<input type="hidden" name="rtp_post_comments[thumbnail_show]" value="0" />
					<input type="checkbox" name="rtp_post_comments[thumbnail_show]" value="1" id="thumbnail_show" <?php checked( $rtp_post_comments[ 'thumbnail_show' ] ); ?> />
					<span class="description"><label for="thumbnail_show"><?php _e( 'Check this to display thumbnails as part of Post Summaries on Archive pages', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label><?php _e( 'Thumbnail Alignment', 'rtPanel' ); ?></label></th>
				<td>
					<div class="alignleft"><input type="radio" name="rtp_post_comments[thumbnail_position]" value="None" id="None" <?php checked( 'None', $rtp_post_comments[ 'thumbnail_position' ] ); ?> /><label for="None"><?php _e( 'None', 'rtPanel' ); ?></label></div>
					<div class="alignleft"><input type="radio" name="rtp_post_comments[thumbnail_position]" value="Left" id="Left" <?php checked( 'Left', $rtp_post_comments[ 'thumbnail_position' ] ); ?> /><label for="Left"><?php _e( 'Left', 'rtPanel' ); ?></label></div>
					<div class="alignleft"><input type="radio" name="rtp_post_comments[thumbnail_position]" value="Right" id="Right" <?php checked( 'Right', $rtp_post_comments[ 'thumbnail_position' ] ); ?> /><label for="Right"><?php _e( 'Right', 'rtPanel' ); ?></label></div>
					<div class="alignleft"><input type="radio" name="rtp_post_comments[thumbnail_position]" value="Center" id="Center" <?php checked( 'Center', $rtp_post_comments[ 'thumbnail_position' ] ); ?> /><label for="Center"><?php _e( 'Center', 'rtPanel' ); ?></label></div>
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
					<input type="checkbox" name="rtp_post_comments[thumbnail_frame]" value="1" id="thumbnail_frame" <?php echo checked( $rtp_post_comments[ 'thumbnail_frame' ] ) ?> />
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
	<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Post Thumbnail Settings', 'secondary', 'rtp_thumbnail_reset', false ); ?>
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
	$date_format_u   = ( $rtp_post_comments[ 'post_date_format_u' ] != 'F j, Y' && $rtp_post_comments[ 'post_date_format_u' ] != 'Y/m/d' && $rtp_post_comments[ 'post_date_format_u' ] != 'm/d/Y' && $rtp_post_comments[ 'post_date_format_u' ] != 'd/m/Y' ) ? true : false;
	$date_format_l   = ( $rtp_post_comments[ 'post_date_format_l' ] != 'F j, Y' && $rtp_post_comments[ 'post_date_format_l' ] != 'Y/m/d' && $rtp_post_comments[ 'post_date_format_l' ] != 'm/d/Y' && $rtp_post_comments[ 'post_date_format_l' ] != 'd/m/Y' ) ? true : false;
	$args            = array( '_builtin' => false );
	$taxonomies      = get_taxonomies( $args, 'objects' );
	?><br />
	<span class="description"><strong><?php _e( 'This option will allow you to specify the post meta attributes and their position', 'rtPanel' ); ?></strong></span><br /><br />
	<strong><?php _e( 'These Post Meta will be displayed above content', 'rtPanel' ); ?></strong>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><p><label for="post_date_u"><?php _e( 'Post Date', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[post_date_u]" value="0" />
		<input type="checkbox" name="rtp_post_comments[post_date_u]" value="1" id="post_date_u" <?php checked( $rtp_post_comments[ 'post_date_u' ] ); ?> />
		<span class="description"><label for="post_date_u"><?php _e( 'Check this box to include Post Dates in meta', 'rtPanel' ); ?></label></span>
		<div class="post-meta-common post_date_format_u">
			<strong><?php _e( 'Select a Date Format', 'rtPanel' ); ?> :</strong><br />
			<input type="radio" name="rtp_post_comments[post_date_format_u]" id="full-date-u" value="F j, Y" <?php checked( 'F j, Y', $rtp_post_comments[ 'post_date_format_u' ] ); ?> /><label class="full-date-u" for="full-date-u" title="F j, Y"><?php echo date_i18n( __( 'F j, Y', 'rtPanel' ) ); ?></label><br />
			<input type="radio" name="rtp_post_comments[post_date_format_u]" id="y-m-d-u" value="Y/m/d" <?php checked( 'Y/m/d', $rtp_post_comments[ 'post_date_format_u' ] ); ?> /><label class="y-m-d-u" for="y-m-d-u" title="Y/m/d"><?php echo date_i18n( __( 'Y/m/d', 'rtPanel' ) ); ?></label><br />
			<input type="radio" name="rtp_post_comments[post_date_format_u]" id="m-d-y-u" value="m/d/Y" <?php checked( 'm/d/Y', $rtp_post_comments[ 'post_date_format_u' ] ); ?> /><label class="m-d-y-u" for="m-d-y-u" title="m/d/Y"><?php echo date_i18n( __( 'm/d/Y', 'rtPanel' ) ); ?></label><br />
			<input type="radio" name="rtp_post_comments[post_date_format_u]" id="d-m-y-u" value="d/m/Y" <?php checked( 'd/m/Y', $rtp_post_comments[ 'post_date_format_u' ] ); ?> /><label class="d-m-y-u" for="d-m-y-u" title="d/m/Y"><?php echo date_i18n( __( 'd/m/Y', 'rtPanel' ) ); ?></label><br />
			<input type="radio" name="rtp_post_comments[post_date_format_u]" id="post_date_custom_format_u" value="<?php echo esc_attr( $rtp_post_comments[ 'post_date_custom_format_u' ] ); ?>" <?php checked( $date_format_u ); ?> /><label for="custom-date-u" title="<?php echo esc_attr( $rtp_post_comments[ 'post_date_custom_format_u' ] ); ?>">Custom :<input id="custom-date-u" value="<?php echo esc_attr( $rtp_post_comments[ 'post_date_custom_format_u' ] ); ?>" type="text" size="5" name="rtp_post_comments[post_date_custom_format_u]" /> <span><?php echo date_i18n( $rtp_post_comments[ 'post_date_custom_format_u' ] ); ?></span><img class="ajax-loading" alt="loading.." src="<?php echo admin_url( '/images/wpspin_light.gif' ); ?>" /></label><br />
		</div>
	</td>
	</tr>
	<tr valign="top">
		<th scope="row"><p><label for="post_author_u"><?php _e( 'Post Author', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[post_author_u]" value="0" />
		<input type="checkbox" name="rtp_post_comments[post_author_u]" value="1" id="post_author_u" <?php checked( $rtp_post_comments[ 'post_author_u' ] ); ?> />
		<span class="description"><label for="post_author_u"><?php _e( 'Check this box to include Author Name in meta', 'rtPanel' ); ?></label></span>
		<div class="post-meta-common post_author_u-sub">
			<input type="hidden" name="rtp_post_comments[author_count_u]" value="0" />
			<input type="checkbox" name="rtp_post_comments[author_count_u]" value="1" id="author_count_u" <?php checked( $rtp_post_comments[ 'author_count_u' ] ); ?> /><label for="author_count_u"><?php _e( 'Show Author Posts Count', 'rtPanel' ); ?></label><br />
			<input type="hidden" name="rtp_post_comments[author_link_u]" value="0" />
			<input type="checkbox" name="rtp_post_comments[author_link_u]" value="1" id="author_link_u" <?php checked( $rtp_post_comments[ 'author_link_u' ] ); ?> /><label for="author_link_u"><?php _e( 'Link to Author Archive page', 'rtPanel' ); ?></label><br />
		</div>
	</td>
	</tr>
	<tr valign="top">
		<th scope="row"><p><label for="post_category_u"><?php _e( 'Post Categories', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[post_category_u]" value="0" />
		<input type="checkbox" name="rtp_post_comments[post_category_u]" value="1" id="post_category_u" <?php checked( $rtp_post_comments[ 'post_category_u' ] ); ?> />
	</td>
	</tr>
	<tr valign="top">
		<th scope="row"><p><label for="post_tags_u"><?php _e( 'Post Tags', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[post_tags_u]" value="0" />
		<input type="checkbox" name="rtp_post_comments[post_tags_u]" value="1" id="post_tags_u" <?php checked( $rtp_post_comments[ 'post_tags_u' ] ); ?> />
	</td>
	</tr><?php
	if ( ! empty( $taxonomies ) ) {
		foreach ( $taxonomies as $key => $taxonomy ) {
			$rtp_post_comments[ 'post_' . $key . '_u' ] = ( isset( $rtp_post_comments[ 'post_' . $key . '_u' ] ) ) ? $rtp_post_comments[ 'post_' . $key . '_u' ] : 0;
			?>
			<tr valign="top">
				<th scope="row"><p><label for="<?php echo 'post_' . $key . '_u'; ?>"><?php printf( __( '%s', 'rtPanel' ), $taxonomy->labels->name ); ?></label></p></th>
			<td>
				<input type="hidden" name="rtp_post_comments[<?php echo 'post_' . $key . '_u'; ?>]" value="0" />
				<input type="checkbox" name="rtp_post_comments[<?php echo 'post_' . $key . '_u'; ?>]" value="1" id="<?php echo 'post_' . $key . '_u'; ?>" <?php checked( $rtp_post_comments[ 'post_' . $key . '_u' ] ); ?> />
			</td>
			</tr><?php
		}
	}
	?>
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
		<input type="checkbox" name="rtp_post_comments[post_date_l]" value="1" id="post_date_l" <?php checked( $rtp_post_comments[ 'post_date_l' ] ); ?> />
		<span class="description"><label for="post_date_l"><?php _e( 'Check this box to include Post Dates in meta', 'rtPanel' ); ?></label></span>
		<div class="post-meta-common post_date_format_l">
			<strong><?php _e( 'Select a Date Format', 'rtPanel' ); ?> :</strong><br />
			<input type="radio" name="rtp_post_comments[post_date_format_l]" id="full-date-l" value="F j, Y" <?php checked( 'F j, Y', $rtp_post_comments[ 'post_date_format_l' ] ); ?> /><label class="full-date-l" for="full-date-l" title="F j, Y"><?php echo date_i18n( __( 'F j, Y', 'rtPanel' ) ); ?></label><br />
			<input type="radio" name="rtp_post_comments[post_date_format_l]" id="y-m-d-l" value="Y/m/d" <?php checked( 'Y/m/d', $rtp_post_comments[ 'post_date_format_l' ] ); ?> /><label class="y-m-d-l" for="y-m-d-l" title="Y/m/d"><?php echo date_i18n( __( 'Y/m/d', 'rtPanel' ) ); ?></label><br />
			<input type="radio" name="rtp_post_comments[post_date_format_l]" id="m-d-y-l" value="m/d/Y" <?php checked( 'm/d/Y', $rtp_post_comments[ 'post_date_format_l' ] ); ?> /><label class="m-d-y-l" for="m-d-y-l" title="m/d/Y"><?php echo date_i18n( __( 'm/d/Y', 'rtPanel' ) ); ?></label><br />
			<input type="radio" name="rtp_post_comments[post_date_format_l]" id="d-m-y-l" value="d/m/Y" <?php checked( 'd/m/Y', $rtp_post_comments[ 'post_date_format_l' ] ); ?> /><label class="d-m-y-l" for="d-m-y-l" title="d/m/Y"><?php echo date_i18n( __( 'd/m/Y', 'rtPanel' ) ); ?></label><br />
			<input type="radio" name="rtp_post_comments[post_date_format_l]" id="post_date_custom_format_l" value="<?php echo esc_attr( $rtp_post_comments[ 'post_date_custom_format_l' ] ); ?>" <?php checked( $date_format_l ); ?> /><label for="custom-date-l" title="<?php echo esc_attr( $rtp_post_comments[ 'post_date_custom_format_l' ] ); ?>">Custom :<input id="custom-date-l" value="<?php echo esc_attr( $rtp_post_comments[ 'post_date_custom_format_l' ] ); ?>" type="text" size="5" name="rtp_post_comments[post_date_custom_format_l]" /> <span><?php echo date_i18n( $rtp_post_comments[ 'post_date_custom_format_l' ] ); ?></span><img class="ajax-loading" alt="loading.." src="<?php echo admin_url( '/images/wpspin_light.gif' ); ?>" /></label><br />
		</div>
	</td>
	</tr>
	<tr valign="top">
		<th scope="row"><p><label for="post_author_l"><?php _e( 'Post Author', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[post_author_l]" value="0" />
		<input type="checkbox" name="rtp_post_comments[post_author_l]" value="1" id="post_author_l" <?php checked( $rtp_post_comments[ 'post_author_l' ] ); ?> />
		<span class="description"><label for="post_author_l"><?php _e( 'Check this box to include Author Name in meta', 'rtPanel' ); ?></label></span>
		<div class="post-meta-common post_author_l-sub">
			<input type="hidden" name="rtp_post_comments[author_count_l]" value="0" />
			<input type="checkbox" name="rtp_post_comments[author_count_l]" value="1" id="author_count_l" <?php checked( $rtp_post_comments[ 'author_count_l' ] ); ?> /><label for="author_count_l"><?php _e( 'Show Author Posts Count', 'rtPanel' ); ?></label><br />
			<input type="hidden" name="rtp_post_comments[author_link_l]" value="0" />
			<input type="checkbox" name="rtp_post_comments[author_link_l]" value="1" id="author_link_l" <?php checked( $rtp_post_comments[ 'author_link_l' ] ); ?> /><label for="author_link_l"><?php _e( 'Link to Author Archive page', 'rtPanel' ); ?></label><br />
		</div>
	</td>
	</tr>
	<tr valign="top">
		<th scope="row"><p><label for="post_category_l"><?php _e( 'Post Categories', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[post_category_l]" value="0" />
		<input type="checkbox" name="rtp_post_comments[post_category_l]" value="1" id="post_category_l" <?php checked( $rtp_post_comments[ 'post_category_l' ] ); ?> />
	</td>
	</tr>
	<tr valign="top">
		<th scope="row"><p><label for="post_tags_l"><?php _e( 'Post Tags', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[post_tags_l]" value="0" />
		<input type="checkbox" name="rtp_post_comments[post_tags_l]" value="1" id="post_tags_l" <?php checked( $rtp_post_comments[ 'post_tags_l' ] ); ?> />
	</td>
	</tr><?php
	if ( ! empty( $taxonomies ) ) {
		foreach ( $taxonomies as $key => $taxonomy ) {
			$rtp_post_comments[ 'post_' . $key . '_l' ] = ( isset( $rtp_post_comments[ 'post_' . $key . '_l' ] ) ) ? $rtp_post_comments[ 'post_' . $key . '_l' ] : 0;
			?>
			<tr valign="top">
				<th scope="row"><p><label for="<?php echo 'post_' . $key . '_l'; ?>"><?php printf( __( '%s', 'rtPanel' ), $taxonomy->labels->name ); ?></label></p></th>
			<td>
				<input type="hidden" name="rtp_post_comments[<?php echo 'post_' . $key . '_l'; ?>]" value="0" />
				<input type="checkbox" name="rtp_post_comments[<?php echo 'post_' . $key . '_l'; ?>]" value="1" id="<?php echo 'post_' . $key . '_l'; ?>" <?php checked( $rtp_post_comments[ 'post_' . $key . '_l' ] ); ?> />
			</td>
			</tr><?php
		}
	}
	?>
	</tbody>
	</table>
	<div class="rtp_submit">
	<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Post Meta Settings', 'secondary', 'rtp_meta_reset', false ); ?>
		<div class="clear"></div>
	</div><?php
}

/**
 * Pagination Settings Metabox - Post & Comments Tab
 * 
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.1
 */
function rtp_pagination_metabox() {
	global $rtp_post_comments;
	?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="pagination_show"><?php _e( 'Enable Pagination', 'rtPanel' ); ?></label></th>
				<td>
					<input type="hidden" name="rtp_post_comments[pagination_show]" value="0" />
					<input type="checkbox" name="rtp_post_comments[pagination_show]" value="1" id="pagination_show" <?php checked( $rtp_post_comments[ 'pagination_show' ] ); ?> />
					<span class="description"><label for="pagination_show"><?php _e( 'Check this to enable default WordPress Pagination on Archive pages ( Pages with multiple posts on them )', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="prev_text"><?php _e( 'Prev Text', 'rtPanel' ); ?></label></th>
				<td>
					<input type="text" value="<?php echo esc_attr( $rtp_post_comments[ 'prev_text' ] ); ?>" size="30" name="rtp_post_comments[prev_text]" id="prev_text" />
					<span class="description"><label for="prev_text"><?php _e( 'Text to display for Previous Page', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="next_text"><?php _e( 'Next Text', 'rtPanel' ); ?></label></th>
				<td>
					<input type="text" value="<?php echo esc_attr( $rtp_post_comments[ 'next_text' ] ); ?>" size="30" name="rtp_post_comments[next_text]" id="next_text" />
					<span class="description"><label for="next_text"><?php _e( 'Text to display for Next Page', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="end_size"><?php _e( 'End Size', 'rtPanel' ); ?></label></th>
				<td>
					<input  maxlength="4" type="number" value="<?php echo esc_attr( $rtp_post_comments[ 'end_size' ] ); ?>" size="4" name="rtp_post_comments[end_size]" id="end_size" />
					<span class="description"><label for="end_size"><?php _e( 'How many numbers on either the start and the end list edges?', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mid_size"><?php _e( 'Mid Size', 'rtPanel' ); ?></label></th>
				<td>
					<input  maxlength="4" type="number" value="<?php echo esc_attr( $rtp_post_comments[ 'mid_size' ] ); ?>" size="4" name="rtp_post_comments[mid_size]" id="mid_size" />
					<span class="description"><label for="mid_size"><?php _e( 'How many numbers to either side of current page, but not including current page?', 'rtPanel' ); ?></label></span>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="rtp_submit">
	<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Pagination Settings', 'secondary', 'rtp_pagination_reset', false ); ?>
		<div class="clear"></div>
	</div><?php
}

/**
 * Comment Settings Metabox - Post & Comments Tab
 *
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.0
 */
function rtp_comment_form_metabox() {
	global $rtp_post_comments;
	?>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><p><label for="gravatar_show"><?php _e( 'Enable Gravatar', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[gravatar_show]" value="0" />
		<input type="checkbox" name="rtp_post_comments[gravatar_show]" value="1" id="gravatar_show" <?php checked( $rtp_post_comments[ 'gravatar_show' ] ); ?> />
	</td>
	</tr>
	<tr valign="top">
		<th scope="row"><p><label for="compact_form"><?php _e( 'Enable Compact Form', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[compact_form]" value="0" />
		<input type="checkbox" name="rtp_post_comments[compact_form]" value="1" id="compact_form" <?php checked( $rtp_post_comments[ 'compact_form' ] ); ?> />
		<span class="description"><label for="compact_form"><?php _e( 'Check this box to compact comment form. Name, URL & Email Fields will be on same line', 'rtPanel' ); ?></label></span>
		<br />
		<input type="hidden" name="rtp_post_comments[hide_labels]" value="0" />
		<input type="checkbox" name="rtp_post_comments[hide_labels]" value="1" id="hide_labels" <?php checked( $rtp_post_comments[ 'hide_labels' ] ); ?> />
		<span class="description"><label for="hide_labels"><?php _e( 'Hide Labels for Name, Email & URL. These will be shown inside fields as default text', 'rtPanel' ); ?></label></span>
	</td>
	</tr>
	<tr valign="top" class="show-fields-comments">
		<th scope="row"><p><label for="comment_textarea"><?php _e( 'Extra Settings', 'rtPanel' ); ?></label></p></th>
	<td>
		<input type="hidden" name="rtp_post_comments[comment_textarea]" value="0" />
		<input type="checkbox" name="rtp_post_comments[comment_textarea]" value="1" id="comment_textarea" <?php checked( $rtp_post_comments[ 'comment_textarea' ] ); ?> />
		<span class="description"><label for="comment_textarea"><?php _e( 'Display Comment textarea above Name, Email, &amp; URL Fields', 'rtPanel' ); ?></label></span>
		<br />
		<input type="hidden" name="rtp_post_comments[comment_separate]" value="0" />
		<input type="checkbox" name="rtp_post_comments[comment_separate]" value="1" id="comment_separate" <?php checked( $rtp_post_comments[ 'comment_separate' ] ); ?> />
		<span class="description"><label for="comment_separate"><?php _e( 'Separate Comments from Trackbacks &amp; Pingbacks', 'rtPanel' ); ?></label></span>
		<br />
		<input type="hidden" name="rtp_post_comments[attachment_comments]" value="0" />
		<input type="checkbox" name="rtp_post_comments[attachment_comments]" value="1" id="attachment_comments" <?php checked( $rtp_post_comments[ 'attachment_comments' ] ); ?> />
		<span class="description"><label for="attachment_comments"><?php _e( 'Enable the comment form on Attachments', 'rtPanel' ); ?></label></span>
	</td>
	</tr>
	</tbody>
	</table>
	<div class="rtp_submit">
	<?php submit_button( 'Save All Changes', 'primary', 'rtp_submit', false ); ?>
	<?php submit_button( 'Reset Comment Settings', 'secondary', 'rtp_comment_reset', false ); ?>
		<div class="clear"></div>
	</div><?php
}
