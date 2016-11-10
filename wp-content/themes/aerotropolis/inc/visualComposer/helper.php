<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Helper file for Visual Composer custom templates
 */

function getButton($key, $class){
  // get button props
  $href = vc_build_link( $key );

  // sanitize the visual composer return values
  $button["url"] = trim($href['url']);
  $button["title"] = trim($href["title"]);
  $button["target"] = trim($href["target"]);
  $button["rel"] = trim($href["rel"]);

  // build a button link
  $target = empty($button["target"]) ? '' : ' target="'. $button["target"] .'"';
  $rel = empty($button["rel"]) ? '' : ' rel="'. $button["rel"] .'"';
  $button["button"] = '<a class="'.$class.'" href="'. $button["url"] .'"'. $rel . $target .'>'. $button["title"] .'</a>';

  // build an onclick handler

  // this will open the URL in the current tab
  $button["onclick"] = empty($button["url"]) ? '' : "window.location.href='". $button["url"] ."'";

  // this will TRY to open the URL in a new tab
  if ($button["target"] == '_blank' && !empty($button["url"])) {
    $button["onclick"] = "window.open('". $button["url"] ."','_blank')";
  }

  return $button;
}