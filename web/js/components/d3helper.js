;(function (hm) {
    'use strict';

    var D3Helper = function () {};

    D3Helper.prototype = {
        translate: function (x, y) {
            if (Array.isArray(x)) {
                var orig = x;

                x = orig[0].toString();
                y = orig[1].toString();
            }

            return 'translate(' + x + ', ' + y + ')';
        }
    };

    hm.extend(hm, { d3: { helper: new D3Helper() }});
})(hm);