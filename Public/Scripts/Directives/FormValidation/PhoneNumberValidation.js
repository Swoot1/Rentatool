/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('phonenumbervalidation', ['$compile', function ($compile) {

      return {
         restrict: 'A',
         replace: false,
         terminal: true,
         priority: 1000,
         compile: function compile(element) {
            // When copy pasting please note that the frontend regexp is double escaped and the backend regexp is single escaped.
            element.attr('ng-pattern', "/^[0-9]{2,4}(\\s|-)?[0-9\\s]{2,12}$/");
            element.attr('type', 'tel');
            element.removeAttr('phonenumbervalidation'); // Remove current directive and avoid infinite loop.

            return {
               pre: function preLink() {
               },
               post: function postLink(scope, element) {
                  $compile(element)(scope);
               }
            }
         }
      };
   }])
})();