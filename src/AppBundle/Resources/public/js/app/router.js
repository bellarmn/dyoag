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
            'backbone',
            'app'
        ], factory);
    } else {
        // Browser globals:
        factory(window.jQuery, window.Backbone, window.App);
    }
}(function($, Backbone, App) {
    'use strict';

    /**
     * Manage events and routes.
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    console.log('rooter loaded');
    
    App.Router = Backbone.Router.extend({
        initialize: function(benagroApp) {
            this.benagroApp = benagroApp;
        },
        //  Les routes
        routes: {
            "": "root",
        },
        /**
         * Home page
         */
        root: function()
        {
        },

    });

    return (App.Router);
}));