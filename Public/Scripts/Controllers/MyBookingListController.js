/**
 * Created by elinnilsson on 03/11/14.
 */
(function () {
   angular.module('Rentatool').controller('MyBookingListController', ['Booking', '$scope', 'NavigationService', function (Booking, $scope, NavigationService) {
      $scope.bookingCollection = Booking.query();
      var now = new Date();
      now.setHours(0, 0, 0, 0);

      $scope.isPastBooking = function (date) {
         return now > new Date(date.toDate);
      };

      $scope.isFutureBooking = function (date) {
         return now < new Date(date.toDate);
      };

      $scope.navigateToRentalObjectList = NavigationService.navigateToRentalObjectList;
      $scope.navigateToBooking = NavigationService.navigateToBooking;

   }]);
})();