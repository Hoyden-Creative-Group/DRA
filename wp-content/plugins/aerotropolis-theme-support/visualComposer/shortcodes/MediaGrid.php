<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom grid element.
 */


class MediaGrid {
  function __construct ($namespace = "", $category = "") {
    $this->name = "aero_media_grid";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Media Grid",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Media Grid',
      "params" => array(
        array(
          "type" => "attach_images",
          "heading" => "Select your images",
          "param_name" => "media",
          "holder" => "div"
        ),
        array(
          "type" => "dropdown",
          "holder" => "div",
          "heading" => "Select number of columns",
          "param_name" => "columns",
          'value' => array_flip(
            array(
              1 => 1,
              2 => 2,
              3 => 3,
              4 => 4,
              5 => 5,
              6 => 6
            )
          )
        ),
        array(
          "type" => "textfield",
          "heading" => "Additional class",
          "param_name" => "class",
          "holder" => "div"
        )
      )
    );
  }

  public function setHtmlTemplatePath ($template) {
    $this->templatePath = $template;
  }

  public function getTemplate ($atts, $content) {
    extract( shortcode_atts( array(
      'media' => array(),
      'columns' => 1,
      'class' => ''
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}
