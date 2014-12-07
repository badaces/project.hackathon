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
            .attr('transform', 'translate(' + (width - chartWidth) / 2 + ', 2)');

    var bar = barChart.selectAll('g')
            .data(data)
        .enter().append('g')
            .attr('transform', function (d, i) { return 'translate(' + (i * barWidth) + ', 0)'; });

    bar.append('rect')
        .attr('y', function (d) { return scaleY(d); })
        .attr('height', function (d) { return chartHeight - scaleY(d); })
        .attr('width', barWidth - 2);

    data = [
        {date: '1-May-14', value: 39},
        {date: '15-May-14', value: 13},
        {date: '23-May-14', value: 24},
        {date: '1-Jun-14', value: 26},
        {date: '15-Jun-14', value: 22},
        {date: '23-Jun-14', value: 27},
        {date: '1-Jul-14', value: 17},
        {date: '15-Jul-14', value: 23},
        {date: '23-Jul-14', value: 21},
        {date: '1-Aug-14', value: 35},
        {date: '15-Aug-14', value: 24},
        {date: '23-Aug-14', value: 16}
    ];

    var margin = {top: 20, right: 20, bottom: 40, left: 40};
    var lineWidth = 190;
    var lineHeight = 110;
    var parseDate = d3.time.format('%d-%b-%y').parse;

    var lineX = d3.time.scale().range([0, lineWidth]);
    var lineY = d3.time.scale().range([lineHeight, 0]);

    var axisX = d3.svg.axis().scale(lineX).orient('bottom');
    var axisY = d3.svg.axis().scale(lineY).orient('left');

    var line = d3.svg.line()
        .x(function (d) { return lineX(d.date); })
        .y(function (d) { return lineY(d.value); });

    var graph = d3.select(panels.herbicide)
        .append('svg')
            .attr('width', width)
            .attr('height', lineHeight + margin.top + margin.bottom)
            .attr('transform', 'translate(' + (width - lineWidth) / 4 + ', 0)')
        .append('g')
            .attr('transform', 'translate(' + margin.left + ', ' + margin.top + ')');

    hm.each(data, function (i, entry) {
        data[i].date = parseDate(entry.date);
        data[i].value = +entry.value;
    });

    lineX.domain(d3.extent(data, function (d) { return d.date; }));
    lineY.domain(d3.extent(data, function (d) { return d.value; }));

    graph.append('g')
        .attr('class', 'x axis')
        .attr('font-size', '0.7em')
        .attr('transform', 'translate(0, ' + lineHeight + ')')
        .call(axisX)
        .selectAll('text')
            .style('text-anchor', 'end')
            .attr('dx', '-.4em')
        .attr('dy', '.12em')
            .attr('transform', 'rotate(-65)');

    graph.append('g')
        .attr('class', 'y axis')
        .attr('font-size', '0.6em')
        .call(axisY)
        .append('text')
            .attr('transform', 'rotate(-90)')
            .attr('y', -35)
            .attr('x', -50)
            .attr('dy', '.71em')
            .style('text-anchor', 'end')
            .text('Value');

    graph.append('path')
        .datum(data)
        .attr('class', 'line')
        .attr('d', line);

})(hm, d3);














