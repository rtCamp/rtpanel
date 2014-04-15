<?php

/**
 * Customize Titan Framework Options
 * 
 * @package rtPanel
 * @since rtPanel 1.2
 */
$rtpanel_titan = rtp_get_titan_obj();

if ( $rtpanel_titan ) {

	/**
	 * Create Theme Customizer Section
	 */
	$section = $rtpanel_titan->createThemeCustomizerSection(
			array(
				'name' => __( 'Theme Option', 'rtPanel' ),
			)
	);

	/**
	 * Create Admin Panel
	 */
	$rtpanel_panel = $rtpanel_titan->createAdminPanel(
			array(
				'name' => __( 'rtPanel', 'rtPanel' ),
				'icon' => 'dashicons-format-gallery',
				'position' => 59,
			)
	);

	/**
	 * Create General Settings Tab
	 */
	$generalTab = $rtpanel_panel->createTab(
			array(
				'name' => __( 'General', 'rtPanel' ),
				'title' => __( 'Logo and Favicon Settings', 'rtPanel' ),
				'id' => 'general',
			)
	);

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
	 * Create Post and Comment Settings Tab
	 */
	$postCommentTab = $rtpanel_panel->createTab(
			array(
				'name' => __( 'Post &amp; Comments', 'rtPanel' ),
				'title' => __( 'Post Summary Settings', 'rtPanel' ),
				'id' => 'post_comments',
			)
	);

	/**
	 * Create Footer Options Tab
	 */
	$footerTab = $rtpanel_panel->createTab(
			array(
				'name' => __( 'Footer Options', 'rtPanel' ),
				'id' => 'footer',
			)
	);



	/**
	 * Create Typography Options Tab
	 */
	$codeTab = $rtpanel_panel->createTab(
			array(
				'name' => __( 'Custom Codes', 'rtPanel' ),
				'id' => 'custom_codes',
				'title' => 'Google Analytics Code',
			)
	);

	/**
	 * Create Theme Options
	 */
	/**
	 * Create Site Logo Option
	 */
	$generalTab->createOption(
			array(
				'name' => __( 'Site Logo Settings', 'rtPanel' ),
				'id' => 'logo_settings',
				'options' => array(
					'site_title' => __( 'Use Site Title', 'rtPanel' ),
					'image' => __( 'Upload Logo', 'rtPanel' ),
				),
				'type' => 'radio',
				'default' => 'site_title',
			)
	);

	/**
	 * Create Logo Uplaod Option
	 */
	$generalTab->createOption(
			array(
				'name' => __( 'Logo Upload', 'rtPanel' ),
				'id' => 'logo_upload',
				'type' => 'upload',
				'desc' => __( 'Upload Logo Here', 'rtPanel' ),
			)
	);

	/**
	 * Create Logo on WordPress Login Option
	 */
	$generalTab->createOption(
			array(
				'name' => __( 'Logo on WordPress login', 'rtPanel' ),
				'id' => 'login_head',
				'type' => 'checkbox',
				'desc' => sprintf( __( 'Check this box to display logo on <a href="%s" title="Wordpress Login">WordPress Login Screen</a>', 'rtPanel' ), site_url( '/wp-login.php' ) ),
				'default' => false,
			)
	);

	/**
	 * Create Site Favicon Options
	 */
	$generalTab->createOption(
			array(
				'name' => __( 'Site Favicon Settings', 'rtPanel' ),
				'id' => 'favicon_settings',
				'options' => array(
					'disable' => __( 'Disable', 'rtPanel' ),
					'image' => __( 'Upload Favicon', 'rtPanel' ),
				),
				'type' => 'radio',
				'default' => 'disable',
			)
	);

	/**
	 * Create Favicon Upload Option
	 */
	$generalTab->createOption(
			array(
				'name' => __( 'Favicon Upload', 'rtPanel' ),
				'id' => 'favicon_upload',
				'type' => 'upload',
				'desc' => __( 'Upload Favicon Here', 'rtPanel' ),
			)
	);

	/**
	 * BuddyPress and bbPress sidebar settings.
	 */
	if ( rt_is_plugin_active( 'buddypress/bp-loader.php' ) || rt_is_plugin_active( 'bbpress/bbpress.php' ) ) {

		/**
		 * Create BuddyPress and bbPress Sidebar Heading
		 */
		$generalTab->createOption(
				array(
					'name' => __( 'Sidebar Settings', 'rtPanel' ),
					'type' => 'heading',
				)
		);

		/**
		 * Create BuddyPress Sidebar Option
		 */
		if ( rt_is_plugin_active( 'buddypress/bp-loader.php' ) ) {
			$generalTab->createOption(
					array(
						'name' => __( 'BuddyPress Sidebar', 'rtPanel' ),
						'id' => 'buddypress_sidebar',
						'type' => 'select',
						'options' => array(
							'default-sidebar' => 'Default Sidebar',
							'buddypress-sidebar' => 'Enable BuddyPress Sidebar',
							'no-sidebar' => 'Disable Sidebar',
						),
						'default' => 'default-sidebar',
					)
			);
		}

		/**
		 * Create bbPress Sidebar Option
		 */
		if ( rt_is_plugin_active( 'bbpress/bbpress.php' ) ) {
			$generalTab->createOption(
					array(
						'name' => __( 'bbPress Sidebar', 'rtPanel' ),
						'id' => 'bbpress_sidebar',
						'type' => 'select',
						'options' => array(
							'default-sidebar' => 'Default Sidebar',
							'bbpress-sidebar' => 'Enable bbPress Sidebar',
							'no-sidebar' => 'Disable Sidebar',
						),
						'default' => 'default-sidebar',
					)
			);
		}
	}

	/**
	 * Save General Settings
	 */
	$generalTab->createOption(
			array(
				'type' => 'save',
			)
	);

	/**
	 * Create Google Analytics Option
	 */
	$codeTab->createOption(
			array(
				'name' => __( 'Google Analytics Code', 'rtPanel' ),
				'id' => 'google_analytics',
				'type' => 'code',
				'desc' => __( 'Add Google Analytics Code here', 'rtPanel' ),
				'lang' => 'html',
			)
	);

	/**
	 * Create Custom Code Heading
	 */
	$codeTab->createOption(
			array(
				'name' => __( 'Custom CSS and JavaScript', 'rtPanel' ),
				'type' => 'heading',
			)
	);

	/**
	 * Create Custom CSS Option
	 */
	$codeTab->createOption(
			array(
				'name' => __( 'Custom CSS', 'rtPanel' ),
				'id' => 'backend_custom_css',
				'type' => 'code',
				'desc' => __( 'Put your custom CSS rules here', 'rtPanel' ),
				'lang' => 'css',
			)
	);

	/**
	 * Create Custom JavaScript Option
	 */
	$codeTab->createOption(
			array(
				'name' => __( 'Custom JavaScript', 'rtPanel' ),
				'id' => 'backend_custom_js',
				'type' => 'code',
				'desc' => __( 'Put your custom JavaScript code here', 'rtPanel' ),
				'lang' => 'javascript',
			)
	);

	/**
	 * Save Custom Code Settings
	 */
	$codeTab->createOption(
			array(
				'type' => 'save',
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
				'show_color' => false,
				'show_font_weight' => false,
				'show_font_style' => false,
				'show_line_height' => false,
				'show_letter_spacing' => false,
				'show_text_transform' => false,
				'show_font_variant' => false,
				'show_text_shadow' => false,
				'default' => array(
					'font-family' => 'Open Sans',
					'color' => '#666666',
					'font-size' => '14px',
				),
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
				'show_font_weight' => false,
				'show_font_style' => false,
				'show_line_height' => false,
				'show_letter_spacing' => false,
				'show_text_transform' => false,
				'show_font_variant' => false,
				'show_text_shadow' => false,
				'default' => array(
					'font-family' => 'Open Sans',
				),
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
				'show_font_size' => false,
				'show_font_weight' => false,
				'show_font_style' => false,
				'show_line_height' => false,
				'show_letter_spacing' => false,
				'show_text_transform' => false,
				'show_font_variant' => false,
				'show_text_shadow' => false,
				'default' => array(
					'font-family' => 'Source Code Pro',
				),
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

	/**
	 * Create Enable/Disable Footer Sidebar Option
	 */
	$footerTab->createOption(
			array(
				'name' => __( 'Enable Footer Sidebar', 'rtPanel' ),
				'id' => 'footer_sidebar',
				'type' => 'checkbox',
				'desc' => __( 'Check this to enable footer sidebar', 'rtPanel' ),
				'default' => false,
			)
	);

	/**
	 * Create Footer Information Option
	 */
	$footerTab->createOption(
			array(
				'name' => __( 'Footer Information', 'rtPanel' ),
				'id' => 'footer_info',
				'type' => 'editor',
				'rows' => 3,
				'media_buttons' => false,
			)
	);

	/**
	 * Create Powered By rtPanel Text Option
	 */
	$footerTab->createOption(
			array(
				'name' => __( 'Powered by rtPanel', 'rtPanel' ),
				'id' => 'powered_by',
				'type' => 'checkbox',
				'desc' => __( 'Show "Powered by rtPanel" link in footer using my affiliate ID', 'rtPanel' ),
				'default' => true,
			)
	);

	/**
	 * Create Affiliate ID Option
	 */
	$footerTab->createOption(
			array(
				'name' => __( 'Affiliate ID', 'rtPanel' ),
				'id' => 'affiliate_ID',
				'type' => 'text',
				'desc' => sprintf( __( 'You can use your rtCamp.com username as affiliate ID or get it from <a href="%s" target="_blank">here</a><br />To know more about our affiliate program, please check - <a href="%s" target="_blank">%s</a>', 'rtPanel' ), 'https://rtcamp.com/wp-admin/admin.php?page=rt-affiliate-banners', 'https://rtcamp.com/affiliates', 'https://rtcamp.com/affiliates' ),
			)
	);

	/**
	 * Save Footer Option Settings
	 */
	$footerTab->createOption(
			array(
				'type' => 'save',
			)
	);

	/**
	 * Create Post Summary Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Enable Post Summary', 'rtPanel' ),
				'id' => 'summary_show',
				'type' => 'checkbox',
				'desc' => __( 'Check this to enable excerpts on Archive pages ( Pages with multiple posts on them )', 'rtPanel' ),
				'default' => true,
			)
	);

	/**
	 * Create Word Limit Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Word Limit', 'rtPanel' ),
				'id' => 'word_limit',
				'type' => 'number',
				'default' => '55',
				'min' => 10,
				'max' => 200,
				'desc' => __( 'Post Content will be cut around Word Limit you will specify here.', 'rtPanel' ),
			)
	);

	/**
	 * Create Read More Text Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Read More Text', 'rtPanel' ),
				'id' => 'read_text',
				'type' => 'text',
				'default' => __( 'Read More &rarr;', 'rtPanel' ),
				'placeholder' => __( 'Read More Text', 'rtPanel' ),
				'desc' => __( 'This will be added after each post summary. Text added here will be automatically converted into a hyperlink pointing to the respective post.', 'rtPanel' ),
			)
	);

	/**
	 * Create Post Thumbnail Heading
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Post Thumbnail Settings', 'rtPanel' ),
				'type' => 'heading',
			)
	);

	/**
	 * Create Enable/Disable Thumbnail Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Enable Thumbnails', 'rtPanel' ),
				'id' => 'thumbnail_show',
				'type' => 'checkbox',
				'desc' => __( 'Check this to display thumbnails as part of Post Summaries on Archive pages', 'rtPanel' ),
				'default' => true,
			)
	);

	/**
	 * Create Thumbnail Alignment Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Thumbnail Alignment', 'rtPanel' ),
				'id' => 'thumbnail_position',
				'options' => array(
					'none' => __( 'None', 'rtPanel' ),
					'left' => __( 'Left', 'rtPanel' ),
					'center' => __( 'Center', 'rtPanel' ),
					'right' => __( 'Right', 'rtPanel' ),
				),
				'type' => 'radio',
				'desc' => __( 'Select the thumbnail alignment', 'rtPanel' ),
				'default' => 'right',
			)
	);

	/**
	 * Create Post Meta Heading
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Post Meta Settings', 'rtPanel' ),
				'type' => 'heading',
			)
	);

	/**
	 * Create Show/Hide Post Date Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Show Post Date', 'rtPanel' ),
				'id' => 'post_date',
				'type' => 'multicheck',
				'desc' => __( 'Check this box to include post dates in meta', 'rtPanel' ),
				'options' => array(
					'show' => __( '<strong>Include Post Date in Meta</strong>', 'rtPanel' ),
					'above' => __( 'Above Post Content', 'rtPanel' ),
					'below' => __( 'Below Post Content', 'rtPanel' ),
				),
				'default' => array( 'show', 'above' ),
			)
	);

	/**
	 * Create Show/Hide Post Author Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Show Post Author', 'rtPanel' ),
				'id' => 'post_author',
				'type' => 'multicheck',
				'desc' => __( 'Check this box to include author name in meta', 'rtPanel' ),
				'options' => array(
					'show' => __( '<strong>Include Author Name in Meta</strong>', 'rtPanel' ),
					'above' => __( 'Above Post Content', 'rtPanel' ),
					'below' => __( 'Below Post Content', 'rtPanel' ),
				),
				'default' => array( 'show', 'above' ),
			)
	);

	/**
	 * Create Show/Hide Post Categories Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Show Post Categories', 'rtPanel' ),
				'id' => 'post_category',
				'type' => 'multicheck',
				'desc' => __( 'Check this box to include post categories in meta', 'rtPanel' ),
				'options' => array(
					'show' => __( '<strong>Include Post Categories in Meta</strong>', 'rtPanel' ),
					'above' => __( 'Above Post Content', 'rtPanel' ),
					'below' => __( 'Below Post Content', 'rtPanel' ),
				),
				'default' => array( 'show', 'above' ),
			)
	);

	/**
	 * Create Show/Hide Post Tags Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Show Post Tags', 'rtPanel' ),
				'id' => 'post_tags',
				'type' => 'multicheck',
				'desc' => __( 'Check this box to include post tags in meta', 'rtPanel' ),
				'options' => array(
					'show' => __( '<strong>Include Post Tags in Meta</strong>', 'rtPanel' ),
					'above' => __( 'Above Post Content', 'rtPanel' ),
					'below' => __( 'Below Post Content', 'rtPanel' ),
				),
				'default' => array( 'show', 'below' ),
			)
	);

	/**
	 * Create Pagination Heading
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Pagination Settings', 'rtPanel' ),
				'type' => 'heading',
			)
	);

	/**
	 * Create Show/Hide Pagination Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Enable Pagination', 'rtPanel' ),
				'id' => 'pagination_show',
				'type' => 'checkbox',
				'desc' => __( 'Check this to enable default WordPress Pagination on Archive pages (Pages with multiple posts on them)', 'rtPanel' ),
				'default' => true,
			)
	);

	/**
	 * Create Pagination Previous Text Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Prev Text', 'rtPanel' ),
				'id' => 'prev_text',
				'type' => 'text',
				'default' => __( '&laquo; Previous', 'rtPanel' ),
				'placeholder' => __( 'Previous Link Text', 'rtPanel' ),
				'desc' => __( 'Text to display for Previous Page', 'rtPanel' ),
			)
	);

	/**
	 * Create Pagination Next Text Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Next Text', 'rtPanel' ),
				'id' => 'next_text',
				'type' => 'text',
				'default' => __( 'Next &raquo;', 'rtPanel' ),
				'placeholder' => __( 'Next Link Text', 'rtPanel' ),
				'desc' => __( 'Text to display for Next Page', 'rtPanel' ),
			)
	);

	/**
	 * Create Pagination End Size Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'End Size', 'rtPanel' ),
				'id' => 'end_size',
				'type' => 'number',
				'default' => '1',
				'min' => 1,
				'max' => 10,
				'desc' => __( 'How many numbers on either the start and the end list edges?', 'rtPanel' ),
			)
	);

	/**
	 * Create Pagination Mid Size Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Mid Size', 'rtPanel' ),
				'id' => 'mid_size',
				'type' => 'number',
				'default' => '2',
				'min' => 1,
				'max' => 10,
				'desc' => __( 'How many numbers to either side of current page, but not including current page?', 'rtPanel' ),
			)
	);

	/**
	 * Create Comment Form Heading
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Comment Form Settings', 'rtPanel' ),
				'type' => 'heading',
			)
	);

	/**
	 * Create Enable/Disable Gravatar Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Enable Gravatar', 'rtPanel' ),
				'id' => 'gravatar_show',
				'type' => 'checkbox',
				'desc' => __( 'Check this to display gravatar on comment template', 'rtPanel' ),
				'default' => true,
			)
	);

	/**
	 * Create Enable/Disable Compact Form Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Enable Compact Form', 'rtPanel' ),
				'id' => 'enable_compact_form',
				'type' => 'multicheck',
				'options' => array(
					'compact_form' => __( 'Check this box to compact comment form. Name, URL &amp; Email Fields will be on same line', 'rtPanel' ),
					'hide_labels' => __( 'Hide Labels for Name, Email &amp; URL. These will be shown inside fields as default text', 'rtPanel' ),
				),
				'default' => array( 'compact_form', 'hide_labels' ),
			)
	);

	/**
	 * Create Form Settings Option
	 */
	$postCommentTab->createOption(
			array(
				'name' => __( 'Extra Form Settings', 'rtPanel' ),
				'id' => 'extra_form_settings',
				'type' => 'multicheck',
				'options' => array(
					'comment_textarea' => __( 'Display Comment textarea above Name, Email, &amp; URL Fields', 'rtPanel' ),
					'comment_separate' => __( 'Separate Comments from Trackbacks &amp; Pingbacks', 'rtPanel' ),
					'attachment_comments' => __( 'Enable the comment form on Attachments', 'rtPanel' ),
				),
				'default' => array( 'comment_separate' ),
			)
	);

	/**
	 * Save Post and Comment Settings
	 */
	$postCommentTab->createOption(
			array(
				'type' => 'save',
			)
	);
}