<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for SiteSelectionItem.
 */


  require_once realpath(dirname(__FILE__) . '/..') . '/helper.php';

  $button1 = getButton($button1, 'button outline blue');

  $class = 'site-selection';
  $class = empty($button1["url"]) ? $class : $class . ' clickable';

  $onclick = empty($button1["onclick"]) ? '' : ' onClick="'. $button1["onclick"] .'"';
?>

<?php ob_start() ;?>

<div class="<?php echo $class; ?>"<?php echo $onclick; ?>>
  <?php if(!empty($icon)) { echo '<div class="icon-'. $icon .'"></div>'; }?>
  <h4><?php echo $title; ?></h4>
  <p><?php echo $description; ?></p>
  <?php echo $button1["button"]; ?>
</div>

<?php
  $output = ob_get_clean();
  return $output;