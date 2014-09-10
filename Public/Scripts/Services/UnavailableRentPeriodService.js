/**
 * Created by elinnilsson on 09/09/14.
 */
angular.module('Rentatool')
   .factory('UnavailableRentPeriodService', ['UnavailableRentPeriod', function (UnavailableRentPeriod) {
      var getUnavailableRentPeriods = function (rentalObjectId, callback) {
         return UnavailableRentPeriod.query({'rentalObjectId' : rentalObjectId}, callback);
      };

      return {
         getUnavailableRentPeriods: getUnavailableRentPeriods
      };
   }]);