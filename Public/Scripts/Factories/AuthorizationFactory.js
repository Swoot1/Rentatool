/**
 * Created by Elin on 2014-07-11.
 */
(function () {
   angular.module('Rentatool').factory('Authorization', ['$resource', function ($resource) {
      return $resource('authorization/:action');
   }]);
})();
