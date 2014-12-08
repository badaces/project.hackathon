;(function ($, Publisher, undefined) {
    'use strict';

    var instance;
    var createInstance = function () {
        if (instance === undefined) {
            instance = new Publisher();
        }

        return instance;
    };

    $.extend($, {eventManager: createInstance});
})(hm, Publisher);
