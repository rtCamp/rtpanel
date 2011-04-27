<?php get_header(); ?>
<div id="content" class="multiple-posts">
    <?php if (have_posts()) : ?>
        <h2><?php printf(__('Search Results for: %s', 'rtbase'), '<span class="search-title">' . get_search_query() . '</span>'); ?></h2>
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
                            <div class="post-content">
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
		
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>