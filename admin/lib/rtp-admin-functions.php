<?php
/**
 * rtPanel Admin Functions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

global $rtp_general, $rtp_post_comments, $rtp_hooks;

// Redirect to rtPanel on theme activation
if ( is_admin() && isset ( $_GET['activated'] ) && $pagenow ==	'themes.php' ) {
    wp_redirect( 'themes.php?page=rtp_general' );
}

/**
 * Feedburner Redirection Code
 *
 * @uses string $feed
 * @uses array $rtp_general
 *
 * @since rtPanel 2.0
 */
function rtp_feed_redirect() {
    global $feed, $rtp_general, $withcomments;
    if ( is_feed() && $feed != 'comments-rss2' && ( $withcomments != 1 ) && !is_singular() && !is_archive() && !empty( $rtp_general['feedburner_url'] ) ) {
        if ( function_exists( 'status_header' ) ) {
            status_header( 302 );
        }
        header( 'Location: ' . trim( $rtp_general['feedburner_url'] ) );
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
 */
function rtp_check_url() {
    global $rtp_general;
    switch ( basename( $_SERVER['PHP_SELF'] ) ) {
        case 'wp-rss.php'         :
        case 'wp-rss2.php'        :
        case 'wp-atom.php'        :
        case 'wp-rdf.php'         : if ( trim( $rtp_general['feedburner_url'] ) != '') {
                                        if ( function_exists( 'status_header' ) ) {
                                            status_header( 302 );
                                        }
                                        header( 'Location: ' . trim( $rtp_general['feedburner_url'] ) );
                                        header( 'HTTP/1.1 302 Temporary Redirect' );
                                        exit();
                                    }
                                    break;

        case 'wp-commentsrss2.php': break;
    }
}

/* Condition to redirect WordPress feeds to feed burner */
if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && !preg_match( '/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
    add_action( 'template_redirect', 'rtp_feed_redirect' );
    add_action( 'init', 'rtp_check_url' );
}

/* condition to check Admin Login Logo option */
if ( $rtp_general['login_head'] && $rtp_general['logo_show'] ) {
    add_action( 'login_head', 'rtp_custom_login_logo' );
    add_filter( 'login_headerurl', 'rtp_login_site_url' );
}

/**
 * Dislays custom logo on Login Page
 *
 * @uses $rtp_general array
 *
 * @since rtPanel 2.0
 */
function rtp_custom_login_logo() {
    $custom_logo = rtp_logo_fav_src( $type = 'logo' );
    $size = @getimagesize( $custom_logo );
    echo '<style type="text/css">
        .login h1 a { background: url(' . $custom_logo . ') no-repeat scroll center top transparent;
               height: ' . $size[1] . 'px;
               width: ' . $size[0] . 'px; margin: 0 auto 15px; padding: 0; }
	</style>';
}

/**
 * Returns Home URL, to be used by custom logo
 * 
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_login_site_url() {
    return home_url('/');
}

/**
 * Modify options and structure of media upload dialog
 *
 * @param array $formfields Array of all the fields in form
 * @param object $post Global Post Object or similar object
 * @return Array
 *
 * @since rtPanel 2.0
 */
function rtp_theme_options_upload( $form_fields, $post ) {
    /* Can now see $post becaue the filter accepts two args, as defined in the add_fitler */
    if ( substr( $post->post_mime_type, 0, 5 ) == 'image' && ( preg_match( '/rtp_theme=rtp_true/i', wp_get_referer() ) ) || preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) || isset( $_POST['rtp_theme'] ) ) {

        $form_fields['url']['label'] = 'Path';
        $form_fields['url']['input'] = 'html';
        preg_match('/<button.*urlfile.*title=\'(.*)\'.*\/button>/iU', $form_fields['url']['html'], $file_path );
        $form_fields['url']['html'] = preg_replace( '/<button.*\/button>/i', '', $form_fields['url']['html'] );
        $form_fields['url']['html'] = preg_replace('/<input/i', '<input readonly="readonly"', $form_fields['url']['html'] );
        $form_fields['url']['html'] = preg_replace('/value=\'.*\'/iU', 'value=\'' . $file_path[1] . '\'', $form_fields['url']['html'] );
        $form_fields['url']['helps'] = '';

        $form_fields['post_excerpt']['value'] = '';
        $form_fields['post_excerpt']['input'] = 'hidden';

        $form_fields['post_content']['value'] = '';
        $form_fields['post_content']['input'] = 'hidden';

        $form_fields['image_alt']['value'] = '';
        $form_fields['image_alt']['input'] = 'hidden';

        $form_fields['align']['value'] = 'aligncenter';
        $form_fields['align']['input'] = 'hidden';

        $form_fields['image-caption']['value'] = 'caption';
        $form_fields['image-caption']['input'] = 'hidden';
        
        $form_fields['buttons'] = array(
            'label' => '',
            'value' => '',
            'input' => 'html'
        );
        $logo_or_favicon = ( preg_match( '/logo_or_favicon=Logo/', @$_SERVER['REQUEST_URI'] ) || preg_match( '/logo_or_favicon=Logo/', wp_get_referer() ) ) ? 'Logo' : 'Favicon';
        $filename = basename( $post->guid );
        $attachment_id = $post->ID;
        if ( current_user_can( 'delete_post', $attachment_id ) ) {
            if ( !EMPTY_TRASH_DAYS ) {
                $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme' value='rtp_true' /><a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id", 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __( 'Delete Permanently', 'rtPanel' ) . '</a>';
            } elseif ( !MEDIA_TRASH ) {
                $form_fields['buttons']['html'] = "<input type='submit' class='button' name='send[$attachment_id]' value='" . esc_attr__('Use This', 'rtPanel' ) . "' /><a href='#' class='del-link' onclick=\"document.getElementById('del_attachment_$attachment_id').style.display='block';return false;\">" . __( 'Delete', 'rtPanel' ) . "</a>
                                                     <div id='del_attachment_$attachment_id' class='del-attachment' style='display:none;'>" . sprintf( __( 'You are about to delete <strong>%s</strong>.', 'rtPanel' ), $filename) . "
                                                     <a href='" . wp_nonce_url( "post.php?action=delete&amp;post=$attachment_id&amp;rtp_theme=rtp_true&amp;logo_or_favicon=$logo_or_favicon" , 'delete-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='button'>" . __( 'Continue', 'rtPanel' ) . "</a>
                                                     <a href='#' class='button' onclick=\"this.parentNode.style.display='none';return false;\">" . __( 'Cancel', 'rtPanel' ) . "</a>
                                                     <input type='hidden' name='rtp_theme' value='rtp_true' />
                                                     </div>";
            } else {
                $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme' value='rtp_true' /><a href='" . wp_nonce_url( "post.php?action=trash&amp;post=$attachment_id", 'trash-attachment_' . $attachment_id ) . "' id='del[$attachment_id]' class='delete'>" . __( 'Move to Trash', 'rtPanel' ) . "</a><a href='" . wp_nonce_url( "post.php?action=untrash&amp;post=$attachment_id", 'untrash-attachment_' . $attachment_id ) . "' id='undo[$attachment_id]' class='undo hidden'>" . __( 'Undo', 'rtPanel' ) . "</a>";
            }
        } else {
            $form_fields['buttons']['html'] = "<input type='hidden' name='rtp_theme' value='rtp_true' />";
        }
    }
    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'rtp_theme_options_upload', 11, 2 );

/**
 * Removes tabs from media upload iframe
 *
 * @param array $tabs Array of all the Tabs present
 * @return Array
 *
 * @since rtPanel 2.0
 */
function rtp_remove_url_tab( $tabs ) {
    unset($tabs['type_url']);
    return $tabs;
}

// Check to see if we are in rtPanel Options Page and modify the Media Upload iframe
if ( is_admin() && isset ( $_SERVER['HTTP_REFERER'] ) && ( preg_match( "/rtp_general/i", wp_get_referer() ) || preg_match( '/rtp_theme=rtp_true/i', @$_SERVER['REQUEST_URI'] ) || preg_match( "/rtp_theme=rtp_true/i", wp_get_referer() )  || ( isset( $_POST['rtp_theme'] ) && preg_match( '/rtp_theme/i', $_POST['rtp_theme'] ) ) ) ) {
    add_filter( 'media_upload_tabs', 'rtp_remove_url_tab', 1, 2 );
}

/**
 * Default rtPanel admin sidebar with metabox styling
 *
 * @return rtPanel_admin_sidebar
 *
 * @since rtPanel 2.0
 */
function rtp_default_admin_sidebar() { ?>
    <div class="postbox" id="social">
        <div title="<?php _e('Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><?php _e('Getting Social is Good', 'rtPanel'); ?></span></h3>
        <div class="inside" style="text-align:center;">
            <a href="<?php printf( '%s', 'http://www.facebook.com/rtPanel' ); ?>" target="_blank" title="<?php _e( 'Become a fan on Facebook', 'rtPanel' ); ?>" class="rtpanel-facebook"><?php _e( 'Facebook', 'rtPanel' ); ?></a>
            <a href="<?php printf( '%s', 'http://twitter.com/rtPanel' ); ?>" target="_blank" title="<?php _e( 'Follow us on Twitter', 'rtPanel' ); ?>" class="rtpanel-twitter"><?php _e( 'Twitter', 'rtPanel' ); ?></a>
            <a href="<?php printf( '%s', 'http://feeds.feedburner.com/rtpanel' ); ?>" target="_blank" title="<?php _e( 'Subscribe to our feeds', 'rtPanel' ); ?>" class="rtpanel-rss"><?php _e( 'RSS Feed', 'rtPanel' ); ?></a>
        </div>
    </div>

    <div class="postbox" id="donations">
        <div title="<?php _e('Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><?php _e( 'Promote, Donate, Share', 'rtPanel' ); ?>...</span></h3>
        <div class="inside">
            <p><?php printf( __( 'Buy coffee/beer for team behind <a href="%s" title="rtPanel">rtPanel</a>.', 'rtPanel' ), 'http://rtcamp.com/rtpanel/' ); ?></p>
            <div class="rt-paypal" style="text-align:center">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_donations" />
                    <input type="hidden" name="business" value="paypal@rtcamp.com" />
                    <input type="hidden" name="lc" value="US" />
                    <input type="hidden" name="item_name" value="rtPanel" />
                    <input type="hidden" name="no_note" value="0" />
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest" />
                    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />
                    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                </form>
            </div>
            <div class="rt-social-share" style="text-align:center; width: 135px; margin: 2px auto">
                <div class="rt-facebook" style="float:left; margin-right:5px;">
                    <a style=" text-align:center;" name="fb_share" type="box_count" share_url="http://rtpanel.com/"></a>
                </div>
                <div class="rt-twitter" style="">
                    <a href="<?php printf( '%s', 'http://twitter.com/share' ); ?>"  class="twitter-share-button" data-text="I &hearts; #rtPanel"  data-url="http://rtcamp.com/rtpanel/" data-count="vertical" data-via="rtPanel"><?php _e( 'Tweet', 'rtPanel' ); ?></a>
                    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="postbox" id="support">
        <div title="<?php _e( 'Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><?php _e( 'Free Support', 'rtPanel' ); ?></span></h3>
        <div class="inside"><p><?php printf( __( 'If you have any problems with this theme or good ideas for improvements, please talk about them in the <a href="%s" target="_blank" title="Click here for rtPanel Free Support">Support forums</a>', 'rtPanel' ), 'http://rtcamp.com/support/forum/rtpanel/' ); ?>.</p></div>
    </div>

    <div class="postbox" id="latest_news">
        <div title="<?php _e( 'Click to toggle', 'rtPanel'); ?>" class="handlediv"><br /></div>
        <h3 class="hndle"><span><?php _e( 'Latest News', 'rtPanel' ); ?></span></h3>
        <div class="inside"><?php rtp_get_feeds(); ?></div>
    </div><?php
}

/**
 * Display feeds from a specified Feed URL
 *
 * @param string $feed_url The Feed URL.
 *
 * @since rtPanel 2.0
 */
function rtp_get_feeds( $feed_url='http://rtcamp.com/blog/category/rtpanel/feed/' ) {

    // Get RSS Feed(s)
    include_once( ABSPATH . WPINC . '/feed.php' );
    $maxitems = 0;
    // Get a SimplePie feed object from the specified feed source.
    $rss = fetch_feed( $feed_url );
    if ( !is_wp_error( $rss ) ) { // Checks that the object is created correctly

        // Figure out how many total items there are, but limit it to 5.
        $maxitems = $rss->get_item_quantity( 5 );

        // Build an array of all the items, starting with element 0 (first element).
        $rss_items = $rss->get_items( 0, $maxitems );
        
    } ?>
    <ul><?php
        if ( $maxitems == 0 ) {
            echo '<li>'.__( 'No items', 'rtPanel' ).'.</li>';
        } else {
            // Loop through each feed item and display each item as a hyperlink.
            foreach ( $rss_items as $item ) { ?>
                <li>
                    <a href='<?php echo $item->get_permalink(); ?>' title='<?php echo __( 'Posted ', 'rtPanel' ) . $item->get_date( 'j F Y | g:i a' ); ?>'><?php echo $item->get_title(); ?></a>
                </li><?php
            }
        } ?>
    </ul><?php
}

/**
 * Adds rtPanel Contextual help
 *
 * @return string
 *
 * @since rtPanel 2.1
 */
function rtp_theme_options_help() {
    
        $general_help = '<p>';
        $general_help .= __( 'rtPanel is the most easy to use WordPress Theme Framework. You will find many state of the art options and widgets with rtPanel. ', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( 'rtPanel is a theme framework for the world. Keeping this in mind our developers have made it localization ready. ', 'rtPanel' );
        $general_help .= __( 'Developers can use rtPanel as a basic and stripped to bones theme framework for developing their own creative and wonderful WordPress Themes.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( 'With the use of rtPanel developers and users can specify settings for basic functions (like date format, excerpt word count etc.) directly from theme options.', 'rtPanel' );
        $general_help .= __( ' rtPanel provides you with some theme options to manage some basic settings for your theme.', 'rtPanel' );
        $general_help .= __( ' Options provided for your convenience on this page are:', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>Logo Settings:</strong> You can manage your theme&#8217;s logo from this setting.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>Favicon Settings:</strong> You can manage your theme&#8217;s favicon from this setting.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>Facebook Open Graph Settings:</strong> You can specify your Faceboook App ID/Admin ID(s) with this setting.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>FeedBurner Settings:</strong> You can specify your FeedBurner URL from this setting to redirect your feeds.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>Google Custom Search Integration:</strong> You can specify the Google Custom Search Code here to harness the power of Google Search instead of the default WordPress search. You also have the option of rendering the Google Search Page without the sidebar.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>Sidebar Settings:</strong> Enable / Disable the Footer Sidebar from here.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>Custom Styles:</strong> You can specify your own CSS styles in this option to override the default Style.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>Plugin Support:</strong> You will get a summary of plugins status that are supported by rtPanel. This information box will allow you to manipulate the plugin settings on the fly.', 'rtPanel' );
        $general_help .= '</p><p>';
        $general_help .= __( '<strong>Backup rtPanel Options:</strong> You can export or import all settings that you have configured in rtPanel.', 'rtPanel' );
        $general_help .= '</p>';
        $general_help .= '<p>' . __( 'Remember to click "<strong>Save All Changes</strong>" to save any changes you have made to the theme options.', 'rtPanel' ) . '</p>';

        $post_comment_help = '<p>';
        $post_comment_help .= __( 'rtPanel is the world\'s easiest and smartest WordPress Theme. You can customize this theme and use it at your ease. You will find many state of the art options and widgets with rtPanel. ', 'rtPanel' );
        $post_comment_help .= '</p><p>';
        $post_comment_help .= __( 'rtPanel is a theme for the world. Keeping this in mind our developers have made it localization ready. ', 'rtPanel' );
        $post_comment_help .= __( 'Developers can use rtPanel as a basic and stripped to bones theme framework for developing their own creative and wonderful WordPress Themes.', 'rtPanel' );
        $post_comment_help .= '</p><p>';
        $post_comment_help .= __( 'With the use of rtPanel developers and users can specify settings for basic functions (like date format, excerpt word count etc.) directly from theme options.', 'rtPanel' );
        $post_comment_help .= __( ' rtPanel provides you with some theme options to manage some basic settings for your theme.', 'rtPanel' );
        $post_comment_help .= __( ' Options provided for your convenience on this page are:', 'rtPanel' );
        $post_comment_help .= '</p><p>';
        $post_comment_help .= __( '<strong>Post Summaries Options:</strong> You can specify the different excerpt parameters like word count etc.', 'rtPanel' );
        $post_comment_help .= '</p><p>';
        $post_comment_help .= __( '<strong>Post Thumbnail Options:</strong> You can specify the post thumbnail options like position, size etc.', 'rtPanel' );
        $post_comment_help .= '<br />';
        $post_comment_help .= __( '<small><strong><em>NOTE:</em></strong> If you use this option to change height or width of the thumbnail, then please use Regenerate Thumbnails Plugin to apply the new dimension settings to your thumbnails.</small>', 'rtPanel' );
        $post_comment_help .= '</p><p>';
        $post_comment_help .= __( '<strong>Post Meta Options:</strong> You can specify the post meta options like post date format, display or hide author name and their positions in relation with the content.', 'rtPanel' );
        $post_comment_help .= '</p><p>';
        $post_comment_help .= __( '<strong>Comment Form Settings:</strong> You can specify the comment form settings from this option.', 'rtPanel' );
        $post_comment_help .= '</p><p>';
        $post_comment_help .= __( '<strong>Gravtar Settings:</strong> You can specify the general Gravtar support from this option.', 'rtPanel' );
        $post_comment_help .= '</p>';
        $post_comment_help .= '<p>' . __( 'Remember to click "<strong>Save All Changes</strong>" to save any changes you have made to the theme options.', 'rtPanel' ) . '</p>';
        
	$sidebar = '<p><strong>' . __( 'For more information, <br />you can always visit:', 'rtPanel' ) . '</strong></p>' .
		'<p>' . __( '<a href="http://rtcamp.com/rtpanel/" target="_blank" title="rtPanel Official Page">rtPanel Official Page</a>', 'rtPanel' ) . '</p>' .
		'<p>' . __( '<a href="http://rtcamp.com/rtpanel/docs/" target="_blank" title="rtPanel Documentation">rtPanel Documentation</a>', 'rtPanel' ) . '</p>' .
		'<p>' . __( '<a href="http://rtcamp.com/support/forum/rtpanel/" target="_blank" title="rtPanel Forum">rtPanel Forum</a>', 'rtPanel' ) . '</p>';

	$screen = get_current_screen();
        
        if ( method_exists( $screen, 'add_help_tab' ) ) {
		// WordPress 3.3
		$screen->add_help_tab( array( 'title' => __( 'General', 'rtPanel' ), 'id' => 'rtp-general-help', 'content' => $general_help ) );
		$screen->add_help_tab( array( 'title' => __( 'Post &amp; Comment', 'rtPanel' ), 'id' => 'post-comments-help', 'content' => $post_comment_help ) );
		$screen->set_help_sidebar( $sidebar );
	} else {
		// WordPress 3.2
		add_contextual_help( $screen, $general_help . $sidebar );
		add_contextual_help( $screen, $post_comment_help . $sidebar );
	}
}
add_action( 'load-appearance_page_rtp_general', 'rtp_theme_options_help' );
add_action( 'load-appearance_page_rtp_post_comments', 'rtp_theme_options_help' );

/**
 * Show rtPanel only to Admin Users ( Admin-Bar only !!! )
 *
 * @since rtPanel 2.0
 */
function rtp_admin_bar_init() {
    // Is the user sufficiently leveled, or has the bar been disabled?
    if ( !is_super_admin() || !is_admin_bar_showing() ) {
        return;
    }
    // Good to go, let's do this!
    add_action( 'admin_bar_menu', 'rtp_admin_bar_links', 500 );
}
add_action( 'admin_bar_init', 'rtp_admin_bar_init' );

/**
 * Adds rtPanel links to Admin Bar
 *
 * @uses object $wp_admin_bar
 *
 * @since rtPanel 2.0
 */
function rtp_admin_bar_links() {
    global $wp_admin_bar, $rt_panel_theme;

    // Links to add, in the form: 'Label' => 'URL'
    foreach( $rt_panel_theme->theme_pages as $key=>$theme_page ) {
            if ( is_array( $theme_page ) )
                $links[$theme_page['menu_title']] = array( 'url' => admin_url( 'themes.php?page='.$theme_page['menu_slug'] ), 'slug' => $theme_page['menu_slug'] );
    }

    //  Add parent link
    $wp_admin_bar->add_menu( array(
        'title' => 'rtPanel',
        'href' => admin_url( 'themes.php?page=rtp_general' ),
        'id' => 'rt_links',
    ) );

    // Add submenu links
    foreach ( $links as $label => $menu ) {
        $wp_admin_bar->add_menu( array(
            'title' => $label,
            'href' => $menu['url'],
            'parent' => 'rt_links',
            'id' => $menu['slug']
        ) );
    }
}

/**
 * Returns 'src' value for Logo / Favicon
 *
 * @uses $rtp_general array
 * @param string $type Optional. Deafult is 'logo'. logo' or 'favicon'
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_logo_fav_src( $type = 'logo' ) {
    global $rtp_general;

    if( $type == 'logo' ) {
        if( $rtp_general['use_logo'] == 'use_logo_url' ) {
            return $rtp_general['logo_url'];
        } elseif ( $rtp_general['use_logo'] == 'use_logo_upload' ) {
            return $rtp_general['logo_upload'];
        }
    } else if($type == 'favicon') {
        if( $rtp_general['use_favicon'] == 'use_favicon_url' ) {
            return $rtp_general['favicon_url'];
        } elseif ( $rtp_general['use_favicon'] == 'use_favicon_upload' ) {
            return $rtp_general['favicon_upload'];
        }
    } else {
        return false;
    }
}

/**
 * Controls file-types for Logo / Favicon uploads
 * 
 * @param array $mime_types The allowed mime types
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_allowed_upload_extensions( $mime_types ) {
	//Creating a new array will reset the allowed filetypes
	if ( preg_match( '/logo_or_favicon=Logo/', wp_get_referer() ) || ( ( preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) ) && ( preg_match( '/logo_or_favicon=Logo/', $_SERVER['REQUEST_URI'] ) ) ) ) {
            $mime_types = array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'gif'          => 'image/gif',
                'png'          => 'image/png',
                'bmp'          => 'image/bmp',
                'ico'          => 'image/x-icon',
                'tif|tiff'     => 'image/tiff'
            );
        } elseif ( preg_match( '/logo_or_favicon=Favicon/', wp_get_referer() ) || ( ( preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) ) && ( preg_match( '/logo_or_favicon=Favicon/', $_SERVER['REQUEST_URI'] ) ) ) ) {
            $mime_types = array(
                'ico' => 'image/x-icon'
            );
        }
	return $mime_types;
}
add_filter( 'upload_mimes', 'rtp_allowed_upload_extensions', 1, 1 );

/**
 * Bypasses Flash Media Uploader
 *
 * @since rtPanel 2.0
 */
function rtp_media_upload_flash_bypass() {
        echo "<input type='hidden' name='rtp_theme' value='rtp_true' />";
        if ( preg_match( '/logo_or_favicon=Favicon/', wp_get_referer() ) || preg_match("/logo_or_favicon=Favicon/", $_SERVER['REQUEST_URI']) ) {
            echo '<script type="text/javascript">
                      jQuery("#tab-type a").attr("href","' . admin_url( '/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Favicon&type=image&TB_iframe=true&tab=type' ) . '" );
                      jQuery("#tab-library a").attr("href","' . admin_url( '/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Favicon&type=image&TB_iframe=true&tab=library' ) . '" );
                  </script>';
        } else {
            echo '<script type="text/javascript">
                      jQuery("#tab-type a").attr("href","' . admin_url( '/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Logo&type=image&TB_iframe=true&tab=type' ) . '" );
                      jQuery("#tab-library a").attr("href","' . admin_url( '/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Logo&type=image&TB_iframe=true&tab=library' ) . '" );
                  </script>';
        }
}

/**
 * Bypasses Browser Media Uploader
 *
 * @since rtPanel 2.0
 */
function rtp_media_upload_html_bypass( $flash = true ) {
    echo "<input type='hidden' name='rtp_theme' value='rtp_true' />";
    if ( preg_match( '/logo_or_favicon=Favicon/', wp_get_referer() ) || preg_match( "/logo_or_favicon=Favicon/", $_SERVER['REQUEST_URI'] ) ) {
        $favicon = '<script type="text/javascript">
                        jQuery("#tab-type a").attr("href","' . admin_url( '/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Favicon&type=image&TB_iframe=true&tab=type' ) . '" );
                        jQuery("#tab-library a").attr("href","' . admin_url( '/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Favicon&type=image&TB_iframe=true&tab=library' ) . '" );
                    </script>';
        echo $favicon;
    } else {
        $logo = '<script type="text/javascript">
                        jQuery("#tab-type a").attr("href","' . admin_url( '/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Logo&type=image&TB_iframe=true&tab=type' ) . '" );
                        jQuery("#tab-library a").attr("href","' . admin_url( '/media-upload.php?post_id=0&rtp_theme=rtp_true&logo_or_favicon=Logo&type=image&TB_iframe=true&tab=library' ) . '" );
                 </script>';
        echo $logo;
    }
}

/**
 * Adds a hidden input field to media library iframe
 *
 * @since rtPanel 2.0
 */
function add_hidden_rtp_variable(){
    echo "<script type='text/javascript'>
            jQuery('p#media-search').append('<input type=\"hidden\" name=\"rtp_theme\" value=\"rtp_true\" />');
          </script>";
}

/* Added filter on rtPanel Options Page Only */
if ( ( preg_match( '/rtp_theme=rtp_true/i', wp_get_referer() ) ) || ( preg_match( '/rtp_theme=rtp_true/i', $_SERVER['REQUEST_URI'] ) ) || ( isset( $_POST['rtp_theme'] ) && preg_match( '/rtp_theme/i', $_POST['rtp_theme'] ) ) ) {
    add_filter( 'flash_uploader', create_function('$flash', 'return false;'), 7 );
    add_action( 'post-flash-upload-ui', 'rtp_media_upload_flash_bypass' );
    add_action( 'post-html-upload-ui', 'rtp_media_upload_html_bypass' );
    add_action('admin_print_footer_scripts', 'add_hidden_rtp_variable');
}

/**
 * Used for redirection within the media library iframe
 * 
 * @param string $location Location to redirect
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_media_library_redirect( $location ) {
    $logo_or_favicon = ( preg_match( "/logo_or_favicon=Logo/", wp_get_referer() ) || preg_match( "/logo_or_favicon=Logo/", @$_SERVER['REQUEST_URI'] ) ) ? "Logo" : "Favicon";
    $location .= '&rtp_theme=rtp_true&logo_or_favicon='.$logo_or_favicon;
    return $location;
}

/* Added filter for the redirection in the iframe on rtPanel Options Page Only */
if( preg_match( "/rtp_theme=rtp_true/i", wp_get_referer() ) || preg_match( "/rtp_theme=rtp_true/i", $_SERVER['REQUEST_URI'] ) ) {
    add_filter( 'media_upload_form_url', 'rtp_media_library_redirect', 99, 1 );
    if ( isset( $_POST['save'] ) ) {
        wp_redirect(str_replace('tab=type', 'tab=library', wp_get_referer()));
    }
    elseif ( ( @$_GET['post-query-submit'] || @$_GET['s']) && !@$_GET['rtp_theme'] ) {
        $logo_or_favicon = ( preg_match( '/Logo/', wp_get_referer() ) ) ? 'Logo' : 'Favicon';
        wp_redirect( $_SERVER['REQUEST_URI'].'&rtp_theme=rtp_true&logo_or_favicon='.$logo_or_favicon );
    }
}

/**
 * Creates rtPanel Options backup file
 * 
 * @uses $wpdb object
 *
 * @since rtPanel 2.0
 */
function rtp_export( ) {
    global $wpdb;
    $sitename = sanitize_key( get_bloginfo( 'name' ) );

    if ( ! empty($sitename) ) $sitename .= '.';

    $filename = $sitename . 'rtpanel.' . date( 'Y-m-d' ) . '.rtp';
  
    $general = "WHERE option_name = 'rtp_general'";
    $post_comments = "WHERE option_name = 'rtp_post_comments'";
    $hooks = "WHERE option_name = 'rtp_hooks'";
    $args['rtp_general'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $general" );
    $args['rtp_post_comments'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $post_comments" );
    $args['rtp_hooks'] = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} $hooks" ); 
    
    header( 'Content-Description: File Transfer' );
    header( 'Content-Disposition: attachment; filename=' . $filename );
    header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true ); ?>
<rtpanel>
    <rtp_version><?php echo maybe_serialize( rtp_export_version() ); ?></rtp_version>
    <rtp_general><?php echo $args['rtp_general']; ?></rtp_general>
    <rtp_post_comments><?php echo $args['rtp_post_comments']; ?></rtp_post_comments>
</rtpanel>
<?php
}

/**
 * Restores rtPanel Options
 *
 * @uses $rtp_general array
 * @uses $rtp_post_comments array
 * @uses $rtp_hooks array
 * @param string $file The
 * @return bool|array
 *
 * @since rtPanel 2.0
 */
function rtp_import( $file ) {
    global $rtp_general, $rtp_post_comments;
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php' );
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php' );
    require_once( ABSPATH . '/wp-admin/includes/file.php' );

    @$file_object = new WP_Filesystem_Direct;
    $overrides = array( 'test_form' => false, 'test_type' => false );    
    $import_file = wp_handle_upload( $file, $overrides );
    extract( wp_check_filetype( $import_file['file'], array('rtp' => 'txt/rtp') ) );
    $data = wp_remote_get( $import_file['url'] );
    $file_object->delete( $import_file['file'] );
    if ( $ext != 'rtp' ) {
         return 'ext';
    }
    if ( is_wp_error( $data ) ) {
        return false;
    } else {
        preg_match('/\<rtp_general\>(.*)<\/rtp_general\>/is', $data['body'], $general);
        preg_match('/\<rtp_post_comments\>(.*)<\/rtp_post_comments\>/is', $data['body'], $post_comments);
        if( !empty( $post_comments[1] ) ) {
            update_option( 'rtp_post_comments', maybe_unserialize( $post_comments[1] ) );
        }
        return $general[1];
    }
}

/**
 * Adds Custom Logo to Admin Dashboard ;)
 *
 * @since rtPanel 2.0
 */
function rtp_custom_admin_logo() {
   echo '<style type="text/css"> #header-logo { background: url("' . RTP_IMG_FOLDER_URL . '/rtp-icon-small.jpg") no-repeat scroll center center transparent !important; } </style>';
}
add_action( 'admin_head', 'rtp_custom_admin_logo' );

/**
 * Adds custom footer text
 *
 * @since rtPanel 2.0
 */
function rtp_custom_admin_footer( $footer_text ) {
    echo $footer_text;
    printf( '<br /><br />' . __( 'Currently using <a href="%s" title="rtPanel" target="_blank">rtPanel</a>', 'rtPanel' ) . ' | '
            . __( '<a href="%s" title="Click here for rtPanel Free Support" target="_blank">Support</a>', 'rtPanel' ) . ' | '
            . __( '<a href="%s" title="Click here for rtPanel Documentation" target="_blank">Documentation</a>', 'rtPanel' ), 'http://rtcamp.com/rtpanel/', 'http://rtcamp.com/support/forum/rtpanel/', 'http://rtcamp.com/rtpanel/docs/' );
}
add_filter( 'admin_footer_text', 'rtp_custom_admin_footer' );

/**
 * Gets rtPanel and WordPress version
 *
 * @since rtPanel 2.0
 */
function rtp_export_version() {
    global $wp_version;
    require_once( ABSPATH . '/wp-admin/includes/update.php' );
    $theme_info = get_theme( get_current_theme() );
    if ( is_child_theme() ) {
        $theme_info = get_theme( $theme_info['Parent Theme'] );
    }
    $theme_version = array( 'wp' => $wp_version, 'rtPanel' => $theme_info['Version'] );
    return $theme_version;
}

/**
 * Gets rtPanel and WordPress version (in text) for footer
 *
 * @since rtPanel 2.0
 */
function rtp_version( $update_footer ) {
    global $rtp_version;
    $update_footer .= '<br /><br />' . __( 'rtPanel Version ', 'rtPanel' ) . $rtp_version;
    return $update_footer;
}
add_filter( 'update_footer', 'rtp_version', 9999 );

/**
 * Handles ajax call to remove the 'regenerate thumbnail' notice
 *
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.0
 */
function rtp_handle_regenerate_notice() {
    global $rtp_post_comments;
    if( isset( $_POST['hide_notice'] ) ) {
        $rtp_post_comments['notices'] = '0';
        update_option( 'rtp_post_comments', $rtp_post_comments );
    }
}
add_action( 'wp_ajax_hide_regenerate_thumbnail_notice', 'rtp_handle_regenerate_notice' );

/**
 * Handles ajax call to remove the upgrade theme notice
 *
 * @uses $rtp_post_comments array
 *
 * @since rtPanel 2.1
 */
function rtp_handle_upgrade_theme_notice() {
    global $rtp_post_comments;
    if( isset( $_POST['hide_upgrade_theme'] ) ) {
        $rtp_post_comments['upgrade_theme'] = '0';
        update_option( 'rtp_post_comments', $rtp_post_comments );
    }
    die();
}
add_action( 'wp_ajax_hide_upgrade_theme_notice', 'rtp_handle_upgrade_theme_notice' );

/**
 *  Displays the regenerate thumbnail notice
 *
 * @since rtPanel 2.0
 */
function rtp_regenerate_thumbnail_notice( $return = false ) {
    if( current_user_can( 'administrator' ) ) {
        if ( is_plugin_active( RTP_REGENERATE_THUMBNAILS ) ) {
            $regenerate_link = admin_url( '/tools.php?page=regenerate-thumbnails' );
        } elseif ( array_key_exists( RTP_REGENERATE_THUMBNAILS, get_plugins() ) ) {
            $regenerate_link = admin_url( '/plugins.php#regenerate-thumbnails' );
        } else {
            $regenerate_link = wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=regenerate-thumbnails' ), 'install-plugin_regenerate-thumbnails' );
        }

        if( $return ) {
            return $regenerate_link;
        } else {
            echo '<div class="error regenerate_thumbnail_notice"><p>' . sprintf( __( 'The Thumbnail Settings have been updated. Please <a href="%s" title="Regenerate Thumbnails">Regenerate Thumbnails</a>.', 'rtPanel' ), $regenerate_link ) . ' <span class="alignright regenerate_thumbnail_notice_close" href="#">X</a></p></div>';
        }
    } else {
        return;
    }
}

/**
 *  Displays the upgrade theme notice
 *
 * @since rtPanel 2.0
 */
function rtp_upgrade_theme_notice() {
    if( current_user_can( 'administrator' ) && is_child_theme() ) {
        echo '<div class="error upgrade_theme_notice"><p>' . sprintf( __( 'If you are using a child theme made on a previous version on rtPanel. Please <a class="upgrade_theme_activate_script" href="%s" title="Click Here">Click Here</a>', 'rtPanel' ), '#' ) . ' <span class="alignright upgrade_theme_notice_close" href="#">X</a></p></div>';
    }
}

/* Shows 'regenerate thumbnail' notice ( Admin User Only !!! ) */
if ( is_admin() && @$rtp_post_comments['notices'] ) {
    add_action( 'admin_notices', 'rtp_regenerate_thumbnail_notice');
}

/* Shows upgrade theme notice ( Admin User Only !!! ) */
if ( is_admin() && @$rtp_post_comments['upgrade_theme'] ) {
    add_action( 'admin_notices', 'rtp_upgrade_theme_notice');
}

/**
 * Outputs neccessary script to hide 'regenerate thumbnail' notice
 *
 * @since rtPanel 2.0
 */
function rtp_regenerate_thumbnail_notice_js() { ?>
    <script type="text/javascript" >
        jQuery(function(){
            jQuery('#wpbody-content').css( 'padding-bottom', '85px' );
            jQuery('.regenerate_thumbnail_notice_close').css( 'color', '#CC0000' );
            jQuery('.regenerate_thumbnail_notice_close').css( 'cursor', 'pointer' );
            jQuery('.regenerate_thumbnail_notice_close').click(function(e){
                e.preventDefault();
                jQuery('.regenerate_thumbnail_notice').hide();
                // call ajax
                jQuery.ajax({
                    url:"<?php echo admin_url('admin-ajax.php'); ?>",
                    type:'POST',
                    data:'action=hide_regenerate_thumbnail_notice&hide_notice=1'
                });
            });
        });
    </script><?php
}
add_action( 'admin_head', 'rtp_regenerate_thumbnail_notice_js' );

/**
 * Outputs neccessary script to hide upgrade theme notice
 *
 * @since rtPanel 2.0
 */
function rtp_upgrade_theme_notice_js() { ?>
    <script type="text/javascript" >
        jQuery(function(){
            jQuery('#wpbody-content').css( 'padding-bottom', '85px' );
            jQuery('.upgrade_theme_notice_close').css( 'color', '#CC0000' );
            jQuery('.upgrade_theme_notice_close').css( 'cursor', 'pointer' );
            jQuery('.upgrade_theme_notice_close').click(function(e){
                e.preventDefault();
                jQuery('.upgrade_theme_notice').hide();
                // call ajax
                jQuery.ajax({
                    url:"<?php echo admin_url('admin-ajax.php'); ?>",
                    type:'POST',
                    data:'action=hide_upgrade_theme_notice&hide_upgrade_theme=1'
                });
            });
        });
    </script><?php
}
add_action( 'admin_head', 'rtp_upgrade_theme_notice_js' );

/* Removes 'regenerate thumbnail' notice ( Admin User Only !!! ) */
if ( is_admin() && $pagenow == 'tools.php' && ( @$_GET['page'] == 'regenerate-thumbnails' ) && @$_POST['regenerate-thumbnails'] ) {
    $rtp_notice = get_option('rtp_post_comments');
    $rtp_notice['notices'] = '0';
    update_option( 'rtp_post_comments', $rtp_notice );
}

/* Check if regeneration of thumbnail is required, or not */
if ( is_array( $rtp_post_comments ) && ( @$rtp_post_comments['thumbnail_width'] != get_option( 'thumbnail_size_w' ) || @$rtp_post_comments['thumbnail_height'] != get_option( 'thumbnail_size_h' ) || @$rtp_post_comments['thumbnail_crop'] != get_option( 'thumbnail_crop' ) ) ) {
    $rtp_post_comments['notices'] = '1';
    $rtp_post_comments['thumbnail_width'] = get_option( 'thumbnail_size_w' );
    $rtp_post_comments['thumbnail_height'] = get_option( 'thumbnail_size_h' );
    $rtp_post_comments['thumbnail_crop'] = get_option( 'thumbnail_crop' );
    update_option( 'rtp_post_comments', $rtp_post_comments );
}

/* Check if upgrade of theme is required, or not */
if ( is_array( $rtp_post_comments ) && !isset( $rtp_post_comments['upgrade_theme'] ) ) {
    $rtp_post_comments['upgrade_theme'] = '1';
    update_option( 'rtp_post_comments', $rtp_post_comments );
}

/**
 * Checks if a new version of rtPanel is available
 *
 * @since rtPanel 2.1
 */
function rtp_is_update_available(){
    static $themes_update;

    require_once( ABSPATH . '/wp-admin/includes/theme.php' );
    $theme = current_theme_info();

    if ( !current_user_can('update_themes' ) )
        return;

    if ( !isset($themes_update) )
        $themes_update = get_site_transient('update_themes');

    if ( is_object($theme) && isset($theme->stylesheet) )
        $stylesheet = $theme->stylesheet;
    elseif ( is_array($theme) && isset($theme['Stylesheet']) )
        $stylesheet = $theme['Stylesheet'];
    else
        return false; //No valid info passed.

    if ( isset($themes_update->response[ $stylesheet ]) ) {
        return true;
    } else {
        false;
    }
}
  
/**
 * Adds Styles dropdown to TinyMCE Editor
 *
 * @since rtPanel 2.1
 */
function rtp_mce_editor_buttons( $buttons ) {  
    array_unshift( $buttons, 'styleselect' );  
    return $buttons;  
}
add_filter( 'mce_buttons_2', 'rtp_mce_editor_buttons' );  
  
/**
 * Adds Non Semantic Helper classes/styles dropdown to TinyMCE Editor
 *
 * @since rtPanel 2.1
 */ 
function rtp_mce_before_init( $settings ) {  
  
    $style_formats = array(  
        array(  
            'title' => 'Clean',  
            'block' => 'div',  
            'classes' => 'clean',  
            'wrapper' => true  
        ),
        array(  
            'title' => 'Alert',  
            'block' => 'div',  
            'classes' => 'alert',  
            'wrapper' => true  
        ),
        array(  
            'title' => 'Info',  
            'block' => 'div',  
            'classes' => 'info',  
            'wrapper' => true  
        ),
        array(  
            'title' => 'Success',  
            'block' => 'div',  
            'classes' => 'success',  
            'wrapper' => true  
        ),
        array(  
            'title' => 'Warning',  
            'block' => 'div',  
            'classes' => 'warning',  
            'wrapper' => true  
        ),
        array(  
            'title' => 'Error',  
            'block' => 'div',  
            'classes' => 'error',  
            'wrapper' => true  
        )
    );  
  
    $settings['style_formats'] = json_encode( $style_formats );  
    return $settings;  
}
add_filter( 'tiny_mce_before_init', 'rtp_mce_before_init' );  