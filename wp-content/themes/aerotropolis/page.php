<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Template for displaying pages.
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			$secondaryNav = get_post_meta( get_the_ID(), 'aero-secondary-nav', true );

			if (!empty($secondaryNav)) {
				wp_nav_menu( array(
					'theme_location'	=> $secondaryNav,
					'menu_class'  		=> 'sticky-secondary-nav'
				) );
			}

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// End of the loop.
		endwhile;
		?>
	</main>
</div>

<aside id="content-bottom-widgets" class="content-bottom-widgets" role="complementary">
	<div class="widget-area">
		<?php dynamic_sidebar( 'footer-contact-bar' ); ?>
	</div>
</aside>

<?php get_footer(); ?>