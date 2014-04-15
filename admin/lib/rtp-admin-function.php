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
 * Get Titan Object
 * @return boolean
 */
function rtp_get_titan_obj() {
	if ( rtp_embedd_titan_framework() ) {
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