<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */
if ( ! class_exists( 'rtpanel_Redux_Framework_config' ) ) {

	class rtpanel_Redux_Framework_config {

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
				'title' => __( 'Section via hook', 'redux-framework-demo' ),
				'desc' => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
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
				'title' => __( 'Home Page', 'redux-framework-demo' ),
				//'desc' => __( 'It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'redux-framework-demo' ),
				'icon' => 'el-icon-home',
				// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(
					array(
						'id' => 'opt-homepage-layout',
						'type' => 'sorter',
						'title' => 'Layout',
						'subtitle' => __( 'Organize how you want the layout to appear on the homepage', 'redux-framework-demo' ),
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
						'title' => __( 'Slides Options', 'redux-framework-demo' ),
						'subtitle' => __( 'Unlimited slides with drag and drop sortings.', 'redux-framework-demo' ),
						//'desc' => __( 'This field will store all slides values into a multidimensional array to use into a foreach loop.', 'redux-framework-demo' ),
						'placeholder' => array(
							'title' => __( 'This is a title', 'redux-framework-demo' ),
							'description' => __( 'Description Here', 'redux-framework-demo' ),
							'url' => __( 'Give us a link!', 'redux-framework-demo' ),
						),
					),
				),
			);

			// General Settings
			$this->sections[] = array(
				'title' => __( 'General', 'redux-framework-demo' ),
				'icon' => 'el-icon-cog',
				'fields' => array(
					array(
						'id' => 'custom_logo',
						'type' => 'media',
						'url' => true,
						'title' => __( 'Logo', 'redux-framework-demo' ),
						'subtitle' => __( 'Upload your custom site logo.', 'redux-framework-demo' ),
						'default' => array( 'url' => get_template_directory_uri() . '/img/rtp-logo.png' ),
					),
					array(
						'id' => 'favicon',
						'type' => 'media',
						'url' => true,
						'title' => __( 'Favicon', 'redux-framework-demo' ),
						'subtitle' => __( 'Upload your custom site favicon.', 'redux-framework-demo' ),
						'default' => array( 'url' => get_template_directory_uri() . '/img/favicon.ico' ),
					),
				)
			);

			// Layout Settings
			$this->sections[] = array(
				'title' => __( 'Layout', 'redux-framework-demo' ),
				'icon' => 'el-icon-website',
				'fields' => array(
					array(
						'id' => 'main_layout',
						'type' => 'select',
						'title' => __( 'Layout Style', 'redux-framework-demo' ),
						'subtitle' => __( 'Select your website layout style.', 'redux-framework-demo' ),
						'options' => array(
							'full-width' => __( 'Full Width', 'redux-framework-demo' ),
							'boxed' => __( 'Boxed', 'redux-framework-demo' ),
						),
						'default' => 'full-width'
					),
					array(
						'id' => 'main_container_width',
						'type' => 'text',
						'title' => __( 'Main Container Width', 'redux-framework-demo' ),
						'subtitle' => __( 'Enter your custom main container width in pixels.', 'redux-framework-demo' ),
						'default' => '1200px',
					),
				)
			);

			// Typography Settings
			$this->sections[] = array(
				'title' => __( 'Typography', 'redux-framework-demo' ),
				'icon' => 'el-icon-font',
				'fields' => array(
					array(
						'id' => 'opt-typography-body',
						'type' => 'typography',
						'title' => __( 'Body Font', 'redux-framework-demo' ),
						'subtitle' => __( 'Specify the body font properties.', 'redux-framework-demo' ),
						'google' => true,
						'line-height' => false,
						'text-align' => false,
						'default' => array(
							'color' => '#dd9933',
							'font-size' => '16px',
							'font-family' => 'Arial,Helvetica,sans-serif',
							'font-weight' => 'Normal',
						),
					),
					array(
						'id' => 'opt-typography-heading',
						'type' => 'typography',
						'title' => __( 'Heading Font', 'redux-framework-demo' ),
						'subtitle' => __( 'Specify the heading tag font properties.', 'redux-framework-demo' ),
						'google' => true,
						'font-size' => false,
						'line-height' => false,
						'text-align' => false,
						'default' => array(
							'color' => '#dd9933',
							'font-family' => 'Arial,Helvetica,sans-serif',
							'font-weight' => 'Normal',
						),
					),
					array(
						'id' => 'opt-typography-coding',
						'type' => 'typography',
						'title' => __( 'Coding Font', 'redux-framework-demo' ),
						'subtitle' => __( 'Set coding fonts for kbd, pre, samp, code, etc tags.', 'redux-framework-demo' ),
						'google' => true,
						'font-size' => false,
						'line-height' => false,
						'text-align' => false,
						'default' => array(
							'color' => '#dd9933',
							'font-family' => 'Arial,Helvetica,sans-serif',
							'font-weight' => 'Normal',
						),
					),
				)
			);

			// Styling Settings
			$this->sections[] = array(
				'title' => __( 'Styling', 'redux-framework-demo' ),
				'icon' => 'el-icon-brush',
				'fields' => array(
					array(
						'id' => 'opt-select-stylesheet',
						'type' => 'select',
						'title' => __( 'Theme Stylesheet', 'redux-framework-demo' ),
						'subtitle' => __( 'Select your themes alternative color scheme.', 'redux-framework-demo' ),
						'options' => array( 'default.css' => 'default.css', 'color1.css' => 'color1.css', 'color2.css' => 'color2.css', 'color3.css' => 'color3.css' ),
						'default' => 'default.css',
					),
					array(
						'id' => 'opt-link-color',
						'type' => 'link_color',
						'title' => __( 'Links Color Option', 'redux-framework-demo' ),
						'subtitle' => __( 'Only color validation can be done on this field type', 'redux-framework-demo' ),
						'desc' => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
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
					array(
						'id' => 'opt-background',
						'type' => 'background',
						'output' => array( 'body' ),
						'title' => __( 'Body Background', 'redux-framework-demo' ),
						'subtitle' => __( 'Body background with image, color, etc.', 'redux-framework-demo' ),
					//'default'   => '#FFFFFF',
					),
					array(
						'id' => 'opt-color-scheme',
						'type' => 'color_scheme',
						'title' => 'Color Schemes',
						'subtitle' => 'Save and load color schemes',
						'output' => true,
						'compiler' => true,
						'simple' => false,
						'default' => array(
							array(
								'id' => 'body-background',
								'title' => 'body background',
								'color' => '#ededed',
								'alpha' => .5,
								'selector' => 'body',
								'mode' => 'background-color',
								'important' => false,
								'group' => 'Body'
							),
						)
					)
				)
			);

			// Header Settings
			$this->sections[] = array(
				'title' => __( 'Header', 'redux-framework-demo' ),
				'icon' => 'el-icon-screen',
				'fields' => array(
					array(
						'id' => 'adminbar',
						'type' => 'checkbox',
						'title' => __( 'Hide Adminbar', 'redux-framework-demo' ),
						'subtitle' => __( 'Hide admin bar on frontend', 'redux-framework-demo' ),
						//'desc' => __( 'Hide admin bar', 'redux-framework-demo' ),
						'default' => '1'// 1 = on | 0 = off
					),
				)
			);

			// Footer Settings
			$this->sections[] = array(
				'title' => __( 'Footer', 'redux-framework-demo' ),
				'icon' => 'el-icon-download',
				'fields' => array(
					array(
						'id' => 'footer_sidebar',
						'type' => 'checkbox',
						'title' => __( 'Footer Sidebar', 'redux-framework-demo' ),
						'subtitle' => __( 'Check this to enable footer sidebar.', 'redux-framework-demo' ),
						//'desc' => __( 'Hide admin bar', 'redux-framework-demo' ),
						'default' => '1'// 1 = on | 0 = off
					),
					array(
						'id' => 'footer_navigation',
						'type' => 'checkbox',
						'title' => __( 'Footer Navigation', 'redux-framework-demo' ),
						'subtitle' => __( 'Show Footer Navigation', 'redux-framework-demo' ),
						//'desc' => __( 'Hide admin bar', 'redux-framework-demo' ),
						'default' => '1'// 1 = on | 0 = off
					),
					array(
						'id' => 'opt-editor',
						'type' => 'editor',
						'title' => __( 'Footer Text', 'redux-framework-demo' ),
						'subtitle' => __( 'You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'redux-framework-demo' ),
						'default' => 'Powered by Redux Framework.',
					),
					array(
						'id' => 'powered_by',
						'type' => 'checkbox',
						'title' => __( 'Powered by rtCamp', 'redux-framework-demo' ),
						'subtitle' => __( 'Show "Powered by rtCamp" link in footer using my affiliate ID', 'redux-framework-demo' ),
						//'desc' => __( 'Hide admin bar', 'redux-framework-demo' ),
						'default' => '0'// 1 = on | 0 = off
					),
					array(
						'id' => 'affiliate_id',
						'type' => 'text',
						'title' => __( 'Affiliate ID', 'redux-framework-demo' ),
						'subtitle' => sprintf( __( 'You can use your rtCamp.com username as affiliate ID or get it from <a href="%s" target="_blank">here</a><br />', 'redux-framework-demo' ), 'https://rtcamp.com/wp-admin/admin.php?page=rt-affiliate-banners' ),
						'default' => '',
						'desc' => sprintf( __( 'To know more about our affiliate program, please check - <a href="%s" target="_blank">%s</a>', 'redux-framework-demo' ), 'https://rtcamp.com/affiliates', 'https://rtcamp.com/affiliates' ),
						'required' => array( 'powered_by', 'equals', '1' ),
					),
				)
			);

			// Blog Settings
			$this->sections[] = array(
				'title' => __( 'Blog', 'redux-framework-demo' ),
				'icon' => 'el-icon-edit',
				'fields' => array(
					array(
						'id' => 'blog_exceprt',
						'type' => 'switch',
						'title' => __( 'Entry Auto Excerpts', 'redux-framework-demo' ),
						'subtitle' => __( 'Toggle your blog auto excerpts on or off.', 'redux-framework-demo' ),
						"default" => '1',
						'on' => __( 'On', 'redux-framework-demo' ),
						'off' => __( 'Off', 'redux-framework-demo' ),
					),
					array(
						'id' => 'blog_excerpt_length',
						'type' => 'text',
						'title' => __( 'Entry Excerpt length', 'redux-framework-demo' ),
						'desc' => '',
						'subtitle' => __( 'How many words do you want to show for your blog entry excerpts?', 'redux-framework-demo' ),
						'default' => '40',
						'required' => array( 'blog_exceprt', 'equals', '1' ),
					),
					array(
						'id' => 'blog_entry_readmore',
						'type' => 'switch',
						'title' => __( 'Entry Read More Button', 'redux-framework-demo' ),
						'subtitle' => __( 'Toggle the blog entry read more button on or off.', 'redux-framework-demo' ),
						"default" => '1',
						'on' => __( 'On', 'redux-framework-demo' ),
						'off' => __( 'Off', 'redux-framework-demo' ),
					),
					array(
						'id' => 'blog_entry_readmore_text',
						'type' => 'text',
						'title' => __( 'Entry Read More Text', 'redux-framework-demo' ),
						'subtitle' => __( 'Your custom entry read more button text, default is "Continue Reading".', 'redux-framework-demo' ),
						"default" => '',
						'required' => array( 'blog_entry_readmore', 'equals', '1' ),
					),
				)
			);

			// Codes Settings
			$this->sections[] = array(
				'title' => __( 'Custom Codes', 'redux-framework-demo' ),
				'icon' => 'el-icon-align-left',
				'fields' => array(
					array(
						'id' => 'tracking',
						'type' => 'textarea',
						'title' => __( 'Tracking Code', 'redux-framework-demo' ),
						'subtitle' => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'redux-framework-demo' ),
						'validate' => 'js',
						'desc' => 'Validate that it\'s javascript!',
					),
					array(
						'id' => 'opt-ace-editor-css',
						'type' => 'ace_editor',
						'title' => __( 'CSS Code', 'redux-framework-demo' ),
						'subtitle' => __( 'Paste your CSS code here.', 'redux-framework-demo' ),
						'mode' => 'css',
						'theme' => 'monokai',
						'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
						'default' => "#header{\nmargin: 0 auto;\n}"
					),
					array(
						'id' => 'opt-ace-editor-js',
						'type' => 'ace_editor',
						'title' => __( 'JS Code', 'redux-framework-demo' ),
						'subtitle' => __( 'Paste your JS code here.', 'redux-framework-demo' ),
						'mode' => 'javascript',
						'theme' => 'chrome',
						'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
						'default' => "jQuery(document).ready(function(){\n\n});"
					),
					array(
						'id' => 'opt-ace-editor-php',
						'type' => 'ace_editor',
						'title' => __( 'PHP Code', 'redux-framework-demo' ),
						'subtitle' => __( 'Paste your PHP code here.', 'redux-framework-demo' ),
						'mode' => 'php',
						'theme' => 'chrome',
						'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
						'default' => '<?php\nisset ( $redux ) ? true : false;\n?>'
					),
				)
			);

			// License Settings
			$this->sections[] = array(
				'title' => __( 'Social Links', 'redux-framework-demo' ),
				'icon' => 'el-icon-bullhorn',
				'fields' => array(
					array(
						'id' => 'social_links',
						'type' => 'sortable',
						'title' => __( 'Social Links', 'redux-framework-demo' ),
						'subtitle' => __( 'Add your social link urls', 'redux-framework-demo' ),
						'desc' => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
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
				'title' => __( 'License', 'redux-framework-demo' ),
				'icon' => 'el-icon-key',
				'fields' => array(
				)
			);

			// Plugins Settings
//			$this->sections[] = array(
//				'title' => __( 'Plugins', 'redux-framework-demo' ),
//				'icon' => 'el-icon-cogs',
//				'fields' => array(
//				)
//			);
			// Support Settings
//			$this->sections[] = array(
//				'title' => __( 'Support', 'redux-framework-demo' ),
//				'icon' => 'el-icon-envelope',
//				'fields' => array(
//				)
//			);
			// Theme Documentation
			if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
				$this->sections[ 'theme_docs' ] = array(
					'icon' => 'el-icon-list-alt',
					'title' => __( 'Documentation', 'redux-framework-demo' ),
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
				'title' => __( 'Import / Export', 'redux-framework-demo' ),
				'desc' => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'redux-framework-demo' ),
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
//				'title' => __( 'Theme Information', 'redux-framework-demo' ),
//				'desc' => __( '<p class="description">This is the Description. Again HTML is allowed</p>', 'redux-framework-demo' ),
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
					'title' => __( 'Documentation', 'redux-framework-demo' ),
					'content' => nl2br( file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) )
				);
			}
		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args[ 'help_tabs' ][] = array(
				'id' => 'redux-help-tab-1',
				'title' => __( 'Theme Information 1', 'redux-framework-demo' ),
				'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
			);

			$this->args[ 'help_tabs' ][] = array(
				'id' => 'redux-help-tab-2',
				'title' => __( 'Theme Information 2', 'redux-framework-demo' ),
				'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
			);

			// Set the help sidebar
			$this->args[ 'help_sidebar' ] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
		}

		/**

		  All the possible arguments for Redux.
		  For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 * */
		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name' => 'rtp_settings', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name' => $theme->get( 'Name' ), // Name that appears at the top of your panel
				'display_version' => $theme->get( 'Version' ), // Version that appears at the top of your panel
				'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu' => true, // Show the sections below the admin menu item or not
				'menu_title' => __( 'rtPanel Options', 'redux-framework-demo' ),
				'page_title' => __( 'rtPanel Options', 'redux-framework-demo' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key' => '', // Must be defined to add google fonts to the typography module
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
				'url' => 'https://github.com/ReduxFramework/ReduxFramework',
				'title' => 'Visit us on GitHub',
				'icon' => 'el-icon-github'
					//'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
			);
			$this->args[ 'share_icons' ][] = array(
				'url' => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
				'title' => 'Like us on Facebook',
				'icon' => 'el-icon-facebook'
			);
			$this->args[ 'share_icons' ][] = array(
				'url' => 'http://twitter.com/reduxframework',
				'title' => 'Follow us on Twitter',
				'icon' => 'el-icon-twitter'
			);
			$this->args[ 'share_icons' ][] = array(
				'url' => 'http://www.linkedin.com/company/redux-framework',
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
				$this->args[ 'intro_text' ] = sprintf( __( '<p>To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
			} else {
				$this->args[ 'intro_text' ] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo' );
			}

			// Add content after the form.
			$this->args[ 'footer_text' ] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo' );
		}

	}

	global $reduxConfig;
	$reduxConfig = new rtpanel_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if ( ! function_exists( 'rtpanel_my_custom_field' ) ):

	function rtpanel_my_custom_field( $field, $value ) {
		print_r( $field );
		echo '<br/>';
		print_r( $value );
	}

endif;

/**
  Custom function for the callback validation referenced above
 * */
if ( ! function_exists( 'rtpanel_validate_callback_function' ) ):

	function rtpanel_validate_callback_function( $field, $value, $existing_value ) {
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