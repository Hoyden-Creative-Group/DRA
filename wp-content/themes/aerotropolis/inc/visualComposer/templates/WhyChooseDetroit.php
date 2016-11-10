<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for WhyChooseDetroit
 */

  require_once realpath(dirname(__FILE__) . '/..') . '/helper.php';

  $button1 = getButton($button1, 'button outline blue');
  $button2 = getButton($button2, 'button outline blue');
?>

<?php ob_start() ;?>

<div class="choose-detroit">
  <div class="map" style="background-image: url(<?php echo wp_get_attachment_image_src( $image, 'full' )[0]; ?>);">
  </div>
  <div class="details">
    <h3><?php echo $title; ?></h3>
    <p class="summary"><?php echo $summary; ?></p>
    <div class="call-to-action">
      <?php echo $button1['button']; ?>
      <?php echo $button2['button']; ?>
    </div>
  </div>
</div>

<?php
  $output = ob_get_clean();
  return $output;