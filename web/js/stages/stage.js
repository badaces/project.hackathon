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

                self.stage = d3.select(element).attr('id', 'stage');
                self.stage.style('opacity', '0');

                eventmanager.publish('d3.stage.ready');
            });
        },
        showClouds: function (data) {
            var cloud = this.assets.cloud;
            //var bubble = d3.layout.pack()
            //    .sort(null)
            //    //.size([300, 300])
            //    .padding(1.5);
            //
            //var svg = d3.select(this.container).append('svg')
            //    .attr('width', '50%');
            //
            //
            //
            //
            //console.log(data);


            var clouds = [[47, 31, 12], [32, 19, 17], [61, 27, 9], [27, 29, 13], [52, 13, 19]];

            hm.each(clouds, hm.proxy(function (i, value) {
                var clone = d3.select(this.container.appendChild(cloud.node().cloneNode(true)));

                clone
                    .style('left', value[0] + '%')
                    .style('top', value[1] + '%')
                    .style('width', value[2] + '%')
                    .style('opacity', '1');
            }, this));
        },
        showTerrain: function () {
            this.stage.style('opacity', '1');
            this.assets.terrain1.style('opacity', '1');
        }
    };

    hm.extend(hm, {stages: {stage: Stage}});
})(hm, d3);