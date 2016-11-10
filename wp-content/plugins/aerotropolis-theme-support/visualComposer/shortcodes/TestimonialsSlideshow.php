<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a testimonials slideshow player.  Testimonials come from
 * the Testimonials post_type and the user can choose whichever
 * category of testimonials to showcase.
 */

class TestimonialsSlideshow {
  function __construct ($namespace = "", $category = "") {
    $this->name = "testimonials_slideshow";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "Testimonials Slideshow",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'Testimonials Slideshow',
      "params" => array(
        array(
          "type" => "attach_image",
          "holder" => "div",
          "class" => "",
          "heading" => "Background Image",
          "param_name" => "image"
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "heading" => "Title",
          "param_name" => "title"
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "heading" => 'Number',
          "param_name" => "number",
          "description" => 'Enter Number of Testimonials to Show.'
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "heading" => 'Duration',
          "param_name" => "duration",
          "description" => 'Number of seconds to show each slide.'
        ),
        array(
          "type" => "dropdown",
          "holder" => "div",
          "heading" => 'Category',
          "param_name" => "category",
          "value" => $this->_getCategories('testimonial-categories')
        ),
        array(
          "type" => "textfield",
          "holder" => "div",
          "heading" => "Additional Class",
          "param_name" => "class"
        ),
      )
    );
  }

  public function setHtmlTemplatePath ($template) {
    $this->templatePath = $template;
  }

  public function getTemplate ($atts, $content) {
    extract( shortcode_atts( array(
      'image' => 'image',
      'title' => 'title',
      'number' => 'number',
      'duration' => 'duration',
      'category' => 'category',
      'class' => 'class'
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }

  private function _getCategories ($category) {
    $catgories = get_terms( array('taxonomy' => $category));
    $slugs = [];

    $slugs["Select Category"] = "";

    foreach ($catgories as $cat) {
      $slugs[$cat->name] = $cat->slug;
    }

    return $slugs;
  }
}