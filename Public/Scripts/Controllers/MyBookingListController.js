/**
 * Created by elinnilsson on 03/11/14.
 */
(function () {
   angular.module('Rentatool').controller('MyBookingListController', ['Booking', '$scope', 'NavigationService', 'CancelRentPeriod', function (Booking, $scope, NavigationService, CancelRentPeriod) {
      $scope.bookingCollection = Booking.query();
      var now = new Date();
      now.setHours(0, 0, 0, 0);

      $scope.isPastBooking = function (date) {
         return now > new Date(date.toDate);
      };

      $scope.isFutureBooking = function (date) {
         return now < new Date(date.toDate);
      };

      $scope.cancelRentPeriod = function (booking) {
         CancelRentPeriod.get({id: booking.rentPeriodId});
      };

      $scope.navigateToRentalObjectList = NavigationService.navigateToRentalObjectList;
      $scope.navigateToMyBooking = NavigationService.navigateToMyBooking;

   }]);
})();