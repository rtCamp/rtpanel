<?php
/*
 * This file contains all social networking related codes like faceboo like, retweet button
 * For details http://devilsworkshop.org/retweet-f-share-google-buzz-buttons-on-your-blog-without-plugins/
 */
return;
class rt_social_share {
    var $content;
    var $networks;
    var $postion;
    var $post_permalink;
    var $post_title;
    var $id;

    // constructor 
    function rt_social_share( $content = '', $networks = '', $postion = 'before_content' ) {
        global $id;
        $this->id = $id;
        $this->content = $content;
        $this->networks = $networks;
        $this->postion = $postion;
        $this->post_permalink = get_permalink($this->id);
        
        add_filter('the_content',array($this,'social_callback') );
        add_filter('the_excerpt',array($this,'social_callback') );
        //add_filter('the_category',array($this,'social_callback') );
    }

    function social_callback( $content ) {
        $this->post_permalink = get_permalink($this->id);
        $this->post_title = get_the_title($this->id);

        $html = '<div class="rt_social_icon">';

        foreach( $this->networks as $k => $v ) {
            $html .= call_user_func( array($this, 'get_'.$k ) );
        }
        $html .= '</div>';
        
        if ( $this->postion == 'before_content' ) {
            $content = $html.$content;
        }

        else if ( $this->postion == 'after_content' ) {
            $content .= $html;
        }
        return $content;
    }

    /* Facebook Share: http://wiki.developers.facebook.com/index.php/Facebook_Share */
    function get_facebook_share() {
        $size = $this->networks['facebook_share'];

        if ( !$this->networks['facebook_share'] || $this->networks['facebook_share'] == '')
            $size = 'button_count';
        
        return '<a name="fb_share" type="' . $size . '" share_url="' .  $this->post_permalink . '" title="Share &ldquo;'.$this->post_title.'&rdquo; on Facebook"></a>';
    }

    function get_facebook_like() {
        $size = $this->networks['facebook_like'];

        if ( !$this->networks['facebook_like'] || $this->networks['facebook_like'] == '') {
            $size = 'button_count';
        }

        if ( $size == 'standard' ) {
            $height = 35;
            $width = 450;
        }
        if ( $size == 'box_count' ) {
            $height = 65;
            $width = 50;
        }
        if ( $size == 'button_count' ) {
            $height = 21;
            $width = 90;
        }

         return '<iframe
            src="http://www.facebook.com/plugins/like.php?href='.rawurlencode(get_permalink($this->id)).'&amp;
            layout='.$size.'&amp;
            show_faces=false&amp;
            width='.$width.'&amp;
            action=like&amp;
            colorscheme=light&amp;
            height='.$height.'
            " scrolling="no" frameborder="0" style="border:none; overflow:hidden;
            width:'.$width.'px;
            height:'.$height.'px;"
            allowTransparency="true"></iframe>';
    }


    /* twitter button: http://twitter.com/about/resources/tweetbutton */
    function get_twitter() {
        $size = $this->networks['twitter'];

        if ( !$this->networks['twitter'] || $this->networks['twitter'] == '')
            $size = 'none';

        return '<a title="Share &ldquo;'.$this->post_title.'&rdquo; on Twitter" href="http://twitter.com/share" class="twitter-share-button" data-url="' .$this->post_permalink. '" data-text="' .$this->post_title. '" data-count="' .$size. '" >' .$this->post_title. '</a>
            <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
    }

    /* GoogleBuzz: http://www.google.com/buzz/api/admin/configPostWidget*/
    function get_googlebuzz() {
        $size = $this->networks['googlebuzz'];
        
        if ( !$this->networks['googlebuzz'] || $this->networks['googlebuzz'] == '')
            $size = 'normal-button';
    
        return '<a title="Share &ldquo;'.$this->post_title.'&rdquo; on Google Buzz" class="google-buzz-button" href="' . $this->post_permalink . '" data-button-style="' . $size . '"></a><script type="text/javascript" src="http://www.google.com/buzz/api/button.js"></script>';
    }

    /* Stumbleupon: http://www.stumbleupon.com/buttons/ */
    function get_stumbleupon() {
        $size = $this->networks['stumbleupon'];

        if ( !$this->networks['stumbleupon'] || $this->networks['stumbleupon'] == '')
            $size = '3';

        return  '<script src="http://www.stumbleupon.com/hostedbadge.php?s='.$size.'&r='.$this->post_permalink.'"></script>';
    }
}
?>