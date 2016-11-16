<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a contact information section element to Visual Composer.
 */

class ContactInfo {
  function __construct ($namespace = "", $category = "") {
    $this->name = "contactInfo";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Contact Information",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Contact Information',
      "params" => array(
        array(
          "type" => "checkbox",
          "holder" => "div",
          "class" => "",
          "param_name" => "contact_labels",
          'value' => array('Show Labels' => true),
          "description" => 'Choose if you want to show a label next to each item.'
        ),
        array(
          "type" => "checkbox",
          "holder" => "div",
          "class" => "",
          "param_name" => "contact_name",
          'value' => array('Show contact name' => true),
          "description" => 'Choose if you want to show the contact name.'
        ),
        array(
          "type" => "checkbox",
          "holder" => "div",
          "class" => "",
          "param_name" => "contact_title",
          'value' => array('Show contact title' => true),
          "description" => 'Choose if you want to show the contact title.'
        ),
        array(
          "type" => "checkbox",
          "holder" => "div",
          "class" => "",
          "param_name" => "contact_address",
          'value' => array('Show contact address' => true),
          "description" => 'Choose if you want to show the contact address.'
        ),
        array(
          "type" => "checkbox",
          "holder" => "div",
          "class" => "",
          "param_name" => "contact_phone",
          'value' => array('Show contact phone number' => true),
          "description" => 'Choose if you want to show the contact phone.'
        ),
        array(
          "type" => "checkbox",
          "holder" => "div",
          "class" => "",
          "param_name" => "contact_email",
          'value' => array('Show contact email' => true),
          "description" => 'Choose if you want to show the contact email.'
        ),
        array(
          "type" => "checkbox",
          "holder" => "div",
          "class" => "",
          "param_name" => "contact_twitter",
          'value' => array('Show contact twitter handle' => true),
          "description" => 'Choose if you want to show the contact twitter handle.'
        )
      )
    );
  }

  public function setHtmlTemplatePath ($template) {
    $this->templatePath = $template;
  }

  public function getTemplate ($atts, $content) {
    extract( shortcode_atts( array(
      'contact_labels' => false,
      'contact_name' => false,
      'contact_title' => false,
      'contact_address' => false,
      'contact_phone' => false,
      'contact_email' => false,
      'contact_twitter' => false
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}