<?php

/**
 * @package Aerotropolis Theme
 * @author  Bryan Stanley <bstanley.0811@gmail.com>
 *
 * Visual Composer template for TestimonialsSlideshow
 */

  $query_args = array(
    'post_type' => 'testimonials',
    'showposts' => $number,
    'orderby' => 'rand',
    'testimonial-categories' => $category
  );

  $query = new WP_Query($query_args);

  $testimonials = [];

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $author = get_post_meta( get_the_ID(), 'aero-author', true );
      $testimonial = get_the_content();

      array_push( $testimonials, array("testimonial" => $testimonial, "author" => $author));
    }
  }

  $id = random_int(1, 10);

  ob_start();

  if (empty($testimonials)) {
    echo '<p style="text-align: center; font-size: 30px; font-weight: bold;">No Testimonails</p>';
  } else {
?>

<script>
  var aeroTestimonials_<?php echo $id; ?> = <?php echo json_encode($testimonials); ?>;

  function AeroTestimonial(id, testimonials, duration) {
    var _this = this;

    this.id = id;
    this.content = testimonials;
    this.total = testimonials.length;
    this.duration = duration;
    this.currentIndex = 0;
    this.timer = 0;

    $(function() {
      _this.$slideshow = $('#testimonial-slideshow-' + _this.id);
      _this.$wrapper = $('.aero-testimonial-wrapper', _this.$slideshow);
      _this.$testimonial = $('.aero-testimonial', _this.$slideshow);
      _this.$author = $('.aero-author', _this.$slideshow);

      $('.aero-left').on('click', _this.prevSlide.bind(_this));
      $('.aero-right').on('click', _this.nextSlide.bind(_this));

      $('.aero-nav', _this.$slideshow).removeClass('hidden');

      _this.showTestimonial();
    });
  }

  AeroTestimonial.prototype.nextSlide = function() {
    clearTimeout(this.timer);
    this.currentIndex++;
    this.currentIndex = this.currentIndex >= this.total ? 0 : this.currentIndex;
    this.loadTestimonial();
  };

  AeroTestimonial.prototype.prevSlide = function() {
    clearTimeout(this.timer);
    this.currentIndex--;
    this.currentIndex = this.currentIndex < 0 ? this.total - 1 : this.currentIndex;
    this.loadTestimonial();
  };

  AeroTestimonial.prototype.loadTestimonial = function() {
    this.$wrapper.addClass('hidden');
    this.$wrapper.one("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", this.showTestimonial.bind(this));
  };

  AeroTestimonial.prototype.showTestimonial = function() {
    var _this = this;
    this.$testimonial.text(this.content[this.currentIndex].testimonial);
    this.$author.html('&mdash; ' + this.content[this.currentIndex].author);
    this.$wrapper.removeClass('hidden');

    this.$wrapper.one("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
      _this.timer = setTimeout(_this.nextSlide.bind(_this), _this.duration);
    });
  };

  new AeroTestimonial(<?php echo $id.', aeroTestimonials_'. $id .', '. $duration * 1000; ?>);


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

  wp_reset_postdata();
  $output = ob_get_clean();
  return $output;