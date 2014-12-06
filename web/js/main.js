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

    var data = [11, 13, 9, 32, 23, 33];

    var chartWidth = 170;
    var chartHeight = 150;
    var barWidth = chartWidth / data.length;

    var scaleY = d3.scale.linear()
        .domain([0, d3.max(data, function (d) { return d; })])
        .range([chartHeight, 0]);

    var chart = d3.select(panels.herbicide)
        .append('svg')
        .attr('width', width)
        .attr('height', chartHeight)
        .attr('transform', 'translate(' + (width - chartWidth) + ', 2)');

    var bar = chart.selectAll('g')
        .data(data)
        .enter().append('g')
        .attr('transform', function (d, i) { return 'translate(' + (i * barWidth) + ', 0)'; });

    bar.append('rect')
        .attr('y', function (d) { return scaleY(d); })
        .attr('height', function (d) { return chartHeight - scaleY(d); })
        .attr('width', barWidth - 2);




    console.log(chart);
    console.log(bar);




    //var chart = d3.select(panels.herbicide)
    //    .data(data)
    //    .enter().append('svg')
    //    .attr('transform', function (d, i) {
    //        return 'translate(' + i * (width / data.length) + ', 0)';
    //    });
    //
    //chart.selectAll('svg').append('rect')
    //    .attr('y', function(d) {
    //        console.log(d);
    //        return scaleY(d);
    //    });
    //
    //console.log(chart.selectAll('svg'));
})(hm, d3);
