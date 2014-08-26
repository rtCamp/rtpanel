<?php

/*
 * Theme Setting Options
 */

function rtp_theme_setting_options($rtpanel_panel, $theme_colors) {

    /* Top Menu Options */
    $rtp_show_hide_components = array(
        'rtp_search' => __('Search', 'rtPanel'),
        'rtp_friends' => __('Friends', 'rtPanel'),
        'rtp_notifications' => __('Notifications', 'rtPanel'),
        'rtp_messages' => __('Messages', 'rtPanel'),
        'rtp_member_match' => __('Member Match Form', 'rtPanel'),
        'rtp_frontend_tool' => __('Front-End Tool', 'rtPanel'),
    );

    /**
     * Create Color Palette Setting Tab
     */
    $themeSettings = $rtpanel_panel->createTab(array(
        'name' => __('Theme Settings', 'rtPanel'),
        'id' => 'colors',
    ));

    /**
     * Create Color Palette Option
     */
    $themeSettings->createOption(array(
        'name' => 'Select a Layout',
        'id' => 'rtp_layout',
        'type' => 'radio-image',
        'options' => array(
            'rtp-full-width-layout' => get_template_directory_uri() . '/images/radio2.png',
            'rtp-box-layout' => get_template_directory_uri() . '/images/radio1.png',
        ),
        'default' => 'rtp-box-layout'
    ));

    /**
     * Create Color Palette Option
     */
    $themeSettings->createOption(array(
        'name' => __('Color Palette', 'rtPanel'),
        'id' => 'rtp_color_palette_option',
        'type' => 'radio-palette',
        'options' => apply_filters('rtp_color_palette', $theme_colors),
        'default' => 0,
    ));

    /**
     * Create Top-Menu Show/Hide Option
     */
    $themeSettings->createOption(array(
        'name' => __('Show/Hide Components', 'rtPanel'),
        'id' => 'rtp_show_hide_component',
        'type' => 'multicheck',
        'desc' => __('<span class="rtp-margin-bottom-20">You can uncheck a box bellow to hide that component.</span>', 'rtPanel'),
        'default' => array('rtp_search', 'rtp_friends', 'rtp_notifications', 'rtp_messages', 'rtp_member_match', 'rtp_frontend_tool'),
        'options' => apply_filters('rtp_rtp_show_hide_components', $rtp_show_hide_components),
    ));

    /**
     * Save Style Settings
     */
    $themeSettings->createOption(array(
        'type' => 'save',
    ));
}
