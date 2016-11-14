<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom widget for signing up for a newsletter.
 */

class Aero_News_Subscribe extends WP_Widget {

  protected $defaults;

  public function __construct () {
    $this->defaults = array(
      'title'      => '',
      'text'       => '',
      'buttonText' => ''
    );

    $options = array(
      'classname'   => 'aero_news_subscribe',
      'description' => 'News Sidebar Newsletter Widget',
    );

    parent::__construct('aero_news_subscribe', 'Aerotropolis Sidebar Newsletter', $options);
  }

  public function form($instance){
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    $title = $instance['title'];
    $text = $instance['text'];
    $buttonText = $instance['buttonText'];
    ?>

    <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
    <p>
      <label for="<?php echo $this->get_field_id('text'); ?>">
        Text:
        <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" style="height: 120px;" name="<?php echo $this->get_field_name('text'); ?>"><?php echo attribute_escape($text); ?></textarea>
      </label>
    </p>
    <p><label for="<?php echo $this->get_field_id('buttonText'); ?>">Button Text: <input class="widefat" id="<?php echo $this->get_field_id('buttonText'); ?>" name="<?php echo $this->get_field_name('buttonText'); ?>" type="text" value="<?php echo attribute_escape($buttonText); ?>" /></label></p>

    <?php
  }

  public function update($new_instance, $old_instance){
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['text'] = $new_instance['text'];
    $instance['buttonText'] = $new_instance['buttonText'];
    return $instance;
  }

  public function widget($args, $instance){
    extract($args, EXTR_SKIP);

    //get vars
    $title = $instance['title'];
    $text = $instance['text'];
    $buttonText = $instance['buttonText'];

    //display
    echo $before_widget;
    echo empty($title) ? '' : '<h5>'. $title .'</h5>';
    echo empty($text) ? '' : '<p class="text">'. $text .'</p>';
    echo '<form method="post">';
      echo '<input type="text" placeholder="Email address" name="email" />';
      echo '<input type="submit" value="'. $buttonText .'" />';
    echo '</form>';
    echo $after_widget;
  }

}

add_action ('widgets_init', function () {
  register_widget('Aero_News_Subscribe');
});