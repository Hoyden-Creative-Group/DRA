<?php
/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Template Name: News
 */


get_header(); ?>


<div id="primary" class="content-area">

  <?php dynamic_sidebar( 'news-side-bar' ); ?>

  <main id="main" class="site-main" role="main">

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

  </main><!-- .site-main -->

</div><!-- .content-area -->

<aside id="content-bottom-widgets" class="content-bottom-widgets" role="complementary">
  <div class="widget-area">
    <?php dynamic_sidebar( 'footer-contact-bar' ); ?>
  </div>
</aside>

<?php get_footer(); ?>
