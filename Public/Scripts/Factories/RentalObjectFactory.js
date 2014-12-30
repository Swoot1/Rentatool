/**
 * Created by Elin on 2014-07-10.
 */
(function(){
   angular.module('Rentatool').factory('RentalObject', ['$resource', function ($resource) {
      return $resource('rentalobjects/:id', {id: '@id'}, {update: {method: 'PUT'}});
   }]);
})();


