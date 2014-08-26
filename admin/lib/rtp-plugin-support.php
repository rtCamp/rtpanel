<?php

/**
 * Supported Plugin List
 */
function rtp_install_plugin_manage_hook() {
	if ( current_user_can( 'install_plugins' ) ) {
		add_action( 'wp_ajax_rtpanel_plugin_manage', 'rtpanel_manage_plugin' );
	}
}

add_action( 'admin_init', 'rtp_install_plugin_manage_hook' );

/**
 * Plugins Page Content
 */
global $rtp_support_plugins;

$rtp_support_plugins = array(
	'bbpress' => array(
		'title' => 'bbPress',
		'plugin_path' => 'bbpress/bbpress.php',
		'plugin_link' => '//wordpress.org/plugins/bbpress/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'buddypress' => array(
		'title' => 'BuddyPress',
		'plugin_path' => 'buddypress/bp-loader.php',
		'plugin_link' => '//wordpress.org/plugins/buddypress/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'buddypress-docs' => array(
		'title' => 'BuddyPress Docs',
		'plugin_path' => 'buddypress-docs/loader.php',
		'plugin_link' => '//wordpress.org/plugins/buddypress-docs/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'contact-form-7' => array(
		'title' => 'Contact Form 7',
		'plugin_path' => 'contact-form-7/wp-contact-form-7.php',
		'plugin_link' => '//wordpress.org/plugins/contact-form-7/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'jetpack' => array(
		'title' => 'Jetpack by WordPress.com',
		'plugin_path' => 'jetpack/jetpack.php',
		'plugin_link' => '//wordpress.org/plugins/jetpack/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'ninja-forms' => array(
		'title' => 'Ninja Forms',
		'plugin_path' => 'ninja-forms/ninja-forms.php',
		'plugin_link' => '//wordpress.org/plugins/ninja-forms/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'regenerate-thumbnails' => array(
		'title' => 'Regenerate Thumbnails',
		'plugin_path' => 'regenerate-thumbnails/regenerate-thumbnails.php',
		'plugin_link' => '//wordpress.org/plugins/regenerate-thumbnails/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'rendez-vous' => array(
		'title' => 'Rendez Vous',
		'plugin_path' => 'rendez-vous/rendez-vous.php',
		'plugin_link' => '//wordpress.org/plugins/rendez-vous/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'rtsocial' => array(
		'title' => 'rtSocial',
		'plugin_path' => 'rtsocial/source.php',
		'plugin_link' => '//wordpress.org/plugins/rtsocial/',
		'is_rt_product' => true,
		'product_link' => false,
	),
	'rtWidgets' => array(
		'title' => 'rtWidgets',
		'plugin_path' => 'rtwidgets/rtwidgets-main.php',
		'plugin_link' => '//wordpress.org/plugins/rtwidgets/',
		'is_rt_product' => true,
		'product_link' => false,
	),
	'rtpanel-hooks-editor' => array(
		'title' => 'rtPanel Hooks Editor',
		'plugin_path' => 'rtpanel-hooks-editor/rtpanel-hooks-editor.php',
		'plugin_link' => '//wordpress.org/plugins/rtpanel-hooks-editor/',
		'is_rt_product' => true,
		'product_link' => false,
	),
	'buddypress-media' => array(
		'title' => 'rtMedia for WordPress, BuddyPress and bbPress',
		'plugin_path' => 'buddypress-media/index.php',
		'plugin_link' => '//wordpress.org/plugins/buddypress-media/',
		'is_rt_product' => true,
		'product_link' => false,
	),
	'rtmedia-pro' => array(
		'title' => 'rtMedia PRO',
		'plugin_path' => 'rtmedia-pro/index.php',
		'plugin_link' => '//rtcamp.com/store/rtmedia-pro/',
		'is_rt_product' => true,
		'product_link' => '//rtcamp.com/store/rtmedia-pro/',
	),
	'subscribe-to-comments-reloaded' => array(
		'title' => 'Subscribe To Comments Reloaded',
		'plugin_path' => 'subscribe-to-comments-reloaded/subscribe-to-comments-reloaded.php',
		'plugin_link' => '//wordpress.org/plugins/subscribe-to-comments-reloaded/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'woocommerce' => array(
		'title' => 'WooCommerce - excelling eCommerce',
		'plugin_path' => 'woocommerce/woocommerce.php',
		'plugin_link' => '//wordpress.org/plugins/woocommerce/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'wordpress-seo' => array(
		'title' => 'WordPress SEO by Yoast',
		'plugin_path' => 'wordpress-seo/wp-seo.php',
		'plugin_link' => '//wordpress.org/plugins/wordpress-seo/',
		'is_rt_product' => false,
		'product_link' => false,
	),
	'yet-another-related-posts-plugin' => array(
		'title' => 'Yet Another Related Posts Plugin (YARPP)',
		'plugin_path' => 'yet-another-related-posts-plugin/yarpp.php',
		'plugin_link' => '//wordpress.org/plugins/yet-another-related-posts-plugin/',
		'is_rt_product' => false,
		'product_link' => false,
	),
);

