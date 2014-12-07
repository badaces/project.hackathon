;(function (hm, d3) {
    'use strict';

    console.log('hm:', hm);

    // rng: http://www.random.org

    var container = document.getElementsByClassName('panel-container')[0];
    var panels = {
        sealevel: {
            data: [29, 71, 30, 42, 38, 57, 50, 58, 78, 45]
        }
    };

    hm.each(hm.panels, function (i, panel) {
        panel = new panel(container);
        panel.show(panels[i].data);

        console.log(i + ':', panel);
    });
})(hm, d3);
