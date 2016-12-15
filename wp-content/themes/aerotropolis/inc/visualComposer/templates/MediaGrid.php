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
    <?php $image = wp_get_attachment($item); ?>
    <?php if (!empty($image['description'])): ?><a href="<?php echo $image['description']; ?>"><?php endif; ?>
    <div class="item"><img src="<?php echo $image['src']; ?>" /></div>
    <?php if (!empty($image['description'])): ?></a><?php endif; ?>
  <?php endforeach; ?>
</div>

<?php
  $output = ob_get_clean();
  return $output;