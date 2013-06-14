<?php
/**
 * Functions related to Post Summaries
 *
 * @package rtPanel
 * 
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
    $alignment = ' right';
    if ( $rtp_post_comments['summary_show'] && $rtp_post_comments['thumbnail_show'] && ( 'Right' == $rtp_post_comments['thumbnail_position'] ) ) {
       $alignment = ' left';
    }
    $read_text =  ( !empty($rtp_post_comments['read_text'] ) ) ? $rtp_post_comments['read_text'] : '';
    $text = str_replace( '[...]', '&hellip;', $text );
    $text .= !is_attachment() ? apply_filters( 'rtp_readmore', ( ( $read_text ) ? '<a role="link" class="rtp-readmore" title="' . sprintf( __( 'Read more on %s', 'rtPanel' ), get_the_title() ) . '" href="' . get_permalink( $post->ID ) . '" rel="nofollow">' . esc_attr( $read_text ) . '</a>' : '' )) : '';
    return $text;
}
add_filter( 'the_excerpt', 'rtp_no_ellipsis' );

/**
 * Remove inline styles printed when the gallery shortcode is used
 *
 * @return string The gallery style filter, with the styles themselves removed
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

/**
 * Displays Attachment Image Thumbnail
 *
 * @since rtPanel 2.0
 */
function rtp_show_post_thumbnail( $post_id = null, $thumbnail_size = 'thumbnail', $default_img_path = '' ) {
    global $rtp_post_comments;
    if ( !is_singular() && $rtp_post_comments['summary_show'] && $rtp_post_comments['thumbnail_show'] && !rtp_is_bbPress() ) {
        $thumbnail_frame = ( $rtp_post_comments['thumbnail_frame'] ) ? 'rtp-thumbnail-shadow' : 'rtp-no-thumbnail-shadow';
        $image_align =  strtolower( $rtp_post_comments['thumbnail_position'] ); 
        if ( has_post_thumbnail() ) {
            echo '<figure class="rtp-thumbnail-container ' . $image_align . ' ' . $thumbnail_frame . '">'; ?>
                <a role="link" class="<?php echo $image_align; ?>" href="<?php echo get_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( $thumbnail_size, array( 'title' => the_title_attribute( array( 'echo' => false ) ), 'class' => 'post-thumb ' . $image_align ) ); ?></a><?php
            echo '</figure>';
        } else {            
            $image = apply_filters( 'rtp_default_image_path', $default_img_path );
            if ( isset($image) && !empty($image) ) {
                $image_id = rtp_get_attachment_id_from_src( $image, true );
                $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true) ? get_post_meta( $image_id, '_wp_attachment_image_alt', true) : 'Image';
                echo '<figure class="rtp-thumbnail-container ' . $image_align . ' ' . $thumbnail_frame . '">'; ?>
                <a role="link" class="<?php echo $image_align; ?>" href="<?php echo get_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img role="img" class="<?php echo 'post-thumb ' . $image_align; ?> wp-post-image" title="<?php the_title_attribute(); ?>" alt="<?php echo $alt; ?>" <?php echo rtp_get_image_dimensions( $image ); ?> src="<?php echo $image; ?>" /></a><?php
                echo '</figure>';
        }
    }
}
}

/**
 * Used to download and create image from 'src' and attach to media library
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
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php' );
    require_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php' );
    @$file_object = new WP_Filesystem_Direct;
    $img_path = urldecode( $match[1] );

    // Need to do this else image fetching will fail
    $remote_get_path = str_replace( ' ', '%20', $img_path);

    // Get the img name from url
    $img_name = basename($img_path);

    /* Set permissions if directory is not writable */
    $upload_path = wp_upload_dir();
    if ( !is_writable( $upload_path['basedir'] ) || !is_executable( $upload_path['basedir'] ) ) {
        $stat = @stat( dirname( $upload_path['basedir'] ) );

        // Get the permission bits
        $dir_perms = $stat['mode'] & 0007777;

        @chmod( $upload_path['basedir'], $dir_perms );
    }

    /* For sanitization of name (just a precaution, although wp_upload_bits will try to take care of this) */
    $img_name = str_replace( '&', '-', $img_name );
    $img_name = str_replace( '?', '-', $img_name );

    $allowed_image_types = array( 'jpg', 'jpeg', 'jpe', 'gif', 'png', 'bmp', 'ico', 'tif', 'tiff' );

    $check_extension = pathinfo($img_name);

    // if not in the array assign a particular name
    if ( !in_array( $check_extension['extension'], $allowed_image_types ) ) {
        $img_name = 'query-image.jpg';
    }

    // get placeholder file in the upload dir with a unique, sanitized filename
    $file = wp_upload_bits( $img_name, 0, '');

    // fetch the remote url and write it to the placeholder file
    $wp_remote_get = wp_get_http( $remote_get_path, $file['file'], 5 );
     if ( $wp_remote_get == '' || $wp_remote_get == false ) {
         $file_object->delete( $file['file'] );
         return 0;
     }

    /* if response id is 200 and it's type is image */
    if ( $wp_remote_get['response'] == 200 && substr( $wp_remote_get['content-type'], 0, 5 ) == 'image' ) {

        //created img path
        $img_path = $file['file'];

        //created img url
        $img_url = $file['url'];

        // Get the image type. Must to use it as a post thumbnail.
        $img_type = wp_check_filetype( $img_path );
        extract( $img_type );

        $img_info = apply_filters( 'wp_handle_upload', array( 'file' => $img_path, 'url' => $img_url, 'type' => $type ), 'sideload' );

        require_once( ABSPATH . '/wp-admin/includes/image.php' );

        /* use image exif/iptc data for title and caption defaults if possible */
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

                // get the img tag classes
                preg_match('/<img.*class\s*=\s*"([^"]*)[^>]+>/i', $match[0], $class);

                /* if the image tag has class attribute and it does not have wp-image in class */
                if( isset( $class[1] ) ) {
                    $updated_class = $class[1].' wp-image-'.$new_image_id;
                    $updated_image_tag = str_replace('class="'.$class[1].'"', 'class="'.$updated_class.'"', $match[0]);
                    $updated_post['post_content'] = str_replace( $match[0], $updated_image_tag, $post->post_content );

                    if ( $double_check_tag != '' ) {
                        $updated_post['post_content'] = str_replace( $double_check_tag, $updated_image_tag, $post->post_content );
                    }

                    // Update the post
                    wp_update_post( $updated_post );
                } else {
                    $updated_image_tag = str_replace( '<img', '<img role="img" class="wp-image-'.$new_image_id.'"', $match[0] );
                    $updated_post['post_content'] = str_replace( $match[0], $updated_image_tag, $post->post_content );

                    // Update the post
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

                    // Update the post
                    wp_update_post( $updated_post );
                } else {
                    $updated_image_tag = str_replace( '<img', '<img role="img" class="wp-image-' . $new_image_id . '"', $match[0] );
                    $updated_post['post_content'] = str_replace( $match[0], $updated_image_tag, $post->post_content );

                    // Update the post
                    wp_update_post( $updated_post );
                }
                return $image_src[0];
            }
        }
    } else {
         $file_object->delete( $file['file'] );
         return 0;
    }
}

