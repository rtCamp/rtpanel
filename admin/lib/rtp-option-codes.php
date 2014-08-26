<?php

/*
 * Code option settings
 */

function rtp_code_option_settings($rtpanel_panel) {

    /**
     * Create Custom Codes Options Tab
     */
    $codeTab = $rtpanel_panel->createTab(
            array(
                'name' => __('Custom Codes', 'rtPanel'),
                'id' => 'custom_codes',
                'title' => 'Google Analytics Code',
            )
    );

    /**
     * Create Google Analytics Option
     */
    $codeTab->createOption(
            array(
                'name' => __('Google Analytics Code', 'rtPanel'),
                'id' => 'google_analytics',
                'type' => 'code',
                'desc' => __('Add Google Analytics Code here', 'rtPanel'),
                'lang' => 'html',
            )
    );

    /**
     * Create Custom Code Heading
     */
    $codeTab->createOption(
            array(
                'name' => __('Custom CSS and JavaScript', 'rtPanel'),
                'type' => 'heading',
            )
    );

    /**
     * Create Custom CSS Option
     */
    $codeTab->createOption(
            array(
                'name' => __('CSS', 'rtPanel'),
                'id' => 'backend_custom_css',
                'type' => 'code',
                'desc' => __('Put your custom CSS rules here', 'rtPanel'),
                'lang' => 'css',
            )
    );

    /**
     * Create Custom JavaScript Option
     */
    $codeTab->createOption(
            array(
                'name' => __('JavaScript', 'rtPanel'),
                'id' => 'backend_custom_js',
                'type' => 'code',
                'desc' => __('Put your custom JavaScript code here', 'rtPanel'),
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
}