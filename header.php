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

        <title><?php wp_title( '|', true, 'right' ); ?></title>

        <!-- Mobile Viewport Fix ( j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag ) -->
        <meta name="viewport" content="<?php echo apply_filters( 'rtp_viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0' ); ?>" />

        <link rel="profile" href="http://gmpg.org/xfn/11" />

        <?php if ( 'disable' != $rtp_general['favicon_use'] ) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_attr($rtp_general['favicon_upload']); ?>" /><?php } ?>

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>><!-- ends in footer.php -->

        <?php rtp_hook_begin_body(); ?>

        <div id="main-wrapper" class="rtp-main-wrapper"><!-- ends in footer.php -->

            <?php rtp_hook_begin_main_wrapper(); ?>

            <div id="header-wrapper" class="rtp-header-wrapper rtp-section-wrapper">

                    <?php rtp_hook_before_header(); ?>

                    <header id="header" class="row rtp-section-container" role="banner">

                        <?php $header_class = get_header_image() ? ' rtp-header-wrapper-image' : ''; ?>
                        <?php $rtp_set_grid_class = apply_filters( 'rtp_set_full_width_grid_class', 'large-12 columns rtp-full-width-grid' ); ?>

                        <div class="rtp-header <?php echo esc_attr($rtp_set_grid_class); ?> <?php echo esc_attr($header_class); ?>">
                            <?php rtp_hook_begin_header(); ?>

                            <div class="rtp-logo-container clearfix">
                                <?php rtp_hook_before_logo(); ?>

                                    <?php $heading = ( is_home() || is_front_page() ) ? 'h1' : 'h2'; ?>
                                    <<?php echo esc_attr($heading); ?> class="rtp-site-logo"><a role="link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( 'image' == $rtp_general['logo_use'] ) ? '<img role="img" alt="' . get_bloginfo( 'name' ) . '" height="' . $rtp_general['logo_height'] . '" width="' . $rtp_general['logo_width'] . '" src="' . $rtp_general['logo_upload'] . '" />' : get_bloginfo( 'name' ); ?></a></<?php echo esc_attr($heading); ?>>

                                <?php rtp_hook_after_logo(); ?>
                            </div>

                            <?php rtp_hook_end_header(); ?>
                        </div>

                    </header><!-- #header -->

                    <?php rtp_hook_after_header(); ?>

            </div><!-- #header-wrapper -->

            <?php rtp_hook_before_content_wrapper(); ?>

            <?php $content_wrapper_class = ( is_search() && $rtp_general['search_code'] && $rtp_general['search_layout'] ) ? 'rtp-content-wrapper rtp-section-wrapper search-layout-wrapper' : 'rtp-content-wrapper rtp-section-wrapper'; ?>

            <div id="content-wrapper" class="<?php echo esc_attr(apply_filters("rtp_content_wrapper_class", $content_wrapper_class)); ?>"><!-- ends in footer.php -->

                <?php rtp_hook_begin_content_wrapper(); ?>

                <div class="row rtp-section-container">