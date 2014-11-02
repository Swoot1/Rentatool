/**
 * Created by elinnilsson on 30/08/14.
 */
(function () {
   angular.module('Rentatool').directive('datepicker', [function () {
      return {
         require: 'ngModel',
         link: function (scope, element, attrs, ngModelCtrl) {
            element.datepicker();
            element.datepicker('option', 'dateFormat', 'yy-mm-dd');
            element.datepicker('option', 'minDate', 0);
            element.datepicker('option', 'onSelect', function (dateText) {
               ngModelCtrl.$setViewValue(dateText);
               scope.$apply();
            });
         }
      };
   }]);
})();