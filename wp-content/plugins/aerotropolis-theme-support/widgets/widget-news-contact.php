<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom widget for showing news contact information.
 */

class Aero_NewsContact extends WP_Widget {

  protected $defaults;

  public function __construct () {
    $this->defaults = array(
      'title'      => '',
      'photo'      => '',
      'email'      => '',
      'phone'      => '',
      'twitter'    => '',
      'buttonText' => '',
      'buttonLink' => ''
    );

    $options = array(
      'classname'   => 'aero_news_contact',
      'description' => 'News contact widget',
    );

    $this->WP_Widget('aero_newscontact', 'Aerotropolis News Contact', $options);

    add_action( 'admin_head-widgets.php', array( $this, 'newscontact_head' ) );
    add_action( 'sidebar_admin_setup', array( $this, 'newscontact_setup' ) );
  }

  public function newscontact_setup() {
    wp_enqueue_media();
    wp_enqueue_script('upload_media_widget', plugins_url('js/newsContactMedia.js', __FILE__), array('jquery', 'media-upload', 'media-views'));
  }

  public function newscontact_head() {
    ?>
  <style type="text/css">
    .aero_news_contact_preview img{
      max-width: 300px;
      max-height: 200px;
    }

  </style>
  <?php
  }

  public function form($instance){
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    $idPrefix = $this->get_field_id('');

    $title = $instance['title'];
    $attachmentID = $instance['attachmentID'];
    $imageURL = $instance['imageURL'];
    $email = $instance['email'];
    $phone = $instance['phone'];
    $twitter = $instance['twitter'];
    $buttonText = $instance['buttonText'];
    $buttonLink = $instance['buttonLink'];
    ?>

    <p><label for="<?php echo $this->get_field_id('title'); ?>">Text: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

    <div>
      <label>
        <p>Image:</p>
        <div id="<?php echo $this->get_field_id('preview'); ?>" class="aero_news_contact_preview">
          <?php echo '<img src="'. $imageURL .'" />'; ?>
        </div>
        <p><input class="upload_image_button button button-primary" type="button" value="Select Image" onclick="imageWidget.uploader( '<?php echo $idPrefix; ?>', '<?php echo abs($instance['attachmentID']); ?>' ); return false;" /></p>
      </label>
      <input type="hidden" id="<?php echo $this->get_field_id('attachmentID'); ?>" name="<?php echo $this->get_field_name('attachmentID'); ?>" value="<?php echo abs($instance['attachmentID']); ?>" />
      <input type="hidden" id="<?php echo $this->get_field_id('imageURL'); ?>" name="<?php echo $this->get_field_name('imageURL'); ?>" value="<?php echo $instance['imageURL']; ?>" />
    </div>

    <?php /*
    <p><label for="<?php echo $this->get_field_id('email'); ?>">Email: <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo attribute_escape($email); ?>" /></label></p>

    <p><label for="<?php echo $this->get_field_id('phone'); ?>">Phone Number: <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo attribute_escape($phone); ?>" /></label></p>

    <p><label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter handle: <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo attribute_escape($twitter); ?>" /></label></p>
    */ ?>

    <p><label for="<?php echo $this->get_field_id('buttonText'); ?>">Button text: <input class="widefat" id="<?php echo $this->get_field_id('buttonText'); ?>" name="<?php echo $this->get_field_name('buttonText'); ?>" type="text" value="<?php echo attribute_escape($buttonText); ?>" /></label></p>

    <p><label for="<?php echo $this->get_field_id('buttonLink'); ?>">Button link: <input class="widefat" id="<?php echo $this->get_field_id('buttonLink'); ?>" name="<?php echo $this->get_field_name('buttonLink'); ?>" type="text" value="<?php echo attribute_escape($buttonLink); ?>" /></label></p>

    <?php
  }

  public function update($new_instance, $old_instance){
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['attachmentID'] = $new_instance['attachmentID'];
    $instance['imageURL'] = $new_instance['imageURL'];
    // $instance['email'] = $new_instance['email'];
    // $instance['phone'] = $new_instance['phone'];
    // $instance['twitter'] = $new_instance['twitter'];
    $instance['buttonText'] = $new_instance['buttonText'];
    $instance['buttonLink'] = $new_instance['buttonLink'];
    return $instance;
  }

  public function widget($args, $instance){
    extract($args, EXTR_SKIP);

    //get vars
    $title = $instance['title'];
    $imageURL = $instance['imageURL'];
    $email = get_option('email');
    $phone = get_option('phone_number');
    $twitter = get_option('twitter');
    $buttonText = $instance['buttonText'];
    $buttonLink = $instance['buttonLink'];

    //display
    echo $before_widget;
    echo empty($title) ? '' : '<h5>'. $title .'</h5>';
    echo empty($imageURL) ? '' : '<p class="image"><img src="'. esc_url($imageURL) .'" /></p>';
    echo empty($email) ? '' : '<p class="email"><a href="mailto:'. $email .'">'. $email .'</a></p>';
    echo empty($phone) ? '' : '<p class="phone"><a href="tel:'. $phone .'">+1 '. $phone .'</a></p>';
    echo empty($twitter) ? '' : '<p class="twitter"><a href="https://twitter.com/'. preg_replace("/^@/", "", $twitter) .'">'. $twitter .'</a></p>';
    echo empty($buttonLink) ? 'no button' : '<p class="news-button"><a href="'. $buttonLink .'">'. $buttonText .'</a></p>';
    echo $after_widget;
  }

}

add_action ('widgets_init', function () {
  register_widget('Aero_NewsContact');
});