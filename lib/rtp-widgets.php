<?php
/**
 * The template for displaying Custom Sidebar and footer widgets
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

/**
 * Makes a custom Widget for RSS Subscription and Social Share
 *
 * @since rtPanel Theme 2.0
 */
class rtp_subscribe_widget extends WP_Widget {

        /**
         * @since rtPanel Theme 2.0
         */
        function rtp_subscribe_widget() {
            $widget_ops = array( 'classname' => 'rtp-subscribe-widget-container', 'description' => __( 'Widget for email subscription form and Social Icons such as Facebook, Twitter, etc.', 'rtPanel' ) );
            $this->WP_Widget( 'rt-subscribe-widget', __( 'rt&para;: Subscribe Widget', 'rtPanel' ), $widget_ops );
        }

        /**
         * @since rtPanel Theme 2.0
         */
        function widget( $args, $instance ) {
            extract( $args, EXTR_SKIP );
            $title = empty(  $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
            $sub_link = $instance['sub_link'];
            $facebook_link = $instance['facebook_link'];
            $twitter_link = $instance['twitter_link'];
            $rss_link = $instance['rss_link'];
            $linkedin_link = $instance['linkedin_link'];
            $myspace_link = $instance['myspace_link'];
            $stumbleupon_link = $instance['stumbleupon_link'];
            $rt_link_target = $instance['rt_link_target'];
            $rt_subscription_show = $instance['rt_show_subscription'];
            $rt_facebook_show = $instance['rt_show_facebook'];
            $rt_twitter_show = $instance['rt_show_twitter'];
            $rt_rss_show = $instance['rt_show_rss'];
            $rt_linkedin_show = $instance['rt_show_linkedin'];
            $rt_myspace_show = $instance['rt_show_myspace'];
            $rt_stumbleupon_show = $instance['rt_show_stumbleupon'];

            echo $before_widget;
            if ( $title )
              echo $before_title . $title . $after_title; ?>

            <div class="email-subscription-container"> <!-- email-subscription-container begins -->
            <?php
                if ( $rt_subscription_show ) { ?>
                    <form onsubmit="window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $sub_link; ?>', 'popupwindow', 'scrollbars=yes,width=700px,height=700px' ); return true" target="popupwindow" method="post" action="http://feedburner.google.com/fb/a/mailverify">
                        <p>
                            <label for="email"><?php _e( 'Sign up for our email news letter', 'rtPanel' ); ?></label>
                            <input id="email" type="text" name="email" onblur="if ( this.value == '' ) { this.value = '<?php _e( 'Enter Email Id', 'rtPanel' ); ?>'; }" onfocus="if ( this.value == '<?php _e( 'Enter Email Id', 'rtPanel' ); ?>') { this.value = ''; }" value="<?php _e( 'Enter Email Id', 'rtPanel' ); ?>" class="email" title="<?php _e( 'Email Id', 'rtPanel' ); ?>" size="15" />
                            <input type="hidden" name="uri" value="<?php echo $sub_link; ?>" />
                            <input type="hidden" value="en_US" name="loc" />
                            <input type="submit" value="<?php _e( 'Sign Up', 'rtPanel' ); ?>" title="<?php _e( 'Subscribe', 'rtPanel' ); ?>" class="btn" />
                        </p>
                    </form><?php
                }
                $target = ( $rt_link_target ) ? 'target="_blank"' : '';

                if ( $rt_facebook_show || $rt_twitter_show || $rt_rss_show || $rt_linkedin_show || $rt_myspace_show || $rt_stumbleupon_show ) { ?>
                    <h4 class="stay-connected"><?php _e( 'Stay Connected', 'rtPanel' ); ?></h4>
                    <ul class="social-icons"><?php
                        echo ( $rt_facebook_show ) ? '<li><a rel="nofollow" ' . $target . ' class="facebook" href="' . $facebook_link . '" title="' . __( 'Follow Us on Facebook', 'rtPanel' ) . '">Facebook</a></li>' : '';
                        echo ( $rt_twitter_show ) ? '<li><a rel="nofollow" ' . $target . ' class="twitter" href="' . $twitter_link . '" title="' . __( 'Follow Us on Twitter', 'rtPanel' ) . '">Twitter</a></li>' : '';
                        echo ( $rt_rss_show ) ? '<li><a rel="nofollow" ' . $target . ' class="rss" href="' . $rss_link . '" title="' . __( 'Follow Us on RSS', 'rtPanel' ) . '">RSS</a></li>' : '';
                        echo ( $rt_linkedin_show ) ? '<li><a rel="nofollow" ' . $target . ' class="linkedin" href="' . $linkedin_link . '" title="' . __( 'Follow Us on LinkedIn', 'rtPanel' ) . '">LinkedIn</a></li>' : '';
                        echo ( $rt_myspace_show ) ? '<li><a rel="nofollow" ' . $target . ' class="myspace" href="' . $myspace_link . '" title="' . __( 'Follow Us on MySpace', 'rtPanel' ) . '">MySpace</a></li>' : '';
                        echo ( $rt_stumbleupon_show ) ? '<li><a rel="nofollow" ' . $target . ' class="stumbleupon" href="' . $stumbleupon_link . '" title="' . __( 'Follow Us on StumbleUpon', 'rtPanel' ) . '">StumbleUpon</a></li>' : ''; ?>
                    </ul><?php
                } ?>
                <div class="clear"></div>
            </div> <!-- end email-subscription-container -->
    <?php echo $after_widget;
        }

        /**
         * @since rtPanel Theme 2.0
         */
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags ( $new_instance['title'] );
            $instance['sub_link'] = strip_tags ( $new_instance['sub_link'] );
            $instance['rss_link'] = strip_tags ( $new_instance['rss_link'] );
            $instance['twitter_link'] = strip_tags ( $new_instance['twitter_link'] );
            $instance['facebook_link'] = strip_tags ( $new_instance['facebook_link'] );
            $instance['linkedin_link'] = strip_tags ( $new_instance['linkedin_link'] );
            $instance['myspace_link'] = strip_tags ( $new_instance['myspace_link'] );
            $instance['stumbleupon_link'] = strip_tags ( $new_instance['stumbleupon_link'] );
            $instance['rt_link_target'] = strip_tags ( $new_instance['rt_link_target'] );
            $instance['rt_show_subscription'] = $new_instance['rt_show_subscription'];
            $instance['rt_show_rss'] = $new_instance['rt_show_rss'];
            $instance['rt_show_facebook'] = $new_instance['rt_show_facebook'];
            $instance['rt_show_twitter'] =  $new_instance['rt_show_twitter'];
            $instance['rt_show_linkedin'] = $new_instance['rt_show_linkedin'];
            $instance['rt_show_myspace'] = $new_instance['rt_show_myspace'];
            $instance['rt_show_stumbleupon'] = $new_instance['rt_show_stumbleupon'];            
            return $instance;
        }

