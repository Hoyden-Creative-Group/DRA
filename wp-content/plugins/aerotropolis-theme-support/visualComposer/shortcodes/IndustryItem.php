<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom element called Industry Item.  This is a teaser
 * section to highlight a specific industry.
 */

class IndustryItem {
  function __construct ($namespace = "", $category = "") {
    $this->name = "industry_item";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Industry Item",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Industry Item',
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
          "heading" => "Button",
          "param_name" => "button1",
          "holder" => "div"
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
      'image' => '',
      'title' => '',
      'summary' => '',
      'button1' => '',
      'class' => ''
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}