/**
 * Include class-wp-upgrader.php
 */
include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

if ( ! class_exists( 'rtPanel_Plugin_Upgrader_Skin' ) ) {

	class rtPanel_Plugin_Upgrader_Skin extends WP_Upgrader_Skin {

		function __construct( $args = array() ) {
			$defaults = array( 'type' => 'web', 'url' => '', 'plugin' => '', 'nonce' => '', 'title' => '' );
			$args = wp_parse_args( $args, $defaults );

			$this->type = $args['type'];
			$this->api = isset( $args['api'] ) ? $args['api'] : array();

			parent::__construct( $args );
		}

		public function request_filesystem_credentials( $error = false ) {
			return true;
		}

		public function error( $errors ) {
			die( '-1' );
		}

		public function header() {
			
		}

		public function footer() {
			
		}

		public function feedback( $string ) {
			
		}
	}
}

/**
 * Get Supported Plugin List
 * @global array $rtp_support_plugins
 * @return type
 */
function inpirebook_get_supported_plugin() {
	global $rtp_support_plugins;
	return apply_filters( 'rtpanel_supported_plugin_list', $rtp_support_plugins );
}

/**
 * Manage Plugins
 */
function rtpanel_manage_plugin() {

	$rtp_support_plugins = inpirebook_get_supported_plugin();

	if ( ! isset( $_POST['plugin'] ) ) {
		wp_send_json_error();
	}

	if ( ! isset( $_POST['plugin_action'] ) ) {
		wp_send_json_error();
	}

	if ( isset( $_POST['plugin'] ) && ! isset( $rtp_support_plugins[$_POST['plugin']] ) ) {
		wp_send_json_error();
	}

	$plugin = $_POST['plugin'];

	switch( $_POST['plugin_action'] ) {
		case 'activate' :
			$return = activate_plugins( $rtp_support_plugins[$plugin]['plugin_path'] );
			if ( is_wp_error( $return ) ) {
				wp_send_json_error( array( 'success' => false, 'data' => $return->get_error_message() ) );
			} else {
				wp_send_json_success();
			}
			break;
		case 'deactivate' :
			$return = deactivate_plugins( $rtp_support_plugins[$plugin]['plugin_path'] );
			if ( is_wp_error( $return ) ) {
				wp_send_json_error( array( 'success' => false, 'data' => $return->get_error_message() ) );
			} else {
				wp_send_json_success();
			}
			break;
		case 'delete' :
			$return = delete_plugins( (array) $rtp_support_plugins[$plugin]['plugin_path'] );
			if ( is_wp_error( $return ) ) {
				wp_send_json_error( array( 'success' => false, 'data' => $return->get_error_message() ) );
			} else {
				wp_send_json_success();
			}
			break;
		case 'install' :
			include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

			$api = plugins_api( 'plugin_information', array( 'slug' => $plugin, 'fields' => array( 'sections' => false ) ) );

			if ( is_wp_error( $api ) ) {
				wp_send_json_error( array( 'success' => false, 'data' => sprintf( __( 'ERROR: Failed to install plugin: %s', 'rtPanel	' ), $api->get_error_message() ) ) );
			}

			$upgrader = new Plugin_Upgrader( new rtPanel_Plugin_Upgrader_Skin( array(
				'nonce' => 'install-plugin_' . $plugin, 'plugin' => $plugin, 'api' => $api,
				) ) );

			$install_result = $upgrader->install( $api->download_link );

			if ( !$install_result || is_wp_error( $install_result ) ) {
				/* $install_result can be false if the file system isn't writable. */
				$error_message = __( 'Please ensure the file system is writable', 'rtPanel' );

				if ( is_wp_error( $install_result ) ) {
					$error_message = $install_result->get_error_message();
				}

				wp_send_json_error( array( 'success' => false, 'data' => sprintf( __( 'ERROR: Failed to install plugin: %s', 'rtPanel	' ), $error_message ) ) );
			} else {
				wp_send_json_success();
			}
			break;
	}
	wp_send_json_error();
}

