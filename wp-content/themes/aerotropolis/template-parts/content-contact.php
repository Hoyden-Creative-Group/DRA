<?php
/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Template Part: Page
 * Description: Shows the content of the contact page
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <div class="entry-content">
    <?php the_content(); ?>

  </div>

</article>
