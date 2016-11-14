<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * The single post template file.
 */

get_header(); ?>


<div id="primary" class="content-area news-page single">

	<aside class="news-sidebar">
		<?php dynamic_sidebar( 'news-side-bar' ); ?>
	</aside>

	<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the single post content template.
			get_template_part( 'template-parts/content', 'single' );

			// End of the loop.
		endwhile;
		?>

	</main>

</div>

<?php get_footer(); ?>
