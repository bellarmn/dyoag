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
            'backbone.associations',
            'backbone.nested'
        ], factory);
    } else {
        // Browser globals:
        factory(window.jQuery, window._, window.Backbone);
    }
}(function($, _, Backbone) {
    'use strict';
    
    if(!Array.isArray) {
      Array.isArray = function(arg) {
        return Object.prototype.toString.call(arg) === '[object Array]';
      };
    }
    
    console.log('app loaded');

    /**
     * Upload application class and model.
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    
    App = window.App = {};

    App.VERSION = '0.1';
    App.model = {};
    App.view = {};


    var _models = {};
    var _collections = {};
    var _associations = {};

    App.collection = {};

    App.Associable = {};
    App.Associable.VERSION = '0.1.2';

    App.Associable.Associations = {};
    App.collection = {};
//    App.View = Backbone.View.extend({});
//    App.Model = Backbone.Model.extend({});

    /**
     * App.Associable.Associations.BelongsToAssociation
     *
     * @beta
     * @since beta
     */
    App.Associable.Associations.BelongsToAssociation = function(modelName, targetName, collectionName, foreignKey, condition) {
        return {
            associationType: "belongsTo",
            modelName: modelName,
            targetName: targetName,
            collectionName: collectionName,
            foreignKey: foreignKey,
            condition: condition,
            findTarget: function(modelElement) {
                return App.Associable.collections[collectionName].get(modelElement.get('properties')[foreignKey])
            },
            toString: function() {
                return "BelongsToAssociation: " + modelName + " belongs to " + targetName + " (" + collectionName + ") via " + foreignKey + ".";
            }
        }
    };


    /**
     * App.Associable.Associations.DelegatesToAssociation
     *
     * @beta
     * @since beta
     */
    App.Associable.Associations.DelegatesToAssociation = function(modelName, targetName, associationName, foreignName) {
        return {
            associationType: "delegatesTo",
            modelName: modelName,
            targetName: targetName,
            associationName: associationName,
            foreignName: foreignName,
            findTarget: function(modelElement) {
                return modelElement.get(associationName).get(foreignName);
            },
            toString: function() {
                return "DelegatesToAssociation: " + modelName + " delegates " + targetName + " to " + associationName + "." + foreignName;
            }
        }
    };

    /**
     * App.View
     *
     * @beta
     * @since beta
     */
    App.View = Backbone.View.extend({
        name: null,
        initialize: function() {
            
        },
        destroy: function () {
            // COMPLETELY UNBIND THE VIEW
            this.undelegateEvents();

            this.$el.removeData().unbind(); 
    
            this.remove();
            Backbone.View.prototype.remove.call(this);
        },
        close: function () {
            this.destroy();
        },
        getEl: function() {
            return this.$el;
        },
        getDomEl: function() {
            return this.el;
        },
        detach: function() {
            this.$el.detach();
            return this;
        },
        hide: function () {
            this.$el.addClass('hide');
            return this;
        },
        show: function () {
            this.$el.removeClass('hide');
            return this;
        },
        focus: function () {
            this.$el.focus();
            return this;
        },
        deleteDefinitively: function() {
            this.undelegateEvents();
            this.$el.removeData().unbind();
            //Remove view from DOM
            this.remove();
            Backbone.View.prototype.remove.call(this);
            delete this;
        }
    });


    /**
     * App.Model
     *
     * @beta
     * @since beta
     */
    App.Model = Backbone.NestedModel.extend({
        name: null,
        get: function(attribute) {
            var association = _associations[this.modelName];
            var finder;

            if (association) {
                finder = association[attribute];
            }

            if (finder) {
                return finder.findTarget(this);
            } else {
                return Backbone.NestedModel.prototype.get.call(this, attribute);
            }
        },
        reset: function (options) {
            this.clear(options);
            this.set(this.defaults);
        },
        initialize: function() {
            if (this.belongsTo) {
                foreignKey = this.foreignKey ? this.foreignKey : this.modelName + '-id';
                App.Model.belongsTo(this.modelName, this.belongsTo, this.belongsTo + 's', foreignKey);
            }
        }
    });


    /**
     * App.RecordableModel
     *
     * @beta
     * @since beta
     */
    App.RecordableModel = Backbone.NestedModel.extend({
        hasChangedSinceLastSync: false,
        initialize: function () {
            this.on('change', this.modelChanged);
        },
        modelChanged: function () {
            this.markDirty();
        },
        reset: function (options) {
            this.clear(options);
            this.set(this.defaults);
        },
        isDirty: function () {
            return this.hasChangedSinceLastSync;
        },
        markDirty: function () {
            this.hasChangedSinceLastSync = true;
        },
        markClean: function () {
            this.hasChangedSinceLastSync = false;
        }
    });
                

    App.Model.belongsTo = function(modelName, targetName, collectionName, foreignKey) {
        App.registerAssociation(new App.Associable.Associations.BelongsToAssociation(modelName, targetName, collectionName, foreignKey));
    };

    App.Model.delegatesTo = function(modelName, targetName, associationName, foreignName) {
        App.registerAssociation(new App.Associable.Associations.DelegatesToAssociation(modelName, targetName, associationName, foreignName));
    };



    /**
     * App.Collection
     * Amélioration des Collections dans Backbone
     *
     * @beta
     * @since 0.2b
     */
    App.Collection = Backbone.Collection.extend({
        query: function(query, options) {
            var models;
            if (options == null) {
                options = {};
            }
            if (options.cache) {
                models = getCache(this, query, options);
            } else {
                models = getSortedModels(this, query, options);
            }
            if (options.limit) {
                models = pageModels(models, options);
            }
            return models;
        },
        one: function(query) {
            return this.query(query)[0];
        },
        where: function(params, options) {
            if (options == null) {
                options = {};
            }
            return new this.constructor(this.query(params, options));
        },
        uncache: function() {
            return this._queryCache = {};
        }
    });
    return App;    
}));