function rtpanel_install_plugin() {
	if ( empty( $_POST['plugin_slug'] ) ) {
		die( __( 'ERROR: No slug was passed to the AJAX callback.', 'rtPanel' ) );
	}

	check_ajax_referer( $_POST['plugin_slug'] . '-install' );

	if ( ! current_user_can( 'install_plugins' ) || !current_user_can( 'activate_plugins' ) ) {
		die( __( 'ERROR: You lack permissions to install and/or activate plugins.', 'rtPanel' ) );
	}

	include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

	$api = plugins_api( 'plugin_information', array( 'slug' => $_POST['plugin_slug'], 'fields' => array( 'sections' => false ) ) );

	if ( is_wp_error( $api ) ) {
		die( sprintf( __( 'ERROR: Error fetching plugin information: %s', 'rtPanel' ), $api->get_error_message() ) );
	}

	$upgrader = new Plugin_Upgrader( new rtPanel_Plugin_Upgrader_Skin( array(
		'nonce' => 'install-plugin_' . $_POST['plugin_slug'], 'plugin' => $_POST['plugin_slug'], 'api' => $api,
		) ) );

	$install_result = $upgrader->install( $api->download_link );

	if ( ! $install_result || is_wp_error( $install_result ) ) {
		/* $install_result can be false if the file system isn't writable. */
		$error_message = __( 'Please ensure the file system is writable', 'rtPanel' );

		if ( is_wp_error( $install_result ) ) {
			$error_message = $install_result->get_error_message();
		}

		die( sprintf( __( 'ERROR: Failed to install plugin: %s', 'rtPanel	' ), $error_message ) );
	}

	echo "true";
	die();
}

function rtp_plugins_submenu_page_callback() {
	$plugins = get_plugins();
	$support_plugins = inpirebook_get_supported_plugin();
	?>
	<div id="poststuff" class="wrap rtp-manage-plugin postbox">
		<h3 class="hndle"><span><?php _e( 'Plugin Support', 'rtPanel' ); ?></span></h3>

		<div class="inside">
			<div class="">
				<p><?php _e( 'Following are the list of plugins which supported by rtPanel.', 'rtPanel' ); ?></p>
				<hr />
			</div>

			<table class="form-table">
				<thead>
					<tr>
						<th><?php _e( 'Plugin', 'rtPanel' ); ?></th>
						<th><?php _e( 'Status', 'rtPanel' ); ?></th>
						<th><?php _e( 'Action', 'rtPanel' ); ?></th>
						<th><?php _e( 'Edit', 'rtPanel' ); ?></th>
					</tr>
				</thead>

				<?php foreach ( $support_plugins as $plugin_key => $plugin_info ) { ?>
					<tr><?php
					if ( is_plugin_active( $plugin_info['plugin_path'] ) ) {
						$status = __( 'Active', 'rtPanel' );
						$st_flag = 'active';
					} elseif ( array_key_exists( $plugin_info['plugin_path'], $plugins ) ) {
						$status = __( 'Inactive', 'rtPanel' );
						$st_flag = 'inactive';
					} else {
						$status = __( 'Not Installed', 'rtPanel' );
						$st_flag = 'not-installed';
					}
					?>

						<td>
							<a target="_blank" href="<?php echo $plugin_info['plugin_link']; ?>"><?php echo $plugin_info['title']; ?></a>
						</td>

						<td class="<?php echo str_replace( " ", "-", strtolower( $status ) ) ?>">
							<?php echo $status ?>
						</td>

						<td><?php
							$action_label = array();
							$action = array();
							$links = array();
							switch( $st_flag ) {
								case 'active' :
									$action_label[] = __( 'Deactivate', 'rtPanel' );
									$action [] = 'deactivate';
									$links [] = '#';
									break;
								case 'inactive' :
									$action_label[] = __( 'Activate', 'rtPanel' );
									$action [] = 'activate';
									$links [] = '#';

									$action_label[] = __( 'Delete', 'rtPanel' );
									$action [] = 'delete';
									$links [] = '#';
									break;
								default :
									if ( $plugin_info['is_rt_product'] === false || $plugin_info['product_link'] === false ) {
										$action_label[] = __( 'Install', 'rtPanel' );
										$action [] = 'install';
										$links [] = '#';
									} else {
										$action_label[] = __( 'Buy Now', 'rtPanel' );
										$action [] = 'purchase';
										$links [] = $plugin_info['product_link'];
									}
							}

							$sep = '';
							foreach ( $action_label as $key => $val ) {
								echo $sep;
								?><a class='rtp-manage-plugin-action <?php echo $action[$key]; ?>'
								   data-plugin='<?php echo esc_attr( $plugin_key ); ?>' href='<?php echo $links[$key]; ?>'
								   data-action='<?php echo $action[$key]; ?>'
								   data-site-url='<?php echo RTP_TEMPLATE_URL; ?>'
								   data-plugin-title ='<?php echo $plugin_info['title']; ?>'
								   data-nonce='<?php echo esc_attr( wp_create_nonce( $plugin_key ) ); ?>'><?php echo $action_label[$key]; ?></a>
								   <?php
								   $sep = '/ ';
							   }
							   ?>
						</td>

						<td><?php
					   if ( $st_flag != "not-installed" ) {
								   ?>
								<a href="<?php echo admin_url( 'plugin-editor.php?file=' . $plugin_info['plugin_path'] ) ?>"><?php _e( 'Edit', 'rtPanel' ); ?></a>
								<?php
							} else {
								?>
								-----
							<?php }
							?>
						</td>
					</tr><?php }
				?>
			</table>
		</div>
	</div><?php
}