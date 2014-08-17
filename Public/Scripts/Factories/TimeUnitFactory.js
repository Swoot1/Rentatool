/**
 * Created by elinnilsson on 17/08/14.
 */
angular.module('Rentatool')
   .factory('TimeUnit', ['$resource', function ($resource) {
      return $resource('timeunits/:id', {id: '@id'}, {update: {method: 'PUT'}});
   }]);