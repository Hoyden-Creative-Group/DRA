<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for IndustryItem
 */

  require_once realpath(dirname(__FILE__) . '/..') . '/helper.php';

  $button1 = getButton($button1, 'button outline blue');

  $class = 'industry-item ' . $class;
  $class = empty($button1["url"]) ? $class : $class . ' clickable';

  $onclick = empty($button1["onclick"]) ? '' : ' onClick="'. $button1["onclick"] .'"';
?>

<?php ob_start() ;?>

<div class="<?php echo $class; ?>"<?php echo $onclick; ?>>
  <div class="thumbnail" style="background-image: url(<?php echo wp_get_attachment_image_src( $image, 'full' )[0]; ?>);">
  </div>
  <div class="details">
    <h4><?php echo $title; ?></h3>
    <p class="summary"><?php echo $summary; ?></p>
    <?php echo empty($button1['url']) ? "" : $button1["button"]; ?>
  </div>
</div>

<?php
  $output = ob_get_clean();
  return $output;