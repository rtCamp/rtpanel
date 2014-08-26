<?php
/*
 * Support Page Content
 */

function rtp_support_submenu_page_callback() {
	if ( class_exists( 'rtPanelSupport' ) ) {
		$rtpanel_support = new rtPanelSupport();
		$rtpanel_support->get_support_content();
	}
}

if ( ! class_exists( 'rtPanelSupport' ) ) {

	class rtPanelSupport {

		var $debug_info;
		var $curr_sub_tab;

		public function __construct( $init = true ) {
			if ( $init ) {
				if ( !is_admin() ) {
					return;
				}

				$this->curr_sub_tab = "support";

				if ( isset( $_REQUEST['tab'] ) ) {
					$this->curr_sub_tab = $_REQUEST['tab'];
				}
			}
		}

		public function get_support_content() {
			$tabs = array();
			$tabs[] = array(
				'title' => __( 'Premium Support', 'rtPanel' ), 'name' => __( 'Premium Support', 'rtPanel' ), 'href' => '#support', 'callback' => array( $this, 'call_get_form' )
			);
			$tabs[] = array(
				'title' => __( 'Debug Info', 'rtPanel' ), 'name' => __( 'Debug Info', 'rtPanel' ), 'href' => '#debug', 'callback' => array( $this, 'debug_info_html' )
			);
			?>
			<div id="rtpanel-support" class="wrap">
				<h2 class="nav-tab-wrapper rtp-tabs">
					<?php
					$i = 1;
					foreach ( $tabs as $tab ) {
						$active_class = '';
						if ( $i == 1 ) {
							$active_class = ' nav-tab-active';
						}
						$i ++;
						?>
						<a id="tab-<?php echo substr( $tab['href'], 1 ) ?>"
						   title="<?php echo $tab['title'] ?>" href="<?php echo $tab['href'] ?>"
						   class="rtpanel-tab-title nav-tab <?php
						   echo sanitize_title( $tab['name'] );
						   echo $active_class
						   ?>"><?php echo $tab['name'] ?></a>
						   <?php
					   }
					   ?>
				</h2>

				<?php
				$k = 1;
				$active_class = '';
				foreach ( $tabs as $tab ) {

					$active_class = '';
					if ( $k == 1 ) {
						$active_class = ' active';
					}
					$k ++;

					$tab_without_hash = explode( "#", $tab['href'] );
					$tab_without_hash = $tab_without_hash[1];
					echo '<div class="postbox tab-content' . $active_class . '" id="' . $tab_without_hash . '">';
					call_user_func( $tab['callback'] );
					echo '</div>';
				}
				?>
			</div>
			<?php
		}

		public function render_support( $page = '' ) {
			global $wp_settings_sections, $wp_settings_fields;

			if ( ! isset( $wp_settings_sections ) || ! isset( $wp_settings_sections[$page] ) ) {
				return;
			}

			foreach ( (array) $wp_settings_sections[$page] as $section ) {

				if ( $section['callback'] ) {
					call_user_func( $section['callback'], $section );
				}

				if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[$page] ) || ! isset( $wp_settings_fields[$page][$section['id']] ) ) {
					continue;
				}

				echo '<table class="form-table">';
				do_settings_fields( $page, $section['id'] );
				echo '</table>';
			}
		}

		function call_get_form() {
			if ( $this->curr_sub_tab == "support" ) {
				echo "<div id='rtpanel_service_contact_container'><form name='rtpanel_service_contact_detail' method='post'>";
				$this->get_form( "premium_support" );
				echo "</form></div>";
			}
		}

		public function get_plugin_info() {
			$active_plugins = (array) get_option( 'active_plugins', array() );
			$rtpanel_plugins = array();
			foreach ( $active_plugins as $plugin ) {
				$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
				$version_string = '';
				if ( !empty( $plugin_data['Name'] ) ) {
					$rtpanel_plugins[] = $plugin_data['Name'] . ' ' . __( 'by', 'rtPanel' ) . ' ' . $plugin_data['Author'] . ' ' . __( 'version', 'rtPanel' ) . ' ' . $plugin_data['Version'] . $version_string;
				}
			}
			if ( sizeof( $rtpanel_plugins ) == 0 ) {
				return false;
			} else {
				return implode( ', <br/>', $rtpanel_plugins );
			}
		}

		public function debug_info() {
			global $wpdb, $wp_version, $bp;
			$debug_info = array();
			$debug_info['Home URL'] = home_url();
			$debug_info['Site URL'] = site_url();
			$debug_info['PHP'] = PHP_VERSION;
			$debug_info['MYSQL'] = $wpdb->db_version();
			$debug_info['WordPress'] = $wp_version;
			$debug_info['OS'] = PHP_OS;
			$debug_info['[php.ini] post_max_size'] = ini_get( 'post_max_size' );
			$debug_info['[php.ini] upload_max_filesize'] = ini_get( 'upload_max_filesize' );
			$debug_info['[php.ini] memory_limit'] = ini_get( 'memory_limit' );
			$debug_info['Installed Plugins'] = $this->get_plugin_info();
			$active_theme = wp_get_theme();
			$debug_info['Theme Name'] = $active_theme->Name;
			$debug_info['Theme Version'] = $active_theme->Version;
			$debug_info['Author URL'] = $active_theme->{'Author URI'};

			$this->debug_info = $debug_info;
		}

		public function debug_info_html() {
			$this->debug_info();
			?>
			<div id="debug-info">

				<table class="form-table">
					<tbody><?php
						if ( $this->debug_info ) {
							foreach ( $this->debug_info as $configuration => $value ) {
								?>
								<tr valign="top">
									<th scope="row"><?php echo $configuration; ?></th>
									<td><?php echo $value; ?></td>
								</tr><?php
							}
						}
						?>
					</tbody>
				</table>
			</div><?php
		}

		/**
		 *
		 * @global type $current_user
		 *
		 * @param type  $form
		 */
		public function get_form( $form = '' ) {
			if ( empty( $form ) ) {
				$form = ( isset( $_POST['form'] ) ) ? $_POST['form'] : '';
			}
			if ( $form == "" ) {
				$form = "premium_support";
			}
			global $current_user;
			switch( $form ) {
				case "bug_report":
					$meta_title = __( 'Submit a Bug Report', 'rtPanel' );
					break;
				case "new_feature":
					$meta_title = __( 'Submit a New Feature Request', 'rtPanel' );
					break;
				case "premium_support":
					$meta_title = __( 'Submit a Premium Support Request', 'rtPanel' );
					break;
			}

			if ( $form == "premium_support" ) {
				?>
				<h3 class="rtp-meta-title"><?php echo $meta_title; ?></h3>
				<div id="support-form" class="rtp-form">
					<ul>
						<li>
							<label class="bp-media-label" for="name"><?php _e( 'Name', 'rtPanel' ); ?>
								:</label><input id="name" type="text" name="name"
											value="<?php echo ( isset( $_REQUEST['name'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['name'] ) ) ) : $current_user->display_name; ?>"
											required/>
						</li>
						<li>
							<label class="bp-media-label" for="email"><?php _e( 'Email', 'rtPanel' ); ?>
								:</label><input id="email" type="text" name="email"
											value="<?php echo ( isset( $_REQUEST['email'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['email'] ) ) ) : get_option( 'admin_email' ); ?>"
											required/>
						</li>
						<li>
							<label class="bp-media-label" for="website"><?php _e( 'Website', 'rtPanel' ); ?>
								:</label><input id="website" type="text" name="website"
											value="<?php echo ( isset( $_REQUEST['website'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['website'] ) ) ) : esc_url( home_url( '/' ) ); ?>"
											required/>
						</li>
						<li>
							<label class="bp-media-label" for="phone"><?php _e( 'Phone', 'rtPanel' ); ?>
								:</label><input id="phone" type="text" name="phone"
											value="<?php echo ( isset( $_REQUEST['phone'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['phone'] ) ) ) : ''; ?>"/>
						</li>
						<li>
							<label class="bp-media-label" for="subject"><?php _e( 'Subject', 'rtPanel' ); ?>
								:</label><input id="subject" type="text" name="subject"
											value="<?php echo ( isset( $_REQUEST['subject'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['subject'] ) ) ) : ''; ?>"
											required/>
						</li>
						<li>
							<label class="bp-media-label" for="details"><?php _e( 'Details', 'rtPanel' ); ?>
								:</label><textarea id="details" type="text" name="details"
											   required/><?php echo ( isset( $_REQUEST['details'] ) ) ? esc_textarea( stripslashes( trim( $_REQUEST['details'] ) ) ) : ''; ?></textarea>
						</li>
						<input type="hidden" name="request_type" value="<?php echo $form; ?>"/>
						<input type="hidden" name="request_id"
							   value="<?php echo wp_create_nonce( date( 'YmdHis' ) ); ?>"/>
						<input type="hidden" name="server_address"
							   value="<?php echo $_SERVER['SERVER_ADDR']; ?>"/>
						<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>"/>
						<input type="hidden" name="server_type"
							   value="<?php echo $_SERVER['SERVER_SOFTWARE']; ?>"/>
						<input type="hidden" name="user_agent"
							   value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>"/>

					</ul>
				</div><!-- .submit-bug-box --><?php if ( $form == 'bug_report' ) { ?>
					<h3 class="rtp-meta-title"><?php _e( 'Additional Information', 'rtPanel' ); ?></h3>
					<div id="support-form" class="rtp-form">
						<ul>

							<li>
								<label for="wp_admin_username"><?php _e( 'Your WP Admin Login:', 'rtPanel' ); ?></label><input
									id="wp_admin_username" type="text"
									name="wp_admin_username"
									value="<?php echo ( isset( $_REQUEST['wp_admin_username'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['wp_admin_username'] ) ) ) : $current_user->user_login; ?>"/>
							</li>
							<li>
								<label class="bp-media-label"
									   for="wp_admin_pwd"><?php _e( 'Your WP Admin password:', 'rtPanel' ); ?></label><input
									   class="bp-media-input" id="wp_admin_pwd" type="password" name="wp_admin_pwd"
									   value="<?php echo ( isset( $_REQUEST['wp_admin_pwd'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['wp_admin_pwd'] ) ) ) : ''; ?>"/>
							</li>
							<li>
								<label class="bp-media-label"
									   for="ssh_ftp_host"><?php _e( 'Your SSH / FTP host:', 'rtPanel' ); ?></label><input
									   class="bp-media-input" id="ssh_ftp_host" type="text" name="ssh_ftp_host"
									   value="<?php echo ( isset( $_REQUEST['ssh_ftp_host'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['ssh_ftp_host'] ) ) ) : ''; ?>"/>
							</li>
							<li>
								<label class="bp-media-label"
									   for="ssh_ftp_username"><?php _e( 'Your SSH / FTP login:', 'rtPanel' ); ?></label><input
									   class="bp-media-input" id="ssh_ftp_username" type="text" name="ssh_ftp_username"
									   value="<?php echo ( isset( $_REQUEST['ssh_ftp_username'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['ssh_ftp_username'] ) ) ) : ''; ?>"/>
							</li>
							<li>
								<label class="bp-media-label"
									   for="ssh_ftp_pwd"><?php _e( 'Your SSH / FTP password:', 'rtPanel' ); ?></label><input
									   class="bp-media-input" id="ssh_ftp_pwd" type="password" name="ssh_ftp_pwd"
									   value="<?php echo ( isset( $_REQUEST['ssh_ftp_pwd'] ) ) ? esc_attr( stripslashes( trim( $_REQUEST['ssh_ftp_pwd'] ) ) ) : ''; ?>"/>
							</li>
						</ul>
					</div><!-- .submit-bug-box --><?php } ?>

				<div class="rtp-button-cotainer">
					<?php submit_button( __( 'Submit', 'rtPanel' ), 'primary', 'rtpanel-submit-request', false ); ?>
					<?php submit_button( __( 'Cancel', 'rtPanel' ), 'secondary', 'cancel-request', false ); ?>
				</div>
				<?php
			}
		}

		public function submit_request() {
			$this->debug_info();
			$rtpanel_support_url = "";
			$form_data = wp_parse_args( $_POST['form_data'] );
			foreach ( $form_data as $key => $formdata ) {
				if ( $formdata == "" && $key != "phone" ) {
					echo "false";
					die();
				}
			}
			if ( $form_data['request_type'] == 'premium_support' ) {
				$mail_type = 'Premium Support';
				$title = __( 'rtPanel Premium Support Request from', 'rtPanel' );
			} elseif ( $form_data['request_type'] == 'new_feature' ) {
				$mail_type = 'New Feature Request';
				$title = __( 'rtPanel New Feature Request from', 'rtPanel' );
			} elseif ( $form_data['request_type'] == 'bug_report' ) {
				$mail_type = 'Bug Report';
				$title = __( 'rtPanel Bug Report from', 'rtPanel' );
			} else {
				$mail_type = 'Bug Report';
				$title = __( 'rtPanel Contact from', 'rtPanel' );
			}
			$message = '<html>
                            <head>
                                    <title>' . $title . get_bloginfo( 'name' ) . '</title>
                            </head>
                            <body>
								<table>
                                    <tr>
                                        <td>Name</td><td>' . strip_tags( $form_data['name'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td><td>' . strip_tags( $form_data['email'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Website</td><td>' . strip_tags( $form_data['website'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td><td>' . strip_tags( $form_data['phone'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Subject</td><td>' . strip_tags( $form_data['subject'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Details</td><td>' . strip_tags( $form_data['details'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Request ID</td><td>' . strip_tags( $form_data['request_id'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Server Address</td><td>' . strip_tags( $form_data['server_address'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>IP Address</td><td>' . strip_tags( $form_data['ip_address'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>Server Type</td><td>' . strip_tags( $form_data['server_type'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>User Agent</td><td>' . strip_tags( $form_data['user_agent'] ) . '</td>
                                    </tr>';
					if ( $form_data['request_type'] == 'bug_report' ) {
						$message .= '<tr>
                                        <td>WordPress Admin Username</td><td>' . strip_tags( $form_data['wp_admin_username'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>WordPress Admin Password</td><td>' . strip_tags( $form_data['wp_admin_pwd'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>SSH FTP Host</td><td>' . strip_tags( $form_data['ssh_ftp_host'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>SSH FTP Username</td><td>' . strip_tags( $form_data['ssh_ftp_username'] ) . '</td>
                                    </tr>
                                    <tr>
                                        <td>SSH FTP Password</td><td>' . strip_tags( $form_data['ssh_ftp_pwd'] ) . '</td>
                                    </tr>
                                    ';
			}

			$message .= '</table>';
			if ( $this->debug_info ) {
				$message .= '<h3>' . __( 'Debug Info', 'rtPanel' ) . '</h3>';
				$message .= '<table>';
				foreach ( $this->debug_info as $configuration => $value ) {
					$message .= '<tr>
                                    <td style="vertical-align:top">' . $configuration . '</td><td>' . $value . '</td>
                                </tr>';
				}
				$message .= '</table>';
			}
			$message .= '</body></html>';
			add_filter( 'wp_mail_content_type', create_function( '', 'return "text/html";' ) );
			$headers = 'From: ' . $form_data['name'] . ' <' . $form_data['email'] . '>' . "\r\n";
			$support_email = "support@rtcamp.com";
			if ( wp_mail( $support_email, '[rtPanel] ' . $mail_type . ' from ' . str_replace( array( 'http://', 'https://' ), '', $form_data['website'] ), $message, $headers ) ) {
				echo '<div class="rtpanel-success" style="margin:10px 0;">';
				if ( $form_data['request_type'] == 'new_feature' ) {
					echo '<p>' . __( 'Thank you for your Feedback/Suggestion.', 'rtPanel' ) . '</p>';
				} else {
					echo '<p>' . __( 'Thank you for posting your support request.', 'rtPanel' ) . '</p>';
					echo '<p>' . __( 'We will get back to you shortly.', 'rtPanel' ) . '</p>';
				}
				echo '</div>';
			} else {
				echo '<div class="rtpanel-error">';
				echo '<p>' . __( 'Your server failed to send an email.', 'rtPanel' ) . '</p>';
				echo '<p>' . __( 'Kindly contact your server support to fix this.', 'rtPanel' ) . '</p>';
				echo '<p>' . sprintf( __( 'You can alternatively create a support request <a href="%s">here</a>', 'rtPanel' ), $rtpanel_support_url ) . '</p>';
				echo '</div>';
			}
			die();
		}
	}
}