/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('zipcodeparser', [function () {

      return {
         restrict: 'A',
         replace: true,
         require: 'ngModel',
         link: function (scope, element, attributes, ngModelController) {

            ngModelController.$parsers.unshift(formatZipCode);

            function formatZipCode(viewValue) {
               var viewValueArray;

               if (!viewValue) {
                  return viewValue;
               }

               viewValueArray = viewValue.replace(' ', '').split('');
               viewValueArray.splice(3, 0, ' ');

               return viewValueArray.join('');
            }
         }
      };
   }])
})();