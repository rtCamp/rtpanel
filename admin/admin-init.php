<?php

// Load the TGM init if it exists
//if ( file_exists( dirname( __FILE__ ) . '/tgm/tgm-init.php' ) ) {
//	require_once( dirname( __FILE__ ) . '/tgm/tgm-init.php' );
//}
// Load Redux extensions - MUST be loaded before your options are set
if ( file_exists( dirname( __FILE__ ) . '/ReduxExtensions/extensions-init.php' ) ) {
	require_once( dirname( __FILE__ ) . '/ReduxExtensions/extensions-init.php' );
}

if ( ! class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' );
}

// Load the theme/plugin options
if ( file_exists( dirname( __FILE__ ) . '/options-init.php' ) ) {
	require_once( dirname( __FILE__ ) . '/options-init.php' );
}