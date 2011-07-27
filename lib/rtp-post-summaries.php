<?php
/**
 * The template containing functions related to Post Summaries
 *
 * @package rtPanel
 * @since rtPanel 2.0
 */


/**
 * Replaces [...] from the excerpt
 *
 * @param string $text
 * @return string
 * 
 * @since rtPanel 2.0
 */
function rtp_no_ellipsis( $text ) {
    global $post, $rtp_post_comments;
    $read_text =  ( !empty($rtp_post_comments['read_text'] ) ) ? $rtp_post_comments['read_text'] : '';
    $text = str_replace( '[...]', '&hellip;', $text );
    $text .= apply_filters( 'rtp_readmore', ( ( $read_text ) ? '<a class="rtp-readmore" title="' . sprintf( __( 'Read More On %s', 'rtPanel' ), get_the_title() ) . '" href="' . get_permalink( $post->ID ) . '" rel="nofollow">' . esc_attr( $read_text ) . '</a>' : '' ));
    return $text;
}
add_filter( 'the_excerpt', 'rtp_no_ellipsis' );

/**
 * Remove inline styles printed when the gallery shortcode is used
 *
 * @return string The gallery style filter, with the styles themselves removed.
 *
 * @since rtPanel 2.0
 */
function rtp_remove_gallery_css( $css ) {
    return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'rtp_remove_gallery_css' );

/**
 * Changes the excerpt default length
 *
 * @uses $rtp_post_comments array
 * @param int $length length
 * @return int
 *
 * @since rtPanel 2.0
 */
function rtp_new_excerpt_length($length) {
    global $rtp_post_comments;
    if ( !empty( $rtp_post_comments['word_limit'] ) ) {
        if ( preg_match( '/^[0-9]{1,3}$/i', $rtp_post_comments['word_limit'] ) )
	return $rtp_post_comments['word_limit'];
    } else {
        return 55;
    }
}
add_filter( 'excerpt_length', 'rtp_new_excerpt_length' );

// Nofollow external links only

/**
 * Callback to rt_nofollow()
 *
 * @param array $matches
 * @return string
 *
 * @since rtPanel 2.0
 */
function rt_nofollow_callback( $matches ) {
    $link = $matches[0];
    $site_link = get_bloginfo( 'url' );
    if ( strpos( $link, 'rel' ) === false ) {
        $link = preg_replace( "%(href=\S(?!$site_link))%i", 'rel="nofollow" $1', $link );
    } elseif ( preg_match( "%href=\S(?!$site_link)%i", $link ) ) {
        $link = preg_replace( '/rel=\S(?!nofollow)\S*/i', 'rel="nofollow"', $link );
    }
    return $link;
}

/**
 * Sets 'nofollow' to external links
 *
 * @param string $content
 * @return mixed
 *
 * @since rtPanel 2.0
 */
function rt_nofollow( $content ) {
    return preg_replace_callback( '/<a[^>]+/', 'rt_nofollow_callback', $content );
}
add_filter( 'the_content', 'rt_nofollow' );
add_filter( 'the_excerpt', 'rt_nofollow' );

/**
 * Displays Attachment Image Thumbnail
 *
 * @since rtPanel 2.0
 */
function rtp_show_post_thumbnail() {
    global $rtp_post_comments;
    if ( !is_singular() && $rtp_post_comments['summary_show'] && $rtp_post_comments['thumbnail_show'] ) {
        $thumbnail_frame = ( $rtp_post_comments['thumbnail_frame'] ) ? ' thumbnail-shadow' : '';
        if ( has_post_thumbnail() ) { ?>
            <span class="post-img<?php echo '-' . strtolower( $rtp_post_comments['thumbnail_position'] ); ?>">
                    <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'post_thumb'.$thumbnail_frame  ) ); ?></a>
            </span><?php
        } else {
            $image = rtp_generate_thumbs();
            $image = ( $image ) ? $image : apply_filters( 'rtp_default_image_path', '' );
            if ( $image ) { ?>
                <span class="post-img<?php echo '-' . strtolower( $rtp_post_comments['thumbnail_position'] ); ?>">
                    <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><img class="post-thumb<?php echo $thumbnail_frame; ?> wp-post-image" alt="<?php echo get_the_title(); ?>" src="<?php echo ( $image ) ? $image : apply_filters( 'rtp_default_image_path', '' ) ; ?>" /></a>
                </span><?php
            }
        }
    }
}

/**
 * Returns required thumbnail 'src' value
 *
 * IMPORTANT : To be used alongwith add_image_size( $name, $width = 0, $height = 0, $crop = FALSE )
 * incase being used for images other than content thumbnail
 *
 * @param int $attach_id The id of the featured image
 * @param string $size The image size required as output ( Must be registered using
 * add_image_size or should use WordPress defaults like thumbnail, medium, large or full )
 * @param int $the_id The current post should be passed if function is used outside the loop
 * @return string
 *
 * @since rtPanel 2.0
 */

