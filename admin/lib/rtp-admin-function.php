<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Plugin activation action
 */
function rtp_is_plugin_activation_action() {
	/*
	 * Don't do anything when we're activating a plugin to prevent errors on redeclaring Titan classes
	 * More Info: http://www.titanframework.net/embedding-titan-framework-in-your-project/
	 */
	if ( !empty( $_GET[ 'action' ] ) && !empty( $_GET[ 'plugin' ] ) ) {
		if ( $_GET[ 'action' ] == 'activate' ) {
			return true;
		}
	}
	return false;
}

/**
 * Check if Titan Framework is activated
 * @return boolean
 */
function rtp_is_titan_activated() {
	$activePlugins = get_option( 'active_plugins' );
	if ( is_array( $activePlugins ) ) {
		foreach ( $activePlugins as $plugin ) {
			if ( is_string( $plugin ) ) {
				if ( stripos( $plugin, '/titan-framework.php' ) !== false ) {
					return true;
				}
			}
		}
	}
	return false;
}

/**
 * Embedd Titan Framework
 * When using the embedded framework, use it only if the framework plugin isn't activated.
 * @return boolean
 * @since rtPanel 1.2
 */
function rtp_embedd_titan_framework() {

	if ( rtp_is_plugin_activation_action() ) {
		return false;
	}

	if ( rtp_is_titan_activated() ) {
		return true;
	}

	/* Use the embedded Titan Framework */
	if ( !class_exists( 'TitanFramework' ) ) {

		if ( !class_exists( 'TitanFramework' ) ) {
			require_once( get_template_directory() . '/titan-framework/titan-framework.php' );
		}

		return true;
	}

	return true;
}

/**
 * Migrate Code
 */
