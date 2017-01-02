define([
    'jquery',
    'underscore',
    'app',
    'itemView',
    'jquery.spin',
    
], function ($, _, App, ItemView) {

    /**
     * A PRODUCT selector.
     * 
     * @author Jacques Adjahoungbo <jtocson@gmail.com>
     */
    App.view.AppView = App.View.extend({
        el : '#paginated-content',

        initialize : function () {
//          new Spinner().spin('#products-area') ; 
          $('#products-area').spin();

          var tags = this.collection;

          tags.on('add', this.addOne, this);
          tags.on('all', this.render, this);
          
          console.log(tags);
          tags.pager();

        },

//        addOne : function ( item ) {
//          var view = new ItemView({model: item});
//          $('#paginated-content').append(view.render().el);
//        },
        
        render: function(){
            this.collection.groupBy(function(list, iterator) {
                return Math.floor(iterator / 3); // 4 == number of columns
            });
//            $('#paginated-content').append(this.el);
//          $('#paginated-content').append(view.render().el);
            console.log(this.collection);
          return this;
        }
    });   
    return App.view.AppView;

});