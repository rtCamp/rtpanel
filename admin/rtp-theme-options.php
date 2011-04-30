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

    /* Public variable */
    var $theme_pages;

    /**
    * Constructor of class, PHP4 compatible construction for backward compatibility.
    */
    function rtp_theme() {
        
  /*       @param string $page_title The text to be displayed in the title tags of the page when the menu is selected
 * @param string $menu_title The text to be used for the menu
 * @param string $capability The capability required for this menu to be displayed to the user.
 * @param string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
 * @param callback $function The function to be called to output the content for this page.
 */
        $this->theme_pages = apply_filters( 'rtp_add_theme_pages', array(
            'rtp_general' => array(
                            'menu_title' => __( 'General', 'rtPanel' ),
                            'menu_slug' => 'rtp_general'
                            ),
            'rtp_post_comments' => array(
                            'menu_title' => __( 'Post &amp; Comments', 'rtPanel' ),
                            'menu_slug' => 'rtp_post_comments'
                            ) )

        );
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
    function rtp_theme_option_page(  ) {
        /* Add options page, you can also add it to different sections or use your own one */
        add_theme_page( 'rtPanel', '<strong class="rtpanel">rtPanel</strong>', 'edit_theme_options', 'rtp_general', array( &$this, 'rtp_admin_options' ) );
        foreach( $this->theme_pages as $key=>$theme_page ) {
            if ( is_array( $theme_page ) )
            add_theme_page( 'rtPanel', '--- <em>' . $theme_page['menu_title'] . '</em>', 'edit_theme_options', $theme_page['menu_slug'], array( &$this, 'rtp_admin_options' ) );
        }

        $tab = isset( $_GET['page'] )  ? $_GET['page'] : "rtp_general";
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
        $tabs = array();
        foreach( $this->theme_pages as $key=>$theme_page ) {
            if ( is_array( $theme_page ) )
            $tabs[$theme_page['menu_slug']] = $theme_page['menu_title'];
        }
        $links = array();

        /* Check to see which tab we are on. */
        $current = isset( $_GET['page'] )  ? $_GET['page'] : "rtp_general";
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
        <?php screen_icon( 'rtpanel' ); ?>
        <h2 class="rtp-tab-wrapper"><?php foreach ( $links as $link ) echo $link; ?></h2><?php
        if ( $pagenow == 'themes.php' ) {
            foreach( $this->theme_pages as $key=>$theme_page ) {
                if ( is_array( $theme_page ) ) {
                    switch ( $current ) {
                        case $theme_page['menu_slug'] :
                            if ( function_exists( $theme_page['menu_slug'].'_options_page' ) )
                            call_user_func( $theme_page['menu_slug'].'_options_page', 'appearance_page_' . $current );
                            break;
                    }
                }
            }
        }?>
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
        $tab = isset( $_GET['page'] )  ? $_GET['page'] : "rtp_general";
        switch ( $tab ) {
            case 'rtp_general' :
                /* All metaboxes registered during load page can be switched off/on at "Screen Options" automatically, nothing special to do therefore. */
                add_meta_box( 'logo_options', __( 'Logo Settings', 'rtPanel'), 'rtp_logo_option_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'fav_options', __( 'Favicon Settings', 'rtPanel'), 'rtp_fav_option_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'feed_options', __( 'Feedburner Settings', 'rtPanel'), 'rtp_feed_option_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'google_search', __( 'Google Custom Search Integration', 'rtPanel'), 'rtp_google_search_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'custom_styles_options', __( 'Custom Styles', 'rtPanel' ), 'rtp_custom_styles_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
                add_meta_box( 'plugin_support', __( 'Plugin Support', 'rtPanel'), 'rtp_plugin_metabox', 'appearance_page_' . $tab, 'normal', 'core' );
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
            do_action('rtp_extend_screen_option_metaboxes');
        }
    }
}

/**
* Display rtPanel
*/
$rt_panel_theme = new rtp_theme();
