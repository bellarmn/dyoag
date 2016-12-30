/*
 * This file is part of the Benagro package.
 *
 * (c) Jacques Adjahoungbo <jtocson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

(function (factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // Register as an anonymous AMD module:
        define([
            'jquery',
            'underscore',
            'app',
            'view/templateselector/TemplateSelector',
            'CollectionType',
            'collection/Default',
            'model/templateselector/TemplateSelector',
            'gridster'
        ], factory);
    } else {
        // Browser globals:
        factory(window.jQuery, window._, window.App, window.App.view.TemplateSelector, window.CollectionType);
    }
}(function ($, _, App, TemplateSelectorView, CollectionType) {
    'use strict';

    /**
     *
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.TemplateSelectorGroup = CollectionType.extend({
        className: 'container',
        itemType: TemplateSelectorView,
        initialize: function (config) {
            this.swapp = config.swapp;
            this.baseUrl = config.baseUrl;
            this.$el.html(
                    '<div id="offers" class="row flow-offset-1 clearleft gridster">' +
                    '<div class="offers-container">' +
                    '</div>' +
                    '<div>' +
                    '<div class="container">' +
                    '<div class="col-inset-2 text-center btn-group" role="group" aria-label="First group">' +
                    '<div id="pagination" class="navigation">' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                    );

            this.templateThumbList = this.$el.find('.offers-container');
            this.thumbListPagination = this.$el.find('#pagination');
            this.$el = this.templateThumbList;

            this.sortedby = null;

            this.collection = new App.collection.Default(
                    [],
                    {
                        name: 'swapp_componentselectorbox',
                        model: App.model.TemplateSelector
                    });
            this.loadTemplate();

            App.view.TemplateSelectorGroup.__super__.initialize.apply(this, arguments);
        },
        filterByCategory: function (category) {
            this.category = category;
            this.loadTemplate(1);
        },
        sortedBy: function (sortedby) {
            this.sortedby = sortedby;
            this.loadTemplate(1);
        },
        loadTemplate: function (page) {
            var self = this;
            var data = {};

            if (page > 1) {
                this.page = page;
            }
            if (this.page > 1) {
                data.page = this.page;
            }

            data.category = this.category;
            data.sortedby = this.sortedby;

            if (jXhr && jXhr.readystate !== 4) {
                jXhr.abort();
            }
            var jXhr = $.ajax({
                url: this.baseUrl,
                type: "GET",
                data: data,
                crossDomain: true,
                context: this.templateThumbList,
                beforeSend: function (jqxhr, settings) {
                    if (self.templateThumbList.data('template') === settings.url) {
                        return false;
                    }
                    self.templateThumbList.data('template', settings.url);
                },
                success: function (response, status, xhr) {
                    if (!response.ventes) {
                        return;
                    }

                    for (var j = 0, l = response.ventes.length; j < l; j++) {
                        response.ventes[j].datarow = Math.floor(j / 4);
                        response.ventes[j].datacol = j % 4;
                    }

                    self.collection.reset(response.ventes);
                    self.$el.removeClass('loaderCollection');

                    var page = parseInt(response.pagination.page);
                    var pages_count = parseInt(response.pagination.pages_count);
                    var pagination = '<ul class="pagination">';
                    if (page > 1) {
                        pagination += '<li><a data-page="1" href="' + self.baseUrl + '?page=1"><<</a></li>' +
                                '<li><a data-page="' + (page - 1) + '" href="' + self.baseUrl + '?page=' + (page - 1) + '"><</a></li>';
                    }

                    // Calculate pagination and show
                    var current;
                    var min = Math.max(page - 5, 1);
                    var max = Math.min(page + 5, pages_count);
                    // display p numbers only from p-3 to p+3 but don't go <1 or >pages_count#}
                    for (var p = min; p <= max; p++) {
                        current = (p === page) ? ' class="active"' : '';
                        pagination += '<li' + current + '><a data-page="' + p + '" href="' + self.baseUrl + '?page=' + p + '">' + p + '</a></li>';
                    }

                    if (page < pages_count) {
                        pagination += '<li><a data-page="' + (page + 1) + '" href="' + self.baseUrl + '?page=' + (page + 1) + '">></a></li>' +
                                '<li><a data-page="' + pages_count + '" href="' + self.baseUrl + '?page=' + pages_count + '">>></a></li>';
                    }
                    pagination += '</ul>';

                    self.thumbListPagination.html(pagination);
                    self.thumbListPagination.find('ul.pagination li a').on('click touchstart', self, self.goToPage);
                },
                error: function () {
                    // initSubFamilySidebar();
                    $(this).removeClass('loaderCollection');
                    // showErrorMsgBox();
                }
            });
        },
        getSelectedTemplateId: function () {
            return this.selectedTemplateId;
        },
        goToPage: function (e) {
            e.preventDefault();
            var self = e.data;
            var page = $(e.target).data('page');
            console.log(self, this, page);
            self.loadTemplate(page);
        },
        /**
         * Select a template in the group
         * @param item
         * @param $clickedTemplate
         */
        selectItem: function (item, $clickedTemplate) {

            var clickedTemplateId;
            // Remove element from all template
            this.$el.find(".template")
                    .removeClass("template-selected")
                    .removeClass("selected")
                    .removeAttr("clicked");

            $clickedTemplate.attr("clicked", "true")
                    .addClass('selected')
                    .addClass('template-selected');

            clickedTemplateId = $clickedTemplate.find('div.project_container').data('id');
            if (clickedTemplateId !== this.selectedTemplateId) {
                this.selectedTemplateId = clickedTemplateId;
                // TODO: Gérer la traduction
                this.$el.trigger('change.itempicker');
            }
        },
        hideAllTemplateSelector: function () {
            for (var i = 0, length = this.viewCollection.length; i < length; i++) {
                this.viewCollection[i].hide();
            }
        },
        render: function () {
            App.view.TemplateSelectorGroup.__super__.render.call(this);
            console.log(this.$el.find(".gridster .offers-container"));
            this.$el.find(".gridster .offers-container").gridster({
                widget_margins: [10, 10],
                widget_base_dimensions: [250, 378]
            });
        }
    });

    return App.view.TemplateSelectorGroup;
}));
