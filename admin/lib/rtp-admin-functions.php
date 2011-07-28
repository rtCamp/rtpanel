<?php
/**
 * rtPanel Admin Functions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

global $rtp_general, $rtp_post_comments, $rtp_hooks;

/* Define plugin support constants */
define( 'RTP_SUBSCRIBE_TO_COMMENTS', 'subscribe-to-comments/subscribe-to-comments.php' );
define( 'RTP_WP_PAGENAVI', 'wp-pagenavi/wp-pagenavi.php' );
define( 'RTP_BREADECRUMB_NAVXT', 'breadcrumb-navxt/breadcrumb_navxt_admin.php' );
define( 'RTP_REGENERATE_THUMBNAILS', 'regenerate-thumbnails/regenerate-thumbnails.php' );

// Redirect to rtPanel on theme activation
if ( is_admin() && isset ( $_GET['activated'] ) && $pagenow ==	'themes.php' ) {
    wp_redirect( 'themes.php?page=rtp_general' );
}

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

                if ( in_array( $logo_extension, array( 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'ico', 'tif', 'tiff' ) ) && ( $wp_remote_get['response'] == 200 ) && $input['logo_url'] != RT_BASE_IMG_FOLDER_URL . '/rtp-logo.jpg' ) {
                    $input['logo_url']    = $logo_file['url'];
                    $input['logo_upload'] = $rtp_general['logo_upload'];
                    add_settings_error( 'logo_upload', 'valid_logo_upload', __( 'The Logo Settings have been updated.', 'rtPanel' ), 'updated' );
                } else {
                    $file_object->delete( $logo_file['file'] );
                    $input['logo_url']    = $rtp_general['logo_url'];
                    $input['logo_upload'] = $rtp_general['logo_upload'];
                    add_settings_error('logo_upload', 'invalid_logo_upload', __( 'The Uploaded Image is invalid or is an invalid Logo Image type.', 'rtPanel' ) );
                }
            } elseif ( $input['use_logo'] == 'use_logo_upload' && $rtp_general['logo_upload'] != $input['logo_upload'] ){
                $logo_info           = pathinfo( $input['logo_upload'] );
                $logo_extension      = strtolower( $logo_info['extension'] );
                if ( in_array( $logo_extension, array( 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'ico', 'tif', 'tiff' ) ) )
                {
                    $input['logo_url'] = $rtp_general['logo_url'];
                    add_settings_error( 'logo_upload', 'valid_logo_upload', __( 'The Logo Settings have been updated.', 'rtPanel' ), 'updated' );
                } else {
                    $input['logo_upload'] = $rtp_general['logo_upload'];
                    $input['logo_url']    = $rtp_general['logo_url'];
                    add_settings_error( 'logo_upload', 'invalid_logo_upload', __( 'The Uploaded Image is invalid or is an invalid Logo Image type.', 'rtPanel' ) );
                }
            } else {
                $input['logo_upload'] = $rtp_general['logo_upload'];
                $input['logo_url']    = $rtp_general['logo_url'];
            }
        } else {
            $input['logo_url']    = $rtp_general['logo_url'];
            $input['logo_upload'] = $rtp_general['logo_upload'];
            $input['login_head']  = $rtp_general['login_head'];
        }

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

            if ( ( $favicon_extension == 'ico' ) && ( $wp_remote_get['response'] == 200 ) && $input['favicon_url'] != RT_BASE_IMG_FOLDER_URL . '/rtpanel-favicon.gif' ) {
                $input['favicon_url']    = $favicon_file['url'];
                $input['favicon_upload'] = $rtp_general['favicon_upload'];
                add_settings_error( 'favicon_upload', 'valid_favicon_upload', __( 'The Favicon Settings have been updated.', 'rtPanel' ), 'updated' );
            } else {
                $file_object->delete( $favicon_file['file'] );
                $input['favicon_url']    = $rtp_general['favicon_url'];
                $input['favicon_upload'] = $rtp_general['favicon_upload'];
                add_settings_error('favicon_upload', 'invalid_favicon_upload', 'The Uploaded Image is invalid or is an invalid Favicon Image type.');
            }
        }
        elseif ( $input['use_favicon'] == 'use_favicon_upload' && $rtp_general['favicon_upload'] != $input['favicon_upload'] ){
            $favicon_info      = pathinfo( $input['favicon_upload'] );
            $favicon_extension = strtolower( $favicon_info['extension'] );
            if ( $favicon_extension == 'ico' ) {
                $input['favicon_url'] = $rtp_general['favicon_url'];
                add_settings_error( 'favicon_upload', 'valid_favicon_upload', __( 'The Favicon Settings have been updated.', 'rtPanel' ), 'updated' );
            } else {
                $input['favicon_url']    = $rtp_general['favicon_url'];
                $input['favicon_upload'] = $rtp_general['favicon_upload'];
                add_settings_error( 'favicon_upload', 'invalid_favicon_upload', 'The Uploaded Image is invalid or is an invalid Favicon Image type.' );
            }
        } else {
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
            if ( !preg_match( '/customSearchControl.draw\(\'cse\'\);/i', $input['search_code'] ) ){
                $input['search_code'] = $rtp_general['search_code'];
                add_settings_error( 'search_code', 'invalid_search_code', __( 'Google Search Code Error : While generating the code the hosting option must be "Search Element" and layout either "full-width" or "compact". The changes made have been reverted.', 'rtPanel' ) );
            } elseif ( $input['search_code'] != $rtp_general['search_code'] ) {
                    add_settings_error( 'search_code', 'valid_search_code', __( 'Google Custom Search Integration has been updated.', 'rtPanel' ), 'updated' );
            }
        }
        
        if ( $_POST['subscribe-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( 'subscribe-to-comments/subscribe-to-comments.php' );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Subscribe to Comments Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['subscribe-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_deactivate'];
            if (!wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-deactivate' ) ) {
                add_settings_error( 'deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array( 'subscribe-to-comments/subscribe-to-comments.php' ) );
                add_settings_error( 'deactivate-plugin', 'plugin_activation', __( 'Subscribe to Comments Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['subscribe-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array( 'subscribe-to-comments/subscribe-to-comments.php' ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'Subscribe to Comments Plugin has been Deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( 'wp-pagenavi/wp-pagenavi.php' );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'WP PageNavi Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_deactivate'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-deactivate' ) ) {
                add_settings_error( 'deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.' ) );
            } else {
                deactivate_plugins( array ( 'wp-pagenavi/wp-pagenavi.php' ) );
                add_settings_error( 'deactivate-plugin', 'plugin_deactivation', __( 'WP PageNavi Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array ( 'wp-pagenavi/wp-pagenavi.php' ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'WP PageNavi Plugin has been Deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADECRUMB_NAVXT . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( 'breadcrumb-navxt/breadcrumb_navxt_admin.php' );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Breadcrumb NavXT Plugin has been Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_deactivate'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADECRUMB_NAVXT . '-deactivate' ) ) {
                add_settings_error('deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array( 'breadcrumb-navxt/breadcrumb_navxt_admin.php' ) );
                add_settings_error( 'deactivate-plugin', 'plugin_deactivation', __( 'Breadcrumb NavXT Plugin has been Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADECRUMB_NAVXT . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array( 'breadcrumb-navxt/breadcrumb_navxt_admin.php' ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'Breadcrumb NavXT Plugin has been Deleted.', 'rtPanel' ), 'updated' );
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
        'fb_admins'     => '',
        'feedburner_url'  => '',
        'footer_sidebar'  => '1',
        'custom_styles'   => '',
        'search_code'     => '',
        'search_layout'   => '1',
    );

    $default_post_comments = array(
        'notices'                    => '0',
        'summary_show'               => '1',
        'word_limit'                 => 55,
        'read_text'                  => __( 'Continue Reading...', 'rtPanel' ),
        'thumbnail_show'             => '1',
        'thumbnail_position'         => __( 'Right', 'rtPanel' ),
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
        'post_tags_l'                => '1',
        'compact_form'               => '0',
        'hide_labels'                => '0',
        'comment_textarea'           => '0',
        'comment_separate'           => '1',
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

/**
 * Feedburner Redirection Code
 *
 * @uses string $feed
 * @uses array $rtp_general
 *
 * @since rtPanel 2.0
 */
function rtp_feed_redirect() {
    global $feed, $rtp_general, $withcomments;
    if ( is_feed() && $feed != 'comments-rss2' && ( $withcomments != 1 ) && !is_singular() && !is_archive() && !empty( $rtp_general['feedburner_url'] ) ) {
        if ( function_exists( 'status_header' ) ) {
            status_header( 302 );
        }
        header( 'Location: ' . trim( $rtp_general['feedburner_url'] ) );
        header( 'HTTP/1.1 302 Temporary Redirect' );
        exit();
    }
}

/**
 * Used to check the feed type ( default or comment feed )
 *
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_check_url() {
    global $rtp_general;
    switch ( basename( $_SERVER['PHP_SELF'] ) ) {
        case 'wp-rss.php'         :
        case 'wp-rss2.php'        :
        case 'wp-atom.php'        :
        case 'wp-rdf.php'         : if ( trim( $rtp_general['feedburner_url'] ) != '') {
                                        if ( function_exists( 'status_header' ) ) {
                                            status_header( 302 );
                                        }
                                        header( 'Location: ' . trim( $rtp_general['feedburner_url'] ) );
                                        header( 'HTTP/1.1 302 Temporary Redirect' );
                                        exit();
                                    }
                                    break;

        case 'wp-commentsrss2.php': break;
    }
}

/* Condition to redirect WordPress feeds to feed burner */
if ( !preg_match( '/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
    add_action( 'template_redirect', 'rtp_feed_redirect' );
    add_action( 'init', 'rtp_check_url' );
}

/* condition to check Admin Login Logo option */
if ( $rtp_general['login_head'] && $rtp_general['logo_show'] ) {
    add_action( 'login_head', 'rtp_custom_login_logo' );
    add_filter( 'login_headerurl', 'rtp_login_site_url' );
}

/**
 * Dislays custom logo on Login Page
 *
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_custom_login_logo() {
    $custom_logo = rtp_logo_fav_src( $type = 'logo' );
    $size = @getimagesize( $custom_logo );
    echo '<style type="text/css">
        h1 a { background: url(' . $custom_logo . ') no-repeat scroll center top transparent;
               height: ' . $size[1] . 'px;
               width: ' . $size[0] . 'px; margin: 0 auto 15px; padding: 0; }
	</style>';
}

/**
 * Returns Home URL, to be used by custom logo
 * 
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_login_site_url() {
    return home_url('/');
}

/**
 * Modify options and structure of media upload dialog
 *
 * @param array $formfields Array of all the fields in form
 * @param object $post Global Post Object or similar object
 * @return Array
 *
 * @since rtPanel 2.0
 */
function rtp_theme_options_upload( $form_fields, $post ) {
    /* Can now see $post becaue the filter accepts two args, as defined in the add_fitler */
    if ( substr( $post->post_mime_type, 0, 5 ) == 'image' && ( preg_match( '/rtp_theme=rtp_true/i', @$_SERVER['HTTP_REFERER'] ) ) || preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) || isset( $_POST['rtp_theme'] ) ) {

        $form_fields['url']['label'] = 'Image Path';
        $form_fields['url']['input'] = 'html';

        $form_fields['post_excerpt']['value'] = '';
        $form_fields['post_excerpt']['input'] = 'hidden';

        $form_fields['post_content']['value'] = '';
        $form_fields['post_content']['input'] = 'hidden';

        $form_fields['image_alt']['value'] = '';
        $form_fields['image_alt']['input'] = 'hidden';

        $form_fields['align']['value'] = 'aligncenter';
        $form_fields['align']['input'] = 'hidden';

        $form_fields['image-caption']['value'] = 'caption';
        $form_fields['image-caption']['input'] = 'hidden';

        $form_fields['buttons'] = array(
            'label' => '',
            'value' => '',
            'input' => 'html'
        );
        $logo_or_favicon = ( preg_match( '/logo_or_favicon=Logo/', @$_SERVER['REQUEST_URI'] ) || preg_match( '/logo_or_favicon=Logo/', @$_SERVER['HTTP_REFERER'] ) ) ? 'Logo' : 'Favicon';
        $filename = basename( $post->guid );
        $attachment_id = $post->ID;
        if ( current_user_can( 'delete_post', $attachment_id ) ) {
            if ( !EMPTY_TRASH_DAYS ) {
                $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme' value='rtp_true' /><a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id", 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __( 'Delete Permanently' ) . '</a>';
            } elseif ( !MEDIA_TRASH ) {
                $form_fields['buttons']['html'] = "<input type='submit' class='button' name='send[$attachment_id]' value='" . esc_attr__('Use This', 'rtPanel' ) . "' /><a href='#' class='del-link' onclick=\"document.getElementById('del_attachment_$attachment_id').style.display='block';return false;\">" . __( 'Delete' ) . "</a>
                                                     <div id='del_attachment_$attachment_id' class='del-attachment' style='display:none;'>" . sprintf( __( 'You are about to delete <strong>%s</strong>.' ), $filename) . "
                                                     <a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id&amp;rtp_theme=rtp_true&amp;logo_or_favicon=$logo_or_favicon" , 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='button'>" . __( 'Continue' ) . "</a>
                                                     <a href='#' class='button' onclick=\"this.parentNode.style.display='none';return false;\">" . __( 'Cancel' ) . "</a>
                                                     <input type='hidden' name='rtp_theme' value='rtp_true' />
                                                     </div>";
            } else {
                $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme' value='rtp_true' /><a href='" . wp_nonce_url( "post.php?action=trash&amp;post=$attachment_id", 'trash-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __( 'Move to Trash' ) . "</a><a href='" . wp_nonce_url( "post.php?action=untrash&amp;post=$attachment_id", 'untrash-attachment_' . $attachment_id ) . "' id='undo[$attachment_id]' class='undo hidden'>" . __( 'Undo' ) . "</a>";
            }
        } else {
            $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme' value='rtp_true' />";
        }
    }
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'rtp_theme_options_upload', 11, 2 );

/**
 * Removes tabs from media upload iframe
 *
 * @param array $tabs Array of all the Tabs present
 * @return Array
 *
 * @since rtPanel 2.0
 */
function rtp_remove_url_tab( $tabs ) {
    unset($tabs['type_url']);
    return $tabs;
}

// Check to see if we are in rtPanel Options Page and modify the Media Upload iframe
if ( is_admin() && isset ( $_SERVER['HTTP_REFERER'] ) && ( preg_match( "/rtp_general/i", $_SERVER['HTTP_REFERER'] ) || preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) || preg_match( "/rtp_theme=rtp_true/i", $_SERVER['HTTP_REFERER'] )  || ( isset( $_POST['rtp_theme'] ) && preg_match( '/rtp_theme/i', $_POST['rtp_theme'] ) ) ) ) {
    add_filter( 'media_upload_tabs', 'rtp_remove_url_tab', 1, 2 );
}

/**
 * Default rtPanel admin sidebar with metabox styling
 *
 * @return rtPanel_admin_sidebar
 *
 * @since rtPanel 2.0
 */
function rtp_default_sidebar() { ?>
    <div class="postbox" id="social">
        <div title="<?php _e('Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><?php _e('Getting Social is Good', 'rtPanel'); ?></span></h3>
        <div class="inside" style="text-align:center;">
            <a href="<?php printf( '%s', 'http://www.facebook.com/rtPanel' ); ?>" target="_blank" title="<?php _e( 'Become a fan on Facebook', 'rtPanel' ); ?>" class="rtpanel-facebook"><?php _e( 'Facebook', 'rtPanel' ); ?></a>
            <a href="<?php printf( '%s', 'http://twitter.com/#!/rtPanel' ); ?>" target="_blank" title="<?php _e( 'Follow us on Twitter', 'rtPanel' ); ?>" class="rtpanel-twitter"><?php _e( 'Twitter', 'rtPanel' ); ?></a>
            <a href="<?php printf( '%s', 'http://feeds.feedburner.com/rtpanel' ); ?>" target="_blank" title="<?php _e( 'Subscribe to our feeds', 'rtPanel' ); ?>" class="rtpanel-rss"><?php _e( 'RSS Feed', 'rtPanel' ); ?></a>
        </div>
    </div>

    <div class="postbox" id="donations">
        <div title="<?php _e('Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><?php _e( 'Promote, Donate, Share', 'rtPanel' ); ?>...</span></h3>
        <div class="inside">
            <p><?php printf( __( 'Buy coffee/beer for team behind <a href="%s" title="rtPanel">rtPanel</a>.', 'rtPanel' ), 'http://rtpanel.com' ); ?></p>
            <div class="rt-paypal" style="text-align:center">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_donations" />
                    <input type="hidden" name="business" value="paypal@rtcamp.com" />
                    <input type="hidden" name="lc" value="US" />
                    <input type="hidden" name="item_name" value="rtPanel" />
                    <input type="hidden" name="no_note" value="0" />
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest" />
                    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />
                    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                </form>
            </div>
            <div class="rt-social-share" style="text-align:center; width: 127px; margin: 2px auto">
                <div class="rt-facebook" style="float:left; margin-right:5px;">
                    <a style=" text-align:center;" name="fb_share" type="box_count" share_url="http://bloggertowp.org/blogger-to-wordpress-redirection-plugin/"></a>
                </div>
                <div class="rt-twitter" style="">
                    <a href="<?php printf( '%s', 'http://twitter.com/share' ); ?>"  class="twitter-share-button" data-text="#rtPanel is awesome"  data-url="http://rtpanel.com" data-count="vertical" data-via="rtPanel"><?php _e( 'Tweet', 'rtPanel' ); ?></a>
                    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="postbox" id="support">
        <div title="<?php _e( 'Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><?php _e( 'Free Support', 'rtPanel' ); ?></span></h3>
        <div class="inside"><p><?php printf( __( 'If you have any problems with this plugin or good ideas for improvements, please talk about them in the <a href="%s" target="_blank" title="Click here for rtPanel Free Support">Support forums</a>', 'rtPanel' ), 'http://rtpanel.com/support' ); ?>.</p></div>
    </div>

    <div class="postbox" id="latest_news">
        <div title="<?php _e( 'Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><?php _e( 'Latest News', 'rtPanel' ); ?></span></h3>
        <div class="inside"><?php rtp_get_feeds(); ?></div>
    </div><?php
}

/**
 * Display feeds from a specified Feed URL
 *
 * @param string $feed_url The Feed URL.
 *
 * @since rtPanel 2.0
 */
function rtp_get_feeds( $feed_url='http://feeds.feedburner.com/rtpanel' ) {

    // Get RSS Feed(s)
    include_once( ABSPATH . WPINC . '/feed.php' );

    // Get a SimplePie feed object from the specified feed source.
    $rss = fetch_feed( $feed_url );
    if ( !is_wp_error( $rss ) ) { // Checks that the object is created correctly

        // Figure out how many total items there are, but limit it to 5.
        $maxitems = $rss->get_item_quantity( 5 );

        // Build an array of all the items, starting with element 0 (first element).
        $rss_items = $rss->get_items( 0, $maxitems );
        
    } ?>
    <ul><?php
        if ( $maxitems == 0 ) {
            echo '<li>'.__( 'No items', 'rtPanel' ).'.</li>';
        } else {
            // Loop through each feed item and display each item as a hyperlink.
            foreach ( $rss_items as $item ) { ?>
                <li>
                    <a href='<?php echo $item->get_permalink(); ?>' title='<?php echo __( 'Posted ', 'rtPanel' ) . $item->get_date( 'j F Y | g:i a' ); ?>'><?php echo $item->get_title(); ?></a>
                </li><?php
            }
        } ?>
    </ul><?php
}

/**
 * Adds rtPanel Contextual help
 *
 * @param string $contextual_help The Text to show
 * @param string $screen_id The Page on which to show
 * @param object $screen The screen information
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_contextual_help( $contextual_help, $screen_id, $screen ) {

    switch( $screen_id ) {
        case 'appearance_page_rtp_general' :
            $contextual_help = __( 'rtPanel is the world\'s easiest and smartest WordPress Theme. You can customize this theme and use it at your ease. You will find many state of the art options and widgets with rtPanel. ', 'rtPanel' );
            $contextual_help .= __( 'rtPanel is a theme for the world. Keeping this in mind our developers have made it localization ready. ', 'rtPanel' );
            $contextual_help .= __( 'Developers can use rtPanel as a basic and stripped to bones theme framework for developing their own creative and wonderful WordPress Themes.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( 'With the use of rtPanel developers and users can specify settings for basic functions (like date format, excerpt word count etc.) directly from theme options.', 'rtPanel' );
            $contextual_help .= __( ' rtPanel provides you with some theme options to manage some basic settings for your theme.', 'rtPanel' );
            $contextual_help .= __( ' Options provided for your convenience on this page are:', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Logo Settings:</strong> You can manage your theme’s logo from this setting.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Favicon Settings:</strong> You can manage your theme’s favicon from this setting.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Facebook Open Graph Settings:</strong> You can specify your Faceboook App ID/Admin ID(s) with this setting.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>FeedBurner Settings:</strong> You can specify your FeedBurner URL from this setting to redirect your feeds.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Google Custom Search Element Code:</strong> You can specify Google Custom Search Code here to use Google Search instead of default WordPress search.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Misc Settings:</strong> Tweak options like the footer sidebar, header image width and height.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Custom Styles:</strong> You can specify your own CSS styles in this option to override the default Style.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Plugin Support:</strong> You will get a summary of plugins status that are supported by rtPanel. This information box will allow you to manipulate the plugin settings on the fly.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Backup rtPanel Options:</strong> You can export or import all settings that you have configured in rtPanel.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>For more information, you can always visit:</strong>' , 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<a href="http://rtpanel.com" title="rtPanel Official Page">rtPanel Official Page</a>' , 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<a href="http://rtpanel.com/docs" title="rtPanel Documentation">rtPanel Documentation</a>' , 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<a href="http://rtpanel.com/support" title="rtPanel Forum">rtPanel Forum</a>' , 'rtPanel' );
            break;
        case 'appearance_page_rtp_post_comments' :
            $contextual_help = __( 'rtPanel is the world\'s easiest and smartest WordPress Theme. You can customize this theme and use it at your ease. You will find many state of the art options and widgets with rtPanel. ', 'rtPanel' );
            $contextual_help .= __( 'rtPanel is a theme for the world. Keeping this in mind our developers have made it localization ready. ', 'rtPanel' );
            $contextual_help .= __( 'Developers can use rtPanel as a basic and stripped to bones theme framework for developing their own creative and wonderful WordPress Themes.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( 'With the use of rtPanel developers and users can specify settings for basic functions (like date format, excerpt word count etc.) directly from theme options.', 'rtPanel' );
            $contextual_help .= __( ' rtPanel provides you with some theme options to manage some basic settings for your theme.', 'rtPanel' );
            $contextual_help .= __( ' Options provided for your convenience on this page are:', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Post Summaries Options:</strong> You can specify the different excerpt parameters like word count etc.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Post Thumbnail Options:</strong> This specify the post thumbnail options like position, size etc.', 'rtPanel' );
            $contextual_help .= '<br />';
            $contextual_help .= __( '<strong>NOTE:</strong> If you use this option to change height or width of the thumbnail, then please use Regenerate Thumbnails Plugin to apply the new dimension settings to your thumbnails.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Post Meta Options:</strong> You can specify the post meta options like post date format, display or hide author name and their positions in relation with the content.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Comment Form Settings:</strong> You can specify the comment form settings from this option.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>Gravtar Settings:</strong> You can specify the general Gravtar support from this option.', 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<strong>For more information, you can always visit:</strong>' , 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<a href="http://rtpanel.com" title="rtPanel Official Page">rtPanel Official Page</a>' , 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<a href="http://rtpanel.com/docs" title="rtPanel Documentation">rtPanel Documentation</a>' , 'rtPanel' );
            $contextual_help .= '<br /><br />';
            $contextual_help .= __( '<a href="http://rtpanel.com/support" title="rtPanel Forum">rtPanel Forum</a>' , 'rtPanel' );
            break;
    }

    return $contextual_help;
}
add_filter('contextual_help', 'rtp_contextual_help', 10, 3);

/**
 * Show rtPanel only to Admin Users ( Admin-Bar only !!! )
 *
 * @since rtPanel 2.0
 */
function rtp_admin_bar_init() {
    // Is the user sufficiently leveled, or has the bar been disabled?
    if ( !is_super_admin() || !is_admin_bar_showing() ) {
        return;
    }
    // Good to go, let's do this!
    add_action( 'admin_bar_menu', 'rtp_admin_bar_links', 500 );
}
add_action( 'admin_bar_init', 'rtp_admin_bar_init' );

/**
 * Adds rtPanel links to Admin Bar
 *
 * @uses object $wp_admin_bar
 *
 * @since rtPanel 2.0
 */
function rtp_admin_bar_links() {
    global $wp_admin_bar, $rt_panel_theme;

    // Links to add, in the form: 'Label' => 'URL'
    foreach( $rt_panel_theme->theme_pages as $key=>$theme_page ) {
            if ( is_array( $theme_page ) )
                $links[$theme_page['menu_title']] = admin_url( 'themes.php?page='.$theme_page['menu_slug'] );
    }

    //  Add parent link
    $wp_admin_bar->add_menu( array(
        'title' => 'rtPanel',
        'href' => admin_url( 'themes.php?page=rtp_general' ),
        'id' => 'rt_links',
    ) );

    // Add submenu links
    foreach ( $links as $label => $url ) {
        $wp_admin_bar->add_menu( array(
            'title' => $label,
            'href' => $url,
            'parent' => 'rt_links',
        ) );
    }
}

/**
 * Handles ajax call to remove the 'regenerate thumbnail' notice
 *
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.0
 */
function rtp_handle_regenerate_notice() {
    global $rtp_post_comments;
    if(isset( $_POST['hide_notice']) ) {
        $rtp_post_comments['notices'] = '0';
        update_option( 'rtp_post_comments', $rtp_post_comments );
    }
}
add_action( 'wp_ajax_hide_regenerate_thumbnail_notice', 'rtp_handle_regenerate_notice' );

/**
 * Returns 'src' value for Logo / Favicon
 *
 * @uses $rtp_general array
 * @param string $type Optional. Deafult is 'logo'. logo' or 'favicon'
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_logo_fav_src( $type = 'logo' ) {
    global $rtp_general;

    if( $type == 'logo' ) {
        if( $rtp_general['use_logo'] == 'use_logo_url' ) {
            return $rtp_general['logo_url'];
        } elseif ( $rtp_general['use_logo'] == 'use_logo_upload' ) {
            return $rtp_general['logo_upload'];
        }
    } else if($type == 'favicon') {
        if( $rtp_general['use_favicon'] == 'use_favicon_url' ) {
            return $rtp_general['favicon_url'];
        } elseif ( $rtp_general['use_favicon'] == 'use_favicon_upload' ) {
            return $rtp_general['favicon_upload'];
        }
    } else {
        return false;
    }
}

/**
 * Controls file-types for Logo / Favicon uploads
 * 
 * @param array $mime_types The allowed mime types
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_allowed_upload_extensions( $mime_types ) {
	//Creating a new array will reset the allowed filetypes
	if ( preg_match( '/logo_or_favicon=Logo/', @$_SERVER['HTTP_REFERER'] ) || ( ( preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) ) && ( preg_match( '/logo_or_favicon=Logo/', $_SERVER['REQUEST_URI'] ) ) ) ) {
            $mime_types = array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'gif'          => 'image/gif',
                'png'          => 'image/png',
                'bmp'          => 'image/bmp',
                'ico'          => 'image/x-icon',
                'tif|tiff'     => 'image/tiff'
            );
        } elseif ( preg_match( '/logo_or_favicon=Favicon/', @$_SERVER['HTTP_REFERER'] ) || ( ( preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) ) && ( preg_match( '/logo_or_favicon=Favicon/', $_SERVER['REQUEST_URI'] ) ) ) ) {
            $mime_types = array(
                'ico' => 'image/x-icon'
            );
        }
	return $mime_types;
}
add_filter( 'upload_mimes', 'rtp_allowed_upload_extensions', 1, 1 );

/**
 * Bypasses Flash Media Uploader
 *
 * @since rtPanel 2.0
 */
function rtp_media_upload_flash_bypass() {
        echo "<input type='hidden' name='rtp_theme' value='rtp_true' />";
        if ( preg_match( '/logo_or_favicon=Favicon/', @$_SERVER['HTTP_REFERER'] ) || preg_match("/logo_or_favicon=Favicon/", $_SERVER['REQUEST_URI']) ) {
            echo '<script type="text/javascript">
                      jQuery("#tab-type a").attr("href","/wp-admin/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Favicon&type=image&TB_iframe=true&tab=type" );
                      jQuery("#tab-library a").attr("href","/wp-admin/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Favicon&type=image&TB_iframe=true&tab=library" );
                  </script>';
        } else {
            echo '<script type="text/javascript">
                      jQuery("#tab-type a").attr("href","/wp-admin/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Logo&type=image&TB_iframe=true&tab=type" );
                      jQuery("#tab-library a").attr("href","/wp-admin/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Logo&type=image&TB_iframe=true&tab=library" );
                  </script>';
        }
}

/**
 * Bypasses Browser Media Uploader
 *
 * @since rtPanel 2.0
 */
function rtp_media_upload_html_bypass( $flash = true ) {
    echo "<input type='hidden' name='rtp_theme' value='rtp_true' />";
    if ( preg_match( '/logo_or_favicon=Favicon/', @$_SERVER['HTTP_REFERER'] ) || preg_match( "/logo_or_favicon=Favicon/", $_SERVER['REQUEST_URI'] ) ) {
        $favicon = '<script type="text/javascript">
                        jQuery("#tab-type a").attr("href","/wp-admin/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Favicon&type=image&TB_iframe=true&tab=type" );
                        jQuery("#tab-library a").attr("href","/wp-admin/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Favicon&type=image&TB_iframe=true&tab=library" );
                    </script>';
        echo $favicon;
    } else {
        $logo = '<script type="text/javascript">
                        jQuery("#tab-type a").attr("href","/wp-admin/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Logo&type=image&TB_iframe=true&tab=type" );
                        jQuery("#tab-library a").attr("href","/wp-admin/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Logo&type=image&TB_iframe=true&tab=library" );
                 </script>';
        echo $logo;
    }
}

/**
 * Adds a hidden input field to media library iframe
 *
 * @since rtPanel 2.0
 */
function add_hidden_rtp_variable(){
    echo "<script type='text/javascript'>
            jQuery('p#media-search').append('<input type=\"hidden\" name=\"rtp_theme\" value=\"rtp_true\" />');
          </script>";
}

/* Added filter on rtPanel Options Page Only */
if ( ( preg_match( '/rtp_theme=rtp_true/i', @$_SERVER['HTTP_REFERER'] ) ) || ( preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) ) || ( isset( $_POST['rtp_theme'] ) && preg_match( '/rtp_theme/i', $_POST['rtp_theme'] ) ) ) {
    add_filter( 'flash_uploader', create_function('$flash', 'return false;'), 7 );
    add_action( 'post-flash-upload-ui', 'rtp_media_upload_flash_bypass' );
    add_action( 'post-html-upload-ui', 'rtp_media_upload_html_bypass' );
    add_action('admin_print_footer_scripts', 'add_hidden_rtp_variable');
}

/**
 * Used for redirection within the media library iframe
 * 
 * @param string $location Location to redirect
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_media_library_redirect( $location ) {
    $logo_or_favicon = ( preg_match( "/logo_or_favicon=Logo/", @$_SERVER['HTTP_REFERER'] ) || preg_match( "/logo_or_favicon=Logo/", @$_SERVER['REQUEST_URI'] ) ) ? "Logo" : "Favicon";
    $location .= '&rtp_theme=rtp_true&logo_or_favicon='.$logo_or_favicon;
    return $location;
}

/* Added filter for the redirection in the iframe on rtPanel Options Page Only */
if( preg_match( "/rtp_theme=rtp_true/i", @$_SERVER['HTTP_REFERER'] ) || preg_match( "/rtp_theme=rtp_true/i", $_SERVER['REQUEST_URI'] ) ) {
    add_filter( 'media_upload_form_url', 'rtp_media_library_redirect', 99, 1 );
    if ( isset( $_POST['save'] ) ) {
        wp_redirect(str_replace('tab=type', 'tab=library', @$_SERVER['HTTP_REFERER']));
    }
    elseif ( ( @$_GET['post-query-submit'] || @$_GET['s']) && !@$_GET['rtp_theme'] ) {
        $logo_or_favicon = ( preg_match( '/Logo/', $_SERVER['HTTP_REFERER'] ) ) ? 'Logo' : 'Favicon';
        wp_redirect( $_SERVER['REQUEST_URI'].'&rtp_theme=rtp_true&logo_or_favicon='.$logo_or_favicon );
    }
}

/**
 * Creates rtPanel Options backup file
 * 
 * @uses $wpdb object
 *
 * @since rtPanel 2.0
 */
function rtp_export( ) {
    global $wpdb;
    $sitename = sanitize_key( get_bloginfo( 'name' ) );

    if ( ! empty($sitename) ) $sitename .= '.';

    $filename = $sitename . 'rtpanel.' . date( 'Y-m-d' ) . '.rtp';
  
    $general = "WHERE option_name = 'rtp_general'";
    $post_comments = "WHERE option_name = 'rtp_post_comments'";
    $hooks = "WHERE option_name = 'rtp_hooks'";
    $args['rtp_general'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $general" );
    $args['rtp_post_comments'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $post_comments" );
    $args['rtp_hooks'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $hooks" ); 
    
    header( 'Content-Description: File Transfer' );
    header( 'Content-Disposition: attachment; filename=' . $filename );
    header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true ); ?>
<rtpanel>
    <rtp_version><?php echo maybe_serialize( rtp_export_version() ); ?></rtp_version>
    <rtp_general><?php echo $args['rtp_general']; ?></rtp_general>
    <rtp_post_comments><?php echo $args['rtp_post_comments']; ?></rtp_post_comments>
</rtpanel>
<?php
}

/**
 * Restores rtPanel Options
 *
 * @uses $rtp_general array
 * @uses $rtp_post_comments array
 * @uses $rtp_hooks array
 * @param string $file The
 * @return bool|array
 *
 * @since rtPanel 2.0
 */
function rtp_import( $file ) {
    global $rtp_general, $rtp_post_comments;
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php' );
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php' );
    require_once( ABSPATH . '/wp-admin/includes/file.php' );

    @$file_object = new WP_Filesystem_Direct;
    $overrides = array( 'test_form' => false, 'test_type' => false );    
    $import_file = wp_handle_upload( $file, $overrides );
    extract( wp_check_filetype( $import_file['file'], array('rtp' => 'txt/rtp') ) );
    $data = wp_remote_get( $import_file['url'] );
    $file_object->delete( $import_file['file'] );
    if ( $ext != 'rtp' ) {
         return 'ext';
    }
    if ( is_wp_error( $data ) ) {
        return false;
    } else {
        preg_match('/\<rtp_general\>(.*)<\/rtp_general\>/is', $data['body'], $general);
        preg_match('/\<rtp_post_comments\>(.*)<\/rtp_post_comments\>/is', $data['body'], $post_comments);
        if( !empty( $post_comments[1] ) ) {
            update_option( 'rtp_post_comments', maybe_unserialize( $post_comments[1] ) );
        }
        return $general[1];
    }
}

/**
 * Adds Custom Logo to Admin Dashboard ;)
 *
 * @since rtPanel 2.0
 */
function rtp_custom_admin_logo() {
   echo '<style type="text/css"> #header-logo { background: url("' . RTP_IMG_FOLDER_URL . '/rtp-icon-small.jpg") no-repeat scroll center center transparent !important; } </style>';
}
add_action( 'admin_head', 'rtp_custom_admin_logo' );

/**
 * Adds custom footer text
 *
 * @since rtPanel 2.0
 */
function rtp_custom_admin_footer() {
    printf( '<span id="footer-thankyou">' . __( 'Thank you for creating with <a href="%s" target="_blank">WordPress</a>.', 'rtPanel' ) . '</span> | ' . __( '<a href="%s" target="_blank">Documentation</a>', 'rtPanel' ) . ' | ' . __( '<a href="%s" target="_blank">Feedback</a>', 'rtPanel' ) . '
        <br /><br />' . __( 'Currently using <a href="%s" title="rtPanel.com" target="_blank">rtPanel</a>', 'rtPanel' ) . ' |
        ' . __( '<a href="%s" title="Click here for rtPanel Free Support" target="_blank">Support</a>', 'rtPanel' ) . ' |
        ' . __( '<a href="%s" title="Click here for rtPanel Documentation" target="_blank">Documentation</a>', 'rtPanel' ), 'http://wordpress.org/', 'http://codex.wordpress.org/', 'http://wordpress.org/support/forum/4', 'http://rtpanel.com/', 'http://rtpanel.com/support', 'http://rtpanel.com/docs' );
}
add_filter( 'admin_footer_text', 'rtp_custom_admin_footer' );

/**
 * Gets rtPanel and WordPress version
 *
 * @since rtPanel 2.0
 */
function rtp_export_version() {
    global $wp_version;
    require_once( ABSPATH . '/wp-admin/includes/update.php' );
    $theme_info = get_theme( get_current_theme() );
    $theme_version = array( 'wp' => $wp_version, 'rtPanel' => $theme_info['Version'] );
    return $theme_version;
}

/**
 * Gets rtPanel and WordPress version (in text) for footer
 *
 * @since rtPanel 2.0
 */
function rtp_version() {
    require_once( ABSPATH . '/wp-admin/includes/update.php' );
    $theme_info = get_theme( get_current_theme() );
    $theme_version = core_update_footer() . '<br /><br />' . __( 'rtPanel Version ', 'rtPanel' ) . $theme_info['Version'];
    return $theme_version;
}
add_filter( 'update_footer', 'rtp_version', 9999 );

/**
 *  Display the regenerate thumbnail notice
 *
 * @since rtPanel 2.0
 */
function rtp_regenerate_thumbnail_notice( $return = false ) {
    if ( is_plugin_active( RTP_REGENERATE_THUMBNAILS ) ) {
        $regenerate_link = admin_url( '/tools.php?page=regenerate-thumbnails' );
    } elseif ( array_key_exists( RTP_REGENERATE_THUMBNAILS, get_plugins() ) ) {
        $regenerate_link = admin_url( '/plugins.php#regenerate-thumbnails' );
    } else {
        $regenerate_link = wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=regenerate-thumbnails' ), 'install-plugin_regenerate-thumbnails' );
    }

    if( $return ) {
        return $regenerate_link;
    } else {
        echo '<div class="error regenerate_thumbnail_notice"><p>' . sprintf( __( 'The Thumbnail Settings have been updated. Please <a href="%s" title="Regenerate Thumbnails">Regenerate Thumbnails</a>', 'rtPanel' ), $regenerate_link ) . ' <a class="alignright regenerate_thumbanil_notice_close" href="#">X</a></p></div>';
    }
}

/* Shows 'regenerate thumbnail' notice ( Admin User Only !!! ) */
if ( is_admin() && @$rtp_post_comments['notices'] ) {
    add_action( 'admin_notices', 'rtp_regenerate_thumbnail_notice');
}


/**
 * Outputs neccessary script to hide 'regenerate thumbnail' notice
 *
 * @since rtPanel 2.0
 */
function rtp_regenerate_thumbnail_notice_js() { ?>
    <script type="text/javascript" >
    jQuery(function(){
        jQuery('.regenerate_thumbanil_notice_close').click(function(){
            jQuery('.regenerate_thumbnail_notice').hide();
            // call ajax
            jQuery.ajax({
                url:"/wp-admin/admin-ajax.php",
                type:'POST',
                data:'action=hide_regenerate_thumbnail_notice&hide_notice=1'
            });
        });
    });
    </script><?php
}
add_action( 'admin_head', 'rtp_regenerate_thumbnail_notice_js' );

/* Removes 'regenerate thumbnail' notice ( Admin User Only !!! ) */
if ( is_admin() && $pagenow == 'tools.php' && ( @$_GET['page'] == 'regenerate-thumbnails' ) && @$_POST['regenerate-thumbnails'] ) {
    $rtp_notice = get_option('rtp_post_comments');
    $rtp_notice['notices'] = '0';
    update_option( 'rtp_post_comments', $rtp_notice );
}

/* Check if regeneration of thumbnail is required, or not */
if ( is_array( $rtp_post_comments ) && ( @$rtp_post_comments['thumbnail_width'] != get_option( 'thumbnail_size_w' ) || @$rtp_post_comments['thumbnail_height'] != get_option( 'thumbnail_size_h' ) || @$rtp_post_comments['thumbnail_crop'] != get_option( 'thumbnail_crop' ) ) ) {
    $rtp_post_comments['notices'] = '1';
    $rtp_post_comments['thumbnail_width'] = get_option( 'thumbnail_size_w' );
    $rtp_post_comments['thumbnail_height'] = get_option( 'thumbnail_size_h' );
    $rtp_post_comments['thumbnail_crop'] = get_option( 'thumbnail_crop' );
    update_option( 'rtp_post_comments', $rtp_post_comments );
}