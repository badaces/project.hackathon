;(function ($, document, undefined) {
    'use strict';

    var defaults = {
        selector: 'information-wrapper',
        childClass: 'info-injector',
        events: {
            selectorUpdated: 'canvas.selector.updated'
        },
        classPrefix: 'select-',
        wikiArticles: {
            cryosphere: '',
            hydrosphere: '',
            lithosphere: '',
            atmosphere: 'Greenhouse effect'
        }
    };

    var InformationPanel = function (eventManager, wikipedia, options) {
        this.eventManager = eventManager;
        this.wikipedia = wikipedia;
        this.setOptions(options);

        this.configure();
    };

    InformationPanel.prototype = {
        panelElement: undefined,
        eventManager: undefined,
        options: undefined,
        wikipedia: undefined,
        setOptions: function (options) {
            this.options = $.extend({}, defaults, options);
        },
        configure: function () {
            this.eventManager.subscribe(this.options.events.selectorUpdated, $.proxy(this.onSelectorUpdated, this));
        },
        onSelectorUpdated: function (event) {
            var targetArticle = event.newElement.className.substr(this.options.classPrefix.length);
            var panelElement = this.panelElement;

            if ($.isUndefined(panelElement)) {
                panelElement = document
                    .getElementById(this.options.selector)
                    .getElementsByClassName(this.options.childClass)[0]
                ;

                this.panelElement = panelElement;
            }

            this.wikipedia.getArticleByName(this.options.wikiArticles[targetArticle], $.proxy(function (data) {
                var article = data.response.result;

                if (article) {
                    var titleElement = panelElement.getElementsByTagName('h2')[0];
                    var paragraphElements = panelElement.getElementsByTagName('p');
                    var sourceCaptionElement = panelElement.getElementsByClassName('source-caption')[0];

                    var elementsToRemove = [];

                    $.each(paragraphElements, function (i, element) {
                        if (i !== 'length' && element.className !== 'source-caption') {
                            elementsToRemove.push(element);
                        }
                    });

                    // Can't delete in the above loop because HTMLCollection will re-key elements.
                    $.each(elementsToRemove, function (i, element) {
                        element.remove();
                    });

                    var paragraphs = article.summary.split(/\n/);
                    $.each(paragraphs, function (i, text) {
                        var newContent = document.createElement('p');
                        newContent.innerHTML = text;

                        panelElement.appendChild(newContent);
                    });
                    panelElement.appendChild(sourceCaptionElement);

                    titleElement.innerHTML = article.title;
                }
            }, this));
        }
    };

    var instance;
    var createInstance = function (options) {
        if ($.isUndefined(instance)) {
            instance = new InformationPanel($.eventManager(), $.wikipedia(), options);
        } else {
            instance.setOptions(options);
        }

        return instance;
    };

    $.extend($, {informationPanel: createInstance});
    $.extend($, {classes: {InformationPanel: InformationPanel}});
})(hm, document);
