<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header();
?>
<section id="content" class="multiple-posts">
	<?php if (have_posts()) :  the_post(); ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h2>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h2>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2>Archive for <?php the_time( get_option( 'F jS, Y' ) ); ?></h2>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2>Archive for <?php the_time( get_option( 'F, Y' ) ); ?></h2>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2>Archive for <?php the_time( get_option( 'Y' ) ); ?></h2>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
        <h2>Author Archive : <span class="rtp-author-name"><?php the_author_posts_link(); ?></span></h2>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2>Blog Archives</h2>
	<?php } ?>


        <div class="wp-pagenavi clearfix">
            <div class="alignleft"><?php next_posts_link('&laquo; Older Entries'); ?></div>
            <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;'); ?></div>
        </div>

		<?php while (have_posts()) : the_post(); ?>
			
		 <div <?php post_class() ?>>
                    <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-meta">
                            <p><strong>Posted on</strong> <?php the_time('l, F jS, Y') ?></p>
                            <p><?php the_tags('<strong>Tags:</strong> ', ', ', '<br />'); ?> <?php if( get_the_category_list() ) { ?><strong>Posted in</strong> <?php the_category(', '); ?> | <?php } ?> <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link( ' &#123; 0 Comment &#125; ', ' &#123; 1 Comment &#125; ', ' &#123; % Comments &#125; ' ); ?></p>
                        </div>
                        <div class="post-content clearfix">
                            <?php the_content(); ?>
                        </div>
                 </div>

		<?php endwhile; ?>

		<?php //support for page-navi plugin, please refer readme.txt for further instructions
     		if( function_exists('wp_pagenavi') ) {
				echo '<div class="wp-pagenavi">';
					wp_pagenavi();
				echo '</div>';
 			} elseif ( get_next_posts_link() || get_previous_posts_link() ) { echo '<div class="wp-pagenavi">'; ?>
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries'); ?></div>
                        <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;'); ?></div>
 		<?php echo '</div>'; } ?>
		
	<?php  endif; ?>
</section><!--end of #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>