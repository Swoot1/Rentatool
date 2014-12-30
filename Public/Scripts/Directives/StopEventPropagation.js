/**
 * Created by elinnilsson on 30/12/14.
 */
(function () {
   angular.module('Rentatool').directive('stopeventpropagation', [function(){
      return {
         restrict: 'A',
         link: function(scope, element){
            element.bind('click', function(e){
               e.stopPropagation();
            });
         }
      };
   }]);
})()