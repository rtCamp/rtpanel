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
			trigger_error( sprintf( __( '%1$s was called with an argument that is <strong>deprecated</strong> since rtPanel version %2$s! %3$s', 'rtPanel' ), $function, $version, $message ) );
		else
			trigger_error( sprintf( __( '%1$s was called with an argument that is <strong>deprecated</strong> since rtPanel version %2$s with no alternative available.', 'rtPanel' ), $function, $version ) );
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

	if ( $type == 'logo' ) {
		return $rtp_general[ 'logo_upload' ];
	} else if ( $type == 'favicon' ) {
		return $rtp_general[ 'favicon_upload' ];
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
	$link		 = $matches[ 0 ];
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
function rtp_header_style() {
	_rtp_deprecated_function( __FUNCTION__, '3.0' );
	return '';
}

/**
 * Returns required thumbnail 'src' value from content
 *
 * @param int $attach_id The id of the featured image
 * @param string $size The image size required as output ( Must be registered using
 * add_image_size or should use WordPress defaults like thumbnail, medium, large or full )
 * @param int $the_id The current post should be passed if function is used outside the loop
 * @return string
 *
 * @since rtPanel 3.0
 */
function rtp_generate_thumbs( $attach_id = null, $size = 'thumbnail', $the_id = '' ) {
	_rtp_deprecated_function( __FUNCTION__, '3.0', 'Not used anymore' );
	return '';
}

if ( ! class_exists( 'Rtp_Ogp' ) ) {

	/**
	 * Facebook Open Graph Protocol
	 *
	 * @since 2.0
	 * @deprecated 4.0
	 */
	class Rtp_Ogp {

		var $data;

		/**
		 * Constructor
		 *
		 * @return void
		 *
		 * @since rtPanel 2.0
		 * @deprecated 4.0
		 * */
		function rtp_ogp() {
			_rtp_deprecated_function( __FUNCTION__, '4.0', 'Not used anymore' );
			add_action( 'wp_head', array( $this, 'rtp_ogp_add_head' ) );
		}

		/**
		 * Outputs Open Graph meta tags
		 *
		 * @since rtPanel 2.0
		 * @deprecated 4.0
		 * */
		function rtp_ogp_add_head() {
			_rtp_deprecated_function( __FUNCTION__, '4.0', 'Not used anymore' );
			$this->data = $this->rtp_ogp_set_data();
			echo $this->rtp_ogp_get_headers( $this->data );
		}

		/**
		 * Sets Open Graph meta tags
		 *
		 * @return array
		 *
		 * @since rtPanel 2.0
		 * @deprecated 4.0
		 * */
		function rtp_ogp_set_data() {
			_rtp_deprecated_function( __FUNCTION__, '4.0', 'Not used anymore' );
			global $post, $rtp_general;
			$data = array();

			if ( ! empty( $rtp_general[ 'fb_app_id' ] ) )
				$data[ 'fb:app_id' ] = $rtp_general[ 'fb_app_id' ];

			if ( ! empty( $rtp_general[ 'fb_admins' ] ) )
				$data[ 'fb:admins' ] = $rtp_general[ 'fb_admins' ];

			$data[ 'og:site_name' ] = get_bloginfo( 'name' );

			if ( is_singular() && ! is_front_page() ) {
				$append			 = '';
				$post_content = ( isset( $post->post_excerpt ) && trim( $post->post_excerpt ) ) ? $post->post_excerpt : $post->post_content;
				if ( strlen( wp_html_excerpt( $post_content, 130 ) ) >= 130 )
					$append = '...';

				$data[ 'og:title' ]		 = esc_attr( $post->post_title );
				$data[ 'og:type' ]		 = 'article';
				$data[ 'og:image' ]		 = $this->rtp_ogp_image_url();
				$data[ 'og:url' ]			 = get_permalink();
				$data[ 'og:description' ] = esc_attr( wp_html_excerpt( $post_content, 130 ) . $append );
			} else {
				$data[ 'og:title' ]		 = get_bloginfo( 'name' );
				$data[ 'og:type' ]		 = 'website';
				$data[ 'og:image' ]		 = $this->rtp_ogp_image_url();
				$data[ 'og:url' ]			 = home_url( $_SERVER[ 'REQUEST_URI' ] );
				$data[ 'og:description' ] = get_bloginfo( 'description' );
			}
			return $data;
		}

		/**
		 * Returns Formatted Open Graph meta tags
		 *
		 * @return array
		 *
		 * @since rtPanel 2.0
		 * @deprecated 4.0
		 * */
		function rtp_ogp_get_headers( $data ) {
			_rtp_deprecated_function( __FUNCTION__, '4.0', 'Not used anymore' );
			if ( ! count( $data ) ) {
				return;
			}
			$out   = array();
			$out[] = "\n<!-- BEGIN: Open Graph Protocol : http://opengraphprotocol.org/ for more info -->";
			foreach ( $data as $property => $content ) {
				if ( $content != '' ) {
					$out[] = "<meta property=\"{$property}\" content=\"" . apply_filters( 'rtp_ogp_content_' . $property, $content ) . "\" />";
				} else {
					$out[] = "<!--{$property} value was blank-->";
				}
			}
			$out[] = "<!-- End: Open Graph Protocol -->\n";
			return implode( "\n", $out );
		}

		/**
		 * Returns Open Graph image meta tag value
		 *
		 * @return string
		 *
		 * @since rtPanel 2.0
		 * @deprecated 4.0
		 * */
		function rtp_ogp_image_url() {
			_rtp_deprecated_function( __FUNCTION__, '4.0', 'Not used anymore' );
			global $post, $rtp_general;
			$image = '';
			if ( is_singular() && ! is_front_page() ) {
				if ( has_post_thumbnail( $post->ID ) ) {
					$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );
					if ( ! empty( $thumbnail ) ) {
						$image = $thumbnail[ 0 ];
					}
				} else {
					$image = apply_filters( 'rtp_default_ogp_image_path', '' );
					if ( empty( $image ) ) {
						$image = $rtp_general[ 'logo_upload' ];
					}
				}
			} else {
				$image = $rtp_general[ 'logo_upload' ];
			}
			return $image;
		}

	}

}

