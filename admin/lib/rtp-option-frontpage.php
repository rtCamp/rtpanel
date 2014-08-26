<?php

/*
 * Front page option settings
 */

function rtp_frontpage_option_settings($rtpanel_panel) {

    /**
     * Create Front Page Tab
     */
    $frontPage = $rtpanel_panel->createTab(
            array(
                'name' => __('Front Page', 'rtPanel'),
                'id' => 'front_page',
                'title' => 'Slider Options',
            )
    );

    /**
     * Create Slider Heading
     */
    $frontPage->createOption(
            array(
                'name' => __('Slider', 'rtPanel'),
                'type' => 'heading',
            )
    );

    /* Slider Images */
    for ($x = 1; $x <= 4; $x++) {
        $frontPage->createOption(array(
            'name' => 'Slide Image ' . $x,
            'id' => 'slider_img_' . $x,
            'type' => 'upload',
        ));
    }

    /**
     * Save Settings
     */
    $frontPage->createOption(
            array(
                'type' => 'save',
                'use_reset' => FALSE,
            )
    );

    /**
     * Create Heading
     */
    $frontPage->createOption(
            array(
                'name' => __('Welcome Info', 'rtPanel'),
                'type' => 'heading',
            )
    );

    /**
     * Create Option
     */
    $frontPage->createOption(
            array(
                'name' => __('Welcome Title', 'rtPanel'),
                'id' => 'rtp_welcome_title',
                'type' => 'text',
                'default' => __('Welcome To rtPanel', 'rtPanel'),
            )
    );

    /**
     * Create Option
     */
    $frontPage->createOption(
            array(
                'name' => __('Welcome Content', 'rtPanel'),
                'id' => 'rtp_welcome_content',
                'type' => 'editor',
                'rows' => 3,
                'media_buttons' => false,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'rtPanel'),
            )
    );

    /* Feature Content */
    for ($x = 1; $x <= 3; $x++) {
        $frontPage->createOption(array(
            'name' => 'Feature Info ' . $x,
            'id' => 'feature_img_' . $x,
            'type' => 'upload',
            'desc' => __('Image size should not more than 200px', 'rtPanel'),
        ));

        $frontPage->createOption(array(
            'name' => 'Feature Content ' . $x,
            'id' => 'feature_content_' . $x,
            'type' => 'editor',
            'rows' => 3,
            'media_buttons' => false,
            'default' => '<h4>1 MILLION</h4><p>MEMBERS IN TOTAL</p>'
        ));
    }

    /**
     * Create Heading
     */
    $frontPage->createOption(
            array(
                'name' => __('Stories', 'rtPanel'),
                'type' => 'heading',
            )
    );

    /**
     * Create Option
     */
    $frontPage->createOption(
            array(
                'name' => __('Stories Title', 'rtPanel'),
                'id' => 'rtp_stories_title',
                'type' => 'text',
                'default' => __('Stories Title', 'rtPanel'),
            )
    );

    $frontPage->createOption(
            array(
                'name' => 'Stories Category',
                'id' => 'rtp_stories',
                'type' => 'select-categories',
                'desc' => 'This is an option'
            )
    );

    /**
     * Save Custom Code Settings
     */
    $frontPage->createOption(
            array(
                'type' => 'save',
            )
    );
}
