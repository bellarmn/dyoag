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
            'backbone',
            'router'
            
        ], factory);
    } else {
        // Browser globals:
        factory(window.jQuery, window._, window.Backbone, window.Router);
    }
}(function ($, _, Backbone, Router ) {

    'use strict';

    /**
     * Upload application class and model.
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */

    BenagroApp = window.BenagroApp = function () {
        _.extend(this, Backbone.Events);
        window.benagroapp = this;
        this.router = new Router(this);
        this.initialize();

    };
    BenagroApp.prototype = {
        initialize: function () {

            var self = this;

            if (window.DEMO_MODE) {
                this.setDemoMode();
            }
            this.isLoading = true;

//            collection de framework
//            un framework a de template 
//            collection de type de components (recherche etc)


            $(document).ready(function () {
                self._onDocumentReady();
                //Load existing page
//                this.templateSelectorGroup = new TemplateSelectorGroup({
//                    swapp: this,
//                    // TODO : Replace by templates route
//                    baseUrl: '/app_dev.php/ws/v1.0/patterns',
//                    el: $('#pageContainer')
//                });
            });
        },

    };
    return BenagroApp;
}));
