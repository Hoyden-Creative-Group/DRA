$(function() {

  var $window = $(window);

  /**
   * Main Menu
   */
  function initMainMenu () {
    $('#menu-main-menu').superfish({
      autoArrows: false
    });
  }


  /**
   * Side menu
   */
  function initSideMenu () {
    var $stickySideNav = $('.sticky-secondary-nav'),
        navHeight = $('.main-nav').outerHeight(true);

        console.log(navHeight);

    if ($stickySideNav.length) {
      $('li', $stickySideNav).on('click', function (e) {
        e.stopPropagation();

        var anchor = $('a', this);
        var href = anchor.attr('href');

        if (!/^#/.test(href)) {
          window.location.href = href;
        } else {
          var elem = $(href.replace("#", "."));
          var currentOffset = $window.scrollTop();
          var offset = elem.offset().top - navHeight;
          var diff = Math.abs(currentOffset - offset);
          var base = 500;
          var speed = (diff * base) / 1000;

          $("html,body").animate({
            scrollTop: offset
          }, speed, 'easeInOutCubic');
        }
      });
    }
  }

  /**
   * Sticky Items
   */
  function initStickyBars () {
    var $mainNav = $('.main-nav'),
        $secondaryNav = $('.secondary-nav'),
        $stickySideNav = $('.sticky-secondary-nav'),
        $footerContact = $('.content-bottom-widgets'),
        $footer = $('.site-footer'),
        mainNavOffset = $secondaryNav.outerHeight(true),
        sideNavHeight = $stickySideNav.outerHeight(true);

    var sticky = {
      mainNav: {
        scrollHandler: function (win, scrollPosition) {
          if (scrollPosition > mainNavOffset) {
            sticky.mainNav.show();
          } else {
            sticky.mainNav.hide();
          }
        },
        show: function () {
          $mainNav.addClass('sticky');
        },
        hide: function () {
          $mainNav.removeClass('sticky');
        }
      },
      sideNav: {
        scrollHandler: function (win, scrollPosition) {
          var offset = $footerContact.position().top - sideNavHeight;

          if ((offset - scrollPosition) <= 300) {
            sticky.sideNav.pause(offset);
          } else {
            sticky.sideNav.play();
          }
        },
        pause: function (offset) {
          $stickySideNav
            .removeClass('fixed')
            .css({'top': offset, position: 'absolute'});
        },
        play: function () {
          $stickySideNav
            .addClass('fixed')
            .removeClass('pause')
            .removeAttr('style');
        }
      }
    };

    // main scrollHandler
    var scrollHandler = function () {
      var scrollPosition = $window.scrollTop();

      sticky.mainNav.scrollHandler($window, scrollPosition);

      if ($stickySideNav.length) {
        sticky.sideNav.scrollHandler($window, scrollPosition);
      }
    };

    scrollHandler();
    $window.on('scroll', scrollHandler);
  }

  $.easing = Object.assign({}, $.easing, {
    easeInOutCubic: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t + b;
        return c/2*((t-=2)*t*t + 2) + b;
    }
  });


  initMainMenu();
  initSideMenu();
  initStickyBars();

});