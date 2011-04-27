<?php
/**
 * Any code to be run after theme is activated here
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */


    /**
     * Set the content width based on the theme's design and stylesheet.
     *
     * Used to set the width of images and content. Should be equal to the width the theme
     * is designed for, generally via the style.css stylesheet.
     */

$content_width = ( isset( $content_width ) ) ? $content_width : 620;

    /**
     * Tell WordPress to run rt_base_setup() when the 'after_setup_theme' hook is run
     */

add_action( 'after_setup_theme', 'rt_base_setup' );

if ( !function_exists( 'rt_base_setup' ) ) {


    /**
     *
     * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
     * @uses register_nav_menus() To add support for navigation menus.
     *
     */
    function rt_base_setup() {


        /**
         * This theme uses post thumbnails
         */

	add_theme_support( 'post-thumbnails' );


        /**
         * Add default posts and comments RSS feed links to head
         */

	add_theme_support( 'automatic-feed-links' );


        /**
         * This theme styles the visual editor with editor-style.css to match the theme style.
         */

        add_editor_style( './css/rtp-editor-style.css' );


        /**
         * Load the text domain
         */

        load_theme_textdomain( 'rtPanel', TEMPLATEPATH . '/languages' );

        /**
         * This theme uses wp_nav_menu() in one location
         */

	register_nav_menus( array(
            'primary' => __( 'Primary Navigation', 'rtPanel' )
	) );

        /**
         * Coming Soon
         */

        if ( 0 ) {
            the_post_thumbnail();
            add_custom_image_header();
            add_custom_background();
        }

    }
}


    /**
     * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
     */

function rtp_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'rtp_page_menu_args' );


    /**
     * Includes Scripts in the Header
     * Files which attached in rtp_header_scripts() function should append in wp_head();
     */

function rtp_header_scripts() { ?>
    <!--[if IE 7 ]>
        <link rel="stylesheet" href="<?php echo RTP_CSS_FOLDER_URL; ?>/rtp-ie7.css"  />
    <![endif]-->
    <!--[if IE 6 ]>
        <link rel="stylesheet" href="<?php echo RTP_CSS_FOLDER_URL; ?>/rtp-ie6.css"  />
    <![endif]-->
    <!--
    ========== [ CSS3PIE Hack ] ==========
    To apply CSS3 border radius, box-shadow, linear gradient. ref. http://css3pie.com/
    -->
    <!--
    <style type="text/css">
        .ClassName { behavior: url(<?php //echo RTP_JS_FOLDER_URL; ?>/PIE.htc); position: relative; }
    </style>
    -->

    <!-- Custom CSS override by admin from Admin -> rtPanel Options -->
    <?php
        global $rtp_general;
        echo ( $rtp_general['custom_styles'] ) ? '<style type="text/css">' . $rtp_general['custom_styles'] . '</style>' : '';
    ?>

<?php }
add_action( 'wp_head', 'rtp_header_scripts' );


    /**
     * Includes Scripts in the footer
     * Files which attached in rtp_footer_scripts() function should append in wp_footer();
     */

function rtp_footer_scripts() {

       /**
        * Note : Below code Paste in (<!--[if lt IE 9]>  <![endif]-->) below condition
        * for rounded corners in IE and PNG Fix in ie6
        * Uses:
        * <!--[if lt IE 9]>
        *   *** Paste below code here ***
        * <![endif]-->
        */

       /**
        * <script type="text/javascript" src="<?php echo RTP_JS_FOLDER_URL; ?>/DD_roundies.js"></script>
        */
    ?>
    <!--[if lt IE 9]>
        <script type="text/javascript" src="<?php echo RTP_JS_FOLDER_URL; ?>/rtp-custom-ie.js"></script>
    <![endif]-->
    <!--[if lte IE 7]>
        <script type="text/javascript" src="<?php echo RTP_JS_FOLDER_URL; ?>/rtp-custom-ie7.js"></script>
    <![endif]-->
    <!--[if IE 6]>
        <script type="text/javascript" src="<?php echo RTP_JS_FOLDER_URL; ?>/rtp-custom-ie6.js"></script>
    <![endif]-->
<?php
}
add_action( 'wp_footer', 'rtp_footer_scripts' );