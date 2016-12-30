/**
 * Définition collection des components
 * @type @exp;Backbone@pro;Collection@call;extend
 */
define([
    'app',
    'underscore',
    'backbone',
    'backbone.localStorage',
], function(ApplicationBuilder, _, Backbone) {

    ApplicationBuilder.collection.Default = Backbone.Collection.extend({
        initialize: function(collection, options) {
            this.name = options.name;
            this.model = options.model;
            if (typeof this.model === 'undefined') {
                throw 'Collection doesn\'t have model. you must define a model if you want to use it'
            }
        },
        constructor: function(collection, options) {
            Backbone.Collection.prototype.constructor.apply(this, arguments);
        }
    });
    return ApplicationBuilder.collection.Default;
});