function AeroTestimonial(id, testimonials, duration) {
  var _this = this;

  this.id = id;
  this.content = testimonials;
  this.total = testimonials.length;
  this.duration = duration;
  this.currentIndex = 0;
  this.timer = 0;

  jQuery(function($) {
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

if (window.aero_testimonials){
  for (var key in window.aero_testimonials) {
    var slideshow = window.aero_testimonials[key];
    new AeroTestimonial(slideshow.id, slideshow.testimonials, slideshow.duration);
  }
}