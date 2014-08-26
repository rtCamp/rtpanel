<?php

/*
 * Customize section settings
 */

function rtp_customize_section_settings($rtpanel_titan, $theme_colors) {
    /**
     * Create Theme Customizer Section
     */
    $customize_section = $rtpanel_titan->createThemeCustomizerSection(
            array(
                'name' => __('Theme Option', 'rtPanel'),
            )
    );

    /**
     * Setup Color Palette Option in Customizer
     */
    $customize_section->createOption(array(
        'name' => __('Color Palette', 'rtPanel'),
        'id' => 'palette_option_customize',
        'type' => 'radio-palette',
        'options' => apply_filters('rtpanel_color_palette', $theme_colors),
        'default' => 0,
    ));
}