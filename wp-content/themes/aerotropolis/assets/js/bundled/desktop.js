/*!
 * hoverIntent v1.8.1 // 2014.08.11 // jQuery v1.9.1+
 * http://briancherne.github.io/jquery-hoverIntent/
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2014 Brian Cherne
 */

/* hoverIntent is similar to jQuery's built-in "hover" method except that
 * instead of firing the handlerIn function immediately, hoverIntent checks
 * to see if the user's mouse has slowed down (beneath the sensitivity
 * threshold) before firing the event. The handlerOut function is only
 * called after a matching handlerIn.
 *
 * // basic usage ... just like .hover()
 * .hoverIntent( handlerIn, handlerOut )
 * .hoverIntent( handlerInOut )
 *
 * // basic usage ... with event delegation!
 * .hoverIntent( handlerIn, handlerOut, selector )
 * .hoverIntent( handlerInOut, selector )
 *
 * // using a basic configuration object
 * .hoverIntent( config )
 *
 * @param  handlerIn   function OR configuration object
 * @param  handlerOut  function OR selector for delegation OR undefined
 * @param  selector    selector OR undefined
 * @author Brian Cherne <brian(at)cherne(dot)net>
 */

(function(factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (jQuery && !jQuery.fn.hoverIntent) {
        factory(jQuery);
    }
})(function($) {
    'use strict';

    // default configuration values
    var _cfg = {
        interval: 100,
        sensitivity: 6,
        timeout: 0
    };

    // counter used to generate an ID for each instance
    var INSTANCE_COUNT = 0;

    // current X and Y position of mouse, updated during mousemove tracking (shared across instances)
    var cX, cY;

    // saves the current pointer position coordinates based on the given mousemove event
    var track = function(ev) {
        cX = ev.pageX;
        cY = ev.pageY;
    };

    // compares current and previous mouse positions
    var compare = function(ev,$el,s,cfg) {
        // compare mouse positions to see if pointer has slowed enough to trigger `over` function
        if ( Math.sqrt( (s.pX-cX)*(s.pX-cX) + (s.pY-cY)*(s.pY-cY) ) < cfg.sensitivity ) {
            $el.off(s.event,track);
            delete s.timeoutId;
            // set hoverIntent state as active for this element (permits `out` handler to trigger)
            s.isActive = true;
            // overwrite old mouseenter event coordinates with most recent pointer position
            ev.pageX = cX; ev.pageY = cY;
            // clear coordinate data from state object
            delete s.pX; delete s.pY;
            return cfg.over.apply($el[0],[ev]);
        } else {
            // set previous coordinates for next comparison
            s.pX = cX; s.pY = cY;
            // use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
            s.timeoutId = setTimeout( function(){compare(ev, $el, s, cfg);} , cfg.interval );
        }
    };

    // triggers given `out` function at configured `timeout` after a mouseleave and clears state
    var delay = function(ev,$el,s,out) {
        delete $el.data('hoverIntent')[s.id];
        return out.apply($el[0],[ev]);
    };

    $.fn.hoverIntent = function(handlerIn,handlerOut,selector) {
        // instance ID, used as a key to store and retrieve state information on an element
        var instanceId = INSTANCE_COUNT++;

        // extend the default configuration and parse parameters
        var cfg = $.extend({}, _cfg);
        if ( $.isPlainObject(handlerIn) ) {
            cfg = $.extend(cfg, handlerIn);
            if ( !$.isFunction(cfg.out) ) {
                cfg.out = cfg.over;
            }
        } else if ( $.isFunction(handlerOut) ) {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerOut, selector: selector } );
        } else {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerIn, selector: handlerOut } );
        }

        // A private function for handling mouse 'hovering'
        var handleHover = function(e) {
            // cloned event to pass to handlers (copy required for event object to be passed in IE)
            var ev = $.extend({},e);

            // the current target of the mouse event, wrapped in a jQuery object
            var $el = $(this);

            // read hoverIntent data from element (or initialize if not present)
            var hoverIntentData = $el.data('hoverIntent');
            if (!hoverIntentData) { $el.data('hoverIntent', (hoverIntentData = {})); }

            // read per-instance state from element (or initialize if not present)
            var state = hoverIntentData[instanceId];
            if (!state) { hoverIntentData[instanceId] = state = { id: instanceId }; }

            // state properties:
            // id = instance ID, used to clean up data
            // timeoutId = timeout ID, reused for tracking mouse position and delaying "out" handler
            // isActive = plugin state, true after `over` is called just until `out` is called
            // pX, pY = previously-measured pointer coordinates, updated at each polling interval
            // event = string representing the namespaced event used for mouse tracking

            // clear any existing timeout
            if (state.timeoutId) { state.timeoutId = clearTimeout(state.timeoutId); }

            // namespaced event used to register and unregister mousemove tracking
            var mousemove = state.event = 'mousemove.hoverIntent.hoverIntent'+instanceId;

            // handle the event, based on its type
            if (e.type === 'mouseenter') {
                // do nothing if already active
                if (state.isActive) { return; }
                // set "previous" X and Y position based on initial entry point
                state.pX = ev.pageX; state.pY = ev.pageY;
                // update "current" X and Y position based on mousemove
                $el.off(mousemove,track).on(mousemove,track);
                // start polling interval (self-calling timeout) to compare mouse coordinates over time
                state.timeoutId = setTimeout( function(){compare(ev,$el,state,cfg);} , cfg.interval );
            } else { // "mouseleave"
                // do nothing if not already active
                if (!state.isActive) { return; }
                // unbind expensive mousemove event
                $el.off(mousemove,track);
                // if hoverIntent state is true, then call the mouseOut function after the specified delay
                state.timeoutId = setTimeout( function(){delay(ev,$el,state,cfg.out);} , cfg.timeout );
            }
        };

        // listen for mouseenter and mouseleave
        return this.on({'mouseenter.hoverIntent':handleHover,'mouseleave.hoverIntent':handleHover}, cfg.selector);
    };
});

