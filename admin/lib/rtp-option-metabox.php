<?php

/*
 * Code option settings
 */

function rtp_metabox_option_settings($rtpanel_titan) {

    /**
     * Create Metabox
     */
    $metabox = $rtpanel_titan->createMetaBox(
            array(
                'name' => 'Additional Options',
                'post_type' => array('testimonial'),
            )
    );

    /**
     * Create Google Analytics Option
     */
    $metabox->createOption(
            array(
                'name' => __('Author Designation', 'rtPanel'),
                'id' => 'rtp_testimonial_author_designaion',
                'type' => 'text',
            )
    );
}