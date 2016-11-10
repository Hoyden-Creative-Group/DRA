<?php

/**
 * @package Aerotropolis Theme Support Plugin
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Adds a custom video element to Visual Composer.
 */

class Html5Video {
  function __construct ($namespace = "", $category = "") {
    $this->name = "html5_video";
    $this->namespace = $namespace;
    $this->category = $category;
    $this->templatePath = '';
  }

  public function getName () {
    return $this->namespace . $this->name;
  }

  public function getComponent () {
    return array(
      "name" => "HTML5 Video",
      "base" => $this->getName(),
      "class" => "",
      "category" => $this->category,
      "description" => 'HTML5 Video',
      "params" => array(
        array(
          "type" => "attach_image",
          "holder" => "div",
          "class" => "",
          "heading" => "Video Poster Image",
          "param_name" => "video_poster",
          "description" => "Poster image of the video while it loads"
        ),
        array(
          "type" => "textfield",
          "heading" => "Mp4 Video Link",
          "param_name" => "video_mp4",
          "holder" => "div"
        ),
        array(
          "type" => "textfield",
          "heading" => "WebM Video Link",
          "param_name" => "video_webm",
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
      'video_poster' => 'video_poster',
      'video_mp4' => 'video_mp4',
      'video_webm' => 'video_webm'
    ), $atts ) );

    $output = '';

    if (strlen($this->templatePath)) {
      $output = include( $this->templatePath );
    }

    return $output;
  }
}