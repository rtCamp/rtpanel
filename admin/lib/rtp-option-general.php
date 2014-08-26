<?php

/*
 * General option settings
 */

function rtp_general_option_settings($rtpanel_panel) {

    /**
     * Create General Settings Tab
     */
    $generalTab = $rtpanel_panel->createTab(
            array(
                'name' => __('General', 'rtPanel'),
                'title' => __('Logo and Favicon Settings', 'rtPanel'),
                'id' => 'general',
            )
    );

    /**
     * Create Site Logo Option
     */
    $generalTab->createOption(
            array(
                'name' => __('Site Logo Settings', 'rtPanel'),
                'id' => 'logo_settings',
                'options' => array(
                    'site_title' => __('Use Site Title', 'rtPanel'),
                    'image' => __('Upload Logo', 'rtPanel'),
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
                'name' => __('Logo Upload', 'rtPanel'),
                'id' => 'logo_upload',
                'type' => 'upload',
                'desc' => __('Upload Logo Here', 'rtPanel'),
            )
    );

    /**
     * Create Logo on WordPress Login Option
     */
    $generalTab->createOption(
            array(
                'name' => __('Logo on WordPress login', 'rtPanel'),
                'id' => 'login_head',
                'type' => 'checkbox',
                'desc' => sprintf(__('Check this box to display logo on <a href="%s" title="Wordpress Login">WordPress Login Screen</a>', 'rtPanel'), site_url('/wp-login.php')),
                'default' => false,
            )
    );

    /**
     * Create Site Favicon Options
     */
    $generalTab->createOption(
            array(
                'name' => __('Site Favicon Settings', 'rtPanel'),
                'id' => 'favicon_settings',
                'options' => array(
                    'disable' => __('Disable', 'rtPanel'),
                    'image' => __('Upload Favicon', 'rtPanel'),
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
                'name' => __('Favicon Upload', 'rtPanel'),
                'id' => 'favicon_upload',
                'type' => 'upload',
                'desc' => __('Upload Favicon Here', 'rtPanel'),
            )
    );

    /**
     * BuddyPress and bbPress sidebar settings.
     */
    if (rtp_is_plugin_active('buddypress/bp-loader.php') || rtp_is_plugin_active('bbpress/bbpress.php')) {

        /**
         * Create BuddyPress and bbPress Sidebar Heading
         */
        $generalTab->createOption(
                array(
                    'name' => __('Sidebar Settings', 'rtPanel'),
                    'type' => 'heading',
                )
        );

        /**
         * Create BuddyPress Sidebar Option
         */
        if (rtp_is_plugin_active('buddypress/bp-loader.php')) {
            $generalTab->createOption(
                    array(
                        'name' => __('BuddyPress Sidebar', 'rtPanel'),
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
        if (rtp_is_plugin_active('bbpress/bbpress.php')) {
            $generalTab->createOption(
                    array(
                        'name' => __('bbPress Sidebar', 'rtPanel'),
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
}