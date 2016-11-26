<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom widget for signing up for a newsletter (used in the footer).
 */

class Aero_Newsletter extends WP_Widget {

  protected $defaults;

  public function __construct () {
    $this->defaults = array(
      'text1'      => '',
      'text2'      => '',
      'buttonText' => ''
    );

    $options = array(
      'classname'   => 'aero_newsletter',
      'description' => 'Newsletter widget',
    );

    parent::__construct('aero_newsletter', 'Aerotropolis Newsletter', $options);

    // register our ajax hook
    add_action('wp_ajax_aero_newsletter_subscribe', array( $this, 'aero_newsletter_ajax'));
  }

  public function form($instance){
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    $text1 = $instance['text1'];
    $text2 = $instance['text2'];
    $buttonText = $instance['buttonText'];
    ?>

    <p><label for="<?php echo $this->get_field_id('text1'); ?>">Text: <input class="widefat" id="<?php echo $this->get_field_id('text1'); ?>" name="<?php echo $this->get_field_name('text1'); ?>" type="text" value="<?php echo esc_attr($text1); ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('text2'); ?>">Text: <input class="widefat" id="<?php echo $this->get_field_id('text2'); ?>" name="<?php echo $this->get_field_name('text2'); ?>" type="text" value="<?php echo esc_attr($text2); ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('buttonText'); ?>">Button Text: <input class="widefat" id="<?php echo $this->get_field_id('buttonText'); ?>" name="<?php echo $this->get_field_name('buttonText'); ?>" type="text" value="<?php echo esc_attr($buttonText); ?>" /></label></p>

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
    $apiKey = get_option('mailchimp_api_key');
    $listID = get_option('mailchimp_list_id');

    if (empty($apiKey) || empty($listID)) {
      echo "Missing API Key and/or list ID.";
      return;
    }

    // register our javascript needed for the widget
    wp_enqueue_script('aero_news_subscribe', plugins_url('js/newsletterSignup.js', __FILE__), array('jquery'));

    //get vars
    extract($args, EXTR_SKIP);
    $text1 = $instance['text1'];
    $text2 = $instance['text2'];
    $buttonText = $instance['buttonText'];

    //display
    echo $before_widget;
    echo empty($text1) ? '' : '<p class="text1">'. $text1 .'</p>';
    echo empty($text2) ? '' : '<p class="text2">'. $text2 .'</p>';
    echo '<form action="'. site_url() .'/wp-admin/admin-ajax.php" class="aero-mailchimp-widget" method="post">';
      echo '<div class="message"></div>';
      echo '<input type="email" placeholder="Email address" name="email" class="email" />';
      echo '<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_0dd5b3bdf1d979b7b8d558fd3_038174d146" tabindex="-1" value=""></div>';
      echo '<input type="hidden" name="action" value="aero_newsletter_subscribe" />';
      echo '<input type="submit" class="btn" data-value="'.$buttonText.'" value="'. $buttonText .'" />';
    echo '</form>';
    echo $after_widget;
  }

  /**
   * Form submission called by ajax.  Expected return is JSON.
   */
  function aero_newsletter_ajax(){
    if (empty($_POST['email'])) {
      $result = array(
        'success' => false,
        'error' => true,
        'message' => "Invalid email"
      );
      echo json_encode($result);
      die(); // needed for successful ajax requests, else appends a '0' to the response.
    }

    $apiKey = get_option('mailchimp_api_key');
    $listID = get_option('mailchimp_list_id');

    $result = aero_mailchimp_do_subscribe($apiKey, $listID, $_POST['email']);

    if (is_array($result)) {
      echo json_encode($result);
      die(); // needed for successful ajax requests, else appends a '0' to the response.
    }

    echo $result;
    die(); // needed for successful ajax requests, else appends a '0' to the response.
  }

}

add_action ('widgets_init', function () {
  register_widget('Aero_Newsletter');
});