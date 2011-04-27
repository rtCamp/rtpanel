<?php
/*
 *  Custom Post Code.
 *
 */

add_action('init', 'rt_custom_post_register');

function rt_custom_post_register() {
    $labels = array(
        'name' => 'Job Openings',
        'singular_name' => 'Job Opening',
        'add_new' => 'Add Job Opening',
        'add_new_item' => 'Add New Job Opening',
        'edit_item' => 'Edit Job Opening',
        'new_item' => 'New Job Openings',
        'view_item' => 'View Job Openings',
        'search_items' => 'Search Job Openings',
        'not_found' =>  'Nothing found',
        'not_found_in_trash' => 'Nothing found in Trash',
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 20,
        'menu_icon' => get_stylesheet_directory_uri() . '/img/job-openings.png',
        'description' => 'Custom post type for Job Openings',
        'supports' => array('title','editor','author','excerpt','thumbnail','custom-fields'),
//                'taxonomies' => array('category', 'post_tag')
    );

    register_post_type( 'job-openings' , $args );
}
?>