/*
 * jQuery Superfish Menu Plugin - v1.7.9
 * Copyright (c) 2016 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *	http://www.opensource.org/licenses/mit-license.php
 *	http://www.gnu.org/licenses/gpl.html
 */

;(function ($, w) {
	"use strict";

	var methods = (function () {
		// private properties and methods go here
		var c = {
				bcClass: 'sf-breadcrumb',
				menuClass: 'sf-js-enabled',
				anchorClass: 'sf-with-ul',
				menuArrowClass: 'sf-arrows'
			},
			ios = (function () {
				var ios = /^(?![\w\W]*Windows Phone)[\w\W]*(iPhone|iPad|iPod)/i.test(navigator.userAgent);
				if (ios) {
					// tap anywhere on iOS to unfocus a submenu
					$('html').css('cursor', 'pointer').on('click', $.noop);
				}
				return ios;
			})(),
			wp7 = (function () {
				var style = document.documentElement.style;
				return ('behavior' in style && 'fill' in style && /iemobile/i.test(navigator.userAgent));
			})(),
			unprefixedPointerEvents = (function () {
				return (!!w.PointerEvent);
			})(),
			toggleMenuClasses = function ($menu, o, add) {
				var classes = c.menuClass,
					method;
				if (o.cssArrows) {
					classes += ' ' + c.menuArrowClass;
				}
				method = (add) ? 'addClass' : 'removeClass';
				$menu[method](classes);
			},
			setPathToCurrent = function ($menu, o) {
				return $menu.find('li.' + o.pathClass).slice(0, o.pathLevels)
					.addClass(o.hoverClass + ' ' + c.bcClass)
						.filter(function () {
							return ($(this).children(o.popUpSelector).hide().show().length);
						}).removeClass(o.pathClass);
			},
			toggleAnchorClass = function ($li, add) {
				var method = (add) ? 'addClass' : 'removeClass';
				$li.children('a')[method](c.anchorClass);
			},
			toggleTouchAction = function ($menu) {
				var msTouchAction = $menu.css('ms-touch-action');
				var touchAction = $menu.css('touch-action');
				touchAction = touchAction || msTouchAction;
				touchAction = (touchAction === 'pan-y') ? 'auto' : 'pan-y';
				$menu.css({
					'ms-touch-action': touchAction,
					'touch-action': touchAction
				});
			},
			getMenu = function ($el) {
				return $el.closest('.' + c.menuClass);
			},
			getOptions = function ($el) {
				return getMenu($el).data('sfOptions');
			},
			over = function () {
				var $this = $(this),
					o = getOptions($this);
				clearTimeout(o.sfTimer);
				$this.siblings().superfish('hide').end().superfish('show');
			},
			close = function (o) {
				o.retainPath = ($.inArray(this[0], o.$path) > -1);
				this.superfish('hide');

				if (!this.parents('.' + o.hoverClass).length) {
					o.onIdle.call(getMenu(this));
					if (o.$path.length) {
						$.proxy(over, o.$path)();
					}
				}
			},
			out = function () {
				var $this = $(this),
					o = getOptions($this);
				if (ios) {
					$.proxy(close, $this, o)();
				}
				else {
					clearTimeout(o.sfTimer);
					o.sfTimer = setTimeout($.proxy(close, $this, o), o.delay);
				}
			},
			touchHandler = function (e) {
				var $this = $(this),
					o = getOptions($this),
					$ul = $this.siblings(e.data.popUpSelector);

				if (o.onHandleTouch.call($ul) === false) {
					return this;
				}

				if ($ul.length > 0 && $ul.is(':hidden')) {
					$this.one('click.superfish', false);
					if (e.type === 'MSPointerDown' || e.type === 'pointerdown') {
						$this.trigger('focus');
					} else {
						$.proxy(over, $this.parent('li'))();
					}
				}
			},
			applyHandlers = function ($menu, o) {
				var targets = 'li:has(' + o.popUpSelector + ')';
				if ($.fn.hoverIntent && !o.disableHI) {
					$menu.hoverIntent(over, out, targets);
				}
				else {
					$menu
						.on('mouseenter.superfish', targets, over)
						.on('mouseleave.superfish', targets, out);
				}
				var touchevent = 'MSPointerDown.superfish';
				if (unprefixedPointerEvents) {
					touchevent = 'pointerdown.superfish';
				}
				if (!ios) {
					touchevent += ' touchend.superfish';
				}
				if (wp7) {
					touchevent += ' mousedown.superfish';
				}
				$menu
					.on('focusin.superfish', 'li', over)
					.on('focusout.superfish', 'li', out)
					.on(touchevent, 'a', o, touchHandler);
			};

		return {
			// public methods
			hide: function (instant) {
				if (this.length) {
					var $this = this,
						o = getOptions($this);
					if (!o) {
						return this;
					}
					var not = (o.retainPath === true) ? o.$path : '',
						$ul = $this.find('li.' + o.hoverClass).add(this).not(not).removeClass(o.hoverClass).children(o.popUpSelector),
						speed = o.speedOut;

					if (instant) {
						$ul.show();
						speed = 0;
					}
					o.retainPath = false;

					if (o.onBeforeHide.call($ul) === false) {
						return this;
					}

					$ul.stop(true, true).animate(o.animationOut, speed, function () {
						var $this = $(this);
						o.onHide.call($this);
					});
				}
				return this;
			},
			show: function () {
				var o = getOptions(this);
				if (!o) {
					return this;
				}
				var $this = this.addClass(o.hoverClass),
					$ul = $this.children(o.popUpSelector);

				if (o.onBeforeShow.call($ul) === false) {
					return this;
				}

				$ul.stop(true, true).animate(o.animation, o.speed, function () {
					o.onShow.call($ul);
				});
				return this;
			},
			destroy: function () {
				return this.each(function () {
					var $this = $(this),
						o = $this.data('sfOptions'),
						$hasPopUp;
					if (!o) {
						return false;
					}
					$hasPopUp = $this.find(o.popUpSelector).parent('li');
					clearTimeout(o.sfTimer);
					toggleMenuClasses($this, o);
					toggleAnchorClass($hasPopUp);
					toggleTouchAction($this);
					// remove event handlers
					$this.off('.superfish').off('.hoverIntent');
					// clear animation's inline display style
					$hasPopUp.children(o.popUpSelector).attr('style', function (i, style) {
						return style.replace(/display[^;]+;?/g, '');
					});
					// reset 'current' path classes
					o.$path.removeClass(o.hoverClass + ' ' + c.bcClass).addClass(o.pathClass);
					$this.find('.' + o.hoverClass).removeClass(o.hoverClass);
					o.onDestroy.call($this);
					$this.removeData('sfOptions');
				});
			},
			init: function (op) {
				return this.each(function () {
					var $this = $(this);
					if ($this.data('sfOptions')) {
						return false;
					}
					var o = $.extend({}, $.fn.superfish.defaults, op),
						$hasPopUp = $this.find(o.popUpSelector).parent('li');
					o.$path = setPathToCurrent($this, o);

					$this.data('sfOptions', o);

					toggleMenuClasses($this, o, true);
					toggleAnchorClass($hasPopUp, true);
					toggleTouchAction($this);
					applyHandlers($this, o);

					$hasPopUp.not('.' + c.bcClass).superfish('hide', true);

					o.onInit.call(this);
				});
			}
		};
	})();

	$.fn.superfish = function (method, args) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		}
		else {
			return $.error('Method ' +  method + ' does not exist on jQuery.fn.superfish');
		}
	};

	$.fn.superfish.defaults = {
		popUpSelector: 'ul,.sf-mega', // within menu context
		hoverClass: 'sfHover',
		pathClass: 'overrideThisToUse',
		pathLevels: 1,
		delay: 800,
		animation: {opacity: 'show'},
		animationOut: {opacity: 'hide'},
		speed: 'normal',
		speedOut: 'fast',
		cssArrows: true,
		disableHI: false,
		onInit: $.noop,
		onBeforeShow: $.noop,
		onShow: $.noop,
		onBeforeHide: $.noop,
		onHide: $.noop,
		onIdle: $.noop,
		onDestroy: $.noop,
		onHandleTouch: $.noop
	};

})(jQuery, window);

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