/**
 * Our main document ready function that handles the core javascript items
 * for our theme
 */
jQuery(function($) {

  var $window = $(window),
      navHeight = $('.main-nav').outerHeight(true);

  /**
   * Main Menu
   */
  function initMainMenu () {

    var $splitMenu = $('.split-menu');

    $splitMenu.each(function() {
      var $this = $(this);
      var $ul = $('ul', $this);
      var $lis = $('li:not(.full)', $this);
      var $fulls = $('li.full', $this);
      var index = Math.floor($lis.length/2);

      // swap li to p
      $lis.each(function() {
        var $this = $(this);
        $this.replaceWith('<p>' + $this.html() + '</p>');
      });

      // select all and then remove from the menu
      $lis = $('p', $splitMenu).remove();

      // splitting the group, re-add to the menu but in split sections
      $ul.append($lis.slice(0, index).wrapAll('<li class="split"><div class="slit-links"></div></li>').parent().parent());
      $ul.append($lis.slice(index).wrapAll('<li class="split"><div class="slit-links"></div></li>').parent().parent());

      // anything labeled as full width will be appended
      $fulls.each(function() {
        $ul.append($(this));
      });
    });

    $('#menu-main-menu').superfish({
      autoArrows: false
    });
  }


  /**
   * Side menu
   */
  function initSideMenu () {
    var $stickySideNav = $('.sticky-secondary-nav');

    if ($stickySideNav.length) {
      $('li', $stickySideNav).on('click', function (e) {
        e.stopPropagation();

        var anchor = $('a', this);
        var href = anchor.attr('href');

        if (!/^#/.test(href)) {
          window.location.href = href;
        } else {
          slideToClass(href.replace("/^#/", ""));
        }
      });
    }
  }

  function slideToClass (className) {
    // if the classname is passed with a period, lets remove it
    className = className.replace("/^./", "");

    var elem = $('.' + className);

    if (elem.length === 1) {
      var currentOffset = $window.scrollTop();
      var offset = elem.offset().top - navHeight;
      var diff = Math.abs(currentOffset - offset);
      var base = 500;
      var speed = (diff * base) / 1000;

      $("html,body").animate({
        scrollTop: offset
      }, speed, 'easeInOutCubic');
    } else {
      console.log('not a unique class');
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
        mainNavOffset = $secondaryNav.outerHeight(true),
        sideNavHeight = $stickySideNav.outerHeight(true),
        sideNavTop = ($window.height() / 2) - (sideNavHeight / 2);

    var stickySideNavBaseCss = {'top': sideNavTop};

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

          if ((offset - scrollPosition) <= sideNavTop) {
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
            .removeAttr('style')
            .css(stickySideNavBaseCss);
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
      if ((t/=d/2) < 1) {
        return c/2*t*t*t + b;
      }
      return c/2*((t-=2)*t*t + 2) + b;
    }
  });


  function initHomeVideo() {
    var $videoWrapper = $('#home-video'),
        $videoContainer = $('.video-container'),
        $videoOverlay = $('.video-overlay', $videoWrapper),
        $videoPlayer = document.getElementById('aero-home-video'),
        $videoScroller = $('.scroll-down', $videoWrapper),
        canPausePlay = true;

    // set the height of the video to the viewport
    if ($videoWrapper.length) {
      $videoWrapper.height($window.height() - $videoWrapper.offset().top);
    }

    // set controls
    $videoContainer.on('click', function(){
      if (!canPausePlay){
        return;
      }

      canPausePlay = false;

      if ($videoPlayer.paused) {
        $videoOverlay.fadeOut({
          duration: 300,
          queue: false,
          complete: function(){
            $videoPlayer.play();
            canPausePlay = true;
          }
        });
      } else {
        $videoPlayer.pause();
        $videoOverlay.fadeIn({
          duration: 300,
          queue: false,
          complete: function() {
            canPausePlay = true;
          }
        });
      }
    });

    $videoScroller.on('click', function (e) {
      e.stopPropagation();
      slideToClass($(this).data('slide-to'));
    });
  }


  initMainMenu();
  initSideMenu();
  initStickyBars();
  initHomeVideo();

});