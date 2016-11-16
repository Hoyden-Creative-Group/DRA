<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a contact form element to Visual Composer.
 */

class ContactForm {
  function __construct ($namespace = "", $category = "") {
    $this->name = "contactForm";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Contact Form",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Contact Form',
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => "Email address",
          "param_name" => "contact_email",
          "holder" => "div",
          "description" => "Where to send the form submissions to"
        ),
        array(
          "type" => "textfield",
          "heading" => "Captcha site key",
          "param_name" => "captcha_site_key",
          "holder" => "div"
        ),
        array(
          "type" => "textfield",
          "heading" => "Captcha secret",
          "param_name" => "captcha_secret",
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
      'contact_email' => '',
      'captcha_site_key' => '',
      'captcha_secret' => ''
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}