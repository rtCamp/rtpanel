<?php

/*
 * Typography option settings
 */

function rtp_typography_option_settings( $rtpanel_panel ) {

	/**
	 * Create Typography Options Tab
	 */
	$typographyTab = $rtpanel_panel->createTab(
			array(
				'name' => __( 'Typography', 'rtPanel' ),
				'id' => 'typography',
			)
	);

	/**
	 * Create Body Font Option
	 */
	$typographyTab->createOption(
			array(
				'name' => __( 'Body Font', 'rtPanel' ),
				'id' => 'body_font_option',
				'type' => 'font',
				'show_color' => true,
				'show_font_weight' => false,
				'show_font_style' => false,
				'show_line_height' => false,
				'show_letter_spacing' => false,
				'show_text_transform' => false,
				'show_font_variant' => false,
				'show_text_shadow' => false,
				'default' => array(
					'font-family' => 'Open Sans',
					'color' => '#4c4c4c',
					'font-size' => '16px',
				),
				'css' => 'body { value }',
				'desc' => __( 'This option is set the body font.', 'rtPanel' )
			)
	);

	/**
	 * Create Heading Font Option
	 */
	$typographyTab->createOption(
			array(
				'name' => __( 'Heading Font', 'rtPanel' ),
				'id' => 'heading_font_option',
				'type' => 'font',
				'show_color' => false,
				'show_font_size' => false,
				'show_font_weight' => true,
				'show_font_style' => false,
				'show_line_height' => false,
				'show_letter_spacing' => false,
				'show_text_transform' => false,
				'show_font_variant' => false,
				'show_text_shadow' => false,
				'default' => array(
					'font-family' => 'Open Sans',
					'font-weight' => '400',
				),
				'css' => 'h1, h2, h3, h4, h5, h6 { value }',
				'desc' => __( 'This option is set heading font for H1-H6 tags.', 'rtPanel' )
			)
	);

	/**
	 * Create Code Font Option
	 */
	$typographyTab->createOption(
			array(
				'name' => __( 'Coding Font', 'rtPanel' ),
				'id' => 'coding_font_option',
				'type' => 'font',
				'show_color' => false,
				'show_font_size' => true,
				'show_font_weight' => false,
				'show_font_style' => false,
				'show_line_height' => false,
				'show_letter_spacing' => false,
				'show_text_transform' => false,
				'show_font_variant' => false,
				'show_text_shadow' => false,
				'default' => array(
					'font-family' => 'Source Code Pro',
					'font-size' => '16px',
				),
				'css' => 'code, kbd, pre, samp { value }',
				'desc' => __( 'This option is set Coding font for code, kbd, pre, samp tags.', 'rtPanel' )
			)
	);

	/**
	 * Save Typography Settings
	 */
	$typographyTab->createOption(
			array(
				'type' => 'save',
			)
	);
}
