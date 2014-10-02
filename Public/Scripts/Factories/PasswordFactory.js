/**
 * Created by elinnilsson on 01/10/14.
 */
(function () {
   angular.module('Rentatool')
      .factory('Password', ['$resource', function ($resource) {
         return new $resource('passwords')
      }
      ]);
})();