=== rtPanel ===
Theme Name: rtPanel
Theme URI: http://rtcamp.com/rtpanel/
Description: WordPress theme framework with Custom Menu, Header and Background along with Logo, Favicon, Featured Image, Google Custom Search Integration and more options. Now includes a Foundation 5 framework, Grunt Task Runner, Bower package manager, SAAS based CSS preprocessor and translation support. This theme comes with free technical support by team of 30+ full-time developers. Support Links: <a href="http://rtcamp.com/support/forum/rtpanel/" title="rtPanel Free Support" rel="follow">rtPanel Support forum</a>, <a href="http://rtcamp.com/rtpanel/docs/" title="rtPanel Documentation" rel="follow">Documentation</a> or visit <a href="http://rtcamp.com/rtpanel/" title="rtPanel" rel="follow">rtPanel</a>.
Version: 4.2
Author: rtCamp
Author URI: http://rtcamp.com/
Contributors: rtCampers ( http://rtcamp.com/about/rtcampers/ )
License: GNU General Public License, v2 (or newer)
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: black, blue, white, orange, light, one-column, two-columns, right-sidebar, custom-header, custom-background, custom-menu, editor-style, theme-options, threaded-comments, sticky-post, translation-ready, responsive-layout, full-width-template, buddypress

== Description ==
rtPanel is the most easy to use WordPress Theme Framework. You will find many state of the art options and widgets with rtPanel.
rtPanel framework is used worldwide and keeping this in mind we have made it localization ready. Developers can use rtPanel as a basic and stripped to bones theme framework for developing their own creative and wonderful WordPress Themes.
By using rtPanel, developers and users can specify settings for basic functions (like date format, excerpt word count etc.) directly from theme options. rtPanel provides theme options to manage some basic settings for your theme. 

== Plugins Supported ==
* bbPress - http://wordpress.org/plugins/bbpress/

* BuddyPress - http://wordpress.org/plugins/buddypress/

* Contact Form 7 - http://wordpress.org/plugins/contact-form-7/

* Gravity Forms - http://www.gravityforms.com/

* Jetpack by WordPress.com - http://wordpress.org/plugins/jetpack/

* Ninja Forms - http://wordpress.org/plugins/ninja-forms/

* Regenerate Thumbnails - http://wordpress.org/plugins/regenerate-thumbnails/

* rtMedia - http://wordpress.org/plugins/buddypress-media/

* rtPanel Hooks Editor - http://wordpress.org/plugins/rtpanel-hooks-editor/

* rtSocial - http://wordpress.org/plugins/rtsocial/

* rtWidgets - http://wordpress.org/plugins/rtwidgets/

* Subscribe To Comments Reloaded - http://wordpress.org/plugins/subscribe-to-comments-reloaded/

* WooCommerce - excelling eCommerce - http://wordpress.org/plugins/woocommerce/

* WordPress SEO by Yoast - http://wordpress.org/plugins/wordpress-seo/

* Yet Another Related Posts Plugin (YARPP) - http://wordpress.org/plugins/yet-another-related-posts-plugin/

== Important Note ==
If you make changes to thumbnail height, width or crop settings, you must use "Regenerate Thumbnail Plugin" ( http://wordpress.org/plugins/regenerate-thumbnails/ ) to regenerate thumbnails on old posts.

== Changelog ==

= 4.2 =
* Modified: Update Foundation version to 5.2.1
* Modified: PHP Coding Standards
* Modified: Plugin Styles
* Resolved: UI Issues Fixed

= 4.1.5 =
* Resolved: Facebook JavaScript SDK issue

= 4.1.4 =
* Added: Added two new hooks
* Modified: Update Foundation 5.0 to 5.0.3
* Modified: rtMedia, BuddyPress, bbPress and other supported plugin CSS
* Resolved: Fixed the esc_attr bugs

= 4.1.3 =
* Modified: rtMedia, BuddyPress and other supported plugin CSS
* Resolved: Navigation issue

= 4.1.2 =
* Added: Jetpack plugin support
* Modified: Escape all instances of home_url()
* Resolved: rtMedia, BuddyPress and Contact Form issues

= 4.1.1 =
* Modified: <title> tag in header.php
* Modified: Default theme logo, used sample logo

= 4.1 =
* Modified: Favicon disabled by default
* Removed: Hook after wp_head() and wp_footer()

= 4.0.1 =
* Modified: CSS Classes
* Resolved: Minor Bugs

= 4.0 =
* Added: Foundation 5 Framework, Grunt Task Runner, Bower Package Manager
* Added: Support for WooCommerce,  rtMedia, BuddyPress, bbPress, Gravity Form, Ninja Form Plugins
* Modified: rtPanel theme options, UI and CSS Classes
* Resolved: Minor Bugs
* Removed: Fallback for older version of WordPress
* Removed: rtPanel default widgets

= 3.2 =
* Added: Sprite support through Sass/Compass
* Added: rtp_head hook
* Modified: Custom CSS hooked onto rtp_head

= 3.1 =
* Added: bbPress Support
* Added: BuddyPress Support

= 3.0 =
* Added: Sass/Compass CSS Prepocessor
* Modified: Styles and CSS Classes
* Resolved: Minor Bugs

= 2.2.3 =
* Added: Google Custom Search Element Version 2 Support
* Modified: Styles and Markup

= 2.2.2 =
* Added: Deprecated functions fallback

= 2.2.1 =
* Resolved: rtp_general default value issue

= 2.2 =
* Added: rtSocial to plugins support
* Resolved: Image Upload functionality for Logo and Favicon ( Markup Changed in WordPress 3.4 )
* Resolved: Unattached Image issue on image template
* Resolved: Empty Open Graph Description by default
* Resolved: Removed function declarations out of document.ready for re-usability
* Resolved: Protected Post functionality ( Changed in WP 3.4+ )
* Resolved: Validation of Plugins Support Section
* Resolved: next_text validation
* Resolved: Upgrade Theme Notice and Version Issues
* Modified: Logo & Favicon Upload Options
* Modified: Subscribe Widget
* Modified: Comments with Gravatar Widget
* Removed: Removed Screen Layout Option
* Removed: bbPress styles ( Default bbPress styles will be served instead )
* Removed: Editor styles ( style.css of theme will be served instead )
* Removed: Removed WP-PageNavi and BreadCrumb NavXT from plugin support list

= 2.1.1 =
* Resolved: Warnings after WordPress 3.4 Update

= 2.1 =
* Added: HTML5
* Added: CSS3
* Added: Responsive Design
* Added: bbPress Support
* Added: 960 Grid Support
* Added: Default WordPress Pagination
* Added: Option to disable comments on attachments
* Added: Attachment Image Template
* Added: Option to disable favicon
* Added: rtPanel.pot
* Added: rtp_hook_begin_body and rtp_hook_end_body hooks
* Added: rtp_hook_begin_main_wrapper and rtp_hook_end_main_wrapper hooks
* Added: Viewport Hook ( rtp_viewport )
* Added: Open Graph Meta Hooks
* Added: Sidebar Hook
* Added: Comment Hook
* Added: Post and Archive Pagination hooks.
* Added: Edit link for pages and custom posts
* Added: rtPanel Hooks Editor to Plugin Support
* Resolved: Post Meta empty div and Naming.
* Resolved: Regenerate Thumbnails Notification
* Resolved: Search layout Class Bug
* Resolved: rtPanel Subscribe Widget Subscription Handle Issue
* Resolved: Comment Count and Comment Open Issue
* Modified: rtPanel Contextual Help
* Modified: reply class to rtp-reply as it conflicts with bbPress
* Modified: Editor Stylesheet
* Removed: IE6 Support
* Removed: JS support for onfoucs onblur on text and textarea fields ( Using HTML5 placeholder instead )