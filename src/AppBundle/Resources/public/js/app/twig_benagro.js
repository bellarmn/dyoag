/*
 * This file is part of the Speedwapp package.
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
            'twig'
        ], factory);
    } else {
        // Browser globals:
        factory(window.Twig);
    }
}(function (Twig) {
    Twig.extendFilter('slice', function (value, arguments) {
        return value.substring(arguments[0], arguments[1]);
    });

    Twig.extendFilter('split', function (value, arguments) {
        return value.split(arguments[0]);
    });

    Twig.extendFilter("trans", function (name) {
        return Translator.trans(name);
    });
    
    Twig.extendFilter("raw", function (value) {
        return value;
    });

    Twig.extendFilter('setPropertyValue', function (values, arguments) {
        if (arguments[1] && arguments[1].hasOwnProperty("_keys")) {
            delete arguments[1]._keys;
        }
        var self = this;

        if (arguments[0] === undefined) {
            return values;
        }
        
        var aProperty = arguments[0].split('|');
        if (aProperty.length === 1) {
            aProperty.unshift('cmp');
        }
        self.reference = values;
        final_key = aProperty.length - 1;

        for (var i =0; i<= final_key; i++) {
            part = aProperty[i];
            
            if (final_key != i) { 

                if (undefined === (self.reference[part])) {
                    self.reference[part] = {};
                }

                self.reference = self.reference[part];

            } else {
                self.reference[part] = arguments[1];
            }
            
        }

        return values;
    });

    Twig.extendTest("string", function (value) {
        return ((typeof value === 'string') && isNaN(parseInt(value)));
    });

    Twig.extendTest("iterable", function (value) {
        return ((value !== null) && (typeof value === 'object'));
    });

    return Twig;
}));