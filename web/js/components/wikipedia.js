;(function ($, undefined) {
    'use strict';

    var defaults = {
        endpoint: '/wikipedia',
        events: {
            response: 'wikipedia.response'
        }
    };

    var Wikipedia = function (eventManager, options) {
        this.eventManager = eventManager;
        this.setOptions(options);
    };

    Wikipedia.prototype = {
        eventManager: undefined,
        options: undefined,
        setOptions: function (options) {
            this.options = $.extend({}, defaults, options);
        },
        getArticleByName: function (name, callback) {
            var url = this.options.endpoint + '?title=' + encodeURI(name);

            var request = new XMLHttpRequest();
            request.responseType = 'json';
            request.onreadystatechange = hm.proxy(function () {
                if (request.readyState === 4) {
                    var response = {
                        status: request.status,
                        response: request.response
                    };

                    if (callback) {
                        callback.apply(callback, [response]);
                    }

                    this.eventManager.publish(this.options.events.response, response);
                }
            }, this);

            request.open('GET', url, true);
            request.send();
        }
    };

    $.extend($, {classes: {Wikipedia: Wikipedia}});
})(hm);
