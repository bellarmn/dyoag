/*
 * This file is part of the Benagro package.
 *
 * (c) Jacques Adjahoungbo <jtocson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */


(function(factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // Register as an anonymous AMD module:
        define([
            'jquery',
            'underscore',
            'app',
            'jquery.ui'
        ], factory);
    } else {
        // Browser globals:
        factory(window.jQuery, window._, window.App);
    }
}(function($, _, App) {
    'use strict';

    /**
     * 
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.CollectionType = App.View.extend({
        tagName: 'div',
        className: 'container',
        itemType: null,
        itemAttribute: 'model',
        constructor: function(options) {
            this.events = $.extend(true, {}, App.view.CollectionType.prototype.events, this.events);
            App.View.prototype.constructor.call(this, options);
        },
        initialize: function() {
            //  Exécuter la methode render à chaque évènement sur l'objet
            _.bindAll(this, 'render');
            //  on exécute la fonction render à chaque fois qu'on a un changement sur le model
            this.collection.on('add', this.renderItem, this);
            this.collection.on('remove', this.removeItemView, this);
            this.collection.on('reset', this.render, this);
            // List of breadcrumb items view
            this.viewCollection = new Array();
//            this.render();
        },
        /**
         * Remove item view from screen
         * @param {type} item
         * @param {type} collection
         * @param {type} data
         * @returns {undefined}
         */
        removeItemView: function(item, collection, data) {
            if (data.index < 0) {
                return;
            }
            this.viewCollection[data.index].deleteDefinitively();
            this.viewCollection.splice(data.index, 1);
        },
        /**
         * Add and render a new item for this collection
         * @param {type} item
         * @returns {undefined}
         */
        renderItem: function (item) {
            var config = {
                container: this,
                model: item
            };
            if (typeof this.swapp !== 'undefined') {
                config.swapp = this.swapp;
            }

            var itemView = new this.itemType(config);
            this.viewCollection.push(itemView);
            this.$el.append(itemView.render().el);
    	},
        render: function() {
            var self = this;
            // detach subitem for prevent loose of event
            for (var i = 0, l = this.viewCollection.length; i < l; i++) {
                this.viewCollection[i] && this.viewCollection[i].deleteDefinitively();
            }
            this.viewCollection = [];

            this.$el.empty();
            this.collection.each(function(item) {
                self.renderItem(item);
            });
            return this;
        },
        clear: function() {
            this.collection.reset();
            return this;
        }
    });

    return App.view.CollectionType;
}));
