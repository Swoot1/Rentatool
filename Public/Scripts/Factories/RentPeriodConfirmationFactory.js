/**
 * Created by Elin on 2014-07-10.
 */
(function () {
   angular.module('Rentatool').factory('RentPeriodConfirmation', ['$resource', function ($resource) {
      return $resource('rentperiodconfirmations/:id', {id: '@id'});
   }]);
})();
