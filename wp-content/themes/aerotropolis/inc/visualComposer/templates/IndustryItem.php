<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for IndustryItem
 */
?>

<?php ob_start() ;?>

<div class="industry-item">
  <div class="thumbnail<?php echo ' '.$image_class; ?>" style="background-image: url(<?php echo wp_get_attachment_image_src( $image, 'full' )[0]; ?>);">
  </div>
  <div class="details">
    <h4><?php echo $title; ?></h3>
    <p class="summary"><?php echo $summary; ?></p>
  </div>
</div>

<?php
  $output = ob_get_clean();
  return $output;