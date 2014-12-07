;(function (hm, d3, undefined) {
    'use strict';

    var options = {
        charts: {
            bar: {
                height: 200,
                width: 200
            },
            pie: {
                height: 250,
                width: 250
            }
        },
        height: 600,
        width: 400
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
        createBarChart: function () {
            var _d3 = this._d3;
            var height = options.charts.bar.height;
            var width = options.charts.bar.width;

            var barHeight = height / this.data.bar.length;

            var scaleX = d3.scale.linear()
                .domain([0, d3.max(this.data.bar)])
                .range([0, width - 10]);

            var chart = d3.select(this.panel)
                .append('svg')
                .attr('width', width)
                .attr('height', height);

            var bar = chart.selectAll('g')
                .data(this.data.bar)
                .enter().append('g')
                .attr('transform', function (d, i) {
                    return _d3.translate(0, (i * barHeight));
                });

            bar.append('rect')
                .style('fill', 'steelblue')
                .attr('width', function (d) { return d + 10; })
                .attr('height', barHeight - 1)
                .on('mouseenter', function () {
                    d3.select(this).transition()
                        .duration(200)
                        .style('fill', 'royalblue');
                })
                .on('mouseleave', function () {
                    d3.select(this).transition()
                        .duration(200)
                        .style('fill', 'steelblue');
                });

            bar.append('text')
                .style('fill', 'white')
                .style('font', '9px sans-serif')
                .style('text-anchor', 'end')
                .attr('x', function (d) { return scaleX(d) - 10; })
                .attr('y', barHeight / 2)
                .attr('dy', '0.35em')
                .text(function (d) { return d; });

            d3.selectAll('rect').transition()
                .duration(750)
                .delay(function (d, i) { return i * 50; })
                .attr('width', function (d) { return scaleX(d); })
        },
        createPieChart: function () {
            var _d3 = this._d3;
            var height = options.charts.pie.height;
            var width = options.charts.pie.width;
            var radius = Math.min(width, height) / 2;

            var color = d3.scale.ordinal()
                .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

            var arc = d3.svg.arc()
                .outerRadius(radius - 10)
                .innerRadius(radius / 2);

            var pie = d3.layout.pie()
                .sort(null)
                .value(function (d) { return d.amount; });

            var svg = d3.select(this.panel)
                .append('svg')
                    .attr('width', width)
                    .attr('height', height)
                .append('g')
                    .attr('transform', _d3.translate(width / 2, height / 2));

            var slice = svg.selectAll('.arc')
                .data(pie(this.data.pie))
                .enter().append('g')
                    .attr('class', 'arc');

            slice.append('path')
                .attr('d', arc)
                .style('stroke', 'white')
                .style('fill', function (d) { return color(d.data.label)});

            slice.append('text')
                .attr('transform', function (d) {
                    var centroid = arc.centroid(d);

                    //centroid[0] = centroid[0] + (centroid[0] * 0.4);
                    //centroid[1] = centroid[1] + (centroid[1] * 0.4);

                    return _d3.translate(centroid);
                })
                .attr('dy', '0.35em')
                .style('font', '9px sans-serif')
                .style('text-anchor', 'middle')
                .text(function (d) { return d.data.label; });
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
            this.createBarChart();
            this.createPieChart();

            return this;
        }
    };

    hm.extend(hm, { panels: { sealevel: SeaLevel }});
})(hm, d3);
