/**
 * Created by elinnilsson on 17/08/14.
 */
angular.module('Rentatool')
   .factory('UnavailableRentPeriod', ['$resource', function ($resource) {
      return $resource('unavailablerentperiods', {'rentalObjectId': '@rentalObjectId'});
   }]);
