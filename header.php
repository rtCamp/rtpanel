<?php
/**
 * The Header for rtPanel
 *
 * Displays all of the <head> section and everything up till <div id="content-wrapper">
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <title><?php wp_title( '', true ); ?></title>

        <!-- Mobile Viewport Fix ( j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag ) -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo rtp_logo_fav_src('favicon'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="all" />

        <!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
                   
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>><!-- ends in footer.php -->
        
        <?php rtp_hook_begin_body(); ?>
        
        <div id="main-wrapper"><!-- ends in footer.php -->
            
            <header id="header-wrapper" role="banner">
                
                <?php global $rtp_general; ?>

                <?php rtp_hook_before_header(); ?>

                <div id="header">
                    <?php rtp_hook_before_logo(); ?>

                        <?php if ( is_home() || is_front_page() ) { ?>
                            <h1 class="rtp-site-logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( $rtp_general['logo_show'] ) ? '<img alt="' . get_bloginfo( 'name' ) . '" src="' . rtp_logo_fav_src('logo') . '" />' : get_bloginfo( 'name' ); ?></a></h1>
                        <?php } else { ?>
                            <h2 class="rtp-site-logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( $rtp_general['logo_show'] ) ? '<img alt="' . get_bloginfo( 'name' ) . '" src="' . rtp_logo_fav_src('logo') . '" />' : get_bloginfo( 'name' ); ?></a></h2>
                        <?php } ?>

                    <?php rtp_hook_after_logo(); ?>

                    <div class="clear"></div>
                </div><!-- #header -->

                <?php rtp_hook_after_header(); ?>

                <div class="clear"></div>
                
            </header><!-- #header-wrapper -->

            <div id="content-wrapper"<?php echo ( $rtp_general['search_code'] && $rtp_general['search_layout'] )?' class="search-layout-wrapper"':''; ?>><!-- ends in footer.php -->
                <?php rtp_hook_begin_content_wrapper(); ?>