;(function ($) {
    'use strict';

    var defaults = {
        selector: 'information-wrapper',
        childClass: 'info-injector',
        events: {
            selectorUpdated: 'canvas.selector.updated'
        }
    };

    var InformationPanel = function (eventManager, wikipedia, options) {
        this.eventManager = eventManager;
        this.wikipedia = wikipedia;
        this.setOptions(options);

        this.configure();
    };

    InformationPanel.prototype = {
        eventManager: undefined,
        options: undefined,
        wikipedia: undefined,
        setOptions: function (options) {
            this.options = $.extend({}, defaults, options);
        },
        configure: function () {
            this.eventManager.subscribe(this.options.events.selectorUpdated, $.proxy(this.onSelectorUpdated, this));
        },
        onSelectorUpdated: function (event) {
            console.log(event);
        }
    };

    var instance;
    var createInstance = function (options) {
        if ($.isUndefined(instance)) {
            instance = new InformationPanel($.eventManager(), $.wikipedia(), options);
        } else {
            instance.setOptions(options);
        }

        return instance;
    };

    $.extend($, {informationPanel: createInstance});
    $.extend($, {classes: {InformationPanel: InformationPanel}});
})(hm);
