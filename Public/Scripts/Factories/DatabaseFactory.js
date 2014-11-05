/**
 * Created by Elin on 2014-07-17.
 */
(function () {
   angular.module('Rentatool').factory('Database', ['$resource', function ($resource) {
      return new $resource('databases/:action', {});
   }]);
})();
