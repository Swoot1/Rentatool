/**
 * Created by elinnilsson on 02/01/15.
 */
(function () {
   angular.module('Rentatool').
      filter('asDate', function(){
         return function(input){
            return new Date(input);
         }
      });
})();
