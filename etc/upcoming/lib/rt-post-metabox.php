<?php

/*
 * Support for post-meta box - Nice interface to otherwise plain and boring custom fields
 */

/* * ********************************************************************
 * Custom form to select stylesheet in post-edior's sidebar
 * -will provide dropdown interface to manipulate a custom-field value for posts/pages
 * -will be used in header.php on is_singular() tag
 * ******************************************************************** */

/*
 * COMMENT out following line if you want to have postmeta support in your theme
 */
return;

/*
 * include necessaru JavaScript
 */
wp_enqueue_script('custom', RTP_TEMPLATE_URL . '/js/rt-post-meta.js', array('jquery'), '', true);

/*
 * SIDEBAR Postmetabox support in post-editor
 */

/* Define the custom box */
add_action('add_meta_boxes', 'rt_postmeta_side_form');

/* Do something with the data entered */
add_action('save_post', 'rt_postmeta_side_form_handler');

/* SIDEBAR META FORM - Adds a box to the main column on the Post and Page edit screens */
function rt_postmeta_side_form() {
    //this will add a meta box in sidebar for "posts"
    add_meta_box('rt_postmeta_side', "Custom Field with UI",
            'rt_postmeta_side_form_body', 'post', 'side', 'high');

    //this will add a meta box in sidebar for "pages"
    add_meta_box('rt_postmeta_side', "Custom Field with UI",
            'rt_postmeta_side_form_body', 'page', 'side', 'high');
}

/* Prints the SIDEBAR box content */

function rt_postmeta_side_form_body() {
    global $post;

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'rt_postmeta_side_form');

    // The actual fields for data entry
    echo '<label for="rt_postmeta_side">This is a custom field</label> ';
    echo '<input type="text" id= "rt_postmeta_side" name="rt_postmeta_side" value="' . get_post_meta($post->ID, '_rt_postmeta_side', true) . '" size="25" />';
}

/* For SIDEBAR metabox - When the post is saved, saves our custom data */
function rt_postmeta_side_form_handler($post_id) {
//    global $post;
    //added by @rahul286
    if (!isset($_POST['rt_postmeta_side_form'])) {
        return;
    }

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (!wp_verify_nonce($_POST['rt_postmeta_side_form'], plugin_basename(__FILE__))) {
        return $post_id;
    }

    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
    // to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;


    // Check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id))
            return $post_id;
    }

    // OK, we're authenticated: we need to find and save the data
    //DO NOT EDIT ANYTHING ABOVE THIS LINE (unless working on custom-post type)
    
    update_post_meta($post_id, "_rt_postmeta_side", $_POST['rt_postmeta_side']);   //underscrore at the start in "_rt_postmeta_side" will keep this field hidden
    //if we are altering any $post attribute we should return it
    return $post_id;
}

/*
 * MAIN Postmetabox support in post-editor
 */

/* Define the custom box */
add_action('add_meta_boxes', 'rt_postmeta_main_form');

/* Do something with the data entered */
add_action('save_post', 'rt_postmeta_main_form_handler');

/* SIDEBAR MAIN FORM - Adds a box to the main column on the Post and Page edit screens */
function rt_postmeta_main_form() {
    //this will add a meta box below content-editor for "posts"
    add_meta_box('rt_postmeta_main', "Custom Field with UI",
            'rt_postmeta_main_form_body', 'post', 'normal', 'high');

    //this will add a meta box below content-editor for "posts"
    add_meta_box('rt_postmeta_main', "Custom Field with UI",
            'rt_postmeta_main_form_body', 'page', 'normal', 'high');
}

/* Prints the MAIN box content */

function rt_postmeta_main_form_body() {
    global $post;

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'rt_postmeta_main_form');

    /* The actual fields for data entry */
    //Check for old data

    $rt_fieldset = unserialize(get_post_meta($post->ID, '_rt_postmeta_fields', true));

    if(empty($rt_fieldset)){
        echo '<fieldset>'
                .'<legend>Set of fields</legend>'
                .'<label for="rt_postmeta_field[0][title]">Enter title</label> '
                .'<input type="text" name="rt_postmeta_field[0][title]" value="" size="25" />'
                .'<label for="rt_postmeta_field[0][description]">Enter description</label> '
                .'<textarea name="rt_postmeta_field[0][description]"></textarea>'
//                .'<label for="rt_postmeta_field[0][pic]">Upload Photo</label> '
//                .'<input type="file" name="rt_postmeta_field[0][pic]"/>'
            .'</fieldset>';
    }else{
        $i = 0;
        foreach ($rt_fieldset as $rt_fields) {
            echo '<fieldset>'
                .'<legend>Set of fields</legend>'
                .'<label for="rt_postmeta_field['.$i.'][title]">Enter title</label> '
                .'<input type="text" name="rt_postmeta_field['.$i.'][title]" value="'.$rt_fields['title'].'" size="25" />'
                .'<label for="rt_postmeta_field['.$i.'][description]">Enter description</label> '
                .'<textarea name="rt_postmeta_field['.$i.'][description]">'.$rt_fields['description'].'</textarea>'
//                .'<label for="rt_postmeta_field['.$i.'][pic]">Upload Photo</label> '
//                .'<input type="file" name="rt_postmeta_field[0][pic]"/>'
//                .'old val = ' . $rt_fields['pic']
            .'</fieldset>';
            $i++;//inc
            }
    }
}

/* For MAIN metabox - When the post is saved, saves our custom data */
function rt_postmeta_main_form_handler($post_id) {
    //added by @rahul286
    error_log("in main form handler");
    if (!isset($_POST['rt_postmeta_main_form'])) {
        return;
    }

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (!wp_verify_nonce($_POST['rt_postmeta_main_form'], plugin_basename(__FILE__))) {
        return $post_id;
    }

    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
    // to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;


    // Check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id))
            return $post_id;
    }

    // OK, we're authenticated: we need to find and save the data
    //DO NOT EDIT ANYTHING ABOVE THIS LINE (unless working on custom-post type)
//    var_dump($_POST['rt_postmeta_field']);
//    var_dump($_FILES);
//    exit;
    update_post_meta($post_id, "_rt_postmeta_fields", serialize($_POST['rt_postmeta_field']));   //underscrore at the start in "_rt_postmeta_side" will keep this field hidden
    //if we are altering any $post attribute we should return it
    return $post_id;
}
?>