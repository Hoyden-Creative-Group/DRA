<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom element called ImageTeaser.  This is a teaser
 * section to highlight a specific items about Aerotropolis with a
 * main image and title that links to someplace.
 */


class ImageTeaser {
  function __construct ($namespace = "", $category = "") {
    $this->name = "image_teaser";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Image Teaser",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Image Teaser',
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
          "type" => "vc_link",
          "heading" => "Button",
          "param_name" => "button1",
          "holder" => "div",
          "description" => "No button will actually show. Use this to link the
            teaser to some place in the site."
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
