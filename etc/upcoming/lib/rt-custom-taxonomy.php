<?php
add_action( 'init', 'rt_create_taxonomies_for_job', 0 );

function rt_create_taxonomies_for_job() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Job Types', 'taxonomy general name' ),
    'singular_name' => _x( 'Job Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Job Types' ),
    'all_items' => __( 'All Job Types' ),
    'parent_item' => __( 'Parent Job Type' ),
    'parent_item_colon' => __( 'Parent Job Type:' ),
    'edit_item' => __( 'Edit Job Type' ),
    'update_item' => __( 'Update Job Type' ),
    'add_new_item' => __( 'Add New Job Type' ),
    'new_item_name' => __( 'New Job Type Name' ),
    'menu_name' => __( 'Job Type' ),
  );

  register_taxonomy('job-type',array('job-openings'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'job-type' ),
  ));

  // Add new taxonomy, make it non-hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Skills', 'taxonomy general name' ),
    'singular_name' => _x( 'Skill', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Skills' ),
    'all_items' => __( 'All Skills' ),
    'parent_item' => __( 'Parent Skill' ),
    'parent_item_colon' => __( 'Parent Skill:' ),
    'edit_item' => __( 'Edit Skill' ),
    'update_item' => __( 'Update Skill' ),
    'add_new_item' => __( 'Add New Skill' ),
    'new_item_name' => __( 'New Skill Name' ),
    'menu_name' => __( 'Skill' ),
  );

  register_taxonomy('skill',array('job-openings'), array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'skill' ),
  ));
}

add_filter("manage_edit-job-openings_columns", "prod_edit_columns");
add_action("manage_posts_custom_column",  "prod_custom_columns");

function prod_edit_columns($columns){
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Title",
        "author" => "Author",
        "job-type" => "Job Type",
        "skill" => "Skill",
        "date" => "Date",
    );

    return $columns;
}

function prod_custom_columns($column){
    global $post;
    switch ($column) {
        case "job-type":
            echo get_the_term_list($post->ID, 'job-type', '', ', ','');
            break;
        case "skill":
            echo get_the_term_list($post->ID, 'skill', '', ', ','');
            break;
        case 'author':
            echo get_post_author($post->ID );
            break;
        case 'date':
            echo get_post_modified_time($d);
            break;
    }
}
