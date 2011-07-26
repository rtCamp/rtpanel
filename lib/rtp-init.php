<?php
/**
 * Any code that runs on initialization of rtPanel theme
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

/**
 * Sets the content's width based on the theme's design and stylesheet
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
$content_width = ( isset( $content_width ) ) ? $content_width : 620;

if ( !function_exists( 'rtpanel_setup' ) ) {
    /**
     * Sets up rtPanel theme
     *
     * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
     * @uses register_nav_menus() To add support for navigation menus.
     *
     * @since rtPanel Theme 2.0
     */
    function rtpanel_setup() {
        global $rtp_general;
        rtp_theme_setup_values();
	add_theme_support( 'post-thumbnails' ); // This theme uses post thumbnails
	add_theme_support( 'automatic-feed-links' ); // Add default posts and comments RSS feed links to head
        add_editor_style( './css/rtp-editor-style.css' ); // This theme styles the visual editor with editor-style.css to match the theme style.
        load_theme_textdomain( 'rtPanel', TEMPLATEPATH . '/languages' ); // Load the text domain
        add_custom_background(); // Add support for custom background
        
        // Don't support text inside the header image
        if ( !defined( 'NO_HEADER_TEXT' ) ) {
            define( 'NO_HEADER_TEXT', true );
        }

        define( 'HEADER_TEXTCOLOR' , '' );
        define( 'HEADER_IMAGE_WIDTH' , apply_filters( 'rtp_header_image_width', 960 ) );
        define( 'HEADER_IMAGE_HEIGHT' , apply_filters( 'rtp_header_image_height', 190 ) );

        /**
         * adding support for the header image
         */
        add_custom_image_header( 'rtp_header_style', 'rt_admin_header_style' );

        if ( !function_exists( 'rt_admin_header_style' ) ) {
            /**
             * Admin header preview styling
             *
             * @since rtPanel Theme 2.0
             */
            function rt_admin_header_style() { ?>
                <style type="text/css">  #headimg { width: <?php echo HEADER_IMAGE_WIDTH; ?>px; height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; } </style><?php
            }
        }

        if ( !function_exists( 'rtp_header_style' ) ) {
            /**
             * Site header styling
             *
             * @since rtPanel Theme 2.0
             */
            function rtp_header_style() {
                if ( get_header_image() ) { ?>
                    <style type="text/css"> #header-wrapper { background: url(<?php header_image(); ?>) no-repeat;width: <?php echo HEADER_IMAGE_WIDTH; ?>px; height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; } </style><?php
                }
            }
        }

        // Makes use of wp_nav_menu() for navigation purpose
	register_nav_menus( array(
            'primary' => __( 'Primary Navigation', 'rtPanel' )
	) );

        if ( !function_exists( 'rtp_meta_description' ) ) {
            /**
             * Returns meta description
             *
             * @return string
             *
             * @since rtPanel Theme 2.0
             */
            function rtp_meta_description() {
                global $post;
                the_excerpt_rss();
                $rawcontent = $post->post_content;
                if ( empty( $rawcontent ) ) {
                    $rawcontent = html_entity_decode( get_bloginfo( 'description', 'abc' ) );
                } else {
                    $rawcontent = apply_filters( 'the_content_rss', strip_tags( $rawcontent ) );
                    $rawcontent = strip_shortcodes( $rawcontent );
                    $chars = array( "", "\n", "\r", "chr(13)",  "\t", "\0", "\x0B" );
                    $rawcontent = str_replace( $chars, " ", $rawcontent );
                    $rawcontent = html_entity_decode( $rawcontent );
                }
                return substr( $rawcontent, 0, 155 );
            }
        }
    }
}

// Tell WordPress to run rtpanel_setup() when the 'after_setup_theme' hook is run
add_action( 'after_setup_theme', 'rtpanel_setup' );

/**
 * Includes Styles in the Header
 * Files which are attached in rtp_header_styles() should append in wp_head();
 *
 * @since rtPanel Theme 2.0
 */
function rtp_header_styles() { ?>
    <!--[if IE 7 ]>
        <link rel="stylesheet" href="<?php echo RTP_CSS_FOLDER_URL; ?>/rtp-ie7.css"  />
    <![endif]-->
    <!--[if IE 6 ]>
        <link rel="stylesheet" href="<?php echo RTP_CSS_FOLDER_URL; ?>/rtp-ie6.css"  />
    <![endif]-->

    <!-- Custom CSS override by admin from Admin -> rtPanel Options -->
    <?php
        global $rtp_general;
        echo ( $rtp_general['custom_styles'] ) ? '<style type="text/css">' . $rtp_general['custom_styles'] . '</style>' : '';
}
add_action( 'wp_head', 'rtp_header_styles' );

/**
 * Includes Scripts in the footer
 * Files which are attached in rtp_footer_scripts() should append in wp_footer();
 *
 * @since rtPanel Theme 2.0
 */
function rtp_footer_scripts() { ?>
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