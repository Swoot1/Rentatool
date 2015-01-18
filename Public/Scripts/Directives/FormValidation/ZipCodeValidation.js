/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('zipcodevalidation', ['$compile', function ($compile) {

      return {
         restrict: 'A',
         replace: false,
         terminal: true,
         priority: 1000,
         compile: function compile(element) {

            element.attr('ng-pattern', "/^[\\d\\s]{5,6}$/");
            element.attr('type', 'text');
            element.removeAttr('zipcodevalidation'); // Remove current directive and avoid infinite loop.

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