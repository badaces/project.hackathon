;(function (hm, d3, $) {
    'use strict';

    console.log('hm:', hm);

    // create a global event manager
    hm.extend(hm, {eventmanager: new Publisher()});

    var eventmanager = hm.eventmanager;

    hm.watchMethod(eventmanager, 'publish', function (event) {
        console.log('published: ', event);
    });

    var canvas = document.getElementById('stage-wrapper');
    var stages = document.getElementsByClassName('stage');
    var scenes = document.getElementsByClassName('scene');
    var clouds = document.getElementsByClassName('cloud');

    var selectors = {
        cryosphere: {
            class: ''
        },
        hydrosphere: {
            class: ''
        },
        lithosphere: {
            class: ''
        },
        atmosphere: {
            stage: document.getElementsByClassName('stage-CO2')[0],
            scene: document.getElementsByClassName('scene-CO2')[0],
            elements: [clouds]
        }
    };

    var hideElements = function () {
        hm.each([stages, scenes, clouds], function (i, collection) {
            hm.each(collection, function (i, element) {
                element.style.opacity = '0';
            });
        });
    };

    eventmanager.subscribe('canvas.selectors.updated', function (data) {
        var newElement = data.newElement;
        var selector = newElement.textContent.toLowerCase();

        hideElements();

        selectors[selector].stage.style.opacity = '1';
        selectors[selector].scene.style.opacity = '1';

        hm.each(selectors[selector].elements, function (i, collection) {
            hm.each(collection, function (i, element) {
                element.style.opacity = 1;
            });
        });
    });

    // initialize scene selection
    // ==========================

    hideElements();

    eventmanager.publish('canvas.selectors.updated', {
        newElement: document.getElementsByClassName('select-atmosphere')[0],
        oldElement: document.getElementsByClassName('select-hydrosphere')[0]
    });






    //$.ajax({
    //    url: '/statistics?type=co2',
    //    success: function (data) {
    //        data = data.result;
    //
    //
    //        var clouds = {
    //            1960: {entries: 0, data: 0},
    //            1970: {entries: 0, data: 0},
    //            1980: {entries: 0, data: 0},
    //            1990: {entries: 0, data: 0},
    //            2000: {entries: 0, data: 0},
    //            2010: {entries: 0, data: 0}
    //        };
    //
    //        hm.each(data, function (i, record) {
    //            if (record.year >= 1960) {
    //                var point = record.year.toString().substring(0, 3) + '0';
    //
    //                clouds[point].entries += 1;
    //                clouds[point].data += record.data;
    //            }
    //        });
    //
    //        console.log(clouds);
    //    },
    //    error: function () {
    //        console.log('unable to load co2 data');
    //    }
    //});

    //eventmanager.subscribe('d3.stage.assets.ready', function () {
    //    stage.showTerrain();
    //
    //    $.ajax({
    //        url: '/statistics?type=co2',
    //        success: function (data) {
    //            stage.showClouds(data.result);
    //        },
    //        error: function () {
    //            console.log('unable to load co2 data');
    //        }
    //    });
    //});
})(hm, d3, jQuery);
