<?php
/**
 * rtPanel Settings Validation and Default Values
 *
 * @package rtPanel
 *
 * @since rtPanel 2.1
 */

/**
 * Data validation for rtPanel General Options
 * 
 * @uses $rtp_general array
 * @return Array
 *
 * @since rtPanel 2.0
 */
function rtp_general_validate( $input ) {
    global $rtp_general;
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php' );
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php' );
    @$file_object = new WP_Filesystem_Direct;
    $default = rtp_theme_setup_values();

    if ( isset ( $_POST['rtp_submit'] ) ) {
        if ( $input['logo_show'] ) {
            if ( $input['use_logo'] == 'use_logo_url' && $rtp_general['logo_url'] != $input['logo_url'] ) {
                $logo_info = pathinfo( $input['logo_url'] );
                $logo_with_extension = urldecode( basename( $input['logo_url'] ) );
                $remote_get_path     = str_replace( ' ', '%20', urldecode($input['logo_url']));
                $logo_extension      = strtolower( $logo_info['extension'] );

                $logo_with_extension = str_replace( '?', '-', $logo_with_extension );
                $logo_with_extension = str_replace( '&', '-', $logo_with_extension );

                // get placeholder file in the upload dir with a unique, sanitized filename
                $logo_file = wp_upload_bits( $logo_with_extension, 0, '');

                // fetch the remote url and write it to the placeholder file
                $wp_remote_get = wp_get_http( $remote_get_path, $logo_file['file'], 5);

                if ( $wp_remote_get == '' || $wp_remote_get == false ) {
                        $file_object->delete( $logo_file['file'] );
                }

                $input['logo_upload'] = $rtp_general['logo_upload'];
                
                if ( in_array( $logo_extension, array( 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'ico', 'tif', 'tiff' ) ) && ( $wp_remote_get['response'] == 200 ) && $input['logo_url'] != RT_BASE_IMG_FOLDER_URL . '/rtp-logo.jpg' ) {
                    $input['logo_url']    = $logo_file['url'];
                    add_settings_error( 'logo_upload', 'valid_logo_upload', __( 'The Logo Settings have been updated.', 'rtPanel' ), 'updated' );
                } else {
                    $file_object->delete( $logo_file['file'] );
                    $input['logo_url']    = $rtp_general['logo_url'];
                    add_settings_error('logo_upload', 'invalid_logo_upload', __( 'The Uploaded Image is invalid or is an invalid Logo Image type.', 'rtPanel' ) );
                }
            } elseif ( $input['use_logo'] == 'use_logo_upload' && $rtp_general['logo_upload'] != $input['logo_upload'] ){
                $logo_info           = pathinfo( $input['logo_upload'] );
                $logo_extension      = strtolower( $logo_info['extension'] );
                $input['logo_url'] = $rtp_general['logo_url'];
                if ( in_array( $logo_extension, array( 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'ico', 'tif', 'tiff' ) ) )
                {
                    add_settings_error( 'logo_upload', 'valid_logo_upload', __( 'The Logo Settings have been updated.', 'rtPanel' ), 'updated' );
                } else {
                    $input['logo_upload'] = $rtp_general['logo_upload'];
                    add_settings_error( 'logo_upload', 'invalid_logo_upload', __( 'The Uploaded Image is invalid or is an invalid Logo Image type.', 'rtPanel' ) );
                }
            } else {
                $input['logo_upload'] = $rtp_general['logo_upload'];
                $input['logo_url']    = $rtp_general['logo_url'];
            }
        } else {
            $input['use_logo']    = $rtp_general['use_logo'];
            $input['logo_url']    = $rtp_general['logo_url'];
            $input['logo_upload'] = $rtp_general['logo_upload'];
            $input['login_head']  = $rtp_general['login_head'];
        }
        
        if ( $input['favicon_show'] ) {
            if ( $input['use_favicon'] == 'use_favicon_url' && $rtp_general['favicon_url'] != $input['favicon_url'] ) {
                $favicon_info = pathinfo( $input['favicon_url'] );
                $favicon_with_extension = urldecode( basename( $input['favicon_url'] ) );
                $remote_get_path     = str_replace( ' ', '%20', urldecode($input['favicon_url']));
                $favicon_extension      = strtolower( $favicon_info['extension'] );

                $favicon_with_extension = str_replace( '?', '-', $favicon_with_extension );
                $favicon_with_extension = str_replace( '&', '-', $favicon_with_extension );

                // get placeholder file in the upload dir with a unique, sanitized filename
                $favicon_file = wp_upload_bits( $favicon_with_extension, 0, '');

                // fetch the remote url and write it to the placeholder file
                $wp_remote_get = wp_get_http( $remote_get_path, $favicon_file['file'], 5);

                if ( $wp_remote_get == '' || $wp_remote_get == false ) {
                        $file_object->delete( $favicon_file['file'] );
                }

                    $input['favicon_upload'] = $rtp_general['favicon_upload'];

                if ( ( $favicon_extension == 'ico' ) && ( $wp_remote_get['response'] == 200 ) && $input['favicon_url'] != RT_BASE_IMG_FOLDER_URL . '/rtpanel-favicon.gif' ) {
                    $input['favicon_url']    = $favicon_file['url'];
                    add_settings_error( 'favicon_upload', 'valid_favicon_upload', __( 'The Favicon Settings have been updated.', 'rtPanel' ), 'updated' );
                } else {
                    $file_object->delete( $favicon_file['file'] );
                    $input['favicon_url']    = $rtp_general['favicon_url'];
                    add_settings_error('favicon_upload', 'invalid_favicon_upload', 'The Uploaded Image is invalid or is an invalid Favicon Image type.');
                }
            } elseif ( $input['use_favicon'] == 'use_favicon_upload' && $rtp_general['favicon_upload'] != $input['favicon_upload'] ){
                $favicon_info      = pathinfo( $input['favicon_upload'] );
                $favicon_extension = strtolower( $favicon_info['extension'] );
                    $input['favicon_url']    = $rtp_general['favicon_url'];
                if ( $favicon_extension == 'ico' ) {
                    add_settings_error( 'favicon_upload', 'valid_favicon_upload', __( 'The Favicon Settings have been updated.', 'rtPanel' ), 'updated' );
                } else {
                    $input['favicon_upload'] = $rtp_general['favicon_upload'];
                    add_settings_error( 'favicon_upload', 'invalid_favicon_upload', 'The Uploaded Image is invalid or is an invalid Favicon Image type.' );
                }
            }
        } else {
            $input['use_favicon']    = $rtp_general['use_favicon'];
            $input['favicon_url']    = $rtp_general['favicon_url'];
            $input['favicon_upload'] = $rtp_general['favicon_upload'];
        }

        if ( !empty( $input['feedburner_url'] ) ) {
            $result = wp_remote_get( $input['feedburner_url'] );
            if ( is_wp_error( $result ) || $result["response"]["code"]!=200 ) {
                 $input['feedburner_url'] = $rtp_general['feedburner_url'];
                 add_settings_error( 'feedburner_url', 'valid_feedburner_url', __( 'The FeedBurner URL is not a valid url. The changes made have been reverted.', 'rtPanel' ) );
            } elseif ( $input['feedburner_url'] != $rtp_general['feedburner_url'] ) {
                add_settings_error( 'feedburner_url', 'invalid_feedburner_url', __( 'The FeedBurner Settings have been updated.', 'rtPanel' ), 'updated' );
            }
        }

        if ( trim( $input['fb_app_id'] ) !=  $rtp_general['fb_app_id'] ) {
                $input['fb_app_id'] = trim( $input['fb_app_id'] );
                add_settings_error( 'fb_app_id', 'valid_fb_app_id', __( 'The Facebook App ID has been updated.', 'rtPanel' ), 'updated' );
        }

        if ( trim( $input['fb_admins'] ) !=  $rtp_general['fb_admins'] ) {
                $input['fb_admins'] = trim( $input['fb_admins'] );
                add_settings_error( 'fb_admins', 'valid_fb_admins', __( 'The Facebook Admin ID(s) has been updated.', 'rtPanel' ), 'updated' );
        }

        if ( !empty( $input['search_code'] ) ) {
            if ( !preg_match( '/customSearchControl.draw\(\'cse\'(.*)\)\;/i', $input['search_code'] ) ){
                $input['search_code'] = $rtp_general['search_code'];
                add_settings_error( 'search_code', 'invalid_search_code', __( 'Google Search Code Error : While generating the code the hosting option must be "Search Element" and layout either "full-width" or "compact". The changes made have been reverted.', 'rtPanel' ) );
            } elseif ( $input['search_code'] != $rtp_general['search_code'] ) {
                add_settings_error( 'search_code', 'valid_search_code', __( 'Google Custom Search Integration has been updated.', 'rtPanel' ), 'updated' );
            }
        }
        
        if ( $_POST['rtp-hooks-editor-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_rtp_hooks_editor_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_HOOKS_EDITOR . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( RTP_HOOKS_EDITOR );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'rtPanel Hooks Editor Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['rtp-hooks-editor-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_rtp_hooks_editor_deactivate'];
            if (!wp_verify_nonce( $nonce, RTP_HOOKS_EDITOR . '-deactivate' ) ) {
                add_settings_error( 'deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array( RTP_HOOKS_EDITOR ) );
                add_settings_error( 'deactivate-plugin', 'plugin_activation', __( 'rtPanel Hooks Editor Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['rtp-hooks-editor-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_rtp_hooks_editor_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_HOOKS_EDITOR . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array( RTP_HOOKS_EDITOR ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'rtPanel Hooks Editor Plugin has been Deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['subscribe-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( RTP_SUBSCRIBE_TO_COMMENTS );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Subscribe to Comments Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['subscribe-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_deactivate'];
            if (!wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-deactivate' ) ) {
                add_settings_error( 'deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array( RTP_SUBSCRIBE_TO_COMMENTS ) );
                add_settings_error( 'deactivate-plugin', 'plugin_activation', __( 'Subscribe to Comments Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['subscribe-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array( RTP_SUBSCRIBE_TO_COMMENTS ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'Subscribe to Comments Plugin has been Deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( RTP_WP_PAGENAVI );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'WP PageNavi Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_deactivate'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-deactivate' ) ) {
                add_settings_error( 'deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array ( RTP_WP_PAGENAVI ) );
                add_settings_error( 'deactivate-plugin', 'plugin_deactivation', __( 'WP PageNavi Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array ( RTP_WP_PAGENAVI ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'WP PageNavi Plugin has been Deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['yoast_seo-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_yoast_seo_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_YOAST_SEO . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( RTP_YOAST_SEO );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Yoast WordPress SEO Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['yoast_seo-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_yoast_seo_deactivate'];
            if ( !wp_verify_nonce( $nonce, RTP_YOAST_SEO . '-deactivate' ) ) {
                add_settings_error( 'deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array ( RTP_YOAST_SEO ) );
                add_settings_error( 'deactivate-plugin', 'plugin_deactivation', __( 'Yoast WordPress SEO Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['yoast_seo-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_yoast_seo_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_YOAST_SEO . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array ( RTP_YOAST_SEO ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'Yoast WordPress SEO Plugin has been Deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADCRUMB_NAVXT . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( RTP_BREADCRUMB_NAVXT );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Breadcrumb NavXT Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_deactivate'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADCRUMB_NAVXT . '-deactivate' ) ) {
                add_settings_error('deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array( RTP_BREADCRUMB_NAVXT ) );
                add_settings_error( 'deactivate-plugin', 'plugin_deactivation', __( 'Breadcrumb NavXT Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADCRUMB_NAVXT . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array( RTP_BREADCRUMB_NAVXT ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'Breadcrumb NavXT Plugin has been Deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['regenerate-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_regenerate_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_REGENERATE_THUMBNAILS . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( RTP_REGENERATE_THUMBNAILS );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Regenerate Thumbnails Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['regenerate-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_regenerate_deactivate'];
            if ( !wp_verify_nonce( $nonce, RTP_REGENERATE_THUMBNAILS . '-deactivate' ) ) {
                add_settings_error('deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array( RTP_REGENERATE_THUMBNAILS ) );
                add_settings_error( 'deactivate-plugin', 'plugin_deactivation', __( 'Regenerate Thumbnails Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['regenerate-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_regenerate_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_REGENERATE_THUMBNAILS . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array( RTP_REGENERATE_THUMBNAILS ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'Regenerate Thumbnails Plugin has been Deleted.', 'rtPanel' ), 'updated' );
            }
        }
    } elseif ( isset ( $_POST['rtp_logo_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['logo_show']   = $default[0]['logo_show'];
        $input['use_logo']    = $default[0]['use_logo'];
        $input['logo_url']    = $default[0]['logo_url'];
        $input['logo_upload'] = $default[0]['logo_upload'];
        $input['login_head']  = $default[0]['login_head'];
        add_settings_error( 'logo_upload', 'logo_reset', __( 'The Logo Settings have been restored to Default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_fav_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['use_favicon']    = $default[0]['use_favicon'];
        $input['favicon_url']    = $default[0]['favicon_url'];
        $input['favicon_upload'] = $default[0]['favicon_upload'];
        add_settings_error( 'favicon_upload', 'fav_reset', __( 'The Favicon Settings have been restored to Default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_fb_ogp_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['fb_app_id'] = $default[0]['fb_app_id'];
        $input['fb_admins'] = $default[0]['fb_admins'];
        add_settings_error( 'facebook_ogp', 'reset_facebook_ogp', __( 'The Facebook Open Graph Settings have been restored to Default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_feed_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['feedburner_url'] = $default[0]['feedburner_url'];
        add_settings_error( 'feedburner_url', 'reset_feeburner_url', __( 'The Feedburner Settings have been restored to Default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_google_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['search_code']   = $default[0]['search_code'];
        $input['search_layout'] = $default[0]['search_layout'];
        add_settings_error( 'search_code', 'reset_search_code', __( 'The Google Custom Search Integration has been restored to Default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_sidebar_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;
        
        $input['footer_sidebar'] = $default[0]['footer_sidebar'];
        add_settings_error( 'sidebar', 'reset_sidebar', __( 'The Sidebar Settings have been restored to Default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_custom_styles_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['custom_styles'] = $default[0]['custom_styles'];
        add_settings_error( 'custom_styles', 'reset_custom_styles', __( 'Custom Styles has been restored to Default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_export'] ) ) {
        rtp_export( );
	die();
    } elseif ( isset ( $_POST['rtp_import'] ) ) {
        $general = rtp_import( $_FILES['rtp_import'] );
        if ( $general && $general != 'ext' ) {
            unset($input);
            $input = maybe_unserialize( $general );
            add_settings_error( 'rtp_import', 'import', __( 'rtPanel Options have been imported successfully', 'rtPanel' ), 'updated' );
        } elseif ( $general == 'ext' ) {
            add_settings_error( 'rtp_import', 'no_import', __( 'Not a valid RTP file', 'rtPanel' ) );
        } else {
            add_settings_error( 'rtp_import', 'no_import', __( 'The file is corrupt. There was an error while importing. Please Try Again', 'rtPanel' ) );
        }
    } elseif ( isset($_POST['rtp_reset'] ) ) {
        $input = $default[0];
        add_settings_error( 'rtp_general', 'reset_general_options', __( 'All the rtPanel General Settings have been restored to default.', 'rtPanel' ), 'updated' );
    }
    return $input; // Return validated input.
}

/**
 * Data validation for rtPanel Post & Comments Options
 * 
 * @uses $rtp_post_comments array
 * @param array $input all post & comments options inputs.
 * @return Array
 *
 * @since rtPanel 2.0
 */
function rtp_post_comments_validate( $input ) {
    global $rtp_post_comments;
    $default = rtp_theme_setup_values();

    if ( isset ( $_POST['rtp_submit'] ) ) {
        $input['notices'] = $rtp_post_comments['notices'];
        if ( $input['summary_show'] ) {
            if ( trim( $input['read_text'] ) != $rtp_post_comments['read_text'] ) {
                $input['read_text'] = trim( $input['read_text'] );
                add_settings_error( 'read_text', 'valid_read_text', __( 'The Post Summary Settings have been updated.', 'rtPanel' ), 'updated' );
            }
            if ( !preg_match( '/^[0-9]{1,3}$/i', $input['word_limit'] ) ) {
                $input['word_limit'] = $rtp_post_comments['word_limit'];
                add_settings_error( 'word_limit', 'invalid_word_limit', __( 'The Word Limit provided is invalid. Please provide a proper value.', 'rtPanel' ) );
            }
            if ( $input['thumbnail_show'] ) {
                if ( !preg_match( '/^[0-9]{1,3}$/i', $input['thumbnail_width'] ) ) {
                    $input['thumbnail_width'] = get_option( 'thumbnail_size_w' );
                    add_settings_error( 'thumbnail_width', 'invalid_thumbnail_width', __( 'The Thumbnail Width provided is invalid. Please provide a proper value.', 'rtPanel' ) );
                } elseif ( get_option( 'thumbnail_size_w' ) != $input['thumbnail_width'] ) {
                    $input['notices'] = '1';
                    update_option( 'thumbnail_size_w', $input['thumbnail_width'] );
                    add_settings_error( 'thumbnail_width', 'valid_thumbnail_width', __( 'The Post Thumbnail Settings have been updated', 'rtPanel' ), 'updated' );
                }

                if ( !preg_match( '/^[0-9]{1,3}$/i', $input['thumbnail_height'] ) ) {
                    $input['thumbnail_height'] = get_option( 'thumbnail_size_h' );
                    add_settings_error( 'thumbnail_height', 'invalid_thumbnail_height', __( 'The Thumbnail Height provided is invalid. Please provide a proper value.', 'rtPanel' ) );
                } elseif ( get_option( 'thumbnail_size_h' ) != $input['thumbnail_height'] ) {
                    $input['notices'] = '1';
                    update_option( 'thumbnail_size_h', $input['thumbnail_height'] );
                    add_settings_error( 'thumbnail_height', 'valid_thumbnail_height', __( 'The Post Thumbnail Settings have been updated', 'rtPanel' ), 'updated' );
                }

                if ( $input['thumbnail_crop'] != get_option( 'thumbnail_crop' ) ) {
                    $input['notices'] = '1';
                    update_option( 'thumbnail_crop', $input['thumbnail_crop'] );
                }
            } else {
                $input['thumbnail_position'] = $rtp_post_comments['thumbnail_position'];
                $input['thumbnail_frame'] = $rtp_post_comments['thumbnail_frame'];
            }
        } else {
            $input['thumbnail_show'] = $rtp_post_comments['thumbnail_show'];
            $input['word_limit'] = $rtp_post_comments['word_limit'];
            $input['read_text'] = $rtp_post_comments['read_text'];
            $input['thumbnail_position'] = $rtp_post_comments['thumbnail_position'];
            $input['thumbnail_frame'] = $rtp_post_comments['thumbnail_frame'];
        }

        if ( !in_array( $input['post_date_format_u'], array( $rtp_post_comments['post_date_format_u'], 'F j, Y', 'Y/m/d', 'm/d/Y', 'd/m/Y' ) ) ) {
            $input['post_date_format_u'] = str_replace( '<', '', $input['post_date_format_u'] );
            $input['post_date_format_l'] = str_replace( '<', '', $input['post_date_format_l'] );
            $input['post_date_custom_format_u'] = str_replace( '<', '', $input['post_date_custom_format_u'] );
            $input['post_date_custom_format_l'] = str_replace( '<', '', $input['post_date_custom_format_l'] );
        }

        if ( !$input['post_date_u'] ) {
            $input['post_date_format_u']        = $rtp_post_comments['post_date_format_u'];
            $input['post_date_custom_format_u'] = $rtp_post_comments['post_date_custom_format_u'];
        }

        if ( !$input['post_date_l'] ) {
            $input['post_date_format_l']        = $rtp_post_comments['post_date_format_l'];
            $input['post_date_custom_format_l'] = $rtp_post_comments['post_date_custom_format_l'];
        }

        if ( !$input['post_author_u'] ) {
            $input['author_count_u'] = $rtp_post_comments['author_count_u'];
            $input['author_link_u']  = $rtp_post_comments['author_link_u'];
        }

        if ( !$input['post_author_l'] ) {
            $input['author_count_l'] = $rtp_post_comments['author_count_l'];
            $input['author_link_l']  = $rtp_post_comments['author_link_l'];
        }

        if ( $input['pagination_show'] ) {
            if ( trim( $input['prev_text'] ) != $rtp_post_comments['prev_text'] ) {
                $input['prev_text'] = trim( $input['prev_text'] );
                add_settings_error( 'prev_text', 'valid_prev_text', __( 'The Post Summary Settings have been updated.', 'rtPanel' ), 'updated' );
            }
            if ( trim( $input['end_text'] ) != $rtp_post_comments['end_text'] ) {
                $input['end_text'] = trim( $input['end_text'] );
                add_settings_error( 'end_text', 'valid_end_text', __( 'The Post Summary Settings have been updated.', 'rtPanel' ), 'updated' );
            }
            if ( !preg_match( '/^[0-9]{1,3}$/i', $input['end_size'] ) ) {
                $input['end_size'] = $rtp_post_comments['end_size'];
                add_settings_error( 'end_size', 'invalid_end_size', __( 'The End Size provided is invalid. Please provide a proper value.', 'rtPanel' ) );
            }
            if ( !preg_match( '/^[0-9]{1,3}$/i', $input['mid_size'] ) ) {
                $input['mid_size'] = $rtp_post_comments['mid_size'];
                add_settings_error( 'mid_size', 'invalid_mid_size', __( 'The Mid Size provided is invalid. Please provide a proper value.', 'rtPanel' ) );
            }
        } else {
            $input['prev_text'] = $rtp_post_comments['prev_text'];
            $input['next_text'] = $rtp_post_comments['next_text'];
            $input['end_size']  = $rtp_post_comments['end_size'];
            $input['mid_size']  = $rtp_post_comments['mid_size'];
        }

        if ( !$input['gravatar_show'] ) {
            $input['gravatar_size'] = $rtp_post_comments['gravatar_size'];
        }

    } elseif ( isset ( $_POST['rtp_summary_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['notices']      = $rtp_post_comments['notices'];
        $input['summary_show'] = $default[1]['summary_show'];
        $input['word_limit']   = $default[1]['word_limit'];
        $input['read_text']    = $default[1]['read_text'];
        add_settings_error( 'summary', 'reset_summary', __( 'The Post Summary Settings have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_thumbnail_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['notices']            = $rtp_post_comments['notices'];
        $input['thumbnail_show']     = $default[1]['thumbnail_show'];
        $input['thumbnail_position'] = $default[1]['thumbnail_position'];
        $input['thumbnail_frame']    = $default[1]['thumbnail_frame'];
        add_settings_error( 'thumbnail', 'reset_thumbnail', __( 'The Post Thumbnail Settings have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_meta_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['notices']                   = $rtp_post_comments['notices'];
        $input['post_date_u']               = $default[1]['post_date_u'];
        $input['post_date_format_u']        = $default[1]['post_date_format_u'];
        $input['post_date_custom_format_u'] = $default[1]['post_date_custom_format_u'];
        $input['post_author_u']             = $default[1]['post_author_u'];
        $input['author_count_u']            = $default[1]['author_count_u'];
        $input['author_link_u']             = $default[1]['author_link_u'];
        $input['post_category_u']           = $default[1]['post_category_u'];
        $input['post_tags_u']               = $default[1]['post_tags_u'];
        $input['post_date_l']               = $default[1]['post_date_l'];
        $input['post_date_format_l']        = $default[1]['post_date_format_l'];
        $input['post_date_custom_format_l'] = $default[1]['post_date_custom_format_l'];
        $input['post_author_l']             = $default[1]['post_author_l'];
        $input['author_count_l']            = $default[1]['author_count_l'];
        $input['author_link_l']             = $default[1]['author_link_l'];
        $input['post_category_l']           = $default[1]['post_category_l'];
        $input['post_tags_l']               = $default[1]['post_tags_l'];
        $args                               = array( '_builtin' => false );
        $taxonomies                         = get_taxonomies( $args, 'names' );

        if ( !empty( $taxonomies ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $input['post_' . $taxonomy . '_u'] = '0';
                $input['post_' . $taxonomy . '_l'] = '0';
            }
        }
        add_settings_error( 'post_meta', 'reset_post_meta', __( 'The Post Meta Settings have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_pagination_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['notices']         = $rtp_post_comments['notices'];
        $input['pagination_show'] = $default[1]['pagination_show'];
        $input['prev_text']       = $default[1]['prev_text'];
        $input['next_text']       = $default[1]['next_text'];
        $input['end_size']        = $default[1]['end_size'];
        $input['mid_size']        = $default[1]['mid_size'];
        add_settings_error( 'pagination', 'reset_pagination', __( 'The Pagination Settings have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_comment_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['notices']          = $rtp_post_comments['notices'];
        $input['compact_form']     = $default[1]['compact_form'];
        $input['hide_labels']      = $default[1]['hide_labels'];
        $input['comment_textarea'] = $default[1]['comment_textarea'];
        $input['comment_separate'] = $default[1]['comment_separate'];
        add_settings_error( 'comment', 'reset_comment', __( 'The Comment Form Settings have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_gravatar_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);

        foreach ( $options as $option => $value )
            $input[$option] = $value;

        $input['notices']       = $rtp_post_comments['notices'];
        $input['gravatar_show'] = $default[1]['gravatar_show'];
        $input['gravatar_size'] = $default[1]['gravatar_size'];
        add_settings_error( 'gravatar', 'reset_gravatar', __( 'The Gravatar Settings have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_reset'] ) ) {
        $input = $default[1];
        $input['notices'] = $rtp_post_comments['notices'];
        $args = array( '_builtin' => false );
        $taxonomies = get_taxonomies( $args, 'names' );
        if ( !empty( $taxonomies ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $input['post_' . $taxonomy . '_u'] = '0';
                $input['post_' . $taxonomy . '_l'] = '0';
            }
        }
        add_settings_error( 'rtp_post_comments', 'reset_post_comments_options', __( 'All the rtPanel Post & Comments Settings have been restored to default.', 'rtPanel' ), 'updated' );
    }
    return $input; // return validated input
}

/**
 * Setup Default Values for rtPanel
 *
 * This function sets up default values for 'rtPanel' and creates
 * 2 options in the WordPress options table: 'rtp_general' &
 * 'rtp_post_comments', where the values for the 'General' and
 * 'Post & Comments' tabs are stored respectively
 *
 * @return array.
 *
 * @since rtPanel 2.0
 */
function rtp_theme_setup_values() {
    global $rtp_general, $rtp_post_comments;
    
    $default_general = array(
        'logo_show'       => '1',
        'use_logo'        => 'use_logo_url',
        'logo_url'        => RTP_IMG_FOLDER_URL . '/rtp-logo.jpg',
        'logo_upload'     => RTP_IMG_FOLDER_URL . '/rtp-logo.jpg',
        'login_head'      => '0',
        'use_favicon'     => 'use_favicon_url',
        'favicon_url'     => RTP_IMG_FOLDER_URL . '/favicon.ico',
        'favicon_upload'  => RTP_IMG_FOLDER_URL . '/favicon.ico',
        'fb_app_id'       => '',
        'fb_admins'       => '',
        'feedburner_url'  => '',
        'footer_sidebar'  => '1',
        'custom_styles'   => '',
        'search_code'     => '',
        'search_layout'   => '1',
    );

    $default_post_comments = array(
        'upgrade_theme'              => '0',
        'notices'                    => '0',
        'summary_show'               => '1',
        'word_limit'                 => 55,
        'read_text'                  => __( 'Read More&hellip;', 'rtPanel' ),
        'thumbnail_show'             => '1',
        'thumbnail_position'         => 'Right',
        'thumbnail_width'            => get_option( 'thumbnail_size_w' ),
        'thumbnail_height'           => get_option( 'thumbnail_size_h' ),
        'thumbnail_crop'             => get_option( 'thumbnail_crop' ),
        'thumbnail_frame'            => '0',
        'post_date_u'                => '1',
        'post_date_format_u'         => 'F j, Y',
        'post_date_custom_format_u'  => 'F j, Y',
        'post_author_u'              => '1',
        'author_count_u'             => '0',
        'author_link_u'              => '1',
        'post_category_u'            => '1',
        'post_tags_u'                => '0',
        'post_date_l'                => '0',
        'post_date_format_l'         => 'F j, Y',
        'post_date_custom_format_l'  => 'F j, Y',
        'post_author_l'              => '0',
        'author_count_l'             => '0',
        'author_link_l'              => '1',
        'post_category_l'            => '0',
        'post_tags_l'                => '0',
        'pagination_show'            => '1',
        'prev_text'                  => '&laquo; Previous',
        'next_text'                  => 'Next &raquo;',
        'end_size'                   => '1',
        'mid_size'                   => '2',
        'compact_form'               => '1',
        'hide_labels'                => '1',
        'comment_textarea'           => '0',
        'comment_separate'           => '1',
        'attachment_comments'        => '0',
        'gravatar_show'              => '1',
        'gravatar_size'              => '64',
    );

    $args = array( '_builtin' => false );
        $taxonomies = get_taxonomies( $args, 'names' );
        if ( !empty( $taxonomies ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $default_post_comments['post_' . $taxonomy . '_u'] = '0';
                $default_post_comments['post_' . $taxonomy . '_l'] = '0';
            }
        }

    if ( !get_option( 'rtp_general' ) ) {
        update_option( 'rtp_general', $default_general );
        $blog_users = get_users();

        foreach ( $blog_users as $blog_user ) {
            $blog_user_id = $blog_user->ID;
            if ( !get_user_meta( $blog_user_id, 'screen_layout_appearance_page_rtp_general' ) )
                update_user_meta( $blog_user_id, 'screen_layout_appearance_page_rtp_general', 1, NULL );
        }
    }
    if ( !get_option( 'rtp_post_comments' ) ) {
        update_option( 'rtp_post_comments', $default_post_comments );
        $blog_users = get_users();

        foreach ( $blog_users as $blog_user ) {
            $blog_user_id = $blog_user->ID;
            if ( !get_user_meta( $blog_user_id, 'screen_layout_appearance_page_rtp_post_comments' ) )
                update_user_meta( $blog_user_id, 'screen_layout_appearance_page_rtp_post_comments', 1, NULL );
        }
    }

    $rtp_version = rtp_export_version();
    if ( !get_option( 'rtp_version' ) || ( get_option( 'rtp_version' ) != $rtp_version['rtPanel'] ) ) {
        update_option( 'rtp_version', $rtp_version['rtPanel'] );
        $updated_general = wp_parse_args( $rtp_general, $default_general );
        $updated_post_comments = wp_parse_args( $rtp_post_comments, $default_post_comments );
        update_option( 'rtp_general', $updated_general );
        update_option( 'rtp_post_comments', $updated_post_comments );
    }

    return array( $default_general, $default_post_comments );
}