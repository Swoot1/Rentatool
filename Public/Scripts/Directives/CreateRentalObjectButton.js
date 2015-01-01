/**
 * Created by elinnilsson on 28/09/14.
 */
(function () {
   angular.module('Rentatool')
      .directive('createrentalobjectbutton', [function () {
         return {
            restrict: 'A',
            replace: 'true',
            template: '<li class="success"><button type="button" ng-click="navigateToCreateNewRentalObject()">Skapa nytt uthyrningsobjekt</button></li>'
         };
      }
      ]);
})();
