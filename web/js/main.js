;(function (hm, d3) {
    'use strict';

    console.log('hm:', hm);

    // rng: http://www.random.org

    var container = document.getElementsByClassName('panel-container')[0];
    var panels = {
        sealevel: {
            data: {
                bar: [29, 71, 30, 42, 38, 57, 50, 58, 78, 45],
                pie: [
                    {amount: 29, label: 'one'},
                    {amount: 71, label: 'two'},
                    {amount: 30, label: 'three'},
                    {amount: 42, label: 'four'},
                    {amount: 38, label: 'five'},
                    {amount: 57, label: 'six'},
                    {amount: 50, label: 'seven'},
                    {amount: 58, label: 'eight'},
                    {amount: 78, label: 'nine'},
                    {amount: 45, label: 'ten'}
                ]
            }
        }
    };

    hm.each(hm.panels, function (i, panel) {
        panel = new panel(container);
        panel.show(panels[i].data);

        console.log(i + ':', panel);
    });
})(hm, d3);
