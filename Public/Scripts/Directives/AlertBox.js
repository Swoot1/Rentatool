/**
 * Created by Elin on 2014-07-31.
 */

(function () {
   angular.module('Rentatool').directive('alertbox', [function () {
      return {
         restrict: 'A',
         replace: true,
         template: '<div data-alert ng-repeat="alertBox in alertBoxes" class="alert-box {{alertBox.type}}">{{alertBox.message}}<a href="" class="close" ng-click="alertBox.close()">&times</a></div>'
      };
   }]);
})();
