<?php
/**
 * Initialize rtPanel Options.
 *
 * Setting Screen layout Columns and Screen Options.
 * Added options for rtPanel in Admin menu.
 * Loaded Metaboxes for rtPanel Options.
 *
 * @since 2.0.0
 * @package rtPanel
 */

/**
* Include all PHP files inside 'admin/php/' folder.
*/
foreach ( glob( get_template_directory() . "/admin/lib/*.php" ) as $lib_filename ) {
    require_once( $lib_filename );
}

/**
 * rtPanel Theme Class.
 *
 * Used to generate the rtPanel admin Panel Options.
 */
class rtp_theme {

    /**
    * Constructor of class, PHP4 compatible construction for backward compatibility.
    */
    function rtp_theme() {
        /* Add filter for WordPress 2.8 changed backend box system ! */
        add_filter( 'screen_layout_columns', array( &$this, 'rtp_on_screen_layout_columns' ), 10, 2 );

        /* Set Screen Layout columns to 1 by default for any user for first time... */
        add_action( 'admin_init', array( &$this, 'rtp_init' ) );
        /* Register callback for admin menu  setup */
        add_action( 'admin_menu', array( &$this, 'rtp_theme_option_page' ) );
    }

        /**
	 * Added option in screen option for 1 or 2 columns layout.
	 * For WordPress 2.8 we have to tell, that we support 2 columns !
	 *
	 * by default it is 1 column.
	 *
         * @param array $columns number of columns.
	 * @param string $screen screen name
         * @return array.
	 */
    function rtp_on_screen_layout_columns($columns, $screen) {
        $tab = isset($_GET['page'] )  ? $_GET['page'] : "rtp_general";
        if ( $screen == 'appearance_page_' . $tab ) {
            $columns['appearance_page_' . $tab] = 2;
        }
        return $columns;
    }


    /**
     * Set Screen Layout columns to 1 by default for any user for first time...
     */
    function rtp_init() {
        $tab = isset($_GET['page'] )  ? $_GET['page'] : "rtp_general";
        $blog_users = get_users();
        foreach ( $blog_users as $blog_user ) {
            $blog_user_id = $blog_user->ID;
            if ( !get_user_meta( $blog_user_id, 'screen_layout_appearance_page_' . $tab ) ) {
                update_user_meta( $blog_user_id, 'screen_layout_appearance_page_' . $tab, 1, NULL );
            }
        }
    }

    /**
     * Extend the admin menu.
     *
     * Adding options for rtPanel in admin menu.
     */
    function rtp_theme_option_page() {
        /* Add options page, you can also add it to different sections or use your own one */
        $tab = isset($_GET['page'] )  ? $_GET['page'] : "rtp_general";
        add_theme_page( 'rtPanel', '<strong class="rtpanel">rt&para;anel</strong>', 'edit_theme_options', 'rtp_general', array( &$this, 'rtp_admin_options' ) );
        add_theme_page( 'rtPanel', '--- <em>' . __( 'General', 'rtPanel') . '</em>', 'edit_theme_options', 'rtp_general', array( &$this, 'rtp_admin_options' ) );
        add_theme_page( 'rtPanel', '--- <em>' . __( 'Post &amp; Comments', 'rtPanel' ) . '</em>', 'edit_theme_options', 'rtp_post_comments', array( &$this, 'rtp_admin_options' ) );
        add_theme_page( 'rtPanel', '--- <em>' . __( 'Hooks', 'rtPanel' ) . '</em>', 'edit_theme_options', 'rtp_hooks', array( &$this, 'rtp_admin_options' ) );

        /* Register  callback gets call prior the own page gets rendered. */
        add_action( 'load-appearance_page_' . $tab, array( &$this, 'rtp_on_load_page' ) );
        add_action( 'admin_print_styles-appearance_page_' . $tab, array( &$this, 'rtp_admin_page_styles' ) );
        add_action( 'admin_print_scripts-appearance_page_' . $tab, array( &$this, 'rtp_admin_page_scripts' ) );
        rtp_theme_setup_values();
    }

    /**
     * Including javascripts scripts for theme options page.
     *
     */
    function rtp_admin_page_scripts() {
        if ( preg_match( '/rtp_general|rtp_post_comments|rtp_hooks/i', @$_GET['page'] ) ) {
            wp_enqueue_script( 'rtp-admin-scripts', RTP_TEMPLATE_URL . '/admin/js/rtp-admin.js' );
            wp_enqueue_script( 'rtp-modernizer', RTP_TEMPLATE_URL . '/admin/js/modernizr-1.7.min.js' );
            wp_enqueue_script( 'thickbox' );
        }
    }

