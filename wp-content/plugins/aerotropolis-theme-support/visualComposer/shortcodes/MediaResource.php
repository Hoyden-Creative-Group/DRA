<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom element called MediaResource
 */

class MediaResource {
  function __construct ($namespace = "", $category = "") {
    $this->name = "media_resource";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Media Resource",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Media Resource',
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
          "type" => "textfield",
          "heading" => "Asset Link",
          "param_name" => "asset_link",
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
      'asset_link' => ''
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}