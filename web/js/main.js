;(function (hm, d3) {
    'use strict';

    console.log('hm:', hm);

    // rng: http://www.random.org

    // create a global event manager
    hm.extend(hm, {eventmanager: new Publisher()});

    var eventmanager = hm.eventmanager;
    var canvas = document.getElementsByClassName('stage-wrapper')[0];
    var stage = new hm.stages.stage(canvas);

    hm.watchMethod(eventmanager, 'publish', function (event) {
        console.log('published: ', event);
    });

    eventmanager.subscribe('d3.stage.assets.ready', function () {
        stage.showTerrain();
    });
})(hm, d3);
