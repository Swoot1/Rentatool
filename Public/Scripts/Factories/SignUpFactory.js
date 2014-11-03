/**
 * Created by Elin on 2014-07-10.
 */
(function () {
   angular.module('Rentatool').factory('SignUp', ['$resource', function ($resource) {
      return $resource('signups');
   }]);
})();
