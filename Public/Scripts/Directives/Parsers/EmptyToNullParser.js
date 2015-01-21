/**
 * Created by elinnilsson on 21/01/15.
 */
(function () {
   angular.module('Rentatool').directive('emptytonull', [function () {
      return {
         restrict: 'A',
         require: 'ngModel',
         link: function (scope, elem, attrs, ngModelController) {
            ngModelController.$parsers.push(function (viewValue) {
               if (viewValue === '') {
                  viewValue = null;
               }
               return viewValue;
            });
         }
      };
   }]);
})();