        /**
         * @since rtPanel Theme 2.0
         */
        function form( $instance ) {
            $title = isset ( $instance['title'] ) ? ( $instance['title'] ) : '';
            $sub_link = isset ( $instance['sub_link'] ) ? $instance['sub_link'] : '';
            $rss_link = isset ( $instance['rss_link'] ) ? $instance['rss_link'] : '';
            $twitter_link = isset ( $instance['twitter_link'] ) ? $instance['twitter_link'] : '';
            $facebook_link = isset ( $instance['facebook_link'] ) ? $instance['facebook_link'] : '';
            $linkedin_link = isset ( $instance['linkedin_link'] ) ? $instance['linkedin_link'] : '';
            $myspace_link = isset ( $instance['myspace_link'] ) ? $instance['myspace_link'] : '';
            $stumbleupon_link = isset ( $instance['stumbleupon_link'] ) ? $instance['stumbleupon_link'] : '';
            
            $defaults = array( 'rt_show_subscription' => '1', 'rt_show_rss' => '0', 'rt_show_facebook' => '0', 'rt_show_twitter' => '0', 'rt_show_linkedin' => '0', 'rt_show_myspace' => '0', 'rt_show_stumbleupon' => '0', 'rt_link_target' => '1' );

            // update instance's default options
            $instance = wp_parse_args( (array) $instance, $defaults );
            $rt_show_subscription = $instance['rt_show_subscription'] ? 1 : 0 ;
            $rt_show_rss = $instance['rt_show_rss'] ? 1 : 0;
            $rt_show_facebook = $instance['rt_show_facebook'] ? 1 : 0;
            $rt_show_twitter = $instance['rt_show_twitter'] ? 1 : 0 ;
            $rt_show_linkedin = $instance['rt_show_linkedin'] ? 1 : 0;
            $rt_show_myspace = $instance['rt_show_myspace'] ? 1 : 0;
            $rt_show_stumbleupon = $instance['rt_show_stumbleupon'] ? 1 : 0;
            $rt_link_target = $instance['rt_link_target'] ? 1 : 0; ?>

            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'rtPanel' ); ?>: </label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
            <p><strong><?php _e( 'RSS Subscribe', 'rtPanel' ); ?>: </strong></p><small>(<?php _e( 'Check to display', 'rtPanel' ); ?>)</small>
            <p>
                <input name="<?php echo $this->get_field_name( 'rt_show_subscription' ); ?>" type="hidden" value="0" />
                <input type="checkbox" name="<?php echo $this->get_field_name( 'rt_show_subscription' ); ?>" value="1" id="<?php echo $this->get_field_id( 'rt_show_subscription' ); ?>" <?php checked( $rt_show_subscription ); ?> />
                <label for="<?php echo $this->get_field_id( 'sub_link' ); ?>"><?php _e( 'RSS Subscription', 'rtPanel' ); ?> <abbr title="<?php _e( 'Uniform Resource Identifier', 'rtPanel' ); ?>"><?php _e( ' URI', 'rtPanel' ); ?></abbr>: </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'sub_link' ); ?>" name="<?php echo $this->get_field_name( 'sub_link' ); ?>" type="text" value="<?php echo esc_attr( $sub_link ); ?>" />
            </p>
            <p><strong><?php _e( 'Social Share', 'rtPanel' ); ?>:</strong></p>
            <small>(<?php _e( 'Check to display', 'rtPanel' ); ?>)</small>
            <p>
                <input name="<?php echo $this->get_field_name( 'rt_show_rss' ); ?>" type="hidden" value="0" />
                <input type="checkbox" name="<?php echo $this->get_field_name( 'rt_show_rss' ); ?>" value="1" id="<?php echo $this->get_field_id( 'rt_show_rss' ); ?>" <?php checked( $rt_show_rss ); ?> />
                <label for="<?php echo $this->get_field_id( 'rt_show_rss' ); ?>"><?php _e( 'RSS Feed Link', 'rtPanel' ); ?>: </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'rss_link' ); ?>" name="<?php echo $this->get_field_name( 'rss_link' ); ?>" type="text" value="<?php echo esc_attr( $rss_link ); ?>" />
            </p>
            <p>
                <input name="<?php echo $this->get_field_name( 'rt_show_facebook' ); ?>" type="hidden" value="0" />
                <input type="checkbox" name="<?php echo $this->get_field_name( 'rt_show_facebook' ); ?>" value="1" id="<?php echo $this->get_field_id( 'rt_show_facebook' ); ?>" <?php  checked( $rt_show_facebook ) ; ?> />
                <label for="<?php echo $this->get_field_id( 'rt_show_facebook' ); ?>"><?php _e( 'Facebook Link', 'rtPanel' ); ?>: </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'facebook_link' ); ?>" name="<?php echo $this->get_field_name( 'facebook_link' ); ?>" type="text" value="<?php echo esc_attr( $facebook_link ); ?>" />
            </p>
            <p>
                <input name="<?php echo $this->get_field_name( 'rt_show_twitter' ); ?>" type="hidden" value="0" />
                <input type="checkbox" name="<?php echo $this->get_field_name( 'rt_show_twitter' ); ?>" value="1" id="<?php echo $this->get_field_id( 'rt_show_twitter' ); ?>" <?php checked( $rt_show_twitter ) ; ?> />
                <label for="<?php echo $this->get_field_id( 'rt_show_twitter' ); ?>"><?php _e( 'Twitter Link', 'rtPanel' ); ?>: </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'twitter_link' ); ?>" name="<?php echo $this->get_field_name( 'twitter_link' ); ?>" type="text" value="<?php echo esc_attr( $twitter_link ); ?>" />
            </p>
            <p>
                <input name="<?php echo $this->get_field_name( 'rt_show_linkedin' ); ?>" type="hidden" value="0" />
                <input type="checkbox" name="<?php echo $this->get_field_name( 'rt_show_linkedin' ); ?>" value="1" id="<?php echo $this->get_field_id( 'rt_show_linkedin' ); ?>" <?php checked( $rt_show_linkedin ); ?> />
                <label for="<?php echo $this->get_field_id( 'rt_show_linkedin' ); ?>"><?php _e( 'LinkedIn Link', 'rtPanel' ); ?>: </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_link' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_link' ); ?>" type="text" value="<?php echo esc_attr( $linkedin_link ); ?>" />
            </p>
            <p>
                <input name="<?php echo $this->get_field_name( 'rt_show_myspace' ); ?>" type="hidden" value="0" />
                <input type="checkbox" name="<?php echo $this->get_field_name( 'rt_show_myspace' ); ?>" value="1" id="<?php echo $this->get_field_id( 'rt_show_myspace' ); ?>" <?php checked( $rt_show_myspace ); ?> />
                <label for="<?php echo $this->get_field_id( 'rt_show_myspace' ); ?>"><?php _e( 'MySpace Link', 'rtPanel' ); ?>: </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'myspace_link' ); ?>" name="<?php echo $this->get_field_name( 'myspace_link' ); ?>" type="text" value="<?php echo esc_attr( $myspace_link ); ?>" />
            </p>
            <p>
                <input name="<?php echo $this->get_field_name( 'rt_show_stumbleupon' ); ?>" type="hidden" value="0" />
                <input type="checkbox" name="<?php echo $this->get_field_name( 'rt_show_stumbleupon' ); ?>" value="1" id="<?php echo $this->get_field_id( 'rt_show_stumbleupon' ); ?>" <?php checked( $rt_show_stumbleupon ); ?> />
                <label for="<?php echo $this->get_field_id( 'rt_show_stumbleupon' ); ?>"><?php _e( 'StumbleUpon Link', 'rtPanel' ); ?>: </label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'stumbleupon_link' ); ?>" name="<?php echo $this->get_field_name( 'stumbleupon_link' ); ?>" type="text" value="<?php echo esc_attr( $stumbleupon_link ); ?>" />
            </p>
            <p>
                <input name="<?php echo $this->get_field_name( 'rt_link_target' ); ?>" type="hidden" value="0" />
                <input class="link_target" id="<?php echo $this->get_field_id( 'rt_link_target' ); ?>" value="1" name="<?php echo $this->get_field_name( 'rt_link_target' ); ?>" type="checkbox" <?php checked( $rt_link_target ); ?> />
                <label for="<?php echo $this->get_field_id( 'rt_link_target' ); ?>"><?php _e( 'Open Social Links in New Tab/Window', 'rtPanel' ); ?>: </label>
            </p><?php
        }
}

