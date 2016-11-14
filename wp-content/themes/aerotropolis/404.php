<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>


<div id="primary" class="content-area not-found">
	<main id="main" class="site-main" role="main">

		<div class="not-found-img"></div>
		<div class="not-found-search">
			<h1>Uh Oh.</h1>
			<h6>You seem to be lost.</h6>
			<p class="not-found-description">Maybe check out our <a href="">site map</a> or use this handy dandy search bar:</p>
			<?php get_search_form(); ?>
		</div>

	</main>
</div>

<aside id="content-bottom-widgets" class="content-bottom-widgets" role="complementary">
	<div class="widget-area">
		<?php dynamic_sidebar( 'footer-contact-bar' ); ?>
	</div>
</aside>

<?php get_footer(); ?>