/**
 * Created by elinnilsson on 03/11/14.
 */
(function () {
   angular.module('Rentatool').controller('MyBookingListController', ['RentPeriod', '$scope', 'NavigationService', function (RentPeriod, $scope, NavigationService) {
      $scope.rentalPeriodCollection = RentPeriod.query();
      var now = new Date();
      now.setHours(0, 0, 0, 0);

      $scope.isPastRentPeriod = function (date) {
         return now > new Date(date.toDate);
      };

      $scope.isFutureRentPeriod = function (date) {
         return now < new Date(date.toDate);
      };

      $scope.navigateToRentalObjectList = NavigationService.navigateToRentalObjectList;

   }]);
})();