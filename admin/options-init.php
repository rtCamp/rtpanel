<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */
if ( ! class_exists( 'rtp_Redux_Framework_config' ) ) {

	class rtp_Redux_Framework_config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct() {

			if ( ! class_exists( 'ReduxFramework' ) ) {
				return;
			}

			// This is needed. Bah WordPress bugs.  ;)
			if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
				$this->initSettings();
			} else {
				add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
			}
		}

		public function initSettings() {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if ( ! isset( $this->args[ 'opt_name' ] ) ) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			// Function to test the compiler hook and demo CSS output.
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			// Change the default value of a field after it's been set, but before it's been useds
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
			// Dynamically add a section. Can be also used to modify sections/fields
			//add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		/**

		  This is a test function that will let you see when the compiler hook occurs.
		  It only runs if a field	set with compiler=>true is changed.

		 * */
		function compiler_action( $options, $css ) {
			//echo '<h1>The compiler hook has run!';
			//print_r($options); //Option values
			//print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

			/*
			  // Demo of how to use the dynamic CSS and write your own static CSS file
			  $filename = dirname(__FILE__) . '/style' . '.css';
			  global $wp_filesystem;
			  if( empty( $wp_filesystem ) ) {
			  require_once( ABSPATH .'/wp-admin/includes/file.php' );
			  WP_Filesystem();
			  }

			  if( $wp_filesystem ) {
			  $wp_filesystem->put_contents(
			  $filename,
			  $css,
			  FS_CHMOD_FILE // predefined mode settings for WP files
			  );
			  }
			 */
		}

		/**

		  Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		  Simply include this function in the child themes functions.php file.

		  NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		  so you must use get_template_directory_uri() if you want to use any of the built in icons

		 * */
		function dynamic_section( $sections ) {
			//$sections = array();
			$sections[] = array(
				'title' => __( 'Section via hook', 'rtPanel' ),
				'desc' => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'rtPanel' ),
				'icon' => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array()
			);

			return $sections;
		}

		/**

		  Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

		 * */
		function change_arguments( $args ) {
			//$args['dev_mode'] = true;

			return $args;
		}

		/**

		  Filter hook for filtering the default value of any given field. Very useful in development mode.

		 * */
		function change_defaults( $defaults ) {
			$defaults[ 'str_replace' ] = 'Testing filter hook!';

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );

				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
			}
		}

		public function setSections() {

			$sampleHTML = '';

			if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
				/** @global WP_Filesystem_Direct $wp_filesystem  */
				global $wp_filesystem;
				if ( empty( $wp_filesystem ) ) {
					require_once(ABSPATH . '/wp-admin/includes/file.php');
					WP_Filesystem();
				}
				$sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
			}

			// Home Page Settings
			$this->sections[] = array(
				'title' => __( 'Home Page', 'rtPanel' ),
				//'desc' => __( 'It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'rtPanel' ),
				'icon' => 'el-icon-home',
				// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
					array(
						'id' => 'opt-homepage-layout',
						'type' => 'sorter',
						'title' => 'Layout',
						'subtitle' => __( 'Organize how you want the layout to appear on the homepage', 'rtPanel' ),
						'compiler' => 'true',
						'options' => array(
							'enabled' => array(
								'highlights' => 'Highlights',
								'slider' => 'Slider',
								'staticpage' => 'Static Page',
								'services' => 'Services'
							),
							'disabled' => array(),
						),
						'limits' => array(
							'disabled' => 2,
						),
					),
					array(
						'id' => 'opt-slides',
						'type' => 'slides',
						'title' => __( 'Slides Options', 'rtPanel' ),
						'subtitle' => __( 'Unlimited slides with drag and drop sortings.', 'rtPanel' ),
						//'desc' => __( 'This field will store all slides values into a multidimensional array to use into a foreach loop.', 'rtPanel' ),
						'placeholder' => array(
							'title' => __( 'This is a title', 'rtPanel' ),
							'description' => __( 'Description Here', 'rtPanel' ),
							'url' => __( 'Give us a link!', 'rtPanel' ),
						),
					),
				),
			);

			// General Settings
			$this->sections[] = array(
				'title' => __( 'General', 'rtPanel' ),
				'icon' => 'el-icon-cog',
				'fields' => array(
					array(
						'id' => 'custom_logo',
						'type' => 'media',
						'url' => true,
						'title' => __( 'Logo', 'rtPanel' ),
						'subtitle' => __( 'Upload your custom site logo.', 'rtPanel' ),
					//'default' => array( 'url' => get_template_directory_uri() . '/img/rtp-logo.png' ),
					),
					array(
						'id' => 'favicon',
						'type' => 'media',
						'url' => true,
						'title' => __( 'Favicon', 'rtPanel' ),
						'subtitle' => __( 'Upload your custom site favicon.', 'rtPanel' ),
					//'default' => array( 'url' => get_template_directory_uri() . '/img/favicon.ico' ),
					),
				)
			);

			// Styling Settings
			$this->sections[] = array(
				'title' => __( 'Background', 'rtPanel' ),
				'icon' => 'el-icon-picture',
				'fields' => array(
					array(
						'id' => 'background_color',
						'transparent' => false,
						'preview_media' => true,
						'type' => 'background',
						'title' => __( 'Background', 'rtPanel' ),
						'default' => '',
						'subtitle' => __( 'Select your custom background for body.', 'rtPanel' ),
						'output' => array( 'body' ),
					),
				)
			);

			// Layout Settings
			$this->sections[] = array(
				'title' => __( 'Layout', 'rtPanel' ),
				'icon' => 'el-icon-website',
				'fields' => array(
					array(
						'id' => 'main_layout',
						'type' => 'select',
						'title' => __( 'Layout Style', 'rtPanel' ),
						'subtitle' => __( 'Select your website layout style.', 'rtPanel' ),
						'options' => array(
							'rtp-full-width-layout' => __( 'Full Width', 'rtPanel' ),
							'rtp-boxed-layout' => __( 'Boxed', 'rtPanel' ),
						),
						'default' => 'rtp-full-width-layout'
					),
					array(
						'id' => 'main_container_width',
						'type' => 'dimensions',
						'title' => __( 'Main Container Width', 'rtPanel' ),
						'subtitle' => __( 'Enter your custom main container width. Default width is 1200px', 'rtPanel' ),
						'height' => false,
						'default' => array(
						//'width' => '1200'
						),
						'output' => array( '.row' ),
					),
				)
			);

			// Typography Settings
			$this->sections[] = array(
				'title' => __( 'Typography', 'rtPanel' ),
				'icon' => 'el-icon-font',
				'fields' => array(
					array(
						'id' => 'typography_body',
						'type' => 'typography',
						'title' => __( 'Body Font', 'rtPanel' ),
						'subtitle' => __( 'Specify the body font properties.', 'rtPanel' ),
						'google' => true,
						'line-height' => false,
						'text-align' => false,
						'default' => array(
							'color' => '#333333',
							'font-size' => '16px',
							'font-family' => 'Arial,Helvetica,sans-serif',
							'font-weight' => 'Normal',
						),
						'output' => array( 'body' ),
					),
					array(
						'id' => 'typography_heading',
						'type' => 'typography',
						'title' => __( 'Heading Font', 'rtPanel' ),
						'subtitle' => __( 'Specify the heading tag font properties.', 'rtPanel' ),
						'google' => true,
						'font-size' => false,
						'line-height' => false,
						'text-align' => false,
						'default' => array(
							'color' => '#333333',
							'font-family' => 'Arial,Helvetica,sans-serif',
							'font-weight' => 'Normal',
						),
						'output' => array( 'h1, h2, h3, h4, h5, h6' ),
					),
					array(
						'id' => 'typography_coding',
						'type' => 'typography',
						'title' => __( 'Coding Font', 'rtPanel' ),
						'subtitle' => __( 'Set coding fonts for kbd, pre, samp, code, etc tags.', 'rtPanel' ),
						'google' => true,
						'color' => false,
						'font-size' => false,
						'line-height' => false,
						'text-align' => false,
						'default' => array(
							'color' => '#dd9933',
							'font-family' => 'Arial,Helvetica,sans-serif',
							'font-weight' => 'Normal',
						),
						'output' => array( 'kbd, pre, samp, code' ),
					),
				)
			);

			// Styling Settings
			$this->sections[] = array(
				'title' => __( 'Styling', 'rtPanel' ),
				'icon' => 'el-icon-brush',
				'fields' => array(
					array(
						'id' => 'select_stylesheet',
						'type' => 'select',
						'title' => __( 'Theme Stylesheet', 'rtPanel' ),
						'subtitle' => __( 'Select your themes alternative color scheme.', 'rtPanel' ),
						'options' => array( 'default.css' => 'default.css', 'color1.css' => 'color1.css', 'color2.css' => 'color2.css', 'color3.css' => 'color3.css' ),
						'default' => 'default.css',
					),
					array(
						'id' => 'link_color',
						'type' => 'link_color',
						'title' => __( 'Links Color Option', 'rtPanel' ),
						'subtitle' => __( 'Only color validation can be done on this field type', 'rtPanel' ),
						'desc' => __( 'This is the description field, again good for additional info.', 'rtPanel' ),
						//'regular'   => false, // Disable Regular Color
						//'hover'     => false, // Disable Hover Color
						//'active'    => false, // Disable Active Color
						//'visited'   => true,  // Enable Visited Color
						'default' => array(
							'regular' => '#aaa',
							'hover' => '#bbb',
							'active' => '#ccc',
						)
					),
				)
			);

			// Header Settings
			$this->sections[] = array(
				'title' => __( 'Header', 'rtPanel' ),
				'icon' => 'el-icon-screen',
				'fields' => array(
					array(
						'id' => 'adminbar',
						'type' => 'switch',
						'title' => __( 'Adminbar', 'rtPanel' ),
						'subtitle' => __( 'Toggle the adminbar on frontend.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
				)
			);

			// Footer Settings
			$this->sections[] = array(
				'title' => __( 'Footer', 'rtPanel' ),
				'icon' => 'el-icon-download',
				'fields' => array(
					array(
						'id' => 'footer_sidebar',
						'type' => 'switch',
						'title' => __( 'Footer Sidebar', 'rtPanel' ),
						'subtitle' => __( 'Check this to enable footer sidebar.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'footer_navigation',
						'type' => 'switch',
						'title' => __( 'Footer Navigation', 'rtPanel' ),
						'subtitle' => __( 'Show Footer Navigation', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'footer_area',
						'type' => 'switch',
						'title' => __( 'Bottom Footer Area', 'rtPanel' ),
						'subtitle' => __( 'Toggle the bottom footer area on or off.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'footer_content',
						'type' => 'editor',
						'title' => __( 'Footer Text', 'rtPanel' ),
						'subtitle' => __( 'You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'rtPanel' ),
						'default' => 'Powered by Redux Framework.',
						'required' => array( 'footer_area', 'equals', '1' ),
					),
					array(
						'id' => 'powered_by',
						'type' => 'switch',
						'title' => __( 'Powered by rtCamp', 'rtPanel' ),
						'subtitle' => __( 'Show "Powered by rtCamp" link in footer using my affiliate ID', 'rtPanel' ),
						"default" => '0',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'affiliate_id',
						'type' => 'text',
						'title' => __( 'Affiliate ID', 'rtPanel' ),
						'subtitle' => sprintf( __( 'You can use your rtCamp.com username as affiliate ID or get it from <a href="%s" target="_blank">here</a><br />', 'rtPanel' ), 'https://rtcamp.com/wp-admin/admin.php?page=rt-affiliate-banners' ),
						'default' => '',
						'desc' => sprintf( __( 'To know more about our affiliate program, please check - <a href="%s" target="_blank">%s</a>', 'rtPanel' ), 'https://rtcamp.com/affiliates', 'https://rtcamp.com/affiliates' ),
						'required' => array( 'powered_by', 'equals', '1' ),
					),
				)
			);

			// Blog Settings
			$this->sections[] = array(
				'title' => __( 'Blog', 'rtPanel' ),
				'icon' => 'el-icon-edit',
				'fields' => array(
					array(
						'id' => 'blog_excerpt',
						'type' => 'switch',
						'title' => __( 'Entry Auto Excerpts', 'rtPanel' ),
						'subtitle' => __( 'Toggle your blog auto excerpts on or off.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'blog_excerpt_length',
						'type' => 'text',
						'title' => __( 'Entry Excerpt length', 'rtPanel' ),
						'desc' => '',
						'subtitle' => __( 'How many words do you want to show for your blog entry excerpts?', 'rtPanel' ),
						'default' => '50',
						'validate' => 'numeric',
						'required' => array( 'blog_excerpt', 'equals', '1' ),
					),
					array(
						'id' => 'blog_entry_readmore',
						'type' => 'switch',
						'title' => __( 'Entry Read More Button', 'rtPanel' ),
						'subtitle' => __( 'Toggle the blog entry read more button on or off.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'blog_entry_readmore_text',
						'type' => 'text',
						'title' => __( 'Entry Read More Text', 'rtPanel' ),
						'subtitle' => __( 'Your custom entry read more button text, default is "Continue Reading".', 'rtPanel' ),
						'default' => 'Continue reading',
						'required' => array( 'blog_entry_readmore', 'equals', '1' ),
					),
					array(
						'id' => 'post_thumb_info',
						'type' => 'info',
						'title' => false,
						'desc' => __( 'Post Thumbnail Settings', 'rtPanel' ),
					),
					array(
						'id' => 'post_thumbnails',
						'type' => 'switch',
						'title' => __( 'Blog Archives Thumbnails', 'rtPanel' ),
						'subtitle' => __( 'Toggle the blog entry post thumbnails on or off. Shows only feature image.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'thumbnail_alignment',
						'type' => 'select',
						'title' => __( 'Thumbnail Alignment', 'rtPanel' ),
						'subtitle' => __( 'Select the thumbnail alignment', 'rtPanel' ),
						'options' => array( 'alignnone' => 'None', 'alignleft' => 'Left', 'alignright' => 'Right', 'aligncenter' => 'Center' ),
						'default' => 'alignright',
						'required' => array( 'post_thumbnails', 'equals', '1' ),
					),
					array(
						'id' => 'blog_single_thumbnail',
						'type' => 'switch',
						'title' => __( 'Post Featured Image', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display of featured images on single blog posts on or off.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'single_thumbnail_alignment',
						'type' => 'select',
						'title' => __( 'Featured Image Alignment', 'rtPanel' ),
						'subtitle' => __( 'Select the image alignment', 'rtPanel' ),
						'options' => array( 'alignnone' => 'None', 'alignleft' => 'Left', 'alignright' => 'Right', 'aligncenter' => 'Center' ),
						'default' => 'aligncenter',
						'required' => array( 'blog_single_thumbnail', 'equals', '1' ),
					),
					array(
						'id' => 'post_meta_info',
						'type' => 'info',
						'title' => false,
						'desc' => __( 'Post Meta Settings', 'rtPanel' ),
					),
					array(
						'id' => 'post_meta',
						'type' => 'switch',
						'title' => __( 'Post Meta', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display post author in meta.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'post_author',
						'type' => 'switch',
						'title' => __( 'Post Author', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display post author in meta.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
						'required' => array( 'post_meta', 'equals', '1' ),
					),
					array(
						'id' => 'post_date',
						'type' => 'switch',
						'title' => __( 'Post Date', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display post dates in meta.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
						'required' => array( 'post_meta', 'equals', '1' ),
					),
					array(
						'id' => 'post_categories',
						'type' => 'switch',
						'title' => __( 'Post Categories', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display post categories in meta.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
						'required' => array( 'post_meta', 'equals', '1' ),
					),
					array(
						'id' => 'post_tags',
						'type' => 'switch',
						'title' => __( 'Post Tags', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display post tags in meta.', 'rtPanel' ),
						"default" => '0',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
						'required' => array( 'post_meta', 'equals', '1' ),
					),
					array(
						'id' => 'post_comment',
						'type' => 'switch',
						'title' => __( 'Post Comments', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display post comment count in meta.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
						'required' => array( 'post_meta', 'equals', '1' ),
					),
					array(
						'id' => 'pagination-info',
						'type' => 'info',
						'title' => false,
						'desc' => __( 'Pagination Settings', 'rtPanel' ),
					),
					array(
						'id' => 'archives_pagination',
						'type' => 'switch',
						'title' => __( 'Blog Archives Pagination', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display custom pagination.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'prev_text',
						'type' => 'text',
						'title' => __( 'Prev Text', 'rtPanel' ),
						'subtitle' => __( 'Text to display for Previous Page', 'rtPanel' ),
						"default" => '« Previous',
						'required' => array( 'archives_pagination', 'equals', '1' ),
					),
					array(
						'id' => 'next_text',
						'type' => 'text',
						'title' => __( 'Next Text', 'rtPanel' ),
						'subtitle' => __( 'Text to display for Next Page', 'rtPanel' ),
						"default" => 'Next »',
						'required' => array( 'archives_pagination', 'equals', '1' ),
					),
					array(
						'id' => 'end_size',
						'type' => 'text',
						'title' => __( 'End Size', 'rtPanel' ),
						'subtitle' => __( 'How many numbers on either the start and the end list edges?', 'rtPanel' ),
						"default" => '1',
						'validate' => 'numeric',
						'required' => array( 'archives_pagination', 'equals', '1' ),
					),
					array(
						'id' => 'mid_size',
						'type' => 'text',
						'title' => __( 'Mid Size', 'rtPanel' ),
						'subtitle' => __( 'How many numbers to either side of current page, but not including current page?', 'rtPanel' ),
						"default" => '2',
						'validate' => 'numeric',
						'required' => array( 'archives_pagination', 'equals', '1' ),
					),
					array(
						'id' => 'single_pagination',
						'type' => 'switch',
						'title' => __( 'Single Post Pagination', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display pagination.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'comment_info',
						'type' => 'info',
						'title' => false,
						'desc' => __( 'Comment Settings', 'rtPanel' ),
					),
					array(
						'id' => 'comments',
						'type' => 'switch',
						'title' => __( 'Site Comments', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display to unable/disable comments.', 'rtPanel' ),
						"default" => '1',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
				)
			);

			// Codes Settings
			$this->sections[] = array(
				'title' => __( 'Custom Codes', 'rtPanel' ),
				'icon' => 'el-icon-align-left',
				'fields' => array(
					array(
						'id' => 'tracking',
						'type' => 'switch',
						'title' => __( 'Tracking', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display to unable/disable tracking.', 'rtPanel' ),
						"default" => '0',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'tracking_code',
						'type' => 'ace_editor',
						'title' => __( 'Tracking Code', 'rtPanel' ),
						'subtitle' => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'rtPanel' ),
						'mode' => 'plain_text',
						'theme' => 'chrome',
						//'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
						//'default' => "jQuery( document ).ready( function(){\n\n});"
						'required' => array( 'tracking', 'equals', '1' ),
					),
					array(
						'id' => 'css',
						'type' => 'switch',
						'title' => __( 'CSS', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display to unable/disable custom css.', 'rtPanel' ),
						"default" => '0',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'custom_css',
						'type' => 'ace_editor',
						'title' => __( 'CSS Code', 'rtPanel' ),
						'subtitle' => __( 'Paste your CSS code here.', 'rtPanel' ),
						'mode' => 'css',
						'theme' => 'chrome',
						//'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
						'default' => "#header{\n    background: red;\n}",
						'required' => array( 'css', 'equals', '1' ),
					),
					array(
						'id' => 'js',
						'type' => 'switch',
						'title' => __( 'JavaScript', 'rtPanel' ),
						'subtitle' => __( 'Toggle the display to unable/disable custom JavaScript.', 'rtPanel' ),
						"default" => '0',
						'on' => __( 'On', 'rtPanel' ),
						'off' => __( 'Off', 'rtPanel' ),
					),
					array(
						'id' => 'custom_js',
						'type' => 'ace_editor',
						'title' => __( 'JS Code', 'rtPanel' ),
						'subtitle' => __( 'Paste your JS code here.', 'rtPanel' ),
						'mode' => 'javascript',
						'theme' => 'chrome',
						//'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
						'default' => "jQuery( document ).ready( function(){\n    //Your codes strat from here\n});",
						'required' => array( 'js', 'equals', '1' ),
					)
				)
			);

			// License Settings
			$this->sections[] = array(
				'title' => __( 'Social Links', 'rtPanel' ),
				'icon' => 'el-icon-bullhorn',
				'fields' => array(
					array(
						'id' => 'social_links',
						'type' => 'sortable',
						'title' => __( 'Social Links', 'rtPanel' ),
						'subtitle' => __( 'Add your social link urls', 'rtPanel' ),
						'desc' => __( 'This is the description field, again good for additional info.', 'rtPanel' ),
						'options' => array(
							'Facebook' => '',
							'Twitter' => '',
							'LinkedIn' => '',
							'Google' => '',
							'Email' => '',
						)
					),
				)
			);

			// License Settings
			$this->sections[] = array(
				'title' => __( 'License', 'rtPanel' ),
				'icon' => 'el-icon-key',
				'fields' => array(
				)
			);

			// Plugins Settings
//			$this->sections[] = array(
//				'title' => __( 'Plugins', 'rtPanel' ),
//				'icon' => 'el-icon-cogs',
//				'fields' => array(
//				)
//			);
			// Support Settings
//			$this->sections[] = array(
//				'title' => __( 'Support', 'rtPanel' ),
//				'icon' => 'el-icon-envelope',
//				'fields' => array(
//				)
//			);
			// Theme Documentation
			if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
				$this->sections[ 'theme_docs' ] = array(
					'icon' => 'el-icon-list-alt',
					'title' => __( 'Documentation', 'rtPanel' ),
					'fields' => array(
						array(
							'id' => '17',
							'type' => 'raw',
							'markdown' => true,
							'content' => file_get_contents( dirname( __FILE__ ) . '/../README.md' )
						),
					),
				);
			}

			// Import / Export
			$this->sections[] = array(
				'title' => __( 'Import / Export', 'rtPanel' ),
				'desc' => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'rtPanel' ),
				'icon' => 'el-icon-refresh',
				'fields' => array(
					array(
						'id' => 'opt-import-export',
						'type' => 'import_export',
						'title' => 'Import Export',
						'subtitle' => 'Save and restore your Redux options',
						'full_width' => false,
					),
				),
			);

			$this->sections[] = array(
				'type' => 'divide',
			);

//			$this->sections[] = array(
//				'icon' => 'el-icon-info-sign',
//				'title' => __( 'Theme Information', 'rtPanel' ),
//				'desc' => __( '<p class="description">This is the Description. Again HTML is allowed</p>', 'rtPanel' ),
//				'fields' => array(
//					array(
//						'id' => 'opt-raw-info',
//						'type' => 'raw',
//						'content' => $sampleHTML,
//					)
//				),
//			);

			if ( file_exists( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) ) {
				$tabs[ 'docs' ] = array(
					'icon' => 'el-icon-book',
					'title' => __( 'Documentation', 'rtPanel' ),
					'content' => nl2br( file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) )
				);
			}
		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args[ 'help_tabs' ][] = array(
				'id' => 'redux-help-tab-1',
				'title' => __( 'Theme Information 1', 'rtPanel' ),
				'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'rtPanel' )
			);

			$this->args[ 'help_tabs' ][] = array(
				'id' => 'redux-help-tab-2',
				'title' => __( 'Theme Information 2', 'rtPanel' ),
				'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'rtPanel' )
			);

			// Set the help sidebar
			$this->args[ 'help_sidebar' ] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'rtPanel' );
		}

		/**

		  All the possible arguments for Redux.
		  For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 * */
		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name' => 'rtp_options', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name' => $theme->get( 'Name' ), // Name that appears at the top of your panel
				'display_version' => $theme->get( 'Version' ), // Version that appears at the top of your panel
				'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu' => true, // Show the sections below the admin menu item or not
				'menu_title' => __( 'rtPanel Options', 'rtPanel' ),
				'page_title' => __( 'rtPanel Options', 'rtPanel' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key' => 'AIzaSyAcVwUB4-1PFXbn3I4_u-ZwoDCnaXJ6MRo', // Must be defined to add google fonts to the typography module
				'async_typography' => true, // Use a asynchronous font on the front end or font string
				//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
				'admin_bar' => true, // Show the panel pages on the admin bar
				'global_variable' => '', // Set a different name for your global variable other than the opt_name
				'dev_mode' => true, // Show the time the page took to load, etc
				'customizer' => true, // Enable basic customizer support
				//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
				//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
				// OPTIONAL -> Give you extra features
				'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon' => '', // Specify a custom URL to an icon
				'last_tab' => '', // Force your panel to always open to a specific tab (by id)
				'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug' => '_options', // Page slug used to denote the panel
				'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
				'default_show' => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
				'show_import_export' => true, // Shows the Import/Export panel when not used as a field.
				// CAREFUL -> These options are for advanced use only
				'transient_time' => 60 * MINUTE_IN_SECONDS,
				'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'system_info' => false, // REMOVE
				// HINTS
				'hints' => array(
					'icon' => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color' => 'lightgray',
					'icon_size' => 'normal',
					'tip_style' => array(
						'color' => 'light',
						'shadow' => true,
						'rounded' => false,
						'style' => '',
					),
					'tip_position' => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect' => array(
						'show' => array(
							'effect' => 'slide',
							'duration' => '500',
							'event' => 'mouseover',
						),
						'hide' => array(
							'effect' => 'slide',
							'duration' => '500',
							'event' => 'click mouseleave',
						),
					),
				)
			);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
			$this->args[ 'share_icons' ][] = array(
				'url' => 'https://github.com/rtcamp/',
				'title' => 'Visit us on GitHub',
				'icon' => 'el-icon-github'
					//'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
			);
			$this->args[ 'share_icons' ][] = array(
				'url' => 'https://www.facebook.com/rtCamp.solutions',
				'title' => 'Like us on Facebook',
				'icon' => 'el-icon-facebook'
			);
			$this->args[ 'share_icons' ][] = array(
				'url' => 'https://twitter.com/rtcamp',
				'title' => 'Follow us on Twitter',
				'icon' => 'el-icon-twitter'
			);
			$this->args[ 'share_icons' ][] = array(
				'url' => 'https://www.linkedin.com/company/rtcamp',
				'title' => 'Find us on LinkedIn',
				'icon' => 'el-icon-linkedin'
			);

			// Panel Intro text -> before the form
			if ( ! isset( $this->args[ 'global_variable' ] ) || $this->args[ 'global_variable' ] !== false ) {
				if ( ! empty( $this->args[ 'global_variable' ] ) ) {
					$v = $this->args[ 'global_variable' ];
				} else {
					$v = str_replace( '-', '_', $this->args[ 'opt_name' ] );
				}
				$this->args[ 'intro_text' ] = sprintf( __( '<p>To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'rtPanel' ), $v );
			} else {
				$this->args[ 'intro_text' ] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'rtPanel' );
			}

			// Add content after the form.
			$this->args[ 'footer_text' ] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'rtPanel' );
		}

	}

	global $reduxConfig;
	$reduxConfig = new rtp_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if ( ! function_exists( 'rtp_my_custom_field' ) ):

	function rtp_my_custom_field( $field, $value ) {
		print_r( $field );
		echo '<br/>';
		print_r( $value );
	}

endif;

/**
  Custom function for the callback validation referenced above
 * */
if ( ! function_exists( 'rtp_validate_callback_function' ) ):

	function rtp_validate_callback_function( $field, $value, $existing_value ) {
		$error = false;
		$value = 'just testing';

		/*
		  do your validation

		  if(something) {
		  $value = $value;
		  } elseif(something else) {
		  $error = true;
		  $value = $existing_value;
		  $field['msg'] = 'your custom error message';
		  }
		 */

		$return[ 'value' ] = $value;
		if ( $error == true ) {
			$return[ 'error' ] = $field;
		}
		return $return;
	}

endif;
?>