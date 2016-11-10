<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom widget for signing up for a newsletter.
 */

class Aero_Newsletter extends WP_Widget {

  protected $defaults;

  public function __construct () {
    $this->defaults = array(
      'text1'      => '',
      'text2'      => '',
      'buttonText' => 'Join'
    );

    $options = array(
      'classname'   => 'aero_newsletter',
      'description' => 'Newsletter widget',
    );

    $this->WP_Widget('aero_newsletter', 'Aerotropolis Newsletter', $options);
  }

  public function form($instance){
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    $text1 = $instance['text1'];
    $text2 = $instance['text2'];
    $buttonText = $instance['buttonText'];
    ?>

    <p><label for="<?php echo $this->get_field_id('text1'); ?>">Text: <input class="widefat" id="<?php echo $this->get_field_id('text1'); ?>" name="<?php echo $this->get_field_name('text1'); ?>" type="text" value="<?php echo attribute_escape($text1); ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('text2'); ?>">Text: <input class="widefat" id="<?php echo $this->get_field_id('text2'); ?>" name="<?php echo $this->get_field_name('text2'); ?>" type="text" value="<?php echo attribute_escape($text2); ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('buttonText'); ?>">Button Text: <input class="widefat" id="<?php echo $this->get_field_id('buttonText'); ?>" name="<?php echo $this->get_field_name('buttonText'); ?>" type="text" value="<?php echo attribute_escape($buttonText); ?>" /></label></p>

    <?php
  }

  public function update($new_instance, $old_instance){
    $instance = $old_instance;
    $instance['text1'] = $new_instance['text1'];
    $instance['text2'] = $new_instance['text2'];
    $instance['buttonText'] = $new_instance['buttonText'];
    return $instance;
  }

  public function widget($args, $instance){
    extract($args, EXTR_SKIP);

    //get vars
    $text1 = $instance['text1'];
    $text2 = $instance['text2'];
    $buttonText = $instance['buttonText'];

    //display
    echo $before_widget;
    echo empty($text1) ? '' : '<p class="text1">'. $text1 .'</p>';
    echo empty($text2) ? '' : '<p class="text2">'. $text2 .'</p>';
    echo '<form method="post">';
      echo '<input type="text" placeholder="Email address" name="email" />';
      echo '<input type="submit" value="'. $buttonText .'" />';
    echo '</form>';
    echo $after_widget;
  }

}

add_action ('widgets_init', function () {
  register_widget('Aero_Newsletter');
});