/**
 * Used to get the attachment id provided 'src'
 * 
 * @uses $wpdb object
 * @param string $image_src The Image Source
 * @param boolean $hard_find
 * @return int
 *
 * @since rtPanel 2.0
 */
function rtp_get_attachment_id_from_src( $image_src, $hard_find = false ) {
    global $wpdb;
    $temp = $image_src;
    if ( $hard_find && !( 200 == wp_remote_retrieve_response_code( wp_remote_get( $image_src = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_src ) ) ) ) ) {
       $image_src = $temp;
    }
    $query = "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid='$image_src' LIMIT 1";
    $id = $wpdb->get_var( $query );
    return $id ? $id : 0;
}

/**
 * Used to get the image dimensions, provided the 'src'
 * 
 * @param string $image_src The Image Source
 * @return mixed
 *
 * @since rtPanel 2.1
 */
function rtp_get_image_dimensions( $src, $array = false, $deprecated = '', $id = 0, $size = null ) {
    global $rtp_general;
    if ( !empty( $deprecated ) )
            _rtp_deprecated_argument( __FUNCTION__, '3.0' );
    $id = $id ? $id : rtp_get_attachment_id_from_src( $src, true );
    if ( !$id ) {
        $width = $rtp_general['logo_width'];
        $height = $rtp_general['logo_height'];
    } else {
        $metadata = wp_get_attachment_metadata( $id );
        if ( ( !preg_match('/(\d+x\d+)(\.(jpg|jpeg|png|gif)$)/i', $src ) || ( 200 != wp_remote_retrieve_response_code( wp_remote_get( preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $src ) ) ) ) ) && ( isset( $metadata ) && isset( $metadata['width'] ) && isset( $metadata['height'] ) ) ) {
            $width = $metadata['width'];
            $height = $metadata['height'];
        } elseif ( isset( $metadata['sizes'] ) ) {
            $pathinfo = pathinfo($src);
            foreach( $metadata['sizes'] as $size ) {
                if ( $size['file'] == $pathinfo['basename'] ) {
                    $width = $size['width'];
                    $height = $size['height'];
                    break;
                }
            }
        }
    }
    if ( !isset( $width ) || !isset( $height ) ) {
        return null;
    }
    if ( $array ) {
        return array( 'width' => $width, 'height' => $height );
    }
    return ' width="' . $width . '" height="' . $height . '"';
} 

/**
 * Used to style password protected post form
 * 
 * @return string
 *
 * @since rtPanel 2.1
 */
function rtp_get_the_password_form() {
    global $post;
    $label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
        $output .= '<p class="info">' . __( 'This post is password protected. To view it please enter your password below:', 'rtPanel' ) . '</p>';
        $output .= '<table><tbody>
                <tr>
                    <td><label for="' . $label . '">' . __( 'Password:', 'rtPanel' ) . '</label></td>
                    <td><input name="post_password" id="' . $label . '" required="required" placeholder="' . __( 'Password', 'rtPanel' ) . '" type="password" size="20" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" role="button" name="submit" value="' . esc_attr__( 'Submit', 'rtPanel' ) . '" /></td>
                </tr>
            </tbody></table></form>';
    return $output;
}
add_filter( 'the_password_form', 'rtp_get_the_password_form' );

/**
 * Converts default caption markup to html5
 * 
 * @return string
 *
 * @since rtPanel 2.1
 */
function rtp_html5_caption( $output, $attr, $content ) {
    extract(shortcode_atts(array(
        'id'	=> '',
        'align'	=> 'alignnone',
        'width'	=> '',
        'caption' => ''
    ), $attr));

    if ( 1 > (int) $width || empty($caption) )
            return $content;
    
    $idtag = NULL;
    if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';

    return '<figure ' . $idtag . 'aria-describedby="figcaption_' . $id . '" class="wp-caption ' . esc_attr($align) . '" >'
    . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '" class="wp-caption-text">' . $caption . '</figcaption></figure>';
}
add_filter( 'img_caption_shortcode', 'rtp_html5_caption', '', 3 );
