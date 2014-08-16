/**
 * Created by Elin on 2014-07-10.
 */
angular.module('Rentatool').factory('RentPeriod', ['$resource', function ($resource) {
   return $resource('rentperiods/:id', {id: '@id'}, {update: {method: 'PUT'}});
}]);
