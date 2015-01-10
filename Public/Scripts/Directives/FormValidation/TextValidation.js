/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('textvalidation', [function () {

      return {
         restrict: 'A',
         replace: true,
         // When copy pasting please note that the frontend regexp is double escaped and the backend regexp is single escaped.
         template: "<input ng-pattern=\"/^[A-ZÅÄÖa-zåäö0-9\\s!#\\\\\\$%%&\\'\\(\\)\\*\\+,\\.\\/:;<=>\\?@^_`\\{|\\}~\\[\\]\\-]+$/\" type=\"text\"/>"
      };
   }])
})();