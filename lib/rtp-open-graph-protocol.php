<?php
/**
 * rtPanel Open Graph Protocol
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */


/**
 * class for open graph protocol
 */
class rtp_ogp {
    
    var $data;

    function rtp_ogp() {
        add_action('wp_head', array($this, 'rtp_ogp_add_head'));
    }

    function rtp_ogp_add_head() {
        $this->data = $this->rtp_ogp_set_data();
        echo $this->rtp_ogp_get_headers($this->data);
    }

    function rtp_ogp_set_data() {
        $data = array();
        global $post, $rtp_general;
        $append = '';
        if( strlen( wp_html_excerpt( $post->post_content, 130 ) ) >= 130 )
                $append = '...';

        if ( !empty( $rtp_general['fb_app_id'] ) )
            $data['fb:app_id'] = $rtp_general['fb_app_id'];

        if ( !empty( $rtp_general['fb_admins'] ) )
            $data['fb:admins'] = $rtp_general['fb_admins'];

        $data['og:site_name'] = get_bloginfo('name');

        if ( is_singular () ) {
            $data['og:title'] = get_the_title();
            $data['og:type'] = 'article';
            $data['og:image'] = $this->rtp_ogp_image_url();
            $data['og:url'] = get_permalink();
            $data['og:description'] = wp_html_excerpt( $post->post_content, 130 ).$append;
        }
        else {
            $data['og:title'] = get_bloginfo('name');
            $data['og:type'] = 'website';
            $data['og:image'] = $this->rtp_ogp_image_url();
            $data['og:url'] = home_url( $_SERVER['REQUEST_URI'] );
            $data['og:description'] = get_bloginfo('description');
        }
        return $data;
    }

    function rtp_ogp_get_headers($data) {
        if (!count($data)) {
            return;
        }
        $out = array();
        $out[] = "\n<!-- BEGIN: Open Graph Protocol : http://opengraphprotocol.org/ for more info -->";
        foreach ($data as $property => $content) {
            if ($content != '') {
                $out[] = "<meta property=\"{$property}\" content=\"" . htmlentities($content) . "\" />";
            } else {
                $out[] = "<!--{$property} value was blank-->";
            }
        }
        $out[] = "<!-- End: Open Graph Protocol -->\n";
        return implode("\n", $out);
    }

    function rtp_ogp_image_url() {
        global $post;
        $image = '';
        if ( is_singular() ) {
            if (has_post_thumbnail($post->ID)) {
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );
                if ( !empty ( $thumbnail ) ) {
                    $image = $thumbnail[0];
                }
            } else {
                $image = rtp_generate_thumbs( get_post_thumbnail_id( $post->ID ) );
                $image = ( $image ) ? $image : apply_filters( 'rtp_default_image_path', '' );
            }
        } else {
            $image = rtp_logo_fav_src('logo');
        }
        return $image;
    }
} ?>