/**
 * Our main document ready function that handles the core javascript items
 * for our theme
 */
jQuery(function($) {

  var $window = $(window),
      $body = $('body'),
      $mainNav = $('.main-nav'),
      navHeight = $mainNav.outerHeight(true),
      $stickySideNav = $('.sticky-secondary-nav'),
      $videoWrapper = $('#home-video'),
      windowWidth = $window.width(),
      MOBILE_NAV_WIDTH_THRESHOLD = 1015;

  /**
   * Adjust the main navigation to have a "split" submenu.
   */
  function initMainMenu () {
    var $splitMenu = $('.split-menu');

    $splitMenu.each(function() {
      var $this = $(this);
      var $ul = $('ul', $this);
      var $lis = $('li:not(.full)', $this);
      var $fulls = $('li.full', $this);
      var $mobile = $('li.mobile', $this);
      var index = Math.floor(($lis.length + $mobile.length)/2);

      // swap li to p
      $lis.each(function() {
        var $this = $(this);
        var classes = $this.attr('class');
        $this.replaceWith('<p class="'+ classes +'">' + $this.html() + '</p>');
      });

      // select all and then remove from the menu
      $lis = $('p', $splitMenu).remove();

      // splitting the group, re-add to the menu but in split sections
      $ul.append($lis.slice(0, index).wrapAll('<li class="split"><div class="split-links"></div></li>').parent().parent());
      $ul.append($lis.slice(index).wrapAll('<li class="split"><div class="split-links"></div></li>').parent().parent());

      // anything labeled as full width will be appended
      $fulls.each(function() {
        $ul.append($(this));
      });
    });
  }


  /**
   * Setup the ticky side menu click events
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
          slideToClass(href.replace(/^#/, ""));
        }
      });
    }
  }


  /**
   * Scrolls the window to the first occurance of a class
   */
  function slideToClass (className) {
    // if the classname is passed with a period, lets remove it
    className = className.replace(/^\./, "");

    var elem = $('.' + className);

    if (elem.length === 1) {
      var currentOffset = $window.scrollTop();
      var offset = windowWidth > MOBILE_NAV_WIDTH_THRESHOLD ? elem.offset().top - navHeight : elem.offset().top;
      var diff = Math.abs(currentOffset - offset);
      var base = 500;
      var speed = (diff * base) / 1000;

      $("html,body").animate({
        scrollTop: offset
      }, speed, 'easeInOutCubic');
    } else {
      console.log(className, 'is not a unique class', elem.length);
    }
  }


  /**
   * Sticky items
   */
  function initStickyBars () {
    var $secondaryNav = $('.secondary-nav'),
        $footerContact = $('.content-bottom-widgets'),
        mainNavOffset = $mainNav.outerHeight(true),
        secondaryNavOffset = $secondaryNav.outerHeight(true),
        sideNavHeight = $stickySideNav.outerHeight(true),
        sideNavTop = ($window.height() / 2) - (sideNavHeight / 2);

    sideNavTop = (sideNavTop < 300) ? 300 : sideNavTop;

    var stickySideNavBaseCss = {'top': sideNavTop};

    var sticky = {
      mainNav: {
        scrollHandler: function (scrollPosition) {
          if (scrollPosition >= secondaryNavOffset) {
            sticky.mainNav.show();
          } else {
            sticky.mainNav.hide();
          }
        },
        show: function () {
          $mainNav.addClass('sticky');
          $body.css({'padding-top': mainNavOffset});
        },
        hide: function () {
          $mainNav.removeClass('sticky');
          $body.removeAttr('style');
        }
      },
      sideNav: {
        scrollHandler: function (scrollPosition) {
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
            .css({'top': offset, 'left': 0, position: 'absolute'});
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

    return sticky;
  }


  /**
   * Sets the control events as well as the  size of the home page video
   */
  function initHomeVideo() {
    var $videoContainer = $('.video-container'),
        $videoOverlay = $('.video-overlay', $videoWrapper),
        $videoPlayer = document.getElementById('aero-home-video'),
        $videoScroller = $('.scroll-down', $videoWrapper),
        canPausePlay = true;

    if (!$videoWrapper.length) {
      return;
    }

    resizeHomeVideo();

    // set a click event on the video container to play/pause the video
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

    // when the video is done playing, fade in the wallpaper
    $videoPlayer.addEventListener('ended', function(){
      canPausePlay = false;
      $videoOverlay.fadeIn({
        duration: 800,
        queue: false,
        complete: function() {
          canPausePlay = true;
        }
      });
    });

    // set a click event for down arrow over the video
    $videoScroller.on('click', function (e) {
      e.stopPropagation();
      slideToClass($(this).data('slide-to'));
    });
  }

  function resizeHomeVideo() {
    if (!$videoWrapper.length) {
      return;
    }

    // set the height of the video to the viewport
    if (windowWidth > MOBILE_NAV_WIDTH_THRESHOLD) {
      $videoWrapper.height($window.height() - $videoWrapper.offset().top);
    } else {
      $videoWrapper.height('auto');
    }
  }


  /**
   * Contact form submission validations
   */
  function initContactForm() {
    var $form = $('#aero-contact-form'),
        $errors = $('.js-form-errors'),
        isSubmittingContact = false,
        emailRegex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;

    if ($form.length) {
      $form.on('submit', function() {
        if (isSubmittingContact) {
          return false;
        }

        isSubmittingContact = true;

        var $message = $('#aero_message', $form);
        var $email = $('#aero_email', $form);

        $message.removeClass('error');
        $email.removeClass('error');
        $errors.hide().html('');

        if (!emailRegex.test($email.val())) {
          $errors.css({'display': 'inline-block'}).html('<p>Oops! Invalid Email.</p>');
          $email.focus().addClass('error');
          isSubmittingContact = false;
          return false;
        }

        if ($message.val().length < 3) {
          $errors.css({'display': 'inline-block'}).html('<p>Oops! Invalid Message.</p>');
          $message.focus().addClass('error');
          isSubmittingContact = false;
          return false;
        }

        return true;
      });
    }
  }


  /**
   * Handles functionality around the window scrolling event
   */
  function initOnWindowScroll() {
    // This class is used prevent scroll event being binded more than once
    if ($body.hasClass('aero-scrolling')) {
      return;
    }

    var stickyMenus = initStickyBars();

    // main scrollHandler
    var scrollHandler = function () {
      var scrollPosition = $window.scrollTop();

      // main nav sticky menu
      stickyMenus.mainNav.scrollHandler(scrollPosition);

      // side bar sticky menu
      if ($stickySideNav.length) {
        stickyMenus.sideNav.scrollHandler(scrollPosition);
      }
    };

    scrollHandler();

    $body.addClass('aero-scrolling');
    $window.on('scroll.aero', scrollHandler);
  }


  /**
   * Handles functionality around the window resizing event.
   */
  function initOnWindowResize() {
    var $mainMenu = $('#menu-main-menu'),
        $mobileMenuBtn = $('.hamburger-menu');

    var menus = {
      main: {
        show: function() {
          if (!$mainMenu.hasClass('sf-js-enabled')){
            $mainMenu.superfish({
              autoArrows: false
            });
          }
        },
        hide: function () {
          if ($mainMenu.superfish) {
            $mainMenu.superfish('destroy');
          }
        }
      },
      mobile: {
        isShowing: false,
        isTransitioning: false,
        showNav: function(){
          menus.mobile.isTransitioning = true;
          menus.mobile.isShowing = true;

          $('.main_menu').slideDown(300, function(){
            menus.mobile.isTransitioning = false;
          });
        },
        hideNav: function() {
          menus.mobile.isTransitioning = true;
          menus.mobile.isShowing = false;

          $('.main_menu').slideUp(300, function(){
            menus.mobile.isTransitioning = false;
          });
        },
        show: function() {
          if (!$body.hasClass('mobile')) {
            // keep track of what sub nav we have open
            var opened = null;

            // show the mobile hamburger icon
            $mobileMenuBtn.show();

            // add body class
            $body.addClass('mobile');

            // hide the menu
            $('.main_menu').hide();

            // submenu handling
            $('.menu-item-has-children', $mainMenu).on('click.mobileSubmenu', function(e){
              var $this = $(this);
              var $target = $(e.target);
              var thisID = $this.attr('id');
              var targetID = $target.parent().attr('id');

              if (thisID !== targetID) {
                window.location.href = $target.attr('href');
                return;
              }

              e.preventDefault();
              e.stopPropagation();

              if ($this.hasClass('opened')){
                // user is clicking on the same menu that is open
                $this.removeClass('opened');
                $('>ul', $this).slideUp();
                opened = null;
              } else {
                // close a submenu if one is open
                if (opened) {
                  opened.removeClass('opened');
                  $('>ul', opened).slideUp();
                }

                // store the submenu we are opening
                opened = $this;
                opened.addClass('opened');
                $('>ul', opened).slideDown();
              }
            });
          }
        },
        hide: function () {
          if ($body.hasClass('mobile')) {
            // hide the hamburger menu and reset it
            $mobileMenuBtn.hide().removeClass('open');
            // remove the body class
            $body.removeClass('mobile');
            // set our menu state
            menus.mobile.isShowing = false;
            // show the menu
            $('.main_menu').show();
            // remove the click events for mobile submenus and remove their class
            $('.menu-item-has-children', $mainMenu).off('click.mobileSubmenu').removeClass('opened');
            // reset all submenus to be hidden
            $('.menu-item-has-children ul.sub-menu', $mainMenu).hide();
          }
        }
      }
    };

    var resizeHandler = function () {
      windowWidth = $window.width();

      resizeHomeVideo();

      // based on the window size, toggle the mobile version of the navigation
      if (windowWidth <= MOBILE_NAV_WIDTH_THRESHOLD) {
        menus.main.hide();
        menus.mobile.show();

        if (window.vcParallaxSkroll) {
          window.vcParallaxSkroll.destroy();
        }

        $window.off('scroll.aero');
        $body.removeClass('aero-scrolling').css({'padding-top': 0});
        $mainNav.removeClass('sticky');

      } else {
        menus.main.show();
        menus.mobile.hide();
        initOnWindowScroll();
      }
    };

    // setup the mobile menu button
    $mobileMenuBtn.on('click', function(){
      if (menus.mobile.isTransitioning) {
        return;
      }

      if (menus.mobile.isShowing) {
        $(this).removeClass('open');
        menus.mobile.hideNav();
      } else {
        $(this).addClass('open');
        menus.mobile.showNav();
      }
    });

    resizeHandler();
    $window.on('resize.aero', debounce(resizeHandler, 100));
  }

  // Debounce method borrowed from underscore :)
  function debounce(func, wait, immediate) {
    var timeout;
    return function() {
      var context = this, args = arguments;
      var later = function() {
        timeout = null;
        if (!immediate) { func.apply(context, args); }
      };
      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) { func.apply(context, args); }
    };
  }

  // Easing function for jQuery
  $.easing = Object.assign({}, $.easing, {
    easeInOutCubic: function (x, t, b, c, d) {
      if ((t/=d/2) < 1) {
        return c/2*t*t*t + b;
      }
      return c/2*((t-=2)*t*t + 2) + b;
    }
  });

  initMainMenu();
  initSideMenu();
  initHomeVideo();
  initContactForm();
  initOnWindowScroll();
  initOnWindowResize();

});