/**
 * Makes a custom Widget for Recent Comments
 *
 * @since rtPanel Theme 2.0
 */
class rtp_comments_widget extends WP_Widget {
            /**
             * @since rtPanel Theme 2.0
             */
            function rtp_comments_widget() {
                $widget_ops = array( 'classname' => 'rtp-comments-widget', 'description' => __( 'Widget for Show Recent Comment with Author Gravatar in Sidebar.', 'rtPanel' ) );
                $this->WP_Widget( 'rt-comments-widget', __( 'rt&para;: Comments with Gravatar', 'rtPanel' ), $widget_ops );
            }

            /**
             * @since rtPanel Theme 2.0
             */
            function widget( $args, $instance ) {
                extract( $args, EXTR_SKIP );
                $title = empty( $instance['title'] ) ? __( 'Recent Comments', 'rtPanel' ) : apply_filters('widget_title', $instance['title'] );
                $show_grav = !empty( $instance['show_grav'] ) ? $instance['show_grav'] : '';
                $gravatar = !empty( $instance['gravatar'] ) ? $instance['gravatar'] : 64;
                $count = !empty( $instance['count'] ) ? $instance['count'] : 0;
                $alternative = !empty( $instance['alternative'] ) ? $instance['alternative'] : '';
                echo $before_widget;
                    if ( $title )
                        echo $before_title . $title . $after_title;
                            global $wpdb;
                            $total_comments = $wpdb->get_results( "SELECT comment_date_gmt,comment_content, comment_author, comment_ID, comment_post_ID, comment_author_email, comment_date_gmt FROM " . $wpdb->comments . " WHERE comment_approved = '1' and comment_type != 'trackback' ORDER BY comment_date_gmt DESC LIMIT $count" );
                            
                            if ( !empty( $total_comments ) ) {
                                echo '<ul>';

                                for ( $comments = 0; $comments < $count; $comments++ ) {
                                    $right_grav = '';
                                    $left_readmore = '';
                                    $show_grav_on = '';

                                    if ( $alternative == 'on' ) {
                                        $right_grav = $comments % 2 ? ' float:right; ' : '' ;
                                        $left_readmore = $comments % 2 ? ' float:left; ' : '' ;
                                    } else {
                                        $right_grav = '';
                                        $left_readmore = '';
                                    }
                                    if ( $show_grav == 'on' ) {
                                        $show_grav_on = '';
                                    } else {
                                        $show_grav_on = ' display:none !important; ';
                                        $left_readmore = '';
                                    }
                                    echo '<li>';
                                        echo "<div class='comment-container clearfix'>";
                                            echo "<div class='author-vcard' style='" . $show_grav_on . ' ' . $right_grav . "' title='" . $total_comments[$comments]->comment_author . "'>";
                                                echo get_avatar( $total_comments[$comments]->comment_author_email, $gravatar, $default='<path_to_url>' );
                                            echo "</div>";
                                            echo "<div class='comment-section'>";
                                                echo '<div class="comment-date">';
                                                    echo '<a title="' . mysql2date( 'F j, Y - g:ia', $total_comments[$comments]->comment_date_gmt ) . '" href="' . get_permalink( $total_comments[$comments]->comment_post_ID ) . '#comment-' . $total_comments[$comments]->comment_ID . '">';
                                                    echo mysql2date( 'F j, Y - g:ia', $total_comments[$comments]->comment_date_gmt );
                                                    echo '</a>';
                                                echo '</div>';
                                                echo "<div class='author-comment'>";
                                                    $str = wp_html_excerpt ( $total_comments[$comments]->comment_content, 65 );
                                                    if ( strlen( $str ) >= 65 ) {
                                                        echo $str.'&hellip;';
                                                    } else {
                                                        echo $str;
                                                    }
                                                echo "</div>";
                                                echo '<div class="rtp-sidebar-readmore" style="' . $left_readmore . '" >';
                                                    echo '<a title="Read More" href="' . get_permalink($total_comments[$comments]->comment_post_ID) . '#comment-' . $total_comments[$comments]->comment_ID . '">';
                                                    echo 'Read More &rarr;';
                                                    echo '</a>';
                                                echo '</div>';
                                            echo '</div>'; //end of .comment-section
                                        echo '</div>'; //end of .comment-container
                                    echo '</li>';
                                }
                                echo '</ul>';
                            }
                 echo $after_widget;
        }

