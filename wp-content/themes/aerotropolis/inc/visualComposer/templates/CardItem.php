<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for CardItem.
 */


  require_once realpath(dirname(__FILE__) . '/..') . '/helper.php';

  $button1 = getButton($button1, 'button outline blue');

  $class = 'card-item ' . $class;
  $class = empty($button1["url"]) ? $class : $class . ' clickable';

  $onclick = empty($button1["onclick"]) ? '' : ' onClick="'. $button1["onclick"] .'"';

  /**
   * Very annoying bug with Visual Composer.  On text areas that have HTML, it seems to
   * try and add a closing </p> to the beginning and an opening <p> to the end of the value.
   * So, for now, I'm regexing that garbage off.
   */
  $description = preg_replace("/^<\/p>|<p>$/", "", $description);
?>

<?php ob_start() ;?>

<div class="<?php echo $class; ?>"<?php echo $onclick; ?>>
  <?php if(!empty($icon)) { echo '<div class="icon-'. $icon .'"></div>'; }?>
  <h4><?php echo $title; ?></h4>
  <?php echo $custom_html ? "" : "<p>"; ?>
  <?php echo $description; ?>
  <?php echo $custom_html ? "" : "</p>"; ?>
  <?php echo empty($button1['url']) ? "" : $button1["button"]; ?>
</div>

<?php
  $output = ob_get_clean();
  return $output;