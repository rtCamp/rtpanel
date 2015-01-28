<?php
/*
 * Logo
 */

if ( ! function_exists( 'rtp_header_logo' ) ) {

	function rtp_header_logo() {
		$show = rtp_get_option( 'logo' );
		$logo_id = rtp_get_option( 'logo_image', 'id' );
		$logo = ( $show && $logo_id ) ? wp_get_attachment_image( $logo_id, 'full', '', array( 'class' => 'rtp-custom-logo' ) ) : get_bloginfo( 'name' );
		?>

		<div class="rtp-logo-container clearfix">
			<?php rtp_hook_before_logo(); ?>

			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="rtp-site-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo $logo; ?>
					</a>
				</h1>
			<?php else : ?>
				<h2 class="rtp-site-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo $logo; ?>
					</a>
				</h2>
			<?php endif; ?>

			<?php rtp_hook_after_logo(); ?>
		</div><?php
	}

	// Header Logo
	add_action( 'rtp_hook_within_header', 'rtp_header_logo' );
}


/**
 * Adds favicon to Wpadmin
 */
if ( ! function_exists( 'rtp_favicon' ) ) {

	function rtp_favicon() {
		$favicon = rtp_get_option( 'favicon' );
		$favicon_url = rtp_get_option( 'favicon_image', 'url' );

		if ( $favicon && $favicon_url ) {
			?>
			<link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url( $favicon_url ); ?>" />
			<?php
		}
	}

	// Favicon
	add_action( 'wp_head', 'rtp_favicon' );
	add_action( 'admin_head', 'rtp_favicon' );
}