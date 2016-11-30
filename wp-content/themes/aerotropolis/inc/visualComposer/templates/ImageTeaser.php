<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for ImageTeaser
 */

  require_once realpath(dirname(__FILE__) . '/..') . '/helper.php';

  $button1 = getButton($button1, 'button outline blue');

  $class = 'image-teaser ' . $class;
  $class = empty($button1["url"]) ? $class : $class . ' clickable';

  $onclick = empty($button1["onclick"]) ? '' : ' onClick="'. $button1["onclick"] .'"';
?>

<?php ob_start() ;?>

<div class="<?php echo $class; ?>"<?php echo $onclick; ?>>
  <div class="thumb-wrapper">
    <img class="thumbnail" src="<?php echo wp_get_attachment_image_src( $image, 'full' )[0]; ?>" alt="<?php echo $title; ?>" />
  </div>
  <h4><?php echo $title; ?></h3>
</div>

<?php
  $output = ob_get_clean();
  return $output;