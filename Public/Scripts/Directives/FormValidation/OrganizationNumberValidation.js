/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('organizationnumbervalidation', [function () {

      return {
         restrict: 'A',
         replace: true,
         // When copy pasting please note that the frontend regexp is double escaped and the backend regexp is single escaped.
         template: "<input ng-pattern=\"/^([\\d]{12,12}|[\\d]{10,10}){1,1}$/\" type=\"text\"/>"
      };
   }])
})();