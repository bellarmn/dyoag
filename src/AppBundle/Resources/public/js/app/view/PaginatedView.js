define([
    'jquery',
    'underscore',
    'app',
    'jquery.spin'
], function ($, _, App) {

    /**
     * A PRODUCT selector.
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.PaginatedView = App.View.extend({
  events: {
    'click button.prev': 'gotoPrev',
    'click button.next': 'gotoNext',
    'click a.page': 'gotoPage'
  },

  template: _.template($('#paginationTemplate').html()),

  initialize: function () {
    this.collection.on('reset', this.render, this);
    this.collection.on('sync', this.render, this);
    this.$el.appendTo('#pagination');
  },

  render: function () {
    var html = this.template(this.collection.info());
    this.$el.html(html);
  },

  gotoPrev: function (e) {
    e.preventDefault();
    $('#products-area').spin();
    this.collection.requestPreviousPage();
  },

  gotoNext: function (e) {
    e.preventDefault();
    $('#products-area').spin();
    this.collection.requestNextPage();
  },

  gotoPage: function (e) {
    e.preventDefault();
    $('#products-area').spin();
    var page = $(e.target).text();
    this.collection.goTo(page);
  }

    });   
    return App.view.PaginatedView;

});