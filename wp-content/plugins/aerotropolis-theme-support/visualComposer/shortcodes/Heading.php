<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom heading element to Visual Composer.
 */

class Heading {
  function __construct ($namespace = "", $category = "") {
    $this->name = "heading";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Heading",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Heading',
      "params" => array(
        array(
          "type" => "dropdown",
          "holder" => "div",
          "heading" => "Heading type",
          "param_name" => "heading",
          'value' => array_flip(
            array(
              '' => 'Select Options',
              'h1' => 'H1',
              'h2' => 'H2',
              'h3' => 'H3',
              'h4' => 'H4',
              'h5' => 'H5',
              'h6' => 'H6'
            )
          )
        ),
        array(
          "type" => "textfield",
          "heading" => "Heading text",
          "param_name" => "text",
          "holder" => "div"
        ),
        array(
          "type" => "textfield",
          "heading" => "Additional class name",
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
      'heading' => 'heading',
      'text' => 'text',
      'class' => 'class'
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}