/**
 * Created by elinnilsson on 05/11/14.
 */
(function () {
   angular.module('Rentatool').factory('ConfirmRentPeriod', ['$resource', function ($resource) {
      return $resource('confirmrentperiods/:id', {id: '@id'}, {update: {method: 'PUT'}});
   }]);
})();