/*
 * This file is part of the Benagro package.
 *
 * (c) Jacques Adjahoungbo <jtocson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

/**
 * Home page
 *
 * @version 1.0 [17 Mai 2016]
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

define(
    [
    'jquery',
    'FloatingSocialButton',
    'app',
],
    function($, FloatingSocialButton, App) {
        'use strict';

        $(function() {
            this.templateSelectorGroup = new TemplateSelectorGroup({
                el: this.$tplContainer2,
                baseUrl: Routing.generate('get_publicprojects')
            });
        });
    }
);