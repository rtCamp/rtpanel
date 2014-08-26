<?php

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
 * Get Titan Object
 * @return boolean
 */
function rtp_get_titan_obj( $instance = 'rtpanel' ) {
	if ( rtp_embedd_titan_framework() ) {
		$obj = TitanFramework::getInstance( $instance );
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
function rtp_is_plugin_active( $plugin ) {
	return in_array( $plugin, ( array ) get_option( 'active_plugins', array() ) ) || rtp_is_plugin_active_for_network( $plugin );
}

/**
 *  Is plugin activate for network
 */
function rtp_is_plugin_active_for_network( $plugin ) {
	if ( !is_multisite() ) {
		return false;
	}

	$plugins = get_site_option( 'active_sitewide_plugins' );
	if ( isset( $plugins[ $plugin ] ) ) {
		return true;
	}

	return false;
}

/**
 * Set Titan Option Value
 * 
 * @param type $optionName Option ID
 * @param type $value Value to set
 * @param type $postID Default NULL
 * @return boolean
 */
function rtp_set_titan_option( $optionName, $value, $postID = null ) {
	$rtpanel_titan = rtp_get_titan_obj();

	if ( $rtpanel_titan ) {
		return $rtpanel_titan->setOption( $optionName, $value, $postID );
	} else {
		return false;
	}
}

/**
 * Get Color Palette Options
 * @global type $theme_colors
 */
function rtpanel_titan_color_option_saved() {
	global $theme_colors;
	$theme_color = rtp_get_titan_option( 'rtp_color_palette_option' );

	foreach ( $theme_colors as $key => $color ) {
		if ( $color === $theme_color ) {
			$palette_option = $key;
			break;
		}
	}

	rtp_set_titan_option( 'palette_option_customize', $palette_option );
	update_site_option( 'rtpanel_color_option_saved', 'rtpanel-titan' );
}

add_action( 'tf_admin_options_saved_rtpanel', 'rtpanel_titan_color_option_saved' );

/**
 * Get Color Palette via Theme Customizer
 * @global type $theme_colors
 */
function rtpanel_customize_color_option_saved() {
	global $theme_colors;
	$theme_color2 = rtp_get_titan_option( 'palette_option_customize' );

	foreach ( $theme_colors as $key => $color ) {
		if ( $color === $theme_color2 ) {
			$palette_option_customize = $key;
			break;
		}
	}

	$rtpanel_data = maybe_unserialize( get_option( 'rtpanel_options' ) );
	$rtpanel_data["rtp_color_palette_option"] = $palette_option_customize;
	update_site_option( 'rtpanel_options', serialize( $rtpanel_data ) );
	update_site_option( 'rtpanel_color_option_saved', 'rtpanel-customize' );
}

add_action( 'customize_save_after', 'rtpanel_customize_color_option_saved' );