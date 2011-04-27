<?php
/*
 * Markup for slideshow can be controlled from here
 */

/**
 * This function returns whole slider html with 10 latest posts.
 * Using http://jquery.malsup.com/cycle/ js for slider
 *
 * @return string returns slider html
 */
function rt_get_cycle() {
    $slider_html = '<div id="rt-home-slider"><div class="slider-container">';

    $query = new WP_Query( array(
        'ignore_sticky_posts' => 1,
        'order' => 'DESC',
        'post_status' => 'publish',
        //'category_name' => 'featured' //if post shows in featured category
    ) );

    while( $query->have_posts() ) {
        $query->the_post();
        $thumb = get_post_thumbnail_id();
        $slider_image = rtp_generate_thumbs( $thumb, 'slider-img' );
        $slider_title = '<h3 class="slider-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . ( ( strlen( get_the_title() ) > 50 ) ? substr( get_the_title(), 0, 50 ) . "..." : get_the_title() ) . '</a></h3>';
        $the_excerpt = '<div class="slider-description">' . str_replace( '[...]', '...', get_the_excerpt() ) . '</div>';

        if( $slider_image ) {
            $slider_html .= '<div class="slides">';                
                $slider_html .= ( $slider_image ) ? '<div class="slider-image"><a href="' . get_permalink() .'" title="'.  get_the_title().'"><img src="' . $slider_image . '" alt="' . get_the_title() . '" /></a></div>' : '';
                $slider_html .= $slider_title . $the_excerpt;
            $slider_html .= '</div>';
        }
    }
    $slider_html .= '</div>';
    
    /* For Pagination in the slider
     *
     *  To be used in js : <code>function pagerFactory(idx, slide) {return '<li><a href="#">'+(idx+1)+'</a></li>';}</code>
     *  Add the above function in custom.js
     *  jQuery('#rt-home-slider .container').cycle({fx: 'scrollHorz',pager: '#nav',prev: '#slider-prev',next: '#slider-next',activePagerClass: 'active',pagerAnchorBuilder: pagerFactory });
     */

    /* Uncomment following line if using pagination in the slider */
    $slider_html .= '<div class="slider-pagination"><a href="#" id="slider-prev" class="slider_previous"><span>Prev</span></a><a href="#" id="slider-next" class="slider_next"><span>Next</span></a><div id="rt-slider-nav" class="pagination"></div></div>';
    $slider_html .= '</div>';
    return $slider_html;
}