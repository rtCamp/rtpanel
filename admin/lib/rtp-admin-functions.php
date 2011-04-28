<?php
/**
 * This file contains all the functions for handling rtPanel Admin.
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */
$rtp_general = get_option( 'rtp_general' );
$rtp_post_comments = get_option( 'rtp_post_comments' );
$rtp_hooks = get_option( 'rtp_hooks' );

/**
 * Used to Validate data for some/all of the input fields in General Options Tab.
 * @uses $rtp_general array
 * @return Array
 */
function rtp_general_validate( $input ) {
    global $rtp_general;
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
                        @unlink( $logo_file['file'] );
                }

                if ( in_array( $logo_extension, array( 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'ico', 'tif', 'tiff' ) ) && ( $wp_remote_get['response'] == 200 ) && $input['logo_url'] != RT_BASE_IMG_FOLDER_URL . '/rtpanel-logo.jpg' ) {
                    $input['logo_url']    = $logo_file['url'];
                    $input['logo_upload'] = $rtp_general['logo_upload'];
                    add_settings_error( 'logo_upload', 'valid_logo_upload', __( 'The Logo Image Was Updated Successfully.', 'rtPanel' ), 'updated' );
                } else {
                    @unlink( $logo_file['file'] );
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
                    add_settings_error( 'logo_upload', 'valid_logo_upload', __( 'The Logo Image Was Updated Successfully.', 'rtPanel' ), 'updated' );
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
                        @unlink( $favicon_file['file'] );
                }

                if ( ( $favicon_extension == 'ico' ) && ( $wp_remote_get['response'] == 200 ) && $input['favicon_url'] != RT_BASE_IMG_FOLDER_URL . '/rtpanel-favicon.gif' ) {
                    $input['favicon_url']    = $favicon_file['url'];
                    $input['favicon_upload'] = $rtp_general['favicon_upload'];
                    add_settings_error( 'favicon_upload', 'valid_favicon_upload', __( 'The Favicon Image Was Updated Successfully.', 'rtPanel' ), 'updated' );
                } else {
                    @unlink( $favicon_file['file'] );
                    $input['favicon_url']    = $rtp_general['favicon_url'];
                    $input['favicon_upload'] = $rtp_general['favicon_upload'];
                    add_settings_error('favicon_upload', 'invalid_favicon_upload', 'The Uploaded Image is invalid or is an invalid Favicon Image type.');
                }

        }
        elseif ( $input['use_favicon'] == 'use_favicon_upload' && $rtp_general['favicon_upload'] != $input['favicon_upload'] ){
            $favicon_info           = pathinfo( $input['favicon_upload'] );
            $favicon_extension      = strtolower( $favicon_info['extension'] );
            if ( $favicon_extension == 'ico' )
            {
                $input['favicon_url'] = $rtp_general['favicon_url'];
                add_settings_error( 'favicon_upload', 'valid_favicon_upload', __( 'The Favicon Image Was Updated Successfully.', 'rtPanel' ), 'updated' );
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
                add_settings_error( 'feedburner_url', 'invalid_feedburner_url', __( 'The FeedBurner URL has been updated.', 'rtPanel' ), 'updated' );
            }
        }

        if ( !empty( $input['search_code'] ) ) {
            if ( !preg_match( '/customSearchControl.draw\(\'cse\'\);/i', $input['search_code'] ) ){
                $input['search_code'] = $rtp_general['search_code'];
                add_settings_error( 'search_code', 'invalid_search_code', __( 'Google Search Code Error : While generating the code the hosting option must be "Search Element" and layout either "full-width" or "compact". The changes made have been reverted.', 'rtPanel' ) );
            } elseif ( $input['search_code'] != $rtp_general['search_code'] ) {
                    add_settings_error( 'search_code', 'valid_search_code', __( 'Google Custom Search Integration ID has been updated.', 'rtPanel' ), 'updated' );
            }
        }

        if ( $_POST['subscribe-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( 'subscribe-to-comments/subscribe-to-comments.php' );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Plugin Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['subscribe-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_deactivate'];
            if (!wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-deactivate' ) ) {
                add_settings_error( 'deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array( 'subscribe-to-comments/subscribe-to-comments.php' ) );
                add_settings_error( 'deactivate-plugin', 'plugin_activation', __( 'Plugin Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['subscribe-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_subscribe_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_SUBSCRIBE_TO_COMMENTS . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array( 'subscribe-to-comments/subscribe-to-comments.php' ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'The selected plugins have been deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( 'wp-pagenavi/wp-pagenavi.php' );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Plugin Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_deactivate'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-deactivate' ) ) {
                add_settings_error( 'deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.' ) );
            } else {
                deactivate_plugins( array ( 'wp-pagenavi/wp-pagenavi.php' ) );
                add_settings_error( 'deactivate-plugin', 'plugin_deactivation', __( 'Plugin Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['pagenavi-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_pagenavi_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_WP_PAGENAVI . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array ( 'wp-pagenavi/wp-pagenavi.php' ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'The selected plugins have been deleted.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-activate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_activate'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADECRUMB_NAVXT . '-activate' ) ) {
                add_settings_error( 'activate-plugin', 'failure_plugin_activation', __( 'You do not have sufficient permissions to activate this plugin.', 'rtPanel' ) );
            } else {
                activate_plugin( 'breadcrumb-navxt/breadcrumb_navxt_admin.php' );
                add_settings_error( 'activate-plugin', 'plugin_activation', __( 'Plugin Activated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-deactivate'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_deactivate'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADECRUMB_NAVXT . '-deactivate' ) ) {
                add_settings_error('deactivate-plugin', 'failure_plugin_deactivation', __( 'You do not have sufficient permissions to deactivate this plugin.', 'rtPanel' ) );
            } else {
                deactivate_plugins( array( 'breadcrumb-navxt/breadcrumb_navxt_admin.php' ) );
                add_settings_error( 'deactivate-plugin', 'plugin_deactivation', __( 'Plugin Deactivated.', 'rtPanel' ), 'updated' );
            }
        } elseif ( $_POST['breadcrumb-delete'] == 1 ) {
            $nonce = $_REQUEST['_wpnonce_breadcrumb_delete'];
            if ( !wp_verify_nonce( $nonce, RTP_BREADECRUMB_NAVXT . '-delete' ) ) {
                add_settings_error( 'delete-plugin', 'failure_plugin_deletion', __( 'You do not have sufficient permissions to delete this plugin.', 'rtPanel' ) );
            } else {
                delete_plugins( array( 'breadcrumb-navxt/breadcrumb_navxt_admin.php' ) );
                add_settings_error( 'delete-plugin', 'plugin_deletion', __( 'The selected plugins have been deleted.', 'rtPanel' ), 'updated' );
            }
        }

    } elseif ( isset ( $_POST['rtp_logo_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['logo_show']    = $default[0]['logo_show'];
        $input['use_logo']    = $default[0]['use_logo'];
        $input['logo_url']    = $default[0]['logo_url'];
        $input['logo_upload'] = $default[0]['logo_upload'];
        $input['login_head']  = $default[0]['login_head'];
        add_settings_error( 'logo_upload', 'logo_reset', __( 'The Logo has been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_fav_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['use_favicon'] = $default[0]['use_favicon'];
        $input['favicon_url'] = $default[0]['favicon_url'];
        $input['favicon_upload'] = $default[0]['favicon_upload'];
        add_settings_error( 'favicon_upload', 'fav_reset', __( 'The Favicon has been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_feed_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['feedburner_url'] = $default[0]['feedburner_url'];
        add_settings_error( 'feedburner_url', 'reset_feeburner_url', __( 'The Feedburner URL has been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_google_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['search_code'] = $default[0]['search_code'];
        add_settings_error( 'search_code', 'reset_search_code', __( 'The Search Code has been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset($_POST['rtp_custom_styles_reset'] ) ) {
        $options = maybe_unserialize( $rtp_general );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['custom_styles'] = $default[0]['custom_styles'];
        add_settings_error( 'custom_styles', 'reset_custom_styles', __( 'The Custom Styles has been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_export'] ) ) {
        rtp_export( );
	die();
    } elseif ( isset ( $_POST['rtp_import'] ) ) {
        $general = rtp_import($_FILES['rtp_import']);
        if( $general ) {
            unset($input);
            $input = maybe_unserialize($general);
            add_settings_error( 'rtp_import', 'import', __( 'rtPanel Options Have been imported successfully', 'rtPanel' ), 'updated' );
        }
        else {
            add_settings_error( 'rtp_import', 'no_import', __( 'There was an error while importing', 'rtPanel' ) );
        }
    } elseif ( isset($_POST['rtp_reset'] ) ) {
        $input = $default[0];
        add_settings_error( 'rtp_general', 'reset_general_options', __( 'All the rtPanel General Options have been restored to default.', 'rtPanel' ), 'updated' );
    } 
    return $input; /* Return validated input. */
}

/**
 * Used to Validate data for some/all of the input fields in Post Comments Options Tab
 * @uses $rtp_post_comments array
 * @param array $input all post & comments options inputs.
 * @return Array
 */
function rtp_post_comments_validate( $input ) {
    global $rtp_post_comments;
    $default = rtp_theme_setup_values();
    
    if ( isset ( $_POST['rtp_submit'] ) ) {
        
        if ( $input['summary_show'] ) {
            if ( $input['read_text'] != $rtp_post_comments['input'] ) {
                $input['read_text'] = trim( $input['read_text']);
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
                    add_settings_error( 'thumbnail_width', 'valid_thumbnail_width', __( 'The Thumbnail Width has been updated', 'rtPanel' ), 'updated' );
                }
                if ( !preg_match( '/^[0-9]{1,3}$/i', $input['thumbnail_height'] ) ) {
                    $input['thumbnail_height'] = get_option( 'thumbnail_size_h' );
                    add_settings_error( 'thumbnail_height', 'invalid_thumbnail_height', __( 'The Thumbnail Height provided is invalid. Please provide a proper value.', 'rtPanel' ) );
                } elseif ( get_option( 'thumbnail_size_h' ) != $input['thumbnail_height'] ) {
                    $input['notices'] = '1';
                    update_option( 'thumbnail_size_h', $input['thumbnail_height'] );
                    add_settings_error( 'thumbnail_height', 'valid_thumbnail_height', __( 'The Thumbnail Height has been updated', 'rtPanel' ), 'updated' );
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
        $input['author_count_u']            = $rtp_post_comments['author_count_u'];
        $input['author_link_u']             = $rtp_post_comments['author_link_u'];
    }
    if ( !$input['post_author_l'] ) {
        $input['author_count_l']            = $rtp_post_comments['author_count_l'];
        $input['author_link_l']             = $rtp_post_comments['author_link_l'];
    }
    if ( !$input['name_email_url_show'] ) {
        $input['comment_textarea']             = $rtp_post_comments['comment_textarea'];
    }
    if ( !$input['gravatar_show'] ) {
        $input['gravatar_size']             = $rtp_post_comments['gravatar_size'];
    }

    } elseif ( isset ( $_POST['rtp_summary_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['summary_show'] = $default[1]['summary_show'];
        $input['word_limit']   = $default[1]['word_limit'];
        $input['read_text']    = $default[1]['read_text'];
        add_settings_error( 'summary', 'reset_summary', __( 'The Summary options have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_thumbnail_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['thumbnail_show']     = $default[1]['thumbnail_show'];
        $input['thumbnail_position'] = $default[1]['thumbnail_position'];
        $input['thumbnail_frame']    = $default[1]['thumbnail_frame'];
        add_settings_error( 'thumbnail', 'reset_thumbnail', __( 'The Thumbnail options have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_meta_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
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
        add_settings_error( 'post_meta', 'reset_post_meta', __( 'The Post Meta options have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_comment_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['comment_textarea']    = $default[1]['comment_textarea'];
        $input['name_email_url_show'] = $default[1]['name_email_url_show'];
        $input['comment_separate']    = $default[1]['comment_separate'];
        add_settings_error( 'comment', 'reset_comment', __( 'The Comment options have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_gravatar_reset'] ) ) {
        $options = maybe_unserialize( $rtp_post_comments );
        unset($input);
        foreach ( $options as $option=>$value )
            $input[$option] = $value;
        $input['gravatar_show'] = $default[1]['gravatar_show'];
        $input['gravatar_size'] = $default[1]['gravatar_size'];
        add_settings_error( 'gravatar', 'reset_gravatar', __( 'The Gravatar options have been restored to default.', 'rtPanel' ), 'updated' );
    } elseif ( isset ( $_POST['rtp_reset'] ) ) {
        $input = $default[1];

        $args = array( '_builtin' => false );
        $taxonomies = get_taxonomies( $args, 'names' );
        if ( !empty( $taxonomies ) ) {
            foreach ( $taxonomies as $taxonomy ) {
                $input['post_' . $taxonomy . '_u'] = '0';
                $input['post_' . $taxonomy . '_l'] = '0';
            }
        }
        add_settings_error( 'rtp_post_comments', 'reset_post_comments_options', __( 'All the rtPanel Post & Comments Options have been restored to default.', 'rtPanel' ), 'updated' );
    }
    //unset ( $input['thumbnail_height'] );
    //unset ( $input['thumbnail_width'] );
    //unset ( $input['thumbnail_crop'] );
    return $input; // return validated input
}

/**
 * Setup Default Values for rtPanel
 *
 * This function sets up all the default values for 'rtPanel' and creates
 * two options in the wordpress database options table 'rtp_general' &
 * 'rtp_post_comments' where the values for the 'General' and
 * 'Post Comments' tabs are stored respectively
 *
 * The normal, expected behavior of this function is to return the values
 *
 * @return array.
 */
function rtp_theme_setup_values() {
    global $rtp_post_comments;
    $default_general = array(
        'logo_show'       => '0',
        'use_logo'        => 'use_logo_url',
        'logo_url'        => RTP_IMG_FOLDER_URL . '/rtpanel-logo.jpg',
        'logo_upload'     => RTP_IMG_FOLDER_URL . '/rtpanel-logo.jpg',
        'login_head'      => '0',
        'use_favicon'     => 'use_favicon_url',
        'favicon_url'     => RTP_IMG_FOLDER_URL . '/favicon.ico',
        'favicon_upload'  => RTP_IMG_FOLDER_URL . '/favicon.ico',
        'feedburner_url'  => '',
        'custom_styles'   => '',
        'search_code'     => '',
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
        'comment_textarea'           => '0',
        'name_email_url_show'        => '1',
        'comment_separate'           => '1',
        'gravatar_show'              => '1',
        'gravatar_size'              => '64 x 64',
    );

    if( isset ( $rt_post_comments ) ) {
        $default_general = array( 'thumbnail_width' => $rt_post_comments['thumbnail_width'], 'thumbnail_height' => $rt_post_comments['thumbnail_height'], 'thumbnail_crop' );
    }

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
    return array( $default_general, $default_post_comments );
}

/**
 * Feedburner Redirection Code
 *
 * Used to redirect the default wordpress feeds.
 * @uses string $feed
 * @uses array $rtp_general
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
 * Used to check the feed type (default or comment feed)
 * @uses $rtp_general array
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

/* Condition to redirect wordpress feeds to feed burner */
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
 * Custom Admin Logo
 *
 * Used to display logo on the Login Page
 * @uses $rtp_general array
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
 * Used to change link of logo on login page
 * @return string
 */
function rtp_login_site_url() {
    return home_url('/');
}

/**
 * Function to modify the options and structure of the media upload dialog
 *
 * @param array $formfields Array of all the fields in form
 * @param object $post Global Post Object or similar object
 *
 * @return Array
 */
function rtp_theme_options_upload( $form_fields, $post ) {
    /* Can now see $post becaue the filter accepts two args, as defined in the add_fitler */
    if ( substr( $post->post_mime_type, 0, 5 ) == 'image' && ( preg_match( '/rtp_theme=rtp_true/i', @$_SERVER['HTTP_REFERER'] ) ) || preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) || isset( $_POST['rtp_theme_true'] ) ) {

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
                $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme_true' value='rtp_theme_true' /><a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id", 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __( 'Delete Permanently' ) . '</a>';
            } elseif ( !MEDIA_TRASH ) {
                $form_fields['buttons']['html'] = "<input type='submit' class='button' name='send[$attachment_id]' value='" . esc_attr__('Use This', 'rtPanel' ) . "' /><a href='#' class='del-link' onclick=\"document.getElementById('del_attachment_$attachment_id').style.display='block';return false;\">" . __( 'Delete' ) . "</a>
                                                     <div id='del_attachment_$attachment_id' class='del-attachment' style='display:none;'>" . sprintf( __( 'You are about to delete <strong>%s</strong>.' ), $filename) . "
                                                     <a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id&amp;rtp_theme=rtp_true&amp;logo_or_favicon=$logo_or_favicon" , 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='button'>" . __( 'Continue' ) . "</a>
                                                     <a href='#' class='button' onclick=\"this.parentNode.style.display='none';return false;\">" . __( 'Cancel' ) . "</a>
                                                     <input type='hidden' name='rtp_theme_true' value='rtp_theme_true' />
                                                     </div>";
            } else {
                $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme_true' value='rtp_theme_true' /><a href='" . wp_nonce_url( "post.php?action=trash&amp;post=$attachment_id", 'trash-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __( 'Move to Trash' ) . "</a><a href='" . wp_nonce_url( "post.php?action=untrash&amp;post=$attachment_id", 'untrash-attachment_' . $attachment_id ) . "' id='undo[$attachment_id]' class='undo hidden'>" . __( 'Undo' ) . "</a>";
            }
        } else {
            $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme_true' value='rtp_theme_true' />";
        }
    }
    return $form_fields;
}

    /* Hook on after priority 10, because WordPress adds a couple of filters to the same hook - added accepted args(2) */
    add_filter( 'attachment_fields_to_edit', 'rtp_theme_options_upload', 11, 2 );

/**
 * Function to remove tabs from media upload Iframe
 *
 * @param array $tabs Array of all the Tabs present
 *
 * @return Array
 */
function rtp_remove_url_tab( $tabs ) {
    unset($tabs['type_url']);
    return $tabs;
}

/* Check to see if we are in rtPanel Options Page and modify the Media Upload IFrame */
if ( is_admin() && isset ( $_SERVER['HTTP_REFERER'] ) && ( preg_match( "/rtp_general/i", $_SERVER['HTTP_REFERER'] ) || preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) || preg_match( "/rtp_theme=rtp_true/i", $_SERVER['HTTP_REFERER'] ) || isset( $_POST['rtp_theme_true'] ) ) ) {
    add_filter( 'media_upload_tabs', 'rtp_remove_url_tab', 1, 2 );
}

/**
 * Display Default rtPanel Admin Sidebar (Exclusively for rtPanel Admin Options)
 *
 * Displays default rtPanel admin sidebar with metabox styling
 *
 * @return rtPanel_admin_sidebar
 */
function rtp_default_sidebar() { ?>
    <div class="postbox" id="social">
        <div title="<?php _e('Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><strong class="red"><?php _e('Getting Social is Good', 'rtPanel'); ?></strong></span></h3>
        <div class="inside" style="text-align:center;">
            <a href="<?php printf( '%s', 'http://www.facebook.com/rtCamp.solutions' ); ?>" target="_blank" title="<?php _e( 'Become a fan on Facebook', 'rtPanel' ); ?>" class="rtpanel-facebook"><?php _e( 'Facebook', 'rtPanel' ); ?></a>
            <a href="<?php printf( '%s', 'http://twitter.com/rtCamp' ); ?>" target="_blank" title="<?php _e( 'Follow us on Twitter', 'rtPanel' ); ?>" class="rtpanel-twitter"><?php _e( 'Twitter', 'rtPanel' ); ?></a>
            <a href="<?php printf( '%s', 'http://feeds.feedburner.com/rtcamp' ); ?>" target="_blank" title="<?php _e( 'Subscribe to our feeds', 'rtPanel' ); ?>" class="rtpanel-rss"><?php _e( 'RSS Feed', 'rtPanel' ); ?></a>
            <a href="<?php printf( '%s', 'http://www.linkedin.com/company/rtcamp-solutions-pvt.-ltd.' ); ?>" target="_blank" title="<?php _e( 'Connect on Linked In', 'rtPanel' ); ?>" class="rtpanel-linkedin"><?php _e( 'Linked In', 'rtPanel' ); ?></a>
        </div>
    </div>

    <div class="postbox" id="donations">
        <div title="<?php _e('Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><strong class="red"><?php _e( 'Promote, Donate, Share', 'rtPanel' ); ?>...</strong></span></h3>
        <div class="inside">
            <p><?php _e( 'A lot of time and effort goes into the development of this theme. If you find it useful, please consider making a donation, or a review on your blog or sharing this with your friends to help us.', 'rtPanel' ); ?></p>
            <div class="rt-paypal" style="text-align:center">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_donations" />
                    <input type="hidden" name="business" value="paypal@rtcamp.com" />
                    <input type="hidden" name="lc" value="US" />
                    <input type="hidden" name="item_name" value="Blogger To WordPress Migration" />
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
                    <a href="<?php printf( '%s', 'http://twitter.com/share' ); ?>"  class="twitter-share-button" data-text="Blogger to WordPress Redirection Plugin"  data-url="http://bloggertowp.org/blogger-to-wordpress-redirection-plugin/" data-count="vertical" data-via="bloggertowp"><?php _e( 'Tweet', 'rtPanel' ); ?></a>
                    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                </div>
                <div class="clear"></div>
            </div>
        </div><!-- end of .inside -->
    </div>

    <div class="postbox" id="support">
        <div title="<?php _e( 'Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><strong class="red"><?php _e( 'Free Support', 'rtPanel' ); ?></strong></span></h3>
        <div class="inside"><p><?php printf( __( 'If you have any problems with this plugin or good ideas for improvements, please talk about them in the <a href="%s" target="_blank">Support forums</a>', 'rtPanel' ), 'http://forum.bloggertowp.org/' ); ?>.</p></div>
    </div>

    <div class="postbox" id="latest_news">
        <div title="<?php _e( 'Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><strong class="red"><?php _e( 'Latest News from Our Blog', 'rtPanel' ); ?></strong></span></h3>
        <div class="inside"><?php rtp_get_feeds(); ?></div>
    </div><?php
}

/**
* Display feeds from a specified Feed URL
*
* Displays feed from the specified feed url. Displays feeds from
* 'http://feeds.feedburner.com/rtcamp' if no argument is passed
*
* @param string $feed_url The Feed URL.
*/
function rtp_get_feeds( $feed_url='http://feeds.feedburner.com/rtcamp' ) {

    // Get RSS Feed(s)
    include_once( ABSPATH . WPINC . '/feed.php' );

    // Get a SimplePie feed object from the specified feed source.
    $rss = fetch_feed( $feed_url );
    if ( !is_wp_error( $rss ) ) : // Checks that the object is created correctly
        // Figure out how many total items there are, but limit it to 5.
        $maxitems = $rss->get_item_quantity( 5 );

        // Build an array of all the items, starting with element 0 (first element).
        $rss_items = $rss->get_items( 0, $maxitems );
    endif;
?>

    <ul>
        <?php
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
    </ul>
<?php
}

/**
 * Used to catch all the error validation is caught and display
 */
function rtp_get_error_or_update_messages() {
    $messages = get_settings_errors();
    if ( is_array( $messages ) ) {
        foreach ( $messages as $message ) {
            echo '<div id="settings-error-' . $message["setting"] . '" class="'. $message["type"] . '"><p><strong>' . $message['message'] . '</strong></p></div>';
        }
    }

    if ( isset ( $_POST['rtp_export'] ) ) {
        rtp_export( );
	die();
    }

     if ( isset ( $_POST['rtp_import'] ) && !$_FILES['rtp_import']['error'] ) {
        rtp_import($_FILES['rtp_import']);
    } elseif ( isset ( $_POST['rtp_import'] ) ) {
        echo '<div id="settings-error-import" class="error"><p><strong>Import file has not been uploaded</strong></p></div>';
    }
}

/**
 * Used to add own contextual help at the top (Next to screen options)
 *
 * @param string $contextual_help The Text to show
 * @param string $screen_id The Page on which to show
 * @param object $screen The screen information
 * @return string
 */
function rtp_my_plugin_help( $contextual_help, $screen_id, $screen ) {
    switch( $screen_id ) {
        case 'appearance_page_rtp_general' :
            $contextual_help = __( 'This is where I would provide help on the General Tab.', 'rtPanel' );
            break;
        case 'appearance_page_rtp_post_comments' :
            $contextual_help = __( 'This is where I would provide help to the Post & Comments Tab.', 'rtPanel' );
            break;
    }
    return $contextual_help;

}
add_filter('contextual_help', 'rtp_my_plugin_help', 10, 3);

/**
 *  Checks whether the links in the admin bar should be displayed or not
 */
function rtp_admin_bar_init() {
    // Is the user sufficiently leveled, or has the bar been disabled?
    if ( !is_super_admin() || !is_admin_bar_showing() ) {
        return;
    }
    // Good to go, lets do this!
    add_action( 'admin_bar_menu', 'rtp_admin_bar_links', 500 );
}
add_action( 'admin_bar_init', 'rtp_admin_bar_init' );

/**
 *  Adds rtPanel link on the admin bar
 *
 * @uses object $wp_admin_bar
 */
function rtp_admin_bar_links() {
    global $wp_admin_bar;

    /* Links to add, in the form: 'Label' => 'URL' */
    $links = array(
        __( 'General', 'rtPanel' ) => admin_url( 'themes.php?page=rtp_general' ),
        __( 'Post &amp; Comments', 'rtPanel' ) => admin_url( 'themes.php?page=rtp_post_comments' )
    );

    /*  Add the Parent link. */
    $wp_admin_bar->add_menu( array(
        'title' => 'rtPanel',
        'href' => admin_url( 'themes.php?page=rtp_general' ),
        'id' => 'rt_links',
    ) );

    /* Add the submenu links. */
    foreach ( $links as $label => $url ) {
        $wp_admin_bar->add_menu( array(
            'title' => $label,
            'href' => $url,
            'parent' => 'rt_links',
        ) );
    }
}

/**
 * Used to handle the src for Logo and Favicon
 *
 * @uses $rtp_general array
 * @param string $type Optional. Deafult is 'logo'. logo' or 'favicon'
 * @return string
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
 * Control the files that are allowd
 * @param array $mime_types The allowed mime types
 * @return string
 */
function rtp_allowed_upload_extensions( $mime_types ) {
	//Creating a new array will reset the allowed filetypes
	if ( preg_match( '/logo_or_favicon=Logo/', @$_SERVER['HTTP_REFERER'] ) || ( ( preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) ) && ( preg_match( '/logo_or_favicon=Logo/', $_SERVER['REQUEST_URI'] ) ) ) ) {
            $mime_types = array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'gif' => 'image/gif',
                'png' => 'image/png',
                'bmp' => 'image/bmp',
                'ico' => 'image/x-icon',
                'tif|tiff' => 'image/tiff'
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
 * Used to bypass the Flash Media Upload and append some fields
 */
function rtp_media_upload_flash_bypass() {
        echo "<input type='hidden' name='rtp_theme_true' value='rtp_theme_true' />";
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
 * Used to bypass the Browser Media Upload and append some fields
 */
function rtp_media_upload_html_bypass( $flash = true ) {
    echo "<input type='hidden' name='rtp_theme_true' value='rtp_theme_true' />";
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

/* Added filter on rtPanel Options Page Only */
if ( ( preg_match( '/rtp_theme=rtp_true/i', @$_SERVER['HTTP_REFERER'] ) ) || ( preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) ) || ( isset( $_POST['rtp_theme_true'] ) && preg_match( '/rtp_theme_true/i', $_POST['rtp_theme_true'] ) ) ) {
    add_filter( 'flash_uploader', create_function('$flash', 'return false;'), 7 );
    add_action( 'post-flash-upload-ui', 'rtp_media_upload_flash_bypass' );
    add_action( 'post-html-upload-ui', 'rtp_media_upload_html_bypass' );
}

/**
 * Used for redirection within the media library iframe
 * 
 * @param string $location Location to redirect
 * @return string
 */
function rtp_media_library_redirect( $location ) {
    $logo_or_favicon = ( preg_match( "/logo_or_favicon=Logo/", @$_SERVER['HTTP_REFERER'] ) || preg_match( "/logo_or_favicon=Logo/", @$_SERVER['REQUEST_URI'] ) ) ? "Logo" : "Favicon";
    $location .= '&rtp_theme=rtp_true&logo_or_favicon='.$logo_or_favicon;
    return $location;
}
/* Added filter for the redirection in the iframe on rtPanel Options Page Only*/
if( preg_match( "/rtp_theme=rtp_true/i", @$_SERVER['HTTP_REFERER'] ) || preg_match( "/rtp_theme=rtp_true/i", $_SERVER['REQUEST_URI'] ) ) {
    add_action( 'restrict_manage_posts', 'rtp_post_query' );
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
 * Creates a backup file of rtPanel Options
 * @uses $wpdb object
 */
function rtp_export( ) {
    global $wpdb;
    $sitename = sanitize_key( get_bloginfo( 'name' ) );
	if ( ! empty($sitename) ) $sitename .= '.';
	$filename = $sitename . 'rtpanel.' . date( 'Y-m-d' ) . '.rtp';
	header( 'Content-Description: File Transfer' );
	header( 'Content-Disposition: attachment; filename=' . $filename );
	header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
        $general = "WHERE option_name = 'rtp_general'";
        $post_comments = "WHERE option_name = 'rtp_post_comments'";
        $hooks = "WHERE option_name = 'rtp_hooks'";
        $args['rtp_general'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $general" );
        $args['rtp_post_comments'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $post_comments" );
        $args['rtp_hooks'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $hooks" );
?><rtpanel>
    <rtp_general><?php echo $args['rtp_general']; ?></rtp_general>
    <rtp_post_comments><?php echo $args['rtp_post_comments']; ?></rtp_post_comments>
</rtpanel>
<?php
}

/**
 *
 * @uses $rtp_general array
 * @uses $rtp_post_comments array
 * @uses $rtp_hooks array
 * @param string $file The
 * @return bool|array
 */
function rtp_import( $file ) {
    global $rtp_general, $rtp_post_comments, $rtp_hooks;
    require_once( ABSPATH . '/wp-admin/includes/file.php' );
    $overrides = array( 'test_form' => false, 'test_type' => false );    
    $import_file = wp_handle_upload( $file, $overrides );
    extract( wp_check_filetype( $import_file['file'], array('rtp' => 'txt/rtp') ) );
    $data = wp_remote_get($import_file['url']);
    unlink($import_file['file']);
    if ( $ext != 'rtp' ) {
         return false;
    }
    if ( is_wp_error( $data ) ) {
        return false;
    } else {
        preg_match('/\<rtp_general\>(.*)<\/rtp_general\>/i', $data['body'], $general);
        preg_match('/\<rtp_post_comments\>(.*)<\/rtp_post_comments\>/i', $data['body'], $post_comments);
        if(!empty($post_comments[1])) update_option('rtp_post_comments', maybe_unserialize($post_comments[1]));
        return $general[1];
    }
}

/**
 * Add Custom Logo to Admin Dashboard
 */
function rtp_custom_admin_logo() {
   echo '<style type="text/css"> #header-logo { background: url("' . RTP_IMG_FOLDER_URL . '/icon-rtpanel.jpg") repeat scroll 0 0 transparent !important; height: 32px; width: 32px; } </style>';
}

/**
 * Add Custom footer text
 */
function rtl_custom_admin_footer() {
    echo '<span id="footer-thankyou">' . __( 'Thank you for creating with <a href="http://wordpress.org/" target="_blank">WordPress</a>.' ) . '</span> | ' . __( '<a href="http://codex.wordpress.org/" target="_blank">Documentation</a>' ) . ' | ' . __( '<a href="http://wordpress.org/support/forum/4" target="_blank">Feedback</a>' ) . '
        ' . __( '<br /><br />Currently using <a href="http://rtpanel.com/" title="rtPanel.com" target="_blank">rtPanel</a>' ) . ' |
        ' . __( '<a href="http://rtpanel.com/support" title="Click here for rtPanel Free Support" target="_blank">Support</a>' ) . ' |
        ' . __( '<a href="http://rtpanel.com/documentation" title="Click here for rtPanel Documentation" target="_blank">Documentation</a>' );
}

/**
 * Add rtPanel Version in Admin Footer
 */
function rtp_version() {
    global $ct;
    require_once( ABSPATH . '/wp-admin/includes/update.php' );

    $themes_info = '';
    $ct = get_current_theme();
    $themes_info = get_themes();
    $theme_version = core_update_footer() . '<br /><br />' . __( 'rtPanel Version ', 'rtPanel' ) . $themes_info[$ct]['Version'];
    return $theme_version;
}

add_action( 'admin_head', 'rtp_custom_admin_logo' );
add_filter( 'admin_footer_text', 'rtl_custom_admin_footer' );
add_filter( 'update_footer', 'rtp_version', 9999 );

if ( is_admin() && @$rtp_post_comments['notices'] ) {
    add_action( 'admin_notices', 'rtp_regenerate_thumbnail_notice');
}

function rtp_regenerate_thumbnail_notice() {
    define( 'RTP_REGENERATE_THUMBNAILS', 'regenerate-thumbnails/regenerate-thumbnails.php' );
    if ( is_plugin_active( RTP_REGENERATE_THUMBNAILS ) ) {
        $regenerate_link = admin_url( '/tools.php?page=regenerate-thumbnails' );
    } elseif ( array_key_exists( RTP_REGENERATE_THUMBNAILS, get_plugins() ) ) {
        $regenerate_link = admin_url( '/plugins.php#regenerate-thumbnails' );
    } else {
        $regenerate_link = wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=regenerate-thumbnails' ), 'install-plugin_regenerate-thumbnails' );
    }
    echo '<div class="error fade"><p>' . sprintf( __( 'The Thumbnail Settings have been updated. Please <a href="%s" title="Regenerate Thumbnails">Regenerate Thumbnails</a>', 'rtPanel' ), $regenerate_link ) . '</p></div>';
}

if ( is_admin() && $pagenow == 'tools.php' && ( @$_GET['page'] == 'regenerate-thumbnails' ) && @$_POST['regenerate-thumbnails'] ) {
    $rtp_notice = get_option('rtp_post_comments');
    $rtp_notice['notices'] = '0';
    update_option( 'rtp_post_comments', $rtp_notice );
}

if ( is_admin() && isset ( $_GET['activated'] ) && $pagenow ==	'themes.php' ) {
    wp_redirect( 'themes.php?page=rtp_general' );
}

if ( isset ( $rtp_post_comments ) && ( @$rtp_post_comments['thumbnail_width'] != get_option( 'thumbnail_size_w' ) || @$rtp_post_comments['thumbnail_height'] != get_option( 'thumbnail_size_h' ) || @$rtp_post_comments['thumbanil_crop'] != get_option( 'thumbnail_crop' ) ) ) {
        $rtp_post_comments['notices'] = '1';
        $rtp_post_comments['thumbnail_width'] = get_option( 'thumbnail_size_w' );
        $rtp_post_comments['thumbnail_height'] = get_option( 'thumbnail_size_h' );
        $rtp_post_comments['thumbanil_crop'] = get_option( 'thumbnail_crop' );
        update_option( 'rtp_post_comments', $rtp_post_comments );
}
