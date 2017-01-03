define([
    'jquery',
    'underscore',
    'app'
], function ($, _, App) {

    /**
     * A PRODUCT selector.
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.ItemView = App.View.extend({
        tagName: 'div',
        className: 'col-sm-4 col-lg-4 col-md-4',
        template: _.template($('#ProductItemTemplate').html()),

        initialize: function() {
          this.model.bind('change', this.render, this);
          this.model.bind('remove', this.remove, this);
        },

        render : function () {
          this.$el.html(this.template(this.model.toJSON()));
          return this;
        }
    });

    return App.view.ItemView;
});