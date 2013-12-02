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
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
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
            <script src="<?php echo RTP_JS_FOLDER_URL; ?>/respond.min.js"></script>
        <![endif]-->

        <?php wp_head(); ?>

        <?php rtp_head(); ?>
    </head>

    <body <?php body_class(); ?>><!-- ends in footer.php -->

        <?php rtp_hook_begin_body(); ?>

        <div id="main-wrapper" class="rtp-main-wrapper"><!-- ends in footer.php -->

            <?php rtp_hook_begin_main_wrapper(); ?>

            <?php $header_class = get_header_image() ? ' rtp-header-wrapper-image' : ''; ?>
            <div id="header-wrapper" class="row<?php echo $header_class; ?>">

                    <?php rtp_hook_before_header(); ?>

                    <header id="header" class="rtp-header large-12 columns" role="banner">

                        <?php rtp_hook_begin_header(); ?>

                        <?php rtp_hook_before_logo(); ?>

                            <?php $heading = ( is_home() || is_front_page() ) ? 'h2' : 'h3'; ?>
                            <<?php echo $heading; ?> class="rtp-site-logo"><a role="link" href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( 'image' == $rtp_general['logo_use'] ) ? '<img role="img" alt="' . get_bloginfo( 'name' ) . '" ' . rtp_get_image_dimensions( $rtp_general['logo_upload'] ) . ' src="' . $rtp_general['logo_upload'] . '" />' : get_bloginfo( 'name' ); ?></a></<?php echo $heading; ?>>

                        <?php rtp_hook_after_logo(); ?>

                        <?php rtp_hook_end_header(); ?>

                    </header><!-- #header -->

                    <?php rtp_hook_after_header(); ?>

            </div><!-- #header-wrapper -->
            <?php rtp_hook_before_content_wrapper(); ?>
            
            <?php 
                $content_wrapper_class = ( is_search() && $rtp_general['search_code'] && $rtp_general['search_layout'] ) ? 'row rtp-content-wrapper search-layout-wrapper' : 'row rtp-content-wrapper';
            ?>
            <div id="content-wrapper" class="<?php echo apply_filters("rtp_content_wrapper_class", $content_wrapper_class); ?>"><!-- ends in footer.php -->
                <?php rtp_hook_begin_content_wrapper(); ?>