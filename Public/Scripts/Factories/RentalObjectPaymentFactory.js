/**
 * Created by elinnilsson on 06/11/14.
 */

(function () {
   angular.module('Rentatool').factory('RentalObjectPayment', ['$resource', function ($resource) {
      return new $resource('rentalobjectpayments');
   }]);
})();