    /**
     *  Including stylesheet for theme options page.
     */
    function rtp_admin_page_styles() {
        if ( preg_match( '/rtp_general|rtp_post_comments|rtp_hooks/i', @$_GET['page'] ) ) {
            wp_enqueue_style( 'rtp-admin-styles', RTP_TEMPLATE_URL . '/admin/css/rtp-admin.css' );
            wp_enqueue_style( 'thickbox'); //thickbox for logo and favicon upload option
        }
    }

    /**
     * Dividing the page into Tabs ( General, post & Comments )
     */
    function rtp_admin_options() {
        /* Separate the options page into two tabs - General & Post Comments. */
        global $pagenow;
        $tabs = array( 'rtp_general' => __( 'General', 'rtPanel' ), 'rtp_post_comments' => __( 'Post &amp; Comments', 'rtPanel' ), 'rtp_hooks' => __( 'Hooks', 'rtPanel' ) );
        $links = array();

        /* Check to see which tab we are on. */
        $current = isset($_GET['page'] )  ? $_GET['page'] : "rtp_general";
        foreach ( $tabs as $tab => $name ) {
            if ( $tab == $current ) {
                $links[] = "<a class='nav-tab nav-tab-active' href='?page=$tab'>$name</a>";
            } else {
                $links[] = "<a class='nav-tab' href='?page=$tab'>$name</a>";
            }
        }
?>
    <div class="metabox-fixed metabox-holder alignright">
        <?php rtp_default_sidebar(); ?>
    </div>

    <div class="wrap"><!-- wrap begins -->
        <div class="icon32" id="icon-themes"></div>
        <h2><?php foreach ( $links as $link ) echo $link; ?></h2><?php
        if ( $pagenow == 'themes.php' ) {
            $tab = isset($_GET['page'] )  ? $_GET['page'] : "rtp_general";
            switch ( $tab ) {
                case 'rtp_general' :
                    rtp_general_options_page( 'appearance_page_' . $current );
                    break;
                case 'rtp_post_comments' :
                    rtp_post_comments_options_page( 'appearance_page_' . $current );
                    break;
                case 'rtp_hooks' :
                    rtp_hooks_options_page( 'appearance_page_' . $current );
                    break;
            }
        } ?>
        </div><!-- end wrap -->
<?php
    }

