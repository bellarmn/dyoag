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
 * @version 1.0 [11 Octobre 2016]
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

define(
        [
            'jquery',
            'bootstrap',
            'FloatingSocialButton',
            'jquery.spin',
        ],
        function ($, FloatingSocialButton) {
            'use strict';
            console.log('OK');
            // $('#dataTables-example').DataTable();

            /**
             * @module       Tabs
             * @description  Bootstrap tabs
             */
            function Mesoffres() {
                
                var self = this;
              
                this.$spinElenment = $('.panel-horizontal form');
                
                $("#myTabs li>a").each(function () {
                    if (this.href === window.location.href) {
                        $(this).parent().addClass("active");

                    }
                });
                
                this.loadListPubliees();//initialisation de la liste
                
                $('#myTabs li>#dashboard_mesoffresPublies').click(function (e) {
                    e.preventDefault();
                    self.loadListPubliees();
                    $(this).tab('show');
                });
                $('#myTabs li>#dashboard_mesoffresBrouillons').click(function (e) {
                    e.preventDefault();
                    self.loadListBrouillons();
                    $(this).tab('show');
                });
                $('#myTabs li>#dashboard_mesoffresExpires').click(function (e) {
                    e.preventDefault();
                    self.loadListExpirees();
                    $(this).tab('show');
                });
                $('#myTabs li>#dashboard_mesoffresResolus').click(function (e) {
                    e.preventDefault();
                    self.loadListResolues();
                    $(this).tab('show');
                });
                $('#myTabs li>#dashboard_mesoffresCorbeille').click(function (e) {
                    e.preventDefault();
                    self.loadListCorbeilles();
                    $(this).tab('show');
                });
                
                  
            }

             Mesoffres.prototype = {
                loadListPubliees: function () {
                    var self = this;
                    self.$spinElenment.spin();
                    $('.startSynchorne').removeClass('hide');
                    $.ajax({
                        type: 'get',
                        url: Routing.generate('dashboard_mesoffresPublies'),
                        data: null
                    }).done(function (response) {
                        //$("#publieesOffre").hide();
                        $("#brouillonsOffre").hide();
                        $("#expireesOffre").hide();
                        $("#resoluesOffre").hide();
                        $("#corbeillesOffre").hide();
                        
                        $("#publieesOffre").show();
                        $("#publieesOffre").html(response);
                          $('.startSynchorne').addClass('hide');
                    }).fail(function () {
                        alert("error");
                    }).always(function () {
                       self.$spinElenment.find('.spinner').hide();
                     
                      console.log('OK');
                    });
                    
                },
                loadListBrouillons: function () {
                    var self = this;
                    self.$spinElenment.spin();
                     $('.startSynchorne').removeClass('hide');
                    $.ajax({
                        type: 'get',
                        url: Routing.generate('dashboard_mesoffresBrouillons'),
                        data: null
                    }).done(function (response) {
                        $("#publieesOffre").hide();
                        //$("#brouillonsOffre").hide();
                        $("#expireesOffre").hide();
                        $("#resoluesOffre").hide();
                        $("#corbeillesOffre").hide();
                        
                        $("#brouillonsOffre").show();
                        $("#brouillonsOffre").html(response);
                          $('.startSynchorne').addClass('hide');
                          
                    }).fail(function () {
                        alert("error");
                    }).always(function () {
                        self.$spinElenment.find('.spinner').hide();
                      console.log('OK');
                    });
                    
                },
                loadListExpirees: function () {
                    var self = this;
                    self.$spinElenment.spin();
                     $('.startSynchorne').removeClass('hide');
                    $.ajax({
                        type: 'get',
                        url: Routing.generate('dashboard_mesoffresExpires'),
                        data: null
                    }).done(function (response) {
                        $("#publieesOffre").hide();
                        $("#brouillonsOffre").hide();
                       // $("#expireesOffre").hide();
                        $("#resoluesOffre").hide();
                        $("#corbeillesOffre").hide();
                        
                        $("#expireesOffre").show();
                        $("#expireesOffre").html(response);
                          $('.startSynchorne').addClass('hide');
                        
                    }).fail(function () {
                        alert("error");
                    }).always(function () {
                        self.$spinElenment.find('.spinner').hide();
                      console.log('OK');
                    });
                    
                },
                loadListResolues: function () {
                    var self = this;
                    self.$spinElenment.spin();
                     $('.startSynchorne').removeClass('hide');
                    $.ajax({
                        type: 'get',
                        url: Routing.generate('dashboard_mesoffresResolus'),
                        data: null
                    }).done(function (response) {
                        $("#publieesOffre").hide();
                        $("#brouillonsOffre").hide();
                       $("#expireesOffre").hide();
                       // $("#resoluesOffre").hide();
                        $("#corbeillesOffre").hide();
                        
                        $("#resoluesOffre").show();
                        $("#resoluesOffre").html(response);
                          $('.startSynchorne').addClass('hide');
                        
                    }).fail(function () {
                        alert("error");
                    }).always(function () {
                        self.$spinElenment.find('.spinner').hide();
                      console.log('OK');
                    });
                    
                },
                loadListCorbeilles: function () {
                    var self = this;
                    self.$spinElenment.spin();
                     $('.startSynchorne').removeClass('hide');
                    $.ajax({
                        type: 'get',
                        url: Routing.generate('dashboard_mesoffresCorbeille'),
                        data: null
                    }).done(function (response) {
                        $("#publieesOffre").hide();
                        $("#brouillonsOffre").hide();
                       $("#expireesOffre").hide();
                        $("#resoluesOffre").hide();
                       // $("#corbeillesOffre").hide();
                        
                        $("#corbeillesOffre").show();
                        $("#corbeillesOffre").html(response);
                          $('.startSynchorne').addClass('hide');
                        
                    }).fail(function () {
                        alert("error");
                    }).always(function () {
                        self.$spinElenment.find('.spinner').hide();
                      console.log('OK');
                    });
                    
                }
               
            }

            new Mesoffres();

        }
);

