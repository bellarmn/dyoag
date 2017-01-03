/*
 * This file is part of the WebApplicationBuilder package.
 *
 * (c) Jacques Adjahoungbo <jtocson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

require(['jquery.ui'], function() {  
    'use strict';

    $(function() {

        /**
         * FloatingSocialButton.
         * 
         * @version 1.0 [17 Mai 2016]
         * @author Jacques ADJAHOUNGBO
         */

            function FloatingSocialButton() {

                this.init();
            }

            FloatingSocialButton.prototype = {

                init: function() {
                    console.log ('FloatingSocialButton');
                    $(".add-buttons .add-icon").mouseenter(function(){
                        $(this).stop();
                        $(this).animate({width: "180"}, 500, "easeOutBounce",function(){});  
                    });
                    $(".add-buttons .add-icon").mouseleave(function(){
                        $(this).stop();
                        $(this).animate({width: "43"}, 500, "easeOutBounce",function(){});
                    });
                }
            }

            new FloatingSocialButton();

    });

});