function rtp_migrate_old_options() {
	if ( false === get_option( 'rtp_options', false ) ) {
		$default_rtpanel = array(
			'logo_settings' => 'site_title',
			'logo_upload' => '',
			'login_head' => false,
			'favicon_settings' => 'disable',
			'favicon_upload' => '',
			'google_analytics' => '',
			'palette_option' =>
			array(
				0 => '#4264AA',
				1 => '#DFE5F2',
				2 => '#2F333C',
				3 => '#F6F7F8',
				4 => '#89919C',
			),
			'top_menu_option' =>
			array(
				0 => 'rtp_search',
				1 => 'rtp_friends',
				2 => 'rtp_notifications',
				3 => 'rtp_messages',
				4 => 'rtp_settings',
			),
			'show_collapse_menu' => true,
			'footer_sidebar' => false,
			'footer_info' => '',
			'powered_by' => true,
			'affiliate_ID' => '',
			'summary_show' => true,
			'word_limit' => '55',
			'read_text' => 'Read More &rarr;',
			'thumbnail_show' => true,
			'thumbnail_position' => 'right',
			'post_date' =>
			array(
				0 => 'show',
				1 => 'above',
			),
			'post_author' =>
			array(
				0 => 'show',
				1 => 'above',
			),
			'post_category' =>
			array(
				0 => 'show',
				1 => 'above',
			),
			'post_tags' =>
			array(
				0 => 'show',
				1 => 'below',
			),
			'pagination_show' => true,
			'prev_text' => '&laquo; Previous',
			'next_text' => 'Next &raquo;',
			'end_size' => '1',
			'mid_size' => '2',
			'gravatar_show' => true,
			'enable_compact_form' =>
			array(
				0 => 'compact_form',
				1 => 'hide_labels',
			),
			'extra_form_settings' =>
			array(
				0 => 'comment_separate',
			),
			'body_font_option' =>
			array(
				'font-family' => 'Open Sans',
				'color' => '#666666',
				'font-size' => '14px',
				'font-weight' => 'normal',
				'font-style' => 'normal',
				'line-height' => '1.5em',
				'letter-spacing' => 'normal',
				'text-transform' => 'none',
				'font-variant' => 'normal',
				'text-shadow-location' => 'none',
				'text-shadow-distance' => '0px',
				'text-shadow-blur' => '0px',
				'text-shadow-color' => '#333333',
				'text-shadow-opacity' => '1',
				'font-type' => 'google',
				'dark' => '',
			),
			'heading_font_option' =>
			array(
				'font-family' => 'Open Sans',
				'color' => '#333333',
				'font-size' => '13px',
				'font-weight' => 'normal',
				'font-style' => 'normal',
				'line-height' => '1.5em',
				'letter-spacing' => 'normal',
				'text-transform' => 'none',
				'font-variant' => 'normal',
				'text-shadow-location' => 'none',
				'text-shadow-distance' => '0px',
				'text-shadow-blur' => '0px',
				'text-shadow-color' => '#333333',
				'text-shadow-opacity' => '1',
				'font-type' => 'google',
				'dark' => '',
			),
			'coding_font_option' =>
			array(
				'font-family' => 'Source Code Pro',
				'color' => '#333333',
				'font-size' => '13px',
				'font-weight' => 'normal',
				'font-style' => 'normal',
				'line-height' => '1.5em',
				'letter-spacing' => 'normal',
				'text-transform' => 'none',
				'font-variant' => 'normal',
				'text-shadow-location' => 'none',
				'text-shadow-distance' => '0px',
				'text-shadow-blur' => '0px',
				'text-shadow-color' => '#333333',
				'text-shadow-opacity' => '1',
				'font-type' => 'google',
				'dark' => '',
			),
			'backend_custom_css' => '',
			'backend_custom_js' => '',
			'buddypress_sidebar' => 'default-sidebar',
			'bbpress_sidebar' => 'default-sidebar',
		);

		$default_rtp_general = array(
			'logo_use' => 'site_title',
			'logo_upload' => '',
			'logo_id' => '0',
			'logo_width' => '224',
			'logo_height' => '51',
			'login_head' => '0',
			'favicon_use' => 'disable',
			'favicon_upload' => '',
			'favicon_id' => '0',
			'search_code' => '',
			'search_layout' => '1',
			'buddypress_sidebar' => 'default-sidebar',
			'bbpress_sidebar' => 'default-sidebar',
			'footer_sidebar' => '0',
			'custom_styles' => '',
		);

		$original_rtp_general = wp_parse_args( get_option( 'rtp_general', array() ), $default_rtp_general );

		$default_rtp_post_comments = array(
			'notices' => '1',
			'summary_show' => '1',
			'word_limit' => 55,
			'read_text' => 'Read More &rarr;',
			'thumbnail_show' => '1',
			'thumbnail_position' => 'Right',
			'thumbnail_width' => '150',
			'thumbnail_height' => '150',
			'thumbnail_crop' => '1',
			'thumbnail_frame' => '0',
			'post_date_u' => '1',
			'post_date_format_u' => 'F j, Y',
			'post_date_custom_format_u' => 'F j, Y',
			'post_author_u' => '1',
			'author_count_u' => '0',
			'author_link_u' => '1',
			'post_category_u' => '1',
			'post_tags_u' => '0',
			'post_date_l' => '0',
			'post_date_format_l' => 'F j, Y',
			'post_date_custom_format_l' => 'F j, Y',
			'post_author_l' => '0',
			'author_count_l' => '0',
			'author_link_l' => '1',
			'post_category_l' => '0',
			'post_tags_l' => '0',
			'pagination_show' => '1',
			'prev_text' => '&laquo; Previous',
			'next_text' => 'Next &raquo;',
			'end_size' => 1,
			'mid_size' => 2,
			'compact_form' => '1',
			'hide_labels' => '1',
			'comment_textarea' => '0',
			'comment_separate' => '1',
			'attachment_comments' => 0,
			'gravatar_show' => '1',
		);
		$original_rtp_post_comments = wp_parse_args( get_option( 'rtp_post_comments', array() ), $default_rtp_post_comments );

		$new_rtpanel = array(
			'logo_settings' => $original_rtp_general['logo_use'],
			'logo_upload' => $original_rtp_general['logo_upload'],
			'login_head' => ( $original_rtp_general['login_head'] === 0 ) ? false : true,
			'favicon_settings' => $original_rtp_general['favicon_use'],
			'favicon_upload' => $original_rtp_general['favicon_upload'],
			'google_analytics' => '',
			'show_collapse_menu' => true,
			'footer_sidebar' => ( $original_rtp_general['footer_sidebar'] === 0 ) ? false : true,
			'footer_info' => '',
			'powered_by' => true,
			'affiliate_ID' => '',
			'summary_show' => ( $original_rtp_post_comments['summary_show'] === 0 ) ? false : true,
			'word_limit' => $original_rtp_post_comments['word_limit'],
			'read_text' => $original_rtp_post_comments['read_text'],
			'thumbnail_show' => ( $original_rtp_post_comments['thumbnail_show'] === 0 ) ? false : true,
			'thumbnail_position' => strtolower( $original_rtp_post_comments['thumbnail_position'] ),
			'post_date' =>
			array(),
			'post_author' =>
			array(),
			'post_category' =>
			array(),
			'post_tags' =>
			array(),
			'pagination_show' => ( $original_rtp_post_comments['pagination_show'] === 0 ) ? false : true,
			'prev_text' => $original_rtp_post_comments['prev_text'],
			'next_text' => $original_rtp_post_comments['next_text'],
			'end_size' => $original_rtp_post_comments['end_size'],
			'mid_size' => $original_rtp_post_comments['mid_size'],
			'gravatar_show' => ( $original_rtp_post_comments['gravatar_show'] === 1 ) ? false : true,
			'enable_compact_form' => array(),
			'extra_form_settings' => array(),
			'body_font_option' =>
			array(
				'font-family' => 'Open Sans',
				'color' => '#666666',
				'font-size' => '14px',
				'font-weight' => 'normal',
				'font-style' => 'normal',
				'line-height' => '1.5em',
				'letter-spacing' => 'normal',
				'text-transform' => 'none',
				'font-variant' => 'normal',
				'text-shadow-location' => 'none',
				'text-shadow-distance' => '0px',
				'text-shadow-blur' => '0px',
				'text-shadow-color' => '#333333',
				'text-shadow-opacity' => '1',
				'font-type' => 'google',
				'dark' => '',
			),
			'heading_font_option' =>
			array(
				'font-family' => 'Open Sans',
				'color' => '#333333',
				'font-size' => '13px',
				'font-weight' => 'normal',
				'font-style' => 'normal',
				'line-height' => '1.5em',
				'letter-spacing' => 'normal',
				'text-transform' => 'none',
				'font-variant' => 'normal',
				'text-shadow-location' => 'none',
				'text-shadow-distance' => '0px',
				'text-shadow-blur' => '0px',
				'text-shadow-color' => '#333333',
				'text-shadow-opacity' => '1',
				'font-type' => 'google',
				'dark' => '',
			),
			'coding_font_option' =>
			array(
				'font-family' => 'Source Code Pro',
				'color' => '#333333',
				'font-size' => '13px',
				'font-weight' => 'normal',
				'font-style' => 'normal',
				'line-height' => '1.5em',
				'letter-spacing' => 'normal',
				'text-transform' => 'none',
				'font-variant' => 'normal',
				'text-shadow-location' => 'none',
				'text-shadow-distance' => '0px',
				'text-shadow-blur' => '0px',
				'text-shadow-color' => '#333333',
				'text-shadow-opacity' => '1',
				'font-type' => 'google',
				'dark' => '',
			),
			'backend_custom_css' => $default_rtp_general['custom_styles'],
			'backend_custom_js' => '',
			'buddypress_sidebar' => $default_rtp_general['buddypress_sidebar'],
			'bbpress_sidebar' => $default_rtp_general['bbpress_sidebar'],
		);

		if ( $original_rtp_post_comments['compact_form'] === '1' ) {
			$new_rtpanel['enable_compact_form'][] = 'compact_form';
		}
		if ( $original_rtp_post_comments['hide_labels'] === '1' ) {
			$new_rtpanel['enable_compact_form'][] = 'hide_labels';
		}
		if ( $original_rtp_post_comments['comment_textarea'] === '1' ) {
			$new_rtpanel['extra_form_settings'][] = 'comment_textarea';
		}
		if ( $original_rtp_post_comments['comment_separate'] === '1' ) {
			$new_rtpanel['extra_form_settings'][] = 'comment_separate';
		}
		if ( $original_rtp_post_comments['attachment_comments'] === '1' ) {
			$new_rtpanel['extra_form_settings'][] = 'attachment_comments';
		}

		if ( $original_rtp_post_comments['post_date_u'] === '1' || $original_rtp_post_comments['post_date_l'] === '1' ) {
			$new_rtpanel['post_data'][] = 'show';
			if ( $original_rtp_post_comments['post_date_u'] == '1' ) {
				$new_rtpanel['post_data'][] = 'above';
			}
			if ( $original_rtp_post_comments['post_date_l'] == '1' ) {
				$new_rtpanel['post_data'][] = 'below';
			}
		}

		if ( $original_rtp_post_comments['post_author_u'] === '1' || $original_rtp_post_comments['post_author_l'] === '1' ) {
			$new_rtpanel['post_author'][] = 'show';
			if ( $original_rtp_post_comments['post_author_u'] == '1' ) {
				$new_rtpanel['post_author'][] = 'above';
			}
			if ( $original_rtp_post_comments['post_author_l'] == '1' ) {
				$new_rtpanel['post_author'][] = 'below';
			}
		}

		if ( $original_rtp_post_comments['post_category_u'] === '1' || $original_rtp_post_comments['post_category_l'] === '1' ) {
			$new_rtpanel['post_category'][] = 'show';
			if ( $original_rtp_post_comments['post_category_u'] == '1' ) {
				$new_rtpanel['post_category'][] = 'above';
			}
			if ( $original_rtp_post_comments['post_category_l'] == '1' ) {
				$new_rtpanel['post_category'][] = 'below';
			}
		}

		if ( $original_rtp_post_comments['post_tags_u'] === '1' || $original_rtp_post_comments['post_tags_l'] === '1' ) {
			$new_rtpanel['post_tags'][] = 'show';
			if ( $original_rtp_post_comments['post_tags_u'] == '1' ) {
				$new_rtpanel['post_tags'][] = 'above';
			}
			if ( $original_rtp_post_comments['post_tags_l'] == '1' ) {
				$new_rtpanel['post_tags'][] = 'below';
			}
		}

		$new_rtpanel = wp_parse_args( $new_rtpanel, $default_rtpanel );
		update_option( 'rtp_general', serialize( $new_rtpanel ) );
		update_option( 'rtp_options', 1 );
	}
}


