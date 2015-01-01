/**
 * Created by elinnilsson on 29/09/14.
 */
(function () {
   angular.module('Rentatool')
      .controller('RentPeriodConfirmationController', ['$scope', '$routeParams', 'RentPeriodConfirmation', function ($scope, $routeParams, RentPeriodConfirmation) {
         if ($routeParams.id) {
            $scope.rentPeriodConfirmation = RentPeriodConfirmation.get({id: $routeParams.id});
         }
         // else TODO redirect 404.
      }]);
})();
