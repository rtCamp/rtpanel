<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

<div id="content" class="single-post">

	<?php	//breadcrumb support is here - please refer readme.txt for further instructions
		if(function_exists('bcn_display')){
			echo '<div class="breadcrumb">';
			bcn_display();
			echo '</div>';
		}
	?>

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?>>
				<div class="post-title">
					<h1><?php the_title(); ?></h1>
					<div class="clear"></div>
				</div><!-- .post-title -->

				<div class="post-meta">
				    <div class="alignleft">
					<!-- time and author -->
					<p><?php the_time('F jS, Y') ?> by <?php the_author() ?></p>
					<!-- comment count -->
					<p><?php comments_popup_link( ' &#123; 0 Comment &#125; ', ' &#123; 1 Comment &#125; ', ' &#123; % Comments &#125; ' ); ?></p>
					<!-- Category -->
					<p>Posted in <?php the_category(', ') ?></p>
					<!-- tags -->
					<p><?php the_tags('Tags: ', ', ', '<br />'); ?></p>
					<!-- edit link for logged in user -->
					<?php edit_post_link('Edit This Entry', '<p>', '</p>'); ?>
				    </div>
				    <!-- Social Buttons -->
				    <div class="alignright social-buttons">
					    <div class="facebook alignleft"><?php echo rt_get_facebook(); ?></div>
					    <div class="tweetmeme alignleft"><?php echo rt_get_tweetmeme(); ?></div>
					    <div class="googlebuzz alignleft"><?php echo rt_get_googlebuzz(); ?></div>
					    <div class="stumbleupon alignleft"><?php echo rt_get_stumbleupon(); ?></div>
				    </div>
				    <div class="clear"></div>
				</div><!-- end of .post-meta -->

				<div class="post-content">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>

				<div class="clear"></div>
			</div><!--end of .post_class -->

			<div id="comment-area">
				<?php comments_template('', true); ?>	<!-- Show Comments and Comment Form -->
			</div>

		<?php endwhile; ?>

	 	<?php //if pagenavi is not installed wordpress default "previous" and "next" links will be shown
     		if (next_posts_link() || previous_posts_link()){
 				next_posts_link('&laquo; Older Entries') ?> | <?php previous_posts_link('Newer Entries &raquo;');
 			}
		?>

	<?php endif; ?>
</div><!--end of #content -->

<?php get_footer(); ?>