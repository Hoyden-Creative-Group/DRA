<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for Heading
 */

  $syntax = empty($heading) ? 'p' : $heading;
  $class = empty($class) ? '' : ' class="'. $class .'"';
?>

<?php ob_start() ;?>

<<?php echo $syntax . $class; ?>><?php echo $text; ?></<?php echo $syntax; ?>>

<?php
  $output = ob_get_clean();
  return $output;