<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * The search results template file.
 */


get_header(); ?>

<section id="primary" class="content-area search-results-content">
	<aside class="news-sidebar">
		<?php dynamic_sidebar( 'news-side-bar' ); ?>
	</aside>

	<main id="main" class="site-main" role="main">
		<h1 class="page-title">Search Results for: <span><?php echo esc_html( get_search_query() ); ?></span></h1>

		<?php if ( have_posts() ) : ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'search' );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => 'Previous page',
				'next_text'          => 'Next page',
				'before_page_number' => '<span class="meta-nav screen-reader-text">Page</span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
	</main>
</section>

<?php get_footer(); ?>