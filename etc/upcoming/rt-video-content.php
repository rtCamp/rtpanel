<?php

/**
 * Returns the list of all valid video urls
 *
 * @param string $content
 * $content is normally the post content. Gets the current post content in the loop by default.
 *
 * @return array This function returns the array of all the valid video urls matched from the given content
 * and NULL if nothing found.
 *
 */
function rt_get_video_url( $content = '' ) {
        global $post;
        if( empty( $content ) ) {
            $content = $post->post_content; // If content is not passed it will take content from current loop
        }

        $all_valid_urls = array();

        /* Stripping tags to find only video urls from the content */
        $content = strip_tags( $content );
        $content = strip_shortcodes( $content );

        /* Regex for getting valid url */
        preg_match_all('/((https?|ftp)\:\/\/)?([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?([a-z0-9-.]*)\.([a-z]{2,3})(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?/i',$content, $result);

        $all_urls = ( $result[0] ) ? $result[0] : null;

        /* Collecting all the valid urls for video display */
        if( $all_urls ) {
                foreach( $all_urls as $single_url ) {
                        if( strstr( $single_url, 'youtube' ) || strstr( $single_url, 'youtu.be' ) || strstr( $single_url, 'blip.tv' ) || strstr( $single_url, 'vimeo' ) || strstr( $single_url, 'dailymotion' ) || strstr( $single_url, 'flickr' ) || strstr( $single_url, 'smugmug' ) || strstr( $single_url, 'hulu' ) || strstr( $single_url, 'viddler' ) || strstr( $single_url, 'qik.com') || strstr( $single_url, 'revision3.com' ) || strstr( $single_url, 'photobucket.com' ) || strstr( $single_url, 'scribd' ) || strstr( $single_url, 'wordpress.tv' ) || strstr( $single_url, 'polldaddy.com' ) || strstr( $single_url, 'funnyordie' ) ) {
                                $all_valid_urls[] = $single_url;
                        }
                }
        }
        return ( $all_valid_urls ? $all_valid_urls : NULL );
}

/**
 * Returns video html of the given url
 * @param string $url Its url of the video to be embedded
 * @param int $width sets the width of the video
 * @param int $height sets the height of the video
 * @return string This function returns the video html of the url, NULL on failure.
 *
 * USAGE : Get the valid urls using "rt_get_video_url()". And Pass one of the url to this function to get its video html.
 */
function rt_get_video_from_url( $url, $width = 250, $height = 200 ) {

        if( ! class_exists( 'WP_oEmbed' ) ) { //if not included,
                $include_dir_path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
                include_once("$include_dir_path/wp-includes/class-oembed.php");
        }

        $url_to_embed = $url; // actual url to embed

        $oembed = _wp_oembed_get_object();
        $video_html = $oembed->get_html( $url_to_embed );

        $video_html = preg_replace( '/width="(\d*)[^"]*"/i', 'width="'.$width.'"', $video_html );
        $video_html = preg_replace( '/height="(\d*)[^"]*"/i', 'height="'.$height.'"', $video_html );

        return ( $video_html ) ? $video_html : NULL;
}