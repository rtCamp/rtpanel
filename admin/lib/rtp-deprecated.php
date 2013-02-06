<?php
/**
 * Deprecated functions from past rtPanel versions. You shouldn't use these
 * functions and look for the alternatives instead. The functions will be removed
 * in a later version.
 */

/*
 * Deprecated functions come here to die.
 */

/**
 * Marks a function as deprecated and informs when it has been used.
 *
 * The current behavior is to trigger a user error if WP_DEBUG is true.
 *
 * This function is to be used in every function that is deprecated.
 *
 * @since 2.2.2
 */
function _rtp_deprecated_function( $function, $version, $replacement = null ) {
    if ( WP_DEBUG ) {
        if ( ! is_null( $replacement ) )
            trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since rtPanel version %2$s! Use %3$s instead.', 'rtPanel' ), $function, $version, $replacement ) );
        else
            trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since rtPanel version %2$s with no alternative available.', 'rtPanel' ), $function, $version ) );
    }
}

function _rtp_deprecated_argument( $function, $version, $message = null ) {
    if ( WP_DEBUG ) {
        if ( ! is_null( $message ) )
            trigger_error( sprintf( __('%1$s was called with an argument that is <strong>deprecated</strong> since rtPanel version %2$s! %3$s'), $function, $version, $message ) );
        else
            trigger_error( sprintf( __('%1$s was called with an argument that is <strong>deprecated</strong> since rtPanel version %2$s with no alternative available.'), $function, $version ) );
    }
}

/**
 * Returns 'src' value for Logo / Favicon
 *
 * @since rtPanel 2.0
 * @deprecated 2.2
 * @deprecated Use global $rtp_general[logo_upload]/$rtp_general[favicon_upload]
 * 
 * @uses $rtp_general array
 * @param string $type Optional. Deafult is 'logo'. logo' or 'favicon'
 * @return string
 *
 */
function rtp_logo_fav_src( $type = 'logo' ) {
    global $rtp_general;
    _rtp_deprecated_function( __FUNCTION__, '2.2', 'global $rtp_general[logo_upload]/$rtp_general[favicon_upload]' );

    if( $type == 'logo' ) {
        return $rtp_general['logo_upload'];
    } else if($type == 'favicon') {
        return $rtp_general['favicon_upload'];
    } else {
        return false;
    }
}

/**
 * Sets 'nofollow' to external links
 *
 * @param string $content
 * @return mixed
 *
 * @since rtPanel 2.0
 */
function rtp_nofollow( $content ) {
    _rtp_deprecated_function( __FUNCTION__, '2.3', 'Not used anymore' );
    return preg_replace_callback( '/<a[^>]+/', 'rtp_nofollow_callback', $content );
}


/**
 * Callback to rtp_nofollow()
 *
 * @param array $matches
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_nofollow_callback( $matches ) {
    _rtp_deprecated_function( __FUNCTION__, '2.3', 'Not used anymore' );
    $link = $matches[0];
    $site_link = home_url();
    if ( strpos( $link, 'rel' ) === false ) {
        $link = preg_replace( "%(href=\S(?!$site_link))%i", 'rel="nofollow" $1', $link );
    } elseif ( preg_match( "%href=\S(?!$site_link)%i", $link ) ) {
        $link = preg_replace( '/rel=\S(?!nofollow)\S*/i', 'rel="nofollow"', $link );
    }
    return $link;
}

/**
 * Header image background style
 *  
 * @return null
 *  
 */
function rtp_header_style(){
    _rtp_deprecated_function( __FUNCTION__, '3.0' );
    return '';    
}