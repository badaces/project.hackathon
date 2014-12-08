;(function (hm, d3, $) {
    'use strict';

    console.log('hm:', hm);

    var eventmanager = hm.eventManager();

    hm.watchMethod(eventmanager, 'publish', function (event) {
        console.log('published: ', event);
    });

    var canvas = document.getElementById('stage-wrapper');
    var stages = document.getElementsByClassName('stage');
    var scenes = document.getElementsByClassName('scene');
    var clouds = document.getElementsByClassName('cloud');

    var selectors = {
        cryosphere: {
            stage: undefined,
            scene: undefined,
            elements: undefined
        },
        hydrosphere: {
            stage: undefined,
            scene: undefined,
            elements: undefined
        },
        lithosphere: {
            stage: undefined,
            scene: undefined,
            elements: undefined
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
                if (i != 'length') {
                    element.style.opacity = '0';
                }
            });
        });
    };

    eventmanager.subscribe('canvas.selector.updated', function (data) {
        var newElement = data.newElement;
        var selector = newElement.textContent.toLowerCase();

        hideElements();

        if (selectors[selector] && selectors[selector].stage) {
            selectors[selector].stage.style.opacity = '1';
            selectors[selector].scene.style.opacity = '1';

            hm.each(selectors[selector].elements, function (i, collection) {
                hm.each(collection, function (i, element) {
                    if (i != 'length') {
                        element.style.opacity = '1';
                    }
                });
            });
        }
    });

    // initialize scene selection
    // ==========================

    hm.canvasSelector();

    eventmanager.publish('canvas.selector.updated', {
        newElement: document.getElementsByClassName('select-atmosphere')[0],
        oldElement: undefined
    });

    // set up cloud CO2 emissions data
    // ===============================

    var cloudRequest = new XMLHttpRequest();

    cloudRequest.open('GET', '/statistics?type=co2', true);
    cloudRequest.responseType = 'json';
    cloudRequest.onreadystatechange = function () {
        if (cloudRequest.readyState === 4 && cloudRequest.status === 200) {
            // consume cloud data
            var data = cloudRequest.response.result;

            var clouds = {
                1960: {entries: 0, data: 0},
                1970: {entries: 0, data: 0},
                1980: {entries: 0, data: 0},
                1990: {entries: 0, data: 0},
                2000: {entries: 0, data: 0},
                2010: {entries: 0, data: 0}
            };

            hm.each(data, function (i, record) {
                if (record.year >= 1960) {
                    var point = record.year.toString().substring(0, 3) + '0';

                    clouds[point].entries += 1;
                    clouds[point].data += record.data;
                }
            });

            // display cloud data
            console.log(clouds);
        }
    };

    cloudRequest.send();

})(hm, d3, jQuery);