    /**
     * Will be executed if wordpress core detects this page has to be rendered.
     */
    function rtp_on_load_page() {
        /* Javascripts loaded to allow drag/drop, expand/collapse and hide/show of boxes. */
        wp_enqueue_script( 'common' );
        wp_enqueue_script( 'wp-lists' );
        wp_enqueue_script( 'postbox' );

        /* Check to see which tab we are on. */
        $tab = isset($_GET['page'] )  ? $_GET['page'] : "rtp_general";
        switch ( $tab ) {
            case 'rtp_general' :
                /* All metaboxes registered during load page can be switched off/on at "Screen Options" automatically, nothing special to do therefore. */
                add_meta_box( 'logo_options', __( 'Logo Settings', 'rtPanel'), 'rtp_logo_option_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'fav_options', __( 'Favicon Settings', 'rtPanel'), 'rtp_fav_option_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'feed_options', __( 'Feedburner Settings', 'rtPanel'), 'rtp_feed_option_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'google_search', __( 'Google Custom Search Integration', 'rtPanel'), 'rtp_google_search_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'plugin_support', __( 'Plugin Support', 'rtPanel'), 'rtp_plugin_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'custom_styles', __( 'Custom Styles', 'rtPanel' ), 'rtp_custom_styles_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'backup_options', __( 'Backup rtPanel Options', 'rtPanel' ), 'rtp_backup_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                break;
            case 'rtp_post_comments' :
                /* All metaboxes registered during load page can be switched off/on at "Screen Options" automatically, nothing special to do therefore. */
                add_meta_box( 'post_summaries_options', __('Post Summaries Options', 'rtPanel'), 'rtp_post_summaries_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'post_thumbnail_options', __('Post Thumbnail Options', 'rtPanel'), 'rtp_post_thumbnail_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'post_meta_options', __('Post Meta Options', 'rtPanel'), 'rtp_post_meta_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'comment_form_options', __('Comment Form Settings', 'rtPanel'), 'rtp_comment_form_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'gravatar_options', __('Gravatar Settings', 'rtPanel'), 'rtp_gravatar_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                break;
            case 'rtp_hooks' :
                /* All metaboxes registered during load page can be switched off/on at "Screen Options" automatically, nothing special to do therefore. */
                add_meta_box( 'hook_options', __( 'Hook Options', 'rtPanel' ), 'rtp_hooks_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                break;
        }
    }
}

/**
* Display rtPanel
*/
$rt_panel_theme = new rtp_theme();

//================================================




function rtp_hooks_metabox() {
        global $rtp_hooks; ?>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_before_header"><?php _e( 'Hook Before Header', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[before_header]" id="rtp_hook_before_header"><?php echo $rtp_hooks['before_header']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_after_header"><?php _e( 'Hook After Header', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[after_header]" id="rtp_hook_after_header"><?php echo $rtp_hooks['after_header']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_before_logo"><?php _e( 'Hook Before Logo', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[before_logo]" id="rtp_hook_before_logo"><?php echo $rtp_hooks['before_logo']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_after_logo"><?php _e( 'Hook After Logo', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[after_logo]" id="rtp_hook_after_logo"><?php echo $rtp_hooks['after_logo']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_after_content_wrapper_begins"><?php _e( 'Hook Before Content Wrapper', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[before_content_wrapper]" id="rtp_hook_after_content_wrapper_begins"><?php echo $rtp_hooks['before_content_wrapper']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_after_content_wrapper"><?php _e( 'Hook After Content Wrapper', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[after_content_wrapper]" id="rtp_hook_after_content_wrapper"><?php echo $rtp_hooks['after_content_wrapper']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_after_content_begins"><?php _e( 'Hook Before Content', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[before_content]" id="rtp_hook_after_content_begins"><?php echo $rtp_hooks['before_content']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_before_content_ends"><?php _e( 'Hook After Content', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[after_content]" id="rtp_hook_before_content_ends"><?php echo $rtp_hooks['after_content']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_before_post"><?php _e( 'Hook Before Post Start', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[before_post_start]" id="rtp_hook_before_post"><?php echo $rtp_hooks['before_post_start']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_after_post"><?php _e( 'Hook After Post End', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[after_post_end]" id="rtp_hook_after_post"><?php echo $rtp_hooks['after_post_end']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_before_sidebar"><?php _e( 'Hook Before Sidebar', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[before_sidebar]" id="rtp_hook_before_sidebar"><?php echo $rtp_hooks['before_sidebar']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_before_sidebar_ends"><?php _e( 'Hook After Sidebar', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[after_sidebar]" id="rtp_hook_before_sidebar_ends"><?php echo $rtp_hooks['after_sidebar']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_before_footer"><?php _e( 'Hook Before Footer', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[before_footer]" id="rtp_hook_before_footer"><?php echo $rtp_hooks['before_footer']; ?></textarea><br /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><p><label for="rtp_hook_after_footer"><?php _e( 'Hook After Footer', 'rtPanel' ); ?></label></p></th>
                        <td><textarea cols="33" rows="5" name="rtp_hooks[after_footer]" id="rtp_hook_after_footer"><?php echo $rtp_hooks['after_footer']; ?></textarea><br /></td>
                    </tr>
                </tbody>
            </table>
            <div class="rtp_submit">
                <input class="button-primary" value="<?php _e( 'Save', 'rtPanel' ); ?>" name="rtp_submit" type="submit" />
                <input class="button-secondary" value="<?php _e( 'Reset', 'rtPanel' ); ?>" name="rtp_hook_reset" type="submit" />
                <div class="clear"></div>
            </div><?php
}

//===========================================


/**
 * Funtion to evalutate and execute php code
 * @param string $content
 * @return string
 */
function rtp_eval_php($content)
	{
		ob_start();
		eval("?>$content<?php ");
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

foreach ( $rtp_hooks as $hook_name=>$code ) {
    if ( $code != '' )
        add_action( 'rtp_hook_'.$hook_name, 'rtp_'.$hook_name );
}

function rtp_before_header( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['before_header']);
}
function rtp_after_header( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['after_header']);
}
function rtp_before_logo( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['before_logo']);
}
function rtp_after_logo( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['after_logo']);
}
function rtp_before_content_wrapper( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['before_content_wrapper']);
}
function rtp_after_content_wrapper( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['after_content_wrapper']);
}
function rtp_before_content( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['before_content']);
}
function rtp_after_content( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['after_content']);
}
function rtp_before_post_start( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['before_post_start']);
}
function rtp_after_post_end( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['after_post_end']);
}
function rtp_before_sidebar( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['before_sidebar']);
}
function rtp_after_sidebar( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['after_sidebar']);
}
function rtp_before_footer( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['before_footer']);
}
function rtp_after_footer( ) {
    global $rtp_hooks;
    echo rtp_eval_php($rtp_hooks['after_footer']);
}


