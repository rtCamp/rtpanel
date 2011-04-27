<?php

//we are not using this file and its functions
/*
 * common function for various purpose
 */

/*
 * Function - Given a full-image URL, return thumbnail-version of URL, including checking for cache
 */
return;
function rt_get_thumbnail_from_image_url($image_url, $max_w, $max_h, $crop) {
    //caculate md5 of $image_url
    //as we are processing full URLs, www, non-www, change in domains >> will invalidate cache.
    //But such big changes are very rare. So for speed and accuracy we will take loose route
    $cache_key = md5($image_url . $max_w . $max_h . $crop);
    $cache_file = $cache_key . "." . pathinfo(parse_url($image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
    $cache_file_path = RT_CACHE_DIR_PATH. $cache_file;    //absoulte path to file


    $cache_file_url = RT_CACHE_DIR_URL. $cache_file;   //weburl to cached thumbnail

    //check if thumbnail is present in cache
    if (file_exists($cache_file_path)) {
        //cache HIT
        return $cache_file_url;
    }

    //cache check failed :-(

    //before going ahead lets check if cache path is writable as of now, otherwise our efforts will go waste
    //suggestion by Phil(@frumph)
    if( !is_writable( dirname($cache_file_path) ) ) {
    	return FALSE;
    }

    //download image and cache its thumbnail version
//  *******Using the WORDPRESS HTTP_API*********

//      if( !class_exists( 'WP_Http' ) )
//
//          include_once( ABSPATH . WPINC. '/class-http.php' );
//
//      $request = new WP_Http;
//
//      $result = $request->request( $image_url );
//  *********************************************
      $result = wp_remote_get($image_url);
      
      if ( is_wp_error($result) || $result["response"]["code"]!=200 ) {
         return;
      }
      $tmp_image = $result["body"];
//  *******end of the WORDPRESS HTTP_API*********

      
//    if (function_exists('curl_init')) {
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $image_url);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
//        $tmp_image = curl_exec($ch);
//        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
//            //echo "Error in CURL transfer";
//            curl_errno($ch);
//            return FALSE;
//        }
//        curl_close($ch);
//    }//end of curl job
    

    if (!function_exists('imagecreatefromstring'))
        return FALSE;
        //return __('The GD image library is not installed.');

    // Set artificially high because GD uses uncompressed images in memory
    $image = imagecreatefromstring($tmp_image);

    if (!is_resource($image))
        return FALSE;
        //return __('error_loading_image');

    $orig_type = image_file_type_from_binary($tmp_image);   //get image mime type
    $orig_w = imagesx($image);
    $orig_h = imagesy($image);

    $dims = rt_image_resize_dimensions($orig_w, $orig_h, $max_w, $max_h, $crop);

    list($dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) = $dims;

    //edited by: Santosh
    //below conditions check if actual image size is smaller than what we expect it to resized,
    //then return actual image path no need to resize
    if($dst_w >= $orig_w && $dst_h >= $orig_h ) return $image_url;

    //if actual image width is less than dest-width then
    //assign max-width and dest-width values equal to actual width
    if($dst_w >= $orig_w ) {
        $max_w = $orig_w;
    }
    //if actual image height is less than dest-height then
    //assign max-height and dest-height values equal to actual width
    if($dst_h >= $orig_h ) {
        $max_h = $orig_h;;
    }

    $cache_file = wp_imagecreatetruecolor($max_w, $max_h);
    //imagecopyresampled($cache_file, $image, 0, 0, $src_x, $src_y, $max_w, $max_h, $orig_w, $orig_h);
    imagecopyresampled($cache_file, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

    // convert from full colors to index colors, like original PNG.
    if (IMAGETYPE_PNG == $orig_type && function_exists('imageistruecolor') && !imageistruecolor($image))
        imagetruecolortopalette($cache_file, false, imagecolorstotal($image));

    // we don't need the original in memory anymore
    imagedestroy($image);

    if (IMAGETYPE_GIF == $orig_type) {
        if (!imagegif($cache_file, $cache_file_path))
                return FALSE;
            //return new WP_Error('resize_path_invalid', __('Resize path invalid'));
    } elseif (IMAGETYPE_PNG == $orig_type) {
        if (!imagepng($cache_file, $cache_file_path))
                return FALSE;
            //return new WP_Error('resize_path_invalid', __('Resize path invalid'));
    } else {
        // all other formats are converted to jpg
        if (!imagejpeg($cache_file, $cache_file_path, apply_filters('jpeg_quality', 100, 'image_resize')))
                return FALSE;
            //return new WP_Error('resize_path_invalid', __('Resize path invalid'));
    }

    imagedestroy($cache_file);

    // Set correct file permissions
    $stat = stat(dirname($cache_file_path));
    $perms = $stat['mode'] & 0000666; //same permissions as parent folder, strip off the executable bits
    @ chmod($cache_file_path, $perms);

    if (file_exists($cache_file_path)) {
        //cache HIT
        return $cache_file_url;
    }
}

/**
 * @source - http://stackoverflow.com/questions/2207095/get-image-mimetype-from-resource-in-php-gd
 *
 */
function image_file_type_from_binary($binary) {
    $hits = array();
    if (
            !preg_match(
                    '/\A(?:(\xff\xd8\xff)|(GIF8[79]a)|(\x89PNG\x0d\x0a)|(BM)|(\x49\x49(\x2a\x00|\x00\x4a))|(FORM.{4}ILBM))/',
                    $binary, $hits
            )
    ) {
        return 'application/octet-stream';
    }

    static $type = array(
1 => 'image/jpeg',
 2 => 'image/gif',
 3 => 'image/png',
 4 => 'image/x-windows-bmp',
 5 => 'image/tiff',
 6 => 'image/x-ilbm',
    );

    return $type[count($hits) - 1];
}

/**
 * This function has been copied from wordpress core to add one small modification to it
 */
function rt_image_resize_dimensions($orig_w, $orig_h, $dest_w, $dest_h, $crop = false) {

    if ($crop) {
        // crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
        $aspect_ratio = $orig_w / $orig_h;
        $new_w = min($dest_w, $orig_w);
        $new_h = min($dest_h, $orig_h);

        if (!$new_w) {
            $new_w = intval($new_h * $aspect_ratio);
        }

        if (!$new_h) {
            $new_h = intval($new_w / $aspect_ratio);
        }

        $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

        $crop_w = round($new_w / $size_ratio);
        $crop_h = round($new_h / $size_ratio);

        $s_x = floor(($orig_w - $crop_w) / 2);
        $s_y = floor(($orig_h - $crop_h) / 2);
    } else {
        // don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
        $crop_w = $orig_w;
        $crop_h = $orig_h;

        $s_x = 0;
        $s_y = 0;

        list( $new_w, $new_h ) = wp_constrain_dimensions($orig_w, $orig_h, $dest_w, $dest_h);
    }

//    // if the resulting image would be the same size or larger we don't want to resize it
    if ($new_w >= $orig_w && $new_h >= $orig_h) {
        /*
         * enlarge check - added by @rahul286
         */
        $new_w = $dest_w;
        $new_h = $dest_h;
//        return false;
    }
    // the return array matches the parameters to imagecopyresampled()
    // int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
    return array(0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h);
}
?>
