/**
 * Created by elinnilsson on 30/12/14.
 */

(function(){
   angular.module('Rentatool').factory('InactivateRentalObject', ['$resource', function ($resource) {
      return $resource('inactivaterentalobjects/:id', {id: '@id'}, {update: {method: 'PUT'}});
   }]);
})();

