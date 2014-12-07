;(function (hm) {
    'use strict';

    var D3Helper = function () {};

    D3Helper.prototype = {
        createPanel: function (height, width) {
            var panel = document.createElement('div');

            panel.className = 'panel';
            panel.style.boxShadow = '0 0 0 1px lightgray';
            panel.style.cssFloat = 'left';
            panel.style.height = height + 'px';
            panel.style.width = width + 'px';

            return panel;
        },
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