        /**
         * @since rtPanel Theme 2.0
         */
        function update( $new_instance, $old_instance ) {
            global $wpdb;
            $total_comments = get_comment_count();
            $comment_total = $total_comments['approved'];
            $instance = $old_instance;
            $instance['title'] = strip_tags ( $new_instance['title'] );
            $instance['show_grav'] = strip_tags ( $new_instance['show_grav'] );
            $instance['gravatar'] = strip_tags ( $new_instance['gravatar'] );
            $instance['count'] = strip_tags ( $new_instance['count']) > $comment_total ? $comment_total : strip_tags ( $new_instance['count'] );
            $instance['alternative'] = strip_tags ( $new_instance['alternative'] );
            return $instance;
        }

        /**
         * @since rtPanel Theme 2.0
         */
        function form($instance) {
            $title = isset ( $instance['title'] ) ? ( $instance['title'] ) : '';
            $show_grav = !empty( $instance['show_grav'] ) ? $instance['show_grav'] : 'on';
            $gravatar = !empty( $instance['gravatar'] ) ? $instance['gravatar'] : 64;
            $count = !empty( $instance['count'] ) ? $instance['count'] : 0;
            $alternative = !empty( $instance['alternative'] ) ? $instance['alternative'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'rtPanel' ); ?>: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'show_grav' ); ?>"><?php _e( 'Show Gravatar', 'rtPanel' ); ?>: </label>
            <input name="<?php echo $this->get_field_name( 'show_grav' ); ?>" type="hidden" value="off" />
            <input class="show_grav" id="<?php echo $this->get_field_id( 'show_grav' ); ?>" value="on" name="<?php echo $this->get_field_name( 'show_grav' ); ?>" type="checkbox" <?php checked( 'on', $show_grav ); ?> />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'gravatar' ); ?>"><?php _e( 'Gravatar Size', 'rtPanel' ); ?>: </label>
            <select id="<?php echo $this->get_field_id( 'gravatar' ); ?>" name="<?php echo $this->get_field_name( 'gravatar' ); ?>" style="width: 120px;">
                <option value="32" <?php selected( '32', $gravatar ); ?>>32px X 32px</option>
                <option value="40" <?php selected( '40', $gravatar ); ?>>40px X 40px</option>
                <option value="48" <?php selected( '48', $gravatar ); ?>>48px X 48px</option>
                <option value="56" <?php selected( '56', $gravatar ); ?>>56px X 56px</option>
                <option value="64" <?php selected( '64', $gravatar ); ?>>64px X 64px</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Show Comments', 'rtPanel' ); ?>: </label>
            <input class="widefat show-comments" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo $count; ?>" />
        </p>
        <?php
            global $wpdb;
            $total_comments = get_comment_count();
            $comment_total = $total_comments['approved']; ?>
            <div style='color: #444444; font-size: 11px; padding: 0 0 12px;'><?php printf( __( 'You have total \'%d\' comments to display', 'rtPanel' ) , $comment_total ); ?></div>
        <p>
            <label for="<?php echo $this->get_field_id( 'alternative' ); ?>"><?php _e( 'Show Alternate Comments', 'rtPanel' ); ?>: </label>
            <input name="<?php echo $this->get_field_name( 'alternative' ); ?>" type="hidden" value="off" />
            <input class="alternate" id="<?php echo $this->get_field_id( 'alternative' ); ?>" value="on" name="<?php echo $this->get_field_name( 'alternative' ); ?>" type="checkbox" <?php checked( 'on', $alternative ); ?> />
        </p>
        <script type="text/javascript">
            jQuery('.show-comments').keyup(function(){
                this.value = this.value.replace(/[^0-9\/]/g,'');
            });
        </script>
        <?php
        }
}

