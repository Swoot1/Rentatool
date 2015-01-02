/**
 * Created by elinnilsson on 29/09/14.
 */
(function () {
   angular.module('Rentatool')
      .controller('BookingController', ['$scope', '$routeParams', 'Booking', function ($scope, $routeParams, Booking) {
         if ($routeParams.id) {
            $scope.booking = Booking.get({id: $routeParams.id});
         }
      }]);
})();
