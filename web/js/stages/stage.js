;(function (hm, d3, undefined) {
    'use strict';

    var defaults = {
        height: 700,
        width: 700
    };

    var Stage = function (container, options) {
        this._d3 = hm.d3.helper;
        this.container = container;
        this.options = hm.extend({}, defaults, options)
    };

    Stage.prototype = {
        _d3: undefined,
        container: undefined,
        options: undefined
    };

    hm.extend(hm, {stages: {stage: Stage}});
})(hm, d3);