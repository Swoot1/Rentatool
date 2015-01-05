/**
 * Created by elinnilsson on 03/11/14.
 */
(function () {
   angular.module('Rentatool').controller('MyBookingListController', ['Booking', '$scope', 'NavigationService', 'CancelRentPeriod', function (Booking, $scope, NavigationService, CancelRentPeriod) {
      $scope.bookingCollection = Booking.query();
      var now = new Date();
      now.setHours(0, 0, 0, 0);

      $scope.isPastBooking = function (booking) {
         return !booking.cancelled && (now > new Date(booking.toDate));
      };

      $scope.isFutureBooking = function (booking) {
         return !booking.cancelled && (now < new Date(booking.toDate));
      };

      $scope.isCancelledBooking = function (booking) {
         return booking.cancelled;
      };

      $scope.cancelRentPeriod = function (booking) {
         CancelRentPeriod.get({id: booking.rentPeriodId}, function(){
            var index = $scope.bookingCollection.indexOf(booking);
            $scope.bookingCollection[index].cancelled = true;
         });
      };

      $scope.navigateToRentalObjectList = NavigationService.navigateToRentalObjectList;
      $scope.navigateToMyBooking = NavigationService.navigateToMyBooking;

   }]);
})();