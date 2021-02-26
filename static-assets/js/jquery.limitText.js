/* ========================================================================
 * jquery.limitText.js v0.0.1
 * 
 * ========================================================================
 * Copyright 2015 Phillip Molaro
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ========================================================================
 * 
 * Usage:
 * 
 <textarea id="myTextArea" cols="120" rows="30" data-status-message="#status"></textarea>
 <div id="status" class="text-right"></div>
 
 <script type="text/javascript">
     $(document).ready(function () {
        $('#myTextArea').limitText();
     });
 </script>
 *
 * Options:
 * @param limit (integer)           - The cutoff character count for the field
 *                                    Default: 200
 * @param warningLimit (integer)    - The remaining character count to trigger class change
 *                                    Default: 10
 * @param statusMessage (string)    - A jQuery selector to id an existing status container DOM element
 *                                    If left empty, a default will be added after the element
 *                                    Default: ''
 * @param counterClass (string)     - Class to apply to the status area, and replaced on warning
 *                                    Default: 'text-primary' (Bootstrap helper class)
 * @param warningClass (string)     - Class applied to status area when warningLimit is reached.
 *                                    Replaces the counterClass on warning
 *                                    Default: 'text-danger' (Bootstrap helper class)
 * @param containerElement (string) - DOM element to be inserted if statusMessage is undefined
 *                                    Default: '<div>'
 * @param containerClass (string)   - Class applied to the status container. 
 *                                    Default: 'limit-text-status' (no definition)
 */


+ function($) {

    'use strict';

    /**
     * LimitText Class Definition
     */
    var LimitText = function(element, options) {
        this.options = options;
        this.$element = $(element);
        // if an existing container is not defined, then a default will be created
        this.$status = (this.options.statusMessage.length) ?
            $(this.options.statusMessage) : $(this.options.containerElement);

        // Add classes to the status container, and insert base text
        this.$status
            .addClass(this.options.containerClass + ' ' + this.options.counterClass)
            .append('<small><strong>' +
                this.options.limit + '</strong> characters remaining</small>');

        // reference not available til we've appended the html snippet
        this.$count = $('strong', this.$status);

        // insert the default message container if one isn't already defined
        if (!this.options.statusMessage.length) this.$element.after(this.$status);

        // set our event handler and proxy it to properly set the context
        this.$element.on('input.limitText.data-api propertychange.limitText.data-api', $.proxy(this.checkCount, this));

        // and run initial check of current value
        this.checkCount();
    };

    LimitText.VERSION = '0.0.1';
    LimitText.NAME = 'limitText';

    LimitText.DEFAULTS = {
        limit: 200,
        warningLimit: 10,
        statusMessage: '',
        // These two are Bootstrap text emphasis classes
        // that you can override in the config, or roll
        // your own of the same name
        counterClass: 'text-primary',
        warningClass: 'text-danger',
        // The default container element is only used if an
        // existing container (statusMessage) is not defined
        containerElement: '<div>',
        containerClass: 'limit-text-status'
    };

    LimitText.prototype.checkCount = function() {
        var currVal = this.$element.val();

        if (currVal.length > this.options.limit) {
            // reset the currVal, so that it stays within the limit
            currVal = currVal.substr(0, this.options.limit - 1);
            this.$element.val(currVal);
        }

        var remaining = this.options.limit - currVal.length;

        this.$count.html(remaining);

        if (remaining <= this.options.warningLimit) {
            this.$status.removeClass(this.options.counterClass).addClass(this.options.warningClass);
        } else {
            this.$status.removeClass(this.options.warningClass).addClass(this.options.counterClass);
        }
    };

    LimitText.prototype.destroy = function() {
        $.removeData(this.$element[0], 'limitText');

        // remove the inserted status container
        if (!this.options.statusMessage.length) {
            this.$status.remove();
        } else {
            this.$status
                .removeClass(
                    this.options.containerClass + ' ' +
                    this.options.counterClass + ' ' +
                    this.options.warningClass)
                .empty();
        }

        this.$element.off('input.limitText.data-api propertychange.limitText.data-api');
        this.$element = null;
    };

    // limitText Plugin Definition

    function Plugin(option) {
        return this.each(function() {
            var $this = $(this),
                data = $this.data('limitText'),
                options = $.extend({}, LimitText.DEFAULTS, $this.data(), typeof option == 'object' && option);

            if (!data) $this.data('limitText', (data = new LimitText(this, options)));
            if (typeof option == 'string') data[option]();
        });
    }

    var old = $.fn.limitText;

    $.fn.limitText = Plugin;
    $.fn.limitText.Constructor = LimitText;

    // limitText No Conflict

    $.fn.limitText.noConflict = function() {
        $.fn.limitText = old;
        return this;
    };

}(jQuery);