/**
 * Created by Elin on 2014-07-10.
 */
(function () {
   angular.module('Rentatool').factory('Booking', ['$resource', function ($resource) {
      return $resource('bookings/:id', {id: '@id'});
   }]);
})();
