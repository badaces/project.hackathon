;(function (hm, d3, undefined) {
    'use strict';

    var defaults = {
        height: 700,
        width: 700
    };

    var Stage = function (container, options) {
        this._d3 = hm.d3.helper;
        this.container = container;
        this.options = hm.extend({}, defaults, options);
        this.eventmanager = hm.eventmanager;
        this.assets = {};

        this.setAssets();
        this.setStage();
    };

    Stage.prototype = {
        _d3: undefined,
        container: undefined,
        eventmanager: undefined,
        options: undefined,
        stage: undefined,
        assets: undefined,
        setAssets: function () {
            var self = this;
            var container = this.container;
            var eventmanager = this.eventmanager;
            var assets = [
                {filename: 'cloud.svg', name: 'cloud'},
                {filename: 'terrain1.svg', name: 'terrain1'}
            ];

            eventmanager.subscribe('d3.stage.ready', function () {
                var assetsLoaded = 0;
                var totalAssets = assets.length;

                hm.each(assets, function (i, asset) {
                    d3.xml('/web/svg/' + asset.filename, 'image/svg+xml', function (xml) {
                        var element = container.appendChild(xml.documentElement);

                        self.assets[asset.name] = d3.select(element)
                            .attr('id', '')
                            .attr('class', 'asset ' + asset.name)
                            .style('opacity', '0');

                        assetsLoaded++;

                        if (assetsLoaded >= totalAssets) {
                            eventmanager.publish('d3.stage.assets.ready');
                        }
                    });
                });
            });
        },
        setStage: function () {
            var self = this;
            var container = this.container;
            var eventmanager = this.eventmanager;

            d3.xml('/web/svg/stage.svg', 'image/svg+xml', function (xml) {
                var element = container.appendChild(xml.documentElement);

                self.stage = d3.select(element).attr('class', 'stage scene-CO2');
                self.stage.style('opacity', '0');

                eventmanager.publish('d3.stage.ready');
            });
        },
        showClouds: function (data) {
            var cloud = this.assets.cloud;
            var clouds = {
                1960: {x: 20, y: 20, entries: 0, data: 0},
                1970: {x: 30, y: 20, entries: 0, data: 0},
                1980: {x: 40, y: 20, entries: 0, data: 0},
                1990: {x: 50, y: 20, entries: 0, data: 0},
                2000: {x: 60, y: 20, entries: 0, data: 0},
                2010: {x: 70, y: 20, entries: 0, data: 0}
            };

            hm.each(data, function (i, record) {
                if (record.year >= 1960) {
                    var point = record.year.toString().substring(0, 3) + '0';

                    clouds[point].entries += 1;
                    clouds[point].data += record.data;
                }
            });

            console.log(clouds);

            hm.each(clouds, hm.proxy(function (year, data) {
                var clone = d3.select(this.container.appendChild(cloud.node().cloneNode(true)));
                var text = d3.select(this.container).append('text');
                var width = (data.data / 100 / 2);

                width = width >= 12 ? width : 12;

                console.log(text);

                clone
                    .style('left', data.y + '%')
                    .style('top', data.x + '%')
                    .style('width', width + '%')
                    .style('opacity', '1');


                text
                    .attr('class', 'text-CO2')
                    .attr('x', 300)
                    .attr('y', 50)
                    .attr('dy', '0.35em')
                    .style('fill', 'black')
                    .style('font', '14px sans-serif')
                    .text(year + ': ' + data.data);
                //
                //console.log(text);
            }, this));

            console.log(data);
        },
        showTerrain: function () {
            this.stage.style('opacity', '1');
            this.assets.terrain1.style('opacity', '1');
        }
    };

    hm.extend(hm, {stages: {stage: Stage}});
})(hm, d3);