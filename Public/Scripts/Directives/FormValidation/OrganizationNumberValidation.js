/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('organizationnumbervalidation', ['$compile', function ($compile) {

      return {
         restrict: 'A',
         replace: false,
         terminal: true,
         priority: 1000,
         compile: function compile(element) {
            // When copy pasting please note that the frontend regexp is double escaped and the backend regexp is single escaped.
            element.attr('ng-pattern', "/^([\\d]{12,12}|[\\d]{10,10}){1,1}$/");
            element.removeAttr('organizationnumbervalidation'); // Remove current directive and avoid infinite loop.

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