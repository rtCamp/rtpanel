<?php
/**
 * rtPanel default functions
 *
 * @package rtPanel
 *
 * @since rtPanel 2.0
 */

/**
 * Checks whether the post meta div needs to be displayed or not
 *
 * @uses $rtp_post_comments Post Comments DB array
 * @uses $post Post Data
 * @param string $position Specify the position of the post meta (u/l)
 *
 * @since rtPanel 2.1
 */
function rtp_has_postmeta ( $position = 'u' ) {
    global $post, $rtp_post_comments;
    $can_edit = ( get_edit_post_link () ) ? 1 : 0;
    $flag = 0;
    // Show Author?
    if ( $rtp_post_comments[ 'post_author_' . $position ] ) {
        $flag ++;
    }
    // Show Date?
    elseif ( $rtp_post_comments[ 'post_date_' . $position ] ) {
        $flag ++;
    }
    // Show Category?
    elseif ( get_the_category_list () && $rtp_post_comments[ 'post_category_' . $position ] ) {
        $flag ++;
    }
    // Show Tags?
    elseif ( get_the_tag_list () && $rtp_post_comments[ 'post_tags_' . $position ] ) {
        $flag ++;
    }
    // Checked if logged in and post meta top
    else if ( $can_edit && $position == 'u' ) {
        $flag ++;
    } elseif ( ( has_action ( 'rtp_hook_begin_post_meta_top' ) || ( has_action ( 'rtp_hook_end_post_meta_top' ) && $can_edit ) ) && $position == 'u' ) {
        $flag ++;
    } elseif ( ( has_action ( 'rtp_hook_begin_post_meta_bottom' ) || has_action ( 'rtp_hook_end_post_meta_bottom' ) ) && $position == 'l' ) {
        $flag ++;
    } else {
        // Show Custom Taxonomies?
        $args = array( '_builtin' => false );
        $taxonomies = get_taxonomies ( $args, 'names' );
        foreach ( $taxonomies as $taxonomy ) {
            if ( get_the_terms ( $post->ID, $taxonomy ) && isset ( $rtp_post_comments[ 'post_' . $taxonomy . '_' . $position ] ) && $rtp_post_comments[ 'post_' . $taxonomy . '_' . $position ] ) {
                $flag ++;
            }
        }
    }

    return $flag;
}

/**
 * Default post meta
 *
 * @uses $rtp_post_comments Post Comments DB array
 * @uses $post Post Data
 * @param string $placement Specify the position of the post meta (top/bottom)
 *
 * @since rtPanel 2.0
 */
