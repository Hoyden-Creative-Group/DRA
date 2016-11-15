<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a specific section called "Why Choose Detroit".
 */

class WhyChooseDetroit {
  function __construct ($namespace = "", $category = "") {
    $this->name = "why_detroit";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Why Choose Detroit",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Why Choose Detroit',
      "params" => array(
        array(
          "type" => "attach_image",
          "holder" => "div",
          "class" => "",
          "heading" => "Image",
          "param_name" => "image"
        ),
        array(
          "type" => "textfield",
          "heading" => "Title",
          "param_name" => "title",
          "holder" => "div"
        ),
        array(
          "type" => "textarea",
          "heading" => "Summary",
          "param_name" => "summary",
          "holder" => "div"
        ),
        array(
          "type" => "vc_link",
          "heading" => "Button 1",
          "param_name" => "button1",
          "holder" => "div"
        ),
        array(
          "type" => "vc_link",
          "heading" => "Button 2",
          "param_name" => "button2",
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
      'image' => '',
      'title' => '',
      'summary' => '',
      'button1' => '',
      'button2' => ''
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}