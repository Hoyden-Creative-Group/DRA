<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * This adds a custom data field to any number of pages.  To add it to a page,
 * add the page screen slug to the $_allowedScreens array.
 */

function aero_testimonials_metabox() {
  new Aero_Testimonials();
}

if ( is_admin() ) {
  add_action('load-post.php', 'aero_testimonials_metabox');
  add_action('load-post-new.php', 'aero_testimonials_metabox');
}


/**
 * Class to add testimonials metaboxes
 */
class Aero_Testimonials {

  /**
    * Whitelist for allowed post types to show this metabox
    */
  private $_allowedScreens = array(
    'testimonials'
  );


  /**
   * Constructor
   */
  public function __construct() {
    $this->metaBoxErrorParam = 'meta-error';

    add_action('add_meta_boxes', array( $this, 'add_meta_box' ));
    add_action('save_post', array( $this, 'save' ) );
    add_action('edit_form_top', array($this, 'customErrors'));
  }


  /**
   * Add metabox for each allowed screen
   *
   */
  public function add_meta_box() {
    foreach ( $this->_allowedScreens as $screen ) {
      add_meta_box(
        'aero-author-metabox',
        'Author',
        array( $this, 'render_meta_box_content' ),
        $screen,
        'advanced',
        'high'
      );
    }
  }


  /**
   * The HTML metabox for the screen
   */
  public function render_meta_box_content( $post ) {
    wp_nonce_field( 'aero_testimonials', 'aero_testimonials_nonce' );

    // get our variables
    $author = get_post_meta( $post->ID, 'aero-author', true );
    ?>

    <p><em>Enter the author name</em></p>
    <p><input type="text" class="widefat" id="aero_testimonial_author" name="aero_testimonial_author" value="<?php echo esc_html($author); ?>" placeholder="Author name"></p>

    <?php
  }


  /**
   * Save method for the metabox
   */
  public function save( $post_id ) {
    // verify the nonce is set
    if ( ! isset( $_POST['aero_testimonials_nonce'] ) ) {
      return $post_id;
    }

    // verify the nonce is valid
    if ( ! wp_verify_nonce( $_POST['aero_testimonials_nonce'], 'aero_testimonials' ) ) {
      return $post_id;
    }

    // if this is an autosave, don't do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return $post_id;
    }

    // verify the user permissions
    if ( isset($_POST['post_type']) && 'testimonials' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return $post_id;
      }
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
      }
    }

    // get our variables
    $author = isset( $_POST['aero_testimonial_author'] ) ? $_POST['aero_testimonial_author'] : "";

    // Error handling
    if (empty($author)) {
      // throw an error
      add_filter('redirect_post_location', function($loc) {
        return add_query_arg( $this->metaBoxErrorParam, 1, $loc );
      });
      return $post_id;
    }

    // update the metadata field
    update_post_meta( $post_id, 'aero-author', $author );
  }


  /**
   * Metabox error handling when screen is saved
   */
  public function customErrors() {
    if (isset($_GET[$this->metaBoxErrorParam])) {
      $screen = get_current_screen();

      // Make sure we are in the proper post type
      if (in_array($screen->post_type, $this->_allowedScreens)) {
        $errorCode = (int)$_GET[$this->metaBoxErrorParam];

        switch($errorCode) {
          case 1:
            $this->_showCustomError('Invalid author field');
            break;
        }
      }
    }
  }


  /**
   * HTML to show the error message
   */
  private function _showCustomError($message, $type='error') {
    ?>
    <div class="<?php esc_attr_e($type); ?> below-h2">
      <p><?php echo $message; ?></p>
    </div>
    <?php
  }
}