function rtp_generate_thumbs( $attach_id = null, $size = 'thumbnail', $the_id = '' ) {

    // $the_id should be set if called outside the loop else global $post
    if ( $the_id != '' ) {
        $post = get_post( $the_id );
    } else {
        global $post;
    }

    // If featured image is set return the required src
    if ( $attach_id ) {
        $image_src = wp_get_attachment_image_src( $attach_id, $size );
        return $image_src[0] ;
    } elseif ( preg_match( '/<img\s.*?src="(.*?)".*?>/is', $post->post_content, $match ) ) {

       /* If the image is inserted into the post through media library
        * Catch the attachment's id from the first img tag's wp-image class
        */
        if ( preg_match( '/wp-image-([\d]*)/i', $match[0], $thumb_id ) ) {
            $image_src = wp_get_attachment_image_src( $thumb_id[1] , $size );

            //check if the id has parents for sanity (To check if the thumbnail id is proper)
            $attachment_parents = get_post_ancestors( $thumb_id[1] );
            //initialise the variable for further processing
            $proceed = 0;
            if( is_array( $attachment_parents ) ) {
                foreach ( $attachment_parents as $parent ) {
                    if ( $parent == $post->ID ) {
                        $proceed = 1;
                    }
                }
            } elseif ( $attachment_parents == $post->ID ) {
                $proceed = 1;
            } else {
                $proceed = 0;
            }

            // if proceed = 0 then download the img src and update the post content accordingly
            if( @!$proceed ) {
                $updated_post = array();
                $updated_post['ID'] = $post->ID;
                //remove the misleading wp-image class from img tag and update the current post
                $updated_image_tag = str_replace( $thumb_id[0], '', $match[0] );
                $updated_post['post_content'] = str_replace($match[0], $updated_image_tag, $post->post_content );
                wp_update_post( $updated_post );
                // trying to manage the replace and creation of image incase wordpress doesn't fetch url
                $double_check_tag = $match[0];
                unset($match[0]);
                $match[0] = $updated_image_tag;
                return rtp_create_external_thumb($match, $post, $size, $double_check_tag);
            }
            // if proceed = 1 then just return the img src
            return $image_src[0];

        } else {
            //if the img src does not contain wp-image class then need to download and create thumb
            return rtp_create_external_thumb($match, $post, $size);
        }
    }
}

/**
 * Used to download and create image from src and attach to library
 *
 * @param array $match Array in which [0]->whole img tag and [1]->the img src
 * @param object|array $post The global post variable or object from get_posts()
 * @param string $size The image size required
 * @param array $double_check_tag Used to take care of the misleading wp-image class
 * @return string
 *
 * @since rtPanel 2.0
 */
