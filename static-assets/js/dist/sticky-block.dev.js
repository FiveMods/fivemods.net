"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var HSStickyBlock =
/*#__PURE__*/
function () {
  function HSStickyBlock(elem, settings) {
    _classCallCheck(this, HSStickyBlock);

    this.elem = elem;
    this.defaults = {
      parentSelector: null,
      parentWidth: null,
      parentPaddingLeft: null,
      parentOffsetLeft: null,
      targetSelector: null,
      targetHeight: 0,
      stickyHeight: null,
      stickyOffsetTop: 0,
      stickyOffsetBottom: 0,
      windowOffsetTop: 0,
      startPoint: null,
      endPoint: null,
      resolutionsList: {
        xs: 0,
        sm: 576,
        md: 768,
        lg: 992,
        xl: 1200
      },
      breakpoint: 'lg',
      styles: {
        position: 'fixed'
      },
      classMap: {
        kill: 'hs-kill-sticky'
      }
    };
    this.settings = settings;
    this.init();
  }

  _createClass(HSStickyBlock, [{
    key: "init",
    value: function init() {
      var context = this,
          $el = context.elem,
          dataSettings = $el.attr('data-hs-sticky-block-options') ? JSON.parse($el.attr('data-hs-sticky-block-options')) : {},
          options = $.extend(true, context.defaults, dataSettings, context.settings);

      context._setRules($el, options);

      $(window).on('resize scroll', function () {
        context.update();
      });
    }
  }, {
    key: "update",
    value: function update() {
      var context = this,
          $el = context.elem,
          dataSettings = $el.attr('data-hs-sticky-block-options') ? JSON.parse($el.attr('data-hs-sticky-block-options')) : {},
          options = $.extend(true, context.defaults, dataSettings, context.settings);

      context._setRules($el, options);
    }
  }, {
    key: "_updateOptions",
    value: function _updateOptions(el, params) {
      var options = params;
      options.windowOffsetTop = $(window).scrollTop();
      options.startPoint = $.isNumeric(options.startPoint) ? options.startPoint : $(options.startPoint).offset().top;
      options.endPoint = $.isNumeric(options.endPoint) ? options.endPoint : $(options.endPoint).offset().top;
      options.parentWidth = $(options.parentSelector).width();
      options.parentPaddingLeft = parseInt($(options.parentSelector).css('padding-left'));
      options.parentOffsetLeft = $(options.parentSelector).offset().left;
      options.targetHeight = options.targetSelector ? $(options.targetSelector).outerHeight() : 0;
      options.stickyHeight = el.outerHeight();
    }
  }, {
    key: "_setRules",
    value: function _setRules(el, params) {
      var context = this;
      var options = params;

      context._kill(el, options);

      context._updateOptions(el, options);

      if (!el.hasClass(options.classMap.kill)) {
        if (options.windowOffsetTop >= options.startPoint - options.targetHeight - options.stickyOffsetTop && options.windowOffsetTop <= options.endPoint - options.targetHeight - options.stickyOffsetTop) {
          context._add(el, options);

          context._top(el, options);

          context._parentSetHeight(options);
        } else {
          context._reset(el);

          context._parentRemoveHeight(options);
        }

        if (options.windowOffsetTop >= options.endPoint - options.targetHeight - options.stickyHeight - options.stickyOffsetTop - options.stickyOffsetBottom) {
          context._bottom(el, options);
        }
      }
    }
  }, {
    key: "_add",
    value: function _add(el, params) {
      var options = params;
      el.css({
        position: options.styles.position,
        left: options.parentOffsetLeft + options.parentPaddingLeft,
        width: options.parentWidth
      });
    }
  }, {
    key: "_top",
    value: function _top(el, params) {
      var options = params;
      el.css({
        top: options.stickyOffsetTop + options.targetHeight
      });
    }
  }, {
    key: "_bottom",
    value: function _bottom(el, params) {
      var options = params;
      el.css({
        top: options.endPoint - options.windowOffsetTop - options.stickyHeight - options.stickyOffsetBottom
      });
    }
  }, {
    key: "_reset",
    value: function _reset(el) {
      el.css({
        position: '',
        top: '',
        bottom: '',
        left: '',
        width: ''
      });
    }
  }, {
    key: "_kill",
    value: function _kill(el, params) {
      var context = this;
      var options = params;

      if (window.innerWidth <= options.resolutionsList[options.breakpoint]) {
        el.addClass(options.classMap.kill);

        context._reset(el);

        context._parentRemoveHeight(options);
      } else {
        el.removeClass(options.classMap.kill);
      }
    }
  }, {
    key: "_parentSetHeight",
    value: function _parentSetHeight(params) {
      var options = params;
      $(options.parentSelector).css({
        height: options.stickyHeight
      });
    }
  }, {
    key: "_parentRemoveHeight",
    value: function _parentRemoveHeight(params) {
      var options = params;
      $(options.parentSelector).css({
        height: ''
      });
    }
  }]);

  return HSStickyBlock;
}();

exports["default"] = HSStickyBlock;