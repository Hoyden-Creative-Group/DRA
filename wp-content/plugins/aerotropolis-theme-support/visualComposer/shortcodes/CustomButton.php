<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom button element to Visual Composer.
 */

class CustomButton {
  function __construct ($namespace = "", $category = "") {
    $this->name = "customButton";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Button",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Button',
      "params" => array(
        array(
          "type" => "dropdown",
          "holder" => "div",
          "heading" => "Button type",
          "param_name" => "type",
          'value' => array_flip(
            array(
              '' => 'Select Options',
              'flat' => 'Flat',
              'outline' => 'Outline'
            )
          )
        ),
        array(
          "type" => "dropdown",
          "holder" => "div",
          "heading" => "Color",
          "param_name" => "color",
          'value' => array_flip(
            array(
              '' => 'Select Options',
              'lightblue' => 'Light Blue',
              'blue' => 'Blue',
              'grey' => 'Grey',
              'darkgrey' => 'Dark Grey'
            )
          )
        ),
        array(
          "type" => "vc_link",
          "heading" => "Button Link",
          "param_name" => "button",
          "holder" => "div"
        ),
        array(
          "type" => "textfield",
          "heading" => "Additional class names",
          "param_name" => "class",
          "holder" => "div"
        ),
      )
    );
  }

  public function setHtmlTemplatePath ($template) {
    $this->templatePath = $template;
  }

  public function getTemplate ($atts, $content) {
    extract( shortcode_atts( array(
      'type' => '',
      'color' => '',
      'button' => '',
      'class' => ''
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}