/**
 * Get Titan Object
 * @return boolean
 */
function rtp_get_titan_obj() {
	if ( rtp_embedd_titan_framework() ) {
		rtp_migrate_old_options();
		$obj = TitanFramework::getInstance( 'rtpanel' );
		return $obj;
	}
	return false;
}

/**
 * Retrieve Titan Option Value
 * 
 * @param type $optionName Option ID
 * @param type $postID Default is NULL
 * @return boolean Value of Option ID
 */
function rtp_get_titan_option( $optionName, $postID = null ) {
	$rtpanel_titan = rtp_get_titan_obj();

	if ( $rtpanel_titan ) {
		return $rtpanel_titan->getOption( $optionName, $postID );
	} else {
		return false;
	}
}

/**
 * Returns Home URL, to be used by custom logo
 * 
 * @return string
 *
 * @since rtPanel 1.1
 */
function rtp_login_site_url() {
	return home_url( '/' );
}

/**
 *  Is plugin activate
 */
function rt_is_plugin_active( $plugin ) {
	return in_array( $plugin, ( array ) get_option( 'active_plugins', array() ) ) || rt_is_plugin_active_for_network( $plugin );
}

/**
 *  Is plugin activate for network
 */
function rt_is_plugin_active_for_network( $plugin ) {
	if ( !is_multisite() ) {
		return false;
	}

	$plugins = get_site_option( 'active_sitewide_plugins' );
	if ( isset( $plugins[ $plugin ] ) ) {
		return true;
	}

	return false;
}