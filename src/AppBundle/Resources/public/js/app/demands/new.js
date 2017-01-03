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
 * New product page
 *
 * @version 1.0 [17 Mai 2016]
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

define(
        [
            'jquery',
            'jquery.spin',
            'bootstrap',
            'select2'
        ],
        function ($) {
            'use strict';

            $(function () {

                /**
                 * @module       Select2
                 * @description  Select2
                 */
                $('select').select2({
                    theme: "bootstrap"
                });

                $("#appbundle_demand_product").change(function () {
                    var data = {
                        product_id: $(this).val()
                    };
                    $('form').spin();
                    $.ajax({
                        type: 'post',
                        url: Routing.generate('vente_select_measures'),
                        data: data
                    }).done(function (data) {
                        var $measures_selector = $('#appbundle_demand_measure'),
                                $product_mage_selector = $('#product_image'),
                                measures = data[0].measures;
                        $product_mage_selector.html('<img alt="" class="img-circle" src="/uploads/images/products/' + data[0].imageName + '">');
                        $measures_selector.html('<option>Unités de mesures</option>');
                        for (var i = 0, total = measures.length; i < total; i++) {
                            console.log(measures[i].id);
                            $measures_selector.append('<option value="' + measures[i].id + '">' + measures[i].name + '</option>');
                        }

                    }).fail(function () {
                        alert("error");
                    }).always(function () {
                        $('form').find('.spinner').hide()
                    });
                });
            });
        }
);

