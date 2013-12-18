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

        <title><?php
            /*
             * Print the <title> tag based on what is being viewed.
             */
            global $page, $paged;

            wp_title( '|', true, 'right' );

            // Add the blog name.
            bloginfo( 'name' );

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) ) {
                echo " | $site_description";
            }

            // Add a page number if necessary:
            if ( $paged >= 2 || $page >= 2 ) {
                echo ' | ' . sprintf( __( 'Page %s', 'rtPanel' ), max( $paged, $page ) );
            } ?>
        </title>

        <!-- Mobile Viewport Fix ( j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag ) -->
        <meta name="viewport" content="<?php echo apply_filters( 'rtp_viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0' ); ?>" />

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <?php if ( 'disable' != $rtp_general['favicon_use'] ) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo $rtp_general['favicon_upload']; ?>" /><?php } ?>

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

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

            <div id="header-wrapper" class="rtp-header-wrapper rtp-section-container">

                    <?php rtp_hook_before_header(); ?>

                    <header id="header" class="row" role="banner">

                        <?php $header_class = get_header_image() ? ' rtp-header-wrapper-image' : ''; ?>
                        <div class="rtp-header large-12 columns <?php echo $header_class; ?>">
                            <?php rtp_hook_begin_header(); ?>

                            <div class="rtp-logo-container clearfix">
                                <?php rtp_hook_before_logo(); ?>

                                    <?php $heading = ( is_home() || is_front_page() ) ? 'h1' : 'h2'; ?>
                                    <<?php echo $heading; ?> class="rtp-site-logo"><a role="link" href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo ( 'image' == $rtp_general['logo_use'] ) ? '<img role="img" alt="' . get_bloginfo( 'name' ) . '" height="' . $rtp_general['logo_height'] . '" width="' . $rtp_general['logo_width'] . '" src="' . $rtp_general['logo_upload'] . '" />' : get_bloginfo( 'name' ); ?></a></<?php echo $heading; ?>>

                                <?php rtp_hook_after_logo(); ?>
                            </div>

                            <?php rtp_hook_end_header(); ?>
                        </div>

                    </header><!-- #header -->

                    <?php rtp_hook_after_header(); ?>

            </div><!-- #header-wrapper -->

            <?php rtp_hook_before_content_wrapper(); ?>

            <?php $content_wrapper_class = ( is_search() && $rtp_general['search_code'] && $rtp_general['search_layout'] ) ? 'rtp-content-wrapper rtp-section-container search-layout-wrapper' : 'rtp-content-wrapper rtp-section-container'; ?>

            <div id="content-wrapper" class="<?php echo apply_filters("rtp_content_wrapper_class", $content_wrapper_class); ?>"><!-- ends in footer.php -->

                <?php rtp_hook_begin_content_wrapper(); ?>

                <div class="row">