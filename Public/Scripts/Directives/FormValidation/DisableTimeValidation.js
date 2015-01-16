/**
 * Created by elinnilsson on 16/01/15.
 */

(function () {
   angular.module('Rentatool').directive('disabletimevalidation', [function () {
      return {
         restrict: 'A',
         replace: true,
         require: 'ngModel',
         link: function (scope, element, attributes, ngModelController) {
            ngModelController.$validators['time'] = function () {
               return true;
            };
         }
      };
   }]);
})();
