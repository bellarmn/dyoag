define([
    'jquery',
    'underscore',
    'app',
    'jquery.spin',
], function ($, _, App) {

    /**
     * A PRODUCT selector.
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.SortedView = App.View.extend({

        events: {
          'click #sortByField a': 'updateSortBy'
        },

        template: _.template($('#sortingTemplate').html()),

        initialize: function () {
          this.collection.on('reset', this.render, this);
          this.collection.on('sync', this.render, this);
          this.$el.appendTo('#sorting');
        },

        render: function () {
          var html = this.template(this.collection.info());
          this.$el.html(html);

          if (this.collection.sortField == undefined){
            var sortText = this.$el.find('#sortByText').text();
          }else{
            var sortText = this.collection.sortField;
          }
          console.log(sortText);
          $('#sortByText').text(sortText);
        },

        updateSortBy: function (e) {
          e.preventDefault();
          var currentSort = $(e.target).attr('href');
          this.collection.updateOrder(currentSort);
          $('#products-area').spin();
        }

    });   
    return App.view.SortedView;

});