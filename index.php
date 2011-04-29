<?php
/**
 * The template for displaying home page, archives pages, 404 page,
 * search page, single post, single page, category and tag pages etc
 *
 * This is the most generic template file in a WordPress theme.
 * This template displays posts according to the query.
 * 
 * @package rtPanel
 * @since rtPanel Theme 2.0
 */

// ========== [ Call Header ] ========== //
get_header();

// ========== [ Call Sidebar ] ========== //
get_sidebar();

$rtp_content_class = '';
if ( is_search() || is_archive() ) {
    $rtp_content_class = ' class="rtp-multiple-post" ';
} elseif ( is_page() || is_single() || is_404() ) {
    $rtp_content_class = ' class="rtp-single-post" ';
} elseif ( is_home() ) {
    $rtp_content_class = ' class="rtp-blog-post" ';
} else {
    $rtp_content_class = '';
}
?>
<div id="content"<?php echo $rtp_content_class; ?>> <!-- content begins -->
    <?php
        rtp_hook_begin_content(); /* rtpanel_hook for adding content after #content begins */

        get_template_part( 'loop', 'common' );
        
        rtp_hook_end_content(); /* rtpanel_hook for adding content before #content ends */
    ?>
</div> <!-- end content -->

<?php
// ========== [ Call Footer ] ========== //
get_footer();
?>