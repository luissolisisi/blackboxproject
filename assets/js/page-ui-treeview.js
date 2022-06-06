var App = (function () {

  App.treeView = function( ){
    'use strict'

    $('span.tree-toggler').click(function () {
      var icon = $(this).children(".fas");
        if(icon.hasClass("fa-plus")){
          icon.removeClass("fa-plus").addClass("fa-minus");
        }else{
          icon.removeClass("fa-minus").addClass("fa-plus");
        }        
        
      $(this).parent().children('ul.tree').toggle(300,function(){
        $(this).parent().toggleClass("open");
        $(".tree .nscroller").nanoScroller({ preventPageScrolling: true });
      });
    });
    
  };

  return App;
})(App || {});
