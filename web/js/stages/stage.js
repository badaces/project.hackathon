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
                            .attr('class', asset.name)
                            .attr('display', 'none');

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

                eventmanager.publish('d3.stage.ready');
            });
        },
        showTerrain: function () {

        }
    };

    hm.extend(hm, {stages: {stage: Stage}});
})(hm, d3);