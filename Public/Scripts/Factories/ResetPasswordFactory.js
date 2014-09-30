/**
 * Created by Elin on 2014-07-10.
 */
(function () {
   angular.module('Rentatool')
      .factory('ResetPassword', ['$resource', function ($resource) {
         return $resource('passwords');
      }]);
})();
