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
    'app',
    'jquery',
    'backbone',
    'marionette',
    'gridRow'
        ], factory);
    } else {
        // Browser globals:
        factory(window.App, window.jQuery, window.Backbone, window.Backbone.Marionette, window.App.view.GridRow);
    }
}(function(App, $,  Backbone, Marionette, GridRow){
    'use strict';

    /**
     *
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.Grid  = Marionette.CompositeView.extend({
    template: "#grid-template",
    itemView: GridRow,
    itemViewContainer: "section",
//    initialize: function() {
//        var grid = this.collection.groupBy(function(list, iterator) {
//            return Math.floor(iterator / 4); // 4 == number of columns
//        });
//        this.collection = new Backbone.Collection(_.toArray(grid));
//    }
    });

    return App.view.Grid;

}));