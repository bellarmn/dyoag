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
            'app'
        ], factory);
    } else {
        // Browser globals:
        factory(window.App);
    }
}(function (App) {
    'use strict';

    /**
     * Model Button.
     *
     * @author Akambi Fagbohoun <contact@akambi-fagbohoun.com>
     */
    App.model.TemplateSelector = App.Model.extend({
        defaults: {
            id: null,
            lieu: null,
            image: null,
            product: null,
            prix: null,
            measure: null,
            url: null,
            stock: null
        }
    });
    return App.model.TemplateSelector;
}));