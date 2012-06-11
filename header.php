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
        <?php if ( $rtp_general['favicon_show'] ) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo rtp_logo_fav_src('favicon'); ?>" /><?php } ?>

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="all" />

        <!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
        <![endif]-->

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>><!-- ends in footer.php -->

        <?php rtp_hook_begin_body(); ?>

        <div id="main-wrapper" class="rtp-container-12 clearfix"><!-- ends in footer.php -->

            <?php rtp_hook_begin_main_wrapper(); ?>

            <header id="header-wrapper" role="banner" class="rtp-container-12 clearfix">

                <?php rtp_hook_before_header(); ?>

                <hgroup id="header" class="rtp-grid-12 clearfix">
                    <?php rtp_hook_before_logo(); ?>

                        <?php $heading = ( is_home() || is_front_page() ) ? 'h1' : 'h2'; ?>
                        <<?php echo $heading; ?> class="rtp-site-logo"><a role="link" href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( $rtp_general['logo_show'] ) ? '<img role="img" alt="' . get_bloginfo( 'name' ) . '" ' . rtp_get_image_dimensions( rtp_logo_fav_src('logo') ) . ' src="' . rtp_logo_fav_src('logo') . '" />' : get_bloginfo( 'name' ); ?></a></<?php echo $heading; ?>>
                        
                    <?php rtp_hook_after_logo(); ?>

                </hgroup><!-- #header -->

                <?php rtp_hook_after_header(); ?>

            </header><!-- #header-wrapper -->

            <div id="content-wrapper"<?php echo ( is_search() && $rtp_general['search_code'] && $rtp_general['search_layout'] ) ? ' class="search-layout-wrapper clearfix"' : ' class="rtp-container-12 clearfix"'; ?>><!-- ends in footer.php -->
                <?php rtp_hook_begin_content_wrapper(); ?>