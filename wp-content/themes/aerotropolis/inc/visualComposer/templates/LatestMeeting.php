<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for LatestMeeting
 */

  $class = empty($class) ? '' : ' '. $class;
  $latestMeeting = get_latest_meeting();
?>

<?php ob_start() ;?>

<div class="latest-meeting<?php echo $class; ?>">
  <div class="meeting-wrapper">
    <?php if (!empty($latestMeeting['title'])){ echo '<h1 class="title">'. $latestMeeting['title'] .'</h1>'; } ?>
    <?php if (!empty($latestMeeting['date'])){ echo '<p class="date">'. $latestMeeting['date'] .'</p>'; } ?>
    <div class="latest-news-post">
      <?php echo $latestMeeting['post']; ?>
    </div>
    <p class="latest-news-link"><a class="button" href="<?php echo $latestMeeting['permalink']; ?>">Read More</a></p>
  </div>
</div>

<?php
  $output = ob_get_clean();
  return $output;