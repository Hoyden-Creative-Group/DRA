$(function() {

  /**
   * Main Menu
   */
  $('#menu-main-menu').superfish({
    autoArrows: false
  });

  /**
   * Sticky Menu
   */
  var $window = $(window),
      $this = $(this),
      $mainNav = $('.main-nav'),
      isSticky = false,
      menuOffset = $('.secondary-nav').height();

  var handleWindowScroll = function() {
    if ($this.scrollTop() > menuOffset) {
      if(!isSticky){
        $mainNav.addClass('sticky');
        isSticky = true;
      }
      return;
    }

    if(isSticky){
      isSticky = false;
      $mainNav.removeClass('sticky');
    }
  };

  handleWindowScroll();
  $window.on('scroll', handleWindowScroll);

});