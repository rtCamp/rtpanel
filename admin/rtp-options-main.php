<?php

/**
 * Customize Titan Framework Options
 * 
 * @package rtPanel
 * @since rtPanel 1.2
 */
global $theme_colors;

$theme_colors = array(
    array(
        "#EF4A4A"
    ),
    array(
        "#16a085"
    ),
    array(
        "#2980b9"
    ),
    array(
        "#8e44ad"
    ),
    array(
        "#f39c12"
    ),
    array(
        "#5e6281"
    ),
    array(
        "#58a032"
    ),
    array(
        "#dd28b5"
    ),
);

$rtpanel_titan = rtp_get_titan_obj();

if ($rtpanel_titan) {

    /**
     * Create Admin Panel
     */
    $rtpanel_panel = $rtpanel_titan->createAdminPanel(
            array(
                'name' => __('rtPanel', 'rtPanel'),
                'icon' => 'dashicons-format-gallery',
                'position' => 59,
            )
    );

    /* Customization Section */
    rtp_customize_section_settings($rtpanel_titan, $theme_colors);

    /* General Settings Tab */
    rtp_general_option_settings($rtpanel_panel);

    /* Theme Setting Tab */
    //rtp_theme_setting_options($rtpanel_panel, $theme_colors);

    /* Typography Setting Tab */
    rtp_typography_option_settings($rtpanel_panel);

    /* Post and Comment Setting Tab */
    rtp_post_comment_option_settings($rtpanel_panel);

    /* Footer Setting Tab */
    rtp_footer_option_settings($rtpanel_panel);

    /* Custom Codes Setting Tab */
    rtp_code_option_settings($rtpanel_panel);

    /* Front page Setting Tab */
    //rtp_frontpage_option_settings($rtpanel_panel);

    /* Addtional Meta Options */
    rtp_metabox_option_settings($rtpanel_titan);
}