<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( ! function_exists( 'rtp_header_logo' ) ) {

	function rtp_header_logo() {
		$logo_id = rtp_option( 'custom_logo', false, 'id' );
		$logo = ( '' != $logo_id ) ? wp_get_attachment_image( $logo_id, 'full', '', array( 'class' => 'rtp-custom-logo' ) ) : get_bloginfo( 'name' );
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
				<p class="rtp-site-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo $logo; ?>
					</a>
				</p>
			<?php endif; ?>

			<?php rtp_hook_after_logo(); ?>
		</div><?php
	}

}
