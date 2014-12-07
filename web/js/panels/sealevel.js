;(function (hm, d3, undefined) {
    'use strict';

    var options = {
        height: 400,
        width: 200
    };

    var SeaLevel = function (container) {
        this._d3 = hm.d3.helper;
        this.container = container;
        this.data = undefined;
        this.panel = undefined;
    };

    SeaLevel.prototype = {
        _d3: undefined,
        container: undefined,
        data: undefined,
        panel: undefined,
        createChart: function () {
            var _d3 = this._d3;
            var chartHeight = options.height * 0.5;
            var chartWidth = options.width * 0.8;

            var barHeight = chartHeight / this.data.length;

            var scaleX = d3.scale.linear()
                .domain([0, d3.max(this.data)])
                .range([0, chartWidth]);

            var chart = d3.select(this.panel)
                .append('svg')
                .attr('width', chartWidth)
                .attr('height', chartHeight);

            var bar = chart.selectAll('g')
                .data(this.data)
                .enter().append('g')
                .attr('transform', function (d, i) {
                    return _d3.translate(0, (i * barHeight));
                });

            bar.append('rect')
                .style('fill', 'steelblue')
                .attr('width', scaleX)
                .attr('height', barHeight - 1);

            bar.append('text')
                .style('fill', 'white')
                .style('font', '9px sans-serif')
                .style('text-anchor', 'end')
                .attr('x', function (d) { return scaleX(d) - 3; })
                .attr('y', barHeight / 2)
                .attr('dy', '0.35em')
                .text(function (d) { return d; });
        },
        getPanel: function () {
            this.panel = this.panel || this._d3.createPanel(options.height, options.width);

            return this.panel;
        },
        setData: function (data) {
            this.data = data;
            return this;
        },
        show: function (data) {
            var panel = this.getPanel();
            panel.className = panel.className + ' sealevel';

            this.container.appendChild(panel);
            this.setData(data);
            this.createChart();

            return this;
        }
    };

    hm.extend(hm, { panels: { sealevel: SeaLevel }});
})(hm, d3);
