<?php
/**
 * The template for displaying Google Cusotm Search or Wordpress Default Search
 * If provided Google Custom Search Integration it will shows output as google custom search result
 * otherwise it shows wordpress default search result
 *
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

// ========== [ Call Header ] ========== //
get_header();

// ========== [ Call Sidebar ] ========== //
get_sidebar();

// ========== [ rtpanel_hook for adding content before #content ] ========== //
rtp_hook_after_content_begins();

global $rtp_general; ?>
<div id="content" class="rtp-multiple-post"> <!-- content begins -->
    <?php
        if ( preg_match( '/customSearchControl.draw\(\'cse\'\);/i', @$rtp_general["search_code"] ) ) {

            // ========== [ Breadcrumb Support ] ========== //
            if ( function_exists( 'bcn_display' ) ) {
                echo '<div class="breadcrumb">';
                    bcn_display();
                echo '</div>';
            } ?>
            <div class="post-title rtp-main-title"><h1><?php printf( __( 'Search Results for: %s', 'rtPanel' ), '<span>' . get_search_query() . '</span>' ); ?></h1></div><?php
            $search_code = preg_split('/customSearchControl.draw\(\'cse\'\);/i', $rtp_general["search_code"]);
            echo $search_code[0];
            echo "customSearchControl.draw('cse');";
            echo "customSearchControl.execute('" . get_search_query() . "');";
            echo $search_code[1];
        } else {
            get_template_part( 'loop', 'common' );
        }
    ?>
</div> <!-- end content -->
<?php
// ========== [ rtpanel_hook for adding content after #content ] ========== //
rtp_hook_before_content_ends();

// ========== [ Call Footer ] ========== //
get_footer(); ?>