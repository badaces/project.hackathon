;(function (hm, d3) {
    'use strict';

    var height  = 400;
    var width   = 300;

    var panels = {};
    var panel = document.createElement('div');
    panel.className = 'panel';

    panel.style.height      = '400px';
    panel.style.width       = '300px';

    panel.style.boxShadow   = '0 0 0 1px #000';
    panel.style.cssFloat    = 'left';

    var container = document.getElementsByClassName('panel-container')[0];

    // Todo: move each panel into a separated file
    panels.herbicide = container.appendChild(panel.cloneNode(true));
    panels.herbicide.className = 'herbicide';

    var data = [25, 13, 27, 32, 23, 47, 34, 22, 18, 34, 11, 42, 35, 44];

    var chartWidth = 170;
    var chartHeight = 150;
    var barWidth = chartWidth / data.length;

    var scaleY = d3.scale.linear()
        .domain([0, d3.max(data, function (d) { return d; })])
        .range([chartHeight, 0]);

    var barChart = d3.select(panels.herbicide)
        .append('svg')
        .attr('width', width)
        .attr('height', chartHeight)
        .attr('transform', 'translate(' + (width - chartWidth) + ', 2)');

    var bar = barChart.selectAll('g')
        .data(data)
        .enter().append('g')
        .attr('transform', function (d, i) { return 'translate(' + (i * barWidth) + ', 0)'; });

    bar.append('rect')
        .attr('y', function (d) { return scaleY(d); })
        .attr('height', function (d) { return chartHeight - scaleY(d); })
        .attr('width', barWidth - 2);

    console.log(barChart);
    console.log(bar);








})(hm, d3);
