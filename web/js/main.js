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

    // initialize stage selection
    // ==========================

    hm.canvasSelector();

    eventmanager.publish('canvas.selector.updated', {
        newElement: document.getElementsByClassName('select-atmosphere')[0],
        oldElement: undefined
    });

    // set up CO2 emissions data
    // ===============================

    var CO2Request = new XMLHttpRequest();

    CO2Request.open('GET', '/statistics?type=co2', true);
    CO2Request.responseType = 'json';
    CO2Request.onreadystatechange = function () {
        if (CO2Request.readyState === 4 && CO2Request.status === 200) {
            // consume CO2 data
            var data = CO2Request.response.result;

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

            // display CO2 data
            console.log(clouds);
        }
    };

    CO2Request.send();

    // set up CH4 emissions data
    // =============================

    var CH4Request = new XMLHttpRequest();

    CH4Request.open('GET', '/statistics?type=methane', true);
    CH4Request.responseType = 'json';
    CH4Request.onreadystatechange = function () {
        if (CH4Request.readyState === 4 && CH4Request.status === 200) {
            // consume CH4 data
            var data = CH4Request.response.result;

            // display CH4 data
            //console.log(data);
        }
    };

    CH4Request.send();


})(hm, d3, jQuery);
