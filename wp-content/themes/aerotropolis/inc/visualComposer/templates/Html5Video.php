<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for HTML5Video
 */
?>

<?php ob_start() ;?>

<div id="home-video" class="video-wrapper">
  <div class="video-container">

    <div class="video-overlay" style="background-image: url(<?php echo wp_get_attachment_image_src( $video_poster, 'full' )[0]; ?>)">
      <div class="icon-play-button"></div>
      <?php echo empty($video_slide_to) ? "" : '<div class="icon-down-arrow scroll-down" data-slide-to="'. $video_slide_to .'"></div>'; ?>
    </div>

    <video muted loop id="aero-home-video">
      <source src="<?php echo $video_webm; ?>" type="video/webm">
      <source src="<?php echo $video_mp4; ?>" type="video/mp4">
    </video>
  </div>
</div>

<?php
  $output = ob_get_clean();
  return $output;