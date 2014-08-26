<?php

/*
 * Footer option settings
 */

function rtp_footer_option_settings($rtpanel_panel) {

    /**
     * Create Footer Options Tab
     */
    $footerTab = $rtpanel_panel->createTab(
            array(
                'name' => __('Footer Options', 'rtPanel'),
                'id' => 'footer',
            )
    );

    /**
     * Create Enable/Disable Footer Sidebar Option
     */
    $footerTab->createOption(
            array(
                'name' => __('Enable Footer Sidebar', 'rtPanel'),
                'id' => 'footer_sidebar',
                'type' => 'checkbox',
                'desc' => __('Check this to enable footer sidebar', 'rtPanel'),
                'default' => true,
            )
    );

    /**
     * Create Footer Navigation
     */
    $footerTab->createOption(
            array(
                'name' => __('Footer Navigation', 'rtPanel'),
                'id' => 'footer_navigation',
                'type' => 'checkbox',
                'desc' => __('Show Footer Navigation', 'rtPanel'),
                'default' => true,
            )
    );

    /**
     * Create Footer Information Option
     */
    $footerTab->createOption(
            array(
                'name' => __('Footer Information', 'rtPanel'),
                'id' => 'footer_info',
                'type' => 'editor',
                'rows' => 3,
                'media_buttons' => false,
                'default' => __('Copyright &copy; 2014 rtCamp.', 'rtPanel'),
            )
    );

    /**
     * Create Powered By rtPanel Text Option
     */
    $footerTab->createOption(
            array(
                'name' => __('Powered by rtPanel', 'rtPanel'),
                'id' => 'powered_by',
                'type' => 'checkbox',
                'desc' => __('Show "Powered by rtCamp" link in footer using my affiliate ID', 'rtPanel'),
                'default' => true,
            )
    );

    /**
     * Create Affiliate ID Option
     */
    $footerTab->createOption(
            array(
                'name' => __('Affiliate ID', 'rtPanel'),
                'id' => 'affiliate_ID',
                'type' => 'text',
                'desc' => sprintf(__('You can use your rtCamp.com username as affiliate ID or get it from <a href="%s" target="_blank">here</a><br />To know more about our affiliate program, please check - <a href="%s" target="_blank">%s</a>', 'rtPanel'), 'https://rtcamp.com/wp-admin/admin.php?page=rt-affiliate-banners', 'https://rtcamp.com/affiliates', 'https://rtcamp.com/affiliates'),
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
}
