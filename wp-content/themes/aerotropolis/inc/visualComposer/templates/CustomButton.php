<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for CustomButton
 */

  require_once realpath(dirname(__FILE__) . '/..') . '/helper.php';

  $button = getButton($button, 'button '. $type .' '.$color);
?>

<?php ob_start() ;?>
<div class="button-wrapper <?php echo trim($class .' '. $alignment); ?>">
<?php echo $button['button']; ?>
</div>
<?php
  $output = ob_get_clean();
  return $output;