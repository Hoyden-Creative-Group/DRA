<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * This adds a custom data field to any number of pages.  To add it to a page,
 * add the page screen slug to the $_allowedScreens array.
 */

function aero_seondarynav_metabox() {
  new Aero_SecondaryNav();
}

if ( is_admin() ) {
  add_action('load-post.php', 'aero_seondarynav_metabox');
  add_action('load-post-new.php', 'aero_seondarynav_metabox');
}


/**
 * Class to add testimonials metaboxes
 */
class Aero_SecondaryNav {

  /**
    * Whitelist for allowed post types to show this metabox
    */
  private $_allowedScreens = array(
    'page'
  );


  /**
   * Constructor
   */
  public function __construct() {
    $this->metaBoxErrorParam = 'meta-error';

    add_action('add_meta_boxes', array( $this, 'add_meta_box' ));
    add_action('save_post', array( $this, 'save' ) );
    // add_action('edit_form_top', array($this, 'customErrors'));
  }


  /**
   * Add metabox for each allowed screen
   *
   */
  public function add_meta_box() {
    foreach ( $this->_allowedScreens as $screen ) {
      add_meta_box(
        'aero-secondary-nav',
        'Secondary Navigation',
        array( $this, 'render_meta_box_content' ),
        $screen,
        'side',
        'low'
      );
    }
  }


  /**
   * The HTML metabox for the screen
   */
  public function render_meta_box_content( $post ) {
    wp_nonce_field( 'aero_secondary_nav', 'aero_secondary_nav_nonce' );

    // get our variables
    $secondaryNav = get_post_meta( $post->ID, 'aero-secondary-nav', true );
    $menus = get_registered_nav_menus();
    ?>

    <p><em>Select an optional secondary menu</em></p>
    <p>
      <select id="aero_secondary_nav_menu" name="aero_secondary_nav_menu">
        <option value>None</option>
        <?php
          foreach ($menus as $key => $value) {
            $selected = $key == $secondaryNav ? ' selected' : '';
            echo '<option value="'. $key .'"'. $selected .'>'. $value .'</option>';
          }
        ?>
      </select>
    </p>

    <?php
  }


  /**
   * Save method for the metabox
   */
  public function save( $post_id ) {
    // verify the nonce is set
    if ( ! isset( $_POST['aero_secondary_nav_nonce'] ) ) {
      return $post_id;
    }

    // verify the nonce is valid
    if ( ! wp_verify_nonce( $_POST['aero_secondary_nav_nonce'], 'aero_secondary_nav' ) ) {
      return $post_id;
    }

    // if this is an autosave, don't do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return $post_id;
    }

    // verify the user permissions
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return $post_id;
      }
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
      }
    }

    // get our variables
    $seondaryNav = isset( $_POST['aero_secondary_nav_menu'] ) ? $_POST['aero_secondary_nav_menu'] : "";

    // Error handling
    // if (empty($seondaryNav)) {
    //   // throw an error
    //   add_filter('redirect_post_location', function($loc) {
    //     return add_query_arg( $this->metaBoxErrorParam, 1, $loc );
    //   });
    //   return $post_id;
    // }

    // update the metadata field
    update_post_meta( $post_id, 'aero-secondary-nav', $seondaryNav );
  }


  /**
   * Metabox error handling when screen is saved
   */
  // public function customErrors() {
  //   if (isset($_GET[$this->metaBoxErrorParam])) {
  //     $screen = get_current_screen();

  //     // Make sure we are in the proper post type
  //     if (in_array($screen->post_type, $this->_allowedScreens)) {
  //       $errorCode = (int)$_GET[$this->metaBoxErrorParam];

  //       switch($errorCode) {
  //         case 1:
  //           $this->_showCustomError('Invalid author field');
  //           break;
  //       }
  //     }
  //   }
  //}


  /**
   * HTML to show the error message
   */
  /*private function _showCustomError($message, $type='error') {
    ?>
    <div class="<?php esc_attr_e($type); ?> below-h2">
      <p><?php echo $message; ?></p>
    </div>
    <?php
  }*/
}
