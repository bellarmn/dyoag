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
            function Mesdemandes() {
                
                var self = this;
              
                this.$spinElenment = $('.panel-horizontal form');
                
                $("#myTabs li>a").each(function () {
                    if (this.href === window.location.href) {
                        $(this).parent().addClass("active");

                    }
                });
                
                this.loadListPubliees();//initialisation de la liste
                
                $('#myTabs li>#dashboard_mesdemandesPublies').click(function (e) {
                    e.preventDefault();
                    self.loadListPubliees();
                    $(this).tab('show');
                });
                $('#myTabs li>#dashboard_mesdemandesBrouillons').click(function (e) {
                    e.preventDefault();
                    self.loadListBrouillons();
                    $(this).tab('show');
                });
                $('#myTabs li>#dashboard_mesdemandesExpires').click(function (e) {
                    e.preventDefault();
                    self.loadListExpirees();
                    $(this).tab('show');
                });
                $('#myTabs li>#dashboard_mesdemandesResolus').click(function (e) {
                    e.preventDefault();
                    self.loadListResolues();
                    $(this).tab('show');
                });
                $('#myTabs li>#dashboard_mesdemandesCorbeille').click(function (e) {
                    e.preventDefault();
                    self.loadListCorbeilles();
                    $(this).tab('show');
                });
                
                  
            }

             Mesdemandes.prototype = {
                loadListPubliees: function () {
                    var self = this;
                    self.$spinElenment.spin();
                    $('.startSynchorne').removeClass('hide');
                    $.ajax({
                        type: 'get',
                        url: Routing.generate('dashboard_mesdemandesPublies'),
                        data: null
                    }).done(function (response) {
                        //$("#publieesDemande").hide();
                        $("#brouillonsDemande").hide();
                        $("#expireesDemande").hide();
                        $("#resoluesDemande").hide();
                        $("#corbeillesDemande").hide();
                        
                        $("#publieesDemande").show();
                        $("#publieesDemande").html(response);
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
                        url: Routing.generate('dashboard_mesdemandesBrouillons'),
                        data: null
                    }).done(function (response) {
                        $("#publieesDemande").hide();
                        //$("#brouillonsDemande").hide();
                        $("#expireesDemande").hide();
                        $("#resoluesDemande").hide();
                        $("#corbeillesDemande").hide();
                        
                        $("#brouillonsDemande").show();
                        $("#brouillonsDemande").html(response);
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
                        url: Routing.generate('dashboard_mesdemandesExpires'),
                        data: null
                    }).done(function (response) {
                        $("#publieesDemande").hide();
                        $("#brouillonsDemande").hide();
                       // $("#expireesDemande").hide();
                        $("#resoluesDemande").hide();
                        $("#corbeillesDemande").hide();
                        
                        $("#expireesDemande").show();
                        $("#expireesDemande").html(response);
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
                        url: Routing.generate('dashboard_mesdemandesResolus'),
                        data: null
                    }).done(function (response) {
                        $("#publieesDemande").hide();
                        $("#brouillonsDemande").hide();
                       $("#expireesDemande").hide();
                       // $("#resoluesDemande").hide();
                        $("#corbeillesDemande").hide();
                        
                        $("#resoluesDemande").show();
                        $("#resoluesDemande").html(response);
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
                        url: Routing.generate('dashboard_mesdemandesCorbeille'),
                        data: null
                    }).done(function (response) {
                        $("#publieesDemande").hide();
                        $("#brouillonsDemande").hide();
                       $("#expireesDemande").hide();
                        $("#resoluesDemande").hide();
                       // $("#corbeillesDemande").hide();
                        
                        $("#corbeillesDemande").show();
                        $("#corbeillesDemande").html(response);
                          $('.startSynchorne').addClass('hide');
                        
                    }).fail(function () {
                        alert("error");
                    }).always(function () {
                        self.$spinElenment.find('.spinner').hide();
                      console.log('OK');
                    });
                    
                }
               
            }

            new Mesdemandes();

        }
);

