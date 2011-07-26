<?php
/**
 * The Header for rtPanel
 *
 * Displays all of the <head> section and everything up till <div id="content-wrapper">
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
        <?php global $rtp_general; ?>
        <!--
            ========== [ Mobile Viewport Fix ] ==========
            j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag
        -->
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
        <meta name="description" content="<?php echo rtp_meta_description(); ?>" />
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo rtp_logo_fav_src('favicon'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link rel="stylesheet" href="<?php echo RTP_CSS_FOLDER_URL; ?>/rtp-reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo RTP_CSS_FOLDER_URL; ?>/rtp-typo.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo RTP_CSS_FOLDER_URL; ?>/rtp-print.css" type="text/css" media="print" />

        <!-- ========== [ Nested Comment Support. For more details check readme.txt ========== -->
        <?php ( is_singular() && get_option( 'thread_comments' ) ) ? wp_enqueue_script('comment-reply') : ''; ?>

        <?php wp_enqueue_script( 'custom', RTP_JS_FOLDER_URL . '/rtp-custom.js', array( 'jquery' ), '', true ); ?>
            
    <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>> <!-- body begins and end in footer.php -->
        <div id="main-wrapper"> <!-- main-wrapper begins and end in footer.php -->
            <div id="header-wrapper"> <!-- header-wrapper begins -->

                <?php rtp_hook_before_header(); /* rtpanel_hook for adding content before #header */ ?>

                <div id="header"> <!-- header begins -->
                    <?php rtp_hook_before_logo(); ?>
                    <?php if ( is_home() || is_front_page() ) { ?>
                        <h1 class="rtp-site-logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( $rtp_general['logo_show'] ) ? '<img alt="' . get_bloginfo( 'name' ) . '" src="' . rtp_logo_fav_src('logo') . '" />' : get_bloginfo( 'name' ); ?></a></h1>
                    <?php } else { ?>
                        <p class="rtp-site-logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( $rtp_general['logo_show'] ) ? '<img alt="' . get_bloginfo( 'name' ) . '" src="' . rtp_logo_fav_src('logo') . '" />' : get_bloginfo( 'name' ); ?></a></p>
                    <?php } ?>
                        <?php if ( get_bloginfo( 'description' ) ) { ?><h2 class="tagline"><?php bloginfo( 'description' ); ?></h2><?php } ?>
                    <?php rtp_hook_after_logo(); ?>
                    <div class="clear"></div>
                </div><!-- end header -->
               
                <?php rtp_hook_after_header(); // rtpanel_hook for adding content after #header ?>
                <div class="clear"></div>
            </div><!-- end header-wrapper -->

            <div id="content-wrapper"<?php echo ( $rtp_general['search_code'] && $rtp_general['search_layout'] )?'class="search-layout-wrapper"':''; ?>> <!-- content-wrapper begins and end in footer.php -->
             <?php rtp_hook_begin_content_wrapper(); /* rtpanel_hook for adding content after #content-wrapper begins */ ?>