/**
 * Makes a custom Widget for Categories
 *
 * @since rtPanel Theme 2.0
 */
class rtp_category_widget extends WP_Widget {
            /**
             * @since rtPanel Theme 2.0
             */
            function rtp_category_widget() {
                $widget_ops = array( 'classname' => 'widget_rtp_category_widget', 'description' => __( 'Widget for Show Recent Comment with Author Gravatar in Sidebar.' ) );
                $this->WP_Widget( 'rt-categories-widget', __( 'rt&para;: Categories', 'rtPanel' ), $widget_ops );
            }
        
            /**
             * @since rtPanel Theme 2.0
             */
            function widget( $args, $instance ) {
                extract($args, EXTR_SKIP);                
                $title = empty( $instance['title'] ) ? __( 'Categories', 'rtPanel' ) : apply_filters( 'widget_title', $instance['title'] );
                $sortby = !empty( $instance['sortby'] ) ? $instance['sortby'] : 'name';
                $showstyle = !empty( $instance['showstyle'] ) ? $instance['showstyle'] : 'list';
                $order = !empty( $instance['order'] ) ? $instance['order'] : 'ASC';
                $show_cat = !empty( $instance['show_cat'] ) ? $instance['show_cat'] : 1;
                $exclude = !empty( $instance['exclude'] ) ? $instance['exclude'] : '';
                $exclude = preg_replace( '/\,$/', '', $exclude );
                $hierarchical = ( $instance['hierarchical'] == 'true' ) ? true : false;
                $show_count = ( $instance['show_count'] == '0' ) ? 0 : 1;
                $hideempty = ( $instance['hideempty'] == '0' ) ? 0 : 1;
                
                echo $before_widget;
                    if ( $title )
                        echo $before_title . $title . $after_title;
                    //$total_category = count( get_categories() );

                        if ( $showstyle == 'list' ) {
                            echo '<ul>';
                                wp_list_categories( array( 'hierarchical' => $hierarchical, 'style' => '' . $showstyle . '', 'hide_empty' => $hideempty, 'show_count' => $show_count, 'number' => $show_cat, 'exclude' => $exclude, 'orderby' => '' . $sortby . '', 'title_li' => '', 'order' => '' . $order . '' ) );
                            echo '</ul>';
                        } else {
                                wp_dropdown_categories( array( 'id' => 'rt_cat', 'name' => 'rt_cat', 'hierarchical' => $hierarchical, 'orderby' => '' . $sortby . '', 'order' => '' . $order . '', 'show_count' => $show_count, 'hide_empty' => $hideempty, 'exclude' => $exclude, 'class' => 'postform rt_cat_dropdown' ) ); ?>
                                <script type="text/javascript">
                                /* <![CDATA[ */
                                        var dropdown = document.getElementById("rt_cat");
                                        function onCatChange() {
                                                if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
                                                        location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
                                                }
                                        }
                                        dropdown.onchange = onCatChange;
                                /* ]]> */
                                </script>
                        <?php }

