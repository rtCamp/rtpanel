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
global $rtp_general; ?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <title><?php wp_title( '' ); ?></title>

        <!-- Mobile Viewport Fix ( j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag ) -->
        <meta name="viewport" content="<?php echo apply_filters( 'rtp_viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0' ); ?>" />

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <?php if ( 'disable' != $rtp_general['favicon_use'] ) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo $rtp_general['favicon_upload']; ?>" /><?php } ?>

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="all" />
        <!--[if lt IE 9]>
        <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
        
        <?php rtp_head(); ?>
        
    </head>
    <body <?php body_class(); ?>><!-- ends in footer.php -->

        <?php rtp_hook_begin_body(); ?>

        <div id="main-wrapper" class="clearfix"><!-- ends in footer.php -->

            <?php rtp_hook_begin_main_wrapper(); ?>

            <?php $header_class = get_header_image() ? ' rtp-header-wrapper-image' : ''; ?>
            <header id="header-wrapper" role="banner" class="<?php echo $header_class; ?>">

                <?php rtp_hook_before_header(); ?>

                <div id="header" class="row clearfix">
                    <?php rtp_hook_before_logo(); ?>

                        <?php $heading = ( is_home() || is_front_page() ) ? 'h2' : 'h3'; ?>
                        <<?php echo $heading; ?> class="rtp-site-logo clearfix"><a role="link" href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( 'image' == $rtp_general['logo_use'] ) ? '<img role="img" alt="' . get_bloginfo( 'name' ) . '" ' . rtp_get_image_dimensions( $rtp_general['logo_upload'] ) . ' src="' . $rtp_general['logo_upload'] . '" />' : get_bloginfo( 'name' ); ?></a></<?php echo $heading; ?>>
                        
                    <?php rtp_hook_after_logo(); ?>
                </div><!-- #header -->

                <?php rtp_hook_after_header(); ?>

            </header><!-- #header-wrapper -->
            <?php rtp_hook_before_content_wrapper(); ?>
            
            <?php 
                $content_wrapper_class = ( is_search() && $rtp_general['search_code'] && $rtp_general['search_layout'] ) ? 'row search-layout-wrapper clearfix"' : ' class="row clearfix"';
            ?>
            <div id="content-wrapper" class="<?php echo apply_filters("rtp_content_wrapper_class",$content_wrapper_class); ?>"><!-- ends in footer.php -->
                <?php rtp_hook_begin_content_wrapper(); ?>