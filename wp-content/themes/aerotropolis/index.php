<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * The main template file.
 */

get_header(); ?>

<div id="primary" class="content-area news-page">
	<aside class="news-sidebar">
		<section class="widget widget_categories">
			<ul>
				<?php wp_list_categories(array(
					'title_li' => '',
					'exclude' => array(11)
					)
				); ?>
			</ul>
		</section>
		<?php dynamic_sidebar( 'news-side-bar' ); ?>
	</aside>

	<main id="main" class="site-main" role="main">
		<h1 class="page-title">News</h1>

		<?php if ( have_posts() ) : ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'mid_size'  => 4,
				'prev_text' => ' ',
				'next_text' => ' ',
				'screen_reader_text' => ' '
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
	</main>
</div>

<?php get_footer(); ?>