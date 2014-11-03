/**
 * Created by Elin on 2014-07-10.
 */
(function(){
   angular.module('Rentatool').factory('User', ['$resource', function ($resource) {
      return $resource('users/:id', {id: '@id'}, {update: {method: 'PUT'}});
   }]);
})();
