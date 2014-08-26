/**
 * Created by Elin on 2014-07-10.
 */
angular.module('Rentatool').factory('RentPeriodCalculator', ['$resource', function ($resource) {
   return $resource('rentperiodcalculators');
}]);
