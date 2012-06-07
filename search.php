<?php
/**
 * The template for displaying Google Custom Search or WordPress Default Search
 *
 * @package rtPanel
 * 
 * @since rtPanel 2.0
 */
get_header(); ?>

<?php global $rtp_general; ?>

    <section id="content" role="main" class="rtp-multiple-post<?php echo (  $rtp_general['search_code'] && $rtp_general['search_layout'] ) ? ' rtp-grid-12' : ' rtp-grid-8'; ?>"> <!-- content begins --><?php

        rtp_hook_begin_content();

        if ( preg_match( '/customSearchControl.draw\(\'cse\'(.*)\)\;/i', @$rtp_general["search_code"], $split_code ) ) { ?>

            <h1 class="post-title rtp-main-title"><?php printf( __( 'Search Results for: %s', 'rtPanel' ), '<span>' . get_search_query() . '</span>' ); ?></h1><?php

            $search_code = preg_split('/customSearchControl.draw\(\'cse\'(.*)\)\;/i', $rtp_general["search_code"]);
            echo $search_code[0];
            echo $split_code[0];
            echo "customSearchControl.execute('" . get_search_query() . "');";
            echo $search_code[1];
        } else {
            get_template_part( 'loop', 'common' );
        } ?>

        <?php rtp_hook_end_content(); ?>

    </section><!-- #content -->

    <?php if ( !$rtp_general['search_code'] || !$rtp_general['search_layout'] ) rtp_hook_sidebar(); ?>

<?php get_footer(); ?>