/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('zipcodevalidation', [function () {

      return {
         restrict: 'A',
         replace: true,
         // When copy pasting please note that the frontend regexp is double escaped and the backend regexp is single escaped.
         template: "<input ng-pattern=\"/^[\\d]{3,3}\\s[\\d]{2,2}$/\" type=\"text\"/>"
      };
   }])
})();