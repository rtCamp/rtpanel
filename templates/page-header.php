<?php
// Home Page
if ( is_home() && ! is_front_page() ) :
	?>
	<header class="page-header">
		<h1 class="page-title screen-reader-text">
			<?php single_post_title(); ?>
		</h1>
	</header>
	<?php
endif;

// Archive Pages
if ( is_archive() ) :
	?>
	<header class="page-header">
		<?php
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
	</header>

	<?php
endif;

// Search Page
if ( is_search() ) :
	?>

	<header class="page-header">
		<h1 class="page-title">
			<?php printf( __( 'Search Results for: %s', 'rtBook' ), get_search_query() ); ?>
		</h1>
	</header>

	<?php

endif;