                 echo $after_widget;
        }

        /**
         * @since rtPanel Theme 2.0
         */
        function update( $new_instance, $old_instance ) {
            $total_category = count( get_categories() );
            $instance = $old_instance;
            $instance['title'] = strip_tags ( $new_instance['title'] );
            $instance['showstyle'] = strip_tags ( $new_instance['showstyle'] );
            $instance['hideempty'] = strip_tags ( $new_instance['hideempty'] );
            $instance['sortby'] = $new_instance['sortby'];
            $instance['order'] = $new_instance['order'];
            $instance['show_cat'] = strip_tags ( $new_instance['show_cat']) > $total_category ? $total_category : strip_tags ( $new_instance['show_cat'] );
            $instance['exclude'] = strip_tags ( $new_instance['exclude'] );
            $instance['hierarchical'] = $new_instance['hierarchical'];
            $instance['show_count'] = $new_instance['show_count'];
            return $instance;
        }

        /**
         * @since rtPanel Theme 2.0
         */
        function form($instance) {
            $title = isset ( $instance['title'] ) ? ( $instance['title'] ) : '';
            $showstyle = isset ( $instance['showstyle'] ) ? ( $instance['showstyle'] ) : 'list';
            $hideempty = isset ( $instance['hideempty'] ) ? ( $instance['hideempty'] ) : 1;
            $sortby = !empty( $instance['sortby'] ) ? $instance['sortby'] : 'name';
            $order = !empty( $instance['order'] ) ? $instance['order'] : 'ASC';
            $show_cat = !empty( $instance['show_cat'] ) ? $instance['show_cat'] : 1;
            $exclude = !empty( $instance['exclude'] ) ? $instance['exclude'] : '';
            $hierarchical = !empty( $instance['hierarchical'] ) ? $instance['hierarchical'] : 'true' ;
            $show_count = !empty( $instance['show_count'] ) ? $instance['show_count'] : '0' ; ?>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>" style="display: block; float: left; padding: 0 0 3px;"><?php _e( 'Title', 'rtPanel' ); ?>: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'sortby' ); ?>" style="display: block;float: left;padding: 3px 0 0;"><?php _e( 'Order by', 'rtPanel' ); ?>: </label>
                <select id="<?php echo $this->get_field_id( 'sortby' ); ?>" name="<?php echo $this->get_field_name( 'sortby' ); ?>" style="float: right; width: 120px;">
                    <option value="name" <?php selected( 'name', $sortby ); ?>><?php _e( 'Category Name', 'rtPanel' ); ?></option>
                    <option value="ID" <?php selected( 'ID', $sortby ); ?>><?php _e( 'Category ID', 'rtPanel' ); ?></option>
                    <option value="count" <?php selected( 'count', $sortby ); ?>><?php _e( 'Category Count', 'rtPanel' ); ?></option>
                    <option value="slug" <?php selected( 'slug', $sortby ); ?>><?php _e( 'Category Slug', 'rtPanel' ); ?></option>
                </select>
            </p>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'order' ); ?>" style="display: block;float: left;padding: 3px 0 0;"><?php _e( 'Sort by', 'rtPanel' ); ?>: </label>
                <select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" style="float: right; width: 120px;">
                    <option value="ASC" <?php selected( 'ASC', $order ); ?>><?php _e( 'Ascending', 'rtPanel' ); ?></option>
                    <option value="DESC" <?php selected( 'DESC', $order ); ?>><?php _e( 'Descending', 'rtPanel' ); ?></option>
                </select>
            </p>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'show_cat' ); ?>" style="display: block;float: left;padding: 3px 0 0;"><?php _e( 'Show Category', 'rtPanel' ); ?>:</label>
                <input class="widefat show-cat" id="<?php echo $this->get_field_id( 'show_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_cat' ); ?>" type="text" value="<?php echo $show_cat; ?>" style="clear: right; float: right; width: 120px;" />
                <span style="clear: both; display: block; color: #444444; font-size: 11px; padding: 5px 0 0;"><?php _e( 'Total Categories', 'rtPanel' ); ?>: <?php echo count( get_categories() ); ?></span>
            </p>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'showstyle' ); ?>" style="display: block;float: left;padding: 3px 0 0;"><?php _e( 'Style', 'rtPanel' ); ?>: </label>
                <select id="<?php echo $this->get_field_id( 'showstyle' ); ?>" name="<?php echo $this->get_field_name( 'showstyle' ); ?>" style="float: right; width: 120px;">
                    <option value="list" <?php selected( 'list', $showstyle ); ?>><?php _e( 'List', 'rtPanel' ); ?></option>
                    <option value="dropdown" <?php selected( 'dropdown', $showstyle ); ?>><?php _e( 'Dropdown', 'rtPanel' ); ?></option>
                </select>
            </p>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>" style="display: block;float: left;padding: 3px 0 0;"><?php _e( 'Hierarchy', 'rtPanel' ); ?>: </label>
                <select id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>" style="float: right; width: 120px;">
                    <option value="true" <?php selected( 'true', $hierarchical ); ?>>Yes</option>
                    <option value="false" <?php selected( 'false', $hierarchical ); ?>>No</option>
                </select>
            </p>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'hideempty' ); ?>" style="display: block;float: left;padding: 3px 0 0;"><?php _e( 'Hide Empty', 'rtPanel' ); ?>: </label>
                <select id="<?php echo $this->get_field_id( 'hideempty' ); ?>" name="<?php echo $this->get_field_name( 'hideempty' ); ?>" style="float: right; width: 120px;">
                    <option value="1" <?php selected( '1', $hideempty ); ?>>Yes</option>
                    <option value="0" <?php selected( '0', $hideempty ); ?>>No</option>
                </select>
            </p>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'show_count' ); ?>" style="display: block;float: left;padding: 3px 0 0;"><?php _e( 'Show Count', 'rtPanel' ); ?>: </label>
                <select id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" style="float: right; width: 120px;">
                    <option value="1" <?php selected( 1, $show_count ); ?>>Yes</option>
                    <option value="0" <?php selected( 0, $show_count ); ?>>No</option>
                </select>
            </p>
            <p style="overflow: hidden;">
                <label for="<?php echo $this->get_field_id( 'exclude' ); ?>" style="display: block; float: left; padding: 3px 0 0;"><?php _e( 'Exclude', 'rtPanel' ); ?>:</label>
                <input class="widefat exclude" id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" type="text" value="<?php echo $exclude; ?>" style="float: right; clear: right; margin: 0 0 0 3px; width: 120px;" /><br />
                <span style="clear: both; display: block; color: #444444; font-size: 11px; padding: 5px 0 0;"><?php _e( 'Separate Category ID with ","', 'rtPanel' ); ?>: <br />eg. 1,5,15</span>
            </p>
            <script type="text/javascript">
                jQuery('.show-cat').keyup( function () { this.value = this.value.replace(/[^0-9\/]/g,''); } );
                jQuery('.exclude').keyup( function () { this.value = this.value.replace(/[^0-9\,]/g,''); } );
            </script><?php
        }
}

/**
 * Registers all the custom widgets
 * 
 * @since rtPanel Theme 2.0
 */
function rt_register_widgets() {
    register_widget( 'rtp_subscribe_widget' );
    register_widget( 'rtp_comments_widget' );
    register_widget( 'rtp_category_widget' );
}
add_action( 'widgets_init', 'rt_register_widgets' );