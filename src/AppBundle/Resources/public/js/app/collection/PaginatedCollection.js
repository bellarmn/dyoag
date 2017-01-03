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
    'paginator',
    'jquery.spin',
    'offre'
        ], factory);
    } else {
        // Browser globals:
        factory(window.App, window.jQuery, window.Backbone, window.Backbone.Paginator );
    }
}(function(App, $,  Backbone, Paginator){
    'use strict';

    /**
     *
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.collection.PaginatedCollection  = Paginator.requestPager.extend({
        model: App.model.Offre,
        paginator_core: {
          dataType: 'json',
          url: Routing.generate('get_ventes')
        },

        paginator_ui: {
          firstPage: 1,
          currentPage: 1,
          perPage: 6,
          totalPages: null
        },

        server_api: {
          'per_page': function() { return this.perPage },
          'page': function() { return this.currentPage },
          'sort': function() {
            if(this.sortField === undefined)
              return 'date';
            return this.sortField;
          }
        },

        parse: function (response) {
          $('#products-area').spin(false);
          this.totalRecords = response.total;
          this.totalPages = Math.ceil(response.total / this.perPage);

          return response.data;
        }

    });

    return App.collection.PaginatedCollection;

}));