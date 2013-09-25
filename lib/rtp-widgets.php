<?php
/**
 * rtPanel Custom Widgets
 *
 * A small 'icing on cake' ;)
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */

/**
 * Custom Widget for FeedBurner RSS Subscription and Social Share
 *
 * @since rtPanel 2.0
 */
class rtp_subscribe_widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     *
     * @since rtPanel 2.0
     **/
    function rtp_subscribe_widget() {
        $widget_ops = array( 'classname' => 'rtp-subscribe-widget-container', 'description' => __( 'Widget for email subscription form and Social Icons such as Facebook, Twitter, etc.', 'rtPanel' ) );
        $this->WP_Widget( 'rt-subscribe-widget', __( 'rtPanel: Subscribe Widget', 'rtPanel' ), $widget_ops );
    }

    /**
     * Outputs the HTML
     *
     * @param array An array of standard parameters for widgets in this theme
     * @param array An array of settings for this widget instance
     * @return void Echoes it's output
     *
     * @since rtPanel 2.0
     **/
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $title = empty(  $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
        $label = empty( $instance['label'] ) ? '' : $instance['label'];
        $button = empty( $instance['button'] ) ? __( 'Subscribe', 'rtPanel' ) : $instance['button'];
        $sub_link = empty ( $instance['sub_link'] ) ? '' : $instance['sub_link'];
        $facebook_link = empty ( $instance['facebook_link'] ) ? '' : $instance['facebook_link'];
        $twitter_link = empty ( $instance['twitter_link'] ) ? '' : $instance['twitter_link'];
        $google_link = empty ( $instance['google_link'] ) ? '' : $instance['google_link'];
        $rss_link = empty ( $instance['rss_link'] ) ? '' : $instance['rss_link'];
        $linkedin_link = empty ( $instance['linkedin_link'] ) ? '' : $instance['linkedin_link'];
        $myspace_link = empty ( $instance['myspace_link'] ) ? '' : $instance['myspace_link'];
        $stumbleupon_link = empty ( $instance['stumbleupon_link'] ) ? '' : $instance['stumbleupon_link'];
        $rtp_link_target = isset( $instance['rtp_link_target'] ) ? $instance['rtp_link_target'] : true;
        $rtp_subscription_show = isset( $instance['rtp_show_subscription'] ) ? $instance['rtp_show_subscription'] : true;
        $rtp_facebook_show = isset( $instance['rtp_show_facebook'] ) ? $instance['rtp_show_facebook'] : true;
        $rtp_google_show = isset( $instance['rtp_show_google'] ) ? $instance['rtp_show_google'] : true;
        $rtp_twitter_show = isset( $instance['rtp_show_twitter'] ) ? $instance['rtp_show_twitter'] : true;
        $rtp_rss_show = isset( $instance['rtp_show_rss'] ) ? $instance['rtp_show_rss'] : true;
        $rtp_linkedin_show = isset( $instance['rtp_show_linkedin'] ) ? $instance['rtp_show_linkedin'] : true;
        $rtp_myspace_show = isset( $instance['rtp_show_myspace'] ) ? $instance['rtp_show_myspace'] : true;
        $rtp_stumbleupon_show = isset( $instance['rtp_show_stumbleupon'] ) ? $instance['rtp_show_stumbleupon'] : true;
        $no_options = 0;

        echo $before_widget;
        if ( $title )
          echo $before_title . $title . $after_title; ?>

        <div class="email-subscription-container"><!-- email-subscription-container begins -->
        <?php
            if ( $rtp_subscription_show && $sub_link ) {
                $no_options++; ?>
                <form onsubmit="window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $sub_link; ?>', 'popupwindow', 'scrollbars=yes,width=700px,height=700px' ); return true" target="popupwindow" method="post" action="http://feedburner.google.com/fb/a/mailverify" class="clearfix">
                    <p><?php 
                        if ( $label ) { ?>
                            <label for="email"><?php echo $label; ?></label><?php
                        } ?>
                        <input id="email" type="email" required="required" name="email" placeholder="<?php _e( 'Enter Email Address', 'rtPanel' ); ?>" class="email" title="<?php _e( 'Enter Email Address', 'rtPanel' ); ?>" size="15" />
                        <input type="hidden" aria-hidden="true" name="uri" value="<?php echo $sub_link; ?>" />
                        <input type="hidden" aria-hidden="true" value="en_US" name="loc" />
                        <input type="submit" value="<?php echo $button; ?>" title="<?php echo $button; ?>" class="btn" />
                    </p>
                </form><?php
            }

            $target = ( $rtp_link_target ) ? ' target="_blank"' : '';

            if ( ( $rtp_facebook_show && $facebook_link ) || ( $rtp_twitter_show && $twitter_link ) || ( $rtp_google_show && $google_link ) || ( $rtp_rss_show && $rss_link ) || ( $rtp_linkedin_show && $linkedin_link ) || ( $rtp_myspace_show && $myspace_link ) || ( $rtp_stumbleupon_show && $stumbleupon_link ) ) {
                $no_options++; ?>
                <ul role="list" class="social-icons clearfix"><?php
                    echo ( $rtp_facebook_show && $facebook_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="facebook" href="' . $facebook_link . '" title="' . __( 'Like Us on Facebook', 'rtPanel' ) . '"><i class="icon-facebook"></i></a></li>' : '';
                    echo ( $rtp_twitter_show && $twitter_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="twitter" href="' . $twitter_link . '" title="' . __( 'Follow Us on Twitter', 'rtPanel' ) . '"><i class="icon-twitter"></i></a></li>' : '';
                    echo ( $rtp_google_show && $google_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="google" href="' . $google_link . '" title="' . __( 'Add to Circle', 'rtPanel' ) . '"><i class="icon-google-plus"></i></a></li>' : '';
                    echo ( $rtp_rss_show && $rss_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="rss" href="' . $rss_link . '" title="' . __( 'Subscribe via RSS', 'rtPanel' ) . '"><i class="icon-rss"></i></a></li>' : '';
                    echo ( $rtp_linkedin_show && $linkedin_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="linkedin" href="' . $linkedin_link . '" title="' . __( 'Connect via LinkedIn', 'rtPanel' ) . '"><i class="icon-linkedin"></i></a></li>' : '';
                    echo ( $rtp_myspace_show && $myspace_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="myspace" href="' . $myspace_link . '" title="' . __( 'Join Us on MySpace', 'rtPanel' ) . '">MySpace</a></li>' : '';
                    echo ( $rtp_stumbleupon_show && $stumbleupon_link ) ? '<li role="listitem"><a role="link" rel="nofollow"' . $target . ' class="stumbleupon" href="' . $stumbleupon_link . '" title="' . __( 'Stumble Us', 'rtPanel' ) . '">StumbleUpon</a></li>' : ''; ?>
                </ul><?php
            }

            if( !$no_options ) { ?>
            <p><?php printf( __( 'Please configure this widget <a href="%s" target="_blank" title="Configure Subscribe Widget">here</a>.', 'rtPanel' ), admin_url( '/widgets.php' ) ); ?></p><?php
            } ?>
        </div> <!-- end email-subscription-container -->
    <?php echo $after_widget;
    }

    /**
     * Deals with the settings when they are saved by the admin
     *
     * @since rtPanel 2.0
     **/
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags ( $new_instance['title'] );
        $instance['label'] =  strip_tags ( $new_instance['label'] );
        $instance['button'] =  !empty( $new_instance['button'] ) ? strip_tags ( $new_instance['button'] ) : 'Subscribe';
        $instance['sub_link'] = !empty( $new_instance['sub_link'] ) ? $new_instance['sub_link'] : '';
        $instance['rss_link'] = esc_url_raw( $new_instance['rss_link'] );
        $instance['twitter_link'] = esc_url_raw( $new_instance['twitter_link'] );
        $instance['facebook_link'] = esc_url_raw( $new_instance['facebook_link'] );
        $instance['google_link'] = esc_url_raw( $new_instance['google_link'] );
        $instance['linkedin_link'] = esc_url_raw( $new_instance['linkedin_link'] );
        $instance['myspace_link'] = esc_url_raw( $new_instance['myspace_link'] );
        $instance['stumbleupon_link'] = esc_url_raw( $new_instance['stumbleupon_link'] );
        $instance['rtp_link_target'] = !empty( $new_instance['rtp_link_target'] ) ? 1 : 0;
        $instance['rtp_show_subscription'] = !empty( $new_instance['rtp_show_subscription'] ) ? 1 : 0;
        $instance['rtp_show_rss'] = !empty( $new_instance['rtp_show_rss'] ) ? 1 : 0;
        $instance['rtp_show_facebook'] = !empty( $new_instance['rtp_show_facebook'] ) ? 1 : 0;
        $instance['rtp_show_twitter'] =  !empty( $new_instance['rtp_show_twitter'] ) ? 1 : 0;
        $instance['rtp_show_google'] =  !empty( $new_instance['rtp_show_google'] ) ? 1 : 0;
        $instance['rtp_show_linkedin'] = !empty( $new_instance['rtp_show_linkedin'] ) ? 1 : 0;
        $instance['rtp_show_myspace'] = !empty( $new_instance['rtp_show_myspace'] ) ? 1 : 0;
        $instance['rtp_show_stumbleupon'] = !empty( $new_instance['rtp_show_stumbleupon'] ) ? 1 : 0;
        return $instance;
    }

    /**
     * Displays the form on the Widgets page of the WP Admin area
     *
     * @since rtPanel 2.0
     **/
    function form( $instance ) {
        $defaults = array( 'label' => 'Sign up for our email newsletter', 'button' => 'Subscribe', 'rtp_show_subscription' => '0', 'rtp_show_rss' => '0', 'rtp_show_facebook' => '0', 'rtp_show_twitter' => '0', 'rtp_show_google' => '0', 'rtp_show_linkedin' => '0', 'rtp_show_myspace' => '0', 'rtp_show_stumbleupon' => '0', 'rtp_link_target' => '1' );
        // update instance's default options
        $instance = wp_parse_args( (array) $instance, $defaults );
        
        $title = isset ( $instance['title'] ) ? esc_attr( ( $instance['title'] ) ) : '';
        $label = isset ( $instance['label'] ) ? esc_textarea( ( $instance['label'] ) ) : '';
        $button = isset ( $instance['button'] ) ? esc_attr( ( $instance['button'] ) ) : 'Subscribe';
        $sub_link = isset ( $instance['sub_link'] ) ? esc_attr( $instance['sub_link'] ) : '';
        $rss_link = isset ( $instance['rss_link'] ) ? esc_url( $instance['rss_link'] ) : '';
        $twitter_link = isset ( $instance['twitter_link'] ) ? esc_url( $instance['twitter_link'] ) : '';
        $facebook_link = isset ( $instance['facebook_link'] ) ? esc_url( $instance['facebook_link'] ) : '';
        $google_link = isset ( $instance['google_link'] ) ? esc_url( $instance['google_link'] ) : '';
        $linkedin_link = isset ( $instance['linkedin_link'] ) ? esc_url( $instance['linkedin_link'] ) : '';
        $myspace_link = isset ( $instance['myspace_link'] ) ? esc_url( $instance['myspace_link'] ) : '';
        $stumbleupon_link = isset ( $instance['stumbleupon_link'] ) ? esc_url( $instance['stumbleupon_link'] ) : '';

        $rtp_show_subscription = isset( $instance['rtp_show_subscription'] ) ? (bool) $instance['rtp_show_subscription'] :false;
        $rtp_show_rss = isset( $instance['rtp_show_rss'] ) ? (bool) $instance['rtp_show_rss'] :false;
        $rtp_show_facebook = isset( $instance['rtp_show_facebook'] ) ? (bool) $instance['rtp_show_facebook'] :false;
        $rtp_show_twitter = isset( $instance['rtp_show_twitter'] ) ? (bool) $instance['rtp_show_twitter'] :false;
        $rtp_show_google = isset( $instance['rtp_show_google'] ) ? (bool) $instance['rtp_show_google'] :false;
        $rtp_show_linkedin = isset( $instance['rtp_show_linkedin'] ) ? (bool) $instance['rtp_show_linkedin'] :false;
        $rtp_show_myspace = isset( $instance['rtp_show_myspace'] ) ? (bool) $instance['rtp_show_myspace'] :false;
        $rtp_show_stumbleupon = isset( $instance['rtp_show_stumbleupon'] ) ? (bool) $instance['rtp_show_stumbleupon'] :false;
        $rtp_link_target = isset( $instance['rtp_link_target'] ) ? (bool) $instance['rtp_link_target'] :false; ?>
        
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'rtPanel' ); ?>: </label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $title ); ?>" /></p>
        <p><strong><?php _e( 'FeedBurner RSS Subscription', 'rtPanel' ); ?>: </strong></p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'rtp_show_subscription' ); ?>" id="<?php echo $this->get_field_id( 'rtp_show_subscription' ); ?>" <?php checked( $rtp_show_subscription ); ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_show_subscription' ); ?>"><?php _e( 'Feedburner Subscription Handler', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'sub_link' ); ?>" name="<?php echo $this->get_field_name( 'sub_link' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $sub_link ); ?>" />
            <span class="description"><?php printf( __( 'Ex: %s would be the FeedBurner Subscription Handler for %s', 'rtPanel' ), '<strong><code>rtpanel</code></strong>', '<code>http://feeds.feedburner.com/<strong>rtpanel</strong></code>' ); ?></span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e( 'Feedburner Form Label', 'rtPanel' ); ?>: </label>
            <textarea class="widefat" rows="2" cols="20" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>"><?php echo $label; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'button' ); ?>"><?php _e( 'Feedburner Form Button', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $button ); ?>" />
        </p>
        <p><strong><?php _e( 'Social Share', 'rtPanel' ); ?>:</strong></p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'rtp_show_rss' ); ?>" id="<?php echo $this->get_field_id( 'rtp_show_rss' ); ?>" <?php checked( $rtp_show_rss ); ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_show_rss' ); ?>"><?php _e( 'RSS Feed Link', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'rss_link' ); ?>" name="<?php echo $this->get_field_name( 'rss_link' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $rss_link ); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'rtp_show_facebook' ); ?>" id="<?php echo $this->get_field_id( 'rtp_show_facebook' ); ?>" <?php  checked( $rtp_show_facebook ) ; ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_show_facebook' ); ?>"><?php _e( 'Facebook Link', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'facebook_link' ); ?>" name="<?php echo $this->get_field_name( 'facebook_link' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $facebook_link ); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'rtp_show_twitter' ); ?>" id="<?php echo $this->get_field_id( 'rtp_show_twitter' ); ?>" <?php checked( $rtp_show_twitter ) ; ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_show_twitter' ); ?>"><?php _e( 'Twitter Link', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'twitter_link' ); ?>" name="<?php echo $this->get_field_name( 'twitter_link' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $twitter_link ); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'rtp_show_google' ); ?>" id="<?php echo $this->get_field_id( 'rtp_show_google' ); ?>" <?php checked( $rtp_show_google ) ; ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_show_google' ); ?>"><?php _e( 'Google+ Link', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'google_link' ); ?>" name="<?php echo $this->get_field_name( 'google_link' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $google_link ); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'rtp_show_linkedin' ); ?>" id="<?php echo $this->get_field_id( 'rtp_show_linkedin' ); ?>" <?php checked( $rtp_show_linkedin ); ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_show_linkedin' ); ?>"><?php _e( 'LinkedIn Link', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_link' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_link' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $linkedin_link ); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'rtp_show_myspace' ); ?>" id="<?php echo $this->get_field_id( 'rtp_show_myspace' ); ?>" <?php checked( $rtp_show_myspace ); ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_show_myspace' ); ?>"><?php _e( 'MySpace Link', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'myspace_link' ); ?>" name="<?php echo $this->get_field_name( 'myspace_link' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $myspace_link ); ?>" />
        </p>
        <p>
            <input role="checkbox" type="checkbox" name="<?php echo $this->get_field_name( 'rtp_show_stumbleupon' ); ?>" id="<?php echo $this->get_field_id( 'rtp_show_stumbleupon' ); ?>" <?php checked( $rtp_show_stumbleupon ); ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_show_stumbleupon' ); ?>"><?php _e( 'StumbleUpon Link', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'stumbleupon_link' ); ?>" name="<?php echo $this->get_field_name( 'stumbleupon_link' ); ?>" type="text" role="textbox" value="<?php echo esc_attr( $stumbleupon_link ); ?>" />
        </p>
        <p>
            <input class="link_target" id="<?php echo $this->get_field_id( 'rtp_link_target' ); ?>" name="<?php echo $this->get_field_name( 'rtp_link_target' ); ?>" role="checkbox" role="checkbox" role="checkbox" role="checkbox" type="checkbox" <?php checked( $rtp_link_target ); ?> />
            <label for="<?php echo $this->get_field_id( 'rtp_link_target' ); ?>"><?php _e( 'Open Social Links in New Tab/Window', 'rtPanel' ); ?></label>
        </p><?php
    }
}

/**
 * Registers all rtPanel Custom Widgets
 * 
 * @since rtPanel 2.0
 */
function rtp_register_widgets() {
    register_widget( 'rtp_subscribe_widget' );
}
add_action( 'widgets_init', 'rtp_register_widgets' );