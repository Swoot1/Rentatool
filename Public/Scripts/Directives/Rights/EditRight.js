/**
 * Created by elinnilsson on 16/01/15.
 */
(function () {
   angular.module('Rentatool').directive('editright', ['$compile', function ($compile) {
      return {
         restrict: 'A',
         replace: false,
         compile: function (element) {
            element.attr('ng-class', "{editable: isUserOwner && !isUserOwner()}");
            element.attr('ng-readonly', "isUserOwner && !isUserOwner()");
            element.removeAttr('editright'); // Remove current directive and avoid infinite loop.

            return {
               pre: function preLink() {
               },
               post: function postLink(scope, element) {
                  $compile(element)(scope);
               }
            }
         }
      };
   }]);
})();