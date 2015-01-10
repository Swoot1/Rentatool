/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('alphanumericvalidation', [function () {

      return {
         restrict: 'A',
         replace: true,
         template: "<input ng-pattern=\"/^[a-zåäöA-ZÅÄÖ0-9]+$/\" type=\"text\"/>"
      };
   }])
})();