function rtp_create_external_thumb( $match, $post, $size, $double_check_tag = '' ) {
            $img_path = urldecode( $match[1] );
            // Need to do this else image fetching will fail
            $remote_get_path = str_replace( ' ', '%20', $img_path);

            // Get the img name from url
            $img_name = basename($img_path);

            // Set permissions if directory is not writable
            $upload_path = wp_upload_dir();
            if ( !is_writable( $upload_path['basedir'] ) || !is_executable( $upload_path['basedir'] ) ) {
                    $stat = @stat( dirname( $upload_path['basedir'] ) );
                    // Get the permission bits.
                    $dir_perms = $stat['mode'] & 0007777;
                    @chmod( $upload_path['basedir'], $dir_perms );
                }

                // For sanitization of name (just a precaution, although wp_upload_bits will try to take care of this)
                $img_name = str_replace( '&', '-', $img_name );
                $img_name = str_replace( '?', '-', $img_name );

                $allowed_image_types = array( 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'ico', 'tif', 'tiff' );

                $check_extension = pathinfo($img_name);
                //if not in the array assign a particular name
                if (!in_array($check_extension['extension'], $allowed_image_types)) {
                    $img_name = 'query-image.jpg';
                }

            // get placeholder file in the upload dir with a unique, sanitized filename
            $file = wp_upload_bits( $img_name, 0, '');

            // fetch the remote url and write it to the placeholder file
            $wp_remote_get = wp_get_http( $remote_get_path, $file['file'], 5);
             if ( $wp_remote_get == '' || $wp_remote_get == false ) {
                 @unlink( $file['file'] );
                 return 0;
             }

            //if response id is 200 and it's type is image
            if ( $wp_remote_get['response'] == 200 && substr( $wp_remote_get['content-type'], 0, 5 ) == 'image' ) {

                //created img path
                $img_path = $file['file'];

                //created img url
                $img_url = $file['url'];

                // Get the image type. Must to use it as a post thumbnail.
                $img_type = wp_check_filetype( $file['file'] );
                extract( $img_type );

                $img_info = apply_filters( 'wp_handle_upload', array( 'file' => $img_path, 'url' => $img_url, 'type' => $type ), 'sideload' );

                require_once( ABSPATH . '/wp-admin/includes/image.php' );

                // use image exif/iptc data for title and caption defaults if possible
                if ( $img_meta = @wp_read_image_metadata( $img_info['file'] ) ) {
                    if ( trim( $img_meta['title'] ) && ! is_numeric( sanitize_title( $img_meta['title'] ) ) ) {
                        $img_title = $img_meta['title'];
                    }
                    if ( trim( $img_meta['caption'] ) ) {
                        $img_content = $img_meta['caption'];
                    }
                }

                $img_title = isset ( $img_title ) ? $img_title : str_replace( '.' . $ext, '', basename( $img_url ) );
                $img_content = isset ( $img_content ) ? $img_content : str_replace( '.' . $ext, '', basename( $img_url ) );

                // Construct the attachment array
                $attachment = array(
                    'post_mime_type' => $img_info['type'],
                    'guid' => $img_url,
                    'post_parent' => $post->ID,
                    'post_title' => $img_title,
                    'post_content' => $img_content,
                );

                // Save the attachment metadata
                $new_image_id = wp_insert_attachment( $attachment, $img_info['file'], $post->ID );

                if ( !is_wp_error( $new_image_id ) && ( $new_image_id != 0 ) && ( $new_image_id != '' ) ) {
                    wp_update_attachment_metadata( $new_image_id, wp_generate_attachment_metadata( $new_image_id, $img_info['file'] ) );
                    $updated_post = array();
                    $updated_post['ID'] = $post->ID;
                    if ( is_int( $new_image_id ) ) {
                        $image_src = wp_get_attachment_image_src( $new_image_id, $size );
                            //get the img tag classes
                            preg_match('/<img.*class\s*=\s*"([^"]*)[^>]+>/i', $match[0], $class);
                            //if the image tag has class attribute and it does not have wp-image in class
                            if( isset( $class[1] ) ) {
                                $updated_class = $class[1].' wp-image-'.$new_image_id;
                                $updated_image_tag = str_replace('class="'.$class[1].'"', 'class="'.$updated_class.'"', $match[0]);
                                $updated_post['post_content'] = str_replace( $match[0], $updated_image_tag, $post->post_content );
                                if ( $double_check_tag != '' ) {
                                $updated_post['post_content'] = str_replace( $double_check_tag, $updated_image_tag, $post->post_content );
                                }
                                // Update the post into the database
                                wp_update_post( $updated_post );
                            }  else {
                                $updated_image_tag = str_replace( '<img', '<img class="wp-image-'.$new_image_id.'"', $match[0] );
                                $updated_post['post_content'] = str_replace( $match[0], $updated_image_tag, $post->post_content );
                                // Update the post into the database
                                wp_update_post( $updated_post );
                            }
                        return $image_src[0];
                    } else {
                        $updated_post = array();
                        $updated_post['ID'] = $post->ID;
                        $new_image_id = rtp_get_attachment_id_from_src( $new_image_id );
                        $image_src = wp_get_attachment_image_src( $new_image_id, $size );
                        preg_match( '/<img.*class\s*=\s*"([^"]*)[^>]+>/i', $match[0], $class );
                            if( isset( $class[1] ) ) {
                                $updated_class = $class[1].' wp-image-'.$new_image_id;
                                $updated_image_tag = str_replace( 'class="'.$class[1].'"', 'class="'.$updated_class.'"', $match[0] );
                                $updated_post['post_content'] = str_replace( $match[0], $updated_image_tag, $post->post_content );
                                if ( $double_check_tag != '' ) {
                                $updated_post['post_content'] = str_replace( $double_check_tag, $updated_image_tag, $post->post_content );
                                }
                                // Update the post into the database
                                wp_update_post( $updated_post );
                            } else {
                                $updated_image_tag = str_replace( '<img', '<img class="wp-image-' . $new_image_id . '"', $match[0] );
                                $updated_post['post_content'] = str_replace( $match[0], $updated_image_tag, $post->post_content );
                                // Update the post into the database
                                wp_update_post( $updated_post );
                            }
                        return $image_src[0];
                    }
                }
            } else {
                 @unlink( $file['file'] );
                 return 0;
            }
}

/**
 * Used to get the attachment id provided the src
 * @uses $wpdb object
 * @param string $image_src The Image Source
 * @return int
 *
 * @since rtPanel 2.0
 */
function rtp_get_attachment_id_from_src( $image_src ) {
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var( $query );
    return $id;
}