function rtp_default_post_meta ( $placement = 'top' ) {

    if ( 'post' == get_post_type () && ! rtp_is_bbPress () ) {
        global $post, $rtp_post_comments;
        $position = ( 'bottom' == $placement ) ? 'l' : 'u'; // l = Lower/Bottom , u = Upper/Top

        if ( rtp_has_postmeta ( $position ) ) {
            if ( $position == 'l' ) {
                echo '<footer class="post-footer">';
            }
            ?>
            <div class="clearfix post-meta post-meta-<?php echo $placement; ?>"><?php
                if ( 'bottom' == $placement )
                    rtp_hook_begin_post_meta_bottom ();
                else
                    rtp_hook_begin_post_meta_top ();

                // Author Link
                if ( $rtp_post_comments[ 'post_author_' . $position ] || $rtp_post_comments[ 'post_date_' . $position ] ) {
                    
                    if ( $rtp_post_comments[ 'post_author_' . $position ] ) {
                        printf ( __ ( '<span class="">Posted by</span> <span class="author">%s</span>', 'rtPanel' ), ( ! $rtp_post_comments[ 'author_link_' . $position ] ? get_the_author () . ( $rtp_post_comments[ 'author_count_' . $position ] ? '(' . get_the_author_posts () . ')' : '' ) : sprintf ( __ ( '<a class="fn" href="%1$s" title="%2$s">%3$s</a>', 'rtPanel' ), get_author_posts_url ( get_the_author_meta ( 'ID' ), get_the_author_meta ( 'user_nicename' ) ), esc_attr ( sprintf ( __ ( 'Posts by %s', 'rtPanel' ), get_the_author () ) ), get_the_author () ) . ( $rtp_post_comments[ 'author_count_' . $position ] ? '(' . get_the_author_posts () . ')' : '' ) ) );
                    }
                    
                    echo ( $rtp_post_comments[ 'post_author_' . $position ] && $rtp_post_comments[ 'post_date_' . $position ] ) ? ' ' : '';
                    
                    if ( $rtp_post_comments[ 'post_date_' . $position ] ) {
                        printf ( __ ( 'on <time class="published" datetime="%s">%s</time>', 'rtPanel' ), get_the_date ( 'c' ), get_the_time ( $rtp_post_comments[ 'post_date_format_' . $position ] ) );
                    }
                    
                }

                // Post Categories
                echo ( get_the_category_list () && $rtp_post_comments[ 'post_category_' . $position ] ) ? '&nbsp;' . __ ( 'in', 'rtPanel' ) . '&nbsp;' . get_the_category_list ( ', ' ) . '' : '';

                // Post Tags
                echo ( get_the_tag_list () && $rtp_post_comments[ 'post_tags_' . $position ] ) ? '<p class="post-tags alignleft">' . get_the_tag_list ( __ ( 'Tagged', 'rtPanel' ) . ': <span>', ', ', '</span>' ) . '</p>' : '';

                // Post Custom Taxonomies
                $args = array( '_builtin' => false );
                $taxonomies = get_taxonomies ( $args, 'objects' );
                foreach ( $taxonomies as $key => $taxonomy ) {
                    ( get_the_terms ( $post->ID, $key ) && isset ( $rtp_post_comments[ 'post_' . $key . '_' . $position ] ) && $rtp_post_comments[ 'post_' . $key . '_' . $position ] ) ? the_terms ( $post->ID, $key, '<p class="post-custom-tax post-' . $key . '">' . $taxonomy->labels->singular_name . ': ', ', ', '</p>' ) : '';
                }
                
                if ( 'bottom' == $placement )
                    rtp_hook_end_post_meta_bottom ();
                else
                    rtp_hook_end_post_meta_top ();
                ?>

            </div><!-- .post-meta --><?php
            if ( $position == 'l' ) {
                echo '</footer>';
            }
        }
    } elseif ( ! rtp_is_bbPress () ) {
        if ( get_edit_post_link () && ( 'top' == $placement ) ) {
            ?>
            <div class="post-meta post-meta-top"><?php rtp_hook_end_post_meta_top (); ?></div><?php
        }
    }
}

add_action ( 'rtp_hook_post_meta_top', 'rtp_default_post_meta' ); // Post Meta Top
add_action ( 'rtp_hook_post_meta_bottom', 'rtp_default_post_meta' ); // Post Meta Bottom

/**
 * Default Navigation Menu
 *
 * @since rtPanel 2.0
 */
function rtp_default_nav_menu () {
    $admin_bar_class_fix = '';
    if ( is_admin_bar_showing () ) {
        $admin_bar_class_fix = " rtp-pading-topbar";
    }

    echo '<div class="rtp-nav-container' . $admin_bar_class_fix . '"><nav id="rtp-primary-menu" role="navigation" class="top-bar' . apply_filters ( 'rtp_mobile_nav_support', ' rtpa-mobile-nav' ) . '">'; ?>
    <ul class="title-area">
        <li class="name">
            <h1><a role="link" href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo bloginfo ( 'name' ); ?></a></h1>
        </li>

        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
    </ul><?php
    echo '<section class="top-bar-section">';
    /* Call wp_nav_menu() for Wordpress Navigaton with fallback wp_list_pages() if menu not set in admin panel */
    if ( function_exists ( 'wp_nav_menu' ) && has_nav_menu ( 'primary' ) ) {
        add_filter ( "wp_nav_menu_items", "filter_wp_nav_menu_items", 1, 2 );
        wp_nav_menu ( array( 'container' => '', 'menu_id' => 'rtp-nav-menu', 'theme_location' => 'primary', 'depth' => apply_filters ( 'rtp_nav_menu_depth', 4 ) ) );
    } else {
        echo '<ul class="left" id="rtp-nav-menu">';
        wp_list_pages ( array( 'title_li' => '', 'sort_column' => 'menu_order', 'number' => '5', 'depth' => apply_filters ( 'rtp_nav_menu_depth', 4 ) ) );
        echo '</ul>';
    }
    echo '</section></nav></div>';
}

