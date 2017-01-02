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
 * show product page
 *
 * @version 1.0 [7 Octobre 2016]
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

define(
        [
            'jquery',
            'bootstrap'
        ],
        function ($) {
            'use strict';
            $(function () {

                /**
                 * @module       Tabs
                 * @description  Bootstrap tabs
                 */

                $('#myTabs a').click(function (e) {
                    e.preventDefault()
                    $(this).tab('show')
                })

                $('#myTabs2 a').click(function (e) {
                    e.preventDefault()
                    $(this).tab('show')
                });

                /**
                 * @module       carousel
                 * @description  Bootstrap carousel
                 */
                $('#itemslider').carousel({interval: 3000});

                $('.carousel-showmanymoveone .item').each(function () {
                    var itemToClone = $(this);

                    for (var i = 1; i < 6; i++) {
                        itemToClone = itemToClone.next();

                        if (!itemToClone.length) {
                            itemToClone = $(this).siblings(':first');
                        }

                        itemToClone.children(':first-child').clone()
                                .addClass("cloneditem-" + (i))
                                .appendTo($(this));
                    }
                });

                /**
                 * @module       show user contact
                 * @description  show user contact
                 */

                $('body').on('click', '#show_contact', function (e) {
                    e.preventDefault;
                    $('#contact-dialog').modal();
                });
            });
        }
);