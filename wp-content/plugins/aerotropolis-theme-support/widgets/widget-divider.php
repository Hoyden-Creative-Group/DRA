<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom widget for a divider.
 */

class Aero_Divider extends WP_Widget {

  public function __construct () {
    $options = array(
      'classname'   => 'aero_divider',
      'description' => 'Divider',
    );

    parent::__construct('aero_divider', 'Divider', $options);
  }

  public function widget($args, $instance){

    //display
    echo '<div class="widget divider"></div>';

  }

}

add_action ('widgets_init', function () {
  register_widget('Aero_Divider');
});