add_action ( 'rtp_hook_after_header', 'rtp_default_nav_menu' ); // Adds default nav menu after #header

function filter_wp_nav_menu_items ( $items, $args ) {
    $items = str_replace ( "\"sub-menu\"", "\"sub-menu dropdown\"", $items );
    $strItems = explode ( "<li", $items );
    $items = "";
    foreach ( $strItems as $item ) {
        if ( trim ( $item ) == "" ) {
            continue;
        }
        if ( strpos ( $item, "sub-menu" ) !== false ) {
            $item = str_replace ( "\"menu-item ", "\"menu-item  has-dropdown ", $item );
        }
        $items.= "<li " . $item;
    }
    return $items;
}

/**
 * 'Edit' link for post/page
 *
 * @since rtPanel 2.0
 */
function rtp_edit_link () {
    // Call Edit Link
    edit_post_link ( __ ( '[ edit ]', 'rtPanel' ), '<p class="rtp-edit-link left">', '&nbsp;</p>' );
}

add_action ( 'rtp_hook_begin_post_meta_top', 'rtp_edit_link' );

/**
 * Adds breadcrumb support to the theme.
 *
 * @since rtPanel 2.0.7
 */
function rtp_breadcrumb_support ( $text ) {
    // Breadcrumb Support
    if ( function_exists ( 'bcn_display' ) ) {
        echo '<div class="breadcrumb">';
        bcn_display ();
        echo '</div>';
    }
}

add_action ( 'rtp_hook_begin_content', 'rtp_breadcrumb_support' );

/**
 * Adds Site Description
 *
 * @since rtPanel 2.0.7
 */
function rtp_blog_description () {
    if ( get_bloginfo ( 'description' ) ) {
        ?>
        <h3 class="tagline subheader"><?php bloginfo ( 'description' ); ?></h3><?php
    }
}

add_action ( 'rtp_hook_after_logo', 'rtp_blog_description' );

/**
 * Adds pagination to single
 *
 * @since rtPanel 2.1
 */
function rtp_default_single_pagination () {
    if ( is_single () && ( get_adjacent_post ( '', '', true ) || get_adjacent_post ( '', '', false ) ) ) {
        ?>
        <div class="rtp-navigation clearfix">
        <?php if ( get_adjacent_post ( '', '', true ) ) { ?><div class="left"><?php previous_post_link ( '%link', __ ( '&larr; %title', 'rtPanel' ) ); ?></div><?php } ?>
        <?php if ( get_adjacent_post ( '', '', false ) ) { ?><div class="right"><?php next_post_link ( '%link', __ ( '%title &rarr;', 'rtPanel' ) ); ?></div><?php } ?>
        </div><!-- .rtp-navigation --><?php
    }
}

add_action ( 'rtp_hook_single_pagination', 'rtp_default_single_pagination' );

/**
 * Adds pagination to archives
 *
 * @since rtPanel 2.1
 */
