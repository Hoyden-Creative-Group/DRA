<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * The category template file.
 */

get_header(); ?>

<div id="primary" class="content-area news-page category-page">
  <aside class="news-sidebar">
    <?php dynamic_sidebar( 'news-side-bar' ); ?>
  </aside>

  <main id="main" class="site-main" role="main">
    <h1 class="page-title"><?php echo single_cat_title(); ?></h1>

    <?php if ( have_posts() ) : ?>

      <?php
      // Start the loop.
      while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/content', get_post_format() );

      // End the loop.
      endwhile;

    // If no content, include the "No posts found" template.
    else :
      get_template_part( 'template-parts/content', 'none' );

    endif;
    ?>
  </main>
</div>

<?php get_footer(); ?>