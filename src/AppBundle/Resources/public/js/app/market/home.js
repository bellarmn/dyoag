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
 * Market home page
 *
 * @version 1.0 [15 Novembre 2016]
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

define(
        [
            'jquery',
            'template_selector_group',
            'app',
        ],
        function ($, TemplateSelectorGroup, App) {
            'use strict';

            function Home() {

                this.$templateList = $("#tplContainer div.template-preview");
                this.$tplContainer2 = $('#tplContainer');
                this.templateSelectorGroup = new TemplateSelectorGroup({
                    el: this.$tplContainer2,
                    baseUrl: Routing.generate('get_ventes')
                });

                this.init();
            }

            Home.prototype = {
                init: function () {
                    var $clickedTemplate;
                    var selectedTemplateId;
                    var self = this;

                    this.$tplContainer2.on('change.itempicker', function () {
                        self.$helpInfo.text('Cliquer sur le bouton "Create Project" pour continuer');
                    });

                    // TODO: Remove and add gestion categories
                    $("#selectTpl > div > div.dropdown > ul.dropdown-menu > li > a").click(function (event) {
                        event.preventDefault();
                    });

                    $('body').on('submit', '#create-form', function (event) {
                        var projectName = $(this).find("#speedwapp_frontendbundle_project_name").val();
                        var projectsubDomainName = $(this).find("#speedwapp_frontendbundle_project_subDomainName").val();
                        var selectedTemplateId = self.templateSelectorGroup.getSelectedTemplateId();
                        if (projectName !== "" && projectsubDomainName !== "") {
                            $(this).find('#speedwapp_frontendbundle_project_templateid').val(selectedTemplateId);
                            return true;
                        } else {
                            console.log("project name or subdomain name is null");
                        }
                    });

                    $("#templatefilter_byname").change(function () {
                        $(".loading").show();
                        var name = $(this).find("option:selected").text();
                        var DATA = 'name=' + name;
                        $.ajax({
                            type: "POST",
                            url: "{{ path('project_filter')}}",
                            data: DATA,
                            cache: false,
                            success: function (data) {
                                $('#filter_result').html(data);
                                $(".loading").hide();
                            }
                        });
                        return false;
                    });

                    // Filter Category
                    $("#template_category > li > a").on('click', function (event) {
                        event.preventDefault();
                        $(".loading").show();
                        var category = $(this).data('id');
                        self.templateSelectorGroup.filterByCategory(category);
                    });

                    // sorted
                    $("#template_sorteby > li > a").on('click', function (event) {
                        event.preventDefault();
                        $(".loading").show();
                        var sortedby = $(this).data('id');
                        self.templateSelectorGroup.sortedBy(sortedby);
                    });

                    this.$dashboardBtnAction.on("click", function (e) {

                        var pos_id, form_id_prefix, pos_name, form_name_prefix, reg_name, limonitoring, $form, form_content, resultHtml
                        e.preventDefault();
                        self.$dashboardBtnAction.removeAttr("clicked");
                        $clickedTemplate = $(this);
                        $clickedTemplate.attr("clicked", "true");

                        $clickedTemplate.parents("div.project-container").each(function (index) {
                            var clickedButtonName = clickedButton.attr('name'),
                                    clickedButtonId = clickedButton.attr('id');
                            pos_id = clickedButtonId.lastIndexOf('_'),
                                    form_id_prefix = clickedButtonId.substring(0, pos_id + 1),
                                    pos_name = clickedButtonName.lastIndexOf('['),
                                    form_name_prefix = clickedButtonName.substring(0, pos_name + 1),
                                    reg_name = new RegExp(form_name_prefix.replace(/(\[)/g, '\\[').replace(/(\])/g, '\\]'), "g"),
                                    limonitoring = $(this);
                            $form = $("<form></form>");
                            form_content = limonitoring.formhtml();

                            form_content = form_content.replace(reg_name, form.data('element') + '[');

                            $form.append(form_content);

                            $(".loading").show();

                            $.post(form.data('elementaction'), $form.serialize(), function (results) {
                                $(".loading").hide();

                                resultHtml = results.html;

                                var el = form.data('element'),
                                        html = resultHtml.replace(new RegExp(el + '_', "g"), form_id_prefix).replace(new RegExp(el + '\\[', "g"), form_name_prefix);
                                limonitoring.html(html);
                            }).fail(function () {
                                alert("error");
                            });
                        });

                        return false;

                    });


                    $(".loading").hide();
                }
            }

            new Home();
        });
