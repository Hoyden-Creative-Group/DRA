<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for TestimonialsSlideshow
 */

  wp_enqueue_script( 'aero_testimonials' );

  $testimonials = get_testimonials($number, $category);
  $id = $uuid;

  ob_start();

  if (empty($testimonials)) {
    echo '<p style="text-align: center; font-size: 30px; font-weight: bold;">No Testimonails</p>';
  } else {
?>

<script>
  if (!window.aero_testimonials) {
    window.aero_testimonials = {};
  }
  window.aero_testimonials["<?php echo $id; ?>"] = {
    id: "<?php echo $id; ?>",
    testimonials: <?php echo json_encode($testimonials); ?>,
    duration:  <?php echo $duration * 1000; ?>
  };
</script>

<div id="testimonial-slideshow-<?php echo $id; ?>" class="aero-testimonial-slideshow <?php echo $class; ?>" style="background-image: url(<?php echo wp_get_attachment_image_src( $image, 'full' )[0]; ?>);">
  <?php echo empty($title) ? '' : '<h2>'. $title .'</h2>'; ?>
  <div class="aero-slider">
    <div class="aero-nav aero-left icon-nav1-arrow-left hidden"></div>
    <div class="aero-testimonial-wrapper hidden">
      <p class="aero-testimonial"></p>
      <p class="aero-author"></p>
    </div>
    <div class="aero-nav aero-right icon-nav1-arrow-right hidden"></div>
  </div>
</div>

<?php
  }

  $output = ob_get_clean();
  return $output;