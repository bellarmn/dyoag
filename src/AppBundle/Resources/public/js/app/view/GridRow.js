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
    'gridItem'
        ], factory);
    } else {
        // Browser globals:
        factory(window.App, window.jQuery, window.Backbone, window.Backbone.Marionette, window.App.view.GridItem);
    }
}(function(App, $,  Backbone, Marionette, GridItem){
    'use strict';

    /**
     *
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.GridRow  = Marionette.CompositeView.extend({
        template: "#row-template",
        itemView: GridItem,
        itemViewContainer: "div.row-fluid",
        initialize: function() {
            this.collection = new Backbone.Collection(_.toArray(this.model.attributes));
        }
    });

    return App.view.GridRow;

}));