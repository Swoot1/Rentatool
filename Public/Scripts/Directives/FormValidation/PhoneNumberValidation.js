/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('phonenumbervalidation', [function () {

      return {
         restrict: 'A',
         replace: true,
         // When copy pasting please note that the frontend regexp is double escaped and the backend regexp is single escaped.
         template: "<input ng-pattern=\"/^[0-9]{2,4}(\\s|-)?[0-9\\s]{2,12}$/\" type=\"tel\"/>"
      };
   }])
})();