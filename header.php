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
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />

        <title><?php wp_title( '|', true, 'right' ); ?></title>

        <!-- Mobile Viewport Fix ( j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag ) -->
        <meta name="viewport" content="<?php echo apply_filters( 'rtp_viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no' ); ?>" />

        <link rel="profile" href="http://gmpg.org/xfn/11" />

        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

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

					<?php rtp_hook_begin_header(); ?>

					<div class="rtp-header <?php echo esc_attr( $rtp_set_grid_class ); ?> <?php echo esc_attr( $header_class ); ?>">

						<?php rtp_hook_within_header(); ?>

					</div>

					<?php rtp_hook_end_header(); ?>

				</header><!-- #header -->

				<?php rtp_hook_after_header(); ?>

            </div><!-- #header-wrapper -->

			<?php rtp_hook_before_content_wrapper(); ?>

			<?php $content_wrapper_class = 'rtp-content-wrapper rtp-section-wrapper'; ?>

            <div id="content-wrapper" class="<?php echo esc_attr( apply_filters( 'rtp_content_wrapper_class', $content_wrapper_class ) ); ?>"><!-- ends in footer.php -->

				<?php rtp_hook_begin_content_wrapper(); ?>

                <div class="row rtp-section-container">

					<?php
					rtp_hook_begin_content_row();