function rtp_default_archive_pagination () {
    /* Page-Navi Plugin Support with WordPress Default Pagination */
    if ( ! rtp_is_bbPress () ) {
        if ( ! is_singular () ) {
            global $wp_query, $rtp_post_comments;
            if ( isset ( $rtp_post_comments[ 'pagination_show' ] ) && $rtp_post_comments[ 'pagination_show' ] ) {
                if ( ( $wp_query->max_num_pages > 1 ) ) {
                    ?>
                    <nav class="wp-pagenavi"><?php
                    echo paginate_links ( array(
                        'base' => str_replace ( 999999999, '%#%', esc_url ( get_pagenum_link ( 999999999 ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max ( 1, get_query_var ( 'paged' ) ),
                        'total' => $wp_query->max_num_pages,
                        'prev_text' => esc_attr ( $rtp_post_comments[ 'prev_text' ] ),
                        'next_text' => esc_attr ( $rtp_post_comments[ 'next_text' ] ),
                        'end_size' => $rtp_post_comments[ 'end_size' ],
                        'mid_size' => $rtp_post_comments[ 'mid_size' ],
                        'type' => 'list'
                    ) );
                    ?>
                    </nav>
                    <?php
                }
            } elseif ( function_exists ( 'wp_pagenavi' ) ) {
                wp_pagenavi ();
            } elseif ( get_next_posts_link () || get_previous_posts_link () ) {
                ?>
                <nav class="rtp-navigation clearfix">
                <?php if ( get_next_posts_link () ) { ?><div class="left"><?php next_posts_link ( __ ( '&larr; Older Entries', 'rtPanel' ) ); ?></div><?php } ?>
                <?php if ( get_previous_posts_link () ) { ?><div class="right"><?php previous_posts_link ( __ ( 'Newer Entries &rarr;', 'rtPanel' ) ); ?></div><?php } ?>
                </nav><!-- .rtp-navigation --><?php
            }
        }
    }
}

add_action ( 'rtp_hook_archive_pagination', 'rtp_default_archive_pagination' );

/**
 * Displays the sidebar.
 *
 * @since rtPanel 2.1
 */
function rtp_default_sidebar () {
    get_sidebar ();
}

add_action ( 'rtp_hook_sidebar', 'rtp_default_sidebar' );

/**
 * Displays the comments and comment form.
 *
 * @since rtPanel 2.1
 */
function rtp_default_comments () {
    if ( is_singular () ) {
        comments_template ( '', true );
    }
}

add_action ( 'rtp_hook_comments', 'rtp_default_comments' );

/**
 * Outputs the comment count linked to the comments of the particular post/page
 *
 * @since rtPanel 2.1
 */
function rtp_default_comment_count () {
    global $rtp_post_comments;
    // Comment Count
    add_filter ( 'get_comments_number', 'rtp_only_comment_count', 11, 2 );
    if ( ( ( get_comments_number () || @comments_open () ) && ! is_attachment () && ! rtp_is_bbPress () ) || ( is_attachment () && $rtp_post_comments[ 'attachment_comments' ] ) ) { // If post meta is set to top then only display the comment count.
        ?>
        <p class="alignright rtp-post-comment-count"><span class="rtp-curly-bracket">{</span><?php comments_popup_link ( _x ( '<span>0</span> Comments', 'comments number', 'rtPanel' ), _x ( '<span>1</span> Comment', 'comments number', 'rtPanel' ), _x ( '<span>%</span> Comments', 'comments number', 'rtPanel' ), 'rtp-post-comment rtp-common-link' ); ?><span class="rtp-curly-bracket">}</span></p><?php
    }
    remove_filter ( 'get_comments_number', 'rtp_only_comment_count', 11, 2 );
}

add_action ( 'rtp_hook_end_post_title', 'rtp_default_comment_count' );

/**
 * Get the sidebar ID for current page.
 *
 * @since rtPanel 3.1
 */
function rtp_get_sidebar_id () {
    global $rtp_general;
    $sidebar_id = "sidebar-widgets";

    if ( function_exists ( 'bp_current_component' ) && bp_current_component () ) {

        if ( $rtp_general[ 'buddypress_sidebar' ] === "buddypress-sidebar" ) {
            $sidebar_id = "buddypress-sidebar-widgets";
        } else if ( $rtp_general[ 'buddypress_sidebar' ] === "no-sidebar" ) {
            $sidebar_id = 0;
        }
    } else if ( function_exists ( 'is_bbpress' ) && is_bbpress () ) {

        if ( $rtp_general[ 'bbpress_sidebar' ] === "bbpress-sidebar" ) {
            $sidebar_id = "bbpress-sidebar-widgets";
        } else if ( $rtp_general[ 'bbpress_sidebar' ] === "no-sidebar" ) {
            $sidebar_id = 0;
        }
    }
    return $sidebar_id;
}

/**
 * Adds custom css through theme options
 *
 * @since rtPanel 3.2
 */
function rtp_custom_css () {
    global $rtp_general;
    echo ( $rtp_general[ 'custom_styles' ] ) ? '<style>' . $rtp_general[ 'custom_styles' ] . '</style>' . "\r\n" : '';
}

add_action ( 'rtp_head', 'rtp_custom_css' );

/**
 * Galary Shorcode hijack with foundation
 *
 * @since rtPanel 3.2
 */
function rtp_galary_shorcode ( $output, $attr ) {
    $post = get_post ();
    static $instance = 0;
    $instance ++;
    if ( isset ( $attr[ 'orderby' ] ) ) {
        $attr[ 'orderby' ] = sanitize_sql_orderby ( $attr[ 'orderby' ] );
        if ( ! $attr[ 'orderby' ] )
            unset ( $attr[ 'orderby' ] );
    }
    extract ( shortcode_atts ( array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'li',
        'icontag' => '',
        'captiontag' => '',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
                    ), $attr ) );

    $id = intval ( $id );
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( ! empty ( $include ) ) {
        $_attachments = get_posts ( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

        $attachments = array( );
        foreach ( $_attachments as $key => $val ) {
            $attachments[ $val->ID ] = $_attachments[ $key ];
        }
    } elseif ( ! empty ( $exclude ) ) {
        $attachments = get_children ( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
    } else {
        $attachments = get_children ( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
    }

    if ( empty ( $attachments ) )
        return '';

    if ( is_feed () ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link ( $att_id, $size, true ) . "\n";
        return $output;
    }

    $itemtag = tag_escape ( $itemtag );
    $captiontag = tag_escape ( $captiontag );
    $icontag = tag_escape ( $icontag );
    $valid_tags = wp_kses_allowed_html ( 'post' );
    if ( ! isset ( $valid_tags[ $itemtag ] ) )
        $itemtag = 'li';
    if ( ! isset ( $valid_tags[ $captiontag ] ) )
        $captiontag = '';
    if ( ! isset ( $valid_tags[ $icontag ] ) )
        $icontag = '';

    $columns = intval ( $columns );
    $itemwidth = $columns > 0 ? floor ( 100 / $columns ) : 100;
    $float = is_rtl () ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';

    $size_class = sanitize_html_class ( $size );
    $gallery_div = "<ul id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} large-block-grid-{$columns} gallery-size-{$size_class} clearing-thumbs' data-clearing>";
    $output = apply_filters ( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

    foreach ( $attachments as $id => $attachment ) {
        $url = wp_get_attachment_image_src ( $id, "full" );
        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "<a href='" . $url[ 0 ] . "'>" . wp_get_attachment_image ( $id, 'thumbnail', false, array( "data-caption" => trim ( $attachment->post_excerpt ) ) ) . "</a>";
        $output .= "</{$itemtag}>";
    }

    $output .= "</ul>\n";
    return $output;
}

add_filter ( "post_gallery", "rtp_galary_shorcode", 1, 2 );

/**
 * Foundation Orbit Slider Funtion
 *
 * @param WP_Query $slider_q
 * @param type $slide_number
 * @param type $content_length
 * @param type $show_title
 * @param type $show_excerpt
 * @param type $show_navigation
 * @param type $show_pagination
 */
function rtp_orbit_slider ( WP_Query $slider_q = null, $slide_number = 100, $content_length = 200, $show_title = true, $show_excerpt = true, $show_navigation = true, $show_pagination = true ) {
    if ( $slider_q == null ) {
        $slider_q = new WP_Query ( array( 'ignore_sticky_posts' => 1, 'posts_per_page' => $slide_number, 'order' => 'DESC' ) );
    }

    if ( $slider_q->have_posts () ) {
        $slider_image = '';
        $slider_pagination = false;
        $slider_html = '<div class="rtp-orbit-slider-row"><ul data-orbit id="rtp-orbit-slider" data-options="timer_speed:2500; bullets:false;">';


        while ( $slider_q->have_posts () ) {
            $slider_q->the_post ();
            $image_details = wp_get_attachment_image_src ( get_post_thumbnail_id (), "full" );
            if ( $image_details ) {
                $slider_image = $image_details[ 0 ];
            } else {
                $slider_image = false;
            }

            if ( $slider_image ) {
                $slider_html .= '<li>';
                $slider_html .= '<img  src ="' . $slider_image . '" alt="' . esc_attr ( get_the_title () ) . '" data-interchange="' . rtp_img_attachement_interchange_string ( get_post_thumbnail_id (), "full", "full", "large" ) . '"/>';
                if ( $show_excerpt ) {
                    $slider_html .= "<div class='orbit-caption'>";
                    $slider_html .= ( strlen ( get_the_content () ) > $content_length ) ? wp_html_excerpt ( get_the_content (), $content_length ) . '... ' : wp_html_excerpt ( get_the_content (), $content_length );
                    $slider_html .="</div>";
                }

                $slider_html .= '</li>';
                $slider_pagination = true;
            }
        }

        $slider_html .= '</ul></div>';
        if ( $slider_pagination )
            echo $slider_html;
    }
    wp_reset_postdata ();
}

function rtp_call_slider () {
    if ( is_home () ) {
        $slider_q = new WP_Query ( array( "post_parent" => 1722, "post_status" => "inherit", "post_type" => "any", 'post_mime_type' => 'image' ) );
        rtp_orbit_slider ( $slider_q );
    }
}

add_action ( "rtp_hook_begin_content_wrapper", "rtp_call_slider", 1, 0 );

/**
 *
 * @param type $ID
 * @param type $large
 * @param type $medium
 * @param type $small
 * @param type $custom = array({"path"=> '', "query"=> ''},{} ..) <br />
 *      <table border=1>

  <tr>
  <th>Name</th>
  <th>Media Query</th>
  </tr>


  <tr>
  <td>default</td>
  <td><code>only screen and (min-width: 1px)</code></td>
  </tr>
  <tr>
  <td>small</td>
  <td><code>only screen and (min-width: 768px)</code></td>
  </tr>
  <tr>
  <td>medium</td>
  <td><code>only screen and (min-width: 1280px)</code></td>
  </tr>
  <tr>
  <td>large</td>
  <td><code>only screen and (min-width: 1440px)</code></td>
  </tr>
  <tr>
  <td>landscape</td>
  <td><code>only screen and (orientation: landscape)</code></td>
  </tr>
  <tr>
  <td>portrait</td>
  <td><code>only screen and (orientation: portrait)</code></td>
  </tr>
  <tr>
  <td>retina <small>(4.2.1)</small></td>
  <td><code>only screen and (-webkit-min-device-pixel-ratio: 2),<br>
  only screen and (min--moz-device-pixel-ratio: 2),<br>
  only screen and (-o-min-device-pixel-ratio: 2/1),<br>
  only screen and (min-device-pixel-ratio: 2),<br>
  only screen and (min-resolution: 192dpi),<br>
  only screen and (min-resolution: 2dppx)</code>
  </td>
  </tr>
  </table>
 * @return string
 */
function rtp_img_attachement_interchange_string ( $ID, $large = false, $medium = false, $small = false, $custom = array( ) ) {
    $str = "";
    $sep = "";
    $img = wp_get_attachment_image_src ( $ID, "small" );
    if ( $img ) {
        $str .= $sep . "[" . $img[ 0 ] . ",(default)]";
        $sep = ",";
    }
    if ( $small ) {
        $img = wp_get_attachment_image_src ( $ID, $small );
        if ( $img ) {
            $str .= $sep . "[" . $img[ 0 ] . ",(small)]";
            $sep = ",";
        }
    }
    if ( $medium ) {
        $img = wp_get_attachment_image_src ( $ID, $medium );
        if ( $img ) {
            $str .= $sep . "[" . $img[ 0 ] . ",(medium)]";
            $sep = ",";
        }
    }
    if ( $large ) {
        $img = wp_get_attachment_image_src ( $ID, $large );
        if ( $img ) {
            $str .= $sep . "[" . $img[ 0 ] . ",(large)]";
            $sep = ",";
        }
    }
    foreach ( $custom as $sz ) {
        $str .= $sep . "[" . $sz[ "path" ] . ",(" . $sz[ "query" ] . ")]";
        $sep = ",";
    }
    return $str;
}
