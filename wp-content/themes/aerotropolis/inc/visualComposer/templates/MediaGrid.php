<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for MediaGrid.
 */

$media = explode(",", $media);

?>

<?php ob_start() ;?>

<div class="aero-media-grid <?php echo $class; ?>">
  <?php foreach($media as $item): ?>
    <?php $image = wp_get_attachment_image_src( $item, 'full' )[0]; ?>
    <div class="item"><img src="<?php echo $image; ?>" /></div>
  <?php endforeach; ?>
</div>

<?php
  $output = ob_get_clean();
  return $output;