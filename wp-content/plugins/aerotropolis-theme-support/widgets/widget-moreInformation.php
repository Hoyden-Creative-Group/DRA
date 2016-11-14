<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom widget for a "More Information" section.
 */

class Aero_MoreInformation extends WP_Widget {

  protected $defaults;

  public function __construct () {
    $this->defaults = array(
      'phoneText'   => '',
      'emailText'   => '',
      'buttonText'  => 'Click for more information',
      'buttonLink'  => ''
    );

    $options = array(
      'classname'   => 'aero_more_information',
      'description' => 'More information widget',
    );

    parent::__construct('aero_more_information', 'Aerotropolis More Information', $options);
  }

  public function form($instance){
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    $phoneText = $instance['phoneText'];
    $emailText = $instance['emailText'];
    $buttonText = $instance['buttonText'];
    $buttonLink = $instance['buttonLink'];
    ?>

    <p><label for="<?php echo $this->get_field_id('phoneText'); ?>">Phone title: <input class="widefat" id="<?php echo $this->get_field_id('phoneText'); ?>" name="<?php echo $this->get_field_name('phoneText'); ?>" type="text" value="<?php echo esc_attr($phoneText); ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('emailText'); ?>">Email title: <input class="widefat" id="<?php echo $this->get_field_id('emailText'); ?>" name="<?php echo $this->get_field_name('emailText'); ?>" type="text" value="<?php echo esc_attr($emailText); ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('buttonText'); ?>">Button text: <input class="widefat" id="<?php echo $this->get_field_id('buttonText'); ?>" name="<?php echo $this->get_field_name('buttonText'); ?>" type="text" value="<?php echo esc_attr($buttonText); ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('buttonLink'); ?>">Button link: <input class="widefat" id="<?php echo $this->get_field_id('buttonLink'); ?>" name="<?php echo $this->get_field_name('buttonLink'); ?>" type="text" value="<?php echo esc_attr($buttonLink); ?>" /></label></p>

    <?php
  }

  public function update($new_instance, $old_instance){
    $instance = $old_instance;
    $instance['phoneText'] = $new_instance['phoneText'];
    $instance['emailText'] = $new_instance['emailText'];
    $instance['buttonText'] = $new_instance['buttonText'];
    $instance['buttonLink'] = $new_instance['buttonLink'];
    return $instance;
  }

  public function widget($args, $instance){
    extract($args, EXTR_SKIP);

    //get vars
    $phoneText = $instance['phoneText'];
    $phoneNumber = get_option('phone_number');
    $emailText = $instance['emailText'];
    $email = get_option('email');
    $buttonText = $instance['buttonText'];
    $buttonLink = $instance['buttonLink'];

    //display
    echo $before_widget;
    echo empty($phoneNumber) || empty($phoneText) ? '' : '<p class="phone-title">'. $phoneText .'</p>';
    echo empty($phoneNumber) ? '' : '<a class="phone" href="tel:'. $phoneNumber .'">+1 '. $phoneNumber .'</a>';
    echo empty($email) || empty($emailText) ? '' : '<p class="email-title">'. $emailText .'</p>';
    echo empty($email) ? '' : '<a class="email" href="mailto:'. $email .'">'. $email .'</a>';
    echo empty($buttonLink) || empty($buttonText) ? '' : '<a href="'. $buttonLink .'" class="button">' . $buttonText .'</a>';
    echo $after_widget;
  }

}

add_action ('widgets_init', function () {
  register_widget('Aero_MoreInformation');
});