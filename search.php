<?php
/**
 * The template for displaying Google Custom Search or WordPress Default Search
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */

global $rtp_general; ?>

<?php get_header(); ?>

    <?php if ( !$rtp_general['search_code'] || !$rtp_general['search_layout'] ) get_sidebar(); ?>

    <?php rtp_hook_begin_content(); ?>

    <div id="content" class="rtp-multiple-post<?php echo (  $rtp_general['search_code'] && $rtp_general['search_layout'] )?' search-layout-content':''; ?>"> <!-- content begins --><?php
        if ( preg_match( '/customSearchControl.draw\(\'cse\'\);/i', @$rtp_general["search_code"] ) ) {
            // Breadcrumb Support
            if ( function_exists( 'bcn_display' ) ) {
                echo '<div class="breadcrumb">';
                    bcn_display();
                echo '</div>';
            } ?>

            <div class="post-title rtp-main-title">
                <h1><?php printf( __( 'Search Results for: %s', 'rtPanel' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </div><?php
            
            $search_code = preg_split('/customSearchControl.draw\(\'cse\'\);/i', $rtp_general["search_code"]);
            echo $search_code[0];
            echo "customSearchControl.draw('cse');";
            echo "customSearchControl.execute('" . get_search_query() . "');";
            echo $search_code[1];
        } else {
            get_template_part( 'loop', 'common' );
        }
        ?>
    </div><!-- #content -->

    <?php rtp_hook_end_content(); ?>

<?php get_footer(); ?>