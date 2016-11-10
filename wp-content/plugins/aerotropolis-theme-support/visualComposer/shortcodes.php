<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * This adds custom elements to Visual Composer by looking in the local
 * "shortcodes/" directory.  It will then try to load the file/class as
 * well as an associated template located in the activated theme.  If
 * there is a template for the class, it will add it as a Visual Composer
 * element.  It's important to note that the file names in the shortcodes
 * directory must match the class name as well as the template names in
 * the activated theme.
 */

function addCustomVisualComposerElements () {

  $dir = dirname(__FILE__) . '/shortcodes/*.php';
  $namespace = "aero_";
  $category = "Aerotropolis"; // The tab name within Visual Composer
  $templateDirectory = get_template_directory();

  foreach (glob($dir) as $filename) {
    // Calculate the class name from the file name
    $className = basename($filename, '.php');

    // Check if there is HTML template made for the class in the theme
    $template = $templateDirectory . '/inc/visualComposer/templates/'. $className .'.php';

    // If there is no HTML template, ignore this Visual Composer element
    if (!file_exists($template)) {
      continue;
    }

    // pull in the Visual Composer element class
    include $filename;

    // instantiate the class
    $element = new $className($namespace, $category);

    // set the template
    $element->setHtmlTemplatePath( $template );

    add_shortcode( $element->getName(), array($element, 'getTemplate') );

    // map the shortcode to visual composer
    if( function_exists( 'vc_map' ) ) {
      vc_map( $element->getComponent() );
    }
  }
}

add_action( 'vc_before_init', 'addCustomVisualComposerElements' );