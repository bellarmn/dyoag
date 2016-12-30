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
    'template_selector_group',
    'bootstrap',
    'FloatingSocialButton'
],
    function($, TemplateSelectorGroup) {
        'use strict';

        function Market() {
            $('.dropdown-toggle').dropdown();
                        
//            this.$tplContainer2 = $('#tplContainer');
//            this.templateSelectorGroup = new TemplateSelectorGroup({
//                el: this.$tplContainer2,
////                baseUrl: Routing.generate('get_ventes')
//                baseUrl: Routing.generate('get_ventes')
//            });


            
            this.search();  
            this.filter();  
        }
        
        Market.prototype = {

            search: function () {
                $('.search input[type="submit"]').hide();

                $('#search_keywords').keyup(function(key)
                {
                    if(this.value.length >= 3 || this.value == '') {
                        $('#loader').show();
                        $('#offers').load(
                            $(this).parent('form').attr('action'),
                            { query: this.value ? this.value + '*' : this.value },
                            function() {
                                $('#loader').hide();
                            }
                        );
                    }
                });    
            },
            
            filter: function(){
                $("#template_category li a").click(function(){
                    var data = {
                        filter: $(this).data('name')
                    };
                     $('#loader').show();
                     
                $.ajax({
                    type: 'post',
                    url: Routing.generate('vente_filter'),
                    data: data,
                    success: function(data) {
                        $('#offers').html(data);
                        $('#loader').hide();
                    }
                    
                });
                
                });
            }
        }
    
    new Market();
    }
);