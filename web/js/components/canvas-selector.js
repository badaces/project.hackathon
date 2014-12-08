;(function ($, document, undefined) {
    'use strict';

    var defaults = {
        selector: 'main-canvas-selectors',
        events: {
            updated: 'canvas.selector.updated'
        }
    };

    var CanvasSelector = function (eventManager, options) {
        this.eventManager = eventManager;
        this.setOptions(options);

        this.configureClickHandlers();
    };

    CanvasSelector.prototype = {
        eventManager: undefined,
        options: undefined,
        navElements: undefined,
        currentElement: undefined,
        setOptions: function (options) {
            this.options = $.extend({}, defaults, options);
        },
        clickHandler: function (event) {
            event.preventDefault();
            var target = event.target.parentNode;

            var eventData = {
                oldElement: this.currentElement,
                newElement: target
            };

            this.currentElement = target;

            this.eventManager.publish(this.options.events.updated, eventData);
        },
        configureClickHandlers: function () {
            var navElements= document.getElementById(this.options.selector).getElementsByTagName('li');
            this.navElements = navElements;

            $.each(navElements, $.proxy(function (i, element) {
                if (i !== 'length') {
                    element.addEventListener('click', $.proxy(this.clickHandler, this));
                }
            }, this));
        }
    };

    var instance;
    var createInstance = function (options) {
        if ($.isUndefined(instance)) {
            instance = new CanvasSelector($.eventManager(), options);
        } else {
            instance.setOptions(options);
        }

        return instance;
    };

    $.extend($, {canvasSelector: createInstance});
    $.extend($, {classes: {CanvasSelector: CanvasSelector}});
})(hm, document);
