;(function (hm, d3) {
    'use strict';

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

    var width   = 100;
    var height  = 150;
    var scaleY  = d3.scale.linear()
        .range([height, 0]);









})(hm, d3);
