<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a "latest meeting" element to Visual Composer.
 */

class LatestMeeting {
  function __construct ($namespace = "", $category = "") {
    $this->name = "latestMeeting";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Latest Meeting",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Latest Meeting',
      "params" => array(
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
      'class' => ''
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}