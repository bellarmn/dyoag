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
            'canvasjs'
        ],
        function ($) {
            'use strict';
            console.log('OK');
            // $('#dataTables-example').DataTable();

            /**
             * @module       Tabs
             * @description  Bootstrap tabs
             */

//            $('#myTabs a').click(function (e) {
//                e.preventDefault()
//                $(this).tab('show')
//            });
 
            $.ajax({
                type: 'get',
                url: Routing.generate('dashboard_graphmarket'),
            }).done(function (response) {
                console.log(parseInt(response.countsupplies));
                var dataOffres = new Array();
                dataOffres.push({y: parseInt(response.CountPulibesV), label: "Publiées"});
                dataOffres.push({y: parseInt(response.CountResolusV), label: "Résolues"});
                dataOffres.push({y: parseInt(response.CountBrouillonsV), label: "Brouillons"});
                dataOffres.push({y: parseInt(response.CountExpiresV), label: "Expirées"});
                dataOffres.push({y: parseInt(response.CountCorbeilleV), label: "Corbeilles"});
                
                var dataDemands = new Array();
                dataDemands.push({y: parseInt(response.CountPulibesD), label: "Publiées"});
                dataDemands.push({y: parseInt(response.CountResolusD), label: "Résolues"});
                dataDemands.push({y: parseInt(response.CountBrouillonsD), label: "Brouillons"});
                dataDemands.push({y: parseInt(response.CountExpiresD), label: "Expirées"});
                dataDemands.push({y: parseInt(response.CountCorbeilleD), label: "Corbeilles"});
                
                var dataCAMarket = new Array();
                dataCAMarket.push({y: parseInt(response.caventes), indexLabel: "CA des Offres Résolues"});
                dataCAMarket.push({y: parseInt(response.casupplies), indexLabel: "CA des Souscriptions Résolues"});
                
                var dataAchatMarket = new Array();
                dataAchatMarket.push({y: parseInt(response.cademands), indexLabel: "Montant des Demandes Résolues"});
                dataAchatMarket.push({y: parseInt(response.caorders), indexLabel: "Montant des Commandes Résolues"});
                
                var datapointMarket = new Array();
                datapointMarket.push({y: parseInt(response.countventes), indexLabel: "Offres"});
                datapointMarket.push({y: parseInt(response.countdemands), indexLabel: "Demandes"});
                datapointMarket.push({y: parseInt(response.countsupplies), indexLabel: "Souscriptions"});
                datapointMarket.push({y: parseInt(response.countorders), indexLabel: "Commandes"});
                
                var dataAchatCAMarket = new Array();
                dataAchatCAMarket.push({y: parseInt(response.caventes)+parseInt(response.casupplies), indexLabel: "Chiffre d'affaire réalisé"});
                dataAchatCAMarket.push({y: parseInt(response.cademands)+parseInt(response.caorders), indexLabel: "Achat effectuée"});
                
                //graph market
                var marketgraph = new CanvasJS.Chart("graphlemarche",
                        {
                            theme: "theme1",
                
                            title: {
                                text: "Le Marché"
                            },
                            data: [
                                {
                                    type: "pie",
                                    showInLegend: true,
                                    legendText: "{indexLabel}",
                                    dataPoints: datapointMarket
                                }
                            ]

                        });
                
                // graphe chiffre d'affaire
                var chiffreaffaire = new CanvasJS.Chart("graphchiffreaffaire",
                    {
                        theme: "theme2",
                        title: {
                            text: "Chiffre d'affaire"
                        },
                        data: [
                            {
                                type: "pie",
                                showInLegend: true,
                                legendText: "{indexLabel}",
                                dataPoints: dataCAMarket
                            }
                        ]
                    });
               
                // graphe achats sur le marché
                var achatmarket = new CanvasJS.Chart("graphachatmarket",
                    {
                        theme: "theme2",
                        title: {
                            text: "Achats"
                        },
                        data: [
                            {
                                type: "pie",
                                showInLegend: true,
                                legendText: "{indexLabel}",
                                dataPoints: dataAchatMarket
                            }
                        ]
                    });
                // graphe achats sur le marché
                var achatchiffreaffairemarket = new CanvasJS.Chart("graphchiffreachat",
                    {
                        theme: "theme2",
                        title: {
                            text: "Chiffre d'affaire & Achat"
                        },
                        data: [
                            {
                                type: "pie",
                                showInLegend: true,
                                legendText: "{indexLabel}",
                                dataPoints: dataAchatCAMarket
                            }
                        ]
                    });
               //GRAPH POUR OFFRES
               var productsoffresgraph = new CanvasJS.Chart("productsoffresgraph",
                    {
                        theme: "theme2",
                        title: {
                            text: "Offres"
                        },
                        data: [
                            {
                                type: "column",
                                showInLegend: false,
                                legendText: "{label}",
                                dataPoints: dataOffres
                            }
                        ]
                    });
              //GRAPH POUR DEMANDES
               var productsdemandgraph = new CanvasJS.Chart("productsdemandgraph",
                    {
                        theme: "theme2",
                        title: {
                            text: "Demandes"
                        },
                        data: [
                            {
                                type: "column",
                                showInLegend: false,
                                legendText: "{label}",
                                dataPoints: dataDemands
                            }
                        ]
                    });
                    
            chiffreaffaire.render();
            marketgraph.render();
            achatchiffreaffairemarket.render();
            achatmarket.render();
            productsoffresgraph.render();
            productsdemandgraph.render();
            
            }).fail(function () {
                alert("error");
            }).always(function () {
                //console.log(response);
            });

            //pour l'affichage de la liste des offres
            
             $('#dashboard_mesoffresPublies').click(function (e) {
                    e.preventDefault();
                     $.ajax({
                        type: 'get',
                        url: Routing.generate('dashboard_mesoffresPublies'),
                        data: null
                    }).done(function (response) {

                        $("#affichageContenuajax").html(response);
                       
                    }).fail(function () {
                        alert("error");
                    }).always(function () {
                       // self.$spinElenment.find('.spinner').hide();
                       console.log('OK');
                    });
                    
                });

        }
);

