<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom element called Card.  This is a teaser
 * section to highlight a specific items about Aerotropolis.
 */


class CardItem {
  function __construct ($namespace = "", $category = "") {
    $this->name = "card_item";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Card item",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Card item',
      "params" => array(
        array(
          "type" => "dropdown",
          "holder" => "div",
          "heading" => "Icon",
          "param_name" => "icon",
          'value' => array_flip(
            array(
              '' => 'None',
              'map-marker' => 'Map Marker',
              'trophy' => 'Trophy',
              'workforce' => 'People',
              'cellbars' => 'Celluar Bars',
              'road' => 'Highway',
              'megaphone' => 'Megaphone',
              'plane' => 'Plane',
              'cargo-plane' => 'Cargo Plane',
            )
          )
        ),
        array(
          "type" => "textfield",
          "heading" => "Title",
          "param_name" => "title",
          "holder" => "div"
        ),
        array(
          "type" => "textarea",
          "heading" => "Description",
          "param_name" => "description",
          "holder" => "div"
        ),
        array(
          "type" => "checkbox",
          "holder" => "div",
          "class" => "",
          "param_name" => "custom_html",
          'value' => array('Custom HTML' => true),
          "description" => 'Check the box if there is HTML in above textarea'
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
      'icon' => '',
      'title' => '',
      'description' => '',
      'custom_html' => '',
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
