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
    'marionette'
        ], factory);
    } else {
        // Browser globals:
        factory(window.App, window.jQuery, window.Backbone, window.Backbone.Marionette);
    }
}(function(App, $,  Backbone, Marionette){
    'use strict';

    /**
     *
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.GridItem  = Marionette.ItemView.extend({
        
        template: "#ProductItemTemplate",
        tagName: 'div',
        className: 'span2'
    });

    return App.view.GridItem;

}));