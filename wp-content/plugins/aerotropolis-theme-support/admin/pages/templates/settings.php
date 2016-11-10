<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 */
?>

<h1>Aerotropolis Theme Settings</h1>

<?php settings_errors(); ?>

<form method="post" action="options.php">
  <?php settings_fields('aero-settings-group'); ?>
  <?php do_settings_sections('aerotropolis_settings'); ?>
  <?php submit_button(); ?>
</form>