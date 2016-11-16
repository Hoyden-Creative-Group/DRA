<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a google maps element to Visual Composer.
 */

class GoogleMaps {
  function __construct ($namespace = "", $category = "") {
    $this->name = "googleMaps";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Google Maps",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Google maps',
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => "Map Address",
          "param_name" => "map_address",
          "holder" => "div",
          "value" => get_option('address')
        ),
        array(
          "type" => "textfield",
          "heading" => "Zoom Level",
          "param_name" => "zoom",
          "holder" => "div",
          "description" => "Any number between 0-19 (19 being the closest zoom level)"
        ),
        array(
          "type" => "textfield",
          "heading" => "Marker Title",
          "param_name" => "marker",
          "holder" => "div",
          "description" => "The title shown when the map marker is clicked"
        ),
        array(
          "type" => "textfield",
          "heading" => "Google API Key",
          "param_name" => "api_key",
          "holder" => "div",
          "description" => 'More info <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>'
        ),
        array(
          "type" => "textfield",
          "heading" => "Extra class name",
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
      'map_address' => '',
      'zoom' => '',
      'marker' => '',
      'api_key' => '',
      'class' => ''
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}