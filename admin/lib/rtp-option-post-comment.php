<?php

/*
 * Post and Comment option settings
 */

function rtp_post_comment_option_settings($rtpanel_panel) {

    /**
     * Create Post and Comment Settings Tab
     */
    $postCommentTab = $rtpanel_panel->createTab(
            array(
                'name' => __('Post &amp; Comments', 'rtPanel'),
                'title' => __('Post Summary Settings', 'rtPanel'),
                'id' => 'post_comments',
            )
    );

    /**
     * Create Post Summary Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Enable Post Summary', 'rtPanel'),
                'id' => 'summary_show',
                'type' => 'checkbox',
                'desc' => __('Check this to enable excerpts on Archive pages ( Pages with multiple posts on them )', 'rtPanel'),
                'default' => true,
            )
    );

    /**
     * Create Word Limit Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Word Limit', 'rtPanel'),
                'id' => 'word_limit',
                'type' => 'number',
                'default' => '55',
                'min' => 10,
                'max' => 200,
                'desc' => __('Post Content will be cut around Word Limit you will specify here.', 'rtPanel'),
            )
    );

    /**
     * Create Read More Text Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Read More Text', 'rtPanel'),
                'id' => 'read_text',
                'type' => 'text',
                'default' => __('Read More &rarr;', 'rtPanel'),
                'placeholder' => __('Read More Text', 'rtPanel'),
                'desc' => __('This will be added after each post summary. Text added here will be automatically converted into a hyperlink pointing to the respective post.', 'rtPanel'),
            )
    );

    /**
     * Create Post Thumbnail Heading
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Post Thumbnail Settings', 'rtPanel'),
                'type' => 'heading',
            )
    );

    /**
     * Create Enable/Disable Thumbnail Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Enable Thumbnails', 'rtPanel'),
                'id' => 'thumbnail_show',
                'type' => 'checkbox',
                'desc' => __('Check this to display thumbnails as part of Post Summaries on Archive pages', 'rtPanel'),
                'default' => true,
            )
    );

    /**
     * Create Thumbnail Alignment Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Thumbnail Alignment', 'rtPanel'),
                'id' => 'thumbnail_position',
                'options' => array(
                    'none' => __('None', 'rtPanel'),
                    'left' => __('Left', 'rtPanel'),
                    'center' => __('Center', 'rtPanel'),
                    'right' => __('Right', 'rtPanel'),
                ),
                'type' => 'radio',
                'desc' => __('Select the thumbnail alignment', 'rtPanel'),
                'default' => 'right',
            )
    );


    /**
     * Save Header Option Settings
     */
    $postCommentTab->createOption(array(
        'type' => 'save',
        'use_reset' => false
    ));

    /**
     * Create Post Meta Heading
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Post Meta Settings', 'rtPanel'),
                'type' => 'heading',
            )
    );

    /**
     * Create Show/Hide Post Date Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Show Post Date', 'rtPanel'),
                'id' => 'post_date',
                'type' => 'multicheck',
                'desc' => __('Check this box to include post dates in meta', 'rtPanel'),
                'options' => array(
                    'show' => __('<strong>Include Post Date in Meta</strong>', 'rtPanel'),
                    'above' => __('Above Post Content', 'rtPanel'),
                    'below' => __('Below Post Content', 'rtPanel'),
                ),
                'default' => array('show', 'above'),
            )
    );

    /**
     * Create Show/Hide Post Author Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Show Post Author', 'rtPanel'),
                'id' => 'post_author',
                'type' => 'multicheck',
                'desc' => __('Check this box to include author name in meta', 'rtPanel'),
                'options' => array(
                    'show' => __('<strong>Include Author Name in Meta</strong>', 'rtPanel'),
                    'above' => __('Above Post Content', 'rtPanel'),
                    'below' => __('Below Post Content', 'rtPanel'),
                ),
                'default' => array('show', 'above'),
            )
    );

    /**
     * Create Show/Hide Post Categories Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Show Post Categories', 'rtPanel'),
                'id' => 'post_category',
                'type' => 'multicheck',
                'desc' => __('Check this box to include post categories in meta', 'rtPanel'),
                'options' => array(
                    'show' => __('<strong>Include Post Categories in Meta</strong>', 'rtPanel'),
                    'above' => __('Above Post Content', 'rtPanel'),
                    'below' => __('Below Post Content', 'rtPanel'),
                ),
                'default' => array('show', 'above'),
            )
    );

    /**
     * Create Show/Hide Post Tags Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Show Post Tags', 'rtPanel'),
                'id' => 'post_tags',
                'type' => 'multicheck',
                'desc' => __('Check this box to include post tags in meta', 'rtPanel'),
                'options' => array(
                    'show' => __('<strong>Include Post Tags in Meta</strong>', 'rtPanel'),
                    'above' => __('Above Post Content', 'rtPanel'),
                    'below' => __('Below Post Content', 'rtPanel'),
                ),
                'default' => array('show', 'below'),
            )
    );

    /**
     * Create Pagination Heading
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Pagination Settings', 'rtPanel'),
                'type' => 'heading',
            )
    );

    /**
     * Create Show/Hide Pagination Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Enable Pagination', 'rtPanel'),
                'id' => 'pagination_show',
                'type' => 'checkbox',
                'desc' => __('Check this to enable default WordPress Pagination on Archive pages (Pages with multiple posts on them)', 'rtPanel'),
                'default' => true,
            )
    );

    /**
     * Create Pagination Previous Text Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Prev Text', 'rtPanel'),
                'id' => 'prev_text',
                'type' => 'text',
                'default' => __('&laquo; Previous', 'rtPanel'),
                'placeholder' => __('Previous Link Text', 'rtPanel'),
                'desc' => __('Text to display for Previous Page', 'rtPanel'),
            )
    );

    /**
     * Create Pagination Next Text Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Next Text', 'rtPanel'),
                'id' => 'next_text',
                'type' => 'text',
                'default' => __('Next &raquo;', 'rtPanel'),
                'placeholder' => __('Next Link Text', 'rtPanel'),
                'desc' => __('Text to display for Next Page', 'rtPanel'),
            )
    );

    /**
     * Create Pagination End Size Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('End Size', 'rtPanel'),
                'id' => 'end_size',
                'type' => 'number',
                'default' => '1',
                'min' => 1,
                'max' => 10,
                'desc' => __('How many numbers on either the start and the end list edges?', 'rtPanel'),
            )
    );

    /**
     * Create Pagination Mid Size Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Mid Size', 'rtPanel'),
                'id' => 'mid_size',
                'type' => 'number',
                'default' => '2',
                'min' => 1,
                'max' => 10,
                'desc' => __('How many numbers to either side of current page, but not including current page?', 'rtPanel'),
            )
    );

    /**
     * Create Comment Form Heading
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Comment Form Settings', 'rtPanel'),
                'type' => 'heading',
            )
    );

    /**
     * Create Enable/Disable Gravatar Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Enable Gravatar', 'rtPanel'),
                'id' => 'gravatar_show',
                'type' => 'checkbox',
                'desc' => __('Check this to display gravatar on comment template', 'rtPanel'),
                'default' => true,
            )
    );

    /**
     * Create Enable/Disable Compact Form Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Enable Compact Form', 'rtPanel'),
                'id' => 'enable_compact_form',
                'type' => 'multicheck',
                'options' => array(
                    'compact_form' => __('Check this box to compact comment form. Name, URL &amp; Email Fields will be on same line', 'rtPanel'),
                    'hide_labels' => __('Hide Labels for Name, Email &amp; URL. These will be shown inside fields as default text', 'rtPanel'),
                ),
                'default' => array('compact_form', 'hide_labels'),
            )
    );

    /**
     * Create Form Settings Option
     */
    $postCommentTab->createOption(
            array(
                'name' => __('Extra Form Settings', 'rtPanel'),
                'id' => 'extra_form_settings',
                'type' => 'multicheck',
                'options' => array(
                    'comment_textarea' => __('Display Comment textarea above Name, Email, &amp; URL Fields', 'rtPanel'),
                    'comment_separate' => __('Separate Comments from Trackbacks &amp; Pingbacks', 'rtPanel'),
                    'attachment_comments' => __('Enable the comment form on Attachments', 'rtPanel'),
                ),
                'default' => array('comment_separate'),
            )
    );

    /**
     * Save Post and Comment Settings
     */
    $postCommentTab->createOption(
            array(
                'type' => 'save',
            )
    );
}
