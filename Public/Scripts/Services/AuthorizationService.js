/**
 * Created by elinnilsson on 28/09/14.
 */
angular.module('Rentatool')
   .factory('AuthorizationService', ['$rootScope', function ($rootScope) {

      $rootScope.userIsLoggedIn = false;

      var logIn = function () {
         $rootScope.userIsLoggedIn = true;
      };

      var logOut = function () {
         $rootScope.userIsLoggedIn = false;
      };

      return {
         'logIn': logIn,
         'logOut': logOut
      }

   }]);