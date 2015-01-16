/**
 * Created by elinnilsson on 16/01/15.
 */
(function () {
   angular.module('Rentatool').directive('editright', [function () {
      return {
         restrict: 'A',
         link: function (scope, element) {
            element.attr('ng-class', "{editable: isUserOwner && !isUserOwner()}");
            element.attr('ng-readonly', "isUserOwner && !isUserOwner()");
         }
      };
   }]);
})();