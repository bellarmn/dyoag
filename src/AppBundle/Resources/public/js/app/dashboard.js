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
      
        'jquery.ui': '/assets/js/jquery-ui',
         'bootstrap.dashboard': '/assets/js/bootstrap',
   
        'chosen': '/assets/js/chosen',
        //dashboard
        'jquery-1.10.2': '/assets/js/jquery-1.10.2',
        'amcharts': '/assets/js/amcharts',
        'serial': '/assets/js/serial',
        'light': '/assets/js/light',
        'radar': '/assets/js/radar',
        'css3clock': '/assets/js/css3clock',
        'skycons': '/assets/js/skycons',
        'jquery.easydropdown': '/assets/js/jquery.easydropdown',
        'CSSPlugin': '/assets/js/CSSPlugin',
        'vroom': '/assets/js/vroom',
        'TweenLite': '/assets/js/TweenLite',
        'jquery.nicescroll': '/assets/js/jquery.nicescroll',
        'scripts': '/assets/js/scripts'
    },
    
    shim: {
      
        'jquery.ui': {
            deps:    ['jquery'],
            exports: '$'
        },
        'bootstrap': {
            deps:    ['jquery'],
        },
       
          'chosen': {
            deps:    ['jquery'],
        }
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


        var deepDiffMapper = function () {
            return {
                VALUE_CREATED: 'created',
                VALUE_UPDATED: 'updated',
                VALUE_DELETED: 'deleted',
                VALUE_UNCHANGED: 'unchanged',
                map: function (obj1, obj2) {
                    var diff;
                    if (this.isFunction(obj1) || this.isFunction(obj2)) {
                        throw 'Invalid argument. Function given, object expected.';
                    }
                    if (this.isValue(obj1) || this.isValue(obj2)) {
                        var type = this.compareValues(obj1, obj2);
                        return {type: type, data: obj1 || obj2};
                    }

                    var result = {};
                    for (var key in obj1) {
                        if (this.isFunction(obj1[key])) {
                            continue;
                        }

                        var value2 = undefined;
                        if ('undefined' != typeof (obj2[key])) {
                            value2 = obj2[key];
                        }

                        diff = this.map(obj1[key], value2);
                        console.log(diff);
                        if ((typeof diff.type !== 'undefined') && (diff.type === this.VALUE_UNCHANGED)) {
                            console.log(key);
                            continue;
                        }
                        console.log(key);
                        result[key] = diff.data;
                    }
                    var type = this.VALUE_UPDATED;
                    if (!this.size(result)) {
                        type = this.VALUE_UNCHANGED;
                    }
                    return {type: type, data: result};

                    for (var key in obj2) {
                        if (this.isFunction(obj2[key]) || ('undefined' !== typeof (result[key]))) {
                            continue;
                        }
                        if ('undefined' !== typeof (obj1[key])) {
                            continue;
                        }

                        diff = this.map(undefined, obj2[key]);
                        if (diff.type !== this.VALUE_UNCHANGED) {
                            result[key] = diff.data;
                        }
                    }
                    return {data: result};
                },
                size: function (obj) {
                    var size = 0, key;
                    for (key in obj) {
                        if (obj.hasOwnProperty(key))
                            size++;
                    }
                    return size;
                },
                compareValues: function (value1, value2) {
                    if (value1 === value2) {
                        return this.VALUE_UNCHANGED;
                    }
                    if ('undefined' == typeof (value1)) {
                        return this.VALUE_CREATED;
                    }
                    if ('undefined' == typeof (value2)) {
                        return this.VALUE_DELETED;
                    }

                    return this.VALUE_UPDATED;
                },
                isFunction: function (obj) {
                    return toString.apply(obj) === '[object Function]';
                },
                isArray: function (obj) {
                    return toString.apply(obj) === '[object Array]';
                },
                isObject: function (obj) {
                    return toString.apply(obj) === '[object Object]';
                },
                isValue: function (obj) {
                    return !this.isObject(obj) && !this.isArray(obj);
                }
            }
        }();


//        var result = deepDiffMapper.map({
//            a: 'i am unchanged',
//            b: 'i am deleted',
//            e: {a: 1, b: false, c: null},
//            f: [1, {a: 'same', b: [{a: 'same'}, {d: 'delete'}]}]
//        },
//        {
//            a: 'i am unchanged',
//            c: 'i am created',
//            e: {a: '1', b: '', d: 'created'},
//            f: [{a: 'same', b: [{a: 'same'}, {c: 'create'}]}, 1]
//
//        });
//        console.log(result);

        Backbone.history.start();
    };
    initialize();
});