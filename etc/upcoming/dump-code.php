<?php
/* 
 * Code Snippets For The Files in Upcoming Folder
 */


//=====================================================================
/*
 * :functions.php
 */
//=====================================================================
//
// ========== [ Social Network Icon Support ] ========== //
/*
    valid sizes for twitter - none, horizontal, vertical
    valid sizes for facebook_like- standard, box_count, button_count
    valid sizes for facebook_share- box_count, button_count, button, icon_link, icon
    valid sizes for google-buzz- small-button, normal-button, link, normal-count, small-count
    valid sizes for stumbleupon - 1, 2, 3, 4, 5, 6
*/
/*
    $networks = array (
        'twitter'=> 'horizontal',
        'facebook_like' => 'button_count',
        'facebook_share' => 'box_count',
        'googlebuzz' => 'small-button',
        'stumbleupon' => 2
    );
*/

// ========== [ Facebook Share Support ] ========== //
/*
    if( !is_admin() )
    wp_enqueue_script('fbshare', 'http://static.ak.fbcdn.net/connect.php/js/FB.Share', '', '', true);
*/

// Create or Initialise object for rt_social_share class, to enable social icons support befor or after post content.
/*
    global $content;
    $rt_social_share = new rt_social_share($content, $networks, 'before_content');
    global $rt_social_share_call;
    $rt_social_share_call = new rt_social_share_call( $networks );
*/

// ========== [ Open Graph Protocol Support ] ========== //
//$rt_ogp = new rt_ogp();


//=====================================================================
/*
 * :loop-common.php
 */
//=====================================================================


// ========== [ Initialise Social Class Before the_loop ] ========== //
//$rt_social_share_call = new rt_social_share_call();


// ========== [ Social Share Support ] ========== //
                /*
                    valid sizes for twitter - none, horizontal, vertical
                    valid sizes for facebook_like - standard, box_count, button_count
                    valid sizes for facebook_share - box_count, button_count, button, icon_link, icon
                    valid sizes for google-buzz - small-button, normal-button, link, normal-count, small-count
                    valid sizes for stumbleupon - 1, 2, 3, 4, 5, 6
                */
                /*
                    $rt_social_share_call->rt_social_set($id);
                    echo $rt_social_share_call->get_twitter('horizontal');
                    echo $rt_social_share_call->get_facebook_like('button_count');
                    echo $rt_social_share_call->get_facebook_share('button_count');
                    echo $rt_social_share_call->get_googlebuzz('normal-button');
                    echo $rt_social_share_call->get_stumbleupon(4);
                */
//=====================================================================
/*
 * :header.php
 */
//=====================================================================
/* Use following script for Slider using Cycle */
// wp_enqueue_script('jquery-cycle', RTP_JS_FOLDER_URL. '/jquery.cycle.js', array('jquery'), '', true);


//=====================================================================
/*
 * :style.css
 * slider style
 */
//=====================================================================
/* Slider Css */
#rt-home-slider { height: auto !important; overflow: hidden; position: relative; width: 500px !important; }
    #rt-home-slider .slider-container { height: 425px !important; position: relative; width: 500px !important; }
    #rt-home-slider .slider-container .slider-title { text-transform: capitalize; }
    #rt-home-slider .slider-container .slider-image {  }
    #rt-home-slider .slider-pagination { position: relative; }
        #rt-home-slider .slider-pagination #slider-prev { float: left; }
        #rt-home-slider .slider-pagination #slider-next { float: right; }
        #rt-home-slider .slider-pagination #rt-slider-nav { text-align: center; }

//=====================================================================
/*
 * :custom.js
 * slider script
 */
//=====================================================================
/* jQuery Slider */
    /* Check out all the available options here http://jquery.malsup.com/cycle/options.html*/

        /*jQuery('#rt-home-slider .slider-container').cycle({
            fx: 'fade',
            pager: '#rt-slider-nav',
            prev: '#slider-prev',
            next: '#slider-next',
            activePagerClass: 'active',
            //pagerAnchorBuilder: pagerFactory
        });*/

    /*
        add following parameter for pagination in the above param list (add comma " , ") before you add params
        pagerAnchorBuilder: pagerFactory
    */

    /* For slider pagination */
    /*function pagerFactory(idx, slide) {
        //var img;
        //img = jQuery(slide).find('img').attr('src');
        //return '<span><a href="#">'+(idx+1)+'<img width="50" height="50" src="'+img+'" /></a></span>';

        return '<span><a href="#">'+(idx+1)+'</a></span>';
    }*/
//
//from header.php (iphone favicon support)
//<!-- ========== [ icon for apple iphone, ipod ] ========== -->
//        <link rel="apple-touch-icon" href="< ?php echo RTP_IMG_FOLDER_URL; ? >/etc/apple-touch-icon.png" />




/**
 * title for tags and texonomy
 */

/*
$taxonomies = get_taxonomies();
foreach ( $taxonomies as $taxonomy ) {
//    print_r(get_terms($taxonomy));
add_filter( 'term_links-'.$taxonomy, 'my_customs');
}

function my_customs($params) {
    $rtp_count = 0;
    foreach ( $params as $param ) {
        preg_match('/<a.*">(.*)<\/a>/', $param, $title);
        $param = str_replace( 'rel', 'title="'. $title[1] .'" rel', $param );
//        var_dump( $param );
        $params[$rtp_count] = $param;
        $rtp_count++;
    }
    return $params;
}*/

?>