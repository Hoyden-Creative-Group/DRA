<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for HTML5Video
 */
?>

<?php ob_start() ;?>

<div class="video-wrapper">
  <div class="video-container">
    <video playsinline autoplay muted loop id="bgvid" poster="<?php echo $video_poster; ?>">
      <source src="<?php echo $video_webm; ?>" type="video/webm">
      <source src="<?php echo $video_mp4; ?>" type="video/mp4">
    </video>
  </div>
</div>

<?php
  $output = ob_get_clean();
  return $output;