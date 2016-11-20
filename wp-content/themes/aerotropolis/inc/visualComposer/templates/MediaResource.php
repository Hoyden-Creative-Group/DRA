<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for MediaResource
 */

?>

<?php ob_start() ;?>

<div class="media-resource">
  <a href="<?php echo $asset_link; ?>">
    <div class="media-preview" style="background-image: url(<?php echo wp_get_attachment_image_src( $image, 'full' )[0]; ?>);">
    </div>
    <div class="media-hover-effect">
      <i class="icon-download"></i>
    </div>
  </a>
  <h4><?php echo $title; ?></h4>
</div>

<?php
  $output = ob_get_clean();
  return $output;