/**
 * Feedburner Redirection Code
 *
 * @uses string $feed
 * @uses array $rtp_general
 *
 * @since rtPanel 2.0
 * @deprecated 4.0
 */
function rtp_feed_redirect() {
	_rtp_deprecated_function( __FUNCTION__, '4.0', 'Not used anymore' );
	global $feed, $rtp_general, $withcomments;
	if ( is_feed() && $feed != 'comments-rss2' && ( $withcomments != 1 ) && ! is_singular() && ! is_archive() && ! empty( $rtp_general[ 'feedburner_url' ] ) ) {
		if ( function_exists( 'status_header' ) ) {
			status_header( 302 );
		}
		header( 'Location: ' . trim( $rtp_general[ 'feedburner_url' ] ) );
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
 * @deprecated 4.0
 */
function rtp_check_url() {
	_rtp_deprecated_function( __FUNCTION__, '4.0', 'Not used anymore' );
	global $rtp_general;
	switch ( basename( $_SERVER[ 'PHP_SELF' ] ) ) {
		case 'wp-rss.php' :
		case 'wp-rss2.php' :
		case 'wp-atom.php' :
		case 'wp-rdf.php' : if ( trim( $rtp_general[ 'feedburner_url' ] ) != '' ) {
				if ( function_exists( 'status_header' ) ) {
					status_header( 302 );
				}
				header( 'Location: ' . trim( $rtp_general[ 'feedburner_url' ] ) );
				header( 'HTTP/1.1 302 Temporary Redirect' );
				exit();
			}
			break;

		case 'wp-commentsrss2.php': break;
	}
}
