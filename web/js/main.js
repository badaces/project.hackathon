;(function (hm, d3, $) {
    'use strict';

    //console.log('hm:', hm);

    var eventmanager = hm.eventManager();

    //hm.watchMethod(eventmanager, 'publish', function (event) {
    //    console.log('published: ', event);
    //});

    var canvas = document.getElementById('stage-wrapper');
    var stages = document.getElementsByClassName('stage');
    var scenes = document.getElementsByClassName('scene');
    var clouds = document.getElementsByClassName('cloud');
    var bubble = document.getElementsByClassName('greenhouse-effect')[0];

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
            stage: document.getElementsByClassName('stage-CO2-img')[0],
            scene: document.getElementsByClassName('scene-CO2-img')[0],
            elements: [clouds]
        }
    };

    var hideElements = function () {
        bubble.style.opacity = '0';

        hm.each([stages, scenes, clouds], function (i, collection) {
            hm.each(collection, function (i, element) {
                if (i !== 'length') {
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
                    if (i !== 'length') {
                        d3.select(element).transition()
                            .delay(100 + (100 * i))
                            .duration(600)
                            .style('opacity', '1');

                        if (i === '5') {
                            element.style.opacity = '1';
                        }
                    }
                });
            });
        }
    });

    var buttun = document.getElementsByClassName('greenhouse-toggle')[0].onclick = function () {
        d3.select(bubble).transition()
            .duration(1000)
            .style('opacity', '1');
    };

    console.log(buttun);

    // initialize stage selection
    // ==========================

    hm.canvasSelector();
    hm.informationPanel();

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

            var CO2 = {
                1960: {entries: 0, data: 0, selector: 'cloud-CO2-01'},
                1970: {entries: 0, data: 0, selector: 'cloud-CO2-02'},
                1980: {entries: 0, data: 0, selector: 'cloud-CO2-03'},
                1990: {entries: 0, data: 0, selector: 'cloud-CO2-04'},
                2000: {entries: 0, data: 0, selector: 'cloud-CO2-05'},
                2010: {entries: 0, data: 0, selector: 'cloud-CO2-06'}
            };

            hm.each(data, function (i, record) {
                if (record.year >= 1960) {
                    var point = record.year.toString().substring(0, 3) + '0';

                    CO2[point].entries += 1;
                    CO2[point].data += record.data;
                }
            });

            // display CO2 data
            hm.each(clouds, function (i, cloud) {
                if (i !== 'length') {
                    var selector = cloud.className.match(/cloud-\S+/g)[0];
                    var info = {};

                    hm.each(CO2, function (i, result) {
                        if (result.selector === selector) {
                            info = result;
                            info.year = i;
                        }
                    });

                    var finalYear = info.year === '2010' ? '13' : (+info.year + 9).toString().substring(2, 4);

                    cloud.getElementsByClassName('stats')[0].innerHTML = Math.round((info.data / info.entries) * 100) / 100;
                    cloud.getElementsByClassName('unit')[0].innerHTML = 'avg ppm CO2';
                    cloud.getElementsByClassName('legend')[0].innerHTML =
                        '<span class="label">Years</span>' + info.year + '-' + finalYear;

                    if (info.year === '1970') {
                        cloud.getElementsByClassName('stats')[0].innerHTML = '1656.1';
                        cloud.getElementsByClassName('unit')[0].innerHTML = 'avg ppb CH4';
                        cloud.getElementsByClassName('legend')[0].innerHTML =
                            '<span class="label">Year</span> 1984';
                    }

                    if (info.year === '1990') {
                        cloud.getElementsByClassName('stats')[0].innerHTML = '1831.1';
                        cloud.getElementsByClassName('unit')[0].innerHTML = 'avg ppb CH4';
                        cloud.getElementsByClassName('legend')[0].innerHTML =
                            '<span class="label">Year</span> 2013';
                    }

                    //cloud.title = 'add hover title here';
                }
            });
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
