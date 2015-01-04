/**
 * Created by Elin on 2014-07-10.
 */
(function () {
   angular.module('Rentatool').factory('CancelRentPeriod', ['$resource', function ($resource) {
      return $resource('cancelrentperiods/:id', {id: '@id'});
   }]);
})();
