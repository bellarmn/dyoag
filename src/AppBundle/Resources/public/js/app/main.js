/*
 * This file is part of the Benagro package.
 *
 * (c) Jacques Adjahoungbo <jtocson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

requirejs.config({
    baseUrl: '/js/app',
    paths: {
        'jquery': '/assets/js/jquery',
        'jquery.ui': '/assets/js/jquery-ui',
        'bootstrap': '/assets/js/bootstrap',
        'underscore': '/assets/js/underscore',
        'backbone': '/assets/js/backbone',
        'gridster': '/assets/js/gridster',
        'image.picker': '/assets/js/image-picker',
        'template_selector_group': 'view/templateselector/TemplateSelectorGroup',
        'backbone.localStorage': '/assets/js/backbone.localStorage',
        'twig': 'vendor/twig',
        'backbone.nested': '/assets/js/backbone-nested',
        'backbone.associations': '/assets/js/backbone-associations',
        'jquery.spin': 'vendor/jquery.spin',
        'spin': 'vendor/spin',
        //dashboard
        'jquery.nicescroll': 'vendor/jquery.nicescroll',
        'canvasjs': 'vendor/canvasjs.min',
        'datatable': '/assets/js/datatable',
        'datapicker': 'vendor/bootstrap-datepicker.min',
        'select2': '/assets/js/select2',
        'jquery.rd.navbar': 'jquery.rd-navbar.min'
    },
    shim: {
        'underscore': {
            exports: '_'
        },
        'backbone': {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        'jquery.ui': {
            deps: ['jquery'],
            exports: '$'
        },
        'bootstrap': {
            deps: ['jquery'],
        },
        'backbone.nested': {
            deps: ['backbone', 'backbone.associations']
        },
        'chosen': {
            deps: ['jquery'],
        },
        'jquery.spin': {
            deps: ['spin'],
        },
        'datatable': {
            deps: ['jquery'],
            export: 'DataTable',
        },
    }
});

require([
    'app',
    'router'

], function (App, Router) {

    /**
     * Entry point of web application builder.
     *
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    var initialize = function () {

        Backbone.history.start();
    };
    initialize();
});