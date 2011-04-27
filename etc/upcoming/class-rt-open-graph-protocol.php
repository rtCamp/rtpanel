<?php
/**
 * class for open graph protocol
 */
class rt_ogp {
    var $data;

    function rt_ogp() {
        add_action('wp_head', array($this, 'rt_ogp_add_head'));
    }

    function rt_ogp_add_head() {
        $this->data = $this->rt_ogp_set_data();
        echo $this->rt_ogp_get_headers($this->data);
    }

    function rt_ogp_set_data() {
        $data = array();
        if (is_single() || is_page()) {
            $data['og:title'] = get_the_title();
            $data['og:type'] = 'blog';
            $data['og:image'] = $this->rt_ogp_image_url();
            $data['og:url'] = get_permalink();
            $data['og:site_name'] = get_bloginfo('name');
        }
        else {
            $data['og:title'] = get_bloginfo('name');
            $data['og:type'] = 'blog';
            $data['og:image'] = $this->rt_ogp_image_url();
            $data['og:url'] = home_url();
            $data['og:site_name'] = get_bloginfo('name');
            $data['og:description'] = get_bloginfo('description');
        }
        return $data;
    }

    function rt_ogp_get_headers($data) {
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

    function rt_ogp_image_url() {
        global $post;
        $image = '';
        if (is_singular ()) {
            if (has_post_thumbnail($post->ID)) {
                $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'post-thumbnail');
                if (!empty ($thumbnail) ) {
                    $image = $thumbnail[0];
                }
            } else {
                $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
                if (!empty ($matches [1][0]) ) {
                    $image = $matches [1][0];
                }
            }
        }
        return $image;
    }
}
?>