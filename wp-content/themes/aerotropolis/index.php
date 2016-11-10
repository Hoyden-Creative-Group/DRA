<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * The main template file.
 */


get_header(); ?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				// *
				//  * Include the Post-Format-specific template for the content.
				//  * If you want to override this in a child theme, then include a file
				//  * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				//  *
				get_template_part( 'template-parts/content', get_post_format() );

			// End the loop.
			endwhile;



		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->



<?php get_footer(); ?>
