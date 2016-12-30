define([
    'jquery',
    'underscore',
    'backbone',
    'twig_benagro',
    'app'
], function ($, _, Backbone, Twig) {

    /**
     * A PRODUCT selector.
     *
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.TemplateSelector = App.View.extend({
        tagName: 'div',
        className: 'col-xs-6 col-md-3',
        constructor: function (options) {
            App.View.prototype.constructor.call(this, options);
        },
        initialize: function (config) {
            var templateId = 'template-selector';
            this.container = config.container;

            this.template = Twig.twig({ref: templateId});
            if (this.template === null) {
                this.template = Twig.twig({
                    id: templateId,
                    data: '<div class="product tumbnail thumbnail-3" data-row={{ datarow }} data-col={{ datacol }}>\
                                <a href="{{ url }}">\
                                    <img alt="" src="{{ image }}">\
                                </a>\
                                <div class="caption">\
                                    <h6>\
                                        <a href="{{ url }}">{{ product }}</a>\
                                    </h6>\
                                    <span class="price sale">{{ prix }} FCFA / {{ measure }}</span><br>\
                                    <span class="stock">{{ stock }} {{ measure }}s en stock.</span>\
                                </div>\
                            </div>'
                });
            }

            //  Exécuter la methode render à  chaque évènement sur l'objet
            _.bindAll(this, 'render');
            //  on exécute la fonction render à  chaque fois qu'on a un changement sur le model
            this.model.on('change', this.render, this);
        },
        render: function () {
            this.$el.data('type', this.model.get('product'));
            this.$el.data('img-label', this.model.get('product'));
            this.$el.data('img-src', this.model.get('image'));
            this.$el.data('datarow', this.model.get('datarow'));
            this.$el.data('datacol', this.model.get('datacol'));

            var renderedContent = this.template.render(this.model.toJSON()).trim();
            this.$el.html(renderedContent);
            return this;
        },
        hide: function () {
            this.$el.addClass('hide');
        },
        events: {
            'click .offer_container': 'onClick'
        },
        onClick: function (e) {
            e.preventDefault();
            this.container.selectItem(this, this.$el);
        }
    });

    return App.view.TemplateSelector;
});
