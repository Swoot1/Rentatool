/**
 * Created by elinnilsson on 21/08/14.
 */
angular.module('Rentatool').filter('timeunitmapper', ['TimeUnit', function(TimeUnit) {
   var timeUnitCollection = TimeUnit.query();

   return function(input) {
      var value = input;

      timeUnitCollection.forEach(function(timeUnit){
         if(input === timeUnit.id){
            value = timeUnit.name;
         }
      });

      return value;
   };
}]);